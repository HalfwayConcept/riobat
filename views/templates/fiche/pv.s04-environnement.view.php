<div class="fiche-title">
    <span class="fiche-title-num">4</span>
    <h2>Environnement</h2>
</div>
<hr class="fiche-hr">

<fieldset class="fiche-fieldset">
    <legend>Données environnement</legend>
    <?php
    $checkIcon = '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>';
    $textRows = [
        'mode_pose_panneaux' => 'Mode de pose',
        'mode_pose_autres_precisions' => 'Précisions mode de pose',
        'nature_integration_systeme' => 'Nature intégration système',
        'isolant_toiture_nature' => 'Nature isolant toiture',
        'proprietaire_assureur_num_contrat' => 'Assureur / contrat propriétaire',
        'bail_renonciation_recours_infos' => 'Bail / renonciation',
        'locataires_details_baux_valeur_ca' => 'Détails locataires',
        'activites_batiment_moins_20m' => 'Activités à moins de 20m',
        'nature_chauffage_ou_sechage' => 'Nature chauffage / séchage',
        'depot_marchandises_tiers_conventions' => 'Conventions dépôt marchandises tiers',
        'stockage_combustibles_details' => 'Détails stockage combustibles',
        'site_cloture_nature_hauteur' => 'Nature / hauteur clôture',
        'detection_intrusion_description_delai' => 'Description intrusion / délai',
        'hypothese_vent_maxi' => 'Hypothèse vent maxi',
    ];
    foreach ($textRows as $key => $label):
        $value = trim((string)($PV_ENVIRONNEMENT[$key] ?? ''));
        if ($value !== ''): ?>
            <div class="fiche-row"><span class="fiche-label"><?= htmlspecialchars($label) ?></span><span class="fiche-value"><?= htmlspecialchars($value) ?></span></div>
        <?php endif;
    endforeach;

    $boolRows = [
        'support_integration_combustible' => 'Support d\'intégration combustible',
        'isolant_toiture_combustible' => 'Isolant toiture combustible',
        'souscripteur_proprietaire_batiment' => 'Souscripteur propriétaire bâtiment',
        'presence_locataires_batiment' => 'Présence de locataires',
        'stockage_matieres_combustibles' => 'Stockage de matières combustibles',
        'site_cloture' => 'Site clôturé',
        'detection_intrusion_electronique' => 'Détection intrusion électronique',
        'video_surveillance' => 'Vidéosurveillance',
        'video_surveillance_24h_intervention' => 'Vidéosurveillance 24h avec intervention',
        'site_gardienne' => 'Site gardienné',
        'etude_structure_risque_tempete' => 'Étude structure risque tempête',
        'etude_foudre_specialisee' => 'Étude foudre spécialisée',
        'parafoudre_dc' => 'Parafoudre DC',
        'parafoudre_ac' => 'Parafoudre AC',
        'debroussaillage_regulier_20cm' => 'Débroussaillage régulier',
    ];
    foreach ($boolRows as $key => $label):
        if (($PV_ENVIRONNEMENT[$key] ?? 0) == 1): ?>
            <div class="fiche-check"><?= $checkIcon ?><span><?= htmlspecialchars($label) ?></span></div>
        <?php endif;
    endforeach;

    $storedMaterials = [
        'stock_hydrocarbure' => 'Hydrocarbures',
        'stock_meubles' => 'Meubles',
        'stock_textiles' => 'Textiles',
        'stock_bombe_aerosols' => 'Bombes aérosols',
        'stock_explosifs' => 'Explosifs',
        'stock_papier' => 'Papier',
        'stock_bois' => 'Bois',
        'stock_fourrage' => 'Fourrage',
        'stock_engrais' => 'Engrais',
        'stock_cereales' => 'Céréales',
    ];
    $selectedMaterials = [];
    foreach ($storedMaterials as $key => $label) {
        if (($PV_ENVIRONNEMENT[$key] ?? 0) == 1) {
            $selectedMaterials[] = $label;
        }
    }
    if (!empty($selectedMaterials)): ?>
        <div class="fiche-row"><span class="fiche-label">Stockage des matières</span><span class="fiche-value"><?= htmlspecialchars(implode(', ', $selectedMaterials)) ?></span></div>
    <?php endif;
    ?>
</fieldset>
