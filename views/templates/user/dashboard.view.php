<section class="bg-slate-50 p-4 dark:bg-gray-900 sm:p-6">
    <div class="mx-auto max-w-screen-xl">
        <div class="mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Mes demandes d’études</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Consultez, modifiez ou complétez vos dossiers.</p>
            </div>
        </div>

        <?php
        $statusLabels = [
            0 => ['label' => 'En cours de création', 'class' => 'bg-blue-100 text-blue-800'],
            1 => ['label' => 'En attente des documents', 'class' => 'bg-amber-100 text-amber-800'],
            2 => ['label' => 'Validée', 'class' => 'bg-green-100 text-green-800'],
            3 => ['label' => 'Clôturée', 'class' => 'bg-gray-200 text-gray-700'],
        ];
        ?>

        <?php if (empty($dos)): ?>
            <div class="rounded-lg border border-dashed border-gray-300 bg-white p-10 text-center text-gray-600 shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                Vous n’avez pas encore créé de demande d’étude.
            </div>
        <?php else: ?>
            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($dos as $do): ?>
                    <?php
                    $isPv = ($do['type_demande'] ?? 'do') === 'pv';
                    $typeLabel = $isPv ? 'Photovoltaïque' : 'Dommage ouvrage';
                    $typeClass = $isPv ? 'border-amber-400 bg-amber-50 dark:bg-amber-950/20' : 'border-blue-500 bg-blue-50 dark:bg-blue-950/20';
                    $badgeClass = $isPv ? 'bg-amber-500 text-white' : 'bg-blue-700 text-white';
                    $status = $statusLabels[(int)($do['status'] ?? 0)] ?? $statusLabels[0];
                    $editPage = $isPv ? 'step2' : 'step1';
                    ?>
                    <article class="rounded-xl border-l-4 <?= $typeClass ?> p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-bold <?= $badgeClass ?>"><?= $typeLabel ?></span>
                                <h2 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">Demande n°<?= (int)$do['DOID'] ?></h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300"><?= htmlspecialchars($do['souscripteur_nom_raison'] ?? '') ?></p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $status['class'] ?>"><?= $status['label'] ?></span>
                        </div>
                        <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">Créée le <?= htmlspecialchars($do['session_debut'] ?? $do['date_creation'] ?? '') ?></p>
                        <div class="mt-5 flex items-center gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                            <a href="index.php?page=fiche&doid=<?= (int)$do['DOID'] ?>" title="Voir la demande" aria-label="Voir la demande" class="rounded-lg p-2 text-gray-600 hover:bg-white hover:text-blue-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0c0 4-4 7-9 7s-9-3-9-7 4-7 9-7 9 3 9 7z"/></svg>
                            </a>
                            <a href="index.php?page=<?= $editPage ?>&session_load_id=<?= (int)$do['DOID'] ?>" title="Modifier la demande" aria-label="Modifier la demande" class="rounded-lg p-2 text-gray-600 hover:bg-white hover:text-blue-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                <img src="public/pictures/file-pen-solid.svg" alt="" width="24" class="h-6 w-6">
                            </a>
                            <?php if ((int)($do['status'] ?? 0) === 1): ?>
                                <a href="index.php?page=<?= $isPv ? 'pv_documents' : 'rcd' ?>&doid=<?= (int)$do['DOID'] ?>" title="Transmettre les documents" aria-label="Transmettre les documents" class="rounded-lg p-2 text-gray-600 hover:bg-white <?= $isPv ? 'hover:text-amber-700' : 'hover:text-blue-700' ?> dark:text-gray-300 dark:hover:bg-gray-800">
                                    <img src="public/pictures/briefcase-upload.svg" alt="" width="24" class="h-6 w-6">
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
