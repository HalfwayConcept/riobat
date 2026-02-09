-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 09 fév. 2026 à 15:02
-- Version du serveur : 11.4.10-MariaDB
-- Version de PHP : 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ruki5964_riobat`
--

-- --------------------------------------------------------

--
-- Structure de la table `dommage_ouvrage`
--

CREATE TABLE `dommage_ouvrage` (
  `DOID` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `repertoire` varchar(255) NOT NULL,
  `souscripteur_id` int(11) NOT NULL,
  `date_creation` date NOT NULL DEFAULT current_timestamp(),
  `date_modification` date DEFAULT NULL,
  `date_validation` date DEFAULT NULL,
  `garantie_do` tinyint(4) NOT NULL,
  `garantie_chantier` tinyint(4) NOT NULL,
  `garantie_juridique` tinyint(4) NOT NULL,
  `moe` tinyint(4) NOT NULL,
  `moe_entreprise_id` int(11) NOT NULL,
  `intervention_moe_independant` tinyint(4) NOT NULL,
  `intervention_moe_independant_qualite` varchar(255) NOT NULL,
  `intervention_moe_independant_mission` enum('conception','direction','complete','autre') NOT NULL,
  `intervention_moe_independant_mission_autre_descr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dommage_ouvrage`
--

INSERT INTO `dommage_ouvrage` (`DOID`, `status`, `repertoire`, `souscripteur_id`, `date_creation`, `date_modification`, `date_validation`, `garantie_do`, `garantie_chantier`, `garantie_juridique`, `moe`, `moe_entreprise_id`, `intervention_moe_independant`, `intervention_moe_independant_qualite`, `intervention_moe_independant_mission`, `intervention_moe_independant_mission_autre_descr`) VALUES
(127, 0, '0000a8945fd8', 129, '2025-07-03', NULL, NULL, 0, 0, 0, 1, 116, 1, '', 'conception', ''),
(129, 0, 'ce400bab89b5', 131, '2025-07-03', NULL, NULL, 0, 0, 0, 0, 0, 0, '', 'conception', ''),
(130, 0, '3ccd8325c2b6', 132, '2025-07-03', NULL, NULL, 0, 0, 0, 0, 0, 0, '', 'conception', ''),
(131, 0, '8af6265e8521', 133, '2025-07-04', NULL, NULL, 0, 0, 0, 0, 0, 0, '', 'conception', ''),
(132, 0, 'affb52e1d895', 134, '2025-07-05', NULL, NULL, 0, 0, 0, 0, 0, 0, '', 'conception', '');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `ID` int(11) NOT NULL,
  `raison_sociale` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `code_postal` varchar(255) NOT NULL,
  `commune` varchar(255) NOT NULL,
  `numero_siret` varchar(255) NOT NULL,
  `type` enum('boi','phv','geo','ctt','cnr','sol','moe','moa') NOT NULL,
  `num_contrat` varchar(255) NOT NULL,
  `nat_juri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`ID`, `raison_sociale`, `nom`, `prenom`, `adresse`, `code_postal`, `commune`, `numero_siret`, `type`, `num_contrat`, `nat_juri`) VALUES
(109, 'Nom entreprise- BOIS', 'Nom Dirigeant - BOIS', 'Prénom Dirigeant - BOIS', 'Adresse Bois', '', 'Commune Bois', 'Siret Bois', 'boi', '', ''),
(110, 'Nom Entreprise PHV', 'Nom Dirigeant - PHV', 'Prénom Dirigeant - PHV', 'Adresse PHV', '', 'Commune Phv', '165162165156 PHV', 'phv', '', ''),
(111, 'Francois', 'MOE Nom', 'MOE PRENOM', '16 rue de la commune', '', 'LANGONGE', '', 'moe', '', ''),
(112, '', 'LP SEI HAND', '', '', '', '', '', 'sol', '', ''),
(113, 'A remplir', 'Architecte', 'A remplir', '', '', '', '', 'moe', '', ''),
(114, 'Francois', 'Regis', '', '16 rue de la commune', '', 'LANGONGE', '5165415615', 'boi', '', ''),
(115, 'LP SEI HAND', 'Mr X', '', '', '', '', '', 'cnr', '', ''),
(116, 'LP SEI HAND', 'Mr X', '', '', '', 'mende', '', 'moe', '', ''),
(117, 'ELEC PV', '', '', '', '', '', '', 'phv', '', ''),
(118, '', '', '', '', '', '', '', 'phv', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `moa`
--

CREATE TABLE `moa` (
  `DOID` int(11) NOT NULL,
  `moa_souscripteur` tinyint(1) DEFAULT NULL,
  `moa_souscripteur_form_civilite` enum('particulier','entreprise') DEFAULT NULL,
  `moa_souscripteur_form_nom_prenom` varchar(255) DEFAULT NULL,
  `moa_souscripteur_form_adresse` varchar(255) DEFAULT NULL,
  `moa_souscripteur_form_raison_sociale` varchar(255) DEFAULT NULL,
  `moa_souscripteur_form_siret` varchar(255) DEFAULT NULL,
  `moa_qualite` enum('etat','hlm_public','syndic','vendeur_prive','sci','entreprise','moa_qualite_autre','collectivites','hlm_prive','vendeur_prive_imm','particulier','prom_prive','asso') DEFAULT NULL,
  `moa_qualite_champ` varchar(255) DEFAULT NULL,
  `moa_construction` tinyint(1) DEFAULT NULL,
  `moa_construction_pro` tinyint(1) DEFAULT NULL,
  `moa_construction_pro_champ` varchar(255) DEFAULT NULL,
  `moa_conception` tinyint(1) DEFAULT NULL,
  `moa_conception_1` tinyint(1) DEFAULT NULL,
  `moa_conception_2` tinyint(1) DEFAULT NULL,
  `moa_conception_3` tinyint(1) DEFAULT NULL,
  `moa_conception_4` varchar(255) DEFAULT NULL,
  `moa_direction` tinyint(1) DEFAULT NULL,
  `moa_direction_1` tinyint(1) DEFAULT NULL,
  `moa_direction_2` tinyint(1) DEFAULT NULL,
  `moa_direction_3` tinyint(1) DEFAULT NULL,
  `moa_direction_4` varchar(255) DEFAULT NULL,
  `moa_surveillance` tinyint(1) DEFAULT NULL,
  `moa_surveillance_1` tinyint(1) DEFAULT NULL,
  `moa_surveillance_2` tinyint(1) DEFAULT NULL,
  `moa_surveillance_3` tinyint(1) DEFAULT NULL,
  `moa_surveillance_4` varchar(255) DEFAULT NULL,
  `moa_execution` tinyint(1) DEFAULT NULL,
  `moa_execution_1` tinyint(1) DEFAULT NULL,
  `moa_execution_2` tinyint(1) DEFAULT NULL,
  `moa_execution_3` tinyint(1) DEFAULT NULL,
  `moa_execution_4` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `moa`
--

INSERT INTO `moa` (`DOID`, `moa_souscripteur`, `moa_souscripteur_form_civilite`, `moa_souscripteur_form_nom_prenom`, `moa_souscripteur_form_adresse`, `moa_souscripteur_form_raison_sociale`, `moa_souscripteur_form_siret`, `moa_qualite`, `moa_qualite_champ`, `moa_construction`, `moa_construction_pro`, `moa_construction_pro_champ`, `moa_conception`, `moa_conception_1`, `moa_conception_2`, `moa_conception_3`, `moa_conception_4`, `moa_direction`, `moa_direction_1`, `moa_direction_2`, `moa_direction_3`, `moa_direction_4`, `moa_surveillance`, `moa_surveillance_1`, `moa_surveillance_2`, `moa_surveillance_3`, `moa_surveillance_4`, `moa_execution`, `moa_execution_1`, `moa_execution_2`, `moa_execution_3`, `moa_execution_4`) VALUES
(127, 0, 'entreprise', 'SCI IMMO', '3 chemin de Sejalan 48000 MENDE', 'SCI IMMO', NULL, 'sci', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `operation_construction`
--

CREATE TABLE `operation_construction` (
  `DOID` int(11) NOT NULL,
  `nature_neuf_exist` enum('neuve','existante') DEFAULT NULL,
  `nature_operation_surelev` tinyint(1) DEFAULT NULL,
  `nature_operation_surelev_sous_oeuvre` tinyint(1) DEFAULT NULL,
  `nature_operation_surelev_hors_fond` tinyint(1) DEFAULT NULL,
  `nature_operation_ext_horizont` tinyint(1) DEFAULT NULL,
  `nature_operation_ext_horizont_exist` tinyint(1) DEFAULT NULL,
  `nature_operation_renovation` tinyint(1) DEFAULT NULL,
  `nature_operation_renovation_fond` tinyint(1) DEFAULT NULL,
  `nature_operation_renovation_iso_therm` tinyint(1) DEFAULT NULL,
  `nature_operation_renovation_refect_toit` tinyint(1) DEFAULT NULL,
  `nature_operation_renovation_etancheite` tinyint(1) DEFAULT NULL,
  `nature_operation_renovation_ravalement` tinyint(1) DEFAULT NULL,
  `nature_operation_rehabilitation` tinyint(1) DEFAULT NULL,
  `nature_operation_rehabilitation_fond` tinyint(1) DEFAULT NULL,
  `nature_operation_rehabilitation_iso_therm` tinyint(1) DEFAULT NULL,
  `nature_operation_rehabilitation_refect_toit` tinyint(1) DEFAULT NULL,
  `nature_operation_rehabilitation_etancheite` tinyint(1) DEFAULT NULL,
  `nature_operation_rehabilitation_ravalement` tinyint(1) DEFAULT NULL,
  `operation_sinistre` tinyint(1) DEFAULT NULL,
  `operation_sinistre_descr` text DEFAULT NULL,
  `type_ouvrage_mais_indiv` tinyint(1) DEFAULT NULL,
  `type_ouvrage_mais_indiv_piscine` tinyint(1) DEFAULT NULL,
  `type_ouvrage_mais_indiv_piscine_situation` varchar(255) DEFAULT NULL,
  `type_ouvrage_ope_pavill` tinyint(1) DEFAULT NULL,
  `type_ouvrage_ope_pavill_nombre` int(11) DEFAULT NULL,
  `type_ouvrage_coll_habit` tinyint(1) DEFAULT NULL,
  `type_ouvrage_coll_habit_nombre` int(11) DEFAULT NULL,
  `type_ouvrage_bat_indus` tinyint(1) DEFAULT NULL,
  `type_ouvrage_centre_com` tinyint(1) DEFAULT NULL,
  `type_ouvrage_centre_com_surf` int(11) DEFAULT NULL,
  `type_ouvrage_bat_bur` tinyint(1) DEFAULT NULL,
  `type_ouvrage_hopital` tinyint(1) DEFAULT NULL,
  `type_ouvrage_vrd_privatif` tinyint(1) DEFAULT NULL,
  `type_ouvrage_autre_const` tinyint(1) DEFAULT NULL,
  `type_ouvrage_autre_const_usage` varchar(255) DEFAULT NULL,
  `construction_adresse_esc_res_bat` varchar(255) DEFAULT NULL,
  `construction_adresse_num_nom_rue` varchar(255) DEFAULT NULL,
  `construction_adresse_lieu_dit` varchar(255) DEFAULT NULL,
  `construction_adresse_arrond` varchar(255) DEFAULT NULL,
  `construction_adresse_code_postal` int(11) DEFAULT NULL,
  `construction_adresse_commune` varchar(255) DEFAULT NULL,
  `construction_date_debut` date DEFAULT NULL,
  `construction_date_debut_prevue` date DEFAULT NULL,
  `construction_date_reception` date DEFAULT NULL,
  `construction_cout_operation` decimal(10,0) DEFAULT NULL,
  `construction_cout_honoraires_moe` decimal(10,0) DEFAULT NULL,
  `cout_operation_tva` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `operation_construction`
--

INSERT INTO `operation_construction` (`DOID`, `nature_neuf_exist`, `nature_operation_surelev`, `nature_operation_surelev_sous_oeuvre`, `nature_operation_surelev_hors_fond`, `nature_operation_ext_horizont`, `nature_operation_ext_horizont_exist`, `nature_operation_renovation`, `nature_operation_renovation_fond`, `nature_operation_renovation_iso_therm`, `nature_operation_renovation_refect_toit`, `nature_operation_renovation_etancheite`, `nature_operation_renovation_ravalement`, `nature_operation_rehabilitation`, `nature_operation_rehabilitation_fond`, `nature_operation_rehabilitation_iso_therm`, `nature_operation_rehabilitation_refect_toit`, `nature_operation_rehabilitation_etancheite`, `nature_operation_rehabilitation_ravalement`, `operation_sinistre`, `operation_sinistre_descr`, `type_ouvrage_mais_indiv`, `type_ouvrage_mais_indiv_piscine`, `type_ouvrage_mais_indiv_piscine_situation`, `type_ouvrage_ope_pavill`, `type_ouvrage_ope_pavill_nombre`, `type_ouvrage_coll_habit`, `type_ouvrage_coll_habit_nombre`, `type_ouvrage_bat_indus`, `type_ouvrage_centre_com`, `type_ouvrage_centre_com_surf`, `type_ouvrage_bat_bur`, `type_ouvrage_hopital`, `type_ouvrage_vrd_privatif`, `type_ouvrage_autre_const`, `type_ouvrage_autre_const_usage`, `construction_adresse_esc_res_bat`, `construction_adresse_num_nom_rue`, `construction_adresse_lieu_dit`, `construction_adresse_arrond`, `construction_adresse_code_postal`, `construction_adresse_commune`, `construction_date_debut`, `construction_date_debut_prevue`, `construction_date_reception`, `construction_cout_operation`, `construction_cout_honoraires_moe`, `cout_operation_tva`) VALUES
(127, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, 'ZAC ', 'Lou CHAOUSSE ', NULL, NULL, 48000, 'MENDE', '2025-07-10', '2025-07-15', '2028-07-30', 11000000, 0, 1),
(129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rcd`
--

CREATE TABLE `rcd` (
  `rcd_id` int(11) NOT NULL,
  `DOID` int(11) NOT NULL,
  `rcd_entreprise_id` int(11) NOT NULL,
  `rcd_nature_id` int(11) NOT NULL,
  `rcd_nature_autre` varchar(255) NOT NULL,
  `rcd_nom` varchar(255) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `fichier_remarque` text NOT NULL,
  `annexe_fichier` varchar(255) NOT NULL,
  `annexe_fichier_remarque` text NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `construction_date_debut` date NOT NULL,
  `construction_date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rcd`
--

INSERT INTO `rcd` (`rcd_id`, `DOID`, `rcd_entreprise_id`, `rcd_nature_id`, `rcd_nature_autre`, `rcd_nom`, `fichier`, `fichier_remarque`, `annexe_fichier`, `annexe_fichier_remarque`, `montant`, `construction_date_debut`, `construction_date_fin`) VALUES
(40, 127, 0, 3, '', 'GEVAUBOIS', '', '', '', '', 120000, '0000-00-00', '0000-00-00'),
(41, 127, 0, 28, '', 'PLOMBIER 48', '', '', '', '', 35000, '0000-00-00', '0000-00-00'),
(42, 130, 117, 5, '', 'PV', '', '', '', '', 15000, '0000-00-00', '0000-00-00'),
(43, 130, 0, 28, '', 'PLOMBIER ', '', '', '', '', 12000, '0000-00-00', '0000-00-00'),
(44, 130, 0, 29, '', 'MO', '', '', '', '', 0, '0000-00-00', '0000-00-00'),
(45, 130, 0, 34, '', 'Artisan', '', '', '', '', 45000, '0000-00-00', '0000-00-00'),
(46, 127, 118, 5, '', '', '', '', '', '', 0, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `rcd_nature`
--

CREATE TABLE `rcd_nature` (
  `rcd_nature_id` int(11) NOT NULL,
  `rcd_nature_nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rcd_nature`
--

INSERT INTO `rcd_nature` (`rcd_nature_id`, `rcd_nature_nom`) VALUES
(1, 'Contrôleur technique'),
(2, 'Etude de sol'),
(3, 'Construction en bois'),
(4, 'Installation géothermique'),
(5, 'Photovoltaïques'),
(21, 'BET\r\n'),
(22, 'Ingénieur conseil'),
(23, 'Maçonnerie'),
(24, 'Enduit'),
(25, 'Charpente bois'),
(26, 'Charpente métallique'),
(27, 'Couverture / étanchéité'),
(28, 'Plomberie'),
(29, 'Carrelage'),
(30, 'Menuiseries'),
(31, 'Plaques de plâtres'),
(32, 'Revêtements souples sols murs'),
(33, 'Électricité'),
(34, 'Fondation'),
(35, 'Terrassement');

-- --------------------------------------------------------

--
-- Structure de la table `situation`
--

CREATE TABLE `situation` (
  `DOID` int(11) NOT NULL,
  `situation_zone_inond` tinyint(1) DEFAULT NULL,
  `situation_sismique` int(11) DEFAULT NULL,
  `situation_insectes` tinyint(1) DEFAULT NULL,
  `situation_proc_techniques` tinyint(1) DEFAULT NULL,
  `situation_parking` tinyint(1) DEFAULT NULL,
  `situation_do_10ans` tinyint(1) DEFAULT NULL,
  `situation_do_10ans_contrat_assureur` varchar(255) DEFAULT NULL,
  `situation_do_10ans_contrat_numero` varchar(255) DEFAULT NULL,
  `situation_mon_hist` tinyint(1) DEFAULT NULL,
  `situation_label_energie` tinyint(1) DEFAULT NULL,
  `situation_label_qualite` tinyint(1) DEFAULT NULL,
  `situation_sol` tinyint(1) DEFAULT NULL,
  `sol_entreprise_id` int(11) DEFAULT NULL,
  `situation_sol_bureau_mission` enum('g2_amp','g2_pro','etude_sol_autre') DEFAULT NULL,
  `situation_sol_bureau_mission_champ` varchar(255) DEFAULT NULL,
  `situation_sol_parking` tinyint(1) DEFAULT NULL,
  `situation_garanties_completes` tinyint(1) DEFAULT NULL,
  `situation_garanties_dommages_existants` tinyint(1) DEFAULT NULL,
  `situation_boi` tinyint(1) DEFAULT NULL,
  `situation_phv` tinyint(1) DEFAULT NULL,
  `situation_geo` tinyint(1) DEFAULT NULL,
  `situation_ctt` tinyint(1) DEFAULT NULL,
  `situation_cnr` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `situation`
--

INSERT INTO `situation` (`DOID`, `situation_zone_inond`, `situation_sismique`, `situation_insectes`, `situation_proc_techniques`, `situation_parking`, `situation_do_10ans`, `situation_do_10ans_contrat_assureur`, `situation_do_10ans_contrat_numero`, `situation_mon_hist`, `situation_label_energie`, `situation_label_qualite`, `situation_sol`, `sol_entreprise_id`, `situation_sol_bureau_mission`, `situation_sol_bureau_mission_champ`, `situation_sol_parking`, `situation_garanties_completes`, `situation_garanties_dommages_existants`, `situation_boi`, `situation_phv`, `situation_geo`, `situation_ctt`, `situation_cnr`) VALUES
(127, 0, 2, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 1),
(129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `souscripteur`
--

CREATE TABLE `souscripteur` (
  `souscripteur_id` int(11) NOT NULL,
  `souscripteur_nom_raison` varchar(255) NOT NULL,
  `souscripteur_siret` varchar(255) DEFAULT NULL,
  `souscripteur_adresse` varchar(255) NOT NULL,
  `souscripteur_code_postal` int(11) NOT NULL,
  `souscripteur_commune` varchar(255) NOT NULL,
  `souscripteur_profession` varchar(255) DEFAULT NULL,
  `souscripteur_telephone` varchar(255) NOT NULL,
  `souscripteur_email` varchar(255) NOT NULL,
  `souscripteur_ancien_client_date` date DEFAULT NULL,
  `souscripteur_ancien_client_num` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `souscripteur`
--

INSERT INTO `souscripteur` (`souscripteur_id`, `souscripteur_nom_raison`, `souscripteur_siret`, `souscripteur_adresse`, `souscripteur_code_postal`, `souscripteur_commune`, `souscripteur_profession`, `souscripteur_telephone`, `souscripteur_email`, `souscripteur_ancien_client_date`, `souscripteur_ancien_client_num`) VALUES
(123, 'Christophe Leydier', '', '20 Rue de la Margeride', 48300, 'Langogne', '', '0664824793', 'christophe_leydier@hotmail.com', '2025-01-02', '5645646'),
(124, 'Christophe Leydier', '', '20 Rue de la Margeride', 48300, 'Langogne', '', '0664824793', 'christophe_leydier@hotmail.com', '2025-01-02', '5645646'),
(125, 'SCI NOT IMMO48', '', '3 Chemin de sejauan', 48000, 'MENDE', '', '04XXXXXXXX', 'scinotimmo48@gmail.com', '0000-00-00', ''),
(126, 'Nom, Prénom et/ou Raison Sociale', 'Siret 1', 'Adresse 1', 0, 'Commune 1', 'Prof', '04XXXXXXX', 'email1@gmail.com', '2025-06-27', '21519512'),
(127, 'Christophe Leydier', '', '20 Rue de la Margeride', 48300, 'Langogne', '', '0664824793', 'christophe_leydier@hotmail.com', '0000-00-00', ''),
(128, 'Christophe Leydier', '', '20 Rue de la Margeride', 48300, 'Langogne', '', '0664824793', 'christophe_leydier@hotmail.com', '0000-00-00', ''),
(129, 'SCI NOT IMMO 48', '', '3 chemin de Sejalan', 48000, 'MENDE', '', '0411223344', 'email@email.com', '0000-00-00', ''),
(130, 'Nom, Prénom et/ou Raison Sociale', '', 'rue de la construction', 43000, 'LFIRMINY', '', '0141418364', 'ludivine.martin@mail.com', '0000-00-00', ''),
(131, 'SCI NOT IMMO 48', '', '3 chemin de Sejalan', 48000, 'MENDE', '', '0411223344', 'email@email.com', '0000-00-00', ''),
(132, 'SCI NOT IMMO 48', '', '3 chemin de Sejalan', 48000, 'MENDE', '', '0411223344', 'email@email.com', '0000-00-00', ''),
(133, 'Bruno', '', '1111111', 430000, 'LE PUY', '', '0466656565', 'AAA@orange.fr', '0000-00-00', ''),
(134, 'Vincent', '', '5 bd du soubeyrand', 48000, 'Mende', '', '0466657979', 'vincent@vincent.fr', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Structure de la table `travaux_annexes`
--

CREATE TABLE `travaux_annexes` (
  `DOID` int(11) NOT NULL,
  `boi_entreprise_id` int(11) DEFAULT NULL,
  `trav_annexes_constr_bois` tinyint(1) DEFAULT NULL,
  `trav_annexes_constr_bois_enveloppe` tinyint(1) DEFAULT NULL,
  `phv_entreprise_id` int(11) DEFAULT NULL,
  `trav_annexes_pv_montage` enum('integre','surimpose','autre') DEFAULT NULL,
  `trav_annexes_pv_etn` tinyint(1) DEFAULT NULL,
  `trav_annexes_pv_liste_c2p` tinyint(1) DEFAULT NULL,
  `trav_annexes_pv_surface` int(11) DEFAULT NULL,
  `trav_annexes_pv_proc_tech` tinyint(1) DEFAULT NULL,
  `trav_annexes_pv_puissance` int(11) DEFAULT NULL,
  `trav_annexes_pv_destination` enum('revente','autocons') DEFAULT NULL,
  `geo_entreprise_id` int(11) DEFAULT NULL,
  `trav_annexes_constr_produits_ce` tinyint(1) DEFAULT NULL,
  `trav_annexes_ct_type_controle` enum('l','lth','le','leth','lautre','lthautre','leautre','lethautre') DEFAULT NULL,
  `trav_annexes_ct_type_controle_l_autres` varchar(255) DEFAULT NULL,
  `trav_annexes_ct_type_controle_lth_autres` varchar(255) DEFAULT NULL,
  `trav_annexes_ct_type_controle_le_autres` varchar(255) DEFAULT NULL,
  `trav_annexes_ct_type_controle_leth_autres` varchar(255) DEFAULT NULL,
  `cnr_entreprise_id` int(11) NOT NULL,
  `cnr_qualite` varchar(255) NOT NULL,
  `ctt_entreprise_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `travaux_annexes`
--

INSERT INTO `travaux_annexes` (`DOID`, `boi_entreprise_id`, `trav_annexes_constr_bois`, `trav_annexes_constr_bois_enveloppe`, `phv_entreprise_id`, `trav_annexes_pv_montage`, `trav_annexes_pv_etn`, `trav_annexes_pv_liste_c2p`, `trav_annexes_pv_surface`, `trav_annexes_pv_proc_tech`, `trav_annexes_pv_puissance`, `trav_annexes_pv_destination`, `geo_entreprise_id`, `trav_annexes_constr_produits_ce`, `trav_annexes_ct_type_controle`, `trav_annexes_ct_type_controle_l_autres`, `trav_annexes_ct_type_controle_lth_autres`, `trav_annexes_ct_type_controle_le_autres`, `trav_annexes_ct_type_controle_leth_autres`, `cnr_entreprise_id`, `cnr_qualite`, `ctt_entreprise_id`) VALUES
(127, NULL, NULL, NULL, 118, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 115, '', NULL),
(129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(130, NULL, NULL, NULL, 117, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(132, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `utilisateur_date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`ID`, `nom`, `prenom`, `email`, `pass`, `utilisateur_date_creation`) VALUES
(1, 'ADMIN', '', 'admin@admin.com', '25f9e794323b453885f5181f1b624d0b', '2024-10-03 09:57:58'),
(2, 'COTTON', 'Alexandre', 'alexandre.cotton@mma.fr', '1697918c7f9551712f531143df2f8a37', '2024-10-04 15:14:01'),
(13, 'Leydier', 'Christophe', 'christophe_leydier@hotmail.com', '916b1f8ffa36850547113519050a76e3', '2024-10-14 08:21:41'),
(14, 'LEYDIER', 'Christophe', 'c.leydier@velay.greta.fr', '1697918c7f9551712f531143df2f8a37', '2024-10-15 09:52:20'),
(15, 'Ludivine', 'MARTIN', 'ludivine.martin@mail.com', '25f9e794323b453885f5181f1b624d0b', '2025-05-20 11:41:52');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_session`
--

CREATE TABLE `utilisateur_session` (
  `utilisateur_session_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `DOID` int(255) NOT NULL,
  `session_debut` datetime NOT NULL DEFAULT current_timestamp(),
  `session_maj` datetime NOT NULL DEFAULT current_timestamp(),
  `session_fin` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur_session`
--

INSERT INTO `utilisateur_session` (`utilisateur_session_id`, `utilisateur_id`, `DOID`, `session_debut`, `session_maj`, `session_fin`) VALUES
(39, 15, 121, '2025-05-27 16:22:11', '2025-05-27 16:22:11', NULL),
(40, 15, 122, '2025-06-05 13:42:47', '2025-06-05 13:42:47', NULL),
(41, 1, 123, '2025-06-23 11:20:26', '2025-06-23 11:20:26', NULL),
(42, 1, 124, '2025-06-23 13:45:09', '2025-06-23 13:45:09', NULL),
(43, 1, 125, '2025-06-24 15:03:08', '2025-06-24 15:03:08', NULL),
(44, 1, 126, '2025-06-24 15:04:50', '2025-06-24 15:04:50', NULL),
(45, 1, 127, '2025-07-03 16:14:16', '2025-07-03 16:14:16', NULL),
(46, 1, 128, '2025-07-03 16:17:19', '2025-07-03 16:17:19', NULL),
(47, 1, 129, '2025-07-03 16:48:40', '2025-07-03 16:48:40', NULL),
(48, 1, 130, '2025-07-03 16:50:12', '2025-07-03 16:50:12', NULL),
(49, 1, 131, '2025-07-04 15:11:41', '2025-07-04 15:11:41', NULL),
(50, 1, 132, '2025-07-05 09:14:53', '2025-07-05 09:14:53', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dommage_ouvrage`
--
ALTER TABLE `dommage_ouvrage`
  ADD PRIMARY KEY (`DOID`),
  ADD KEY `souscripteur_id` (`souscripteur_id`),
  ADD KEY `moe_entreprise_id` (`moe_entreprise_id`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `moa`
--
ALTER TABLE `moa`
  ADD PRIMARY KEY (`DOID`);

--
-- Index pour la table `operation_construction`
--
ALTER TABLE `operation_construction`
  ADD PRIMARY KEY (`DOID`);

--
-- Index pour la table `rcd`
--
ALTER TABLE `rcd`
  ADD PRIMARY KEY (`rcd_id`),
  ADD KEY `cnr_doid` (`DOID`),
  ADD KEY `rcd_nature_id` (`rcd_nature_id`);

--
-- Index pour la table `rcd_nature`
--
ALTER TABLE `rcd_nature`
  ADD PRIMARY KEY (`rcd_nature_id`);

--
-- Index pour la table `situation`
--
ALTER TABLE `situation`
  ADD PRIMARY KEY (`DOID`),
  ADD KEY `sol_entreprise_id` (`sol_entreprise_id`);

--
-- Index pour la table `souscripteur`
--
ALTER TABLE `souscripteur`
  ADD PRIMARY KEY (`souscripteur_id`),
  ADD KEY `souscripteur_id` (`souscripteur_id`);

--
-- Index pour la table `travaux_annexes`
--
ALTER TABLE `travaux_annexes`
  ADD PRIMARY KEY (`DOID`),
  ADD KEY `bois_entreprise_id` (`boi_entreprise_id`),
  ADD KEY `pv_entreprise_id` (`phv_entreprise_id`),
  ADD KEY `geo_entreprise_id` (`geo_entreprise_id`),
  ADD KEY `ct_entreprise_id` (`ctt_entreprise_id`),
  ADD KEY `cnr_entreprise_id` (`cnr_entreprise_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `utilisateur_session`
--
ALTER TABLE `utilisateur_session`
  ADD PRIMARY KEY (`utilisateur_session_id`),
  ADD KEY `session_id` (`DOID`),
  ADD KEY `utilisateur_id` (`utilisateur_id`,`DOID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dommage_ouvrage`
--
ALTER TABLE `dommage_ouvrage`
  MODIFY `DOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT pour la table `rcd`
--
ALTER TABLE `rcd`
  MODIFY `rcd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `rcd_nature`
--
ALTER TABLE `rcd_nature`
  MODIFY `rcd_nature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `souscripteur`
--
ALTER TABLE `souscripteur`
  MODIFY `souscripteur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `utilisateur_session`
--
ALTER TABLE `utilisateur_session`
  MODIFY `utilisateur_session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dommage_ouvrage`
--
ALTER TABLE `dommage_ouvrage`
  ADD CONSTRAINT `dommage_ouvrage_ibfk_1` FOREIGN KEY (`souscripteur_id`) REFERENCES `souscripteur` (`souscripteur_id`);

--
-- Contraintes pour la table `rcd`
--
ALTER TABLE `rcd`
  ADD CONSTRAINT `rcd_ibfk_1` FOREIGN KEY (`rcd_nature_id`) REFERENCES `rcd_nature` (`rcd_nature_id`),
  ADD CONSTRAINT `rcd_ibfk_2` FOREIGN KEY (`DOID`) REFERENCES `dommage_ouvrage` (`DOID`);

--
-- Contraintes pour la table `travaux_annexes`
--
ALTER TABLE `travaux_annexes`
  ADD CONSTRAINT `travaux_annexes_ibfk_1` FOREIGN KEY (`boi_entreprise_id`) REFERENCES `entreprise` (`ID`),
  ADD CONSTRAINT `travaux_annexes_ibfk_2` FOREIGN KEY (`phv_entreprise_id`) REFERENCES `entreprise` (`ID`),
  ADD CONSTRAINT `travaux_annexes_ibfk_3` FOREIGN KEY (`geo_entreprise_id`) REFERENCES `entreprise` (`ID`),
  ADD CONSTRAINT `travaux_annexes_ibfk_4` FOREIGN KEY (`ctt_entreprise_id`) REFERENCES `entreprise` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
