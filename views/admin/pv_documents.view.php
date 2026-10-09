<section class="mx-auto max-w-4xl p-6">
    <div class="mb-6 flex items-center justify-between">
        <div><h1 class="text-2xl font-bold">Documents photovoltaïques</h1><p class="text-gray-600">Dossier n°<?= $doid ?> — <?= htmlspecialchars($data['souscripteur_nom_raison'] ?? '') ?></p></div>
        <a href="index.php?page=<?= $isStaff ? 'admin' : 'dashboard' ?>" class="rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">Retour</a>
    </div>
    <?php if ($message): ?><div class="mb-5 rounded border p-4 <?= $messageType === 'error' ? 'border-red-300 bg-red-50 text-red-800' : 'border-green-300 bg-green-50 text-green-800' ?>"><?= htmlspecialchars($message) ?></div><?php endif; ?>
    <?php if ($isStaff): ?><section class="mb-6 rounded-lg bg-white p-5 shadow">
        <h2 class="mb-3 text-lg font-semibold">Lien sécurisé de dépôt</h2>
        <p class="mb-4 text-sm text-gray-600">Le lien est valide pendant 7 jours. Il permet au client de transmettre les documents sans se connecter.</p>
        <form method="post" class="flex flex-wrap gap-3">
            <input type="hidden" name="doid" value="<?= $doid ?>">
            <button name="generate_pv_link" value="1" class="rounded bg-blue-700 px-4 py-2 text-white hover:bg-blue-800">Générer le lien</button>
            <button name="send_pv_link" value="1" class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Générer et envoyer par e-mail</button>
        </form>
        <?php if ($uploadUrl): ?><div class="mt-4"><label class="mb-1 block text-sm font-medium">Lien à transmettre</label><input readonly value="<?= htmlspecialchars($uploadUrl) ?>" class="w-full rounded border bg-gray-50 p-2 text-sm" onclick="this.select()"></div><?php endif; ?>
    </section><?php endif; ?>
    <?php if ($canUpload): ?><section class="mb-6 rounded-lg bg-white p-5 shadow">
        <h2 class="mb-3 text-lg font-semibold">Déposer des documents</h2>
        <p class="mb-4 text-sm text-gray-600">Vous pouvez transmettre une ou plusieurs pièces au nom du client. Formats acceptés : PDF, JPEG et PNG — 20 Mo maximum par fichier.</p>
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="doid" value="<?= $doid ?>">
            <input type="hidden" name="upload_pv_documents" value="1">
            <div><label class="mb-1 block font-medium">Facture d’installation</label><input type="file" name="pv_documents[facture_installation]" accept=".pdf,image/jpeg,image/png" class="block w-full rounded border p-2"></div>
            <div><label class="mb-1 block font-medium">Extrait K-bis</label><input type="file" name="pv_documents[kbis]" accept=".pdf,image/jpeg,image/png" class="block w-full rounded border p-2"></div>
            <div><label class="mb-1 block font-medium">Document relatif au contrat de la société</label><input type="file" name="pv_documents[contrat_societe]" accept=".pdf,image/jpeg,image/png" class="block w-full rounded border p-2"></div>
            <label class="flex items-center gap-2"><input type="checkbox" name="pv_toiture_geree_societe" value="1" <?= !empty($documents['toiture_geree_societe']) ? 'checked' : '' ?>> La toiture est gérée par une société</label>
            <button type="submit" class="rounded bg-amber-600 px-4 py-2 text-white hover:bg-amber-700">Enregistrer les documents</button>
        </form>
    </section><?php elseif (!$isStaff): ?><div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 p-4 text-amber-800">Les documents ne peuvent être transmis qu’après leur demande par votre gestionnaire.</div><?php endif; ?>
    <section class="rounded-lg bg-white p-5 shadow">
        <h2 class="mb-4 text-lg font-semibold">Pièces transmises</h2>
        <?php foreach (['facture_installation_fichier' => 'Facture d’installation', 'kbis_fichier' => 'Extrait K-bis', 'contrat_societe_fichier' => 'Contrat de la société'] as $column => $label): ?>
            <?php $filename = $documents[$column] ?? ''; ?>
            <div class="flex items-center justify-between border-b py-3 last:border-b-0"><span><?= $label ?><?= ($column !== 'contrat_societe_fichier' || !empty($documents['toiture_geree_societe'])) ? ' <span class="text-red-600">*</span>' : '' ?></span><?php if ($filename): ?><a target="_blank" class="text-blue-700 hover:underline" href="<?= htmlspecialchars(ltrim(UPLOAD_FOLDER, '/') . '/' . $folder . '/pv/' . $filename) ?>">Consulter le document</a><?php else: ?><span class="text-amber-700">Non transmis</span><?php endif; ?></div>
        <?php endforeach; ?>
        <?php if (!empty($documents['toiture_geree_societe'])): ?><p class="mt-3 text-sm text-gray-600">La toiture est gérée par une société.</p><?php endif; ?>
    </section>
</section>
