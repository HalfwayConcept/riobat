<?php
require_once __DIR__ . '/connect.db.php';

// ...existing code...



    //création des nature RCD
    function getListNature(){
        $pdo = $GLOBALS['pdo'] ?? null;
        $stmt = $pdo->query('SELECT * FROM rcd_nature');
        require_once __DIR__ . '/../controllers/LogController.php';
        $user_id = $_SESSION['user_id'] ?? null;
        logQuery(null, 'rcd_nature', $stmt->queryString ?? 'SELECT * FROM rcd_nature', [], $user_id, 'réussi');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getFolderName($DOID){
        $pdo = $GLOBALS['pdo'] ?? null;
        $stmt = $pdo->prepare('SELECT DISTINCT repertoire as folder FROM dommage_ouvrage WHERE DOID = :doid LIMIT 1');
        $stmt->execute([':doid' => $DOID]);
        require_once __DIR__ . '/../controllers/LogController.php';
        $user_id = $_SESSION['user_id'] ?? null;
        logQuery($DOID, 'dommage_ouvrage', $stmt->queryString, [':doid' => $DOID], $user_id, 'réussi');
        $folder = $stmt->fetch(PDO::FETCH_ASSOC);
        return $folder['folder'] ?? '';
    }

    function getRcdByDoid($DOID){
        $pdo = $GLOBALS['pdo'] ?? null;
        $stmt = $pdo->prepare('SELECT rcd.*, e.raison_sociale FROM rcd LEFT JOIN entreprise e ON e.ID = rcd.rcd_entreprise_id WHERE rcd.DOID = :doid');
        $stmt->execute([':doid' => $DOID]);
        require_once __DIR__ . '/../controllers/LogController.php';
        $user_id = $_SESSION['user_id'] ?? null;
        logQuery($DOID, 'rcd', $stmt->queryString, [':doid' => $DOID], $user_id, 'réussi');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

//création du souscripteur et de l'assurance dommage ouvrage + doid dans chaque table
    function insert_rdc($array_values){
        if (!empty($array_values)){
            $pdo = $GLOBALS['pdo'] ?? null;
            $stmt = $pdo->prepare('INSERT INTO rcd (DOID, rcd_nature_id, rcd_nom, montant) VALUES (:doid, :nature_id, :nom, :montant)');
            try {
                $stmt->execute([
                    ':doid' => $array_values['doid'] ?? null,
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':montant' => $array_values['lot_montant'] ?? null,
                ]);
                require_once __DIR__ . '/../controllers/LogController.php';
                $user_id = $_SESSION['user_id'] ?? null;
                logQuery($array_values['doid'] ?? null, 'rcd', $stmt->queryString, [
                    ':doid' => $array_values['doid'] ?? null,
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':montant' => $array_values['lot_montant'] ?? null,
                ], $user_id, 'réussi');
                return true;
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) throw $e;
                return false;
            }
        }
        return true;
    }

    function update_rdc($lot_id, $array_values){
        if (!empty($array_values)){
            $pdo = $GLOBALS['pdo'] ?? null;
            $stmt = $pdo->prepare('UPDATE rcd SET rcd_nature_id = :nature_id, rcd_nom = :nom, montant = :montant, construction_date_debut = :date_debut, construction_date_fin = :date_fin WHERE rcd_id = :lot_id');
            try {
                $stmt->execute([
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':montant' => $array_values['lot_montant'] ?? null,
                    ':date_debut' => convertDateFormat($array_values['date_debut'] ?? '', 'us-fr'),
                    ':date_fin' => convertDateFormat($array_values['date_fin'] ?? '', 'us-fr'),
                    ':lot_id' => $lot_id,
                ]);
                require_once __DIR__ . '/../controllers/LogController.php';
                $user_id = $_SESSION['user_id'] ?? null;
                logQuery(null, 'rcd', $stmt->queryString, [
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':montant' => $array_values['lot_montant'] ?? null,
                    ':date_debut' => convertDateFormat($array_values['date_debut'] ?? '', 'us-fr'),
                    ':date_fin' => convertDateFormat($array_values['date_fin'] ?? '', 'us-fr'),
                    ':lot_id' => $lot_id,
                ], $user_id, 'réussi');
                return true;
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) throw $e;
                return false;
            }
        }
        return true;
    }      

    function init_RCD_DOID($DOID){
        $pdo = $GLOBALS['pdo'] ?? null;
        $sql = "INSERT INTO rcd (rcd_entreprise_id, DOID, rcd_nature_id)
                SELECT boi_entreprise_id, DOID, (SELECT rcd_nature_id FROM rcd_nature WHERE rcd_nature_nom = 'Construction en bois')
                FROM travaux_annexes WHERE boi_entreprise_id > 0 AND DOID = :doid
                UNION
                SELECT geo_entreprise_id, DOID, (SELECT rcd_nature_id FROM rcd_nature WHERE rcd_nature_nom = 'Installation géothermique')
                FROM travaux_annexes WHERE geo_entreprise_id > 0 AND DOID = :doid
                UNION
                SELECT sol_entreprise_id, DOID, (SELECT rcd_nature_id FROM rcd_nature WHERE rcd_nature_nom = 'Installation géothermique')
                FROM situation WHERE sol_entreprise_id > 0 AND DOID = :doid
                UNION
                SELECT phv_entreprise_id, DOID, (SELECT rcd_nature_id FROM rcd_nature WHERE rcd_nature_nom = 'Photovoltaïques')
                FROM travaux_annexes WHERE phv_entreprise_id > 0 AND DOID = :doid
                UNION
                SELECT ctt_entreprise_id, DOID, (SELECT rcd_nature_id FROM rcd_nature WHERE rcd_nature_nom = 'Contrôleur technique')
                FROM travaux_annexes WHERE ctt_entreprise_id > 0 AND DOID = :doid";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([':doid' => $DOID]);
            require_once __DIR__ . '/../controllers/LogController.php';
            $user_id = $_SESSION['user_id'] ?? null;
            logQuery($DOID, 'rcd', $stmt->queryString, [':doid' => $DOID], $user_id, 'réussi');
            return true;
        } catch (PDOException $e) {
            if (defined('DEBUG') && DEBUG) throw $e;
            return false;
        }
    }


function convertDateFormat($date, $direction) {
    // Vérifier la direction de conversion
    if ($direction === 'us-fr') {
        // Conversion de MM/DD/YYYY vers YYYY-MM-DD
        $parts = explode('/', $date);
        if (count($parts) === 3) {
            $month = $parts[0];
            $day = $parts[1];
            $year = $parts[2];
            return "$year-$month-$day";
        }
    } elseif ($direction === 'fr-us') {
        // Conversion de YYYY-MM-DD vers MM/DD/YYYY
        $parts = explode('-', $date);
        if (count($parts) === 3) {
            $year = $parts[0];
            $month = $parts[1];
            $day = $parts[2];
            return "$month/$day/$year";
        }
    }
    // Retourner la date originale en cas de format invalide
    return $date;
}


?>
