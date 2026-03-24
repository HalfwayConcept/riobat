



<div class="flex flex-row justify-center mt-8 no-print">
<?php if(!empty($isAdminFiche)): ?>
    <!-- Mode Admin : Retour tableau de bord + Imprimer -->
    <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
        <a href="index.php?page=admin" class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-40 px-5 py-2.5 text-center dark:bg-gray-500 dark:hover:bg-gray-600 dark:focus:ring-gray-700 inline-flex items-center justify-center gap-2">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Tableau de bord
        </a>
    </div>
    <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
        <button onclick="window.print()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-40 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center justify-center gap-2">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Imprimer
        </button>
    </div>
<?php else: ?>
    <!-- Mode Utilisateur : Précédent + Valider -->
    <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
        <a href="index.php?page=step5&doid=<?= (int)$DOID ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Précédent
        </a>
    </div>
    <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
        <a href="index.php?page=final_step&doid=<?= (int)$DOID ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Valider
        </a>
    </div>
<?php endif; ?>
</div>

   
