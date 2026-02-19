// Gère dynamiquement l'attribut required sur les champs adresse/code postal sol
function updateSolRequiredFields() {
    var solForm = document.getElementById('sol_form');
    var adresse = document.getElementById('sol_entreprise_adresse');
    var cp = document.getElementById('sol_entreprise_code_postal');
    if (solForm && adresse && cp) {
        if (!solForm.classList.contains('hidden')) {
            adresse.setAttribute('required', 'required');
            cp.setAttribute('required', 'required');
        } else {
            adresse.removeAttribute('required');
            cp.removeAttribute('required');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var solToggle = document.getElementById('toggle_sol');
    if (solToggle) {
        solToggle.addEventListener('change', updateSolRequiredFields);
    }
    // Appel initial au chargement
    updateSolRequiredFields();
});
// JS pour les toggles oui/non de s04-informations-diverses
// À inclure dans la page via <script src="/public/script/s04-informations-diverses.js"></script>

document.addEventListener('DOMContentLoaded', function () {
    // Initialisation automatique de tous les toggles Oui/Non
    const toggles = [
        {toggle: 'toggle_zone_inond', span: 'zone_inond_value', radioOui: 'radio_zone_inond_oui', radioNon: 'radio_zone_inond_non'},
        {toggle: 'toggle_insectes', span: 'insectes_value', radioOui: 'radio_insectes_oui', radioNon: 'radio_insectes_non'},
        {toggle: 'toggle_proc_techniques', span: 'proc_techniques_value', radioOui: 'radio_proc_techniques_oui', radioNon: 'radio_proc_techniques_non'},
        {toggle: 'toggle_parking', span: 'parking_value', radioOui: 'radio_parking_oui', radioNon: 'radio_parking_non'},
        {toggle: 'toggle_do_10ans', span: 'do_10ans_value', radioOui: 'radio_do_10ans_oui', radioNon: 'radio_do_10ans_non'},
        {toggle: 'toggle_mon_hist', span: 'mon_hist_value', radioOui: 'radio_mon_hist_oui', radioNon: 'radio_mon_hist_non'},
        {toggle: 'toggle_label_energie', span: 'label_energie_value', radioOui: 'radio_label_energie_oui', radioNon: 'radio_label_energie_non'},
        {toggle: 'toggle_label_qualite', span: 'label_qualite_value', radioOui: 'radio_label_qualite_oui', radioNon: 'radio_label_qualite_non'},
        {toggle: 'toggle_sol_parking', span: 'sol_parking_value', radioOui: 'radio_sol_parking_oui', radioNon: 'radio_sol_parking_non'},
        {toggle: 'toggle_garanties_completes', span: 'garanties_completes_value', radioOui: 'radio_garanties_completes_oui', radioNon: 'radio_garanties_completes_non'},
        {toggle: 'toggle_garanties_dommages_existants', span: 'garanties_dommages_existants_value', radioOui: 'radio_garanties_dommages_existants_oui', radioNon: 'radio_garanties_dommages_existants_non'},
        {toggle: 'toggle_boi', span: 'boi_value', radioOui: 'radio_boi_oui', radioNon: 'radio_boi_non'},
        {toggle: 'toggle_phv', span: 'phv_value', radioOui: 'radio_phv_oui', radioNon: 'radio_phv_non'},
        {toggle: 'toggle_geo', span: 'geo_value', radioOui: 'radio_geo_oui', radioNon: 'radio_geo_non'},
        {toggle: 'toggle_ctt', span: 'ctt_value', radioOui: 'radio_ctt_oui', radioNon: 'radio_ctt_non'},
        {toggle: 'toggle_cnr', span: 'cnr_value', radioOui: 'radio_cnr_oui', radioNon: 'radio_cnr_non'},
    ];
    toggles.forEach(({toggle, span, radioOui, radioNon}) => {
        const cb = document.getElementById(toggle);
        if (cb) {
            handleToggleYN(cb, radioOui, radioNon, span);
        }
    });
});

