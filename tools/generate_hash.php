<?php
// Script pour générer le hash bcrypt du mot de passe '0e2e2e2e2e2e2e2e'
$plain = '0e2e2e2e2e2e2e2e';
$hash = password_hash($plain, PASSWORD_DEFAULT);
echo $hash;
