<?php
    $info = $_SESSION['info_operation_construction'] ?? [];
?>
<section class="mb-8 p-4 border-l-4 border-amber-500 bg-amber-50 dark:bg-gray-800 dark:border-amber-400">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <div>
                <h1 class="text-2xl font-extrabold text-amber-800 dark:text-amber-300">DESCRIPTION DE LA CENTRALE PHOTOVOLTAÏQUE</h1>
                <div class="flex flex-col gap-0 mt-1 hover:underline text-amber-700 text-sm">
                    <a href="index.php?page=step2pv">&gt; description de la centrale</a>
                    <a href="index.php?page=step4pv">&gt; prévention</a>
                    <a href="index.php?page=step4bispv">&gt; environnement</a>
                </div>
            </div>
        </div>
        <hr class="border-amber-200 mb-4">
    </div>

    <?php if (!empty($_SESSION['validation_errors'])): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <h4 class="font-bold mb-2">Erreurs de validation :</h4>
            <ul class="list-disc list-inside">
                <?php foreach ($_SESSION['validation_errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
            <?php unset($_SESSION['validation_errors'], $_SESSION['validation_errors_step']); ?>
    <?php endif; ?>

    <form action="" method="post" class="space-y-6">
        <div class="relative">
            <label for="search_pv_adresse" class="block mb-2 text-sm font-medium text-gray-900">Recherche d'adresse</label>
            <input type="text" id="search_pv_adresse" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 pr-10" placeholder="Rechercher une adresse..." autocomplete="off" />
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none mt-7">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </span>
            <ul id="search_pv_adresse_suggestions" class="bg-white border border-gray-300 rounded-lg mt-1 max-h-40 overflow-y-auto hidden z-10 absolute w-full"></ul>
            <small class="text-gray-500">Recherchez puis sélectionnez une adresse pour remplir automatiquement les champs ci-dessous.</small>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-3">
                <label class="block mb-2 text-sm font-medium text-gray-900">Adresse de la centrale photovoltaïque *</label>
                <input type="text" name="pv_adresse" value="<?= htmlspecialchars($info['pv_adresse'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Code postal *</label>
                <input type="text" name="pv_code_postal" value="<?= htmlspecialchars($info['pv_code_postal'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900">Commune *</label>
                <input type="text" name="pv_commune" value="<?= htmlspecialchars($info['pv_commune'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nom et qualification de l'entreprise de pose (Quali PV) *</label>
            <input type="text" name="pv_entreprise_pose_qualipv" value="<?= htmlspecialchars($info['pv_entreprise_pose_qualipv'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Valeur à neuf de remplacement *</label>
                <div class="flex gap-2">
                    <input type="text" name="pv_valeur_neuve_remplacement" value="<?= htmlspecialchars($info['pv_valeur_neuve_remplacement'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
                    <select name="pv_valeur_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 p-2.5">
                        <option value="HT" <?= (($info['pv_valeur_type'] ?? 'HT') === 'HT') ? 'selected' : '' ?>>HT</option>
                        <option value="TTC" <?= (($info['pv_valeur_type'] ?? '') === 'TTC') ? 'selected' : '' ?>>TTC</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Date de mise en service *</label>
                <input type="date" name="pv_date_mise_en_service" value="<?= htmlspecialchars($info['pv_date_mise_en_service'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center justify-between gap-4">
                <label class="text-sm font-medium text-gray-900">A-t-elle déjà été assurée ? *</label>
                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_pv_deja_assuree" class="sr-only peer" <?= (($info['pv_deja_assuree'] ?? '0') === '1') ? 'checked' : '' ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        <span id="pv_deja_assuree_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_deja_assuree'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                    </label>
                    <input type="radio" name="pv_deja_assuree" value="1" id="radio_pv_deja_assuree_oui" class="hidden" <?= (($info['pv_deja_assuree'] ?? '') === '1') ? 'checked' : '' ?> />
                    <input type="radio" name="pv_deja_assuree" value="0" id="radio_pv_deja_assuree_non" class="hidden" <?= (($info['pv_deja_assuree'] ?? '0') === '0') ? 'checked' : '' ?> />
                </div>
            </div>
            <div class="flex items-center justify-between gap-4">
                <label class="text-sm font-medium text-gray-900">La centrale a-t-elle déjà subi un (ou des) sinistre(s) ? *</label>
                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_pv_sinistre_deja" class="sr-only peer" <?= (($info['pv_sinistre_deja'] ?? '0') === '1') ? 'checked' : '' ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        <span id="pv_sinistre_deja_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_sinistre_deja'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                    </label>
                    <input type="radio" name="pv_sinistre_deja" value="1" id="radio_pv_sinistre_deja_oui" class="hidden" <?= (($info['pv_sinistre_deja'] ?? '') === '1') ? 'checked' : '' ?> />
                    <input type="radio" name="pv_sinistre_deja" value="0" id="radio_pv_sinistre_deja_non" class="hidden" <?= (($info['pv_sinistre_deja'] ?? '0') === '0') ? 'checked' : '' ?> />
                </div>
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si oui, nature et montant</label>
            <input type="text" name="pv_sinistre_nature_montant" value="<?= htmlspecialchars($info['pv_sinistre_nature_montant'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Surface totale (m2) *</label>
                <input type="text" name="pv_surface_totale" value="<?= htmlspecialchars($info['pv_surface_totale'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Puissance crête (kWc) *</label>
                <input type="text" name="pv_puissance_crete" value="<?= htmlspecialchars($info['pv_puissance_crete'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nature des panneaux photovoltaïques *</label>
            <div class="flex flex-wrap gap-6 text-sm">
                <label><input type="radio" name="pv_nature_panneaux" value="mono" <?= (($info['pv_nature_panneaux'] ?? '') === 'mono') ? 'checked' : '' ?> /> Mono</label>
                <label><input type="radio" name="pv_nature_panneaux" value="polycristallin" <?= (($info['pv_nature_panneaux'] ?? '') === 'polycristallin') ? 'checked' : '' ?> /> Polycristallin</label>
                <label><input type="radio" name="pv_nature_panneaux" value="amorphe" <?= (($info['pv_nature_panneaux'] ?? '') === 'amorphe') ? 'checked' : '' ?> /> Amorphe</label>
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nombre, marque, modèle des panneaux photovoltaïques *</label>
            <textarea name="pv_panneaux_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['pv_panneaux_details'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nombre, marque, modèle des onduleurs *</label>
            <textarea name="pv_onduleurs_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['pv_onduleurs_details'] ?? '') ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Prix de vente du kWh (€) *</label>
                <input type="text" name="pv_prix_vente_kwh" value="<?= htmlspecialchars($info['pv_prix_vente_kwh'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Recettes prévisionnelles annuelles (€) *</label>
                <input type="text" name="pv_recettes_annuelles" value="<?= htmlspecialchars($info['pv_recettes_annuelles'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Mode d'exploitation de l'énergie *</label>
            <div class="flex gap-6 text-sm">
                <label><input type="radio" name="pv_destination_energie" value="revente" <?= (($info['pv_destination_energie'] ?? '') === 'revente') ? 'checked' : '' ?> /> Revente</label>
                <label><input type="radio" name="pv_destination_energie" value="autoconsommation" <?= (($info['pv_destination_energie'] ?? '') === 'autoconsommation') ? 'checked' : '' ?> /> Autoconsommation</label>
            </div>
        </div>

        <div id="pv_autoconsommation_fields" class="<?= (($info['pv_destination_energie'] ?? '') === 'autoconsommation') ? '' : 'hidden' ?>">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Si autoconsommation : économies d'achat d'énergie annuelles prévisionnelles (€)</label>
                <input type="text" name="pv_economies_achat_annuelles" value="<?= htmlspecialchars($info['pv_economies_achat_annuelles'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
            </div>

            <div class="flex items-center justify-between gap-4 mt-6">
                <label class="text-sm font-medium text-gray-900">Existe-t-il des batteries d'accumulateurs ? *</label>
                <div class="flex items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_pv_batteries_existent" class="sr-only peer" <?= (($info['pv_batteries_existent'] ?? '0') === '1') ? 'checked' : '' ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                        <span id="pv_batteries_existent_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_batteries_existent'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                    </label>
                    <input type="radio" name="pv_batteries_existent" value="1" id="radio_pv_batteries_existent_oui" class="hidden" <?= (($info['pv_batteries_existent'] ?? '') === '1') ? 'checked' : '' ?> />
                    <input type="radio" name="pv_batteries_existent" value="0" id="radio_pv_batteries_existent_non" class="hidden" <?= (($info['pv_batteries_existent'] ?? '0') === '0') ? 'checked' : '' ?> />
                </div>
            </div>

            <div class="mt-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Si oui, indiquer (qté x puissance) et technologie</label>
                <textarea name="pv_batteries_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['pv_batteries_details'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step1pv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Précédent</button>
            </div>
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step4pv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="operation_construction">
        <input type="hidden" name="doid" value="<?= isset($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : '' ?>">
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('search_pv_adresse');
    const ul = document.getElementById('search_pv_adresse_suggestions');
    const pvAdresse = document.querySelector('input[name="pv_adresse"]');
    const pvCodePostal = document.querySelector('input[name="pv_code_postal"]');
    const pvCommune = document.querySelector('input[name="pv_commune"]');
    let timeoutAdresse;

    if (input && ul && pvAdresse && pvCodePostal && pvCommune) {
        input.addEventListener('input', function() {
            const query = input.value.trim();
            clearTimeout(timeoutAdresse);

            if (query.length < 3) {
                ul.classList.add('hidden');
                ul.innerHTML = '';
                return;
            }

            timeoutAdresse = setTimeout(() => {
                fetch('https://api-adresse.data.gouv.fr/search/?q=' + encodeURIComponent(query) + '&limit=7')
                    .then(response => response.json())
                    .then(data => {
                        ul.innerHTML = '';
                        if (!data.features || data.features.length === 0) {
                            ul.classList.add('hidden');
                            return;
                        }

                        data.features.forEach(feature => {
                            const li = document.createElement('li');
                            li.textContent = feature.properties.label;
                            li.className = 'px-4 py-2 cursor-pointer hover:bg-amber-100';
                            li.onclick = function() {
                                input.value = feature.properties.label || '';
                                pvAdresse.value = feature.properties.name || feature.properties.label || '';
                                pvCodePostal.value = feature.properties.postcode || '';
                                pvCommune.value = feature.properties.city || '';
                                ul.classList.add('hidden');
                            };
                            ul.appendChild(li);
                        });

                        ul.classList.remove('hidden');
                    })
                    .catch(() => {
                        ul.classList.add('hidden');
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !ul.contains(e.target)) {
                ul.classList.add('hidden');
            }
        });
    }

    const bindYesNoToggle = function(toggleId, radioOuiId, radioNonId, labelId) {
        const toggle = document.getElementById(toggleId);
        const radioOui = document.getElementById(radioOuiId);
        const radioNon = document.getElementById(radioNonId);
        const label = document.getElementById(labelId);
        if (!toggle || !radioOui || !radioNon || !label) {
            return;
        }

        const sync = function() {
            if (toggle.checked) {
                radioOui.checked = true;
                label.textContent = 'Oui';
            } else {
                radioNon.checked = true;
                label.textContent = 'Non';
            }
        };

        toggle.addEventListener('change', sync);
        sync();
    };

    bindYesNoToggle('toggle_pv_deja_assuree', 'radio_pv_deja_assuree_oui', 'radio_pv_deja_assuree_non', 'pv_deja_assuree_value');
    bindYesNoToggle('toggle_pv_sinistre_deja', 'radio_pv_sinistre_deja_oui', 'radio_pv_sinistre_deja_non', 'pv_sinistre_deja_value');
    bindYesNoToggle('toggle_pv_batteries_existent', 'radio_pv_batteries_existent_oui', 'radio_pv_batteries_existent_non', 'pv_batteries_existent_value');

    const autoconsBlock = document.getElementById('pv_autoconsommation_fields');
    const destinationRadios = document.querySelectorAll('input[name="pv_destination_energie"]');
    const syncAutoconsBlock = function() {
        if (!autoconsBlock) return;
        const selected = document.querySelector('input[name="pv_destination_energie"]:checked');
        const isAutocons = selected && selected.value === 'autoconsommation';
        autoconsBlock.classList.toggle('hidden', !isAutocons);
    };
    destinationRadios.forEach(function(radio) {
        radio.addEventListener('change', syncAutoconsBlock);
    });
    syncAutoconsBlock();
});
</script>
