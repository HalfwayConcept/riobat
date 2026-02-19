-- Migration pour simplification du stockage du type de contrôle dans travaux_annexes
ALTER TABLE `travaux_annexes`
  MODIFY `trav_annexes_ct_type_controle` varchar(50) DEFAULT NULL,
  ADD COLUMN `trav_annexes_ct_type_controle_autres` varchar(255) DEFAULT NULL,
  DROP COLUMN `trav_annexes_ct_type_controle_l_autres`,
  DROP COLUMN `trav_annexes_ct_type_controle_lth_autres`,
  DROP COLUMN `trav_annexes_ct_type_controle_le_autres`,
  DROP COLUMN `trav_annexes_ct_type_controle_leth_autres`;
