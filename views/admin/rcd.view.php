<!-- Date Picker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

<div class="myContainer">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <!-- component -->
        <form id="form-rcd" action="" method="post" enctype="multipart/form-data" novalidate data-souscripteur-email="<?= htmlspecialchars($DATA['souscripteur_email'] ?? '') ?>" data-doid="<?= (int)$_GET['doid'] ?>">
                <input type="hidden" name="folder" value="<?= getFolderName($_GET['doid']);?>">
                <input type="hidden" name="fields" value="lots-techniques">

        <div class="w-full max-w-xl mb-4">
            <div class="mb-2 flex justify-between items-center">
                <label class="text-sm font-medium text-gray-900 dark:text-white">Lien d'upload sécurisé (7 jours) :</label>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center flex-1">
                    <button type="button" id="btn-generate-link" onclick="generateRcdToken(<?= (int)$_GET['doid'] ?>)" class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-white bg-blue-700 dark:bg-blue-600 border hover:bg-blue-800 dark:hover:bg-blue-700 rounded-s-lg border-blue-700 dark:border-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 me-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/></svg>
                        Générer le lien
                    </button>
                    <div class="relative w-full">
                        <input id="url-shortener" type="text" class="bg-gray-50 border border-gray-300 text-gray-500 dark:text-gray-400 text-sm border-s-0 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" value="" placeholder="Cliquez sur 'Générer le lien'" readonly />
                    </div>
                    <button type="button" onclick="copyUploadLink()" data-tooltip-target="tooltip-url-shortener" class="shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-gray-500 dark:text-gray-400 hover:text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600">
                        <span id="default-icon">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </span>
                        <span id="success-icon" class="hidden">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                        </span>
                    </button>
                    <div id="tooltip-url-shortener" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        <span id="default-tooltip-message">Copier le lien</span>
                        <span id="success-tooltip-message" class="hidden">Copié!</span>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
                <!-- Bouton envoyer par mail -->
                <button type="button" id="btn-mailto-link" onclick="sendUploadLinkByMail()" class="shrink-0 inline-flex items-center gap-1 py-2.5 px-4 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg focus:ring-4 focus:outline-none focus:ring-green-300 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8L17.4392 9.975C15.454 11.078 14.4614 11.63 13.4102 11.846C12.4798 12.037 11.5202 12.037 10.5898 11.846C9.53864 11.63 8.54603 11.078 6.5608 9.975L3 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.59 20.5903 18.284 20.782 17.908C21 17.48 21 16.92 21 15.8V8.2C21 7.08 21 6.52 20.782 6.092C20.5903 5.716 20.2843 5.41 19.908 5.218C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.218C3.71569 5.41 3.40973 5.716 3.21799 6.092C3 6.52 3 7.08 3 8.2V15.8C3 16.92 3 17.48 3.21799 17.908C3.40973 18.284 3.71569 18.59 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z"/></svg>
                    Envoyer par mail
                </button>
            </div>
            <p id="link-expiry-info" class="mt-1 text-xs text-gray-500 dark:text-gray-400 hidden"></p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Attention à ne communiquer ce lien qu'à l'émetteur de la demande</p>
        </div>

        <?php
        // Natures déjà utilisées (pour filtrer les dropdowns)
        $used_nature_ids = [];
        foreach ($array_datas as $d) {
            if (!empty($d['rcd_nature_id']) && $d['rcd_nature_id'] != 99) {
                $used_nature_ids[] = (int)$d['rcd_nature_id'];
            }
        }
        // Couleurs de statut
        $status_row_bg = [
            0 => 'bg-yellow-50 border-l-4 border-l-yellow-400',
            1 => 'bg-red-50 border-l-4 border-l-red-400',
            2 => 'bg-orange-50 border-l-4 border-l-orange-400',
            3 => 'bg-green-50 border-l-4 border-l-green-400',
        ];
        $status_colors = [
            0 => 'bg-yellow-100 text-yellow-800',
            1 => 'bg-red-100 text-red-800',
            2 => 'bg-orange-100 text-orange-800',
            3 => 'bg-green-100 text-green-800',
        ];
        $status_labels = [0 => 'En attente', 1 => 'Illisible/incorrect', 2 => 'Partiel', 3 => 'Validé'];
        ?>
        <table class="border-collapse w-full table-fixed" id="lotsTechniquesTable">
        <thead>
            <tr>
                <th class="p-3 text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 lg:table-cell" style="width:30%">Nom / Nature</th>
                <th class="p-3 text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 lg:table-cell" style="width:10%">Montant</th>
                <th class="p-3 text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 lg:table-cell" style="width:15%">Période de Garantie</th>
                <th class="p-3 text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 lg:table-cell" style="width:30%">Documents</th>
                <th class="p-3 text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 lg:table-cell" style="width:15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            $upload_modals = '';
            foreach ($array_datas as $key => $item) {
                $is_locked = in_array($item['rcd_id'], $locked_rcd_ids);
                $fs = (int)($item['fichier_status'] ?? 0);
                $afs = (int)($item['annexe_fichier_status'] ?? 0);
                $has_rcd = !empty($item['fichier']);
                $has_annexe = !empty($item['annexe_fichier']);
                if ($has_rcd && $has_annexe) { $row_status = min($fs, $afs); }
                elseif ($has_rcd) { $row_status = $fs; }
                elseif ($has_annexe) { $row_status = $afs; }
                else { $row_status = -1; }
                $row_bg = ($row_status >= 0) ? $status_row_bg[$row_status] : (($key % 2 == 0) ? 'bg-white' : 'bg-gray-50');
            ?>
            <tr class="<?= $row_bg ?> lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                <td class="w-full lg:w-1/4 p-3 text-gray-800 border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Lot #<?=$item['rcd_id'];?></span>
                    <input type="hidden" name="lot_id[]" value="<?=$item['rcd_id'];?>" />
                    <?php if (!empty($item['raison_sociale'])): ?>
                    <div class="flex items-center gap-1 mb-1">
                        <?php if ($is_locked): ?><svg class="w-3 h-3 flex-shrink-0 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1a5 5 0 0 0-5 5v2H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 7H7V6a3 3 0 1 1 6 0v2Z"/></svg><?php endif; ?>
                        <input type="text" value="<?= htmlspecialchars($item['raison_sociale']) ?>" readonly class="flex-1 min-w-0 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-300 rounded px-2 py-1 cursor-not-allowed truncate" title="<?= htmlspecialchars($item['raison_sociale']) ?>" />
                        <button type="button" data-popover-target="popover-entreprise-<?= $item['rcd_id'] ?>" data-popover-placement="right" class="flex-shrink-0 text-gray-400 hover:text-gray-600"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg></button>
                    </div>
                    <!-- Popover coordonnées entreprise -->
                    <div data-popover id="popover-entreprise-<?= $item['rcd_id'] ?>" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-80 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3">
                            <p class="font-extrabold text-gray-900 dark:text-white mb-1"><?= htmlspecialchars($item['raison_sociale']) ?></p>
                            <?php if (!empty($item['e_nom']) || !empty($item['e_prenom'])): ?>
                            <p class="text-sm"><span class="font-medium">Contact :</span> <?= htmlspecialchars(($item['e_nom'] ?? '').' '.($item['e_prenom'] ?? '')) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['e_adresse'])): ?>
                            <p class="text-sm"><span class="font-medium">Adresse :</span> <?= htmlspecialchars($item['e_adresse']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['e_code_postal']) || !empty($item['e_commune'])): ?>
                            <p class="text-sm"><?= htmlspecialchars(($item['e_code_postal'] ?? '').' '.($item['e_commune'] ?? '')) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['e_numero_siret'])): ?>
                            <p class="text-sm"><span class="font-medium">SIRET :</span> <?= htmlspecialchars($item['e_numero_siret']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="relative z-0 w-full mb-3 group">
                        <input type="text" name="lot_nom[]" value="<?= $item['rcd_nom']?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="lot_nom[]" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nom</label>
                    </div>
                    <select onchange="if(this.value==99){document.getElementById('autre-nature<?= $key;?>').classList.remove('hidden')}else{document.getElementById('autre-nature<?= $key;?>').classList.add('hidden')}" name="lot_nature[]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" <?= $is_locked ? 'disabled' : '' ?>>
                        <option value="">-- Lot technique --</option>
                        <?php foreach ($array_natures as $nature):
                            $is_current = ($item['rcd_nature_id'] == $nature['rcd_nature_id']);
                            // Masquer les natures déjà utilisées par d'autres lots (sauf celle du lot courant)
                            if (!$is_current && in_array((int)$nature['rcd_nature_id'], $used_nature_ids)) continue;
                        ?>
                        <option <?= $is_current ? 'selected' : '' ?> value="<?= $nature['rcd_nature_id'] ?>"><?= $nature['rcd_nature_nom'] ?></option>
                        <?php endforeach; ?>
                        <option value="99" <?= $item['rcd_nature_id'] == 99 ? 'selected' : '' ?>>-Autre-</option>
                    </select>
                    <?php if ($is_locked): ?>
                    <input type="hidden" name="lot_nature[]" value="<?= $item['rcd_nature_id'] ?>" />
                    <?php endif; ?>
                    <input type="text" class="mt-2 w-full text-sm border border-gray-300 rounded-lg p-2 <?php if($item['rcd_nature_id'] != 99){echo 'hidden';}?>" name="lot_nature_autre[]" value="<?= $item['rcd_nature_autre']?>" id="autre-nature<?= $key;?>" placeholder="Précisez..." />
                </td>
                <td class="w-full lg:min-w-24 p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Montant</span>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" name="lot_montant[]" value="<?= $item['montant']?>" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="lot_montant" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">€uros</label>
                    </div>
                </td>
                <td class="w-full min-w-40 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Période de garantie assurance</span>
                    <?php if (!$has_rcd): ?>
                    <div data-tooltip-target="tooltip-dates-<?= $item['rcd_id'] ?>" class="opacity-50">
                    <?php endif; ?>
                    <h4>Début</h4>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input name="lot_date_debut[]" value="<?= $has_rcd ? convertDateFormat($item['construction_date_debut'], 'fr-us') : '' ?>" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 <?= !$has_rcd ? 'cursor-not-allowed' : '' ?>" placeholder="Select date" <?= !$has_rcd ? 'disabled' : '' ?> data-rcd-date="<?= $item['rcd_id'] ?>">
                    </div>
                    <h4>Fin</h4>
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input name="lot_date_fin[]" value="<?= $has_rcd ? convertDateFormat($item['construction_date_fin'], 'fr-us') : '' ?>" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 <?= !$has_rcd ? 'cursor-not-allowed' : '' ?>" placeholder="Select date" <?= !$has_rcd ? 'disabled' : '' ?> data-rcd-date="<?= $item['rcd_id'] ?>">
                    </div>
                    <?php if (!$has_rcd): ?>
                    </div>
                    <div id="tooltip-dates-<?= $item['rcd_id'] ?>" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Joindre le document RCD avant de renseigner les dates de garantie
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <?php endif; ?>
                </td>                                   
                <!-- DOCUMENTS (RCD + Annexe) -->
                <td class="w-full lg:w-auto p-3 text-gray-800 border border-b block lg:table-cell relative lg:static">
                    <!-- RCD -->
                    <div class="flex items-center justify-between gap-2 mb-3 pb-2 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 uppercase">RCD</span>
                            <?php if(!empty($item['fichier'])): ?>
                            <a target="_blank" title="<?= $item['fichier']?>" href="<?=ltrim(UPLOAD_FOLDER, '/')."/".$folder."/".$item['fichier'];?>">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-700 hover:bg-blue-800 text-white">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z"/></svg>
                                </span>
                            </a>
                            <button data-popover-target="file-rcd-description-<?= $key;?>" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 text-gray-400 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg></button>
                            <div data-popover id="file-rcd-description-<?= $key;?>" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarques RCD</label>
                                <textarea rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Remarques"><?= $item['fichier_remarque']?></textarea>
                            </div>
                            <?php else: ?>
                            <button id="upload-rcd-<?= $key;?>" data-modal-target="rcd-file-modal<?= $key;?>" data-modal-toggle="rcd-file-modal<?= $key;?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-600" type="button">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/></svg>
                            </button>
                            <?php ob_start(); ?>
                            <!-- Modal upload RCD -->
                            <div id="rcd-file-modal<?= $key;?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Responsabilité décennale</h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="rcd-file-modal<?= $key;?>">
                                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5">
                                            <input type="text" name="file_number[]" value="rcd-<?=$item['rcd_id'];?>" class="hidden">
                                            <input name="file_rcd[]" type="file" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG ou PDF</p>
                                            <label class="block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white">Remarques</label>
                                            <textarea name="rcdRemarques[]" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Remarques"></textarea>
                                            <button type="button" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center" data-modal-hide="rcd-file-modal<?= $key;?>" onclick="var btn=document.getElementById('upload-rcd-<?= $key;?>'); var modal=document.getElementById('rcd-file-modal<?= $key;?>'); var fileInput=modal.querySelector('input[type=file]'); if(fileInput && fileInput.files.length>0){btn.classList.remove('bg-gray-300','hover:bg-gray-400','text-gray-600');btn.classList.add('bg-green-500','hover:bg-green-600','text-white');}">Confirmer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $upload_modals .= ob_get_clean(); ?>
                            <?php endif; ?>
                        </div>
                        <?php if($has_rcd): ?>
                        <select onchange="updateFileStatus(<?= $item['rcd_id'] ?>, 'fichier_status', this.value, <?= (int)$_GET['doid'] ?>)" class="text-xs border border-gray-300 rounded p-1 transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="0" <?= $fs == 0 ? 'selected' : '' ?>>En attente</option>
                            <option value="1" <?= $fs == 1 ? 'selected' : '' ?>>Illisible/incorrect</option>
                            <option value="2" <?= $fs == 2 ? 'selected' : '' ?>>Partiel</option>
                            <option value="3" <?= $fs == 3 ? 'selected' : '' ?>>Validé</option>
                        </select>
                        <?php endif; ?>
                    </div>
                    <!-- Annexe -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 uppercase">Annexe</span>
                            <?php if(!empty($item['annexe_fichier'])): ?>
                            <a target="_blank" title="<?= $item['annexe_fichier']?>" href="<?=ltrim(UPLOAD_FOLDER, '/')."/".$folder."/".$item['annexe_fichier'];?>">
                                <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-700 hover:bg-blue-800 text-white">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z"/></svg>
                                </span>
                            </a>
                            <button data-popover-target="file-annexe-description-<?= $key;?>" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 text-gray-400 hover:text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg></button>
                            <div data-popover id="file-annexe-description-<?= $key;?>" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarques Annexe</label>
                                <textarea rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Remarques"><?= $item['annexe_fichier_remarque']?></textarea>
                            </div>
                            <?php else: ?>
                            <button id="upload-annexe-<?= $key;?>" data-modal-target="annexe-file-modal<?= $key;?>" data-modal-toggle="annexe-file-modal<?= $key;?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-600" type="button">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/></svg>
                            </button>
                            <?php ob_start(); ?>
                            <!-- Modal upload Annexe -->
                            <div id="annexe-file-modal<?= $key;?>" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Ajouter un fichier Annexe</h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="annexe-file-modal<?= $key;?>">
                                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5">
                                            <input name="file_annexe[]" type="file" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">PNG, JPG ou PDF</p>
                                            <label class="block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white">Remarques</label>
                                            <textarea name="annexeRemarques[]" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Remarques"></textarea>
                                            <button onclick="var btn=document.getElementById('upload-annexe-<?= $key;?>'); var modal=document.getElementById('annexe-file-modal<?= $key;?>'); var fileInput=modal.querySelector('input[type=file]'); if(fileInput && fileInput.files.length>0){btn.classList.remove('bg-gray-300','hover:bg-gray-400','text-gray-600');btn.classList.add('bg-green-500','hover:bg-green-600','text-white');}" data-modal-hide="annexe-file-modal<?= $key;?>" type="button" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center">Confirmer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $upload_modals .= ob_get_clean(); ?>
                            <?php endif; ?>
                        </div>
                        <?php if($has_annexe): ?>
                        <select onchange="updateFileStatus(<?= $item['rcd_id'] ?>, 'annexe_fichier_status', this.value, <?= (int)$_GET['doid'] ?>)" class="text-xs border border-gray-300 rounded p-1 transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="0" <?= $afs == 0 ? 'selected' : '' ?>>En attente</option>
                            <option value="1" <?= $afs == 1 ? 'selected' : '' ?>>Illisible/incorrect</option>
                            <option value="2" <?= $afs == 2 ? 'selected' : '' ?>>Partiel</option>
                            <option value="3" <?= $afs == 3 ? 'selected' : '' ?>>Validé</option>
                        </select>
                        <?php endif; ?>
                    </div>
                </td>    
                
                <!-- DEBUT DES ACTIONS -->
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                    <div class="flex flex-col items-center gap-2">
                        <?php if (!$has_rcd && !empty($DATA['souscripteur_email'])): ?>
                        <!-- Bouton email pour demander la pièce -->
                        <?php
                            $nature_label = '';
                            foreach ($array_natures as $n) { if ($n['rcd_nature_id'] == $item['rcd_nature_id']) { $nature_label = $n['rcd_nature_nom']; break; } }
                            $mail_subject = rawurlencode('Demande de pièce RCD - DO n°' . $_GET['doid']);
                            $mail_body = rawurlencode("Bonjour,\n\nNous vous prions de bien vouloir nous transmettre l'attestation de responsabilité civile décennale pour le lot suivant :\n\n- Lot : " . ($item['rcd_nom'] ?: $nature_label) . "\n- Entreprise : " . ($item['raison_sociale'] ?? '') . "\n\nCordialement");
                        ?>
                        <a href="mailto:<?= htmlspecialchars($DATA['souscripteur_email']) ?>?subject=<?= $mail_subject ?>&body=<?= $mail_body ?>" title="Envoyer un mail au souscripteur pour demander la pièce" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-green-600 hover:bg-green-700 text-white">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8L17.4392 9.97822C15.454 11.0811 14.4614 11.6326 13.4102 11.8488C12.4798 12.0401 11.5202 12.0401 10.5898 11.8488C9.53864 11.6326 8.54603 11.0811 6.5608 9.97822L3 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z"/></svg>
                        </a>
                        <?php endif; ?>
                        <?php if ($is_locked): ?>
                        <span class="inline-flex items-center gap-1 text-xs text-gray-400" title="Lot créé automatiquement depuis les travaux annexes">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 1a5 5 0 0 0-5 5v2H4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 7H7V6a3 3 0 1 1 6 0v2Z"/></svg>
                        </span>
                        <?php else: ?>
                        <a href="#" data-modal-target="delete-modal" data-modal-toggle="delete-modal" onClick="document.getElementById('lot-del').innerHTML=this.closest('tr').querySelector('input[name=\'lot_nom[]\']').value;globalrow=this;" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <button type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-white bg-orange-400 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </button>
                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php
                # end foreach
            $total +=$item['montant'];
            }
            ?>
           
        </tbody>
    </table>

    <!-- Upload modals (outside table for proper Flowbite initialization) -->
    <?= $upload_modals ?>

    <!-- Delete modal (unique, outside loop) -->
    <div id="delete-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Suppression</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Etes vous sûr de vouloir supprimer le lot technique "<span id="lot-del"></span>" ?</h3>
                    <button data-modal-hide="delete-modal" onclick="console.log(globalrow);deleteRow(globalrow)" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Oui je suis sûr
                    </button>
                    <button data-modal-hide="delete-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex m-16">
        <div class="flex h-16 ">
            <button onclick="insRow()" type="button" class="text-xl text-white flex bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-[32px] h-[32px] text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/>
                </svg>
                &nbsp;Ajouter un Lot
                
            </button>
            <button type="submit" class="text-white text-xl flex bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-[32px] h-[36px] text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z"/>
                </svg>
                &nbsp;Enregistrer
            </button>
            <button id="btn-save-statuses" type="button" onclick="saveAllFileStatuses()" class="hidden text-xl text-white flex bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                <svg class="w-[32px] h-[36px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                &nbsp;<span class="btn-label">Valider les statuts</span>&nbsp;(<span class="status-count">0</span>)
            </button>             
        </div>
        <div class="flex max-w-sm mx-auto h-16 items-right">
                <label for="number-input" class="block  text-2xl m-4 font-medium text-gray-900 dark:text-white">Total </label>
                <input type="number" value="<?= $total?>" id="number-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-2xl text-center rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                <span class="text-2xl m-4 font-medium ">€</span>
        </div>
    </div>    
    <div class="flex ">   

   
    </div>

    </form>

        <table class="hidden" id="lotsTechniquesTableVierge">
        <tbody>
        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                <td class="w-full lg:w-1/4 p-3 text-gray-800 border border-b block lg:table-cell relative lg:static">
                    <input type="hidden" name="lot_id[]" value="NEW_LOT" />
                    <div class="relative z-0 w-full mb-3 group">
                        <input type="text" name="lot_nom[]" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nom</label>
                    </div>
                    <select required name="lot_nature[]" onchange="var autre=this.parentNode.querySelector('input[name=\'lot_nature_autre[]\']');if(this.value==99){autre.classList.remove('hidden')}else{autre.classList.add('hidden')}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Lot technique --</option>
                        <?php foreach ($array_natures as $nature):
                            if (in_array((int)$nature['rcd_nature_id'], $used_nature_ids)) continue;
                        ?>
                        <option value="<?= $nature['rcd_nature_id'] ?>"><?= $nature['rcd_nature_nom'] ?></option>
                        <?php endforeach; ?>
                        <option value="99">-Autre-</option>
                    </select>
                    <input type="text" name="lot_nature_autre[]" class="mt-2 w-full text-sm border border-gray-300 rounded-lg p-2 hidden" placeholder="Précisez..." />
                </td>
                <td class="w-full lg:min-w-24 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="number" min="0" name="lot_montant[]" value="" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                        <label class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">€uros</label>
                    </div>
                </td>
                <td class="w-full min-w-40 p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static opacity-50">
                    <h4>Début</h4>
                    <div class="relative max-w-sm">
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5 cursor-not-allowed" placeholder="Select date" disabled>
                    </div>
                    <h4>Fin</h4>
                    <div class="relative max-w-sm">
                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5 cursor-not-allowed" placeholder="Select date" disabled>
                    </div>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                    <span class="text-sm text-gray-500">Enregistrez d'abord</span>
                </td>
                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                </td>
            </tr>
        </tbody>
        </table>

</div>

    <p class="flex items-center text-sm text-red-500 dark:text-red-400">A compléter obligatoirement <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button></p>
    <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
        A compléter obligatoirement en cas d'absence de liste complète fournie par le souscripteur.
        A Vérifier la présence des éléments (coordonnées assureur, n° de contrat, coordonnées de l'assuré, période de validité), et en particulier : 
        <ul>
            <li> que l'attestation concerne bien la garantie responsabilité décennale, </li>
            <li> que la date d'ouverture de chantier (DOC) est bien incluse dans la période de garantie du contrat RCD indiquée sur l'attestation, </li>
            <li> que l'activité mentionnée sur l'attestation correspond au lot technique réalisé par le constructeur. </li>
        </ul>
        <br/>
        <strong>Attention : Est irrecevable :</strong> 
        <ul>
            <li>l'attestation à l'en-tête de l'apporteur et non de l'assureur</li>
            <li>l'attestation visant une garantie autre que la garantie responsabilité décennale</li>
        </ul>
    </div> 


    <fieldset class="flex flex-wrap border-2 border-gray-400 p-4 m-6">
        <legend>Statut des documents</legend>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-yellow-400 rounded-full me-1.5 flex-shrink-0"></span>En attente de validation</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-red-500 rounded-full me-1.5 flex-shrink-0"></span>Document illisible ou incorrect</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-orange-400 rounded-full me-1.5 flex-shrink-0"></span>Validation partielle</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-green-500 rounded-full me-1.5 flex-shrink-0"></span>Validé</span>
    </fieldset>



</div>

</div>


<script src="public/script/admin-rcd.js"></script>