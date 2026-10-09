CREATE TABLE IF NOT EXISTS pv_document_upload_token (
    token CHAR(64) PRIMARY KEY,
    DOID INT NOT NULL,
    created_by INT DEFAULT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_pv_document_upload_doid (DOID),
    CONSTRAINT fk_pv_document_upload_doid
        FOREIGN KEY (DOID) REFERENCES dommage_contrat(DOID)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
