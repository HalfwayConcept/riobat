<?php
require_once 'models/rcd_token.model.php';
require_once 'models/rcd.model.php';

function publicUploadRcd() {
    $token = $_GET['token'] ?? '';
    $tokenData = validateRcdUploadToken($token);

    if (!$tokenData) {
        $error = 'Ce lien est invalide ou a expiré. Veuillez contacter votre gestionnaire pour obtenir un nouveau lien.';
        require 'views/public/upload_rcd_error.view.php';
        return;
    }

    $DOID = (int)$tokenData['DOID'];
    $folder = getFolderName($DOID);
    $array_datas = getRcdByDoid($DOID);
    $array_natures = getListNature();
    $success_msg = '';
    $error_msg = '';

    // Traitement de la soumission (fichiers OU infos)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $uploaded = 0;
        $upload_dir = ROOT_PATH . UPLOAD_FOLDER;

        // Indexer les statuts actuels par rcd_id pour vérification
        $current_statuses = [];
        foreach ($array_datas as $d) {
            $current_statuses[(int)$d['rcd_id']] = [
                'fichier_status' => (int)($d['fichier_status'] ?? 0),
                'annexe_fichier_status' => (int)($d['annexe_fichier_status'] ?? 0),
            ];
        }

        // 1. Sauvegarde des dates et montants pour chaque lot
        $pdo = $GLOBALS['pdo'] ?? null;
        foreach ($array_datas as $lot) {
            $rcd_id = (int)$lot['rcd_id'];
            $montant = isset($_POST['montant_' . $rcd_id]) ? $_POST['montant_' . $rcd_id] : null;
            $date_debut = isset($_POST['date_debut_' . $rcd_id]) ? trim($_POST['date_debut_' . $rcd_id]) : null;
            $date_fin = isset($_POST['date_fin_' . $rcd_id]) ? trim($_POST['date_fin_' . $rcd_id]) : null;
            $fields = [];
            $params = [ ':rcd_id' => $rcd_id, ':doid' => $DOID ];
            if ($montant !== null && $montant !== '') {
                $fields[] = 'montant = :montant';
                $params[':montant'] = $montant;
            }
            if ($date_debut !== null && $date_debut !== '') {
                $fields[] = 'construction_date_debut = :date_debut';
                $params[':date_debut'] = $date_debut;
            }
            if ($date_fin !== null && $date_fin !== '') {
                $fields[] = 'construction_date_fin = :date_fin';
                $params[':date_fin'] = $date_fin;
            }
            if (!empty($fields)) {
                $sql = 'UPDATE rcd SET ' . implode(', ', $fields) . ' WHERE rcd_id = :rcd_id AND DOID = :doid';
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);
            }
        }

        // 2. Traitement des fichiers (comme avant)
        if (!empty($_FILES)) {
            foreach ($_FILES as $input_name => $file) {
                if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE) continue;

                // Extraire rcd_id et type depuis le name (ex: rcd_file_12 ou annexe_file_12)
                if (preg_match('/^(rcd|annexe)_file_(\d+)$/', $input_name, $m)) {
                    $type = $m[1]; // 'rcd' ou 'annexe'
                    $rcd_id = (int)$m[2];
                } else {
                    continue;
                }

                // Bloquer l'upload si le document est déjà validé (status 3)
                $status_field = ($type === 'rcd') ? 'fichier_status' : 'annexe_fichier_status';
                if (isset($current_statuses[$rcd_id]) && $current_statuses[$rcd_id][$status_field] === 3) {
                    $error_msg .= "Le document est déjà validé pour le lot #$rcd_id, remplacement impossible. ";
                    continue;
                }

                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $error_msg .= "Erreur lors du téléchargement de {$file['name']}. ";
                    continue;
                }

                if ($file['size'] > 20 * 1024 * 1024) {
                    $error_msg .= "Le fichier {$file['name']} dépasse 20 Mo. ";
                    continue;
                }

                $mime = mime_content_type($file['tmp_name']);
                $allowed = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'application/pdf' => 'pdf'];
                if (!isset($allowed[$mime])) {
                    $error_msg .= "Format de fichier non autorisé pour {$file['name']}. ";
                    continue;
                }

                $ext = $allowed[$mime];
                $safe_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
                $filename = $safe_name . '.' . $ext;

                $target_dir = $upload_dir . '/' . $folder;
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                $target_path = $target_dir . '/' . $filename;
                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    // Mettre à jour la BDD
                    $col = ($type === 'rcd') ? 'fichier' : 'annexe_fichier';
                    $status_col = ($type === 'rcd') ? 'fichier_status' : 'annexe_fichier_status';
                    $stmt = $pdo->prepare("UPDATE rcd SET $col = :f, $status_col = 0 WHERE rcd_id = :rid AND DOID = :doid");
                    $stmt->execute([':f' => $filename, ':rid' => $rcd_id, ':doid' => $DOID]);

                    // Historique
                    require_once 'models/do.model.php';
                    $type_label = ($type === 'rcd') ? 'RCD' : 'Annexe';
                    addDoHistorique($DOID, 'Upload externe', null, "Document $type_label uploadé via lien partagé pour le lot #$rcd_id : $filename");

                    $uploaded++;
                }
            }
        }

        markTokenUsed($token);

        if ($uploaded > 0) {
            $success_msg = "$uploaded fichier(s) uploadé(s) avec succès.";
        }
        // Recharger les données après upload
        $array_datas = getRcdByDoid($DOID);
    }

    require 'views/public/upload_rcd.view.php';
}
