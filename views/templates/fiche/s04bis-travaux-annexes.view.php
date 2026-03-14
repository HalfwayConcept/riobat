<!-- Travaux annexes -->
<div class="flex items-center gap-3 mb-2 mt-6">
    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8" />
    </svg>
    <h2 class="text-xl font-bold text-gray-800">Travaux annexes</h2>
</div>
<hr class="mb-4 border-blue-200">
    <?php 
    if(isset($DATA['situation_boi']) && $DATA['situation_boi'] == 1):
    ?>
    <div id="situation_boi">
        <?php 
            if(!empty($DATA['boi_entreprise_id'])){
                    echo viewEntreprise($DATA['boi_entreprise_id']);
            }
        ?>        
            <?php 
                if(isset($DATA['trav_annexes_constr_bois']) && $DATA['trav_annexes_constr_bois'] == 1){
                    echo "<strong>La structure de la construction (poteaux, poutres et voiles) est en bois</strong>";
                    }
            ?>
            <?php 
                if(isset($DATA['trav_annexes_constr_bois_enveloppe']) && $DATA['trav_annexes_constr_bois_enveloppe'] == 1){
                    echo "<strong>L'enveloppe de la construction (façade, planchers et balcons) est en bois</strong>";
                }
            ?>
            <?php 
                if(isset($DATA['trav_annexes_constr_produits_ce']) && $DATA['trav_annexes_constr_produits_ce'] == 1){
                    echo "<strong>Les produits utilisés bénéficient d'un marquage CE</strong>";
                }
            ?>
                    </fieldset>
                </div>

    </div>
    <?php 
    endif; //fin bois

    if(isset($DATA['situation_phv']) && $DATA['situation_phv'] == 1):
    ?>
    <div id="situation_phv">
        <?php 
            echo viewEntreprise($DATA['phv_entreprise_id']);
            ?>
            <?php 
            if(isset($DATA['trav_annexes_pv_montage'])){
                switch ($DATA['trav_annexes_pv_montage']){
                    case 'integre':
                        echo "<strong>Les panneaux photovoltaïques sont intégrés à la toiture</strong>";
                        break;
                    case 'surimpose':
                        echo "<strong>Les panneaux photovoltaïques sont surimposés à la toiture</strong>";
                        break;
                    case 'autre':
                        echo "<strong>Les panneaux photovoltaïques ne sont ni intégrés ni surimposés à la toiture</strong>";
                        break;
                }
            }
            ?>

            <?php 
                if(isset($DATA['trav_annexes_pv_proc_tech']) && $DATA['trav_annexes_pv_proc_tech'] == 1){
                    echo "<strong>Les procédés mis en oeuvre bénéficient d'un avis technique</strong>";
                        if(isset($DATA['trav_annexes_pv_etn']) && $DATA['trav_annexes_pv_etn'] == 1){
                            echo "<strong> et ils sont visés par une Enquête de Technique Nouvelle (ETN)</strong>";
                        }
                }
            ?>

            <?php 
                if(isset($DATA['trav_annexes_pv_liste_c2p']) && $DATA['trav_annexes_pv_liste_c2p'] == 1){
                    echo "<strong>Les procédés figurent sur la liste verte C2P</strong>";
                }
            ?>
            <div class='ml-6'><?=isset($DATA['trav_annexes_pv_surface']) ? "<strong>La surface de l'installation est de ".$DATA['trav_annexes_pv_surface']." m²</strong>" : "";?></div>
            <div class='ml-6'><?=isset($DATA['trav_annexes_pv_puissance']) ? "<strong>La puissance de l'installation est de ".$DATA['trav_annexes_pv_puissance']." kWc</strong>" : "";?></div>

            <?php 
            if(isset($DATA['trav_annexes_pv_destination'])){
                if($DATA['trav_annexes_pv_destination'] == "revente"){
                    echo "<strong>L'électricité produite par l'intallation photovoltaïque est destinée à la revente à un opérateur dans le domaine de l'énergie</strong>";
                }elseif($DATA['trav_annexes_pv_destination'] == "autocons"){
                    echo "<strong>L'électricité produite par l'intallation photovoltaïque est destinée à l'autoconsommation</strong>";
                }
            }
            ?>        
                </fieldset>
            </div>
    <?php 
    endif;

    if(isset($DATA['situation_geo']) && $DATA['situation_geo'] == 1):
    ?>
    <div id="situation_geo">
        <?php
            if(isset($DATA['situation_geo']) && $DATA['situation_geo'] == 1){

                    echo viewEntreprise($DATA['geo_entreprise_id']);
                }else{
                    echo "<strong>Pas d'installation géothermique</strong>";
                }
        ?>
                    </fieldset>
        </div>
    </div>
    <?php 
    endif;

    if(isset($DATA['situation_ctt']) && $DATA['situation_ctt'] == 1):
    ?>
            <div id="situation_ctt">
                <div class="mt-10">
                    <?php
                        echo viewEntreprise($DATA['ctt_entreprise_id']);
                    ?>
                        <div class="mt-10 ml-2">
                            <?php
                                if(isset($DATA['trav_annexes_ct_type_controle'])){
                                    echo "<div class='flex flex-row'><h3>Type de contrôle :</h3><div class='flex flex-row ml-2'>";
                                    $types = array();
                                    if (!empty($DATA['trav_annexes_ct_type_controle'])) {
                                        // Peut être une chaîne (ex: "le,th") ou un tableau
                                        $types = is_array($DATA['trav_annexes_ct_type_controle']) ? $DATA['trav_annexes_ct_type_controle'] : explode(',', $DATA['trav_annexes_ct_type_controle']);
                                    }
                                    $labels = ['le' => 'LE', 'th' => 'TH'];
                                    $out = [];
                                    foreach ($types as $t) {
                                        $t = trim($t);
                                        if ($t === 'autres' && !empty($DATA['trav_annexes_ct_type_controle_autres'])) {
                                            $out[] = "Autres : <strong>".htmlspecialchars($DATA['trav_annexes_ct_type_controle_autres'])."</strong>";
                                        } elseif (isset($labels[$t])) {
                                            $out[] = "<strong>".$labels[$t]."</strong>";
                                        }
                                    }
                                    echo implode(' + ', $out);
                                    echo "</div></div>";
                                    }
                                ?>
                    </fieldset>
                </div>
            </div>
    <?php 
    endif;

    if(isset($DATA['situation_cnr']) && $DATA['situation_cnr'] == 1):
    ?>
    <div>
    <?php

        echo viewEntreprise($DATA['cnr_entreprise_id']);
    ?>
    </div>     
    <?php
    endif;
    ?>
