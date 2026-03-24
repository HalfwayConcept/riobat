<?php $_chk = $_chk ?? '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>'; ?>
<div>
    <div class="fiche-title">
        <span class="fiche-title-num">4</span>
        <h2>Informations diverses</h2>
    </div>
    <hr class="fiche-hr">

    <fieldset class="fiche-fieldset">
        <legend>Situation de l'ouvrage</legend>

        <?php if(isset($DATA['situation_zone_inond']) && $DATA['situation_zone_inond'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>L'ouvrage est situé en zone inondable</span></div>
        <?php endif; ?>

        <?php
            if(isset($DATA['situation_sismique'])){
                $sismLabels = ['1'=>'très faible','2'=>'faible','3'=>'modérée','4'=>'moyenne','5'=>'forte'];
                $sismVal = $sismLabels[$DATA['situation_sismique']] ?? null;
                if($sismVal){
                    echo '<div class="fiche-row"><span class="fiche-label">Zone de sismicité</span><span class="fiche-value">'.ucfirst($sismVal).'</span></div>';
                }
            }
        ?>

        <?php if(isset($DATA['situation_insectes']) && $DATA['situation_insectes'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Zone contaminée par les termites ou insectes xylophages</span></div>
        <?php endif; ?>

        <?php if(isset($DATA['situation_proc_tech']) && $DATA['situation_proc_tech'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Matériaux traditionnels ou procédés de technique courante</span></div>
        <?php endif; ?>

        <?php if(isset($DATA['situation_parking']) && $DATA['situation_parking'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Un parking dessert l'ouvrage</span></div>
        <?php endif; ?>

        <?php if(isset($DATA['situation_do_10ans']) && $DATA['situation_do_10ans'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Existants &lt; 10 ans avec contrat d'assurance dommages ouvrage</span></div>
            <?php if(!empty($DATA['situation_do_10ans_contrat_assureur'])): ?>
                <div class="fiche-row ml-6"><span class="fiche-label">Assureur</span><span class="fiche-value"><?=$DATA['situation_do_10ans_contrat_assureur']?></span></div>
            <?php endif; ?>
            <?php if(!empty($DATA['situation_do_10ans_contrat_numero'])): ?>
                <div class="fiche-row ml-6"><span class="fiche-label">N° de contrat</span><span class="fiche-value"><?=$DATA['situation_do_10ans_contrat_numero']?></span></div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(isset($DATA['situation_mon_hist']) && $DATA['situation_mon_hist'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Existants classés monuments historiques ou protection du patrimoine</span></div>
        <?php endif; ?>

        <?php if(isset($DATA['situation_label_energie']) && $DATA['situation_label_energie'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Label de performance énergétique</span></div>
        <?php endif; ?>

        <?php if(isset($DATA['situation_label_qualite']) && $DATA['situation_label_qualite'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Label de qualité environnementale</span></div>
        <?php endif; ?>
    </fieldset>

    <?php if(isset($DATA['sol']) && $DATA['sol'] == 1): ?>
    <fieldset class="fiche-fieldset">
        <legend>Étude de sol</legend>
        <?php echo viewEntreprise($DATA['sol_entreprise_id']); ?>
        <?php
            $missions = ['g2_amp'=>'AMP','g2_pro'=>'G2 PRO','etude_sol_autre'=>$DATA['sol_bureau_mission_champ'] ?? ''];
            if(isset($DATA['sol_bureau_mission']) && isset($missions[$DATA['sol_bureau_mission']])){
                echo '<div class="fiche-row"><span class="fiche-label">Mission</span><span class="fiche-value">'.$missions[$DATA['sol_bureau_mission']].'</span></div>';
            }
        ?>
        <?php if(isset($DATA['sol_parking']) && $DATA['sol_parking'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>L'étude de sol vise également le parking et/ou les voiries</span></div>
        <?php endif; ?>
    </fieldset>
    <?php endif; ?>

    <?php
    if((isset($DATA['situation_garanties_completes']) && $DATA['situation_garanties_completes'] == 1) || (isset($DATA['situation_garanties_dommages_existants']) && $DATA['situation_garanties_dommages_existants'] == 1)):
    ?>
    <fieldset class="fiche-fieldset">
        <legend>Garanties demandées</legend>
        <?php if(isset($DATA['situation_garanties_completes']) && $DATA['situation_garanties_completes'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Garanties complètes (CS n°811)</span></div>
        <?php endif; ?>
        <?php if(isset($DATA['situation_garanties_dommages_existants']) && $DATA['situation_garanties_dommages_existants'] == 1): ?>
            <div class="fiche-check"><?=$_chk?><span>Dommages matériels subis par les existants (CS n°811)</span></div>
        <?php endif; ?>
    </fieldset>
    <?php endif; ?>
</div>