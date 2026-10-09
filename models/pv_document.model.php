<?php
require_once __DIR__ . '/connect.db.php';
require_once __DIR__ . '/do.model.php';

const PV_DOCUMENT_MAX_SIZE = 20 * 1024 * 1024;

function getPvDocuments(int $doid): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || $doid <= 0) {
        return [];
    }

    $stmt = $pdo->prepare('SELECT * FROM pv_documents WHERE DOID = :doid LIMIT 1');
    $stmt->execute([':doid' => $doid]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
}

function getPvDocumentStatsAllDo(): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return [];

    $stats = [];
    $documents = $pdo->query('SELECT DOID, facture_installation_fichier, kbis_fichier, contrat_societe_fichier, toiture_geree_societe FROM pv_documents')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($documents as $document) {
        $required = !empty($document['toiture_geree_societe']) ? 3 : 2;
        $uploaded = (int)!empty($document['facture_installation_fichier'])
            + (int)!empty($document['kbis_fichier'])
            + (int)(!empty($document['toiture_geree_societe']) && !empty($document['contrat_societe_fichier']));
        $stats[(int)$document['DOID']] = ['required' => $required, 'uploaded' => $uploaded, 'requested' => false];
    }

    $tokens = $pdo->query('SELECT DOID, MAX(created_at) AS requested_at FROM pv_document_upload_token GROUP BY DOID')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tokens as $token) {
        $doid = (int)$token['DOID'];
        $stats[$doid] = $stats[$doid] ?? ['required' => 2, 'uploaded' => 0, 'requested' => false];
        $stats[$doid]['requested'] = true;
    }
    return $stats;
}

function savePvDocuments(int $doid, array $files, bool $toitureGereeSociete, bool $validateRequiredDocuments): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || $doid <= 0) {
        return ['success' => false, 'errors' => ['Dossier photovoltaïque invalide.']];
    }

    $current = getPvDocuments($doid);
    $documents = [
        'facture_installation' => [
            'column' => 'facture_installation_fichier',
            'label' => 'La facture d’installation',
            'required' => true,
        ],
        'kbis' => [
            'column' => 'kbis_fichier',
            'label' => 'Le K-bis',
            'required' => true,
        ],
        'contrat_societe' => [
            'column' => 'contrat_societe_fichier',
            'label' => 'Le document relatif au contrat de la société',
            'required' => $toitureGereeSociete,
        ],
    ];
    $normalizedFiles = [];
    if (isset($files['name']) && is_array($files['name'])) {
        foreach (array_keys($documents) as $field) {
            $normalizedFiles[$field] = [
                'name' => $files['name'][$field] ?? '',
                'type' => $files['type'][$field] ?? '',
                'tmp_name' => $files['tmp_name'][$field] ?? '',
                'error' => $files['error'][$field] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$field] ?? 0,
            ];
        }
    } else {
        $normalizedFiles = $files;
    }

    $folderStmt = $pdo->prepare('SELECT repertoire FROM ' . getContractTableName() . ' WHERE DOID = :doid LIMIT 1');
    $folderStmt->execute([':doid' => $doid]);
    $folder = (string)$folderStmt->fetchColumn();
    if ($folder === '') {
        return ['success' => false, 'errors' => ['Répertoire de dépôt introuvable pour ce dossier.']];
    }

    $uploadDir = ROOT_PATH . UPLOAD_FOLDER . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'pv';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        return ['success' => false, 'errors' => ['Impossible de créer le répertoire de dépôt des documents PPV.']];
    }

    $errors = [];
    $updates = [];
    $newFiles = [];
    $allowedMimes = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];

    foreach ($documents as $field => $document) {
        $file = $normalizedFiles[$field] ?? null;
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $errors[] = $document['label'] . ' n’a pas pu être téléversé.';
            continue;
        }
        if (($file['size'] ?? 0) <= 0 || $file['size'] > PV_DOCUMENT_MAX_SIZE) {
            $errors[] = $document['label'] . ' doit peser au maximum 20 Mo.';
            continue;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : false;
        if ($finfo) {
            finfo_close($finfo);
        }
        if (!isset($allowedMimes[$mime])) {
            $errors[] = $document['label'] . ' doit être un PDF, une image JPEG ou PNG.';
            continue;
        }

        $filename = $field . '_' . bin2hex(random_bytes(16)) . '.' . $allowedMimes[$mime];
        $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            $errors[] = 'Impossible d’enregistrer ' . strtolower($document['label']) . '.';
            continue;
        }

        $updates[$document['column']] = $filename;
        $newFiles[] = $targetPath;
    }

    if (!empty($errors)) {
        foreach ($newFiles as $newFile) {
            if (is_file($newFile)) {
                unlink($newFile);
            }
        }
        return ['success' => false, 'errors' => $errors];
    }

    $finalDocuments = array_merge($current, $updates);
    if ($validateRequiredDocuments) {
        foreach ($documents as $document) {
            if ($document['required'] && empty($finalDocuments[$document['column']])) {
                $errors[] = $document['label'] . ' est obligatoire.';
            }
        }
    }
    if (!empty($errors)) {
        foreach ($newFiles as $newFile) {
            if (is_file($newFile)) {
                unlink($newFile);
            }
        }
        return ['success' => false, 'errors' => $errors];
    }

    $params = [
        ':doid' => $doid,
        ':facture' => $finalDocuments['facture_installation_fichier'] ?? null,
        ':kbis' => $finalDocuments['kbis_fichier'] ?? null,
        ':contrat' => $finalDocuments['contrat_societe_fichier'] ?? null,
        ':toiture_geree_societe' => $toitureGereeSociete ? 1 : 0,
    ];
    $stmt = $pdo->prepare(
        'INSERT INTO pv_documents (
            DOID, facture_installation_fichier, kbis_fichier, contrat_societe_fichier, toiture_geree_societe
        ) VALUES (
            :doid, :facture, :kbis, :contrat, :toiture_geree_societe
        ) ON DUPLICATE KEY UPDATE
            facture_installation_fichier = VALUES(facture_installation_fichier),
            kbis_fichier = VALUES(kbis_fichier),
            contrat_societe_fichier = VALUES(contrat_societe_fichier),
            toiture_geree_societe = VALUES(toiture_geree_societe)'
    );
    if (!$stmt->execute($params)) {
        foreach ($newFiles as $newFile) {
            if (is_file($newFile)) {
                unlink($newFile);
            }
        }
        return ['success' => false, 'errors' => ['La sauvegarde des documents PPV a échoué.']];
    }

    require_once __DIR__ . '/../controllers/LogController.php';
    logQuery($doid, 'pv_documents', $stmt->queryString, $params, $_SESSION['user_id'] ?? null, 'réussi');

    return ['success' => true, 'errors' => []];
}
