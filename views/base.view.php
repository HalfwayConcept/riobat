<?php
    require 'header.view.php';
    require 'stepper.view.php';
    ?>

    <section class="bg-slate-100 w-[460px] lg:w-[780px] xl:w-[1050px] m-auto p-4 mt-2">
        <!-- Récupération du contenu de la page à afficher -->
        <?= $content ?>
    </section>

<?php
    require 'footer.view.php';
    ?>