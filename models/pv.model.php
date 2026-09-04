<?php
require_once __DIR__ . '/connect.db.php';

function getPvStepTables(): array {
	// Ajouter ici les futures tables pv_* (une ligne par DOID)
	return [
		'pv_description_centrale',
		'pv_prevention',
		'pv_environnement',
		'pv_protection',
	];
}

function pvTableExists(string $table): bool {
	static $cache = [];
	if (isset($cache[$table])) {
		return $cache[$table];
	}

	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo) {
		$cache[$table] = false;
		return false;
	}

	$stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = :table");
	$stmt->execute([':table' => $table]);
	$cache[$table] = ((int)$stmt->fetchColumn() > 0);
	return $cache[$table];
}

function insertPvDefaultRow(string $table, int $doid): bool {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists($table)) {
		return false;
	}

	if ($table === 'pv_description_centrale') {
		$sql = "INSERT INTO pv_description_centrale (
			DOID,
			adresse_centrale,
			code_postal,
			commune,
			entreprise_pose_qualipv,
			valeur_neuve_remplacement,
			valeur_type,
			date_mise_en_service,
			deja_assuree,
			sinistre_deja,
			surface_totale_m2,
			puissance_crete_kwc,
			nature_panneaux,
			panneaux_details,
			onduleurs_details,
			prix_vente_kwh,
			recettes_previsionnelles_annuelles,
			destination_energie,
			batteries_existent
		) VALUES (
			:doid,
			'',
			'',
			'',
			'',
			0,
			'HT',
			CURRENT_DATE,
			0,
			0,
			0,
			0,
			'mono',
			'',
			'',
			0,
			0,
			'revente',
			0
		)";
		$stmt = $pdo->prepare($sql);
		return $stmt->execute([':doid' => $doid]);
	}

	if ($table === 'pv_protection') {
		$sql = "INSERT INTO pv_protection (DOID) VALUES (:doid)";
		$stmt = $pdo->prepare($sql);
		return $stmt->execute([':doid' => $doid]);
	}

	$stmt = $pdo->prepare("INSERT INTO $table (DOID) VALUES (:doid)");
	return $stmt->execute([':doid' => $doid]);
}

function insertPvRows(int $doid): bool {
	if ($doid <= 0) return false;

	$pdo = $GLOBALS['pdo'] ?? null;
	if ($pdo) {
		foreach (getPvStepTables() as $table) {
			if (!pvTableExists($table)) {
				continue;
			}
			if (!insertPvDefaultRow($table, $doid)) {
				return false;
			}
			require_once __DIR__ . '/../controllers/LogController.php';
			logQuery($doid, $table, 'INSERT default row', [':doid' => $doid], $_SESSION['user_id'] ?? null, 'réussi');
		}
		return true;
	}

	// Fallback mysqli (legacy)
	if (!isset($GLOBALS['conn'])) return false;
	foreach (getPvStepTables() as $table) {
		$existsQ = mysqli_query($GLOBALS['conn'], "SHOW TABLES LIKE '" . mysqli_real_escape_string($GLOBALS['conn'], $table) . "'");
		if (!$existsQ || mysqli_num_rows($existsQ) === 0) {
			continue;
		}
		$sql = "INSERT INTO $table (DOID) VALUES ('" . (int)$doid . "')";
		if (!mysqli_query($GLOBALS['conn'], $sql)) {
			return false;
		}
		$_SESSION['SQL'][$table] = $sql;
	}
	return true;
}


function ensurePvRow(string $table, int $doid): bool {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists($table)) {
		return false;
	}

	$stmt = $pdo->prepare("SELECT COUNT(*) FROM $table WHERE DOID = :doid");
	$stmt->execute([':doid' => $doid]);
	if ((int)$stmt->fetchColumn() > 0) {
		return true;
	}

	return insertPvDefaultRow($table, $doid);
}

function savePvDescription(int $doid, array $info): bool {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists('pv_description_centrale')) {
		$_SESSION['update_error'] = !$pdo ? 'Connexion PDO indisponible.' : ($doid <= 0 ? 'DOID invalide.' : 'La table pv_description_centrale est absente.');
		return false;
	}

	if (!ensurePvRow('pv_description_centrale', $doid)) {
		$_SESSION['update_error'] = 'Impossible de créer ou retrouver la ligne pv_description_centrale pour DOID=' . $doid . '.';
		return false;
	}

	$toDecimal = function ($value, int $precision = 2): ?string {
		if ($value === null || $value === '') return null;
		$str = str_replace([' ', ','], ['', '.'], (string)$value);
		if (!is_numeric($str)) return null;
		return number_format((float)$str, $precision, '.', '');
	};

	$params = [
		':doid' => $doid,
		':adresse_centrale' => trim((string)($info['pv_adresse'] ?? '')),
		':code_postal' => trim((string)($info['pv_code_postal'] ?? '')),
		':commune' => trim((string)($info['pv_commune'] ?? '')),
		':entreprise_pose_qualipv' => trim((string)($info['pv_entreprise_pose_qualipv'] ?? '')),
		':valeur_neuve_remplacement' => $toDecimal($info['pv_valeur_neuve_remplacement'] ?? null, 2),
		':valeur_type' => (($info['pv_valeur_type'] ?? 'HT') === 'TTC') ? 'TTC' : 'HT',
		':date_mise_en_service' => !empty($info['pv_date_mise_en_service']) ? $info['pv_date_mise_en_service'] : null,
		':deja_assuree' => (($info['pv_deja_assuree'] ?? '0') === '1') ? 1 : 0,
		':sinistre_deja' => (($info['pv_sinistre_deja'] ?? '0') === '1') ? 1 : 0,
		':sinistre_nature_montant' => !empty($info['pv_sinistre_nature_montant']) ? trim((string)$info['pv_sinistre_nature_montant']) : null,
		':surface_totale_m2' => $toDecimal($info['pv_surface_totale'] ?? null, 2),
		':puissance_crete_kwc' => $toDecimal($info['pv_puissance_crete'] ?? null, 2),
		':nature_panneaux' => in_array(($info['pv_nature_panneaux'] ?? ''), ['mono', 'polycristallin', 'amorphe'], true) ? $info['pv_nature_panneaux'] : null,
		':panneaux_details' => trim((string)($info['pv_panneaux_details'] ?? '')),
		':onduleurs_details' => trim((string)($info['pv_onduleurs_details'] ?? '')),
		':prix_vente_kwh' => $toDecimal($info['pv_prix_vente_kwh'] ?? null, 5),
		':recettes_previsionnelles_annuelles' => $toDecimal($info['pv_recettes_annuelles'] ?? null, 2),
		':destination_energie' => in_array(($info['pv_destination_energie'] ?? ''), ['revente', 'autoconsommation'], true) ? $info['pv_destination_energie'] : null,
		':economies_achat_annuelles' => $toDecimal($info['pv_economies_achat_annuelles'] ?? null, 2),
		':batteries_existent' => (($info['pv_batteries_existent'] ?? '0') === '1') ? 1 : 0,
		':batteries_details' => !empty($info['pv_batteries_details']) ? trim((string)$info['pv_batteries_details']) : null,
	];

	$sql = "UPDATE pv_description_centrale SET
				adresse_centrale = :adresse_centrale,
				code_postal = :code_postal,
				commune = :commune,
				entreprise_pose_qualipv = :entreprise_pose_qualipv,
				valeur_neuve_remplacement = :valeur_neuve_remplacement,
				valeur_type = :valeur_type,
				date_mise_en_service = :date_mise_en_service,
				deja_assuree = :deja_assuree,
				sinistre_deja = :sinistre_deja,
				sinistre_nature_montant = :sinistre_nature_montant,
				surface_totale_m2 = :surface_totale_m2,
				puissance_crete_kwc = :puissance_crete_kwc,
				nature_panneaux = :nature_panneaux,
				panneaux_details = :panneaux_details,
				onduleurs_details = :onduleurs_details,
				prix_vente_kwh = :prix_vente_kwh,
				recettes_previsionnelles_annuelles = :recettes_previsionnelles_annuelles,
				destination_energie = :destination_energie,
				economies_achat_annuelles = :economies_achat_annuelles,
				batteries_existent = :batteries_existent,
				batteries_details = :batteries_details,
				date_mise_a_jour = CURRENT_TIMESTAMP
			WHERE DOID = :doid";

	try {
		$stmt = $pdo->prepare($sql);
		$res = $stmt->execute($params);
		require_once __DIR__ . '/../controllers/LogController.php';
		logQuery($doid, 'pv_description_centrale', $stmt->queryString, $params, $_SESSION['user_id'] ?? null, $res ? 'réussi' : 'échec');
		if ($res) {
			unset($_SESSION['update_error']);
		}
		return $res;
	} catch (PDOException $e) {
		error_log('[riobat] savePvDescription failed for DOID=' . $doid . ' : ' . $e->getMessage());
		$_SESSION['update_error'] = $e->getMessage();
		return false;
	}
}

function savePvPrevention(int $doid, array $info): bool {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists('pv_prevention')) {
		$_SESSION['update_error'] = !$pdo ? 'Connexion PDO indisponible.' : ($doid <= 0 ? 'DOID invalide.' : 'La table pv_prevention est absente.');
		return false;
	}

	$ensureRow = ensurePvRow('pv_prevention', $doid);
	if (!$ensureRow) {
		$_SESSION['update_error'] = 'Impossible de créer ou retrouver la ligne pv_prevention pour DOID=' . $doid . '.';
		return false;
	}

	$toDecimal = function ($value, int $precision = 2): ?string {
		if ($value === null || $value === '') return null;
		$str = str_replace([' ', ','], ['', '.'], (string)$value);
		if (!is_numeric($str)) return null;
		return number_format((float)$str, $precision, '.', '');
	};

	$params = [
		':doid' => $doid,
		':contrat_maintenance_equipements' => (($info['pv_prev_contrat_maintenance'] ?? '0') === '1') ? 1 : 0,
		':monitoring_production_continue' => (($info['pv_prev_monitoring'] ?? '0') === '1') ? 1 : 0,
		':duree_garantie_onduleurs' => !empty($info['pv_prev_duree_garantie_onduleurs']) ? trim((string)$info['pv_prev_duree_garantie_onduleurs']) : null,
		':onduleurs_local_coupe_feu_2h' => (($info['pv_prev_local_coupe_feu'] ?? '0') === '1') ? 1 : 0,
		':hauteur_implantation_min_m' => $toDecimal($info['pv_prev_hauteur_mini_m'] ?? null, 2),
		':fixation_modules_antivol' => (($info['pv_prev_systeme_antivol'] ?? '0') === '1') ? 1 : 0,
		':fixation_antivol_details' => !empty($info['pv_prev_systeme_antivol_details']) ? trim((string)$info['pv_prev_systeme_antivol_details']) : null,
		':incendie_extincteurs_mobiles' => (($info['pv_prev_incendie_extincteurs'] ?? '0') === '1') ? 1 : 0,
		':incendie_poteaux' => (($info['pv_prev_incendie_poteaux'] ?? '0') === '1') ? 1 : 0,
		':incendie_detection_automatique' => (($info['pv_prev_incendie_detection_auto'] ?? '0') === '1') ? 1 : 0,
		':incendie_sprinkler' => (($info['pv_prev_incendie_sprinkler'] ?? '0') === '1') ? 1 : 0,
		':incendie_autres' => !empty($info['pv_prev_incendie_autres']) ? trim((string)$info['pv_prev_incendie_autres']) : null,
		':verification_electrique_annuelle' => (($info['pv_prev_verif_elec_annuelle'] ?? '0') === '1') ? 1 : 0,
		':nom_organisme_verificateur' => !empty($info['pv_prev_nom_organisme_verificateur']) ? trim((string)$info['pv_prev_nom_organisme_verificateur']) : null,
		':controle_thermographie_infrarouge' => (($info['pv_prev_thermo_infrarouge'] ?? '0') === '1') ? 1 : 0,
		':etude_resistance_vent_ombriere' => (($info['pv_prev_etude_vent_ombriere'] ?? '0') === '1') ? 1 : 0,
	];

	$sql = "UPDATE pv_prevention SET
			contrat_maintenance_equipements = :contrat_maintenance_equipements,
			monitoring_production_continue = :monitoring_production_continue,
			duree_garantie_onduleurs = :duree_garantie_onduleurs,
			onduleurs_local_coupe_feu_2h = :onduleurs_local_coupe_feu_2h,
			hauteur_implantation_min_m = :hauteur_implantation_min_m,
			fixation_modules_antivol = :fixation_modules_antivol,
			fixation_antivol_details = :fixation_antivol_details,
			incendie_extincteurs_mobiles = :incendie_extincteurs_mobiles,
			incendie_poteaux = :incendie_poteaux,
			incendie_detection_automatique = :incendie_detection_automatique,
			incendie_sprinkler = :incendie_sprinkler,
			incendie_autres = :incendie_autres,
			verification_electrique_annuelle = :verification_electrique_annuelle,
			nom_organisme_verificateur = :nom_organisme_verificateur,
			controle_thermographie_infrarouge = :controle_thermographie_infrarouge,
			etude_resistance_vent_ombriere = :etude_resistance_vent_ombriere,
			date_mise_a_jour = CURRENT_TIMESTAMP
		WHERE DOID = :doid";

	try {
		$stmt = $pdo->prepare($sql);
		$res = $stmt->execute($params);
		require_once __DIR__ . '/../controllers/LogController.php';
		logQuery($doid, 'pv_prevention', $stmt->queryString, $params, $_SESSION['user_id'] ?? null, $res ? 'réussi' : 'échec');
		if ($res) {
			unset($_SESSION['update_error']);
		}
		return $res;
	} catch (PDOException $e) {
		error_log('[riobat] savePvPrevention failed for DOID=' . $doid . ' : ' . $e->getMessage());
		$_SESSION['update_error'] = $e->getMessage();
		return false;
	}
}

function savePvEnvironnement(int $doid, array $info): bool {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists('pv_environnement')) {
		$_SESSION['update_error'] = !$pdo ? 'Connexion PDO indisponible.' : ($doid <= 0 ? 'DOID invalide.' : 'La table pv_environnement est absente.');
		return false;
	}

	if (!ensurePvRow('pv_environnement', $doid)) {
		$_SESSION['update_error'] = 'Impossible de créer ou retrouver la ligne pv_environnement pour DOID=' . $doid . '.';
		return false;
	}

	$bool = function ($value): int {
		return ((string)$value === '1') ? 1 : 0;
	};

	$params = [
		':doid' => $doid,
		':mode_pose_panneaux' => in_array(($info['trav_annexes_pv_montage'] ?? ''), ['integration_bati', 'integration_simplifiee', 'ombriere', 'sol', 'autre'], true) ? $info['trav_annexes_pv_montage'] : null,
		':mode_pose_autres_precisions' => !empty($info['trav_annexes_pv_env_mode_pose_autres']) ? trim((string)$info['trav_annexes_pv_env_mode_pose_autres']) : null,
		':support_integration_combustible' => $bool($info['trav_annexes_pv_env_support_combustible'] ?? '0'),
		':nature_integration_systeme' => !empty($info['trav_annexes_pv_env_nature_integration']) ? trim((string)$info['trav_annexes_pv_env_nature_integration']) : null,
		':isolant_toiture_combustible' => $bool($info['trav_annexes_pv_env_isolant_combustible'] ?? '0'),
		':isolant_toiture_nature' => !empty($info['trav_annexes_pv_env_isolant_nature']) ? trim((string)$info['trav_annexes_pv_env_isolant_nature']) : null,
		':souscripteur_proprietaire_batiment' => $bool($info['trav_annexes_pv_env_souscripteur_proprietaire'] ?? '0'),
		':proprietaire_assureur_num_contrat' => !empty($info['trav_annexes_pv_env_proprietaire_assureur_contrat']) ? trim((string)$info['trav_annexes_pv_env_proprietaire_assureur_contrat']) : null,
		':bail_renonciation_recours_infos' => !empty($info['trav_annexes_pv_env_bail_renonciation']) ? trim((string)$info['trav_annexes_pv_env_bail_renonciation']) : null,
		':presence_locataires_batiment' => $bool($info['trav_annexes_pv_env_locataires'] ?? '0'),
		':locataires_details_baux_valeur_ca' => !empty($info['trav_annexes_pv_env_locataires_details']) ? trim((string)$info['trav_annexes_pv_env_locataires_details']) : null,
		':activites_batiment_moins_20m' => !empty($info['trav_annexes_pv_env_activites_20m']) ? trim((string)$info['trav_annexes_pv_env_activites_20m']) : null,
		':nature_chauffage_ou_sechage' => !empty($info['trav_annexes_pv_env_nature_chauffage_sechage']) ? trim((string)$info['trav_annexes_pv_env_nature_chauffage_sechage']) : null,
		':depot_marchandises_tiers_conventions' => !empty($info['trav_annexes_pv_env_depot_tiers_conventions']) ? trim((string)$info['trav_annexes_pv_env_depot_tiers_conventions']) : null,
		':stockage_matieres_combustibles' => $bool($info['trav_annexes_pv_env_stockage_combustibles'] ?? '0'),
		':stockage_combustibles_details' => !empty($info['trav_annexes_pv_env_stockage_combustibles_details']) ? trim((string)$info['trav_annexes_pv_env_stockage_combustibles_details']) : null,
		':site_cloture' => $bool($info['trav_annexes_pv_env_site_cloture'] ?? '0'),
		':site_cloture_nature_hauteur' => !empty($info['trav_annexes_pv_env_site_cloture_details']) ? trim((string)$info['trav_annexes_pv_env_site_cloture_details']) : null,
		':detection_intrusion_electronique' => $bool($info['trav_annexes_pv_env_detection_intrusion'] ?? '0'),
		':detection_intrusion_description_delai' => !empty($info['trav_annexes_pv_env_detection_intrusion_details']) ? trim((string)$info['trav_annexes_pv_env_detection_intrusion_details']) : null,
		':video_surveillance' => $bool($info['trav_annexes_pv_env_video_surveillance'] ?? '0'),
		':video_surveillance_24h_intervention' => $bool($info['trav_annexes_pv_env_video_24h'] ?? '0'),
		':site_gardienne' => $bool($info['trav_annexes_pv_env_site_gardienne'] ?? '0'),
		':etude_structure_risque_tempete' => $bool($info['trav_annexes_pv_env_etude_vent'] ?? '0'),
		':hypothese_vent_maxi' => !empty($info['trav_annexes_pv_env_hypothese_vent_maxi']) ? trim((string)$info['trav_annexes_pv_env_hypothese_vent_maxi']) : null,
		':etude_foudre_specialisee' => $bool($info['trav_annexes_pv_env_etude_foudre'] ?? '0'),
		':parafoudre_dc' => $bool($info['trav_annexes_pv_env_parafoudre_dc'] ?? '0'),
		':parafoudre_ac' => $bool($info['trav_annexes_pv_env_parafoudre_ac'] ?? '0'),
		':debroussaillage_regulier_20cm' => $bool($info['trav_annexes_pv_env_debroussaillage'] ?? '0'),
		':stock_hydrocarbure' => $bool($info['trav_annexes_pv_env_stock_hydrocarbure'] ?? '0'),
		':stock_meubles' => $bool($info['trav_annexes_pv_env_stock_meubles'] ?? '0'),
		':stock_textiles' => $bool($info['trav_annexes_pv_env_stock_textiles'] ?? '0'),
		':stock_bombe_aerosols' => $bool($info['trav_annexes_pv_env_stock_bombe_aerosols'] ?? '0'),
		':stock_explosifs' => $bool($info['trav_annexes_pv_env_stock_explosifs'] ?? '0'),
		':stock_papier' => $bool($info['trav_annexes_pv_env_stock_papier'] ?? '0'),
		':stock_bois' => $bool($info['trav_annexes_pv_env_stock_bois'] ?? '0'),
		':stock_fourrage' => $bool($info['trav_annexes_pv_env_stock_fourrage'] ?? '0'),
		':stock_engrais' => $bool($info['trav_annexes_pv_env_stock_engrais'] ?? '0'),
		':stock_cereales' => $bool($info['trav_annexes_pv_env_stock_cereales'] ?? '0'),
	];

	$sql = "UPDATE pv_environnement SET
			mode_pose_panneaux = :mode_pose_panneaux,
			mode_pose_autres_precisions = :mode_pose_autres_precisions,
			support_integration_combustible = :support_integration_combustible,
			nature_integration_systeme = :nature_integration_systeme,
			isolant_toiture_combustible = :isolant_toiture_combustible,
			isolant_toiture_nature = :isolant_toiture_nature,
			souscripteur_proprietaire_batiment = :souscripteur_proprietaire_batiment,
			proprietaire_assureur_num_contrat = :proprietaire_assureur_num_contrat,
			bail_renonciation_recours_infos = :bail_renonciation_recours_infos,
			presence_locataires_batiment = :presence_locataires_batiment,
			locataires_details_baux_valeur_ca = :locataires_details_baux_valeur_ca,
			activites_batiment_moins_20m = :activites_batiment_moins_20m,
			nature_chauffage_ou_sechage = :nature_chauffage_ou_sechage,
			depot_marchandises_tiers_conventions = :depot_marchandises_tiers_conventions,
			stockage_matieres_combustibles = :stockage_matieres_combustibles,
			stockage_combustibles_details = :stockage_combustibles_details,
			site_cloture = :site_cloture,
			site_cloture_nature_hauteur = :site_cloture_nature_hauteur,
			detection_intrusion_electronique = :detection_intrusion_electronique,
			detection_intrusion_description_delai = :detection_intrusion_description_delai,
			video_surveillance = :video_surveillance,
			video_surveillance_24h_intervention = :video_surveillance_24h_intervention,
			site_gardienne = :site_gardienne,
			etude_structure_risque_tempete = :etude_structure_risque_tempete,
			hypothese_vent_maxi = :hypothese_vent_maxi,
			etude_foudre_specialisee = :etude_foudre_specialisee,
			parafoudre_dc = :parafoudre_dc,
			parafoudre_ac = :parafoudre_ac,
			debroussaillage_regulier_20cm = :debroussaillage_regulier_20cm,
			stock_hydrocarbure = :stock_hydrocarbure,
			stock_meubles = :stock_meubles,
			stock_textiles = :stock_textiles,
			stock_bombe_aerosols = :stock_bombe_aerosols,
			stock_explosifs = :stock_explosifs,
			stock_papier = :stock_papier,
			stock_bois = :stock_bois,
			stock_fourrage = :stock_fourrage,
			stock_engrais = :stock_engrais,
			stock_cereales = :stock_cereales,
			date_mise_a_jour = CURRENT_TIMESTAMP
		WHERE DOID = :doid";

	try {
		$stmt = $pdo->prepare($sql);
		$res = $stmt->execute($params);
		require_once __DIR__ . '/../controllers/LogController.php';
		logQuery($doid, 'pv_environnement', $stmt->queryString, $params, $_SESSION['user_id'] ?? null, $res ? 'réussi' : 'échec');
		if ($res) {
			unset($_SESSION['update_error']);
		}
		return $res;
	} catch (PDOException $e) {
		error_log('[riobat] savePvEnvironnement failed for DOID=' . $doid . ' : ' . $e->getMessage());
		$_SESSION['update_error'] = $e->getMessage();
		return false;
	}
}

function getPvDescription(int $doid): array {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists('pv_description_centrale')) {
		return [];
	}

	$stmt = $pdo->prepare('SELECT * FROM pv_description_centrale WHERE DOID = :doid LIMIT 1');
	$stmt->execute([':doid' => $doid]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$row) return [];

	return [
		'pv_adresse' => $row['adresse_centrale'] ?? null,
		'pv_code_postal' => $row['code_postal'] ?? null,
		'pv_commune' => $row['commune'] ?? null,
		'pv_entreprise_pose_qualipv' => $row['entreprise_pose_qualipv'] ?? null,
		'pv_valeur_neuve_remplacement' => $row['valeur_neuve_remplacement'] ?? null,
		'pv_valeur_type' => $row['valeur_type'] ?? null,
		'pv_date_mise_en_service' => $row['date_mise_en_service'] ?? null,
		'pv_deja_assuree' => isset($row['deja_assuree']) ? (string)$row['deja_assuree'] : null,
		'pv_sinistre_deja' => isset($row['sinistre_deja']) ? (string)$row['sinistre_deja'] : null,
		'pv_sinistre_nature_montant' => $row['sinistre_nature_montant'] ?? null,
		'pv_surface_totale' => $row['surface_totale_m2'] ?? null,
		'pv_puissance_crete' => $row['puissance_crete_kwc'] ?? null,
		'pv_nature_panneaux' => $row['nature_panneaux'] ?? null,
		'pv_panneaux_details' => $row['panneaux_details'] ?? null,
		'pv_onduleurs_details' => $row['onduleurs_details'] ?? null,
		'pv_prix_vente_kwh' => $row['prix_vente_kwh'] ?? null,
		'pv_recettes_annuelles' => $row['recettes_previsionnelles_annuelles'] ?? null,
		'pv_destination_energie' => $row['destination_energie'] ?? null,
		'pv_economies_achat_annuelles' => $row['economies_achat_annuelles'] ?? null,
		'pv_batteries_existent' => isset($row['batteries_existent']) ? (string)$row['batteries_existent'] : null,
		'pv_batteries_details' => $row['batteries_details'] ?? null,
	];
}

function getMappedPvPrevention(int $doid): array {
	$row = getPvPrevention($doid);
	if (empty($row)) return [];

	return [
		'pv_prev_contrat_maintenance' => isset($row['contrat_maintenance_equipements']) ? (string)$row['contrat_maintenance_equipements'] : null,
		'pv_prev_monitoring' => isset($row['monitoring_production_continue']) ? (string)$row['monitoring_production_continue'] : null,
		'pv_prev_duree_garantie_onduleurs' => $row['duree_garantie_onduleurs'] ?? null,
		'pv_prev_local_coupe_feu' => isset($row['onduleurs_local_coupe_feu_2h']) ? (string)$row['onduleurs_local_coupe_feu_2h'] : null,
		'pv_prev_hauteur_mini_m' => $row['hauteur_implantation_min_m'] ?? null,
		'pv_prev_systeme_antivol' => isset($row['fixation_modules_antivol']) ? (string)$row['fixation_modules_antivol'] : null,
		'pv_prev_systeme_antivol_details' => $row['fixation_antivol_details'] ?? null,
		'pv_prev_incendie_extincteurs' => isset($row['incendie_extincteurs_mobiles']) ? (string)$row['incendie_extincteurs_mobiles'] : null,
		'pv_prev_incendie_poteaux' => isset($row['incendie_poteaux']) ? (string)$row['incendie_poteaux'] : null,
		'pv_prev_incendie_detection_auto' => isset($row['incendie_detection_automatique']) ? (string)$row['incendie_detection_automatique'] : null,
		'pv_prev_incendie_sprinkler' => isset($row['incendie_sprinkler']) ? (string)$row['incendie_sprinkler'] : null,
		'pv_prev_incendie_autres' => $row['incendie_autres'] ?? null,
		'pv_prev_verif_elec_annuelle' => isset($row['verification_electrique_annuelle']) ? (string)$row['verification_electrique_annuelle'] : null,
		'pv_prev_nom_organisme_verificateur' => $row['nom_organisme_verificateur'] ?? null,
		'pv_prev_thermo_infrarouge' => isset($row['controle_thermographie_infrarouge']) ? (string)$row['controle_thermographie_infrarouge'] : null,
		'pv_prev_etude_vent_ombriere' => isset($row['etude_resistance_vent_ombriere']) ? (string)$row['etude_resistance_vent_ombriere'] : null,
	];
}

function getMappedPvEnvironnement(int $doid): array {
	$row = getPvEnvironnement($doid);
	if (empty($row)) return [];

	return [
		'trav_annexes_pv_montage' => $row['mode_pose_panneaux'] ?? null,
		'trav_annexes_pv_env_mode_pose_autres' => $row['mode_pose_autres_precisions'] ?? null,
		'trav_annexes_pv_env_support_combustible' => isset($row['support_integration_combustible']) ? (string)$row['support_integration_combustible'] : null,
		'trav_annexes_pv_env_nature_integration' => $row['nature_integration_systeme'] ?? null,
		'trav_annexes_pv_env_isolant_combustible' => isset($row['isolant_toiture_combustible']) ? (string)$row['isolant_toiture_combustible'] : null,
		'trav_annexes_pv_env_isolant_nature' => $row['isolant_toiture_nature'] ?? null,
		'trav_annexes_pv_env_souscripteur_proprietaire' => isset($row['souscripteur_proprietaire_batiment']) ? (string)$row['souscripteur_proprietaire_batiment'] : null,
		'trav_annexes_pv_env_proprietaire_assureur_contrat' => $row['proprietaire_assureur_num_contrat'] ?? null,
		'trav_annexes_pv_env_bail_renonciation' => $row['bail_renonciation_recours_infos'] ?? null,
		'trav_annexes_pv_env_locataires' => isset($row['presence_locataires_batiment']) ? (string)$row['presence_locataires_batiment'] : null,
		'trav_annexes_pv_env_locataires_details' => $row['locataires_details_baux_valeur_ca'] ?? null,
		'trav_annexes_pv_env_activites_20m' => $row['activites_batiment_moins_20m'] ?? null,
		'trav_annexes_pv_env_nature_chauffage_sechage' => $row['nature_chauffage_ou_sechage'] ?? null,
		'trav_annexes_pv_env_depot_tiers_conventions' => $row['depot_marchandises_tiers_conventions'] ?? null,
		'trav_annexes_pv_env_stockage_combustibles' => isset($row['stockage_matieres_combustibles']) ? (string)$row['stockage_matieres_combustibles'] : null,
		'trav_annexes_pv_env_stockage_combustibles_details' => $row['stockage_combustibles_details'] ?? null,
		'trav_annexes_pv_env_site_cloture' => isset($row['site_cloture']) ? (string)$row['site_cloture'] : null,
		'trav_annexes_pv_env_site_cloture_details' => $row['site_cloture_nature_hauteur'] ?? null,
		'trav_annexes_pv_env_detection_intrusion' => isset($row['detection_intrusion_electronique']) ? (string)$row['detection_intrusion_electronique'] : null,
		'trav_annexes_pv_env_detection_intrusion_details' => $row['detection_intrusion_description_delai'] ?? null,
		'trav_annexes_pv_env_video_surveillance' => isset($row['video_surveillance']) ? (string)$row['video_surveillance'] : null,
		'trav_annexes_pv_env_video_24h' => isset($row['video_surveillance_24h_intervention']) ? (string)$row['video_surveillance_24h_intervention'] : null,
		'trav_annexes_pv_env_site_gardienne' => isset($row['site_gardienne']) ? (string)$row['site_gardienne'] : null,
		'trav_annexes_pv_env_etude_vent' => isset($row['etude_structure_risque_tempete']) ? (string)$row['etude_structure_risque_tempete'] : null,
		'trav_annexes_pv_env_hypothese_vent_maxi' => $row['hypothese_vent_maxi'] ?? null,
		'trav_annexes_pv_env_etude_foudre' => isset($row['etude_foudre_specialisee']) ? (string)$row['etude_foudre_specialisee'] : null,
		'trav_annexes_pv_env_parafoudre_dc' => isset($row['parafoudre_dc']) ? (string)$row['parafoudre_dc'] : null,
		'trav_annexes_pv_env_parafoudre_ac' => isset($row['parafoudre_ac']) ? (string)$row['parafoudre_ac'] : null,
		'trav_annexes_pv_env_debroussaillage' => isset($row['debroussaillage_regulier_20cm']) ? (string)$row['debroussaillage_regulier_20cm'] : null,
		'trav_annexes_pv_env_stock_hydrocarbure' => isset($row['stock_hydrocarbure']) ? (string)$row['stock_hydrocarbure'] : null,
		'trav_annexes_pv_env_stock_meubles' => isset($row['stock_meubles']) ? (string)$row['stock_meubles'] : null,
		'trav_annexes_pv_env_stock_textiles' => isset($row['stock_textiles']) ? (string)$row['stock_textiles'] : null,
		'trav_annexes_pv_env_stock_bombe_aerosols' => isset($row['stock_bombe_aerosols']) ? (string)$row['stock_bombe_aerosols'] : null,
		'trav_annexes_pv_env_stock_explosifs' => isset($row['stock_explosifs']) ? (string)$row['stock_explosifs'] : null,
		'trav_annexes_pv_env_stock_papier' => isset($row['stock_papier']) ? (string)$row['stock_papier'] : null,
		'trav_annexes_pv_env_stock_bois' => isset($row['stock_bois']) ? (string)$row['stock_bois'] : null,
		'trav_annexes_pv_env_stock_fourrage' => isset($row['stock_fourrage']) ? (string)$row['stock_fourrage'] : null,
		'trav_annexes_pv_env_stock_engrais' => isset($row['stock_engrais']) ? (string)$row['stock_engrais'] : null,
		'trav_annexes_pv_env_stock_cereales' => isset($row['stock_cereales']) ? (string)$row['stock_cereales'] : null,
	];
}

function getMappedPvProtection(int $doid): array {
	$row = getPvTableRow('pv_protection', $doid);
	if (empty($row)) return [];

	return [
		'respect_ute_c15712' => isset($row['respect_ute_c15712']) ? (string)$row['respect_ute_c15712'] : '0',
		'certificat_cofrac_securite_incendie' => isset($row['certificat_cofrac_securite_incendie']) ? (string)$row['certificat_cofrac_securite_incendie'] : '0',
		'verification_annuelle_qualifiquee' => isset($row['verification_annuelle_qualifiquee']) ? (string)$row['verification_annuelle_qualifiquee'] : '0',
		'maintenance_mise_en_place' => isset($row['maintenance_mise_en_place']) ? (string)$row['maintenance_mise_en_place'] : '0',
		'maintenance_entreprise_tierce' => isset($row['maintenance_entreprise_tierce']) ? (string)$row['maintenance_entreprise_tierce'] : '0',
		'procedure_remediation_defauts' => isset($row['procedure_remediation_defauts']) ? (string)$row['procedure_remediation_defauts'] : '0',
		'connecteurs_conformes_en50521' => isset($row['connecteurs_conformes_en50521']) ? (string)$row['connecteurs_conformes_en50521'] : '0',
		'boucles_induction' => isset($row['boucles_induction']) ? (string)$row['boucles_induction'] : '0',
		'thermographie_infrarouge_annuelle' => isset($row['thermographie_infrarouge_annuelle']) ? (string)$row['thermographie_infrarouge_annuelle'] : '0',
		'zone_graviers_5m_interieur_cloture' => isset($row['zone_graviers_5m_interieur_cloture']) ? (string)$row['zone_graviers_5m_interieur_cloture'] : '0',
		'protection_cables_rongeurs' => isset($row['protection_cables_rongeurs']) ? (string)$row['protection_cables_rongeurs'] : '0',
		'observations' => $row['observations'] ?? '',
	];
}

function getPvTableRow(string $table, int $doid): array {
	$pdo = $GLOBALS['pdo'] ?? null;
	if (!$pdo || $doid <= 0 || !pvTableExists($table)) {
		return [];
	}

	$stmt = $pdo->prepare("SELECT * FROM $table WHERE DOID = :doid LIMIT 1");
	$stmt->execute([':doid' => $doid]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row ?: [];
}

function getPvPrevention(int $doid): array {
	return getPvTableRow('pv_prevention', $doid);
}

function getPvEnvironnement(int $doid): array {
	return getPvTableRow('pv_environnement', $doid);
}

function getPvProtection(int $doid): array {
	return getPvTableRow('pv_protection', $doid);
}
