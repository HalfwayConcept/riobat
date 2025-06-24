<?php 
    require_once 'models/do.model.php';
    require_once 'models/rcd.model.php';
    //

    function rcdDisplay($currentstep){
        
        // Titre personnalisé
        $title = "Formulaire RCD";
        
        $date = new DateTimeImmutable();
        $newfolder= hash('crc32', $date->getTimestamp());

        

        $DATA = array();
        if (isset($_GET['doid']) && !empty($_GET['doid'])) {   
            $folder = getFolderName($_GET['doid']);

            $DOID = $_GET['doid'];
            $DATA = getDo($DOID);

            $array_datas = getRcdByDoid($_GET['doid']);

            if (empty($DATA)) {
                //header("Location: index.php?page=error");
            } else {
                // On remplace les valeurs de l'array par les valeurs de la BDD

            }
        }

        // Envoi des champs du formulaire
        if (isset($_POST)) {
            if(!empty($_POST['lot_id'])){
                foreach ($_POST['lot_id'] as $key => $value) {
                    $array_values = array();
                    # code...   
                    $array_values['doid']           = $_GET['doid'];
                    $array_values['lot_nom']        = $_POST['lot_nom'][$key];
                    $array_values['lot_montant']    = $_POST['lot_montant'][$key];
                    $array_values['lot_nature']     = $_POST['lot_nature'][$key];
                    insert_rdc($array_values);
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
            
            $keys = array_keys($_SESSION['info_'.$_POST['fields']]);
            if (in_array('send_step8', $keys)) {
                unset($_SESSION['info_'.$_POST['fields']]['send_step8']);
            }  
            //header("Location: index.php?page=validation");
        }

        $array_natures = getListNature();
        // Remplissage de la variable $content
        ob_start();
        require 'views/templates/fiche/do.header.view.php';
        require 'views/admin/rcd.view.php';
        
        $content = ob_get_clean();
        require("views/base.view.php");
    }