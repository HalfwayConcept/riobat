<?php
        function coordFormDisplay($type, $array_entreprise, $read = false){
        
            if($read === true){
                $coordform = file_get_contents('views/templates/fiche/view-entreprise.template.html');
                $prefix_key ="";
            }else{
                $coordform = file_get_contents('views/templates/form/form-entreprise.template.html');                
                $prefix_key = $type.'_entreprise_';
            }

            //on ajoute la variable dans le résultat HTML généré
            $coordform = str_replace('##type##',$type, $coordform);
            
            $raison_social = "";
            $nom = "";
            $prenom ="";
            $code_postal ="";
            $adresse ="";
            $commune ="";
            $numero_siret ="";

            if(!empty($array_entreprise[$prefix_key.'raison_sociale'])){$raison_social = $array_entreprise[$prefix_key.'raison_sociale'];}
            if(!empty($array_entreprise[$prefix_key.'nom'])){$nom = $array_entreprise[$prefix_key.'nom'];}
            if(!empty($array_entreprise[$prefix_key.'prenom'])){$prenom = $array_entreprise[$prefix_key.'prenom'];}
            if(!empty($array_entreprise[$prefix_key.'code_postal'])){$code_postal = $array_entreprise[$prefix_key.'code_postal'];}
            if(!empty($array_entreprise[$prefix_key.'adresse'])){$adresse = $array_entreprise[$prefix_key.'adresse'];}
            if(!empty($array_entreprise[$prefix_key.'commune'])){$commune = $array_entreprise[$prefix_key.'commune'];}
            if(!empty($array_entreprise[$prefix_key.'numero_siret'])){$numero_siret = $array_entreprise[$prefix_key.'numero_siret'];}
            
            if(!empty($array_entreprise[$prefix_key.'id'])){
                $ID = $array_entreprise[$prefix_key.'id'];                
            }else{
                $ID = "";
            }

            $coordform = str_replace('##valeur_entreprise_id##', $ID,$coordform);    
            
            $coordform = str_replace('##valeur_entreprise_raison_sociale##', $raison_social,$coordform);
            $coordform = str_replace('##valeur_entreprise_nom##', $nom,$coordform);
            $coordform = str_replace('##valeur_entreprise_prenom##', $prenom,$coordform);
            $coordform = str_replace('##valeur_entreprise_code_postal##', $code_postal,$coordform);
            $coordform = str_replace('##valeur_entreprise_adresse##', $adresse,$coordform);
            $coordform = str_replace('##valeur_entreprise_commune##', $commune,$coordform);            
            $coordform = str_replace('##valeur_entreprise_numero_siret##', $numero_siret,$coordform);


            switch ($type) {
                case 'sol':
                case 'cnr':
                case 'ctt':
                case 'boi':
                case 'phv':                    
                    $icon = "<img class='h-10 m-2' src='public/pictures/icons/$type.png'";
                    break;
                
                default: $icon = "";   break;
            }
            $coordform = str_replace('##icon##', $icon,$coordform);
            return $coordform;
        }

        function viewEntreprise($array_entreprise){

            $echo ="";
            $type = $array_entreprise["type"];
            switch ($type) {
                case 'phv':
                    $echo .="<strong>Entreprise réalisant l'installation des panneaux photovoltaïques :</strong>";
                    break;
                
                default:
                    # code...
                    break;
            }
                        
            $echo .="<div class='ml-6'>
                    <div class='flex flex-row'>
                        <h3>Nom entreprise ou raison sociale</h3>
                        <strong class='pl-4'>".$array_entreprise["raison_sociale"]."</strong>
                    </div>            
                    <div class='flex flex-row'>
                        <h3>Nom</h3>
                        <strong class='pl-4'>".$array_entreprise["nom"]."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Prénom</h3>
                        <strong class='pl-4'>".$array_entreprise["prenom"]."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Adresse</h3>
                        <strong class='pl-4'>".$array_entreprise["adresse"]."&nbsp;".$array_entreprise["code_postal"]."&nbsp;".$array_entreprise["commune"]."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Siret n°</h3>
                        <strong class='pl-4'>".$array_entreprise["numero_siret"]."</strong>
                    </div>
                </div>";
            return $echo;
        }

        function loadEntreprise($entreprise_id){
            $sql = "SELECT *
                    FROM entreprise
                    WHERE ID = $entreprise_id;";
            $resquery = mysqli_query($GLOBALS["conn"], $sql);
            $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
            return $DATA;
        }

        function getEntreprises($doid){
            $sql = "SELECT  TA.`DOID`
                    ,`boi_entreprise_id`,`phv_entreprise_id`
                    ,`geo_entreprise_id`,`cnr_entreprise_id`,`ctt_entreprise_id`
                    ,`sol_entreprise_id`, `moe_entreprise_id`
                    FROM `travaux_annexes` TA, `situation` S, `dommage_ouvrage` DO
                    WHERE   TA.DOID = S.DOID
                    AND     TA.DOID = DO.DOID
                    AND     TA.DOID = $doid;";
            $resquery = mysqli_query($GLOBALS["conn"], $sql);
            $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
            return $DATA;
        }
    
    
        function insertEntreprise($array_entreprise){
            $type = $array_entreprise["type"];
            // insertion de souscripteur_id dans dommage_ouvrage
            //$souscripteur_id = mysqli_insert_id($GLOBALS["conn"]);
            $sqlInsert = " INSERT INTO `entreprise` (
                            `id`, `raison_sociale`, `nom`, `prenom`,                             
                            `adresse`, `code_postal`, `commune`,  `numero_siret`, `type`,
                            `nat_juri`, `num_contrat`) ";
            $sqlInsert .= ' VALUES (NULL, 
                            "'.$array_entreprise['raison_sociale'].'", 
                            "'.$array_entreprise['nom'].'", 
                            "'.$array_entreprise['prenom'].'",  
                            "'.$array_entreprise['adresse'].'", 
                            "'.$array_entreprise['code_postal'].'", 
                            "'.$array_entreprise['commune'].'",  
                            "'.$array_entreprise['numero_siret'].'", "'.$type.'",
                            "","")';       
            $query = mysqli_query($GLOBALS["conn"], $sqlInsert);            
            $entreprise_id = mysqli_insert_id($GLOBALS["conn"]);           
            return $entreprise_id;
        };

        function updateEntrepriseID($entreprise_id, $type, $DOID){
            $type_entreprise_id = $type."_entreprise_id";
            switch ($type ) {
                case 'sol':
                    $table =  "situation";
                    break;
                case 'moe':
                    $table =  "dommage_ouvrage";
                    break;                
                default:
                    $table =  "travaux_annexes";
                    break;
            }

            $sqlUpdate = "UPDATE `$table` SET `$type_entreprise_id` = '$entreprise_id' WHERE `DOID` = $DOID";
            $query = mysqli_query($GLOBALS["conn"], $sqlUpdate);
            return true;
        }

        function updateEntreprise($entreprise_id, $array_entreprise){
            $type = $array_entreprise["type"];
            $sqlUpdate = ' UPDATE `entreprise` 
                            SET `raison_sociale` = "'.$array_entreprise['raison_sociale'].'"
                                , `nom` = "'.$array_entreprise['nom'].'"
                                , `prenom` = "'.$array_entreprise['prenom'].'"
                                , `adresse` = "'.$array_entreprise['adresse'].'"
                                , `code_postal` = "'.$array_entreprise['code_postal'].'"
                                , `commune` = "'.$array_entreprise['commune'].'"
                                , `numero_siret`= "'.$array_entreprise['numero_siret'].'"
                             WHERE id='.$entreprise_id ;  
            //echo $sqlUpdate;
            
            $query = mysqli_query($GLOBALS["conn"], $sqlUpdate);
            return $entreprise_id;
        };