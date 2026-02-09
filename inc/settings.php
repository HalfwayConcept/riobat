<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load .env file if present (simple parser)
$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$name, $value] = array_map('trim', explode('=', $line, 2) + [1 => null]);
        if ($name !== null && $value !== null) {
            // remove quotes
            $value = trim($value, "'\"");
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

define('ROOT_PATH', dirname(__FILE__) );
define('UPLOAD_FOLDER', "/public/uploads" );

// Load configuration from environment where possible. Keep sane defaults for local setups.
define('APP_ENV', getenv('APP_ENV') ?: ($_SESSION['env'] ?? 'prod'));

// Admin password: prefer environment variable to avoid committing secrets.
define('PASSWORD_ADMIN', getenv('PASSWORD_ADMIN') ?: '9%VBV!7zFkbH');

// Database configuration from environment variables with fallbacks.
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'ruki5964_riobat');
define('DB_PASS', getenv('DB_PASS') ?: 'YNJuzTq/(WqE5lVR');
define('DB_NAME', getenv('DB_NAME') ?: 'ruki5964_riobat');
define('DB_PORT', getenv('DB_PORT') ?: 3306);

if (APP_ENV === 'dev') {
    define('DEBUG', true);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    define('DEBUG', false);
    ini_set('display_errors', '0');
    error_reporting(0);
}


define("RGPD_TEXT",
    "Accordant une grande importance au respect de la vie privée de ses clients (ci-après « Vous »), La société Cabinet Cotton Alexandre vous informe de la façon la plus transparente possible, des traite-ments mis en œuvre dans le cadre de l'utilisation des données personnelles que vous lui confiez.
     Le présent document a pour but de répondre à la réglementation en vigueur et notamment au Règlement (UE) 2016/679 du Parlement Européen et du Conseil du 27 avril 2016 relatif à la protection des personnes physiques à l'égard du traitement des données à caractère personnel et à la libre circulation de ces données (RGPD), et abrogeant la directive 95/46/CE.
     Ainsi, dans le cadre de nos relations professionnelles, nous sommes amenés à collecter, traiter et détenir des informations vous concernant :
     • sur des bases légales différentes (votre consentement, la nécessité contractuelle, le respect d'une obligation légale et/ou encore l'intérêt légitime du Responsable du traitement).
     • conformément aux finalités définies ensemble.
     Les données collectées seront conservées pendant toute la durée de nos relations contractuelles et ensuite en archive pendant un délai de cinq (5) ans, à défaut des délais plus courts ou plus longs spécialement prévus notamment en cas de litige.
     Mr Cotton Alexandre agit en qualité de responsable de traitement au sens des dispositions du Règlement Général sur la protection des données personnelles (RGPD).
     Vous bénéficiez d'un droit d'accès, de rectification, de suppression, de portabilité, de limitation, d'opposition, de définition des directives relatives au sort de vos Données à Caractère Personnel suite à une demande adressée :
     • par voie postale à l'adresse : 5 bd, rue Soubeyran - 48000 - MENDE
     • ou électronique à Mr Cotton Alexandre responsable du traitement par mail à l'adresse : Cabinet Cotton Alexandre cabinetcotton@outlook.fr.fr
     • vos demandes seront prises en compte dans un délai maximum d'un mois.
     Les Données à Caractère Personnel qui vous seront communiquées dans le cadre de l'exercice de votre droit d'accès le seront à titre personnel et confidentiel. A ce titre, pour que votre demande d'accès soit prise en compte, Vous devrez faire parvenir les éléments nécessaires à votre identification à savoir, une attestation écrite sur l'honneur par laquelle Vous certifiez être le titulaire desdites Données à Caractère Personnel ainsi qu'une photocopie d'une pièce d'identité. 
     Vous disposez par ailleurs en cas de non-respect par La société Cabinet Cotton Alexandre à ses obli-gations au titre de la législation/réglementation en vigueur, du droit d'introduire une réclamation auprès de la Commission Nationale de l'Informatique et des Libertés (CNIL).");