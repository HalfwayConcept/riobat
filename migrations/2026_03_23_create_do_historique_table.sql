-- Table d'historique des actions sur les dommages ouvrages
CREATE TABLE IF NOT EXISTS do_historique (
    id_historique INT AUTO_INCREMENT PRIMARY KEY,
    DOID INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    user_id INT NULL,
    user_nom VARCHAR(255) NULL,
    date_action DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    details TEXT NULL,
    FOREIGN KEY (DOID) REFERENCES dommage_ouvrage(DOID) ON DELETE CASCADE
);
