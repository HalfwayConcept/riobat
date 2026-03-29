-- Migration: Ajouter 'particulier' au ENUM type de la table entreprise
-- Permet de stocker les données MOA particulier dans la table entreprise
-- Date: 2026-03-26

-- Vérifier si 'particulier' n'est pas déjà dans le ENUM
SET @col_type = (SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'entreprise' AND COLUMN_NAME = 'type');

SET @sql = IF(@col_type NOT LIKE '%particulier%',
    "ALTER TABLE entreprise MODIFY COLUMN type ENUM('boi','phv','geo','ctt','cnr','sol','moe','moa','particulier') NOT NULL",
    'SELECT ''particulier already in ENUM'' AS info');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
