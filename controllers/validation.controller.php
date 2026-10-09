<?php

    require_once 'models/do.model.php';
    require_once 'models/entreprise.model.php';
    require_once 'models/rcd.model.php';
    require_once 'models/email.model.php';

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
            $isPvDemand = (($DATA['type_demande'] ?? 'do') === 'pv');
            if ($isPvDemand) {
                $title = $isAdminFiche ? "Fiche d'étude Photovoltaique n° ".$DOID : "Recueil d'information Contrat photovoltaique";
            } else {
                $title = $isAdminFiche ? "Fiche Dommage Ouvrage n° ".$DOID : "Recueil d'information Dommage ouvrage";
            }

            $PV_DESCRIPTION = [];
            $PV_PREVENTION = [];
            $PV_ENVIRONNEMENT = [];
            $PV_PROTECTION = [];
            if ($isPvDemand) {
                $PV_DESCRIPTION = getPvDescription((int)$DOID);
                $PV_PREVENTION = getPvPrevention((int)$DOID);
                $PV_ENVIRONNEMENT = getPvEnvironnement((int)$DOID);
                $PV_PROTECTION = getPvProtection((int)$DOID);
            }

            // Remplissage de la variable $content
            ob_start();
            if ($isPvDemand) {
                require 'views/templates/fiche/pv.header.view.php';
                require 'views/templates/fiche/s01-coordonnees.view.php';
                require 'views/templates/fiche/pv.s02-description.view.php';
                require 'views/templates/fiche/pv.s03-prevention.view.php';
                require 'views/templates/fiche/pv.s04-environnement.view.php';
                require 'views/templates/fiche/pv.s05-protection-garanties.view.php';
            } else {
                require 'views/templates/fiche/do.header.view.php';
                require 'views/templates/fiche/s01-coordonnees.view.php';
                require 'views/templates/fiche/s02-maitre-ouvrage.view.php';
                require 'views/templates/fiche/s03-oper-construct.view.php';
                require 'views/templates/fiche/s04-informations-diverses.view.php';
                require 'views/templates/fiche/s04bis-travaux-annexes.view.php';
                require 'views/templates/fiche/s05-maitrise-oeuvre.view.php';
            }
            require 'views/validation.view.php';
            $content = ob_get_clean();
            require("views/base.view.php");
        }

   function finalDisplay($currentstep){
            // Résoudre le DOID depuis GET (prioritaire) ou session (fallback)
            $doid = !empty($_GET['doid']) ? (int)$_GET['doid'] : (!empty($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : 0);
            $do = $doid > 0 ? getDo($doid) : false;
            $isPvDemand = ($do['type_demande'] ?? 'do') === 'pv';
            $title = $isPvDemand
                ? "Recueil d'information photovoltaïque - Finalisation"
                : "Recueil d'information Dommage ouvrage - Finalisation";
            $isUpdate = $do && (int)($do['status'] ?? 0) !== 0;

            // Remplissage de la variable $content
            ob_start();

            if ($do && validDo($doid)) {
                if (!$isPvDemand) {
                    init_RCD_DOID($doid);
                }
                addDoHistorique(
                    $doid,
                    'Validation',
                    $_SESSION['user_id'] ?? null,
                    'Validation et finalisation de la demande ' . ($isPvDemand ? 'photovoltaïque' : 'DO')
                );
                sendDossierValidationAlert($doid, (bool)$isUpdate);
            }
            require 'views/finalisation.view.php';
            $content = ob_get_clean();
            require("views/base.view.php");
        
    }        