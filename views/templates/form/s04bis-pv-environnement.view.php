<?php
$info = $_SESSION['info_pv_environnement'] ?? [];
?>
<section class="mb-8 p-4 border-l-4 border-amber-500 bg-amber-50 dark:bg-gray-800 dark:border-amber-400">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <div>
                <h1 class="text-2xl font-extrabold text-amber-800 dark:text-amber-300">CENTRALE PHOTOVOLTAIQUE &gt; Environnement</h1>
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
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Quel est le mode de pose des panneaux ? *</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                <label><input type="radio" name="trav_annexes_pv_montage" value="integration_bati" <?= (($info['trav_annexes_pv_montage'] ?? '') === 'integration_bati') ? 'checked' : '' ?> /> Intégration au bâti</label>
                <label><input type="radio" name="trav_annexes_pv_montage" value="integration_simplifiee" <?= (($info['trav_annexes_pv_montage'] ?? '') === 'integration_simplifiee') ? 'checked' : '' ?> /> Intégration simplifiée au bâti</label>
                <label><input type="radio" name="trav_annexes_pv_montage" value="ombriere" <?= (($info['trav_annexes_pv_montage'] ?? '') === 'ombriere') ? 'checked' : '' ?> /> Ombrière</label>
                <label><input type="radio" name="trav_annexes_pv_montage" value="sol" <?= (($info['trav_annexes_pv_montage'] ?? '') === 'sol') ? 'checked' : '' ?> /> Sol</label>
                <label><input type="radio" name="trav_annexes_pv_montage" value="autre" <?= (($info['trav_annexes_pv_montage'] ?? '') === 'autre') ? 'checked' : '' ?> /> Autres</label>
            </div>
            <input type="text" name="trav_annexes_pv_env_mode_pose_autres" value="<?= htmlspecialchars($info['trav_annexes_pv_env_mode_pose_autres'] ?? '') ?>" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" placeholder="Précisez si Autres" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Le support d'intégration des panneaux photovoltaïques en toiture est-il combustible ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_support_combustible" class="sr-only peer" <?= (($info['trav_annexes_pv_env_support_combustible'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_support_combustible_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_support_combustible'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_support_combustible" value="1" id="radio_trav_annexes_pv_env_support_combustible_oui" class="hidden" <?= (($info['trav_annexes_pv_env_support_combustible'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_support_combustible" value="0" id="radio_trav_annexes_pv_env_support_combustible_non" class="hidden" <?= (($info['trav_annexes_pv_env_support_combustible'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nature de l'intégration (en toiture, en façade...), nom commercial et descriptif du système</label>
            <textarea name="trav_annexes_pv_env_nature_integration" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_nature_integration'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Existe-t-il un isolant combustible en toiture ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_isolant_combustible" class="sr-only peer" <?= (($info['trav_annexes_pv_env_isolant_combustible'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_isolant_combustible_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_isolant_combustible'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_isolant_combustible" value="1" id="radio_trav_annexes_pv_env_isolant_combustible_oui" class="hidden" <?= (($info['trav_annexes_pv_env_isolant_combustible'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_isolant_combustible" value="0" id="radio_trav_annexes_pv_env_isolant_combustible_non" class="hidden" <?= (($info['trav_annexes_pv_env_isolant_combustible'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Nature de l'isolant</label>
            <input type="text" name="trav_annexes_pv_env_isolant_nature" value="<?= htmlspecialchars($info['trav_annexes_pv_env_isolant_nature'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Le souscripteur est-il propriétaire du bâtiment ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_souscripteur_proprietaire" class="sr-only peer" <?= (($info['trav_annexes_pv_env_souscripteur_proprietaire'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_souscripteur_proprietaire_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_souscripteur_proprietaire'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_souscripteur_proprietaire" value="1" id="radio_trav_annexes_pv_env_souscripteur_proprietaire_oui" class="hidden" <?= (($info['trav_annexes_pv_env_souscripteur_proprietaire'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_souscripteur_proprietaire" value="0" id="radio_trav_annexes_pv_env_souscripteur_proprietaire_non" class="hidden" <?= (($info['trav_annexes_pv_env_souscripteur_proprietaire'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si oui : nom de l'assureur et n° de contrat</label>
            <input type="text" name="trav_annexes_pv_env_proprietaire_assureur_contrat" value="<?= htmlspecialchars($info['trav_annexes_pv_env_proprietaire_assureur_contrat'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si non : bail et renonciation à recours réciproque (commentaires/pièces)</label>
            <textarea name="trav_annexes_pv_env_bail_renonciation" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_bail_renonciation'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Y a-t-il des locataires dans le bâtiment supportant la centrale ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_locataires" class="sr-only peer" <?= (($info['trav_annexes_pv_env_locataires'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_locataires_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_locataires'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_locataires" value="1" id="radio_trav_annexes_pv_env_locataires_oui" class="hidden" <?= (($info['trav_annexes_pv_env_locataires'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_locataires" value="0" id="radio_trav_annexes_pv_env_locataires_non" class="hidden" <?= (($info['trav_annexes_pv_env_locataires'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si oui : baux, valeur du contenu et CA de chaque locataire</label>
            <textarea name="trav_annexes_pv_env_locataires_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_locataires_details'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Quelles sont les activités exercées dans le bâtiment et à moins de 20 m ?</label>
            <textarea name="trav_annexes_pv_env_activites_20m" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_activites_20m'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Préciser la nature du chauffage ou du séchage</label>
            <textarea name="trav_annexes_pv_env_nature_chauffage_sechage" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_nature_chauffage_sechage'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">S'il existe un dépôt de marchandises appartenant à des tiers, préciser la/les convention(s)</label>
            <textarea name="trav_annexes_pv_env_depot_tiers_conventions" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_depot_tiers_conventions'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Y a-t-il stockage de matières combustibles dans le bâtiment ou à moins de 20 m ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_stockage_combustibles" class="sr-only peer" <?= (($info['trav_annexes_pv_env_stockage_combustibles'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_stockage_combustibles_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_stockage_combustibles'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_stockage_combustibles" value="1" id="radio_trav_annexes_pv_env_stockage_combustibles_oui" class="hidden" <?= (($info['trav_annexes_pv_env_stockage_combustibles'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_stockage_combustibles" value="0" id="radio_trav_annexes_pv_env_stockage_combustibles_non" class="hidden" <?= (($info['trav_annexes_pv_env_stockage_combustibles'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si oui, décrire la nature et la quantité des matières stockées</label>
            <textarea name="trav_annexes_pv_env_stockage_combustibles_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_stockage_combustibles_details'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Le site est-il clôturé ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_site_cloture" class="sr-only peer" <?= (($info['trav_annexes_pv_env_site_cloture'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_site_cloture_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_site_cloture'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_site_cloture" value="1" id="radio_trav_annexes_pv_env_site_cloture_oui" class="hidden" <?= (($info['trav_annexes_pv_env_site_cloture'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_site_cloture" value="0" id="radio_trav_annexes_pv_env_site_cloture_non" class="hidden" <?= (($info['trav_annexes_pv_env_site_cloture'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si oui, préciser la nature et la hauteur de la clôture</label>
            <textarea name="trav_annexes_pv_env_site_cloture_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_site_cloture_details'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Le périmètre du site est-il équipé d'une détection d'intrusion électronique ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_detection_intrusion" class="sr-only peer" <?= (($info['trav_annexes_pv_env_detection_intrusion'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_detection_intrusion_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_detection_intrusion'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_detection_intrusion" value="1" id="radio_trav_annexes_pv_env_detection_intrusion_oui" class="hidden" <?= (($info['trav_annexes_pv_env_detection_intrusion'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_detection_intrusion" value="0" id="radio_trav_annexes_pv_env_detection_intrusion_non" class="hidden" <?= (($info['trav_annexes_pv_env_detection_intrusion'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Si oui, description (linéaire, volumétrique, contact...) et délai d'intervention</label>
            <textarea name="trav_annexes_pv_env_detection_intrusion_details" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['trav_annexes_pv_env_detection_intrusion_details'] ?? '') ?></textarea>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Le site est-il équipé de vidéosurveillance ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_video_surveillance" class="sr-only peer" <?= (($info['trav_annexes_pv_env_video_surveillance'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_video_surveillance_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_video_surveillance'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_video_surveillance" value="1" id="radio_trav_annexes_pv_env_video_surveillance_oui" class="hidden" <?= (($info['trav_annexes_pv_env_video_surveillance'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_video_surveillance" value="0" id="radio_trav_annexes_pv_env_video_surveillance_non" class="hidden" <?= (($info['trav_annexes_pv_env_video_surveillance'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Si oui, est-elle opérationnelle 24h/24 avec intervention sur site ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_video_24h" class="sr-only peer" <?= (($info['trav_annexes_pv_env_video_24h'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_video_24h_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_video_24h'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_video_24h" value="1" id="radio_trav_annexes_pv_env_video_24h_oui" class="hidden" <?= (($info['trav_annexes_pv_env_video_24h'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_video_24h" value="0" id="radio_trav_annexes_pv_env_video_24h_non" class="hidden" <?= (($info['trav_annexes_pv_env_video_24h'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Le site est-il gardienné ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_site_gardienne" class="sr-only peer" <?= (($info['trav_annexes_pv_env_site_gardienne'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_site_gardienne_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_site_gardienne'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_site_gardienne" value="1" id="radio_trav_annexes_pv_env_site_gardienne_oui" class="hidden" <?= (($info['trav_annexes_pv_env_site_gardienne'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_site_gardienne" value="0" id="radio_trav_annexes_pv_env_site_gardienne_non" class="hidden" <?= (($info['trav_annexes_pv_env_site_gardienne'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Risque tempête : structure étudiée par un bureau d'étude spécialisé ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_etude_vent" class="sr-only peer" <?= (($info['trav_annexes_pv_env_etude_vent'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_etude_vent_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_etude_vent'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_etude_vent" value="1" id="radio_trav_annexes_pv_env_etude_vent_oui" class="hidden" <?= (($info['trav_annexes_pv_env_etude_vent'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_etude_vent" value="0" id="radio_trav_annexes_pv_env_etude_vent_non" class="hidden" <?= (($info['trav_annexes_pv_env_etude_vent'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Hypothèse de vent maxi retenue</label>
            <input type="text" name="trav_annexes_pv_env_hypothese_vent_maxi" value="<?= htmlspecialchars($info['trav_annexes_pv_env_hypothese_vent_maxi'] ?? '') ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Une étude foudre a-t-elle été effectuée par une entreprise spécialisée ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_etude_foudre" class="sr-only peer" <?= (($info['trav_annexes_pv_env_etude_foudre'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_etude_foudre_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_etude_foudre'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_etude_foudre" value="1" id="radio_trav_annexes_pv_env_etude_foudre_oui" class="hidden" <?= (($info['trav_annexes_pv_env_etude_foudre'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_etude_foudre" value="0" id="radio_trav_annexes_pv_env_etude_foudre_non" class="hidden" <?= (($info['trav_annexes_pv_env_etude_foudre'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Parafoudres côté courant continu (DC) ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_parafoudre_dc" class="sr-only peer" <?= (($info['trav_annexes_pv_env_parafoudre_dc'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_parafoudre_dc_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_parafoudre_dc'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_parafoudre_dc" value="1" id="radio_trav_annexes_pv_env_parafoudre_dc_oui" class="hidden" <?= (($info['trav_annexes_pv_env_parafoudre_dc'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_parafoudre_dc" value="0" id="radio_trav_annexes_pv_env_parafoudre_dc_non" class="hidden" <?= (($info['trav_annexes_pv_env_parafoudre_dc'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Parafoudres côté courant alternatif (AC) ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_parafoudre_ac" class="sr-only peer" <?= (($info['trav_annexes_pv_env_parafoudre_ac'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_parafoudre_ac_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_parafoudre_ac'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_parafoudre_ac" value="1" id="radio_trav_annexes_pv_env_parafoudre_ac_oui" class="hidden" <?= (($info['trav_annexes_pv_env_parafoudre_ac'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_parafoudre_ac" value="0" id="radio_trav_annexes_pv_env_parafoudre_ac_non" class="hidden" <?= (($info['trav_annexes_pv_env_parafoudre_ac'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900">Débroussaillage régulier afin que la végétation ne dépasse pas 20 cm ?</label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_trav_annexes_pv_env_debroussaillage" class="sr-only peer" <?= (($info['trav_annexes_pv_env_debroussaillage'] ?? '0') === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="trav_annexes_pv_env_debroussaillage_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= (($info['trav_annexes_pv_env_debroussaillage'] ?? '0') === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="trav_annexes_pv_env_debroussaillage" value="1" id="radio_trav_annexes_pv_env_debroussaillage_oui" class="hidden" <?= (($info['trav_annexes_pv_env_debroussaillage'] ?? '') === '1') ? 'checked' : '' ?> />
                <input type="radio" name="trav_annexes_pv_env_debroussaillage" value="0" id="radio_trav_annexes_pv_env_debroussaillage_non" class="hidden" <?= (($info['trav_annexes_pv_env_debroussaillage'] ?? '0') === '0') ? 'checked' : '' ?> />
            </div>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Le bâtiment est-il utilisé pour le stockage des matières suivantes ?</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_hydrocarbure" value="1" <?= (($info['trav_annexes_pv_env_stock_hydrocarbure'] ?? '0') === '1') ? 'checked' : '' ?> /> Hydrocarbure</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_meubles" value="1" <?= (($info['trav_annexes_pv_env_stock_meubles'] ?? '0') === '1') ? 'checked' : '' ?> /> Meubles</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_textiles" value="1" <?= (($info['trav_annexes_pv_env_stock_textiles'] ?? '0') === '1') ? 'checked' : '' ?> /> Textiles</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_bombe_aerosols" value="1" <?= (($info['trav_annexes_pv_env_stock_bombe_aerosols'] ?? '0') === '1') ? 'checked' : '' ?> /> Bombes aérosols</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_explosifs" value="1" <?= (($info['trav_annexes_pv_env_stock_explosifs'] ?? '0') === '1') ? 'checked' : '' ?> /> Explosifs</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_papier" value="1" <?= (($info['trav_annexes_pv_env_stock_papier'] ?? '0') === '1') ? 'checked' : '' ?> /> Papier</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_bois" value="1" <?= (($info['trav_annexes_pv_env_stock_bois'] ?? '0') === '1') ? 'checked' : '' ?> /> Bois</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_fourrage" value="1" <?= (($info['trav_annexes_pv_env_stock_fourrage'] ?? '0') === '1') ? 'checked' : '' ?> /> Fourrage</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_engrais" value="1" <?= (($info['trav_annexes_pv_env_stock_engrais'] ?? '0') === '1') ? 'checked' : '' ?> /> Engrais</label>
                <label><input type="checkbox" name="trav_annexes_pv_env_stock_cereales" value="1" <?= (($info['trav_annexes_pv_env_stock_cereales'] ?? '0') === '1') ? 'checked' : '' ?> /> Céréales</label>
            </div>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step4pv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Précédent</button>
            </div>
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step4terpv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="pv_environnement">
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

    bindYesNoToggle('toggle_trav_annexes_pv_env_support_combustible', 'radio_trav_annexes_pv_env_support_combustible_oui', 'radio_trav_annexes_pv_env_support_combustible_non', 'trav_annexes_pv_env_support_combustible_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_isolant_combustible', 'radio_trav_annexes_pv_env_isolant_combustible_oui', 'radio_trav_annexes_pv_env_isolant_combustible_non', 'trav_annexes_pv_env_isolant_combustible_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_souscripteur_proprietaire', 'radio_trav_annexes_pv_env_souscripteur_proprietaire_oui', 'radio_trav_annexes_pv_env_souscripteur_proprietaire_non', 'trav_annexes_pv_env_souscripteur_proprietaire_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_locataires', 'radio_trav_annexes_pv_env_locataires_oui', 'radio_trav_annexes_pv_env_locataires_non', 'trav_annexes_pv_env_locataires_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_stockage_combustibles', 'radio_trav_annexes_pv_env_stockage_combustibles_oui', 'radio_trav_annexes_pv_env_stockage_combustibles_non', 'trav_annexes_pv_env_stockage_combustibles_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_site_cloture', 'radio_trav_annexes_pv_env_site_cloture_oui', 'radio_trav_annexes_pv_env_site_cloture_non', 'trav_annexes_pv_env_site_cloture_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_detection_intrusion', 'radio_trav_annexes_pv_env_detection_intrusion_oui', 'radio_trav_annexes_pv_env_detection_intrusion_non', 'trav_annexes_pv_env_detection_intrusion_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_video_surveillance', 'radio_trav_annexes_pv_env_video_surveillance_oui', 'radio_trav_annexes_pv_env_video_surveillance_non', 'trav_annexes_pv_env_video_surveillance_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_video_24h', 'radio_trav_annexes_pv_env_video_24h_oui', 'radio_trav_annexes_pv_env_video_24h_non', 'trav_annexes_pv_env_video_24h_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_site_gardienne', 'radio_trav_annexes_pv_env_site_gardienne_oui', 'radio_trav_annexes_pv_env_site_gardienne_non', 'trav_annexes_pv_env_site_gardienne_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_etude_vent', 'radio_trav_annexes_pv_env_etude_vent_oui', 'radio_trav_annexes_pv_env_etude_vent_non', 'trav_annexes_pv_env_etude_vent_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_etude_foudre', 'radio_trav_annexes_pv_env_etude_foudre_oui', 'radio_trav_annexes_pv_env_etude_foudre_non', 'trav_annexes_pv_env_etude_foudre_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_parafoudre_dc', 'radio_trav_annexes_pv_env_parafoudre_dc_oui', 'radio_trav_annexes_pv_env_parafoudre_dc_non', 'trav_annexes_pv_env_parafoudre_dc_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_parafoudre_ac', 'radio_trav_annexes_pv_env_parafoudre_ac_oui', 'radio_trav_annexes_pv_env_parafoudre_ac_non', 'trav_annexes_pv_env_parafoudre_ac_value');
    bindYesNoToggle('toggle_trav_annexes_pv_env_debroussaillage', 'radio_trav_annexes_pv_env_debroussaillage_oui', 'radio_trav_annexes_pv_env_debroussaillage_non', 'trav_annexes_pv_env_debroussaillage_value');
});
</script>
