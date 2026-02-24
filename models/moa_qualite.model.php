<?php
// models/moa_qualite.model.php
// ...existing code...

function getAllMoaQualites() {
    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = "SELECT * FROM moa_qualite ORDER BY label";
    $stmt = $pdo->query($sql);
    require_once __DIR__ . '/../controllers/LogController.php';
    $user_id = $_SESSION['user_id'] ?? null;
    logQuery(null, 'moa_qualite', $stmt->queryString, [], $user_id, 'réussi');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
