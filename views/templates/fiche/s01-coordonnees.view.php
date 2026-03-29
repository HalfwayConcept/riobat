
<div>
    <div class="fiche-title">
        <span class="fiche-title-num">1</span>
        <h2>Souscripteur<?php if(isset($DATA['moa_souscripteur']) && $DATA['moa_souscripteur'] == 1): ?> <span style="font-weight:400; color:#64748b; font-size:0.85rem;">(Le maître d'ouvrage est le souscripteur)</span><?php endif; ?></h2>
    </div>
    <hr class="fiche-hr">
    <div class="grid md:grid-cols-2 grid-cols-1 gap-4 items-start">
    <div>
    <fieldset class="fiche-fieldset">
        <legend>Coordonnées</legend>
        <div class="fiche-row">
            <span class="fiche-label">Nom, Prénom et/ou Raison Sociale</span>
            <span class="fiche-value"><?=$DATA['souscripteur_nom_raison'] ?? ''?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Siret n°</span>
            <span class="fiche-value"><?=$DATA['souscripteur_siret'] ?? ''?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Profession</span>
            <span class="fiche-value"><?=$DATA['souscripteur_profession'] ?? ''?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Téléphone</span>
            <span class="fiche-value"><?=$DATA['souscripteur_telephone'] ?? ''?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Email</span>
            <span class="fiche-value"><?=$DATA['souscripteur_email'] ?? ''?></span>
        </div>
    </fieldset>
    </div>
    <div>
    <fieldset class="fiche-fieldset">
        <legend>Adresse</legend>
        <div class="fiche-row">
            <span class="fiche-label">Adresse</span>
            <span class="fiche-value"><?=$DATA['souscripteur_adresse'] ?? ''?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Code postal</span>
            <span class="fiche-value"><?=$DATA['souscripteur_code_postal'] ?? ''?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">Commune</span>
            <span class="fiche-value"><?=$DATA['souscripteur_commune'] ?? ''?></span>
        </div>
    </fieldset>
    <?php if (!empty($DATA['souscripteur_ancien_client_date']) || !empty($DATA['souscripteur_ancien_client_num'])): ?>
    <fieldset class="fiche-fieldset">
        <legend>Ancien assuré MMA</legend>
        <div class="fiche-row">
            <span class="fiche-label">Date de souscription</span>
            <span class="fiche-value"><?= !empty($DATA['souscripteur_ancien_client_date']) ? dateFormat($DATA['souscripteur_ancien_client_date']) : '' ?></span>
        </div>
        <div class="fiche-row">
            <span class="fiche-label">N° assuré</span>
            <span class="fiche-value"><?= htmlspecialchars($DATA['souscripteur_ancien_client_num'] ?? '') ?></span>
        </div>
    </fieldset>
    <?php endif; ?>
    </div>
    </div>
</div>




