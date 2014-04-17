-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 17. Apr 2014 um 00:18
-- Server Version: 5.1.70-log
-- PHP-Version: 5.5.10-pl0-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `timesheet`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `courses`
--

INSERT INTO `courses` (`id`, `number`, `name`) VALUES
(1, 716100, 'Mobile Applications');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `courses_tasks`
--

CREATE TABLE IF NOT EXISTS `courses_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `courses_tasks`
--

INSERT INTO `courses_tasks` (`id`, `course_id`, `task_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `entries`
--

CREATE TABLE IF NOT EXISTS `entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `courses_tasks_id` int(10) unsigned NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_tasks_id` (`courses_tasks_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `entries`
--

INSERT INTO `entries` (`id`, `user_id`, `courses_tasks_id`, `begin`, `end`, `notes`) VALUES
(1, 1, 4, '2014-02-11 23:00:00', '2014-02-12 01:00:00', 'Created git repository and initial readme file.'),
(2, 1, 1, '2014-03-05 08:00:00', '2014-03-05 12:00:00', 'First lecture: Introduction.'),
(3, 1, 2, '2014-03-11 15:00:00', '2014-03-11 22:00:00', 'Mid term exam: Content of book Extreme_Programming_Explained_-_Embrace_Change_1999_Kent_Beck.'),
(4, 1, 4, '2014-03-11 22:00:00', '2014-03-12 01:00:00', 'Timesheet data base.'),
(5, 1, 1, '2014-03-12 10:00:00', '2014-03-12 12:00:00', 'Second lecture: Android tutorial.'),
(6, 1, 4, '2014-03-15 20:00:00', '2014-03-15 23:00:00', 'Reimplemented the tutorial example.'),
(7, 1, 4, '2014-03-16 20:00:00', '2014-03-17 01:00:00', 'Reimplemented the tutorial example.'),
(8, 1, 4, '2014-04-01 14:00:00', '2014-04-01 18:00:00', 'Pre presentation and github setup.'),
(9, 1, 4, '2014-04-14 14:00:00', '2014-04-14 17:00:00', 'Mile stone planning, general principles, technical overview.'),
(10, 1, 5, '2014-04-15 10:45:00', '2014-04-15 13:00:00', 'Main application, first test cases for start/stop button. Implementation of button.'),
(11, 1, 5, '2014-04-15 14:00:00', '2014-04-15 18:00:00', 'Bug fixing, switched start/stop button to toggle button, adapted test case. General refactoring.'),
(12, 1, 6, '2014-04-16 14:00:00', '2014-04-16 16:00:00', 'Small refinements on code.'),
(13, 1, 5, '2014-04-16 16:00:00', '2014-04-16 18:00:00', 'Visual improvements (Action bar icon change on start/stop).');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `hours_all`
--
CREATE TABLE IF NOT EXISTS `hours_all` (
`hours` time
);
-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `hours_plieschn`
--
CREATE TABLE IF NOT EXISTS `hours_plieschn` (
`hours` time
);
-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `hours_plieschn_ma`
--
CREATE TABLE IF NOT EXISTS `hours_plieschn_ma` (
`hours` time
);
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `coding_percentage` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `coding_percentage`) VALUES
(1, 'visit lecture', 0),
(2, 'learn for mid term exam', 0),
(3, 'learn for end term exam', 0),
(4, 'project preparation', 0),
(5, 'project', 1),
(6, 'project refactoring', 0.8);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`) VALUES
(1, 'plieschn', 'Markus', 'Plieschnegger');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_courses`
--

CREATE TABLE IF NOT EXISTS `users_courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `users_courses`
--

INSERT INTO `users_courses` (`id`, `user_id`, `course_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Struktur des Views `hours_all`
--
DROP TABLE IF EXISTS `hours_all`;
-- in Benutzung(#1142 - SHOW VIEW command denied to user 'timesheet'@'localhost' for table 'hours_all')

-- --------------------------------------------------------

--
-- Struktur des Views `hours_plieschn`
--
DROP TABLE IF EXISTS `hours_plieschn`;
-- in Benutzung(#1142 - SHOW VIEW command denied to user 'timesheet'@'localhost' for table 'hours_plieschn')

-- --------------------------------------------------------

--
-- Struktur des Views `hours_plieschn_ma`
--
DROP TABLE IF EXISTS `hours_plieschn_ma`;
-- in Benutzung(#1142 - SHOW VIEW command denied to user 'timesheet'@'localhost' for table 'hours_plieschn_ma')

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `courses_tasks`
--
ALTER TABLE `courses_tasks`
  ADD CONSTRAINT `courses_tasks_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `courses_tasks_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

--
-- Constraints der Tabelle `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`courses_tasks_id`) REFERENCES `courses_tasks` (`id`),
  ADD CONSTRAINT `entries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `users_courses`
--
ALTER TABLE `users_courses`
  ADD CONSTRAINT `users_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
