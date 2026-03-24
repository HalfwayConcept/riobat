-- Migration : Ajout du drapeau is_test pour identifier les DO créés par le test runner
ALTER TABLE `dommage_ouvrage`
  ADD COLUMN `is_test` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`;
