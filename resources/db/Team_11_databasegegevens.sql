-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2018 at 11:40 AM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `team11`
--
CREATE DATABASE IF NOT EXISTS `team11` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `team11`;

-- --------------------------------------------------------

--
-- Table structure for table `afstand`
--

CREATE TABLE IF NOT EXISTS `afstand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `afstand` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `afstand`
--

INSERT INTO `afstand` (`id`, `afstand`) VALUES
(1, '50'),
(2, '100'),
(3, '150'),
(4, '200'),
(5, '250');

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `locatieId` int(10) unsigned NOT NULL,
  `begindatum` date NOT NULL,
  `einddatum` date DEFAULT NULL,
  `beginuur` time NOT NULL,
  `einduur` time DEFAULT NULL,
  `extraInfo` text,
  `evenementTypeId` int(10) unsigned NOT NULL,
  `evenementReeksId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evenementReeksId` (`evenementReeksId`),
  KEY `evenementTypeId` (`evenementTypeId`),
  KEY `locatieId` (`locatieId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `evenement`
--

INSERT INTO `evenement` (`id`, `naam`, `locatieId`, `begindatum`, `einddatum`, `beginuur`, `einduur`, `extraInfo`, `evenementTypeId`, `evenementReeksId`) VALUES
(1, 'evenement1', 1, '2018-09-21', NULL, '09:00:00', '10:00:00', 'extra1', 1, 1),
(2, 'evenement2', 2, '2018-09-28', NULL, '09:00:00', '10:00:00', 'extra2', 1, 1),
(3, 'evenement3', 3, '2019-09-15', NULL, '15:30:00', '16:00:00', 'extra3', 2, NULL),
(4, 'evenement4', 4, '2019-08-21', '2019-08-24', '11:00:00', NULL, 'extra4', 3, NULL),
(5, 'evenement5', 5, '2019-09-21', NULL, '09:00:00', NULL, 'extra5', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evenementdeelname`
--

CREATE TABLE IF NOT EXISTS `evenementdeelname` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persoonId` int(10) unsigned NOT NULL,
  `evenementId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `persoonId` (`persoonId`),
  KEY `evenementId` (`evenementId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `evenementdeelname`
--

INSERT INTO `evenementdeelname` (`id`, `persoonId`, `evenementId`) VALUES
(1, 3, 1),
(2, 4, 2),
(3, 5, 3),
(4, 3, 4),
(5, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `evenementreeks`
--

CREATE TABLE IF NOT EXISTS `evenementreeks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `evenementreeks`
--

INSERT INTO `evenementreeks` (`id`, `naam`) VALUES
(1, 'reeks1'),
(2, 'reeks2'),
(3, 'reeks3'),
(4, 'reeks4'),
(5, 'reeks5');

-- --------------------------------------------------------

--
-- Table structure for table `evenementtype`
--

CREATE TABLE IF NOT EXISTS `evenementtype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `evenementtype`
--

INSERT INTO `evenementtype` (`id`, `type`) VALUES
(1, 'training'),
(2, 'medische test'),
(3, 'stage'),
(4, 'overige');

-- --------------------------------------------------------

--
-- Table structure for table `homepagina`
--

CREATE TABLE IF NOT EXISTS `homepagina` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groepsfoto` varchar(250) NOT NULL,
  `informatie` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `homepagina`
--

INSERT INTO `homepagina` (`id`, `groepsfoto`, `informatie`) VALUES
(1, 'foto.jpg', 'deze week trainen we voor de olympische spelen');

-- --------------------------------------------------------

--
-- Table structure for table `inname`
--

CREATE TABLE IF NOT EXISTS `inname` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persoonId` int(10) unsigned NOT NULL,
  `voedingssupplementId` int(11) unsigned NOT NULL,
  `aantal` varchar(10) NOT NULL,
  `datum` date NOT NULL,
  `innameReeksId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `persoonId` (`persoonId`),
  KEY `innameReeksId` (`innameReeksId`),
  KEY `voedingssupplementId` (`voedingssupplementId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `inname`
--

INSERT INTO `inname` (`id`, `persoonId`, `voedingssupplementId`, `aantal`, `datum`, `innameReeksId`) VALUES
(1, 3, 1, '1', '2018-08-21', 1),
(2, 4, 2, '2', '2018-09-21', 2),
(3, 5, 3, '3', '2018-10-21', 3),
(4, 3, 4, '4', '2018-11-21', 4),
(5, 4, 5, '5', '2018-12-21', 5);

-- --------------------------------------------------------

--
-- Table structure for table `innamereeks`
--

CREATE TABLE IF NOT EXISTS `innamereeks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reeks` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `innamereeks`
--

INSERT INTO `innamereeks` (`id`, `reeks`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `locatie`
--

CREATE TABLE IF NOT EXISTS `locatie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `straat` varchar(200) DEFAULT NULL,
  `nr` varchar(30) DEFAULT NULL,
  `postcode` varchar(4) DEFAULT NULL,
  `gemeente` varchar(100) DEFAULT NULL,
  `land` varchar(100) DEFAULT NULL,
  `zaal` varchar(100) DEFAULT NULL,
  `extraInfo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `locatie`
--

INSERT INTO `locatie` (`id`, `naam`, `straat`, `nr`, `postcode`, `gemeente`, `land`, `zaal`, `extraInfo`) VALUES
(1, 'olympisch zwemcentrum wezenberg', 'desquinlei', '17', '2018', 'antwerpen', 'belgië', 'zwembad', 'extra1'),
(2, 'axion geel', 'zwaarvoerdersspoor', '4', '2440', 'geel', 'belgië', 'grote sporthal', 'extra2'),
(3, 'zwembad westerlo', 'kasteelpark', '6', '2260', 'westerlo', 'belgië', 'trainingszaal', 'extra3'),
(4, 'atletiekcentrum den haag', 'atletiekstraat', '27', '1623', 'den haag', 'Nederland', 'atletiekpiste', 'extra4'),
(5, 'sportcomplex lille', 'rue du sport', '37', '9854', 'lille', 'frankrijk', 'kleine sporthal', 'extra5');

-- --------------------------------------------------------

--
-- Table structure for table `melding`
--

CREATE TABLE IF NOT EXISTS `melding` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persoonId` int(10) unsigned NOT NULL,
  `titel` varchar(250) NOT NULL,
  `boodschap` text NOT NULL,
  `momentVerzonden` datetime NOT NULL,
  `gelezen` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `persoonId` (`persoonId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `melding`
--

INSERT INTO `melding` (`id`, `persoonId`, `titel`, `boodschap`, `momentVerzonden`, `gelezen`) VALUES
(1, 3, 'inschrijving goedgekeurd', 'Je inschrijving voor wedstrijd x, reeks y, is goedgekeurd', '2018-10-21 00:00:00', 0),
(2, 4, 'Nieuwe training', 'Er is een nieuwe training aan je schema toegevoegd', '2018-09-25 00:00:00', 0),
(3, 5, 'Nieuwe inname', 'Er is een nieuwe inname aan je schema toegevoegd', '2018-08-21 00:00:00', 1),
(4, 3, 'Nieuwe wedstrijd', 'Er is een nieuwe wedstrijd beschikbaar', '2018-07-21 00:00:00', 1),
(5, 4, 'Nieuwe medische test', 'Er is een nieuwe medische test aan je schema toegevoegd', '2018-09-17 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nieuwsitem`
--

CREATE TABLE IF NOT EXISTS `nieuwsitem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tekst` text NOT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `titel` varchar(250) NOT NULL,
  `actief` tinyint(1) unsigned NOT NULL,
  `datum` datetime NOT NULL,
  `homepaginaId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `homepaginaId` (`homepaginaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `nieuwsitem`
--

INSERT INTO `nieuwsitem` (`id`, `tekst`, `foto`, `titel`, `actief`, `datum`, `homepaginaId`) VALUES
(1, 'tekst1', 'foto1.jpg', 'titel1', 1, '2018-07-21 00:00:00', 1),
(2, 'tekst2', 'foto2.jpg', 'titel2', 0, '2018-08-21 00:00:00', 1),
(3, 'tekst3', 'foto3.jpg', 'titel3', 0, '2018-09-21 00:00:00', 1),
(4, 'tekst4', 'foto4.jpg', 'titel4', 1, '2018-10-21 00:00:00', 1),
(5, 'tekst5', 'foto5.jpg', 'titel5', 1, '2018-11-21 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `persoon`
--

CREATE TABLE IF NOT EXISTS `persoon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typePersoonId` int(10) unsigned NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `familienaam` varchar(100) NOT NULL,
  `geboortedatum` date DEFAULT NULL,
  `straat` varchar(255) DEFAULT NULL,
  `nummer` varchar(10) DEFAULT NULL,
  `postcode` varchar(4) DEFAULT NULL,
  `woonplaats` varchar(150) DEFAULT NULL,
  `mailadres` varchar(250) NOT NULL,
  `gsmnummer` varchar(15) DEFAULT NULL,
  `biografie` text,
  `foto` varchar(250) DEFAULT NULL,
  `gebruikersnaam` varchar(150) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `actief` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `typePersoonId` (`typePersoonId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `persoon`
--

INSERT INTO `persoon` (`id`, `typePersoonId`, `voornaam`, `familienaam`, `geboortedatum`, `straat`, `nummer`, `postcode`, `woonplaats`, `mailadres`, `gsmnummer`, `biografie`, `foto`, `gebruikersnaam`, `wachtwoord`, `actief`) VALUES
(1, 1, 'rik', 'valcke', '1970-01-01', 'kleinhoefstraat', '4', '2240', 'geel', 'projectwezenberg@gmail.com', '04999999', 'Hoofdrainer van het Belgisch zwemteam', 'rik.jpg', 'rik', '$2y$10$CG0vHHvpK7xOUx5BdTv6Zeh5Q2SgJFB6bTm3bW7DvydUq0xW3A2O.', 1),
(2, 1, 'wauter', 'derycke', '1975-01-01', 'kleinhoefstraat', '4', '2240', 'geel', 'projectwezenberg@gmail.com', '04999999', 'Hulptrainer van het Belgisch zwemteam', 'wauter.jpg', 'wauter', '$2y$10$wG5.IWakmoXogky1gPQPoex3WgI1wUY05NhKCjgsb/5BL88qA1blG', 1),
(3, 2, 'louis', 'croenen', '1994-01-04', 'kleinhoefstraat', '4', '2240', 'geel', 'projectwezenberg@gmail.com', '04999999', 'Na een korte carrière als voetballer legde Louis Croenen zich volledig toe op het zwemmen. Op 18-jarige leeftijd beleefde hij zijn olympisch debuut op de Spelen in Londen. Samen met Dieter Dekoninck, Glenn Surgeloose en Pieter Timmers verbeterde hij er het Belgisch record op de 4x200m vrije slag. In 2015 was Louis Croenen de eerste Belg sinds Fred Deburghgraeve (1998) die de finale van een individueel nummer bereikte op een WK. Op de Olympische Spelen in Rio in 2016 zwom hij in 3 finales! Zo werd hij 8e op de 200m vlinderslag en met het aflossingsteam werd hij knap 6e op de 4x100m in een nieuw BR en 8e op de 4x200m vrije slag.', 'louiscroenen.jpg', 'louis', '$2y$10$.sqby6qhLqFR9glH7gEApOy6T0cxnYNN9zAdAZwwFUgituJLN/1G6', 1),
(4, 2, 'basten', 'caerts', '1997-10-27', 'kleinhoefstraat', '4', '2240', 'geel', 'projectwezenberg@gmail.com', '04999999', 'Basten Caerts is een jonge schoolslagzwemmer. In 2016 snoepte hij nog het Belgisch record op de 50m schoolslag af van niemand minder dan Frederik Deburghgraeve. Ook het BR op de 200m staat op zijn naam. Met deelnames aan de Europese Spelen in Baku (2015), de Jeugd Olympische Spelen in Nanjing (2014) en het Europees Jeugd Olympisch Festival in Utrecht (2013) en kan Basten Caerts al aardig wat olympische ervaring voorleggen. In 2016 mocht hij deelnemen aan zijn eesrte Olympische Spelen in Rio!', 'bastencaerts.jpg', 'basten', '$2y$10$gYWGIl7N5OJ1K6.ilATO9.EifxWi/g7DhBJJ86LJM2RFqwbyYA3ci', 1),
(5, 2, 'sjobbe', 'luyten', '1998-09-08', 'kleinhoefstraat', '4', '2240', 'geel', 'projectwezenberg@gmail.com', '04999999', 'Sjobbe is een jonge Belgische zwemmer.', 'sjobbeluyten.jpg', 'sjobbe', '$2y$10$MwBNJfL5JdmIfHibKyQJ4upczrdObNHTgAzVozYTQjOmO34pmzFoK', 1);

-- --------------------------------------------------------

--
-- Table structure for table `resultaat`
--

CREATE TABLE IF NOT EXISTS `resultaat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rondeTypeId` int(10) unsigned NOT NULL,
  `tijd` time NOT NULL,
  `ranking` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rondeTypeId` (`rondeTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `resultaat`
--

INSERT INTO `resultaat` (`id`, `rondeTypeId`, `tijd`, `ranking`) VALUES
(1, 1, '00:02:15', 1),
(2, 2, '00:03:25', 2),
(3, 3, '00:04:15', 3),
(4, 4, '00:02:25', 4),
(5, 1, '00:03:07', 5);

-- --------------------------------------------------------

--
-- Table structure for table `rondetype`
--

CREATE TABLE IF NOT EXISTS `rondetype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `rondetype`
--

INSERT INTO `rondetype` (`id`, `type`) VALUES
(1, 'voorronde'),
(2, 'kwartfinale'),
(3, 'halve finale'),
(4, 'finale');

-- --------------------------------------------------------

--
-- Table structure for table `slag`
--

CREATE TABLE IF NOT EXISTS `slag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `slag`
--

INSERT INTO `slag` (`id`, `naam`) VALUES
(1, 'crawl'),
(2, 'schoolslag'),
(3, 'vlinderslag'),
(4, 'rugslag'),
(5, 'vrije slag');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'in afwachting'),
(2, 'goedgekeurd'),
(3, 'afgewezen');

-- --------------------------------------------------------

--
-- Table structure for table `supplementdoelstelling`
--

CREATE TABLE IF NOT EXISTS `supplementdoelstelling` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doelstelling` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `supplementdoelstelling`
--

INSERT INTO `supplementdoelstelling` (`id`, `doelstelling`) VALUES
(1, 'spiermassa vergroten'),
(2, 'uithoudingsvermogen verbeteren'),
(3, 'spieren ontspannen'),
(4, 'stofwisseling versnellen'),
(5, 'metabolisme versnellen');

-- --------------------------------------------------------

--
-- Table structure for table `typepersoon`
--

CREATE TABLE IF NOT EXISTS `typepersoon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typePersoon` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `typepersoon`
--

INSERT INTO `typepersoon` (`id`, `typePersoon`) VALUES
(1, 'trainer'),
(2, 'zwemmer');

-- --------------------------------------------------------

--
-- Table structure for table `voedingssupplement`
--

CREATE TABLE IF NOT EXISTS `voedingssupplement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `doelstellingId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `doelstellingId` (`doelstellingId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `voedingssupplement`
--

INSERT INTO `voedingssupplement` (`id`, `naam`, `doelstellingId`) VALUES
(1, 'supplement1', 1),
(2, 'supplement2', 2),
(3, 'supplement3', 3),
(4, 'supplement4', 4),
(5, 'supplement5', 5);

-- --------------------------------------------------------

--
-- Table structure for table `wedstrijd`
--

CREATE TABLE IF NOT EXISTS `wedstrijd` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naam` varchar(150) NOT NULL,
  `locatieId` int(10) unsigned NOT NULL,
  `begindatum` date NOT NULL,
  `einddatum` date DEFAULT NULL,
  `extraInfo` text,
  PRIMARY KEY (`id`),
  KEY `locatieId` (`locatieId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wedstrijd`
--

INSERT INTO `wedstrijd` (`id`, `naam`, `locatieId`, `begindatum`, `einddatum`, `extraInfo`) VALUES
(1, 'olympische spelen', 1, '2018-09-21', '2018-11-21', 'extra1'),
(2, 'WK', 2, '2017-07-21', '2017-08-21', 'extra2'),
(3, 'BK', 3, '2018-02-18', '2017-02-30', 'extra3'),
(4, 'wedstrijd4', 4, '2019-09-21', NULL, 'extra4'),
(5, 'wedstrijd5', 5, '2019-08-21', NULL, 'extra5');

-- --------------------------------------------------------

--
-- Table structure for table `wedstrijddeelname`
--

CREATE TABLE IF NOT EXISTS `wedstrijddeelname` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `persoonId` int(10) unsigned NOT NULL,
  `wedstrijdReeksId` int(10) unsigned NOT NULL,
  `resultaatId` int(10) unsigned DEFAULT NULL,
  `statusId` int(10) unsigned NOT NULL,
  `ranking` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `persoonId` (`persoonId`),
  KEY `wedstrijdReeksId` (`wedstrijdReeksId`),
  KEY `resultaatId` (`resultaatId`),
  KEY `statusId` (`statusId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wedstrijddeelname`
--

INSERT INTO `wedstrijddeelname` (`id`, `persoonId`, `wedstrijdReeksId`, `resultaatId`, `statusId`, `ranking`) VALUES
(1, 3, 1, 1, 2, 1),
(2, 4, 2, 2, 2, 2),
(3, 5, 3, 3, 2, 3),
(4, 4, 4, 4, 1, NULL),
(5, 5, 5, 5, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wedstrijdreeks`
--

CREATE TABLE IF NOT EXISTS `wedstrijdreeks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wedstrijdId` int(11) unsigned NOT NULL,
  `datum` date NOT NULL,
  `beginuur` time NOT NULL,
  `einduur` time DEFAULT NULL,
  `slagId` int(10) unsigned NOT NULL,
  `afstandId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wedstrijdId` (`wedstrijdId`),
  KEY `slagId` (`slagId`,`afstandId`),
  KEY `afstandId` (`afstandId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wedstrijdreeks`
--

INSERT INTO `wedstrijdreeks` (`id`, `wedstrijdId`, `datum`, `beginuur`, `einduur`, `slagId`, `afstandId`) VALUES
(1, 1, '2018-09-21', '13:30:00', '13:45:00', 1, 1),
(2, 2, '2018-10-21', '13:15:00', '13:30:00', 2, 2),
(3, 3, '2018-09-16', '14:30:00', NULL, 3, 3),
(4, 4, '2018-08-21', '14:15:00', NULL, 4, 4),
(5, 5, '2018-11-21', '13:45:00', '14:00:00', 5, 5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`evenementReeksId`) REFERENCES `evenementreeks` (`id`),
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`evenementTypeId`) REFERENCES `evenementtype` (`id`),
  ADD CONSTRAINT `evenement_ibfk_3` FOREIGN KEY (`locatieId`) REFERENCES `locatie` (`id`);

--
-- Constraints for table `evenementdeelname`
--
ALTER TABLE `evenementdeelname`
  ADD CONSTRAINT `evenementdeelname_ibfk_1` FOREIGN KEY (`evenementId`) REFERENCES `evenement` (`id`),
  ADD CONSTRAINT `evenementdeelname_ibfk_2` FOREIGN KEY (`persoonId`) REFERENCES `persoon` (`id`);

--
-- Constraints for table `inname`
--
ALTER TABLE `inname`
  ADD CONSTRAINT `inname_ibfk_1` FOREIGN KEY (`persoonId`) REFERENCES `persoon` (`id`),
  ADD CONSTRAINT `inname_ibfk_2` FOREIGN KEY (`innameReeksId`) REFERENCES `innamereeks` (`id`),
  ADD CONSTRAINT `inname_ibfk_3` FOREIGN KEY (`voedingssupplementId`) REFERENCES `voedingssupplement` (`id`);

--
-- Constraints for table `melding`
--
ALTER TABLE `melding`
  ADD CONSTRAINT `melding_ibfk_1` FOREIGN KEY (`persoonId`) REFERENCES `persoon` (`id`);

--
-- Constraints for table `nieuwsitem`
--
ALTER TABLE `nieuwsitem`
  ADD CONSTRAINT `nieuwsitem_ibfk_1` FOREIGN KEY (`homepaginaId`) REFERENCES `homepagina` (`id`);

--
-- Constraints for table `persoon`
--
ALTER TABLE `persoon`
  ADD CONSTRAINT `typePersoonFK` FOREIGN KEY (`typePersoonId`) REFERENCES `typepersoon` (`id`);

--
-- Constraints for table `resultaat`
--
ALTER TABLE `resultaat`
  ADD CONSTRAINT `resultaat_ibfk_1` FOREIGN KEY (`rondeTypeId`) REFERENCES `rondetype` (`id`);

--
-- Constraints for table `voedingssupplement`
--
ALTER TABLE `voedingssupplement`
  ADD CONSTRAINT `voedingssupplement_ibfk_1` FOREIGN KEY (`doelstellingId`) REFERENCES `supplementdoelstelling` (`id`);

--
-- Constraints for table `wedstrijd`
--
ALTER TABLE `wedstrijd`
  ADD CONSTRAINT `wedstrijd_ibfk_1` FOREIGN KEY (`locatieId`) REFERENCES `locatie` (`id`);

--
-- Constraints for table `wedstrijddeelname`
--
ALTER TABLE `wedstrijddeelname`
  ADD CONSTRAINT `wedstrijddeelname_ibfk_1` FOREIGN KEY (`persoonId`) REFERENCES `persoon` (`id`),
  ADD CONSTRAINT `wedstrijddeelname_ibfk_2` FOREIGN KEY (`resultaatId`) REFERENCES `resultaat` (`id`),
  ADD CONSTRAINT `wedstrijddeelname_ibfk_3` FOREIGN KEY (`statusId`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `wedstrijddeelname_ibfk_4` FOREIGN KEY (`wedstrijdReeksId`) REFERENCES `wedstrijdreeks` (`id`);

--
-- Constraints for table `wedstrijdreeks`
--
ALTER TABLE `wedstrijdreeks`
  ADD CONSTRAINT `wedstrijdreeks_ibfk_1` FOREIGN KEY (`wedstrijdId`) REFERENCES `wedstrijd` (`id`),
  ADD CONSTRAINT `wedstrijdreeks_ibfk_2` FOREIGN KEY (`slagId`) REFERENCES `slag` (`id`),
  ADD CONSTRAINT `wedstrijdreeks_ibfk_3` FOREIGN KEY (`afstandId`) REFERENCES `afstand` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
