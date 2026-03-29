<?php
require_once __DIR__ . '/connect.db.php';
// ...existing code...

function getDo($doid){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) {
        $sql = "SELECT dommage_ouvrage.*, souscripteur.*, moa.*, operation_construction.*, situation.*, travaux_annexes.*
                FROM dommage_ouvrage
                JOIN souscripteur ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
                JOIN moa ON moa.DOID = dommage_ouvrage.DOID
                JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID
                JOIN travaux_annexes ON travaux_annexes.DOID = dommage_ouvrage.DOID
                JOIN situation ON situation.DOID = dommage_ouvrage.DOID
                WHERE dommage_ouvrage.DOID = $doid;";
        $resquery = mysqli_query($GLOBALS['conn'], $sql);
        $DATA = mysqli_fetch_array($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

    $sql = "SELECT dommage_ouvrage.*, souscripteur.*, moa.*, operation_construction.*, situation.*, travaux_annexes.*,
                   IF(moa.moa_souscripteur_id IS NULL, 1, 0) AS moa_souscripteur,
                   moa_sub.souscripteur_id AS moa_sub_souscripteur_id,
                   moa_sub.souscripteur_form_civilite AS moa_sub_civilite,
                   moa_sub.souscripteur_nom_raison AS moa_sub_nom_raison,
                   moa_sub.souscripteur_siret AS moa_sub_siret,
                   moa_sub.souscripteur_adresse AS moa_sub_adresse,
                   moa_sub.souscripteur_code_postal AS moa_sub_code_postal,
                   moa_sub.souscripteur_commune AS moa_sub_commune,
                   moa_sub.souscripteur_telephone AS moa_sub_telephone,
                   moa_sub.souscripteur_email AS moa_sub_email
            FROM dommage_ouvrage
            JOIN souscripteur ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
            JOIN moa ON moa.DOID = dommage_ouvrage.DOID
            LEFT JOIN souscripteur moa_sub ON moa_sub.souscripteur_id = moa.moa_souscripteur_id
            JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID
            JOIN travaux_annexes ON travaux_annexes.DOID = dommage_ouvrage.DOID
            JOIN situation ON situation.DOID = dommage_ouvrage.DOID
            WHERE dommage_ouvrage.DOID = :doid
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':doid' => $doid]);
        // Log requête
        require_once __DIR__ . '/../controllers/LogController.php';
        $user_id = $_SESSION['user_id'] ?? null;
        logQuery($doid, 'dommage_ouvrage', $stmt->queryString, [':doid' => $doid], $user_id, 'réussi');
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getListDo($user_id = null){
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) {
        $sql = "SELECT dommage_ouvrage.*, operation_construction.*, situation.*, souscripteur.*, moa.*, travaux_annexes.*, utilisateur_session.*
                FROM souscripteur
                JOIN dommage_ouvrage ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
                JOIN moa ON moa.DOID = dommage_ouvrage.DOID
                JOIN utilisateur_session ON utilisateur_session.DOID = dommage_ouvrage.DOID
                JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID
                JOIN travaux_annexes ON travaux_annexes.DOID = dommage_ouvrage.DOID
                JOIN situation ON situation.DOID = dommage_ouvrage.DOID";
        if($user_id != null){
            $sql .= " WHERE utilisateur_session.utilisateur_id = $user_id";
        }
        $resquery = mysqli_query($GLOBALS['conn'], $sql);
        $DATA = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $DATA;
    }

    $sql = "SELECT dommage_ouvrage.*, operation_construction.*, situation.*, souscripteur.*, moa.*, travaux_annexes.*, utilisateur_session.*,
                   assurance.nom AS assurance_nom, assurance.logo AS assurance_logo,
                   IF(moa.moa_souscripteur_id IS NULL, 1, 0) AS moa_souscripteur,
                   moa_sub.souscripteur_id AS moa_sub_souscripteur_id,
                   moa_sub.souscripteur_form_civilite AS moa_sub_civilite,
                   moa_sub.souscripteur_nom_raison AS moa_sub_nom_raison,
                   moa_sub.souscripteur_siret AS moa_sub_siret,
                   moa_sub.souscripteur_adresse AS moa_sub_adresse
            FROM souscripteur
            JOIN dommage_ouvrage ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
            JOIN moa ON moa.DOID = dommage_ouvrage.DOID
            LEFT JOIN souscripteur moa_sub ON moa_sub.souscripteur_id = moa.moa_souscripteur_id
            JOIN utilisateur_session ON utilisateur_session.DOID = dommage_ouvrage.DOID
            JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID
            JOIN travaux_annexes ON travaux_annexes.DOID = dommage_ouvrage.DOID
            JOIN situation ON situation.DOID = dommage_ouvrage.DOID
            LEFT JOIN assurance ON assurance.assurance_id = dommage_ouvrage.assurance_id";
    $params = [];
    if($user_id != null){
        $sql .= " WHERE utilisateur_session.utilisateur_id = :user_id";
        $params[':user_id'] = $user_id;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
        // Log requête
        require_once __DIR__ . '/../controllers/LogController.php';
        $uid = $_SESSION['user_id'] ?? null;
        logQuery(null, 'dommage_ouvrage', $stmt->queryString, $params, $uid, 'réussi');
    return $stmt->fetchAll();
}

function insert($array_SESSION){
    $pdo = $GLOBALS['pdo'] ?? null;
    $DOID = false;
    $souscripteur_id = false;
    if (strlen($array_SESSION["souscripteur_nom_raison"]) > 0 ){
        // insertion des données du souscripteur
        $s = $array_SESSION; // shorthand
        if ($pdo) {
            try {
                $pdo->beginTransaction();
                $sql = "INSERT INTO souscripteur (souscripteur_nom_raison, souscripteur_siret, souscripteur_adresse, souscripteur_code_postal, souscripteur_commune, souscripteur_profession, souscripteur_telephone, souscripteur_email, souscripteur_ancien_client_date, souscripteur_ancien_client_num)
                        VALUES (:nom, :siret, :adresse, :cp, :commune, :profession, :telephone, :email, :ancien_date, :ancien_num)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nom' =>           $s['souscripteur_nom_raison'] ?? null,
                    ':siret' =>         !empty($s['souscripteur_siret']) ? $s['souscripteur_siret'] : null,
                    ':adresse' =>       !empty($s['souscripteur_adresse']) ? $s['souscripteur_adresse'] : null,
                    ':cp' =>            !empty($s['souscripteur_code_postal']) ? $s['souscripteur_code_postal'] : null,
                    ':commune' =>       !empty($s['souscripteur_commune']) ? $s['souscripteur_commune'] : null,
                    ':profession' =>    !empty($s['souscripteur_profession']) ? $s['souscripteur_profession'] : null,
                    ':telephone' =>     !empty($s['souscripteur_telephone']) ? $s['souscripteur_telephone'] : null,
                    ':email' =>         !empty($s['souscripteur_email']) ? $s['souscripteur_email'] : null,
                    ':ancien_date' =>   !empty($s['souscripteur_ancien_client_date']) ? $s['souscripteur_ancien_client_date'] : null,
                    ':ancien_num' =>    !empty($s['souscripteur_ancien_client_num']) ? $s['souscripteur_ancien_client_num'] : null,
                ]);
                // Log requête souscripteur
                require_once __DIR__ . '/../controllers/LogController.php';
                $uid = $_SESSION['user_id'] ?? null;

                $souscripteur_id = (int)$pdo->lastInsertId();
                
                logQuery(null, 'souscripteur', $stmt->queryString, [':nom' => $s['souscripteur_nom_raison'] ?? null], $uid, 'réussi');


                $sql_do = "INSERT INTO dommage_ouvrage (souscripteur_id,repertoire) VALUES (:souscripteur_id, LEFT(MD5(RAND()), 12))";
                $stmt = $pdo->prepare($sql_do);
                $stmt->execute([':souscripteur_id' => $souscripteur_id]);
                    // Log requête dommage_ouvrage
                

                $DOID = (int)$pdo->lastInsertId();


                logQuery($DOID, 'dommage_ouvrage', $stmt->queryString, [':souscripteur_id' => $souscripteur_id], $uid, 'réussi');
                $tables = ['moa','operation_construction','situation','travaux_annexes'];
                foreach ($tables as $t) {
                    $stmt = $pdo->prepare("INSERT INTO $t (DOID) VALUES (:doid)");
                    $stmt->execute([':doid' => $DOID]);
                        // Log requête pour chaque table
                        logQuery($DOID, $t, $stmt->queryString, [':doid' => $DOID], $uid, 'réussi');
                }

                $pdo->commit();
            } catch (PDOException $e) {
                if ($pdo->inTransaction()) $pdo->rollBack();
                if (defined('DEBUG') && DEBUG) {
                    throw $e;
                }
                return false;
            }
        } else {
            // mysqli fallback (legacy)
            extract($array_SESSION);
            $sql = "INSERT INTO souscripteur (souscripteur_nom_raison, souscripteur_siret, souscripteur_adresse, souscripteur_code_postal, souscripteur_commune, souscripteur_profession, souscripteur_telephone, souscripteur_email, souscripteur_ancien_client_date, souscripteur_ancien_client_num) 
            VALUES ('$souscripteur_nom_raison', '$souscripteur_siret', '$souscripteur_adresse', '$souscripteur_code_postal', '$souscripteur_commune', '$souscripteur_profession', '$souscripteur_telephone', '$souscripteur_email', '$souscripteur_ancien_client_date', '$souscripteur_ancien_client_num');";
            $_SESSION["SQL"]["souscripteur"] = $sql;
            $query = mysqli_query($GLOBALS["conn"], $sql);

            $souscripteur_id = mysqli_insert_id($GLOBALS["conn"]);
            $sql_do = "INSERT INTO dommage_ouvrage (souscripteur_id,repertoire) VALUES ('$souscripteur_id',LEFT(MD5(RAND()), 12) );";
            $_SESSION["SQL"]["do"] = $sql_do;
            $query = mysqli_query($GLOBALS["conn"], $sql_do);

            $DOID = mysqli_insert_id($GLOBALS["conn"]);

            $sql_moa = "INSERT INTO moa (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["moa"] = $sql_moa;
            $query = mysqli_query($GLOBALS["conn"], $sql_moa);

            $sql_ope = "INSERT INTO operation_construction (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["ope"] = $sql_ope;
            $query = mysqli_query($GLOBALS["conn"], $sql_ope);

            $sql_situation = "INSERT INTO situation (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["situation"] = $sql_situation;
            $query = mysqli_query($GLOBALS["conn"], $sql_situation);

            $sql_travaux = "INSERT INTO travaux_annexes (DOID) VALUES ('$DOID');";
            $_SESSION["SQL"]["travaux"] = $sql_travaux;
            $query = mysqli_query($GLOBALS["conn"], $sql_travaux);
        }
    }
    return $DOID;
}

function update($array_SESSION, $table, $DOID){
    $allowed_tables = ['souscripteur', 'operation_construction', 'situation', 'travaux_annexes', 'moa', 'dommage_ouvrage'];
    if (!in_array($table, $allowed_tables)) {
        return false; // prevent SQL injection via table name
    }

    $pdo = $GLOBALS['pdo'] ?? null;
    $fields = [];
    $params = [];

    // Validate session keys against actual DB columns to prevent "Unknown column" errors
    $valid_columns = getColumnNames($table);

    foreach ($array_SESSION as $field => $value) {
        if($field != "fields" &&  $field != "page_next"
            && $field != "DOID"
            && !str_starts_with($field, "moa_conception")
            && !str_starts_with($field, "moa_direction")
            && !str_starts_with($field, "moa_surveillance")
            && !str_starts_with($field, "moa_execution")
            && in_array($field, $valid_columns)
        ){
            $fields[] = "$field = :$field";
            $params[":$field"] = ($value === '' ? null : $value);
        }
    }

    if (count($fields) === 0) return false;

    $sqlupdate = "UPDATE $table SET " . implode(', ', $fields) . " WHERE $table.DOID = :doid";
    $params[':doid'] = $DOID;

    if ($pdo) {
        try {
            $stmt = $pdo->prepare($sqlupdate);
            $res = $stmt->execute($params);
                // Log requête update
                require_once __DIR__ . '/../controllers/LogController.php';
                $uid = $_SESSION['user_id'] ?? null;
                logQuery($DOID, $table, $stmt->queryString, $params, $uid, $res ? 'réussi' : 'échec');
            $_SESSION["SQL"][$table] = debugQuery($sqlupdate, array_values($params));
            return $res;
        } catch (PDOException $e) {
            error_log("[riobat] UPDATE $table DOID=$DOID failed: " . $e->getMessage());
            $_SESSION['update_error'] = $e->getMessage();
            if (defined('DEBUG') && DEBUG) {
                throw $e;
            }
            return false;
        }
    } else {
        // mysqli fallback (less secure)
        $array_values = array_values($params);
        $sqlupdate_mysqli = $sqlupdate; // parameters already interpolated below
        // naive interpolation for debug only
        $_SESSION["SQL"][$table] = debugQuery($sqlupdate_mysqli, $array_values);
        // attempt to prepare using mysqli (not binding named params)

        
        $res = false;
        if ($stmt = mysqli_prepare($GLOBALS['conn'], $sqlupdate_mysqli)) {
            $res = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        return $res;
    }
}

function debugQuery($query, $params = array()){
    foreach ($params as $param) {
        $query = preg_replace('/\?/', "'" . $param . "'", $query, 1);
    }
    return $query;
}

// changement du format de la date
function dateFormat($date){
    if (empty($date)) return '';
    $ts = strtotime($date);
    if ($ts === false) return '';
    return date('d-m-Y', $ts);
}

// Affichage des intitulés des radio et checkbox
function boxDisplay($checked, $name, $mode = "write"){

    if($mode == "write"){
        if($checked == 1){
            $display = 'checked="checked"';
        }else{
            $display = "";
        }
        $str_checkbox = "<input type='checkbox' $display name='$name' value='1' ";

    }elseif($mode == "read"){
        if($checked == 1){
             $str_checkbox = "<svg class='w-6 h-6 me-2 text-green-500 dark:text-green-400 shrink-0' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 20 20'>
                                <path d='M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z'/>
                            </svg> "; 
        }else{
             $str_checkbox = "<svg class='w-6 h-6 text-red-800 dark:text-red' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>
                                <path stroke='currentColor' stroke-linecap='round' stroke-width='2' d='m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'/>
                            </svg> ";
        }
    }
    return $str_checkbox;
};


function deleteAllTestDos() {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return 0;

    // Récupérer tous les DOID de test
    $stmt = $pdo->query('SELECT DOID FROM dommage_ouvrage WHERE is_test = 1');
    $doids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    if (empty($doids)) return 0;

    $count = 0;
    foreach ($doids as $doid) {
        try {
            $pdo->beginTransaction();
            // Récupérer les IDs d'entreprises liées
            $entStmt = $pdo->prepare('SELECT boi_entreprise_id, phv_entreprise_id, geo_entreprise_id, ctt_entreprise_id, cnr_entreprise_id FROM travaux_annexes WHERE DOID = :d');
            $entStmt->execute([':d' => $doid]);
            $entRow = $entStmt->fetch(PDO::FETCH_ASSOC);
            $solStmt = $pdo->prepare('SELECT sol_entreprise_id FROM situation WHERE DOID = :d');
            $solStmt->execute([':d' => $doid]);
            $solRow = $solStmt->fetch(PDO::FETCH_ASSOC);
            $moeStmt = $pdo->prepare('SELECT moe_entreprise_id FROM dommage_ouvrage WHERE DOID = :d');
            $moeStmt->execute([':d' => $doid]);
            $moeRow = $moeStmt->fetch(PDO::FETCH_ASSOC);
            $moaStmt = $pdo->prepare('SELECT moa_souscripteur_id, moa_entreprise_id FROM moa WHERE DOID = :d');
            $moaStmt->execute([':d' => $doid]);
            $moaRow = $moaStmt->fetch(PDO::FETCH_ASSOC);

            foreach (['do_historique', 'utilisateur_session', 'rcd', 'travaux_annexes', 'situation', 'operation_construction', 'moa'] as $t) {
                $pdo->prepare("DELETE FROM $t WHERE DOID = :d")->execute([':d' => $doid]);
            }
            $sStmt = $pdo->prepare('SELECT souscripteur_id FROM dommage_ouvrage WHERE DOID = :d');
            $sStmt->execute([':d' => $doid]);
            $sid = $sStmt->fetchColumn();
            $pdo->prepare('DELETE FROM dommage_ouvrage WHERE DOID = :d')->execute([':d' => $doid]);
            if ($sid) {
                $pdo->prepare('DELETE FROM souscripteur WHERE souscripteur_id = :s')->execute([':s' => $sid]);
            }
            // Supprimer les entreprises liées
            $entIds = [];
            if ($entRow) { foreach ($entRow as $eid) { if ($eid) $entIds[] = (int)$eid; } }
            if ($solRow && !empty($solRow['sol_entreprise_id'])) $entIds[] = (int)$solRow['sol_entreprise_id'];
            if ($moeRow && !empty($moeRow['moe_entreprise_id'])) $entIds[] = (int)$moeRow['moe_entreprise_id'];
            if ($moaRow && !empty($moaRow['moa_entreprise_id'])) $entIds[] = (int)$moaRow['moa_entreprise_id'];
            foreach (array_unique($entIds) as $eid) {
                $pdo->prepare('DELETE FROM entreprise WHERE ID = :id')->execute([':id' => $eid]);
            }
            // Supprimer le souscripteur MOA lié
            if ($moaRow && !empty($moaRow['moa_souscripteur_id'])) {
                $pdo->prepare('DELETE FROM souscripteur WHERE souscripteur_id = :s')->execute([':s' => (int)$moaRow['moa_souscripteur_id']]);
            }
            $pdo->commit();
            $count++;
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
        }
    }
    return $count;
}

function deleteDo($doid){
    $pdo = $GLOBALS['pdo'] ?? null;
    try {
        $pdo->beginTransaction();
        $tables = ['dommage_ouvrage','moa','operation_construction','situation','travaux_annexes'];
        foreach ($tables as $t) {
            $stmt = $pdo->prepare("DELETE FROM $t WHERE DOID = :doid");
            $stmt->execute([':doid' => $doid]);
        }
        $pdo->commit();
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        if (defined('DEBUG') && DEBUG) throw $e;
        return false;
    }
    header( "Location: index.php?page=admin" );
    return true;
}

function validDo($doid){
    $pdo = $GLOBALS['pdo'] ?? null;
    $stmt = $pdo->prepare('UPDATE dommage_ouvrage SET status = 1 WHERE DOID = :doid');
    $stmt->execute([':doid' => $doid]);
    return true;
}


function loadDo($doid){
    // Préserver les données d'authentification
    $preserve = [
        'user_id'   => $_SESSION['user_id'] ?? null,
        'user_role' => $_SESSION['user_role'] ?? null,
        'env'       => $_SESSION['env'] ?? null,
        'action'    => $_SESSION['action'] ?? null,
    ];
    $_SESSION = $preserve;

    $_SESSION['DOID']       = $doid;
    $do = getDo($doid);

    $_SESSION["info_souscripteur"]["souscripteur_id"] = $do["souscripteur_id"];

    $array_tables = array('souscripteur', 'operation_construction', 'situation', 'travaux_annexes', 'moa','dommage_ouvrage');
    foreach ($array_tables as $table) {
        $col_names =  getColumnNames($table);
        foreach ($col_names as $key => $col) {
            if ($col === 'DOID') continue; // DOID is managed separately, skip to avoid polluting UPDATE queries
            $_SESSION["info_".$table][$col] = $do[$col] ?? null;                    
        }
    }

    // Dériver moa_souscripteur (booléen) depuis moa_souscripteur_id
    // (la colonne moa_souscripteur a été supprimée, on la recalcule pour la session)
    $_SESSION['info_moa']['moa_souscripteur'] = empty($do['moa_souscripteur_id']) ? 1 : 0;

    // Charger les données du souscripteur MOA (si MOA ≠ souscripteur)
    // et restaurer les clés de session compatibles avec le formulaire step2
    if (!empty($do['moa_souscripteur_id'])) {
        $_SESSION['info_moa_souscripteur'] = [
            'souscripteur_form_civilite' => $do['moa_sub_civilite'] ?? null,
            'souscripteur_nom_raison'    => $do['moa_sub_nom_raison'] ?? null,
            'souscripteur_siret'         => $do['moa_sub_siret'] ?? null,
            'souscripteur_adresse'       => $do['moa_sub_adresse'] ?? null,
            'souscripteur_code_postal'   => $do['moa_sub_code_postal'] ?? null,
            'souscripteur_commune'       => $do['moa_sub_commune'] ?? null,
            'souscripteur_telephone'     => $do['moa_sub_telephone'] ?? null,
            'souscripteur_email'         => $do['moa_sub_email'] ?? null,
        ];

        // Restaurer les clés formulaire dans info_moa pour le template step2
        $civilite = $do['moa_sub_civilite'] ?? null;
        $_SESSION['info_moa']['moa_souscripteur_form_civilite'] = $civilite;
        $_SESSION['info_moa']['moa_souscripteur_form_adresse'] = $do['moa_sub_adresse'] ?? null;
        $_SESSION['info_moa']['moa_souscripteur_form_code_postal'] = $do['moa_sub_code_postal'] ?? null;
        $_SESSION['info_moa']['moa_souscripteur_form_commune'] = $do['moa_sub_commune'] ?? null;
        $_SESSION['info_moa']['moa_souscripteur_form_siret'] = $do['moa_sub_siret'] ?? null;

        // Raison sociale : depuis souscripteur_nom_raison si entreprise
        $_SESSION['info_moa']['moa_souscripteur_form_raison_sociale'] = ($civilite === 'entreprise') ? ($do['moa_sub_nom_raison'] ?? null) : null;

        // Nom et prénom toujours stockés dans la table entreprise
        if (!empty($_SESSION['info_moa']['moa_entreprise_id'])) {
            require_once __DIR__ . '/entreprise.model.php';
            $moa_ent = loadEntreprise($_SESSION['info_moa']['moa_entreprise_id']);
            $_SESSION['info_moa']['moa_souscripteur_form_nom'] = $moa_ent['nom'] ?? '';
            $_SESSION['info_moa']['moa_souscripteur_form_prenom'] = $moa_ent['prenom'] ?? '';
        } else {
            $_SESSION['info_moa']['moa_souscripteur_form_nom'] = '';
            $_SESSION['info_moa']['moa_souscripteur_form_prenom'] = '';
        }
    } else {
        $_SESSION['info_moa_souscripteur'] = [];
    }
}

// Ajoute une entrée dans l'historique d'un dommage ouvrage
function addDoHistorique($doid, $action, $user_id = null, $details = null) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || !$doid) return false;

    $user_nom = null;
    if ($user_id) {
        $stmt = $pdo->prepare('SELECT CONCAT(prenom, " ", nom) AS fullname FROM utilisateur WHERE ID = :id LIMIT 1');
        $stmt->execute([':id' => $user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) $user_nom = $row['fullname'];
    }

    $stmt = $pdo->prepare('INSERT INTO do_historique (DOID, action, user_id, user_nom, date_action, details) VALUES (:doid, :action, :user_id, :user_nom, NOW(), :details)');
    return $stmt->execute([
        ':doid' => $doid,
        ':action' => $action,
        ':user_id' => $user_id,
        ':user_nom' => $user_nom,
        ':details' => $details,
    ]);
}

// Récupère l'historique d'un dommage ouvrage
function getDoHistorique($doid) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return [];

    $stmt = $pdo->prepare('SELECT * FROM do_historique WHERE DOID = :doid ORDER BY date_action ASC');
    $stmt->execute([':doid' => $doid]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
* Get the column names for a mysql table
**/
function getColumnNames($table) {
    $allowed_tables = ['souscripteur', 'operation_construction', 'situation', 'travaux_annexes', 'moa', 'dommage_ouvrage'];
    if (!in_array($table, $allowed_tables)) return [];

    $pdo = $GLOBALS['pdo'] ?? null;
    $sql = 'DESCRIBE ' . $table;
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $rows;
}

function getListAssurances() {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return [];
    $stmt = $pdo->query('SELECT * FROM assurance WHERE active = 1 ORDER BY nom ASC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateDoStatus($doid, $status) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $allowed = [0, 1, 2, 3];
    if (!in_array((int)$status, $allowed, true)) return false;
    $stmt = $pdo->prepare('UPDATE dommage_ouvrage SET status = :status WHERE DOID = :doid');
    return $stmt->execute([':status' => (int)$status, ':doid' => $doid]);
}

function updateDoAssurance($doid, $assurance_id) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $val = $assurance_id === '' || $assurance_id === null ? null : (int)$assurance_id;
    $stmt = $pdo->prepare('UPDATE dommage_ouvrage SET assurance_id = :assurance_id WHERE DOID = :doid');
    return $stmt->execute([':assurance_id' => $val, ':doid' => $doid]);
}

// --- Assurance CRUD ---

function getAllAssurances() {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return [];
    $stmt = $pdo->query('SELECT * FROM assurance ORDER BY nom ASC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAssurance($id) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return null;
    $stmt = $pdo->prepare('SELECT * FROM assurance WHERE assurance_id = :id');
    $stmt->execute([':id' => (int)$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertAssurance($nom, $logo, $active = 1) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('INSERT INTO assurance (nom, logo, active) VALUES (:nom, :logo, :active)');
    return $stmt->execute([':nom' => $nom, ':logo' => $logo, ':active' => (int)$active]);
}

function updateAssurance($id, $nom, $logo, $active) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('UPDATE assurance SET nom = :nom, logo = :logo, active = :active WHERE assurance_id = :id');
    return $stmt->execute([':nom' => $nom, ':logo' => $logo, ':active' => (int)$active, ':id' => (int)$id]);
}

function deleteAssurance($id) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    // Vérifier qu'aucune DO n'utilise cette assurance
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM dommage_ouvrage WHERE assurance_id = :id');
    $stmt->execute([':id' => (int)$id]);
    if ($stmt->fetchColumn() > 0) return 'used';
    $stmt = $pdo->prepare('DELETE FROM assurance WHERE assurance_id = :id');
    return $stmt->execute([':id' => (int)$id]);
}

/**
 * Crée ou met à jour le souscripteur MOA (quand MOA ≠ souscripteur principal).
 * Retourne l'ID du souscripteur MOA.
 */
function upsertMoaSouscripteur(int $doid, array $data): int|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;

    // Récupérer l'ID existant
    $stmt = $pdo->prepare('SELECT moa_souscripteur_id FROM moa WHERE DOID = :doid');
    $stmt->execute([':doid' => $doid]);
    $existing_id = $stmt->fetchColumn();

    $params = [
        ':civilite'   => $data['souscripteur_form_civilite'] ?? null,
        ':nom'        => $data['souscripteur_nom_raison'] ?? null,
        ':siret'      => !empty($data['souscripteur_siret']) ? $data['souscripteur_siret'] : null,
        ':adresse'    => $data['souscripteur_adresse'] ?? null,
        ':cp'         => !empty($data['souscripteur_code_postal']) ? $data['souscripteur_code_postal'] : 0,
        ':commune'    => $data['souscripteur_commune'] ?? '',
        ':telephone'  => $data['souscripteur_telephone'] ?? '',
        ':email'      => $data['souscripteur_email'] ?? '',
    ];

    if ($existing_id) {
        // UPDATE
        $sql = "UPDATE souscripteur SET
                    souscripteur_form_civilite = :civilite,
                    souscripteur_nom_raison = :nom,
                    souscripteur_siret = :siret,
                    souscripteur_adresse = :adresse,
                    souscripteur_code_postal = :cp,
                    souscripteur_commune = :commune,
                    souscripteur_telephone = :telephone,
                    souscripteur_email = :email
                WHERE souscripteur_id = :id";
        $params[':id'] = $existing_id;
        $pdo->prepare($sql)->execute($params);

        require_once __DIR__ . '/../controllers/LogController.php';
        logQuery($doid, 'souscripteur', $sql, $params, $_SESSION['user_id'] ?? null, 'réussi');

        return (int)$existing_id;
    } else {
        // INSERT
        $sql = "INSERT INTO souscripteur (souscripteur_form_civilite, souscripteur_nom_raison, souscripteur_siret,
                    souscripteur_adresse, souscripteur_code_postal, souscripteur_commune, souscripteur_telephone, souscripteur_email)
                VALUES (:civilite, :nom, :siret, :adresse, :cp, :commune, :telephone, :email)";
        $pdo->prepare($sql)->execute($params);
        $new_id = (int)$pdo->lastInsertId();

        // Lier à la table moa
        $pdo->prepare('UPDATE moa SET moa_souscripteur_id = :sid WHERE DOID = :doid')
            ->execute([':sid' => $new_id, ':doid' => $doid]);

        require_once __DIR__ . '/../controllers/LogController.php';
        logQuery($doid, 'souscripteur', $sql, $params, $_SESSION['user_id'] ?? null, 'réussi');

        return $new_id;
    }
}

/**
 * Récupère les données du souscripteur MOA (quand MOA ≠ souscripteur principal).
 */
function getMoaSouscripteur(int $doid): array|false {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $sql = "SELECT s.* FROM souscripteur s
            JOIN moa ON moa.moa_souscripteur_id = s.souscripteur_id
            WHERE moa.DOID = :doid LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':doid' => $doid]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Supprime le lien MOA→souscripteur (quand on repasse MOA = souscripteur).
 */
function clearMoaSouscripteur(int $doid): bool {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('UPDATE moa SET moa_souscripteur_id = NULL WHERE DOID = :doid');
    return $stmt->execute([':doid' => $doid]);
}

