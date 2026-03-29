<?php
/**
 * Test runner amélioré — Scénarios multiples pour le formulaire DO
 * 
 * Scénario A : Admin sans annexes (parcours basique)
 * Scénario B : Nouvel utilisateur + travaux annexes aléatoires + entreprises
 * 
 * Pas de nettoyage automatique — liens vers la page validation en fin de test.
 * Bouton de nettoyage séparé.
 */

function _testRandomStr($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $str = '';
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $str;
}

function _testRandomEntreprise($type) {
    return [
        'raison_sociale' => 'TEST_ENT_' . strtoupper($type) . '_' . _testRandomStr(5),
        'nom'            => 'Nom_' . _testRandomStr(4),
        'prenom'         => 'Pren_' . _testRandomStr(4),
        'adresse'        => _testRandomStr(10),
        'code_postal'    => (string)rand(10000, 99999),
        'commune'        => _testRandomStr(6),
        'numero_siret'   => (string)rand(10000000000000, 99999999999999),
        'type'           => $type,
    ];
}

/**
 * Exécute un scénario complet steps 1→5 et retourne ['results' => [...], 'ok' => bool, 'doid' => int|null, 'cleanup' => [...]]
 */
function _runScenario($scenarioLabel, $userId, $withAnnexes = false) {
    $results = [];
    $ok = true;
    $doid = null;
    $cleanup = ['entreprises' => [], 'user_id' => null];

    try {
        // ====== STEP 1 : Souscripteur + Création DO ======
        $souscripteur_nom = 'TEST_' . _testRandomStr(8);
        $sessionData = [
            'fields'                       => 'souscripteur',
            'souscripteur_nom_raison'      => $souscripteur_nom,
            'souscripteur_siret'           => (string)rand(10000000000000, 99999999999999),
            'souscripteur_adresse'         => _testRandomStr(12),
            'souscripteur_code_postal'     => (string)rand(10000, 99999),
            'souscripteur_commune'         => _testRandomStr(8),
            'souscripteur_profession'      => _testRandomStr(6),
            'souscripteur_telephone'       => '06' . rand(10000000, 99999999),
            'souscripteur_email'           => _testRandomStr(6) . '@test.local',
            'page_next'                    => 'step2',
        ];

        $doid = insert($sessionData);
        if ($doid) {
            // Flaguer comme DO de test
            $pdo = $GLOBALS['pdo'] ?? null;
            if ($pdo) {
                $pdo->prepare('UPDATE dommage_ouvrage SET is_test = 1 WHERE DOID = :d')->execute([':d' => $doid]);
            }
            $_SESSION['DOID'] = $doid;
            insert_utilisateur_session($doid, $userId);
            addDoHistorique($doid, 'Test auto', $userId, "Création DO — $scenarioLabel");
            $results[] = ['step' => '1', 'label' => 'Souscripteur + Création DO', 'ok' => true,
                'detail' => "DOID = $doid — nom = $souscripteur_nom"];
        } else {
            $results[] = ['step' => '1', 'label' => 'Souscripteur + Création DO', 'ok' => false,
                'detail' => 'insert() a retourné false'];
            return ['results' => $results, 'ok' => false, 'doid' => null, 'cleanup' => $cleanup];
        }

        // ====== STEP 2 : Maître d'Ouvrage ======
        $r2 = update([
            'fields'             => 'moa',
            'moa_souscripteur'   => '1',
            'moa_qualite'        => '1',
            'moa_construction'   => '0',
            'page_next'          => 'step3',
        ], 'moa', $doid);
        $results[] = ['step' => '2', 'label' => 'Maître d\'Ouvrage', 'ok' => (bool)$r2,
            'detail' => $r2 ? 'OK' : 'update(moa) échoué'];
        if (!$r2) $ok = false;

        // ====== STEP 3 : Opération de construction ======
        $r3 = update([
            'fields'                            => 'operation_construction',
            'nature_neuf_exist'                 => 'neuve',
            'construction_adresse'              => _testRandomStr(12),
            'construction_adresse_code_postal'  => (string)rand(10000, 99999),
            'construction_adresse_commune'      => _testRandomStr(8),
            'type_ouvrage_mais_indiv'           => '1',
            // Ajout simulation des dates comme dans test_runner.php
            'construction_date_debut'           => date('Y-m-d', strtotime('+'.rand(1,30).' days')),
            'construction_date_debut_prevue'    => date('Y-m-d', strtotime('+'.rand(31,60).' days')),
            'construction_date_reception'       => date('Y-m-d', strtotime('+'.rand(180,365).' days')),
            'page_next'                         => 'step4',
        ], 'operation_construction', $doid);
        $results[] = ['step' => '3', 'label' => 'Opération de construction', 'ok' => (bool)$r3,
            'detail' => $r3 ? 'OK' : 'update(operation_construction) échoué'];
        if (!$r3) $ok = false;

        // ====== STEP 4 : Situation de l'ouvrage ======
        $annexeTypes = ['boi', 'phv', 'geo', 'ctt', 'cnr'];
        $enabledAnnexes = [];

        if ($withAnnexes) {
            // Activer aléatoirement 2 à 4 annexes
            shuffle($annexeTypes);
            $nbAnnexes = rand(2, min(4, count($annexeTypes)));
            $enabledAnnexes = array_slice($annexeTypes, 0, $nbAnnexes);
        }

        $situationData = [
            'fields'                  => 'situation',
            'situation_zone_inond'    => '0',
            'situation_sismique'      => '1',
            'situation_insectes'      => '0',
            'situation_proc_techniques' => '0',
            'situation_parking'       => '0',
            'situation_do_10ans'      => '0',
            'situation_mon_hist'      => '0',
            'situation_label_energie' => '0',
            'situation_label_qualite' => '0',
            'situation_sol'           => '0',
            'situation_boi'           => in_array('boi', $enabledAnnexes) ? '1' : '0',
            'situation_phv'           => in_array('phv', $enabledAnnexes) ? '1' : '0',
            'situation_geo'           => in_array('geo', $enabledAnnexes) ? '1' : '0',
            'situation_ctt'           => in_array('ctt', $enabledAnnexes) ? '1' : '0',
            'situation_cnr'           => in_array('cnr', $enabledAnnexes) ? '1' : '0',
            'page_next'               => empty($enabledAnnexes) ? 'step5' : 'step4bis',
        ];
        $r4 = update($situationData, 'situation', $doid);
        $annexeLabel = empty($enabledAnnexes) ? 'aucune annexe' : implode(', ', $enabledAnnexes);
        $results[] = ['step' => '4', 'label' => 'Situation de l\'ouvrage', 'ok' => (bool)$r4,
            'detail' => $r4 ? "OK — annexes : $annexeLabel" : 'update(situation) échoué'];
        if (!$r4) $ok = false;

        // ====== STEP 4bis : Travaux annexes + Entreprises ======
        if (!empty($enabledAnnexes)) {
            $travauxData = ['fields' => 'travaux_annexes', 'page_next' => 'step5'];
            $entreprisesCreated = [];

            foreach ($enabledAnnexes as $type) {
                // Ajouter les champs spécifiques par type d'annexe
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
                        $travauxData['cnr_qualite'] = 'Maitre d\'ouvrage délégué';
                        break;
                }

                // Créer une entreprise pour cette annexe
                $entData = _testRandomEntreprise($type);
                $entId = insertEntreprise($entData);
                if ($entId) {
                    updateEntrepriseID($entId, $type, $doid);
                    $entreprisesCreated[] = "$type=#$entId";
                    $cleanup['entreprises'][] = $entId;
                } else {
                    $entreprisesCreated[] = "$type=ÉCHEC";
                    $ok = false;
                }
            }

            // Sauvegarder les données de travaux annexes
            $r4b = update($travauxData, 'travaux_annexes', $doid);
            $results[] = ['step' => '4bis', 'label' => 'Travaux annexes + Entreprises', 'ok' => (bool)$r4b && $ok,
                'detail' => ($r4b ? 'OK' : 'update(travaux_annexes) échoué') . ' — entreprises : ' . implode(', ', $entreprisesCreated)];
            if (!$r4b) $ok = false;

            addDoHistorique($doid, 'Test auto', $userId, 'Travaux annexes : ' . implode(', ', $enabledAnnexes));
        } else {
            $results[] = ['step' => '4bis', 'label' => 'Travaux annexes (sauté)', 'ok' => true,
                'detail' => 'Aucune situation annexe cochée — étape non nécessaire'];
        }

        // ====== STEP 5 : Maîtrise d'œuvre + Garanties ======
        $r5 = update([
            'fields'              => 'dommage_ouvrage',
            'moe'                 => '0',
            'garantie_do'         => '1',
            'garantie_chantier'   => '0',
            'garantie_juridique'  => '0',
            'page_next'           => 'validation',
        ], 'dommage_ouvrage', $doid);
        $results[] = ['step' => '5', 'label' => 'Maîtrise d\'œuvre + Garanties', 'ok' => (bool)$r5,
            'detail' => $r5 ? 'OK' : 'update(dommage_ouvrage) échoué'];
        if (!$r5) $ok = false;

        addDoHistorique($doid, 'Test auto', $userId, 'Fin du formulaire — step5 terminé');

        // ====== VÉRIFICATION BDD ======
        $doData = getDo($doid);
        if ($doData) {
            $checks = [
                'souscripteur_nom_raison' => $souscripteur_nom,
                'nature_neuf_exist'       => 'neuve',
                'situation_sismique'      => '1',
                'garantie_do'             => '1',
            ];
            // Vérifier les drapeaux d'annexes
            foreach ($annexeTypes as $at) {
                $checks['situation_' . $at] = in_array($at, $enabledAnnexes) ? '1' : '0';
            }
            // Vérifier les entreprises
            if (!empty($enabledAnnexes)) {
                $entreprises = getEntreprises($doid);
                if ($entreprises) {
                    foreach ($enabledAnnexes as $at) {
                        $fk = $at . '_entreprise_id';
                        if (empty($entreprises[$fk])) {
                            $checks['__entreprise_' . $at] = 'MANQUANTE';
                        }
                    }
                }
            }

            $verif_ok = true;
            $verif_lines = [];
            foreach ($checks as $f => $expected) {
                if (str_starts_with($f, '__entreprise_')) {
                    $verif_ok = false;
                    $verif_lines[] = "Entreprise " . substr($f, 13) . " non liée";
                    continue;
                }
                $actual = $doData[$f] ?? 'NULL';
                if ((string)$actual !== (string)$expected) {
                    $verif_ok = false;
                    $verif_lines[] = "$f : attendu « $expected » — obtenu « $actual »";
                }
            }
            $results[] = ['step' => 'V', 'label' => 'Vérification BDD', 'ok' => $verif_ok,
                'detail' => $verif_ok ? 'Toutes les données correspondent' : implode(' | ', $verif_lines)];
            if (!$verif_ok) $ok = false;
        } else {
            $results[] = ['step' => 'V', 'label' => 'Vérification BDD', 'ok' => false,
                'detail' => "getDo($doid) a retourné null"];
            $ok = false;
        }

        // ====== VÉRIFICATION HISTORIQUE ======
        $historique = getDoHistorique($doid);
        $nbHist = count($historique);
        $histOk = $nbHist >= 2; // Au minimum : création + fin step5
        $results[] = ['step' => 'H', 'label' => 'Historique DO', 'ok' => $histOk,
            'detail' => $histOk
                ? "$nbHist entrée(s) trouvée(s) — OK"
                : "Seulement $nbHist entrée(s) trouvée(s) (minimum 2 attendues)"];
        if (!$histOk) $ok = false;

    } catch (Exception $e) {
        $results[] = ['step' => 'E', 'label' => 'Erreur fatale', 'ok' => false,
            'detail' => $e->getMessage()];
        $ok = false;
    }

    return ['results' => $results, 'ok' => $ok, 'doid' => $doid, 'cleanup' => $cleanup];
}

// ============================================================
// Nettoyage à la demande (via GET cleanup_doid)
// ============================================================
if (isset($_GET['cleanup_doid'])) {
    $cleanupDoid = (int)$_GET['cleanup_doid'];
    $pdo = $GLOBALS['pdo'] ?? null;
    $cleanupMsg = '';
    if ($pdo && $cleanupDoid > 0) {
        try {
            $pdo->beginTransaction();
            // Supprimer entreprises liées
            $entStmt = $pdo->prepare("SELECT boi_entreprise_id, phv_entreprise_id, geo_entreprise_id, ctt_entreprise_id, cnr_entreprise_id FROM travaux_annexes WHERE DOID = :d");
            $entStmt->execute([':d' => $cleanupDoid]);
            $entRow = $entStmt->fetch(PDO::FETCH_ASSOC);
            $solStmt = $pdo->prepare("SELECT sol_entreprise_id FROM situation WHERE DOID = :d");
            $solStmt->execute([':d' => $cleanupDoid]);
            $solRow = $solStmt->fetch(PDO::FETCH_ASSOC);
            $moeStmt = $pdo->prepare("SELECT moe_entreprise_id FROM dommage_ouvrage WHERE DOID = :d");
            $moeStmt->execute([':d' => $cleanupDoid]);
            $moeRow = $moeStmt->fetch(PDO::FETCH_ASSOC);

            foreach (['do_historique', 'utilisateur_session', 'rcd', 'travaux_annexes', 'situation', 'operation_construction', 'moa'] as $t) {
                $pdo->prepare("DELETE FROM $t WHERE DOID = :d")->execute([':d' => $cleanupDoid]);
            }
            $stmt = $pdo->prepare('SELECT souscripteur_id FROM dommage_ouvrage WHERE DOID = :d');
            $stmt->execute([':d' => $cleanupDoid]);
            $sid = $stmt->fetchColumn();
            $pdo->prepare('DELETE FROM dommage_ouvrage WHERE DOID = :d')->execute([':d' => $cleanupDoid]);
            if ($sid) {
                $pdo->prepare('DELETE FROM souscripteur WHERE souscripteur_id = :s')->execute([':s' => $sid]);
            }
            // Supprimer les entreprises liées
            $entIds = [];
            if ($entRow) {
                foreach ($entRow as $eid) { if ($eid) $entIds[] = (int)$eid; }
            }
            if ($solRow && !empty($solRow['sol_entreprise_id'])) $entIds[] = (int)$solRow['sol_entreprise_id'];
            if ($moeRow && !empty($moeRow['moe_entreprise_id'])) $entIds[] = (int)$moeRow['moe_entreprise_id'];
            foreach (array_unique($entIds) as $eid) {
                $pdo->prepare('DELETE FROM entreprise WHERE ID = :id')->execute([':id' => $eid]);
            }
            $pdo->commit();
            $cleanupMsg = "DOID $cleanupDoid nettoyé avec succès (" . count($entIds) . " entreprise(s) supprimée(s))";
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $cleanupMsg = "Erreur nettoyage DOID $cleanupDoid : " . $e->getMessage();
        }
    }
}

// ============================================================
// Exécution des scénarios
// ============================================================
$_original_session = $_SESSION;
$_scenarios = [];

// --- SCÉNARIO A : Admin sans annexes ---
$_SESSION['user_id'] = 1;
$scenA = _runScenario('Admin sans annexes', 1, false);
$_scenarios[] = [
    'title'   => 'Scénario A — Admin sans annexes',
    'desc'    => 'Utilisateur admin (ID=1), parcours basique steps 1→5, aucune annexe',
    'results' => $scenA['results'],
    'ok'      => $scenA['ok'],
    'doid'    => $scenA['doid'],
    'cleanup' => $scenA['cleanup'],
];

// --- SCÉNARIO B : Nouvel utilisateur + annexes aléatoires ---
$testEmail = 'test_' . _testRandomStr(8) . '@test.local';
$testPassword = 'Test1234!';
$newUserId = register_user([
    'nom'              => 'TEST_NOM_' . _testRandomStr(4),
    'prenom'           => 'TEST_PRE_' . _testRandomStr(4),
    'email'            => $testEmail,
    'password'         => $testPassword,
    'confirm_password' => $testPassword,
]);

if (is_int($newUserId) && $newUserId > 0) {
    $_SESSION['user_id'] = $newUserId;
    $scenB = _runScenario('Nouvel utilisateur + annexes', $newUserId, true);
    $_scenarios[] = [
        'title'   => 'Scénario B — Nouvel utilisateur + annexes aléatoires',
        'desc'    => "Utilisateur créé (ID=$newUserId, $testEmail), travaux annexes aléatoires avec entreprises",
        'results' => array_merge(
            [['step' => '0', 'label' => 'Création utilisateur', 'ok' => true, 'detail' => "ID = $newUserId — email = $testEmail"]],
            $scenB['results']
        ),
        'ok'      => $scenB['ok'],
        'doid'    => $scenB['doid'],
        'cleanup' => array_merge($scenB['cleanup'], ['user_id' => $newUserId]),
    ];
} else {
    $errMsg = is_string($newUserId) ? $newUserId : 'Erreur inconnue';
    $_scenarios[] = [
        'title'   => 'Scénario B — Nouvel utilisateur + annexes aléatoires',
        'desc'    => "Échec de création utilisateur : $errMsg",
        'results' => [['step' => '0', 'label' => 'Création utilisateur', 'ok' => false, 'detail' => $errMsg]],
        'ok'      => false,
        'doid'    => null,
        'cleanup' => ['entreprises' => [], 'user_id' => null],
    ];
}

// Restaurer la session d'origine
$_SESSION = $_original_session;

// Résultat global
$_test_overall = true;
foreach ($_scenarios as $s) {
    if (!$s['ok']) $_test_overall = false;
}
?>

<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-center font-bold text-2xl mt-4 mb-6">Tests de non-régression — Formulaire DO</h2>

        <?php if (isset($cleanupMsg)): ?>
        <div class="mb-4 p-3 rounded-lg text-center text-sm font-medium bg-yellow-50 border border-yellow-300 text-yellow-800">
            <?= htmlspecialchars($cleanupMsg) ?>
        </div>
        <?php endif; ?>

        <!-- Résultat global -->
        <div class="mb-6 p-4 rounded-lg text-center font-semibold text-lg <?= $_test_overall ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' ?>">
            <?= $_test_overall ? '&#10004; TOUS LES SCÉNARIOS ONT RÉUSSI' : '&#10008; CERTAINS SCÉNARIOS ONT ÉCHOUÉ' ?>
        </div>

        <?php foreach ($_scenarios as $idx => $scenario): ?>
        <div class="mb-8 border rounded-xl overflow-hidden <?= $scenario['ok'] ? 'border-green-300' : 'border-red-300' ?>">
            <!-- En-tête scénario -->
            <div class="p-4 <?= $scenario['ok'] ? 'bg-green-50' : 'bg-red-50' ?>">
                <h3 class="font-bold text-lg text-gray-800">
                    <?= $scenario['ok'] ? '&#9989;' : '&#10060;' ?>
                    <?= htmlspecialchars($scenario['title']) ?>
                </h3>
                <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($scenario['desc']) ?></p>
            </div>

            <!-- Détails par étape -->
            <div class="p-4 space-y-2 bg-white">
                <?php foreach ($scenario['results'] as $tr): ?>
                <div class="flex items-start gap-3 p-2 rounded-lg <?= $tr['ok'] ? 'bg-green-50' : 'bg-red-50' ?>">
                    <span class="shrink-0 mt-0.5"><?= $tr['ok'] ? '&#9989;' : '&#10060;' ?></span>
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Étape <?= htmlspecialchars($tr['step']) ?> — <?= htmlspecialchars($tr['label']) ?></p>
                        <p class="text-xs text-gray-600 mt-0.5"><?= htmlspecialchars($tr['detail']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Liens d'action pour ce scénario -->
            <?php if ($scenario['doid']): ?>
            <div class="p-4 bg-gray-50 border-t flex flex-wrap gap-3 items-center">
                <a href="index.php?page=validation&doid=<?= $scenario['doid'] ?>" target="_blank"
                   class="inline-flex items-center gap-2 text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    Voir résultat — Validation DOID <?= $scenario['doid'] ?>
                </a>
                <a href="index.php?page=admin&run_tests=1&cleanup_doid=<?= $scenario['doid'] ?>"
                   class="inline-flex items-center gap-2 text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-4 py-2"
                   onclick="return confirm('Supprimer le DOID <?= $scenario['doid'] ?> et toutes les données associées ?')">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/></svg>
                    Nettoyer DOID <?= $scenario['doid'] ?>
                </a>
                <span class="text-xs text-gray-500">DOID <?= $scenario['doid'] ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <!-- Boutons globaux -->
        <div class="mt-6 text-center flex flex-wrap justify-center gap-3">
            <a href="index.php?page=admin" class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/></svg>
                Retour à l'administration
            </a>
            <a href="index.php?page=admin&run_tests=1" class="inline-flex items-center gap-2 text-white bg-gray-600 hover:bg-gray-700 font-medium rounded-lg text-sm px-5 py-2.5">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/></svg>
                Relancer les tests
            </a>
        </div>
    </div>
</section>
