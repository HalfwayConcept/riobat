<?php 
    //require_once 'models/do.model.php';
    require_once 'models/rcd.model.php';

    function rcdDisplay($currentstep){
        
        // Titre personnalisé
        $title = "Formulaire RCD";
        
        $date = new DateTimeImmutable();
        $newfolder= hash('crc32', $date->getTimestamp());

        $array_natures = getListNature();

        $array_fake_data = array
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
            1 => array
                    (
                        'nom' => 'MACON 48',
                        'montant' => 35500,
                        'nature' => 3,
                        'nature-autre' => "",
                        'debut' => '20/02/2022',
                        'fin' => '20/02/2032',                        
                        'folder' => '82f52dfc',
                        'rcdfile' => '',
                        'rcdfileremarque' => '',     
                        'annexefile' => 'urssaf-justificatif-declaration-2024-03-20240425-09h11.pdf',
                        'annexefileremarque' => 'Yes !  trop bien',
                        'status' => '2'                                           
                    ),
            2 => array
                    (
                        'nom' => 'TTRAVO',
                        'montant' => 35500,
                        'nature' => 99,
                        'nature-autre' => "chauffe-eau-solaire",
                        'debut' => '20/02/2022',
                        'fin' => '20/02/2032',                        
                        'folder' => '82f52dfc',
                        'rcdfile' => '',
                        'rcdfileremarque' => '',     
                        'annexefile' => 'urssaf-justificatif-declaration-2024-03-20240425-09h11.pdf',
                        'annexefileremarque' => 'Encore mieux ☺️',
                        'status' => '2'                                           
                    ) ,
            3 => array
                    (
                        'nom' => 'Carreleur',
                        'montant' => 12500,
                        'nature' => 11,
                        'nature-autre' => "",
                        'debut' => '20/02/2022',
                        'fin' => '20/02/2032',                        
                        'folder' => '82f52dfc',
                        'rcdfile' => '',
                        'rcdfileremarque' => '',     
                        'annexefile' => '',
                        'annexefileremarque' => '',
                        'status' => '2'                                           
                    )                                       
        );
        
        $array_datas = $array_fake_data;

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
        require 'views/rcd.view.php';
        
        $content = ob_get_clean();
        require("views/base.view.php");
    }