<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8">
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <h1 class="text-center font-bold text-3xl mt-8 mb-10 text-gray-900 dark:text-white">
            <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Administration
        </h1>

        <!-- Lien retour tableau de bord -->
        <div class="mb-8">
            <a href="index.php?page=admin" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour au tableau de bord DO
            </a>
        </div>

        <?php if(!empty($settings_message)): ?>
            <?= $settings_message; ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- ============================================ -->
            <!-- PARAMETRAGES -->
            <!-- ============================================ -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        Paramétrages
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="index.php?page=admin_emails" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-blue-50 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300">Gérer les emails</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Templates, signature, expéditeur, reply-to</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="index.php?page=admin_users" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-blue-50 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300">Utilisateurs</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Comptes, rôles, mots de passe</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="index.php?page=admin_assurances" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-blue-50 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300">Compagnies d'assurance</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Ajouter, modifier, activer/désactiver</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="index.php?page=admin_tickets" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-blue-50 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300">Tickets</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Bugs, améliorations signalés par les utilisateurs</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gray-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>
                        Gestion BDD
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <form method="post" action="index.php?page=admin_settings" onsubmit="return confirm('⚠️ ATTENTION : Cela va supprimer TOUTES les données des tables DO (souscripteur, dommage_ouvrage, situation, etc.) de manière irréversible.\n\nConfirmer le nettoyage ?');">
                        <button type="submit" name="truncate_form_tables" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-red-50 dark:bg-gray-700 dark:hover:bg-red-900/20 transition-colors group text-left">
                            <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/40 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white group-hover:text-red-700 dark:group-hover:text-red-300">Vider toutes les tables DO</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Suppression irréversible de toutes les DO</p>
                            </div>
                        </button>
                    </form>

                    <a href="index.php?page=logs" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200">Logs SQL</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Historique des échanges BDD</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- TESTS APPLICATIFS -->
            <!-- ============================================ -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-orange-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Tests applicatifs
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <form method="post" action="index.php?page=admin_settings" onsubmit="return confirm('Supprimer toutes les DO créées par le test runner (is_test = 1) ?');">
                        <button type="submit" name="delete_test_dos" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-orange-50 dark:bg-gray-700 dark:hover:bg-orange-900/20 transition-colors group text-left">
                            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 dark:bg-orange-900/40 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white group-hover:text-orange-700 dark:group-hover:text-orange-300">Vider toutes les DO Tests</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Supprime les DO marquées is_test = 1</p>
                            </div>
                        </button>
                    </form>

                    <a href="index.php?page=admin&run_tests=1" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-50 hover:bg-orange-50 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors group">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-300">Tests automatiques DO</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Lancer les tests de non-régression</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
