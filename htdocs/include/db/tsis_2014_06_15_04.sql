-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. Jun 2014 um 19:06
-- Server Version: 5.1.70-log
-- PHP-Version: 5.5.12-pl0-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `tsis`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(25) NOT NULL,
  `value_int` int(11) DEFAULT NULL,
  `value_text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `information`
--

INSERT INTO `information` (`id`, `key`, `value_int`, `value_text`) VALUES
(1, 'version', NULL, '1.0.0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(150) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `last_time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`id`, `username`, `password`, `first_name`, `last_name`, `title`, `admin`, `last_time_modified`) VALUES
(2, 'plieschn', '*8CDA35FD2F78B711A87C25F2A2CBEBCF8615BDCA', 'Markus', 'Plieschnegger', 'BSc', 0, '2014-06-15 00:22:08');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `points`
--

CREATE TABLE IF NOT EXISTS `points` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `track_id` int(10) unsigned NOT NULL,
  `number` int(10) unsigned NOT NULL,
  `longitude` decimal(17,14) NOT NULL,
  `latitude` decimal(17,14) NOT NULL,
  `height` decimal(8,5) NOT NULL,
  `when` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`,`track_id`),
  KEY `track_id` (`track_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `points`
--

INSERT INTO `points` (`id`, `project_id`, `track_id`, `number`, `longitude`, `latitude`, `height`, `when`) VALUES
(1, 1, 1, 0, '15.14753759242735', '47.04351470905308', '455.00000', '2013-09-04 08:25:00'),
(2, 1, 1, 1, '15.14754142582748', '47.04351255596844', '455.00000', '2013-09-04 08:25:01'),
(3, 1, 1, 2, '15.14754513141350', '47.04351007281513', '455.00000', '2013-09-04 08:25:02'),
(4, 1, 1, 3, '15.14754878879578', '47.04351114713411', '455.00000', '2013-09-04 08:25:03'),
(5, 1, 1, 4, '15.14754881858373', '47.04351113181861', '455.00000', '2013-09-04 08:25:04');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `projects`
--

INSERT INTO `projects` (`id`, `name`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'lecturer'),
(2, 'student');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `number` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tracks`
--

INSERT INTO `tracks` (`id`, `project_id`, `number`) VALUES
(1, 1, 1);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `points_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `points_ibfk_2` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
