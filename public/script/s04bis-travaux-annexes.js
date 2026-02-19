// s04bis-travaux-annexes.js
// Toggle logic for step4bis (travaux annexes)
document.addEventListener('DOMContentLoaded', function () {
    // For all toggles with .peer and .toggle-label
    document.querySelectorAll('input[type="checkbox"].peer').forEach(function (toggle) {
        const label = toggle.closest('label').querySelector('.toggle-label .toggle-text');
        function updateLabel() {
            if (toggle.checked) {
                label.textContent = 'Oui';
                label.classList.remove('text-red-500');
                label.classList.add('text-green-600');
            } else {
                label.textContent = 'Non';
                label.classList.remove('text-green-600');
                label.classList.add('text-red-500');
            }
        }
        toggle.addEventListener('change', updateLabel);
        updateLabel();
    });

    // Toggle for destination (revente/autocons)
    const destToggle = document.querySelector('input[name="trav_annexes_pv_destination"]');
    if (destToggle) {
        const destLabel = document.getElementById('pv-destination-label');
        const infoIcon = document.getElementById('pv-destination-info');
        function updateDestLabel() {
            if (destToggle.checked) {
                destLabel.textContent = 'Revente';
                destLabel.classList.remove('text-red-500');
                destLabel.classList.add('text-green-600');
                infoIcon.title = 'Un contrat de production a été souscrit avec un opérateur dans le domaine de l\'énergie';
            } else {
                destLabel.textContent = 'Autoconsommation';
                destLabel.classList.remove('text-green-600');
                destLabel.classList.add('text-red-500');
                infoIcon.title = '';
            }
        }
        destToggle.addEventListener('change', updateDestLabel);
        updateDestLabel();
    }
});
