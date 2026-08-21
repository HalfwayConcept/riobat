-- Migration : Création de la table étape PV "Environnement" (S04bis)
-- Date : 2026-08-21
-- Description : Stockage dédié des réponses d'environnement PV (une ligne par DOID)

CREATE TABLE IF NOT EXISTS `pv_environnement` (
    `pv_environnement_id`                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `DOID`                                     INT NOT NULL,

    `mode_pose_panneaux`                       ENUM('integration_bati','integration_simplifiee','ombriere','sol','autre') NULL,
    `mode_pose_autres_precisions`              VARCHAR(255) NULL,

    `support_integration_combustible`          TINYINT(1) NOT NULL DEFAULT 0,
    `nature_integration_systeme`               TEXT NULL,

    `isolant_toiture_combustible`              TINYINT(1) NOT NULL DEFAULT 0,
    `isolant_toiture_nature`                   VARCHAR(255) NULL,

    `souscripteur_proprietaire_batiment`       TINYINT(1) NOT NULL DEFAULT 0,
    `proprietaire_assureur_num_contrat`        VARCHAR(255) NULL,
    `bail_renonciation_recours_infos`          TEXT NULL,

    `presence_locataires_batiment`             TINYINT(1) NOT NULL DEFAULT 0,
    `locataires_details_baux_valeur_ca`        TEXT NULL,

    `activites_batiment_moins_20m`             TEXT NULL,
    `nature_chauffage_ou_sechage`              TEXT NULL,
    `depot_marchandises_tiers_conventions`     TEXT NULL,

    `stockage_matieres_combustibles`           TINYINT(1) NOT NULL DEFAULT 0,
    `stockage_combustibles_details`            TEXT NULL,

    `site_cloture`                             TINYINT(1) NOT NULL DEFAULT 0,
    `site_cloture_nature_hauteur`              TEXT NULL,

    `detection_intrusion_electronique`         TINYINT(1) NOT NULL DEFAULT 0,
    `detection_intrusion_description_delai`    TEXT NULL,

    `video_surveillance`                       TINYINT(1) NOT NULL DEFAULT 0,
    `video_surveillance_24h_intervention`      TINYINT(1) NOT NULL DEFAULT 0,

    `site_gardienne`                           TINYINT(1) NOT NULL DEFAULT 0,

    `etude_structure_risque_tempete`           TINYINT(1) NOT NULL DEFAULT 0,
    `hypothese_vent_maxi`                      VARCHAR(255) NULL,

    `etude_foudre_specialisee`                 TINYINT(1) NOT NULL DEFAULT 0,
    `parafoudre_dc`                            TINYINT(1) NOT NULL DEFAULT 0,
    `parafoudre_ac`                            TINYINT(1) NOT NULL DEFAULT 0,

    `debroussaillage_regulier_20cm`            TINYINT(1) NOT NULL DEFAULT 0,

    `stock_hydrocarbure`                       TINYINT(1) NOT NULL DEFAULT 0,
    `stock_meubles`                            TINYINT(1) NOT NULL DEFAULT 0,
    `stock_textiles`                           TINYINT(1) NOT NULL DEFAULT 0,
    `stock_bombe_aerosols`                     TINYINT(1) NOT NULL DEFAULT 0,
    `stock_explosifs`                          TINYINT(1) NOT NULL DEFAULT 0,
    `stock_papier`                             TINYINT(1) NOT NULL DEFAULT 0,
    `stock_bois`                               TINYINT(1) NOT NULL DEFAULT 0,
    `stock_fourrage`                           TINYINT(1) NOT NULL DEFAULT 0,
    `stock_engrais`                            TINYINT(1) NOT NULL DEFAULT 0,
    `stock_cereales`                           TINYINT(1) NOT NULL DEFAULT 0,

    `date_creation`                            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour`                         DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`pv_environnement_id`),
    UNIQUE KEY `uq_pv_environnement_doid` (`DOID`),
    INDEX `idx_pv_environnement_doid` (`DOID`),
    INDEX `idx_pv_mode_pose` (`mode_pose_panneaux`)
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
      AND table_name = 'pv_environnement'
      AND constraint_name = 'fk_pv_environnement_doid'
);

SET @sql = IF(
    @target_table IS NOT NULL AND @fk_exists = 0,
    CONCAT(
        'ALTER TABLE `pv_environnement` ',
        'ADD CONSTRAINT `fk_pv_environnement_doid` ',
        'FOREIGN KEY (`DOID`) REFERENCES `', @target_table, '` (`DOID`) ',
        'ON DELETE CASCADE'
    ),
    'SELECT 1'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
