<?php

    require_once 'connect.db.php';



    //création des nature RCD
    function getListNature(){
        $pdo = $GLOBALS['pdo'] ?? null;
        if ($pdo) {
            $stmt = $pdo->query('SELECT * FROM rcd_nature');
            return $stmt->fetchAll();
        }
        // mysqli fallback
        $sql = "SELECT * FROM `rcd_nature`";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        return mysqli_fetch_all($resquery, MYSQLI_ASSOC);
    }

    function getFolderName($DOID){
        $pdo = $GLOBALS['pdo'] ?? null;
        if ($pdo) {
            $stmt = $pdo->prepare('SELECT DISTINCT repertoire as folder FROM dommage_ouvrage WHERE DOID = :doid LIMIT 1');
            $stmt->execute([':doid' => $DOID]);
            $folder = $stmt->fetch();
            return $folder['folder'] ?? '';
        }
        // mysqli fallback
        $sql = "SELECT distinct(repertoire) as folder FROM `dommage_ouvrage` where DOID = $DOID";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        $folder = mysqli_fetch_all($resquery, MYSQLI_ASSOC);
        return $folder[0]['folder'] ?? '';
    }

    function getRcdByDoid($DOID){
        $pdo = $GLOBALS['pdo'] ?? null;
        if ($pdo) {
            $stmt = $pdo->prepare('SELECT rcd.*, e.raison_sociale FROM rcd LEFT JOIN entreprise e ON e.ID = rcd.rcd_entreprise_id WHERE rcd.DOID = :doid');
            $stmt->execute([':doid' => $DOID]);
            return $stmt->fetchAll();
        }
        // mysqli fallback
        $sql = "SELECT `rcd`.*, raison_sociale FROM `rcd` LEFT JOIN `entreprise` ON entreprise.ID = `rcd`.rcd_entreprise_id WHERE `DOID` = $DOID";
        $resquery = mysqli_query($GLOBALS["conn"], $sql);
        return mysqli_fetch_all($resquery, MYSQLI_ASSOC);
    } 

//création du souscripteur et de l'assurance dommage ouvrage + doid dans chaque table
    function insert_rdc($array_values){
        if (!empty($array_values)){
            $pdo = $GLOBALS['pdo'] ?? null;
            if ($pdo) {
                $stmt = $pdo->prepare('INSERT INTO rcd (DOID, rcd_nature_id, rcd_nom, montant) VALUES (:doid, :nature_id, :nom, :montant)');
                try {
                    $stmt->execute([
                        ':doid' => $array_values['doid'] ?? null,
                        ':nature_id' => $array_values['lot_nature'] ?? null,
                        ':nom' => $array_values['lot_nom'] ?? null,
                        ':montant' => $array_values['lot_montant'] ?? null,
                    ]);
                    return true;
                } catch (PDOException $e) {
                    if (defined('DEBUG') && DEBUG) throw $e;
                    return false;
                }
            } else {
                // mysqli fallback
                $sql_rcd = "INSERT INTO `rcd` ( `DOID`, `rcd_nature_id`, `rcd_nom`, `montant`) VALUES ('".$array_values['doid']."', '".$array_values['lot_nature']."', '".$array_values['lot_nom']."', '".$array_values['lot_montant']."')";
                $query = mysqli_query($GLOBALS["conn"], $sql_rcd);
                if (!$query) {
                    die("Erreur lors de l'ajout de nouveaux lots: " . mysqli_error($GLOBALS["conn"]));
                }
                return true;
            }
        }
        return true;
    }

    function update_rdc($lot_id, $array_values){
        if (!empty($array_values)){
            $pdo = $GLOBALS['pdo'] ?? null;
            if ($pdo) {
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
                    return true;
                } catch (PDOException $e) {
                    if (defined('DEBUG') && DEBUG) throw $e;
                    return false;
                }
            } else {
                // mysqli fallback
                $sql_rcd = "UPDATE `rcd` SET rcd_nature_id = '".$array_values['lot_nature']."', rcd_nom = '".$array_values['lot_nom']."', montant = '".$array_values['lot_montant']."', construction_date_debut = '".convertDateFormat($array_values['date_debut'], 'us-fr')."', construction_date_fin = '".convertDateFormat($array_values['date_fin'], 'us-fr')."' WHERE `rcd_id` = $lot_id";
                $query = mysqli_query($GLOBALS["conn"], $sql_rcd);
                if (!$query) {
                    die("Erreur lors de l'ajout de nouveaux lots: " . mysqli_error($GLOBALS["conn"]));
                }
                return true;
            }
        }
        return true;
    }      

    function init_RCD_DOID($DOID){
        $pdo = $GLOBALS['pdo'] ?? null;
        if ($pdo) {
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
                return true;
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) throw $e;
                return false;
            }
        } else {
            // mysqli fallback
            $sql = "INSERT into rcd (rcd_entreprise_id,DOID, rcd_nature_id) 
                    SELECT boi_entreprise_id,DOID,  (SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Construction en bois')   
                    FROM `travaux_annexes` WHERE boi_entreprise_id>0 and `DOID`=$DOID      
                    UNION   
                    SELECT geo_entreprise_id,DOID,  (SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Installation géothermique')   
                    FROM `travaux_annexes` WHERE geo_entreprise_id>0 and `DOID`=$DOID
                    UNION
                    SELECT sol_entreprise_id,DOID, (SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Installation géothermique') 
                    FROM `situation` WHERE sol_entreprise_id>0 and `DOID`=$DOID
                    UNION
                    SELECT phv_entreprise_id,DOID,(SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Photovoltaïques') 
                    FROM `travaux_annexes` WHERE phv_entreprise_id>0  and `DOID`=$DOID
                    UNION   
                    SELECT ctt_entreprise_id,DOID,(SELECT rcd_nature_id FROM  `rcd_nature` WHERE rcd_nature_nom='Contrôleur technique') 
                    FROM `travaux_annexes` WHERE ctt_entreprise_id>0  and `DOID`=$DOID";

            $resquery = mysqli_query($GLOBALS["conn"], $sql);
            if (!$resquery) {
                die("Erreur lors de l'initialisation des RCD: " . mysqli_error($GLOBALS["conn"]));
            }
            return true;
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
