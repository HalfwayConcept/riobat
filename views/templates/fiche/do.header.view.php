
<h1 class="text-xl font-medium">Veuillez vérifier vos informations avant validation</h1>
<div class="">
    <!-- Informations souscripteur -->
    <fieldset class="grid md:gap-6 border-2 border-gray-400 p-4 m-6">
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
</div>
