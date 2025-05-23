<?php


define('ROOT_PATH', dirname(__FILE__) );
define('UPLOAD_FOLDER', "/public/uploads" );


define('PASSWORD_ADMIN', "9%VBV!7zFkbH" );

if($_SESSION['env'] == 'dev'){
    define("SERVER",    "localhost");
    define("USER",      "ruki5964_riobat");
    define("PASSWORD",  "YNJuzTq/(WqE5lVR");
    define("BDD",       "ruki5964_riobat");
    define('DEBUG', false );

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);    
}else{
    define("SERVER",    "localhost");
    define("USER",      "ruki5964_riobat");
    define("PASSWORD",  "YNJuzTq/(WqE5lVR");
    define("BDD",       "ruki5964_riobat");

    define('DEBUG', false );
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