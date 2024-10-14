-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 11 oct. 2024 à 17:11
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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
  `souscripteur_id` int(11) NOT NULL,
  `date_creation` date NOT NULL DEFAULT current_timestamp(),
  `date_modification` date DEFAULT NULL,
  `date_validation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dommage_ouvrage`
--

INSERT INTO `dommage_ouvrage` (`DOID`, `souscripteur_id`, `date_creation`, `date_modification`, `date_validation`) VALUES
(80, 81, '2024-05-28', NULL, NULL),
(81, 82, '2024-05-28', NULL, NULL),
(82, 83, '2024-05-28', NULL, NULL),
(83, 84, '2024-05-28', NULL, NULL),
(84, 85, '2024-05-28', NULL, NULL),
(85, 86, '2024-05-28', NULL, NULL),
(88, 89, '2024-05-29', NULL, NULL),
(89, 90, '2024-10-07', NULL, NULL),
(90, 91, '2024-10-09', NULL, NULL),
(91, 92, '2024-10-09', NULL, NULL),
(92, 93, '2024-10-11', NULL, NULL),
(93, 94, '2024-10-11', NULL, NULL),
(94, 95, '2024-10-11', NULL, NULL),
(95, 96, '2024-10-11', NULL, NULL);

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
  `type` enum('boi','phv','geo','ctt','cnr','sol') NOT NULL,
  `num_contrat` varchar(255) NOT NULL,
  `nat_juri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`ID`, `raison_sociale`, `nom`, `prenom`, `adresse`, `code_postal`, `commune`, `numero_siret`, `type`, `num_contrat`, `nat_juri`) VALUES
(47, '', 'CONS', 'Contructeur NOM', 'rue de la construction', '', 'LFIRMINY', '', 'ctt', '', ''),
(48, '', 'Max', 'X', 'Rue de l\'archi', '', 'MILLAU', '', 'boi', '', ''),
(49, '', 'CONSTR', 'Contructeur NOM', 'rue de la construction', '', 'LFIRMINY', '', 'ctt', '', ''),
(56, 'SOL entreprise', 'Tecte', 'dza', 'Rue de l\'archi', '', 'MILLAU', '', 'sol', '', ''),
(57, 'ELEC', 'CONS', '', 'rue de la construction', '', 'LFIRMINY', '', 'boi', '', ''),
(58, 'ELEC', 'ELEC', '', 'rue du PV', '', 'CLERMINT', '', 'phv', '', ''),
(59, 'MARTIN', 'Ludivine', '', 'rue du PV', '', 'CLERMINT', '', 'cnr', '', ''),
(60, 'Contructeur NOM', 'CONS', '', 'rue de la construction', '', 'LFIRMINY', '', 'boi', '', ''),
(61, 'ELEC', 'ELEC', 'ELEC', 'rue du PV', '', 'CLERMINT', '', 'geo', '', ''),
(62, 'ELEC', 'ELEC', 'ELEC', 'rue du PV', '', 'CLERMINT', '', 'ctt', '', ''),
(63, 'ELEC', 'ELEC', '', 'rue du PV', '', 'CLERMINT', '', 'cnr', '', ''),
(64, 'MOE', 'MOE Nom', 'MOE PRENOM', 'MOE RUE', '', 'MOE VILLE', '', '', '', ''),
(65, 'MOE', 'MOE Nom', 'MOE PRENOM', 'MOE RUE', '', 'MOE VILLE', '', '', '', '');

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
(80, 1, NULL, NULL, NULL, NULL, NULL, 'asso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 1, NULL, NULL, NULL, NULL, NULL, 'particulier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 1, NULL, NULL, NULL, NULL, NULL, 'collectivites', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 1, NULL, NULL, NULL, NULL, NULL, 'prom_prive', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 1, NULL, NULL, NULL, NULL, NULL, 'particulier', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 1, NULL, NULL, NULL, NULL, NULL, 'particulier', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 1, 'particulier', NULL, NULL, NULL, NULL, 'sci', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 1, NULL, NULL, NULL, NULL, NULL, 'hlm_public', NULL, 1, 1, NULL, 1, NULL, 1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 1, NULL, NULL, NULL, NULL, NULL, 'hlm_public', NULL, 1, 1, NULL, 1, NULL, 1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 1, NULL, NULL, NULL, NULL, NULL, 'syndic', NULL, 1, 1, 'Architecte', 1, 1, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 1, 'entreprise', NULL, NULL, NULL, NULL, 'hlm_public', NULL, 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 1, 'entreprise', NULL, NULL, NULL, NULL, 'hlm_public', NULL, 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, NULL, 'entreprise', NULL, NULL, NULL, NULL, 'hlm_public', NULL, 1, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 1, NULL, NULL, NULL, NULL, NULL, 'hlm_prive', NULL, 1, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `moe`
--

CREATE TABLE `moe` (
  `DOID` int(11) NOT NULL,
  `moe` tinyint(1) DEFAULT NULL,
  `moe_entreprise_id` int(11) DEFAULT NULL,
  `moe_intervention_independant` tinyint(1) DEFAULT NULL,
  `moe_intervention_independant_qualite` varchar(255) DEFAULT NULL,
  `moe_intervention_independant_mission` enum('conception','direction','complete','autre') DEFAULT NULL,
  `moe_intervention_independant_mission_autre_descr` varchar(255) DEFAULT NULL,
  `moe_garantie_do` tinyint(1) NOT NULL,
  `moe_garantie_cnr` tinyint(1) NOT NULL,
  `moe_garantie_chantier` tinyint(1) NOT NULL,
  `moe_garantie_juridique` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `moe`
--

INSERT INTO `moe` (`DOID`, `moe`, `moe_entreprise_id`, `moe_intervention_independant`, `moe_intervention_independant_qualite`, `moe_intervention_independant_mission`, `moe_intervention_independant_mission_autre_descr`, `moe_garantie_do`, `moe_garantie_cnr`, `moe_garantie_chantier`, `moe_garantie_juridique`) VALUES
(80, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(81, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(82, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(83, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(84, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(85, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0),
(88, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 1),
(89, 1, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0),
(90, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(91, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(92, 1, NULL, 1, NULL, NULL, NULL, 1, 0, 0, 0),
(93, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(94, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(95, 1, 65, NULL, NULL, NULL, NULL, 0, 0, 0, 0);

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
  `type_ouvrage_mais_indiv_piscine_situation` varchar(255) NOT NULL,
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
(80, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'khjkjhkjhk', 'hkjhk', 'jhkjhk', 'jhkh', 0, 'hkjkj', '0022-02-12', '0022-02-22', '0022-02-22', 7487686, 6546, NULL),
(81, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'jhijhikjh', 'kjhjh', 'kjhk', 'jhkjh', 0, 'hkjhkj', '0546-06-04', '0455-05-06', '0555-04-05', 768469, 65156, 1),
(82, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'hgbiuhbguhg', 'uihgviu', 'gviu', 'gviyguvi', 0, 'yugvu', '0062-05-14', '5465-06-04', '0046-05-06', 6587654, 654645, 1),
(83, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'iygobçuy', 'iuygbçuyh', 'uiygbui', 'uygui', 62000, 'Bruxelles', '0465-05-04', '0046-05-06', '0465-05-06', 6387, 65741645, 1),
(84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'existante', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'ugugu', 'ygu', 'yguyg', 'uyguy', 0, 'uguy', '0554-12-04', '0055-05-05', '0055-05-05', 0, 6546456546, 1),
(88, 'existante', 1, 1, NULL, 1, 1, 1, 1, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'piscine extérieure', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rthrthvrthrvthrthtrhrhtrr', 'jhg', 'jhgj', 'hgjh', 'gjhg', 0, 'jhghjgjhj', '0022-05-04', '0222-02-22', '0658-02-22', 5647516, 654153, 1),
(89, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '45 rue de la margeride', NULL, NULL, 48300, 'LANGOGNE', '2024-10-07', '2024-10-16', '2024-10-26', 1500, 1250, 1),
(90, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '46 rue de la margeride', NULL, NULL, 48300, 'LANGOGNE', '2024-10-07', '2024-10-16', '2024-10-26', 1500, 1250, 1),
(91, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rue de la construction', 'rue de la construction', 'rue de la construction', 'rue de la construction', 43000, 'LFIRMINY', '2024-11-01', '2024-12-08', '2025-03-01', 350000, 1250, NULL),
(92, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rue de la construction', 'rue de la construction', 'rue de la construction', 'rue de la construction', 43000, 'LFIRMINY', '2024-10-11', '2024-10-25', '2025-11-15', 350000, 1250, NULL),
(93, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rue de la construction', 'rue de la construction', 'rue de la construction', 'rue de la construction', 43000, 'LFIRMINY', '2024-10-11', '2024-10-25', '2025-11-15', 350000, 1250, NULL),
(94, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rue de la construction', 'rue de la construction', 'rue de la construction', 'rue de la construction', 43000, 'LFIRMINY', '2024-10-11', '2024-10-25', '2025-11-15', 350000, 1250, NULL),
(95, 'neuve', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rue du PV', 'rue du PV', 'rue du PV', 'rue du PV', 63000, 'CLERMINT', '2024-10-05', '2024-10-12', '2025-11-02', 350000, 1250, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rcd`
--

CREATE TABLE `rcd` (
  `rcd_id` int(11) NOT NULL,
  `DOID` int(11) NOT NULL,
  `rcd_nature_id` int(11) NOT NULL,
  `rcd_nature_autre` varchar(255) NOT NULL,
  `rcd_nom` varchar(255) NOT NULL,
  `repertoire` varchar(255) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `fichier_remarque` text NOT NULL,
  `annexe_fichier` varchar(255) NOT NULL,
  `annexe_fichier_remarque` text NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `construction_date_debut` date NOT NULL,
  `construction_date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'BET\r\n'),
(2, 'Ingénieur conseil'),
(3, 'Maçonnerie'),
(4, 'Enduit'),
(5, 'Charpente bois'),
(6, 'Charpente métallique'),
(7, 'Couverture / étanchéité'),
(8, 'Plomberie'),
(9, 'Carrelage'),
(10, 'Menuiseries'),
(11, 'Plaques de plâtres'),
(12, 'Revêtements souples sols murs'),
(13, 'Électricité'),
(14, 'Fondation'),
(15, 'Terrassement');

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
  `sol` tinyint(1) DEFAULT NULL,
  `sol_entreprise_id` int(11) DEFAULT NULL,
  `sol_bureau_mission` enum('g2_amp','g2_pro','etude_sol_autre') DEFAULT NULL,
  `sol_bureau_mission_champ` varchar(255) DEFAULT NULL,
  `sol_parking` tinyint(1) DEFAULT NULL,
  `situation_garanties_completes` tinyint(1) DEFAULT NULL,
  `situation_garanties_dommages_existants` tinyint(1) DEFAULT NULL,
  `situation_construction_bois` tinyint(1) DEFAULT NULL,
  `situation_pann_photo` tinyint(1) DEFAULT NULL,
  `situation_geothermie` tinyint(1) DEFAULT NULL,
  `situation_controle_tech` tinyint(1) DEFAULT NULL,
  `situation_cnr` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `situation`
--

INSERT INTO `situation` (`DOID`, `situation_zone_inond`, `situation_sismique`, `situation_insectes`, `situation_proc_techniques`, `situation_parking`, `situation_do_10ans`, `situation_do_10ans_contrat_assureur`, `situation_do_10ans_contrat_numero`, `situation_mon_hist`, `situation_label_energie`, `situation_label_qualite`, `sol`, `sol_entreprise_id`, `sol_bureau_mission`, `sol_bureau_mission_champ`, `sol_parking`, `situation_garanties_completes`, `situation_garanties_dommages_existants`, `situation_construction_bois`, `situation_pann_photo`, `situation_geothermie`, `situation_controle_tech`, `situation_cnr`) VALUES
(80, NULL, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 1, 5, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 1, 5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 1, 2, 1, NULL, 1, 1, 'MMA', '1236579', 1, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, NULL, 4, 1, 1, 1, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1),
(88, 1, 5, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 1, 1, 1, 1, 1),
(89, 1, 4, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1),
(90, 1, 4, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 1),
(91, NULL, 2, 1, 1, NULL, NULL, NULL, NULL, 1, 1, 1, 1, NULL, 'g2_pro', NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL),
(92, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 56, 'g2_pro', NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL),
(93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `souscripteur`
--

CREATE TABLE `souscripteur` (
  `souscripteur_id` int(11) NOT NULL,
  `souscripteur_nom_raison` varchar(255) NOT NULL,
  `souscripteur_siret` varchar(255) NOT NULL,
  `souscripteur_adresse` varchar(255) NOT NULL,
  `souscripteur_code_postal` int(11) NOT NULL,
  `souscripteur_commune` varchar(255) NOT NULL,
  `souscripteur_profession` varchar(255) NOT NULL,
  `souscripteur_telephone` varchar(255) NOT NULL,
  `souscripteur_email` varchar(255) NOT NULL,
  `souscripteur_ancien_client_date` date NOT NULL,
  `souscripteur_ancien_client_num` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `souscripteur`
--

INSERT INTO `souscripteur` (`souscripteur_id`, `souscripteur_nom_raison`, `souscripteur_siret`, `souscripteur_adresse`, `souscripteur_code_postal`, `souscripteur_commune`, `souscripteur_profession`, `souscripteur_telephone`, `souscripteur_email`, `souscripteur_ancien_client_date`, `souscripteur_ancien_client_num`) VALUES
(81, 'César Jules', '4564656546', 'Via Appia', 82000, 'Rome', 'Empereur', '0682026840', 'j.cesar@gmail.fr', '0000-00-00', ''),
(82, 'Trump Donald', '678479', 'Trump Tower', 82000, 'New York', 'Milliardaire', '0682026840', 'd.trump@gmail.fr', '0000-00-00', ''),
(83, 'Turner Tina', '64', 'Chicago', 92000, 'Chicago', 'Chanteuse', '0682026840', 't.turner@gmail.com', '0000-00-00', ''),
(84, 'Poirot Hercule', '54545', 'Rue de Liège', 62000, 'Bruxelles', 'Enquêteur', '0682026840', 'h.poirot@gmail.com', '0000-00-00', ''),
(85, 'ugvjug', 'ugug', 'uygui', 0, 'uguiy', 'guyg', 'iuyguiyg', 'uiyg@gmail.com', '0000-00-00', ''),
(86, 'ugvjug', 'ugug', 'uygui', 0, 'uguiy', 'guyg', 'iuyguiyg', 'uiyg@gmail.com', '0000-00-00', ''),
(87, 'Steph', 'Steph', 'Steph', 48700, 'Serverette', 'Dev', '0682026840', 's.vincent@gmail.com', '0000-00-00', ''),
(88, 'jh', 'jhgj', 'hgjh', 0, 'jhg', 'jhg', 'jhgjhgjghj', 'hgjh@gmail.com', '0000-00-00', ''),
(89, 'kjh', 'khk', 'hkj', 0, 'hkj', 'hkjh', 'kjhkjhkjhkj', 'hkjhkj@gmail.com', '0000-00-00', ''),
(90, 'MARTIN Ludivine', '50 avenue foch', 'Rue du ruisseau', 48300, 'Langogene', '', '0471009626', 'ludivine.martin@mail.com', '0000-00-00', ''),
(91, 'MARTIN Ludivine', '50 avenue foch', 'Rue du ruisseau', 48300, 'Langogene', '', '0471009626', 'ludivine.martin@mail.com', '0000-00-00', ''),
(92, 'MARTIN Ludivine', '', 'rue du PV', 63000, 'CLERMINT', '', '0141418364', 'ludivine.martin@mail.com', '0000-00-00', ''),
(93, 'MARTIN Ludivine', '', 'rue du PV', 63000, 'CLERMINT', '', '0141418364', 'ludivine.martin@mail.com', '0000-00-00', ''),
(94, 'MARTIN Ludivine', '', 'rue du PV', 63000, 'CLERMINT', '', '0141418364', 'ludivine.martin@mail.com', '0000-00-00', ''),
(95, 'MARTIN Ludivine', '', 'rue du PV', 63000, 'CLERMINT', '', '0141418364', 'ludivine.martin@mail.com', '0000-00-00', ''),
(96, 'MARTIN Ludivine', '', 'rue du PV', 63000, 'CLERMINT', '', '0141418364', 'ludivine.martin@mail.com', '0000-00-00', '');

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
(80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(81, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(85, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'guygiuyuyguo', NULL),
(88, NULL, 1, NULL, NULL, 'integre', NULL, 1, 12, 1, 23, 'autocons', NULL, NULL, 'lth', NULL, NULL, NULL, NULL, 0, 'kijgyboui', NULL),
(89, NULL, NULL, NULL, NULL, 'surimpose', NULL, NULL, 45, 1, 3, 'autocons', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'maçon', NULL),
(90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(91, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', 49),
(92, 57, NULL, NULL, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 59, '', NULL),
(93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', NULL),
(95, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 61, NULL, NULL, NULL, NULL, NULL, NULL, 63, '', 62);

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
(1, 'ADMIN', '', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '2024-10-03 09:57:58'),
(11, 'LEYDIER', 'Christophe', 'christophe_leydier3@hotmail.com', '1697918c7f9551712f531143df2f8a37', '2024-10-04 15:14:01'),
(12, 'Ludivine', 'MARTIN', 'ludivine.martin@mail.com', '1697918c7f9551712f531143df2f8a37', '2024-10-07 13:18:05');

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
(2, 7, 0, '2024-09-08 16:45:00', '2024-09-08 16:45:17', NULL),
(3, 1, 91, '2024-09-09 16:45:00', '2024-09-10 16:45:17', '2024-10-10 07:39:57'),
(5, 1, 89, '2024-09-10 16:45:00', '2024-09-10 16:45:17', '2024-10-10 07:50:44'),
(6, 2, 0, '2024-09-17 17:43:56', '2024-09-17 17:43:56', '2024-10-01 14:58:11'),
(7, 7, 0, '2024-09-30 15:40:28', '2024-09-30 15:40:28', NULL),
(8, 7, 0, '2024-09-30 15:42:53', '2024-09-30 15:42:53', NULL),
(9, 7, 0, '2024-09-30 15:43:00', '2024-09-30 15:43:00', NULL),
(10, 7, 0, '2024-10-01 14:38:46', '2024-10-01 14:38:46', NULL),
(11, 7, 0, '2024-10-01 14:39:07', '2024-10-01 14:39:07', NULL),
(12, 7, 0, '2024-10-01 16:53:18', '2024-10-01 16:53:18', NULL),
(13, 11, 0, '2024-10-04 17:14:30', '2024-10-04 17:21:57', '2024-10-04 15:21:57');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dommage_ouvrage`
--
ALTER TABLE `dommage_ouvrage`
  ADD PRIMARY KEY (`DOID`),
  ADD KEY `souscripteur_id` (`souscripteur_id`);

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
-- Index pour la table `moe`
--
ALTER TABLE `moe`
  ADD PRIMARY KEY (`DOID`),
  ADD KEY `moe_entreprise_id` (`moe_entreprise_id`);

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
  MODIFY `DOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `rcd`
--
ALTER TABLE `rcd`
  MODIFY `rcd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rcd_nature`
--
ALTER TABLE `rcd_nature`
  MODIFY `rcd_nature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `souscripteur`
--
ALTER TABLE `souscripteur`
  MODIFY `souscripteur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `utilisateur_session`
--
ALTER TABLE `utilisateur_session`
  MODIFY `utilisateur_session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
