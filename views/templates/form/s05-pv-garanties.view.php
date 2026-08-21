<?php
$info = $_SESSION['info_dommage_ouvrage'] ?? [];
?>
<section class="mb-8 p-4 border-l-4 border-amber-500 bg-amber-50 dark:bg-gray-800 dark:border-amber-400">
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
            </svg>
            <h1 class="text-2xl font-extrabold text-amber-800 dark:text-amber-300">CENTRALE PHOTOVOLTAIQUE &gt; Garanties</h1>
        </div>
        <hr class="border-amber-200 mb-4">
    </div>

    <?php if (!empty($_SESSION['validation_errors'])): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <h4 class="font-bold mb-2">Erreurs de validation :</h4>
            <ul class="list-disc list-inside">
                <?php foreach ($_SESSION['validation_errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['validation_errors']); ?>
    <?php endif; ?>

    <form action="" method="post" class="space-y-6">
        <div>
            <h3 class="text-gray-700 font-semibold">Garanties demandées <span class="text-red-600">*</span></h3>

            <div class="mx-2 mt-4 flex justify-end items-center gap-4">
                <span class="font-normal text-left flex-1">Dommages</span>
                <div class="flex gap-4 items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="garantie_do" value="1" <?= (($info['garantie_do'] ?? '') === '1' || ($info['garantie_do'] ?? 0) == 1) ? 'checked' : '' ?> />
                        <span class="ml-1">Oui</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="garantie_do" value="0" <?= (($info['garantie_do'] ?? '') === '0' || (!isset($info['garantie_do']))) ? 'checked' : '' ?> />
                        <span class="ml-1">Non</span>
                    </label>
                </div>
            </div>

            <div class="mx-2 mt-4 flex justify-end items-center gap-4">
                <span class="font-normal text-left flex-1">Pertes financières</span>
                <div class="flex gap-4 items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="garantie_chantier" value="1" <?= (($info['garantie_chantier'] ?? '') === '1' || ($info['garantie_chantier'] ?? 0) == 1) ? 'checked' : '' ?> />
                        <span class="ml-1">Oui</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="garantie_chantier" value="0" <?= (($info['garantie_chantier'] ?? '') === '0' || (!isset($info['garantie_chantier']))) ? 'checked' : '' ?> />
                        <span class="ml-1">Non</span>
                    </label>
                </div>
            </div>

            <div class="mx-2 mt-4 flex justify-end items-center gap-4">
                <span class="font-normal text-left flex-1">Responsabilité civile</span>
                <div class="flex gap-4 items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="garantie_juridique" value="1" <?= (($info['garantie_juridique'] ?? '') === '1' || ($info['garantie_juridique'] ?? 0) == 1) ? 'checked' : '' ?> />
                        <span class="ml-1">Oui</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="garantie_juridique" value="0" <?= (($info['garantie_juridique'] ?? '') === '0' || (!isset($info['garantie_juridique']))) ? 'checked' : '' ?> />
                        <span class="ml-1">Non</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center mt-10">
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step4ter" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Precedent</button>
            </div>
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="validation" class="text-white bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="dommage_ouvrage">
        <input type="hidden" name="garantie_cnr" value="0">
        <input type="hidden" name="doid" value="<?= isset($_SESSION['DOID']) ? (int)$_SESSION['DOID'] : '' ?>">
    </form>
</section>
