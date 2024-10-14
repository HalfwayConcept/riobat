<section class="dark:bg-gray-900 p-3 sm:p-5">
<p class="text-center font-medium text-2xl mt-16">Bienvenue sur votre tableau de bord</p>
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <?php if(isset($infodelete)){ echo "<span>".$infodelete."</span>"; }; ?>
    </div>
    <section class="bg-white dark:bg-gray-900">
    <div class="px-4">
        Bienvenue
    </div>
    <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:px-6">
        <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
            <h2 class="mb-4 text-xl tracking-tight font-extrabold text-gray-900 dark:text-white">Votre dashboard</h2>
            <p class="mb-4 text-sm ">
                <ul class="max-w-md text-sm space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                    <li>Consuler vos dossier de dommages ouvrage</li>
                </ul>
            </div>
        <div class="grid">
            <img class="w-full rounded-lg" src="public/pictures/home_picture_1.jpg" alt="office content 1">
        </div>
    </div>
</section>    
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white flex flex-row flex-wrap dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            
                <?php
                echo "<pre>";
                    //var_dump($dos);
                echo "</pre>";
                foreach($dos as $key => $do){
                    $doprogress = "0.5";
                    ?>
                    <div class="max-w-sm p-6 w-72 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 font-2xl font-bold tracking-tight text-gray-900 dark:text-white">Dommage Ouvrage
                            <button data-popover-target="popover-<?= $do['DOID']?>" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">#<?php echo $do['DOID']; ?></button>

                            <div data-popover id="popover-<?= $do['DOID']?>" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Session_id</h3>
                                </div>
                                <div class="px-3 py-2">
                                    <p><?= $doprogress;?></p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                    
                        </h5>
                        <h5 class="mb-2 font-xl font-bold tracking-tight text-gray-900 dark:text-white">Débuté le: </h5>
                        
                        <?php if (1 == 1){
                           
                        ?>
                            <h5 class="mb-2 font-xl font-bold tracking-tight text-gray-900 dark:text-white">Terminé le: </h5>
                        <?php
                        }else{
                        ?>
                            <h5 class="mb-2 font-xl font-bold tracking-tight text-gray-900 dark:text-white">Dernière MAJ: </h5>
                        <?php
                        }
                        ?>
                        <h5 class="mb-2 font-xl font-bold tracking-tight text-gray-900 dark:text-white">Nombre d'étape :</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"> ??/5</p>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="bg-<?= ( $doprogress == 1 ? "green" : "blue");?>-600 h-6 rounded-full" style="width: <?= $doprogress*100;?>%">
                                <p class="text-center w-full text-white font-medium"><?= $doprogress*100;?>%</p>
                            </div>
                        </div>
                        
                        <br/>
                        
                            <?php 
                            if ($doprogress== 1){
                            ?>
                            <a href="index.php?page=result&session_id=<?= $do['DOID'];?>" class="inline-flex items-center px-1 py-2 text-sm text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Rapport&nbsp;&nbsp;
                                <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                                </svg>

                            </a>
                            <?php
                            }else{
                            ?>
                            <a href="index.php?page=dc&session_id=<?= $do['DOID'];?>" class="inline-flex items-center px-1 py-2 text-sm text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Reprendre
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                            <?php
                            }
                            ?>
                            


                            </a>                            

                            <!-- button data-modal-target="popup-modal<?= $do['DOID'];?>" data-modal-toggle="popup-modal<?= $do['DOID'];?>" class="block felx text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                    Supprimer&nbsp;&nbsp;
                                    <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                    </svg>
                            </button>

                            <div id="popup-modal<?= $do['DOID'];?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Fermer</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                                            <a href="index.php?page=dashboard&session_id=<?= $do['DOID'];?>" class="inline-flex items-center px-1 py-2 text-sm text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <button data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                               Je suis sûr !
                                            </button>
                                            </a>
                                            <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div -->
                        
                    </div>
                <?php
                }
                ?>             
                <div class="max-w-sm p-6 w-72 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <br/>
                    <a href="index.php?page=dc&session_id=new" class="inline-flex w-full items-center px-1 py-2 text-sm text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Débuter un nouveau test
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
        </div>
    </div>
</section>