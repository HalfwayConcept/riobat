
<div>
    <!-- Operation de construction : nature de l'ouvrage -->
    <fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Opération de construction : nature et type de l'ouvrage</legend>

        <div class="flex flex-col">
            <h3>Nature de l'opération :</h3>
            <div class="flex flex-row pl-8">
    <?php 
        if(isset($DATA['nature_neuf_exist']) && $DATA['nature_neuf_exist'] == "neuve"){
            echo "<strong>Construction neuve</strong>";
        }elseif(isset($DATA['nature_neuf_exist']) && $DATA['nature_neuf_exist'] == "existante"){
            echo "<div class='flex flex-row'>
                    <strong>Travaux sur construction existante </strong>
                    <div class='flex flex-col'>";
                        if(isset($DATA['nature_operation_surelev']) && $DATA['nature_operation_surelev'] == 1){
                            echo "<div class='ml-6'>
                            <strong>Surélévation</strong>";
                            if(isset($DATA['nature_operation_surelev_sous_oeuvre']) && $DATA['nature_operation_surelev_sous_oeuvre'] == 1){
                                $content = boxDisplay("Reprise en sous-oeuvre / Travaux sur fondation");
                                echo $content;
                            }
                            if(isset($DATA['nature_operation_surelev_hors_fond']) && $DATA['nature_operation_surelev_hors_fond'] == 1){
                                $content = boxDisplay("Intervention sur la structure existante (hors fondation)");
                                echo $content;
                            }
                            echo "</div>";
                        }

                        if($DATA['nature_operation_ext_horizont'] == 1){
                            echo "<div class='ml-6'>
                                    <strong>Extension horizontale</strong>";
                                    if(isset($DATA['nature_operation_ext_horizont_exist']) && $DATA['nature_operation_ext_horizont_exist'] == 1){
                                        $content = boxDisplay("Intervention sur la structure existante y compris la fondation");
                                        echo $content;
                                    }
                            echo "</div>";
                        }

                        if($DATA['nature_operation_renovation'] == 1){
                            echo "<div class='ml-6'>
                                    <strong>Rénovation</strong>
                                    ";
                                    if(isset($DATA['nature_operation_renovation_fond']) && $DATA['nature_operation_renovation_fond'] == 1){
                                        $content = boxDisplay("Intervention sur la structure existante y compris la fondation");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_renovation_iso_therm']) && $DATA['nature_operation_renovation_iso_therm'] == 1){
                                        $content = boxDisplay("Isolation thermique extérieure");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_renovation_refect_toit']) && $DATA['nature_operation_renovation_refect_toit'] == 1){
                                        $content = boxDisplay("Réfection de toiture");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_renovation_etancheite']) && $DATA['nature_operation_renovation_etancheite'] == 1){
                                        $content = boxDisplay("Travaux d'étanchéité");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_renovation_ravalement']) && $DATA['nature_operation_renovation_ravalement'] == 1){
                                        $content = boxDisplay("Ravalement de façade");
                                        echo $content;
                                    }
                            echo "</div>";
                        }

                        if($DATA['nature_operation_rehabilitation'] == 1){
                            echo "<div class='ml-6'>
                                    <strong>Réhabilitation</strong>
                                    ";
                                    if(isset($DATA['nature_operation_rehabilitation_fond']) && $DATA['nature_operation_rehabilitation_fond'] == 1){
                                        $content = boxDisplay("Intervention sur la structure existante y compris la fondation");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_iso_therm']) && $DATA['nature_operation_rehabilitation_iso_therm'] == 1){
                                        $content = boxDisplay("Isolation thermique extérieure");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_refect_toit']) && $DATA['nature_operation_rehabilitation_refect_toit'] == 1){
                                        $content = boxDisplay("Réfection de toiture");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_etancheite']) && $DATA['nature_operation_rehabilitation_etancheite'] == 1){
                                        $content = boxDisplay("Travaux d'étanchéité");
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_ravalement']) && $DATA['nature_operation_rehabilitation_ravalement'] == 1){
                                        $content = boxDisplay("Ravalement de façade");
                                        echo $content;
                                    }
                            echo "</div>";
                        }

                        if(isset($DATA['operation_sinistre']) && $DATA['operation_sinistre'] == 1){
                            echo "<strong class='ml-6'>Réparation suite à sinistre :".$DATA['operation_sinistre_descr']."</strong>";
                        }
                            echo "</div>";
                    echo "</div>";
                }
                   
                ?>
            </div>
        </div>

        <div class="mt-4">
            <h3>Type de l'ouvrage :</h3>
            <div class="flex flex-col pl-8">
                <?php 
                    if(isset($DATA['type_ouvrage_mais_indiv']) && $DATA['type_ouvrage_mais_indiv'] == 1){
                        echo "<div class='flex flex-row ml-6'>
                                <strong>Maison individuelle</strong>";
                        echo "<span class='flex flex-row'>";
                            if(isset($DATA['type_ouvrage_mais_indiv_piscine']) && $DATA['type_ouvrage_mais_indiv_piscine'] == 1){
                                echo "<span class='font-medium ml-2'>: présence d'une piscine</span>";
                                echo "<span class='font-medium ml-4'>( ".$DATA['type_ouvrage_mais_indiv_piscine_situation']." )</span>";
                            }
                        echo "</span>
                            </div>";
                    }
                    if(isset($DATA['type_ouvrage_ope_pavill']) && $DATA['type_ouvrage_ope_pavill'] == 1){
                        $content = boxDisplay("Opération pavillonnaire :");
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_ope_pavill_nombre']." maisons</span></div>";
                    }
                    if(isset($DATA['type_ouvrage_coll_habit']) && $DATA['type_ouvrage_coll_habit'] == 1){
                        $content = boxDisplay("Collectif d'habitation :");
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_coll_habit_nombre']." appartements</span></div>";
                    }
                    if(isset($DATA['type_ouvrage_bat_indus']) && $DATA['type_ouvrage_bat_indus'] == 1){
                        $content = boxDisplay("Bâtiment à usage industriel ou agricole");
                        echo $content;
                    }
                    if(isset($DATA['type_ouvrage_centre_com']) && $DATA['type_ouvrage_centre_com'] == 1){
                        $content = boxDisplay("Centre commercial, bâtiment à usage de vente :");
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_centre_com_surf']." m²</span></div>";
                    }
                    if(isset($DATA['type_ouvrage_bat_bur']) && $DATA['type_ouvrage_bat_bur'] == 1){
                        $content = boxDisplay("Bâtiment à usage de bureau");
                        echo $content;
                    }
                    if(isset($DATA['type_ouvrage_hopital']) && $DATA['type_ouvrage_hopital'] == 1){
                        $content = boxDisplay("Bâtiment d'établissement Hospitalier, de Maison de retraite, Clinique");
                        echo $content;
                    }
                    if(isset($DATA['type_ouvrage_vrd_privatif']) && $DATA['type_ouvrage_vrd_privatif'] == 1){
                        $content = boxDisplay("Voirie réseaux Divers (VRD) à usage privatif d'un bâtiment");
                        echo $content;
                    }
                    if(isset($DATA['type_ouvrage_autre_const']) && $DATA['type_ouvrage_autre_const'] == 1){
                        $content = boxDisplay("Autre construction :");
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_autre_const_usage']."</span></div>";
                    }
                    ?>                    
        </div>

        <div class="flex flex-col">
            <h3>Adresse de la construction :</h3>
            <div class="flex flex-col pl-8">
                <strong class="pl-4"><?php if(isset($DATA['construction_adresse_num_nom_rue'])){ echo $DATA['construction_adresse_num_nom_rue'];}; ?></strong>
                <strong class="pl-4"><?php if(isset($DATA['construction_adresse_esc_res_bat'])){ echo $DATA['construction_adresse_esc_res_bat'];};  ?></strong>
                <strong class="pl-4"><?php if(isset($DATA['construction_adresse_lieu_dit'])){ echo $DATA['construction_adresse_lieu_dit'];}; ?></strong>
                <strong class="pl-4"><?php if(isset($DATA['construction_adresse_arrond'])){ echo $DATA['construction_adresse_arrond'];}; ?> ième arrondissement</strong>
                <div>
                    <strong class="pl-4"><?php if(isset($DATA['construction_adresse_code_postal'])){ echo $DATA['construction_adresse_code_postal'];}; ?></strong>
                    <strong class="pl-2"><?php if(isset($DATA['construction_adresse_commune'])){ echo $DATA['construction_adresse_commune'];}; ?></strong>
                </div>
            </div>
        </div>

        <div class="flex flex-row">
            <div class="flex flex-col">
                <div class="flex flex-row">
                    <h3>Date d'ouverture de chantier : </h3>
                    <strong class='pl-6'>
                        <?php if(isset($DATA['construction_date_debut'])){
                                    $datedebut = dateFormat($DATA['construction_date_debut']);
                                    echo $datedebut;
                                    }
                        ?>
                    </strong>
                </div>
                <div class="flex flex-row">
                    <h3>Date prévue d'ouverture de chantier : </h3>
                    <strong class='pl-6'>
                        <?php if(isset($DATA['construction_date_debut_prevue'])){
                                    $datedebut = dateFormat($DATA['construction_date_debut_prevue']);
                                    echo $datedebut;
                                }
                        ?>
                    </strong>
                </div>
                <div class="flex flex-row">
                    <h3>Date de réception prévisionnelle : </h3>
                    <strong class='pl-6'>
                        <?php if(isset($DATA['construction_date_reception'])){
                                    $datedebut = dateFormat($DATA['construction_date_reception']);
                                    echo $datedebut;
                                    }
                        ?>
                    </strong>
                </div>
            </div>
        </div>

        <div class="flex flex-col mt-2">

            <h3>Coût de l'opération de construction :</h3>

            <div class="flex flex-col ml-6">
                <span>Coût en € : <?php if(isset($DATA['construction_cout_operation'])){
                    echo "<strong>".$DATA['construction_cout_operation']."</strong>";
                } ;?></span>
                <span>Honoraires du maitre d'oeuvre en € : <?php if(isset($DATA['construction_cout_honoraires_moe'])){
                    echo "<strong>".$DATA['construction_cout_honoraires_moe']."</strong>";
                } ;?></span>
                <strong>
                    <?php if(isset($DATA['cout_operation_tva']) && $DATA['cout_operation_tva'] == 1){
                            echo "La TVA est comprise";
                            }else{
                                echo "La TVA n'est pas comprise";} ?>
                </strong>
            </div>
        </div>

    </fieldset>
</div>








