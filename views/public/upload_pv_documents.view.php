<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents photovoltaïques</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
<main class="mx-auto max-w-2xl px-4 py-10">
    <section class="rounded-lg bg-white p-6 shadow">
        <h1 class="text-2xl font-bold text-gray-900">Documents de votre demande photovoltaïque</h1>
        <p class="mt-2 text-gray-600">Dossier n°<?= (int)$doid ?>. Formats acceptés : PDF, JPEG ou PNG (20 Mo maximum).</p>
        <p class="mt-1 text-sm text-gray-500">Ce lien expire le <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($tokenData['expires_at']))) ?>.</p>
        <?php if ($success): ?><p class="mt-4 rounded border border-green-200 bg-green-50 p-3 text-green-800"><?= htmlspecialchars($success) ?></p><?php endif; ?>
        <?php if ($errors): ?><div class="mt-4 rounded border border-red-200 bg-red-50 p-3 text-red-800"><ul class="list-inside list-disc"><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="mt-6 space-y-5">
            <?php foreach (['facture_installation' => ['Facture d’installation', 'facture_installation_fichier'], 'kbis' => ['Extrait K-bis', 'kbis_fichier'], 'contrat_societe' => ['Document relatif au contrat de la société', 'contrat_societe_fichier']] as $field => [$label, $column]): ?>
                <div><label class="mb-1 block font-medium"><?= $label ?><?= $field !== 'contrat_societe' ? ' *' : '' ?></label><?php if (!empty($documents[$column])): ?><p class="mb-1 text-sm text-green-700">Déjà transmis : <?= htmlspecialchars($documents[$column]) ?></p><?php endif; ?><input type="file" name="pv_documents[<?= $field ?>]" accept=".pdf,image/jpeg,image/png" class="block w-full rounded border p-2" /></div>
            <?php endforeach; ?>
            <label class="flex gap-2"><input type="checkbox" name="pv_toiture_geree_societe" value="1" <?= !empty($documents['toiture_geree_societe']) ? 'checked' : '' ?>> La toiture est gérée par une société</label>
            <p class="text-sm text-gray-600">Dans ce cas, le document relatif au contrat de la société est obligatoire.</p>
            <button class="rounded bg-amber-600 px-5 py-2.5 font-medium text-white hover:bg-amber-700">Transmettre les documents</button>
        </form>
    </section>
</main>
</body>
</html>
