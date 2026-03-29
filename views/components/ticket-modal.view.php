<!-- Modal ticket : déclaration bug / amélioration -->
<div id="ticket-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="ticket-modal-title">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h3 id="ticket-modal-title" class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                Déclarer un bug ou une amélioration
            </h3>
            <button type="button" onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" aria-label="Fermer">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Form -->
        <form id="ticket-form" enctype="multipart/form-data" class="p-4 space-y-4">
            <input type="hidden" name="url_page" id="ticket-url-page" value="">

            <!-- Descriptif -->
            <div>
                <label for="ticket-descriptif" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                    Description du problème ou de l'amélioration souhaitée <span class="text-red-500">*</span>
                </label>
                <textarea id="ticket-descriptif" name="descriptif" rows="5" required minlength="10"
                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Décrivez le bug rencontré ou l'amélioration que vous souhaitez..."></textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 10 caractères</p>
            </div>

            <!-- Fichier joint -->
            <div>
                <label for="ticket-fichier" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                    Pièce jointe (capture d'écran, PDF...)
                </label>
                <input type="file" id="ticket-fichier" name="fichier" accept="image/png,image/jpeg,image/gif,image/webp,application/pdf"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF, WEBP ou PDF — 5 Mo max</p>
            </div>

            <!-- URL (lecture seule) -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Page concernée</label>
                <p id="ticket-url-display" class="text-xs text-gray-400 dark:text-gray-500 break-all"></p>
            </div>

            <!-- Messages -->
            <div id="ticket-message" class="hidden"></div>

            <!-- Boutons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeTicketModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                    Annuler
                </button>
                <button type="submit" id="ticket-submit-btn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    Envoyer le ticket
                </button>
            </div>
        </form>
    </div>
</div>
