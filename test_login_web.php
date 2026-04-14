<?php
session_start();
$_SESSION['env'] = 'dev';
include_once("inc/settings.php");
require 'models/connect.db.php';

echo "<h2>Test login via navigateur</h2>";

// Simulate POST
$email = 'admin@admin.com';
$password = '0e2e2e2e2e2e2e2e';

echo "DB_HOST=" . DB_HOST . "<br>";
echo "DB_NAME=" . DB_NAME . "<br>";
echo "PDO: " . (isset($GLOBALS['pdo']) ? 'OK' : 'FAIL') . "<br>";

$pdo = $GLOBALS['pdo'];
$stmt = $pdo->prepare('SELECT ID, email, pass, role FROM utilisateur WHERE email = :email LIMIT 1');
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Aucun utilisateur trouvé!<br>";
    $stmt = $pdo->query('SELECT ID, email, role FROM utilisateur');
    foreach ($stmt->fetchAll() as $r) {
        echo "ID={$r['ID']} email={$r['email']} role={$r['role']}<br>";
    }
} else {
    echo "User trouvé: ID={$user['ID']} email={$user['email']} role={$user['role']}<br>";
    echo "Hash: {$user['pass']}<br>";
    echo "password_verify: " . (password_verify($password, $user['pass']) ? 'TRUE' : 'FALSE') . "<br>";
}
