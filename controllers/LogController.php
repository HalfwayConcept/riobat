<?php
// LogController.php
// Contrôleur pour la gestion des logs des échanges avec la base de données


// Ajoute un log d'échange avec la base de données
function logQuery($doid, $table, $sql, $params = [], $user_id = null, $status = 'réussi') {
    require_once __DIR__ . '/../inc/settings.php';
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return;
    $type = detectQueryType($sql);
    // Gestion du mode de log
    if (!defined('LOG_MODE')) define('LOG_MODE', 2);
    if (LOG_MODE === 0) return; // Aucun log
    if (LOG_MODE === 1 && !in_array($type, ['INSERT', 'UPDATE', 'DELETE'])) return;
    if (LOG_MODE === 2 && !in_array($type, ['INSERT', 'UPDATE', 'DELETE', 'SELECT'])) return;
    $date_exec = date('Y-m-d H:i:s');
    $params_json = json_encode($params);
    $stmt = $pdo->prepare("INSERT INTO log (DOID, date_exec_log, table_cible, requete_sql, parametres, type_requete, user_id, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$doid, $date_exec, $table, $sql, $params_json, $type, $user_id, $status]);
}

// Détecte le type de requête SQL (SELECT, INSERT, UPDATE, DELETE...)
function detectQueryType($sql) {
    if (preg_match('/^\s*(SELECT|INSERT|UPDATE|DELETE|ALTER|CREATE|DROP|TRUNCATE)/i', $sql, $matches)) {
        return strtoupper($matches[1]);
    }
    return 'AUTRE';
}

// Récupère les logs avec filtres et tri
function getLogs($filters = [], $order = 'date_exec_log DESC, DOID DESC') {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return [];
    $where = [];
    $params = [];
    if (!empty($filters['DOID'])) {
        $where[] = 'DOID = ?';
        $params[] = $filters['DOID'];
    }
    if (!empty($filters['user_id'])) {
        $where[] = 'user_id = ?';
        $params[] = $filters['user_id'];
    }
    if (!empty($filters['date'])) {
        $where[] = 'DATE(date_exec_log) = ?';
        $params[] = $filters['date'];
    }
    if (!empty($filters['table'])) {
        $where[] = 'table_cible = ?';
        $params[] = $filters['table'];
    }
    $sql = 'SELECT * FROM log';
    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }
    $sql .= ' ORDER BY ' . $order;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
