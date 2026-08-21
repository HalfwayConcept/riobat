-- Migration: renommer la table centrale et typer les demandes (DO/PV)
-- Date: 2026-08-21

PREPARE stmt FROM @rename_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2) Ajouter la colonne de type de demande
ALTER TABLE dommage_contrat
    ADD COLUMN IF NOT EXISTS type_demande ENUM('do','pv') NOT NULL DEFAULT 'do' AFTER souscripteur_id;

-- 3) Sécuriser les valeurs existantes
UPDATE dommage_contrat
SET type_demande = 'do'
WHERE type_demande IS NULL OR type_demande = '';

-- 4) Index pour les futurs filtres dashboard/admin
ALTER TABLE dommage_contrat
    ADD INDEX IF NOT EXISTS idx_dommage_contrat_type_demande (type_demande);
