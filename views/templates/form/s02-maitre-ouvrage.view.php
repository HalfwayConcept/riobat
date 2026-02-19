<section class="mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">
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
        <!-- Formulaire caché : "Maitre d'ouvrage est-il le souscripteur ?"-->
        <div>
            <div class="flex flex-col lg:flex-row gap-4 items-center">
                <div class="lg:w-2/3">
                    <span class="text-gray-500 font-medium">Le Maitre d'Ouvrage est-il le souscripteur ?</span>
                </div>
                <div class="lg:w-1/3">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_moa_souscripteur" class="sr-only peer" <?= isset($_SESSION['info_moa']['moa_souscripteur']) ? ($_SESSION['info_moa']['moa_souscripteur']==1 ? "checked=checked" : "") : "checked=checked"; ?> onchange="handleToggleSouscripteur(this)"/>
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span class="select-none ms-3 text-sm font-medium text-heading" id="moa_souscripteur_value"><?= isset($_SESSION['info_moa']['moa_souscripteur']) ? ($_SESSION['info_moa']['moa_souscripteur']==1 ? 'Oui' : 'Non') : 'Oui' ?></span>
                    </label>
                </div>
                <input type="radio" name="moa_souscripteur" value="1" id="radio_moa_souscripteur_oui" class="hidden" <?= isset($_SESSION['info_moa']['moa_souscripteur']) ? ($_SESSION['info_moa']['moa_souscripteur']==1 ? "checked=checked" : "") : "checked=checked"; ?> onclick="hideElement('moa_form','moa')"/>
                <input type="radio" name="moa_souscripteur" value="0" id="radio_moa_souscripteur_non" class="hidden" <?= isset($_SESSION['info_moa']['moa_souscripteur']) && ($_SESSION['info_moa']['moa_souscripteur'])==0 ? "checked=checked" : ""; ?> onclick="showElement('moa_form','moa')"/>
            </div>
            <script>
            function handleToggleSouscripteur(checkbox) {
                const radioOui = document.getElementById('radio_moa_souscripteur_oui');
                const radioNon = document.getElementById('radio_moa_souscripteur_non');
                const spanValue = document.getElementById('moa_souscripteur_value');
                if (checkbox.checked) {
                    radioOui.checked = true;
                    spanValue.textContent = 'Oui';
                    hideElement('moa_form','moa');
                } else {
                    radioNon.checked = true;
                    spanValue.textContent = 'Non';
                    showElement('moa_form','moa');
                }
            }
            </script>  
            <div id="moa_form" class="<?= isset($_SESSION['info_moa']['moa_souscripteur']) && ($_SESSION['info_moa']['moa_souscripteur'])==0 ? "" : "hidden"; ?> px-8 py-4">
                <div class="mb-6 md:grid-cols-2">
                    <div class="flex flex-row py-4 items-center gap-4">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Civilité :</span>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium text-gray-700">Particulier</span>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="toggle_moa_civilite" class="sr-only peer" <?= isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && ($_SESSION['info_moa']['moa_souscripteur_form_civilite'])=="entreprise" ? "checked=checked" : ""; ?> onchange="handleToggleCivilite(this)"/>
                                <div class="relative w-9 h-5 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-300 rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                            <span class="text-sm font-medium text-gray-700">Entreprise</span>
                        </div>
                        <input type="radio" name="moa_souscripteur_form_civilite" value="particulier" id="radio_moa_civilite_particulier" class="hidden" <?= isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && ($_SESSION['info_moa']['moa_souscripteur_form_civilite'])=="particulier" ? "checked=checked" : ""; ?>/>
                        <input type="radio" name="moa_souscripteur_form_civilite" value="entreprise" id="radio_moa_civilite_entreprise" class="hidden" <?= isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && ($_SESSION['info_moa']['moa_souscripteur_form_civilite'])=="entreprise" ? "checked=checked" : ""; ?>/>
                    </div>
                    <script>
                    function handleToggleCivilite(checkbox) {
                        const radioParticulier = document.getElementById('radio_moa_civilite_particulier');
                        const radioEntreprise = document.getElementById('radio_moa_civilite_entreprise');
                        if (checkbox.checked) {
                            radioEntreprise.checked = true;
                            showElement('siret_champ');
                            showElement('raison_champ');
                        } else {
                            radioParticulier.checked = true;
                            hideElement('siret_champ');
                            hideElement('raison_champ');
                        }
                    }
                    </script>
                    <div class="py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom, Prénom <span class="text-red-600">*</span></label>
                        <input type="text" name="moa_souscripteur_form_nom_prenom" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_nom_prenom']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_nom_prenom']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>

                    <div id="raison_champ" class="hidden py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison sociale</label>
                        <input type="text" id="moa_souscripteur_form_raison_sociale" name="moa_souscripteur_form_raison_sociale" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_raison_sociale']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_raison_sociale']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div id="siret_champ" class="hidden py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SIRET n°</label>
                        <input type="text" name="moa_souscripteur_form_siret" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_siret']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_siret']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>
            </div>
        </div>


                <!-- Bloc Dates et Coût de l'opération supprimé -->
        <div class="my-16">
            <h3 class="mb-2 text-gray-500 font-medium">Qualité du maitre d'ouvrage (choisissez l'option correspondante) : <span class="text-red-600">*</span></h3>
            <?php
                require_once __DIR__ . '/../../../models/moa_qualite.model.php';
                $moa_qualites = getAllMoaQualites();
                $selected_qualite = isset($_SESSION['info_moa']['moa_qualite']) ? $_SESSION['info_moa']['moa_qualite'] : '';
            ?>
            <div class="flex flex-col mx-6 mb-2">
                <div class="flex flex-col ml-8">
                    <select id="moa_qualite_select" name="moa_qualite" class="block w-full bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-4 py-3.5 shadow-xs placeholder:text-body mb-4" required onchange="toggleMoaQualiteAutre(this)">
                        <option value="" disabled <?= $selected_qualite=='' ? 'selected' : '' ?>>Sélectionnez une qualité</option>
                        <?php foreach ($moa_qualites as $qualite): ?>
                            <option value="<?= $qualite['id'] ?>" <?= ($selected_qualite == $qualite['id']) ? 'selected' : '' ?>><?= htmlspecialchars($qualite['label']) ?></option>
                        <?php endforeach; ?>
                        <option value="999" <?= ($selected_qualite == 999) ? 'selected' : '' ?>>Autre qualité</option>
                    </select>
                    <div id="moa_qualite_autre_div" class="<?= ($selected_qualite == 999 ) ? '' : 'hidden' ?> mt-2">
                        <input type="text" name="moa_qualite_autre" value="<?= isset($_SESSION['info_moa']['moa_qualite_champ']) ? htmlspecialchars($_SESSION['info_moa']['moa_qualite_champ']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Veuillez préciser"/>
                    </div>
                </div>
            </div>
            <script>
            function toggleMoaQualiteAutre(select) {
                var autre = document.getElementById('moa_qualite_autre_div');
                if (select.value === '999') {
                    autre.classList.remove('hidden');
                } else {
                    autre.classList.add('hidden');
                }
            }
            </script>
        </div>


        <!-- Formulaire caché : "Maitre d'ouvrage participe t-il à la construction ?"-->
        <div>
            <div class="flex flex-col lg:flex-row gap-4 items-center text-gray-500 font-medium">
                <span class="lg:w-2/3">Le Maitre d'Ouvrage participe à la construction ? <span class="text-red-600">*</span></span>
                <div class="lg:w-1/3">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_moa_construction" class="sr-only peer" <?= isset($_SESSION['info_moa']['moa_construction']) ? ($_SESSION['info_moa']['moa_construction']==1 ? "checked=checked" : "") : ""; ?> onchange="handleToggleConstruction(this)"/>
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="moa_construction_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= isset($_SESSION['info_moa']['moa_construction']) ? ($_SESSION['info_moa']['moa_construction']==1 ? 'Oui' : 'Non') : 'Non' ?></span>
                    </label>
                </div>
                <input type="radio" name="moa_construction" value="1" id="radio_moa_construction_oui" class="hidden" <?= isset($_SESSION['info_moa']['moa_construction']) ? ($_SESSION['info_moa']['moa_construction']==1 ? "checked=checked" : "") : ""; ?> />
                <input type="radio" name="moa_construction" value="0" id="radio_moa_construction_non" class="hidden" <?= isset($_SESSION['info_moa']['moa_construction']) ? ($_SESSION['info_moa']['moa_construction']==0 ? "checked=checked" : "") : "checked=checked"; ?> />
            </div>
            <script>
            function handleToggleConstruction(checkbox) {
                const radioOui = document.getElementById('radio_moa_construction_oui');
                const radioNon = document.getElementById('radio_moa_construction_non');
                const spanValue = document.getElementById('moa_construction_value');
                if (checkbox.checked) {
                    radioOui.checked = true;
                    spanValue.textContent = 'Oui';
                    showElement('moa_construction_form');
                    showElement('moa_construction_pro_tableau');
                } else {
                    radioNon.checked = true;
                    spanValue.textContent = 'Non';
                    hideElement('moa_construction_form');
                    hideElement('moa_construction_pro_tableau');
                }
            }
            </script>
            <div id="moa_construction_form" class="<?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==1 ? "" : "hidden"; ?> py-4">
                <div class="flex flex-row p-2 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <p class="text-gray-900 text-sm block w-full p-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">La clause contrat n°001 des Conventions Spéciales n°811 "Intervention du maître d'ouvrage dans la conception, la direction, la surveillance ou la réalisation des travaux" est obligatoirement souscrite.</p>
                </div>
                <div class="mb-6">
                    <div class="flex flex-row items-center gap-4">
                        <span class="text-gray-500 font-medium">Le Maitre d'Ouvrage est-il un professionnel de la construction ? &ensp;&ensp; </span>
                        <div> <!-- Infobulle -->
                            <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button" class="mr-2"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Conditions d'acceptation : </h3>
                                    <p>Si le maître d'ouvrage n'a pas la qualité de professionnel de la construction, seuls les travaux de papiers peints et/ou de peintures intérieures sont acceptés sans cotisation supplémentaire avec souscription de la CC 001. S'il intervient sur d'autres travaux, l'affaire doit être refusée.<br><br>Si le maître d'ouvrage a la qualité de professionnel de la construction, les travaux de papiers peints et/ou de peintures intérieures sont acceptés sans cotisation supplémentaire avec souscription de la CC 001. S'il intervient sur d'autres travaux, consulter votre interlocuteur société.</p>
                                </div>
                            </div>
                        </div>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_moa_construction_pro" class="sr-only peer" <?= isset($_SESSION['info_moa']['moa_construction_pro']) ? ($_SESSION['info_moa']['moa_construction_pro']==1 ? "checked=checked" : "") : ""; ?> onchange="handleToggleConstructionPro(this)"/>
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                            <span class="select-none ms-3 text-sm font-medium text-gray-900" id="moa_construction_pro_value"><?= isset($_SESSION['info_moa']['moa_construction_pro']) ? ($_SESSION['info_moa']['moa_construction_pro']==1 ? 'Oui' : 'Non') : 'Non' ?></span>
                        </label>
                        <input type="radio" name="moa_construction_pro" value="1" id="radio_moa_construction_pro_oui" class="hidden" <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==1 ? "checked=checked" : ""; ?> required/>
                        <input type="radio" name="moa_construction_pro" value="0" id="radio_moa_construction_pro_non" class="hidden" <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==0 ? "checked=checked" : "checked=checked"; ?> required/>
                    </div>
                    <script>
                    function handleToggleConstructionPro(checkbox) {
                        const radioOui = document.getElementById('radio_moa_construction_pro_oui');
                        const radioNon = document.getElementById('radio_moa_construction_pro_non');
                        const spanValue = document.getElementById('moa_construction_pro_value');
                        if (checkbox.checked) {
                            radioOui.checked = true;
                            spanValue.textContent = 'Oui';
                            showElement('moa_construction_pro_form');
                        } else {
                            radioNon.checked = true;
                            spanValue.textContent = 'Non';
                            hideElement('moa_construction_pro_form');
                        }
                    }
                    </script>
                    <div id="moa_construction_pro_form" class="py-4 <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==1 ? "" : "hidden"; ?> mx-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa profession :</label>
                        <input type="text" name="moa_construction_pro_champ" value="<?= isset($_SESSION['info_moa']['moa_construction_pro_champ']) ? htmlspecialchars($_SESSION['info_moa']['moa_construction_pro_champ']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                </div>
                <div id="moa_construction_pro_tableau" class="<?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==1 ? "" : "hidden"; ?> mt-10">
                    <span class="text-gray-500 font-medium">Complétez le tableau ci-dessous en cochant les cases correspondantes :</span>
                    <table class="text-sm font-light ml-6 mt-4">
                        <tr>
                            <td></td>
                            <td class="bg-gray-50 border-t-2 border-b-2 border-l-2 border-gray-300 p-2"></td>
                            <td class="bg-gray-50 border-t-2 border-b-2 border-gray-300 p-2">Nature des travaux</td>
                            <td class="bg-gray-50 border-t-2 border-b-2 border-r-2 border-gray-300 p-2"></td>
                        </tr>
                        <tr class="bg-gray-50 border-b-2 border-l-2 border-r-2 border-gray-300">
                            <td class="border-t-2 border-r-2 border-gray-300 text-center p-2">Activité ou mission exercée</td>
                            <td class="border-r-2 border-gray-300 text-center p-2">Papiers peints<br>et/ou Peintures intérieures</td>
                            <td class="border-r-2 border-gray-300 text-center p-2">Gros oeuvre fondations,<br>Charpente - Couverture, Etanchéité</td>
                            <td class="p-2">Autres travaux</td>
                            <td class="border-2 border-gray-300 text-center p-2">(autres travaux: précisez)</td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-l-2 border-b border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception'])==1 ? "checked=checked" : ""; ?> name="moa_conception"/>
                                <label>&ensp; Conception</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception_1'])==1 ? "checked=checked" : ""; ?> name="moa_conception_1"/></td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception_2'])==1 ? "checked=checked" : ""; ?> name="moa_conception_2"/></td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception_3'])==1 ? "checked=checked" : ""; ?> name="moa_conception_3"/></td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" name="moa_conception_4" value="<?= isset($_SESSION['info_moa']['moa_conception_4']) ? htmlspecialchars($_SESSION['info_moa']['moa_conception_4']) : ''?>"/></td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-b border-l-2 border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_direction'])==1 ? "checked=checked" : ""; ?> name="moa_direction"/>
                                <label>&ensp; Direction</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1"  <?= isset($_SESSION['info_moa']['moa_direction_1'])==1 ? "checked=checked" : ""; ?> name="moa_direction_1"/>

                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_direction_2'])==1 ? "checked=checked" : ""; ?> name="moa_direction_2"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_direction_3'])==1 ? "checked=checked" : ""; ?> name="moa_direction_3"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" value="<?= isset($_SESSION['info_moa']['moa_direction_4']) ? htmlspecialchars($_SESSION['info_moa']['moa_direction_4']) : ''?>" name="moa_direction_4"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-b border-l-2 border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance'])==1 ? "checked=checked" : ""; ?>  name="moa_surveillance"/>
                                <label>&ensp; Surveillance</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance_1'])==1 ? "checked=checked" : ""; ?>  name="moa_surveillance_1"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance_2'])==1 ? "checked=checked" : ""; ?>  name="moa_surveillance_2"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance_3'])==1 ? "checked=checked" : ""; ?> name="moa_surveillance_3"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" name="moa_surveillance_4" value="<?= isset($_SESSION['info_moa']['moa_surveillance_4']) ? htmlspecialchars($_SESSION['info_moa']['moa_surveillance_4']) : ''?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-l-2 border-b-2 border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution'])==1 ? "checked=checked" : ""; ?> name="moa_execution"/>
                                <label>&ensp; Exécution</label>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution_1'])==1 ? "checked=checked" : ""; ?> name="moa_execution_1"/>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution_2'])==1 ? "checked=checked" : ""; ?> name="moa_execution_2"/>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution_3'])==1 ? "checked=checked" : ""; ?> name="moa_execution_3"/>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="text" name="moa_execution_4" value="<?= isset($_SESSION['info_moa']['moa_execution_4']) ? htmlspecialchars($_SESSION['info_moa']['moa_execution_4']) : ''?>"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <!-- Bouton précédent -->                                          
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step1" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Précédent</button>
            </div>
            <!-- Bouton suivant -->
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step3" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="moa">
    </form>
</section>