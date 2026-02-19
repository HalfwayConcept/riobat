<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
?>
    <div class="mt-4">
        <h2 class="section-title">Travaux annexes</h2>
    </div>
<form action="" method="post">
    
    <!-- Construction bois -->
    <?php
    if($_SESSION["info_situation"]['situation_boi']=="1"):
    ?>        
    <hr>    
    <div class="mt-4">
        <h3 class="section-title">Construction en bois</h3>
        <div class="ml-10 mt-4 flex items-center justify-between">
            <label class="font-normal flex-1 pr-4 text-left">La structure de la construction (poteaux, poutres et voiles) est-elle en bois ?</label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle_trav_annexes_constr_bois" class="sr-only peer" name="trav_annexes_constr_bois" value="1"
                    onchange="handleToggleYN(this, 'radio_trav_annexes_constr_bois_oui', 'radio_trav_annexes_constr_bois_non', 'trav_annexes_constr_bois_value')" />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="trav_annexes_constr_bois_value" class="select-none ms-3 text-sm font-medium text-gray-900">Non</span>
                <input type="radio" name="trav_annexes_constr_bois" value="1" id="radio_trav_annexes_constr_bois_oui" class="hidden" />
                <input type="radio" name="trav_annexes_constr_bois" value="0" id="radio_trav_annexes_constr_bois_non" class="hidden" checked="checked" />
            </label>
        </div>
        <div class="ml-10 mt-4 flex items-center justify-between">
            <label class="font-normal flex-1 pr-4 text-left">L'enveloppe de la construction (façade, planchers et balcons) est-elle en bois ?</label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle_trav_annexes_constr_bois_enveloppe" class="sr-only peer" name="trav_annexes_constr_bois_enveloppe" value="1"
                    onchange="handleToggleYN(this, 'radio_trav_annexes_constr_bois_enveloppe_oui', 'radio_trav_annexes_constr_bois_enveloppe_non', 'trav_annexes_constr_bois_enveloppe_value')" />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="trav_annexes_constr_bois_enveloppe_value" class="select-none ms-3 text-sm font-medium text-gray-900">Non</span>
                <input type="radio" name="trav_annexes_constr_bois_enveloppe" value="1" id="radio_trav_annexes_constr_bois_enveloppe_oui" class="hidden" />
                <input type="radio" name="trav_annexes_constr_bois_enveloppe" value="0" id="radio_trav_annexes_constr_bois_enveloppe_non" class="hidden" checked="checked" />
            </label>
        </div>
        <div class="ml-10 mt-4 flex items-center justify-between">
            <label class="font-normal flex-1 pr-4 text-left">Les produits utilisés bénéficient-ils d'un marquage CE ?</label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle_trav_annexes_constr_produits_ce" class="sr-only peer" name="trav_annexes_constr_produits_ce" value="1"
                    onchange="handleToggleYN(this, 'radio_trav_annexes_constr_produits_ce_oui', 'radio_trav_annexes_constr_produits_ce_non', 'trav_annexes_constr_produits_ce_value')" />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="trav_annexes_constr_produits_ce_value" class="select-none ms-3 text-sm font-medium text-gray-900">Non</span>
                <input type="radio" name="trav_annexes_constr_produits_ce" value="1" id="radio_trav_annexes_constr_produits_ce_oui" class="hidden" />
                <input type="radio" name="trav_annexes_constr_produits_ce" value="0" id="radio_trav_annexes_constr_produits_ce_non" class="hidden" checked="checked" />
            </label>
        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">Nom de l'entreprise réalisant la construction bois : &ensp;&ensp;</span>
            <div><?php echo coordFormDisplay('boi', $_SESSION['info_travaux_annexes']["boi_entreprise_id"]); ?></div>
        </div>
    </div>
    <?php
    endif;  // fin construction bois
    ?>

    <!-- Panneaux photovoltaïques -->
    <?php
    if($_SESSION["info_situation"]['situation_phv'] =="1"):
    ?>    
    <hr>
    <div class="mt-4">
        <h3 class="section-title">Panneaux photovoltaïques</h3>
        <div class="ml-10 mt-6">
            <h3 class="section-title">Quel est le système de montage des panneaux ?</h3>
            <div class="ml-10">
                <span>
                    <input type="radio" name="trav_annexes_pv_montage" value="integre" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage'])=="integre" ? "checked=checked" : ""; ?>/>
                    <label> intégrés à la toiture</label>
                </span>
                <span class="ml-4">
                    <input type="radio" name="trav_annexes_pv_montage" value="surimpose" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage'])=="surimpose" ? "checked=checked" : ""; ?>/>
                    <label> surimposés à la toiture</label>
                </span>
                <span class="ml-4">
                    <input type="radio" name="trav_annexes_pv_montage" value="autre" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_montage'])=="autre" ? "checked=checked" : ""; ?>/>
                    <label> autres (ex : façade... )</label>
                </span>
            </div>
        </div>
        <div class="ml-10 mt-4 flex items-center justify-between">
            <label class="font-normal flex-1 pr-4 text-left">Les procédés mis en oeuvre bénéficient-ils d'un avis technique ?</label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle_trav_annexes_pv_proc_tech" class="sr-only peer" name="trav_annexes_pv_proc_tech" value="1"
                    onchange="handleToggleYN(this, 'radio_trav_annexes_pv_proc_tech_oui', 'radio_trav_annexes_pv_proc_tech_non', 'trav_annexes_pv_proc_tech_value')" />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="trav_annexes_pv_proc_tech_value" class="select-none ms-3 text-sm font-medium text-gray-900">Non</span>
                <input type="radio" name="trav_annexes_pv_proc_tech" value="1" id="radio_trav_annexes_pv_proc_tech_oui" class="hidden" />
                <input type="radio" name="trav_annexes_pv_proc_tech" value="0" id="radio_trav_annexes_pv_proc_tech_non" class="hidden" checked="checked" />
            </label>
        </div>
        <div id="pv_etn" class="ml-10 mt-4 hidden flex items-center justify-between">
            <label class="font-normal flex-1 pr-4 text-left">Sont-ils visés par une Enquête de Technique Nouvelle (ETN) ? <span class="text-red-500">*</span></label>
            <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="trav_annexes_pv_etn" value="1" class="sr-only peer"
                    <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_etn']) ? ($_SESSION['info_travaux_annexes']['trav_annexes_pv_etn'] ? 'checked' : '') : '' ?> />
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 toggle-label"> <span class="toggle-text">Non</span></span>
            </label>
        </div>
        <div class="ml-10 mt-4 flex items-center justify-between">
            <label class="font-normal flex-1 pr-4 text-left">En présence d'un avis technique, les procédés figurent-ils sur la liste verte de la C2P ?</label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle_trav_annexes_pv_liste_c2p" class="sr-only peer" name="trav_annexes_pv_liste_c2p" value="1"
                    onchange="handleToggleYN(this, 'radio_trav_annexes_pv_liste_c2p_oui', 'radio_trav_annexes_pv_liste_c2p_non', 'trav_annexes_pv_liste_c2p_value')" />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="trav_annexes_pv_liste_c2p_value" class="select-none ms-3 text-sm font-medium text-gray-900">Non</span>
                <input type="radio" name="trav_annexes_pv_liste_c2p" value="1" id="radio_trav_annexes_pv_liste_c2p_oui" class="hidden" />
                <input type="radio" name="trav_annexes_pv_liste_c2p" value="0" id="radio_trav_annexes_pv_liste_c2p_non" class="hidden" checked="checked" />
            </label>
        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">Quelle est la surface de l'installation ?
                <input type="text" name="trav_annexes_pv_surface" value="<?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_surface']) ? $_SESSION['info_travaux_annexes']['trav_annexes_pv_surface'] : ''?>" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 ml-4"/> m²
            </span>
        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">Quelle est la puissance de l'installation ?
                <input type="text" name="trav_annexes_pv_puissance" value="<?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_puissance']) ? $_SESSION['info_travaux_annexes']['trav_annexes_pv_puissance'] : ''?>" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 ml-4"/> kWc
            </span>
        </div>
        <div class="ml-10 mt-4">
                <label class="font-normal flex-1 pr-4 text-left flex items-center">
                    Quelle est la destination de l'électricité produite par l'installation photovoltaïque ? <span class="text-red-500">*</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <span class="select-none text-sm font-medium text-gray-900 flex items-center">
                        <span id="label_revente" class="destination-label<?= (!isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_destination']) || $_SESSION['info_travaux_annexes']['trav_annexes_pv_destination']=='revente') ? ' font-bold' : '' ?>" title="Revente : l'électricité est vendue à un opérateur">Revente</span>
                        <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button" class="ml-1 mr-2"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                        <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Conditions d'acceptation : </h3>
                                    <p>Un contrat de production a été souscrit avec un opérateur dans le domaine de l'énergie</p>
                                </div>
                        </div>
                        <span class="mx-1"></span>
                        <input name="trav_annexes_pv_destination" type="checkbox" id="toggle_trav_annexes_pv_destination" class="sr-only peer" value="revente"
                            onchange="
                                document.getElementById('label_autocons').classList.toggle('font-bold', this.checked===false);
                                document.getElementById('label_revente').classList.toggle('font-bold', this.checked===true);
                            "
                            <?php
                                // Par défaut revente sélectionné
                                if (!isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_destination']) || $_SESSION['info_travaux_annexes']['trav_annexes_pv_destination']=="revente") {
                                    echo 'checked';
                                }
                            ?> />
                        <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:bg-blue-600 transition-all peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all mx-2"></div>
                        <span id="label_autocons" class="destination-label<?= (isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_destination']) && $_SESSION['info_travaux_annexes']['trav_annexes_pv_destination']=='autocons') ? ' font-bold' : '' ?>">Autoconsommation</span>
                    </span>
                </label>

        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">Nom de l'entreprise réalisant l'installation : &ensp;&ensp;</span>
            <div><?php echo coordFormDisplay('phv', $_SESSION['info_travaux_annexes']["phv_entreprise_id"]); ?></div>
        </div>
    </div>
    <?php
    endif;  // fin panneaux photovoltaïques
    ?>

    <!-- Géothermie -->
    <?php
    if($_SESSION["info_situation"]['situation_geo'] =="1"):
    ?>
    <hr>
    <div class="mt-4">
        <h3 class="text-xl text-gray-500 font-medium">Géothermie</h3>
        <div class="ml-10 mt-6">
            <span class="font-normal">Nom de l'entreprise réalisant les forages : &ensp;&ensp;</span>
            <div><?php echo coordFormDisplay('geo', $_SESSION['info_travaux_annexes']['geo_entreprise_id'] ?? ''); ?></div>
        </div>
    </div>
    <?php
    endif;  // fin géothermie
    ?>

    <!-- Contrôleur technique-->
    <?php
    if($_SESSION["info_situation"]['situation_ctt'] =="1"):
    ?>
    <hr>
    <div class="mt-4 ">
        <h3 class="text-xl text-gray-500 font-medium">Contrôleur technique</h3>
        <div class="ml-10 mt-6">
            <span class="font-normal">Nom du contrôleur technique : &ensp;&ensp;</span>
            <div><?php echo coordFormDisplay('ctt', $_SESSION['info_travaux_annexes']["ctt_entreprise_id"]); ?></div>
        </div>
        <div class="ml-10 mt-14">
            <h3 class="font-normal mb-4">Type de contrôle (cochez tout ce qui s'applique) :</h3>
            <div class="flex flex-row gap-6 ml-10 items-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="trav_annexes_ct_type_controle[]" value="le" class="mr-2" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && (is_array($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) ? in_array('le', $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) : $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']=='le') ? 'checked=checked' : ''; ?> /> LE
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="trav_annexes_ct_type_controle[]" value="th" class="mr-2" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && (is_array($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) ? in_array('th', $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) : $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']=='th') ? 'checked=checked' : ''; ?> /> TH
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="trav_annexes_ct_type_controle[]" value="autres" class="mr-2" id="ct_type_controle_autres" onchange="toggleAutresPrecisez(this)" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && (is_array($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) ? in_array('autres', $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) : $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']=='autres') ? 'checked=checked' : ''; ?> /> Autres
                </label>
                <input type="text" name="trav_annexes_ct_type_controle_autres_precisez" id="ct_type_controle_autres_precisez" class="ml-2 bg-gray-50 border border-gray-300 rounded px-2 py-1 text-sm" placeholder="Précisez" value="<?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle_autres_precisez']) ? htmlspecialchars($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle_autres_precisez']) : '' ?>" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ((is_array($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && in_array('autres', $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])) || $_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']=='autres') ? '' : 'style="display:none"'; ?> required />
            </div>
            <script>
            function toggleAutresPrecisez(checkbox) {
                var champ = document.getElementById('ct_type_controle_autres_precisez');
                if (checkbox.checked) {
                    champ.style.display = '';
                    champ.required = true;
                } else {
                    champ.style.display = 'none';
                    champ.required = false;
                    champ.value = '';
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                var autres = document.getElementById('ct_type_controle_autres');
                if (autres) toggleAutresPrecisez(autres);
            });
            </script>
        </div>

    </div>
    <?php
    endif;  // fin contrôleur technique
    ?>
 
    <?php
    if($_SESSION["info_situation"]['situation_cnr'] =="1"):
    ?>
    <hr>
    <div class="mt-4">
        <h3 class="text-xl text-gray-500 font-medium">Désignation du constructeur non réalisateur</h3>
        <div class="ml-10">
            <?php echo coordFormDisplay('cnr',$_SESSION['info_travaux_annexes']["cnr_entreprise_id"] ); ?>
        </div>
        <div class="my-2 ml-10">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervenant en qualité de ?</label>
            <input type="text" name="cnr_qualite" value="<?= isset($_SESSION['info_travaux_annexes']['cnr_qualite']) ? $_SESSION['info_travaux_annexes']['cnr_qualite'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        </div>
    </div>
    <?php
    endif;  // fin CNR
    ?>


    <div class="flex flex-row justify-center mt-4">
        <!-- Bouton précédent -->                                          
        <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
            <button type="submit" name="page_next" value="step4" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Précédent</button>
        </div>
        <!-- Bouton suivant -->
        <div class="text-center ml-6">
            <button type="submit" name="page_next" value="step5" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Suivant</button>
        </div>
    </div>


    <input type="hidden" name="fields" value="travaux_annexes">
</form>
<script src="public/script/s04bis-travaux-annexes.js"></script>

