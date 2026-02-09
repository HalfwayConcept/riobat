<?php
require_once 'connect.db.php';

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

    $sql = "SELECT dommage_ouvrage.*, souscripteur.*, moa.*, operation_construction.*, situation.*, travaux_annexes.*
            FROM dommage_ouvrage
            JOIN souscripteur ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
            JOIN moa ON moa.DOID = dommage_ouvrage.DOID
            JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID
            JOIN travaux_annexes ON travaux_annexes.DOID = dommage_ouvrage.DOID
            JOIN situation ON situation.DOID = dommage_ouvrage.DOID
            WHERE dommage_ouvrage.DOID = :doid
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':doid' => $doid]);
    return $stmt->fetch();
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

    $sql = "SELECT dommage_ouvrage.*, operation_construction.*, situation.*, souscripteur.*, moa.*, travaux_annexes.*, utilisateur_session.*
            FROM souscripteur
            JOIN dommage_ouvrage ON dommage_ouvrage.souscripteur_id = souscripteur.souscripteur_id
            JOIN moa ON moa.DOID = dommage_ouvrage.DOID
            JOIN utilisateur_session ON utilisateur_session.DOID = dommage_ouvrage.DOID
            JOIN operation_construction ON operation_construction.DOID = dommage_ouvrage.DOID
            JOIN travaux_annexes ON travaux_annexes.DOID = dommage_ouvrage.DOID
            JOIN situation ON situation.DOID = dommage_ouvrage.DOID";
    $params = [];
    if($user_id != null){
        $sql .= " WHERE utilisateur_session.utilisateur_id = :user_id";
        $params[':user_id'] = $user_id;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
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
                    ':nom' => $s['souscripteur_nom_raison'] ?? null,
                    ':siret' => !empty($s['souscripteur_siret']) ? $s['souscripteur_siret'] : null,
                    ':adresse' => !empty($s['souscripteur_adresse']) ? $s['souscripteur_adresse'] : null,
                    ':cp' => !empty($s['souscripteur_code_postal']) ? $s['souscripteur_code_postal'] : null,
                    ':commune' => !empty($s['souscripteur_commune']) ? $s['souscripteur_commune'] : null,
                    ':profession' => !empty($s['souscripteur_profession']) ? $s['souscripteur_profession'] : null,
                    ':telephone' => !empty($s['souscripteur_telephone']) ? $s['souscripteur_telephone'] : null,
                    ':email' => !empty($s['souscripteur_email']) ? $s['souscripteur_email'] : null,
                    ':ancien_date' => !empty($s['souscripteur_ancien_client_date']) ? $s['souscripteur_ancien_client_date'] : null,
                    ':ancien_num' => !empty($s['souscripteur_ancien_client_num']) ? $s['souscripteur_ancien_client_num'] : null,
                ]);
                $souscripteur_id = (int)$pdo->lastInsertId();

                $sql_do = "INSERT INTO dommage_ouvrage (souscripteur_id,repertoire) VALUES (:souscripteur_id, LEFT(MD5(RAND()), 12))";
                $stmt = $pdo->prepare($sql_do);
                $stmt->execute([':souscripteur_id' => $souscripteur_id]);
                $DOID = (int)$pdo->lastInsertId();

                $tables = ['moa','operation_construction','situation','travaux_annexes'];
                foreach ($tables as $t) {
                    $stmt = $pdo->prepare("INSERT INTO $t (DOID) VALUES (:doid)");
                    $stmt->execute([':doid' => $DOID]);
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

    foreach ($array_SESSION as $field => $value) {
        if($field != "fields" &&  $field != "page_next"
            && !str_starts_with($field, "sol_")
            && !str_starts_with($field, "boi_")
            && !str_starts_with($field, "phv_")
            && !str_starts_with($field, "geo_")
            && !str_starts_with($field, "ctt_")
            && !str_starts_with($field, "moe_")
            && !str_starts_with($field, "cnr_")
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
            $_SESSION["SQL"][$table] = debugQuery($sqlupdate, array_values($params));
            return $res;
        } catch (PDOException $e) {
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
    return date('d-m-Y', strtotime($date));
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


function deleteDo($doid){
    $pdo = $GLOBALS['pdo'] ?? null;
    if ($pdo) {
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
    } else {
        $deletesql = "DELETE FROM dommage_ouvrage WHERE DOID = '$doid'";
        mysqli_query($GLOBALS['conn'], $deletesql);
        $deletesql = "DELETE FROM moa WHERE DOID = '$doid'";
        mysqli_query($GLOBALS['conn'], $deletesql);
        $deletesql = "DELETE FROM operation_construction WHERE DOID = '$doid'";
        mysqli_query($GLOBALS['conn'], $deletesql);
        $deletesql = "DELETE FROM situation WHERE DOID = '$doid'";
        mysqli_query($GLOBALS['conn'], $deletesql);
        $deletesql = "DELETE FROM travaux_annexes WHERE DOID = '$doid'";
        mysqli_query($GLOBALS['conn'], $deletesql);
    }

    header( "Location: index.php?page=admin" );

    return true;
}

function validDo($doid){
    $pdo = $GLOBALS['pdo'] ?? null;
    if ($pdo) {
        $stmt = $pdo->prepare('UPDATE dommage_ouvrage SET status = 1 WHERE DOID = :doid');
        $stmt->execute([':doid' => $doid]);
    } else {
        $updatestatusSql = "UPDATE `dommage_ouvrage` SET `status` = '1' WHERE `dommage_ouvrage`.`DOID` = $doid;";
        mysqli_query($GLOBALS['conn'], $updatestatusSql);
    }
    return true;
}


function loadDo($doid){
    $user_id =  $_SESSION['user_id'] ?? null;
    $_SESSION = [];

    $_SESSION['DOID']       = $doid;
    $_SESSION['user_id']    = $user_id;
    $do = getDo($doid);

    $_SESSION["info_souscripteur"]["souscripteur_id"] = $do["souscripteur_id"];

    $array_tables = array('souscripteur', 'operation_construction', 'situation', 'travaux_annexes', 'moa','dommage_ouvrage');
    foreach ($array_tables as $table) {
        $col_names =  getColumnNames($table);
        foreach ($col_names as $key => $col) {
            $_SESSION["info_".$table][$col] = $do[$col] ?? null;                    
        }
    }
}

/**
* Get the column names for a mysql table
**/
function getColumnNames($table) {
    $allowed_tables = ['souscripteur', 'operation_construction', 'situation', 'travaux_annexes', 'moa', 'dommage_ouvrage'];
    if (!in_array($table, $allowed_tables)) return [];

    $pdo = $GLOBALS['pdo'] ?? null;
    if ($pdo) {
        $sql = 'DESCRIBE ' . $table;
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return $rows;
    }

    $sql = 'DESCRIBE '.$table;
    $result = mysqli_query($GLOBALS['conn'], $sql);
    $rows = array();
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row['Field'];
    }    
    return $rows;
}

  




