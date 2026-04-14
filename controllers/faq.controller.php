<?php
require_once 'models/faq.model.php';

/**
 * Affichage FAQ côté utilisateur (page publique).
 */
function faqDisplay() {
    $title = "Foire aux questions";
    $faqs = getActiveFaqs();

    ob_start();
    require('views/faq.view.php');
    $content = ob_get_clean();
    require("views/base.view.php");
}

/**
 * Administration des FAQ (CRUD).
 */
function adminFaqDisplay() {
    $user_role = $_SESSION['user_role'] ?? 'user';
    if ($user_role !== 'admin') {
        require 'views/header.view.php';
        require 'views/page-erreur.view.php';
        require 'views/footer.view.php';
        return;
    }

    $title = "Administration FAQ";

    // Traitement des actions POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Création d'une nouvelle FAQ
        if (isset($_POST['create_faq'])) {
            $question  = trim($_POST['question'] ?? '');
            $reponse   = trim($_POST['reponse'] ?? '');
            $ordre     = (int)($_POST['ordre'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            if ($question !== '' && $reponse !== '') {
                createFaq($question, $reponse, $ordre, $is_active);
            }
            header('Location: index.php?page=admin_faq');
            exit;
        }

        // Mise à jour d'une FAQ
        if (isset($_POST['update_faq'])) {
            $faq_id    = (int)($_POST['faq_id'] ?? 0);
            $question  = trim($_POST['question'] ?? '');
            $reponse   = trim($_POST['reponse'] ?? '');
            $ordre     = (int)($_POST['ordre'] ?? 0);
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            if ($faq_id > 0 && $question !== '' && $reponse !== '') {
                updateFaq($faq_id, $question, $reponse, $ordre, $is_active);
            }
            header('Location: index.php?page=admin_faq');
            exit;
        }

        // Suppression d'une FAQ
        if (isset($_POST['delete_faq'])) {
            $faq_id = (int)($_POST['faq_id'] ?? 0);
            if ($faq_id > 0) {
                deleteFaq($faq_id);
            }
            header('Location: index.php?page=admin_faq');
            exit;
        }
    }

    $faqs = getAllFaqs();
    $edit_faq = null;
    if (!empty($_GET['edit'])) {
        $edit_faq = getFaqById((int)$_GET['edit']);
    }

    require 'views/header.view.php';
    require 'views/admin/admin_faq.view.php';
    require 'views/footer.view.php';
}
