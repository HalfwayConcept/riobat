-- Migration : Création de la table étape PV "Prévention" (S03)
-- Date : 2026-08-21
-- Description : Stockage dédié des réponses de prévention PV (une ligne par DOID)

CREATE TABLE IF NOT EXISTS `pv_prevention` (
    `pv_prevention_id`                     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `DOID`                                 INT NOT NULL,

    `contrat_maintenance_equipements`      TINYINT(1) NOT NULL DEFAULT 0,
    `monitoring_production_continue`       TINYINT(1) NOT NULL DEFAULT 0,
    `duree_garantie_onduleurs`             VARCHAR(100) NULL,
    `onduleurs_local_coupe_feu_2h`         TINYINT(1) NOT NULL DEFAULT 0,

    `hauteur_implantation_min_m`           DECIMAL(8,2) NULL,

    `fixation_modules_antivol`             TINYINT(1) NOT NULL DEFAULT 0,
    `fixation_antivol_details`             TEXT NULL,

    `incendie_extincteurs_mobiles`         TINYINT(1) NOT NULL DEFAULT 0,
    `incendie_poteaux`                     TINYINT(1) NOT NULL DEFAULT 0,
    `incendie_detection_automatique`       TINYINT(1) NOT NULL DEFAULT 0,
    `incendie_sprinkler`                   TINYINT(1) NOT NULL DEFAULT 0,
    `incendie_autres`                      TEXT NULL,

    `verification_electrique_annuelle`     TINYINT(1) NOT NULL DEFAULT 0,
    `nom_organisme_verificateur`           VARCHAR(255) NULL,

    `controle_thermographie_infrarouge`    TINYINT(1) NOT NULL DEFAULT 0,
    `etude_resistance_vent_ombriere`       TINYINT(1) NOT NULL DEFAULT 0,

    `date_creation`                        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour`                     DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`pv_prevention_id`),
    UNIQUE KEY `uq_pv_prevention_doid` (`DOID`),
    INDEX `idx_pv_prevention_doid` (`DOID`)
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
      AND table_name = 'pv_prevention'
      AND constraint_name = 'fk_pv_prevention_doid'
);

SET @sql = IF(
    @target_table IS NOT NULL AND @fk_exists = 0,
    CONCAT(
        'ALTER TABLE `pv_prevention` ',
        'ADD CONSTRAINT `fk_pv_prevention_doid` ',
        'FOREIGN KEY (`DOID`) REFERENCES `', @target_table, '` (`DOID`) ',
        'ON DELETE CASCADE'
    ),
    'SELECT 1'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
