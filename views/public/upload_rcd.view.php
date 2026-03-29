<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload documents RCD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto py-8 px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/></svg>
                <h1 class="text-2xl font-bold text-gray-900">Traitements des fichiers (RCD et annexes)</h1>
            </div>
            <p class="text-gray-600">Dossier DO n°<?= htmlspecialchars($DOID) ?>. Veuillez transmettre les attestations de responsabilité civile décennale pour les lots ci-dessous.</p>
            <p class="text-sm text-gray-500 mt-1">Ce lien expire le <?= date('d/m/Y à H:i', strtotime($tokenData['expires_at'])) ?>.</p>

        </div>
        <!-- Message d'information utilisateur -->
        <div class="bg-blue-50 border border-blue-200 text-blue-900 rounded-lg p-4 mb-6">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                <li>Le <strong>montant des travaux</strong> peut être indiqué à titre <strong>facultatif</strong>.</li>
                <li>Vous pouvez également préciser la <strong>période de garantie couverte par la RCD</strong> (facultatif).</li>
                <li>Les <strong>annexes</strong> sont disponibles pour ajouter des <strong>devis</strong> ou <strong>documents complémentaires</strong> relatifs au prestataire du lot concerné.</li>
            </ul>
        </div>

        <?php if (!empty($success_msg)): ?>
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <svg class="inline w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            <?= htmlspecialchars($success_msg) ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($error_msg)): ?>
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
            <?= htmlspecialchars($error_msg) ?>
        </div>
        <?php endif; ?>

        <!-- Upload form -->
        <?php
        $status_labels = [0 => 'En attente de validation', 1 => 'Illisible / incorrect', 2 => 'Validation partielle', 3 => 'Validé'];
        $all_validated = true;
        $has_any_upload = false;
        foreach ($array_datas as $check_item) {
            $rfs = (int)($check_item['fichier_status'] ?? 0);
            $afs = (int)($check_item['annexe_fichier_status'] ?? 0);
            $hr = !empty($check_item['fichier']);
            $ha = !empty($check_item['annexe_fichier']);
            if (!$hr || $rfs !== 3) $all_validated = false;
            if ($hr && $rfs !== 3) $has_any_upload = true;
            if (!$hr) $has_any_upload = true;
            if (!$ha || $afs !== 3) { /* annexe not fully validated */ }
            if ($ha && $afs !== 3) $has_any_upload = true;
            if (!$ha) $has_any_upload = true;
        }
        ?>

        <?php if ($all_validated): ?>
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
            <svg class="inline w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
            Tous les documents ont été validés. Aucune action supplémentaire n'est requise.
        </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <?php foreach ($array_datas as $item):
                $nature_nom = '';
                foreach ($array_natures as $n) {
                    if ($n['rcd_nature_id'] == $item['rcd_nature_id']) { $nature_nom = $n['rcd_nature_nom']; break; }
                }
                $has_rcd = !empty($item['fichier']);
                $has_annexe = !empty($item['annexe_fichier']);
                $rcd_status = (int)($item['fichier_status'] ?? 0);
                $annexe_status = (int)($item['annexe_fichier_status'] ?? 0);
                $rcd_remarque = trim($item['fichier_remarque'] ?? '');
                $annexe_remarque = trim($item['annexe_fichier_remarque'] ?? '');
            ?>
            <div class="bg-white rounded-lg shadow-sm p-5 border <?= ($has_rcd && $rcd_status === 1) || ($has_annexe && $annexe_status === 1) ? 'border-red-300' : (($has_rcd && $rcd_status === 2) || ($has_annexe && $annexe_status === 2) ? 'border-orange-300' : 'border-gray-200') ?>">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="font-semibold text-gray-900">
                            <?= htmlspecialchars($item['rcd_nom'] ?: $nature_nom) ?>
                            <?php if (!empty($item['raison_sociale'])): ?>
                            <span class="text-sm font-normal text-gray-500">— <?= htmlspecialchars($item['raison_sociale']) ?></span>
                            <?php endif; ?>
                        </h3>
                        <span class="text-xs text-gray-500"><?= htmlspecialchars($nature_nom) ?></span>
                    </div>
                    <span class="text-xs text-gray-400">Lot #<?= $item['rcd_id'] ?></span>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="md:col-span-2 grid md:grid-cols-3 gap-4 items-start">
                        <!-- Bloc RCD à gauche (2/3) -->
                        <div class="md:col-span-2">
                            <label class="block mb-1 text-sm font-medium text-gray-700">Document RCD</label>
                            <?php /* ...existing RCD upload logic ici... */ ?>
                            <?php if ($has_rcd && $rcd_status === 3): ?>
                            <div class="flex items-center gap-2 p-2 bg-green-50 rounded-lg border border-green-200">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                                <a href="<?= htmlspecialchars(ltrim(UPLOAD_FOLDER, '/') . '/' . $folder . '/' . $item['fichier']) ?>" target="_blank" class="text-sm text-green-700 hover:underline truncate"><?= htmlspecialchars($item['fichier']) ?></a>
                            </div>
                            <span class="inline-flex items-center gap-1 mt-1 text-xs font-medium text-green-700"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Validé</span>
                            <?php elseif ($has_rcd && ($rcd_status === 1 || $rcd_status === 2)): ?>
                            <div class="p-3 mb-2 rounded-lg border <?= $rcd_status === 1 ? 'bg-red-50 border-red-300' : 'bg-orange-50 border-orange-300' ?>">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-5 h-5 flex-shrink-0 <?= $rcd_status === 1 ? 'text-red-600' : 'text-orange-600' ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                    <span class="text-sm font-semibold <?= $rcd_status === 1 ? 'text-red-800' : 'text-orange-800' ?>"><?= $status_labels[$rcd_status] ?></span>
                                </div>
                                <p class="text-xs <?= $rcd_status === 1 ? 'text-red-700' : 'text-orange-700' ?> mb-1">Document transmis : <span class="font-medium"><?= htmlspecialchars($item['fichier']) ?></span></p>
                                <?php if (!empty($rcd_remarque)): ?>
                                <div class="mt-2 p-2 rounded bg-white border <?= $rcd_status === 1 ? 'border-red-200' : 'border-orange-200' ?>">
                                    <p class="text-xs font-semibold <?= $rcd_status === 1 ? 'text-red-700' : 'text-orange-700' ?> mb-0.5">Remarque du gestionnaire :</p>
                                    <p class="text-sm <?= $rcd_status === 1 ? 'text-red-900' : 'text-orange-900' ?> font-medium"><?= nl2br(htmlspecialchars($rcd_remarque)) ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <label class="block mb-1 text-sm font-medium <?= $rcd_status === 1 ? 'text-red-700' : 'text-orange-700' ?>">Transmettre un nouveau document RCD :</label>
                            <input type="file" name="rcd_file_<?= $item['rcd_id'] ?>" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-900 border <?= $rcd_status === 1 ? 'border-red-400' : 'border-orange-400' ?> rounded-lg cursor-pointer bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium <?= $rcd_status === 1 ? 'file:bg-red-50 file:text-red-700 hover:file:bg-red-100' : 'file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100' ?>">
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG ou PNG (max 20 Mo)</p>
                            <?php elseif ($has_rcd && $rcd_status === 0): ?>
                            <div class="flex items-center gap-2 p-2 bg-yellow-50 rounded-lg border border-yellow-200">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                <span class="text-sm text-yellow-700 truncate"><?= htmlspecialchars($item['fichier']) ?></span>
                            </div>
                            <span class="inline-flex items-center gap-1 mt-1 text-xs text-yellow-700">En attente de validation par le gestionnaire</span>
                            <?php else: ?>
                            <input type="file" name="rcd_file_<?= $item['rcd_id'] ?>" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">PDF, JPG ou PNG (max 20 Mo)</p>
                            <?php endif; ?>
                        </div>
                        <!-- Bloc dates de garantie RCD (1/3) -->
                        <div class="md:col-span-1 flex flex-col md:items-end gap-4">
                            <div class="w-full">
                                <label class="block mb-1 text-sm font-medium text-gray-700">Période de garantie RCD <span class="text-xs text-gray-400">(facultatif)</span></label>
                                <div class="flex gap-2">
                                    <input type="date" name="date_debut_<?= $item['rcd_id'] ?>" value="<?= htmlspecialchars($item['construction_date_debut'] ?? '') ?>" class="block w-1/2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 p-2">
                                    <span class="self-center text-xs text-gray-500">à</span>
                                    <input type="date" name="date_fin_<?= $item['rcd_id'] ?>" value="<?= htmlspecialchars($item['construction_date_fin'] ?? '') ?>" class="block w-1/2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 p-2">
                                </div>
                            </div>
                        </div>
                        <!-- Bloc annexes + montant sur la même ligne -->
                        <div class="md:col-span-3 mt-4">
                            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                                <div class="flex-1">
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Annexes (devis ou documents complémentaires)</label>
                                    <?php if ($has_annexe && $annexe_status === 3): ?>
                                    <div class="flex items-center gap-2 p-2 bg-green-50 rounded-lg border border-green-200">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/></svg>
                                        <a href="<?= htmlspecialchars(ltrim(UPLOAD_FOLDER, '/') . '/' . $folder . '/' . $item['annexe_fichier']) ?>" target="_blank" class="text-sm text-green-700 hover:underline truncate"><?= htmlspecialchars($item['annexe_fichier']) ?></a>
                                    </div>
                                    <span class="inline-flex items-center gap-1 mt-1 text-xs font-medium text-green-700"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Validé</span>
                                    <?php elseif ($has_annexe && ($annexe_status === 1 || $annexe_status === 2)): ?>
                                    <div class="p-3 mb-2 rounded-lg border <?= $annexe_status === 1 ? 'bg-red-50 border-red-300' : 'bg-orange-50 border-orange-300' ?>">
                                        <div class="flex items-center gap-2 mb-1">
                                            <svg class="w-5 h-5 flex-shrink-0 <?= $annexe_status === 1 ? 'text-red-600' : 'text-orange-600' ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                            <span class="text-sm font-semibold <?= $annexe_status === 1 ? 'text-red-800' : 'text-orange-800' ?>"><?= $status_labels[$annexe_status] ?></span>
                                        </div>
                                        <p class="text-xs <?= $annexe_status === 1 ? 'text-red-700' : 'text-orange-700' ?> mb-1">Document transmis : <span class="font-medium"><?= htmlspecialchars($item['annexe_fichier']) ?></span></p>
                                        <?php if (!empty($annexe_remarque)): ?>
                                        <div class="mt-2 p-2 rounded bg-white border <?= $annexe_status === 1 ? 'border-red-200' : 'border-orange-200' ?>">
                                            <p class="text-xs font-semibold <?= $annexe_status === 1 ? 'text-red-700' : 'text-orange-700' ?> mb-0.5">Remarque du gestionnaire :</p>
                                            <p class="text-sm <?= $annexe_status === 1 ? 'text-red-900' : 'text-orange-900' ?> font-medium"><?= nl2br(htmlspecialchars($annexe_remarque)) ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <label class="block mb-1 text-sm font-medium <?= $annexe_status === 1 ? 'text-red-700' : 'text-orange-700' ?>">Transmettre un nouveau document annexe :</label>
                                    <input type="file" name="annexe_file_<?= $item['rcd_id'] ?>" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-900 border <?= $annexe_status === 1 ? 'border-red-400' : 'border-orange-400' ?> rounded-lg cursor-pointer bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium <?= $annexe_status === 1 ? 'file:bg-red-50 file:text-red-700 hover:file:bg-red-100' : 'file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100' ?>">
                                    <p class="mt-1 text-xs text-gray-500">PDF, JPG ou PNG (max 20 Mo)</p>
                                    <?php elseif ($has_annexe && $annexe_status === 0): ?>
                                    <div class="flex items-center gap-2 p-2 bg-yellow-50 rounded-lg border border-yellow-200">
                                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                        <span class="text-sm text-yellow-700 truncate"><?= htmlspecialchars($item['annexe_fichier']) ?></span>
                                    </div>
                                    <span class="inline-flex items-center gap-1 mt-1 text-xs text-yellow-700">En attente de validation par le gestionnaire</span>
                                    <?php else: ?>
                                    <input type="file" name="annexe_file_<?= $item['rcd_id'] ?>" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-xs text-gray-500">PDF, JPG ou PNG (max 20 Mo)</p>
                                    <?php endif; ?>
                                </div>
                                <div class="md:w-56 flex-shrink-0">
                                    <label class="block mb-1 text-sm font-medium text-gray-700">Montant des travaux (€) <span class="text-xs text-gray-400">(facultatif)</span></label>
                                    <input type="number" step="0.01" min="0" name="montant_<?= $item['rcd_id'] ?>" value="<?= htmlspecialchars($item['montant'] ?? '') ?>" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 p-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (!$all_validated): ?>
            <div class="flex justify-center pt-4">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/></svg>
                    Soumettre mes informations
                </button>
            </div>
            <?php endif; ?>
        </form>

        <p class="text-center text-xs text-gray-400 mt-8">
            Les fichiers transmis seront vérifiés par votre gestionnaire.
            En cas de difficulté, contactez votre interlocuteur habituel.
        </p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
