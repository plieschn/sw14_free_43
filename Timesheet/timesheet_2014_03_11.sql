-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Mrz 2014 um 23:11
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `courses_tasks`
--

INSERT INTO `courses_tasks` (`id`, `course_id`, `task_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `entries`
--

INSERT INTO `entries` (`id`, `user_id`, `courses_tasks_id`, `begin`, `end`, `notes`) VALUES
(1, 1, 4, '2014-02-11 23:00:00', '2014-02-12 01:00:00', 'Created git repository and initial readme file.'),
(2, 1, 1, '2014-03-05 08:00:00', '2014-03-05 12:00:00', 'First lecture: Introduction'),
(3, 1, 2, '2014-03-11 15:00:00', '2014-03-11 22:00:00', 'Mid term exam: Content of book Extreme_Programming_Explained_-_Embrace_Change_1999_Kent_Beck'),
(4, 1, 4, '2014-03-11 22:00:00', '2014-03-12 00:00:00', 'Timesheet data base.');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `tasks`
--

INSERT INTO `tasks` (`id`, `name`) VALUES
(1, 'visit lecture'),
(2, 'learn for mid term exam'),
(3, 'learn for end term exam'),
(4, 'project preparation'),
(5, 'project');

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hours_all` AS select sec_to_time(sum((unix_timestamp(`entries`.`end`) - unix_timestamp(`entries`.`begin`)))) AS `hours` from `entries`;

-- --------------------------------------------------------

--
-- Struktur des Views `hours_plieschn`
--
DROP TABLE IF EXISTS `hours_plieschn`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hours_plieschn` AS select sec_to_time(sum((unix_timestamp(`entries`.`end`) - unix_timestamp(`entries`.`begin`)))) AS `hours` from `entries` where (`entries`.`user_id` = 1);

-- --------------------------------------------------------

--
-- Struktur des Views `hours_plieschn_ma`
--
DROP TABLE IF EXISTS `hours_plieschn_ma`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `hours_plieschn_ma` AS select sec_to_time(sum((unix_timestamp(`entries`.`end`) - unix_timestamp(`entries`.`begin`)))) AS `hours` from ((`entries` join `courses_tasks` on((`entries`.`courses_tasks_id` = `courses_tasks`.`id`))) join `courses` on((`courses_tasks`.`course_id` = `courses`.`id`))) where ((`entries`.`user_id` = 1) and (`courses`.`id` = 1));

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `courses_tasks`
--
ALTER TABLE `courses_tasks`
  ADD CONSTRAINT `courses_tasks_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  ADD CONSTRAINT `courses_tasks_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints der Tabelle `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `entries_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`courses_tasks_id`) REFERENCES `courses_tasks` (`id`);

--
-- Constraints der Tabelle `users_courses`
--
ALTER TABLE `users_courses`
  ADD CONSTRAINT `users_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `users_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
