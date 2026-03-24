// public/script/s02-maitre-ouvrage.js
// Gère la sérialisation du tableau missions en JSON dans un champ caché

document.addEventListener('DOMContentLoaded', function() {
  const table = document.getElementById('missions-table');
  const hidden = document.getElementById('missions_json');
  if (!table || !hidden) return;

  // Remplir le tableau à partir du JSON si présent
  try {
    if (hidden.value) {
      const data = JSON.parse(hidden.value);
      let rowIdx = 0;
      table.querySelectorAll('tr').forEach((row, i) => {
        if (i === 0) return; // skip header
        const cells = row.querySelectorAll('input,textarea');
        if (cells.length && data[rowIdx]) {
          cells.forEach((cell, j) => {
            if (cell.type === 'checkbox') cell.checked = !!data[rowIdx][j];
            else cell.value = data[rowIdx][j] || '';
          });
          rowIdx++;
        }
      });
    }
  } catch(e) { /* ignore */ }

  function updateHidden() {
    const data = [];
    table.querySelectorAll('tr').forEach((row, i) => {
      if (i === 0) return; // skip header
      const cells = row.querySelectorAll('input,textarea');
      if (cells.length) {
        const rowData = [];
        cells.forEach(cell => {
          if (cell.type === 'checkbox') rowData.push(cell.checked ? 1 : 0);
          else rowData.push(cell.value);
        });
        data.push(rowData);
      }
    });
    hidden.value = JSON.stringify(data);
  }
  table.addEventListener('change', updateHidden);
  table.addEventListener('input', updateHidden);
  updateHidden();
});

// --- Fonctions toggle extraites de s02-maitre-ouvrage.view.php ---

function handleToggleSouscripteur(checkbox) {
    const radioOui = document.getElementById('radio_moa_souscripteur_oui');
    const radioNon = document.getElementById('radio_moa_souscripteur_non');
    const spanValue = document.getElementById('moa_souscripteur_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        hideElement('moa_form','moa');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        showElement('moa_form','moa');
    }
}

function handleToggleCivilite(checkbox) {
    const radioParticulier = document.getElementById('radio_moa_civilite_particulier');
    const radioEntreprise = document.getElementById('radio_moa_civilite_entreprise');
    if (checkbox.checked) {
        radioEntreprise.checked = true;
        showElement('siret_champ');
        showElement('raison_champ');
    } else {
        radioParticulier.checked = true;
        hideElement('siret_champ');
        hideElement('raison_champ');
    }
}

function toggleMoaQualiteAutre(select) {
    var autre = document.getElementById('moa_qualite_autre_div');
    if (select.value === '999') {
        autre.classList.remove('hidden');
    } else {
        autre.classList.add('hidden');
    }
}

function handleToggleConstruction(checkbox) {
    const radioOui = document.getElementById('radio_moa_construction_oui');
    const radioNon = document.getElementById('radio_moa_construction_non');
    const spanValue = document.getElementById('moa_construction_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        showElement('moa_construction_form');
        showElement('moa_construction_pro_tableau');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        hideElement('moa_construction_form');
        hideElement('moa_construction_pro_tableau');
    }
}

function handleToggleConstructionPro(checkbox) {
    const radioOui = document.getElementById('radio_moa_construction_pro_oui');
    const radioNon = document.getElementById('radio_moa_construction_pro_non');
    const spanValue = document.getElementById('moa_construction_pro_value');
    if (checkbox.checked) {
        radioOui.checked = true;
        spanValue.textContent = 'Oui';
        showElement('moa_construction_pro_form');
    } else {
        radioNon.checked = true;
        spanValue.textContent = 'Non';
        hideElement('moa_construction_pro_form');
    }
}

// --- Nature des travaux (tableau dynamique) ---

const moaNatureTravauxRows = [
    { key: 'conception', label: 'Conception' },
    { key: 'direction', label: 'Direction' },
    { key: 'surveillance', label: 'Surveillance' },
    { key: 'execution', label: 'Exécution' }
];
const moaNatureTravauxCols = [
    { key: '1', label: 'Papiers peints/Peintures intérieures' },
    { key: '2', label: 'Gros oeuvre/Charpente/Couverture/Etanchéité' },
    { key: '3', label: 'Autres travaux' }
];

function getInitialNatureTravaux() {
    let val = document.getElementById('moa_nature_travaux_json').value;
    if (!val) return {};
    try { return JSON.parse(val); } catch { return {}; }
}

function updateNatureTravauxJSON(obj) {
    document.getElementById('moa_nature_travaux_json').value = JSON.stringify(obj);
}

function renderNatureTravauxTable() {
    const tbody = document.createElement('tbody');
    let data = getInitialNatureTravaux();
    moaNatureTravauxRows.forEach(row => {
        const tr = document.createElement('tr');
        const tdLabel = document.createElement('td');
        tdLabel.className = 'border-r-2 border-l-2 border-b border-gray-300 p-2 pl-4';
        tdLabel.innerHTML = `<label>${row.label}</label>`;
        tr.appendChild(tdLabel);
        moaNatureTravauxCols.forEach(col => {
            const td = document.createElement('td');
            td.className = 'border-r-2 border-b border-gray-300 text-center p-2';
            const id = `moa_${row.key}_${col.key}`;
            const checked = data[row.key] && data[row.key][col.key];
            td.innerHTML = `<input type="checkbox" id="${id}" ${checked ? 'checked' : ''} />`;
            tr.appendChild(td);
        });
        const tdAutre = document.createElement('td');
        tdAutre.className = 'border-r-2 border-b border-gray-300 text-center p-2';
        const inputId = `moa_${row.key}_autre`;
        const val = data[row.key] && data[row.key]['autre'] ? data[row.key]['autre'] : '';
        tdAutre.innerHTML = `<input type="text" id="${inputId}" value="${val.replace(/"/g,'&quot;')}" class="w-full px-2 py-1 border rounded" placeholder="Précisez..." />`;
        tr.appendChild(tdAutre);
        tbody.appendChild(tr);
    });
    const table = document.querySelector('#moa_construction_pro_tableau table');
    const oldTbody = table.querySelector('tbody');
    if (oldTbody) table.removeChild(oldTbody);
    table.appendChild(tbody);
}

function syncNatureTravauxFromUI() {
    let obj = {};
    moaNatureTravauxRows.forEach(row => {
        obj[row.key] = {};
        moaNatureTravauxCols.forEach(col => {
            const id = `moa_${row.key}_${col.key}`;
            obj[row.key][col.key] = document.getElementById(id).checked;
        });
        const inputId = `moa_${row.key}_autre`;
        obj[row.key]['autre'] = document.getElementById(inputId).value;
    });
    updateNatureTravauxJSON(obj);
}

document.addEventListener('DOMContentLoaded', function() {
    // Render nature travaux table if present
    if (document.getElementById('moa_nature_travaux_json')) {
        renderNatureTravauxTable();
        moaNatureTravauxRows.forEach(row => {
            moaNatureTravauxCols.forEach(col => {
                const id = `moa_${row.key}_${col.key}`;
                const el = document.getElementById(id);
                if (el) el.addEventListener('change', syncNatureTravauxFromUI);
            });
            const inputId = `moa_${row.key}_autre`;
            const el = document.getElementById(inputId);
            if (el) el.addEventListener('input', syncNatureTravauxFromUI);
        });
    }
});
