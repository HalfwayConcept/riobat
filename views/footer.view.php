    <footer class="text-xs/[13px] px-8 py-8 md:text-xs md:px-16 md:py-16 xl:px-36">
        <p>SIRET N° 840 357 743 -RCS MENDE - N° ORIAS 18002947- www.orias.fr en qualité d'agent général/courtier d'assurances - travaille avec un nombre restreint de fournisseurs, la liste peut être transmise sur simple demande. Le cabinet est rémunéré par le fournisseur choisi sous forme de commissions en pourcentage de la prime payée. Le cabinet a souscrit une garantie financière et responsabilité civile conformément aux codes des assurances. Il est également soumis au contrôle ACPR - 4 Place de Budapest CS 92459 - 75436 PARIS CEDEX 09 - En cas de réclamation, vous pouvez envoyer un courrier à l'adresse du cabinet ou un mail à l'adresse cabinetcotton@outlook.fr. Si toutefois, un différend persiste, vous pouvez saisir le médiateur de l'assurance par courrier : TSA 50110 - 75441 PARIS Cedex 09.
        </p>

    </footer>

    <!-- Laisser ce script juste avant la balise fermante body ! -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    
    <?php

    if(DEBUG == true){
    
        ?>
            <div id="accordion-color" data-accordion="collapse" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
                <h2 id="accordion-color-heading-1">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-1" aria-expanded="true" aria-controls="accordion-color-body-1">
                    <span>SESSION</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                    </button>
                </h2>
                <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        <pre>
                        <?php var_dump($_SESSION); ?>
                        </pre>
                    </div>
                </div>
                <h2 id="accordion-color-heading-2">
                    <button type="button" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-color-body-2" aria-expanded="false" aria-controls="accordion-color-body-2">
                    <span>SQL</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                    </button>
                </h2>
                <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                    <pre>
                        <?php var_dump($_SESSION["SQL"]); ?>
                    </pre>
                    </div>
                </div>
            </div>


        <?php
    }
    ?>
</body>
</html>