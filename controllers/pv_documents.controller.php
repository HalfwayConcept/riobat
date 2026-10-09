<?php
require_once 'models/do.model.php';
require_once 'models/pv_document.model.php';
require_once 'models/pv_document_token.model.php';
require_once 'models/email.model.php';

function pvDocumentsAdminDisplay(): void {
    $role = $_SESSION['user_role'] ?? 'user';
    $isStaff = in_array($role, ['admin', 'collab'], true);
    if (!in_array($role, ['admin', 'collab', 'user'], true)) {
        require 'views/page-erreur.view.php';
        return;
    }

    $doid = (int)($_GET['doid'] ?? 0);
    $data = $doid > 0 ? getDo($doid) : false;
    if (!$data || ($data['type_demande'] ?? '') !== 'pv') {
        header('Location: index.php?page=admin');
        exit;
    }
    if (!$isStaff) {
        $userDoids = array_map(static fn(array $do): int => (int)$do['DOID'], getListDo((int)$_SESSION['user_id']));
        if (!in_array($doid, $userDoids, true)) {
            require 'views/page-erreur.view.php';
            return;
        }
    }
    $pvStats = getPvDocumentStatsAllDo()[$doid] ?? ['requested' => false];
    $canUpload = $isStaff || $pvStats['requested'];

    $uploadUrl = '';
    $message = '';
    $messageType = 'success';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doid'], $_POST['upload_pv_documents']) && $canUpload) {
        $result = savePvDocuments(
            $doid,
            $_FILES['pv_documents'] ?? [],
            isset($_POST['pv_toiture_geree_societe']),
            false
        );
        if ($result['success']) {
            addDoHistorique($doid, 'Upload documents PPV', $_SESSION['user_id'] ?? null, 'Documents PPV transmis depuis l’administration.');
            $message = 'Les documents PPV ont été enregistrés.';
        } else {
            $message = implode(' ', $result['errors']);
            $messageType = 'error';
        }
    } elseif ($isStaff && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doid']) && (isset($_POST['generate_pv_link']) || isset($_POST['send_pv_link']))) {
        $token = createPvDocumentUploadToken($doid, (int)$_SESSION['user_id']);
        if (!$token) {
            $message = 'La génération du lien sécurisé a échoué.';
            $messageType = 'error';
        } else {
            $uploadUrl = buildPvDocumentUploadUrl($token);
            if (isset($_POST['send_pv_link'])) {
                if (sendPvDocumentRequest(
                    (string)($data['souscripteur_email'] ?? ''),
                    $doid,
                    $uploadUrl,
                    (string)($data['souscripteur_nom_raison'] ?? '')
                )) {
                    addDoHistorique($doid, 'Demande de documents PPV', $_SESSION['user_id'] ?? null, 'Lien sécurisé envoyé au souscripteur.');
                    $message = 'Le lien sécurisé a été envoyé au souscripteur.';
                } else {
                    $message = 'Le lien a été généré, mais l’e-mail n’a pas pu être envoyé.';
                    $messageType = 'error';
                }
            } else {
                $message = 'Le lien sécurisé a été généré. Copiez-le ou envoyez-le par e-mail.';
            }
        }
    }

    $title = 'Documents photovoltaïques';
    $documents = getPvDocuments($doid);
    $folder = (string)($data['repertoire'] ?? '');
    if ($folder === '') {
        $message = 'Le répertoire de dépôt du dossier est introuvable.';
        $messageType = 'error';
    }
    require 'views/header.view.php';
    require 'views/admin/pv_documents.view.php';
    require 'views/footer.view.php';
}
