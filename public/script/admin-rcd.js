// admin-rcd.js
// Gestion dynamique des lots techniques RCD

function deleteRow(row) {
    var i = row.parentNode.parentNode.rowIndex;
    document.getElementById('lotsTechniquesTable').deleteRow(i);
}

function insRow() {
    var tablevierge = document.getElementById('lotsTechniquesTableVierge');
    var new_row = tablevierge.rows[0].cloneNode(true);
    // Mark as new row for validation
    new_row.classList.add('new-lot-row');
    var tablelt = document.getElementById('lotsTechniquesTable');
    var tbody = tablelt.querySelector('tbody');
    tbody.appendChild(new_row);
    new_row.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('form-rcd');
    if (!form) return;
    var formModified = false;

    form.addEventListener('input', function() {
        formModified = true;
    });

    window.onbeforeunload = function(e) {
        if (formModified) {
            var confirmationMessage = "Vous avez des modifications non enregistrées. Voulez-vous vraiment quitter la page ?";
            e.returnValue = confirmationMessage;
            return confirmationMessage;
        }
    };

    // Custom validation on submit (replaces browser HTML5 validation)
    form.addEventListener('submit', function(e) {
        // Clear previous error highlights
        form.querySelectorAll('.validation-error').forEach(function(el) {
            el.classList.remove('validation-error', 'border-red-500', 'ring-2', 'ring-red-300');
        });
        var errors = [];
        // Validate all lot rows in the table
        var rows = document.querySelectorAll('#lotsTechniquesTable tbody tr');
        rows.forEach(function(row, idx) {
            var nomInput = row.querySelector('input[name="lot_nom[]"]');
            var natureSelect = row.querySelector('select[name="lot_nature[]"]');
            if (nomInput && nomInput.value.trim() === '') {
                nomInput.classList.add('validation-error', 'border-red-500', 'ring-2', 'ring-red-300');
                errors.push('Lot ' + (idx + 1) + ' : le nom est requis');
            }
            if (natureSelect && natureSelect.value === '' && !natureSelect.disabled) {
                natureSelect.classList.add('validation-error', 'border-red-500', 'ring-2', 'ring-red-300');
                errors.push('Lot ' + (idx + 1) + ' : la nature est requise');
            }
        });
        if (errors.length > 0) {
            e.preventDefault();
            alert('Veuillez corriger les erreurs suivantes :\n\n' + errors.join('\n'));
            // Scroll to first error
            var firstErr = form.querySelector('.validation-error');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        formModified = false;
    });
});

// Pending file status changes (batched)
var pendingStatusChanges = {};

function updateFileStatus(rcdId, field, status, doid) {
    var key = rcdId + '_' + field;
    pendingStatusChanges[key] = { rcd_id: rcdId, field: field, status: parseInt(status), doid: doid };

    // Visual feedback on the select
    var sel = event.target;
    sel.classList.add('ring-2', 'ring-orange-400', 'bg-orange-50');

    // Show/hide the save button
    var btn = document.getElementById('btn-save-statuses');
    if (btn) {
        btn.classList.remove('hidden');
        var count = Object.keys(pendingStatusChanges).length;
        btn.querySelector('.status-count').textContent = count;
    }
}

function saveAllFileStatuses() {
    var changes = Object.values(pendingStatusChanges);
    if (changes.length === 0) return;

    var btn = document.getElementById('btn-save-statuses');
    if (btn) {
        btn.disabled = true;
        btn.querySelector('.btn-label').textContent = 'Enregistrement...';
    }

    fetch('index.php?page=rcd_status_bulk', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ changes: changes })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'Erreur lors de la mise à jour des statuts');
            if (btn) {
                btn.disabled = false;
                btn.querySelector('.btn-label').textContent = 'Valider les statuts';
            }
        }
    })
    .catch(function() {
        alert('Erreur réseau');
        if (btn) {
            btn.disabled = false;
            btn.querySelector('.btn-label').textContent = 'Valider les statuts';
        }
    });
}

// Enable date fields when a RCD file is selected in the upload modal
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name="file_rcd[]"]').forEach(function(input) {
        input.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                // Find the parent row and enable date inputs
                var row = this.closest('tr');
                if (row) {
                    row.querySelectorAll('input[data-rcd-date]').forEach(function(dateInput) {
                        dateInput.disabled = false;
                        dateInput.classList.remove('cursor-not-allowed');
                    });
                }
            }
        });
    });

    // Charger le token existant au chargement de la page
    var form = document.getElementById('form-rcd');
    if (form) {
        var doid = form.dataset.doid;
        if (doid) {
            fetch('index.php?page=rcd_token&doid=' + doid)
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success && data.url) {
                        var input = document.getElementById('url-shortener');
                        input.value = data.url;
                        document.getElementById('btn-mailto-link').disabled = false;
                        document.getElementById('btn-rappel-link').disabled = false;
                        document.getElementById('btn-generate-link').textContent = 'Renouveler';
                        var info = document.getElementById('link-expiry-info');
                        info.textContent = 'Expire le ' + new Date(data.expires).toLocaleDateString('fr-FR') + ' à ' + new Date(data.expires).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'});
                        info.classList.remove('hidden');
                    }
                })
                .catch(function() {});
        }
    }
});

function generateRcdToken(doid) {
    var btn = document.getElementById('btn-generate-link');
    btn.disabled = true;
    btn.textContent = 'Génération...';

    fetch('index.php?page=rcd_token&doid=' + doid)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                var input = document.getElementById('url-shortener');
                input.value = data.url;
                document.getElementById('btn-mailto-link').disabled = false;
                document.getElementById('btn-rappel-link').disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4 me-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/></svg> Renouveler';
                var info = document.getElementById('link-expiry-info');
                info.textContent = 'Expire le ' + new Date(data.expires).toLocaleDateString('fr-FR') + ' à ' + new Date(data.expires).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'});
                info.classList.remove('hidden');
            } else {
                alert(data.error || 'Erreur lors de la génération du lien');
            }
            btn.disabled = false;
        })
        .catch(function() {
            alert('Erreur réseau');
            btn.disabled = false;
            btn.textContent = 'Générer le lien';
        });
}

function copyUploadLink() {
    var input = document.getElementById('url-shortener');
    if (!input.value || input.value === '') return;

    navigator.clipboard.writeText(input.value).then(function() {
        document.getElementById('default-icon').classList.add('hidden');
        document.getElementById('success-icon').classList.remove('hidden');
        document.getElementById('default-tooltip-message').classList.add('hidden');
        document.getElementById('success-tooltip-message').classList.remove('hidden');
        setTimeout(function() {
            document.getElementById('default-icon').classList.remove('hidden');
            document.getElementById('success-icon').classList.add('hidden');
            document.getElementById('default-tooltip-message').classList.remove('hidden');
            document.getElementById('success-tooltip-message').classList.add('hidden');
        }, 2000);
    });
}

function sendUploadLinkByMail() {
    var url = document.getElementById('url-shortener').value;
    if (!url) return;

    var form = document.getElementById('form-rcd');
    var email = form.dataset.souscripteurEmail || '';
    var doid = form.dataset.doid || '';

    var subject = encodeURIComponent('Documents RCD à transmettre - DO n°' + doid);
    var body = encodeURIComponent(
        'Bonjour,\n\n' +
        'Dans le cadre du dossier Dommage Ouvrage n°' + doid + ', nous vous prions de bien vouloir nous transmettre les attestations de responsabilité civile décennale.\n\n' +
        'Pour cela, veuillez cliquer sur le lien sécurisé ci-dessous :\n' +
        url + '\n\n' +
        'Ce lien est valable 7 jours.\n\n' +
        'Cordialement'
    );

    window.location.href = 'mailto:' + encodeURIComponent(email) + '?subject=' + subject + '&body=' + body;
}

function sendRappelRcdByMail() {
    var url = document.getElementById('url-shortener').value;
    if (!url) return;

    var form = document.getElementById('form-rcd');
    var email = form.dataset.souscripteurEmail || '';
    var doid = form.dataset.doid || '';

    var subject = encodeURIComponent('Rappel — Pièces RCD manquantes — DO n°' + doid);
    var body = encodeURIComponent(
        'Bonjour,\n\n' +
        'Nous vous avons précédemment sollicité pour la transmission des attestations de responsabilité civile décennale concernant la dommage ouvrage n°' + doid + '.\n\n' +
        'À ce jour, certaines pièces n\'ont pas encore été transmises ou nécessitent une correction.\n\n' +
        'Nous vous prions de bien vouloir compléter votre envoi via le lien sécurisé ci-dessous :\n' +
        url + '\n\n' +
        'Sans retour de votre part, le traitement du dossier ne pourra pas être finalisé.\n\n' +
        'Cordialement'
    );

    window.location.href = 'mailto:' + encodeURIComponent(email) + '?subject=' + subject + '&body=' + body;
}
