<?php $_chk = '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>'; ?>
<div class="fiche-title">
    <span class="fiche-title-num">5</span>
    <h2>Protection et Garanties</h2>
</div>
<hr class="fiche-hr">

<fieldset class="fiche-fieldset">
    <legend>Protection</legend>
    <?php
    $rows = [
        'respect_ute_c15712' => 'Installations conformes UTE C15-712',
        'certificat_cofrac_securite_incendie' => 'Certificat COFRAC sécurité incendie',
        'verification_annuelle_qualifiee' => 'Vérification annuelle qualifiée',
        'maintenance_mise_en_place' => 'Maintenance mise en place',
        'maintenance_entreprise_tierce' => 'Maintenance par entreprise tierce',
        'procedure_remediation_defauts' => 'Procédure de remédiation des défauts',
        'connecteurs_conformes_en50521' => 'Connecteurs conformes EN 50521',
        'boucles_induction' => 'Boucles d\'induction',
        'thermographie_infrarouge_annuelle' => 'Thermographie infrarouge annuelle',
        'zone_graviers_5m_interieur_cloture' => 'Zone graviers 5m intérieur clôture',
        'protection_cables_rongeurs' => 'Protection des câbles contre rongeurs',
    ];
    foreach ($rows as $k => $label):
        if (($PV_PROTECTION[$k] ?? 0) == 1): ?>
            <div class="fiche-check"><?= $_chk ?><span><?= htmlspecialchars($label) ?></span></div>
        <?php endif;
    endforeach;
    ?>
    <div class="fiche-row"><span class="fiche-label">Observations</span><span class="fiche-value"><?= htmlspecialchars($PV_PROTECTION['observations'] ?? '') ?></span></div>
</fieldset>

<fieldset class="fiche-fieldset">
    <legend>Garanties demandées</legend>
    <?php if (isset($DATA['garantie_do']) && (int)$DATA['garantie_do'] === 1): ?>
        <div class="fiche-check"><?= $_chk ?><span>Dommages</span></div>
    <?php endif; ?>
    <?php if (isset($DATA['garantie_chantier']) && (int)$DATA['garantie_chantier'] === 1): ?>
        <div class="fiche-check"><?= $_chk ?><span>Pertes financières</span></div>
    <?php endif; ?>
    <?php if (isset($DATA['garantie_juridique']) && (int)$DATA['garantie_juridique'] === 1): ?>
        <div class="fiche-check"><?= $_chk ?><span>Responsabilité civile</span></div>
    <?php endif; ?>
</fieldset>
