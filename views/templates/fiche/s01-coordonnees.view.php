
<div>
    <!-- Informations souscripteur -->
    <fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Soucripteur</legend>
        <div class="flex flex-row">
            <h3>Nom, Prénom et/ou Raison Sociale <span class="text-red-600">*</span></h3>
            <strong class="pl-4"><?=$DATA['souscripteur_nom_raison']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Siret n°</h3>
            <strong class="pl-4"><?=$DATA['souscripteur_siret']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Adresse <span class="text-red-600">*</span></h3>
            <strong class="pl-4"><?=$DATA['souscripteur_adresse']?>&nbsp;<?=$DATA['souscripteur_code_postal']?>&nbsp;<?=$DATA['souscripteur_commune']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Profession</h3>
            <strong class="pl-4"><?=$DATA['souscripteur_profession']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Téléphone <span class="text-red-600">*</span></h3>
            <strong class="pl-4"><?=$DATA['souscripteur_telephone']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Email <span class="text-red-600">*</span></h3>
            <strong class="pl-4"><?=$DATA['souscripteur_email']?></strong>
        </div>
    </fieldset>
</div>








