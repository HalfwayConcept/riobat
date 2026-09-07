<?php
$info = $_SESSION['info_pv_prevention'] ?? [];
?>
<section class="mb-8 p-4 border-l-4 border-amber-500 bg-amber-50 dark:bg-gray-800 dark:border-amber-400">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <div>
                <h1 class="text-2xl font-extrabold text-amber-800 dark:text-amber-300">CENTRALE PHOTOVOLTAIQUE &gt; Prévention</h1>
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
        <?php unset($_SESSION['validation_errors']); ?>
    <?php endif; ?>

    <form action="" method="post" class="space-y-6">
        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Existe-t-il un contrat de maintenance des équipements ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_contrat_maintenance" class="sr-only peer" <?= (($info['pv_prev_contrat_maintenance'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_contrat_maintenance_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_contrat_maintenance'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_contrat_maintenance" value="1" id="radio_pv_prev_contrat_maintenance_oui" class="hidden" <?= (($info['pv_prev_contrat_maintenance'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_contrat_maintenance" value="0" id="radio_pv_prev_contrat_maintenance_non" class="hidden" <?= (($info['pv_prev_contrat_maintenance'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Existe-t-il un monitoring (suivi de la production en continu) ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_monitoring" class="sr-only peer" <?= (($info['pv_prev_monitoring'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_monitoring_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_monitoring'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_monitoring" value="1" id="radio_pv_prev_monitoring_oui" class="hidden" <?= (($info['pv_prev_monitoring'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_monitoring" value="0" id="radio_pv_prev_monitoring_non" class="hidden" <?= (($info['pv_prev_monitoring'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Durée de garantie des onduleurs</label>
            <input type="text" name="pv_prev_duree_garantie_onduleurs" value="<?= htmlspecialchars($info['pv_prev_duree_garantie_onduleurs'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" placeholder="Ex: 10 ans" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Les onduleurs sont-ils installés dans un local dédié coupe-feu 2h ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_local_coupe_feu" class="sr-only peer" <?= (($info['pv_prev_local_coupe_feu'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_local_coupe_feu_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_local_coupe_feu'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_local_coupe_feu" value="1" id="radio_pv_prev_local_coupe_feu_oui" class="hidden" <?= (($info['pv_prev_local_coupe_feu'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_local_coupe_feu" value="0" id="radio_pv_prev_local_coupe_feu_non" class="hidden" <?= (($info['pv_prev_local_coupe_feu'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Hauteur mini d'implantation des panneaux photovoltaïques par rapport au sol (m)</label>
            <input type="text" name="pv_prev_hauteur_mini_m" value="<?= htmlspecialchars($info['pv_prev_hauteur_mini_m'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Fixation des modules avec système antivol ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_systeme_antivol" class="sr-only peer" <?= (($info['pv_prev_systeme_antivol'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_systeme_antivol_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_systeme_antivol'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_systeme_antivol" value="1" id="radio_pv_prev_systeme_antivol_oui" class="hidden" <?= (($info['pv_prev_systeme_antivol'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_systeme_antivol" value="0" id="radio_pv_prev_systeme_antivol_non" class="hidden" <?= (($info['pv_prev_systeme_antivol'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Dans l'affirmative, décrire le système</label>
            <textarea name="pv_prev_systeme_antivol_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['pv_prev_systeme_antivol_details'] ?? '') ?></textarea>
        </div>

        <div class="pt-2">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Moyens de protection incendie</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between gap-4">
                    <label class="text-sm font-medium text-gray-900">Extincteurs mobiles</label>
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_pv_prev_incendie_extincteurs" class="sr-only peer" <?= (($info['pv_prev_incendie_extincteurs'] ?? '0') === '1') ? 'checked' : '' ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            <span id="pv_prev_incendie_extincteurs_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_incendie_extincteurs'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                        </label>
                        <input type="radio" name="pv_prev_incendie_extincteurs" value="1" id="radio_pv_prev_incendie_extincteurs_oui" class="hidden" <?= (($info['pv_prev_incendie_extincteurs'] ?? '') === '1') ? 'checked' : '' ?> />
                        <input type="radio" name="pv_prev_incendie_extincteurs" value="0" id="radio_pv_prev_incendie_extincteurs_non" class="hidden" <?= (($info['pv_prev_incendie_extincteurs'] ?? '0') === '0') ? 'checked' : '' ?> />
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <label class="text-sm font-medium text-gray-900">Poteaux incendie</label>
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_pv_prev_incendie_poteaux" class="sr-only peer" <?= (($info['pv_prev_incendie_poteaux'] ?? '0') === '1') ? 'checked' : '' ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            <span id="pv_prev_incendie_poteaux_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_incendie_poteaux'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                        </label>
                        <input type="radio" name="pv_prev_incendie_poteaux" value="1" id="radio_pv_prev_incendie_poteaux_oui" class="hidden" <?= (($info['pv_prev_incendie_poteaux'] ?? '') === '1') ? 'checked' : '' ?> />
                        <input type="radio" name="pv_prev_incendie_poteaux" value="0" id="radio_pv_prev_incendie_poteaux_non" class="hidden" <?= (($info['pv_prev_incendie_poteaux'] ?? '0') === '0') ? 'checked' : '' ?> />
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <label class="text-sm font-medium text-gray-900">Détection automatique d'incendie</label>
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_pv_prev_incendie_detection_auto" class="sr-only peer" <?= (($info['pv_prev_incendie_detection_auto'] ?? '0') === '1') ? 'checked' : '' ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            <span id="pv_prev_incendie_detection_auto_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_incendie_detection_auto'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                        </label>
                        <input type="radio" name="pv_prev_incendie_detection_auto" value="1" id="radio_pv_prev_incendie_detection_auto_oui" class="hidden" <?= (($info['pv_prev_incendie_detection_auto'] ?? '') === '1') ? 'checked' : '' ?> />
                        <input type="radio" name="pv_prev_incendie_detection_auto" value="0" id="radio_pv_prev_incendie_detection_auto_non" class="hidden" <?= (($info['pv_prev_incendie_detection_auto'] ?? '0') === '0') ? 'checked' : '' ?> />
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <label class="text-sm font-medium text-gray-900">Sprinkler</label>
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_pv_prev_incendie_sprinkler" class="sr-only peer" <?= (($info['pv_prev_incendie_sprinkler'] ?? '0') === '1') ? 'checked' : '' ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            <span id="pv_prev_incendie_sprinkler_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_incendie_sprinkler'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                        </label>
                        <input type="radio" name="pv_prev_incendie_sprinkler" value="1" id="radio_pv_prev_incendie_sprinkler_oui" class="hidden" <?= (($info['pv_prev_incendie_sprinkler'] ?? '') === '1') ? 'checked' : '' ?> />
                        <input type="radio" name="pv_prev_incendie_sprinkler" value="0" id="radio_pv_prev_incendie_sprinkler_non" class="hidden" <?= (($info['pv_prev_incendie_sprinkler'] ?? '0') === '0') ? 'checked' : '' ?> />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Autres</label>
            <textarea name="pv_prev_incendie_autres" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['pv_prev_incendie_autres'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Vérification annuelle des installations électriques par un organisme agréé ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_verif_elec_annuelle" class="sr-only peer" <?= (($info['pv_prev_verif_elec_annuelle'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_verif_elec_annuelle_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_verif_elec_annuelle'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_verif_elec_annuelle" value="1" id="radio_pv_prev_verif_elec_annuelle_oui" class="hidden" <?= (($info['pv_prev_verif_elec_annuelle'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_verif_elec_annuelle" value="0" id="radio_pv_prev_verif_elec_annuelle_non" class="hidden" <?= (($info['pv_prev_verif_elec_annuelle'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nom de l'organisme vérificateur</label>
            <input type="text" name="pv_prev_nom_organisme_verificateur" value="<?= htmlspecialchars($info['pv_prev_nom_organisme_verificateur'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Existe-t-il un contrôle annuel par thermographie infrarouge ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_thermo_infrarouge" class="sr-only peer" <?= (($info['pv_prev_thermo_infrarouge'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_thermo_infrarouge_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_thermo_infrarouge'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_thermo_infrarouge" value="1" id="radio_pv_prev_thermo_infrarouge_oui" class="hidden" <?= (($info['pv_prev_thermo_infrarouge'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_thermo_infrarouge" value="0" id="radio_pv_prev_thermo_infrarouge_non" class="hidden" <?= (($info['pv_prev_thermo_infrarouge'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Existe-t-il une étude sur la résistance au vent de la structure de l'ombrière ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_pv_prev_etude_vent_ombriere" class="sr-only peer" <?= (($info['pv_prev_etude_vent_ombriere'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="pv_prev_etude_vent_ombriere_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['pv_prev_etude_vent_ombriere'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="pv_prev_etude_vent_ombriere" value="1" id="radio_pv_prev_etude_vent_ombriere_oui" class="hidden" <?= (($info['pv_prev_etude_vent_ombriere'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="pv_prev_etude_vent_ombriere" value="0" id="radio_pv_prev_etude_vent_ombriere_non" class="hidden" <?= (($info['pv_prev_etude_vent_ombriere'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step2pv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Précédent</button>
            </div>
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step4bispv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="pv_prevention">
        <input type="hidden" name="doid" value="<?= isset($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : '' ?>">
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

    bindYesNoToggle('toggle_pv_prev_contrat_maintenance', 'radio_pv_prev_contrat_maintenance_oui', 'radio_pv_prev_contrat_maintenance_non', 'pv_prev_contrat_maintenance_value');
    bindYesNoToggle('toggle_pv_prev_monitoring', 'radio_pv_prev_monitoring_oui', 'radio_pv_prev_monitoring_non', 'pv_prev_monitoring_value');
    bindYesNoToggle('toggle_pv_prev_local_coupe_feu', 'radio_pv_prev_local_coupe_feu_oui', 'radio_pv_prev_local_coupe_feu_non', 'pv_prev_local_coupe_feu_value');
    bindYesNoToggle('toggle_pv_prev_systeme_antivol', 'radio_pv_prev_systeme_antivol_oui', 'radio_pv_prev_systeme_antivol_non', 'pv_prev_systeme_antivol_value');
    bindYesNoToggle('toggle_pv_prev_incendie_extincteurs', 'radio_pv_prev_incendie_extincteurs_oui', 'radio_pv_prev_incendie_extincteurs_non', 'pv_prev_incendie_extincteurs_value');
    bindYesNoToggle('toggle_pv_prev_incendie_poteaux', 'radio_pv_prev_incendie_poteaux_oui', 'radio_pv_prev_incendie_poteaux_non', 'pv_prev_incendie_poteaux_value');
    bindYesNoToggle('toggle_pv_prev_incendie_detection_auto', 'radio_pv_prev_incendie_detection_auto_oui', 'radio_pv_prev_incendie_detection_auto_non', 'pv_prev_incendie_detection_auto_value');
    bindYesNoToggle('toggle_pv_prev_incendie_sprinkler', 'radio_pv_prev_incendie_sprinkler_oui', 'radio_pv_prev_incendie_sprinkler_non', 'pv_prev_incendie_sprinkler_value');
    bindYesNoToggle('toggle_pv_prev_verif_elec_annuelle', 'radio_pv_prev_verif_elec_annuelle_oui', 'radio_pv_prev_verif_elec_annuelle_non', 'pv_prev_verif_elec_annuelle_value');
    bindYesNoToggle('toggle_pv_prev_thermo_infrarouge', 'radio_pv_prev_thermo_infrarouge_oui', 'radio_pv_prev_thermo_infrarouge_non', 'pv_prev_thermo_infrarouge_value');
    bindYesNoToggle('toggle_pv_prev_etude_vent_ombriere', 'radio_pv_prev_etude_vent_ombriere_oui', 'radio_pv_prev_etude_vent_ombriere_non', 'pv_prev_etude_vent_ombriere_value');
});
</script>
