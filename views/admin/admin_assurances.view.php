<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <h1 class="text-center font-bold text-3xl mt-8 mb-10 text-gray-900 dark:text-white">
            <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Gestion des compagnies d'assurance
        </h1>

        <div class="mb-8 flex items-center justify-between">
            <a href="index.php?page=admin_settings" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'administration
            </a>
            <button onclick="document.getElementById('modal-add-assurance').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Ajouter une compagnie
            </button>
        </div>

        <?php if(!empty($assurance_message)): ?>
            <?= $assurance_message; ?>
        <?php endif; ?>

        <!-- Tableau des assurances -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3">Logo</th>
                            <th scope="col" class="px-4 py-3">Nom</th>
                            <th scope="col" class="px-4 py-3">Statut</th>
                            <th scope="col" class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($assurances as $a): ?>
                        <tr class="border-b dark:border-gray-700 <?= $a['active'] ? 'bg-white dark:bg-gray-800' : 'bg-gray-100 dark:bg-gray-800/50 opacity-60' ?>">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?= (int)$a['assurance_id']; ?></td>
                            <td class="px-4 py-3">
                                <?php if(!empty($a['logo'])): ?>
                                    <img src="public/pictures/assurance/<?= htmlspecialchars($a['logo']); ?>" alt="<?= htmlspecialchars($a['nom']); ?>" class="h-8 w-auto max-w-[100px] object-contain rounded">
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs italic">Aucun logo</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($a['nom']); ?></td>
                            <td class="px-4 py-3">
                                <?php if($a['active']): ?>
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Actif</span>
                                <?php else: ?>
                                    <span class="text-xs font-medium px-2.5 py-0.5 rounded bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditAssurance(<?= htmlspecialchars(json_encode($a), ENT_QUOTES); ?>)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Modifier">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form method="post" action="index.php?page=admin_assurances" onsubmit="return confirm('Supprimer cette compagnie d\'assurance ?');" class="inline">
                                        <input type="hidden" name="delete_assurance_id" value="<?= (int)$a['assurance_id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Supprimer">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            <?= count($assurances); ?> compagnie(s) d'assurance enregistrée(s).
        </p>
    </div>
</section>

<!-- ============================== -->
<!-- Modal : Ajouter une assurance -->
<!-- ============================== -->
<div id="modal-add-assurance" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ajouter une compagnie</h3>
            <button onclick="document.getElementById('modal-add-assurance').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_assurances" class="p-4 space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom de la compagnie *</label>
                <input type="text" name="add_nom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Fichier logo</label>
                <select name="add_logo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">-- Aucun logo --</option>
                    <?php
                    $logoDir = ROOT_PATH . '/public/pictures/assurance/';
                    if (is_dir($logoDir)) {
                        $logoFiles = array_diff(scandir($logoDir), ['.', '..']);
                        sort($logoFiles);
                        foreach ($logoFiles as $file) {
                            echo '<option value="' . htmlspecialchars($file) . '">' . htmlspecialchars($file) . '</option>';
                        }
                    }
                    ?>
                </select>
                <p class="mt-1 text-xs text-gray-500">Fichiers dans public/pictures/assurance/</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="add_active" id="add_active" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="add_active" class="text-sm font-medium text-gray-900 dark:text-white">Actif</label>
            </div>
            <button type="submit" name="add_assurance" class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Ajouter</button>
        </form>
    </div>
</div>

<!-- ============================== -->
<!-- Modal : Modifier une assurance -->
<!-- ============================== -->
<div id="modal-edit-assurance" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifier la compagnie</h3>
            <button onclick="document.getElementById('modal-edit-assurance').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_assurances" class="p-4 space-y-4">
            <input type="hidden" name="edit_id" id="edit_assurance_id">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom de la compagnie *</label>
                <input type="text" name="edit_nom" id="edit_assurance_nom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Fichier logo</label>
                <select name="edit_logo" id="edit_assurance_logo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">-- Aucun logo --</option>
                    <?php
                    if (is_dir($logoDir)) {
                        foreach ($logoFiles as $file) {
                            echo '<option value="' . htmlspecialchars($file) . '">' . htmlspecialchars($file) . '</option>';
                        }
                    }
                    ?>
                </select>
                <div id="edit_logo_preview" class="mt-2 hidden">
                    <img id="edit_logo_img" src="" alt="Aperçu" class="h-10 w-auto max-w-[120px] object-contain rounded border">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="edit_active" id="edit_assurance_active" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="edit_assurance_active" class="text-sm font-medium text-gray-900 dark:text-white">Actif</label>
            </div>
            <button type="submit" name="edit_assurance" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">Enregistrer les modifications</button>
        </form>
    </div>
</div>

<script>
function openEditAssurance(a) {
    document.getElementById('edit_assurance_id').value = a.assurance_id;
    document.getElementById('edit_assurance_nom').value = a.nom;
    // Set logo select
    const logoSelect = document.getElementById('edit_assurance_logo');
    logoSelect.value = a.logo || '';
    // Logo preview
    const preview = document.getElementById('edit_logo_preview');
    const img = document.getElementById('edit_logo_img');
    if (a.logo) {
        img.src = 'public/pictures/assurance/' + a.logo;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
    // Active checkbox
    document.getElementById('edit_assurance_active').checked = (a.active == 1);
    document.getElementById('modal-edit-assurance').classList.remove('hidden');
}

// Update logo preview when select changes
document.getElementById('edit_assurance_logo').addEventListener('change', function() {
    const preview = document.getElementById('edit_logo_preview');
    const img = document.getElementById('edit_logo_img');
    if (this.value) {
        img.src = 'public/pictures/assurance/' + this.value;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
});
</script>
