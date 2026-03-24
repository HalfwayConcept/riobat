-- Ajout de la colonne role à la table utilisateur
-- Rôles : admin, collab, user (par défaut)
-- admin  : accès total (tableau de bord admin, gestion de tous les DO, gestion utilisateurs)
-- collab : consultation du tableau de bord et des DO (lecture seule)
-- user   : création et modification de ses propres DO, consultation de son profil

ALTER TABLE `utilisateur`
  ADD COLUMN `role` ENUM('admin', 'collab', 'user') NOT NULL DEFAULT 'user'
  AFTER `pass`;

-- Promouvoir l'utilisateur ID=1 en admin
UPDATE `utilisateur` SET `role` = 'admin' WHERE `ID` = 1;
