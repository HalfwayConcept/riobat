    <section class="bg-white dark:bg-gray-900 mb-8 p-4 border-l-4 <?= ($do['type_demande'] ?? 'do') === 'pv' ? 'border-amber-500 bg-amber-50' : 'border-blue-500 bg-blue-50' ?>">
        <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
            <div class="max-w-screen-md">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Demande terminée</h2>
                <p class="mb-8 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    <?php if (($do['type_demande'] ?? 'do') === 'pv'): ?>
                        Votre demande photovoltaïque a été enregistrée auprès de nos services. Nous reviendrons bientôt vers vous pour la suite de son étude.
                    <?php else: ?>
                        Votre demande de Dommage ouvrage a été enregistrée auprès de nos services. Nous reviendrons bientôt vers vous pour traiter les attestations complémentaires.
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <?php require 'views/components/contact-info.view.php'; ?>
    </section>

    