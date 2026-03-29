-- Migration : Refactoring MOA ↔ Souscripteur
-- Date : 2026-03-26
-- Description : 
--   - Ajouter souscripteur_form_civilite à la table souscripteur
--   - Ajouter moa_souscripteur_id et moa_entreprise_id dans la table moa
--   - Migrer les données existantes des champs moa_souscripteur_form_* vers un nouveau souscripteur
--   - Supprimer les colonnes moa_souscripteur_form_* et moa_souscripteur de la table moa
--
-- NOTE : Ce script est idempotent (vérifie l'existence avant d'ajouter).
--        Les contraintes FK sont dans un script séparé : 2026_03_26_add_moa_foreign_keys.sql

-- 1. Ajouter la colonne civilité dans souscripteur (si absente)
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'souscripteur' AND COLUMN_NAME = 'souscripteur_form_civilite');
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `souscripteur` ADD COLUMN `souscripteur_form_civilite` ENUM(''particulier'',''entreprise'') NULL DEFAULT NULL AFTER `souscripteur_id`',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 2. Ajouter les colonnes moa_souscripteur_id et moa_entreprise_id dans moa (si absentes)
SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'moa' AND COLUMN_NAME = 'moa_souscripteur_id');
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `moa` ADD COLUMN `moa_souscripteur_id` INT NULL DEFAULT NULL AFTER `moa_souscripteur`, ADD INDEX `idx_moa_souscripteur_id` (`moa_souscripteur_id`)',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col_exists = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'moa' AND COLUMN_NAME = 'moa_entreprise_id');
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `moa` ADD COLUMN `moa_entreprise_id` INT NULL DEFAULT NULL AFTER `moa_souscripteur_id`, ADD INDEX `idx_moa_entreprise_id` (`moa_entreprise_id`)',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 3. Migrer les données existantes : créer un souscripteur pour chaque MOA ≠ souscripteur
-- NOTE : Exécuter ce bloc ligne par ligne ou via un script PHP si la procédure stockée ne fonctionne pas.
-- Cette procédure insère un souscripteur pour chaque MOA ayant des données form_* renseignées,
-- puis met à jour moa.moa_souscripteur_id avec l'ID du nouveau souscripteur.

DELIMITER //
CREATE PROCEDURE migrate_moa_to_souscripteur()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_doid INT;
    DECLARE v_civilite ENUM('particulier','entreprise');
    DECLARE v_nom VARCHAR(255);
    DECLARE v_adresse VARCHAR(255);
    DECLARE v_raison VARCHAR(255);
    DECLARE v_siret VARCHAR(255);
    DECLARE v_new_id INT;

    DECLARE cur CURSOR FOR
        SELECT DOID, moa_souscripteur_form_civilite, moa_souscripteur_form_nom_prenom,
               moa_souscripteur_form_adresse, moa_souscripteur_form_raison_sociale, moa_souscripteur_form_siret
        FROM moa
        WHERE moa_souscripteur = 0
          AND moa_souscripteur_form_nom_prenom IS NOT NULL
          AND moa_souscripteur_form_nom_prenom != '';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_doid, v_civilite, v_nom, v_adresse, v_raison, v_siret;
        IF done THEN LEAVE read_loop; END IF;

        INSERT INTO souscripteur (souscripteur_form_civilite, souscripteur_nom_raison, souscripteur_adresse,
                                  souscripteur_siret, souscripteur_code_postal, souscripteur_commune,
                                  souscripteur_telephone, souscripteur_email)
        VALUES (v_civilite,
                COALESCE(IF(v_civilite = 'entreprise', v_raison, v_nom), v_nom),
                COALESCE(v_adresse, ''),
                IF(v_civilite = 'entreprise', v_siret, NULL),
                0, '', '', '');

        SET v_new_id = LAST_INSERT_ID();
        UPDATE moa SET moa_souscripteur_id = v_new_id WHERE DOID = v_doid;
    END LOOP;
    CLOSE cur;
END //
DELIMITER ;

CALL migrate_moa_to_souscripteur();
DROP PROCEDURE IF EXISTS migrate_moa_to_souscripteur;

-- 4. Supprimer les anciennes colonnes de moa (y compris moa_souscripteur devenu redondant avec moa_souscripteur_id)
ALTER TABLE `moa`
    DROP COLUMN `moa_souscripteur`,
    DROP COLUMN `moa_souscripteur_form_civilite`,
    DROP COLUMN `moa_souscripteur_form_nom_prenom`,
    DROP COLUMN `moa_souscripteur_form_adresse`,
    DROP COLUMN `moa_souscripteur_form_raison_sociale`,
    DROP COLUMN `moa_souscripteur_form_siret`;
