<!-- CGU, RGPD et checkbox -->
<div class="bg-white my-16">
    <div class="py-8 text-center lg:py-16">

        <!-- Champ texte CGU -->
        <h1 class="mb-4 text-xl lg:text-2xl font-extrabold tracking-tight leading-none text-gray-800 dark:text-white">Dommage Ouvrage</h1>
        <textarea id="cgu" class="p-2 w-[500px] h-[400px] lg:w-[700px] mb-8 font-normal text-xs sm:text-sm lg:text-lg text-gray-500 sm:px-4 lg:px-16 dark:text-gray-400">
            Ce contrat est commercialisé par la société Cabinet Cotton Alexandre, courtier/agent d'assurance -  immatriculé  à  l'Orias  (Registre  unique  des  intermédiaires  en  assurance)  sous  le  numéro  18002947 (www.orias.fr) et au RCS de Mende n° 840 357 743.  
            Le siège social de la société Cabinet Cotton Alexandre est situé au 5, rue Boulevard du Soubeyran 48000 MENDE. La forme juridique de la société Cabinet Cotton Alexandre est une EIRL. 

            La société Cabinet Cotton Alexandre ne détient aucune participation directe ou indirecte d'une compagnie d'assurance. Aucune compagnie d'assurance ne détient de participation directe ou indirecte dans la société Cabinet Cotton Alexandre. 
            La société Cabinet Cotton Alexandre  exerce son activité de courtage d'assurance conformément à l'article L.520-1, II, 1°, b du code des assurances.  
            Le nom des entreprises d'assurance avec lesquelles la société Cabinet Cotton Alexandre travaille en qualité de courtier, sont : 
            GROUPAMA, GENERALI, L'AUXILIAIRE, QBE, HELVETIA METLIFE, EUROP ASSISTANCE, GROUPE ZEPHIR, NETVOX, APRIL, AIG, ALBINGIA, TETRIS, AXRE, ENTORIA, ALPTIS, KLARITY, ERGO, APICIL, CHUBB.                            
            En cas de difficulté dans l'application du contrat d'assurance, vous pouvez adresser votre réclamation par courrier à Cabinet Cotton Alexandre à l'adresse du siège social ou par email cabinetcotton@outlook.fr : Vous recevrez un accusé de réception au maximum sous 10  jours et une réponse dans un délai maximum de 2 mois. En cas d'échec de votre réclamation, vous pouvez vous adresser au Médiateur de l'Assurance soit par courrier à La Médiation de l'Assurance, TSA 50110 75441 Paris Cedex 09, ou par mail : le.mediateur@mediation-assurance.org 
            La société SARL Cabinet Cotton Alexandre est soumise au contrôle de l'Autorité de Contrôle Prudentiel et de Résolution (ACPR) - 4 place de Budapest - CS 92459, 75436 PARIS Cedex 09.
        </textarea>
            
        <!-- Champ texte RGPD -->
        <h1 class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-800 lg:text-2xl dark:text-white">Mentions légales RGPD</h1>
        <textarea id="rgpd" class="p-2 w-[500px] h-[400px] lg:w-[700px] mb-8 font-normal text-xs sm:text-sm lg:text-lg text-gray-500 sm:px-4 lg:px-16 dark:text-gray-400">
           <?= RGPD_TEXT ?>
        </textarea>

        <!-- Bouton démarrer -->     
        <form action="" method="post">
            <input type="hidden" name="fields" value="debut">
            <!-- Checkbox "Lu et approuvé" -->
            <div class="flex flex-col justify-center mb-4">
                <div>
                    <input id="checkbox-approuve" name="checkbox-approuve" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-400 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" onclick="buttonActivate('start-button', 'checkbox-approuve')">
                    <label for="checkbox-approuve" class="text-base font-medium text-black dark:text-gray-300">&nbsp;Lu et approuvé.</label>
                </div>
                <span class="text-xs mt-2">( veuillez cocher la case pour continuer )</span>
            </div><br />                                                 
            <div  class="flex space-y-4 justify-center sm:space-y-0">
                <button type="submit" id="start-button" name="page_next" value="step1"  class="hidden inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Commencer
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </button>
            </div>
        </form>

    </div>
</div>