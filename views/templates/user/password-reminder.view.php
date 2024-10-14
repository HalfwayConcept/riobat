<section class="bg-white dark:bg-gray-900">
    <div class="py-8 mt-12 text-center lg:py-16">
        <div class="flex flex-col justify-center mb-4">
            <section class="bg-white dark:bg-gray-900">
                <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
                    <p class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                        Rappel de mot de passe    
                    </p>
                    <div class="w-full bg-white rounded-lg shadow-xl dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h2 class="text-sm font-bold leading-tight tracking-tight text-gray-900 dark:text-white">
                                Veuillez indiquer l'email
                            </h2>
                            <form method="POST" class="space-y-4 md:space-y-6" action="index.php?page=passwordReminder">
                                <div>
                                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                                </div>
                                
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Renvoyer</button>
                            </form>
                            <?php
                            if(!empty($erreur)){
                                ?>
                                    <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                                        <span class="font-medium">Erreur : </span> <?= $erreur;?>
                                    </div>
                                <?php
                            }?>

                        </div>
                    </div>                
                </div>
            </section>           
        </div><br />
    </div>
</section>