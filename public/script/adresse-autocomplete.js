// Adresse Autocomplete - API adresse.data.gouv.fr
// Utilisation : adresseAutocomplete(inputId, suggestionsId)

function adresseAutocomplete(inputId, suggestionsId) {
    let timeoutAdresse;
    const input = document.getElementById(inputId);
    const ul = document.getElementById(suggestionsId);
    if (!input || !ul) return;

    input.addEventListener('input', function() {
        const query = input.value;
        clearTimeout(timeoutAdresse);
        if (query.length < 3) {
            ul.classList.add('hidden');
            return;
        }
        timeoutAdresse = setTimeout(() => {
            fetch('https://api-adresse.data.gouv.fr/search/?q=' + encodeURIComponent(query) + '&limit=5')
                .then(response => response.json())
                .then(data => {
                    const suggestions = data.features.map(f => f.properties.label);
                    ul.innerHTML = '';
                    if (suggestions.length === 0) {
                        ul.classList.add('hidden');
                        return;
                    }
                    suggestions.forEach(addr => {
                        const li = document.createElement('li');
                        li.textContent = addr;
                        li.className = 'px-4 py-2 cursor-pointer hover:bg-blue-100';
                        li.onclick = function() {
                            input.value = addr;
                            ul.classList.add('hidden');
                        };
                        ul.appendChild(li);
                    });
                    ul.classList.remove('hidden');
                });
        }, 300);
    });

    // Cacher la liste si clic ailleurs
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !ul.contains(e.target)) {
            ul.classList.add('hidden');
        }
    });
}
