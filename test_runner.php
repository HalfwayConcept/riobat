<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// test_runner.php : Script CLI pour tests de non-régression formulaire DO
// Usage : php test_runner.php

function randomString($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $str;
}

function postStep($url, $fields, &$cookieFile, &$output) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    $response = curl_exec($ch);
    $err = curl_error($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $output[] = [
        'url' => $url,
        'fields' => $fields,
        'http' => $http,
        'error' => $err,
        'response' => $response
    ];
    return $response;
}

function runTests() {
    $baseUrl = 'http://localhost/riobat/index.php?page=';
    $cookieFile = tempnam(sys_get_temp_dir(), 'riobat_test_cookie');
    $output = [];
    $success = true;

    // Step 1 : Souscripteur
    $fields1 = [
        'fields' => 'souscripteur',
        'souscripteur_nom_raison' => randomString(10),
        'souscripteur_siret' => rand(10000000000000, 99999999999999),
        'souscripteur_adresse' => randomString(12),
        'souscripteur_code_postal' => rand(10000, 99999),
        'souscripteur_commune' => randomString(8),
        'souscripteur_profession' => randomString(6),
        'souscripteur_telephone' => '06'.rand(10000000,99999999),
        'souscripteur_email' => randomString(6).'@test.fr',
        'page_next' => 'step2'
    ];
    $resp1 = postStep($baseUrl.'step1', $fields1, $cookieFile, $output);
    if (strpos($resp1, 'Formulaire DO-02') === false) $success = false;

    // Step 2 : MOA
    $fields2 = [
        'fields' => 'moa',
        'moa_qualite' => 'proprietaire',
        'moa_construction' => '1',
        'moa_construction_pro' => '0',
        'page_next' => 'step3'
    ];
    $resp2 = postStep($baseUrl.'step2', $fields2, $cookieFile, $output);
    if (strpos($resp2, 'Formulaire DO-03') === false) $success = false;

    // Step 3 : Opération
    $fields3 = [
        'fields' => 'operation_construction',
        'nature_neuf_exist' => 'neuve',
        'construction_adresse' => randomString(10),
        'construction_adresse_code_postal' => rand(10000,99999),
        'construction_adresse_commune' => randomString(8),
        'page_next' => 'step4'
    ];
    $resp3 = postStep($baseUrl.'step3', $fields3, $cookieFile, $output);
    if (strpos($resp3, 'Formulaire DO-04') === false) $success = false;

    // Step 4 : Situation
    $fields4 = [
        'fields' => 'situation',
        'page_next' => 'step4bis'
    ];
    $resp4 = postStep($baseUrl.'step4', $fields4, $cookieFile, $output);
    if (strpos($resp4, 'Formulaire DO-04bis') === false) $success = false;

    // Step 4bis : Travaux annexes
    $fields5 = [
        'fields' => 'travaux_annexes',
        'page_next' => 'step5'
    ];
    $resp5 = postStep($baseUrl.'step4bis', $fields5, $cookieFile, $output);
    if (strpos($resp5, 'Formulaire DO-05') === false) $success = false;

    unlink($cookieFile);
    return ['success' => $success, 'log' => $output];
}

if (php_sapi_name() === 'cli') {
    $result = runTests();
    echo $result['success'] ? "\033[32mTOUS LES TESTS PASSÉS\033[0m\n" : "\033[31mECHEC TESTS\033[0m\n";
    foreach ($result['log'] as $step => $info) {
        echo "\n--- Etape ".($step+1)." ---\n";
        echo "URL: ".$info['url']."\n";
        echo "HTTP: ".$info['http']."\n";
        if ($info['error']) echo "Erreur cURL: ".$info['error']."\n";
        echo "Champs envoyés: ".json_encode($info['fields'])."\n";
        echo "---\n";
    }
}
