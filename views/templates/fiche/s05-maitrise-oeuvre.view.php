<?php $_chk = $_chk ?? '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>'; ?>

<div class="fiche-title">
    <span class="fiche-title-num">5</span>
    <h2>Maîtrise d'œuvre et Garanties</h2>
</div>
<hr class="fiche-hr">

<fieldset class="fiche-fieldset">
    <legend>Architecte / Maître d'œuvre</legend>
    <?php
    if(isset($DATA['moe']) && $DATA['moe'] == 0){
        echo '<div class="fiche-check">'.$_chk.'<span>Aucun architecte ou maître d\'œuvre n\'intervient</span></div>';
    }
    elseif(isset($DATA['moe']) && $DATA['moe'] == 1){
        echo viewEntreprise($DATA['moe_entreprise_id']);

        if(isset($DATA['moe_intervention_independant']) && $DATA['moe_intervention_independant'] == 1){
            echo '<div class="fiche-check">'.$_chk.'<span>Indépendant à l\'égard des autres constructeurs et du maître d\'ouvrage</span></div>';
        }
        elseif(isset($DATA['moe_intervention_independant']) && $DATA['moe_intervention_independant'] == 0){
            if(isset($DATA['moe_intervention_independant_qualite'])){
                echo '<div class="fiche-row"><span class="fiche-label">Qualité et fonction</span><span class="fiche-value">'.$DATA['moe_intervention_independant_qualite'].'</span></div>';
            }
            if(isset($DATA['moe_intervention_independant_mission'])){
                $missionLabels = ['conception'=>'Conception','direction'=>'Direction et surveillance des travaux','complete'=>'Mission complète','autre'=>'Autre : '.($DATA['moe_intervention_independant_autre_descr'] ?? '')];
                $missionVal = $missionLabels[$DATA['moe_intervention_independant_mission']] ?? '';
                echo '<div class="fiche-row"><span class="fiche-label">Mission</span><span class="fiche-value">'.$missionVal.'</span></div>';
            }
        }
    }
    ?>
</fieldset>

<fieldset class="fiche-fieldset">
    <legend>Garanties demandées</legend>
    <?php if(isset($DATA['garantie_do']) && $DATA['garantie_do'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Dommage Ouvrage</span></div>
    <?php endif; ?>
    <?php if(isset($DATA['garantie_cnr']) && $DATA['garantie_cnr'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Responsabilité du Constructeur Non Réalisateur</span></div>
    <?php endif; ?>
    <?php if(isset($DATA['garantie_chantier']) && $DATA['garantie_chantier'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Tous risques chantier</span></div>
    <?php endif; ?>
    <?php if(isset($DATA['garantie_juridique']) && $DATA['garantie_juridique'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Protection juridique</span></div>
    <?php endif; ?>
</fieldset>