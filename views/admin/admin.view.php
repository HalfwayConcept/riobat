<style>
    .rcd-icon-red { filter: invert(27%) sepia(91%) saturate(5583%) hue-rotate(352deg) brightness(93%) contrast(97%); }
    .rcd-icon-yellow { filter: invert(73%) sepia(74%) saturate(658%) hue-rotate(360deg) brightness(101%) contrast(104%); }
    .rcd-icon-green { filter: invert(52%) sepia(87%) saturate(391%) hue-rotate(93deg) brightness(96%) contrast(92%); }
    .action-icon-neutral { filter: invert(50%) sepia(0%) saturate(0%) brightness(60%) contrast(90%); }
</style>
<script src="public/script/admin-historique.js"></script>
<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8 p-4 border-l-4 border-blue-500 bg-blue-50 dark:bg-gray-800 dark:border-blue-400">
    <div class="flex justify-end mb-4 gap-4">
        <a href="index.php?page=admin_settings" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Administration
        </a>
    </div>
<p class="text-center font-medium text-2xl mt-16">Liste des Dommages Ouvrages</p>
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <?php if(isset($infodelete)){ echo "<span>".$infodelete."</span>"; }; ?>
    </div>

    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <?php include 'views/admin/filter.view.php'; ?>
            <div class="overflow-x-auto">
                <table class="bg-slate-50 w-full text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Demande DO n°</th>
                            <th scope="col" class="px-4 py-3">Date de création</th>
                            <th scope="col" class="px-4 py-3">Souscripteur</th>
                            <th scope="col" class="px-4 py-3">Adresse de la construction</th>
                            <th scope="col" class="px-4 py-3">Coût en €</th>
                            <th scope="col" class="px-4 py-3">Statut</th>
                            <th scope="col" class="px-4 py-3">Assurance</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status_config = [
                            0 => ['label' => 'En cours de création', 'bg' => 'bg-blue-100',   'badge' => 'bg-blue-500 text-white'],
                            1 => ['label' => 'En attente des documents', 'bg' => 'bg-amber-100',  'badge' => 'bg-amber-500 text-white'],
                            2 => ['label' => 'Validé (offre transmise)', 'bg' => 'bg-green-100',  'badge' => 'bg-green-500 text-white'],
                            3 => ['label' => 'Clôturé',                  'bg' => 'bg-gray-200',   'badge' => 'bg-gray-500 text-white'],
                        ];
                        foreach($dos as $do){
                            $do_status = (int)($do['status'] ?? 0);
                            $sc = $status_config[$do_status] ?? $status_config[0];
                            ?>
                            <tr class="<?= $sc['bg'] ?> border-b text-black dark:border-gray-700">
                                <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap dark:text-white">
                                    <?php echo $do['DOID']; ?>
                                </th>
                                <td class="px-4 py-3 text-center"><?php echo $do['date_creation']; ?></td>
                                <td class="px-4 py-3 text-center"><?php echo $do['souscripteur_nom_raison']; ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col text-center">
                                        <?php echo "<span>".$do['construction_adresse']."</span>"; ?>
                                        <?php echo "<span>".$do['construction_adresse_code_postal']."&nbsp;". $do['construction_adresse_commune'] ."</span>"; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center"><?php echo $do['construction_cout_operation']; ?></td>
                                <!-- Statut -->
                                <td class="px-4 py-3 text-center">
                                    <form method="POST" action="index.php?page=admin" class="inline">
                                        <input type="hidden" name="update_do_status" value="1">
                                        <input type="hidden" name="do_status_doid" value="<?= $do['DOID'] ?>">
                                        <select name="do_status_value" onchange="this.form.submit()" class="text-xs rounded px-2 py-1 border border-gray-300 <?= $sc['badge'] ?>">
                                            <?php foreach ($status_config as $val => $cfg): ?>
                                                <option value="<?= $val ?>" <?= $val === $do_status ? 'selected' : '' ?>><?= $cfg['label'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </td>
                                <!-- Assurance -->
                                <td class="px-4 py-3 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        <?php if (!empty($do['assurance_logo'])): ?>
                                            <img src="public/pictures/assurance/<?= htmlspecialchars($do['assurance_logo']) ?>" alt="<?= htmlspecialchars($do['assurance_nom'] ?? '') ?>" class="h-8 max-w-[80px] object-contain" title="<?= htmlspecialchars($do['assurance_nom'] ?? '') ?>">
                                        <?php endif; ?>
                                        <form method="POST" action="index.php?page=admin" class="inline">
                                            <input type="hidden" name="update_do_assurance" value="1">
                                            <input type="hidden" name="do_assurance_doid" value="<?= $do['DOID'] ?>">
                                            <select name="do_assurance_value" onchange="this.form.submit()" class="text-xs rounded px-1 py-0.5 border border-gray-300 bg-white max-w-[120px]">
                                                <option value="">— Aucune —</option>
                                                <?php foreach ($assurances as $ass): ?>
                                                    <option value="<?= $ass['assurance_id'] ?>" <?= ((int)($do['assurance_id'] ?? 0)) === (int)$ass['assurance_id'] ? 'selected' : '' ?>><?= htmlspecialchars($ass['nom']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 flex justify-center">
                                    <div class="flex flex-row py-1 text-sm dark:text-gray-200">
                                        <?php
                                        $doid_key = (int)$do['DOID'];
                                        $rcd_s = $rcd_stats[$doid_key] ?? ['total' => 0, 'uploaded' => 0];
                                        if ($rcd_s['total'] === 0) {
                                            $rcd_color = 'grayscale opacity-40';
                                            $rcd_title = 'Aucun lot RCD';
                                        } elseif ($rcd_s['uploaded'] === 0) {
                                            $rcd_color = 'rcd-icon-red';
                                            $rcd_title = 'Aucun document uploadé (' . $rcd_s['total'] . ' lot(s))';
                                        } elseif ($rcd_s['uploaded'] < $rcd_s['total']) {
                                            $rcd_color = 'rcd-icon-yellow';
                                            $rcd_title = $rcd_s['uploaded'] . '/' . $rcd_s['total'] . ' document(s) uploadé(s)';
                                        } else {
                                            $rcd_color = 'rcd-icon-green';
                                            $rcd_title = 'Tous les documents uploadés (' . $rcd_s['total'] . '/' . $rcd_s['total'] . ')';
                                        }
                                        ?>
                                        <a href="index.php?page=rcd&doid=<?php echo $do['DOID']; ?>" class="relative block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" title="<?= $rcd_title ?>">
                                            <img src="public/pictures/briefcase-upload.svg" alt="RCD" width="20px" class="<?= $rcd_color ?>"/>
                                            <?php if ($rcd_s['total'] > 0): ?>
                                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white rounded-full <?= $rcd_s['uploaded'] === $rcd_s['total'] ? 'bg-green-500' : ($rcd_s['uploaded'] === 0 ? 'bg-red-500' : 'bg-yellow-500') ?>"><?= $rcd_s['uploaded'] ?></span>
                                            <?php endif; ?>
                                        </a>
                                        <a href="index.php?page=fiche&doid=<?php echo $do['DOID']; ?>" class="block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"><img src="public/pictures/eye-solid.svg" alt="see-pic" width="20px" class="action-icon-neutral"/></a>
                                        <a href="index.php?page=step1&session_load_id=<?php echo $do['DOID']; ?>" class="block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"><img src="public/pictures/file-pen-solid.svg" alt="edit-pic" width="20px" class="action-icon-neutral"/></a>
                                        <button type="button" onclick="openHistorique(<?php echo $do['DOID']; ?>)" class="block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white" title="Historique">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                        <a href="index.php?page=admin&deletedo=<?php echo $do['DOID']; ?>" class="block py-2 px-1 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"><img src="public/pictures/trash-solid.svg" alt="trash-pic" width="16px" class="action-icon-neutral"/></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                    </tbody>
                </table>
            </div>
    <fieldset class="flex flex-wrap border-2 border-gray-400 p-4 m-6">
        <legend>Statut DO</legend>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-blue-500 rounded-full me-1.5 flex-shrink-0"></span>En cours de création</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-amber-500 rounded-full me-1.5 flex-shrink-0"></span>En attente des documents</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-green-500 rounded-full me-1.5 flex-shrink-0"></span>Validé (offre transmise)</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-gray-500 rounded-full me-1.5 flex-shrink-0"></span>Clôturé</span>
    </fieldset>                
            <!-- <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                </span>
                <ul class="inline-flex items-stretch -space-x-px">
                    <li>
                        <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav> -->
        </div>
    </div>
</section>

<!-- Modal Historique DO -->
<div id="historique-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-lg w-[90vw] mx-auto flex flex-col relative">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="historique-modal-title">Historique DO</h3>
            <button type="button" onclick="closeHistorique()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div class="p-4 overflow-y-auto max-h-[60vh]" id="historique-modal-body">
            <p class="text-gray-500 dark:text-gray-400 text-center">Chargement...</p>
        </div>
        <div class="flex justify-end p-4 border-t dark:border-gray-600">
            <button type="button" onclick="closeHistorique()" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Fermer</button>
        </div>
    </div>
</div>

