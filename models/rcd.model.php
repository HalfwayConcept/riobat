<?php

    require_once 'connect.db.php';

    //création des nature RCD
    function getListNature(){
        $sql = "SELECT * FROM `rcd_nature`;";
        $resquery   = mysqli_query($GLOBALS["conn"], $sql);
        $DATA       = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

?>