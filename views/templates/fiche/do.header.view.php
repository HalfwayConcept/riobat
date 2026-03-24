
<!-- ===== Fiche DO : CSS uniforme + impression ===== -->
<style>
/* --- Fiche section titles --- */
.fiche-title { display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0 0.5rem; }
.fiche-title-num { display: inline-flex; align-items: center; justify-content: center; width: 1.75rem; height: 1.75rem; border-radius: 9999px; background: #2563eb; color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; }
.fiche-title h2 { font-size: 1.15rem; font-weight: 700; color: #1e3a5f; margin: 0; }
.fiche-hr { border: 0; border-top: 2px solid #bfdbfe; margin-bottom: 1rem; }

/* --- Fieldsets --- */
.fiche-fieldset { border: 1px solid #cbd5e1; border-radius: 0.5rem; padding: 1rem 1.25rem; margin: 0.5rem 0 1rem; }
.fiche-fieldset legend { padding: 0 0.5rem; font-size: 0.95rem; font-weight: 600; color: #334155; }

/* --- Data rows (label + value) --- */
.fiche-row { display: flex; align-items: baseline; padding: 0.3rem 0; border-bottom: 1px dotted #e2e8f0; gap: 0.75rem; }
.fiche-row:last-child { border-bottom: none; }
.fiche-label { min-width: 240px; flex-shrink: 0; color: #64748b; font-size: 0.875rem; }
.fiche-value { font-weight: 600; color: #1e293b; font-size: 0.875rem; }

/* --- Check items (boolean flags) --- */
.fiche-check { display: flex; align-items: center; gap: 0.5rem; padding: 0.25rem 0; }
.fiche-check-icon { width: 1rem; height: 1rem; color: #16a34a; flex-shrink: 0; }
.fiche-check span { color: #1e293b; font-size: 0.875rem; }

/* --- Sub-section titles --- */
.fiche-sub { font-weight: 600; color: #334155; font-size: 0.9rem; margin: 0.75rem 0 0.25rem; padding-left: 0.25rem; }

/* --- Entreprise cards (viewEntreprise) --- */
.fiche-entreprise { border: 1px solid #cbd5e1; border-radius: 0.5rem; padding: 0.75rem 1rem; margin: 0.5rem 0; background: #f8fafc; }
.fiche-entreprise-header { display: flex; align-items: center; gap: 0.5rem; font-weight: 600; color: #334155; font-size: 0.9rem; margin-bottom: 0.5rem; padding-bottom: 0.35rem; border-bottom: 1px solid #e2e8f0; }
.fiche-entreprise-header img { height: 1.25rem; }
.fiche-entreprise .fiche-row { border-bottom: none; padding: 0.15rem 0; }

/* ===== Print ===== */
@media print {
    body { font-size: 11pt; color: #000; background: #fff; }
    header, footer, nav, .stepper, .font-resizer, .no-print,
    button[onclick], a[href*="step"], a[href*="final_step"] { display: none !important; }
    section { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0.5rem !important; border: none !important; }
    .fiche-fieldset { break-inside: avoid; border-color: #999; page-break-inside: avoid; }
    .fiche-title { margin-top: 1rem; }
    .fiche-title-num { background: #000; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .fiche-row { border-bottom-color: #ccc; }
    .fiche-label { min-width: 200px; }
    .fiche-entreprise { background: #f5f5f5; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    h1 { font-size: 14pt; }
    @page { margin: 1.5cm; }
}
</style>
<!-- ===== En-tête Dommage Ouvrage ===== -->
<div style="display:flex; align-items:baseline; justify-content:space-between; margin:1.5rem 0 0.5rem; flex-wrap:wrap; gap:0.5rem;">
    <h2 style="font-size:1.25rem; font-weight:700; color:#1e3a5f; margin:0;">Dommage ouvrage N° <?=htmlspecialchars($DATA['DOID'])?></h2>
    <span style="font-size:0.9rem; color:#64748b;">Date de création : <strong style="color:#1e293b;"><?=dateFormat($DATA['date_creation'])?></strong></span>
</div>
<hr class="fiche-hr">
