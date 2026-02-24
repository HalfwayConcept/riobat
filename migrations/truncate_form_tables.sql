-- Script de nettoyage des tables principales du formulaire DO
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE `travaux_annexes`;
TRUNCATE TABLE `dommage_ouvrage`;
TRUNCATE TABLE `entreprise`;
TRUNCATE TABLE `moa`;
TRUNCATE TABLE `operation_construction`;
TRUNCATE TABLE `rcd`;
TRUNCATE TABLE `situation`;
TRUNCATE TABLE `souscripteur`;
SET FOREIGN_KEY_CHECKS=1;
