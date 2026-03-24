// admin-logs.js
// Gestion des modales SQL et highlight.js pour la page des logs

document.addEventListener('DOMContentLoaded', function() {
    if (typeof hljs !== 'undefined') {
        hljs.highlightAll();
    }

    // Boutons copier
    document.querySelectorAll('.copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var text = btn.getAttribute('data-copy');
            navigator.clipboard.writeText(text);
            var span = btn.querySelector('span');
            var originalText = span.textContent;
            span.textContent = 'Copié!';
            setTimeout(function() { span.textContent = originalText; }, 1200);
        });
    });

    // Ouverture des modales SQL
    document.querySelectorAll('.sql-modal-trigger').forEach(function(icon) {
        icon.addEventListener('click', function(e) {
            e.stopPropagation();
            var logId = icon.getAttribute('data-log-id');
            var modal = document.getElementById('sql-modal-' + logId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    });

    // Fermeture des modales SQL
    document.querySelectorAll('.close-sql-modal').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            btn.closest('.fixed').classList.add('hidden');
            btn.closest('.fixed').classList.remove('flex');
        });
    });

    // Fermer en cliquant sur le fond
    document.querySelectorAll('.fixed.z-50').forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });
});
