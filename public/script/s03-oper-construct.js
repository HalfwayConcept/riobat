// Autocomplétion d'adresse pour step3
function fillAdresseFieldsFromSelection(feature) {
    if (feature && feature.properties) {
        document.querySelector('input[name="construction_adresse"]').value = feature.properties.name || feature.properties.label || '';
        document.querySelector('input[name="construction_adresse_code_postal"]').value = feature.properties.postcode || '';
        document.querySelector('input[name="construction_adresse_commune"]').value = feature.properties.city || '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('search_construction_adresse');
    var ul = document.getElementById('search_construction_adresse_suggestions');
    let timeoutAdresse;
    if (!input || !ul) return;
    input.addEventListener('input', function() {
        const query = input.value;
        clearTimeout(timeoutAdresse);
        if (query.length < 3) {
            ul.classList.add('hidden');
            return;
        }
        timeoutAdresse = setTimeout(() => {
            fetch('https://api-adresse.data.gouv.fr/search/?q=' + encodeURIComponent(query) + '&limit=7')
                .then(response => response.json())
                .then(data => {
                    ul.innerHTML = '';
                    if (!data.features || data.features.length === 0) {
                        ul.classList.add('hidden');
                        return;
                    }
                    data.features.forEach(feature => {
                        const li = document.createElement('li');
                        li.textContent = feature.properties.label;
                        li.className = 'px-4 py-2 cursor-pointer hover:bg-blue-100';
                        li.onclick = function() {
                            input.value = feature.properties.label;
                            ul.classList.add('hidden');
                            fillAdresseFieldsFromSelection(feature);
                        };
                        ul.appendChild(li);
                    });
                    ul.classList.remove('hidden');
                });
        }, 300);
    });
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !ul.contains(e.target)) {
            ul.classList.add('hidden');
        }
    });
});
// Fonction générique pour les toggles Oui/Non avec label coloré
function handleToggleYN(checkbox, spanId) {
    const spanValue = document.getElementById(spanId);
    if (!spanValue) return;
    if (checkbox.checked) {
        spanValue.textContent = 'Oui';
        spanValue.classList.remove('text-red-500');
        spanValue.classList.add('text-green-600');
    } else {
        spanValue.textContent = 'Non';
        spanValue.classList.remove('text-green-600');
        spanValue.classList.add('text-red-500');
    }
}
// JS extrait de s03-oper-construct.view.php


// Gère le toggle entre "Construction neuve" et "Travaux sur construction existante"
// Affiche ou masque la section des travaux existants
function handleToggleNatureNeufExist(checkbox) {
    const radioNeuve = document.getElementById('radio_nature_neuve');
    const radioExistante = document.getElementById('radio_nature_existante');
    if (checkbox.checked) {
        radioExistante.checked = true;
        showElement('nature_operation');
    } else {
        radioNeuve.checked = true;
        hideElement('nature_operation');
    }
}

// Gère le toggle pour la surélévation
// Affiche ou masque le formulaire de surélévation
function handleToggleSurelev(checkbox) {
    const radioOui = document.getElementById('radio_surelev_oui');
    const radioNon = document.getElementById('radio_surelev_non');
    const spanValue = document.getElementById('surelev_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        showElement('nature_operation_surelev_form');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        hideElement('nature_operation_surelev_form');
    }
}

// Gère le toggle pour la reprise en sous-oeuvre
function handleToggleSousOeuvre(checkbox) {
    const radioOui = document.getElementById('radio_sous_oeuvre_oui');
    const radioNon = document.getElementById('radio_sous_oeuvre_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'sous_oeuvre_value');
}

// Gère le toggle pour l'intervention sur la structure existante (hors fondation)
function handleToggleHorsFond(checkbox) {
    const radioOui = document.getElementById('radio_hors_fond_oui');
    const radioNon = document.getElementById('radio_hors_fond_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'hors_fond_value');
}

// Gère le toggle pour l'extension horizontale
// Affiche ou masque le formulaire d'extension
function handleToggleExtHorizont(checkbox) {
    const radioOui = document.getElementById('radio_ext_horizont_oui');
    const radioNon = document.getElementById('radio_ext_horizont_non');
    const spanValue = document.getElementById('ext_horizont_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        showElement('nature_operation_ext_horizont');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        hideElement('nature_operation_ext_horizont');
    }
}

// Gère le toggle pour la rénovation
// Affiche ou masque le formulaire de rénovation
function handleToggleRenovation(checkbox) {
    const radioOui = document.getElementById('radio_renovation_oui');
    const radioNon = document.getElementById('radio_renovation_non');
    const spanValue = document.getElementById('renovation_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        showElement('nature_operation_renovation');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        hideElement('nature_operation_renovation');
    }
}

// Gère le toggle pour l'intervention sur la structure existante (fondation) en rénovation
function handleToggleRenovationFond(checkbox) {
    const radioOui = document.getElementById('radio_renovation_fond_oui');
    const radioNon = document.getElementById('radio_renovation_fond_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'renovation_fond_value');
}

// Gère le toggle pour l'isolation thermique extérieure en rénovation
function handleToggleRenovationIsoTherm(checkbox) {
    const radioOui = document.getElementById('radio_renovation_iso_therm_oui');
    const radioNon = document.getElementById('radio_renovation_iso_therm_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'renovation_iso_therm_value');
}

// Gère le toggle pour la réfection de toiture en rénovation
function handleToggleRenovationRefectToit(checkbox) {
    const radioOui = document.getElementById('radio_renovation_refect_toit_oui');
    const radioNon = document.getElementById('radio_renovation_refect_toit_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'renovation_refect_toit_value');
}

// Gère le toggle pour les travaux d'étanchéité en rénovation
function handleToggleRenovationEtancheite(checkbox) {
    const radioOui = document.getElementById('radio_renovation_etancheite_oui');
    const radioNon = document.getElementById('radio_renovation_etancheite_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'renovation_etancheite_value');
}

// Gère le toggle pour le ravalement de façade en rénovation
function handleToggleRenovationRavalement(checkbox) {
    const radioOui = document.getElementById('radio_renovation_ravalement_oui');
    const radioNon = document.getElementById('radio_renovation_ravalement_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'renovation_ravalement_value');
}

// Gère le toggle pour la réhabilitation
// Affiche ou masque le formulaire de réhabilitation
function handleToggleRehabilitation(checkbox) {
    const radioOui = document.getElementById('radio_rehabilitation_oui');
    const radioNon = document.getElementById('radio_rehabilitation_non');
    const spanValue = document.getElementById('rehabilitation_value');
    const bloc = document.getElementById('nature_operation_rehabilitation');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        if (bloc) bloc.classList.remove('hidden');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        if (bloc) bloc.classList.add('hidden');
    }
}

// Gère le toggle pour l'intervention sur la structure existante (fondation) en réhabilitation
function handleToggleRehabilitationFond(checkbox) {
    const radioOui = document.getElementById('radio_rehabilitation_fond_oui');
    const radioNon = document.getElementById('radio_rehabilitation_fond_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'rehabilitation_fond_value');
}

// Gère le toggle pour l'isolation thermique extérieure en réhabilitation
function handleToggleRehabIsoTherm(checkbox) {
    const radioOui = document.getElementById('radio_rehab_iso_therm_oui');
    const radioNon = document.getElementById('radio_rehab_iso_therm_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'rehab_iso_therm_value');
}

// Gère le toggle pour la réfection de toiture en réhabilitation
function handleToggleRehabRefectToit(checkbox) {
    const radioOui = document.getElementById('radio_rehab_refect_toit_oui');
    const radioNon = document.getElementById('radio_rehab_refect_toit_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'rehab_refect_toit_value');
}

// Gère le toggle pour les travaux d'étanchéité en réhabilitation
function handleToggleRehabEtancheite(checkbox) {
    const radioOui = document.getElementById('radio_rehab_etancheite_oui');
    const radioNon = document.getElementById('radio_rehab_etancheite_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'rehab_etancheite_value');
}

// Gère le toggle pour le ravalement de façade en réhabilitation
function handleToggleRehabRavalement(checkbox) {
    const radioOui = document.getElementById('radio_rehab_ravalement_oui');
    const radioNon = document.getElementById('radio_rehab_ravalement_non');
    if (checkbox.checked) {
        radioOui.checked = true;
    } else {
        radioNon.checked = true;
    }
    handleToggleYN(checkbox, 'rehab_ravalement_value');
}

// Gère le toggle pour la question sinistre
// Affiche ou masque le champ de description du sinistre
function handleToggleSinistre(checkbox) {
    const radioOui = document.getElementById('radio_sinistre_oui');
    const radioNon = document.getElementById('radio_sinistre_non');
    const bloc = document.getElementById('operation_sinistre_champ_descr');
    if (checkbox.checked) {
        radioOui.checked = true;
        if (bloc) bloc.classList.remove('hidden');
    } else {
        radioNon.checked = true;
        if (bloc) bloc.classList.add('hidden');
    }
}

// Gère le toggle pour la piscine
// Affiche ou masque le bloc "situation_piscine"
function handleTogglePiscine(checkbox) {
    const radioOui = document.getElementById('radio_piscine_oui');
    const radioNon = document.getElementById('radio_piscine_non');
    const spanValue = document.getElementById('piscine_value');
    const bloc = document.getElementById('situation_piscine');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        if (bloc) bloc.classList.remove('hidden');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        if (bloc) bloc.classList.add('hidden');
    }
}

// Gère le toggle pour l'existence dans l'extension horizontale
function handleToggleExtHorizontExist(checkbox) {
    const radioOui = document.getElementById('radio_ext_horizont_exist_oui');
    const radioNon = document.getElementById('radio_ext_horizont_exist_non');
    const spanValue = document.getElementById('ext_horizont_exist_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
    }
}

// Gère le toggle pour la TVA
function handleToggleTva(checkbox) {
    const radioOui = document.getElementById('radio_tva_oui');
    const radioNon = document.getElementById('radio_tva_non');
    const spanValue = document.getElementById('tva_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        if (spanValue) spanValue.textContent = 'Oui';
    } else {
        radioNon.checked = true;
        if (spanValue) spanValue.textContent = 'Non';
    }
}

// Initialisation dynamique des blocs dépendants des toggles au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Autocomplétion adresse
    if (typeof adresseAutocomplete === 'function') {
        adresseAutocomplete('construction_adresse_autocomplete', 'suggestions_construction_adresse');
    }
    // Nature de l'opération
    var toggleNature = document.getElementById('toggle_nature_neuf_exist');
    if (toggleNature && typeof handleToggleNatureNeufExist === 'function') {
        handleToggleNatureNeufExist(toggleNature);
    }
    // Surélévation
    var toggleSurelev = document.getElementById('toggle_surelev');
    if (toggleSurelev && typeof handleToggleSurelev === 'function') {
        handleToggleSurelev(toggleSurelev);
    }
    // Extension horizontale
    var toggleExtHorizont = document.getElementById('toggle_ext_horizont');
    if (toggleExtHorizont && typeof handleToggleExtHorizont === 'function') {
        handleToggleExtHorizont(toggleExtHorizont);
    }
    // Rénovation
    var toggleRenovation = document.getElementById('toggle_renovation');
    if (toggleRenovation && typeof handleToggleRenovation === 'function') {
        handleToggleRenovation(toggleRenovation);
    }
    // Réhabilitation
    var toggleRehabilitation = document.getElementById('toggle_rehabilitation');
    if (toggleRehabilitation && typeof handleToggleRehabilitation === 'function') {
        handleToggleRehabilitation(toggleRehabilitation);
    }
    // Sinistre
    var toggleSinistre = document.getElementById('toggle_operation_sinistre');
    if (toggleSinistre && typeof handleToggleSinistre === 'function') {
        handleToggleSinistre(toggleSinistre);
    }
    // Piscine
    var togglePiscine = document.getElementById('toggle_piscine');
    if (togglePiscine && typeof handleTogglePiscine === 'function') {
        handleTogglePiscine(togglePiscine);
    }
});
