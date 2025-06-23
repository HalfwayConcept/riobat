
<div class="">
    <!-- Informations Maitre d'ouvrage -->
    <fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Maitre d'ouvrage</legend>

        <div class="">
            <?php 
                if(isset($DATA['moa_souscripteur']) && ($DATA['moa_souscripteur']) == 1){
                    echo "<strong>Le maitre d'ouvrage est le souscripteur</strong>";
                }else{
                    echo "<div class='flex flex-row'>
                            <h3>Nom, Prénom</h3>
                            <strong class='pl-4'>".$DATA['moa_souscripteur_form_nom_prenom']."</strong><br />
                        </div>
                        <div class='flex flex-row'>
                            <h3>Adresse</h3>
                            <strong class='pl-4'>".$DATA['moa_souscripteur_form_adresse']."</strong><br />
                        </div>";
                    if($DATA['moa_souscripteur_form_civilite'] == "entreprise"){
                        echo "<div class='flex flex-row'>
                            <h3>Raison sociale</h3>
                            <strong class='pl-4'>".$DATA['moa_souscripteur_form_raison_sociale']."</strong><br />
                        </div>
                        <div class='flex flex-row'>
                            <h3>Siret n°</h3>
                            <strong class='pl-4'>".$DATA['moa_souscripteur_form_siret']."</strong><br />
                        </div>";
                    }               
                }
            ?>
        </div>
        <div class="flex flex-row">
            <h3>Qualité du maitre d'ouvrage</h3>
            <strong class="pl-4"><?php
                switch ($DATA['moa_qualite']){
                    case 'etat':
                        echo "Etat (services publics)";
                        break;
                    case 'hlm_public':
                        echo "Organismes d'habitations à loyer modéré (secteur public)";
                        break;
                    case 'syndic':
                        echo "Syndicats de copropriétaires";
                        break;
                    case 'vendeur_prive':
                        echo "Vendeur privé après achèvement";
                        break;
                    case'sci':
                        echo "Société Civile Immobilière";
                        break;
                    case 'entreprise':
                        echo "Entreprise";
                        break;
                    case'moa_qualite_autre':
                        echo $DATA['moa_qualite_champ'];
                        break;
                    case 'collectivites':
                        echo "Collectivités locales";
                        break;
                    case 'hlm_prive':
                        echo "Organismes d'habitations à loyer modéré (secteur privé)";
                        break;
                    case'vendeur_prive_imm':
                        echo "Vendeur privé d'immeubles à construire";
                        break;
                    case 'particulier':
                        echo "Particulier";
                        break;
                    case 'prom_prive':
                        echo "Promoteur privé immobilier";
                        break;
                    case 'asso':
                        echo "Association";
                        break;
                };
            ?></strong>
        </div>

        <div class="flex flex-col ">
            <?php
                if(isset($DATA['moa_construction']) && ($DATA['moa_construction']) == 1){
                    echo "<div class='flex flex-row'>
                            <strong>Le maitre d'ouvrage participe à la construction </strong>";
                            if(isset($DATA['moa_construction_pro']) && ($DATA['moa_construction_pro']) == 1){                        
                                echo ".<h3>en tant que professionel de : </h3><strong class='pl-4'>".$DATA['moa_construction_pro']."</strong>";
                            }else{
                                echo "<strong>et n'est pas un professionnel de la construction</strong>";
                            };
                    echo "</div>";
                    
                    if((isset($DATA['moa_conception']) && $DATA['moa_conception'] == 1) || 
                        (isset($DATA['moa_direction']) && $DATA['moa_direction'] == 1) || 
                        (isset($DATA['moa_surveillance']) && $DATA['moa_surveillance'] == 1) || 
                        (isset($DATA['moa_execution']) && $DATA['moa_execution'] == 1)){

                        echo "<h2>Ses activités et/ou missions</h2>";                        
                        $content ='<table class="text-sm font-light ml-6 mt-4">
                        <tbody><tr>
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
                                '.boxDisplay($DATA['moa_conception_1'],"moa_conception_1","read").'
                                <label>Conception</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_conception_1'],"moa_conception_1","read").'
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_conception_2'],"moa_conception_2","read").'
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_conception_3'],"moa_conception_3","read").'
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" name="moa_conception_4" value="'.$DATA['moa_conception_4'].'"></td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-b border-l-2 border-gray-300 p-2 pl-4">
                                '.boxDisplay($DATA['moa_direction'],"moa_direction","read").'
                                <label>Direction</label>
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_direction_1'],"moa_direction_1","read").'

                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_direction_2'],"moa_direction_2","read").'
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_direction_3'],"moa_direction_3","read").'
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text"  name="moa_direction_4" value="'.$DATA['moa_direction_4'].'">
                            </td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-b border-l-2 border-gray-300 p-2 pl-4">
                                '.boxDisplay($DATA['moa_surveillance'],"moa_surveillance","read").'
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_surveillance_1'],"moa_surveillance_1","read").'
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_surveillance_2'],"moa_surveillance_2","read").'
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_surveillance_3'],"moa_","read").'
                            </td>
                            <td class="border-r-2 border-b border-gray-300 text-center p-2">
                                <input type="text" name="moa_surveillance_4" value="'.$DATA['moa_surveillance_4'].'">
                            </td>
                        </tr>
                        <tr>
                            <td class="border-r-2 border-l-2 border-b-2 border-gray-300 p-2 pl-4">
                                '.boxDisplay($DATA['moa_execution'],"moa_execution","read").'
                                <label>Exécution</label>
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_execution_1'],"moa_execution_1","read").'
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_execution_2'],"moa_execution_2","read").'
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                '.boxDisplay($DATA['moa_execution_3'],"moa_execution_3","read").'
                            </td>
                            <td class="border-b-2 border-r-2 border-gray-300 text-center p-2">
                                <input type="text" name="moa_execution_4" value="'.$DATA['moa_execution_4'].'">
                            </td>
                        </tr>
                    </tbody></table>';
                        echo $content;
                    }
                    
                }else{
                    echo "<strong>Le maitre d'ouvrage ne participe pas à la construction</strong>";
                }
            ?>
        </div>

    </fieldset>
</div>








