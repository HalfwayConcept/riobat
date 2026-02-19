</script>
<script src="/public/script/s02-maitre-ouvrage.js"></script>

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
            <h3>Qualité du maitre d'ouvrage <span class="text-red-600">*</span></h3>
            <strong class="pl-4"> ##TABLE MOA QUALITE##</strong>
        </div>

        <div class="flex flex-col ">
            <?php
                    if(isset($DATA['moa_construction']) && ($DATA['moa_construction']) == 1){
                    echo "<div class='flex flex-row'>
                            <strong>Le maitre d'ouvrage participe à la construction <span class='text-red-600'>*</span></strong>";
                            if(isset($DATA['moa_construction_pro']) && ($DATA['moa_construction_pro']) == 1){                        
                                echo ".<h3>en tant que professionel de : </h3><strong class='pl-4'>".$DATA['moa_construction_pro']."</strong>";
                            }else{
                                echo "<strong>et n'est pas un professionnel de la construction</strong>";
                            };
                    echo "</div>";
                    
                    // Bloc détaillé des missions supprimé
                    
                }else{
                    echo "<strong>Le maitre d'ouvrage ne participe pas à la construction</strong>";
                }
            ?>
            <div class="my-2">
                <label for="missions_json" class="block text-xs text-gray-500">missions_json (JSON sérialisé du tableau)</label>
                <input type="text" name="missions_json" id="missions_json" value="" class="w-full border border-gray-300 rounded p-1 text-xs bg-gray-100">
            </div>
        </div>

    </fieldset>
</div>








