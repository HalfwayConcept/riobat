<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-2">
        <svg class="w-8 h-8 inline-block mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Foire aux questions
    </h1>
    <p class="text-center text-gray-500 dark:text-gray-400 mb-8">Retrouvez les réponses aux questions les plus fréquentes sur notre application.</p>

    <?php if (empty($faqs)): ?>
        <p class="text-center text-gray-400 dark:text-gray-500 py-12">Aucune question n'a encore été publiée.</p>
    <?php else: ?>
        <div id="faq-accordion" data-accordion="collapse" data-active-classes="bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
            <?php foreach ($faqs as $i => $faq): ?>
                <h2 id="faq-heading-<?= (int)$faq['faq_id'] ?>">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border <?= $i === 0 ? 'rounded-t-xl' : '' ?> <?= $i === count($faqs) - 1 && $i !== 0 ? '' : 'border-b-0' ?> border-gray-200 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-50 dark:hover:bg-gray-700 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 gap-3"
                        data-accordion-target="#faq-body-<?= (int)$faq['faq_id'] ?>"
                        aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"
                        aria-controls="faq-body-<?= (int)$faq['faq_id'] ?>">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01"/></svg>
                            <?= htmlspecialchars($faq['question']) ?>
                        </span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                        </svg>
                    </button>
                </h2>
                <div id="faq-body-<?= (int)$faq['faq_id'] ?>" class="<?= $i === 0 ? '' : 'hidden' ?>" aria-labelledby="faq-heading-<?= (int)$faq['faq_id'] ?>">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <div class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed faq-content">
                            <?= nl2br(htmlspecialchars($faq['reponse'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="mt-10 text-center">
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-3">Vous n'avez pas trouvé la réponse à votre question ?</p>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <button onclick="openTicketModal()" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                Envoyer un ticket
            </button>
        <?php else: ?>
            <a href="index.php?page=login" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                Connectez-vous pour nous contacter
            </a>
        <?php endif; ?>
    </div>
</div>
