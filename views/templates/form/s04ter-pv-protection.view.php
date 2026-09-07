<?php
$info = $_SESSION['info_pv_protection'] ?? [];
?>
<section class="mb-8 p-4 border-l-4 border-amber-500 bg-amber-50 dark:bg-gray-800 dark:border-amber-400">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <div>
                <h1 class="text-2xl font-extrabold text-amber-800 dark:text-amber-300">CENTRALE PHOTOVOLTAIQUE &gt; Protection</h1>
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
        <?php
        $rows = [
            'respect_ute_c15712' => "Les installations photovoltaïques sont-elles réalisées conformément aux spécifications des normes UTE C15-712 ?",
            'certificat_cofrac_securite_incendie' => "Un document COFRAC atteste-t-il la conformité des panneaux en cas d'incendie ?",
            'verification_annuelle_qualifiee' => "Les installations sont-elles vérifiées annuellement par un vérificateur qualifié COFRAC ?",
            'maintenance_mise_en_place' => "Une maintenance des installations est-elle mise en place ?",
            'maintenance_entreprise_tierce' => "Les opérations de maintenance sont-elles effectuées par une entreprise tierce spécialisée ?",
            'procedure_remediation_defauts' => "Une procédure de remédiation aux défauts signalés est-elle mise en place ?",
            'connecteurs_conformes_en50521' => "Les connecteurs sont-ils conformes à la norme EN 50521 ?",
            'boucles_induction' => "Le câblage comporte-t-il une ou plusieurs boucles d'induction ?",
            'thermographie_infrarouge_annuelle' => "Contrôle annuel par thermographie infrarouge de l'installation ?",
            'zone_graviers_5m_interieur_cloture' => "Existe-t-il une zone de graviers de 5 mètres de large minimum à l'intérieur de la clôture ?",
            'protection_cables_rongeurs' => "Y a-t-il une protection des câbles électriques contre les rongeurs ?",
        ];
        foreach ($rows as $key => $label):
            $value = (($info[$key] ?? '0') === '1') ? '1' : '0';
        ?>
        <div class="flex items-center justify-between gap-4">
            <label class="text-sm font-medium text-gray-900"><?= htmlspecialchars($label) ?></label>
            <div class="flex items-center">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_<?= $key ?>" class="sr-only peer" <?= ($value === '1') ? 'checked' : '' ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                    <span id="<?= $key ?>_value" class="select-none ms-3 text-sm font-medium text-gray-900"><?= ($value === '1') ? 'Oui' : 'Non' ?></span>
                </label>
                <input type="radio" name="<?= $key ?>" value="1" id="radio_<?= $key ?>_oui" class="hidden" <?= ($value === '1') ? 'checked' : '' ?> />
                <input type="radio" name="<?= $key ?>" value="0" id="radio_<?= $key ?>_non" class="hidden" <?= ($value === '0') ? 'checked' : '' ?> />
            </div>
        </div>
        <?php endforeach; ?>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Observations</label>
            <textarea name="observations" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5"><?= htmlspecialchars($info['observations'] ?? '') ?></textarea>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step4bispv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Précédent</button>
            </div>
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step5pv" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="pv_protection">
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

    bindYesNoToggle('toggle_respect_ute_c15712', 'radio_respect_ute_c15712_oui', 'radio_respect_ute_c15712_non', 'respect_ute_c15712_value');
    bindYesNoToggle('toggle_certificat_cofrac_securite_incendie', 'radio_certificat_cofrac_securite_incendie_oui', 'radio_certificat_cofrac_securite_incendie_non', 'certificat_cofrac_securite_incendie_value');
    bindYesNoToggle('toggle_verification_annuelle_qualifiee', 'radio_verification_annuelle_qualifiee_oui', 'radio_verification_annuelle_qualifiee_non', 'verification_annuelle_qualifiee_value');
    bindYesNoToggle('toggle_maintenance_mise_en_place', 'radio_maintenance_mise_en_place_oui', 'radio_maintenance_mise_en_place_non', 'maintenance_mise_en_place_value');
    bindYesNoToggle('toggle_maintenance_entreprise_tierce', 'radio_maintenance_entreprise_tierce_oui', 'radio_maintenance_entreprise_tierce_non', 'maintenance_entreprise_tierce_value');
    bindYesNoToggle('toggle_procedure_remediation_defauts', 'radio_procedure_remediation_defauts_oui', 'radio_procedure_remediation_defauts_non', 'procedure_remediation_defauts_value');
    bindYesNoToggle('toggle_connecteurs_conformes_en50521', 'radio_connecteurs_conformes_en50521_oui', 'radio_connecteurs_conformes_en50521_non', 'connecteurs_conformes_en50521_value');
    bindYesNoToggle('toggle_boucles_induction', 'radio_boucles_induction_oui', 'radio_boucles_induction_non', 'boucles_induction_value');
    bindYesNoToggle('toggle_thermographie_infrarouge_annuelle', 'radio_thermographie_infrarouge_annuelle_oui', 'radio_thermographie_infrarouge_annuelle_non', 'thermographie_infrarouge_annuelle_value');
    bindYesNoToggle('toggle_zone_graviers_5m_interieur_cloture', 'radio_zone_graviers_5m_interieur_cloture_oui', 'radio_zone_graviers_5m_interieur_cloture_non', 'zone_graviers_5m_interieur_cloture_value');
    bindYesNoToggle('toggle_protection_cables_rongeurs', 'radio_protection_cables_rongeurs_oui', 'radio_protection_cables_rongeurs_non', 'protection_cables_rongeurs_value');
});
</script>
