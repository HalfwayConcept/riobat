<?php 
    require_once 'models/do.model.php';
    require_once 'models/rcd.model.php';
    //

    function rcdDisplay($currentstep){
        
        // Titre personnalisé
        $title = "Formulaire RCD";
        
        $date = new DateTimeImmutable();
        $newfolder= hash('crc32', $date->getTimestamp());

    
        // Envoi des champs du formulaire
        if (!empty($_POST)) {

            //insert
            if(!empty($_POST['lot_id'])){
                foreach ($_POST['lot_id'] as $key => $lot_id) {
                    $array_values = array();
                    $array_values['doid']           = $_GET['doid'];
                    $array_values['lot_nom']        = $_POST['lot_nom'][$key];
                    $array_values['lot_montant']    = $_POST['lot_montant'][$key];
                    $array_values['lot_nature']     = $_POST['lot_nature'][$key];
                    if($lot_id == 'NEW_LOT'){         
                        insert_rdc($array_values);
                    }else{
                        $array_values['date_debut']    = $_POST['lot_date_debut'][$key];
                        $array_values['date_fin']      = $_POST['lot_date_fin'][$key];
                        update_rdc($lot_id, $array_values);
                    }
                }
            }

            foreach ($_POST as $key => $value)
            {
                $_SESSION['info_'.$_POST['fields']][$key] = $value;
            }

            $files_ok = array();
            if(!empty($_FILES)){
               require_once 'models/upload.php';
            }            
            if(!empty($files_ok)){
                foreach ($files_ok as $key => $value) {
                    updatercdupload($_POST['fields'], $value, $_POST['doid']);
                }
            }
        }
        $DATA = array();
        if (isset($_GET['doid']) && !empty($_GET['doid'])) {   
            $folder = getFolderName($_GET['doid']);

            $DOID = $_GET['doid'];
            $DATA = getDo($DOID);

        }        
        $array_datas = getRcdByDoid($_GET['doid']);
        $array_natures = getListNature();
        // Remplissage de la variable $content
        ob_start();
        require 'views/templates/fiche/do.header.view.php';
        require 'views/admin/rcd.view.php';
        
        $content = ob_get_clean();
        require("views/base.view.php");
    }