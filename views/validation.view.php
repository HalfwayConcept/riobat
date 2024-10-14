<h2 class="text-center font-medium mt-16"></h2>



<div class="flex flex-row justify-center mt-8">
    <!-- Bouton précédent -->                                          
    <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
        <a href="index.php?page=step5" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Précédent
        </a>
    </div>
    <!-- Bouton valider -->
    <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
        <a href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Valider
        </a>
    </div>
</div>


<?php if(DEBUG==true):
    echo "<div class='mt-24'>
    <p class='font-medium mb-6'>Récapitulatif des champs soumis :</p>
    <pre class='ml-12'>";
    print_r($_SESSION);
    echo "</pre></div>";
endif;?> 


<?php
        // if(DEBUG == true){
        //     echo "<pre>";
        //     var_dump($_SESSION);
        //     echo "</pre>";
?>

   
