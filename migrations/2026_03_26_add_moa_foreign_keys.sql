-- Contraintes FK pour la table moa
-- Date : 2026-03-26
-- À exécuter APRÈS 2026_03_26_refactor_moa_souscripteur.sql

-- FK moa_souscripteur_id → souscripteur(souscripteur_id)
SET @fk_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'moa' AND CONSTRAINT_NAME = 'fk_moa_souscripteur');
SET @sql = IF(@fk_exists = 0, 
    'ALTER TABLE `moa` ADD CONSTRAINT `fk_moa_souscripteur` FOREIGN KEY (`moa_souscripteur_id`) REFERENCES `souscripteur` (`souscripteur_id`) ON DELETE SET NULL',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- FK moa_entreprise_id → entreprise(ID)
SET @fk_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'moa' AND CONSTRAINT_NAME = 'fk_moa_entreprise');
SET @sql = IF(@fk_exists = 0, 
    'ALTER TABLE `moa` ADD CONSTRAINT `fk_moa_entreprise` FOREIGN KEY (`moa_entreprise_id`) REFERENCES `entreprise` (`ID`) ON DELETE SET NULL',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
