<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <h1 class="text-center font-bold text-3xl mt-8 mb-10 text-gray-900 dark:text-white">
            <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Gestion de la FAQ
        </h1>

        <div class="mb-8 flex items-center justify-between">
            <a href="index.php?page=admin_settings" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'administration
            </a>
            <a href="index.php?page=faq" target="_blank" class="inline-flex items-center gap-2 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium text-sm">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Voir la FAQ publique
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Formulaire d'ajout / édition -->
            <div class="lg:w-1/3">
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6 sticky top-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <?= $edit_faq ? 'Modifier la question' : 'Ajouter une question' ?>
                    </h2>

                    <form method="POST" action="index.php?page=admin_faq">
                        <?php if ($edit_faq): ?>
                            <input type="hidden" name="update_faq" value="1">
                            <input type="hidden" name="faq_id" value="<?= (int)$edit_faq['faq_id'] ?>">
                        <?php else: ?>
                            <input type="hidden" name="create_faq" value="1">
                        <?php endif; ?>

                        <div class="mb-4">
                            <label for="question" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Question <span class="text-red-500">*</span></label>
                            <input type="text" id="question" name="question" required maxlength="500"
                                value="<?= htmlspecialchars($edit_faq['question'] ?? '') ?>"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Ex: Qu'est-ce qu'une DO ?">
                        </div>

                        <div class="mb-4">
                            <label for="reponse" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Réponse <span class="text-red-500">*</span></label>
                            <textarea id="reponse" name="reponse" required rows="8"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Rédigez la réponse ici..."><?= htmlspecialchars($edit_faq['reponse'] ?? '') ?></textarea>
                            <p class="mt-1 text-xs text-gray-400">Utilisez les retours à la ligne pour structurer votre réponse.</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="ordre" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Ordre d'affichage</label>
                                <input type="number" id="ordre" name="ordre" min="0"
                                    value="<?= (int)($edit_faq['ordre'] ?? 0) ?>"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" class="sr-only peer" <?= ($edit_faq === null || ($edit_faq['is_active'] ?? 1)) ? 'checked' : '' ?>>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                                <?= $edit_faq ? 'Mettre à jour' : 'Ajouter' ?>
                            </button>
                            <?php if ($edit_faq): ?>
                                <a href="index.php?page=admin_faq" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                                    Annuler
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des FAQ -->
            <div class="lg:w-2/3">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3 w-12">#</th>
                                    <th scope="col" class="px-4 py-3">Question</th>
                                    <th scope="col" class="px-4 py-3 w-16 text-center">Ordre</th>
                                    <th scope="col" class="px-4 py-3 w-20 text-center">Statut</th>
                                    <th scope="col" class="px-4 py-3 w-28 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($faqs)): ?>
                                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Aucune question FAQ pour le moment.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($faqs as $faq): ?>
                                    <tr class="border-b dark:border-gray-700 <?= ($edit_faq && $edit_faq['faq_id'] == $faq['faq_id']) ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800' ?> hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?= (int)$faq['faq_id'] ?></td>
                                        <td class="px-4 py-3">
                                            <p class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars(mb_strimwidth($faq['question'], 0, 80, '…')) ?></p>
                                            <p class="text-xs text-gray-400 mt-1"><?= htmlspecialchars(mb_strimwidth($faq['reponse'], 0, 100, '…')) ?></p>
                                        </td>
                                        <td class="px-4 py-3 text-center"><?= (int)$faq['ordre'] ?></td>
                                        <td class="px-4 py-3 text-center">
                                            <?php if ($faq['is_active']): ?>
                                                <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Active</span>
                                            <?php else: ?>
                                                <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="index.php?page=admin_faq&edit=<?= (int)$faq['faq_id'] ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Modifier">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>
                                                <form method="POST" action="index.php?page=admin_faq" class="inline" onsubmit="return confirm('Supprimer cette question ?');">
                                                    <input type="hidden" name="delete_faq" value="1">
                                                    <input type="hidden" name="faq_id" value="<?= (int)$faq['faq_id'] ?>">
                                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Supprimer">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
