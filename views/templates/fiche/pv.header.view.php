<style>
.fiche-title { display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0 0.5rem; }
.fiche-title-num { display: inline-flex; align-items: center; justify-content: center; width: 1.75rem; height: 1.75rem; border-radius: 9999px; background: #d97706; color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
.fiche-title h2 { font-size: 1.15rem; font-weight: 700; color: #92400e; margin: 0; }
.fiche-hr { border: 0; border-top: 2px solid #fcd34d; margin-bottom: 1rem; }
.fiche-fieldset { border: 1px solid #f3d8a8; border-radius: 0.5rem; padding: 1rem 1.25rem; margin: 0.5rem 0 1rem; }
.fiche-fieldset legend { padding: 0 0.5rem; font-size: 0.95rem; font-weight: 600; color: #78350f; }
.fiche-row { display: flex; align-items: baseline; padding: 0.3rem 0; border-bottom: 1px dotted #fde68a; gap: 0.75rem; }
.fiche-row:last-child { border-bottom: none; }
.fiche-label { min-width: 260px; flex-shrink: 0; color: #92400e; font-size: 0.875rem; }
.fiche-value { font-weight: 600; color: #1f2937; font-size: 0.875rem; }
.fiche-check { display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0; }
.fiche-check-icon { width: 1rem; height: 1rem; color: #16a34a; flex-shrink: 0; }
.fiche-two-columns { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 1.5rem; }
.fiche-address-block { margin: 0; }
.fiche-address-block .fiche-label { min-width: 100px; }
@media (max-width: 640px) { .fiche-two-columns { grid-template-columns: 1fr; } }
@media print {
    header, footer, nav, .stepper, .font-resizer, .no-print, button[onclick], a[href*="step"], a[href*="final_step"] { display: none !important; }
    section { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0.5rem !important; border: none !important; }
    .fiche-fieldset { break-inside: avoid; page-break-inside: avoid; }
    .fiche-two-columns { grid-template-columns: 1fr 1fr; }
}
</style>
<div style="display:flex; align-items:baseline; justify-content:space-between; margin:1.5rem 0 0.5rem; flex-wrap:wrap; gap:0.5rem;">
    <h2 style="font-size:1.25rem; font-weight:700; color:#92400e; margin:0;">Contrat photovoltaique N° <?= htmlspecialchars($DATA['DOID']) ?></h2>
    <span style="font-size:0.9rem; color:#92400e;">Date de création : <strong style="color:#1f2937;"><?= dateFormat($DATA['date_creation']) ?></strong></span>
</div>
<hr class="fiche-hr">
