<section>
    <form action="" method="post">
        <!-- Formulaire caché : "Nature opération : neuf ou existant"-->
        <div class="flex flex-col lg:flex-row">
            <span class="text-gray-500 font-medium">Nature de l'opération : </span>
            <div> <!-- Infobulle -->
                <button data-popover-target="nature-operation-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                <div data-popover id="nature-operation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                    <div class="p-3 space-y-2">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Rappel : </h3>
                        <p>Le permis de construire est une autorisation délivrée à l'issue d'une procédure obligatoire destinée à vérifier la conformité d'un projet de bâtiment avec l'ensemble des dispositions législatives ou réglementaires en vigueur : règles d'urbanisme nationales ou locales (PLD, POS ou PLU local, règles de construction, impact sur les sites) et servitudes de droit public et de droit privé. La durée de validité d'un permis de construire est de 3 ans. Ce délai peut être prorogé de 2 fois 1 an.</p>
                    </div>
                </div>
            </div>
            <span class="ml-6 text-gray-500 font-medium">
                <input type="radio" name="nature_neuf_exist" value="neuve" <?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && $_SESSION['info_operation_construction']['nature_neuf_exist']=="neuve" ? "checked=checked" : ""; ?> onclick="hideElement('nature_operation')" required/>
                <label> Construction neuve &ensp;</label>
                <p class="text-xs text-gray-500 font-normal">(indépendante de tout bâtiment existant)</p>
            </span>
            <span class="ml-6 mt-2 lg:mt-0 text-gray-500 font-medium">
                <input type="radio" name="nature_neuf_exist" value="existante" <?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && $_SESSION['info_operation_construction']['nature_neuf_exist']=="existante" ? "checked=checked" : ""; ?> onclick="showElement('nature_operation')"/>
                <label> Travaux sur construction existante</label>
            </span>
        </div>
        <div id="nature_operation" class="<?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && ($_SESSION['info_operation_construction']['nature_neuf_exist'])=="existante" ? "" : "hidden"; ?> mt-8">
            <h3 class="text-gray-500 font-medium mb-6">De quoi s'agit-il ?</h3>
            <div class="ml-12">
                <!-- Surélévation -->
                <div class="flex flex-col my-4">
                    <div class="flex flex-row">
                        <span class="text-gray-500 font-medium">D'une surélévation ?</span>  
                        <div> <!-- Infobulle -->
                            <button data-popover-target="surelevation-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="surelevation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Surélévation : </h3>
                                    <p>Construction rapportée après coup, en superstructure, au-dessus d'une autre</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="radio" name="nature_operation_surelev" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && ($_SESSION['info_operation_construction']['nature_operation_surelev'])==1 ? "checked=checked" : ""; ?> onclick="showElement('nature_operation_surelev_form')"/>
                            <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                            <input type="radio" name="nature_operation_surelev" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && ($_SESSION['info_operation_construction']['nature_operation_surelev'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('nature_operation_surelev_form')"/>
                            <label class="text-gray-500 font-medium"> Non</label>
                        </div>
                    </div>
                    <div id="nature_operation_surelev_form" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && ($_SESSION['info_operation_construction']['nature_operation_surelev'])==1 ? "" : "hidden"; ?>">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reprise en sous-oeuvre / Travaux sur fondation ? :&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="surelevation-sous-oeuvre-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="surelevation-sous-oeuvre-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Reprise en sous œuvre :  </h3>
                                            <p>Consolidation ou réfection de l'assise d'un ouvrage</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="radio" name="nature_operation_surelev_sous_oeuvre" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) && ($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre'])==1 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                <input type="radio" name="nature_operation_surelev_sous_oeuvre" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) && ($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre'])==0 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Non</label>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervention sur la structure existante (hors fondation) ? : &ensp;&ensp;</span>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="surelevation-existant-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="surelevation-existant-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                            <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="radio" name="nature_operation_surelev_hors_fond" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) && ($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond'])==1 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                <input type="radio" name="nature_operation_surelev_hors_fond" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) && ($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond'])==0 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Non</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Extension horizontale -->
                <div class="flex flex-col my-4">
                    <div class="flex flex-row">
                        <span class="text-gray-500 font-medium">D'une extension horizontale ? &ensp;&ensp;</span>
                        <div> <!-- Infobulle -->
                            <button data-popover-target="extension-horizont-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="extension-horizont-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Extension :   </h3>
                                    <p>Agrandissement d’un bâtiment par un autre bâtiment annexe</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="radio" name="nature_operation_ext_horizont" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && ($_SESSION['info_operation_construction']['nature_operation_ext_horizont'])==1 ? "checked=checked" : ""; ?> onclick="showElement('nature_operation_ext_horizont')"/>
                            <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                            <input type="radio" name="nature_operation_ext_horizont" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && ($_SESSION['info_operation_construction']['nature_operation_ext_horizont'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('nature_operation_ext_horizont')"/>
                            <label class="text-gray-500 font-medium"> Non</label> 
                        </div>
                    </div>

                    <div id="nature_operation_ext_horizont" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && ($_SESSION['info_operation_construction']['nature_operation_ext_horizont'])==1 ? "" : "hidden"; ?> px-8 py-4">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervention sur la structure existante y compris la fondation ? : &ensp;&ensp;</span>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="extension-horizont-existante-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="extension-horizont-existante-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                            <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="radio" name="nature_operation_ext_horizont_exist" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont_exist']) && ($_SESSION['info_operation_construction']['nature_operation_ext_horizont_exist'])==1 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                <input type="radio" name="nature_operation_ext_horizont_exist" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont_exist']) && ($_SESSION['info_operation_construction']['nature_operation_ext_horizont_exist'])==0 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Non</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Rénovation -->
                <div class="flex flex-col my-4">
                    <div class="flex flex-row">
                        <span class="text-gray-500 font-medium">D'une rénovation ?&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span> 
                        <div> <!-- Infobulle -->
                            <button data-popover-target="renovation-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="renovation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Rénovation :   </h3>
                                    <p>Remise en état sans changement de destination (elle peut faire l’objet d’autorisation), hors restauration. Par restauration, on entend l’intervention sur un bâtiment faisant l’objet d’une protection du patrimoine. Une question est prévue en lien : « intervention sur un bâtiment classé ».</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <input type="radio" name="nature_operation_renovation" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && ($_SESSION['info_operation_construction']['nature_operation_renovation'])==1 ? "checked=checked" : ""; ?> onclick="showElement('nature_operation_renovation')"/>
                            <label class="text-gray-500 font-medium"> Oui &ensp;&ensp; </label>
                            <input type="radio" name="nature_operation_renovation" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && ($_SESSION['info_operation_construction']['nature_operation_renovation'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('nature_operation_renovation')"/>
                            <label class="text-gray-500 font-medium"> Non</label> 
                        </div>
                    </div>
                    <div id="nature_operation_renovation" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && ($_SESSION['info_operation_construction']['nature_operation_renovation'])==1 ? "" : "hidden"; ?> px-8 py-4">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervention sur la structure existante y compris la fondation ? : &ensp;&ensp;</span>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="renovation-existante-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="renovation-existante-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                            <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="radio" name="nature_operation_renovation_fond" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_fond'])==1 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                <input type="radio" name="nature_operation_renovation_fond" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_fond'])==0 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Non</label>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Isolation thermique extérieure ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_renovation_iso_therm" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_renovation_iso_therm" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Réfection de toiture ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_renovation_refect_toit" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_renovation_refect_toit" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Travaux d'étanchéité ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_renovation_etancheite" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_renovation_etancheite" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ravalement de façade ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_renovation_ravalement" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_renovation_ravalement" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) && ($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Réhabilitation -->
                <div class="my-4">
                    <span class="text-gray-500 font-medium">D'une réhabilitation ? &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                        <input type="radio" name="nature_operation_rehabilitation" value ="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation'])==1 ? "checked=checked" : ""; ?> onclick="showElement('nature_operation_rehabilitation')"/>
                        <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                        <input type="radio" name="nature_operation_rehabilitation" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('nature_operation_rehabilitation')"/>
                        <label class="text-gray-500 font-medium"> Non</label>
                    </span>  
                    <div id="nature_operation_rehabilitation" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation'])==1 ? "" : "hidden"; ?> px-8 py-4">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervention sur la structure existante y compris la fondation ? : &ensp;&ensp; </span>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="extension-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="extension-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                            <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="radio" name="nature_operation_rehabilitation_fond" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond'])==1 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                <input type="radio" name="nature_operation_rehabilitation_fond" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond'])==0 ? "checked=checked" : ""; ?>>
                                <label class="text-gray-500 font-medium">&ensp; Non</label>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Isolation thermique extérieure ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_rehabilitation_iso_therm" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_rehabilitation_iso_therm" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Réfection de toiture ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_rehabilitation_refect_toit" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_rehabilitation_refect_toit" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Travaux d'étanchéité ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_rehabilitation_etancheite" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_rehabilitation_etancheite" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ravalement de façade ? : &ensp;&ensp;
                                    <input type="radio" name="nature_operation_rehabilitation_ravalement" value="1" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement'])==1 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Oui &ensp;&ensp;</label>
                                    <input type="radio" name="nature_operation_rehabilitation_ravalement" value="0" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement'])==0 ? "checked=checked" : ""; ?>>
                                    <label class="text-gray-500 font-medium">&ensp; Non</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-10">
                <span class="text-gray-500 font-medium">S'agit-il d'une réparation suite à sinistre ? &ensp;&ensp;
                    <input type="radio" name="operation_sinistre" value="1" <?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && ($_SESSION['info_operation_construction']['operation_sinistre'])==1 ? "checked=checked" : ""; ?> onclick="showElement('operation_sinistre_champ_descr')"/>
                    <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                    <input type="radio" name="operation_sinistre" value="0" <?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && ($_SESSION['info_operation_construction']['operation_sinistre'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('operation_sinistre_champ_descr')"/>
                    <label class="text-gray-500 font-medium"> Non</label>
                </span>
                <div id="operation_sinistre_champ_descr" class="<?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && ($_SESSION['info_operation_construction']['operation_sinistre'])==1 ? "" : "hidden"; ?> ml-10 mt-4 ">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez décrire le sinistre :&ensp;&ensp;</label>
                    <input type="text" name="operation_sinistre_descr" value="<?= isset($_SESSION['info_operation_construction']['operation_sinistre_descr']) ? $_SESSION['info_operation_construction']['operation_sinistre_descr'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
            </div>
        </div>

        <!-- Checkboxes "Type d'ouvrage"-->
        <fieldset class="flex flex-col lg:flex-row mb-2 mt-10">
            <legend class="mb-2 text-gray-500 font-medium">Type de l'ouvrage (cochez la ou les cases correspondantes) :</legend>
            <div class="flex flex-col ml-8">
                <div class="flex flex-col">
                    <span><input type="checkbox" name="type_ouvrage_mais_indiv" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv'])==1 ? "checked=checked" : ""; ?>/> Maison individuelle</span>
                    <div class="flex flex-row text-gray-500 font-medium">
                        <span class="text-xs text-black font-normal">Présence d'une piscine ?</span> &ensp;&ensp;
                        <input type="radio" name="type_ouvrage_mais_indiv_piscine" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) && $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="1" ? "checked=checked" : ""; ?> onclick="showElement('situation_piscine')"/>
                        <label class="text-xs text-black ml-2"> Oui &ensp;</label>
                        <input type="radio" name="type_ouvrage_mais_indiv_piscine" value="0" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) && $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="0" ? "checked=checked" : ""; ?> onclick="hideElement('situation_piscine')"/>
                        <label class="text-xs text-black ml-2"> Non &ensp;</label>
                    </div>
                    <div id="situation_piscine" class="flex flex-col ml-6 <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) && $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="1" ? "" : "hidden"; ?>">
                        <span class="text-xs">Veuillez préciser sa situation (intérieure, extérieure,...) :</span>
                        <input type="text" name="type_ouvrage_mais_indiv_piscine_situation" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine_situation']) ? $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine_situation'] : ''?>" style="height:10px; width: 250px; border-radius:6px;" class="text-sm bg-gray-50"/>

                    </div>
                </div>
                <div>
                    <span><input type="checkbox" name="type_ouvrage_ope_pavill" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_ope_pavill'])==1 ? "checked=checked" : ""; ?>/> Opération pavillonnaire :</span><br />
                    <span class="text-xs">(nombre de maisons : 
                        <input type="text" name="type_ouvrage_ope_pavill_nombre" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_ope_pavill_nombre']) ? $_SESSION['info_operation_construction']['type_ouvrage_ope_pavill_nombre'] : ''?>" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50"/> )
                    </span>
                </div>
                <div>
                    <span><input type="checkbox" name="type_ouvrage_coll_habit" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_coll_habit'])==1 ? "checked=checked" : ""; ?>/> Collectif d'habitation :</span><br />
                    <span class="text-xs">(nombre d'appartements : 
                        <input type="text" name="type_ouvrage_coll_habit_nombre" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_coll_habit_nombre']) ? $_SESSION['info_operation_construction']['type_ouvrage_coll_habit_nombre'] : ''?>" style="height:10px; width: 60px; border-radius:6px;" class="text-sm bg-gray-50"/> )
                    </span>
                </div>
                <span>
                    <input type="checkbox" name="type_ouvrage_bat_indus" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_bat_indus'])==1 ? "checked=checked" : ""; ?>/> Bâtiment à usage industriel ou agricole
                </span>
                <div>
                    <span>
                        <input type="checkbox" name="type_ouvrage_centre_com" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_centre_com'])==1 ? "checked=checked" : ""; ?>/> Centre commercial, bâtiment à usage de vente :
                    </span><br />
                    <span class="text-xs">(superficie hors oeuvre nette (SHON) : 
                        <input type="text" name="type_ouvrage_centre_com_surf" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_centre_com_surf']) ? $_SESSION['info_operation_construction']['type_ouvrage_centre_com_surf'] : ''?>" style="height:10px; width:60px; border-radius:6px;" class="text-sm bg-gray-50"/> m²)
                    </span>
                </div>
            </div>
            <div class="flex flex-col ml-8">
                <span><input type="checkbox" name="type_ouvrage_bat_bur" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_bat_bur'])==1 ? "checked=checked" : ""; ?>/> Bâtiment à usage de bureau</span>
                <span><input type="checkbox" name="type_ouvrage_hopital" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_hopital'])==1 ? "checked=checked" : ""; ?>/> Bâtiment d'établissement Hospitalier, de Maison de retraite, Clinique</span>
                <span><input type="checkbox" name="type_ouvrage_vrd_privatif" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_vrd_privatif'])==1 ? "checked=checked" : ""; ?>/> Voirie réseaux Divers (VRD) à usage privatif d'un bâtiment</span>
                <div>
                    <span>
                        <input type="checkbox" name="type_ouvrage_autre_const" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_autre_const'])==1 ? "checked=checked" : ""; ?>/> Autre construction :
                    </span><br />
                    <span class="text-xs">(son usage : 
                        <input type="text" name="type_ouvrage_autre_const_usage" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_autre_const_usage']) ? $_SESSION['info_operation_construction']['type_ouvrage_autre_const_usage'] : ''?>" style="height:10px; width:200px; border-radius:6px;" class="text-sm bg-gray-50"/> )
                    </span>
                </div>
            </div>
        </fieldset>

        <!-- Adresse de la construction -->
        <div class="mt-10">
            <span class="text-gray-500 font-medium">Adresse de la construction</span>
            <div class="mx-8 my-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Escalier, résidence, bâtiment</label>
                <input type="text" name="construction_adresse_esc_res_bat" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_esc_res_bat']) ? $_SESSION['info_operation_construction']['construction_adresse_esc_res_bat'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </div>
            <div class="mx-8 my-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numéro et nom de la rue</label>
                <input type="text" name="construction_adresse_num_nom_rue" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_num_nom_rue']) ? $_SESSION['info_operation_construction']['construction_adresse_num_nom_rue'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
            </div>
            <div class="grid gap-6 mb-2 mx-8 md:grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lieu-dit</label>
                    <input type="text" name="construction_adresse_lieu_dit" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_lieu_dit']) ? $_SESSION['info_operation_construction']['construction_adresse_lieu_dit'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Arrondissement</label>
                    <input type="text" name="construction_adresse_arrond" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_arrond']) ? $_SESSION['info_operation_construction']['construction_adresse_arrond'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
            </div>
            <div class="grid gap-6 mb-2 mx-8 md:grid-cols-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code postal</label>
                    <input type="text" name="construction_adresse_code_postal" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_code_postal']) ? $_SESSION['info_operation_construction']['construction_adresse_code_postal'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Commune</label>
                    <input type="text" name="construction_adresse_commune" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_commune']) ? $_SESSION['info_operation_construction']['construction_adresse_commune'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                </div>
            </div>
        </div>

        <!-- Dates de l'opération de construction -->
        <div class="mt-10">
            <span class="text-gray-500 font-medium">Dates de l'opération de construction</span>
            <div class="mx-8 my-2">
                <div class="flex flex-row">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date d'ouverture de chantier</label>
                    <div> <!-- Infobulle -->
                        <button data-popover-target="date-operation-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                        <div data-popover id="date-operation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-3 space-y-2">
                                <p>Si la date n'est pas encore établie, entrez une date approximative</p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="date" name="construction_date_debut" value="<?= isset($_SESSION['info_operation_construction']['construction_date_debut']) ? $_SESSION['info_operation_construction']['construction_date_debut'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
            </div>
            <div class="mx-8 mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A défaut, date prévue de début</label>
                <input type="date" name="construction_date_debut_prevue" value="<?= isset($_SESSION['info_operation_construction']['construction_date_debut_prevue']) ? $_SESSION['info_operation_construction']['construction_date_debut_prevue'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
            </div>
            <div class="mx-8 mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date de réception prévisionnelle</label>
                <input type="date" name="construction_date_reception" value="<?= isset($_SESSION['info_operation_construction']['construction_date_reception']) ? $_SESSION['info_operation_construction']['construction_date_reception'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
            </div>
        </div>

        <!-- Coût de l'opération de construction -->
        <div class="mt-10">
            <span class="text-gray-500 font-medium">Coût de l'opération de construction</span>
            <div class="mx-8 my-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coût en €</label>
                <input type="text" name="construction_cout_operation" value="<?= isset($_SESSION['info_operation_construction']['construction_cout_operation']) ? $_SESSION['info_operation_construction']['construction_cout_operation'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
            </div>
            <div class="mx-8 my-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Honoraires du maitre d'oeuvre en €</label>
                <input type="text" name="construction_cout_honoraires_moe" value="<?= isset($_SESSION['info_operation_construction']['construction_cout_honoraires_moe']) ? $_SESSION['info_operation_construction']['construction_cout_honoraires_moe'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
            </div>
            <div class="mx-8 mt-4">
                <span class="text-sm font-medium text-gray-900">Comprend la TVA ? &ensp;&ensp;
                    <input type="radio" name="cout_operation_tva" value="1" <?= isset($_SESSION['info_operation_construction']['cout_operation_tva']) && ($_SESSION['info_operation_construction']['cout_operation_tva'])==1 ? "checked=checked" : ""; ?>/>
                    <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                    <input type="radio" name="cout_operation_tva" value="0" <?= isset($_SESSION['info_operation_construction']['cout_operation_tva']) && ($_SESSION['info_operation_construction']['cout_operation_tva'])==0 ? "checked=checked" : ""; ?>/>
                    <label class="text-gray-500 font-medium"> Non</label>
                </span>  
            </div>
        </div>



        <div class="flex flex-row justify-center mt-4">
            <!-- Bouton précédent -->                                          
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step2" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Précédent</button>
            </div>
            <!-- Bouton suivant -->
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step4" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="operation_construction">
    </form>
</section>