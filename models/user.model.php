<?php
require_once 'connect.db.php';

// Vérifie les identifiants utilisateur.
// Retourne un tableau associatif contenant l'ID si OK, sinon false.
function check_login($email, $password){
    if (empty($email) || empty($password)) return false;
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $stmt = $pdo->prepare('SELECT ID, pass FROM utilisateur WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();
    if (!$user) return false;

    $stored = $user['pass'];

    // Support legacy MD5 hashes: if stored password is 32 chars, compare MD5 and rehash.
    if (strlen($stored) === 32 && md5($password) === $stored) {
        // Rehash with password_hash
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $pdo->prepare('UPDATE utilisateur SET pass = :pass WHERE ID = :id');
        $upd->execute([':pass' => $newHash, ':id' => $user['ID']]);
        return ['ID' => $user['ID']];
    }

    if (password_verify($password, $stored)) {
        return ['ID' => $user['ID']];
    }
    return false;
}

function check_email($email){
    if (empty($email)) return false;
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('SELECT ID FROM utilisateur WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $data = $stmt->fetch();
    return ($data != false);
}

function get_infos($user_id){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('SELECT ID, nom, prenom, email, siret, adresse, code_postal, commune, profession, telephone FROM utilisateur WHERE ID = :id LIMIT 1');
    $stmt->execute([':id' => $user_id]);
    $data = $stmt->fetch();
    return $data ?: false;
}

function insert_utilisateur_session($DOID, $user_id){
    if ($user_id <= 0 && $_SESSION['env'] === 'dev') {
        $user_id = 1; // Pour les tests en dev, on force à 1
    }
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('INSERT INTO utilisateur_session (utilisateur_id, DOID, session_debut, session_maj, session_fin) VALUES (:user_id, :doid, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), NULL)');
    if ($stmt->execute([':user_id' => $user_id, ':doid' => $DOID])){
        return (int)$pdo->lastInsertId();
    } else {
        return false;
    }
}

function register_user($array_post){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return 'Erreur de connexion';

    $first_name = trim($array_post['nom'] ?? '');
    $last_name = trim($array_post['prenom'] ?? '');
    $email = trim($array_post['email'] ?? '');
    $password = $array_post['password'] ?? '';
    $confirm = $array_post['confirm_password'] ?? '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        return 'Tous les champs sont requis.';
    }

    if ($password !== $confirm) {
        return 'Les 2 mots de passe ne sont pas identiques !';
    }

    if (check_email($email)) {
        return 'Cet email est déjà utilisé !';
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO utilisateur (nom, prenom, email, pass) VALUES (:nom, :prenom, :email, :pass)');
    try {
        $stmt->execute([':nom' => $first_name, ':prenom' => $last_name, ':email' => $email, ':pass' => $hash]);
        $last_id = (int)$pdo->lastInsertId();
        send_email_new_user($last_id, $first_name, $last_name, $email );
        return $last_id;
    } catch (PDOException $e) {
        if (defined('DEBUG') && DEBUG) {
            return 'Erreur lors de la création: ' . $e->getMessage();
        }
        return 'Erreur lors de la création';
    }
}

function send_email_new_user($last_id, $first_name, $last_name, $email ){
    $to = "christophe_leydier@hotmail.com";
    $subject = "[RIOBAT] Nouvel utilisateur";

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

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <contact@riobat.ruki5964.odns.fr>' . "\r\n";

    mail($to,$subject,$message,$headers);
}

function update_user_profile($user_id, $array_post){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $first_name = trim($array_post['nom'] ?? '');
    $last_name = trim($array_post['prenom'] ?? '');
    $email = trim($array_post['email'] ?? '');
    $siret = trim($array_post['siret'] ?? '');
    $adresse = trim($array_post['adresse'] ?? '');
    $code_postal = trim($array_post['code_postal'] ?? '');
    $commune = trim($array_post['commune'] ?? '');
    $profession = trim($array_post['profession'] ?? '');
    $telephone = trim($array_post['telephone'] ?? '');

    if (empty($first_name) || empty($last_name) || empty($email)) {
        return 'Nom, prénom et email sont requis.';
    }

    $stmt = $pdo->prepare('UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, siret = :siret, adresse = :adresse, code_postal = :code_postal, commune = :commune, profession = :profession, telephone = :telephone WHERE ID = :id');
    try {
        $stmt->execute([
            ':nom' => $first_name,
            ':prenom' => $last_name,
            ':email' => $email,
            ':siret' => $siret,
            ':adresse' => $adresse,
            ':code_postal' => $code_postal,
            ':commune' => $commune,
            ':profession' => $profession,
            ':telephone' => $telephone,
            ':id' => $user_id,
        ]);
        return true;
    } catch (PDOException $e) {
        if (defined('DEBUG') && DEBUG) {
            return 'Erreur lors de la mise à jour: ' . $e->getMessage();
        }
        return false;
    }
} 