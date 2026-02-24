-- Table de log des échanges avec la base de données
CREATE TABLE IF NOT EXISTS log (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    DOID INT NULL,
    date_exec_log DATETIME NOT NULL,
    table_cible VARCHAR(100) NOT NULL,
    requete_sql TEXT NOT NULL,
    parametres JSON NULL,
    type_requete VARCHAR(20) NOT NULL,
    user_id INT NULL,
    statut VARCHAR(20) DEFAULT 'réussi'
);