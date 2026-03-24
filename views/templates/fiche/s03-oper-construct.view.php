
<?php
// Helper for check icon SVG (reused in this template)
$_chk = '<svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>';
?>
<div>
    <div class="fiche-title">
        <span class="fiche-title-num">3</span>
        <h2>Opération de construction</h2>
    </div>
    <hr class="fiche-hr">

    <div class="grid md:grid-cols-2 grid-cols-1 gap-4 items-start">
    <div>
    <fieldset class="fiche-fieldset">
        <legend>Nature et type de l'ouvrage</legend>

        <!-- Nature de l'opération -->
        <?php 
        if(isset($DATA['nature_neuf_exist']) && $DATA['nature_neuf_exist'] == "neuve"){
            echo '<div class="fiche-row"><span class="fiche-label">Nature de l\'opération</span><span class="fiche-value">'.$_chk.' Construction neuve</span></div>';
        }elseif(isset($DATA['nature_neuf_exist']) && $DATA['nature_neuf_exist'] == "existante"){
            echo '<div class="fiche-row"><span class="fiche-label">Nature de l\'opération</span><span class="fiche-value">'.$_chk.' Travaux sur construction existante</span></div>';

            if(isset($DATA['nature_operation_surelev']) && $DATA['nature_operation_surelev'] == 1){
                echo '<p class="fiche-sub ml-4">Surélévation</p>';
                if(isset($DATA['nature_operation_surelev_sous_oeuvre']) && $DATA['nature_operation_surelev_sous_oeuvre'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Reprise en sous-œuvre / Travaux sur fondation</span></div>';
                }
                if(isset($DATA['nature_operation_surelev_hors_fond']) && $DATA['nature_operation_surelev_hors_fond'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Intervention sur la structure existante (hors fondation)</span></div>';
                }
            }
            
            if(isset($DATA['nature_operation_ext_horizont']) && $DATA['nature_operation_ext_horizont'] == 1){
                echo '<p class="fiche-sub ml-4">Extension horizontale</p>';
                if(isset($DATA['nature_operation_ext_horizont_exist']) && $DATA['nature_operation_ext_horizont_exist'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Intervention sur la structure existante y compris la fondation</span></div>';
                }
            }

            if(isset($DATA['nature_operation_renovation']) && $DATA['nature_operation_renovation'] == 1){
                echo '<p class="fiche-sub ml-4">Rénovation</p>';
                if(isset($DATA['nature_operation_renovation_fond']) && $DATA['nature_operation_renovation_fond'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Intervention sur la structure existante y compris la fondation</span></div>';
                }
                if(isset($DATA['nature_operation_renovation_iso_therm']) && $DATA['nature_operation_renovation_iso_therm'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Isolation thermique extérieure</span></div>';
                }
                if(isset($DATA['nature_operation_renovation_refect_toit']) && $DATA['nature_operation_renovation_refect_toit'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Réfection de toiture</span></div>';
                }
                if(isset($DATA['nature_operation_renovation_etancheite']) && $DATA['nature_operation_renovation_etancheite'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Travaux d\'étanchéité</span></div>';
                }
                if(isset($DATA['nature_operation_renovation_ravalement']) && $DATA['nature_operation_renovation_ravalement'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Ravalement de façade</span></div>';
                }
            }

            if(isset($DATA['nature_operation_rehabilitation']) && $DATA['nature_operation_rehabilitation'] == 1){
                echo '<p class="fiche-sub ml-4">Réhabilitation</p>';
                if(isset($DATA['nature_operation_rehabilitation_fond']) && $DATA['nature_operation_rehabilitation_fond'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Intervention sur la structure existante y compris la fondation</span></div>';
                }
                if(isset($DATA['nature_operation_rehabilitation_iso_therm']) && $DATA['nature_operation_rehabilitation_iso_therm'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Isolation thermique extérieure</span></div>';
                }
                if(isset($DATA['nature_operation_rehabilitation_refect_toit']) && $DATA['nature_operation_rehabilitation_refect_toit'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Réfection de toiture</span></div>';
                }
                if(isset($DATA['nature_operation_rehabilitation_etancheite']) && $DATA['nature_operation_rehabilitation_etancheite'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Travaux d\'étanchéité</span></div>';
                }
                if(isset($DATA['nature_operation_rehabilitation_ravalement']) && $DATA['nature_operation_rehabilitation_ravalement'] == 1){
                    echo '<div class="fiche-check ml-8">'.$_chk.'<span>Ravalement de façade</span></div>';
                }
            }

            if(isset($DATA['operation_sinistre']) && $DATA['operation_sinistre'] == 1){
                echo '<div class="fiche-row ml-4"><span class="fiche-label">Réparation suite à sinistre</span><span class="fiche-value">'.$DATA['operation_sinistre_descr'].'</span></div>';
            }
        }
        ?>

        <!-- Type de l'ouvrage -->
        <?php
        $_typeItems = [];
        if(isset($DATA['type_ouvrage_mais_indiv']) && $DATA['type_ouvrage_mais_indiv'] == 1){
            $txt = 'Maison individuelle';
            if(isset($DATA['type_ouvrage_mais_indiv_piscine']) && $DATA['type_ouvrage_mais_indiv_piscine'] == 1){
                $txt .= ' — piscine ('.$DATA['type_ouvrage_mais_indiv_piscine_situation'].')';
            }
            $_typeItems[] = $txt;
        }
        if(isset($DATA['type_ouvrage_ope_pavill']) && $DATA['type_ouvrage_ope_pavill'] == 1)
            $_typeItems[] = 'Opération pavillonnaire : '.$DATA['type_ouvrage_ope_pavill_nombre'].' maisons';
        if(isset($DATA['type_ouvrage_coll_habit']) && $DATA['type_ouvrage_coll_habit'] == 1)
            $_typeItems[] = 'Collectif d\'habitation : '.$DATA['type_ouvrage_coll_habit_nombre'].' appartements';
        if(isset($DATA['type_ouvrage_bat_indus']) && $DATA['type_ouvrage_bat_indus'] == 1)
            $_typeItems[] = 'Bâtiment à usage industriel ou agricole';
        if(isset($DATA['type_ouvrage_centre_com']) && $DATA['type_ouvrage_centre_com'] == 1)
            $_typeItems[] = 'Centre commercial : '.$DATA['type_ouvrage_centre_com_surf'].' m²';
        if(isset($DATA['type_ouvrage_bat_bur']) && $DATA['type_ouvrage_bat_bur'] == 1)
            $_typeItems[] = 'Bâtiment à usage de bureau';
        if(isset($DATA['type_ouvrage_hopital']) && $DATA['type_ouvrage_hopital'] == 1)
            $_typeItems[] = 'Établissement hospitalier, maison de retraite, clinique';
        if(isset($DATA['type_ouvrage_vrd_privatif']) && $DATA['type_ouvrage_vrd_privatif'] == 1)
            $_typeItems[] = 'VRD à usage privatif';
        if(isset($DATA['type_ouvrage_autre_const']) && $DATA['type_ouvrage_autre_const'] == 1)
            $_typeItems[] = 'Autre : '.$DATA['type_ouvrage_autre_const_usage'];
        if(!empty($_typeItems)){
            echo '<div class="fiche-row"><span class="fiche-label">Type de l\'ouvrage</span><span class="fiche-value">'.$_chk.' '.implode(', ', $_typeItems).'</span></div>';
        }
        ?>

    </fieldset>
    <fieldset class="fiche-fieldset">
        <legend><svg style="display:inline; width:1rem; height:1rem; vertical-align:-2px; margin-right:4px; color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>Coût de l'opération</legend>
        <div class="fiche-row">
            <span class="fiche-label">Coût en €</span>
            <span class="fiche-value"><?= $DATA['construction_cout_operation'] ?? '' ?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Honoraires maître d'œuvre en €</span>
            <span class="fiche-value"><?= $DATA['construction_cout_honoraires_moe'] ?? '' ?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">TVA</span>
            <span class="fiche-value"><?= (isset($DATA['cout_operation_tva']) && $DATA['cout_operation_tva'] == 1) ? 'Comprise' : 'Non comprise' ?></span>
        </div>
    </fieldset>
    </div>
    <div>
    <fieldset class="fiche-fieldset">
        <legend><svg style="display:inline; width:1rem; height:1rem; vertical-align:-2px; margin-right:4px; color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>Adresse de la construction</legend>
        <div class="fiche-row">
            <span class="fiche-label">Adresse</span>
            <span class="fiche-value">
                <?php
                    $parts = [];
                    if(!empty($DATA['construction_adresse'])) $parts[] = $DATA['construction_adresse'];
                    if(!empty($DATA['construction_adresse_esc_res_bat'])) $parts[] = $DATA['construction_adresse_esc_res_bat'];
                    if(!empty($DATA['construction_adresse_lieu_dit'])) $parts[] = $DATA['construction_adresse_lieu_dit'];
                    if(!empty($DATA['construction_adresse_arrond'])) $parts[] = $DATA['construction_adresse_arrond'].'e arrondissement';
                    echo implode(', ', $parts);
                ?>
            </span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Code postal / Commune</span>
            <span class="fiche-value"><?= ($DATA['construction_adresse_code_postal'] ?? '') . ' ' . ($DATA['construction_adresse_commune'] ?? '') ?></span>
        </div>
    </fieldset>
    <fieldset class="fiche-fieldset">
        <legend><svg style="display:inline; width:1rem; height:1rem; vertical-align:-2px; margin-right:4px; color:#2563eb;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>Dates des travaux</legend>
        <div class="fiche-row">
            <span class="fiche-label">Date d'ouverture de chantier</span>
            <span class="fiche-value"><?= isset($DATA['construction_date_debut']) ? dateFormat($DATA['construction_date_debut']) : '' ?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Date prévue d'ouverture</span>
            <span class="fiche-value"><?= isset($DATA['construction_date_debut_prevue']) ? dateFormat($DATA['construction_date_debut_prevue']) : '' ?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Date de réception prévisionnelle</span>
            <span class="fiche-value"><?= isset($DATA['construction_date_reception']) ? dateFormat($DATA['construction_date_reception']) : '' ?></span>
        </div>
    </fieldset>
    </div>
    </div><!-- /grid -->
</div>



