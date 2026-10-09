<?php
require_once 'models/pv_document_token.model.php';
require_once 'models/pv_document.model.php';
require_once 'models/do.model.php';

function publicUploadPvDocuments(): void {
    $token = (string)($_GET['token'] ?? '');
    $tokenData = validatePvDocumentUploadToken($token);
    if (!$tokenData) {
        $error = 'Ce lien est invalide ou a expiré. Veuillez contacter votre gestionnaire.';
        require 'views/public/upload_rcd_error.view.php';
        return;
    }

    $doid = (int)$tokenData['DOID'];
    $documents = getPvDocuments($doid);
    $errors = [];
    $success = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = savePvDocuments($doid, $_FILES['pv_documents'] ?? [], isset($_POST['pv_toiture_geree_societe']), true);
        if ($result['success']) {
            markPvDocumentUploadTokenUsed($token);
            addDoHistorique($doid, 'Upload documents PPV', null, 'Documents PPV transmis via lien sécurisé.');
            $documents = getPvDocuments($doid);
            $success = 'Vos documents ont bien été transmis.';
        } else {
            $errors = $result['errors'];
        }
    }
    require 'views/public/upload_pv_documents.view.php';
}
