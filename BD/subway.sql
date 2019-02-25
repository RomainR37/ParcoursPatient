-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 25 Février 2019 à 20:19
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `subway`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `ID_ACTIVITE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `INT_DUREE` bigint(4) DEFAULT NULL,
  `TXT_COMMENTAIRE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `activite`
--

INSERT INTO `activite` (`ID_ACTIVITE`, `TXT_NOM`, `INT_DUREE`, `TXT_COMMENTAIRE`) VALUES
(0, 'Début', 0, NULL),
(1, 'RDV paramédical Obésité', 20, 'Consultation'),
(2, 'ECG', 15, ''),
(3, 'Bilan biologique', 20, 'Prélèvement à jeun'),
(4, 'Echo hépatique', 15, 'A jeun'),
(5, 'Calorimétrie', 30, ''),
(6, 'Entretien psy', 40, ''),
(7, 'Entretien infirmier', 30, ''),
(8, 'Entretien diet', 60, ''),
(9, 'Synthèse', 30, ''),
(10, 'TOGD', 20, ''),
(11, 'Bilan anthropométrique', 60, ''),
(12, 'Fibroscan', 10, ''),
(13, 'Scanner abdo', 20, ''),
(14, 'Entretien hépato', 45, ''),
(15, 'Traitement Rémicade', 120, ''),
(16, 'Ponction Ascite', 180, ''),
(17, 'Soins ponction', 195, ''),
(18, 'Injection Ferinject', 60, ''),
(19, 'Injection', 40, ''),
(20, 'Scintigraphie myocardique', 30, NULL),
(21, 'Scanner des corronaires', 10, NULL),
(22, 'Echodoppler TSA et MI', 30, NULL),
(23, 'Rétinographie', 15, ''),
(24, 'Pose pompe et/ou Holter', 30, ''),
(26, 'Scanner TMD pied + radios', 40, ''),
(27, 'Doppler des artères des MI', 30, ''),
(28, 'Soin, pansement, mesures IPS', 40, ''),
(29, 'RDV médical', 40, ''),
(30, 'Prélèvements', 15, ''),
(31, 'Collation', 15, ''),
(33, 'RDV Paramédical Hors Obésité', 15, ''),
(34, 'RDV médical + diet', 55, ''),
(35, 'OK chimio', 10, ''),
(36, 'RDV paramédical chimio', 15, ''),
(37, 'Pose d''aiguille PAC', 15, ''),
(38, 'Prémédication', 20, ''),
(39, 'Consultation médicale', 20, ''),
(40, 'Examens chimio', 20, ''),
(41, 'OK administration', 10, ''),
(42, 'Administration chimio', 15, ''),
(43, 'ETP', 30, ''),
(44, 'ETP', 0, ''),
(45, 'Consultation médicale gériatrie', 30, ''),
(46, 'Soins', 190, ''),
(47, 'Examens', 60, ''),
(48, 'Test d''efforts', 25, ''),
(49, 'Explorations fonctionnelles ou morphologiques', 40, ''),
(50, 'Bilan cardio', 30, ''),
(51, 'Test fonctionnel', 20, ''),
(52, 'IRM', 40, ''),
(53, 'Echo cardiaque', 20, ''),
(54, 'Examens cliniques', 30, ''),
(55, 'Médecine nucléaire', 30, ''),
(56, 'RDV Accueil', 5, ''),
(57, 'ARM', 15, ''),
(58, 'Echodoppler TSA', 20, ''),
(59, 'ETT', 20, ''),
(60, 'Holter', 30, ''),
(61, 'Synthèse neuro', 30, ''),
(62, 'EEG', 40, ''),
(63, 'Scintigraphie cérébrale', 40, ''),
(64, 'Ponction lombaire', 15, ''),
(65, 'Consultation neuropsy', 180, ''),
(66, 'Consultation psy', 30, '');

-- --------------------------------------------------------

--
-- Structure de la table `champ`
--

CREATE TABLE IF NOT EXISTS `champ` (
  `ID_CHAMP` bigint(11) NOT NULL,
  `ID_TYPECHAMP` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_CHAMP`),
  KEY `I_FK_CHAMP_TYPECHAMP` (`ID_TYPECHAMP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `champ`
--

INSERT INTO `champ` (`ID_CHAMP`, `ID_TYPECHAMP`, `TXT_NOM`) VALUES
(1, 1, 'Nom'),
(2, 3, 'Observation'),
(3, 2, 'Date d''observation'),
(4, 3, 'Attention'),
(5, 3, 'New'),
(6, 1, 'Nouveau champ'),
(7, 4, 'champ1'),
(8, 1, 'Champ2'),
(9, 1, 'new'),
(10, 1, 'champ2'),
(11, 1, 'CHAMP1'),
(12, 1, 'NEW'),
(13, 1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `composer`
--

CREATE TABLE IF NOT EXISTS `composer` (
  `ID_PARCOURS` bigint(11) NOT NULL,
  `ID_ACTIVITE` bigint(11) NOT NULL,
  `ID_ACTIVITE_PRECEDENTE` bigint(11) NOT NULL,
  `INT_DELAIMIN` bigint(4) DEFAULT NULL,
  `INT_DELAIMAX` bigint(4) DEFAULT NULL,
  PRIMARY KEY (`ID_PARCOURS`,`ID_ACTIVITE`,`ID_ACTIVITE_PRECEDENTE`),
  KEY `I_FK_COMPOSER_PARCOURS` (`ID_PARCOURS`),
  KEY `I_FK_COMPOSER_ACTIVITE` (`ID_ACTIVITE`),
  KEY `I_FK_COMPOSER_ACTIVITE1` (`ID_ACTIVITE_PRECEDENTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `composer`
--

INSERT INTO `composer` (`ID_PARCOURS`, `ID_ACTIVITE`, `ID_ACTIVITE_PRECEDENTE`, `INT_DELAIMIN`, `INT_DELAIMAX`) VALUES
(1, 1, 0, 0, 0),
(1, 2, 1, 0, 90),
(1, 3, 1, 0, 110),
(1, 4, 1, 0, 110),
(1, 5, 1, 0, 110),
(1, 6, 11, 0, 170),
(1, 7, 11, 0, 170),
(1, 8, 11, 0, 170),
(1, 9, 6, 0, 120),
(1, 9, 7, 0, 130),
(1, 9, 8, 0, 100),
(1, 11, 31, 0, 30),
(1, 31, 2, 0, 90),
(1, 31, 3, 0, 85),
(1, 31, 4, 0, 90),
(1, 31, 5, 0, 75),
(2, 1, 0, 0, 0),
(2, 3, 1, 0, 135),
(2, 5, 1, 0, 135),
(2, 6, 11, 0, 120),
(2, 7, 11, 0, 130),
(2, 8, 11, 0, 100),
(2, 9, 6, 0, 120),
(2, 9, 7, 0, 130),
(2, 9, 8, 0, 100),
(2, 10, 1, 0, 135),
(2, 11, 31, 0, 30),
(2, 31, 3, 0, 80),
(2, 31, 5, 0, 65),
(2, 31, 10, 0, 75),
(3, 1, 0, 0, 0),
(3, 3, 1, 0, 75),
(3, 4, 1, 0, 75),
(3, 5, 1, 0, 60),
(3, 6, 11, 0, 130),
(3, 6, 12, 0, 180),
(3, 7, 11, 0, 140),
(3, 7, 12, 0, 190),
(3, 8, 11, 0, 110),
(3, 8, 12, 0, 140),
(3, 9, 6, 0, 120),
(3, 9, 7, 0, 130),
(3, 9, 8, 0, 100),
(3, 11, 31, 0, 40),
(3, 12, 31, 0, 90),
(3, 31, 3, 0, 75),
(3, 31, 4, 0, 75),
(3, 31, 5, 0, 60),
(4, 2, 33, 0, 60),
(4, 5, 33, 0, 40),
(4, 7, 11, 0, 120),
(4, 7, 12, 0, 170),
(4, 7, 13, 0, 160),
(4, 8, 11, 0, 60),
(4, 8, 12, 0, 140),
(4, 8, 13, 0, 130),
(4, 9, 7, 0, 90),
(4, 9, 8, 0, 60),
(4, 11, 31, 0, 60),
(4, 12, 31, 0, 110),
(4, 13, 31, 0, 130),
(4, 31, 2, 0, 60),
(4, 31, 5, 0, 40),
(4, 33, 0, 0, 0),
(5, 3, 33, 0, 45),
(5, 4, 33, 0, 45),
(5, 12, 31, 0, 30),
(5, 14, 12, 0, 40),
(5, 31, 3, 0, 45),
(5, 31, 4, 0, 45),
(5, 33, 0, 0, 0),
(6, 3, 33, 0, 30),
(6, 9, 15, 0, 30),
(6, 14, 31, 0, 30),
(6, 15, 14, 0, 30),
(6, 31, 3, 0, 30),
(6, 33, 0, 0, 0),
(7, 3, 33, 0, 30),
(7, 9, 17, 0, 30),
(7, 14, 31, 0, 30),
(7, 16, 14, 0, 30),
(7, 17, 16, 0, 30),
(7, 31, 3, 0, 30),
(7, 33, 0, 0, 0),
(8, 3, 33, 0, 30),
(8, 9, 18, 0, 30),
(8, 14, 31, 0, 30),
(8, 18, 14, 0, 30),
(8, 31, 3, 0, 30),
(8, 33, 0, 0, 0),
(10, 8, 13, 0, 80),
(10, 8, 23, 0, 85),
(10, 13, 31, 0, 45),
(10, 23, 31, 0, 50),
(10, 29, 13, 0, 75),
(10, 29, 23, 0, 80),
(10, 30, 0, 0, 0),
(10, 31, 30, 0, 30),
(11, 26, 31, 0, 100),
(11, 27, 31, 0, 110),
(11, 28, 31, 0, 100),
(11, 29, 26, 0, 100),
(11, 29, 27, 0, 110),
(11, 29, 28, 0, 100),
(11, 30, 0, 0, 0),
(11, 31, 30, 0, 30),
(12, 24, 31, 0, 30),
(12, 30, 0, 0, 0),
(12, 31, 30, 0, 30),
(12, 34, 24, 0, 30),
(16, 35, 0, 0, 0),
(16, 36, 35, 0, 30),
(16, 37, 36, 0, 50),
(16, 38, 37, 0, 30),
(16, 39, 36, 0, 65),
(16, 40, 38, 0, 50),
(16, 40, 39, 0, 65),
(16, 41, 40, 0, 30),
(16, 42, 41, 0, 30),
(16, 43, 0, 0, 0),
(17, 37, 41, 0, 30),
(17, 38, 37, 0, 30),
(17, 39, 0, 0, 0),
(17, 40, 39, 0, 30),
(17, 41, 40, 0, 30),
(17, 42, 38, 0, 30),
(17, 44, 0, 0, 0),
(18, 2, 31, 0, 125),
(18, 3, 0, 0, 0),
(18, 31, 3, 0, 30),
(18, 39, 31, 0, 105),
(18, 48, 31, 0, 110),
(18, 49, 31, 0, 95),
(18, 50, 2, 0, 125),
(18, 50, 39, 0, 105),
(18, 50, 48, 0, 110),
(18, 50, 49, 0, 95),
(19, 2, 31, 0, 195),
(19, 3, 0, 0, 0),
(19, 31, 3, 0, 30),
(19, 43, 31, 0, 175),
(19, 48, 31, 0, 180),
(19, 51, 31, 0, 185),
(19, 52, 31, 0, 165),
(19, 53, 31, 0, 185),
(19, 54, 31, 0, 175),
(20, 2, 31, 0, 130),
(20, 3, 0, 0, 0),
(20, 31, 3, 0, 30),
(20, 49, 31, 0, 100),
(20, 54, 31, 0, 110),
(20, 55, 31, 0, 110),
(21, 2, 31, 0, 180),
(21, 30, 56, 0, 30),
(21, 31, 30, 0, 30),
(21, 50, 31, 0, 170),
(21, 52, 31, 0, 145),
(21, 56, 0, 0, 0),
(21, 57, 31, 0, 175),
(21, 58, 31, 0, 170),
(21, 59, 31, 0, 140),
(21, 60, 31, 0, 160),
(21, 61, 2, 0, 180),
(21, 61, 50, 0, 170),
(21, 61, 52, 0, 145),
(21, 61, 57, 0, 175),
(21, 61, 58, 0, 170),
(21, 61, 59, 0, 140),
(21, 61, 60, 0, 160),
(22, 17, 64, 0, 30),
(22, 19, 31, 0, 305),
(22, 30, 54, 0, 30),
(22, 31, 30, 0, 30),
(22, 52, 31, 0, 315),
(22, 54, 56, 0, 30),
(22, 56, 0, 0, 0),
(22, 61, 65, 0, 30),
(22, 62, 31, 0, 320),
(22, 63, 19, 0, 30),
(22, 64, 31, 0, 205),
(22, 65, 17, 0, 205),
(22, 65, 52, 0, 315),
(22, 65, 62, 0, 320),
(22, 65, 63, 0, 305),
(23, 30, 56, 0, 30),
(23, 31, 30, 0, 30),
(23, 52, 31, 0, 270),
(23, 56, 0, 0, 0),
(23, 61, 52, 0, 270),
(23, 61, 62, 0, 275),
(23, 61, 65, 0, 145),
(23, 61, 66, 0, 295),
(23, 62, 31, 0, 275),
(23, 65, 31, 0, 145),
(23, 66, 31, 0, 295),
(24, 30, 54, 0, 30),
(24, 31, 30, 0, 30),
(24, 52, 31, 0, 90),
(24, 54, 56, 0, 30),
(24, 56, 0, 0, 0),
(24, 58, 31, 0, 115),
(24, 61, 52, 0, 90),
(24, 61, 58, 0, 115),
(24, 61, 62, 0, 95),
(24, 62, 31, 0, 95),
(25, 3, 0, 0, 0),
(25, 45, 3, 0, 30),
(25, 46, 45, 0, 30),
(25, 47, 46, 0, 30),
(26, 3, 0, 0, 0),
(26, 39, 3, 0, 30),
(26, 46, 39, 0, 30),
(26, 47, 46, 0, 30);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `ID_COMPTE` bigint(11) NOT NULL,
  `TXT_LOGIN` varchar(255) DEFAULT NULL,
  `TXT_MOTDEPASSE` varchar(255) DEFAULT NULL,
  `ID_TYPECOMPTE` bigint(11) NOT NULL,
  PRIMARY KEY (`ID_COMPTE`),
  KEY `compte_ibfk_1` (`ID_TYPECOMPTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`ID_COMPTE`, `TXT_LOGIN`, `TXT_MOTDEPASSE`, `ID_TYPECOMPTE`) VALUES
(1, 'martin', '$2Cw51.ICu1Nw', 1),
(2, 'bernard', '$2Cw51.ICu1Nw', 1),
(3, 'dubois', '$2Cw51.ICu1Nw', 1),
(4, 'thomas', '$2Cw51.ICu1Nw', 1),
(5, 'robert', '$2Cw51.ICu1Nw', 1),
(6, 'richard', '$2Cw51.ICu1Nw', 1),
(7, 'petit', '$2Cw51.ICu1Nw', 1),
(8, 'durand', '$2Cw51.ICu1Nw', 1),
(9, 'leroy', '$2Cw51.ICu1Nw', 1),
(10, 'moreau', '$2Cw51.ICu1Nw', 1),
(11, 'cheniour', '$2Cw51.ICu1Nw', 2),
(12, 'verheyde', '$2Cw51.ICu1Nw', 2),
(13, 'attias', '$2Cw51.ICu1Nw', 2),
(14, 'cabinet', '$2Cw51.ICu1Nw', 2),
(15, 'pasquet', '$2Cw51.ICu1Nw', 2),
(16, 'viomesnil', '$2Cw51.ICu1Nw', 2),
(17, 'guerrero', '$2Cw51.ICu1Nw', 2),
(18, 'neuman', '$2Cw51.ICu1Nw', 2),
(19, 'teboul', '$2Cw51.ICu1Nw', 2),
(20, 'belhadj', '$2Cw51.ICu1Nw', 2),
(21, 'admin', '$2gCXDSrN2DHo', 4),
(22, 'roche', '123', 2),
(23, 'fontaine', '123', 2),
(24, 'marie', '123', 2),
(25, 'Simon', '123', 2),
(26, 'Delo', '123', 2),
(27, 'Ruit', '123', 2),
(28, 'Pochet', '$21N5YZFMHzG2', 1),
(29, 'pochet', '$22RmIkCCm0t2', 1),
(30, 'pochet', '$21N5YZFMHzG2', 1),
(31, 'pochet', '$21N5YZFMHzG2', 1),
(32, 'pochet', '$21N5YZFMHzG2', 1),
(33, 'pochet', '$21N5YZFMHzG2', 1),
(34, 'pochet', '$21N5YZFMHzG2', 1),
(35, 'pochet', '$21N5YZFMHzG2', 1),
(36, 'pochet', '$21N5YZFMHzG2', 1),
(37, 'admin', 'admin', 2),
(38, 'YANG.Jing', '$2h5ADN5BooAA', 1),
(39, 'YANG.Jing', '$2h5ADN5BooAA', 1),
(40, 'YANG.J', '$2bk6E2mLJ4Es', 1),
(41, 'YANG.ying', '$2bk6E2mLJ4Es', 1),
(42, 'YANG.pateint', '$2bk6E2mLJ4Es', 1),
(43, 'YANG.pateint', '$2bk6E2mLJ4Es', 1),
(44, 'YANG.one', '$2bk6E2mLJ4Es', 1),
(45, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(46, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(47, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(48, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(49, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(50, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(51, 'YANG.Jemika', '$2bk6E2mLJ4Es', 1),
(52, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(53, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(54, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(55, 'YANG.Jing', '$2bk6E2mLJ4Es', 1),
(56, 'YANG.Jemika', '$2bk6E2mLJ4Es', 1),
(57, 'YANG.Jemika', '$2bk6E2mLJ4Es', 1),
(58, 'YANG.Jing', '$2h5ADN5BooAA', 1),
(59, 'YANG.Jemika', '$2W.wZ10iVwWo', 1),
(60, 'YANG.J', '$2bk6E2mLJ4Es', 1),
(61, 'YANG.ying', '$2bk6E2mLJ4Es', 1),
(62, 'aa.aaa', '$2F4KK3Qd9.gY', 1),
(63, 'Sebastien.Patrick', '$2UmU7LJRude.', 1),
(64, 'Sebastien.Patrick', '$2UmU7LJRude.', 1),
(65, 'patseb', 'c''estlafête', 2),
(66, 'medecinhepato', 'medecinhepato', 2),
(67, 'jeanorthoptiste', 'jeanotrhoptiste', 2),
(68, 'micheldiabetologue', 'micheldiabetologue', 2),
(69, 'idepansement', 'idepansement', 2),
(70, 'denispodologue', 'denispodologue', 2),
(71, 'pompeinsuline', 'pompeinsuline', 2),
(72, 'insulinothérapie', 'insulinothérapie', 2),
(73, 'josechimio', 'jocechimio', 2),
(74, 'jeromegeneraliste', 'jeromegeneraliste', 2),
(75, 'gerardgeriatre', 'gerardgeriatre', 2),
(76, 'michaelcardiologue', 'michaelcardioologue', 2),
(77, 'jeankine', 'jeankine', 2),
(78, 'idecardio', 'idecardio', 2),
(79, 'agentaccueil', 'agentaccueil', 2),
(80, 'alphonseneurologue', 'alphonseneurologue', 2),
(81, 'neuropsychiatre', 'neuropsychiatre', 2),
(82, 'Un.Numero', '$2FSeMrBqFIJc', 1),
(83, 'Deux.Numero', '$2uND8MNHHC.2', 1),
(84, 'Trois.Numero', '$2FSeMrBqFIJc', 1),
(85, 'Quatre.Numero', '$2dduJUEGC.rM', 1),
(86, 'Cinq.Numero', '$2UmU7LJRude.', 1),
(87, 'Six.Numero', '$2UmU7LJRude.', 1),
(88, 'Sept.Numero', '$2dduJUEGC.rM', 1),
(89, 'Huit.Numero', '$2dduJUEGC.rM', 1),
(90, 'Neuf.Numero', '$2QilzLl5Uwts', 1),
(91, 'ide', 'obesite', 2),
(92, 'ide', 'chimio', 2),
(93, 'ide', 'chimio', 2),
(94, 'interne', 'obesite', 2),
(95, 'medecin', 'generaliste', 2),
(96, 'un.Numero', '$2wZocjqVQKp2', 1),
(97, 'Deux.Numero', '$2QilzLl5Uwts', 1),
(98, 'Trois.Numero', '$2yg83mefGwzc', 1),
(99, 'Quatre.Numero', '$2yg83mefGwzc', 1),
(100, 'Cinq.Numero', '$2QilzLl5Uwts', 1);

-- --------------------------------------------------------

--
-- Structure de la table `constituerdossier`
--

CREATE TABLE IF NOT EXISTS `constituerdossier` (
  `ID_CHAMP` bigint(11) NOT NULL,
  `ID_ONGLET` bigint(11) NOT NULL,
  `ID_DOSSIERPARCOURS` bigint(11) NOT NULL,
  `TXT_VALEUR` varchar(255) DEFAULT NULL,
  KEY `I_FK_CONSTITUERDOSSIER_CHAMP` (`ID_CHAMP`),
  KEY `I_FK_CONSTITUERDOSSIER_DOSSIERPARCOURS` (`ID_DOSSIERPARCOURS`),
  KEY `I_FK_CONSTITUERDOSSIER_ONGLET` (`ID_ONGLET`),
  KEY `ID_CHAMP` (`ID_CHAMP`,`ID_ONGLET`,`ID_DOSSIERPARCOURS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `constituerdossier`
--

INSERT INTO `constituerdossier` (`ID_CHAMP`, `ID_ONGLET`, `ID_DOSSIERPARCOURS`, `TXT_VALEUR`) VALUES
(2, 1, 33, NULL),
(3, 1, 33, NULL),
(2, 2, 33, NULL),
(3, 2, 33, NULL),
(2, 3, 33, NULL),
(3, 3, 33, NULL),
(2, 4, 33, NULL),
(3, 4, 33, NULL),
(2, 5, 33, NULL),
(3, 5, 33, NULL),
(2, 6, 33, NULL),
(3, 6, 33, NULL),
(2, 7, 33, NULL),
(3, 7, 33, NULL),
(2, 8, 33, NULL),
(3, 8, 33, NULL),
(2, 9, 33, NULL),
(3, 9, 33, NULL),
(2, 9, 33, NULL),
(3, 9, 33, NULL),
(2, 9, 33, NULL),
(3, 9, 33, NULL),
(2, 11, 33, NULL),
(3, 11, 33, NULL),
(2, 31, 33, NULL),
(3, 31, 33, NULL),
(2, 31, 33, NULL),
(3, 31, 33, NULL),
(2, 31, 33, NULL),
(3, 31, 33, NULL),
(2, 31, 33, NULL),
(3, 31, 33, NULL),
(2, 1, 34, NULL),
(3, 1, 34, NULL),
(2, 2, 34, NULL),
(3, 2, 34, NULL),
(2, 3, 34, NULL),
(3, 3, 34, NULL),
(2, 4, 34, NULL),
(3, 4, 34, NULL),
(2, 5, 34, NULL),
(3, 5, 34, NULL),
(2, 6, 34, NULL),
(3, 6, 34, NULL),
(2, 7, 34, NULL),
(3, 7, 34, NULL),
(2, 8, 34, NULL),
(3, 8, 34, NULL),
(2, 9, 34, NULL),
(3, 9, 34, NULL),
(2, 9, 34, NULL),
(3, 9, 34, NULL),
(2, 9, 34, NULL),
(3, 9, 34, NULL),
(2, 11, 34, NULL),
(3, 11, 34, NULL),
(2, 31, 34, NULL),
(3, 31, 34, NULL),
(2, 31, 34, NULL),
(3, 31, 34, NULL),
(2, 31, 34, NULL),
(3, 31, 34, NULL),
(2, 31, 34, NULL),
(3, 31, 34, NULL),
(2, 1, 35, NULL),
(3, 1, 35, NULL),
(2, 2, 35, NULL),
(3, 2, 35, NULL),
(2, 3, 35, NULL),
(3, 3, 35, NULL),
(2, 4, 35, NULL),
(3, 4, 35, NULL),
(2, 5, 35, NULL),
(3, 5, 35, NULL),
(2, 6, 35, NULL),
(3, 6, 35, NULL),
(2, 7, 35, NULL),
(3, 7, 35, NULL),
(2, 8, 35, NULL),
(3, 8, 35, NULL),
(2, 9, 35, NULL),
(3, 9, 35, NULL),
(2, 9, 35, NULL),
(3, 9, 35, NULL),
(2, 9, 35, NULL),
(3, 9, 35, NULL),
(2, 11, 35, NULL),
(3, 11, 35, NULL),
(2, 31, 35, NULL),
(3, 31, 35, NULL),
(2, 31, 35, NULL),
(3, 31, 35, NULL),
(2, 31, 35, NULL),
(3, 31, 35, NULL),
(2, 31, 35, NULL),
(3, 31, 35, NULL),
(2, 1, 36, NULL),
(3, 1, 36, NULL),
(2, 2, 36, NULL),
(3, 2, 36, NULL),
(2, 3, 36, NULL),
(3, 3, 36, NULL),
(2, 4, 36, NULL),
(3, 4, 36, NULL),
(2, 5, 36, NULL),
(3, 5, 36, NULL),
(2, 6, 36, NULL),
(3, 6, 36, NULL),
(2, 7, 36, NULL),
(3, 7, 36, NULL),
(2, 8, 36, NULL),
(3, 8, 36, NULL),
(2, 9, 36, NULL),
(3, 9, 36, NULL),
(2, 9, 36, NULL),
(3, 9, 36, NULL),
(2, 9, 36, NULL),
(3, 9, 36, NULL),
(2, 11, 36, NULL),
(3, 11, 36, NULL),
(2, 31, 36, NULL),
(3, 31, 36, NULL),
(2, 31, 36, NULL),
(3, 31, 36, NULL),
(2, 31, 36, NULL),
(3, 31, 36, NULL),
(2, 31, 36, NULL),
(3, 31, 36, NULL);

--
-- Déclencheurs `constituerdossier`
--
DROP TRIGGER IF EXISTS `apres_modification_dossier`;
DELIMITER //
CREATE TRIGGER `apres_modification_dossier` AFTER UPDATE ON `constituerdossier`
 FOR EACH ROW UPDATE dossierparcours set DATE_DERNIERE_MODIFICATION = NOW() where id_dossierparcours=NEW.id_dossierparcours
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `dossiergenerique`
--

CREATE TABLE IF NOT EXISTS `dossiergenerique` (
  `ID_CHAMP` bigint(11) NOT NULL,
  `ID_ONGLET` bigint(11) NOT NULL,
  `ID_PARCOURS` bigint(11) NOT NULL,
  `ID_ACTIVITE` bigint(11) NOT NULL,
  PRIMARY KEY (`ID_CHAMP`,`ID_ONGLET`,`ID_PARCOURS`,`ID_ACTIVITE`),
  KEY `I_FK_DOSSIERGENERIQUE_CHAMP` (`ID_CHAMP`),
  KEY `I_FK_DOSSIERGENERIQUE_ONGLET` (`ID_ONGLET`),
  KEY `I_FK_DOSSIERGENERIQUE_PARCOURS` (`ID_PARCOURS`),
  KEY `I_FK_DOSSIERGENERIQUE_ACTIVITE` (`ID_ACTIVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dossierparcours`
--

CREATE TABLE IF NOT EXISTS `dossierparcours` (
  `ID_DOSSIERPARCOURS` bigint(11) NOT NULL,
  `ID_PATIENT` bigint(11) NOT NULL,
  `ID_PARCOURS` bigint(11) NOT NULL,
  `DATE_CREATION_DOSSIER` date NOT NULL,
  `DATE_DERNIERE_MODIFICATION` date DEFAULT NULL,
  `DATE_DISPONIBLE_DEBUT` date DEFAULT NULL,
  `DATE_DISPONIBLE_FIN` date DEFAULT NULL,
  PRIMARY KEY (`ID_DOSSIERPARCOURS`),
  KEY `I_FK_DOSSIERPARCOURS_PATIENT` (`ID_PATIENT`),
  KEY `I_FK_DOSSIERPARCOURS_PARCOURS` (`ID_PARCOURS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dossierparcours`
--

INSERT INTO `dossierparcours` (`ID_DOSSIERPARCOURS`, `ID_PATIENT`, `ID_PARCOURS`, `DATE_CREATION_DOSSIER`, `DATE_DERNIERE_MODIFICATION`, `DATE_DISPONIBLE_DEBUT`, `DATE_DISPONIBLE_FIN`) VALUES
(33, 18, 1, '2019-01-22', '2019-01-22', '2019-01-22', '2019-01-22'),
(34, 2, 1, '2019-02-25', '2019-02-25', '2019-03-30', '2019-03-30'),
(35, 3, 1, '2019-02-25', '2019-02-25', '2019-03-30', '2019-03-30'),
(36, 7, 1, '2019-02-25', '2019-02-25', '2019-03-30', '2019-03-30');

--
-- Déclencheurs `dossierparcours`
--
DROP TRIGGER IF EXISTS `apres_creation_dossier_parcours`;
DELIMITER //
CREATE TRIGGER `apres_creation_dossier_parcours` AFTER INSERT ON `dossierparcours`
 FOR EACH ROW INSERT INTO constituerdossier (ID_CHAMP, ID_ONGLET, ID_DOSSIERPARCOURS, TXT_VALEUR)
SELECT id_champ,id_onglet, NEW.id_dossierparcours, NULL
FROM dossiergenerique
WHERE id_parcours = NEW.id_parcours
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `etreindisponible`
--

CREATE TABLE IF NOT EXISTS `etreindisponible` (
  `ID_ETREINDISPONIBLE` bigint(11) NOT NULL,
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `DATE_DEBUT` datetime NOT NULL,
  `DATE_FIN` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_ETREINDISPONIBLE`),
  KEY `I_FK_ETREINDISPONIBLE_RESSOURCE` (`ID_RESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etreindisponible`
--

INSERT INTO `etreindisponible` (`ID_ETREINDISPONIBLE`, `ID_RESSOURCE`, `DATE_DEBUT`, `DATE_FIN`) VALUES
(1, 1, '2018-04-13 00:04:00', '2018-04-13 23:53:00'),
(2, 6, '2018-09-27 00:00:00', '2018-09-30 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `end` datetime NOT NULL,
  `start` datetime NOT NULL,
  `ressourceId` bigint(11) NOT NULL,
  `patientId` bigint(11) NOT NULL,
  `parcoursId` bigint(11) NOT NULL,
  `activiteId` bigint(11) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `ressourceId` (`ressourceId`),
  KEY `patientId` (`patientId`),
  KEY `parcoursId` (`parcoursId`),
  KEY `activiteId` (`activiteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1660 ;

-- --------------------------------------------------------

--
-- Structure de la table `jour`
--

CREATE TABLE IF NOT EXISTS `jour` (
  `ID_JOUR` bigint(20) NOT NULL,
  `TXT_JOUR` varchar(20) NOT NULL,
  `INT_JOUR_SQL` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_JOUR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `jour`
--

INSERT INTO `jour` (`ID_JOUR`, `TXT_JOUR`, `INT_JOUR_SQL`) VALUES
(1, 'lundi', 0),
(2, 'mardi', 1),
(3, 'mercredi', 2),
(4, 'jeudi', 3),
(5, 'vendredi', 4),
(6, 'samedi', 5),
(7, 'dimanche', 6);

-- --------------------------------------------------------

--
-- Structure de la table `necessiter`
--

CREATE TABLE IF NOT EXISTS `necessiter` (
  `ID_ACTIVITE` bigint(11) NOT NULL,
  `ID_TYPERESSOURCE` bigint(11) NOT NULL,
  `QUANTITE` bigint(4) DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVITE`,`ID_TYPERESSOURCE`),
  KEY `I_FK_NECESSITER_ACTIVITE` (`ID_ACTIVITE`),
  KEY `I_FK_NECESSITER_TYPERESSOURCE` (`ID_TYPERESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `necessiter`
--

INSERT INTO `necessiter` (`ID_ACTIVITE`, `ID_TYPERESSOURCE`, `QUANTITE`) VALUES
(1, 1, 1),
(1, 44, 1),
(2, 2, 1),
(2, 41, 1),
(3, 2, 1),
(3, 41, 1),
(5, 1, 1),
(5, 43, 1),
(6, 3, 1),
(6, 44, 1),
(7, 1, 1),
(7, 44, 1),
(8, 4, 1),
(8, 44, 1),
(9, 5, 1),
(9, 44, 1),
(11, 44, 1),
(11, 55, 1),
(12, 43, 1),
(12, 56, 1),
(13, 42, 1),
(14, 44, 1),
(14, 56, 1),
(15, 45, 1),
(16, 55, 1),
(16, 58, 1),
(17, 2, 1),
(17, 58, 1),
(18, 2, 1),
(18, 57, 1),
(19, 42, 1),
(23, 44, 1),
(23, 59, 1),
(24, 44, 1),
(24, 60, 1),
(24, 63, 1),
(26, 42, 1),
(27, 42, 1),
(28, 46, 1),
(28, 60, 1),
(28, 61, 1),
(28, 62, 1),
(29, 44, 1),
(29, 60, 1),
(30, 2, 1),
(30, 41, 1),
(33, 2, 1),
(33, 44, 1),
(34, 4, 1),
(34, 44, 1),
(34, 60, 1),
(34, 64, 1),
(36, 44, 1),
(36, 65, 1),
(37, 57, 1),
(37, 65, 1),
(38, 57, 1),
(38, 65, 1),
(39, 44, 1),
(39, 66, 1),
(40, 2, 1),
(40, 58, 1),
(42, 57, 1),
(42, 65, 1),
(43, 58, 1),
(43, 70, 1),
(45, 44, 1),
(45, 67, 1),
(46, 2, 1),
(46, 57, 1),
(47, 58, 1),
(49, 42, 1),
(50, 44, 1),
(50, 68, 1),
(51, 44, 1),
(51, 69, 1),
(52, 42, 1),
(53, 42, 1),
(54, 44, 1),
(54, 68, 1),
(55, 42, 1),
(56, 71, 1),
(58, 42, 1),
(59, 42, 1),
(59, 72, 1),
(60, 58, 1),
(60, 70, 1),
(61, 44, 1),
(61, 72, 1),
(62, 42, 1),
(64, 58, 1),
(64, 72, 1),
(65, 44, 1),
(65, 73, 1),
(66, 3, 1),
(66, 44, 1);

-- --------------------------------------------------------

--
-- Structure de la table `onglet`
--

CREATE TABLE IF NOT EXISTS `onglet` (
  `ID_ONGLET` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `ID_ACTIVITE` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ONGLET`),
  KEY `FK_ID` (`ID_ACTIVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `onglet`
--

INSERT INTO `onglet` (`ID_ONGLET`, `TXT_NOM`, `ID_ACTIVITE`) VALUES
(0, 'Début', 0),
(1, 'RDV paramédical', 1),
(2, 'ECG', 2),
(3, 'Bilan biologique', 3),
(4, 'Echo hépatique', 4),
(5, 'Calorimétrie', 5),
(6, 'Entretien psy', 6),
(7, 'Entretien infirmier', 7),
(8, 'Entretien diet', 8),
(9, 'synthèse', 9),
(10, 'TOGD', 10),
(11, 'Bilan anthropométrique', 11),
(12, 'Fibroscan', 12),
(13, 'Scanner abdo', 13),
(14, 'Entretien hépato', 14),
(15, 'Traitement Rémicade', 15),
(16, 'Ponction Ascite', 16),
(17, 'Soins ponction', 17),
(18, 'Injection Ferinject', 18),
(19, 'Injection', 19),
(20, 'Scintigraphie myocardique', 20),
(21, 'Scanner des corronaires', 21),
(22, 'Echodoppler TSA et MI', 22),
(23, 'Rétinographie', 23),
(24, 'Pose Holter', 24),
(26, 'Scanner TMD pied + radios', 26),
(27, 'Doppler des artères des MI', 27),
(28, 'Soin, pansement, mesures IPS', 28),
(29, 'RDV médical', 29),
(30, 'Prélèvement', 30),
(31, 'Collation', 31),
(33, 'RDV Paramédical', 33),
(34, 'RDV médical + diet', 34),
(35, 'OK chimio', 35),
(36, 'RDV paramédical chimio', 36),
(37, 'Pose d''aiguille PAC', 37),
(38, 'Prémédication', 38),
(39, 'Consultation médicale', 39),
(40, 'Examens', 40),
(41, 'OK administration', 41),
(42, 'Administration chimio', 42),
(43, 'ETP', 43),
(44, 'ETP', 44),
(45, 'Consultation médiacle gériatrie', 45),
(46, 'Soins', 46),
(47, 'Examens', 47),
(48, 'Test d''efforts', 48),
(49, 'Explorations fonctionnelles ou morphologiques', 49),
(50, 'Bilan cardio', 50),
(51, 'Test fonctionnel', 51),
(52, 'IRM', 52),
(53, 'Echo cardiaque', 53),
(54, 'Examens cliniques', 54),
(55, 'Médecine nucléaire', 55),
(56, 'RDV Accueil', 56),
(57, 'ARM', 57),
(58, 'Echodoppler TSA', 58),
(59, 'ETT', 59),
(60, 'Holter', 60),
(61, 'Synthèse neuro', 61),
(62, 'EEG', 62),
(63, 'Scintigraphie cérébrale', 63),
(64, 'Ponction lombaire', 64),
(65, 'Consultation neuropsy', 65),
(66, 'Consultation psy', 66);

-- --------------------------------------------------------

--
-- Structure de la table `ordonnancer`
--

CREATE TABLE IF NOT EXISTS `ordonnancer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `end` datetime NOT NULL,
  `start` datetime NOT NULL,
  `ressourceId` bigint(11) NOT NULL,
  `patientId` bigint(11) NOT NULL,
  `parcoursId` bigint(11) NOT NULL,
  `activiteId` bigint(11) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `ressourceId` (`ressourceId`),
  KEY `patientId` (`patientId`),
  KEY `parcoursId` (`parcoursId`),
  KEY `activiteId` (`activiteId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1600 ;

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE IF NOT EXISTS `parcours` (
  `ID_PARCOURS` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `INT_OBJECTIF` int(11) DEFAULT NULL,
  `TXT_CODE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PARCOURS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `parcours`
--

INSERT INTO `parcours` (`ID_PARCOURS`, `TXT_NOM`, `INT_OBJECTIF`, `TXT_CODE`) VALUES
(1, 'Obésité sévère – diagnostique', NULL, 'P1'),
(2, 'Obésité sévère – Post-op', NULL, 'P2'),
(3, 'Obésité sévère – J+1an', NULL, 'P3'),
(4, 'Bilan nutritionnel hors obésité sévère', NULL, 'P4'),
(5, 'Dépistage des maladies du foie', NULL, 'P5'),
(6, 'Biothérapies (dont MICI)', NULL, 'P6'),
(7, 'Ponction ascite', NULL, 'P8'),
(8, 'Injection de fer', NULL, 'P9'),
(9, 'Bilan des complications du diabète', NULL, 'P10'),
(10, 'Bilan diagnostic étiologique et/ou décompensation d''un diabète avec initiation de la prise en charge', NULL, 'P11'),
(11, 'Traitement du pied diabétique', NULL, 'P12'),
(12, 'ETP diabétique', NULL, 'P13'),
(16, 'Chimio - Avec OK chimio', NULL, 'P17'),
(17, 'Chimio - sans OK chimio', NULL, 'P17'),
(18, 'Cardio – explorations de la maladie coronaire', NULL, 'P20'),
(19, 'Cardio – insuffisance cardiaque', NULL, 'P21'),
(20, 'Cardio – onco', NULL, 'P22'),
(21, 'AIT ', NULL, 'P23'),
(22, 'Bilan troubles cognitifs', NULL, 'P24'),
(23, 'Epilepsie', NULL, 'P25'),
(24, 'Céphalées sub-aigues', NULL, 'P26'),
(25, 'Gériatrie', NULL, 'P18'),
(26, 'Parcours long médecine', NULL, 'P19');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `ID_PATIENT` bigint(11) NOT NULL,
  `ID_COMPTE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `TXT_PRENOM` varchar(255) DEFAULT NULL,
  `TXT_ADRESSENUM` varchar(255) DEFAULT NULL,
  `TXT_ADRESSERUE` varchar(255) DEFAULT NULL,
  `TXT_ADRESSECODEPOSTAL` varchar(255) DEFAULT NULL,
  `TXT_ADRESSEVILLE` varchar(255) DEFAULT NULL,
  `TXT_ADRESSEPAYS` varchar(255) DEFAULT NULL,
  `TXT_MAIL` varchar(255) DEFAULT NULL,
  `TXT_TELEPHONEFIXE` varchar(255) DEFAULT NULL,
  `TXT_TELEPHONEPORTABLE` varchar(255) DEFAULT NULL,
  `TXT_NUMSECU` varchar(255) DEFAULT NULL,
  `DATE_NAISSANCE` date DEFAULT NULL,
  `ID_PARCOURS_SUP` bigint(11) DEFAULT NULL,
  `DATE_DISPONIBLE_DEBUT` datetime DEFAULT NULL,
  `DATE_DISPONIBLE_FIN` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_PATIENT`),
  KEY `I_FK_PATIENT_COMPTE` (`ID_COMPTE`),
  KEY `I_FK_PATIENT_PARCOURS` (`ID_PARCOURS_SUP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `patient`
--

INSERT INTO `patient` (`ID_PATIENT`, `ID_COMPTE`, `TXT_NOM`, `TXT_PRENOM`, `TXT_ADRESSENUM`, `TXT_ADRESSERUE`, `TXT_ADRESSECODEPOSTAL`, `TXT_ADRESSEVILLE`, `TXT_ADRESSEPAYS`, `TXT_MAIL`, `TXT_TELEPHONEFIXE`, `TXT_TELEPHONEPORTABLE`, `TXT_NUMSECU`, `DATE_NAISSANCE`, `ID_PARCOURS_SUP`, `DATE_DISPONIBLE_DEBUT`, `DATE_DISPONIBLE_FIN`) VALUES
(2, 2, 'Bernard', 'Laurent', '15', 'Arbre Sec', '75000', 'Paris', 'France', 'bernard.laurent@gmail.com', '0123456789', '0753868024', '123456789012345', '1990-09-12', 1, '2019-03-30 08:30:00', '2019-03-30 19:05:00'),
(3, 3, 'Dubois', 'Lefebvre', '6', 'Cambon', '75000', 'Paris', 'France', 'dubois.lefebvre@gmail.com', '0123456789', '0753868029', '123456789012345', '1983-10-17', 1, '2019-03-30 08:30:00', '2019-03-30 19:30:00'),
(7, 7, 'Petit', 'Bertrand', '7', 'Duphot', '37000', 'Tours', 'France', 'petit.bertrand@hotmail.com', '0123456789', '0658426125', '123456789012345', '1986-08-12', 1, '2019-03-30 08:20:00', '2019-03-30 19:50:00'),
(18, 64, 'Sebastien', 'Patrick', '25', 'Avenue de la fête', '75000', 'Paris', 'France', 'patseb@mail.fr', '02555841564564564589654', '844159865946194619461', '447974516816', '1950-04-24', 1, '2019-01-22 09:00:00', '2019-01-22 19:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE IF NOT EXISTS `personnel` (
  `ID_PERSONNEL` bigint(11) NOT NULL,
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `ID_COMPTE` bigint(11) NOT NULL,
  `TXT_NOM` char(255) DEFAULT NULL,
  `TXT_PRENOM` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PERSONNEL`),
  KEY `I_FK_PERSONNEL_RESSOURCE` (`ID_RESSOURCE`),
  KEY `I_FK_PERSONNEL_COMPTE` (`ID_COMPTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personnel`
--

INSERT INTO `personnel` (`ID_PERSONNEL`, `ID_RESSOURCE`, `ID_COMPTE`, `TXT_NOM`, `TXT_PRENOM`) VALUES
(1, 1, 11, 'Cheniour', 'Soumaya'),
(3, 3, 13, 'Attias', 'Elie'),
(4, 4, 14, 'Cabinet', 'Selarl'),
(5, 5, 15, 'Pasquet', 'Jean-Pierre'),
(6, 6, 16, 'Viomesnil', 'Vanessa'),
(7, 7, 17, 'Guerrero', 'Jean-Marc'),
(8, 8, 18, 'Neuman', 'Caroline'),
(9, 9, 19, 'Teboul', 'Patrick'),
(10, 10, 20, 'Belhadj', 'Karim'),
(32, 32, 22, 'Jean', 'Roche'),
(34, 34, 24, 'Pierre', 'Marie'),
(35, 35, 25, 'Jacques', 'Simon'),
(36, 36, 26, 'Delo', 'Marie'),
(37, 37, 27, 'Ruit', 'Pauline'),
(41, 41, 65, 'Sébastien', 'Patrick'),
(42, 42, 66, 'Hépato', 'Médecin'),
(46, 46, 67, 'Orthoptiste', 'Jean'),
(47, 47, 68, 'Diabétologue', 'Michel'),
(48, 48, 69, 'Pansement', 'IDE'),
(49, 49, 70, 'Podologue', 'Denis'),
(50, 50, 71, 'Insuline', 'Pompe'),
(51, 51, 72, 'Thérapie', 'Insulino'),
(52, 52, 73, 'Chimio', 'infirmier'),
(53, 53, 74, 'Généraliste', 'Jérôme'),
(54, 54, 75, 'Gériatre', 'Gérard'),
(55, 55, 76, 'Cardiologue', 'Michael'),
(56, 56, 77, 'Kiné', 'Jean'),
(57, 57, 78, 'Cardio', 'Infirmier'),
(59, 59, 80, 'Neurologue', 'Alphonse'),
(60, 60, 81, 'Psychiatre', 'Neuro'),
(65, 65, 92, 'Chimios', 'IDE'),
(67, 67, 94, 'Interne', 'Obesite'),
(68, 68, 95, 'Medecin', 'Generaliste');

-- --------------------------------------------------------

--
-- Structure de la table `planparcours`
--

CREATE TABLE IF NOT EXISTS `planparcours` (
  `ID_PARCOURS` bigint(20) NOT NULL,
  `ID_JOUR` bigint(20) NOT NULL,
  `INT_NB_PATIENT` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_PARCOURS`,`ID_JOUR`),
  KEY `planparcours_ibfk_2` (`ID_JOUR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='le nombre de patient qui exécutent ce parcours à ce jour';

--
-- Contenu de la table `planparcours`
--

INSERT INTO `planparcours` (`ID_PARCOURS`, `ID_JOUR`, `INT_NB_PATIENT`) VALUES
(1, 1, 24),
(1, 2, 4),
(1, 3, 8),
(1, 4, 6),
(1, 5, 6),
(2, 1, 10),
(2, 2, 10),
(2, 3, 10),
(2, 4, 10),
(2, 5, 10),
(3, 1, 10),
(3, 2, 10),
(3, 3, 10),
(3, 4, 10),
(3, 5, 10),
(4, 1, 10),
(4, 2, 10),
(4, 3, 10),
(4, 4, 10),
(4, 5, 10),
(5, 1, 10),
(5, 2, 10),
(5, 3, 10),
(5, 4, 10),
(5, 5, 10),
(6, 1, 10),
(6, 2, 10),
(6, 3, 10),
(6, 4, 10),
(6, 5, 10),
(7, 1, 10),
(7, 2, 10),
(7, 3, 10),
(7, 4, 10),
(7, 5, 10),
(8, 1, 10),
(8, 2, 10),
(8, 3, 10),
(8, 4, 10),
(8, 5, 10),
(9, 1, 10),
(9, 2, 10),
(9, 3, 10),
(9, 4, 10),
(9, 5, 10),
(10, 1, 10),
(10, 2, 10),
(10, 3, 10),
(10, 4, 10),
(10, 5, 10),
(11, 1, 10),
(11, 2, 10),
(11, 3, 10),
(11, 4, 10),
(11, 5, 10),
(12, 1, 6),
(12, 2, 4),
(12, 3, 10),
(12, 4, 10),
(12, 5, 10),
(25, 1, 5),
(25, 2, 5),
(25, 3, 5),
(25, 4, 5),
(25, 5, 5),
(26, 1, 5),
(26, 2, 5),
(26, 3, 5),
(26, 4, 5),
(26, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ressource`
--

CREATE TABLE IF NOT EXISTS `ressource` (
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `ID_TYPERESSOURCE` bigint(11) NOT NULL,
  PRIMARY KEY (`ID_RESSOURCE`),
  KEY `I_FK_RESSOURCE_TYPERESSOURCE` (`ID_TYPERESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ressource`
--

INSERT INTO `ressource` (`ID_RESSOURCE`, `ID_TYPERESSOURCE`) VALUES
(0, 0),
(1, 1),
(37, 1),
(3, 2),
(4, 2),
(32, 2),
(36, 2),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(34, 4),
(9, 5),
(10, 5),
(35, 5),
(11, 6),
(12, 6),
(13, 7),
(14, 7),
(15, 8),
(16, 8),
(19, 41),
(20, 41),
(23, 43),
(24, 43),
(39, 43),
(25, 44),
(26, 44),
(61, 44),
(28, 45),
(29, 46),
(30, 46),
(41, 55),
(67, 55),
(42, 56),
(27, 57),
(43, 57),
(44, 57),
(45, 58),
(46, 59),
(47, 60),
(48, 61),
(49, 62),
(50, 63),
(51, 64),
(52, 65),
(65, 65),
(53, 66),
(68, 66),
(54, 67),
(55, 68),
(56, 69),
(57, 70),
(59, 72),
(60, 73);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `ID_SALLE` bigint(11) NOT NULL,
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_SALLE`),
  KEY `I_FK_SALLE_RESSOURCE` (`ID_RESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`ID_SALLE`, `ID_RESSOURCE`, `TXT_NOM`) VALUES
(3, 19, 'Box prélèvement 1'),
(4, 20, 'Box prélèvement 2'),
(5, 23, 'HDJ obésité 1'),
(6, 24, 'HDJ obésité 2'),
(7, 25, 'Bureau CS 1'),
(8, 26, 'Bureau CS 2'),
(9, 27, 'Box soin commun 3'),
(10, 28, 'Box soin 2'),
(11, 29, 'Salle pansement 1'),
(12, 30, 'Salle pansement 2'),
(39, 39, 'HDJ obésité 3'),
(43, 43, 'Box soin commun 1'),
(44, 44, 'Box Soin Commun 2'),
(45, 45, 'Box soin individuel 1'),
(61, 61, 'Bureau CS 3');

-- --------------------------------------------------------

--
-- Structure de la table `typechamp`
--

CREATE TABLE IF NOT EXISTS `typechamp` (
  `ID_TYPECHAMP` bigint(11) NOT NULL,
  `TXT_LIBELLE` varchar(255) DEFAULT NULL,
  `TXT_VALEUR` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`ID_TYPECHAMP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typechamp`
--

INSERT INTO `typechamp` (`ID_TYPECHAMP`, `TXT_LIBELLE`, `TXT_VALEUR`) VALUES
(1, 'Texte', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <input type="text" class="form-control" id="!!ID!!" value="!!VALEUR!!">\r\n		              </div>\r\n		            </div>'),
(2, 'Date', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <input type="text" class="form-control" id="!!ID!!" value="!!VALEUR!!">\r\n		                <script type="text/javascript">\r\n		                $("body").delegate("#!!ID!!", "focusin", function(){\r\n							   $(this).datepicker();\r\n							});\r\n				        </script>\r\n		              </div>\r\n		            </div>\r\n'),
(3, 'Texte multiligne', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <textarea class="form-control" rows="3"  id="!!ID!!">!!VALEUR!!</textarea>\r\n		              </div>\r\n		            </div>'),
(4, 'Numérique', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <input type="number" class="form-control" id="!!ID!!" value="!!VALEUR!!">\r\n		              </div>\r\n		            </div>');

-- --------------------------------------------------------

--
-- Structure de la table `typecompte`
--

CREATE TABLE IF NOT EXISTS `typecompte` (
  `ID_TYPECOMPTE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(16) NOT NULL,
  `INT_NIVEAU` int(11) NOT NULL,
  PRIMARY KEY (`ID_TYPECOMPTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typecompte`
--

INSERT INTO `typecompte` (`ID_TYPECOMPTE`, `TXT_NOM`, `INT_NIVEAU`) VALUES
(1, 'patient', 1),
(2, 'personnel', 2),
(3, 'coordination', 3),
(4, 'admin', 3);

-- --------------------------------------------------------

--
-- Structure de la table `typeressource`
--

CREATE TABLE IF NOT EXISTS `typeressource` (
  `ID_TYPERESSOURCE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_TYPERESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `typeressource`
--

INSERT INTO `typeressource` (`ID_TYPERESSOURCE`, `TXT_NOM`) VALUES
(0, 'Autres'),
(1, 'IDE obésité'),
(2, 'IDE'),
(3, 'Psychologue'),
(4, 'Diététicien'),
(5, 'nutritioniste'),
(6, 'Interne obésité'),
(7, 'Médecin hépato'),
(8, 'externe'),
(9, 'IDE cardio'),
(10, 'cardiologue'),
(11, 'Orthoptiste'),
(12, 'Diabétologue'),
(13, 'Podologue'),
(14, 'Podologue'),
(15, 'IDE pansement'),
(16, 'médecin'),
(17, 'IDE pompe insuline'),
(18, 'IDE insulinothérapie'),
(19, 'Technicien (IDE)'),
(20, 'IDE sommeil'),
(21, 'aide-soignante'),
(22, 'Médecin du sommeil'),
(23, 'prestataire'),
(24, 'IDE chimio'),
(25, 'Généraliste'),
(40, 'Box'),
(41, 'Box prélèvement'),
(42, 'Hors HDJ'),
(43, 'HDJ obésité'),
(44, 'Bureau CS'),
(45, 'Box soin'),
(46, 'Salle pansement'),
(47, 'Chambre du patient'),
(48, 'Explorations fonctionnelles'),
(49, 'Pièce isolée avec fauteuil'),
(50, 'a'),
(51, 'f'),
(52, 'a'),
(53, 'a'),
(54, 'f'),
(55, 'Interne obésité'),
(56, 'Médecin Hépato'),
(57, 'Box Soin Commun'),
(58, 'Box Soin Individuel'),
(59, 'Orthoptiste'),
(60, 'Diabétologue'),
(61, 'IDE Pansement'),
(62, 'Podologue'),
(63, 'IDE pompe insuline'),
(64, 'IDE insulinothérapie'),
(65, 'IDE chimio'),
(66, 'Généraliste'),
(67, 'Gériatre'),
(68, 'Cardiologue'),
(69, 'Kinésithérapeute'),
(70, 'IDE Cardio'),
(71, 'Agent Accueil'),
(72, 'Neurologue'),
(73, 'Neuropsychiatre');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `champ`
--
ALTER TABLE `champ`
  ADD CONSTRAINT `champ_ibfk_1` FOREIGN KEY (`ID_TYPECHAMP`) REFERENCES `typechamp` (`ID_TYPECHAMP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `composer_ibfk_1` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `composer_ibfk_2` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `composer_ibfk_3` FOREIGN KEY (`ID_ACTIVITE_PRECEDENTE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_ibfk_1` FOREIGN KEY (`ID_TYPECOMPTE`) REFERENCES `typecompte` (`ID_TYPECOMPTE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `constituerdossier`
--
ALTER TABLE `constituerdossier`
  ADD CONSTRAINT `constituerdossier_ibfk_1` FOREIGN KEY (`ID_CHAMP`) REFERENCES `champ` (`ID_CHAMP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constituerdossier_ibfk_2` FOREIGN KEY (`ID_DOSSIERPARCOURS`) REFERENCES `dossierparcours` (`ID_DOSSIERPARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constituerdossier_ibfk_3` FOREIGN KEY (`ID_ONGLET`) REFERENCES `onglet` (`ID_ONGLET`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dossiergenerique`
--
ALTER TABLE `dossiergenerique`
  ADD CONSTRAINT `dossiergenerique_ibfk_1` FOREIGN KEY (`ID_CHAMP`) REFERENCES `champ` (`ID_CHAMP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiergenerique_ibfk_2` FOREIGN KEY (`ID_ONGLET`) REFERENCES `onglet` (`ID_ONGLET`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiergenerique_ibfk_3` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiergenerique_ibfk_4` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dossierparcours`
--
ALTER TABLE `dossierparcours`
  ADD CONSTRAINT `dossierparcours_ibfk_1` FOREIGN KEY (`ID_PATIENT`) REFERENCES `patient` (`ID_PATIENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossierparcours_ibfk_2` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `etreindisponible`
--
ALTER TABLE `etreindisponible`
  ADD CONSTRAINT `etreindisponible_ibfk_1` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`ressourceId`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`patientId`) REFERENCES `patient` (`ID_PATIENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_3` FOREIGN KEY (`parcoursId`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_4` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `necessiter`
--
ALTER TABLE `necessiter`
  ADD CONSTRAINT `necessiter_ibfk_1` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `necessiter_ibfk_2` FOREIGN KEY (`ID_TYPERESSOURCE`) REFERENCES `typeressource` (`ID_TYPERESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `onglet`
--
ALTER TABLE `onglet`
  ADD CONSTRAINT `FK_ID` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ordonnancer`
--
ALTER TABLE `ordonnancer`
  ADD CONSTRAINT `ordonnancer_ibfk_1` FOREIGN KEY (`ressourceId`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordonnancer_ibfk_2` FOREIGN KEY (`patientId`) REFERENCES `patient` (`ID_PATIENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordonnancer_ibfk_3` FOREIGN KEY (`parcoursId`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordonnancer_ibfk_4` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `planparcours`
--
ALTER TABLE `planparcours`
  ADD CONSTRAINT `planparcours_ibfk_1` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planparcours_ibfk_2` FOREIGN KEY (`ID_JOUR`) REFERENCES `jour` (`ID_JOUR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
