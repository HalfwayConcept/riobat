<script src="public/script/s02-maitre-ouvrage.js"></script>
<script src="public/script/adresse-autocomplete.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('search_adresse_moa');
    var ul = document.getElementById('search_adresse_moa_suggestions');
    if (!input || !ul) return;
    let timeoutMoa;
    input.addEventListener('input', function() {
        var query = input.value;
        clearTimeout(timeoutMoa);
        if (query.length < 3) { ul.classList.add('hidden'); return; }
        timeoutMoa = setTimeout(function() {
            fetch('https://api-adresse.data.gouv.fr/search/?q=' + encodeURIComponent(query) + '&limit=7')
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    ul.innerHTML = '';
                    if (!data.features || data.features.length === 0) { ul.classList.add('hidden'); return; }
                    data.features.forEach(function(f) {
                        var li = document.createElement('li');
                        li.textContent = f.properties.label;
                        li.className = 'px-4 py-2 cursor-pointer hover:bg-blue-100';
                        li.onclick = function() {
                            input.value = f.properties.label;
                            ul.classList.add('hidden');
                            var adresse = document.getElementById('moa_souscripteur_form_adresse');
                            var cp = document.querySelector('input[name="moa_souscripteur_form_code_postal"]');
                            var commune = document.querySelector('input[name="moa_souscripteur_form_commune"]');
                            if (adresse) adresse.value = f.properties.name || '';
                            if (cp) cp.value = f.properties.postcode || '';
                            if (commune) commune.value = f.properties.city || '';
                        };
                        ul.appendChild(li);
                    });
                    ul.classList.remove('hidden');
                });
        }, 300);
    });
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !ul.contains(e.target)) ul.classList.add('hidden');
    });
});
</script>
<section class="mb-8 p-4 border-l-4 border-blue-500 bg-blue-50 dark:bg-gray-800 dark:border-blue-400">
    <!-- HEADER HARMONISÉ -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <h1 class="text-2xl font-extrabold text-blue-800 dark:text-blue-300">Étape 2 : Maître d'Ouvrage</h1>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <span>Formulaire Dommages Ouvrage</span>
            <span class="mx-2">|</span>
            <span>Projet de construction</span>
        </div>
        <hr class="border-blue-200 mb-4">
    </div>
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
            <!-- Champ hidden pour stocker le JSON du tableau Nature des travaux -->
            
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
                    <?php $is_entreprise = isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && $_SESSION['info_moa']['moa_souscripteur_form_civilite'] === 'entreprise'; ?>
                    <div class="py-4">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                <input type="text" name="moa_souscripteur_form_nom" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_nom']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_nom']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                                <input type="text" name="moa_souscripteur_form_prenom" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_prenom']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_prenom']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                            </div>
                        </div>
                    </div>
                    <div id="raison_champ" class="<?= $is_entreprise ? '' : 'hidden' ?> py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison sociale</label>
                        <input type="text" id="moa_souscripteur_form_raison_sociale" name="moa_souscripteur_form_raison_sociale" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_raison_sociale']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_raison_sociale']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div id="siret_champ" class="<?= $is_entreprise ? '' : 'hidden' ?> py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SIRET n°</label>
                        <input type="text" name="moa_souscripteur_form_siret" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_siret']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_siret']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <!-- Recherche d'adresse avec autocomplétion -->
                    <div class="py-4 relative">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Recherche d'adresse</label>
                        <div class="relative">
                            <input type="text" id="search_adresse_moa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Rechercher une adresse..." autocomplete="off" />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </span>
                            <ul id="search_adresse_moa_suggestions" class="bg-white border border-gray-300 rounded-lg mt-1 max-h-40 overflow-y-auto hidden z-10 absolute w-full"></ul>
                        </div>
                    </div>

                    <div class="py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse</label>
                        <input type="text" id="moa_souscripteur_form_adresse" name="moa_souscripteur_form_adresse" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_adresse']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_adresse']) : ''; ?>" placeholder="Adresse du Maître d'Ouvrage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div class="grid gap-6 mb-2 md:grid-cols-2">
                        <div class="py-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code postal</label>
                            <input type="text" name="moa_souscripteur_form_code_postal" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_code_postal']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_code_postal']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                        </div>
                        <div class="py-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Commune</label>
                            <input type="text" name="moa_souscripteur_form_commune" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_commune']) ? htmlspecialchars($_SESSION['info_moa']['moa_souscripteur_form_commune']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>


                <!-- Bloc Dates et Coût de l'opération supprimé -->
        <div class="my-16">
            <h3 class="mb-2 text-gray-500 font-medium">Qualité du maitre d'ouvrage (choisissez l'option correspondante) : </h3>
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
        </div>


        <!-- Formulaire caché : "Maitre d'ouvrage participe t-il à la construction ?"-->
        <div>
            <div class="flex flex-col lg:flex-row gap-4 items-center text-gray-500 font-medium">
                <span class="lg:w-2/3">Le Maitre d'Ouvrage participe à la construction ? </span>
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
                    <div id="moa_construction_pro_form" class="py-4 <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==1 ? "" : "hidden"; ?> mx-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa profession :</label>
                        <input type="text" name="moa_construction_pro_champ" value="<?= isset($_SESSION['info_moa']['moa_construction_pro_champ']) ? htmlspecialchars($_SESSION['info_moa']['moa_construction_pro_champ']) : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                </div>
                <div id="moa_construction_pro_tableau" class="<?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==1 ? "" : "hidden"; ?> mt-10">
                    
                    <span class="text-gray-500 font-medium">Complétez le tableau ci-dessous en cochant les cases correspondantes :</span>
                    <input type="hidden" name="moa_nature_travaux_json" id="moa_nature_travaux_json" value='<?= isset($_SESSION['info_moa']['moa_nature_travaux_json']) ? htmlspecialchars($_SESSION['info_moa']['moa_nature_travaux_json']) : '' ?>'>
                    <div class="overflow-x-auto">
                    <table class="text-sm font-light mt-4 min-w-[600px] w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border-t-2 border-b-2 border-l-2 border-gray-300 p-2 text-center">Activité ou mission exercée</th>
                                <th class="border-t-2 border-b-2 border-gray-300 p-2 text-center">Papiers peints<br>et/ou Peintures intérieures</th>
                                <th class="border-t-2 border-b-2 border-gray-300 p-2 text-center">Gros oeuvre fondations,<br>Charpente - Couverture, Etanchéité</th>
                                <th class="border-t-2 border-b-2 border-gray-300 p-2 text-center">Autres travaux</th>
                                <th class="border-t-2 border-b-2 border-r-2 border-gray-300 p-2 text-center">(autres travaux: précisez)</th>
                            </tr>
                        </thead>
                        <!-- Lignes dynamiques générées par JS -->
                    </table>
                    </div>
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
        <input type="hidden" name="doid" value="<?= isset($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : '' ?>">
    </form>
</section>