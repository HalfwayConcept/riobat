<?php $_chk = $_chk ?? '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>'; ?>

<div class="fiche-title">
    <span class="fiche-title-num">4b</span>
    <h2>Travaux annexes</h2>
</div>
<hr class="fiche-hr">

<?php
$_hasAnnexes = (!empty($DATA['situation_boi']) && $DATA['situation_boi'] == 1)
    || (!empty($DATA['situation_phv']) && $DATA['situation_phv'] == 1)
    || (!empty($DATA['situation_geo']) && $DATA['situation_geo'] == 1)
    || (!empty($DATA['situation_ctt']) && $DATA['situation_ctt'] == 1)
    || (!empty($DATA['situation_cnr']) && $DATA['situation_cnr'] == 1);
if(!$_hasAnnexes):
?>
<p style="color:#64748b; font-style:italic; padding:0.5rem 0;">Aucun travaux annexe</p>
<?php endif; ?>

<?php if(isset($DATA['situation_boi']) && $DATA['situation_boi'] == 1): ?>
<fieldset class="fiche-fieldset">
    <legend>Construction bois</legend>
    <?php if(!empty($DATA['boi_entreprise_id'])) echo viewEntreprise($DATA['boi_entreprise_id']); ?>
    <?php if(isset($DATA['trav_annexes_constr_bois']) && $DATA['trav_annexes_constr_bois'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Structure en bois (poteaux, poutres, voiles)</span></div>
    <?php endif; ?>
    <?php if(isset($DATA['trav_annexes_constr_bois_enveloppe']) && $DATA['trav_annexes_constr_bois_enveloppe'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Enveloppe en bois (façade, planchers, balcons)</span></div>
    <?php endif; ?>
    <?php if(isset($DATA['trav_annexes_constr_produits_ce']) && $DATA['trav_annexes_constr_produits_ce'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Produits avec marquage CE</span></div>
    <?php endif; ?>
</fieldset>
<?php endif; ?>

<?php if(isset($DATA['situation_phv']) && $DATA['situation_phv'] == 1): ?>
<fieldset class="fiche-fieldset">
    <legend>Photovoltaïque</legend>
    <?php echo viewEntreprise($DATA['phv_entreprise_id']); ?>
    <?php
        if(isset($DATA['trav_annexes_pv_montage'])){
            $pvLabels = ['integre'=>'Intégrés à la toiture','surimpose'=>'Surimposés à la toiture','autre'=>'Autre montage'];
            if(isset($pvLabels[$DATA['trav_annexes_pv_montage']])){
                echo '<div class="fiche-row"><span class="fiche-label">Montage des panneaux</span><span class="fiche-value">'.$pvLabels[$DATA['trav_annexes_pv_montage']].'</span></div>';
            }
        }
    ?>
    <?php if(isset($DATA['trav_annexes_pv_proc_tech']) && $DATA['trav_annexes_pv_proc_tech'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Procédés avec avis technique<?= (isset($DATA['trav_annexes_pv_etn']) && $DATA['trav_annexes_pv_etn'] == 1) ? ' + Enquête de Technique Nouvelle (ETN)' : '' ?></span></div>
    <?php endif; ?>
    <?php if(isset($DATA['trav_annexes_pv_liste_c2p']) && $DATA['trav_annexes_pv_liste_c2p'] == 1): ?>
        <div class="fiche-check"><?=$_chk?><span>Procédés sur la liste verte C2P</span></div>
    <?php endif; ?>
    <?php if(!empty($DATA['trav_annexes_pv_surface'])): ?>
        <div class="fiche-row"><span class="fiche-label">Surface de l'installation</span><span class="fiche-value"><?=$DATA['trav_annexes_pv_surface']?> m²</span></div>
    <?php endif; ?>
    <?php if(!empty($DATA['trav_annexes_pv_puissance'])): ?>
        <div class="fiche-row"><span class="fiche-label">Puissance</span><span class="fiche-value"><?=$DATA['trav_annexes_pv_puissance']?> kWc</span></div>
    <?php endif; ?>
    <?php
        if(isset($DATA['trav_annexes_pv_destination'])){
            $destLabels = ['revente'=>'Revente à un opérateur','autocons'=>'Autoconsommation'];
            if(isset($destLabels[$DATA['trav_annexes_pv_destination']])){
                echo '<div class="fiche-row"><span class="fiche-label">Destination de l\'électricité</span><span class="fiche-value">'.$destLabels[$DATA['trav_annexes_pv_destination']].'</span></div>';
            }
        }
    ?>
</fieldset>
<?php endif; ?>

<?php if(isset($DATA['situation_geo']) && $DATA['situation_geo'] == 1): ?>
<fieldset class="fiche-fieldset">
    <legend>Géothermie</legend>
    <?php echo viewEntreprise($DATA['geo_entreprise_id']); ?>
</fieldset>
<?php endif; ?>

<?php if(isset($DATA['situation_ctt']) && $DATA['situation_ctt'] == 1): ?>
<fieldset class="fiche-fieldset">
    <legend>Contrôle technique</legend>
    <?php echo viewEntreprise($DATA['ctt_entreprise_id']); ?>
    <?php
        if(isset($DATA['trav_annexes_ct_type_controle'])){
            $types = is_array($DATA['trav_annexes_ct_type_controle']) ? $DATA['trav_annexes_ct_type_controle'] : explode(',', $DATA['trav_annexes_ct_type_controle']);
            $labels = ['le' => 'LE', 'th' => 'TH'];
            $out = [];
            foreach ($types as $t) {
                $t = trim($t);
                if ($t === 'autres' && !empty($DATA['trav_annexes_ct_type_controle_autres'])) {
                    $out[] = 'Autres : '.htmlspecialchars($DATA['trav_annexes_ct_type_controle_autres']);
                } elseif (isset($labels[$t])) {
                    $out[] = $labels[$t];
                }
            }
            if(!empty($out)){
                echo '<div class="fiche-row"><span class="fiche-label">Type de contrôle</span><span class="fiche-value">'.implode(' + ', $out).'</span></div>';
            }
        }
    ?>
</fieldset>
<?php endif; ?>

<?php if(isset($DATA['situation_cnr']) && $DATA['situation_cnr'] == 1): ?>
<fieldset class="fiche-fieldset">
    <legend>Constructeur non réalisateur</legend>
    <?php echo viewEntreprise($DATA['cnr_entreprise_id']); ?>
</fieldset>
<?php endif; ?>
