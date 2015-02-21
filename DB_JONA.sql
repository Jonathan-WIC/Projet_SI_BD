-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 21 Février 2015 à 18:46
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `db_monster_park`
--
CREATE DATABASE IF NOT EXISTS `db_monster_park` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_monster_park`;

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `ID_ACCOUNT` int(10) NOT NULL AUTO_INCREMENT,
  `PSEUDO` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(20) DEFAULT NULL,
  `IP` varchar(15) DEFAULT NULL,
  `DATE_INSCRIPTION` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_ACCOUNT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`ID_ACCOUNT`, `PSEUDO`, `EMAIL`, `PASSWORD`, `IP`, `DATE_INSCRIPTION`) VALUES
(1, 'titit', 'chevals@poney.unicorn', 'oui', 'non', '2015-01-01 04:24:07');

-- --------------------------------------------------------

--
-- Structure de la table `assoc_monster_element`
--

CREATE TABLE IF NOT EXISTS `assoc_monster_element` (
  `ID_ELEMENT` int(10) NOT NULL AUTO_INCREMENT,
  `ID_MONSTER` int(10) NOT NULL,
  PRIMARY KEY (`ID_ELEMENT`,`ID_MONSTER`),
  KEY `FK_ASSOC_MONSTER_ELEMENT_ID_MONSTER` (`ID_MONSTER`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `assoc_monster_element`
--

INSERT INTO `assoc_monster_element` (`ID_ELEMENT`, `ID_MONSTER`) VALUES
(2, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `assoc_player_account`
--

CREATE TABLE IF NOT EXISTS `assoc_player_account` (
  `ID_PLAYER` int(10) NOT NULL AUTO_INCREMENT,
  `ID_ACCOUNT` int(10) NOT NULL,
  `DATE_CONNEXION` datetime DEFAULT NULL,
  PRIMARY KEY (`ID_PLAYER`,`ID_ACCOUNT`),
  KEY `FK_ASSOC_PLAYER_ACCOUNT_ID_ACCOUNT` (`ID_ACCOUNT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `assoc_player_account`
--

INSERT INTO `assoc_player_account` (`ID_PLAYER`, `ID_ACCOUNT`, `DATE_CONNEXION`) VALUES
(1, 1, '2015-02-02 19:10:02');

-- --------------------------------------------------------

--
-- Structure de la table `assoc_player_enclosure`
--

CREATE TABLE IF NOT EXISTS `assoc_player_enclosure` (
  `ID_ENCLOSURE` int(10) NOT NULL AUTO_INCREMENT,
  `ID_PLAYER` int(10) NOT NULL,
  PRIMARY KEY (`ID_ENCLOSURE`,`ID_PLAYER`),
  KEY `FK_ASSOC_PLAYER_ENCLOSURE_ID_JOUEUR` (`ID_PLAYER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `assoc_player_quest`
--

CREATE TABLE IF NOT EXISTS `assoc_player_quest` (
  `ID_QUEST` int(10) NOT NULL AUTO_INCREMENT,
  `ID_PLAYER` int(10) NOT NULL,
  `ASSOC_PLAYER_QUEST_COST` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_QUEST`,`ID_PLAYER`),
  KEY `FK_ASSOC_PLAYER_QUEST_ID_JOUEUR` (`ID_PLAYER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `element`
--

CREATE TABLE IF NOT EXISTS `element` (
  `ID_ELEMENT` int(10) NOT NULL AUTO_INCREMENT,
  `LIB_ELEMENT` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_ELEMENT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `element`
--

INSERT INTO `element` (`ID_ELEMENT`, `LIB_ELEMENT`) VALUES
(1, 'FIRE'),
(2, 'WATER'),
(3, 'THUNDER'),
(4, 'ICE'),
(5, 'WIND'),
(6, 'DRAGON');

-- --------------------------------------------------------

--
-- Structure de la table `enclosure`
--

CREATE TABLE IF NOT EXISTS `enclosure` (
  `ID_ENCLOSURE` int(10) NOT NULL AUTO_INCREMENT,
  `TYPE_ENCLOS` enum('BASIC','AVIARY','AQUARIUM') DEFAULT NULL,
  `CAPACITY_MONSTER` int(10) DEFAULT NULL,
  `PRICE` int(10) DEFAULT NULL,
  `CLIMATE` enum('FOREST','VOLCANIC','ARID','TROPICAL','CAVERNOUS','MOUNTAINOUS','ARCTIC','ISLAND','OCEANIC') DEFAULT NULL,
  `ID_SUB_SPECIE` int(10) DEFAULT NULL,
  `ID_PARK` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_ENCLOSURE`),
  KEY `FK_ENCLOSURE_ID_SUB_SPECIE` (`ID_SUB_SPECIE`),
  KEY `FK_ENCLOSURE_ID_PARK` (`ID_PARK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `ID_ITEM` int(10) NOT NULL AUTO_INCREMENT,
  `TYPE_ITEM` enum('ENTRETIEN','FOOD','WEAPON','ARMOR') DEFAULT NULL,
  `LIB_ITEM` varchar(20) DEFAULT NULL,
  `PRIX_ITEM` int(10) DEFAULT NULL,
  `FAMILY_ITEM` enum('CONSUMABLE','EQUIPMENT') DEFAULT NULL,
  `ID_PLAYER` int(10) NOT NULL,
  `ID_QUEST` int(10) NOT NULL,
  PRIMARY KEY (`ID_ITEM`),
  KEY `FK_ITEM_ID_JOUEUR` (`ID_PLAYER`),
  KEY `FK_ITEM_ID_QUEST` (`ID_QUEST`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `maturity`
--

CREATE TABLE IF NOT EXISTS `maturity` (
  `ID_MATURITY` int(10) NOT NULL AUTO_INCREMENT,
  `MATURITY_LEVEL` int(5) DEFAULT NULL,
  `LIB_MATURITY` varchar(20) DEFAULT NULL,
  `TIME_REQUIRE` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_MATURITY`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `maturity`
--

INSERT INTO `maturity` (`ID_MATURITY`, `MATURITY_LEVEL`, `LIB_MATURITY`, `TIME_REQUIRE`) VALUES
(1, 1, 'EGG', 10),
(2, 7, 'ADULT', 72);

-- --------------------------------------------------------

--
-- Structure de la table `monster`
--

CREATE TABLE IF NOT EXISTS `monster` (
  `ID_MONSTER` int(10) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(20) DEFAULT NULL,
  `GENDER` enum('F','M') DEFAULT NULL,
  `AGE` int(5) DEFAULT NULL,
  `WEIGHT` int(5) DEFAULT NULL,
  `DANGER_SCALE` enum('INOFFENSIVE','AGGRESSIVE','DANGEROUS','MORTAL') DEFAULT NULL,
  `HEALTH_STATE` int(10) DEFAULT NULL,
  `HUNGER_STATE` int(10) DEFAULT NULL,
  `CLEAN_SCALE` int(10) DEFAULT NULL,
  `REGIME` enum('HERBIVORE','FRUITARIAN','PESCETARIAN','OMNIVOROUS','CARNIVORE') DEFAULT NULL,
  `ID_ENCLOSURE` int(10) DEFAULT NULL,
  `ID_MATURITY` int(10) DEFAULT NULL,
  `ID_PLAYER` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_MONSTER`),
  KEY `FK_MONSTER_ID_ENCLOSURE` (`ID_ENCLOSURE`),
  KEY `FK_MONSTER_ID_MATURITY` (`ID_MATURITY`),
  KEY `FK_MONSTER_ID_JOUEUR` (`ID_PLAYER`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `monster`
--

INSERT INTO `monster` (`ID_MONSTER`, `NAME`, `GENDER`, `AGE`, `WEIGHT`, `DANGER_SCALE`, `HEALTH_STATE`, `HUNGER_STATE`, `CLEAN_SCALE`, `REGIME`, `ID_ENCLOSURE`, `ID_MATURITY`, `ID_PLAYER`) VALUES
(1, 'Cathy', 'F', 20, 47, 'MORTAL', 100, 100, 100, 'CARNIVORE', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `ID_NEWS` int(10) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(20) DEFAULT NULL,
  `PICTURE` varchar(20) DEFAULT NULL,
  `CONTENT` varchar(200) DEFAULT NULL,
  `ID_NEWSPAPER` int(10) NOT NULL,
  PRIMARY KEY (`ID_NEWS`),
  KEY `FK_NEWS_ID_NEWSPAPER` (`ID_NEWSPAPER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `newspaper`
--

CREATE TABLE IF NOT EXISTS `newspaper` (
  `ID_NEWSPAPER` int(10) NOT NULL AUTO_INCREMENT,
  `PUBLICATION` date DEFAULT NULL,
  PRIMARY KEY (`ID_NEWSPAPER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `park`
--

CREATE TABLE IF NOT EXISTS `park` (
  `ID_PARK` int(10) NOT NULL AUTO_INCREMENT,
  `NAME_PARK` varchar(20) DEFAULT NULL,
  `CAPACITY_ENCLOSURE` int(10) DEFAULT NULL,
  `ID_PLAYER` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_PARK`),
  KEY `FK_PARK_ID_JOUEUR` (`ID_PLAYER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `ID_PLAYER` int(10) NOT NULL AUTO_INCREMENT,
  `FIRST_NAME` varchar(20) DEFAULT NULL,
  `LAST_NAME` varchar(20) DEFAULT NULL,
  `GENDER` enum('F','M') DEFAULT NULL,
  `BIRTH_DATE` date DEFAULT NULL,
  `PHONE_NUMBER` varchar(10) DEFAULT NULL,
  `DESCRIPTION` longtext,
  `WEBSITE` varchar(200) DEFAULT NULL,
  `ITEM_CAPACITY` int(10) DEFAULT NULL,
  `MONEY` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_PLAYER`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `player`
--

INSERT INTO `player` (`ID_PLAYER`, `FIRST_NAME`, `LAST_NAME`, `GENDER`, `BIRTH_DATE`, `PHONE_NUMBER`, `DESCRIPTION`, `WEBSITE`, `ITEM_CAPACITY`, `MONEY`) VALUES
(1, 'Cathy', 'Farrahi', 'F', '1994-06-22', '0123456789', 'Ma petite chérie d''amour!!!!! <3<3<3<3<<3', NULL, NULL, 1000000);

-- --------------------------------------------------------

--
-- Structure de la table `ptransaction`
--

CREATE TABLE IF NOT EXISTS `ptransaction` (
  `ID_PTRANSACTION` int(10) NOT NULL AUTO_INCREMENT,
  `AMOUNT` int(10) DEFAULT NULL,
  `PTRANSACTION_DATE` datetime DEFAULT NULL,
  `ID_PLAYER` int(10) NOT NULL,
  PRIMARY KEY (`ID_PTRANSACTION`),
  KEY `FK_PTRANSACTION_ID_JOUEUR` (`ID_PLAYER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `quest`
--

CREATE TABLE IF NOT EXISTS `quest` (
  `ID_QUEST` int(10) NOT NULL AUTO_INCREMENT,
  `FEE` float DEFAULT NULL,
  `DATE_DEB` date DEFAULT NULL,
  `DURATION` int(5) DEFAULT NULL,
  `IS_COMPLETED` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID_QUEST`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `specie`
--

CREATE TABLE IF NOT EXISTS `specie` (
  `ID_SPECIE` int(10) NOT NULL AUTO_INCREMENT,
  `LIB_SPECIE` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_SPECIE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `specie`
--

INSERT INTO `specie` (`ID_SPECIE`, `LIB_SPECIE`) VALUES
(1, 'WYVERN'),
(2, 'ANCIENT_DRAGONS'),
(3, 'CAT'),
(4, 'HERBIVORES');

-- --------------------------------------------------------

--
-- Structure de la table `sub_specie`
--

CREATE TABLE IF NOT EXISTS `sub_specie` (
  `ID_SUB_SPECIE` int(10) NOT NULL AUTO_INCREMENT,
  `LIB_SUB_SPECIE` varchar(20) DEFAULT NULL,
  `LIB_HABITAT` varchar(20) DEFAULT NULL,
  `ID_SPECIE` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID_SUB_SPECIE`),
  KEY `FK_SUB_SPECIE_ID_SPECIE` (`ID_SPECIE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `sub_specie`
--

INSERT INTO `sub_specie` (`ID_SUB_SPECIE`, `LIB_SUB_SPECIE`, `LIB_HABITAT`, `ID_SPECIE`) VALUES
(1, 'WYVERN_AVIAIRE', 'JUNGLE', 1),
(2, 'WYVERN_AQUA', 'OCEAN', 1),
(3, 'WYVERN_VOLANT', 'PLAINE', 1),
(4, 'FELYNE', 'CITY', 3),
(5, 'MELYNX', 'FOREST', 3),
(6, 'FIRE_DRAGON', 'VOLCANO', 2),
(7, 'MAMIFERE', 'PLAINE', 4),
(8, 'CETACE', 'OCEAN', 4),
(9, 'PRIMATE', 'JUNGLE', 4);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `assoc_monster_element`
--
ALTER TABLE `assoc_monster_element`
  ADD CONSTRAINT `FK_ASSOC_MONSTER_ELEMENT_ID_MONSTER` FOREIGN KEY (`ID_MONSTER`) REFERENCES `monster` (`ID_MONSTER`),
  ADD CONSTRAINT `FK_ASSOC_MONSTER_ELEMENT_ID_ELEMENT` FOREIGN KEY (`ID_ELEMENT`) REFERENCES `element` (`ID_ELEMENT`);

--
-- Contraintes pour la table `assoc_monster_sub_specie`
--
ALTER TABLE `assoc_monster_sub_specie`
  ADD CONSTRAINT `FK_ASSOC_MONSTER_SUB_SPECIE_ID_MONSTER` FOREIGN KEY (`ID_MONSTER`) REFERENCES `monster` (`ID_MONSTER`),
  ADD CONSTRAINT `FK_ASSOC_MONSTER_SUB_SPECIE_ID_SUB_SPECIE` FOREIGN KEY (`ID_SUB_SPECIE`) REFERENCES `sub_specie` (`ID_SUB_SPECIE`);

--
-- Contraintes pour la table `assoc_player_account`
--
ALTER TABLE `assoc_player_account`
  ADD CONSTRAINT `FK_ASSOC_PLAYER_ACCOUNT_ID_ACCOUNT` FOREIGN KEY (`ID_ACCOUNT`) REFERENCES `account` (`ID_ACCOUNT`),
  ADD CONSTRAINT `FK_ASSOC_PLAYER_ACCOUNT_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`);

--
-- Contraintes pour la table `assoc_player_enclosure`
--
ALTER TABLE `assoc_player_enclosure`
  ADD CONSTRAINT `FK_ASSOC_PLAYER_ENCLOSURE_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`),
  ADD CONSTRAINT `FK_ASSOC_PLAYER_ENCLOSURE_ID_ENCLOSURE` FOREIGN KEY (`ID_ENCLOSURE`) REFERENCES `enclosure` (`ID_ENCLOSURE`);

--
-- Contraintes pour la table `assoc_player_quest`
--
ALTER TABLE `assoc_player_quest`
  ADD CONSTRAINT `FK_ASSOC_PLAYER_QUEST_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`),
  ADD CONSTRAINT `FK_ASSOC_PLAYER_QUEST_ID_QUEST` FOREIGN KEY (`ID_QUEST`) REFERENCES `quest` (`ID_QUEST`);

--
-- Contraintes pour la table `enclosure`
--
ALTER TABLE `enclosure`
  ADD CONSTRAINT `FK_ENCLOSURE_ID_PARK` FOREIGN KEY (`ID_PARK`) REFERENCES `park` (`ID_PARK`),
  ADD CONSTRAINT `FK_ENCLOSURE_ID_SUB_SPECIE` FOREIGN KEY (`ID_SUB_SPECIE`) REFERENCES `sub_specie` (`ID_SUB_SPECIE`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_ITEM_ID_QUEST` FOREIGN KEY (`ID_QUEST`) REFERENCES `quest` (`ID_QUEST`),
  ADD CONSTRAINT `FK_ITEM_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`);

--
-- Contraintes pour la table `monster`
--
ALTER TABLE `monster`
  ADD CONSTRAINT `FK_MONSTER_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`),
  ADD CONSTRAINT `FK_MONSTER_ID_ENCLOSURE` FOREIGN KEY (`ID_ENCLOSURE`) REFERENCES `enclosure` (`ID_ENCLOSURE`),
  ADD CONSTRAINT `FK_MONSTER_ID_MATURITY` FOREIGN KEY (`ID_MATURITY`) REFERENCES `maturity` (`ID_MATURITY`);

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `FK_NEWS_ID_NEWSPAPER` FOREIGN KEY (`ID_NEWSPAPER`) REFERENCES `newspaper` (`ID_NEWSPAPER`);

--
-- Contraintes pour la table `park`
--
ALTER TABLE `park`
  ADD CONSTRAINT `FK_PARK_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`);

--
-- Contraintes pour la table `ptransaction`
--
ALTER TABLE `ptransaction`
  ADD CONSTRAINT `FK_PTRANSACTION_ID_JOUEUR` FOREIGN KEY (`ID_PLAYER`) REFERENCES `player` (`ID_PLAYER`);

--
-- Contraintes pour la table `sub_specie`
--
ALTER TABLE `sub_specie`
  ADD CONSTRAINT `FK_SUB_SPECIE_ID_SPECIE` FOREIGN KEY (`ID_SPECIE`) REFERENCES `specie` (`ID_SPECIE`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
