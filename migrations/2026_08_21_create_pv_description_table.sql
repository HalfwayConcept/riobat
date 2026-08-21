-- Migration : Création de la table étape PV "Description de la centrale photovoltaïque"
-- Date : 2026-08-21
-- Description : Stockage dédié des réponses step3 PV (une ligne par DOID)

CREATE TABLE IF NOT EXISTS `pv_description_centrale` (
    `pv_description_id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `DOID`                              INT NOT NULL,

    `adresse_centrale`                  VARCHAR(255) NOT NULL,
    `code_postal`                       VARCHAR(10) NOT NULL,
    `commune`                           VARCHAR(120) NOT NULL,

    `entreprise_pose_qualipv`           VARCHAR(255) NOT NULL,

    `valeur_neuve_remplacement`         DECIMAL(15,2) NOT NULL,
    `valeur_type`                       ENUM('HT','TTC') NOT NULL DEFAULT 'HT',

    `date_mise_en_service`              DATE NOT NULL,
    `deja_assuree`                      TINYINT(1) NOT NULL DEFAULT 0,

    `sinistre_deja`                     TINYINT(1) NOT NULL DEFAULT 0,
    `sinistre_nature_montant`           TEXT NULL,

    `surface_totale_m2`                 DECIMAL(12,2) NOT NULL,
    `puissance_crete_kwc`               DECIMAL(12,2) NOT NULL,

    `nature_panneaux`                   ENUM('mono','polycristallin','amorphe') NOT NULL,
    `panneaux_details`                  TEXT NOT NULL,
    `onduleurs_details`                 TEXT NOT NULL,

    `prix_vente_kwh`                    DECIMAL(10,5) NOT NULL,
    `recettes_previsionnelles_annuelles` DECIMAL(15,2) NOT NULL,

    `destination_energie`               ENUM('revente','autoconsommation') NOT NULL,
    `economies_achat_annuelles`         DECIMAL(15,2) NULL,

    `batteries_existent`                TINYINT(1) NOT NULL DEFAULT 0,
    `batteries_details`                 TEXT NULL,

    `date_creation`                     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour`                  DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`pv_description_id`),
    UNIQUE KEY `uq_pv_description_doid` (`DOID`),
    INDEX `idx_pv_description_doid` (`DOID`),
    INDEX `idx_pv_destination` (`destination_energie`),
    INDEX `idx_pv_date_mise_en_service` (`date_mise_en_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ajout FK vers la table contrat active
-- Priorité : dommage_contrat, sinon fallback dommage_ouvrage
SET @target_table = (
    SELECT CASE
        WHEN EXISTS (
            SELECT 1
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
              AND table_name = 'dommage_contrat'
        ) THEN 'dommage_contrat'
        WHEN EXISTS (
            SELECT 1
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
              AND table_name = 'dommage_ouvrage'
        ) THEN 'dommage_ouvrage'
        ELSE NULL
    END
);

SET @fk_exists = (
    SELECT COUNT(*)
    FROM information_schema.table_constraints
    WHERE table_schema = DATABASE()
      AND table_name = 'pv_description_centrale'
      AND constraint_name = 'fk_pv_description_doid'
);

SET @sql = IF(
    @target_table IS NOT NULL AND @fk_exists = 0,
    CONCAT(
        'ALTER TABLE `pv_description_centrale` ',
        'ADD CONSTRAINT `fk_pv_description_doid` ',
        'FOREIGN KEY (`DOID`) REFERENCES `', @target_table, '` (`DOID`) ',
        'ON DELETE CASCADE'
    ),
    'SELECT 1'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
