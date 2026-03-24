-- ============================================================
-- Migration: Create email management tables
-- Date: 2026-03-24
-- Description: Email templates + email settings (signature, reply-to, etc.)
-- ============================================================

-- Table des paramètres email (clé/valeur)
CREATE TABLE IF NOT EXISTS email_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Paramètres par défaut
INSERT INTO email_settings (setting_key, setting_value) VALUES
('from_name', 'Cabinet Cotton Alexandre'),
('from_email', 'contact@riobat.ruki5964.odns.fr'),
('reply_to', 'cabinetcotton@outlook.fr'),
('signature', '<p>Cordialement,</p><p><strong>Cabinet Cotton Alexandre</strong><br>5 bd, rue Soubeyran - 48000 MENDE<br>cabinetcotton@outlook.fr</p>');

-- Table des templates email
CREATE TABLE IF NOT EXISTS email_templates (
    template_id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    sujet VARCHAR(255) NOT NULL,
    corps TEXT NOT NULL,
    active TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Templates par défaut
INSERT INTO email_templates (slug, nom, sujet, corps) VALUES
('bienvenue', 'Mail de bienvenue', '[RIOBAT] Bienvenue {{prenom}} {{nom}}',
'<p>Bonjour <strong>{{prenom}} {{nom}}</strong>,</p>
<p>Votre compte RIOBAT a été créé avec succès.</p>
<p>Vous pouvez dès à présent vous connecter avec votre adresse email <strong>{{email}}</strong>.</p>
<p>Si vous n''avez pas demandé la création de ce compte, veuillez ignorer ce message.</p>'),

('validation_do', 'Validation de la DO', '[RIOBAT] Dommage ouvrage N°{{do_id}} validée',
'<p>Bonjour <strong>{{prenom}} {{nom}}</strong>,</p>
<p>La dommage ouvrage <strong>N°{{do_id}}</strong> pour <strong>{{souscripteur}}</strong> a été validée avec succès.</p>
<p>Vous pouvez consulter la fiche récapitulative depuis votre espace.</p>'),

('demande_rcd', 'Demande de RCD', '[RIOBAT] Demande de RCD — DO N°{{do_id}}',
'<p>Bonjour,</p>
<p>Une demande de Relevé de Compte Définitif (RCD) a été générée pour la dommage ouvrage <strong>N°{{do_id}}</strong>.</p>
<p>Souscripteur : <strong>{{souscripteur}}</strong></p>
<p>Merci de bien vouloir transmettre les documents demandés via le lien sécurisé ci-dessous :</p>
<p><a href="{{lien_rcd}}">{{lien_rcd}}</a></p>'),

('do_complete', 'Dommage ouvrage complète', '[RIOBAT] DO N°{{do_id}} — Dossier complet',
'<p>Bonjour <strong>{{prenom}} {{nom}}</strong>,</p>
<p>Le dossier de dommage ouvrage <strong>N°{{do_id}}</strong> pour <strong>{{souscripteur}}</strong> est désormais complet.</p>
<p>L''ensemble des documents et informations nécessaires ont été réunis.</p>');
