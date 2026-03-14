<?php
// Script pour générer le hash et mettre à jour le mot de passe de admin@admin.com
require_once __DIR__ . '/../inc/settings.php';
require_once __DIR__ . '/../models/connect.db.php';

$plain = '0e2e2e2e2e2e2e2e';
$hash = password_hash($plain, PASSWORD_DEFAULT);

$pdo = $GLOBALS['pdo'];
$upd = $pdo->prepare('UPDATE utilisateur SET pass = :pass WHERE email = :email');
$upd->execute([':pass' => $hash, ':email' => 'admin@admin.com']);

echo "Mot de passe mis à jour pour admin@admin.com. Nouveau hash :\n$hash";
