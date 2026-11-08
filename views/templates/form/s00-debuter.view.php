<!-- Information sur l'intermédiation et la confidentialité -->
<?php
    $isPvTheme = (($_SESSION['type_demande'] ?? 'do') === 'pv');
    $accentBtn = $isPvTheme
        ? 'bg-amber-500 hover:bg-amber-600 focus:ring-amber-300 text-gray-900 dark:focus:ring-amber-900'
        : 'bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 text-white dark:focus:ring-blue-900';
    $accentCheck = $isPvTheme
        ? 'text-amber-600 focus:ring-amber-500 dark:focus:ring-amber-600'
        : 'text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600';
?>
<div class="bg-white my-16">
    <div class="py-8 text-center lg:py-16">

        <!-- Information et liens vers le site du cabinet -->
        <h1 class="mb-4 text-xl lg:text-2xl font-extrabold tracking-tight leading-none text-gray-800 dark:text-white"><?= $isPvTheme ? 'Photovoltaique' : 'Dommage Ouvrage' ?></h1>
        <p class="mb-8 text-sm text-gray-600 dark:text-gray-400">
            Consultez les <a href="https://cc-assur.fr/#mentions-legales" class="text-blue-700 hover:underline" target="_blank" rel="noopener noreferrer">mentions légales</a>
            et la <a href="https://cc-assur.fr/#politique-confidentialite" class="text-blue-700 hover:underline" target="_blank" rel="noopener noreferrer">politique de confidentialité</a>
            sur le site de CC Assur.
        </p>

        <!-- Bouton démarrer -->     
        <form action="" method="post">
            <input type="hidden" name="fields" value="debut">
            <!-- Accusé de prise de connaissance -->
            <div class="flex flex-col justify-center mb-4">
                <div>
                    <input id="checkbox-approuve" name="checkbox-approuve" type="checkbox" value="1" class="w-4 h-4 bg-gray-100 border-gray-400 rounded dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 <?= $accentCheck ?>" onclick="buttonActivate('start-button', 'checkbox-approuve')">
                    <label for="checkbox-approuve" class="text-base font-medium text-black dark:text-gray-300">&nbsp;J'ai pris connaissance des informations légales et de confidentialité.</label>
                </div>
                <span class="text-xs mt-2">( veuillez cocher la case pour continuer )</span>
            </div><br />                                                 
            <div  class="flex space-y-4 justify-center sm:space-y-0">
                <button type="submit" id="start-button" name="page_next" value="<?= $isPvTheme ? 'step1pv' : 'step1do' ?>"  class="hidden inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center rounded-lg focus:ring-4 <?= $accentBtn ?>">
                    Commencer
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </button>
            </div>
        </form>

    </div>
</div>