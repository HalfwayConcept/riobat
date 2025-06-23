<?php

    require_once 'connect.db.php';



    //création des nature RCD
    function getListNature(){
       
        $sql = "SELECT * FROM `rcd_nature`;";
        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        $DATA       = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

    function getFolderName($DOID)
    {
        $folder = '';
        $sql = "SELECT distinct(repertoire) FROM `rcd` where DOID=$DOID;";
        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        $folder       = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $folder[0];
    }



    //création des nature RCD
    function getRcdByDoid($DOID){
        $sql = "SELECT `rcd`.*,raison_sociale  FROM `rcd` 
                LEFT JOIN `entreprise` ON entreprise.ID = `rcd`.rcd_entreprise_id
                WHERE `DOID` = $DOID;";
        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        $DATA       = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    } 

    function init_RCD_DOID($DOID){

        $sql = "INSERT into rcd (rcd_entreprise_id,DOID, rcd_nature_id) 
                SELECT boi_entreprise_id,DOID,  (SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Construction en bois')   
                FROM `travaux_annexes` WHERE boi_entreprise_id>0 and `DOID`=$DOID      
                UNION   
                SELECT geo_entreprise_id,DOID,  (SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Installation géothermique')   
                FROM `travaux_annexes` WHERE geo_entreprise_id>0 and `DOID`=$DOID
                UNION
                SELECT sol_entreprise_id,DOID, (SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Installation géothermique') 
                FROM `situation` WHERE sol_entreprise_id>0 and `DOID`=$DOID
                UNION
                SELECT phv_entreprise_id,DOID,(SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Photovoltaïques') 
                FROM `travaux_annexes` WHERE phv_entreprise_id>0  and `DOID`=$DOID
                UNION   
                SELECT ctt_entreprise_id,DOID,(SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Contrôleur technique') 
                FROM `travaux_annexes` WHERE ctt_entreprise_id>0  and `DOID`=$DOID";

        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        //nombre de lignes insérées
        //echo mysqli_affected_rows($GLOBALS["conn"]);
        if (!$resquery) {
            die("Erreur lors de l'initialisation des RCD: " . mysqli_error($GLOBALS["conn"]));
        }
        return $sql;

    }

?>