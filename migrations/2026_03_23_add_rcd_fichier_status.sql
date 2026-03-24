-- Ajout des colonnes de statut de validation pour les fichiers RCD et annexes
ALTER TABLE rcd
    ADD COLUMN fichier_status TINYINT NOT NULL DEFAULT 0 COMMENT '0=En attente, 1=Illisible/incorrect, 2=Validation partielle, 3=Validé',
    ADD COLUMN annexe_fichier_status TINYINT NOT NULL DEFAULT 0 COMMENT '0=En attente, 1=Illisible/incorrect, 2=Validation partielle, 3=Validé';
