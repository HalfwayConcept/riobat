<?php
/**
 * Affiche un tableau de missions à partir d'un JSON (lecture seule, sans champs texte)
 * @param string|array $missions_json JSON ou tableau PHP
 * @return string HTML du tableau
 */
function renderMissionsTableReadOnly($missions_json) {
    if (is_string($missions_json)) {
        $missions = json_decode($missions_json, true);
    } else {
        $missions = $missions_json;
    }
    if (!$missions || !is_array($missions)) return '<em>Aucune donnée</em>';

    $labels = [
        'conception'   => 'Conception',
        'direction'    => 'Direction',
        'surveillance' => 'Surveillance',
        'execution'    => 'Exécution',
    ];
    $columns = [
        1 => 'Papiers peints<br>et/ou Peintures intérieures',
        2 => 'Gros oeuvre fondations,<br>Charpente - Couverture, Etanchéité',
        3 => 'Autres travaux',
        'autre' => '(autres travaux: précisez)',
    ];

    ob_start();
    ?>
    <div class="overflow-x-auto w-full">
    <table class="text-sm font-light ml-0 md:ml-6 mt-4 min-w-[600px] w-[95%] border-collapse mx-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="border-t-2 border-b-2 border-l-2 border-gray-300 p-2 text-center">Activité ou mission exercée</th>
                <?php foreach ($columns as $col => $colLabel): ?>
                    <th class="border-t-2 border-b-2 border-gray-300 p-2 text-center">
                        <?= $colLabel ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($labels as $key => $label): ?>
            <tr>
                <td class="border-r-2 border-l-2 border-b border-gray-300 p-2 pl-4">
                    <label><?= $label ?></label>
                </td>
                <?php foreach ([1,2,3] as $col): ?>
                    <td class="border-r-2 border-b border-gray-300 text-center p-2">
                        <?php if (!empty($missions[$key][$col])): ?>
                            <svg class="w-5 h-5 text-green-600 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <?php else: ?>
                            <svg class="w-5 h-5 text-gray-300 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2"/></svg>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
                <td class="border-r-2 border-b border-gray-300 text-center p-2">
                    <?= !empty($missions[$key]['autre']) ? htmlspecialchars($missions[$key]['autre']) : '' ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php
    return ob_get_clean();
}
