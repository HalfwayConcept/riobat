<?php
    error_reporting(0);
?>
<form action="" method="post">
    <!-- Maitrise d'oeuvre -->
    <div class="">
        <h3 class="text-gray-500 font-medium">Maitrise d'oeuvre</h3>
        <div class="flex flex-col lg:flex-row ml-10 mt-6">
            <span class="font-normal">Y a-t-il intervention d'un architecte ou d'un maitre d'oeuvre ? &ensp;&ensp;</span>
            <div class="ml-8 text-gray-500 font-medium">
                <input type="radio" name="moe" value="1" <?= isset($_SESSION['info_moe']['moe']) && ($_SESSION['info_moe']['moe'])==1 ? "checked=checked" : ""; ?> onclick="showElement('moe_intervention_form')" required/>
                <label> Oui &ensp;</label>
                <input type="radio" name="moe" value="0" <?= isset($_SESSION['info_moe']['moe']) && ($_SESSION['info_moe']['moe'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('moe_intervention_form')"/>
                <label> Non</label>
            </div>
        </div>
        <div id="moe_intervention_form" class="<?= isset($_SESSION['info_moe']['moe_intervention']) && ($_SESSION['info_moe']['moe_intervention'])==1 ? "" : "hidden"; ?> px-8 py-4">
            <div>
                <?php echo coordFormDisplay('moe',$_SESSION['info_moe']); ?>
            </div>
            <div class="flex mt-4">
                <span class="font-normal">Est-il indépendant à l'égard des autres constructeurs et du maître d'ouvrage ?</span>
                <div class="ml-10">
                    <input type="radio" name="moe_intervention_independant" value="1" <?= isset($_SESSION['info_moe']['moe_intervention_independant']) && ($_SESSION['info_moe']['moe_intervention_independant'])==1 ? "checked=checked" : ""; ?> onclick="hideElement('moe_intervention_independant_info')"/>
                    <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                    <input type="radio" name="moe_intervention_independant" value="0" <?= isset($_SESSION['info_moe']['moe_intervention_independant']) && ($_SESSION['info_moe']['moe_intervention_independant'])==0 ? "checked=checked" : ""; ?> onclick="showElement('moe_intervention_independant_info')"/>
                    <label class="text-gray-500 font-medium"> Non</label>
                </div>
            </div>
        </div>
        <div id="moe_intervention_independant_info" class="<?= isset($_SESSION['info_moe']['moe_intervention_independant']) && ($_SESSION['info_moe']['moe_intervention_independant'])==1 ? "" : "hidden"; ?> px-8 py-4">
            <div class="ml-10">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa qualité, sa fonction</label>
                <input type="text" name="moe_intervention_independant_qualite" value="<?= isset($_SESSION['info_moe']['moe_intervention_independant_qualite']) ? $_SESSION['info_moe']['moe_intervention_independant_qualite'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </div>
            <div class="ml-10 mt-4">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa mission</span>
                <div class="ml-10">
                    <div>
                        <input type="radio" name="moe_intervention_independant_mission" value="conception" <?= isset($_SESSION['info_moe']['moe_intervention_independant_mission']) && ($_SESSION['info_moe']['moe_intervention_independant_mission'])=="conception" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Conception</label>
                    </div>
                    <div>
                        <input type="radio" name="moe_intervention_independant_mission" value="direction" <?= isset($_SESSION['info_moe']['moe_intervention_independant_mission']) && ($_SESSION['info_moe']['moe_intervention_independant_mission'])=="direction" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Direction et surveillance des travaux</label>
                    </div>
                    <div>                
                        <input type="radio" name="moe_intervention_independant_mission" value="complete" <?= isset($_SESSION['info_moe']['moe_intervention_independant_mission']) && ($_SESSION['info_moe']['moe_intervention_independant_mission'])=="complete" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Mission complète</label>
                    </div>
                    <div>                  
                        <input type="radio" name="moe_intervention_independant_mission" value="autre" <?= isset($_SESSION['info_moe']['moe_intervention_independant_mission']) && ($_SESSION['info_moe']['moe_intervention_independant_mission'])=="autre" ? "checked=checked" : ""; ?>>
                        <label class="font-normal">Autre</label>
                        <span class="text-xs">(à décrire : 
                            <input type="text" name="moe_intervention_independant_mission_autre_descr" value="<?= isset($_SESSION['info_moe']['moe_intervention_mission_autre_descr']) ? $_SESSION['info_moe']['moe_intervention_mission_autre_descr'] : ''; ?>" style="height:10px; width: 350px; border-radius:6px; font-size:14px;" class="bg-gray-50"/> )
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Garanties -->
    <div class="mt-8">
        <h3 class="text-gray-500 font-medium">Garanties demandées</h3>
        <div class="mx-10 mt-4">
            <span class="font-normal text-gray-900">Dommage Ouvrage  &ensp;&ensp;</span>
                <input type="radio" name="moe_garantie_do" value="1" <?= isset($_SESSION['info_moe']['moe_garantie_do']) && ($_SESSION['info_moe']['moe_garantie_do'])==1 ? "checked=checked" : ""; ?> required/>
                <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                <input type="radio" name="moe_garantie_do" value="0" <?= isset($_SESSION['info_moe']['moe_garantie_do']) && ($_SESSION['info_moe']['moe_garantie_do'])==0 ? "checked=checked" : ""; ?>/>
                <label class="text-gray-500 font-medium"> Non</label>
            </span>  
        </div>
        <div class='<?= isset($_SESSION['info_situation']['situation_cnr']) && ($_SESSION['info_situation']['situation_cnr'])==1 ? "" : "hidden"; ?> mx-10 mt-4' id="garantie_cnr">
            <span class='font-normal text-gray-900'>Responsabilité du Constructeur Non Réalisateur &ensp;&ensp;
                <input type='radio' name='moe_garantie_cnr' value='1' <?= isset($_SESSION['info_moe']['moe_garantie_cnr']) && ($_SESSION['info_moe']['moe_garantie_cnr'])==1 ? 'checked=checked' : ''; ?>/>
                <label class='text-gray-500 font-medium'> Oui &ensp;</label>
                <input type='radio' name='moe_garantie_cnr' value='0' <?= isset($_SESSION['info_moe']['moe_garantie_cnr']) && ($_SESSION['info_moe']['moe_garantie_cnr'])==0 ? 'checked=checked' : ''; ?>/>
                <label class='text-gray-500 font-medium'> Non</label>
            </span>  
        </div>
        <div class='mx-10 mt-4'>
            <span class='font-normal text-gray-900'>Tous risques chantier &ensp;&ensp;
                <input type='radio' name='moe_garantie_chantier' value='1' <?= isset($_SESSION['info_moe']['moe_garantie_chantier']) && ($_SESSION['info_moe']['moe_garantie_chantier'])==1 ? 'checked=checked' : ''; ?> required/>
                <label class='text-gray-500 font-medium'> Oui &ensp;</label>
                <input type='radio' name='moe_garantie_chantier' value='0' <?= isset($_SESSION['info_moe']['moe_garantie_chantier']) && ($_SESSION['info_moe']['moe_garantie_chantier'])==0 ? 'checked=checked' : ''; ?>/>
                <label class='text-gray-500 font-medium'> Non</label>
            </span>  
        </div>
        <div class='mx-10 mt-4'>
            <span class='font-normal text-gray-900'>Protection juridique &ensp;&ensp;
                <input type='radio' name='moe_garantie_juridique' value='1' <?= isset($_SESSION['info_moe']['moe_garantie_juridique']) && ($_SESSION['info_moe']['moe_garantie_juridique'])==1 ? 'checked=checked' : ''; ?> required/>
                <label class='text-gray-500 font-medium'> Oui &ensp;</label>
                <input type='radio' name='moe_garantie_juridique' value='0' <?= isset($_SESSION['info_moe']['moe_garantie_juridique']) && ($_SESSION['info_moe']['moe_garantie_juridique'])==0 ? 'checked=checked' : ''; ?>/>
                <label class='text-gray-500 font-medium'> Non</label>
            </span>  
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


    <input type="hidden" name="fields" value="moe">
</form>