<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <h1 class="text-center font-bold text-3xl mt-8 mb-10 text-gray-900 dark:text-white">
            <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Gestion des emails
        </h1>

        <div class="mb-8 flex items-center justify-between">
            <a href="index.php?page=admin_settings" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour à l'administration
            </a>
        </div>

        <?php if(!empty($email_message)): ?>
            <?= $email_message; ?>
        <?php endif; ?>

        <!-- ============================================================ -->
        <!-- PARAMETRAGE EMAIL (Signature, Reply-to, From) -->
        <!-- ============================================================ -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 mb-8">
            <div class="bg-indigo-600 px-6 py-4 rounded-t-lg">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Paramètres d'envoi
                </h2>
            </div>
            <form method="post" action="index.php?page=admin_emails" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom de l'expéditeur (From Name)</label>
                        <input type="text" name="from_name" value="<?= htmlspecialchars($emailSettings['from_name'] ?? ''); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Cabinet Cotton Alexandre">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email expéditeur (From Email)</label>
                        <input type="email" name="from_email" value="<?= htmlspecialchars($emailSettings['from_email'] ?? ''); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="contact@riobat.fr">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Email de réponse (Reply-To)</label>
                        <input type="email" name="reply_to" value="<?= htmlspecialchars($emailSettings['reply_to'] ?? ''); ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="cabinetcotton@outlook.fr">
                        <p class="mt-1 text-xs text-gray-500">Adresse où les destinataires répondront</p>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Signature email (HTML)</label>
                    <textarea name="signature" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono text-xs"><?= htmlspecialchars($emailSettings['signature'] ?? ''); ?></textarea>
                    <p class="mt-1 text-xs text-gray-500">HTML autorisé. Cette signature sera ajoutée à la fin de chaque email envoyé.</p>
                </div>
                <?php if(!empty($emailSettings['signature'])): ?>
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Aperçu de la signature :</p>
                    <div class="text-sm text-gray-800 dark:text-gray-200"><?= $emailSettings['signature']; ?></div>
                </div>
                <?php endif; ?>
                <button type="submit" name="save_email_settings" class="inline-flex items-center gap-2 text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer les paramètres
                </button>
            </form>
        </div>

        <!-- ============================================================ -->
        <!-- TEMPLATES EMAIL -->
        <!-- ============================================================ -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <div class="bg-blue-600 px-6 py-4 rounded-t-lg flex items-center justify-between">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Templates de notification
                </h2>
                <button onclick="document.getElementById('modal-add-template').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Ajouter un template
                </button>
            </div>

            <div class="p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Variables disponibles dans le sujet et le corps :
                    <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{prenom}}</code>
                    <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{nom}}</code>
                    <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{email}}</code>
                    <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{do_id}}</code>
                    <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{souscripteur}}</code>
                    <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded text-xs">{{lien_rcd}}</code>
                </p>

                <?php if(empty($emailTemplates)): ?>
                    <p class="text-center text-gray-400 dark:text-gray-500 py-8">Aucun template email configuré.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach($emailTemplates as $tpl): ?>
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden <?= $tpl['active'] ? '' : 'opacity-50' ?>">
                            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-mono bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-0.5 rounded"><?= htmlspecialchars($tpl['slug']); ?></span>
                                    <h3 class="font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($tpl['nom']); ?></h3>
                                    <?php if($tpl['active']): ?>
                                        <span class="text-xs font-medium px-2 py-0.5 rounded bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Actif</span>
                                    <?php else: ?>
                                        <span class="text-xs font-medium px-2 py-0.5 rounded bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">Inactif</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button onclick='openEditTemplate(<?= htmlspecialchars(json_encode($tpl), ENT_QUOTES); ?>)' class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="Modifier">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button onclick="togglePreview(<?= $tpl['template_id']; ?>)" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" title="Aperçu">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <form method="post" action="index.php?page=admin_emails" onsubmit="return confirm('Supprimer ce template ?');" class="inline">
                                        <input type="hidden" name="delete_template_id" value="<?= (int)$tpl['template_id']; ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Supprimer">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-600">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">Sujet :</span> <?= htmlspecialchars($tpl['sujet']); ?>
                                </p>
                            </div>
                            <!-- Aperçu dépliable -->
                            <div id="preview-<?= $tpl['template_id']; ?>" class="hidden px-4 py-3 border-t border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Aperçu du corps :</p>
                                <div class="text-sm text-gray-800 dark:text-gray-200 p-3 bg-gray-50 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600">
                                    <?= $tpl['corps']; ?>
                                    <?php if(!empty($emailSettings['signature'])): ?>
                                        <hr class="my-3 border-gray-300 dark:border-gray-500">
                                        <?= $emailSettings['signature']; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    <?= count($emailTemplates); ?> template(s) configuré(s).
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ============================== -->
<!-- Modal : Ajouter un template -->
<!-- ============================== -->
<div id="modal-add-template" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ajouter un template</h3>
            <button onclick="document.getElementById('modal-add-template').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_emails" class="p-4 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Slug (identifiant unique) *</label>
                    <input type="text" name="add_slug" required pattern="[a-z0-9_]+" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono" placeholder="mon_template">
                    <p class="mt-1 text-xs text-gray-500">Lettres minuscules, chiffres et underscores uniquement</p>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom d'affichage *</label>
                    <input type="text" name="add_nom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Mon template email">
                </div>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Sujet de l'email *</label>
                <input type="text" name="add_sujet" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="[RIOBAT] Sujet du mail">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Corps de l'email (HTML)</label>
                <textarea name="add_corps" rows="8" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono text-xs" placeholder="<p>Bonjour {{prenom}} {{nom}},</p>"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="add_active" id="add_tpl_active" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="add_tpl_active" class="text-sm font-medium text-gray-900 dark:text-white">Actif</label>
            </div>
            <button type="submit" name="add_template" class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">Ajouter le template</button>
        </form>
    </div>
</div>

<!-- ============================== -->
<!-- Modal : Modifier un template -->
<!-- ============================== -->
<div id="modal-edit-template" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifier le template <span id="edit_tpl_slug_display" class="text-sm font-mono text-gray-500"></span></h3>
            <button onclick="document.getElementById('modal-edit-template').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="post" action="index.php?page=admin_emails" class="p-4 space-y-4">
            <input type="hidden" name="edit_id" id="edit_tpl_id">
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nom d'affichage *</label>
                <input type="text" name="edit_nom" id="edit_tpl_nom" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Sujet de l'email *</label>
                <input type="text" name="edit_sujet" id="edit_tpl_sujet" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Corps de l'email (HTML)</label>
                <textarea name="edit_corps" id="edit_tpl_corps" rows="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white font-mono text-xs"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="edit_active" id="edit_tpl_active" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="edit_tpl_active" class="text-sm font-medium text-gray-900 dark:text-white">Actif</label>
            </div>
            <button type="submit" name="edit_template" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">Enregistrer les modifications</button>
        </form>
    </div>
</div>

<script>
function openEditTemplate(tpl) {
    document.getElementById('edit_tpl_id').value = tpl.template_id;
    document.getElementById('edit_tpl_slug_display').textContent = '(' + tpl.slug + ')';
    document.getElementById('edit_tpl_nom').value = tpl.nom;
    document.getElementById('edit_tpl_sujet').value = tpl.sujet;
    document.getElementById('edit_tpl_corps').value = tpl.corps;
    document.getElementById('edit_tpl_active').checked = (tpl.active == 1);
    document.getElementById('modal-edit-template').classList.remove('hidden');
}

function togglePreview(id) {
    const el = document.getElementById('preview-' + id);
    el.classList.toggle('hidden');
}
</script>
