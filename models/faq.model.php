<?php
require_once __DIR__ . '/connect.db.php';
require_once __DIR__ . '/../controllers/LogController.php';

/**
 * Récupère toutes les FAQ actives, triées par ordre.
 */
function getActiveFaqs(): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT faq_id, question, reponse, ordre FROM faq WHERE is_active = 1 ORDER BY ordre ASC, faq_id ASC";
    $stmt = $pdo->query($sql);
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'faq', $sql, [], $user_id, 'réussi');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère toutes les FAQ (actives et inactives) pour l'admin.
 */
function getAllFaqs(): array {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT * FROM faq ORDER BY ordre ASC, faq_id ASC";
    $stmt = $pdo->query($sql);
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'faq', $sql, [], $user_id, 'réussi');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère une FAQ par son ID.
 */
function getFaqById(int $faq_id): array|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT * FROM faq WHERE faq_id = :faq_id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':faq_id' => $faq_id]);
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'faq', $sql, [':faq_id' => $faq_id], $user_id, 'réussi');
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Crée une nouvelle entrée FAQ.
 */
function createFaq(string $question, string $reponse, int $ordre = 0, int $is_active = 1): int|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "INSERT INTO faq (question, reponse, ordre, is_active) VALUES (:question, :reponse, :ordre, :is_active)";
    $stmt = $pdo->prepare($sql);
    $params = [':question' => $question, ':reponse' => $reponse, ':ordre' => $ordre, ':is_active' => $is_active];
    $stmt->execute($params);
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'faq', $sql, $params, $user_id, 'réussi');
    return (int)$pdo->lastInsertId();
}

/**
 * Met à jour une FAQ existante.
 */
function updateFaq(int $faq_id, string $question, string $reponse, int $ordre, int $is_active): bool {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "UPDATE faq SET question = :question, reponse = :reponse, ordre = :ordre, is_active = :is_active WHERE faq_id = :faq_id";
    $stmt = $pdo->prepare($sql);
    $params = [':question' => $question, ':reponse' => $reponse, ':ordre' => $ordre, ':is_active' => $is_active, ':faq_id' => $faq_id];
    $result = $stmt->execute($params);
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'faq', $sql, $params, $user_id, 'réussi');
    return $result;
}

/**
 * Supprime une FAQ.
 */
function deleteFaq(int $faq_id): bool {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "DELETE FROM faq WHERE faq_id = :faq_id";
    $stmt = $pdo->prepare($sql);
    $params = [':faq_id' => $faq_id];
    $result = $stmt->execute($params);
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'faq', $sql, $params, $user_id, 'réussi');
    return $result;
}
