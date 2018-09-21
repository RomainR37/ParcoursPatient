-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2018-03-27 22:00:03
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `subway`
--

-- --------------------------------------------------------

--
-- 表的结构 `activite`
--
CREATE DATABASE IF NOT EXISTS `subway` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `subway`;

CREATE TABLE IF NOT EXISTS `activite` (
  `ID_ACTIVITE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `INT_DUREE` bigint(4) DEFAULT NULL,
  `TXT_COMMENTAIRE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `activite`
--

INSERT INTO `activite` (`ID_ACTIVITE`, `TXT_NOM`, `INT_DUREE`, `TXT_COMMENTAIRE`) VALUES
(0, 'Début', 0, NULL),
(1, 'RDV paramédical', 20, 'Consultation'),
(2, 'ECG', 15, NULL),
(3, 'Bilan biologique', 15, 'Prélèvement à jeun'),
(4, 'Echo hépatique', 15, 'A jeun'),
(5, 'Calorimétrie', 30, NULL),
(6, 'Entretien psy', 40, NULL),
(7, 'Entretien infirmier', 30, NULL),
(8, 'Entretien diet', 60, NULL),
(9, 'synthèse', 30, NULL),
(10, 'TOGD', 20, NULL),
(11, 'Bilan anthropométrique', 60, NULL),
(12, 'Fibroscan', 10, NULL),
(13, 'Scanner abdo', 20, ''),
(14, 'Entretien hépato', 45, NULL),
(15, 'Traitement Rémicade', 120, NULL),
(16, 'Ponction Ascite', 180, NULL),
(17, 'Soins ponction', 135, NULL),
(18, 'Injection Ferinject', 60, NULL),
(19, 'Injection', 40, NULL),
(20, 'Scintigraphie myocardique', 30, NULL),
(21, 'Scanner des corronaires', 10, NULL),
(22, 'Echodoppler TSA et MI', 30, NULL),
(23, 'Rétinographie', 15, NULL),
(24, 'Pose Holter', 15, NULL),
(25, 'Scanner abdo', 30, NULL),
(26, 'Scanner TMD pied + radios', 40, NULL),
(27, 'Doppler des artères des MI', 30, NULL),
(28, 'Soin, pansement, mesures IPS', 40, NULL),
(29, 'RDV médical', 35, NULL),
(30, 'Prélèvement', 15, NULL),
(31, 'Collation', 10, NULL),
(32, 'Synthèse', 30, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `champ`
--

CREATE TABLE IF NOT EXISTS `champ` (
  `ID_CHAMP` bigint(11) NOT NULL,
  `ID_TYPECHAMP` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_CHAMP`),
  KEY `I_FK_CHAMP_TYPECHAMP` (`ID_TYPECHAMP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `champ`
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
(12, 1, 'NEW');

-- --------------------------------------------------------

--
-- 表的结构 `composer`
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
-- 转存表中的数据 `composer`
--

INSERT INTO `composer` (`ID_PARCOURS`, `ID_ACTIVITE`, `ID_ACTIVITE_PRECEDENTE`, `INT_DELAIMIN`, `INT_DELAIMAX`) VALUES
(1, 1, 0, 0, 0),
(1, 2, 1, 5, 100),
(1, 3, 1, 10, 60),
(1, 4, 1, 20, 80),
(1, 5, 1, 10, 60),
(1, 6, 31, 0, 60),
(1, 7, 31, 5, 130),
(1, 8, 31, 5, 120),
(1, 9, 6, 0, 120),
(1, 9, 7, 10, 130),
(1, 9, 8, 5, 120),
(1, 31, 2, 0, 130),
(1, 31, 3, 0, 100),
(1, 31, 4, 5, 100),
(1, 31, 5, 0, 90),
(26, 1, 0, 0, 0),
(26, 13, 1, 5, 15),
(27, 1, 0, 0, 0),
(27, 4, 1, 5, 20),
(27, 13, 4, 10, 15);

-- --------------------------------------------------------

--
-- 表的结构 `compte`
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
-- 转存表中的数据 `compte`
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
(61, 'YANG.ying', '$2bk6E2mLJ4Es', 1);

-- --------------------------------------------------------

--
-- 表的结构 `constituerdossier`
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
-- 转存表中的数据 `constituerdossier`
--

INSERT INTO `constituerdossier` (`ID_CHAMP`, `ID_ONGLET`, `ID_DOSSIERPARCOURS`, `TXT_VALEUR`) VALUES
(2, 1, 2, NULL),
(3, 1, 2, '03/07/2018'),
(2, 2, 2, NULL),
(3, 2, 2, NULL),
(2, 3, 2, NULL),
(3, 3, 2, NULL),
(2, 4, 2, NULL),
(3, 4, 2, NULL),
(2, 5, 2, NULL),
(3, 5, 2, NULL),
(2, 6, 2, NULL),
(3, 6, 2, NULL),
(2, 7, 2, NULL),
(3, 7, 2, NULL),
(2, 8, 2, NULL),
(3, 8, 2, NULL),
(2, 9, 2, NULL),
(3, 9, 2, NULL),
(2, 9, 2, NULL),
(3, 9, 2, NULL),
(2, 9, 2, NULL),
(3, 9, 2, NULL),
(2, 31, 2, NULL),
(3, 31, 2, NULL),
(2, 31, 2, NULL),
(3, 31, 2, NULL),
(2, 31, 2, NULL),
(3, 31, 2, NULL),
(2, 31, 2, NULL),
(3, 31, 2, NULL),
(2, 1, 4, NULL),
(3, 1, 4, NULL),
(2, 2, 4, NULL),
(3, 2, 4, NULL),
(2, 3, 4, NULL),
(3, 3, 4, NULL),
(2, 4, 4, NULL),
(3, 4, 4, NULL),
(2, 5, 4, NULL),
(3, 5, 4, NULL),
(2, 6, 4, NULL),
(3, 6, 4, NULL),
(2, 7, 4, NULL),
(3, 7, 4, NULL),
(2, 8, 4, NULL),
(3, 8, 4, NULL),
(2, 9, 4, NULL),
(3, 9, 4, NULL),
(2, 9, 4, NULL),
(3, 9, 4, NULL),
(2, 9, 4, NULL),
(3, 9, 4, NULL),
(2, 31, 4, NULL),
(3, 31, 4, NULL),
(2, 31, 4, NULL),
(3, 31, 4, NULL),
(2, 31, 4, NULL),
(3, 31, 4, NULL),
(2, 31, 4, NULL),
(3, 31, 4, NULL),
(2, 1, 1, NULL),
(3, 1, 1, ''),
(2, 13, 1, NULL),
(3, 13, 1, NULL),
(2, 1, 5, NULL),
(3, 1, 5, NULL),
(2, 4, 5, NULL),
(3, 4, 5, NULL),
(2, 13, 5, NULL),
(3, 13, 5, NULL),
(11, 1, 1, 'OK'),
(12, 1, 2, 'BIEN');

--
-- 触发器 `constituerdossier`
--
DROP TRIGGER IF EXISTS `apres_modification_dossier`;
DELIMITER //
CREATE TRIGGER `apres_modification_dossier` AFTER UPDATE ON `constituerdossier`
 FOR EACH ROW UPDATE dossierparcours set DATE_DERNIERE_MODIFICATION = NOW() where id_dossierparcours=NEW.id_dossierparcours
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `dossiergenerique`
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
-- 表的结构 `dossierparcours`
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
-- 转存表中的数据 `dossierparcours`
--

INSERT INTO `dossierparcours` (`ID_DOSSIERPARCOURS`, `ID_PATIENT`, `ID_PARCOURS`, `DATE_CREATION_DOSSIER`, `DATE_DERNIERE_MODIFICATION`, `DATE_DISPONIBLE_DEBUT`, `DATE_DISPONIBLE_FIN`) VALUES
(1, 12, 26, '2018-03-27', '2018-03-27', '2018-03-28', '2018-03-28'),
(2, 12, 1, '2018-03-27', '2018-03-27', '2018-03-31', '2018-03-31'),
(4, 12, 1, '2018-03-27', '2018-03-27', '2018-04-07', '2018-04-07'),
(5, 12, 27, '2018-03-27', '2018-03-27', '2018-03-21', '2018-03-21');

--
-- 触发器 `dossierparcours`
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
-- 表的结构 `etreindisponible`
--

CREATE TABLE IF NOT EXISTS `etreindisponible` (
  `ID_ETREINDISPONIBLE` bigint(11) NOT NULL,
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `DATE_DEBUT` datetime NOT NULL,
  `DATE_FIN` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_ETREINDISPONIBLE`),
  KEY `I_FK_ETREINDISPONIBLE_RESSOURCE` (`ID_RESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `evenement`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=480 ;

--
-- 转存表中的数据 `evenement`
--

INSERT INTO `evenement` (`id`, `title`, `end`, `start`, `ressourceId`, `patientId`, `parcoursId`, `activiteId`, `color`) VALUES
(325, 'Martin Simon - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 10:20:00', '2017-04-06 10:00:00', 1, 1, 1, 1, '#FF1490'),
(326, 'Martin Simon - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 10:20:00', '2017-04-06 10:00:00', 23, 1, 1, 1, '#FF1490'),
(329, 'Martin Simon - ECG - Obésité sévère – diagnostique', '2017-04-06 10:40:00', '2017-04-06 10:25:00', 3, 1, 1, 2, '#FF1490'),
(330, 'Martin Simon - ECG - Obésité sévère – diagnostique', '2017-04-06 10:40:00', '2017-04-06 10:25:00', 17, 1, 1, 2, '#FF1490'),
(331, 'Martin Simon - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 11:15:00', '2017-04-06 11:00:00', 4, 1, 1, 3, '#FF1490'),
(332, 'Martin Simon - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 11:15:00', '2017-04-06 11:00:00', 19, 1, 1, 3, '#FF1490'),
(333, 'Martin Simon - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 11:00:00', '2017-04-06 10:45:00', 31, 1, 1, 4, '#FF1490'),
(335, 'Martin Simon - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 11:45:00', '2017-04-06 11:15:00', 39, 1, 1, 5, '#FF1490'),
(336, 'Martin Simon - Collation - Obésité sévère – diagnostique', '2017-04-06 11:55:00', '2017-04-06 11:45:00', 3, 1, 1, 31, '#FF1490'),
(337, 'Martin Simon - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 11:55:00', 5, 1, 1, 6, '#FF1490'),
(338, 'Martin Simon - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 11:55:00', 25, 1, 1, 6, '#FF1490'),
(339, 'Martin Simon - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 14:05:00', '2017-04-06 13:35:00', 1, 1, 1, 7, '#FF1490'),
(340, 'Martin Simon - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 14:05:00', '2017-04-06 13:35:00', 23, 1, 1, 7, '#FF1490'),
(341, 'Martin Simon - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:35:00', '2017-04-06 12:35:00', 7, 1, 1, 8, '#FF1490'),
(342, 'Martin Simon - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:35:00', '2017-04-06 12:35:00', 24, 1, 1, 8, '#FF1490'),
(343, 'Martin Simon - synthèse - Obésité sévère – diagnostique', '2017-04-06 14:45:00', '2017-04-06 14:15:00', 9, 1, 1, 9, '#FF1490'),
(344, 'Martin Simon - synthèse - Obésité sévère – diagnostique', '2017-04-06 14:45:00', '2017-04-06 14:15:00', 23, 1, 1, 9, '#FF1490'),
(346, 'Bernard Laurent - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 09:10:00', '2017-04-06 08:50:00', 23, 2, 1, 1, '#90BC90'),
(347, 'Bernard Laurent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:30:00', '2017-04-06 09:15:00', 3, 2, 1, 2, '#90BC90'),
(348, 'Bernard Laurent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:30:00', '2017-04-06 09:15:00', 17, 2, 1, 2, '#90BC90'),
(349, 'Bernard Laurent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:45:00', '2017-04-06 09:30:00', 4, 2, 1, 3, '#90BC90'),
(350, 'Bernard Laurent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:45:00', '2017-04-06 09:30:00', 19, 2, 1, 3, '#90BC90'),
(351, 'Bernard Laurent - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 10:00:00', '2017-04-06 09:45:00', 31, 2, 1, 4, '#90BC90'),
(352, 'Bernard Laurent - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 10:00:00', 37, 2, 1, 5, '#90BC90'),
(353, 'Bernard Laurent - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 10:00:00', 24, 2, 1, 5, '#90BC90'),
(354, 'Bernard Laurent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:25:00', '2017-04-06 10:45:00', 5, 2, 1, 6, '#90BC90'),
(355, 'Bernard Laurent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:25:00', '2017-04-06 10:45:00', 25, 2, 1, 6, '#90BC90'),
(356, 'Bernard Laurent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:05:00', '2017-04-06 11:35:00', 1, 2, 1, 7, '#90BC90'),
(357, 'Bernard Laurent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:05:00', '2017-04-06 11:35:00', 24, 2, 1, 7, '#90BC90'),
(364, 'Bernard Laurent - Collation - Obésité sévère – diagnostique', '2017-04-06 10:40:00', '2017-04-06 10:30:00', 6, 2, 1, 31, '#90BC90'),
(373, 'Bernard Laurent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:05:00', '2017-04-06 12:05:00', 34, 2, 1, 8, '#90BC90'),
(374, 'Bernard Laurent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:05:00', '2017-04-06 12:05:00', 23, 2, 1, 8, '#90BC90'),
(375, 'Bernard Laurent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:50:00', '2017-04-06 13:20:00', 10, 2, 1, 9, '#90BC90'),
(376, 'Bernard Laurent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:50:00', '2017-04-06 13:20:00', 39, 2, 1, 9, '#90BC90'),
(377, 'Robert Garcia - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 08:20:00', '2017-04-06 08:00:00', 1, 5, 1, 1, '#880088'),
(378, 'Robert Garcia - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 08:20:00', '2017-04-06 08:00:00', 23, 5, 1, 1, '#880088'),
(379, 'Robert Garcia - ECG - Obésité sévère – diagnostique', '2017-04-06 08:40:00', '2017-04-06 08:25:00', 3, 5, 1, 2, '#880088'),
(380, 'Robert Garcia - ECG - Obésité sévère – diagnostique', '2017-04-06 08:40:00', '2017-04-06 08:25:00', 17, 5, 1, 2, '#880088'),
(381, 'Robert Garcia - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 08:55:00', '2017-04-06 08:40:00', 4, 5, 1, 3, '#880088'),
(382, 'Robert Garcia - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 08:55:00', '2017-04-06 08:40:00', 19, 5, 1, 3, '#880088'),
(383, 'Robert Garcia - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 09:10:00', '2017-04-06 08:55:00', 31, 5, 1, 4, '#880088'),
(384, 'Leroy Vincent - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 09:20:00', '2017-04-06 09:00:00', 1, 9, 1, 1, '#FF8C00'),
(385, 'Leroy Vincent - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 09:20:00', '2017-04-06 09:00:00', 24, 9, 1, 1, '#FF8C00'),
(386, 'Leroy Vincent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:25:00', 32, 9, 1, 2, '#FF8C00'),
(387, 'Leroy Vincent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:25:00', 18, 9, 1, 2, '#FF8C00'),
(388, 'Leroy Vincent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:55:00', '2017-04-06 09:40:00', 36, 9, 1, 3, '#FF8C00'),
(389, 'Leroy Vincent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:55:00', '2017-04-06 09:40:00', 20, 9, 1, 3, '#FF8C00'),
(390, 'Leroy Vincent - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 10:10:00', '2017-04-06 09:55:00', 38, 9, 1, 4, '#FF8C00'),
(391, 'Leroy Vincent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:35:00', '2017-04-06 10:55:00', 33, 9, 1, 6, '#FF8C00'),
(392, 'Leroy Vincent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:35:00', '2017-04-06 10:55:00', 26, 9, 1, 6, '#FF8C00'),
(394, 'Leroy Vincent - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 10:45:00', '2017-04-06 10:15:00', 40, 9, 1, 5, '#FF8C00'),
(395, 'Leroy Vincent - Collation - Obésité sévère – diagnostique', '2017-04-06 10:55:00', '2017-04-06 10:45:00', 33, 9, 1, 31, '#FF8C00'),
(396, 'Leroy Vincent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:10:00', '2017-04-06 11:40:00', 37, 9, 1, 7, '#FF8C00'),
(397, 'Leroy Vincent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:10:00', '2017-04-06 11:40:00', 40, 9, 1, 7, '#FF8C00'),
(398, 'Leroy Vincent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:10:00', '2017-04-06 12:10:00', 8, 9, 1, 8, '#FF8C00'),
(399, 'Leroy Vincent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:10:00', '2017-04-06 12:10:00', 39, 9, 1, 8, '#FF8C00'),
(400, 'Leroy Vincent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:45:00', '2017-04-06 13:15:00', 9, 9, 1, 9, '#FF8C00'),
(401, 'Leroy Vincent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:45:00', '2017-04-06 13:15:00', 40, 9, 1, 9, '#FF8C00'),
(402, 'Robert Garcia - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:10:00', 37, 5, 1, 5, '#880088'),
(403, 'Robert Garcia - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:10:00', 39, 5, 1, 5, '#880088'),
(404, 'Robert Garcia - Collation - Obésité sévère – diagnostique', '2017-04-06 09:50:00', '2017-04-06 09:40:00', 35, 5, 1, 31, '#880088'),
(405, 'Robert Garcia - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 09:50:00', 5, 5, 1, 6, '#880088'),
(406, 'Robert Garcia - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 09:50:00', 25, 5, 1, 6, '#880088'),
(407, 'Robert Garcia - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 11:00:00', '2017-04-06 10:30:00', 1, 5, 1, 7, '#880088'),
(408, 'Robert Garcia - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 11:00:00', '2017-04-06 10:30:00', 39, 5, 1, 7, '#880088'),
(409, 'Robert Garcia - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 12:00:00', '2017-04-06 11:00:00', 7, 5, 1, 8, '#880088'),
(410, 'Robert Garcia - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 12:00:00', '2017-04-06 11:00:00', 23, 5, 1, 8, '#880088'),
(411, 'Robert Garcia - synthèse - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 12:05:00', 35, 5, 1, 9, '#880088'),
(412, 'Robert Garcia - synthèse - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 12:05:00', 24, 5, 1, 9, '#880088'),
(413, 'Dubois Lefebvre - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 14:50:00', '2017-04-06 14:30:00', 1, 3, 1, 1, '#008C90'),
(414, 'Dubois Lefebvre - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 14:50:00', '2017-04-06 14:30:00', 24, 3, 1, 1, '#008C90'),
(415, 'Dubois Lefebvre - ECG - Obésité sévère – diagnostique', '2017-04-06 15:35:00', '2017-04-06 15:20:00', 3, 3, 1, 2, '#008C90'),
(416, 'Dubois Lefebvre - ECG - Obésité sévère – diagnostique', '2017-04-06 15:35:00', '2017-04-06 15:20:00', 17, 3, 1, 2, '#008C90'),
(417, 'Dubois Lefebvre - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 15:15:00', '2017-04-06 15:00:00', 4, 3, 1, 3, '#008C90'),
(418, 'Dubois Lefebvre - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 15:15:00', '2017-04-06 15:00:00', 19, 3, 1, 3, '#008C90'),
(419, 'Dubois Lefebvre - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 16:20:00', '2017-04-06 16:05:00', 31, 3, 1, 4, '#008C90'),
(420, 'Dubois Lefebvre - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 16:05:00', '2017-04-06 15:35:00', 1, 3, 1, 5, '#008C90'),
(421, 'Dubois Lefebvre - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 16:05:00', '2017-04-06 15:35:00', 23, 3, 1, 5, '#008C90'),
(422, 'Dubois Lefebvre - Collation - Obésité sévère – diagnostique', '2017-04-06 16:40:00', '2017-04-06 16:30:00', 5, 3, 1, 31, '#008C90'),
(423, 'Dubois Lefebvre - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 17:55:00', '2017-04-06 17:15:00', 6, 3, 1, 6, '#008C90'),
(424, 'Dubois Lefebvre - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 17:55:00', '2017-04-06 17:15:00', 25, 3, 1, 6, '#008C90'),
(425, 'Dubois Lefebvre - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 17:15:00', '2017-04-06 16:45:00', 1, 3, 1, 7, '#008C90'),
(426, 'Dubois Lefebvre - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 17:15:00', '2017-04-06 16:45:00', 23, 3, 1, 7, '#008C90'),
(427, 'Dubois Lefebvre - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 18:55:00', '2017-04-06 17:55:00', 7, 3, 1, 8, '#008C90'),
(428, 'Dubois Lefebvre - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 18:55:00', '2017-04-06 17:55:00', 24, 3, 1, 8, '#008C90'),
(429, 'Dubois Lefebvre - synthèse - Obésité sévère – diagnostique', '2017-04-06 19:30:00', '2017-04-06 19:00:00', 9, 3, 1, 9, '#008C90'),
(430, 'Dubois Lefebvre - synthèse - Obésité sévère – diagnostique', '2017-04-06 19:30:00', '2017-04-06 19:00:00', 23, 3, 1, 9, '#008C90'),
(434, 'Moreau Fournier - RDV paramédical - Obésité sévère – diagnostique', '2017-03-29 08:20:00', '2017-03-29 08:00:00', 1, 10, 1, 1, '#9800D8'),
(435, 'Moreau Fournier - RDV paramédical - Obésité sévère – diagnostique', '2017-03-29 08:20:00', '2017-03-29 08:00:00', 23, 10, 1, 1, '#9800D8'),
(436, 'Moreau Fournier - ECG - Obésité sévère – diagnostique', '2017-03-29 08:40:00', '2017-03-29 08:25:00', 3, 10, 1, 2, '#9800D8'),
(437, 'Moreau Fournier - ECG - Obésité sévère – diagnostique', '2017-03-29 08:40:00', '2017-03-29 08:25:00', 17, 10, 1, 2, '#9800D8'),
(438, 'Moreau Fournier - Bilan biologique - Obésité sévère – diagnostique', '2017-03-29 08:55:00', '2017-03-29 08:40:00', 4, 10, 1, 3, '#9800D8'),
(439, 'Moreau Fournier - Bilan biologique - Obésité sévère – diagnostique', '2017-03-29 08:55:00', '2017-03-29 08:40:00', 19, 10, 1, 3, '#9800D8'),
(440, 'Moreau Fournier - Echo hépatique - Obésité sévère – diagnostique', '2017-03-29 09:10:00', '2017-03-29 08:55:00', 31, 10, 1, 4, '#9800D8'),
(441, 'Moreau Fournier - Calorimétrie - Obésité sévère – diagnostique', '2017-03-29 09:45:00', '2017-03-29 09:15:00', 1, 10, 1, 5, '#9800D8'),
(442, 'Moreau Fournier - Calorimétrie - Obésité sévère – diagnostique', '2017-03-29 09:45:00', '2017-03-29 09:15:00', 23, 10, 1, 5, '#9800D8'),
(443, 'Moreau Fournier - Collation - Obésité sévère – diagnostique', '2017-03-29 09:55:00', '2017-03-29 09:45:00', 37, 10, 1, 31, '#9800D8'),
(444, 'Moreau Fournier - Entretien psy - Obésité sévère – diagnostique', '2017-03-29 10:40:00', '2017-03-29 10:00:00', 5, 10, 1, 6, '#9800D8'),
(445, 'Moreau Fournier - Entretien psy - Obésité sévère – diagnostique', '2017-03-29 10:40:00', '2017-03-29 10:00:00', 25, 10, 1, 6, '#9800D8'),
(446, 'Moreau Fournier - Entretien infirmier - Obésité sévère – diagnostique', '2017-03-29 11:20:00', '2017-03-29 10:50:00', 1, 10, 1, 7, '#9800D8'),
(447, 'Moreau Fournier - Entretien infirmier - Obésité sévère – diagnostique', '2017-03-29 11:20:00', '2017-03-29 10:50:00', 23, 10, 1, 7, '#9800D8'),
(448, 'Moreau Fournier - Entretien diet - Obésité sévère – diagnostique', '2017-03-29 12:20:00', '2017-03-29 11:20:00', 7, 10, 1, 8, '#9800D8'),
(449, 'Moreau Fournier - Entretien diet - Obésité sévère – diagnostique', '2017-03-29 12:20:00', '2017-03-29 11:20:00', 24, 10, 1, 8, '#9800D8'),
(450, 'Moreau Fournier - synthèse - Obésité sévère – diagnostique', '2017-03-29 12:55:00', '2017-03-29 12:25:00', 9, 10, 1, 9, '#9800D8'),
(451, 'Moreau Fournier - synthèse - Obésité sévère – diagnostique', '2017-03-29 12:55:00', '2017-03-29 12:25:00', 23, 10, 1, 9, '#9800D8'),
(474, 'YANG Jing - ECG - Obésité sévère – diagnostique', '2018-03-16 08:40:00', '2018-03-16 08:25:00', 3, 12, 1, 2, '#90BC90'),
(475, 'YANG Jing - ECG - Obésité sévère – diagnostique', '2018-03-16 08:40:00', '2018-03-16 08:25:00', 17, 12, 1, 2, '#90BC90'),
(478, 'YANG Jing - Scanner abdo - PAR1', '2018-03-26 09:50:00', '2018-03-26 09:30:00', 5, 12, 26, 13, '#90BC90'),
(479, 'YANG Jing - Scanner abdo - PAR1', '2018-03-26 09:50:00', '2018-03-26 09:30:00', 27, 12, 26, 13, '#90BC90');

-- --------------------------------------------------------

--
-- 表的结构 `jour`
--

CREATE TABLE IF NOT EXISTS `jour` (
  `ID_JOUR` bigint(20) NOT NULL,
  `TXT_JOUR` varchar(20) NOT NULL,
  `INT_JOUR_SQL` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_JOUR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `jour`
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
-- 表的结构 `necessiter`
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
-- 转存表中的数据 `necessiter`
--

INSERT INTO `necessiter` (`ID_ACTIVITE`, `ID_TYPERESSOURCE`, `QUANTITE`) VALUES
(1, 1, 1),
(1, 43, 1),
(2, 2, 1),
(2, 40, 1),
(3, 2, 1),
(3, 41, 1),
(4, 42, 1),
(5, 1, 1),
(5, 43, 1),
(6, 3, 1),
(6, 44, 1),
(7, 1, 1),
(7, 43, 1),
(8, 4, 1),
(8, 43, 1),
(9, 5, 1),
(9, 43, 1),
(13, 3, 1),
(13, 45, 1);

-- --------------------------------------------------------

--
-- 表的结构 `onglet`
--

CREATE TABLE IF NOT EXISTS `onglet` (
  `ID_ONGLET` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `ID_ACTIVITE` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ONGLET`),
  KEY `FK_ID` (`ID_ACTIVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `onglet`
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
(25, 'Scanner abdo', 25),
(26, 'Scanner TMD pied + radios', 26),
(27, 'Doppler des artères des MI', 27),
(28, 'Soin, pansement, mesures IPS', 28),
(29, 'RDV médical', 29),
(30, 'Prélèvement', 30),
(31, 'Collation', 31),
(32, 'Synthèse', 32);

-- --------------------------------------------------------

--
-- 表的结构 `ordonnancer`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=480 ;

--
-- 转存表中的数据 `ordonnancer`
--

INSERT INTO `ordonnancer` (`id`, `title`, `end`, `start`, `ressourceId`, `patientId`, `parcoursId`, `activiteId`, `color`) VALUES
(325, 'Martin Simon - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 10:20:00', '2017-04-06 10:00:00', 1, 1, 1, 1, '#FF1490'),
(326, 'Martin Simon - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 10:20:00', '2017-04-06 10:00:00', 23, 1, 1, 1, '#FF1490'),
(329, 'Martin Simon - ECG - Obésité sévère – diagnostique', '2017-04-06 10:40:00', '2017-04-06 10:25:00', 3, 1, 1, 2, '#FF1490'),
(330, 'Martin Simon - ECG - Obésité sévère – diagnostique', '2017-04-06 10:40:00', '2017-04-06 10:25:00', 17, 1, 1, 2, '#FF1490'),
(331, 'Martin Simon - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 11:15:00', '2017-04-06 11:00:00', 4, 1, 1, 3, '#FF1490'),
(332, 'Martin Simon - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 11:15:00', '2017-04-06 11:00:00', 19, 1, 1, 3, '#FF1490'),
(333, 'Martin Simon - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 11:00:00', '2017-04-06 10:45:00', 31, 1, 1, 4, '#FF1490'),
(335, 'Martin Simon - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 11:45:00', '2017-04-06 11:15:00', 39, 1, 1, 5, '#FF1490'),
(336, 'Martin Simon - Collation - Obésité sévère – diagnostique', '2017-04-06 11:55:00', '2017-04-06 11:45:00', 3, 1, 1, 31, '#FF1490'),
(337, 'Martin Simon - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 11:55:00', 5, 1, 1, 6, '#FF1490'),
(338, 'Martin Simon - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 11:55:00', 25, 1, 1, 6, '#FF1490'),
(339, 'Martin Simon - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 14:05:00', '2017-04-06 13:35:00', 1, 1, 1, 7, '#FF1490'),
(340, 'Martin Simon - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 14:05:00', '2017-04-06 13:35:00', 23, 1, 1, 7, '#FF1490'),
(341, 'Martin Simon - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:35:00', '2017-04-06 12:35:00', 7, 1, 1, 8, '#FF1490'),
(342, 'Martin Simon - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:35:00', '2017-04-06 12:35:00', 24, 1, 1, 8, '#FF1490'),
(343, 'Martin Simon - synthèse - Obésité sévère – diagnostique', '2017-04-06 14:45:00', '2017-04-06 14:15:00', 9, 1, 1, 9, '#FF1490'),
(344, 'Martin Simon - synthèse - Obésité sévère – diagnostique', '2017-04-06 14:45:00', '2017-04-06 14:15:00', 23, 1, 1, 9, '#FF1490'),
(346, 'Bernard Laurent - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 09:10:00', '2017-04-06 08:50:00', 23, 2, 1, 1, '#90BC90'),
(347, 'Bernard Laurent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:30:00', '2017-04-06 09:15:00', 3, 2, 1, 2, '#90BC90'),
(348, 'Bernard Laurent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:30:00', '2017-04-06 09:15:00', 17, 2, 1, 2, '#90BC90'),
(349, 'Bernard Laurent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:45:00', '2017-04-06 09:30:00', 4, 2, 1, 3, '#90BC90'),
(350, 'Bernard Laurent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:45:00', '2017-04-06 09:30:00', 19, 2, 1, 3, '#90BC90'),
(351, 'Bernard Laurent - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 10:00:00', '2017-04-06 09:45:00', 31, 2, 1, 4, '#90BC90'),
(352, 'Bernard Laurent - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 10:00:00', 37, 2, 1, 5, '#90BC90'),
(353, 'Bernard Laurent - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 10:00:00', 24, 2, 1, 5, '#90BC90'),
(354, 'Bernard Laurent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:25:00', '2017-04-06 10:45:00', 5, 2, 1, 6, '#90BC90'),
(355, 'Bernard Laurent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:25:00', '2017-04-06 10:45:00', 25, 2, 1, 6, '#90BC90'),
(356, 'Bernard Laurent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:05:00', '2017-04-06 11:35:00', 1, 2, 1, 7, '#90BC90'),
(357, 'Bernard Laurent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:05:00', '2017-04-06 11:35:00', 24, 2, 1, 7, '#90BC90'),
(364, 'Bernard Laurent - Collation - Obésité sévère – diagnostique', '2017-04-06 10:40:00', '2017-04-06 10:30:00', 6, 2, 1, 31, '#90BC90'),
(373, 'Bernard Laurent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:05:00', '2017-04-06 12:05:00', 34, 2, 1, 8, '#90BC90'),
(374, 'Bernard Laurent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:05:00', '2017-04-06 12:05:00', 23, 2, 1, 8, '#90BC90'),
(375, 'Bernard Laurent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:50:00', '2017-04-06 13:20:00', 10, 2, 1, 9, '#90BC90'),
(376, 'Bernard Laurent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:50:00', '2017-04-06 13:20:00', 39, 2, 1, 9, '#90BC90'),
(377, 'Robert Garcia - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 08:20:00', '2017-04-06 08:00:00', 1, 5, 1, 1, '#880088'),
(378, 'Robert Garcia - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 08:20:00', '2017-04-06 08:00:00', 23, 5, 1, 1, '#880088'),
(379, 'Robert Garcia - ECG - Obésité sévère – diagnostique', '2017-04-06 08:40:00', '2017-04-06 08:25:00', 3, 5, 1, 2, '#880088'),
(380, 'Robert Garcia - ECG - Obésité sévère – diagnostique', '2017-04-06 08:40:00', '2017-04-06 08:25:00', 17, 5, 1, 2, '#880088'),
(381, 'Robert Garcia - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 08:55:00', '2017-04-06 08:40:00', 4, 5, 1, 3, '#880088'),
(382, 'Robert Garcia - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 08:55:00', '2017-04-06 08:40:00', 19, 5, 1, 3, '#880088'),
(383, 'Robert Garcia - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 09:10:00', '2017-04-06 08:55:00', 31, 5, 1, 4, '#880088'),
(384, 'Leroy Vincent - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 09:20:00', '2017-04-06 09:00:00', 1, 9, 1, 1, '#FF8C00'),
(385, 'Leroy Vincent - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 09:20:00', '2017-04-06 09:00:00', 24, 9, 1, 1, '#FF8C00'),
(386, 'Leroy Vincent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:25:00', 32, 9, 1, 2, '#FF8C00'),
(387, 'Leroy Vincent - ECG - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:25:00', 18, 9, 1, 2, '#FF8C00'),
(388, 'Leroy Vincent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:55:00', '2017-04-06 09:40:00', 36, 9, 1, 3, '#FF8C00'),
(389, 'Leroy Vincent - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 09:55:00', '2017-04-06 09:40:00', 20, 9, 1, 3, '#FF8C00'),
(390, 'Leroy Vincent - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 10:10:00', '2017-04-06 09:55:00', 38, 9, 1, 4, '#FF8C00'),
(391, 'Leroy Vincent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:35:00', '2017-04-06 10:55:00', 33, 9, 1, 6, '#FF8C00'),
(392, 'Leroy Vincent - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 11:35:00', '2017-04-06 10:55:00', 26, 9, 1, 6, '#FF8C00'),
(394, 'Leroy Vincent - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 10:45:00', '2017-04-06 10:15:00', 40, 9, 1, 5, '#FF8C00'),
(395, 'Leroy Vincent - Collation - Obésité sévère – diagnostique', '2017-04-06 10:55:00', '2017-04-06 10:45:00', 33, 9, 1, 31, '#FF8C00'),
(396, 'Leroy Vincent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:10:00', '2017-04-06 11:40:00', 37, 9, 1, 7, '#FF8C00'),
(397, 'Leroy Vincent - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 12:10:00', '2017-04-06 11:40:00', 40, 9, 1, 7, '#FF8C00'),
(398, 'Leroy Vincent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:10:00', '2017-04-06 12:10:00', 8, 9, 1, 8, '#FF8C00'),
(399, 'Leroy Vincent - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 13:10:00', '2017-04-06 12:10:00', 39, 9, 1, 8, '#FF8C00'),
(400, 'Leroy Vincent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:45:00', '2017-04-06 13:15:00', 9, 9, 1, 9, '#FF8C00'),
(401, 'Leroy Vincent - synthèse - Obésité sévère – diagnostique', '2017-04-06 13:45:00', '2017-04-06 13:15:00', 40, 9, 1, 9, '#FF8C00'),
(402, 'Robert Garcia - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:10:00', 37, 5, 1, 5, '#880088'),
(403, 'Robert Garcia - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 09:40:00', '2017-04-06 09:10:00', 39, 5, 1, 5, '#880088'),
(404, 'Robert Garcia - Collation - Obésité sévère – diagnostique', '2017-04-06 09:50:00', '2017-04-06 09:40:00', 35, 5, 1, 31, '#880088'),
(405, 'Robert Garcia - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 09:50:00', 5, 5, 1, 6, '#880088'),
(406, 'Robert Garcia - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 10:30:00', '2017-04-06 09:50:00', 25, 5, 1, 6, '#880088'),
(407, 'Robert Garcia - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 11:00:00', '2017-04-06 10:30:00', 1, 5, 1, 7, '#880088'),
(408, 'Robert Garcia - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 11:00:00', '2017-04-06 10:30:00', 39, 5, 1, 7, '#880088'),
(409, 'Robert Garcia - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 12:00:00', '2017-04-06 11:00:00', 7, 5, 1, 8, '#880088'),
(410, 'Robert Garcia - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 12:00:00', '2017-04-06 11:00:00', 23, 5, 1, 8, '#880088'),
(411, 'Robert Garcia - synthèse - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 12:05:00', 35, 5, 1, 9, '#880088'),
(412, 'Robert Garcia - synthèse - Obésité sévère – diagnostique', '2017-04-06 12:35:00', '2017-04-06 12:05:00', 24, 5, 1, 9, '#880088'),
(413, 'Dubois Lefebvre - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 14:50:00', '2017-04-06 14:30:00', 1, 3, 1, 1, '#008C90'),
(414, 'Dubois Lefebvre - RDV paramédical - Obésité sévère – diagnostique', '2017-04-06 14:50:00', '2017-04-06 14:30:00', 24, 3, 1, 1, '#008C90'),
(415, 'Dubois Lefebvre - ECG - Obésité sévère – diagnostique', '2017-04-06 15:35:00', '2017-04-06 15:20:00', 3, 3, 1, 2, '#008C90'),
(416, 'Dubois Lefebvre - ECG - Obésité sévère – diagnostique', '2017-04-06 15:35:00', '2017-04-06 15:20:00', 17, 3, 1, 2, '#008C90'),
(417, 'Dubois Lefebvre - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 15:15:00', '2017-04-06 15:00:00', 4, 3, 1, 3, '#008C90'),
(418, 'Dubois Lefebvre - Bilan biologique - Obésité sévère – diagnostique', '2017-04-06 15:15:00', '2017-04-06 15:00:00', 19, 3, 1, 3, '#008C90'),
(419, 'Dubois Lefebvre - Echo hépatique - Obésité sévère – diagnostique', '2017-04-06 16:20:00', '2017-04-06 16:05:00', 31, 3, 1, 4, '#008C90'),
(420, 'Dubois Lefebvre - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 16:05:00', '2017-04-06 15:35:00', 1, 3, 1, 5, '#008C90'),
(421, 'Dubois Lefebvre - Calorimétrie - Obésité sévère – diagnostique', '2017-04-06 16:05:00', '2017-04-06 15:35:00', 23, 3, 1, 5, '#008C90'),
(422, 'Dubois Lefebvre - Collation - Obésité sévère – diagnostique', '2017-04-06 16:40:00', '2017-04-06 16:30:00', 5, 3, 1, 31, '#008C90'),
(423, 'Dubois Lefebvre - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 17:55:00', '2017-04-06 17:15:00', 6, 3, 1, 6, '#008C90'),
(424, 'Dubois Lefebvre - Entretien psy - Obésité sévère – diagnostique', '2017-04-06 17:55:00', '2017-04-06 17:15:00', 25, 3, 1, 6, '#008C90'),
(425, 'Dubois Lefebvre - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 17:15:00', '2017-04-06 16:45:00', 1, 3, 1, 7, '#008C90'),
(426, 'Dubois Lefebvre - Entretien infirmier - Obésité sévère – diagnostique', '2017-04-06 17:15:00', '2017-04-06 16:45:00', 23, 3, 1, 7, '#008C90'),
(427, 'Dubois Lefebvre - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 18:55:00', '2017-04-06 17:55:00', 7, 3, 1, 8, '#008C90'),
(428, 'Dubois Lefebvre - Entretien diet - Obésité sévère – diagnostique', '2017-04-06 18:55:00', '2017-04-06 17:55:00', 24, 3, 1, 8, '#008C90'),
(429, 'Dubois Lefebvre - synthèse - Obésité sévère – diagnostique', '2017-04-06 19:30:00', '2017-04-06 19:00:00', 9, 3, 1, 9, '#008C90'),
(430, 'Dubois Lefebvre - synthèse - Obésité sévère – diagnostique', '2017-04-06 19:30:00', '2017-04-06 19:00:00', 23, 3, 1, 9, '#008C90'),
(434, 'Moreau Fournier - RDV paramédical - Obésité sévère – diagnostique', '2017-03-29 08:20:00', '2017-03-29 08:00:00', 1, 10, 1, 1, '#9800D8'),
(435, 'Moreau Fournier - RDV paramédical - Obésité sévère – diagnostique', '2017-03-29 08:20:00', '2017-03-29 08:00:00', 23, 10, 1, 1, '#9800D8'),
(436, 'Moreau Fournier - ECG - Obésité sévère – diagnostique', '2017-03-29 08:40:00', '2017-03-29 08:25:00', 3, 10, 1, 2, '#9800D8'),
(437, 'Moreau Fournier - ECG - Obésité sévère – diagnostique', '2017-03-29 08:40:00', '2017-03-29 08:25:00', 17, 10, 1, 2, '#9800D8'),
(438, 'Moreau Fournier - Bilan biologique - Obésité sévère – diagnostique', '2017-03-29 08:55:00', '2017-03-29 08:40:00', 4, 10, 1, 3, '#9800D8'),
(439, 'Moreau Fournier - Bilan biologique - Obésité sévère – diagnostique', '2017-03-29 08:55:00', '2017-03-29 08:40:00', 19, 10, 1, 3, '#9800D8'),
(440, 'Moreau Fournier - Echo hépatique - Obésité sévère – diagnostique', '2017-03-29 09:10:00', '2017-03-29 08:55:00', 31, 10, 1, 4, '#9800D8'),
(441, 'Moreau Fournier - Calorimétrie - Obésité sévère – diagnostique', '2017-03-29 09:45:00', '2017-03-29 09:15:00', 1, 10, 1, 5, '#9800D8'),
(442, 'Moreau Fournier - Calorimétrie - Obésité sévère – diagnostique', '2017-03-29 09:45:00', '2017-03-29 09:15:00', 23, 10, 1, 5, '#9800D8'),
(443, 'Moreau Fournier - Collation - Obésité sévère – diagnostique', '2017-03-29 09:55:00', '2017-03-29 09:45:00', 37, 10, 1, 31, '#9800D8'),
(444, 'Moreau Fournier - Entretien psy - Obésité sévère – diagnostique', '2017-03-29 10:40:00', '2017-03-29 10:00:00', 5, 10, 1, 6, '#9800D8'),
(445, 'Moreau Fournier - Entretien psy - Obésité sévère – diagnostique', '2017-03-29 10:40:00', '2017-03-29 10:00:00', 25, 10, 1, 6, '#9800D8'),
(446, 'Moreau Fournier - Entretien infirmier - Obésité sévère – diagnostique', '2017-03-29 11:20:00', '2017-03-29 10:50:00', 1, 10, 1, 7, '#9800D8'),
(447, 'Moreau Fournier - Entretien infirmier - Obésité sévère – diagnostique', '2017-03-29 11:20:00', '2017-03-29 10:50:00', 23, 10, 1, 7, '#9800D8'),
(448, 'Moreau Fournier - Entretien diet - Obésité sévère – diagnostique', '2017-03-29 12:20:00', '2017-03-29 11:20:00', 7, 10, 1, 8, '#9800D8'),
(449, 'Moreau Fournier - Entretien diet - Obésité sévère – diagnostique', '2017-03-29 12:20:00', '2017-03-29 11:20:00', 24, 10, 1, 8, '#9800D8'),
(450, 'Moreau Fournier - synthèse - Obésité sévère – diagnostique', '2017-03-29 12:55:00', '2017-03-29 12:25:00', 9, 10, 1, 9, '#9800D8'),
(451, 'Moreau Fournier - synthèse - Obésité sévère – diagnostique', '2017-03-29 12:55:00', '2017-03-29 12:25:00', 23, 10, 1, 9, '#9800D8'),
(474, 'YANG Jing - ECG - Obésité sévère – diagnostique', '2018-03-16 08:40:00', '2018-03-16 08:25:00', 3, 12, 1, 2, '#90BC90'),
(475, 'YANG Jing - ECG - Obésité sévère – diagnostique', '2018-03-16 08:40:00', '2018-03-16 08:25:00', 17, 12, 1, 2, '#90BC90'),
(478, 'YANG Jing - Scanner abdo - PAR1', '2018-03-26 09:50:00', '2018-03-26 09:30:00', 5, 12, 26, 13, '#90BC90'),
(479, 'YANG Jing - Scanner abdo - PAR1', '2018-03-26 09:50:00', '2018-03-26 09:30:00', 27, 12, 26, 13, '#90BC90');

-- --------------------------------------------------------

--
-- 表的结构 `parcours`
--

CREATE TABLE IF NOT EXISTS `parcours` (
  `ID_PARCOURS` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  `INT_OBJECTIF` int(11) DEFAULT NULL,
  `TXT_CODE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PARCOURS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `parcours`
--

INSERT INTO `parcours` (`ID_PARCOURS`, `TXT_NOM`, `INT_OBJECTIF`, `TXT_CODE`) VALUES
(1, 'Obésité sévère – diagnostique', NULL, ''),
(2, 'Obésité sévère – Post-op', NULL, NULL),
(3, 'Obésité sévère – J+1an', NULL, NULL),
(4, 'Bilan nutritionnel hors obésité sévère', NULL, NULL),
(5, 'Dépistage des maladies du foie', 3, 'P5'),
(6, 'Biothérapies (dont MICI)', 3, 'P6'),
(7, 'Ponction ascite', NULL, NULL),
(8, 'Injection de fer', NULL, NULL),
(9, 'Bilan des complications du diabète', NULL, NULL),
(10, 'Bilan diagnostic étiologique et/ou décompensation d''un diabète avec initiation de la prise en charge', NULL, NULL),
(11, 'Traitement du pied diabétique', NULL, NULL),
(12, 'ETP diabétique', NULL, NULL),
(13, 'HDJ nuit : Diagnostic nuit', NULL, NULL),
(14, 'HDJ Jour Diagnostic jour', NULL, NULL),
(15, 'HDJ jour : Thérapeutique', NULL, NULL),
(16, 'Chimio - Avec OK chimio', NULL, NULL),
(17, 'Chimio - sans OK chimio', NULL, NULL),
(18, 'Cardio – explorations de la maladie coronaire', NULL, NULL),
(19, 'Cardio – insuffisance cardiaque', NULL, NULL),
(20, 'Cardio – onco', NULL, NULL),
(21, 'AIT ', NULL, NULL),
(22, 'Bilan troubles cognitifs', NULL, NULL),
(23, 'Epilepsie', NULL, NULL),
(24, 'Céphalées sub-aigues', NULL, NULL),
(26, 'PAR1', NULL, ''),
(27, 'PAR2', NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `patient`
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
-- 转存表中的数据 `patient`
--

INSERT INTO `patient` (`ID_PATIENT`, `ID_COMPTE`, `TXT_NOM`, `TXT_PRENOM`, `TXT_ADRESSENUM`, `TXT_ADRESSERUE`, `TXT_ADRESSECODEPOSTAL`, `TXT_ADRESSEVILLE`, `TXT_ADRESSEPAYS`, `TXT_MAIL`, `TXT_TELEPHONEFIXE`, `TXT_TELEPHONEPORTABLE`, `TXT_NUMSECU`, `DATE_NAISSANCE`, `ID_PARCOURS_SUP`, `DATE_DISPONIBLE_DEBUT`, `DATE_DISPONIBLE_FIN`) VALUES
(1, 1, 'Martin', 'Simon', '20', 'Saint-Martin', '75000', 'Paris', 'France', 'martin.simon@gmail.com', '245', '0753868034', '2545242', '2003-01-01', 1, '2018-04-28 07:30:00', '2018-04-28 15:55:00'),
(2, 2, 'Bernard', 'Laurent', '15', 'Arbre Sec', '75000', 'Paris', 'France', 'bernard.laurent@gmail.com', '454', '0753868024', '45856', '1990-09-12', 25, '2018-03-31 07:35:00', '2018-03-31 13:15:00'),
(3, 3, 'Dubois', 'Lefebvre', '6', 'Cambon', '75000', 'Paris', 'France', 'dubois.lefebvre@gmail.com', '144', '0753868029', '444', '1983-10-17', 25, '2018-03-31 06:10:00', '2018-03-31 08:45:00'),
(4, 4, 'Thomas', 'Michel', '31', 'Saint Honore', '75000', 'Paris', 'France', 'thomas.michel@gmail.com', '2522525', '0753482620', '25435343', '1972-11-05', 1, '2018-03-31 06:15:00', '2018-03-31 15:30:00'),
(5, 5, 'Robert', 'Garcia', '23', 'Temple', '75000', 'Paris', 'France', 'robert.garcia@gmail.com', '4511513', '0753864952', '3453463', '1984-11-24', 1, '2018-03-31 08:40:00', '2018-03-31 19:20:00'),
(7, 7, 'Petit', 'Bertrand', '7', 'Duphot', '37000', 'Tours', 'France', 'petit.bertrand@hotmail.com', '44', '0658426125', '533443', '1986-08-12', 0, '2018-03-31 06:15:00', '2018-03-31 12:05:00'),
(8, 8, 'Durand', 'Rous', '43', 'delperier', '37000', 'Tours', 'France', 'durand.rous@hotmail.com', '585', '0685469256', '785857887', '1995-05-06', 25, '2018-03-31 07:00:00', '2018-03-31 16:35:00'),
(9, 9, 'Leroy', 'Vincent', '91', 'etranger', '37300', 'Tours', 'France', 'leroy.vincent@gmail.com', '4541212', '0786452156', '543453422', '1983-07-16', 25, '2018-03-31 06:25:00', '2018-03-31 11:00:00'),
(10, 10, 'Moreau', 'Fournier', '23', 'grapiere', '86420', 'Lille', 'France', 'moreau.fournier@soho.com', NULL, '0753168529', '3654545', '1863-08-08', 1, '2018-03-31 06:20:00', '2018-03-31 15:30:00'),
(11, 30, 'pochet', 'guillaume', '53', 'avenue de montjoyeux', '37200', 'Tours', 'France', 'guillaume.pochet@gmail.com', '0636777546', '0636777546', '2545242', '1994-04-06', 1, '2018-03-31 06:20:00', '2018-03-31 17:25:00'),
(12, 58, 'YANG', 'Jing', '31', 'richelieu', '37000', 'TOURS', 'FRANCE', 'yangjingaimer@163.com', '0695212590', '0695212599', '129999', '1990-09-10', 27, '2018-03-21 07:00:00', '2018-03-21 13:40:00'),
(13, 59, 'YANG', 'Jemika', '99', 'ty', '37000', 'TOURS', 'FRANCE', 'yangjingaimer@163.com', '0695212599', '0695212599', '90', '1995-04-07', 25, '2018-03-16 08:55:00', '2018-03-16 15:55:00'),
(14, 60, 'YANG', 'J', '1', 'Q', '37000', 'TOURS', 'FRANCE', 'yangjingaimer@163.com', '0695212599', '0695212599', '1231', '1996-10-10', NULL, NULL, NULL),
(15, 61, 'YANG', 'ying', '12', 'qwe', '37000', 'TOURS', 'FRANCE', 'yangjingaimer@163.com', '0695212599', '0695212599', '132', '1996-10-10', 1, '2018-05-02 06:25:00', '2018-05-02 15:30:00');

-- --------------------------------------------------------

--
-- 表的结构 `personnel`
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
-- 转存表中的数据 `personnel`
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
(33, 33, 23, 'Mélanie', 'Fontaine'),
(34, 34, 24, 'Pierre', 'Marie'),
(35, 35, 25, 'Jacques', 'Simon'),
(36, 36, 26, 'Delo', 'Marie'),
(37, 37, 27, 'Ruit', 'Pauine');

-- --------------------------------------------------------

--
-- 表的结构 `planparcours`
--

CREATE TABLE IF NOT EXISTS `planparcours` (
  `ID_PARCOURS` bigint(20) NOT NULL,
  `ID_JOUR` bigint(20) NOT NULL,
  `INT_NB_PATIENT` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ID_PARCOURS`,`ID_JOUR`),
  KEY `planparcours_ibfk_2` (`ID_JOUR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='le nombre de patient qui exécutent ce parcours à ce jour';

--
-- 转存表中的数据 `planparcours`
--

INSERT INTO `planparcours` (`ID_PARCOURS`, `ID_JOUR`, `INT_NB_PATIENT`) VALUES
(1, 1, 5),
(1, 2, 4),
(1, 3, 6),
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
(12, 1, 10),
(12, 2, 10),
(12, 3, 10),
(12, 4, 10),
(12, 5, 10),
(13, 1, 10),
(13, 2, 10),
(13, 3, 10),
(13, 4, 10),
(13, 5, 10),
(26, 1, 5),
(26, 2, 5),
(26, 3, 5),
(26, 4, 5),
(26, 5, 5),
(27, 1, 5),
(27, 2, 5),
(27, 3, 5),
(27, 4, 5),
(27, 5, 5);

-- --------------------------------------------------------

--
-- 表的结构 `ressource`
--

CREATE TABLE IF NOT EXISTS `ressource` (
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `ID_TYPERESSOURCE` bigint(11) NOT NULL,
  PRIMARY KEY (`ID_RESSOURCE`),
  KEY `I_FK_RESSOURCE_TYPERESSOURCE` (`ID_TYPERESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `ressource`
--

INSERT INTO `ressource` (`ID_RESSOURCE`, `ID_TYPERESSOURCE`) VALUES
(1, 1),
(37, 1),
(3, 2),
(4, 2),
(32, 2),
(36, 2),
(5, 3),
(6, 3),
(33, 3),
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
(17, 40),
(18, 40),
(19, 41),
(20, 41),
(31, 42),
(38, 42),
(23, 43),
(24, 43),
(39, 43),
(40, 43),
(25, 44),
(26, 44),
(27, 45),
(28, 45),
(29, 46),
(30, 46);

-- --------------------------------------------------------

--
-- 表的结构 `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `ID_SALLE` bigint(11) NOT NULL,
  `ID_RESSOURCE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_SALLE`),
  KEY `I_FK_SALLE_RESSOURCE` (`ID_RESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `salle`
--

INSERT INTO `salle` (`ID_SALLE`, `ID_RESSOURCE`, `TXT_NOM`) VALUES
(1, 17, 'Box 1'),
(2, 18, 'Box 2'),
(3, 19, 'Box prélèvement 1'),
(4, 20, 'Box prélèvement 2'),
(5, 23, 'HDJ obésité 1'),
(6, 24, 'HDJ obésité 2'),
(7, 25, 'Bureau CS 1'),
(8, 26, 'Bureau CS 2'),
(9, 27, 'Box soin 1'),
(10, 28, 'Box soin 2'),
(11, 29, 'Salle pansement 1'),
(12, 30, 'Salle pansement 2'),
(13, 31, 'Hors HDJ 1'),
(38, 38, 'Hors HDJ 2'),
(39, 39, 'HDJ obésité 3'),
(40, 40, 'HDJ obésité 4');

-- --------------------------------------------------------

--
-- 表的结构 `typechamp`
--

CREATE TABLE IF NOT EXISTS `typechamp` (
  `ID_TYPECHAMP` bigint(11) NOT NULL,
  `TXT_LIBELLE` varchar(255) DEFAULT NULL,
  `TXT_VALEUR` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`ID_TYPECHAMP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `typechamp`
--

INSERT INTO `typechamp` (`ID_TYPECHAMP`, `TXT_LIBELLE`, `TXT_VALEUR`) VALUES
(1, 'Texte', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <input type="text" class="form-control" id="!!ID!!" value="!!VALEUR!!">\r\n		              </div>\r\n		            </div>'),
(2, 'Date', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <input type="text" class="form-control" id="!!ID!!" value="!!VALEUR!!">\r\n		                <script type="text/javascript">\r\n		                $("body").delegate("#!!ID!!", "focusin", function(){\r\n							   $(this).datepicker();\r\n							});\r\n				        </script>\r\n		              </div>\r\n		            </div>\r\n'),
(3, 'Texte multiligne', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <textarea class="form-control" rows="3"  id="!!ID!!">!!VALEUR!!</textarea>\r\n		              </div>\r\n		            </div>'),
(4, 'Numérique', '<div class="form-group row champ-dossier">\r\n		              <label for="!!ID!!" class="col-md-2 control-label">!!NOM!!</label>\r\n		              <div class="col-md-10">\r\n		                <input type="number" class="form-control" id="!!ID!!" value="!!VALEUR!!">\r\n		              </div>\r\n		            </div>');

-- --------------------------------------------------------

--
-- 表的结构 `typecompte`
--

CREATE TABLE IF NOT EXISTS `typecompte` (
  `ID_TYPECOMPTE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(16) NOT NULL,
  `INT_NIVEAU` int(11) NOT NULL,
  PRIMARY KEY (`ID_TYPECOMPTE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `typecompte`
--

INSERT INTO `typecompte` (`ID_TYPECOMPTE`, `TXT_NOM`, `INT_NIVEAU`) VALUES
(1, 'patient', 1),
(2, 'personnel', 2),
(3, 'coordination', 3),
(4, 'admin', 3);

-- --------------------------------------------------------

--
-- 表的结构 `typeressource`
--

CREATE TABLE IF NOT EXISTS `typeressource` (
  `ID_TYPERESSOURCE` bigint(11) NOT NULL,
  `TXT_NOM` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_TYPERESSOURCE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `typeressource`
--

INSERT INTO `typeressource` (`ID_TYPERESSOURCE`, `TXT_NOM`) VALUES
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
(54, 'f');

--
-- 限制导出的表
--

--
-- 限制表 `champ`
--
ALTER TABLE `champ`
  ADD CONSTRAINT `champ_ibfk_1` FOREIGN KEY (`ID_TYPECHAMP`) REFERENCES `typechamp` (`ID_TYPECHAMP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `composer_ibfk_1` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `composer_ibfk_2` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `composer_ibfk_3` FOREIGN KEY (`ID_ACTIVITE_PRECEDENTE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_ibfk_1` FOREIGN KEY (`ID_TYPECOMPTE`) REFERENCES `typecompte` (`ID_TYPECOMPTE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `constituerdossier`
--
ALTER TABLE `constituerdossier`
  ADD CONSTRAINT `constituerdossier_ibfk_1` FOREIGN KEY (`ID_CHAMP`) REFERENCES `champ` (`ID_CHAMP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constituerdossier_ibfk_2` FOREIGN KEY (`ID_DOSSIERPARCOURS`) REFERENCES `dossierparcours` (`ID_DOSSIERPARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constituerdossier_ibfk_3` FOREIGN KEY (`ID_ONGLET`) REFERENCES `onglet` (`ID_ONGLET`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `dossiergenerique`
--
ALTER TABLE `dossiergenerique`
  ADD CONSTRAINT `dossiergenerique_ibfk_1` FOREIGN KEY (`ID_CHAMP`) REFERENCES `champ` (`ID_CHAMP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiergenerique_ibfk_2` FOREIGN KEY (`ID_ONGLET`) REFERENCES `onglet` (`ID_ONGLET`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiergenerique_ibfk_3` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiergenerique_ibfk_4` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `dossierparcours`
--
ALTER TABLE `dossierparcours`
  ADD CONSTRAINT `dossierparcours_ibfk_1` FOREIGN KEY (`ID_PATIENT`) REFERENCES `patient` (`ID_PATIENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossierparcours_ibfk_2` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `etreindisponible`
--
ALTER TABLE `etreindisponible`
  ADD CONSTRAINT `etreindisponible_ibfk_1` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`ressourceId`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`patientId`) REFERENCES `patient` (`ID_PATIENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_3` FOREIGN KEY (`parcoursId`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evenement_ibfk_4` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `necessiter`
--
ALTER TABLE `necessiter`
  ADD CONSTRAINT `necessiter_ibfk_1` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `necessiter_ibfk_2` FOREIGN KEY (`ID_TYPERESSOURCE`) REFERENCES `typeressource` (`ID_TYPERESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `onglet`
--
ALTER TABLE `onglet`
  ADD CONSTRAINT `FK_ID` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `ordonnancer`
--
ALTER TABLE `ordonnancer`
  ADD CONSTRAINT `ordonnancer_ibfk_1` FOREIGN KEY (`ressourceId`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordonnancer_ibfk_2` FOREIGN KEY (`patientId`) REFERENCES `patient` (`ID_PATIENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordonnancer_ibfk_3` FOREIGN KEY (`parcoursId`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordonnancer_ibfk_4` FOREIGN KEY (`activiteId`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `planparcours`
--
ALTER TABLE `planparcours`
  ADD CONSTRAINT `planparcours_ibfk_1` FOREIGN KEY (`ID_PARCOURS`) REFERENCES `parcours` (`ID_PARCOURS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planparcours_ibfk_2` FOREIGN KEY (`ID_JOUR`) REFERENCES `jour` (`ID_JOUR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`ID_RESSOURCE`) REFERENCES `ressource` (`ID_RESSOURCE`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
