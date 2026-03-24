<?php
    require 'header.view.php';
    require 'stepper.view.php';
?>

<section class="bg-slate-100 dark:bg-gray-800 lg:w-[780px] xl:w-[1050px] m-auto p-4 p-4 border-l-4">
    <!-- Récupération du contenu de la page à afficher -->
    <?= $content ?>
</section>

<?php
    if (!isset($_GET['run_tests'])) {
        require 'footer.view.php';
    }
?>