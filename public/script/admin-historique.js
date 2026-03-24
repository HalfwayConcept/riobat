// admin-historique.js
// Gestion de la popup d'historique des dommages ouvrages dans l'admin

function openHistorique(doid) {
    var modal = document.getElementById('historique-modal');
    var title = document.getElementById('historique-modal-title');
    var body = document.getElementById('historique-modal-body');
    title.textContent = 'Historique DO n\u00b0 ' + doid;
    body.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-center">Chargement...</p>';
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    fetch('index.php?page=do_historique&doid=' + encodeURIComponent(doid))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.error) {
                body.innerHTML = '<p class="text-red-500 text-center">' + escapeHtml(data.error) + '</p>';
                return;
            }
            if (!data.length) {
                body.innerHTML = '<p class="text-gray-400 text-center">Aucun historique pour cette demande.</p>';
                return;
            }
            var html = '<ol class="relative border-s border-gray-300 dark:border-gray-600 ms-3">';
            data.forEach(function(item) {
                var badgeColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                if (item.action === 'Validation') badgeColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                html += '<li class="mb-6 ms-6">';
                html += '<span class="absolute flex items-center justify-center w-6 h-6 rounded-full -start-3 ring-8 ring-white dark:ring-gray-800 ' + (item.action === 'Validation' ? 'bg-green-200 dark:bg-green-900' : 'bg-blue-200 dark:bg-blue-900') + '">';
                html += '<svg class="w-3 h-3 ' + (item.action === 'Validation' ? 'text-green-600 dark:text-green-300' : 'text-blue-600 dark:text-blue-300') + '" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>';
                html += '</span>';
                html += '<h3 class="flex items-center mb-1 text-sm font-semibold text-gray-900 dark:text-white">';
                html += '<span class="' + badgeColor + ' text-xs font-medium me-2 px-2.5 py-0.5 rounded">' + escapeHtml(item.action) + '</span>';
                html += '</h3>';
                html += '<time class="block mb-1 text-xs font-normal leading-none text-gray-500 dark:text-gray-400">' + escapeHtml(item.date_action) + '</time>';
                html += '<p class="text-sm text-gray-600 dark:text-gray-300">';
                if (item.user_nom) {
                    html += 'Par <span class="font-medium">' + escapeHtml(item.user_nom) + '</span>';
                    if (item.user_id) html += ' <span class="text-gray-400 dark:text-gray-500">(ID: ' + escapeHtml(String(item.user_id)) + ')</span>';
                } else if (item.user_id) {
                    html += 'Par utilisateur ID: ' + escapeHtml(String(item.user_id));
                } else {
                    html += 'Utilisateur inconnu';
                }
                html += '</p>';
                if (item.details) {
                    html += '<p class="text-xs text-gray-400 dark:text-gray-500 mt-1">' + escapeHtml(item.details) + '</p>';
                }
                html += '</li>';
            });
            html += '</ol>';
            body.innerHTML = html;
        })
        .catch(function() {
            body.innerHTML = '<p class="text-red-500 text-center">Erreur lors du chargement de l\'historique.</p>';
        });
}

function closeHistorique() {
    var modal = document.getElementById('historique-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function escapeHtml(text) {
    var d = document.createElement('div');
    d.appendChild(document.createTextNode(text));
    return d.innerHTML;
}

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('historique-modal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeHistorique();
        });
    }
});
