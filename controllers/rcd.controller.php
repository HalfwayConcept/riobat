<?php 
    require_once 'models/do.model.php';
    require_once 'models/rcd.model.php';
    //require_once 'models/upload.php';

    function rcdDisplay($currentstep){
        
        // Titre personnalisé
        $title = "Formulaire RCD";
        
        $date = new DateTimeImmutable();
        $newfolder= hash('crc32', $date->getTimestamp());

        $array_natures = getListNature();



        /*$array_fake_data = array
        (
            0 => array
                    (
                        'nom' => 'GEVAUBOIS',
                        'montant' => 5500,
                        'nature' => 5,
                        'nature-autre' => "",
                        'debut' => '20/02/2024',
                        'fin' => '20/02/2034',
                        'folder' => '94f52dfc',
                        'rcdfile' => 'urssaf-justificatif-declaration-2024-03-20240425-09h11.pdf',
                        'rcdfileremarque' => 'Yes !  trop bien',
                        'annexefile' => '',
                        'annexefileremarque' => '',
                        'status' => '1'
                    ),                              
        );
        
        $array_datas = $array_fake_data;*/



        if($_FILES){
            var_dump($_FILES);
        }
        $DATA = array();
        if (isset($_GET['doid']) && !empty($_GET['doid'])) {   

            $DOID = $_GET['doid'];
            $DATA = getDo($DOID);

            $array_datas = getRcdByDoid($_GET['doid']);
            echo "<pre>";
            var_dump($array_datas);
            echo "</pre>";
            //var_dump($DATA_RCD);

            if (empty($DATA)) {
                //header("Location: index.php?page=error");
            } else {
                // On remplace les valeurs de l'array par les valeurs de la BDD

            }
        }

        // Envoi des champs du formulaire
        if (isset($_POST['fields'])) {
            foreach ($_POST as $key => $value)
            {
                $_SESSION['info_'.$_POST['fields']][$key] = $value;
            }

            if(!empty($_FILES)){
                require "models/upload.php";
            }            
            $keys = array_keys($_SESSION['info_'.$_POST['fields']]);
            if (in_array('send_step8', $keys)) {
                unset($_SESSION['info_'.$_POST['fields']]['send_step8']);
            }  
            //header("Location: index.php?page=validation");
        }

        // Remplissage de la variable $content
        ob_start();
        require 'views/templates/fiche/do.header.view.php';
        require 'views/admin/rcd.view.php';
        
        $content = ob_get_clean();
        require("views/base.view.php");
    }