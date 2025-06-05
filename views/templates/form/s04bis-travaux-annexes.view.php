<?php
    error_reporting(0);
?>
    <div class="mt-4">
        <h2 class="text-2xl text-gray-500 font-medium">Travaux annexes</h2>
    </div>
<form action="" method="post">
    
    <!-- Construction bois -->
    <?php
    if($_SESSION["info_situation"]['situation_boi']=="1"):
    ?>        
    <hr>    
    <div class="mt-4">
        <h3 class="text-xl text-gray-500 font-medium">Construction en bois</h3>
        <div class="ml-10 mt-4">
            <span class="font-normal">La structure de la construction (poteaux, poutres et voiles) est-elle en bois ? &ensp;&ensp;
                <input type="radio" name="trav_annexes_constr_bois" value="1" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois']) && ($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois'])==1 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                <input type="radio" name="trav_annexes_constr_bois" value="0" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois']) && ($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois'])==0 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Non</label>
            </span>
        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">L'enveloppe de la construction (façade, planchers et balcons) est-elle en bois ? &ensp;&ensp;
                <input type="radio" name="trav_annexes_constr_bois_enveloppe" value="1" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois_enveloppe']) && ($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois_enveloppe'])==1 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                <input type="radio" name="trav_annexes_constr_bois_enveloppe" value="0" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois_enveloppe']) && ($_SESSION['info_travaux_annexes']['trav_annexes_constr_bois_enveloppe'])==0 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Non</label>
            </span>
        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">Les produits utilisés bénéficient-ils d'un marquage CE ? &ensp;&ensp;
                <input type="radio" name="trav_annexes_constr_produits_ce"  value="1" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_constr_produits_ce']) && ($_SESSION['info_travaux_annexes']['trav_annexes_constr_produits_ce'])==1 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                <input type="radio" name="trav_annexes_constr_produits_ce" value="0" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_constr_produits_ce']) && ($_SESSION['info_travaux_annexes']['trav_annexes_constr_produits_ce'])==0 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Non</label>
            </span>
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
        <h3 class="text-xl text-gray-500 font-medium">Panneaux photovoltaïques</h3>
        <div class="ml-10 mt-6">
            <h3 class="font-normal">Quel est le système de montage des panneaux ? &ensp;&ensp;</h3>
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
        <div class="ml-10 mt-4">
            <span class="font-normal">Les procédés mis en oeuvre bénéficient-ils d'un avis technique ? &ensp;&ensp;
                <input type="radio" name="trav_annexes_pv_proc_tech" value="1" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_proc_tech']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_proc_tech'])==1 ? "checked=checked" : ""; ?> onclick="hideElement('pv_etn')"/>
                <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                <input type="radio" name="trav_annexes_pv_proc_tech" value="0" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_proc_tech']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_proc_tech'])==0 ? "checked=checked" : ""; ?> onclick="showElement('pv_etn')"/>
                <label class="text-gray-500 font-medium"> Non</label>
            </span>
            <div id="pv_etn" class="hidden">
                <span class="font-normal ml-10">Sont-ils visés par une Enquête de Technique Nouvelle (ETN) ? &ensp;&ensp;
                    <input type="radio" name="trav_annexes_pv_etn" value="1" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_etn']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_etn'])==1 ? "checked=checked" : ""; ?>/>
                    <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                    <input type="radio" name="trav_annexes_pv_etn" value="0" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_etn']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_etn'])==0 ? "checked=checked" : ""; ?>/>
                    <label class="text-gray-500 font-medium"> Non</label>
                </span>
            </div>
        </div>
        <div class="ml-10 mt-4">
            <span class="font-normal">En présence d'un avis technique, les procédés figurent-ils sur la liste verte de la C2P ? &ensp;&ensp;
                <input type="radio" name="trav_annexes_pv_liste_c2p" value="1" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_liste_c2p']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_liste_c2p'])==1 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                <input type="radio" name="trav_annexes_pv_liste_c2p" value="0" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_liste_c2p']) && ($_SESSION['info_travaux_annexes']['trav_annexes_pv_liste_c2p'])==0 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Non</label>
            </span>  
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
            <h3 class="font-normal">Quelle est la destination de l'électricité produite par l'installation photovoltaïque ? &ensp;&ensp;</h3>
            <div class="ml-10">
                <span>
                    <input type="radio" name="trav_annexes_pv_destination" value="revente" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_destination'])=="revente" ? "checked=checked" : ""; ?>/>
                    <label> revente à un opérateur dans le domaine de l'énergie</label>
                </span>
                <span class="ml-4">
                    <input type="radio" name="trav_annexes_pv_destination" value="autocons" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_pv_destination'])=="autocons" ? "checked=checked" : ""; ?>/>
                    <label> autoconsommation</label>
                </span>
            </div>
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
            <div><?php echo coordFormDisplay('geo', $_SESSION['info_travaux_annexes']); ?></div>
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
            <h3 class="font-normal mb-4">Type de contrôle (choisissez l'option correspondante):</h3>
            <div class="flex flex-row ml-10">
                <div class="flex flex-col">
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="l" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="l" ? "checked=checked" : ""; ?>/> L</span>
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="lth" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="lth" ? "checked=checked" : ""; ?>/> L + TH</span>
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="le" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="le" ? "checked=checked" : ""; ?>/> LE</span>
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="leth" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="leth" ? "checked=checked" : ""; ?>/> LE + TH</span>
                </div>
                <div class="flex flex-col ml-12">
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="lautre" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="lautre" ? "checked=checked" : ""; ?>/> L + Autres ( précisez : <input type="text" name="trav_annexes_ct_type_controle_l_autres" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 ml-4"/> )</span>
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="lthautre" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="lthautre" ? "checked=checked" : ""; ?>/> L + TH + Autres ( précisez : <input type="text" name="trav_annexes_ct_type_controle_lth_autres" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 ml-4"/> )</span>
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="leautre" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="leautre" ? "checked=checked" : ""; ?>/> LE + Autres ( précisez : <input type="text" name="trav_annexes_ct_type_controle_le_autres" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 ml-4"/> )</span>
                    <span><input type="radio" name="trav_annexes_ct_type_controle" value="lethautre" <?= isset($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle']) && ($_SESSION['info_travaux_annexes']['trav_annexes_ct_type_controle'])=="lethautre" ? "checked=checked" : ""; ?>/> LE + TH + Autres ( précisez : <input type="text" name="trav_annexes_ct_type_controle_leth_autres" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 ml-4"/> )</span>
                </div>
            </div>
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

