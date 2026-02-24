-- Ajout du champ moa_nature_travaux_json à la table maître d'ouvrage (remplacer le nom de table si besoin)
ALTER TABLE moa 
ADD COLUMN moa_nature_travaux_json TEXT NULL COMMENT 'Valeurs JSON du tableau Nature des travaux';
