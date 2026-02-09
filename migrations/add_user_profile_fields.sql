-- Migration: Add professional info fields to utilisateur table
-- Description: Adds siret, adresse, code_postal, commune, profession, telephone columns

ALTER TABLE `utilisateur` ADD COLUMN `siret` varchar(255) DEFAULT NULL AFTER `email`;
ALTER TABLE `utilisateur` ADD COLUMN `adresse` varchar(255) DEFAULT NULL AFTER `siret`;
ALTER TABLE `utilisateur` ADD COLUMN `code_postal` varchar(10) DEFAULT NULL AFTER `adresse`;
ALTER TABLE `utilisateur` ADD COLUMN `commune` varchar(255) DEFAULT NULL AFTER `code_postal`;
ALTER TABLE `utilisateur` ADD COLUMN `profession` varchar(255) DEFAULT NULL AFTER `commune`;
ALTER TABLE `utilisateur` ADD COLUMN `telephone` varchar(20) DEFAULT NULL AFTER `profession`;

-- If you need to see the changes, run:
-- DESCRIBE utilisateur;
