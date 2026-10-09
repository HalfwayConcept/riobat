INSERT INTO email_templates (slug, nom, sujet, corps, active)
VALUES (
    'demande_pv_documents',
    'Demande de documents PV',
    '[RIOBAT] Documents photovoltaïques demandés — Dossier N°{{do_id}}',
    '<p>Bonjour,</p>
<p>Des documents complémentaires sont nécessaires pour votre demande photovoltaïque <strong>N°{{do_id}}</strong>.</p>
<p>Souscripteur : <strong>{{souscripteur}}</strong></p>
<p>Merci de transmettre la facture d’installation, le K-bis et, si la toiture est gérée par une société, le document relatif au contrat correspondant.</p>
<p><a href="{{lien_pv}}">Transmettre mes documents</a></p>
<p>Ce lien sécurisé est valable pendant 7 jours.</p>',
    1
)
ON DUPLICATE KEY UPDATE
    nom = VALUES(nom),
    sujet = VALUES(sujet),
    corps = VALUES(corps),
    active = VALUES(active);
