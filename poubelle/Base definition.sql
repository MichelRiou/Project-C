-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 29 juin 2018 à 13:57
-- Version du serveur :  10.1.32-MariaDB
-- Version de PHP :  5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `calestor1`
--
CREATE DATABASE IF NOT EXISTS `calestor1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `calestor1`;

-- --------------------------------------------------------

--
-- Structure de la table `audiodevice`
--

DROP TABLE IF EXISTS `audiodevice`;
CREATE TABLE IF NOT EXISTS `audiodevice` (
  `audio_id` int(11) NOT NULL AUTO_INCREMENT,
  `audio_builder` varchar(255) NOT NULL,
  `audio_type` char(2) NOT NULL,
  `audio_model` varchar(50) NOT NULL,
  `audio_proc` varchar(50) NOT NULL,
  `audio_luminosity` varchar(10) NOT NULL,
  `audio_resolution` varchar(10) NOT NULL,
  `audio_focale` varchar(20) NOT NULL,
  `audio_interieur` tinyint(1) NOT NULL,
  PRIMARY KEY (`audio_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `audiodevice`
--

INSERT INTO `audiodevice` (`audio_id`, `audio_builder`, `audio_type`, `audio_model`, `audio_proc`, `audio_luminosity`, `audio_resolution`, `audio_focale`, `audio_interieur`) VALUES
(1, 'VIVITEK', 'V', 'QUMI Q3+', 'DLP', '500', 'WXGA', 'CLASSIQUE', 1),
(2, 'NEC', 'V', 'V302H', 'DLP', '7000', 'FULL HD', 'ULTRA COURTE', 0),
(3, 'NEC', 'V', 'UM301Wi', 'LCD', '3000', 'WXGA', 'ultra courte', 1),
(4, 'EPSON', 'V', 'EB-675W', 'FULL HD', '3500', 'WUXGA', 'CLASSIQUE', 0),
(5, 'HP', 'V', 'PA803U', 'LCD', '7000', 'WUXGA', 'classique', 1);

-- --------------------------------------------------------

--
-- Structure de la table `businessunit`
--

DROP TABLE IF EXISTS `businessunit`;
CREATE TABLE IF NOT EXISTS `businessunit` (
  `bu_id` int(11) NOT NULL AUTO_INCREMENT,
  `bu_name` varchar(50) NOT NULL,
  PRIMARY KEY (`bu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `businessunit`
--

INSERT INTO `businessunit` (`bu_id`, `bu_name`) VALUES
(1, 'PRINTER'),
(2, 'AUDIOVISUEL'),
(3, 'IT');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment`, `comment_date`) VALUES
(1, 2, 'Mathieu', 'Preum\'s', '2017-09-24 17:12:30'),
(2, 2, 'Sam', 'Quelqu\'un a un avis là-dessus ? Je ne sais pas quoi en penser.', '2017-09-24 17:21:34'),
(8, 1, 'Jojo', 'C\'est moi !', '2017-09-28 19:50:14'),
(9, 2, 'Mathieu', 'Retest\r\nEncore', '2017-10-27 11:46:50'),
(10, 2, 'Sam', 'tu testes quoi ?', '2017-10-27 15:44:14');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `creation_date`) VALUES
(3, 'title', 'content', '2018-06-19 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_bu` int(11) NOT NULL,
  `request_name` varchar(50) NOT NULL,
  `request_libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`request_id`),
  UNIQUE KEY `request_bu_idx` (`request_bu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`request_bu`) REFERENCES `businessunit` (`bu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
