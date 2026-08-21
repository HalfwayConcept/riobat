<?php $_chk = '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>'; ?>
<div class="fiche-title">
    <span class="fiche-title-num">3</span>
    <h2>Prévention</h2>
</div>
<hr class="fiche-hr">

<fieldset class="fiche-fieldset">
    <legend>Questionnaire prévention</legend>
    <?php
    $rows = [
        'contrat_maintenance_equipements' => 'Contrat de maintenance des équipements',
        'monitoring_production_continue' => 'Monitoring de la production en continu',
        'onduleurs_local_coupe_feu_2h' => 'Onduleurs en local coupe-feu 2h',
        'fixation_modules_antivol' => 'Fixation des modules avec système antivol',
        'incendie_extincteurs_mobiles' => 'Extincteurs mobiles',
        'incendie_poteaux' => 'Poteaux incendie',
        'incendie_detection_automatique' => 'Détection automatique incendie',
        'incendie_sprinkler' => 'Sprinkler',
        'verification_electrique_annuelle' => 'Vérification électrique annuelle',
        'controle_thermographie_infrarouge' => 'Contrôle thermographie infrarouge',
        'etude_resistance_vent_ombriere' => 'Étude résistance vent ombrière',
    ];
    foreach ($rows as $k => $label):
        if (($PV_PREVENTION[$k] ?? 0) == 1): ?>
            <div class="fiche-check"><?= $_chk ?><span><?= htmlspecialchars($label) ?></span></div>
        <?php endif;
    endforeach;
    ?>
    <div class="fiche-row"><span class="fiche-label">Durée garantie onduleurs</span><span class="fiche-value"><?= htmlspecialchars($PV_PREVENTION['duree_garantie_onduleurs'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Hauteur mini implantation (m)</span><span class="fiche-value"><?= htmlspecialchars((string)($PV_PREVENTION['hauteur_implantation_min_m'] ?? '')) ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Détail antivol</span><span class="fiche-value"><?= htmlspecialchars($PV_PREVENTION['fixation_antivol_details'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Autres moyens incendie</span><span class="fiche-value"><?= htmlspecialchars($PV_PREVENTION['incendie_autres'] ?? '') ?></span></div>
    <div class="fiche-row"><span class="fiche-label">Organisme vérificateur</span><span class="fiche-value"><?= htmlspecialchars($PV_PREVENTION['nom_organisme_verificateur'] ?? '') ?></span></div>
</fieldset>
