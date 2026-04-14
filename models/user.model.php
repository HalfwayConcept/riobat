<?php
require_once __DIR__ . '/connect.db.php';
// ...existing code...

// Vérifie les identifiants utilisateur.
// Retourne un tableau associatif contenant l'ID si OK, sinon false.
function check_login($email, $password){
    if (empty($email) || empty($password)) return false;
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $stmt = $pdo->prepare('SELECT ID, pass, role FROM utilisateur WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    // Log requête login
    require_once __DIR__ . '/../controllers/LogController.php';
    $user_id = null;
    logQuery(null, 'utilisateur', $stmt->queryString, [':email' => $email], $user_id, 'réussi');
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) return false;

    $stored = $user['pass'];

    if (password_verify($password, $stored)) {
        return ['ID' => $user['ID'], 'role' => $user['role']];
    }
    return false;
}

function check_email($email){
    if (empty($email)) return false;
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('SELECT ID FROM utilisateur WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
        // Log requête check email
        require_once __DIR__ . '/../controllers/LogController.php';
        logQuery(null, 'utilisateur', $stmt->queryString, [':email' => $email], null, 'réussi');
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return ($data != false);
}

function get_infos($user_id){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('SELECT ID, nom, prenom, email, role, siret, adresse, code_postal, commune, profession, telephone FROM utilisateur WHERE ID = :id LIMIT 1');
    $stmt->execute([':id' => $user_id]);
        // Log requête infos user
        require_once __DIR__ . '/../controllers/LogController.php';
        logQuery($user_id, 'utilisateur', $stmt->queryString, [':id' => $user_id], $user_id, 'réussi');
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
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
            // Log requête insert session
            require_once __DIR__ . '/../controllers/LogController.php';
            logQuery($DOID, 'utilisateur_session', $stmt->queryString, [':user_id' => $user_id, ':doid' => $DOID], $user_id, 'réussi');
        return (int)$pdo->lastInsertId();
    } else {
        return false;
    }
}

function userOwnsDo($user_id, $doid) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('SELECT 1 FROM utilisateur_session WHERE utilisateur_id = :uid AND DOID = :doid LIMIT 1');
    $stmt->execute([':uid' => (int)$user_id, ':doid' => (int)$doid]);
    return (bool)$stmt->fetch();
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
            // Log requête register
            require_once __DIR__ . '/../controllers/LogController.php';
            logQuery(null, 'utilisateur', $stmt->queryString, [':nom' => $first_name, ':prenom' => $last_name, ':email' => $email, ':pass' => $hash], null, 'réussi');
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
    $to = "contact@riobat.cc-assur.fr";
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
    $headers .= 'From: <contact@riobat.cc-assur.fr>' . "\r\n";

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
            // Log requête update profil
            require_once __DIR__ . '/../controllers/LogController.php';
            logQuery($user_id, 'utilisateur', $stmt->queryString, [
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
            ], $user_id, 'réussi');
        return true;
    } catch (PDOException $e) {
        if (defined('DEBUG') && DEBUG) {
            return 'Erreur lors de la mise à jour: ' . $e->getMessage();
        }
        return false;
    }
}

// ============ Fonctions admin : gestion utilisateurs ============

function getAllUsers(){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return [];
    $stmt = $pdo->query('SELECT ID, nom, prenom, email, role, utilisateur_date_creation FROM utilisateur ORDER BY ID ASC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adminCreateUser($nom, $prenom, $email, $password, $role = 'user'){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return 'Erreur de connexion';

    if (check_email($email)) {
        return 'Cet email est déjà utilisé.';
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO utilisateur (nom, prenom, email, pass, role) VALUES (:nom, :prenom, :email, :pass, :role)');
    try {
        $stmt->execute([':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':pass' => $hash, ':role' => $role]);
        return (int)$pdo->lastInsertId();
    } catch (PDOException $e) {
        return 'Erreur : ' . $e->getMessage();
    }
}

function adminUpdateUser($user_id, $nom, $prenom, $email, $role){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $stmt = $pdo->prepare('UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, role = :role WHERE ID = :id');
    return $stmt->execute([':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':role' => $role, ':id' => $user_id]);
}

function adminResetPassword($user_id, $new_password){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('UPDATE utilisateur SET pass = :pass WHERE ID = :id');
    return $stmt->execute([':pass' => $hash, ':id' => $user_id]);
}

function adminDeleteUser($user_id){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $stmt = $pdo->prepare('DELETE FROM utilisateur WHERE ID = :id');
    return $stmt->execute([':id' => $user_id]);
}

function truncateFormTables(){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    $tables = ['do_historique', 'utilisateur_session', 'rcd', 'rcd_upload_token', 'log', 'travaux_annexes', 'situation', 'operation_construction', 'moa', 'dommage_ouvrage', 'entreprise', 'souscripteur'];
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    foreach ($tables as $t) {
        $pdo->exec('TRUNCATE TABLE `' . $t . '`');
    }
    $pdo->exec('ALTER TABLE `dommage_ouvrage` AUTO_INCREMENT = 1');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    return true;
}