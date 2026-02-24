<section class="dark:bg-gray-900 p-3 sm:p-5 mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">
    <div class="flex justify-end mb-4 gap-4">
        <a href="index.php?page=admin&run_tests=1" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tests automatiques DO</a>
        <form method="post" action="index.php?page=admin" onsubmit="return confirm('Confirmer le nettoyage de toutes les tables du formulaire ? Cette action est irréversible.');">
            <button type="submit" name="truncate_form_tables" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Vider toutes les tables DO</button>
        </form>
    </div>
<p class="text-center font-medium text-2xl mt-16">Liste des Dommages Ouvrages</p>
    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <?php if(isset($infodelete)){ echo "<span>".$infodelete."</span>"; }; ?>
    </div>

    <div class="mx-auto my-12 max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <?php include 'views/admin/filter.view.php'; ?>
            <div class="overflow-x-auto">
                <table class="bg-slate-50 w-full text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Demande DO n°</th>
                            <th scope="col" class="px-4 py-3">Date de création</th>
                            <th scope="col" class="px-4 py-3">Souscripteur</th>
                            <th scope="col" class="px-4 py-3">Adresse de la construction</th>
                            <th scope="col" class="px-4 py-3">Coût en €</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($dos as $do){
                            ?>
                            <tr class="bg-sky-200 border-b text-black dark:border-gray-700">
                                <th scope="row" class="px-4 py-3 font-medium  whitespace-nowrap dark:text-white">
                                    <?php echo $do['DOID']; ?>
                                </th>
                                <td class="px-4 py-3 text-center"><?php echo $do['date_creation']; ?></td>
                                <td class="px-4 py-3 text-center"><?php echo $do['souscripteur_nom_raison']; ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col text-center">
                                        <?php echo "<span>".$do['construction_adresse']."</span>"; ?>
                                        <?php echo "<span>".$do['construction_adresse_code_postal']."&nbsp;". $do['construction_adresse_commune'] ."</span>"; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center"><?php echo $do['construction_cout_operation']; ?></td>
                                <td class="px-4 py-3 flex justify-center">
                                    <div class="flex flex-row py-1 text-sm dark:text-gray-200">
                                        <a href="index.php?page=rcd&doid=<?php echo $do['DOID']; ?>" class="block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"><img src="public/pictures/briefcase-upload.svg" alt="see-pic" width="20px"/></a>
                                        <a href="index.php?page=fiche&doid=<?php echo $do['DOID']; ?>" class="block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"><img src="public/pictures/eye-solid.svg" alt="see-pic" width="20px"/></a>
                                        <a href="index.php?page=step1&session_load_id=<?php echo $do['DOID']; ?>" class="block py-2 px-1 hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"><img src="public/pictures/file-pen-solid.svg" alt="edit-pic" width="20px"/></a>
                                        <a href="index.php?page=admin&deletedo=<?php echo $do['DOID']; ?>" class="block py-2 px-1 text-sm text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"><img src="public/pictures/trash-solid.svg" alt="trash-pic" width="16px"/></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                    </tbody>
                </table>
            </div>
    <fieldset class="flex border-2 border-gray-400 p-4 m-6">
        <legend>Statut</legend>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-blue-600 rounded-full me-1.5 flex-shrink-0"></span> A traiter</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-green-500 rounded-full me-1.5 flex-shrink-0"></span>Validé</span>
        <span class="flex items-center text-sm font-medium text-gray-900 dark:text-white me-3"><span class="flex w-2.5 h-2.5 bg-red-500 rounded-full me-1.5 flex-shrink-0"></span>  Refusé</span>
    </fieldset>                
            <!-- <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                </span>
                <ul class="inline-flex items-stretch -space-x-px">
                    <li>
                        <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav> -->
        </div>
    </div>
</section>