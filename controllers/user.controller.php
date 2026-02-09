<?php

require_once 'models/user.model.php';
require_once 'models/do.model.php';


function login(){  
    ob_start();
    $title = "Login";
    $check = null;
    if(!empty($_POST)){
        $check = check_login($_POST['email'], $_POST['password']);
        if($check == null){
            $erreur = "Login/Mot de passe incorrect";
        }
    }
    if($check == null){
        require('views/templates/user/login.view.php');
    }else{        
        $_SESSION['user_id'] = $check['ID'];

        if($_SESSION['user_id'] == 1 ){
            header("Location: index.php?page=admin");        
        }else{
            header("Location: index.php?page=home");        
        }
    }

    $content = ob_get_clean();
    require("views/base.view.php");
}


function logout(){ 
    session_destroy();
    header("Location: index.php?page=home"); 
}

function passwordReminder($message =""){
    $php_SSID = session_id();
    $erreur = null;
    ob_start();
    $title = "Oubli de mot de passe";
    require('views/templates/user/password-reminder.view.php'); 
    $content = ob_get_clean();
    require("views/base.view.php");              
}

function stepRegister($message =""){
    $php_SSID = session_id();
    $erreur = null;
    ob_start();
    $title = "Création de compte";
    if(!empty($_POST)){
        $array_post = $_POST;
        $new_user = register_user($array_post);
        if(is_numeric($new_user) ){
            header("Location: index.php?page=login&new_user=".$new_user);
        }else{
            $message = $new_user;
        }
    }

    require('views/templates/user/register.view.php'); 
    $content = ob_get_clean();
    require("views/base.view.php");              
}

function displayProfil(){  
    ob_start();
    $title = "Mon profil";
    $message = "";
    $profil = get_infos($_SESSION['user_id']);
    
    // Traiter la mise à jour du profil
    if (!empty($_POST)) {
        require_once 'models/user.model.php';
        $result = update_user_profile($_SESSION['user_id'], $_POST);
        if ($result === true) {
            $message = "Profil mis à jour avec succès !";
            $profil = get_infos($_SESSION['user_id']); // Recharger les infos
        } else {
            $message = $result; // Afficher le message d'erreur
        }
    }
    
    require('views/templates/user/profil.view.php');
    $content = ob_get_clean();
    require("views/base.view.php");
}

function displayDashboard(){  
    ob_start();
    $title = "Dashboard";
    $dos = getListDo($_SESSION['user_id']);
    require('views/templates/user/dashboard.view.php');

    $content = ob_get_clean();
    require("views/base.view.php");
}