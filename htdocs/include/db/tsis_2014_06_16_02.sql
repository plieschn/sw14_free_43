-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Jun 2014 um 17:25
-- Server Version: 5.1.70-log
-- PHP-Version: 5.5.10-pl0-gentoo

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`id`, `username`, `password`, `first_name`, `last_name`, `title`, `admin`, `last_time_modified`) VALUES
(2, 'plieschn', '*8CDA35FD2F78B711A87C25F2A2CBEBCF8615BDCA', 'Markus', 'Plieschnegger', 'BSc', 0, '2014-06-15 00:22:08'),
(3, 'TSISTest', '*94BDCEBE19083CE2A1F959FD02F964C7AF4CFC29', 'TSIS', 'Test', 'Java', 0, '2014-06-16 17:16:19');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Daten für Tabelle `points`
--

INSERT INTO `points` (`id`, `project_id`, `track_id`, `number`, `longitude`, `latitude`, `height`, `when`) VALUES
(1, 1, 1, 0, '15.14753759242735', '47.04351470905308', '455.00000', '2013-09-04 08:25:00'),
(2, 1, 1, 1, '15.14754142582748', '47.04351255596844', '455.00000', '2013-09-04 08:25:01'),
(3, 1, 1, 2, '15.14754513141350', '47.04351007281513', '455.00000', '2013-09-04 08:25:02'),
(4, 1, 1, 3, '15.14754878879578', '47.04351114713411', '455.00000', '2013-09-04 08:25:03'),
(5, 1, 1, 4, '15.14754881858373', '47.04351113181861', '455.00000', '2013-09-04 08:25:04'),
(6, 2, 2, 0, '15.14753759242735', '47.04351470905308', '455.00000', '2013-09-04 08:25:00'),
(7, 2, 2, 1, '15.14754142582748', '47.04351255596844', '455.00000', '2013-09-04 08:25:01'),
(8, 2, 2, 2, '15.14754513141350', '47.04351007281513', '455.00000', '2013-09-04 08:25:02'),
(9, 2, 2, 3, '15.14754878879578', '47.04351114713411', '455.00000', '2013-09-04 08:25:03'),
(10, 2, 2, 4, '15.14754881858373', '47.04351113181861', '455.00000', '2013-09-04 08:25:04'),
(11, 2, 3, 0, '15.14753759242735', '47.04351470905308', '455.00000', '2013-09-04 08:25:00'),
(12, 2, 3, 1, '15.14754142582748', '47.04351255596844', '455.00000', '2013-09-04 08:25:01'),
(13, 2, 3, 2, '15.14754513141350', '47.04351007281513', '455.00000', '2013-09-04 08:25:02'),
(14, 2, 3, 3, '15.14754878879578', '47.04351114713411', '455.00000', '2013-09-04 08:25:03'),
(15, 2, 3, 4, '15.14754881858373', '47.04351113181861', '455.00000', '2013-09-04 08:25:04'),
(16, 3, 4, 0, '15.14753759242735', '47.04351470905308', '455.00000', '2013-09-04 08:25:00'),
(17, 3, 4, 1, '15.14754142582748', '47.04351255596844', '455.00000', '2013-09-04 08:25:01'),
(18, 3, 4, 2, '15.14754513141350', '47.04351007281513', '455.00000', '2013-09-04 08:25:02'),
(19, 3, 4, 3, '15.14754878879578', '47.04351114713411', '455.00000', '2013-09-04 08:25:03'),
(20, 3, 4, 4, '15.14754881858373', '47.04351113181861', '455.00000', '2013-09-04 08:25:04'),
(21, 4, 5, 0, '15.45057200000000', '47.06952300000000', '354.11000', '2014-06-01 11:40:18'),
(22, 4, 5, 1, '15.45041200000000', '47.06961200000000', '354.21000', '2014-06-01 11:41:18'),
(23, 4, 5, 2, '15.45045600000000', '47.06964300000000', '354.52000', '2014-06-01 11:42:18'),
(24, 4, 5, 3, '15.45044000000000', '47.06970100000000', '354.32000', '2014-06-01 11:43:18'),
(25, 4, 5, 4, '15.45043800000000', '47.06972000000000', '354.29000', '2014-06-01 11:44:18'),
(26, 5, 6, 0, '15.45057200000000', '47.06952300000000', '354.11000', '2014-06-01 11:40:18'),
(27, 5, 6, 1, '15.45041200000000', '47.06961200000000', '354.21000', '2014-06-01 11:41:18'),
(28, 5, 6, 2, '15.45045600000000', '47.06964300000000', '354.52000', '2014-06-01 11:42:18'),
(29, 5, 6, 3, '15.45044000000000', '47.06970100000000', '354.32000', '2014-06-01 11:43:18'),
(30, 5, 6, 4, '15.45043800000000', '47.06972000000000', '354.29000', '2014-06-01 11:44:18'),
(31, 6, 7, 0, '15.45057200000000', '47.06952300000000', '354.11000', '2014-06-01 11:40:18'),
(32, 6, 7, 1, '15.45041200000000', '47.06961200000000', '354.21000', '2014-06-01 11:41:18'),
(33, 6, 7, 2, '15.45045600000000', '47.06964300000000', '354.52000', '2014-06-01 11:42:18'),
(34, 6, 7, 3, '15.45044000000000', '47.06970100000000', '354.32000', '2014-06-01 11:43:18'),
(35, 6, 7, 4, '15.45043800000000', '47.06972000000000', '354.29000', '2014-06-01 11:44:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `projects`
--

INSERT INTO `projects` (`id`, `person_id`, `name`) VALUES
(1, 2, 'test1'),
(2, 2, 'test2'),
(3, 2, 'test3'),
(4, 2, 'test4'),
(5, 3, 'Test Track'),
(6, 3, 'TestTrack');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `tracks`
--

INSERT INTO `tracks` (`id`, `project_id`, `number`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 2, 0),
(4, 3, 0),
(5, 4, 0),
(6, 5, 0),
(7, 6, 0);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `points_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `points_ibfk_2` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`);

--
-- Constraints der Tabelle `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
