<div class="fiche-title">
    <span class="fiche-title-num">4</span>
    <h2>Environnement</h2>
</div>
<hr class="fiche-hr">

<fieldset class="fiche-fieldset">
    <legend>Données environnement</legend>
    <div class="fiche-row"><span class="fiche-label">Mode de pose</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['mode_pose_panneaux'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Précisions mode de pose</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['mode_pose_autres_precisions'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Nature intégration système</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['nature_integration_systeme'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Nature isolant toiture</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['isolant_toiture_nature'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Assureur / contrat propriétaire</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['proprietaire_assureur_num_contrat'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Bail / renonciation</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['bail_renonciation_recours_infos'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Détails locataires</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['locataires_details_baux_valeur_ca'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Activités à moins de 20m</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['activites_batiment_moins_20m'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Nature chauffage / séchage</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['nature_chauffage_ou_sechage'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Conventions dépôt marchandises tiers</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['depot_marchandises_tiers_conventions'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Détails stockage combustibles</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['stockage_combustibles_details'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Nature / hauteur clôture</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['site_cloture_nature_hauteur'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Description intrusion / délai</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['detection_intrusion_description_delai'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Hypothèse vent maxi</span><span class="fiche-value"><?= htmlspecialchars($PV_ENVIRONNEMENT['hypothese_vent_maxi'] ?? '') ?></span></div>

    <?php
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
        'stock_hydrocarbure' => 'Stock hydrocarbure',
        'stock_meubles' => 'Stock meubles',
        'stock_textiles' => 'Stock textiles',
        'stock_bombe_aerosols' => 'Stock bombes aérosols',
        'stock_explosifs' => 'Stock explosifs',
        'stock_papier' => 'Stock papier',
        'stock_bois' => 'Stock bois',
        'stock_fourrage' => 'Stock fourrage',
        'stock_engrais' => 'Stock engrais',
        'stock_cereales' => 'Stock céréales',
    ];
    foreach ($boolRows as $k => $label): ?>
        <div class="fiche-row">
            <span class="fiche-label"><?= htmlspecialchars($label) ?></span>
            <span class="fiche-value"><?= (($PV_ENVIRONNEMENT[$k] ?? 0) == 1) ? 'Oui' : 'Non' ?></span>
        </div>
    <?php endforeach; ?>
</fieldset>
