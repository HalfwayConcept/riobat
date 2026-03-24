</script>
<script src="/public/script/s02-maitre-ouvrage.js"></script>

<div>
    <div class="fiche-title">
        <span class="fiche-title-num">2</span>
        <h2>Maître d'ouvrage</h2>
    </div>
    <hr class="fiche-hr">

    <fieldset class="fiche-fieldset">
        <legend>Identité du maître d'ouvrage</legend>
        <?php 
            if(isset($DATA['moa_souscripteur']) && ($DATA['moa_souscripteur']) == 1){
                echo '<div class="fiche-check"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>Le maître d\'ouvrage est le souscripteur</span></div>';
            }else{
                $civilite = $DATA['moa_souscripteur_form_civilite'] ?? '';
                $civiliteLabel = ($civilite == 'entreprise') ? 'Entreprise' : 'Particulier';
                echo '<div class="fiche-row"><span class="fiche-label">Civilité</span><span class="fiche-value">'.$civiliteLabel.'</span></div>';
                if($civilite == 'entreprise'){
                    echo '<div class="fiche-row"><span class="fiche-label">Raison sociale</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_souscripteur_form_raison_sociale'] ?? '').'</span></div>';
                    echo '<div class="fiche-row"><span class="fiche-label">Siret n°</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_souscripteur_form_siret'] ?? '').'</span></div>';
                }
                echo '<div class="fiche-row"><span class="fiche-label">Nom, Prénom</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_souscripteur_form_nom_prenom'] ?? '').'</span></div>';
                echo '<div class="fiche-row"><span class="fiche-label">Adresse</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_souscripteur_form_adresse'] ?? '').'</span></div>';
            }
        ?>
        
        <div class="fiche-row">
            <span class="fiche-label">Qualité du maître d'ouvrage</span>
            <span class="fiche-value">
                <?php
                require_once 'models/moa_qualite.model.php';
                if (!empty($DATA['moa_qualite'])) {
                    echo htmlspecialchars(getMoaQualiteLabelById($DATA['moa_qualite']));
                } else {
                    echo '<span class="text-gray-400">Non renseigné</span>';
                }
                ?>
            </span>
        </div>

        <?php
            if(isset($DATA['moa_construction']) && ($DATA['moa_construction']) == 1){
                echo '<div class="fiche-check"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>Le maître d\'ouvrage participe à la construction</span></div>';
                if(isset($DATA['moa_construction_pro']) && ($DATA['moa_construction_pro']) == 1){                        
                    echo '<div class="fiche-row ml-6"><span class="fiche-label">En tant que professionnel de</span><span class="fiche-value">'.$DATA['moa_construction_pro'].'</span></div>';
                }else{
                    echo '<div class="fiche-check ml-6"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>N\'est pas un professionnel de la construction</span></div>';
                }
            }else{
                echo '<div class="fiche-check"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>Le maître d\'ouvrage ne participe pas à la construction</span></div>';
            }
        ?>
    </fieldset>

    <?php
        require_once __DIR__ . '/../../components/renderMissionsTableReadOnly.php';
        if (!empty($DATA['moa_nature_travaux_json'])) {
            echo '<div class="overflow-x-auto w-full mt-2">';
            $table = renderMissionsTableReadOnly($DATA['moa_nature_travaux_json']);
            $table = str_replace('w-full', 'w-[95%]', $table);
            echo $table;
            echo '</div>';
        } else {
            echo '<em class="text-gray-400 ml-4">Aucune mission renseignée</em>';
        }
    ?>
</div>



