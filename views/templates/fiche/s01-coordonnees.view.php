
<div>
    <div class="fiche-title">
        <span class="fiche-title-num">1</span>
        <h2>Souscripteur<?php if(isset($DATA['moa_souscripteur']) && $DATA['moa_souscripteur'] == 1): ?> <span style="font-weight:400; color:#64748b; font-size:0.85rem;">(Le maître d'ouvrage est le souscripteur)</span><?php endif; ?></h2>
    </div>
    <hr class="fiche-hr">
    <fieldset class="fiche-fieldset">
        <legend>Coordonnées</legend>
        <div class="fiche-row">
            <span class="fiche-label">Nom</span>
            <span class="fiche-value"><?=$DATA['souscripteur_nom_raison']?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Siret n°</span>
            <span class="fiche-value"><?=$DATA['souscripteur_siret']?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Adresse</span>
            <span class="fiche-value"><?=$DATA['souscripteur_adresse']?>&nbsp;<?=$DATA['souscripteur_code_postal']?>&nbsp;<?=$DATA['souscripteur_commune']?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Profession</span>
            <span class="fiche-value"><?=$DATA['souscripteur_profession']?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Téléphone</span>
            <span class="fiche-value"><?=$DATA['souscripteur_telephone']?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Email</span>
            <span class="fiche-value"><?=$DATA['souscripteur_email']?></span>
        </div>
    </fieldset>
</div>




