<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <h1 class="text-center font-bold text-3xl mt-8 mb-10 text-gray-900 dark:text-white">
            <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Gestion des utilisateurs
        </h1>

        <div class="mb-8 flex items-center justify-between">
            <a href="index.php?page=admin_settings" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'administration
            </a>
            <button onclick="document.getElementById('modal-add-user').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Ajouter un utilisateur
            </button>
        </div>

        <?php if(!empty($users_message)): ?>
            <?= $users_message; ?>
        <?php endif; ?>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3">Nom</th>
                            <th scope="col" class="px-4 py-3">Prénom</th>
                            <th scope="col" class="px-4 py-3">Email</th>
                            <th scope="col" class="px-4 py-3">Rôle</th>
                            <th scope="col" class="px-4 py-3">Date de création</th>
                            <th scope="col" class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr class="border-b dark:border-gray-700 <?= $u['role'] === 'admin' ? 'bg-amber-50 dark:bg-amber-900/10' : 'bg-white dark:bg-gray-800' ?>">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($u['ID']); ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($u['nom']); ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($u['prenom']); ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($u['email']); ?></td>
                            <td class="px-4 py-3">
                                <?php
                                $roleBadge = match($u['role']) {
                                    'admin'  => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300',
                                    'collab' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300',
                                    default  => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300',
                                };
                                ?>
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded <?= $roleBadge; ?>"><?= htmlspecialchars($u['role']); ?></span>
                            </td>
                            <td class="px-4 py-3"><?= htmlspecialchars($u['utilisateur_date_creation']); ?></td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditUser(<?= htmlspecialchars(json_encode($u), ENT_QUOTES); ?>)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Modifier">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="openResetPassword(<?= $u['ID']; ?>, '<?= htmlspecialchars($u['nom'] . ' ' . $u['prenom'], ENT_QUOTES); ?>')" class="text-orange-600 hover:text-orange-800 dark:text-orange-400" title="Réinitialiser mot de passe">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                    </button>
                                    <?php if($u['ID'] != $_SESSION['user_id']): ?>
                                    <form method="post" action="index.php?page=admin_users" onsubmit="return confirm('Supprimer cet utilisateur ?');" class="inline">
                                        <input type="hidden" name="delete_user_id" value="<?= $u['ID']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Supprimer">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ============================== -->
<!-- Modal : Ajouter un utilisateur -->
<!-- ============================== -->
<div id="modal-add-user" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ajouter un utilisateur</h3>
            <button onclick="document.getElementById('modal-add-user').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_users" class="p-4 space-y-4">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                <input type="text" name="add_nom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                <input type="text" name="add_prenom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="add_email" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                <input type="password" name="add_password" required minlength="6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Rôle</label>
                <select name="add_role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="user">User</option>
                    <option value="collab">Collab</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="add_user" class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Créer l'utilisateur</button>
        </form>
    </div>
</div>

<!-- ============================== -->
<!-- Modal : Modifier un utilisateur -->
<!-- ============================== -->
<div id="modal-edit-user" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifier l'utilisateur</h3>
            <button onclick="document.getElementById('modal-edit-user').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_users" class="p-4 space-y-4">
            <input type="hidden" name="edit_user_id" id="edit_user_id">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                <input type="text" name="edit_nom" id="edit_nom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                <input type="text" name="edit_prenom" id="edit_prenom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" name="edit_email" id="edit_email" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Rôle</label>
                <select name="edit_role" id="edit_role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="user">User</option>
                    <option value="collab">Collab</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="edit_user" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">Enregistrer les modifications</button>
        </form>
    </div>
</div>

<!-- ============================== -->
<!-- Modal : Réinitialiser mot de passe -->
<!-- ============================== -->
<div id="modal-reset-password" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Réinitialiser le mot de passe</h3>
            <button onclick="document.getElementById('modal-reset-password').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_users" class="p-4 space-y-4">
            <input type="hidden" name="reset_user_id" id="reset_user_id">
            <p class="text-sm text-gray-600 dark:text-gray-400">Nouveau mot de passe pour <strong id="reset_user_name"></strong> :</p>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nouveau mot de passe</label>
                <input type="password" name="reset_password" required minlength="6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Confirmer</label>
                <input type="password" name="reset_password_confirm" required minlength="6" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <button type="submit" name="reset_password_submit" class="w-full text-white bg-orange-600 hover:bg-orange-700 font-medium rounded-lg text-sm px-5 py-2.5">Réinitialiser</button>
        </form>
    </div>
</div>

<script>
function openEditUser(user) {
    document.getElementById('edit_user_id').value = user.ID;
    document.getElementById('edit_nom').value = user.nom;
    document.getElementById('edit_prenom').value = user.prenom;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_role').value = user.role;
    document.getElementById('modal-edit-user').classList.remove('hidden');
}

function openResetPassword(userId, userName) {
    document.getElementById('reset_user_id').value = userId;
    document.getElementById('reset_user_name').textContent = userName;
    document.getElementById('modal-reset-password').classList.remove('hidden');
}
</script>
