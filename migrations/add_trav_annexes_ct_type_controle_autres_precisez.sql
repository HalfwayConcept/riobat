-- Migration SQL : Ajout du champ trav_annexes_ct_type_controle_autres_precisez
ALTER TABLE `do` 
ADD COLUMN `trav_annexes_ct_type_controle_autres_precisez` VARCHAR(255) NULL DEFAULT NULL AFTER `trav_annexes_ct_type_controle`;
