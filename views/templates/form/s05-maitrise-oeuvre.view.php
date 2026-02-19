<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>
<form action="" method="post">
    <?php if (!empty($_SESSION['form_errors'])): ?>
        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <ul class="list-disc pl-5">
                <?php foreach ($_SESSION['form_errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <!-- Maitrise d'oeuvre -->
    <div class="">
        <h3 class="text-gray-500 font-medium">Maitrise d'oeuvre <span class="text-red-600">*</span></h3>
        <div class="flex flex-col lg:flex-row ml-10 mt-6">
            <span class="font-normal">Y a-t-il intervention d'un architecte ou d'un maitre d'oeuvre ?</span>
            <div class="lg:w-1/3 flex justify-end">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_moe" class="sr-only peer" onchange="handleToggleYN(this, 'radio_moe_oui', 'radio_moe_non', 'moe_value'); if(this.checked){showElement('moe_form','moe');}else{hideElement('moe_form','moe');}" <?= isset($_SESSION['info_dommage_ouvrage']['moe']) && $_SESSION['info_dommage_ouvrage']['moe']==1 ? "checked=checked" : ""; ?> required />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                    <span id="moe_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                        <?= isset($_SESSION['info_dommage_ouvrage']['moe']) ? ($_SESSION['info_dommage_ouvrage']['moe']==1 ? 'Oui' : 'Non') : 'Non' ?>
                    </span>
                </label>
                <input type="radio" name="moe" value="1" id="radio_moe_oui" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['moe']) && $_SESSION['info_dommage_ouvrage']['moe']==1 ? "checked=checked" : ""; ?> />
                <input type="radio" name="moe" value="0" id="radio_moe_non" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['moe']) && $_SESSION['info_dommage_ouvrage']['moe']==0 ? "checked=checked" : (!isset($_SESSION['info_dommage_ouvrage']['moe']) ? "checked=checked" : ""); ?> />
            </div>
        </div>
        <div id="moe_form" class="<?= isset($_SESSION['info_dommage_ouvrage']['intervention']) && ($_SESSION['info_dommage_ouvrage']['intervention'])==1 ? "" : "hidden"; ?> px-8 py-4">
            <div>
                <?php 
                //var_dump($_SESSION['info_dommage_ouvrage']);
                echo coordFormDisplay('moe',$_SESSION['info_dommage_ouvrage']["moe_entreprise_id"]); ?>
            </div>
            <div class="flex mt-4">
                <span class="font-normal">Est-il indépendant à l'égard des autres constructeurs et du maître d'ouvrage ?</span>
                <div class="ml-10 flex justify-end">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_moe_indep" class="sr-only peer" onchange="handleToggleYN(this, 'radio_moe_indep_oui', 'radio_moe_indep_non', 'moe_indep_value'); if(!this.checked){showElement('intervention_moe_independant_info');}else{hideElement('intervention_moe_independant_info');}"
                            <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']) && $_SESSION['info_dommage_ouvrage']['intervention_moe_independant']==1 ? "checked=checked" : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="moe_indep_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']) ? ($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="intervention_moe_independant" value="1" id="radio_moe_indep_oui" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']) && $_SESSION['info_dommage_ouvrage']['intervention_moe_independant']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="intervention_moe_independant" value="0" id="radio_moe_indep_non" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']) && $_SESSION['info_dommage_ouvrage']['intervention_moe_independant']==0 ? "checked=checked" : (!isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']) ? "checked=checked" : ""); ?> />
                </div>
            </div>
        </div>
        <div id="intervention_moe_independant_info" class="<?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant']) && ($_SESSION['info_dommage_ouvrage']['intervention_moe_independant'])==1 ? "" : "hidden"; ?> px-8 py-4">
            <div class="ml-10">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa qualité, sa fonction</label>
                <input type="text" name="intervention_moe_independant_qualite" value="<?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_qualite']) ? $_SESSION['info_dommage_ouvrage']['intervention_moe_independant_qualite'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </div>
            <div class="ml-10 mt-4">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa mission</span>
                <div class="ml-10">
                    <div>
                        <input type="radio" name="intervention_moe_independant_mission" value="conception" <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission']) && ($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission'])=="conception" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Conception</label>
                    </div>
                    <div>
                        <input type="radio" name="intervention_moe_independant_mission" value="direction" <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission']) && ($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission'])=="direction" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Direction et surveillance des travaux</label>
                    </div>
                    <div>                
                        <input type="radio" name="intervention_moe_independant_mission" value="complete" <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission']) && ($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission'])=="complete" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Mission complète</label>
                    </div>
                    <div>                  
                        <input type="radio" name="intervention_moe_independant_mission" value="autre" <?= isset($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission']) && ($_SESSION['info_dommage_ouvrage']['intervention_moe_independant_mission'])=="autre" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Autre</label>
                        <span class="text-xs">(à décrire : 
                            <input type="text" name="intervention_moe_independant_mission_autre_descr" value="<?= isset($_SESSION['info_dommage_ouvrage']['intervention_mission_autre_descr']) ? $_SESSION['info_dommage_ouvrage']['intervention_mission_autre_descr'] : ''; ?>" style="height:10px; width: 350px; border-radius:6px; font-size:14px;" class="bg-gray-50"/> )
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Garanties -->
    <div class="mt-8">
        <h3 class="text-gray-500 font-medium">Garanties demandées <span class="text-red-600">*</span></h3>
        <div class="mx-10 mt-4 flex justify-end items-center">
            <span class="font-normal text-left flex-1">Dommage Ouvrage</span>
            <label class="inline-flex items-center cursor-pointer justify-end">
                <input type="checkbox" id="toggle_garantie_do" class="sr-only peer" onchange="handleToggleYN(this, 'radio_garantie_do_oui', 'radio_garantie_do_non', 'garantie_do_value')"
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_do']) && $_SESSION['info_dommage_ouvrage']['garantie_do']==1 ? "checked=checked" : ""; ?> />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="garantie_do_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_do']) ? ($_SESSION['info_dommage_ouvrage']['garantie_do']==1 ? 'Oui' : 'Non') : 'Non' ?>
                </span>
            </label>
            <input type="radio" name="garantie_do" value="1" id="radio_garantie_do_oui" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_do']) && $_SESSION['info_dommage_ouvrage']['garantie_do']==1 ? "checked=checked" : ""; ?> />
            <input type="radio" name="garantie_do" value="0" id="radio_garantie_do_non" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_do']) && $_SESSION['info_dommage_ouvrage']['garantie_do']==0 ? "checked=checked" : (!isset($_SESSION['info_dommage_ouvrage']['garantie_do']) ? "checked=checked" : ""); ?> />
        </div>
        <div class='<?= isset($_SESSION['info_situation']['situation_cnr']) && ($_SESSION['info_situation']['situation_cnr'])==1 ? "" : "hidden"; ?> mx-10 mt-4 flex justify-end items-center' id="garantie_cnr">
            <span class="font-normal text-left flex-1">Responsabilité du Constructeur Non Réalisateur</span>
            <label class="inline-flex items-center cursor-pointer justify-end">
                <input type="checkbox" id="toggle_garantie_cnr" class="sr-only peer" onchange="handleToggleYN(this, 'radio_garantie_cnr_oui', 'radio_garantie_cnr_non', 'garantie_cnr_value')"
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_cnr']) && $_SESSION['info_dommage_ouvrage']['garantie_cnr']==1 ? "checked=checked" : ""; ?> />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="garantie_cnr_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_cnr']) ? ($_SESSION['info_dommage_ouvrage']['garantie_cnr']==1 ? 'Oui' : 'Non') : 'Non' ?>
                </span>
            </label>
            <input type="radio" name="garantie_cnr" value="1" id="radio_garantie_cnr_oui" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_cnr']) && $_SESSION['info_dommage_ouvrage']['garantie_cnr']==1 ? "checked=checked" : ""; ?> />
            <input type="radio" name="garantie_cnr" value="0" id="radio_garantie_cnr_non" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_cnr']) && $_SESSION['info_dommage_ouvrage']['garantie_cnr']==0 ? "checked=checked" : (!isset($_SESSION['info_dommage_ouvrage']['garantie_cnr']) ? "checked=checked" : ""); ?> />
        </div>
        <div class="mx-10 mt-4 flex justify-end items-center">
            <span class="font-normal text-left flex-1">Tous risques chantier</span>
            <label class="inline-flex items-center cursor-pointer justify-end">
                <input type="checkbox" id="toggle_garantie_trc" class="sr-only peer" onchange="handleToggleYN(this, 'radio_garantie_trc_oui', 'radio_garantie_trc_non', 'garantie_trc_value')"
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_chantier']) && $_SESSION['info_dommage_ouvrage']['garantie_chantier']==1 ? "checked=checked" : ""; ?> />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="garantie_trc_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_chantier']) ? ($_SESSION['info_dommage_ouvrage']['garantie_chantier']==1 ? 'Oui' : 'Non') : 'Non' ?>
                </span>
            </label>
            <input type="radio" name="garantie_chantier" value="1" id="radio_garantie_trc_oui" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_chantier']) && $_SESSION['info_dommage_ouvrage']['garantie_chantier']==1 ? "checked=checked" : ""; ?> />
            <input type="radio" name="garantie_chantier" value="0" id="radio_garantie_trc_non" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_chantier']) && $_SESSION['info_dommage_ouvrage']['garantie_chantier']==0 ? "checked=checked" : (!isset($_SESSION['info_dommage_ouvrage']['garantie_chantier']) ? "checked=checked" : ""); ?> />
        </div>
        <div class="mx-10 mt-4 flex justify-end items-center">
            <span class="font-normal text-left flex-1">Protection juridique</span>
            <label class="inline-flex items-center cursor-pointer justify-end">
                <input type="checkbox" id="toggle_garantie_pj" class="sr-only peer" onchange="handleToggleYN(this, 'radio_garantie_pj_oui', 'radio_garantie_pj_non', 'garantie_pj_value')"
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_juridique']) && $_SESSION['info_dommage_ouvrage']['garantie_juridique']==1 ? "checked=checked" : ""; ?> />
                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                <span id="garantie_pj_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                    <?= isset($_SESSION['info_dommage_ouvrage']['garantie_juridique']) ? ($_SESSION['info_dommage_ouvrage']['garantie_juridique']==1 ? 'Oui' : 'Non') : 'Non' ?>
                </span>
            </label>
            <input type="radio" name="garantie_juridique" value="1" id="radio_garantie_pj_oui" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_juridique']) && $_SESSION['info_dommage_ouvrage']['garantie_juridique']==1 ? "checked=checked" : ""; ?> />
            <input type="radio" name="garantie_juridique" value="0" id="radio_garantie_pj_non" class="hidden" <?= isset($_SESSION['info_dommage_ouvrage']['garantie_juridique']) && $_SESSION['info_dommage_ouvrage']['garantie_juridique']==0 ? "checked=checked" : (!isset($_SESSION['info_dommage_ouvrage']['garantie_juridique']) ? "checked=checked" : ""); ?> />
        </div>
    </div>


    <div class="flex flex-row justify-center mt-10">
        <!-- Bouton précédent -->                                          
        <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
            <?php
                if (isset($_SESSION['info_travaux_annexes'])){                
                    $nextstep = "step4bis";
                }else{
                    $nextstep = "step4";
                }
            ?>

        <div class="flex flex-row justify-center mt-10">
            <!-- Bouton précédent -->                                          
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="<?= $nextstep; ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Précédent</button>
            </div>
            <!-- Bouton suivant -->
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="validation" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Suivant</button>
            </div>
        </div>
    </div>


    <input type="hidden" name="fields" value="dommage_ouvrage">
</form>
<script src="public/script/s04-informations-diverses.js"></script>