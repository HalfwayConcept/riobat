<?php
require 'inc/settings.php';
require 'models/connect.db.php';

$pdo = $GLOBALS['pdo'];
$hash = password_hash('0e2e2e2e2e2e2e2e', PASSWORD_DEFAULT);

$stmt = $pdo->prepare('UPDATE utilisateur SET pass = :pass, email = :email WHERE ID = 1');
$stmt->execute([':pass' => $hash, ':email' => 'admin@admin.com']);
echo "ID=1 updated: " . $stmt->rowCount() . " row(s)\n";

$stmt = $pdo->prepare('UPDATE utilisateur SET pass = :pass, email = :email WHERE ID = 2');
$stmt->execute([':pass' => $hash, ':email' => 'admin@admin.com']);
echo "ID=2 updated: " . $stmt->rowCount() . " row(s)\n";

// Verify
$stmt = $pdo->query('SELECT ID, email, LENGTH(pass) as hash_len FROM utilisateur WHERE ID IN (1,2)');
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    echo "ID={$row['ID']} email={$row['email']} hash_len={$row['hash_len']}\n";
}
