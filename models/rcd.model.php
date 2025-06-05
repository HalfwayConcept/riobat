<?php

    require_once 'connect.db.php';


    //création des nature RCD
    function getRCD(){
        $sql = "SELECT * FROM `rcd_nature`;";
        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        $DATA       = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    }


    //création des nature RCD
    function getListNature(){
        $sql = "SELECT * FROM `rcd_nature`;";
        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        $DATA       = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    }


    function init_RCD_DOID($DOID){
        $sql = "INSERT into rcd (rcd_entreprise_id,DOID, rcd_nature_id) 
                SELECT geo_entreprise_id,DOID,14   FROM `travaux_annexes` WHERE geo_entreprise_id>0 and `DOID`=121
                UNION
                SELECT boi_entreprise_id,DOID,5  FROM `travaux_annexes` WHERE boi_entreprise_id>0  and `DOID`=121
                UNION
                SELECT phv_entreprise_id,DOID,16  FROM `travaux_annexes` WHERE phv_entreprise_id>0  and `DOID`=121";

    }

?>