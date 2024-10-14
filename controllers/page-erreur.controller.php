<?php
    function errorDisplay(){
        $title = "Page non trouvée...";
        require 'views/header.view.php';
        require 'views/page-erreur.view.php';
        require 'views/footer.view.php';
    }
