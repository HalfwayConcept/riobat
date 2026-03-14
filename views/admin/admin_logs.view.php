
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
                <table class="bg-slate-50 w-full text-sm text-gray-500 dark:text-gray-400" style="table-layout:fixed;">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <?php foreach ($sortable as $col => $label): ?>
                                <?php if ($col === 'parametres') continue; ?>
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
                            <td class="px-4 py-2 text-center" style="width:60px;">
                                <span class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline w-6 h-6 text-blue-600 cursor-pointer sql-modal-trigger" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-log-id="<?= $log['id_log'] ?>">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6v6a2 2 0 002 2h12a2 2 0 002-2V6M4 6V4a2 2 0 012-2h12a2 2 0 012 2v2M4 6h16" />
                                    </svg>
                                </span>
                                <div id="sql-modal-<?= $log['id_log'] ?>" class="fixed z-50 inset-0 hidden items-center justify-center bg-black bg-opacity-60">
                                    <div class="bg-gray-900 text-white p-8 rounded-lg shadow-2xl border border-blue-400 max-w-3xl w-[90vw] mx-auto flex flex-col relative">
                                        <button class="absolute top-2 right-2 text-gray-300 hover:text-white text-2xl font-bold close-sql-modal">&times;</button>
                                        <div class="mb-4 flex flex-col gap-1">
                                            <span class="text-sm font-bold text-blue-200">Log #<?= $log['id_log'] ?></span>
                                            <span class="text-xs text-gray-300">Exécuté le : <?= htmlspecialchars($log['date_exec_log']) ?></span>
                                        </div>
                                        <div class="flex justify-end mb-4 gap-2">
                                            <button class="flex items-center text-body bg-neutral-primary-strong border border-default-strong hover:bg-neutral-secondary-strong/70 hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none copy-btn" data-copy="<?= htmlspecialchars($log['requete_sql']) ?>">
                                                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z"/></svg>
                                                <span class="text-xs font-semibold">Copier SQL</span>
                                            </button>
                                            <button class="flex items-center text-body bg-neutral-primary-strong border border-default-strong hover:bg-neutral-secondary-strong/70 hover:text-heading focus:ring-4 focus:ring-neutral-tertiary-soft font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none copy-btn" data-copy="<?= htmlspecialchars($log['parametres']) ?>">
                                                <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z"/></svg>
                                                <span class="text-xs font-semibold">Copier paramètres</span>
                                            </button>
                                        </div>
                                        <div>
                                            <div class="mb-4">
                                                <span class="text-blue-300 font-bold">SQL :</span>
                                                <pre class="whitespace-pre-wrap break-all text-xs mt-1" style="max-height:30vh;overflow:auto;"><code class="sql language-sql"><?= htmlspecialchars($log['requete_sql']) ?></code></pre>
                                            </div>
                                            <div>
                                                <span class="text-blue-300 font-bold">Paramètres :</span>
                                                <pre class="whitespace-pre-wrap break-all text-xs mt-1" style="max-height:20vh;overflow:auto;"><code class="language-json"><?= htmlspecialchars($log['parametres']) ?></code></pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Scripts highlight.js et modale SQL -->
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/sql.min.js"></script>
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                hljs.highlightAll();
                                // Copy buttons
                                document.querySelectorAll('.copy-btn').forEach(function(btn) {
                                    btn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        const text = btn.getAttribute('data-copy');
                                        navigator.clipboard.writeText(text);
                                        btn.querySelector('span').textContent = 'Copié!';
                                        setTimeout(() => { btn.querySelector('span').textContent = btn.classList.contains('copy-sql') ? 'Copier SQL' : 'Copier paramètres'; }, 1200);
                                    });
                                });
                                // Modal logic
                                document.querySelectorAll('.sql-modal-trigger').forEach(function(icon) {
                                    icon.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                        const logId = icon.getAttribute('data-log-id');
                                        const modal = document.getElementById('sql-modal-' + logId);
                                        if (modal) {
                                            modal.classList.remove('hidden');
                                            modal.classList.add('flex');
                                        }
                                    });
                                });
                                document.querySelectorAll('.close-sql-modal').forEach(function(btn) {
                                    btn.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                        btn.closest('.fixed').classList.add('hidden');
                                        btn.closest('.fixed').classList.remove('flex');
                                    });
                                });
                                // Close modal on background click
                                document.querySelectorAll('.fixed.z-50').forEach(function(modal) {
                                    modal.addEventListener('click', function(e) {
                                        if (e.target === modal) {
                                            modal.classList.add('hidden');
                                            modal.classList.remove('flex');
                                        }
                                    });
                                });
                            });
                            </script>
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
