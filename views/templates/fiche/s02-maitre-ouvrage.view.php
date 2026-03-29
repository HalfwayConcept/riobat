</script>
<script src="/public/script/s02-maitre-ouvrage.js"></script>

<div>
    <div class="fiche-title">
        <span class="fiche-title-num">2</span>
        <h2>Maître d'ouvrage</h2>
    </div>
    <hr class="fiche-hr">

    <?php if(isset($DATA['moa_souscripteur']) && ($DATA['moa_souscripteur']) == 1): ?>
    <fieldset class="fiche-fieldset">
        <legend>Identité du maître d'ouvrage</legend>
        <?php echo '<div class="fiche-check"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>Le maître d\'ouvrage est le souscripteur</span></div>'; ?>
    </fieldset>
    <?php else: ?>
    <div class="grid md:grid-cols-2 grid-cols-1 gap-4 items-start">
    <div>
    <fieldset class="fiche-fieldset">
        <legend>Identité du maître d'ouvrage</legend>
        <?php
                $civilite = $DATA['moa_sub_civilite'] ?? '';
                $civiliteLabel = ($civilite == 'entreprise') ? 'Entreprise' : 'Particulier';
                echo '<div class="fiche-row"><span class="fiche-label">Civilité</span><span class="fiche-value">'.$civiliteLabel.'</span></div>';
                if (!empty($DATA['moa_entreprise_id'])) {
                    require_once 'models/entreprise.model.php';
                    $moa_ent = loadEntreprise($DATA['moa_entreprise_id']);
                    if ($moa_ent) {
                        if (!empty($moa_ent['nom'])) {
                            echo '<div class="fiche-row"><span class="fiche-label">Nom</span><span class="fiche-value">'.htmlspecialchars($moa_ent['nom']).'</span></div>';
                        }
                        if (!empty($moa_ent['prenom'])) {
                            echo '<div class="fiche-row"><span class="fiche-label">Prénom</span><span class="fiche-value">'.htmlspecialchars($moa_ent['prenom']).'</span></div>';
                        }
                    }
                }
                if($civilite == 'entreprise'){
                    echo '<div class="fiche-row"><span class="fiche-label">Raison sociale</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_sub_nom_raison'] ?? '').'</span></div>';
                    echo '<div class="fiche-row"><span class="fiche-label">Siret n°</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_sub_siret'] ?? '').'</span></div>';
                }
        ?>
    </fieldset>
    </div>
    <div>
    <fieldset class="fiche-fieldset">
        <legend>Adresse</legend>
        <?php
                echo '<div class="fiche-row"><span class="fiche-label">Adresse</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_sub_adresse'] ?? '').'</span></div>';
                echo '<div class="fiche-row"><span class="fiche-label">Code postal</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_sub_code_postal'] ?? '').'</span></div>';
                echo '<div class="fiche-row"><span class="fiche-label">Commune</span><span class="fiche-value">'.htmlspecialchars($DATA['moa_sub_commune'] ?? '').'</span></div>';
        ?>
    </fieldset>
    </div>
    </div>
    <?php endif; ?>

    <fieldset class="fiche-fieldset">
        <legend>Intervention du maître d'ouvrage</legend>

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
                    echo '<div class="fiche-row"><span class="fiche-label">En tant que professionnel de</span><span class="fiche-value">'.$DATA['moa_construction_pro'].'</span></div>';
                }else{
                    echo '<div class="fiche-check"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>N\'est pas un professionnel de la construction</span></div>';
                }
            }else{
                echo '<div class="fiche-check"><svg class="fiche-check-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg><span>Le maître d\'ouvrage ne participe pas à la construction</span></div>';
            }
        ?>

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
    </fieldset>
</div>



