<?php
    session_start();

    //session_destroy();
    $_SESSION['env'] = 'prod'; //prod

    include_once("inc/settings.php");
    require 'controllers/page-erreur.controller.php';
    require 'controllers/user.controller.php';
    if(empty($_SESSION['user_id'])){
        $_SESSION['user_id']=null;
    }
    // Vide la superglobale $_SESSION
    // $_SESSION = [];
    if (isset($_GET['page'])){
        $currentstep = $_GET['page'];
        $_SESSION['action'] = $currentstep;
        switch($_GET['page']){
            case 'home':
                require 'controllers/home.controller.php';
                homeDisplay($currentstep);
                break;
            case 'step0':
                require 'controllers/do.controller.php'; 
                clearSessionDO();
                stepDisplay($currentstep);
                break;
            case 'step1':
            case 'step2':
            case 'step3':
            case 'step4':
            case 'step4bis':
            case 'step5':   
                require 'controllers/do.controller.php';    
                stepDisplay($currentstep);
                break;               
            case 'validation':
                require 'controllers/validation.controller.php';
                validDisplay($currentstep);
                break;
            case 'rcd':
                require 'controllers/rcd.controller.php';
                rcdDisplay($currentstep);
                break;                 
            case 'admin':
                require 'controllers/admin.controller.php';
                adminDisplay();
                break; 
            case 'fiche':
                require 'controllers/admin.controller.php';
                singleDoDisplay();
                break;  
            case 'edit':
                require 'controllers/admin.controller.php';
                editDo($_GET['doid']);
                break;  
                

            /* USER Action */
            case 'login':
                login();
                break; 
            case 'logout':
                logout();
                break;                 
            case 'register':
                stepRegister();
                break;                 
            case 'passwordReminder':
                passwordReminder();
                break;                     
            case 'dashboard':
                if(empty($_SESSION['user_id'])){
                    login();
                }else{
                    displayDashboard();
                }                
                break;    
            case 'profil':
                displayProfil();
                break; 

            default:
                throw new Exception ('Paramètre invalide !');
                break;
        }
    }else{
        errorDisplay();
    }

?>