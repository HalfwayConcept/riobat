<?php
/**
 * Ticket Controller — Gestion des tickets (création, admin, API)
 */

require_once 'models/ticket.model.php';

/**
 * API : Création d'un ticket (appelée en AJAX POST)
 */
function ticketCreate() {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
        exit;
    }

    // En mode prod, il faut être connecté
    $user_id = $_SESSION['user_id'] ?? null;
    if (APP_ENV !== 'dev' && empty($user_id)) {
        echo json_encode(['success' => false, 'error' => 'Vous devez être connecté pour envoyer un ticket.']);
        exit;
    }

    $descriptif = trim($_POST['descriptif'] ?? '');
    $url_page   = trim($_POST['url_page'] ?? '');

    if (strlen($descriptif) < 10) {
        echo json_encode(['success' => false, 'error' => 'Le descriptif doit contenir au moins 10 caractères.']);
        exit;
    }

    // Gestion du fichier joint (optionnel)
    $fichier = null;
    if (!empty($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        $max_size = 5 * 1024 * 1024; // 5 Mo
        if ($_FILES['fichier']['size'] > $max_size) {
            echo json_encode(['success' => false, 'error' => 'Le fichier ne doit pas dépasser 5 Mo.']);
            exit;
        }

        $mime = mime_content_type($_FILES['fichier']['tmp_name']);
        $allowed = [
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
        ];
        if (!isset($allowed[$mime])) {
            echo json_encode(['success' => false, 'error' => 'Format de fichier non autorisé (PNG, JPG, GIF, WEBP, PDF uniquement).']);
            exit;
        }

        $ext = $allowed[$mime];
        $safe_name = 'ticket_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

        $target_dir = ROOT_PATH . UPLOAD_FOLDER . '/tickets';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_path = $target_dir . '/' . $safe_name;
        if (!move_uploaded_file($_FILES['fichier']['tmp_name'], $target_path)) {
            echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'upload du fichier.']);
            exit;
        }
        $fichier = $safe_name;
    }

    $ticket_id = createTicket($descriptif, $url_page, $user_id, $fichier);

    if ($ticket_id) {
        echo json_encode(['success' => true, 'ticket_id' => $ticket_id, 'message' => 'Ticket #' . $ticket_id . ' créé avec succès.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la création du ticket.']);
    }
    exit;
}

/**
 * Page admin : Liste des tickets
 */
function adminTicketsDisplay() {
    $user_role = $_SESSION['user_role'] ?? 'user';
    if ($user_role !== 'admin') {
        require 'views/page-erreur.view.php';
        return;
    }

    // Traitement POST : mise à jour statut ou solution
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['update_ticket_statut'], $_POST['ticket_id'])) {
            $tid = (int)$_POST['ticket_id'];
            $statut = $_POST['update_ticket_statut'];
            updateTicketStatut($tid, $statut);
            header('Location: index.php?page=admin_tickets');
            exit;
        }
        if (isset($_POST['update_ticket_solution'], $_POST['ticket_id'])) {
            $tid = (int)$_POST['ticket_id'];
            $solution = trim($_POST['update_ticket_solution']);
            updateTicketSolution($tid, $solution);
            header('Location: index.php?page=admin_tickets&detail=' . $tid);
            exit;
        }
    }

    $title = "Gestion des tickets";
    $filtre_statut = $_GET['statut'] ?? null;
    $allowed_statuts = ['ouvert', 'en_cours', 'en_attente', 'cloture'];
    if ($filtre_statut !== null && !in_array($filtre_statut, $allowed_statuts)) {
        $filtre_statut = null;
    }

    $tickets = getAllTickets($filtre_statut);
    $counts = countTicketsByStatut();

    // Détail d'un ticket ?
    $detail = null;
    if (!empty($_GET['detail'])) {
        $detail = getTicketById((int)$_GET['detail']);
    }

    require 'views/header.view.php';
    require 'views/admin/admin_tickets.view.php';
    require 'views/footer.view.php';
}
