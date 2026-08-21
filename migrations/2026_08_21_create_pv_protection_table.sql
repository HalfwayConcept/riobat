-- Migration : Création de la table étape PV "Protection"
-- Date : 2026-08-21
-- Description : Stockage dédié des réponses de protection PV (une ligne par DOID)

CREATE TABLE IF NOT EXISTS `pv_protection` (
    `pv_protection_id`                               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `DOID`                                           INT NOT NULL,

    `respect_ute_c15712`                              TINYINT(1) NOT NULL DEFAULT 0,
    `certificat_cofrac_securite_incendie`             TINYINT(1) NOT NULL DEFAULT 0,
    `verification_annuelle_qualifiee`                 TINYINT(1) NOT NULL DEFAULT 0,
    `maintenance_mise_en_place`                       TINYINT(1) NOT NULL DEFAULT 0,
    `maintenance_entreprise_tierce`                   TINYINT(1) NOT NULL DEFAULT 0,
    `procedure_remediation_defauts`                   TINYINT(1) NOT NULL DEFAULT 0,
    `connecteurs_conformes_en50521`                   TINYINT(1) NOT NULL DEFAULT 0,
    `boucles_induction`                               TINYINT(1) NOT NULL DEFAULT 0,
    `thermographie_infrarouge_annuelle`               TINYINT(1) NOT NULL DEFAULT 0,
    `zone_graviers_5m_interieur_cloture`              TINYINT(1) NOT NULL DEFAULT 0,
    `protection_cables_rongeurs`                      TINYINT(1) NOT NULL DEFAULT 0,
    `observations`                                    TEXT NULL,

    `date_creation`                                  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour`                               DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`pv_protection_id`),
    UNIQUE KEY `uq_pv_protection_doid` (`DOID`),
    INDEX `idx_pv_protection_doid` (`DOID`)
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
      AND table_name = 'pv_protection'
      AND constraint_name = 'fk_pv_protection_doid'
);

SET @sql = IF(
    @target_table IS NOT NULL AND @fk_exists = 0,
    CONCAT(
        'ALTER TABLE `pv_protection` ',
        'ADD CONSTRAINT `fk_pv_protection_doid` ',
        'FOREIGN KEY (`DOID`) REFERENCES `', @target_table, '` (`DOID`) ',
        'ON DELETE CASCADE'
    ),
    'SELECT 1'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;