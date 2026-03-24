-- Add 'Constructeur Non Réalisateur' to rcd_nature table
INSERT INTO rcd_nature (rcd_nature_id, rcd_nature_nom) 
VALUES (6, 'Constructeur Non Réalisateur')
ON DUPLICATE KEY UPDATE rcd_nature_nom = 'Constructeur Non Réalisateur';
