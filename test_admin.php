<?php
require 'inc/settings.php';
require 'models/connect.db.php';
$stmt = $GLOBALS['pdo']->query("SELECT ID, email, LEFT(pass,20) as pass_start, LENGTH(pass) as pass_len, role FROM utilisateur WHERE role='admin'");
$users = $stmt->fetchAll();
foreach ($users as $u) {
    echo "ID={$u['ID']} | email={$u['email']} | pass_start={$u['pass_start']} | pass_len={$u['pass_len']} | role={$u['role']}\n";
}
