<?php

    require_once 'models/do.model.php';
    require_once 'models/entreprise.model.php';
    require_once 'models/rcd.model.php';

    function validDisplay($currentstep){
        
            $title = "Recueil d'information Dommage ouvrage - synthèse";         
            $DOID = $_GET['doid'];
            $DATA = getDo($DOID);
            //var_dump($DATA);
            $DATA['moa_nature_travaux_json'] = json_decode($DATA['moa_nature_travaux_json'], true);
            $entreprises = getEntreprises($DOID);
            foreach ($entreprises as $key => $entreprise) {
                if(!empty($entreprise)){
                    $array_entreprises[substr($key,0,3)] = loadEntreprise($entreprise);
                }
            }


            // Remplissage de la variable $content
            ob_start();
            require 'views/templates/fiche/do.header.view.php';
            require 'views/templates/fiche/s01-coordonnees.view.php';
            require 'views/templates/fiche/s02-maitre-ouvrage.view.php';
            require 'views/templates/fiche/s03-oper-construct.view.php';
            require 'views/templates/fiche/s04-informations-diverses.view.php';
            require 'views/templates/fiche/s04bis-travaux-annexes.view.php';
            require 'views/templates/fiche/s05-maitrise-oeuvre.view.php';
            require 'views/validation.view.php';
            $content = ob_get_clean();
            require("views/base.view.php");
        }

   function finalDisplay($currentstep){
        
            $title = "Recueil d'information Dommage ouvrage - Finalisation";         

            // Remplissage de la variable $content
            ob_start();

            init_RCD_DOID($_SESSION['DOID']);
            require 'views/finalisation.view.php';
            $content = ob_get_clean();
            require("views/base.view.php");
        
    }        