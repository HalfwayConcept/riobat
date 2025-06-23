
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
                    
                    <div class='flex flex-col'><strong>Travaux sur construction existante </strong>";
                        if(isset($DATA['nature_operation_surelev']) && $DATA['nature_operation_surelev'] == 1){
                            echo '<div class="ml-6">
                                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Surélévation:</h2>
                                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">';

                                        if(isset($DATA['nature_operation_surelev_sous_oeuvre']) && $DATA['nature_operation_surelev_sous_oeuvre'] == 1){
                                                echo '<li class="flex items-center">
                                                    <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                                    </svg>
                                                    Reprise en sous-oeuvre / Travaux sur fondation
                                                </li>';                                
                                        }
                                        if(isset($DATA['nature_operation_surelev_hors_fond']) && $DATA['nature_operation_surelev_hors_fond'] == 1){
                                                echo '<li class="flex items-center">
                                                        <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                                        </svg>
                                                    Intervention sur la structure existante (hors fondation)
                                                </li>';   
                                        }
                                    echo '</ul>';
                            echo "</div>";
                        }
                        
                        if($DATA['nature_operation_ext_horizont'] == 1){
                            echo '<div class="ml-6">
                                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Extension horizontale:</h2>
                                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">';

                                        if(isset($DATA['nature_operation_ext_horizont_exist']) && $DATA['nature_operation_ext_horizont_exist'] == 1){
                                                echo '<li class="flex items-center">
                                                    <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                                    </svg>
                                                    Intervention sur la structure existante y compris la fondation
                                                </li>';   
                                        }
                                    echo '</ul>'; 
                            echo "</div>";                           
                        }

                        if($DATA['nature_operation_renovation'] == 1){
                            echo '<div class="ml-6">
                                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Rénovation:</h2>
                                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">';

                                    if(isset($DATA['nature_operation_renovation_fond']) && $DATA['nature_operation_renovation_fond'] == 1){
                                        echo '<li class="flex items-center">
                                            <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            Intervention sur la structure existante y compris la fondation
                                        </li>';
                                    }
                                    if(isset($DATA['nature_operation_renovation_iso_therm']) && $DATA['nature_operation_renovation_iso_therm'] == 1){
                                      echo '<li class="flex items-center">
                                            <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            Isolation thermique extérieureon
                                        </li>';                                        
                                    }
                                    if(isset($DATA['nature_operation_renovation_refect_toit']) && $DATA['nature_operation_renovation_refect_toit'] == 1){
                                      echo '<li class="flex items-center">
                                            <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            Réfection de toiture
                                        </li>';                                          
                                    }
                                    if(isset($DATA['nature_operation_renovation_etancheite']) && $DATA['nature_operation_renovation_etancheite'] == 1){
                                      echo '<li class="flex items-center">
                                            <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            Travaux d\'étanchéité
                                        </li>';                                         
                                    }
                                    if(isset($DATA['nature_operation_renovation_ravalement']) && $DATA['nature_operation_renovation_ravalement'] == 1){
                                        echo '<li class="flex items-center">
                                            <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            Ravalement de façade
                                        </li>';                                                
                                    }
                            echo '</ul>';
                            echo "</div>";
                        }

                        if($DATA['nature_operation_rehabilitation'] == 1){
                            echo "<div class='ml-6'>
                                    <strong>Réhabilitation</strong>
                                    ";
                                    if(isset($DATA['nature_operation_rehabilitation_fond']) && $DATA['nature_operation_rehabilitation_fond'] == 1){
                                        $content = boxDisplay($DATA['nature_operation_rehabilitation_fond'],"nature_operation_rehabilitation_fond","read");
                                        $content .= "Intervention sur la structure existante y compris la fondation";
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_iso_therm']) && $DATA['nature_operation_rehabilitation_iso_therm'] == 1){
                                        $content = boxDisplay($DATA['nature_operation_rehabilitation_iso_therm'],"nature_operation_rehabilitation_iso_therm","read");
                                        $content .= "Isolation thermique extérieure";
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_refect_toit']) && $DATA['nature_operation_rehabilitation_refect_toit'] == 1){
                                        $content = boxDisplay($DATA['nature_operation_rehabilitation_refect_toit'],"nature_operation_rehabilitation_refect_toit","read");
                                        $content .= "Réfection de toiture";
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_etancheite']) && $DATA['nature_operation_rehabilitation_etancheite'] == 1){
                                        $content = boxDisplay($DATA['nature_operation_rehabilitation_etancheite'],"nature_operation_rehabilitation_etancheite","read");
                                        $content .= "Travaux d'étanchéité";
                                        echo $content;
                                    }
                                    if(isset($DATA['nature_operation_rehabilitation_ravalement']) && $DATA['nature_operation_rehabilitation_ravalement'] == 1){
                                        $content = boxDisplay($DATA['nature_operation_rehabilitation_ravalement'],"nature_operation_rehabilitation_ravalement","read");
                                        $content .= "Ravalement de façade";
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
            
                <?php 
                    if(isset($DATA['type_ouvrage_mais_indiv']) && $DATA['type_ouvrage_mais_indiv'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_mais_indiv'],"type_ouvrage_mais_indiv","read");
                        $content .= "Maison individuelle";
                        echo $content;   
                            if(isset($DATA['type_ouvrage_mais_indiv_piscine']) && $DATA['type_ouvrage_mais_indiv_piscine'] == 1){
                                echo "<span class='flex flex-row'>";
                                    echo "<span class='font-medium ml-2'>: présence d'une piscine</span>";
                                    echo "<span class='font-medium ml-4'>( ".$DATA['type_ouvrage_mais_indiv_piscine_situation']." )</span>";
                                echo "</span>";
                            } 
                        echo "</div>";
                    }

                    if(isset($DATA['type_ouvrage_ope_pavill']) && $DATA['type_ouvrage_ope_pavill'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_ope_pavill'],"type_ouvrage_ope_pavill","read");
                        $content .= "Opération pavillonnaire :";
                        echo $content;
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_ope_pavill_nombre']." maisons</span></div>";
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_coll_habit']) && $DATA['type_ouvrage_coll_habit'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_coll_habit'],"type_ouvrage_coll_habit","read");
                        $content .= "Collectif d'habitation :";
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_coll_habit_nombre']." appartements</span></div>";
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_bat_indus']) && $DATA['type_ouvrage_bat_indus'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_bat_indus'],"type_ouvrage_bat_indus","read");
                        $content .= "Bâtiment à usage industriel ou agricole";
                        echo $content;
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_centre_com']) && $DATA['type_ouvrage_centre_com'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_centre_com'],"type_ouvrage_centre_com","read");
                        $content.="Centre commercial, bâtiment à usage de vente :";
                        echo $content;                        
                        echo "<div class='flex flex-row'>".$DATA['type_ouvrage_centre_com_surf']." m²</div>";
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_bat_bur']) && $DATA['type_ouvrage_bat_bur'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_bat_bur'],"type_ouvrage_bat_bur","read");
                        $content .= "Bâtiment à usage de bureau";
                        echo $content;
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_hopital']) && $DATA['type_ouvrage_hopital'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_hopital'],"type_ouvrage_hopital","read");
                        $content .= "Bâtiment d'établissement Hospitalier, de Maison de retraite, Clinique";
                        echo $content;
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_vrd_privatif']) && $DATA['type_ouvrage_vrd_privatif'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_hopital'],"type_ouvrage_hopital","read");
                        $content .= "Voirie réseaux Divers (VRD) à usage privatif d'un bâtiment";
                        echo $content;
                        echo "</div>";
                    }
                    if(isset($DATA['type_ouvrage_autre_const']) && $DATA['type_ouvrage_autre_const'] == 1){
                        $content ='<div class="flex flex-row pl-8">';
                        $content .= boxDisplay($DATA['type_ouvrage_hopital'],"type_ouvrage_hopital","read");
                        $content .= "Autre construction :";
                        echo $content;
                        echo "<div class='flex flex-row'>".$content."&nbsp;<span>".$DATA['type_ouvrage_autre_const_usage']."</span></div>";
                        echo "</div>";
                    }
                    ?>                    
             </div>

        <div class="flex flex-col">
            <h2>Adresse de la construction :</h2>
            <div class="flex flex-col pl-8">
                <strong class="pl-4">
                <?php if(isset($DATA['construction_adresse_num_nom_rue'])){ echo $DATA['construction_adresse_num_nom_rue']."<br>";}; ?>
                <?php if(isset($DATA['construction_adresse_esc_res_bat'])){ echo $DATA['construction_adresse_esc_res_bat']."<br>";};  ?>
                <?php if(isset($DATA['construction_adresse_lieu_dit'])){ echo $DATA['construction_adresse_lieu_dit']."<br>";}; ?>
                <?php if(isset($DATA['construction_adresse_arrond'])){ echo $DATA['construction_adresse_arrond']."&nbsp;ième arrondissement<br>";}; ?> 
                <div>
                    <?php if(isset($DATA['construction_adresse_code_postal'])){ echo $DATA['construction_adresse_code_postal'];}; ?>
                    <?php if(isset($DATA['construction_adresse_commune'])){ echo $DATA['construction_adresse_commune'];}; ?>
                </div>
                </strong>
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








