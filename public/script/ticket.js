/* Ticket system — open/close modal + AJAX submit */

function openTicketModal() {
    var modal = document.getElementById('ticket-modal');
    var urlField = document.getElementById('ticket-url-page');
    var urlDisplay = document.getElementById('ticket-url-display');
    if (!modal) return;
    urlField.value = window.location.href;
    urlDisplay.textContent = window.location.href;
    modal.classList.remove('hidden');
    document.getElementById('ticket-descriptif').focus();
}

function closeTicketModal() {
    var modal = document.getElementById('ticket-modal');
    if (!modal) return;
    modal.classList.add('hidden');
    document.getElementById('ticket-form').reset();
    var msg = document.getElementById('ticket-message');
    msg.classList.add('hidden');
    msg.innerHTML = '';
}

document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('ticket-form');
    if (!form) return;

    /* Close on Escape key */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeTicketModal();
    });

    /* Close on backdrop click */
    var modal = document.getElementById('ticket-modal');
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeTicketModal();
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var btn = document.getElementById('ticket-submit-btn');
        var msg = document.getElementById('ticket-message');
        btn.disabled = true;
        btn.textContent = 'Envoi en cours…';
        msg.classList.add('hidden');

        var fd = new FormData(form);

        fetch('index.php?page=ticket_create', {
            method: 'POST',
            body: fd
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            msg.classList.remove('hidden');
            if (data.success) {
                msg.innerHTML = '<div class="p-3 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-green-900/30 dark:text-green-400">' + escapeHtml(data.message) + '</div>';
                form.reset();
                setTimeout(closeTicketModal, 2000);
            } else {
                msg.innerHTML = '<div class="p-3 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-red-900/30 dark:text-red-400">' + escapeHtml(data.error) + '</div>';
            }
        })
        .catch(function () {
            msg.classList.remove('hidden');
            msg.innerHTML = '<div class="p-3 text-sm text-red-800 rounded-lg bg-red-50">Erreur réseau. Veuillez réessayer.</div>';
        })
        .finally(function () {
            btn.disabled = false;
            btn.textContent = 'Envoyer le ticket';
        });
    });
});

function escapeHtml(text) {
    var d = document.createElement('div');
    d.appendChild(document.createTextNode(text));
    return d.innerHTML;
}
