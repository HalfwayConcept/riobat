<div class="fiche-title">
    <span class="fiche-title-num">2</span>
    <h2>Centrale photovoltaique - Description</h2>
</div>
<hr class="fiche-hr">

<fieldset class="fiche-fieldset">
    <legend>Informations générales</legend>
    <div class="fiche-row"><span class="fiche-label">Adresse</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_adresse'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Code postal</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_code_postal'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Commune</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_commune'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Entreprise de pose / qualification</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_entreprise_pose_qualipv'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Valeur à neuf</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_DESCRIPTION['pv_valeur_neuve_remplacement'] ?? '')) ?> <?= htmlspecialchars((string)($PV_DESCRIPTION['pv_valeur_type'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Date de mise en service</span><span class="fiche-value"><?= !empty($PV_DESCRIPTION['pv_date_mise_en_service']) ? dateFormat($PV_DESCRIPTION['pv_date_mise_en_service']) : '' ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Déjà assurée</span><span class="fiche-value"><?= (($PV_DESCRIPTION['pv_deja_assuree'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Sinistre déjà survenu</span><span class="fiche-value"><?= (($PV_DESCRIPTION['pv_sinistre_deja'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Nature / montant du sinistre</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_sinistre_nature_montant'] ?? '') ?></span></div>
</fieldset>

<fieldset class="fiche-fieldset">
    <legend>Caractéristiques techniques</legend>
    <div class="fiche-row"><span class="fiche-label">Surface totale (m2)</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_DESCRIPTION['pv_surface_totale'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Puissance crête (kWc)</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_DESCRIPTION['pv_puissance_crete'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Nature des panneaux</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_nature_panneaux'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Détail panneaux</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_panneaux_details'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Détail onduleurs</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_onduleurs_details'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Prix vente kWh</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_DESCRIPTION['pv_prix_vente_kwh'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Recettes annuelles</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_DESCRIPTION['pv_recettes_annuelles'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Destination énergie</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_destination_energie'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Économies annuelles</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_DESCRIPTION['pv_economies_achat_annuelles'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Batteries</span><span class="fiche-value"><?= (($PV_DESCRIPTION['pv_batteries_existent'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Détail batteries</span><span class="fiche-value"><?= htmlspecialchars($PV_DESCRIPTION['pv_batteries_details'] ?? '') ?></span></div>
</fieldset>
