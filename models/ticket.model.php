<?php
/**
 * Ticket Model — CRUD pour le système de tickets
 */

require_once __DIR__ . '/connect.db.php';
require_once __DIR__ . '/../controllers/LogController.php';

/**
 * Crée un nouveau ticket
 */
function createTicket(string $descriptif, string $url_page, ?int $user_id, ?string $fichier): int|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "INSERT INTO ticket (descriptif, url_page, user_id, fichier, statut)
            VALUES (:descriptif, :url_page, :user_id, :fichier, 'ouvert')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':descriptif' => $descriptif,
        ':url_page'   => $url_page,
        ':user_id'    => $user_id,
        ':fichier'    => $fichier,
    ]);
    logQuery($sql, ['descriptif' => $descriptif, 'url_page' => $url_page, 'user_id' => $user_id], 'ticket', $user_id);
    return $pdo->lastInsertId();
}

/**
 * Récupère un ticket par son ID
 */
function getTicketById(int $ticket_id): array|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT t.*, u.nom AS user_nom, u.prenom AS user_prenom, u.email AS user_email
            FROM ticket t
            LEFT JOIN utilisateur u ON t.user_id = u.ID
            WHERE t.ticket_id = :id
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $ticket_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Liste tous les tickets avec filtre optionnel sur le statut
 */
function getAllTickets(?string $statut = null, string $order = 'date_creation DESC'): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    $allowed_orders = [
        'date_creation DESC', 'date_creation ASC',
        'statut ASC', 'statut DESC',
        'ticket_id DESC', 'ticket_id ASC',
    ];
    if (!in_array($order, $allowed_orders)) {
        $order = 'date_creation DESC';
    }
    $sql = "SELECT t.*, u.nom AS user_nom, u.prenom AS user_prenom, u.email AS user_email
            FROM ticket t
            LEFT JOIN utilisateur u ON t.user_id = u.ID";
    $params = [];
    if ($statut !== null) {
        $sql .= " WHERE t.statut = :statut";
        $params[':statut'] = $statut;
    }
    $sql .= " ORDER BY $order";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Met à jour le statut d'un ticket
 */
function updateTicketStatut(int $ticket_id, string $statut): bool {
    $allowed = ['ouvert', 'en_cours', 'en_attente', 'cloture'];
    if (!in_array($statut, $allowed)) return false;
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "UPDATE ticket SET statut = :statut WHERE ticket_id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([':statut' => $statut, ':id' => $ticket_id]);
    logQuery($sql, ['statut' => $statut, 'ticket_id' => $ticket_id], 'ticket', $_SESSION['user_id'] ?? null);
    return $result;
}

/**
 * Met à jour la solution admin d'un ticket
 */
function updateTicketSolution(int $ticket_id, string $solution): bool {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "UPDATE ticket SET solution = :solution WHERE ticket_id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([':solution' => $solution, ':id' => $ticket_id]);
    logQuery($sql, ['solution' => $solution, 'ticket_id' => $ticket_id], 'ticket', $_SESSION['user_id'] ?? null);
    return $result;
}

/**
 * Compte les tickets par statut (pour badges admin)
 */
function countTicketsByStatut(): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT statut, COUNT(*) AS nb FROM ticket GROUP BY statut";
    $stmt = $pdo->query($sql);
    $counts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $counts[$row['statut']] = (int)$row['nb'];
    }
    return $counts;
}

/**
 * Récupère les tickets d'un utilisateur donné
 */
function getTicketsByUser(int $user_id): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT * FROM ticket WHERE user_id = :uid ORDER BY date_creation DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':uid' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
