
<div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
        <div class="w-full flex flex-col items-center p-4">
            <form method="get" action="index.php" class="flex flex-row flex-wrap gap-2 justify-center items-center w-full mb-4">
                <input type="hidden" name="page" value="logs">
                <input type="text" name="DOID" placeholder="DOID" class="border rounded px-2 py-1 text-sm" value="<?= htmlspecialchars($_GET['DOID'] ?? '') ?>">
                <input type="text" name="user_id" placeholder="User ID" class="border rounded px-2 py-1 text-sm" value="<?= htmlspecialchars($_GET['user_id'] ?? '') ?>">
                <input type="date" name="date" class="border rounded px-2 py-1 text-sm" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
                <?php
                // Récupérer la liste des tables SQL hors log
                $pdo = $GLOBALS['pdo'] ?? null;
                $tables = [];
                if ($pdo) {
                    $stmt = $pdo->query("SHOW TABLES");
                    $allTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($allTables as $t) {
                        if (strtolower($t) !== 'log' && strtolower($t) !== 'logs') $tables[] = $t;
                    }
                }
                ?>
                <input list="table-list" name="table" placeholder="Table" class="border rounded px-2 py-1 text-sm" value="<?= htmlspecialchars($_GET['table'] ?? '') ?>">
                <datalist id="table-list">
                    <?php foreach ($tables as $t): ?>
                        <option value="<?= htmlspecialchars($t) ?>">
                    <?php endforeach; ?>
                </datalist>
                <input type="text" id="search-log" name="search" class="border rounded px-2 py-1 text-sm" placeholder="Recherche dans les logs..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">Filtrer</button>
            </form>

            <?php
            // Gestion du tri
            $sortable = [
                'id_log' => 'ID Log',
                'DOID' => 'DOID',
                'date_exec_log' => 'Date exécution',
                'table_cible' => 'Table cible',
                'type_requete' => 'Type requête',
                'requete_sql' => 'Requête SQL',
                'parametres' => 'Paramètres',
                'user_id' => 'User ID',
                'statut' => 'Statut',
            ];
            $order = $_GET['order'] ?? 'date_exec_log';
            $dir = $_GET['dir'] ?? 'desc';
            function sort_icon($col, $order, $dir) {
                if ($col !== $order) return '<span class="inline-block w-3"></span>';
                if ($dir === 'asc') {
                    return '<svg class="inline w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>';
                } else {
                    return '<svg class="inline w-3 h-3 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>';
                }
            }
            // Générer l'URL de tri
            function sort_url($col, $order, $dir) {
                $params = $_GET;
                $params['order'] = $col;
                $params['dir'] = ($order === $col && $dir === 'asc') ? 'desc' : 'asc';
                return 'index.php?' . http_build_query($params);
            }
            // Appliquer le tri côté PHP si besoin (le tri SQL est fait côté contrôleur si possible)
            if (!empty($logs) && isset($sortable[$order])) {
                usort($logs, function($a, $b) use ($order, $dir) {
                    if ($a[$order] == $b[$order]) return 0;
                    if ($dir === 'asc') return ($a[$order] < $b[$order]) ? -1 : 1;
                    return ($a[$order] > $b[$order]) ? -1 : 1;
                });
            }
            ?>
                <table class="bg-slate-50 w-full text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <?php foreach ($sortable as $col => $label): ?>
                                <th scope="col" class="px-4 py-3">
                                    <a href="<?= sort_url($col, $order, $dir) ?>" class="flex items-center gap-1 <?= $order === $col ? 'text-blue-700 font-bold' : '' ?>">
                                        <?= $label ?>
                                        <?= sort_icon($col, $order, $dir) ?>
                                    </a>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-2 text-center font-medium text-gray-900 dark:text-white"><?= $log['id_log'] ?></td>
                            <td class="px-4 py-2 text-center"><?= $log['DOID'] ?></td>
                            <td class="px-4 py-2 text-center"><?= $log['date_exec_log'] ?></td>
                            <td class="px-4 py-2 text-center"><?= htmlspecialchars($log['table_cible']) ?></td>
                            <td class="px-4 py-2 text-center"><?= $log['type_requete'] ?></td>
                            <td class="px-4 py-2 max-w-xs overflow-x-auto"><pre class="whitespace-pre-wrap break-all text-xs"><?= htmlspecialchars($log['requete_sql']) ?></pre></td>
                            <td class="px-4 py-2 max-w-xs overflow-x-auto"><pre class="whitespace-pre-wrap break-all text-xs"><?= htmlspecialchars($log['parametres']) ?></pre></td>
                            <td class="px-4 py-2 text-center"><?= $log['user_id'] ?></td>
                            <td class="px-4 py-2 text-center">
                                <?php if ($log['statut'] === 'réussi'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Réussi</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Échec</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
