<!-- CGU, RGPD et checkbox -->
<div class="bg-white my-16">
    <div class="py-8 text-center lg:py-16">

        <div>
            <h1 class="text-xl lg:text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Création de compte
            </h1>         
            
            <?php
            if($message){?>
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium"><?= $message?></span> 
                </div>
            <?php    
            }
            
            ?>
        </div> 

        <!-- Bouton démarrer -->     
        <form action="index.php?page=register" method="POST">

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= (!empty($_POST['nom'])? $_POST['nom'] : "");?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ludivine" required />
                </div>
                <div>
                    <label for="prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?= (!empty($_POST['prenom'])? $_POST['prenom'] : "");?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="MARTIN" required />
                </div>
            </div>
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse email</label>
                <input type="email" id="email" name="email" value="<?= (!empty($_POST['email'])? $_POST['email'] : "");?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ludivine.martin@email.fr" required />
            </div> 
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe (au moins 8 caractères)</label>
                <input type="password" id="password"  name="password" minlength="8" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required />
            </div> 
            <div class="mb-6">
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmer mot de passe</label>
                <input type="password" id="confirm_password" minlength="8" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required />
            </div> 
         
            
            <!-- Champ texte RGPD -->
            <h1 class="mb-6 text-xl font-extrabold tracking-tight leading-none text-gray-800 lg:text-2xl dark:text-white">Mentions légales RGPD</h1>
            <textarea id="rgpd" class="p-2 h-[200px] md:w-[410px] lg:w-[730px] xl:w-[1000px] m-auto p-4  mb-8 font-normal text-xs sm:text-sm lg:text-lg text-gray-500 sm:px-4 lg:px-16 dark:text-gray-400">
                <?= RGPD_TEXT;?>
            </textarea>
            <!-- Checkbox "Lu et approuvé" -->
            <div class="flex justify-center mb-6">
                    <div class="flex  ">
                    <input id="checkbox-approuve" onclick="buttonActivate('start-button', 'checkbox-approuve');buttonActivate('restart-button', 'checkbox-approuve');"  type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required />
                    </div>
                    <label for="checkbox-approuve" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Je suis d'accord avec le <a href="#" class="text-blue-600 hover:underline dark:text-blue-500">conditions générales</a>.
                    <br/><span class="text-xs mt-2">( veuillez cocher la case pour continuer )</span>
                    </label>
                </div>     
            <div>                                                           
            <div  class="flex space-y-4 justify-center sm:space-y-0">
                <button type="submit" id="start-button" name="page" value="step1"  class="hidden flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    
                    <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6.072 10.072 2 2 6-4m3.586 4.314.9-.9a2 2 0 0 0 0-2.828l-.9-.9a2 2 0 0 1-.586-1.414V5.072a2 2 0 0 0-2-2H13.8a2 2 0 0 1-1.414-.586l-.9-.9a2 2 0 0 0-2.828 0l-.9.9a2 2 0 0 1-1.414.586H5.072a2 2 0 0 0-2 2v1.272a2 2 0 0 1-.586 1.414l-.9.9a2 2 0 0 0 0 2.828l.9.9a2 2 0 0 1 .586 1.414v1.272a2 2 0 0 0 2 2h1.272a2 2 0 0 1 1.414.586l.9.9a2 2 0 0 0 2.828 0l.9-.9a2 2 0 0 1 1.414-.586h1.272a2 2 0 0 0 2-2V13.8a2 2 0 0 1 .586-1.414Z"/>
                    </svg> Créer mon compte&nbsp;&nbsp;         
                </button>
                <!-- button type="submit" id="restart-button" name="page" value="stepTest"  class="hidden  justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                    Reprendre&nbsp;&nbsp;
                    <svg class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
                    </svg>   
                </button -->                
            </div>
        </form>
        <div  class="flex space-y-4 justify-center sm:space-y-0">
            <br/>
                <a href="index.php?page=login" class="flex text-blue-600 hover:underline dark:text-blue-500">
                <svg class="w-6 h-6 text-dark-blue" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    
                </svg> Vous avez déjà un compte</a>.
        </div>
    </div>
</div>