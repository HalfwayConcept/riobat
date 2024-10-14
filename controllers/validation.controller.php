<?php

    require_once 'models/do.model.php';
    require_once 'models/entreprise.model.php';

    function validDisplay($currentstep){
        
            $title = "Recueil d'information Dommage ouvrage - synthèse";         
            $DATA = getDo($_SESSION['DOID']);

            $entreprises = getEntreprises($_SESSION['DOID']);
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