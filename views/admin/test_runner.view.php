<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sessionStarted = session_start();

// Toujours forcer utilisateur_id à 1 pour les tests (même si la session existe déjà)
$_SESSION['utilisateur_id'] = 1;
$step = isset($_GET['step']) ? intval($_GET['step']) : 1;
$log = [];
$cookieFile = sys_get_temp_dir() . '/riobat_test_cookie_' . session_id();
$baseUrl = 'http://localhost/riobat/index.php?page=';
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
if (!isset($_SESSION['test_runner'])) {
    // Pour les tests, on force utilisateur_id à 1
    $_SESSION['utilisateur_id'] = 1;
    // Initialisation des valeurs de session pour chaque étape
    $_SESSION['test_runner'] = [
        'fields1' => [
            'fields' => 'souscripteur',
            'souscripteur_nom_raison' => randomString(10),
            'souscripteur_siret' => rand(10000000000000, 99999999999999),
            'souscripteur_adresse' => randomString(12),
            'souscripteur_code_postal' => rand(10000, 99999),
            'souscripteur_commune' => randomString(8),
            'souscripteur_profession' => randomString(6),
            'souscripteur_telephone' => '06'.rand(10000000,99999999),
            'souscripteur_email' => randomString(6).'@test.fr',
            // Initialisation explicite de la coche/toggle (exemple : acceptation des CGU ou autre champ booléen)
            'souscripteur_cgu' => '1', // coche activée (adapter le nom du champ si besoin)
            'page_next' => 'step2'
        ],
        'fields2' => [
            'fields' => 'moa',
            'moa_qualite' => 'proprietaire',
            'moa_construction' => '1',
            'moa_construction_pro' => '0',
            'page_next' => 'step3'
        ],
        'fields3' => [
            'fields' => 'operation_construction',
            'nature_neuf_exist' => 'neuve',
            'construction_adresse' => randomString(10),
            'construction_adresse_code_postal' => rand(10000,99999),
            'construction_adresse_commune' => randomString(8),
            'page_next' => 'step4'
        ],
        'fields4' => [
            'fields' => 'situation',
            'page_next' => 'step4bis'
        ],
        'fields5' => [
            'fields' => 'travaux_annexes',
            'page_next' => 'step5'
        ]
    ];
}
$steps = [
    1 => ['label' => 'Step 1 : Souscripteur', 'url' => $baseUrl.'step1', 'fields' => 'fields1', 'expect' => 'Formulaire DO-02'],
    2 => ['label' => 'Step 2 : MOA', 'url' => $baseUrl.'step2', 'fields' => 'fields2', 'expect' => 'Formulaire DO-03'],
    3 => ['label' => 'Step 3 : Opération', 'url' => $baseUrl.'step3', 'fields' => 'fields3', 'expect' => 'Formulaire DO-04'],
    4 => ['label' => 'Step 4 : Situation', 'url' => $baseUrl.'step4', 'fields' => 'fields4', 'expect' => 'Formulaire DO-04bis'],
    5 => ['label' => 'Step 4bis : Travaux annexes', 'url' => $baseUrl.'step4bis', 'fields' => 'fields5', 'expect' => 'Formulaire DO-05'],
];
$result = null;
if (isset($steps[$step])) {
    $stepData = $steps[$step];
    $fields = $_SESSION['test_runner'][$stepData['fields']];
    $response = postStep($stepData['url'], $fields, $cookieFile, $log);
    $success = strpos($response, $stepData['expect']) !== false;
    $result = [
        'success' => $success,
        'log' => $log,
        'response' => $response
    ];
}
?>
<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">
    <h2 class="text-center font-medium text-2xl mt-8 mb-4">Tests de non-régression DO (manuel)</h2>
    <form method="get" class="flex flex-wrap gap-2 justify-center mb-6">
        <?php foreach ($steps as $i => $s): ?>
            <button type="submit" name="step" value="<?= $i ?>" <?= ($step == $i) ? 'style="background:#007bff;color:#fff;"' : '' ?>><?= $s['label'] ?></button>
        <?php endforeach; ?>
    </form>
    <?php if ($result): ?>
        <h3 class="font-semibold mb-2">Résultat pour <?= htmlspecialchars($steps[$step]['label']) ?></h3>
        <p>Status : <b style="color:<?= $result['success'] ? 'green' : 'red' ?>;">
            <?= $result['success'] ? 'OK' : 'ECHEC' ?></b></p>
        <h4 class="font-semibold mb-2">Log technique</h4>
        <pre><?= htmlspecialchars(print_r($result['log'], true)) ?></pre>
        <h4 class="font-semibold mb-2">Réponse HTML</h4>
        <pre><?= htmlspecialchars($result['response']) ?></pre>
    <?php endif; ?>
    <form method="post">
        <button type="submit" name="reset" value="1">Réinitialiser la session de test</button>
    </form>
    <?php if (isset($_POST['reset'])) {
        unset($_SESSION['test_runner']);
        echo '<p>Session de test réinitialisée.</p>';
    } ?>
</section>
