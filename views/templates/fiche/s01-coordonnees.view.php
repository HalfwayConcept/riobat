
<div>
    <!-- Informations souscripteur -->
    <div class="flex items-center gap-3 mb-2 mt-6">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8" />
        </svg>
        <h2 class="text-xl font-bold text-gray-800">Soucripteur</h2>
    </div>
    <hr class="mb-4 border-blue-200">
    <fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Coordonnées</legend>
        <div class="flex flex-row">
            <h3>Nom</h3><strong class="pl-4"><?=$DATA['souscripteur_nom_raison']?></strong>
        </div>         
        <div class="flex flex-row">
            <h3>Siret n°</h3><strong class="pl-4"><?=$DATA['souscripteur_siret']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Adresse</h3>
            <strong class="pl-4"><?=$DATA['souscripteur_adresse']?>&nbsp;<?=$DATA['souscripteur_code_postal']?>&nbsp;<?=$DATA['souscripteur_commune']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Profession</h3>
            <strong class="pl-4"><?=$DATA['souscripteur_profession']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Téléphone</h3>
            <strong class="pl-4"><?=$DATA['souscripteur_telephone']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Email</h3>
            <strong class="pl-4"><?=$DATA['souscripteur_email']?></strong>
        </div>
    </fieldset>
</div>









