-- MIGRATION: Remplacer le champ `code` par un id auto-incrémenté dans moa_qualite et adapter les données
ALTER TABLE `moa_qualite` DROP INDEX `code`;
ALTER TABLE `moa_qualite` DROP COLUMN `code`;
-- Si des clés étrangères pointaient sur `code`, il faut les adapter pour pointer sur `id` (à faire dans les autres tables)
