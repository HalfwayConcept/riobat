<?php
    require_once 'connect.db.php';

    //lecture des données contenues dans la base
    function getDo($doid){
        $sql = "SELECT 
                dommage_ouvrage.*, souscripteur.*, moa.*, operation_construction.*, situation.*, travaux_annexes.* 
                FROM dommage_ouvrage, souscripteur, moa, operation_construction, situation, travaux_annexes 
                WHERE dommage_ouvrage.DOID = $doid
                AND dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
                AND moa.DOID = dommage_ouvrage.DOID
                AND operation_construction.DOID = dommage_ouvrage.DOID
                AND travaux_annexes.DOID = dommage_ouvrage.DOID
                AND situation.DOID = dommage_ouvrage.DOID;";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

    function getListDo($user_id = null){
        $sql = "SELECT dommage_ouvrage.*, 
                operation_construction.*, situation.*,
                souscripteur.*, moa.*, travaux_annexes.*, 
                utilisateur_session.*
                FROM souscripteur, dommage_ouvrage, moa, 
                        operation_construction, situation, travaux_annexes,
                        utilisateur_session
                WHERE dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
                AND moa.DOID = dommage_ouvrage.DOID
                AND utilisateur_session.DOID = dommage_ouvrage.DOID
                AND operation_construction.DOID = dommage_ouvrage.DOID
                AND travaux_annexes.DOID = dommage_ouvrage.DOID
                AND situation.DOID = dommage_ouvrage.DOID ";
        if($user_id != null){
            $sql .= "AND utilisateur_session.utilisateur_id = $user_id;";
        }
       // echo $sql;
        
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        $DATA = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

    
    //création du souscripteur et de l'assurance dommage ouvrage + doid dans chaque table
    function insert($array_SESSION){
        $DOID = false;
        $souscripteur_id = false;
        if (strlen($array_SESSION["souscripteur_nom_raison"]) > 0 ){
            // insertion des données du souscripteur
            extract($array_SESSION);

            $sql = "INSERT INTO souscripteur (souscripteur_nom_raison, souscripteur_siret, souscripteur_adresse, souscripteur_code_postal, souscripteur_commune, souscripteur_profession, souscripteur_telephone, souscripteur_email, souscripteur_ancien_client_date, souscripteur_ancien_client_num) 
            VALUES ('$souscripteur_nom_raison', '$souscripteur_siret', '$souscripteur_adresse', '$souscripteur_code_postal', '$souscripteur_commune', '$souscripteur_profession', '$souscripteur_telephone', '$souscripteur_email', '$souscripteur_ancien_client_date', '$souscripteur_ancien_client_num');";
            $_SESSION["SQL"]["souscripteur"] = $sql;
            $query = mysqli_query($GLOBALS["conn"], $sql);

            // insertion de souscripteur_id dans dommage_ouvrage
            $souscripteur_id = mysqli_insert_id($GLOBALS["conn"]);
            $sql_do = "INSERT INTO dommage_ouvrage (souscripteur_id) VALUES ('$souscripteur_id')";
            $_SESSION["SQL"]["do"] = $sql_do;
            $query = mysqli_query($GLOBALS["conn"], $sql_do);

            // récupération de DOID et ajout dans toutes les tables
            $DOID = mysqli_insert_id($GLOBALS["conn"]);

            $sql_moa = "INSERT INTO moa (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["moa"] = $sql_moa;
            $query = mysqli_query($GLOBALS["conn"], $sql_moa);

            $sql_ope = "INSERT INTO operation_construction (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["ope"] = $sql_ope;
            $query = mysqli_query($GLOBALS["conn"], $sql_ope);

            $sql_situation = "INSERT INTO situation (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["situation"] = $sql_situation;
            $query = mysqli_query($GLOBALS["conn"], $sql_situation);

            $sql_travaux = "INSERT INTO travaux_annexes (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["travaux"] = $sql_travaux;
            $query = mysqli_query($GLOBALS["conn"], $sql_travaux);

        }
        return $DOID;
    }

    //mise à jour de la base à partir de la deuxième étape
    function update($array_SESSION, $table, $DOID){
        $array_values = array();
        $sqlupdate = "UPDATE $table";
        $strparams = "";
        $i =0;
        
        foreach ($array_SESSION as $field => $value) {  
            //on ignore certains champs qui ne sont pas en base de données            
            if($field != "fields" &&  $field != "page_next" 
            // && $field !="construction_cout_operation_honoraires_moe"
            && !str_starts_with($field, "sol_")  //l'entreprise de sol doit utiliser la table entreprise, on ignore ces champs là
            && !str_starts_with($field, "boi_")    //idem pour bois
            && !str_starts_with($field, "phv_")    //idem pour le photovoltaique
            && !str_starts_with($field, "geo_")    //idem pour géothermie
            && !str_starts_with($field, "ctt_")    //idem pour controleur technique
            && !str_starts_with($field, "moe_")    //idem pour moe 
            && !str_starts_with($field, "cnr_")    //idem pour cnr      
            

            ){   
                if($i == 0){
                    $sqlupdate.=" SET $field = ? ";
                }else{
                    $sqlupdate.=" , $field = ? ";
                }
                
                if(empty($value) && $value!=0){
                    $value=null;
                }
                array_push($array_values,$value);
                $i++;
            }else{
                
                $rightPart = substr($field, 11); // Récupère les 11 derniers caractères
                if($rightPart == "_entreprise"){
                    
                }
            }
            
        }
        $sqlupdate.=" WHERE $table.DOID = $DOID;";
        
        try {
            /* Crée une requête préparée */
            if ($stmt = mysqli_prepare($GLOBALS["conn"], $sqlupdate)) {
                /* Exécution de la requête */
                    $res = mysqli_stmt_execute($stmt, $array_values);
                    /* Fermeture du traitement */
                    mysqli_stmt_close($stmt);  
                    echo "<pre>";  
                    echo $i."===>".$table."<br />";
                    print_r($array_values);
                    echo "</pre>";
                    $_SESSION["SQL"][$table] = debugQuery($sqlupdate, $array_values);   
                    
                    //echo debugQuery($sqlupdate, $array_values);
            }
        }catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
    
        return $res;
    }

    function debugQuery($query, $params = array()){ 
        foreach ($params as $param) {
            $query = preg_replace('/\?/', "'" . $param . "'", $query, 1);
        }
        return $query;
    }

    // changement du format de la date
    function dateFormat($date){
        return date('d-m-Y', strtotime($date));
    }


    // Affichage des intitulés des radio et checkbox
    function boxDisplay($checked, $name, $mode = "write"){

        if($mode == "write"){
            if($checked == 1){
                $display = 'checked="checked"';
            }else{
                $display = "";
            }            
            $str_checkbox = "<input type='checkbox' $display name='$name' value='1' ";

        }elseif($mode == "read"){
            if($checked == 1){                                        
                 $str_checkbox = "<svg class='w-6 h-6 me-2 text-green-500 dark:text-green-400 shrink-0' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                                    <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z'/>
                                </svg>"; 
            }else{
                 $str_checkbox = "<svg class='w-6 h-6 text-red-800 dark:text-red' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>
                                    <path stroke='currentColor' stroke-linecap='round' stroke-width='2' d='m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'/>
                                </svg> ";
            }
        }
        return $str_checkbox;
    };


    function deleteDo($doid){

        $deletesql = "DELETE FROM dommage_ouvrage WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);
        $deletesql = "DELETE FROM moa WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);
        $deletesql = "DELETE FROM operation_construction WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);
        $deletesql = "DELETE FROM situation WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);
        $deletesql = "DELETE FROM travaux_annexes WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);

        header( "Location: index.php?page=admin" );

        return true;
    }

    function validDo($doid){
        $updatestatusSql = "UPDATE `dommage_ouvrage` SET `status` = '1' WHERE `dommage_ouvrage`.`DOID` = $doid;";
        mysqli_query($GLOBALS["conn"], $updatestatusSql);
        return true;
    }


    function loadDo($doid){
        $user_id =  $_SESSION['user_id'];
        $_SESSION = [];

        $_SESSION['DOID']       = $doid;
        $_SESSION['user_id']    = $user_id;
        $do = getDo($doid);

            $_SESSION["info_souscripteur"]["souscripteur_id"] = $do["souscripteur_id"];

            $array_tables = array('souscripteur', 'operation_construction', 'situation', 'travaux_annexes', 'moa','dommage_ouvrage');
            
            foreach ($array_tables as $table) {
                $col_names =  getColumnNames($table);
                foreach ($col_names as $key => $col) {
                    $_SESSION["info_".$table][$col] = $do[$col];                    
                }
            }
    }

    /**
    * Get the column names for a mysql table
    **/
    function getColumnNames($table) {
        $sql = 'DESCRIBE '.$table;
        $result = mysqli_query($GLOBALS["conn"], $sql);
        
        $rows = array();
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row['Field'];
        }    
        return $rows;
    }
        
       



  
  