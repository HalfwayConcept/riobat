-- Table des qualités du maître d'ouvrage (moa_qualite)
CREATE TABLE `moa_qualite` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(32) NOT NULL UNIQUE,
  `label` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `moa_qualite` (`code`, `label`) VALUES
('etat', 'Etat (services publics)'),
('hlm_public', "Organismes d'habitations à loyer modéré (secteur public)"),
('syndic', 'Syndicats de copropriétaires'),
('vendeur_prive', 'Vendeur privé après achèvement'),
('sci', 'Société Civile Immobilière'),
('entreprise', 'Entreprise'),
('collectivites', 'Collectivités locales'),
('hlm_prive', "Organismes d'habitations à loyer modéré (secteur privé)"),
('vendeur_prive_imm', "Vendeur privé d'immeubles à construire"),
('particulier', 'Particulier'),
('prom_prive', 'Promoteur privé immobilier'),
('asso', 'Association');
