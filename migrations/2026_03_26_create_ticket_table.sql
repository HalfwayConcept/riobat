-- Migration : Création de la table ticket
-- Date : 2026-03-26
-- Description : Système de tickets (bug / amélioration) pour les utilisateurs

CREATE TABLE IF NOT EXISTS `ticket` (
    `ticket_id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `date_creation`     DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `descriptif`        TEXT            NOT NULL,
    `url_page`          VARCHAR(500)    NOT NULL DEFAULT '',
    `user_id`           INT             NULL     DEFAULT NULL,
    `fichier`           VARCHAR(255)    NULL     DEFAULT NULL,
    `solution`          TEXT            NULL     DEFAULT NULL,
    `statut`            ENUM('ouvert','en_cours','en_attente','cloture') NOT NULL DEFAULT 'ouvert',
    `date_mise_a_jour`  DATETIME        NULL     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`ticket_id`),
    INDEX `idx_ticket_user` (`user_id`),
    INDEX `idx_ticket_statut` (`statut`),
    INDEX `idx_ticket_date` (`date_creation` DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
