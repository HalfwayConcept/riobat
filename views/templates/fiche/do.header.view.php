
<h1 class="text-xl font-medium"><?=$title;?></h1>
<div class="grid md:grid-cols-2 grid-cols-1 gap-4">
    <!-- Informations souscripteur -->
    <fieldset class="md:gap-6 border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Dommage ouvrage</legend>
        <div class="flex flex-row">
            <h3>Numéro de dossier</h3>
            <strong class="pl-4"><?=$DATA['DOID']?></strong>
        </div>
        <div class="flex flex-row">
            <h3>Date de création</h3>
            <strong class="pl-4"><?=dateFormat($DATA['date_creation'])?></strong>
        </div>
    </fieldset>
    <!-- Informations souscripteur -->
    <fieldset class=" border-2 border-gray-400 p-4 m-6">
        <legend class="mx-2 p-2 text-xl font-medium">Date des travaux</legend>
        <div class="grid grid-cols-3 ">
            <div class="col-span-2"><h3>Date d'ouverture de chantier</h3></div>
            <div class="col-span-1 text-right"><strong class="pl-4"><?=$DATA['construction_date_debut']?></strong></div>
        </div>
        <div class="grid grid-cols-3 ">
            <div class="col-span-2"><h3>Date prévue d'ouverture de chantier</h3></div>
            <div class="col-span-1 text-right"><strong class="pl-4"><?=$DATA['construction_date_reception']?></strong></div>
        </div>
        <div class="grid grid-cols-3 ">
            <div class="col-span-2"><h3>Date de réception prévisionnelle</h3></div>
            <div class="col-span-1 text-right"><strong class="pl-4"><?=$DATA['construction_date_reception']?></strong></div>
        </div>                
    </fieldset>    
</div>
