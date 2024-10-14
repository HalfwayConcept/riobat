<?php
    require_once 'connect.db.php';

    //lecture des données contenues dans la base
    function getDo($doid){
        $sql = "SELECT 
                dommage_ouvrage.*, souscripteur.*, moa.*, operation_construction.*, situation.*, travaux_annexes.*, moe.*
        
                FROM dommage_ouvrage, souscripteur, moa, operation_construction, situation, travaux_annexes, moe
                WHERE dommage_ouvrage.DOID = $doid
                AND dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
                AND moa.DOID = dommage_ouvrage.DOID
                AND moe.DOID = dommage_ouvrage.DOID
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
                souscripteur.*, moa.*, moe.*, travaux_annexes.*, 
                utilisateur_session.*
                FROM souscripteur, dommage_ouvrage, moa, 
                        operation_construction, situation, travaux_annexes, moe,
                        utilisateur_session
                WHERE dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
                AND moa.DOID = dommage_ouvrage.DOID
                AND moe.DOID = dommage_ouvrage.DOID
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
        //var_dump($array_SESSION);
        if (strlen($array_SESSION["souscripteur_nom_raison"]) > 0 ){

            // insertion des données du souscripteur
            extract($array_SESSION);
            $sql = "INSERT INTO souscripteur (souscripteur_nom_raison, souscripteur_siret, souscripteur_adresse, souscripteur_code_postal, souscripteur_commune, souscripteur_profession, souscripteur_telephone, souscripteur_email, souscripteur_ancien_client_date, souscripteur_ancien_client_num) 
            VALUES ('$souscripteur_nom_raison', '$souscripteur_siret', '$souscripteur_adresse', '$souscripteur_code_postal', '$souscripteur_commune', '$souscripteur_profession', '$souscripteur_telephone', '$souscripteur_email', '$souscripteur_ancien_client_date', '$souscripteur_ancien_client_num');";
            $query = mysqli_query($GLOBALS["conn"], $sql);

            // insertion de souscripteur_id dans dommage_ouvrage
            $souscripteur_id = mysqli_insert_id($GLOBALS["conn"]);
            $sql = "INSERT INTO dommage_ouvrage (souscripteur_id) VALUES ('$souscripteur_id')";
            $query = mysqli_query($GLOBALS["conn"], $sql);

            // récupération de DOID et ajout dans toutes les tables
            $DOID = mysqli_insert_id($GLOBALS["conn"]);
            $sql = "INSERT INTO moa (DOID) VALUES ('$DOID');";
            $query = mysqli_query($GLOBALS["conn"], $sql);
            $sql = "INSERT INTO operation_construction (DOID) VALUES ('$DOID');";
            $query = mysqli_query($GLOBALS["conn"], $sql);
            $sql = "INSERT INTO situation (DOID) VALUES ('$DOID');";
            $query = mysqli_query($GLOBALS["conn"], $sql);
            $sql = "INSERT INTO travaux_annexes (DOID) VALUES ('$DOID');";
            $query = mysqli_query($GLOBALS["conn"], $sql);
            $sql = "INSERT INTO moe (DOID) VALUES ('$DOID');";
            $query = mysqli_query($GLOBALS["conn"], $sql);

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
            && !str_starts_with($field, "sol_entreprise")  //l'entreprise de sol doit utiliser la table entreprise, on ignore ces champs là
            && !str_starts_with($field, "boi_entreprise")    //idem pour bois
            && !str_starts_with($field, "phv_entreprise")    //idem pour le photovoltaique
            && !str_starts_with($field, "geo_entreprise")    //idem pour géothermie
            && !str_starts_with($field, "ctt_entreprise")    //idem pour controleur technique
            && !str_starts_with($field, "moe_entreprise")    //idem pour moe 
            && !str_starts_with($field, "cnr_entreprise")    //idem pour cnr      

            ){   
                if($i == 0){
                    $sqlupdate.=" SET $field = ? ";
                }else{
                    $sqlupdate.=" , $field = ? ";
                }
                if(empty($value)){
                    $value=null;
                }
                array_push($array_values,$value);
                $i++;
            }else{
                
                $rightPart = substr($field, 11); // Récupère les 11 derniers caractères
                if($rightPart == "_entreprise"){
                    //var_dump($array_SESSION);
                }
            }
            
        }

        $sqlupdate.=" WHERE $table.DOID = $DOID;";
        if(DEBUG == true){
            /*echo "<pre>";
                echo "<br>SQL:<strong>$sqlupdate</strong><br>";
                print_r($array_values);
            echo "</pre>";*/
        }
        
        try {
            /* Crée une requête préparée */
            if ($stmt = mysqli_prepare($GLOBALS["conn"], $sqlupdate)) {
                /* Exécution de la requête */
                    print_r($stmt);
                    $res = mysqli_stmt_execute($stmt, $array_values);
                
                    /* Fermeture du traitement */
                    mysqli_stmt_close($stmt);                
            }
        }catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }
        var_dump($res); 
        
        return $res;
    }

    // changement du format de la date
    function dateFormat($date){
        return date('d-m-Y', strtotime($date));
    }


    // Affichage des intitulés des radio et checkbox
    function boxDisplay($fieldcontent){
        $display = "<div class='flex flex-row'>
        <strong class='pl-6'>".$fieldcontent."</strong>
        </div>";
        return $display;
    };


    function deleteDo($doid){

        $deletesql = "DELETE FROM dommage_ouvrage WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);
        $deletesql = "DELETE FROM moa WHERE DOID = '$doid'";
        mysqli_query($GLOBALS["conn"], $deletesql);
        $deletesql = "DELETE FROM moe WHERE DOID = '$doid'";
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


    function loadDo(){

    }

    // récupération des noms de colonne
    /*function get_column_names($table) {
        $sql = 'DESCRIBE '.$table;
        $result = mysqli_query($GLOBALS["conn"], $sql);
    
        $rows = array();
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row['Field'];
        }
    
        return $rows;
    }*/
  
  