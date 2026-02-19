-- 2026_02_19_simplify_moa_table.sql
-- Suppression des champs détaillés sur la conception, direction, surveillance, exécution dans la table moa

ALTER TABLE `moa`
  DROP COLUMN `moa_conception`,
  DROP COLUMN `moa_conception_1`,
  DROP COLUMN `moa_conception_2`,
  DROP COLUMN `moa_conception_3`,
  DROP COLUMN `moa_conception_4`,
  DROP COLUMN `moa_direction`,
  DROP COLUMN `moa_direction_1`,
  DROP COLUMN `moa_direction_2`,
  DROP COLUMN `moa_direction_3`,
  DROP COLUMN `moa_direction_4`,
  DROP COLUMN `moa_surveillance`,
  DROP COLUMN `moa_surveillance_1`,
  DROP COLUMN `moa_surveillance_2`,
  DROP COLUMN `moa_surveillance_3`,
  DROP COLUMN `moa_surveillance_4`,
  DROP COLUMN `moa_execution`,
  DROP COLUMN `moa_execution_1`,
  DROP COLUMN `moa_execution_2`,
  DROP COLUMN `moa_execution_3`,
  DROP COLUMN `moa_execution_4`;
