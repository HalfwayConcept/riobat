<div>
    <!-- Operation de construction : situation de l'ouvrage -->
    <fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Opération de construction : situation de l'ouvrage</legend>

        <div class="flex flex-col">
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_zone_inond']) && $DATA['situation_zone_inond'] == 1){
                        echo "<strong>L'ouvrage est situé en zone innondable</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php
                    if(isset($DATA['situation_sismique'])){
                        switch ($DATA['situation_sismique']){
                            case '1':
                                echo "<strong>L'ouvrage est situé dans une zone de sismicité très faible</strong>";
                                break;
                            case '2':
                                echo "<strong>L'ouvrage est situé dans une zone de sismicité faible</strong>";
                                break;
                            case '3':
                                echo "<strong>L'ouvrage est situé dans une zone de sismicité modérée</strong>";
                                break;
                            case '4':
                                echo "<strong>L'ouvrage est situé dans une zone de sismicité moyenne</strong>";
                                break;
                            case '5':
                                echo "<strong>L'ouvrage est situé dans une zone de sismicité forte</strong>";
                                break;
                            }
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_insectes']) && $DATA['situation_insectes'] == 1){
                        echo "<strong>L'ouvrage est situé dans une zone contaminée par les termites ou autres insectes xylophages</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_proc_tech']) && $DATA['situation_proc_tech'] == 1){
                        echo "<strong>Les travaux sont réalisés avec des matériaux traditionnels ou selon des procédés de technique courante</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_parking']) && $DATA['situation_parking'] == 1){
                        echo "<strong>Un parking (accessoire de l'ouvrage) dessert l'ouvrage</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_do_10ans']) && $DATA['situation_do_10ans'] == 1){
                        echo "<strong>Les existants datent de moins de 10 ans, et ils ont fait l'objet d'un contrat d'assurance \"dommages ouvrage\"</strong>";
                        }
                ?>
                    <div class="ml-6">
                        <?php 
                            if(isset($DATA['situation_do_10ans_contrat_assureur'])){
                                echo "<span class='mr-2'>Nom de l'assureur :</span><strong>".$DATA['situation_do_10ans_contrat_assureur']."</strong>";
                                }
                            if(isset($DATA['situation_do_10ans_contrat_numero'])){
                                echo "<span class='mr-2'>Numéro de contrat :</span><strong>".$DATA['situation_do_10ans_contrat_numero']."</strong>";
                                }
                        ?>
                    </div>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_mon_hist']) && $DATA['situation_mon_hist'] == 1){
                        echo "<strong>Les existants sont classés monuments historiques ou font l'objet d'une protection du patrimoine</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_label_energie']) && $DATA['situation_label_energie'] == 1){
                        echo "<strong>L'opération de construction bénéficie d'un label de performance énergétique</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['situation_label_qualite']) && $DATA['situation_label_qualite'] == 1){
                        echo "<strong>L'opération de construction bénéficie d'un label de qualité environnementale</strong>";
                        }
                ?>
            </div>
            <div class='ml-6'>
                <?php 
                    if(isset($DATA['sol']) && $DATA['sol'] == 1){

                        echo "<div class='ml-6'>";
                            echo viewEntreprise($DATA['sol_entreprise_id']);
                        echo "</div>";
                        echo "Mission :";
                            switch ($DATA['sol_bureau_mission']){
                                case 'g2_amp':
                                    echo "G2 AMP";
                                    break;
                                case 'g2_pro':
                                    echo "G2 PRO";
                                    break;
                                case 'etude_sol_autre':
                                    echo $DATA['sol_bureau_mission_champ'];
                                    break;
                            }
                    }
                ?>
                <div class='ml-6'>
                    <?php 
                        if(isset($DATA['sol_parking']) && $DATA['sol_parking'] == 1){
                            echo "<strong>L'étude de sol vise également le parking et/ou les voiries</strong>";
                            }
                    ?>
                </div>
            </div>
            <?php
                if((isset($DATA['situation_garanties_completes']) && $DATA['situation_garanties_completes'] == 1) || (isset($DATA['situation_garanties_dommages_existants']) && $DATA['situation_garanties_dommages_existants'] == 1)){
                    echo "<div class='flex flex-col mt-10'>
                        <h3>Garanties demandées</h3>";
                    if(isset($DATA['situation_garanties_completes']) && $DATA['situation_garanties_completes'] == 1){
                        echo "<strong class='ml-6'>Garanties complètes (CS n°811)</strong>";
                    }
                    if(isset($DATA['situation_garanties_dommages_existants']) && $DATA['situation_garanties_dommages_existants'] == 1){
                        echo "<strong class='ml-6'>Dommages matériels subits par les existants (CS n°811)</strong>";
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </fieldset>
</div>