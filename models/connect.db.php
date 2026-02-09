<?php

// Backwards-compatible mysqli connection (kept for legacy code).
$mysqli_conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
if (!$mysqli_conn) {
    if (defined('DEBUG') && DEBUG) {
        echo "Erreur de connexion à MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
    }
    exit();
}
mysqli_set_charset($mysqli_conn, "utf8mb4");
$GLOBALS['mysqli_conn'] = $mysqli_conn;
$GLOBALS['conn'] = $mysqli_conn; // legacy alias expected by older code

// PDO connection for new code (use prepared statements, exceptions)
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

