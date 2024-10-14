<?php
    require_once 'connect.db.php';

    function getListDOBoard($user_id = null){
        $boardsql = "SELECT dommage_ouvrage.DOID, situation.DOID, date_creation, souscripteur_nom_raison, construction_adresse_num_nom_rue, construction_adresse_code_postal, construction_adresse_commune, construction_cout_operation 
        FROM souscripteur, dommage_ouvrage, situation, operation_construction
        WHERE dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
        AND situation.DOID = dommage_ouvrage.DOID
        AND operation_construction.DOID = dommage_ouvrage.DOID;";

        $resquery = mysqli_query($GLOBALS["conn"], $boardsql);
        $boardata = mysqli_fetch_all($resquery, MYSQLI_ASSOC);

        return $boardata;

         //return array( 1 => "DO156415", 2 => "DO564456");
    }


   