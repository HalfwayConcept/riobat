<?php

    require_once 'models/do.model.php';
    require_once 'models/entreprise.model.php';
    require_once 'models/rcd.model.php';

    function validDisplay($currentstep){
               
            $DOID = $_GET['doid'];
            $DATA = getDo($DOID);
            $DATA['moa_nature_travaux_json'] = json_decode($DATA['moa_nature_travaux_json'] ?? '', true);
            $entreprises = getEntreprises($DOID);
            $array_entreprises = [];
            foreach ($entreprises as $key => $entreprise) {
                if(!empty($entreprise)){
                    $array_entreprises[substr($key,0,3)] = loadEntreprise($entreprise);
                }
            }

            // Mode admin (fiche) ou utilisateur (validation)
            $isAdminFiche = ($currentstep === 'fiche');
            $title = $isAdminFiche ? "Fiche Dommage Ouvrage n° ".$DOID : "Recueil d'information Dommage ouvrage";

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

            // Résoudre le DOID depuis GET (prioritaire) ou session (fallback)
            $doid = !empty($_GET['doid']) ? (int)$_GET['doid'] : (!empty($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : 0);

            // Remplissage de la variable $content
            ob_start();

            init_RCD_DOID($doid);
            addDoHistorique($doid, 'Validation', $_SESSION['user_id'] ?? null, 'Validation et finalisation de la demande DO');
            require 'views/finalisation.view.php';
            $content = ob_get_clean();
            require("views/base.view.php");
        
    }        