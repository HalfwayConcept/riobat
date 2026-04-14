<?php
/**
 * test_runner.php : Script CLI pour tests de non-régression formulaire DO
 * Usage : php test_runner.php [--cleanup]
 * 
 * Sans --cleanup : exécute les scénarios et conserve les données (affiche les DOID)
 * Avec --cleanup : exécute les scénarios puis nettoie automatiquement
 */
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('Accès interdit.');
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$autoCleanup = in_array('--cleanup', $argv ?? []);

// Bootstrap minimal
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['env'] = 'dev';
require_once __DIR__ . '/inc/settings.php';
require_once __DIR__ . '/models/do.model.php';
require_once __DIR__ . '/models/user.model.php';
require_once __DIR__ . '/models/entreprise.model.php';
require_once __DIR__ . '/controllers/LogController.php';

function _cliRandomStr($len = 8) {
    $c = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $s = '';
    for ($i = 0; $i < $len; $i++) $s .= $c[random_int(0, strlen($c) - 1)];
    return $s;
}

function _cliRandomEntreprise($type) {
    return [
        'raison_sociale' => 'CLI_ENT_' . strtoupper($type) . '_' . _cliRandomStr(5),
        'nom'            => 'Nom_' . _cliRandomStr(4),
        'prenom'         => 'Pren_' . _cliRandomStr(4),
        'adresse'        => _cliRandomStr(10),
        'code_postal'    => (string)rand(10000, 99999),
        'commune'        => _cliRandomStr(6),
        'numero_siret'   => (string)rand(10000000000000, 99999999999999),
        'type'           => $type,
    ];
}

function _cliCleanupDoid($doid, $entrepriseIds = []) {
    $pdo = $GLOBALS['pdo'] ?? null;
    if (!$pdo || !$doid) return false;
    try {
        $pdo->beginTransaction();
        // Récupérer les IDs d'entreprises liées avant suppression
        $entStmt = $pdo->prepare("SELECT boi_entreprise_id, phv_entreprise_id, geo_entreprise_id, ctt_entreprise_id, cnr_entreprise_id FROM travaux_annexes WHERE DOID = :d");
        $entStmt->execute([':d' => $doid]);
        $entRow = $entStmt->fetch(PDO::FETCH_ASSOC);

        foreach (['do_historique', 'utilisateur_session', 'rcd', 'travaux_annexes', 'situation', 'operation_construction', 'moa'] as $t) {
            $pdo->prepare("DELETE FROM $t WHERE DOID = :d")->execute([':d' => $doid]);
        }
        $stmt = $pdo->prepare('SELECT souscripteur_id FROM dommage_ouvrage WHERE DOID = :d');
        $stmt->execute([':d' => $doid]);
        $sid = $stmt->fetchColumn();
        $pdo->prepare('DELETE FROM dommage_ouvrage WHERE DOID = :d')->execute([':d' => $doid]);
        if ($sid) $pdo->prepare('DELETE FROM souscripteur WHERE souscripteur_id = :s')->execute([':s' => $sid]);

        // Supprimer les entreprises
        $allEntIds = $entrepriseIds;
        if ($entRow) {
            foreach ($entRow as $eid) { if ($eid) $allEntIds[] = (int)$eid; }
        }
        foreach (array_unique($allEntIds) as $eid) {
            $pdo->prepare('DELETE FROM entreprise WHERE ID = :id')->execute([':id' => $eid]);
        }
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        echo "  NETTOYAGE ECHEC: " . $e->getMessage() . "\n";
        return false;
    }
}

/**
 * Exécute un scénario complet steps 1→5
 */
function _cliRunScenario($label, $userId, $withAnnexes = false, $moaOverride = []) {
    $success = true;
    $doid = null;
    $entrepriseIds = [];

    echo "--- $label ---\n";

    try {
        // Step 1
        $nom = 'CLI_TEST_' . _cliRandomStr(6);
        $doid = insert([
            'fields' => 'souscripteur',
            'souscripteur_nom_raison' => $nom,
            'souscripteur_siret' => (string)rand(10000000000000, 99999999999999),
            'souscripteur_adresse' => _cliRandomStr(12),
            'souscripteur_code_postal' => (string)rand(10000, 99999),
            'souscripteur_commune' => _cliRandomStr(8),
            'souscripteur_profession' => _cliRandomStr(6),
            'souscripteur_telephone' => '06' . rand(10000000, 99999999),
            'souscripteur_email' => _cliRandomStr(6) . '@test.local',
            'page_next' => 'step2',
        ]);
        if ($doid) {
            // Flaguer comme DO de test
            $pdo = $GLOBALS['pdo'] ?? null;
            if ($pdo) {
                $pdo->prepare('UPDATE dommage_ouvrage SET is_test = 1 WHERE DOID = :d')->execute([':d' => $doid]);
            }
            $_SESSION['DOID'] = $doid;
            insert_utilisateur_session($doid, $userId);
            addDoHistorique($doid, 'Test auto', $userId, "Création DO — $label");
            echo "  Step 1  OK  DOID=$doid  nom=$nom\n";
        } else {
            echo "  Step 1  ECHEC\n";
            return ['ok' => false, 'doid' => null, 'entreprises' => []];
        }

        // Step 2
        $moaData = ['fields' => 'moa', 'moa_souscripteur' => '1', 'moa_qualite' => '1', 'moa_construction' => '0', 'page_next' => 'step3'];
        if (!empty($moaOverride)) {
            $moaData = array_merge($moaData, $moaOverride);

            // MOA ≠ souscripteur : créer le souscripteur MOA via upsertMoaSouscripteur
            if (isset($moaOverride['moa_souscripteur']) && $moaOverride['moa_souscripteur'] == '0') {
                $civilite = $moaOverride['moa_souscripteur_form_civilite'] ?? 'particulier';
                $nom_prenom = $moaOverride['moa_souscripteur_form_nom_prenom'] ?? '';
                $raison_sociale = $moaOverride['moa_souscripteur_form_raison_sociale'] ?? '';
                $sub_data = [
                    'souscripteur_form_civilite' => $civilite,
                    'souscripteur_nom_raison' => ($civilite === 'entreprise') ? $raison_sociale : $nom_prenom,
                    'souscripteur_adresse' => $moaOverride['moa_souscripteur_form_adresse'] ?? '',
                    'souscripteur_siret' => ($civilite === 'entreprise') ? ($moaOverride['moa_souscripteur_form_siret'] ?? '') : null,
                ];
                $sub_id = upsertMoaSouscripteur($doid, $sub_data);
                if ($sub_id) {
                    $moaData['moa_souscripteur_id'] = $sub_id;
                }

                // Si entreprise, aussi créer l'enregistrement entreprise
                if ($civilite === 'entreprise') {
                    $ent_id = insertEntreprise([
                        'raison_sociale' => $raison_sociale,
                        'nom' => $nom_prenom,
                        'prenom' => '',
                        'adresse' => $moaOverride['moa_souscripteur_form_adresse'] ?? '',
                        'code_postal' => '',
                        'commune' => '',
                        'numero_siret' => $moaOverride['moa_souscripteur_form_siret'] ?? '',
                        'type' => 'moa',
                    ]);
                    if ($ent_id) {
                        $moaData['moa_entreprise_id'] = $ent_id;
                        $entrepriseIds[] = $ent_id;
                        echo "    Entreprise moa=#$ent_id\n";
                    }
                }
            }
        }
        $r = update($moaData, 'moa', $doid);
        $moaLabel = ($moaData['moa_souscripteur'] == '1') ? 'MOA=souscripteur' : 'MOA≠souscripteur (' . ($moaOverride['moa_souscripteur_form_civilite'] ?? '?') . ')';
        echo "  Step 2  " . ($r ? 'OK' : 'ECHEC') . "  $moaLabel\n";
        if (!$r) $success = false;

        // Step 3
        $r = update(['fields' => 'operation_construction', 'nature_neuf_exist' => 'neuve', 'construction_adresse' => _cliRandomStr(12), 'construction_adresse_code_postal' => (string)rand(10000, 99999), 'construction_adresse_commune' => _cliRandomStr(8), 'type_ouvrage_mais_indiv' => '1', 'construction_date_debut' => date('Y-m-d', strtotime('+'.rand(1,30).' days')), 'construction_date_debut_prevue' => date('Y-m-d', strtotime('+'.rand(31,60).' days')), 'construction_date_reception' => date('Y-m-d', strtotime('+'.rand(180,365).' days')), 'page_next' => 'step4'], 'operation_construction', $doid);
        echo "  Step 3  " . ($r ? 'OK' : 'ECHEC') . "\n";
        if (!$r) $success = false;

        // Step 4 — Situation
        $annexeTypes = ['boi', 'phv', 'geo', 'ctt', 'cnr'];
        $enabledAnnexes = [];
        if ($withAnnexes) {
            shuffle($annexeTypes);
            $enabledAnnexes = array_slice($annexeTypes, 0, rand(2, 4));
        }

        $situationData = [
            'fields' => 'situation',
            'situation_zone_inond' => '0', 'situation_sismique' => '1',
            'situation_insectes' => '0', 'situation_proc_techniques' => '0',
            'situation_parking' => '0', 'situation_do_10ans' => '0',
            'situation_mon_hist' => '0', 'situation_label_energie' => '0',
            'situation_label_qualite' => '0', 'situation_sol' => '0',
            'situation_boi' => in_array('boi', $enabledAnnexes) ? '1' : '0',
            'situation_phv' => in_array('phv', $enabledAnnexes) ? '1' : '0',
            'situation_geo' => in_array('geo', $enabledAnnexes) ? '1' : '0',
            'situation_ctt' => in_array('ctt', $enabledAnnexes) ? '1' : '0',
            'situation_cnr' => in_array('cnr', $enabledAnnexes) ? '1' : '0',
            'page_next' => empty($enabledAnnexes) ? 'step5' : 'step4bis',
        ];
        $r = update($situationData, 'situation', $doid);
        $annexeLabel = empty($enabledAnnexes) ? 'aucune' : implode(',', $enabledAnnexes);
        echo "  Step 4  " . ($r ? 'OK' : 'ECHEC') . "  annexes=$annexeLabel\n";
        if (!$r) $success = false;

        // Step 4bis
        if (!empty($enabledAnnexes)) {
            $travauxData = ['fields' => 'travaux_annexes', 'page_next' => 'step5'];
            foreach ($enabledAnnexes as $type) {
                switch ($type) {
                    case 'boi':
                        $travauxData['trav_annexes_constr_bois'] = '1';
                        $travauxData['trav_annexes_constr_bois_enveloppe'] = '1';
                        break;
                    case 'phv':
                        $travauxData['trav_annexes_pv_montage'] = 'integre';
                        $travauxData['trav_annexes_pv_etn'] = '1';
                        $travauxData['trav_annexes_pv_liste_c2p'] = '0';
                        $travauxData['trav_annexes_pv_surface'] = rand(10, 200);
                        $travauxData['trav_annexes_pv_proc_tech'] = '1';
                        $travauxData['trav_annexes_pv_puissance'] = rand(3, 50);
                        $travauxData['trav_annexes_pv_destination'] = 'revente';
                        break;
                    case 'geo':
                        $travauxData['trav_annexes_constr_produits_ce'] = '1';
                        break;
                    case 'ctt':
                        $travauxData['trav_annexes_ct_type_controle'] = 'L,LE';
                        break;
                    case 'cnr':
                        $travauxData['cnr_qualite'] = 'Maitre d\'ouvrage delegue';
                        break;
                }
                $entId = insertEntreprise(_cliRandomEntreprise($type));
                if ($entId) {
                    updateEntrepriseID($entId, $type, $doid);
                    $entrepriseIds[] = $entId;
                    echo "    Entreprise $type=#$entId\n";
                } else {
                    echo "    Entreprise $type=ECHEC\n";
                    $success = false;
                }
            }
            $r = update($travauxData, 'travaux_annexes', $doid);
            echo "  Step 4b " . ($r ? 'OK' : 'ECHEC') . "\n";
            if (!$r) $success = false;
            addDoHistorique($doid, 'Test auto', $userId, 'Travaux annexes : ' . implode(', ', $enabledAnnexes));
        } else {
            echo "  Step 4b SKIP\n";
        }

        // Step 5
        $r = update(['fields' => 'dommage_ouvrage', 'moe' => '0', 'garantie_do' => '1', 'garantie_chantier' => '0', 'garantie_juridique' => '0', 'page_next' => 'validation'], 'dommage_ouvrage', $doid);
        echo "  Step 5  " . ($r ? 'OK' : 'ECHEC') . "\n";
        if (!$r) $success = false;

        addDoHistorique($doid, 'Test auto', $userId, 'Fin du formulaire');

        // Vérification BDD
        $data = getDo($doid);
        if ($data && $data['souscripteur_nom_raison'] === $nom && $data['nature_neuf_exist'] === 'neuve') {
            echo "  Verif   OK\n";
        } else {
            echo "  Verif   ECHEC\n";
            $success = false;
        }

        // Vérification dates
        if (!empty($data['construction_date_debut']) && !empty($data['construction_date_debut_prevue']) && !empty($data['construction_date_reception'])) {
            echo "  Dates   OK  debut=" . $data['construction_date_debut'] . " prevue=" . $data['construction_date_debut_prevue'] . " recept=" . $data['construction_date_reception'] . "\n";
        } else {
            echo "  Dates   ECHEC (valeurs vides)\n";
            $success = false;
        }

        // Vérification MOA
        if (!empty($moaOverride) && isset($moaOverride['moa_souscripteur']) && $moaOverride['moa_souscripteur'] == '0') {
            $civilite = $moaOverride['moa_souscripteur_form_civilite'] ?? '';
            $moaCivOk = ($data['moa_sub_civilite'] ?? '') === $civilite;
            $expectedNom = ($civilite === 'entreprise')
                ? ($moaOverride['moa_souscripteur_form_raison_sociale'] ?? '')
                : ($moaOverride['moa_souscripteur_form_nom_prenom'] ?? '');
            $moaNomOk = ($data['moa_sub_nom_raison'] ?? '') === $expectedNom;
            if ($moaCivOk && $moaNomOk) {
                echo "  MOA     OK  civilite=" . ($data['moa_sub_civilite'] ?? '') . " nom=" . ($data['moa_sub_nom_raison'] ?? '') . "\n";
                if ($civilite === 'entreprise') {
                    $siretOk = ($data['moa_sub_siret'] ?? '') === ($moaOverride['moa_souscripteur_form_siret'] ?? '');
                    $entOk = !empty($data['moa_entreprise_id']);
                    echo "  MOAent  " . (($siretOk && $entOk) ? 'OK' : 'ECHEC') . "  siret=" . ($data['moa_sub_siret'] ?? '') . " ent_id=" . ($data['moa_entreprise_id'] ?? 'null') . "\n";
                    if (!$siretOk || !$entOk) $success = false;
                }
            } else {
                echo "  MOA     ECHEC  civilite=" . ($data['moa_sub_civilite'] ?? 'null') . " nom=" . ($data['moa_sub_nom_raison'] ?? 'null') . "\n";
                $success = false;
            }
        }

        // Vérification Historique
        $hist = getDoHistorique($doid);
        $nbHist = count($hist);
        if ($nbHist >= 2) {
            echo "  Histor  OK ($nbHist entrees)\n";
        } else {
            echo "  Histor  ECHEC ($nbHist entrees, min 2)\n";
            $success = false;
        }

        // Vérification entreprises liées
        if (!empty($enabledAnnexes)) {
            $ent = getEntreprises($doid);
            $entOk = true;
            foreach ($enabledAnnexes as $at) {
                if (empty($ent[$at . '_entreprise_id'])) {
                    echo "  EntLnk  ECHEC ($at non liée)\n";
                    $entOk = false;
                    $success = false;
                }
            }
            if ($entOk) echo "  EntLnk  OK\n";
        }

    } catch (Exception $e) {
        echo "  ERREUR: " . $e->getMessage() . "\n";
        $success = false;
    }

    return ['ok' => $success, 'doid' => $doid, 'entreprises' => $entrepriseIds];
}

// ============================================================
echo "=== Tests de non-régression DO ===\n\n";
$overall = true;
$doidsToClean = [];

// --- SCÉNARIO A : Admin sans annexes ---
$_SESSION['user_id'] = 1;
$scenA = _cliRunScenario('Scenario A — Admin sans annexes', 1, false);
if (!$scenA['ok']) $overall = false;
if ($scenA['doid']) $doidsToClean[] = $scenA;
echo "\n";

// --- SCÉNARIO B : MOA ≠ souscripteur (Particulier) ---
$_SESSION['user_id'] = 1;
$scenMoaP = _cliRunScenario('Scenario B — MOA particulier (pas souscripteur)', 1, false, [
    'moa_souscripteur' => '0',
    'moa_souscripteur_form_civilite' => 'particulier',
    'moa_souscripteur_form_nom_prenom' => 'Dupont Jean-Pierre',
    'moa_souscripteur_form_adresse' => '12 rue des Lilas 43000 Le Puy',
]);
if (!$scenMoaP['ok']) $overall = false;
if ($scenMoaP['doid']) $doidsToClean[] = $scenMoaP;
echo "\n";

// --- SCÉNARIO C : MOA ≠ souscripteur (Entreprise) ---
$_SESSION['user_id'] = 1;
$scenMoaE = _cliRunScenario('Scenario C — MOA entreprise (pas souscripteur)', 1, false, [
    'moa_souscripteur' => '0',
    'moa_souscripteur_form_civilite' => 'entreprise',
    'moa_souscripteur_form_nom_prenom' => 'Martin Sophie',
    'moa_souscripteur_form_adresse' => '45 avenue Victor Hugo 69003 Lyon',
    'moa_souscripteur_form_raison_sociale' => 'SARL Bâti-Concept',
    'moa_souscripteur_form_siret' => '98765432100012',
]);
if (!$scenMoaE['ok']) $overall = false;
if ($scenMoaE['doid']) $doidsToClean[] = $scenMoaE;
echo "\n";

// --- SCÉNARIO D : Nouvel utilisateur + annexes ---
$testEmail = 'cli_test_' . _cliRandomStr(8) . '@test.local';
$testPassword = 'Test1234!';
$newUserId = register_user([
    'nom' => 'CLI_NOM_' . _cliRandomStr(4),
    'prenom' => 'CLI_PRE_' . _cliRandomStr(4),
    'email' => $testEmail,
    'password' => $testPassword,
    'confirm_password' => $testPassword,
]);
if (is_int($newUserId) && $newUserId > 0) {
    echo "  User cree ID=$newUserId email=$testEmail\n";
    $_SESSION['user_id'] = $newUserId;
    $scenD = _cliRunScenario('Scenario D — Nouvel utilisateur + annexes', $newUserId, true);
    if (!$scenD['ok']) $overall = false;
    if ($scenD['doid']) $doidsToClean[] = $scenD;
} else {
    echo "  User creation ECHEC: " . (is_string($newUserId) ? $newUserId : 'erreur inconnue') . "\n";
    $overall = false;
}
echo "\n";

// ============================================================
// Résultat final
echo "===========================================\n";
echo $overall ? "TOUS LES SCENARIOS PASSES\n" : "DES SCENARIOS ONT ECHOUE\n";
echo "===========================================\n";

// Nettoyage ou affichage des liens
if ($autoCleanup) {
    echo "\nNettoyage automatique...\n";
    foreach ($doidsToClean as $sc) {
        $ok = _cliCleanupDoid($sc['doid'], $sc['entreprises']);
        echo "  DOID " . $sc['doid'] . " : " . ($ok ? 'supprimé' : 'échec') . "\n";
    }
    if (isset($newUserId) && is_int($newUserId) && $newUserId > 0) {
        $pdo = $GLOBALS['pdo'] ?? null;
        if ($pdo) {
            $pdo->prepare('DELETE FROM utilisateur WHERE ID = :id')->execute([':id' => $newUserId]);
            echo "  Utilisateur $newUserId supprimé\n";
        }
    }
} else {
    echo "\nDonnées conservées. Pour chaque DOID, voir :\n";
    foreach ($doidsToClean as $sc) {
        echo "  https://localhost/riobat/index.php?page=validation&doid=" . $sc['doid'] . "\n";
    }
    echo "\nRelancer avec --cleanup pour nettoyer : php test_runner.php --cleanup\n";
}
