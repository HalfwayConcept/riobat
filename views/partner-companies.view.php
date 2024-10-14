
<?php
    // Titre personnalisé
    $title = "Partenaires";
    
    // Remplissage de la variable $content
    ob_start();
    ?>
    
    
<div class="flex flex-wrap">
    <img src="public/pictures/aig.jpg" alt="aig" class="m-6 w-[120px]"/>
    <img src="public/pictures/albingia.jpg" alt="albingia" class="m-6 w-[120px]"/>
    <img src="public/pictures/alptis.jpg" alt="alptis" class="m-6 w-[120px]"/>
    <img src="public/pictures/apicil.png" alt="apicil" class="m-6 w-[120px]"/>
    <img src="public/pictures/april.png" alt="april" class="m-6 w-[120px]"/>
    <img src="public/pictures/auxiliaire.png" alt="auxiliaire" class="m-6 w-[120px]"/>
    <img src="public/pictures/axre.png" alt="axre" class="m-6 w-[120px]"/>
    <img src="public/pictures/groupama.png" alt="groupama" class="m-6 w-[120px]"/>
    <img src="public/pictures/chubb.jpg" alt="chubb" class="m-6 w-[120px]"/>
    <img src="public/pictures/generali.jpg" alt="generali" class="m-6 w-[120px]"/>
    <img src="public/pictures/klarity.png" alt="klarity" class="m-6 w-[120px]"/>
    <img src="public/pictures/europ-assistance.png" alt="europ-assistance" class="m-6 w-[120px]"/>
    <img src="public/pictures/ergo.png" alt="ergo" class="m-6 w-[120px]"/>
    <img src="public/pictures/entoria.jpg" alt="entoria" class="m-6 w-[120px]"/>
    <img src="public/pictures/metlife.jpg" alt="helvetia-metlife" class="m-6 w-[120px]"/>
    <img src="public/pictures/zephir.jpg" alt="groupe-zephir" class="m-6 w-[120px]"/>
    <img src="public/pictures/netvox.jpg" alt="netvox" class="m-6 w-[120px]"/>
    <img src="public/pictures/qbe.jpg" alt="qbe" class="m-6 w-[120px]"/>
    <img src="public/pictures/tetris.png" alt="tetris" class="m-6 w-[120px]"/>
</div>


<?php
    $content = ob_get_clean();
    require("base.view.php");
    ?>