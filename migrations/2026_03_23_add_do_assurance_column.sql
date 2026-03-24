-- Valeurs status : 0 = En cours de création, 1 = En attente des documents, 2 = Validé (offre transmise), 3 = Clôturé

-- Création de la table de référence des assurances
CREATE TABLE IF NOT EXISTS assurance (
    assurance_id INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    logo VARCHAR(255) NOT NULL COMMENT 'Nom du fichier image dans public/pictures/assurance/',
    active TINYINT NOT NULL DEFAULT 1,
    PRIMARY KEY (assurance_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertion des assurances depuis les images disponibles
INSERT INTO assurance (nom, logo) VALUES
('Albingia', 'albingia.jpg'),
('April', 'april.png'),
('Auxiliaire', 'auxiliaire.png'),
('AXRE', 'axre.png'),
('Chubb', 'chubb.jpg'),
('Entoria', 'entoria.jpg'),
('ERGO', 'ergo.png'),
('Generali', 'generali.jpg'),
('Groupama', 'groupama.png'),
('QBE', 'qbe.jpg'),
('Tetris', 'tetris.png');

-- Ajout de la clé étrangère assurance_id dans dommage_ouvrage
ALTER TABLE dommage_ouvrage
    ADD COLUMN assurance_id INT DEFAULT NULL COMMENT 'Référence vers la table assurance',
    ADD KEY fk_do_assurance (assurance_id),
    ADD CONSTRAINT fk_do_assurance FOREIGN KEY (assurance_id) REFERENCES assurance(assurance_id) ON DELETE SET NULL ON UPDATE CASCADE;
