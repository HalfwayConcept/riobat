<?php
    
    require_once 'models/do.model.php';
    require_once 'models/entreprise.model.php'; 
    

    function clearSessionDO(){
        $_SESSION["info_debut"]=[];
        $_SESSION["info_souscripteur"]=[];
        $_SESSION["DOID"]=[];
        $_SESSION["info_operation_construction"]=[];
        $_SESSION["info_moa"]=[];
        $_SESSION["info_situation"]=[];
        $_SESSION["info_travaux_annexes"]=[];
        $_SESSION["info_moe"]=[];
        return true;
    }

    function stepDisplay($currentstep){  
        // Remplissage de la variable $content
        ob_start();

        if(!empty($_GET['session_load_id'])){
            loadDo($_GET['session_load_id']);
        }

        switch ($currentstep) {
            case 'step0':
                $title = "Formulaire Dommage Ouvrage";
                require('views/templates/form/s00-debuter.view.php');
                break;            
            case 'step1':
                $title = "Formulaire DO-01";
                require('views/templates/form/s01-coordonnees.view.php');
                break;
            case 'step2':
                $title = "Formulaire DO-02";
                require('views/templates/form/s02-maitre-ouvrage.view.php');
                break;           
            case 'step3':
                $title = "Formulaire DO-03";
                require('views/templates/form/s03-oper-construct.view.php');
                break;
            case 'step4':
                $title = "Formulaire DO-04";
                require('views/templates/form/s04-informations-diverses.view.php');
                break; 
            case 'step4bis':
                $title = "Formulaire DO-04bis";                                
                require('views/templates/form/s04bis-travaux-annexes.view.php');     
                break;                
            case 'step5':
                $title = "Formulaire DO-05";
                require('views/templates/form/s05-maitrise-oeuvre.view.php');
                break;                                               
            default:
                # code...
                break;
        }

         // Envoi des champs du formulaire
         if (isset($_POST['fields'])) {
            foreach ($_POST as $key => $value)
            {
                $_SESSION['info_'.$_POST['fields']][$key] = $value;
            }
            $keys = array_keys($_SESSION['info_'.$_POST['fields']]);
            //$res = false;
            if($currentstep == "step0"){
                if(isset($_POST['checkbox-approuve'])){
                    if($_POST['checkbox-approuve'] == 1){
                        $res=true;  
                    }
                }else{
                    $res=false;
                    $message = "Vous devez cocher la case pour accepter les conditions générales du contrat Dommage Ouvrage et les Mentions légales RGPD";
                }
            }elseif($currentstep == "step1"){
                if(!empty($_GET['session_load_id'])){
                    $new_DOID = $_GET['session_load_id'];
                }else{
                    $new_DOID = insert($_SESSION["info_souscripteur"]);
                    $new_DOID = insert_utilisateur_session($new_DOID, $_SESSION['user_id']);
                }
                $_SESSION["DOID"] = $new_DOID;
                $res=true;
            }elseif($currentstep == "step4" || $currentstep == "step5"){            
                if($currentstep == "step4"){
                    $prefix = 'sol' ;
                    $session_key = "info_situation";
                }else{
                    $prefix = 'moe';
                    $session_key = "info_dommage_ouvrage";
                }  
                $doid = $_SESSION["DOID"];
                $res = update($_SESSION['info_'.$_POST['fields']], $_POST['fields'], $_SESSION["DOID"] );
                if($_SESSION['info_'.$_POST['fields']][$prefix] == 1){
                    $array_entreprise = array();
                    
                    $array_entreprise['id']            = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_id'];                                          
                    $array_entreprise['raison_sociale']= $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_raison_sociale'];
                    $array_entreprise['nom']           = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_nom'];
                    $array_entreprise['prenom']        = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_prenom'];
                    $array_entreprise['adresse']       = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_adresse'];
                    $array_entreprise['code_postale']  = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_code_postale'];
                    $array_entreprise['commune']       = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_commune'];
                    $array_entreprise['numero_siret']  = $_SESSION['info_'.$_POST['fields']][$prefix.'_numero_siret'];
                    $array_entreprise['type']          = $prefix; 

                    if(!empty($array_entreprise['id'])){
                        $id = updateEntreprise($_SESSION[$session_key][$prefix.'_entreprise_id'],$array_entreprise);   
                        $_SESSION[$session_key][$prefix.'_entreprise_id'] = $id;                                                                                            
                    }else{
                        $id = insertEntreprise($array_entreprise);
                        $_SESSION[$session_key][$prefix.'_entreprise_id'] = $id;
                        updateEntrepriseID($id, $prefix, $_SESSION["DOID"]);
                    }      
              
                }
            }elseif($currentstep == "step4bis"){
                    $res = update($_SESSION['info_'.$_POST['fields']], $_POST['fields'], $_SESSION["DOID"] );
                    $top = 0;
                    $array_entreprises = array();
                    foreach ($_SESSION["info_travaux_annexes"] as $key => $value) {
                        if(     $key == 'phv_entreprise_raison_sociale'
                            ||  $key == 'cnr_entreprise_raison_sociale'
                            ||  $key == 'boi_entreprise_raison_sociale'
                            ||  $key == 'geo_entreprise_raison_sociale'
                            ||  $key == 'ctt_entreprise_raison_sociale'
                            ||  $key == 'sol_entreprise_raison_sociale'
                        ){
                            $prefix =  substr($key, 0, 3);
                            $array_entreprises[$top]['id']            = $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_id'];                                          
                            $array_entreprises[$top]['raison_sociale']= $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_raison_sociale'];
                            $array_entreprises[$top]['nom']           = $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_nom'];
                            $array_entreprises[$top]['prenom']        = $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_prenom'];
                            $array_entreprises[$top]['adresse']       = $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_adresse'];
                            $array_entreprises[$top]['code_postale']  = $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_code_postale'];
                            $array_entreprises[$top]['commune']       = $_SESSION["info_travaux_annexes"][$prefix.'_entreprise_commune'];
                            $array_entreprises[$top]['numero_siret']  = $_SESSION["info_travaux_annexes"][$prefix.'_numero_siret'];
                            $array_entreprises[$top]['type']          = $prefix;
                            
                            $top++;
                        }
                    }
                    if(count($array_entreprises)>0){
                        foreach ($array_entreprises as $key => $array_entreprise) {
                            if(!empty($array_entreprise)){
                                //$res = viewEntreprise($array_entreprise);
                                
                                if(!empty($array_entreprise['id'])){

                                    $id = updateEntreprise($_SESSION["info_travaux_annexes"][$array_entreprise['type'].'_entreprise_id'],$array_entreprise);
                                    
                                    $_SESSION["info_travaux_annexes"][$array_entreprise['type'].'_entreprise_id'] = $id;                                                           
                                    
                                }else{
                                    $id = insertEntreprise($array_entreprise);
                                    $_SESSION["info_travaux_annexes"][$array_entreprise['type'].'_entreprise_id'] = $id;
                                    updateEntrepriseID($id, $array_entreprise['type'], $_SESSION["DOID"]);
                                }                               
                            }
                        }
                    }
            }else{
                $res = update($_SESSION['info_'.$_POST['fields']], $_POST['fields'], $_SESSION["DOID"] );
                $doid = $_SESSION["DOID"];
            }

            if($res === false){
                // echo ERREUR LORS DE L'AJOUT OU MODIFICATION EN BDD
            }else{                
                if(!empty($_POST['page_next'])){
                    $nextstep = $_POST['page_next'];
                }
                $doid = $_SESSION["DOID"];
                header("Location: index.php?page=".$nextstep."&doid=$doid"); 

            }
            
        }

        if($currentstep == 'step4bis'){
            if($_SESSION["info_situation"]['situation_boi']=="0"
            && $_SESSION["info_situation"]['situation_phv'] =="0" 
            && $_SESSION["info_situation"]['situation_geo'] =="0" 
            && $_SESSION["info_situation"]['situation_ctt'] =="0"
            && $_SESSION["info_situation"]['situation_cnr'] =="0") {
                header("Location: index.php?page=step5");
            }  
        }

 
        $content = ob_get_clean();
        require("views/base.view.php");
    }

