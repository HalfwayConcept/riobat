    <footer class="text-xs/[13px] md:text-xs p-8 dark:bg-gray-900 dark:text-gray-400">
        <p class="text-gray-600 dark:text-gray-400">Cabinet Cotton Alexandre — entrepreneur individuel et intermédiaire en assurance immatriculé à l’ORIAS sous le numéro 18 002 947.</p>
        <nav class="mt-4 flex flex-wrap gap-4 text-sm">
            <a href="#mentions-legales" class="text-blue-700 hover:underline dark:text-blue-400">Mentions légales</a>
            <a href="#politique-confidentialite" class="text-blue-700 hover:underline dark:text-blue-400">Politique de confidentialité</a>
        </nav>

    </footer>
    <?php require __DIR__ . '/templates/home/legal/site-legal-info.view.php'; ?>

    <!-- Font size resizer widget -->
    <div class="font-resizer" role="region" aria-label="Contrôles taille du texte">
        <button id="font-decrease" aria-label="Réduire la taille du texte">A-</button>
        <button id="font-reset" aria-label="Taille normale"><span class="label">A</span></button>
        <button id="font-increase" aria-label="Augmenter la taille du texte">A+</button>
    </div>

    <!-- Bouton flottant ticket (bug / amélioration) -->
    <?php if (!empty($_SESSION['user_id']) || (defined('APP_ENV') && APP_ENV === 'dev')): ?>
    <button id="ticket-open-btn" onclick="openTicketModal()" class="ticket-fab" aria-label="Signaler un bug ou une amélioration" title="Signaler un bug ou une amélioration">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </button>
    <?php require_once ROOT_PATH . '/views/components/ticket-modal.view.php'; ?>
    <?php endif; ?>

    <!-- Laisser ce script juste avant la balise fermante body ! -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="public/script/ticket.js"></script>

</body>
</html>