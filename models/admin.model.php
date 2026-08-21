<?php
require_once __DIR__ . '/connect.db.php';
// ...existing code...

function getListDOBoard($user_id = null){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) {
        // fallback to mysqli
        $sql = "SELECT dommage_contrat.DOID, situation.DOID, date_creation, souscripteur_nom_raison, construction_adresse, construction_adresse_code_postal, construction_adresse_commune, construction_cout_operation
        FROM souscripteur
        JOIN dommage_contrat ON dommage_contrat.souscripteur_id = souscripteur.souscripteur_id
        JOIN situation ON situation.DOID = dommage_contrat.DOID
        JOIN operation_construction ON operation_construction.DOID = dommage_contrat.DOID";
        $resquery = mysqli_query($GLOBALS['conn'], $sql);
        $boardata = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $boardata;
    }

        $sql = "SELECT dommage_contrat.DOID, situation.DOID, date_creation, souscripteur_nom_raison, construction_adresse, construction_adresse_code_postal, construction_adresse_commune, construction_cout_operation
            FROM souscripteur
            JOIN dommage_contrat ON dommage_contrat.souscripteur_id = souscripteur.souscripteur_id
            JOIN situation ON situation.DOID = dommage_contrat.DOID
            JOIN operation_construction ON operation_construction.DOID = dommage_contrat.DOID";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}


