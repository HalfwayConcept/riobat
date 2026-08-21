<?php
    
    require_once 'models/do.model.php';
    require_once 'models/entreprise.model.php'; 
    require_once 'models/user.model.php';

    /**
     * Résout le DOID de manière sécurisée :
     * 1. Priorité au POST (champ hidden dans le formulaire)
     * 2. Fallback sur la session
     * 3. Vérifie la cohérence POST vs session (si les deux existent)
     * 4. Vérifie que l'utilisateur est bien propriétaire du DO
     */
    function resolveDoid() {
        $post_doid = !empty($_POST['doid']) ? (int)$_POST['doid'] : 0;
        $session_doid = !empty($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : 0;

        $doid = $post_doid > 0 ? $post_doid : $session_doid;

        // Vérification de propriété (sauf admin/collab)
        if ($doid > 0 && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user') {
            if (!userOwnsDo($_SESSION['user_id'] ?? 0, $doid)) {
                $_SESSION['validation_errors'] = ["Accès non autorisé à ce dossier."];
                header("Location: index.php?page=home");
                exit;
            }
        }

        if ($post_doid > 0 && $session_doid > 0 && $session_doid !== $post_doid) {
            // Recharger les données de cette DO en session
            loadDo($post_doid);
        }
        return $doid;
    }

    function clearSessionDO(){
        $_SESSION["info_debut"]=[];
        $_SESSION["info_souscripteur"]=[];
        $_SESSION["DOID"]=[];
        $_SESSION["type_demande"]='pv';
        $_SESSION["info_operation_construction"]=[];
        $_SESSION["info_dommage_ouvrage"]=[];
        $_SESSION["info_moa"]=[];
        $_SESSION["info_moa_souscripteur"]=[];
        $_SESSION["info_situation"]=[];
        $_SESSION["info_travaux_annexes"]=[];
        $_SESSION["info_pv_prevention"]=[];
        $_SESSION["info_pv_environnement"]=[];
        $_SESSION["info_pv_protection"]=[];
        $_SESSION["info_moe"]=[];
        $_SESSION["SQL"]=[];
        return true;
    }

    function stepDisplay($currentstep){  
        // Remplissage de la variable $content
        ob_start();

        // Toutes les nouvelles demandes sont désormais de type photovoltaïque.
        $_SESSION['type_demande'] = 'pv';

        if(!empty($_GET['session_load_id'])){
            loadDo($_GET['session_load_id']);
        } elseif (!empty($_GET['doid'])) {
            // Synchroniser la session si le doid GET diffère du doid session (multi-onglet)
            $get_doid = (int)$_GET['doid'];
            if ($get_doid > 0 && (!isset($_SESSION['DOID']) || (int)$_SESSION['DOID'] !== $get_doid)) {
                loadDo($get_doid);
            }
        }
        
        // Pré-remplir step1 avec les infos du profil utilisateur si connecté
        if ($currentstep === 'step1' && empty($_GET['session_load_id'])) {
            if (!empty($_SESSION['user_id'])) {
                require_once 'models/user.model.php';
                $user_info = get_infos($_SESSION['user_id']);
                if ($user_info) {
                    $_SESSION["info_souscripteur"] = [
                        'souscripteur_nom_raison' => $user_info['nom'] . ' ' . $user_info['prenom'],
                        'souscripteur_siret' => $user_info['siret'] ?? '',
                        'souscripteur_adresse' => $user_info['adresse'] ?? '',
                        'souscripteur_code_postal' => $user_info['code_postal'] ?? '',
                        'souscripteur_commune' => $user_info['commune'] ?? '',
                        'souscripteur_profession' => $user_info['profession'] ?? '',
                        'souscripteur_telephone' => $user_info['telephone'] ?? '',
                        'souscripteur_email' => $user_info['email'] ?? '',
                    ];
                }
            }
        }

        switch ($currentstep) {
            case 'step0':
                $title = (($_SESSION['type_demande'] ?? 'do') === 'pv') ? "Formulaire Contrat" : "Formulaire Dommage Ouvrage";
                require('views/templates/form/s00-debuter.view.php');
                break;            
            case 'step1':
                $title = "Formulaire DO-01";
                require('views/templates/form/s01-coordonnees.view.php');
                break;
            case 'step2':
                $title = "Formulaire DO-02";
                if (($_SESSION['type_demande'] ?? 'do') === 'pv') {
                    require('views/templates/form/s02-pv-description.view.php');
                } else {
                    require('views/templates/form/s02-maitre-ouvrage.view.php');
                }
                break;           
            case 'step3':
                $title = "Formulaire DO-03";
                if (($_SESSION['type_demande'] ?? 'do') === 'pv') {
                    $doid_redirect = isset($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : 0;
                    header("Location: index.php?page=step4&doid=$doid_redirect");
                    exit;
                } else {
                    require('views/templates/form/s03-do-oper-construct.view.php');
                }
                break;
            case 'step4':
                $title = "Formulaire DO-04";
                if (($_SESSION['type_demande'] ?? 'do') === 'pv') {
                    require('views/templates/form/s04-pv-prevention.view.php');
                } else {
                    require('views/templates/form/s04-do-informations-diverses.view.php');
                }
                break; 
            case 'step4bis':
                $title = "Formulaire DO-04bis";                                
                if (($_SESSION['type_demande'] ?? 'do') === 'pv') {
                    require('views/templates/form/s04bis-pv-environnement.view.php');
                } else {
                    require('views/templates/form/s04bis-do-travaux-annexes.view.php');
                }
                break;                
            case 'step4ter':
                $title = "Formulaire DO-04ter";
                if (($_SESSION['type_demande'] ?? 'do') === 'pv') {
                    require('views/templates/form/s04ter-pv-protection.view.php');
                } else {
                    require('views/templates/form/s05-maitrise-oeuvre.view.php');
                }
                break;
            case 'step5':
                $title = "Formulaire DO-05";
                if (($_SESSION['type_demande'] ?? 'do') === 'pv') {
                    require('views/templates/form/s05-pv-garanties.view.php');
                } else {
                    require('views/templates/form/s05-maitrise-oeuvre.view.php');
                }
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

            // Résoudre le DOID depuis POST (prioritaire) ou session (fallback)
            $doid = resolveDoid();
            // DEV: Vider les tableaux de session si demandé
            if ($currentstep == "step1" && isset($_POST['dev_clear_session']) && $_POST['dev_clear_session'] == '1') {
                $_SESSION['info_moa'] = [];
                $_SESSION['info_operation_construction'] = [];
                $_SESSION['info_situation'] = [];
                $_SESSION['info_travaux_annexes'] = [];
                $_SESSION['info_pv_prevention'] = [];
                $_SESSION['info_pv_environnement'] = [];
                $_SESSION['info_pv_protection'] = [];
            }
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
                    $res = true;
                }else{
                    $new_DOID = insert($_SESSION["info_souscripteur"], $_SESSION['type_demande'] ?? 'do');
                    if ($new_DOID && (int)$new_DOID > 0) {
                        // Si l'utilisateur n'est pas connecté, on ne crée pas de session utilisateur liée
                        if (!empty($_SESSION['user_id'])) {
                            $new_user_session = insert_utilisateur_session($new_DOID, $_SESSION['user_id']);
                            addDoHistorique($new_DOID, 'Création', $_SESSION['user_id'], 'Création de la demande ' . strtoupper($_SESSION['type_demande'] ?? 'do'));
                        } else {
                            addDoHistorique($new_DOID, 'Création', null, 'Création de la demande ' . strtoupper($_SESSION['type_demande'] ?? 'do') . ' (anonyme)');
                        }
                        $res = true;
                    } else {
                        $res = false;
                        $_SESSION['validation_errors'] = [
                            "Erreur lors de la création du dossier. Vérifiez que la migration de table centrale est bien appliquée."
                        ];
                    }
                }
                if ($res) {
                    $_SESSION["DOID"] = $new_DOID;
                    $doid = (int)$new_DOID;
                }
            }elseif($currentstep == "step2"){
                $isPvStep = (($_SESSION['type_demande'] ?? 'do') === 'pv');

                if ($isPvStep) {
                    $errors = [];
                    $info = $_SESSION['info_operation_construction'];

                    if (empty(trim((string)($info['pv_adresse'] ?? '')))) {
                        $errors[] = "L'adresse de la centrale photovoltaïque est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_code_postal'] ?? '')))) {
                        $errors[] = "Le code postal est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_commune'] ?? '')))) {
                        $errors[] = "La commune est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_entreprise_pose_qualipv'] ?? '')))) {
                        $errors[] = "Le nom et la qualification de l'entreprise de pose sont obligatoires.";
                    }
                    if (empty(trim((string)($info['pv_valeur_neuve_remplacement'] ?? '')))) {
                        $errors[] = "La valeur à neuf de remplacement est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_date_mise_en_service'] ?? '')))) {
                        $errors[] = "La date de mise en service est obligatoire.";
                    }
                    if (!isset($info['pv_deja_assuree']) || ($info['pv_deja_assuree'] !== '0' && $info['pv_deja_assuree'] !== '1')) {
                        $errors[] = "Vous devez indiquer si la centrale a déjà été assurée.";
                    }
                    if (!isset($info['pv_sinistre_deja']) || ($info['pv_sinistre_deja'] !== '0' && $info['pv_sinistre_deja'] !== '1')) {
                        $errors[] = "Vous devez indiquer si la centrale a déjà subi un sinistre.";
                    }
                    if (($info['pv_sinistre_deja'] ?? '0') === '1' && empty(trim((string)($info['pv_sinistre_nature_montant'] ?? '')))) {
                        $errors[] = "La nature et le montant du sinistre sont obligatoires.";
                    }
                    if (empty(trim((string)($info['pv_surface_totale'] ?? '')))) {
                        $errors[] = "La surface totale est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_puissance_crete'] ?? '')))) {
                        $errors[] = "La puissance crête est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_nature_panneaux'] ?? '')))) {
                        $errors[] = "La nature des panneaux photovoltaïques est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_panneaux_details'] ?? '')))) {
                        $errors[] = "Le détail des panneaux photovoltaïques est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_onduleurs_details'] ?? '')))) {
                        $errors[] = "Le détail des onduleurs est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_prix_vente_kwh'] ?? '')))) {
                        $errors[] = "Le prix de vente du kWh est obligatoire.";
                    }
                    if (empty(trim((string)($info['pv_recettes_annuelles'] ?? '')))) {
                        $errors[] = "Les recettes prévisionnelles annuelles sont obligatoires.";
                    }
                    if (empty(trim((string)($info['pv_destination_energie'] ?? '')))) {
                        $errors[] = "Le mode d'exploitation de l'énergie est obligatoire.";
                    }
                    if (($info['pv_destination_energie'] ?? '') === 'autoconsommation') {
                        if (empty(trim((string)($info['pv_economies_achat_annuelles'] ?? '')))) {
                            $errors[] = "Les économies annuelles prévisionnelles sont obligatoires en autoconsommation.";
                        }
                        if (!isset($info['pv_batteries_existent']) || ($info['pv_batteries_existent'] !== '0' && $info['pv_batteries_existent'] !== '1')) {
                            $errors[] = "Vous devez indiquer s'il existe des batteries d'accumulateurs.";
                        }
                        if (($info['pv_batteries_existent'] ?? '0') === '1' && empty(trim((string)($info['pv_batteries_details'] ?? '')))) {
                            $errors[] = "Le détail des batteries est obligatoire.";
                        }
                    } else {
                        // Hors autoconsommation, ces champs ne s'appliquent pas.
                        $_SESSION['info_operation_construction']['pv_economies_achat_annuelles'] = null;
                        $_SESSION['info_operation_construction']['pv_batteries_existent'] = '0';
                        $_SESSION['info_operation_construction']['pv_batteries_details'] = null;
                    }

                    if (count($errors) > 0) {
                        $res = false;
                        $_SESSION['validation_errors'] = $errors;
                    } else {
                        $resPv = savePvDescription((int)$doid, $_SESSION['info_operation_construction']);
                        $res = $resPv;
                        if ($res) {
                            $_SESSION['validation_errors'] = [];
                        } elseif (empty($_SESSION['validation_errors'])) {
                            $detail = !empty($_SESSION['update_error']) ? ' (' . $_SESSION['update_error'] . ')' : '';
                            $_SESSION['validation_errors'] = ["Échec de sauvegarde de la table pv_description_centrale$detail"];
                        }
                    }
                } else {
                    // Validation step2 (DO)
                    $errors = [];
                    $moa_construction = isset($_SESSION['info_moa']['moa_construction']) ? $_SESSION['info_moa']['moa_construction'] : '';

                    if (isset($_SESSION['info_moa']['moa_souscripteur']) && $_SESSION['info_moa']['moa_souscripteur'] == 0) {
                        if (empty($_SESSION['info_moa']['moa_souscripteur_form_nom'])) {
                            $errors[] = "Le nom du Maître d'Ouvrage est obligatoire.";
                        }
                        if (empty($_SESSION['info_moa']['moa_souscripteur_form_adresse'])) {
                            $errors[] = "L'adresse du Maître d'Ouvrage est obligatoire.";
                        }
                        if (isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && $_SESSION['info_moa']['moa_souscripteur_form_civilite'] == 'entreprise') {
                            if (empty($_SESSION['info_moa']['moa_souscripteur_form_raison_sociale'])) {
                                $errors[] = "La raison sociale est obligatoire pour une entreprise.";
                            }
                        }
                    }

                    if (empty($_SESSION['info_moa']['moa_qualite'])) {
                        $errors[] = "Vous devez sélectionner une qualité de Maître d'Ouvrage.";
                    } else if ($_SESSION['info_moa']['moa_qualite'] !== 'moa_qualite_autre' && !is_numeric($_SESSION['info_moa']['moa_qualite'])) {
                        $errors[] = "La qualité sélectionnée est invalide.";
                    }

                    if ($moa_construction === '' || ($moa_construction != '0' && $moa_construction != '1')) {
                        $errors[] = "Vous devez indiquer si le Maître d'Ouvrage participe à la construction.";
                    }

                    if ($moa_construction == '1') {
                        $moa_construction_pro = isset($_SESSION['info_moa']['moa_construction_pro']) ? $_SESSION['info_moa']['moa_construction_pro'] : '';
                        if ($moa_construction_pro === '' || ($moa_construction_pro != '0' && $moa_construction_pro != '1')) {
                            $errors[] = "Vous devez indiquer si le Maître d'Ouvrage est un professionnel de la construction.";
                        }
                    }

                    if (count($errors) > 0) {
                        $res = false;
                        $_SESSION['validation_errors'] = $errors;
                    } else {
                        if (isset($_SESSION['info_moa']['moa_qualite_champ'])) {
                            unset($_SESSION['info_moa']['moa_qualite_champ']);
                        }

                        if (isset($_SESSION['info_moa']['moa_souscripteur']) && $_SESSION['info_moa']['moa_souscripteur'] == 0) {
                            $civilite = $_SESSION['info_moa']['moa_souscripteur_form_civilite'] ?? 'particulier';
                            $nom = $_SESSION['info_moa']['moa_souscripteur_form_nom'] ?? '';
                            $prenom = $_SESSION['info_moa']['moa_souscripteur_form_prenom'] ?? '';
                            $adresse = $_SESSION['info_moa']['moa_souscripteur_form_adresse'] ?? '';
                            $code_postal = $_SESSION['info_moa']['moa_souscripteur_form_code_postal'] ?? '';
                            $commune = $_SESSION['info_moa']['moa_souscripteur_form_commune'] ?? '';
                            $raison_sociale = $_SESSION['info_moa']['moa_souscripteur_form_raison_sociale'] ?? '';
                            $siret = $_SESSION['info_moa']['moa_souscripteur_form_siret'] ?? '';

                            $souscripteur_data = [
                                'souscripteur_form_civilite' => $civilite,
                                'souscripteur_nom_raison' => ($civilite === 'entreprise') ? $raison_sociale : trim($nom . ' ' . $prenom),
                                'souscripteur_adresse' => $adresse,
                                'souscripteur_code_postal' => $code_postal,
                                'souscripteur_commune' => $commune,
                                'souscripteur_siret' => ($civilite === 'entreprise') ? $siret : null,
                            ];

                            $sub_id = upsertMoaSouscripteur($doid, $souscripteur_data);
                            if ($sub_id) {
                                $_SESSION['info_moa']['moa_souscripteur_id'] = $sub_id;
                            }

                            $existing_ent_id = $_SESSION['info_moa']['moa_entreprise_id'] ?? null;
                            $array_entreprise = [
                                'raison_sociale' => ($civilite === 'entreprise') ? $raison_sociale : '',
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'adresse' => $adresse,
                                'code_postal' => $code_postal,
                                'commune' => $commune,
                                'numero_siret' => ($civilite === 'entreprise') ? $siret : '',
                                'type' => ($civilite === 'entreprise') ? 'moa' : 'particulier',
                            ];

                            if (!empty($existing_ent_id)) {
                                updateEntreprise($existing_ent_id, $array_entreprise);
                            } else {
                                $ent_id = insertEntreprise($array_entreprise);
                                if ($ent_id) {
                                    $_SESSION['info_moa']['moa_entreprise_id'] = $ent_id;
                                }
                            }
                        } else {
                            clearMoaSouscripteur($doid);
                            $_SESSION['info_moa']['moa_souscripteur_id'] = null;
                            $_SESSION['info_moa']['moa_entreprise_id'] = null;
                        }

                        $res = update($_SESSION['info_moa'], 'moa', $doid);
                        $_SESSION['validation_errors'] = [];
                    }
                }
            }elseif($currentstep == "step3"){
                $errors = [];
                $info = $_SESSION['info_operation_construction'];

                $nature_neuf_exist = isset($info['nature_neuf_exist']) ? $info['nature_neuf_exist'] : '';

                if (empty($nature_neuf_exist) || ($nature_neuf_exist != 'neuve' && $nature_neuf_exist != 'existante')) {
                    $errors[] = "Vous devez sélectionner la nature de l'opération (Neuve ou Existante).";
                }

                if ($nature_neuf_exist == 'existante') {
                    $has_existant_option = (isset($info['nature_operation_surelev']) && $info['nature_operation_surelev'] == 1)
                        || (isset($info['nature_operation_ext_horizont']) && $info['nature_operation_ext_horizont'] == 1)
                        || (isset($info['nature_operation_renovation']) && $info['nature_operation_renovation'] == 1)
                        || (isset($info['nature_operation_rehabilitation']) && $info['nature_operation_rehabilitation'] == 1)
                        || (isset($info['operation_sinistre']) && $info['operation_sinistre'] == 1);

                    if (!$has_existant_option) {
                        $errors[] = "Pour une construction existante, vous devez sélectionner au moins une option (surélévation, extension, rénovation, réhabilitation ou sinistre).";
                    }
                }

                if (empty($info['construction_adresse'])) {
                    $errors[] = "L'adresse de la construction est obligatoire.";
                }
                if (empty($info['construction_adresse_code_postal'])) {
                    $errors[] = "Le code postal est obligatoire.";
                }
                if (empty($info['construction_adresse_commune'])) {
                    $errors[] = "La commune est obligatoire.";
                }

                if (count($errors) > 0) {
                    $res = false;
                    $_SESSION['validation_errors'] = $errors;
                } else {
                    foreach ([
                        'construction_cout_operation',
                        'construction_cout_honoraires_moe',
                        'type_ouvrage_ope_pavill_nombre',
                        'type_ouvrage_coll_habit_nombre'
                    ] as $numField) {
                        if (isset($_SESSION['info_operation_construction'][$numField])) {
                            $val = preg_replace('/[^0-9]/', '', (string)$_SESSION['info_operation_construction'][$numField]);
                            $_SESSION['info_operation_construction'][$numField] = $val === '' ? null : $val;
                        }
                    }
                    $res = update($_SESSION['info_operation_construction'], 'operation_construction', $doid);
                    $_SESSION['validation_errors'] = [];
                }
            }elseif($currentstep == "step4" || $currentstep == "step5"){  
                $isPvStep = (($_SESSION['type_demande'] ?? 'do') === 'pv');

                if($currentstep == "step4"){
                    $prefix = 'sol' ;
                    $session_key = "info_situation";
                }
                if($currentstep == "step5"){
                    $prefix = 'moe';
                    $session_key = "info_dommage_ouvrage";
                }
                $res = update($_SESSION['info_'.$_POST['fields']], $_POST['fields'], $doid );

                // En parcours PV, l'etape 5 ne contient que les garanties (pas de maitre d'oeuvre).
                if ($currentstep == "step5" && $isPvStep) {
                    // Rien d'autre a persister ici.
                } else {
                // N'enregistrer les coordonnées que si la réponse est "Oui" (1)
                if(isset($_SESSION['info_'.$_POST['fields']][$prefix]) && $_SESSION['info_'.$_POST['fields']][$prefix] == 1){
                    $array_entreprise = array();
                    $array_entreprise['id']            = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_id'] ?? null;
                    $array_entreprise['raison_sociale']= $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_raison_sociale'] ?? '';
                    $array_entreprise['nom']           = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_nom'] ?? '';
                    $array_entreprise['prenom']        = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_prenom'] ?? '';
                    $array_entreprise['adresse']       = $_SESSION['info_'.$_POST['fields']][$prefix.'_entreprise_adresse'] ?? '';
                    $array_entreprise['code_postale']  = $_SESSION['info_'.$_POST['fields']][$prefix+'_entreprise_code_postale'] ?? '';
                    $array_entreprise['commune']       = $_SESSION['info_'.$_POST['fields']][$prefix+'_entreprise_commune'] ?? '';
                    $array_entreprise['numero_siret']  = $_SESSION['info_'.$_POST['fields']][$prefix+'_numero_siret'] ?? '';
                    $array_entreprise['type']          = $prefix;
                    // Ne rien faire si aucune info d'entreprise n'est renseignée (évite l'id null)
                    $hasEntreprise = $array_entreprise['raison_sociale'] || $array_entreprise['nom'] || $array_entreprise['prenom'] || $array_entreprise['adresse'] || $array_entreprise['code_postale'] || $array_entreprise['commune'] || $array_entreprise['numero_siret'];
                    if($hasEntreprise){
                        if(!empty($array_entreprise['id'])){
                            $id = updateEntreprise($_SESSION[$session_key][$prefix.'_entreprise_id'],$array_entreprise);   
                            $_SESSION[$session_key][$prefix.'_entreprise_id'] = $id;                                                                                            
                        }else{
                            $id = insertEntreprise($array_entreprise);
                            $_SESSION[$session_key][$prefix.'_entreprise_id'] = $id;
                            updateEntrepriseID($id, $prefix, $doid);
                        }
                    }
                }
                }
            }elseif($currentstep == "step4bis"){
                    $errors = [];
                    $isPvStep = (($_SESSION['type_demande'] ?? 'do') === 'pv');

                    if ($isPvStep) {
                        $env = $_SESSION['info_pv_environnement'] ?? [];

                        if (empty(trim((string)($env['trav_annexes_pv_montage'] ?? '')))) {
                            $errors[] = "Le mode de pose des panneaux est obligatoire.";
                        }
                        if (($env['trav_annexes_pv_montage'] ?? '') === 'autre' && empty(trim((string)($env['trav_annexes_pv_env_mode_pose_autres'] ?? '')))) {
                            $errors[] = "Veuillez préciser le mode de pose (Autres).";
                        }
                        if (($env['trav_annexes_pv_env_souscripteur_proprietaire'] ?? '0') === '1' && empty(trim((string)($env['trav_annexes_pv_env_proprietaire_assureur_contrat'] ?? '')))) {
                            $errors[] = "Si le souscripteur est propriétaire, le nom de l'assureur et le n° de contrat sont obligatoires.";
                        }
                        if (($env['trav_annexes_pv_env_stockage_combustibles'] ?? '0') === '1' && empty(trim((string)($env['trav_annexes_pv_env_stockage_combustibles_details'] ?? '')))) {
                            $errors[] = "Veuillez décrire la nature et la quantité des matières combustibles stockées.";
                        }
                        if (($env['trav_annexes_pv_env_site_cloture'] ?? '0') === '1' && empty(trim((string)($env['trav_annexes_pv_env_site_cloture_details'] ?? '')))) {
                            $errors[] = "Veuillez préciser la nature et la hauteur de la clôture.";
                        }
                        if (($env['trav_annexes_pv_env_detection_intrusion'] ?? '0') === '1' && empty(trim((string)($env['trav_annexes_pv_env_detection_intrusion_details'] ?? '')))) {
                            $errors[] = "Veuillez décrire la détection d'intrusion et le délai d'intervention.";
                        }
                    } else {
                        // Validation des champs PHV obligatoires sur le parcours DO historique
                        if (isset($_SESSION['info_situation']['situation_phv']) && $_SESSION['info_situation']['situation_phv'] == '1') {
                            if (empty($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage'])) {
                                $errors[] = "Le système de montage des panneaux est obligatoire.";
                            }
                            if (empty($_SESSION['info_travaux_annexes']['trav_annexes_pv_surface'])) {
                                $errors[] = "La surface de l'installation est obligatoire.";
                            }
                            if (empty($_SESSION['info_travaux_annexes']['trav_annexes_pv_puissance'])) {
                                $errors[] = "La puissance de l'installation est obligatoire.";
                            }
                        }
                    }
                    if (!empty($errors)) {
                        $res = false;
                        $_SESSION['validation_errors'] = $errors;
                    } else {
                        $res = savePvEnvironnement((int)$doid, $_SESSION['info_pv_environnement'] ?? []);
                        if ($res) {
                            $_SESSION['validation_errors'] = [];
                        } elseif (empty($_SESSION['validation_errors'])) {
                            $detail = !empty($_SESSION['update_error']) ? ' (' . $_SESSION['update_error'] . ')' : '';
                            $_SESSION['validation_errors'] = ["Échec de sauvegarde de la table pv_environnement$detail"];
                        }
                    }
            }elseif($currentstep == "step4ter"){
                    $res = update($_SESSION['info_'.$_POST['fields']], $_POST['fields'], $doid );
            }else{
                $res = update($_SESSION['info_'.$_POST['fields']], $_POST['fields'], $doid );
            }

            if($res === false){
                // Only set DB error if no validation errors already set
                if (empty($_SESSION['validation_errors']) && !empty($_SESSION['update_error'])) {
                    $_SESSION['validation_errors'] = ["Erreur lors de la sauvegarde en base de données. (" . $_SESSION['update_error'] . ")"];
                } elseif (empty($_SESSION['validation_errors'])) {
                    $_SESSION['validation_errors'] = ["Erreur lors de la sauvegarde en base de données."];
                }
                unset($_SESSION['update_error']);
            }else{                
                // Détermination dynamique de l'étape suivante après step4
                if ($currentstep == 'step4' && (($_SESSION['type_demande'] ?? 'do') !== 'pv') && (!empty($_POST['page_next']) && $_POST['page_next'] !== 'step3')) {
                    $info = $_SESSION['info_situation'];
                    $has_annexe = (
                        (isset($info['situation_boi']) && $info['situation_boi'] == '1') ||
                        (isset($info['situation_phv']) && $info['situation_phv'] == '1') ||
                        (isset($info['situation_geo']) && $info['situation_geo'] == '1') ||
                        (isset($info['situation_ctt']) && $info['situation_ctt'] == '1') ||
                        (isset($info['situation_cnr']) && $info['situation_cnr'] == '1')
                    );
                    $nextstep = $has_annexe ? 'step4bis' : 'step5';
                } else if (!empty($_POST['page_next'])) {
                    $nextstep = $_POST['page_next'];
                }
                header("Location: index.php?page=".$nextstep."&doid=$doid");

            }
            
        }

        if($currentstep == 'step4bis' && (($_SESSION['type_demande'] ?? 'do') !== 'pv')){
            if($_SESSION["info_situation"]['situation_boi']=="0"
            && $_SESSION["info_situation"]['situation_phv'] =="0" 
            && $_SESSION["info_situation"]['situation_geo'] =="0" 
            && $_SESSION["info_situation"]['situation_ctt'] =="0"
            && $_SESSION["info_situation"]['situation_cnr'] =="0") {
                $doid = !empty($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : '';
                header("Location: index.php?page=step5&doid=$doid");
            }  
        }

 
        $content = ob_get_clean();
        require("views/base.view.php");
    }

