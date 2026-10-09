-- Pièces justificatives déposées par le souscripteur d'une étude photovoltaïque.
-- Une ligne par dossier : aucune gestion de lots n'est nécessaire.
CREATE TABLE IF NOT EXISTS pv_documents (
    DOID INT NOT NULL PRIMARY KEY,
    facture_installation_fichier VARCHAR(255) DEFAULT NULL,
    kbis_fichier VARCHAR(255) DEFAULT NULL,
    contrat_societe_fichier VARCHAR(255) DEFAULT NULL,
    toiture_geree_societe TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pv_documents_doid
        FOREIGN KEY (DOID) REFERENCES dommage_contrat(DOID)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
