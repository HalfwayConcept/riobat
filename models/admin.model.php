<?php
require_once 'connect.db.php';

function getListDOBoard($user_id = null){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) {
        // fallback to mysqli
        $sql = "SELECT dommage_ouvrage.DOID, situation.DOID, date_creation, souscripteur_nom_raison, construction_adresse_num_nom_rue, construction_adresse_code_postal, construction_adresse_commune, construction_cout_operation
        FROM souscripteur
        JOIN dommage_ouvrage ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
        JOIN situation ON situation.DOID = dommage_ouvrage.DOID
        JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID";
        $resquery = mysqli_query($GLOBALS['conn'], $sql);
        $boardata = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $boardata;
    }

    $sql = "SELECT dommage_ouvrage.DOID, situation.DOID, date_creation, souscripteur_nom_raison, construction_adresse_num_nom_rue, construction_adresse_code_postal, construction_adresse_commune, construction_cout_operation
            FROM souscripteur
            JOIN dommage_ouvrage ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
            JOIN situation ON situation.DOID = dommage_ouvrage.DOID
            JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}


