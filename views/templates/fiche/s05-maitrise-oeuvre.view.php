<fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
    <legend class="mx-2 p-2 text-xl font-medium">Maitrise d'oeuvre et Garanties <span class="text-red-600">*</span></legend>

    <div class="flex flex-col">
        <div class='ml-6'>
    <?php 
        if(isset($DATA['moe']) && ($DATA['moe'] == 0))
        {
            echo "<strong>Aucun architecte ou maitre d'oeuvre n'intervient dans l'opération de construction</strong>";

        }
        elseif(isset($DATA['moe']) && ($DATA['moe'] == 1))
        {       
            echo "<strong>Architecte ou maitre d'oeuvre :</strong>";
            echo viewEntreprise($DATA['moe_entreprise_id']);
            
            if(isset($DATA['moe_intervention_independant']) && $DATA['moe_intervention_independant'] == 1)
            {
                $content = boxDisplay($DATA['moe_intervention_independant'],"moe_intervention_independant","read");
                $content .="L'architecte ou le maitre d'oeuvre est indépendant à l'égard des autres constructeurs et du maitre d'ouvrage";
                echo $content;
            }
            elseif(isset($DATA['moe_intervention_independant']) && $DATA['moe_intervention_independant'] == 0)
            {
                if(isset($DATA['moe_intervention_independant_qualite']))
                {
                    echo "<span class='mr-2'>Qualité et fonction du maitre d'oeuvre :</span><strong>".$DATA['moe_intervention_independant_qualite']."</strong>";
                }
                if(isset($DATA['moe_intervention_independant_mission']))
                {
                    echo "<h3 class='mr-2'>Mission du maitre d'oeuvre :</h3>";
                    switch ($DATA['moe_intervention_independant_mission'])
                    {
                        case 'conception':
                            echo"<strong>Conception</strong>";
                            break;
                        case 'direction':
                            echo"<strong>Direction et surveillance des travaux</strong>";
                            break;
                        case 'complete':
                            echo"<strong>Mission complète</strong>";
                            break;
                        case 'autre':
                            echo"<strong>Autre : ".$DATA['moe_intervention_independant_autre_descr']."</strong>";
                        break;
                    }
                }
                
            }
        }
    ?>
        </div>
    </div>

    <div class="flex flex-col">
        <ul class="max-w-md space-y-1 list-inside ml-6">
            <li class="flex items-center text-red-800 dark:text-red">

            </li>
        <?php
                echo "<h3>Garanties demandées</h3>";
                if(isset($DATA['garantie_do']) && $DATA['garantie_do'] == 1){
                    echo "<strong class='pl-4'>Dommage Ouvrage</strong>";
                    }
                if(isset($DATA['garantie_cnr']) && $DATA['garantie_cnr'] == 1){
                    echo "<strong class='pl-4'>Responsabilité du Constructeur Non Réalisateur</strong>";
                    }
                if(isset($DATA['garantie_chantier']) && $DATA['garantie_chantier'] == 1){
                    echo "<strong class='pl-4'>Tous risques chantier</strong>";
                    }
                if(isset($DATA['garantie_juridique']) && $DATA['garantie_juridique'] == 1){
                        ?>

                        <li class="flex items-center text-grey-800 dark:text-grey">
                            <svg class="w-6 h-6 text-green-800 dark:text-green" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m6 6 12 12m3-6a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg> Protection juridique
                        </li>

                        <?php
                };
                ?>
        </ul>
      
    </div>
            
</fieldset>