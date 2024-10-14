<?php
    require_once 'connect.db.php';


    //lecture des données contenues dans la base
    function check_login($email, $password){
        $password = htmlspecialchars($password);  
        $passwordmd5 = MD5($password);
        $sql = "SELECT ID FROM `utilisateur` where `email` ='$email' and `pass`='$passwordmd5';";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

    //lecture des données contenues dans la base
    function check_email($email){
        $sql = "SELECT ID FROM `utilisateur` where `email` ='$email';";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
        if($DATA==null){
            return false;
        }else{
            return true;
        }
    }

    //Nom de l'utilisateur connecté
    function get_infos($user_id){
        $sql = "SELECT ID,nom,prenom,email FROM `utilisateur` where `id` ='$user_id';";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
        if($DATA==null){
            return false;
        }else{
            return $DATA;
        }
    }    



    function register_user($array_post){
        // Escape user inputs for security
        $first_name = mysqli_real_escape_string($GLOBALS["conn"], $array_post['nom']);
        $last_name = mysqli_real_escape_string($GLOBALS["conn"], $array_post['prenom']);
        $email = mysqli_real_escape_string($GLOBALS["conn"], $array_post['email']);
        $password = mysqli_real_escape_string($GLOBALS["conn"], $array_post['password']);
        if(check_email($email) == false){
            if($array_post['password']!=$array_post['confirm_password']){
                return 'Les 2 mots de passes ne sont pas identiques !';
            }else{
                $sql = " INSERT INTO `utilisateur` (`ID`, `nom`,`prenom`, `email`, `pass`) VALUES (NULL,'$first_name', '$last_name', '$email', MD5('$password'));";
                if(mysqli_query($GLOBALS["conn"], $sql)){
                    $last_id = mysqli_insert_id($GLOBALS["conn"]);
                    send_email_new_user($last_id, $first_name, $last_name, $email );

                    return $last_id;
                } else{
                    return "Erreur lors de la création " . mysqli_error($link);
                }
            }
        }else{
            $rtn =  "Cet email est déjà utilisé !";
            //$rtn .= "<br /><a href='index.php?page=passwordReminder'> 👉 <u>Rappel de mot de passe</u></a>";
            return $rtn;
        }

    }    


    function send_email_new_user($last_id, $first_name, $last_name, $email ){
            $to = "c.leydier@velay.greta.fr";
            $subject = "[diagnosticompetences] Nouvel utilisateur";

            $message = "
            <html>
            <head>
            <title>Nouvel utilisateur</title>
            </head>
            <body>
            <p>Un nouvel utilisateur vient de s'inscrire!</p>
            <table>
            <tr>
                <th>ID</th>
                <th>Prenom</th>
                <th>NOM</th>
                <th>email</th>
            </tr>
            <tr>
                <td>$last_id</td>
                <td>$first_name</td>
                <td>$last_name</td>
                <td>$email</td>
            </tr>
            </table>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <contact@diagnosticompetences.net>' . "\r\n";
            $headers .= 'Cc: christophe.leydier@greta-auvergne.fr' . "\r\n";

            mail($to,$subject,$message,$headers);
    }


