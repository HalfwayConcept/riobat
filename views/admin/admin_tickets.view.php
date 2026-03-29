<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <h1 class="text-center font-bold text-3xl mt-8 mb-10 text-gray-900 dark:text-white">
            <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
            Gestion des tickets
        </h1>

        <div class="mb-8 flex items-center justify-between">
            <a href="index.php?page=admin_settings" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'administration
            </a>
        </div>

        <!-- Filtres par statut -->
        <?php
        $statut_labels = [
            'ouvert'     => ['label' => 'Ouvert',     'color' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300'],
            'en_cours'   => ['label' => 'En cours',   'color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300'],
            'en_attente' => ['label' => 'En attente', 'color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300'],
            'cloture'    => ['label' => 'Clôturé',    'color' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300'],
        ];
        $total_tickets = array_sum($counts);
        ?>
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="index.php?page=admin_tickets" class="px-3 py-1.5 text-sm rounded-lg font-medium <?= $filtre_statut === null ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600' ?>">
                Tous <span class="ml-1 font-bold"><?= $total_tickets ?></span>
            </a>
            <?php foreach ($statut_labels as $key => $info): ?>
                <a href="index.php?page=admin_tickets&statut=<?= $key ?>" class="px-3 py-1.5 text-sm rounded-lg font-medium <?= $filtre_statut === $key ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : $info['color'] ?>">
                    <?= $info['label'] ?> <span class="ml-1 font-bold"><?= $counts[$key] ?? 0 ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Liste des tickets -->
            <div class="<?= $detail ? 'lg:w-1/2' : 'w-full' ?>">
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">#</th>
                                    <th scope="col" class="px-4 py-3">Date</th>
                                    <th scope="col" class="px-4 py-3">Utilisateur</th>
                                    <th scope="col" class="px-4 py-3">Descriptif</th>
                                    <th scope="col" class="px-4 py-3">Statut</th>
                                    <th scope="col" class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($tickets)): ?>
                                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Aucun ticket trouvé.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($tickets as $t): ?>
                                    <tr class="border-b dark:border-gray-700 <?= ($detail && $detail['ticket_id'] == $t['ticket_id']) ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-white dark:bg-gray-800' ?> hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?= (int)$t['ticket_id'] ?></td>
                                        <td class="px-4 py-3 whitespace-nowrap"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['date_creation']))) ?></td>
                                        <td class="px-4 py-3">
                                            <?php if ($t['user_nom']): ?>
                                                <?= htmlspecialchars($t['user_nom'] . ' ' . $t['user_prenom']) ?>
                                            <?php else: ?>
                                                <span class="text-gray-400 italic">Anonyme</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3 max-w-xs truncate" title="<?= htmlspecialchars($t['descriptif']) ?>">
                                            <?= htmlspecialchars(mb_strimwidth($t['descriptif'], 0, 80, '…')) ?>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-xs font-medium px-2.5 py-0.5 rounded <?= $statut_labels[$t['statut']]['color'] ?? 'bg-gray-100 text-gray-800' ?>">
                                                <?= $statut_labels[$t['statut']]['label'] ?? $t['statut'] ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="index.php?page=admin_tickets&detail=<?= (int)$t['ticket_id'] ?><?= $filtre_statut ? '&statut=' . urlencode($filtre_statut) : '' ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Voir le détail">
                                                <svg class="w-5 h-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Détail du ticket (panneau latéral) -->
            <?php if ($detail): ?>
            <div class="lg:w-1/2">
                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-6 sticky top-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Ticket #<?= (int)$detail['ticket_id'] ?></h2>
                        <a href="index.php?page=admin_tickets<?= $filtre_statut ? '&statut=' . urlencode($filtre_statut) : '' ?>" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="Fermer">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    </div>

                    <div class="space-y-4">
                        <!-- Infos -->
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Date :</span>
                                <p class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars(date('d/m/Y à H:i', strtotime($detail['date_creation']))) ?></p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Utilisateur :</span>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    <?php if ($detail['user_nom']): ?>
                                        <?= htmlspecialchars($detail['user_nom'] . ' ' . $detail['user_prenom']) ?>
                                        <br><span class="text-xs text-gray-400"><?= htmlspecialchars($detail['user_email']) ?></span>
                                    <?php else: ?>
                                        <span class="italic text-gray-400">Anonyme</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- URL -->
                        <?php if (!empty($detail['url_page'])): ?>
                        <div class="text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Page concernée :</span>
                            <p class="text-xs text-blue-600 dark:text-blue-400 break-all mt-1"><?= htmlspecialchars($detail['url_page']) ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Descriptif -->
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Description :</span>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-sm text-gray-900 dark:text-white whitespace-pre-wrap"><?= htmlspecialchars($detail['descriptif']) ?></div>
                        </div>

                        <!-- Fichier joint -->
                        <?php if (!empty($detail['fichier'])): ?>
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Pièce jointe :</span>
                            <?php
                            $file_path = 'public/uploads/tickets/' . $detail['fichier'];
                            $ext = strtolower(pathinfo($detail['fichier'], PATHINFO_EXTENSION));
                            $is_image = in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp']);
                            ?>
                            <div class="mt-1">
                                <?php if ($is_image): ?>
                                    <a href="<?= htmlspecialchars($file_path) ?>" target="_blank">
                                        <img src="<?= htmlspecialchars($file_path) ?>" alt="Pièce jointe" class="max-h-48 rounded-lg border dark:border-gray-600">
                                    </a>
                                <?php else: ?>
                                    <a href="<?= htmlspecialchars($file_path) ?>" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <?= htmlspecialchars($detail['fichier']) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <hr class="dark:border-gray-700">

                        <!-- Changement de statut -->
                        <form method="POST" action="index.php?page=admin_tickets" class="flex items-end gap-3">
                            <input type="hidden" name="ticket_id" value="<?= (int)$detail['ticket_id'] ?>">
                            <div class="flex-1">
                                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Statut</label>
                                <select name="update_ticket_statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <?php foreach ($statut_labels as $key => $info): ?>
                                        <option value="<?= $key ?>" <?= $detail['statut'] === $key ? 'selected' : '' ?>><?= $info['label'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                                Mettre à jour
                            </button>
                        </form>

                        <!-- Solution admin -->
                        <form method="POST" action="index.php?page=admin_tickets">
                            <input type="hidden" name="ticket_id" value="<?= (int)$detail['ticket_id'] ?>">
                            <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Réponse / Solution (admin)</label>
                            <textarea name="update_ticket_solution" rows="4"
                                class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Notez ici la solution ou la réponse…"><?= htmlspecialchars($detail['solution'] ?? '') ?></textarea>
                            <div class="mt-2 flex justify-end">
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600">
                                    Enregistrer la solution
                                </button>
                            </div>
                        </form>

                        <?php if (!empty($detail['date_mise_a_jour'])): ?>
                        <p class="text-xs text-gray-400 dark:text-gray-500 text-right">
                            Dernière mise à jour : <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($detail['date_mise_a_jour']))) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>
