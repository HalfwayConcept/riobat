<section class="">
    <form action="" method="post">
        <!-- Formulaire caché : "Maitre d'ouvrage est-il le souscripteur ?"-->
        <div>
            <div class="flex flex-col lg:flex-row text-gray-500 font-medium">
                <span>Le Maitre d'Ouvrage est-il le souscripteur ? &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</span>
                <div class="ml-8">
                    <input type="radio" name="moa_souscripteur" value="1" <?= isset($_SESSION['info_moa']['moa_souscripteur']) && ($_SESSION['info_moa']['moa_souscripteur'])==1 ? "checked=checked" : ""; ?> onclick="hideElement('moa_form','moa')"/>
                    <label> Oui &ensp;</label>
                    <input type="radio" name="moa_souscripteur" value="0" <?= isset($_SESSION['info_moa']['moa_souscripteur']) && ($_SESSION['info_moa']['moa_souscripteur'])==0 ? "checked=checked" : ""; ?> onclick="showElement('moa_form','moa')"/>
                    <label> Non</label>
                </div>
            </div>  
            <div id="moa_form" class="<?= isset($_SESSION['info_moa']['moa_souscripteur']) && ($_SESSION['info_moa']['moa_souscripteur'])==0 ? "" : "hidden"; ?> px-8 py-4">
                <div class="mb-6 md:grid-cols-2">
                    <div class="flex flex-row py-4">
                        <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Civilité : &ensp;&ensp;
                        <input type="radio" name="moa_souscripteur_form_civilite" value="particulier" <?= isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && ($_SESSION['info_moa']['moa_souscripteur_form_civilite'])=="particulier" ? "checked=checked" : ""; ?> onclick="hideElement('siret_champ'),hideElement('raison_champ')">
                        <label>&ensp; Particulier &ensp;&ensp;</label>
                        <input type="radio" name="moa_souscripteur_form_civilite" value="entreprise" <?= isset($_SESSION['info_moa']['moa_souscripteur_form_civilite']) && ($_SESSION['info_moa']['moa_souscripteur_form_civilite'])=="entreprise" ? "checked=checked" : ""; ?> onclick="showElement('siret_champ'),showElement('raison_champ')">
                        <label>&ensp; Entreprise</label></span>
                    </div>
                    <div class="py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom, Prénom</label>
                        <input type="text" name="moa_souscripteur_form_nom_prenom" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_nom_prenom']) ? $_SESSION['info_moa']['moa_souscripteur_form_nom_prenom'] : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div class="py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse actuelle</label>
                        <input type="text" name="moa_souscripteur_form_adresse" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_adresse']) ? $_SESSION['info_moa']['moa_souscripteur_form_adresse'] : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div id="raison_champ" class="hidden py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison sociale</label>
                        <input type="text" name="moa_souscripteur_form_raison_sociale" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_raison_sociale']) ? $_SESSION['info_moa']['moa_souscripteur_form_raison_sociale'] : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                    <div id="siret_champ" class="hidden py-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SIRET n°</label>
                        <input type="text" name="moa_souscripteur_form_siret" value="<?= isset($_SESSION['info_moa']['moa_souscripteur_form_siret']) ? $_SESSION['info_moa']['moa_souscripteur_form_siret'] : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>
            </div>
        </div>


        <!-- Qualité du maitre d'ouvrage -->
        <div class="my-16">
            <h3 class="mb-2 text-gray-500 font-medium">Qualité du maitre d'ouvrage (choisissez l'option correspondante) :</h3>
            <div class="flex flex-col lg:flex-row mx-6 mb-2">
                <div class="flex flex-col ml-8">
                    <span><input type="radio" name="moa_qualite" value="etat" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="etat" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')" required/> Etat (services publics)</span>
                    <span><input type="radio" name="moa_qualite" value="hlm_public" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="hlm_public" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Organismes d'habitations à loyer modéré (secteur public)</span>
                    <span><input type="radio" name="moa_qualite" value="syndic" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="syndic" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Syndicats de copropriétaires</span>
                    <span><input type="radio" name="moa_qualite" value="vendeur_prive" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="vendeur_prive" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Vendeur privé après achèvement</span>
                    <span><input type="radio" name="moa_qualite" value="sci" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="sci" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Société Civile Immobilière</span>
                    <span><input type="radio" name="moa_qualite" value="entreprise" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="entreprise" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Entreprise</span>
                    <span><input type="radio" name="moa_qualite" value="moa_qualite_autre" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="moa_qualite_autre" ? "checked=checked" : ""; ?> onclick="showElement('moa_qualite_autre')"/> Autre qualité</span>
                    <div id="moa_qualite_autre" class="hidden mt-2">
                        <input type="text" name="moa_qualite_champ" value="<?= isset($_SESSION['info_moa']['moa_qualite_champ']) ? $_SESSION['info_moa']['moa_qualite_champ'] : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Veuillez préciser"/>
                    </div>    
                </div>
                <div class="flex flex-col ml-8">
                    <span><input type="radio" name="moa_qualite" value="collectivites" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="collectivites" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Collectivités locales</span>
                    <span><input type="radio" name="moa_qualite" value="hlm_prive" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="hlm_prive" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Organismes d'habitations à loyer modéré (secteur privé)</span>
                    <span><input type="radio" name="moa_qualite" value="vendeur_prive_imm" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="vendeur_prive_imm" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Vendeur privé d'immeubles à construire</span>
                    <span><input type="radio" name="moa_qualite" value="particulier" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="particulier" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Particulier</span>
                    <span><input type="radio" name="moa_qualite" value="prom_prive" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="prom_priv" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Promoteur privé immobilier</span>
                    <span><input type="radio" name="moa_qualite" value="asso" <?= isset($_SESSION['info_moa']['moa_qualite']) && ($_SESSION['info_moa']['moa_qualite'])=="asso" ? "checked=checked" : ""; ?> onclick="hideElement('moa_qualite_autre')"/> Association</span>
                </div>
            </div>
        </div>


        <!-- Formulaire caché : "Maitre d'ouvrage participe t-il à la construction ?"-->
        <div>
            <div class="flex flex-col lg:flex-row text-gray-500 font-medium">
                <span>Le Maitre d'Ouvrage participe à la construction ? &ensp;&ensp;</span>
                <div class="ml-8">
                    <input type="radio" name="moa_construction" value="1" <?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==1 ? "checked=checked" : ""; ?> onclick="showElement('moa_construction_form'),showElement('moa_construction_pro_tableau')" required/>
                    <label> Oui &ensp;</label>
                    <input type="radio" name="moa_construction" value="0" <?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('moa_construction_form'),hideElement('moa_construction_pro_tableau')"/>
                    <label> Non</label>
                </div>
            </div>
            <div id="moa_construction_form" class="<?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==1 ? "" : "hidden"; ?> py-4">
                <div class="flex flex-row p-2 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <p class="text-gray-900 text-sm block w-full p-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white">La clause contrat n°001 des Conventions Spéciales n°811 "Intervention du maître d'ouvrage dans la conception, la direction, la surveillance ou la réalisation des travaux" est obligatoirement souscrite.</p>
                </div>
                <div class="mb-6">
                    <div class="flex flex-row">
                        <span class="text-gray-500 font-medium">Le Maitre d'Ouvrage est-il un professionnel de la construction ? &ensp;&ensp; </span>
                        <div> <!-- Infobulle -->
                            <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button" class="mr-8"><svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only">Show information</span></button>
                            <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                <div class="p-3 space-y-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Conditions d'acceptation : </h3>
                                    <p>Si le maître d'ouvrage n'a pas la qualité de professionnel de la construction, seuls les travaux de papiers peints et/ou de peintures intérieures sont acceptés sans cotisation supplémentaire avec souscription de la CC 001. S'il intervient sur d'autres travaux, l'affaire doit être refusée.<br><br>Si le maître d'ouvrage a la qualité de professionnel de la construction, les travaux de papiers peints et/ou de peintures intérieures sont acceptés sans cotisation supplémentaire avec souscription de la CC 001. S'il intervient sur d'autres travaux, consulter votre interlocuteur société.</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="radio" name="moa_construction_pro" value="1" <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==1 ? "checked=checked" : ""; ?> onclick="showElement('moa_construction_pro_form')"/>
                            <label class="text-gray-500 font-medium"> Oui &ensp;</label>
                            <input type="radio" name="moa_construction_pro" value="0" <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==0 ? "checked=checked" : ""; ?> onclick="hideElement('moa_construction_pro_form')"/>
                            <label class="text-gray-500 font-medium"> Non</label>
                        </div>
                    </div>
                    <div id="moa_construction_pro_form" class="py-4 <?= isset($_SESSION['info_moa']['moa_construction_pro']) && ($_SESSION['info_moa']['moa_construction_pro'])==1 ? "" : "hidden"; ?> mx-6">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Veuillez indiquer sa profession :</label>
                        <input type="text" name="moa_construction_pro_champ" value="<?= isset($_SESSION['info_moa']['moa_construction_pro_champ']) ? $_SESSION['info_moa']['moa_construction_pro_champ'] : ''; ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                </div>
                <div id="moa_construction_pro_tableau" class="<?= isset($_SESSION['info_moa']['moa_construction']) && ($_SESSION['info_moa']['moa_construction'])==1 ? "" : "hidden"; ?> mt-10">
                    <span class="text-gray-500 font-medium">Complétez le tableau ci-dessous en cochant les cases correspondantes :</span>
                    <table class="text-sm font-light ml-6 mt-4">
                        <tr>
                            <td></td>
                            <td class="bg-gray-50 border-t-2 border-b-2 border-l-2 border-gray-300 p-2"></td>
                            <td class="bg-gray-50 border-t-2 border-b-2 border-gray-300 p-2">Nature des travaux</td>
                            <td class="bg-gray-50 border-t-2 border-b-2 border-r-2 border-gray-300 p-2"></td>
                        </tr>
                        <tr class="bg-gray-50 border-b-2 border-l-2 border-r-2 border-gray-300">
                            <td class="border-t-2 border-r-2 border-gray-300 text-center p-2">Activité ou mission exercée</td>
                            <td class="border-r-2 border-gray-300 text-center p-2">Papiers peints<br>et/ou Peintures intérieures</td>
                            <td class="border-r-2 border-gray-300 text-center p-2">Gros oeuvre fondations,<br>Charpente - Couverture, Etanchéité</td>
                            <td class="p-2">Autres travaux</td>
                            <td class="border-2 border-gray-300 text-center p-2">(autres travaux: précisez)</td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-l-2 border-b border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception'])==1 ? "checked=checked" : ""; ?> name="moa_conception"/>
                                <label>&ensp; Conception</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception_1'])==1 ? "checked=checked" : ""; ?> name="moa_conception_1"/></td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception_2'])==1 ? "checked=checked" : ""; ?> name="moa_conception_2"/></td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_conception_3'])==1 ? "checked=checked" : ""; ?> name="moa_conception_3"/></td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" name="moa_conception_4" value="<?= isset($_SESSION['info_moa']['moa_conception_4']) ? $_SESSION['info_moa']['moa_conception_4'] : ''?>"/></td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-b border-l-2 border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_direction'])==1 ? "checked=checked" : ""; ?> name="moa_direction"/>
                                <label>&ensp; Direction</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1"  <?= isset($_SESSION['info_moa']['moa_direction_1'])==1 ? "checked=checked" : ""; ?> name="moa_direction_1"/>

                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_direction_2'])==1 ? "checked=checked" : ""; ?> name="moa_direction_2"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_direction_3'])==1 ? "checked=checked" : ""; ?> name="moa_direction_3"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" value="<?= isset($_SESSION['info_moa']['moa_direction_4']) ? $_SESSION['info_moa']['moa_direction_4'] : ''?>" name="moa_direction_4"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-b border-l-2 border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance'])==1 ? "checked=checked" : ""; ?>  name="moa_surveillance"/>
                                <label>&ensp; Surveillance</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance_1'])==1 ? "checked=checked" : ""; ?>  name="moa_surveillance_1"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance_2'])==1 ? "checked=checked" : ""; ?>  name="moa_surveillance_2"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_surveillance_3'])==1 ? "checked=checked" : ""; ?> name="moa_surveillance_3"/>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" name="moa_surveillance_4" value="<?= isset($_SESSION['info_moa']['moa_surveillance_4']) ? $_SESSION['info_moa']['moa_surveillance_4'] : ''?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-l-2 border-b-2 border-gray-300 p-2 pl-4">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution'])==1 ? "checked=checked" : ""; ?> name="moa_execution"/>
                                <label>&ensp; Exécution</label>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution_1'])==1 ? "checked=checked" : ""; ?> name="moa_execution_1"/>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution_2'])==1 ? "checked=checked" : ""; ?> name="moa_execution_2"/>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="checkbox" value="1" <?= isset($_SESSION['info_moa']['moa_execution_3'])==1 ? "checked=checked" : ""; ?> name="moa_execution_3"/>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="text" name="moa_execution_4" value="<?= isset($_SESSION['info_moa']['moa_execution_4']) ? $_SESSION['info_moa']['moa_execution_4'] : ''?>"/>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <!-- Bouton précédent -->                                          
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step1" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Précédent</button>
            </div>
            <!-- Bouton suivant -->
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step3" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="moa">
    </form>
</section>