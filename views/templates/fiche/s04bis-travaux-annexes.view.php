<!-- Travaux annexes -->
<fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
    <legend class="mx-2 p-2 text-xl font-medium">Travaux annexes</legend>
    <?php 
    if(isset($DATA['situation_boi']) && $DATA['situation_boi'] == 1):
    ?>
    <div id="situation_boi">
        <div class='ml-6'>
            <?php 
                if(isset($DATA['trav_annexes_constr_bois']) && $DATA['trav_annexes_constr_bois'] == 1){
                    echo "<strong>La structure de la construction (poteaux, poutres et voiles) est en bois</strong>";
                    }
            ?>
        </div>
        <div class='ml-6'>
            <?php 
                if(isset($DATA['trav_annexes_constr_bois_enveloppe']) && $DATA['trav_annexes_constr_bois_enveloppe'] == 1){
                    echo "<strong>L'enveloppe de la construction (façade, planchers et balcons) est en bois</strong>";
                }
            ?>
        </div>
        <div class='ml-6'>
            <?php 
                if(isset($DATA['trav_annexes_constr_produits_ce']) && $DATA['trav_annexes_constr_produits_ce'] == 1){
                    echo "<strong>Les produits utilisés bénéficient d'un marquage CE</strong>";
                }
            ?>
        </div>
        <?php 
            if(!empty($DATA['boi_entreprise_id'])){
                echo "<strong class='ml-6'>Entreprise réalisant la construction en bois :</strong>";
                echo coordFormDisplay('boi',$array_entreprises['boi'],true);
            }
        ?>
    </div>
    <?php 
    endif; //fin bois

    if(isset($DATA['situation_phv']) && $DATA['situation_phv'] == 1):
    ?>
    <div id="situation_phv">
        <?php 
            echo "<strong class='ml-6'>Entreprise réalisant la pause de photovoltaïque :</strong>";
            echo coordFormDisplay('phv',$array_entreprises['phv'],true);
            ?>
            <div class='ml-6'>
            <?php 
            if(isset($DATA['trav_annexes_pv_montage'])){
                switch ($DATA['trav_annexes_pv_montage']){
                    case 'integre':
                        echo "<strong>Les panneaux photovoltaïques sont intégrés à la toiture</strong>";
                        break;
                    case 'surimpose':
                        echo "<strong>Les panneaux photovoltaïques sont surimposés à la toiture</strong>";
                        break;
                    case 'autre':
                        echo "<strong>Les panneaux photovoltaïques ne sont ni intégrés ni surimposés à la toiture</strong>";
                        break;
                }
            }
            ?>
            </div>
            <div class='ml-6'>
            <?php 
                if(isset($DATA['trav_annexes_pv_proc_tech']) && $DATA['trav_annexes_pv_proc_tech'] == 1){
                    echo "<strong>Les procédés mis en oeuvre bénéficient d'un avis technique</strong>";
                        if(isset($DATA['trav_annexes_pv_etn']) && $DATA['trav_annexes_pv_etn'] == 1){
                            echo "<strong> et ils sont visés par une Enquête de Technique Nouvelle (ETN)</strong>";
                        }
                }
            ?>
            </div>
            <div class='ml-6'>
            <?php 
                if(isset($DATA['trav_annexes_pv_liste_c2p']) && $DATA['trav_annexes_pv_liste_c2p'] == 1){
                    echo "<strong>Les procédés figurent sur la liste verte C2P</strong>";
                }
            ?>
            </div>
            <div class='ml-6'><?=isset($DATA['trav_annexes_pv_surface']) ? "<strong>La surface de l'installation est de ".$DATA['trav_annexes_pv_surface']." m²</strong>" : "";?></div>
            <div class='ml-6'><?=isset($DATA['trav_annexes_pv_puissance']) ? "<strong>La puissance de l'installation est de ".$DATA['trav_annexes_pv_puissance']." kWc</strong>" : "";?></div>
            <div class='ml-6'>
            <?php 
            if(isset($DATA['trav_annexes_pv_destination'])){
                if($DATA['trav_annexes_pv_destination'] == "revente"){
                echo "<strong>L'électricité produite par l'intallation photovoltaïque est destinée à la revente à un opérateur dans le domaine de l'énergie</strong>";
                }elseif($DATA['trav_annexes_pv_destination'] == "autocons"){
                    echo "<strong>L'électricité produite par l'intallation photovoltaïque est destinée à l'autoconsommation</strong>";
                }
            }
            ?>        
            </div>
    <?php 
    endif;

    if(isset($DATA['situation_geo']) && $DATA['situation_geo'] == 1):
    ?>

    <div id="situation_geo">
        <div class="mt-10">
            <?php
                if(isset($DATA['situation_geo']) && $DATA['situation_geo'] == 1){
                    echo "<h3>Géothermie : Entreprise réalisant les forages :</h3>";
                    echo "<div class='ml-6'>
                            <div class='flex flex-row'>
                                <h3>Nom entreprise ou raison sociale</h3>
                                <strong class='pl-4'>".$DATA['geo_entreprise_raison_sociale']."</strong>
                            </div>
                            <div class='flex flex-row'>
                                <h3>Nom</h3>
                                <strong class='pl-4'>".$DATA['geo_entreprise_nom']."</strong>
                            </div>
                            <div class='flex flex-row'>
                                <h3>Prénom</h3>
                                <strong class='pl-4'>".$DATA['geo_entreprise_prenom']."</strong>
                            </div>
                            <div class='flex flex-row'>
                                <h3>Adresse</h3>
                                <strong class='pl-4'>".$DATA['geo_entreprise_adresse']."&nbsp;".$DATA['geo_entreprise_code_postal']."&nbsp;".$DATA['geo_entreprise_commune']."</strong>
                            </div>
                            <div class='flex flex-row'>
                                <h3>Siret n°</h3>
                                <strong class='pl-4'>".$DATA['geo_entreprise_numero_siret']."</strong>
                            </div>
                        </div>";
                    }else{
                        echo "<strong>Pas d'installation géothermique</strong>";
                    }
            ?>
        </div>
    </div>
    <?php 
    endif;

    if(isset($DATA['situation_ctt']) && $DATA['situation_ctt'] == 1):
    ?>
    <div id="situation_ctt">
        <div class="mt-10">
            <?php
            echo "<strong class='ml-6'>Contrôleur technique :</strong>";
            echo "<div class='ml-6'>
                    <div class='flex flex-row'>
                        <h3>Nom entreprise ou raison sociale</h3>
                        <strong class='pl-4'>".$DATA['ct_entreprise_raison_sociale']."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Nom</h3>
                        <strong class='pl-4'>".$DATA['ct_entreprise_nom']."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Prénom</h3>
                        <strong class='pl-4'>".$DATA['ct_entreprise_prenom']."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Adresse</h3>
                        <strong class='pl-4'>".$DATA['ct_entreprise_adresse']."&nbsp;".$DATA['ct_entreprise_code_postal']."&nbsp;".$DATA['ct_entreprise_commune']."</strong>
                    </div>
                    <div class='flex flex-row'>
                        <h3>Siret n°</h3>
                        <strong class='pl-4'>".$DATA['ct_entreprise_numero_siret']."</strong>
                    </div>
                </div>";

            ?>
            <div class="mt-10 ml-2">
                <?php
                    if(isset($DATA['trav_annexes_ct_type_controle'])){
                        echo "<div class='flex flex-row'><h3>Type de contrôle :</h3><div class='flex flex-row ml-2'>";
                        switch ($DATA['trav_annexes_ct_type_controle']){
                            case 'l':
                                echo "<strong>L</strong>";
                                break;
                            case 'lth':
                                echo "<strong>L + TH</strong>";
                                break;
                            case 'le':
                                echo "<strong>LE</strong>";
                                break;
                            case 'leth':
                                echo "<strong>LE + TH</strong>";
                                break;
                            case'lautre':
                                echo "<strong>L + autres :</strong>";
                                if(isset($DATA['trav_annexes_ct_type_controle_l_autres'])){
                                    $result = boxDisplay($DATA['trav_annexes_ct_type_controle_l_autres']);
                                echo $result;
                                }
                                break;
                            case 'entreprise':
                                echo "<strong>L + TH + autres :</strong>";
                                if(isset($DATA['trav_annexes_ct_type_controle_lth_autres'])){
                                    $result = boxDisplay($DATA['trav_annexes_ct_type_controle_lth_autres']);
                                echo $result;
                                }
                                break;
                            case'moa_qualite_autre':
                                echo "<strong>LE + autres :</strong>";
                                if(isset($DATA['trav_annexes_ct_type_controle_le_autres'])){
                                    $result = boxDisplay($DATA['trav_annexes_ct_type_controle_le_autres']);
                                echo $result;
                                }
                                break;
                            case'moa_qualite_autre':
                                echo "<strong>LE + TH + autres :</strong>";
                                if(isset($DATA['trav_annexes_ct_type_controle_leth_autres'])){
                                    $result = boxDisplay($DATA['trav_annexes_ct_type_controle_leth_autres']);
                                echo $result;
                                }
                                break;
                            }
                        echo "</div></div>";
                        }
                    ?>
            </div>
        </div>
    </div>
    <?php 
    endif;

    if(isset($DATA['situation_cnr']) && $DATA['situation_cnr'] == 1):
    ?>
    <div>
        <?php
        echo "<h3>Désignation du constructeur non réalisateur :</h3>";
        echo "<div class='ml-6'>
                <div class='flex flex-row'>
                    <h3>Nom entreprise ou raison sociale</h3>
                    <strong class='pl-4'>".$DATA['cnr_entreprise_raison_sociale']."</strong>
                </div>
                <div class='flex flex-row'>
                    <h3>Nom</h3>
                    <strong class='pl-4'>".$DATA['cnr_entreprise_nom']."</strong>
                </div>
                <div class='flex flex-row'>
                    <h3>Prénom</h3>
                    <strong class='pl-4'>".$DATA['cnr_entreprise_prenom']."</strong>
                </div>
                <div class='flex flex-row'>
                    <h3>Adresse</h3>
                    <strong class='pl-4'>".$DATA['cnr_entreprise_adresse']."&nbsp;".$DATA['cnr_entreprise_code_postal']."&nbsp;".$DATA['cnr_entreprise_commune']."</strong>
                </div>
                <div class='flex flex-row'>
                    <h3>Siret n°</h3>
                    <strong class='pl-4'>".$DATA['cnr_entreprise_numero_siret']."</strong>
                </div>
                <div class='flex flex-row'>
                    <h3>Siret n°</h3>
                    <strong class='pl-4'>".$DATA['cnr_qualite']."</strong>
                </div>
            </div>";

        ?>
    </div>     
    <?php
    endif;
    ?>
</fieldset>
