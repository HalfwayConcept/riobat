<?php

$GLOBALS["conn"] = mysqli_connect(SERVER, USER, PASSWORD, BDD, "3306");
mysqli_set_charset($GLOBALS["conn"], "utf8mb4");
if (mysqli_connect_errno()){
    echo "Erreur de connexion à MySQL: (". mysqli_connect_errno(). ") ". mysqli_connect_error();
    exit();
}
    
    