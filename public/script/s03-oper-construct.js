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

// Fonctions utilitaires
// Affiche un élément par son id
function showElement(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('hidden');
}
// Masque un élément par son id
function hideElement(id) {
    const el = document.getElementById(id);
    if (el) el.classList.add('hidden');
}
