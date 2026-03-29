    <footer class="text-xs/[13px] md:text-xs p-8 dark:bg-gray-900 dark:text-gray-400">
        <p class="text-gray-600 dark:text-gray-400">SIRET N° 840 357 743 -RCS MENDE - N° ORIAS 18002947- www.orias.fr en qualité d'agent général/courtier d'assurances - travaille avec un nombre restreint de fournisseurs, la liste peut être transmise sur simple demande. Le cabinet est rémunéré par le fournisseur choisi sous forme de commissions en pourcentage de la prime payée. Le cabinet a souscrit une garantie financière et responsabilité civile conformément aux codes des assurances. Il est également soumis au contrôle ACPR - 4 Place de Budapest CS 92459 - 75436 PARIS CEDEX 09 - En cas de réclamation, vous pouvez envoyer un courrier à l'adresse du cabinet ou un mail à l'adresse cabinetcotton@outlook.fr. Si toutefois, un différend persiste, vous pouvez saisir le médiateur de l'assurance par courrier : TSA 50110 - 75441 PARIS Cedex 09.
        </p>

    </footer>

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