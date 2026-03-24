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
        $sql = 'SELECT rcd.*,
            COALESCE(e.raison_sociale, ef.raison_sociale) AS raison_sociale,
            COALESCE(e.nom, ef.nom) AS e_nom,
            COALESCE(e.prenom, ef.prenom) AS e_prenom,
            COALESCE(e.adresse, ef.adresse) AS e_adresse,
            COALESCE(e.code_postal, ef.code_postal) AS e_code_postal,
            COALESCE(e.commune, ef.commune) AS e_commune,
            COALESCE(e.numero_siret, ef.numero_siret) AS e_numero_siret,
            COALESCE(e.type, ef.type) AS e_type
            FROM rcd
            LEFT JOIN entreprise e ON e.ID = rcd.rcd_entreprise_id
            LEFT JOIN rcd_nature rn ON rn.rcd_nature_id = rcd.rcd_nature_id
            LEFT JOIN travaux_annexes ta ON ta.DOID = rcd.DOID
            LEFT JOIN entreprise ef ON ef.ID = CASE rn.rcd_nature_nom
                WHEN \'Construction en bois\' THEN ta.boi_entreprise_id
                WHEN \'Photovoltaïques\' THEN ta.phv_entreprise_id
                WHEN \'Installation géothermique\' THEN ta.geo_entreprise_id
                WHEN \'Contrôleur technique\' THEN ta.ctt_entreprise_id
                WHEN \'Constructeur Non Réalisateur\' THEN ta.cnr_entreprise_id
                ELSE NULL
            END
            WHERE rcd.DOID = :doid';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':doid' => $DOID]);
        require_once __DIR__ . '/../controllers/LogController.php';
        $user_id = $_SESSION['user_id'] ?? null;
        logQuery($DOID, 'rcd', $sql, [':doid' => $DOID], $user_id, 'réussi');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    function getRcdStatsAllDo() {
        $pdo = $GLOBALS['pdo'] ?? null;
        $sql = 'SELECT DOID,
                       COUNT(*) AS total_lots,
                       SUM(CASE WHEN fichier != "" THEN 1 ELSE 0 END) AS lots_with_rcd
                FROM rcd
                GROUP BY DOID';
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stats = [];
        foreach ($rows as $r) {
            $stats[(int)$r['DOID']] = [
                'total' => (int)$r['total_lots'],
                'uploaded' => (int)$r['lots_with_rcd'],
            ];
        }
        return $stats;
    }

//création du souscripteur et de l'assurance dommage ouvrage + doid dans chaque table
    function insert_rdc($array_values){
        if (!empty($array_values)){
            $pdo = $GLOBALS['pdo'] ?? null;
            $stmt = $pdo->prepare('INSERT INTO rcd (DOID, rcd_entreprise_id, rcd_nature_id, rcd_nature_autre, rcd_nom, fichier, fichier_remarque, annexe_fichier, annexe_fichier_remarque, montant, construction_date_debut, construction_date_fin) VALUES (:doid, :entreprise_id, :nature_id, :nature_autre, :nom, :f, :fr, :af, :afr, :montant, :dd, :df)');
            try {
                $today = date('Y-m-d');
                $stmt->execute([
                    ':doid' => $array_values['doid'] ?? null,
                    ':entreprise_id' => $array_values['entreprise_id'] ?? 0,
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nature_autre' => $array_values['lot_nature_autre'] ?? '',
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':f' => '', ':fr' => '', ':af' => '', ':afr' => '',
                    ':montant' => $array_values['lot_montant'] ?? 0,
                    ':dd' => $today, ':df' => $today,
                ]);
                require_once __DIR__ . '/../controllers/LogController.php';
                $user_id = $_SESSION['user_id'] ?? null;
                logQuery($array_values['doid'] ?? null, 'rcd', $stmt->queryString, [
                    ':doid' => $array_values['doid'] ?? null,
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nature_autre' => $array_values['lot_nature_autre'] ?? '',
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':montant' => $array_values['lot_montant'] ?? 0,
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
            $has_dates = !empty($array_values['date_debut']) || !empty($array_values['date_fin']);
            if ($has_dates) {
                $sql = 'UPDATE rcd SET rcd_nature_id = :nature_id, rcd_nature_autre = :nature_autre, rcd_nom = :nom, montant = :montant, construction_date_debut = :date_debut, construction_date_fin = :date_fin WHERE rcd_id = :lot_id';
            } else {
                $sql = 'UPDATE rcd SET rcd_nature_id = :nature_id, rcd_nature_autre = :nature_autre, rcd_nom = :nom, montant = :montant WHERE rcd_id = :lot_id';
            }
            $stmt = $pdo->prepare($sql);
            try {
                $params = [
                    ':nature_id' => $array_values['lot_nature'] ?? null,
                    ':nature_autre' => $array_values['lot_nature_autre'] ?? '',
                    ':nom' => $array_values['lot_nom'] ?? null,
                    ':montant' => $array_values['lot_montant'] ?? null,
                    ':lot_id' => $lot_id,
                ];
                if ($has_dates) {
                    $params[':date_debut'] = convertDateFormat($array_values['date_debut'] ?? '', 'us-fr');
                    $params[':date_fin'] = convertDateFormat($array_values['date_fin'] ?? '', 'us-fr');
                }
                $stmt->execute($params);
                require_once __DIR__ . '/../controllers/LogController.php';
                $user_id = $_SESSION['user_id'] ?? null;
                logQuery(null, 'rcd', $stmt->queryString, $params, $user_id, 'réussi');
                return true;
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) throw $e;
                return false;
            }
        }
        return true;
    }      

    function init_RCD_DOID($DOID){
        // Delegate to the idempotent sync function
        return syncRcdFromAnnexes($DOID);
    }

    /**
     * Synchronise les lots RCD avec les flags travaux annexes (situation table).
     * - Crée les lots manquants quand un flag est actif et l'entreprise renseignée
     * - Supprime les lots auto-créés quand le flag passe à Non (seulement si pas de fichier uploadé)
     * - Idempotent : ne crée pas de doublons
     */
    function syncRcdFromAnnexes($DOID) {
        $pdo = $GLOBALS['pdo'] ?? null;
        if (!$pdo || !$DOID) return false;

        // Mapping: situation flag => [table, entreprise column, rcd_nature_nom]
        $mappings = [
            'situation_boi' => ['travaux_annexes', 'boi_entreprise_id', 'Construction en bois'],
            'situation_phv' => ['travaux_annexes', 'phv_entreprise_id', 'Photovoltaïques'],
            'situation_geo' => ['travaux_annexes', 'geo_entreprise_id', 'Installation géothermique'],
            'situation_ctt' => ['travaux_annexes', 'ctt_entreprise_id', 'Contrôleur technique'],
            'situation_cnr' => ['travaux_annexes', 'cnr_entreprise_id', 'Constructeur Non Réalisateur'],
        ];

        // Get current situation flags
        $stmt = $pdo->prepare('SELECT * FROM situation WHERE DOID = :doid LIMIT 1');
        $stmt->execute([':doid' => $DOID]);
        $situation = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$situation) return false;

        // Get travaux_annexes data
        $stmt = $pdo->prepare('SELECT * FROM travaux_annexes WHERE DOID = :doid LIMIT 1');
        $stmt->execute([':doid' => $DOID]);
        $travaux = $stmt->fetch(PDO::FETCH_ASSOC);

        // Get existing auto-created RCD lots (those with rcd_entreprise_id > 0)
        $stmt = $pdo->prepare('SELECT rcd_id, rcd_nature_id, rcd_entreprise_id, fichier, annexe_fichier FROM rcd WHERE DOID = :doid AND rcd_entreprise_id > 0');
        $stmt->execute([':doid' => $DOID]);
        $existingAuto = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Build lookup: nature_nom => nature_id
        $natures = getListNature();
        $natureByName = [];
        foreach ($natures as $n) {
            $natureByName[$n['rcd_nature_nom']] = (int)$n['rcd_nature_id'];
        }

        // Index existing auto lots by nature_id
        $existingByNature = [];
        foreach ($existingAuto as $row) {
            $existingByNature[(int)$row['rcd_nature_id']] = $row;
        }

        require_once __DIR__ . '/../controllers/LogController.php';
        $uid = $_SESSION['user_id'] ?? null;

        foreach ($mappings as $flag => $config) {
            [$table, $entrepriseCol, $natureName] = $config;
            $flagActive = !empty($situation[$flag]) && $situation[$flag] == '1';
            $natureId = $natureByName[$natureName] ?? null;

            if (!$natureId) continue;

            $entrepriseId = 0;
            if ($travaux && !empty($travaux[$entrepriseCol])) {
                $entrepriseId = (int)$travaux[$entrepriseCol];
            }

            $exists = isset($existingByNature[$natureId]);

            if ($flagActive && $entrepriseId > 0 && !$exists) {
                // Create the lot
                $today = date('Y-m-d');
                $params = [':doid' => $DOID, ':eid' => $entrepriseId, ':nid' => $natureId, ':na' => '', ':nom' => $natureName, ':f' => '', ':fr' => '', ':af' => '', ':afr' => '', ':mt' => 0, ':dd' => $today, ':df' => $today];
                $ins = $pdo->prepare('INSERT INTO rcd (DOID, rcd_entreprise_id, rcd_nature_id, rcd_nature_autre, rcd_nom, fichier, fichier_remarque, annexe_fichier, annexe_fichier_remarque, montant, construction_date_debut, construction_date_fin) VALUES (:doid, :eid, :nid, :na, :nom, :f, :fr, :af, :afr, :mt, :dd, :df)');
                $ins->execute($params);
                logQuery($DOID, 'rcd', $ins->queryString, $params, $uid, 'réussi');
            } elseif (!$flagActive && $exists) {
                // Flag turned off: remove auto-created lot only if no file uploaded
                $lot = $existingByNature[$natureId];
                if (empty($lot['fichier']) && empty($lot['annexe_fichier'])) {
                    $del = $pdo->prepare('DELETE FROM rcd WHERE rcd_id = :rid');
                    $del->execute([':rid' => $lot['rcd_id']]);
                    logQuery($DOID, 'rcd', $del->queryString, [':rid' => $lot['rcd_id']], $uid, 'réussi');
                }
            }
        }

        // Also handle sol_entreprise_id from situation table (maps to Installation géothermique)
        $solEntrepriseId = !empty($situation['sol_entreprise_id']) ? (int)$situation['sol_entreprise_id'] : 0;
        $geoNatureId = $natureByName['Installation géothermique'] ?? null;
        if ($geoNatureId && $solEntrepriseId > 0 && !isset($existingByNature[$geoNatureId])) {
            $today = date('Y-m-d');
            $params = [':doid' => $DOID, ':eid' => $solEntrepriseId, ':nid' => $geoNatureId, ':na' => '', ':nom' => 'Installation g\u00e9othermique', ':f' => '', ':fr' => '', ':af' => '', ':afr' => '', ':mt' => 0, ':dd' => $today, ':df' => $today];
            $ins = $pdo->prepare('INSERT INTO rcd (DOID, rcd_entreprise_id, rcd_nature_id, rcd_nature_autre, rcd_nom, fichier, fichier_remarque, annexe_fichier, annexe_fichier_remarque, montant, construction_date_debut, construction_date_fin) VALUES (:doid, :eid, :nid, :na, :nom, :f, :fr, :af, :afr, :mt, :dd, :df)');
            $ins->execute($params);
            logQuery($DOID, 'rcd', $ins->queryString, $params, $uid, 'réussi');
        }

        return true;
    }

    /**
     * Retourne les rcd_id des lots auto-créés (depuis travaux annexes) pour un DOID.
     * Ces lots ne doivent pas être supprimables depuis la page RCD.
     */
    function getLockedRcdIds($DOID) {
        $pdo = $GLOBALS['pdo'] ?? null;
        if (!$pdo) return [];
        $stmt = $pdo->prepare('SELECT rcd_id FROM rcd WHERE DOID = :doid AND rcd_entreprise_id > 0');
        $stmt->execute([':doid' => $DOID]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
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

function updatercdupload($file_ref, $filepath, $doid) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || empty($file_ref)) return false;

    $parts = explode('-', $file_ref);
    if (count($parts) < 2) return false;

    $type = $parts[0]; // 'rcd'
    $rcd_id = (int)$parts[1];
    if ($rcd_id <= 0) return false;

    $filename = basename($filepath);

    $stmt = $pdo->prepare('UPDATE rcd SET fichier = :fichier WHERE rcd_id = :rid AND DOID = :doid');
    try {
        $stmt->execute([':fichier' => $filename, ':rid' => $rcd_id, ':doid' => $doid]);
        require_once __DIR__ . '/../controllers/LogController.php';
        $uid = $_SESSION['user_id'] ?? null;
        logQuery($doid, 'rcd', $stmt->queryString, [':fichier' => $filename, ':rid' => $rcd_id, ':doid' => $doid], $uid, 'réussi');

        // Historique DO
        require_once __DIR__ . '/do.model.php';
        $lot_nom = '';
        $s = $pdo->prepare('SELECT rcd_nom FROM rcd WHERE rcd_id = :rid LIMIT 1');
        $s->execute([':rid' => $rcd_id]);
        $r = $s->fetch(PDO::FETCH_ASSOC);
        if ($r) $lot_nom = $r['rcd_nom'];
        $details = "Lot « $lot_nom » (#$rcd_id) — Document RCD uploadé : $filename";
        addDoHistorique($doid, 'Upload RCD', $uid, $details);

        return true;
    } catch (PDOException $e) {
        if (defined('DEBUG') && DEBUG) throw $e;
        return false;
    }
}

function updateRcdFileStatus($rcd_id, $field, $status, $doid) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || !$rcd_id) return false;

    $allowed = ['fichier_status', 'annexe_fichier_status'];
    if (!in_array($field, $allowed)) return false;
    $status = (int)$status;
    if ($status < 0 || $status > 3) return false;

    $stmt = $pdo->prepare("UPDATE rcd SET $field = :status WHERE rcd_id = :rid AND DOID = :doid");
    try {
        $stmt->execute([':status' => $status, ':rid' => $rcd_id, ':doid' => $doid]);
        require_once __DIR__ . '/../controllers/LogController.php';
        $uid = $_SESSION['user_id'] ?? null;
        logQuery($doid, 'rcd', $stmt->queryString, [':status' => $status, ':rid' => $rcd_id, ':doid' => $doid], $uid, 'réussi');

        // Ajouter à l'historique DO
        require_once __DIR__ . '/do.model.php';
        $labels = [
            0 => 'En attente de validation',
            1 => 'Document illisible ou incorrect',
            2 => 'Validation partielle, voir remarque',
            3 => 'Validé',
        ];
        $type_doc = ($field === 'fichier_status') ? 'RCD' : 'Annexe';
        $lot_nom = '';
        $s = $pdo->prepare('SELECT rcd_nom FROM rcd WHERE rcd_id = :rid LIMIT 1');
        $s->execute([':rid' => $rcd_id]);
        $r = $s->fetch(PDO::FETCH_ASSOC);
        if ($r) $lot_nom = $r['rcd_nom'];
        $details = "Lot « $lot_nom » (#$rcd_id) — $type_doc : " . ($labels[$status] ?? 'Inconnu');
        addDoHistorique($doid, 'Validation RCD', $uid, $details);

        return true;
    } catch (PDOException $e) {
        if (defined('DEBUG') && DEBUG) throw $e;
        return false;
    }
}


?>
