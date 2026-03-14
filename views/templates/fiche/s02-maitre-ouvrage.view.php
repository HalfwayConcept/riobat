</script>
<script src="/public/script/s02-maitre-ouvrage.js"></script>

<div class="">
    <!-- Informations Maitre d'ouvrage -->
    <div class="flex items-center gap-3 mb-2 mt-6">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8" />
        </svg>
        <h2 class="text-xl font-bold text-gray-800">Maitre d'ouvrage</h2>
    </div>
    <hr class="mb-4 border-blue-200">

        <div class="grid md:gap-6  border-gray-400 p-4 m-6">
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
        
        <div class="flex flex-row">
            <h3>Qualité du maitre d'ouvrage </h3>
            <strong class="pl-4">
                <?php
                require_once 'models/moa_qualite.model.php';
                if (!empty($DATA['moa_qualite'])) {
                    echo htmlspecialchars(getMoaQualiteLabelById($DATA['moa_qualite']));
                } else {
                    echo '<span class="text-gray-400">Non renseigné</span>';
                }
                ?>
            </strong>
        </div>

        <div class="flex flex-col ">
            <?php
                if(isset($DATA['moa_construction']) && ($DATA['moa_construction']) == 1){
                    echo "<div class='flex flex-row'>
                            <strong>Le maitre d'ouvrage participe à la construction</strong>";
                            if(isset($DATA['moa_construction_pro']) && ($DATA['moa_construction_pro']) == 1){                        
                                echo ".<h3>en tant que professionel de : </h3><strong class='pl-4'>".$DATA['moa_construction_pro']."</strong>";
                            }else{
                                echo "<strong>et n'est pas un professionnel de la construction</strong>";
                            };
                    echo "</div>";
                
                    
                }else{
                    echo "<strong>Le maitre d'ouvrage ne participe pas à la construction</strong>";
                }
            ?>

        
        <?php
            require_once __DIR__ . '/../../components/renderMissionsTableReadOnly.php';
            if (!empty($DATA['moa_nature_travaux_json'])) {
                echo '<div class="overflow-x-auto w-full">';
                // Patch la largeur du tableau généré
                $table = renderMissionsTableReadOnly($DATA['moa_nature_travaux_json']);
                $table = str_replace('w-full', 'w-[95%]', $table);
                echo $table;
                echo '</div>';
            } else {
                echo '<em class="text-gray-400">Aucune mission renseignée</em>';
            }
        ?> 
        </div>   
</div>








