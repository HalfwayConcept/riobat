-- ============================================================
-- Migration: Add rappel_rcd email template
-- Date: 2026-04-07
-- Description: Ajout du template email de rappel pour pièces RCD manquantes
-- ============================================================

INSERT INTO email_templates (slug, nom, sujet, corps) VALUES
('rappel_rcd', 'Rappel pièces RCD manquantes', '[RIOBAT] Rappel — Pièces RCD manquantes — DO N°{{do_id}}',
'<p>Bonjour,</p>
<p>Nous vous avons précédemment sollicité pour la transmission des attestations de responsabilité civile décennale concernant la dommage ouvrage <strong>N°{{do_id}}</strong>.</p>
<p>Souscripteur : <strong>{{souscripteur}}</strong></p>
<p>À ce jour, certaines pièces n''ont pas encore été transmises ou nécessitent une correction.</p>
<p>Nous vous prions de bien vouloir compléter votre envoi via le lien sécurisé ci-dessous :</p>
<p><a href="{{lien_rcd}}">{{lien_rcd}}</a></p>
<p>Sans retour de votre part, le traitement du dossier ne pourra pas être finalisé.</p>');
