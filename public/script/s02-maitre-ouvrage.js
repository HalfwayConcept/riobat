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
