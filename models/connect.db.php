<?php

// Backwards-compatible mysqli connection (kept for legacy code).

// PDO connection for all code (use prepared statements, exceptions)
$dsn = sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8mb4', DB_HOST, DB_NAME, DB_PORT);
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $GLOBALS['pdo'] = $pdo;
} catch (PDOException $e) {
    if (defined('DEBUG') && DEBUG) {
        echo "PDO error: " . $e->getMessage();
    }
    exit();
}

