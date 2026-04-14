<?php
require 'inc/settings.php';
require 'models/connect.db.php';

$pdo = $GLOBALS['pdo'];
$email = 'admin@admin.com';
$password = '0e2e2e2e2e2e2e2e';

// 1. Check if user exists
$stmt = $pdo->prepare('SELECT ID, email, pass, role FROM utilisateur WHERE email = :email LIMIT 1');
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Aucun utilisateur trouvé avec email: $email\n";
    // List all users
    $stmt = $pdo->query('SELECT ID, email, role FROM utilisateur');
    echo "Utilisateurs existants:\n";
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
        echo "  ID={$r['ID']} email={$r['email']} role={$r['role']}\n";
    }
} else {
    echo "User trouvé: ID={$user['ID']} email={$user['email']} role={$user['role']}\n";
    echo "Hash stocké: {$user['pass']}\n";
    echo "Longueur hash: " . strlen($user['pass']) . "\n";
    echo "password_verify result: " . (password_verify($password, $user['pass']) ? 'TRUE' : 'FALSE') . "\n";
    
    // Test with check_login
    require 'models/user.model.php';
    $result = check_login($email, $password);
    echo "check_login result: ";
    var_dump($result);
}
