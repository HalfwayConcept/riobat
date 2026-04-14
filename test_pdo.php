<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=ruki5964_riobat;port=3306;charset=utf8mb4', 'root', '');
    echo "PDO OK\n";
} catch (PDOException $e) {
    echo "PDO ERROR: " . $e->getMessage() . "\n";
}
