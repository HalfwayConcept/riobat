<section class="mb-8 p-4 border-l-4 border-blue-500 bg-blue-50">
    <!-- Situation de l'ouvrage -->
    <h2 class="text-lg font-bold text-gray-900 mb-4">Situation de l'ouvrage <span class="text-red-600">*</span></h2>
    <form action="" method="post">
            <!-- Zone inondable -->
        <div class="flex flex-col lg:flex-row mt-4">
            <div class="lg:w-2/3">
                <span class="text-gray-500 font-medium">Est-il situé dans une zone inondable ?</span>
            </div>
            <div class="lg:w-1/3 flex justify-end">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_zone_inond" class="sr-only peer" onchange="handleToggleYN(this, 'radio_zone_inond_oui', 'radio_zone_inond_non', 'zone_inond_value')"
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_zone_inond']) && $_SESSION['info_situation']['situation_zone_inond']==1) ? "checked=checked" : ""; ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                    <span id="zone_inond_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_zone_inond'])) ? ($_SESSION['info_situation']['situation_zone_inond']==1 ? 'Oui' : 'Non') : 'Non' ?>
                    </span>
                </label>
                <input type="radio" name="situation_zone_inond" value="1" id="radio_zone_inond_oui" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_zone_inond']) && $_SESSION['info_situation']['situation_zone_inond']==1) ? "checked=checked" : ""; ?> />
                <input type="radio" name="situation_zone_inond" value="0" id="radio_zone_inond_non" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_zone_inond']) && $_SESSION['info_situation']['situation_zone_inond']==0) ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_zone_inond']) ? "checked=checked" : ""); ?> />
            </div>
        </div>
        <!-- Zone sismicité -->
        <div class="flex flex-row mt-4">
                <span class="text-gray-500 font-medium">Dans quelle zone de sismicité est-il situé ?</span>
        </div>
        <div class="w-full flex flex-row mt-4">
            <div class="w-full flex flex-col items-center" id="situation_sismique_options">
                <div class="flex flex-row justify-center gap-6 w-full">
                    <label class="flex flex-col items-center w-full text-center">
                        <input type="radio" name="situation_sismique" value="1" class="mb-1" <?= isset($_SESSION['info_situation']['situation_sismique']) && ($_SESSION['info_situation']['situation_sismique'])==1 ? "checked=checked" : ""; ?>/>
                        <span class="text-xs w-full text-center">1<br><span class="font-normal">(très faible)</span></span>
                    </label>
                    <label class="flex flex-col items-center w-full text-center">
                        <input type="radio" name="situation_sismique" value="2" class="mb-1" <?= isset($_SESSION['info_situation']['situation_sismique']) && ($_SESSION['info_situation']['situation_sismique'])==2 ? "checked=checked" : ""; ?>/>
                        <span class="text-xs w-full text-center">2<br><span class="font-normal">(faible)</span></span>
                    </label>
                    <label class="flex flex-col items-center w-full text-center">
                        <input type="radio" name="situation_sismique" value="3" class="mb-1" <?= isset($_SESSION['info_situation']['situation_sismique']) && ($_SESSION['info_situation']['situation_sismique'])==3 ? "checked=checked" : ""; ?>/>
                        <span class="text-xs w-full text-center">3<br><span class="font-normal">(modérée)</span></span>
                    </label>
                    <label class="flex flex-col items-center w-full text-center">
                        <input type="radio" name="situation_sismique" value="4" class="mb-1" <?= isset($_SESSION['info_situation']['situation_sismique']) && ($_SESSION['info_situation']['situation_sismique'])==4 ? "checked=checked" : ""; ?>/>
                        <span class="text-xs w-full text-center">4<br><span class="font-normal">(moyenne)</span></span>
                    </label>
                    <label class="flex flex-col items-center w-full text-center">
                        <input type="radio" name="situation_sismique" value="5" class="mb-1" <?= isset($_SESSION['info_situation']['situation_sismique']) && ($_SESSION['info_situation']['situation_sismique'])==5 ? "checked=checked" : ""; ?>/>
                        <span class="text-xs w-full text-center">5<br><span class="font-normal">(forte)</span></span>
                    </label>
                </div>
            </div>
        </div>
            <!-- Zone termites insectes -->
        <div class="flex flex-col lg:flex-row mt-4">
            <div class="lg:w-2/3">
                <span class="text-gray-500 font-medium">Est-il situé dans une zone contaminée par les termites ou autres insectes xylophages ?</span>
            </div>
            <div class="lg:w-1/3 flex justify-end">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_insectes" class="sr-only peer" onchange="handleToggleYN(this, 'radio_insectes_oui', 'radio_insectes_non', 'insectes_value')"
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_insectes']) && $_SESSION['info_situation']['situation_insectes']==1) ? "checked=checked" : ""; ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                    <span id="insectes_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_insectes'])) ? ($_SESSION['info_situation']['situation_insectes']==1 ? 'Oui' : 'Non') : 'Non' ?>
                    </span>
                </label>
                <input type="radio" name="situation_insectes" value="1" id="radio_insectes_oui" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_insectes']) && $_SESSION['info_situation']['situation_insectes']==1) ? "checked=checked" : ""; ?> />
                <input type="radio" name="situation_insectes" value="0" id="radio_insectes_non" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_insectes']) && $_SESSION['info_situation']['situation_insectes']==0) ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_insectes']) ? "checked=checked" : ""); ?> />
            </div>
        </div>
            <!-- Matériaux traditionnels ou technique courante -->
        <div class="flex flex-col lg:flex-row mt-4">
            <div class="lg:w-2/3">
                <span class="text-gray-500 font-medium">Les travaux sont-ils réalisés avec des matériaux traditionnels ou selon des procédés de technique courante ?</span>
            </div>
            <div class="lg:w-1/3 flex justify-end">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_proc_techniques" class="sr-only peer" onchange="handleToggleYN(this, 'radio_proc_techniques_oui', 'radio_proc_techniques_non', 'proc_techniques_value')"
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_proc_techniques']) && $_SESSION['info_situation']['situation_proc_techniques']==1) ? "checked=checked" : ""; ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                    <span id="proc_techniques_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_proc_techniques'])) ? ($_SESSION['info_situation']['situation_proc_techniques']==1 ? 'Oui' : 'Non') : 'Non' ?>
                    </span>
                </label>
                <input type="radio" name="situation_proc_techniques" value="1" id="radio_proc_techniques_oui" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_proc_techniques']) && $_SESSION['info_situation']['situation_proc_techniques']==1) ? "checked=checked" : ""; ?> />
                <input type="radio" name="situation_proc_techniques" value="0" id="radio_proc_techniques_non" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_proc_techniques']) && $_SESSION['info_situation']['situation_proc_techniques']==0) ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_proc_techniques']) ? "checked=checked" : ""); ?> />
            </div>
        </div>
            <!-- Parking -->
        <div class="flex flex-col lg:flex-row mt-4">
            <div class="lg:w-2/3">
                <span class="text-gray-500 font-medium">Y a-t-il la présence d'un parking (accessoire de l'ouvrage) desservant l'ouvrage ?</span>
            </div>
            <div class="lg:w-1/3 flex justify-end">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="toggle_parking" class="sr-only peer" onchange="handleToggleYN(this, 'radio_parking_oui', 'radio_parking_non', 'parking_value')"
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_parking']) && $_SESSION['info_situation']['situation_parking']==1) ? "checked=checked" : ""; ?> />
                    <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                    <span id="parking_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                        <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_parking'])) ? ($_SESSION['info_situation']['situation_parking']==1 ? 'Oui' : 'Non') : 'Non' ?>
                    </span>
                </label>
                <input type="radio" name="situation_parking" value="1" id="radio_parking_oui" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_parking']) && $_SESSION['info_situation']['situation_parking']==1) ? "checked=checked" : ""; ?> />
                <input type="radio" name="situation_parking" value="0" id="radio_parking_non" class="hidden" <?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_parking']) && $_SESSION['info_situation']['situation_parking']==0) ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_parking']) ? "checked=checked" : ""); ?> />
            </div>
        </div>
            <!-- Travaux sur existants -->
        <div class="mt-4">
            <h3 class="text-gray-500 font-medium">Si travaux sur une contruction existante ou sur existants :</h3>
                <div class="flex flex-col lg:flex-row my-4">
                    <div class="lg:w-2/3">
                        <span class="font-normal">Si les existants datent de moins de 10 ans, ont-ils fait l'objet d'un contrat d'assurance "dommages ouvrage" ?</span>
                    </div>
                    <div class="lg:w-1/3 flex justify-end">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_do_10ans" class="sr-only peer" onchange="handleToggleYN(this, 'radio_do_10ans_oui', 'radio_do_10ans_non', 'do_10ans_value'); if(this.checked){showElement('situation_do_10ans_contrat');}else{hideElement('situation_do_10ans_contrat');}"
                                <?= isset($_SESSION['info_situation']['situation_do_10ans']) && $_SESSION['info_situation']['situation_do_10ans']==1 ? "checked=checked" : ""; ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                            <span id="do_10ans_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                <?= isset($_SESSION['info_situation']['situation_do_10ans']) ? ($_SESSION['info_situation']['situation_do_10ans']==1 ? 'Oui' : 'Non') : 'Non' ?>
                            </span>
                        </label>
                        <input type="radio" name="situation_do_10ans" value="1" id="radio_do_10ans_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_do_10ans']) && $_SESSION['info_situation']['situation_do_10ans']==1 ? "checked=checked" : ""; ?> />
                        <input type="radio" name="situation_do_10ans" value="0" id="radio_do_10ans_non" class="hidden" <?= isset($_SESSION['info_situation']['situation_do_10ans']) && $_SESSION['info_situation']['situation_do_10ans']==0 ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_do_10ans']) ? "checked=checked" : ""); ?> />
                    </div>
                </div>
                    <div class="flex flex-col lg:flex-row my-4">
                        <div id="situation_do_10ans_contrat" class="w-full <?= isset($_SESSION['info_situation']['situation_do_10ans']) && ($_SESSION['info_situation']['situation_do_10ans'])==1 ? "" : "hidden"; ?> ml-10 mt-4 ">
                            <div class="flex flex-col lg:flex-row gap-4">
                                <div class="w-full lg:w-1/2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom de l'assureur :&ensp;&ensp;</label>
                                    <input type="text" name="situation_do_10ans_contrat_assureur" value="<?= isset($_SESSION['info_situation']['situation_do_10ans_contrat_assureur']) ? $_SESSION['info_situation']['situation_do_10ans_contrat_assureur'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                                </div>
                                <div class="w-full lg:w-1/2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">N° de contrat :&ensp;&ensp;</label>
                                    <input type="text" name="situation_do_10ans_contrat_numero" value="<?= isset($_SESSION['info_situation']['situation_do_10ans_contrat_numero']) ? $_SESSION['info_situation']['situation_do_10ans_contrat_numero'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col lg:flex-row mt-4">
                    <div class="lg:w-2/3">
                        <span class="font-normal">Les existants sont-ils classés monuments historiques ou font-ils l'objet d'une protection du patrimoine ?</span>
                    </div>
                    <div class="lg:w-1/3 flex justify-end">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggle_mon_hist" class="sr-only peer" onchange="handleToggleYN(this, 'radio_mon_hist_oui', 'radio_mon_hist_non', 'mon_hist_value')"
                                <?= isset($_SESSION['info_situation']['situation_mon_hist']) && $_SESSION['info_situation']['situation_mon_hist']==1 ? "checked=checked" : ""; ?> />
                            <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                            <span id="mon_hist_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                                <?= isset($_SESSION['info_situation']['situation_mon_hist']) ? ($_SESSION['info_situation']['situation_mon_hist']==1 ? 'Oui' : 'Non') : 'Non' ?>
                            </span>
                        </label>
                        <input type="radio" name="situation_mon_hist" value="1" id="radio_mon_hist_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_mon_hist']) && $_SESSION['info_situation']['situation_mon_hist']==1 ? "checked=checked" : ""; ?> />
                        <input type="radio" name="situation_mon_hist" value="0" id="radio_mon_hist_non" class="hidden" <?= isset($_SESSION['info_situation']['situation_mon_hist']) && $_SESSION['info_situation']['situation_mon_hist']==0 ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_mon_hist']) ? "checked=checked" : ""); ?> />
                    </div>
                </div>
        </div>
            <!-- Label -->
        <div class="mt-4">
            <h3 class="text-gray-500 font-medium">Label :</h3>
            <div class="flex flex-col lg:flex-row my-2">
                <div class="lg:w-2/3">
                    <span class="font-normal">L'opération de construction bénéficie-t-elle d'un label de performance énergétique (ex. BBC...) ?</span>
                </div>
                <div class="lg:w-1/3 flex justify-end">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_label_energie" class="sr-only peer" onchange="handleToggleYN(this, 'radio_label_energie_oui', 'radio_label_energie_non', 'label_energie_value')"
                            <?= isset($_SESSION['info_situation']['situation_label_energie']) && $_SESSION['info_situation']['situation_label_energie']==1 ? "checked=checked" : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="label_energie_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_label_energie']) ? ($_SESSION['info_situation']['situation_label_energie']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_label_energie" value="1" id="radio_label_energie_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_label_energie']) && $_SESSION['info_situation']['situation_label_energie']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_label_energie" value="0" id="radio_label_energie_non" class="hidden" <?= isset($_SESSION['info_situation']['situation_label_energie']) && $_SESSION['info_situation']['situation_label_energie']==0 ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_label_energie']) ? "checked=checked" : ""); ?> />
                </div>
            </div>
            <div class="flex flex-col lg:flex-row my-2">
                <div class="lg:w-2/3">
                    <span class="font-normal">L'opération de construction bénéficie-t-elle d'un label de qualité environnementale (ex. HQE...) ?</span>
                </div>
                <div class="lg:w-1/3 flex justify-end">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_label_qualite" class="sr-only peer" onchange="handleToggleYN(this, 'radio_label_qualite_oui', 'radio_label_qualite_non', 'label_qualite_value')"
                            <?= isset($_SESSION['info_situation']['situation_label_qualite']) && $_SESSION['info_situation']['situation_label_qualite']==1 ? "checked=checked" : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="label_qualite_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_label_qualite']) ? ($_SESSION['info_situation']['situation_label_qualite']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_label_qualite" value="1" id="radio_label_qualite_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_label_qualite']) && $_SESSION['info_situation']['situation_label_qualite']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_label_qualite" value="0" id="radio_label_qualite_non" class="hidden" <?= isset($_SESSION['info_situation']['situation_label_qualite']) && $_SESSION['info_situation']['situation_label_qualite']==0 ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_label_qualite']) ? "checked=checked" : ""); ?> />
                </div>
            </div>
        </div>
            <!-- Etude de sol -->
        <div class="mt-20">
            <h3 class="text-gray-500 font-medium">Etude de sol <span class="text-red-600">*</span></h3>
            <div class="flex flex-col lg:flex-row ml-10 mt-6 gap-4">
                <span class="font-normal flex-1">Intervention d'un bureau spécialisé ?</span>
                <div class="flex justify-end items-center">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_sol" value="0" class="sr-only peer" onchange="handleToggleYN(this, 'radio_sol_oui', 'radio_sol_non', 'sol_value'); if(this.checked){showElement('sol_form');}else{hideElement('sol_form');}"
                            <?= isset($_SESSION['info_situation']['situation_sol']) && $_SESSION['info_situation']['situation_sol']==1 ? "checked=checked" : ""; ?>  />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="sol_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_sol']) ? ($_SESSION['info_situation']['situation_sol']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_sol" value="1" id="radio_sol_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_sol']) && $_SESSION['info_situation']['situation_sol']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_sol" value="0" id="radio_sol_non" class="hidden" <?= isset($_SESSION['info_situation']['situation_sol']) && $_SESSION['info_situation']['situation_sol']==0 ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_sol']) ? "checked=checked" : ""); ?> />
                </div>
            </div>
            <div id="sol_form" class="<?= (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['situation_sol']) && $_SESSION['info_situation']['situation_sol']==1) ? "" : "hidden"; ?> px-8 py-4">
                <div>
                    <?php echo coordFormDisplay('sol', (isset($_SESSION['info_situation']) && isset($_SESSION['info_situation']['sol_entreprise_id'])) ? $_SESSION['info_situation']['sol_entreprise_id'] : null ); ?>
                </div>
                <div class="flex flex-col lg:flex-row ml-24 mt-2">
                    <span class="text-sm font-medium mt-2">Mission : &ensp;&ensp;</span>
                    <div class="flex flex-row ml-8 text-gray-500 font-medium mt-2">
                        <span>
                            <input type="radio" name="situation_sol_bureau_mission" value="g2_amp" <?= isset($_SESSION['info_situation']['situation_sol_bureau_mission']) && ($_SESSION['info_situation']['situation_sol_bureau_mission'])=="g2_amp" ? "checked=checked" : ""; ?> onclick="hideElement('situation_sol_bureau_mission_autre')"/> 
                            G2 AMP
                        </span>
                        <span class="ml-6">
                            <input type="radio" name="situation_sol_bureau_mission" value="g2_pro" <?= isset($_SESSION['info_situation']['situation_sol_bureau_mission']) && ($_SESSION['info_situation']['situation_sol_bureau_mission'])=="g2_pro" ? "checked=checked" : ""; ?> onclick="hideElement('situation_sol_bureau_mission_autre')"/> 
                            G2 Pro
                        </span>
                        <span class="ml-6">
                            <input type="radio" name="situation_sol_bureau_mission" value="etude_sol_autre" <?= isset($_SESSION['info_situation']['situation_sol_bureau_mission']) && ($_SESSION['info_situation']['situation_sol_bureau_mission'])=="etude_sol_autre" ? "checked=checked" : ""; ?> onclick="showElement('situation_sol_bureau_mission_autre')"/> 
                            Autre 
                        </span>
                    </div>
                    <div id="situation_sol_bureau_mission_autre" class="<?= isset($_SESSION['info_situation']['situation_sol_bureau_mission']) && ($_SESSION['info_situation']['situation_sol_bureau_mission'])=="etude_sol_autre" ? "" : "hidden"; ?> ml-4">
                        <input type="text" name="situation_sol_bureau_mission_champ" value="<?= isset($_SESSION['info_situation']['situation_sol_bureau_mission_champ']) ? $_SESSION['info_situation']['situation_sol_bureau_mission_champ'] : ''?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Veuillez précisez"/>
                    </div>    
                </div>
            </div>
            <div class="flex flex-col lg:flex-row mt-6">
                <div class="lg:w-2/3">
                    <span class="font-normal">Si présence d'un parking et/ou de voiries, l'étude de sol vise-t-elle également ces ouvrages ?</span>
                </div>
                <div class="lg:w-1/3 flex justify-end">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle_sol_parking" class="sr-only peer" onchange="handleToggleYN(this, 'radio_sol_parking_oui', 'radio_sol_parking_non', 'sol_parking_value')"
                            <?= isset($_SESSION['info_situation']['situation_sol_parking']) && $_SESSION['info_situation']['situation_sol_parking']==1 ? "checked=checked" : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="sol_parking_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_sol_parking']) ? ($_SESSION['info_situation']['situation_sol_parking']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_sol_parking" value="1" id="radio_sol_parking_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_sol_parking']) && $_SESSION['info_situation']['situation_sol_parking']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_sol_parking" value="0" id="radio_sol_parking_non" class="hidden" <?= isset($_SESSION['info_situation']['situation_sol_parking']) && $_SESSION['info_situation']['situation_sol_parking']==0 ? "checked=checked" : (!isset($_SESSION['info_situation']['situation_sol_parking']) ? "checked=checked" : ""); ?> />
                </div>
            </div>
        </div>
        <!-- Section Garanties demandées supprimée à la demande -->
        <!-- Travaux annexes -->
        <div class="flex-column mt-4">
            <span class="text-gray-500 font-medium">Travaux annexes :</span>
            <div class="ml-10 mt-2">
                <div class="flex justify-end items-center">
                    <span class="font-normal text-left flex-1">S'agit-il d'une construction en bois ?</span>
                    <label class="inline-flex items-center cursor-pointer justify-end">
                        <input type="checkbox" id="toggle_boi" class="sr-only peer" onchange="handleToggleYN(this, 'radio_boi_oui', 'radio_boi_non', 'boi_value')"
                            <?= isset($_SESSION['info_situation']['situation_boi']) ? ($_SESSION['info_situation']['situation_boi']==1 ? "checked=checked" : "") : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="boi_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_boi']) ? ($_SESSION['info_situation']['situation_boi']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_boi" value="1" id="radio_boi_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_boi']) && $_SESSION['info_situation']['situation_boi']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_boi" value="0" id="radio_boi_non" class="hidden" <?= (isset($_SESSION['info_situation']['situation_boi']) && $_SESSION['info_situation']['situation_boi']==0) || !isset($_SESSION['info_situation']['situation_boi']) ? "checked=checked" : ""; ?> />
                </span>
            </div>
            <div class="mt-2">
                <div class="flex justify-end items-center">
                    <span class="font-normal text-left flex-1">Y a-t-il la présence de panneaux photovoltaïques ?</span>
                    <label class="inline-flex items-center cursor-pointer justify-end">
                        <input type="checkbox" id="toggle_phv" class="sr-only peer" onchange="handleToggleYN(this, 'radio_phv_oui', 'radio_phv_non', 'phv_value')"
                            <?= isset($_SESSION['info_situation']['situation_phv']) ? ($_SESSION['info_situation']['situation_phv']==1 ? "checked=checked" : "") : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="phv_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_phv']) ? ($_SESSION['info_situation']['situation_phv']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_phv" value="1" id="radio_phv_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_phv']) && $_SESSION['info_situation']['situation_phv']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_phv" value="0" id="radio_phv_non" class="hidden" <?= (isset($_SESSION['info_situation']['situation_phv']) && $_SESSION['info_situation']['situation_phv']==0) || !isset($_SESSION['info_situation']['situation_phv']) ? "checked=checked" : ""; ?> />
                </div>
            </div>
            <div class="mt-2">
                <div class="flex justify-end items-center">
                    <span class="font-normal text-left flex-1">L'opération de construction bénéficie-t-elle d'une installation géothermique ?</span>
                    <label class="inline-flex items-center cursor-pointer justify-end">
                        <input type="checkbox" id="toggle_geo" class="sr-only peer" onchange="handleToggleYN(this, 'radio_geo_oui', 'radio_geo_non', 'geo_value')"
                            <?= isset($_SESSION['info_situation']['situation_geo']) ? ($_SESSION['info_situation']['situation_geo']==1 ? "checked=checked" : "") : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="geo_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_geo']) ? ($_SESSION['info_situation']['situation_geo']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_geo" value="1" id="radio_geo_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_geo']) && $_SESSION['info_situation']['situation_geo']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_geo" value="0" id="radio_geo_non" class="hidden" <?= (isset($_SESSION['info_situation']['situation_geo']) && $_SESSION['info_situation']['situation_geo']==0) || !isset($_SESSION['info_situation']['situation_geo']) ? "checked=checked" : ""; ?> />
                </div>
            </div>
            <div class="mt-2">
                <div class="flex justify-end items-center">
                    <span class="font-normal text-left flex-1">Y a-t-il intervention d'un contrôleur technique ?</span>
                    <label class="inline-flex items-center cursor-pointer justify-end">
                        <input type="checkbox" id="toggle_ctt" class="sr-only peer" onchange="handleToggleYN(this, 'radio_ctt_oui', 'radio_ctt_non', 'ctt_value')"
                            <?= isset($_SESSION['info_situation']['situation_ctt']) ? ($_SESSION['info_situation']['situation_ctt']==1 ? "checked=checked" : "") : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="ctt_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_ctt']) ? ($_SESSION['info_situation']['situation_ctt']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_ctt" value="1" id="radio_ctt_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_ctt']) && $_SESSION['info_situation']['situation_ctt']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_ctt" value="0" id="radio_ctt_non" class="hidden" <?= (isset($_SESSION['info_situation']['situation_ctt']) && $_SESSION['info_situation']['situation_ctt']==0) || !isset($_SESSION['info_situation']['situation_ctt']) ? "checked=checked" : ""; ?> />
                </div>
            </div>
            <div class="mt-2">
                <div class="flex justify-end items-center">
                    <span class="font-normal text-left flex-1">Y a-t-il désignation d'un Constructeur Non Réalisateur ?</span>
                    <label class="inline-flex items-center cursor-pointer justify-end">
                        <input type="checkbox" id="toggle_cnr" class="sr-only peer" onchange="handleToggleYN(this, 'radio_cnr_oui', 'radio_cnr_non', 'cnr_value')"
                            <?= isset($_SESSION['info_situation']['situation_cnr']) ? ($_SESSION['info_situation']['situation_cnr']==1 ? "checked=checked" : "") : ""; ?> />
                        <div class="relative w-9 h-5 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-300 rounded-full peer peer-checked:bg-green-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-buffer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:peer-focus:ring-4 peer-checked:peer-focus:ring-green-300"></div>
                        <span id="cnr_value" class="select-none ms-3 text-sm font-medium text-gray-900">
                            <?= isset($_SESSION['info_situation']['situation_cnr']) ? ($_SESSION['info_situation']['situation_cnr']==1 ? 'Oui' : 'Non') : 'Non' ?>
                        </span>
                    </label>
                    <input type="radio" name="situation_cnr" value="1" id="radio_cnr_oui" class="hidden" <?= isset($_SESSION['info_situation']['situation_cnr']) && $_SESSION['info_situation']['situation_cnr']==1 ? "checked=checked" : ""; ?> />
                    <input type="radio" name="situation_cnr" value="0" id="radio_cnr_non" class="hidden" <?= (isset($_SESSION['info_situation']['situation_cnr']) && $_SESSION['info_situation']['situation_cnr']==0) || !isset($_SESSION['info_situation']['situation_cnr']) ? "checked=checked" : ""; ?> />
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center mt-4">
            <!-- Bouton précédent -->                                          
            <div class="flex space-y-4 justify-center sm:space-y-0 mr-6">
                <button type="submit" name="page_next" value="step2" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Précédent</button>
            </div>
            <!-- Bouton suivant -->
            <div class="text-center ml-6">
                <button type="submit" name="page_next" value="step4" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-32 px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Suivant</button>
            </div>
        </div>

        <input type="hidden" name="fields" value="situation">

        <!-- SECTION: Etude de sol (step4) supprimée à la demande -->
    </form>
</section>
