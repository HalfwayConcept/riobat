<section class="mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">
    <script src="public/script/s03-oper-construct.js"></script>
    <script>
    // Initialisation dynamique des blocs dépendants des toggles au chargement
    document.addEventListener('DOMContentLoaded', function() {
        // Nature de l'opération
        var toggleNature = document.getElementById('toggle_nature_neuf_exist');
        if (toggleNature && typeof handleToggleNatureNeufExist === 'function') {
            handleToggleNatureNeufExist(toggleNature);
        }
        // Surélévation
        var toggleSurelev = document.getElementById('toggle_surelev');
        if (toggleSurelev && typeof handleToggleSurelev === 'function') {
            handleToggleSurelev(toggleSurelev);
        }
        // Extension horizontale
        var toggleExtHorizont = document.getElementById('toggle_ext_horizont');
        if (toggleExtHorizont && typeof handleToggleExtHorizont === 'function') {
            handleToggleExtHorizont(toggleExtHorizont);
        }
        // Rénovation
        var toggleRenovation = document.getElementById('toggle_renovation');
        if (toggleRenovation && typeof handleToggleRenovation === 'function') {
            handleToggleRenovation(toggleRenovation);
        }
        // Réhabilitation
        var toggleRehabilitation = document.getElementById('toggle_rehabilitation');
        if (toggleRehabilitation && typeof handleToggleRehabilitation === 'function') {
            handleToggleRehabilitation(toggleRehabilitation);
        }
        // Sinistre
        var toggleSinistre = document.getElementById('toggle_operation_sinistre');
        if (toggleSinistre && typeof handleToggleSinistre === 'function') {
            handleToggleSinistre(toggleSinistre);
        }
        // Piscine
        var togglePiscine = document.getElementById('toggle_piscine');
        if (togglePiscine && typeof handleTogglePiscine === 'function') {
            handleTogglePiscine(togglePiscine);
        }
    });
    </script>
    <!-- Affichage des erreurs de validation -->
    <?php if (!empty($_SESSION['validation_errors'])): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <h4 class="font-bold mb-2">Erreurs de validation :</h4>
            <ul class="list-disc list-inside">
                <?php foreach ($_SESSION['validation_errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['validation_errors']); ?>
    <?php endif; ?>
    
    
    <form action="" method="post">
        <!-- SECTION 1 : Nature de l'opération -->
        <div>
            <h2 class="text-lg font-bold text-gray-900 mb-4">1. Nature de l'opération <span class="text-red-600">*</span></h2>
            <div class="flex flex-row items-center gap-6 mb-4">
                <span class="text-gray-700 font-medium">Construction neuve</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_nature_neuf_exist" class="sr-only peer" onchange="handleToggleNatureNeufExist(this)" 
                        <?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && $_SESSION['info_operation_construction']['nature_neuf_exist']=="existante" ? "checked=checked" : ""; ?> />
                    <div class="relative w-9 h-5 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-300 rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                </label>
                <span class="text-gray-700 font-medium">Travaux sur construction existante</span>
                <input type="radio" name="nature_neuf_exist" value="neuve" id="radio_nature_neuve" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && $_SESSION['info_operation_construction']['nature_neuf_exist']=="neuve" ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_neuf_exist']) ? "checked=checked" : ""); ?> />
                <input type="radio" name="nature_neuf_exist" value="existante" id="radio_nature_existante" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && $_SESSION['info_operation_construction']['nature_neuf_exist']=="existante" ? "checked=checked" : ""; ?> />
            </div>
            <?php if (isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && $_SESSION['info_operation_construction']['nature_neuf_exist']=="existante"): ?>
                <button type="button" data-popover-target="nature-operation-popup" class="text-blue-600 hover:text-blue-800 text-sm underline mt-2">
                    ℹ️ Consulter les explications
                </button>
            <?php endif; ?>
        </div>

        <!-- Popover - Nature de l'opération -->
        <div data-popover id="nature-operation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
            <div class="p-3 space-y-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">Rappel :</h3>
                <p>Le permis de construire est une autorisation délivrée à l'issue d'une procédure obligatoire destinée à vérifier la conformité d'un projet de bâtiment avec l'ensemble des dispositions législatives ou réglementaires en vigueur.</p>
            </div>
        </div>
        <!-- SECTION 2 : Détails des travaux sur construction existante -->
        <div id="nature_operation" class="<?= isset($_SESSION['info_operation_construction']['nature_neuf_exist']) && ($_SESSION['info_operation_construction']['nature_neuf_exist'])=="existante" ? "" : "hidden"; ?>">
            <h2 class="text-lg font-bold text-gray-900 mb-4">2. Détails des travaux existants</h2>
            
            <div>
                <!-- Surélévation -->
                <div class="flex flex-col my-4">
                    <div class="flex flex-row radio-right">
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
                        <div class="flex-1 flex justify-end">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_surelev" class="sr-only peer" onchange="handleToggleSurelev(this)" 
                                    <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && $_SESSION['info_operation_construction']['nature_operation_surelev']==1 ? "checked=checked" : ""; ?> />
                                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                <span id="surelev_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                    <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) ? ($_SESSION['info_operation_construction']['nature_operation_surelev']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                </span>
                            </label>
                            <input type="radio" name="nature_operation_surelev" value="1" id="radio_surelev_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && $_SESSION['info_operation_construction']['nature_operation_surelev']==1 ? "checked=checked" : ""; ?> />
                            <input type="radio" name="nature_operation_surelev" value="0" id="radio_surelev_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && $_SESSION['info_operation_construction']['nature_operation_surelev']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_surelev']) ? "checked=checked" : ""); ?> />
                        </div>
                    </div>
                    <div id="nature_operation_surelev_form" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_surelev']) && ($_SESSION['info_operation_construction']['nature_operation_surelev'])==1 ? "" : "hidden"; ?>">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reprise en sous-oeuvre / Travaux sur fondation ?</span>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="surelevation-sous-oeuvre-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="surelevation-sous-oeuvre-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Reprise en sous œuvre :  </h3>
                                            <p>Consolidation ou réfection de l'assise d'un ouvrage</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_sous_oeuvre" class="sr-only peer" onchange="handleToggleSousOeuvre(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) && $_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="sous_oeuvre_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) ? ($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_surelev_sous_oeuvre" value="1" id="radio_sous_oeuvre_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) && $_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_surelev_sous_oeuvre" value="0" id="radio_sous_oeuvre_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) && $_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_surelev_sous_oeuvre']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervention sur la structure existante (hors fondation) ?
                                    <div> <!-- Infobulle -->
                                        <button data-popover-target="surelevation-existant-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                        <div data-popover id="surelevation-existant-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                                <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_hors_fond" class="sr-only peer" onchange="handleToggleHorsFond(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) && $_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="hors_fond_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) ? ($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_surelev_hors_fond" value="1" id="radio_hors_fond_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) && $_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_surelev_hors_fond" value="0" id="radio_hors_fond_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) && $_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_surelev_hors_fond']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
     
        </div>
            
                <!-- Extension horizontale -->
                <div class="flex flex-col my-4">
                    <div class="flex flex-row radio-right">
                        <span class="text-gray-500 font-medium">D'une extension horizontale ?</span>
                        <div> <!-- Infobulle -->
                            <button data-popover-target="extension-horizont-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="extension-horizont-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Extension :   </h3>
                                    <p>Agrandissement d’un bâtiment par un autre bâtiment annexe</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 flex justify-end">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_ext_horizont" class="sr-only peer" onchange="handleToggleExtHorizont(this)" 
                                    <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && $_SESSION['info_operation_construction']['nature_operation_ext_horizont']==1 ? "checked=checked" : ""; ?> />
                                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                <span id="ext_horizont_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                    <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) ? ($_SESSION['info_operation_construction']['nature_operation_ext_horizont']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                </span>
                            </label>
                            <input type="radio" name="nature_operation_ext_horizont" value="1" id="radio_ext_horizont_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && $_SESSION['info_operation_construction']['nature_operation_ext_horizont']==1 ? "checked=checked" : ""; ?> />
                            <input type="radio" name="nature_operation_ext_horizont" value="0" id="radio_ext_horizont_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && $_SESSION['info_operation_construction']['nature_operation_ext_horizont']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) ? "checked=checked" : ""); ?> />
                        </div>
                    </div>

                    <div id="nature_operation_ext_horizont" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_ext_horizont']) && ($_SESSION['info_operation_construction']['nature_operation_ext_horizont'])==1 ? "" : "hidden"; ?> px-8 py-4">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">Intervention sur la structure existante y compris la fondation ?
                                    <button data-popover-target="extension-horizont-existante-popup" data-popover-placement="bottom-end" type="button" class="ml-2"><svg class="w-4 h-4 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                </span>
                                <div data-popover id="extension-horizont-existante-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <div class="p-3 space-y-2">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                        <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
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
                    <div class="flex flex-row radio-right">
                        <span class="text-gray-500 font-medium">D'une rénovation ?</span>
                        <div> <!-- Infobulle -->
                            <button data-popover-target="renovation-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="renovation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Rénovation :   </h3>
                                    <p>Remise en état sans changement de destination (elle peut faire l’objet d’autorisation), hors restauration. Par restauration, on entend l’intervention sur un bâtiment faisant l’objet d’une protection du patrimoine. Une question est prévue en lien : « intervention sur un bâtiment classé ».</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 flex justify-end">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_renovation" class="sr-only peer" onchange="handleToggleRenovation(this)" 
                                    <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && $_SESSION['info_operation_construction']['nature_operation_renovation']==1 ? "checked=checked" : ""; ?> />
                                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                <span id="renovation_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                    <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) ? ($_SESSION['info_operation_construction']['nature_operation_renovation']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                </span>
                            </label>
                            <input type="radio" name="nature_operation_renovation" value="1" id="radio_renovation_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && $_SESSION['info_operation_construction']['nature_operation_renovation']==1 ? "checked=checked" : ""; ?> />
                            <input type="radio" name="nature_operation_renovation" value="0" id="radio_renovation_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && $_SESSION['info_operation_construction']['nature_operation_renovation']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_renovation']) ? "checked=checked" : ""); ?> />
                        </div>
                    </div>
                    <div id="nature_operation_renovation" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_renovation']) && ($_SESSION['info_operation_construction']['nature_operation_renovation'])==1 ? "" : "hidden"; ?> px-8 py-4">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center">Intervention sur la structure existante y compris la fondation ?
                                    <button data-popover-target="renovation-existante-popup" data-popover-placement="bottom-end" type="button" class="ml-2"><svg class="w-4 h-4 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                </span>
                                <div data-popover id="renovation-existante-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                    <div class="p-3 space-y-2">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                        <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                    </div>
                                </div>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_renovation_fond" class="sr-only peer" onchange="handleToggleRenovationFond(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) && $_SESSION['info_operation_construction']['nature_operation_renovation_fond']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="renovation_fond_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) ? ($_SESSION['info_operation_construction']['nature_operation_renovation_fond']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_renovation_fond" value="1" id="radio_renovation_fond_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) && $_SESSION['info_operation_construction']['nature_operation_renovation_fond']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_renovation_fond" value="0" id="radio_renovation_fond_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) && $_SESSION['info_operation_construction']['nature_operation_renovation_fond']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_renovation_fond']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Isolation thermique extérieure ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_renovation_iso_therm" class="sr-only peer" onchange="handleToggleRenovationIsoTherm(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) && $_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="renovation_iso_therm_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) ? ($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_renovation_iso_therm" value="1" id="radio_renovation_iso_therm_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) && $_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_renovation_iso_therm" value="0" id="radio_renovation_iso_therm_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) && $_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_renovation_iso_therm']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Réfection de toiture ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_renovation_refect_toit" class="sr-only peer" onchange="handleToggleRenovationRefectToit(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) && $_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="renovation_refect_toit_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) ? ($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_renovation_refect_toit" value="1" id="radio_renovation_refect_toit_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) && $_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_renovation_refect_toit" value="0" id="radio_renovation_refect_toit_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) && $_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_renovation_refect_toit']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Travaux d'étanchéité ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_renovation_etancheite" class="sr-only peer" onchange="handleToggleRenovationEtancheite(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) && $_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="renovation_etancheite_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) ? ($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_renovation_etancheite" value="1" id="radio_renovation_etancheite_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) && $_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_renovation_etancheite" value="0" id="radio_renovation_etancheite_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) && $_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_renovation_etancheite']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                            <div class="flex flex-row py-2 radio-right">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ravalement de façade ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_renovation_ravalement" class="sr-only peer" onchange="handleToggleRenovationRavalement(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) && $_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="renovation_ravalement_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) ? ($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_renovation_ravalement" value="1" id="radio_renovation_ravalement_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) && $_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_renovation_ravalement" value="0" id="radio_renovation_ravalement_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) && $_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_renovation_ravalement']) ? "checked=checked" : ""); ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Réhabilitation -->
                <div class="my-4">
                    <span class="text-gray-500 font-medium">D'une réhabilitation ?</span>
                    <div class="flex-1 flex justify-end">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_rehabilitation" class="sr-only peer" onchange="handleToggleRehabilitation(this)"
                                <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation']==1 ? "checked=checked" : ""; ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                            <span id="rehabilitation_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) ? ($_SESSION['info_operation_construction']['nature_operation_rehabilitation']==1 ? 'Oui' : 'Non') : 'Non' ?>
                            </span>
                        </label>
                        <input type="radio" name="nature_operation_rehabilitation" value="1" id="radio_rehabilitation_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation']==1 ? "checked=checked" : ""; ?> />
                        <input type="radio" name="nature_operation_rehabilitation" value="0" id="radio_rehabilitation_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) ? "checked=checked" : ""); ?> />
                    </div>
                    <div id="nature_operation_rehabilitation" class="<?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation']) && ($_SESSION['info_operation_construction']['nature_operation_rehabilitation'])==1 ? "" : "hidden"; ?> px-8 py-4">
                        <div class="mb-2 md:grid-cols-2">
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervention sur la structure existante y compris la fondation ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_rehabilitation_fond" class="sr-only peer" onchange="handleToggleRehabilitationFond(this)"
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="rehabilitation_fond_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) ? ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_rehabilitation_fond" value="1" id="radio_rehabilitation_fond_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_rehabilitation_fond" value="0" id="radio_rehabilitation_fond_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_fond']) ? "checked=checked" : ""); ?> />
                                </div>
                                <div> <!-- Infobulle -->
                                    <button data-popover-target="extension-popup" data-popover-placement="bottom-end" type="button" class="mx-6"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                                    <div data-popover id="extension-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                        <div class="p-3 space-y-2">
                                            <h3 class="font-semibold text-gray-900 dark:text-white">Intervention sur la structure existante :   </h3>
                                            <p>Sont visés tous les travaux :<br> - avec intervention quelle qu'elle soit, sur des éléments structurels, et/ou <br>- consistant en la suppression de poteaux, de poutres ou d'éléments structurels.<br><br>Exemples d'intervention sur la structure existante : <br> - lors d'une surélévation : création d'une nouvelle poutre ou poteau dans la partie existante qui pourra charger ou sous-charger certain élément existant <br> - lors d'une extension horizontale : nouvelle dalle repose sur un voile ou poutre existant ce qui engendrera une surcharge sur la fondation existante <br> - lors d'une rénovation : remplacement d'un mur porteur par une poutre IPN</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Isolation thermique extérieure ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_rehab_iso_therm" class="sr-only peer" onchange="handleToggleRehabIsoTherm(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="rehab_iso_therm_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) ? ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_rehabilitation_iso_therm" value="1" id="radio_rehab_iso_therm_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_rehabilitation_iso_therm" value="0" id="radio_rehab_iso_therm_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_iso_therm']) ? "checked=checked" : ""); ?> />
                                </div>

                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Réfection de toiture ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_rehab_refect_toit" class="sr-only peer" onchange="handleToggleRehabRefectToit(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="rehab_refect_toit_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) ? ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_rehabilitation_refect_toit" value="1" id="radio_rehab_refect_toit_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_rehabilitation_refect_toit" value="0" id="radio_rehab_refect_toit_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_refect_toit']) ? "checked=checked" : ""); ?> />
                                </div>

                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Travaux d'étanchéité ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_rehab_etancheite" class="sr-only peer" onchange="handleToggleRehabEtancheite(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="rehab_etancheite_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) ? ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_rehabilitation_etancheite" value="1" id="radio_rehab_etancheite_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_rehabilitation_etancheite" value="0" id="radio_rehab_etancheite_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_etancheite']) ? "checked=checked" : ""); ?> />
                                </div>

                            </div>
                            <div class="flex flex-row py-2">
                                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ravalement de façade ?</span>
                                <div class="flex-1 flex justify-end">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="toggle_rehab_ravalement" class="sr-only peer" onchange="handleToggleRehabRavalement(this)" 
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']==1 ? "checked=checked" : ""; ?> />
                                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                        <span id="rehab_ravalement_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                            <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) ? ($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                        </span>
                                    </label>
                                    <input type="radio" name="nature_operation_rehabilitation_ravalement" value="1" id="radio_rehab_ravalement_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']==1 ? "checked=checked" : ""; ?> />
                                    <input type="radio" name="nature_operation_rehabilitation_ravalement" value="0" id="radio_rehab_ravalement_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) && $_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['nature_operation_rehabilitation_ravalement']) ? "checked=checked" : ""); ?> />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-10">
                <div class="flex flex-row items-center gap-4">
                    <span class="text-gray-500 font-medium">S'agit-il d'une réparation suite à sinistre ?</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_operation_sinistre" class="sr-only peer" onchange="handleToggleSinistre(this)" 
                            <?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && $_SESSION['info_operation_construction']['operation_sinistre']==1 ? "checked=checked" : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="sinistre_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_operation_construction']['operation_sinistre']) ? ($_SESSION['info_operation_construction']['operation_sinistre']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="operation_sinistre" value="1" id="radio_sinistre_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && $_SESSION['info_operation_construction']['operation_sinistre']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="operation_sinistre" value="0" id="radio_sinistre_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && $_SESSION['info_operation_construction']['operation_sinistre']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['operation_sinistre']) ? "checked=checked" : ""); ?> />
                </div>
                <div id="operation_sinistre_champ_descr" class="<?= isset($_SESSION['info_operation_construction']['operation_sinistre']) && $_SESSION['info_operation_construction']['operation_sinistre']==1 ? "" : "hidden"; ?> ml-10 mt-4 ">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez décrire le sinistre :&ensp;&ensp;</label>
                    <input type="text" name="operation_sinistre_descr" value="<?= isset($_SESSION['info_operation_construction']['operation_sinistre_descr']) ? htmlspecialchars($_SESSION['info_operation_construction']['operation_sinistre_descr']) : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
            </div>
        </div>

        <!-- Checkboxes "Type d'ouvrage"-->
        <fieldset class="flex flex-col lg:flex-row mb-2 mt-10">
            <legend class="mb-2 text-gray-500 font-medium">Type de l'ouvrage (cochez la ou les cases correspondantes) :</legend>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-2 ml-8">
                <!-- Maison individuelle -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_mais_indiv" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv'])==1 ? "checked=checked" : ""; ?> id="chk_mais_indiv"/>
                    <label for="chk_mais_indiv" class="ml-2">Maison individuelle</label>
                </div>
                <div class="flex items-center">
                    <span class="text-xs text-black font-normal mr-2">Présence d'une piscine ?</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_piscine" class="sr-only peer" name="type_ouvrage_mais_indiv_piscine" value="1"
                            onchange="handleTogglePiscine(this)"
                            <?= (isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) && $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="1") ? "checked=checked" : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="piscine_value" class="select-none ms-3 text-xs font-medium text-gray-900">
                            <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) ? ($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="1" ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="type_ouvrage_mais_indiv_piscine" value="1" id="radio_piscine_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) && $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="1" ? "checked=checked" : ""; ?> />
                    <input type="radio" name="type_ouvrage_mais_indiv_piscine" value="0" id="radio_piscine_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) && $_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']=="0" ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['type_ouvrage_mais_indiv_piscine']) ? "checked=checked" : ""); ?> />
                </div>
                <!-- Opération pavillonnaire -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_ope_pavill" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_ope_pavill'])==1 ? "checked=checked" : ""; ?> id="chk_ope_pavill"/>
                    <label for="chk_ope_pavill" class="ml-2">Opération pavillonnaire</label>
                </div>
                <div class="flex items-center">
                    <span class="text-xs mr-2">nombre de maisons :</span>
                    <input type="text" name="type_ouvrage_ope_pavill_nombre" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_ope_pavill_nombre']) ? $_SESSION['info_operation_construction']['type_ouvrage_ope_pavill_nombre'] : ''?>" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 text-xs"/>
                </div>
                <!-- Collectif d'habitation -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_coll_habit" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_coll_habit'])==1 ? "checked=checked" : ""; ?> id="chk_coll_habit"/>
                    <label for="chk_coll_habit" class="ml-2">Collectif d'habitation</label>
                </div>
                <div class="flex items-center">
                    <span class="text-xs mr-2">nombre d'appartements :</span>
                    <input type="text" name="type_ouvrage_coll_habit_nombre" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_coll_habit_nombre']) ? $_SESSION['info_operation_construction']['type_ouvrage_coll_habit_nombre'] : ''?>" style="height:10px; width: 60px; border-radius:6px;" class="bg-gray-50 text-xs"/>
                </div>
                <!-- Bâtiment à usage industriel ou agricole -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_bat_indus" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_bat_indus'])==1 ? "checked=checked" : ""; ?> id="chk_bat_indus"/>
                    <label for="chk_bat_indus" class="ml-2">Bâtiment à usage industriel ou agricole</label>
                </div>
                <div></div>
                <!-- Centre commercial, bâtiment à usage de vente -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_centre_com" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_centre_com'])==1 ? "checked=checked" : ""; ?> id="chk_centre_com"/>
                    <label for="chk_centre_com" class="ml-2">Centre commercial, bâtiment à usage de vente</label>
                </div>
                <div class="flex items-center">
                    <span class="text-xs mr-2">superficie hors oeuvre nette (SHON) :</span>
                    <input type="text" name="type_ouvrage_centre_com_surf" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_centre_com_surf']) ? $_SESSION['info_operation_construction']['type_ouvrage_centre_com_surf'] : ''?>" style="height:10px; width:60px; border-radius:6px;" class="bg-gray-50 text-xs"/> m²
                </div>
                <!-- Bâtiment à usage de bureau -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_bat_bur" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_bat_bur'])==1 ? "checked=checked" : ""; ?> id="chk_bat_bur"/>
                    <label for="chk_bat_bur" class="ml-2">Bâtiment à usage de bureau</label>
                </div>
                <div></div>
                <!-- Bâtiment d'établissement Hospitalier, de Maison de retraite, Clinique -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_hopital" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_hopital'])==1 ? "checked=checked" : ""; ?> id="chk_hopital"/>
                    <label for="chk_hopital" class="ml-2">Bâtiment d'établissement Hospitalier, de Maison de retraite, Clinique</label>
                </div>
                <div></div>
                <!-- Voirie réseaux Divers (VRD) à usage privatif d'un bâtiment -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_vrd_privatif" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_vrd_privatif'])==1 ? "checked=checked" : ""; ?> id="chk_vrd_privatif"/>
                    <label for="chk_vrd_privatif" class="ml-2">Voirie réseaux Divers (VRD) à usage privatif d'un bâtiment</label>
                </div>
                <div></div>
                <!-- Autre construction -->
                <div class="flex items-center col-span-2">
                    <input type="checkbox" name="type_ouvrage_autre_const" value="1" <?= isset($_SESSION['info_operation_construction']['type_ouvrage_autre_const'])==1 ? "checked=checked" : ""; ?> id="chk_autre_const"/>
                    <label for="chk_autre_const" class="ml-2">Autre construction</label>
                </div>
                <div class="flex items-center">
                    <span class="text-xs mr-2">son usage :</span>
                    <input type="text" name="type_ouvrage_autre_const_usage" value="<?= isset($_SESSION['info_operation_construction']['type_ouvrage_autre_const_usage']) ? $_SESSION['info_operation_construction']['type_ouvrage_autre_const_usage'] : ''?>" style="height:10px; width:200px; border-radius:6px;" class="bg-gray-50 text-xs"/>
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
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numéro et nom de la rue <span class="text-red-600">*</span></label>
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
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code postal <span class="text-red-600">*</span></label>
                    <input type="text" name="construction_adresse_code_postal" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_code_postal']) ? $_SESSION['info_operation_construction']['construction_adresse_code_postal'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Commune <span class="text-red-600">*</span></label>
                    <input type="text" name="construction_adresse_commune" value="<?= isset($_SESSION['info_operation_construction']['construction_adresse_commune']) ? $_SESSION['info_operation_construction']['construction_adresse_commune'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                </div>
            </div>
        </div>

        <!-- Dates et coût de l'opération de construction sur 2 colonnes -->
        <div class="mt-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Colonne Dates -->
                <div>
                    <span class="text-gray-500 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Dates de l'opération de construction
                    </span>
                    <div class="mx-2 my-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white flex items-center gap-2">Date d'ouverture de chantier
                            <span class="text-red-600">*</span>
                            <button data-popover-target="date-operation-popup" data-popover-placement="bottom-end" type="button" class="mx-2"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg></button>
                            <div data-popover id="date-operation-popup" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Date d'ouverture de chantier :</h3>
                                    <p>Indiquez la date réelle ou prévue d'ouverture du chantier. Cette information est importante pour le suivi du projet et la planification des étapes de construction.</p>
                                </div>
                            </div>
                        </label>
                        <input type="date" name="construction_date_debut" value="<?= isset($_SESSION['info_operation_construction']['construction_date_debut']) ? $_SESSION['info_operation_construction']['construction_date_debut'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                    </div>
                    <div class="mx-2 my-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">A défaut, date prévue de début</label>
                        <input type="date" name="construction_date_debut_prevue" value="<?= isset($_SESSION['info_operation_construction']['construction_date_debut_prevue']) ? $_SESSION['info_operation_construction']['construction_date_debut_prevue'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div class="mx-2 my-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date de réception prévisionnelle <span class="text-red-600">*</span></label>
                        <input type="date" name="construction_date_reception" value="<?= isset($_SESSION['info_operation_construction']['construction_date_reception']) ? $_SESSION['info_operation_construction']['construction_date_reception'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                    </div>
                </div>
                <!-- Colonne Coût -->
                <div>
                    <span class="text-gray-500 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-4.41 0-8-1.79-8-4V6c0-2.21 3.59-4 8-4s8 1.79 8 4v8c0 2.21-3.59 4-8 4z"/></svg>
                        Coût de l'opération de construction
                    </span>
                    <div class="mx-2 my-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Coût en € <span class="text-red-600">*</span></label>
                        <input type="text" name="construction_cout_operation" value="<?= isset($_SESSION['info_operation_construction']['construction_cout_operation']) ? $_SESSION['info_operation_construction']['construction_cout_operation'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                    </div>
                    <div class="mx-2 my-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Honoraires du maitre d'oeuvre en € <span class="text-red-600">*</span></label>
                        <input type="text" name="construction_cout_honoraires_moe" value="<?= isset($_SESSION['info_operation_construction']['construction_cout_honoraires_moe']) ? $_SESSION['info_operation_construction']['construction_cout_honoraires_moe'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required/>
                    </div>
                    <div class="mx-2 mt-4">
                        <div class="flex flex-row items-center gap-4">
                            <span class="text-sm font-medium text-gray-900">Comprend la TVA ?</span>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_cout_operation_tva" class="sr-only peer" onchange="handleToggleTva(this)" 
                                    <?= isset($_SESSION['info_operation_construction']['cout_operation_tva']) && $_SESSION['info_operation_construction']['cout_operation_tva']==1 ? "checked=checked" : ""; ?> />
                                <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                                <span id="tva_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                    <?= isset($_SESSION['info_operation_construction']['cout_operation_tva']) ? ($_SESSION['info_operation_construction']['cout_operation_tva']==1 ? 'Oui' : 'Non') : 'Non' ?>
                                </span>
                            </label>
                            <input type="radio" name="cout_operation_tva" value="1" id="radio_tva_oui" class="hidden" <?= isset($_SESSION['info_operation_construction']['cout_operation_tva']) && $_SESSION['info_operation_construction']['cout_operation_tva']==1 ? "checked=checked" : ""; ?> />
                            <input type="radio" name="cout_operation_tva" value="0" id="radio_tva_non" class="hidden" <?= isset($_SESSION['info_operation_construction']['cout_operation_tva']) && $_SESSION['info_operation_construction']['cout_operation_tva']==0 ? "checked=checked" : (!isset($_SESSION['info_operation_construction']['cout_operation_tva']) ? "checked=checked" : ""); ?> />
                        </div>
                    </div>
                </div>
            </div>
        </div>
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