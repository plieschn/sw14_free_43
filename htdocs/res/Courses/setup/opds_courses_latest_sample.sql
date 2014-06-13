-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. Mai 2014 um 18:45
-- Server Version: 5.1.70-log
-- PHP-Version: 5.3.28-pl3-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `opds_courses`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `organisation_id` int(10) unsigned NOT NULL,
  `number` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `objectives` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_2` (`number`),
  KEY `organisation_id` (`organisation_id`),
  KEY `number` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `courses`
--

INSERT INTO `courses` (`id`, `organisation_id`, `number`, `name`, `content`, `objectives`) VALUES
(1, 1, 706004, 'Databases 1', '1. Introduction to Database systems (architecture, data description and data manipulation languages, data models). \r\n2. Relational Data Model (Properties of Relations, Normalization, Relational Algebra, Relational Calculus, SQL, QBE, Integrity). \r\n3. Physical and Logical Integrity, Database recovering methods', 'The course provides students with a theoretical background and practical knowledge on Relational Database Systems'),
(2, 1, 707030, 'Databases 2', 'Scalable and parallel parallel data processing\r\nNoSQL systems\r\nMap/Reduce\r\nGraph databases', 'Recently, new type of database systems has emerged as a response to huge amount of unstructured and semi-structured data that are available on the World Wide Web. Those systems differ from the traditional database systems as they offer flexibility, massive scalability, high performance and availability. These new systems are typically called nowadays "NoSQL" systems. The goal of this course is to give a theoritical introduction of NoSQL systems, as well as to gain a practical experience with these systems by implementing a NoSQL database. We will discuss in more details systems such as Map/Reduce and graph databases.'),
(3, 1, 706045, 'Structured Data-Management - Advanced Topics', '1. Introduction to Structured Data-Management (Well-Structured Data, Ill-structured Data, separating structure and content). \r\n2. Conventional Data Models (Relational, Network and Object-Oriented) \r\n3. Deductive Data Models \r\n4. Functional Data Models \r\n5. Semantic Data Models \r\n6. Hypermedia Data Models \r\n7. Document Management', 'The course provides students with a theoretical background and practical knowledge on modern Structured Data-Management Systems from Databases to Hypermedia and document management systems.'),
(4, 1, 706057, 'Information Visualisation', '1. Introduction \r\n2. History of Information Visualisation \r\n3. Visualising Linear Structures \r\n4. Visualising Hierarchies \r\n5. Visualising Networks and Graphs \r\n6. Visualising Multidimensional Metadata \r\n7. Visualising Text and Object Collections \r\n8. Visualising Query Spaces', 'Participants will gain an understanding of the methods and \r\nprinciples of information visualisation. They will posess the \r\nbasic skills needed to develop their own visualisations.'),
(5, 2, 705040, 'Verification and Testing', 'In this course we will discuss recent research in testing and verification of hardware and software. We will discuss advanced techniques such as model checking and delta debugging. SUch techniques are not yet in common use in industry, but that will change. The course will have a formal/theoretical slant.', 'Knowledge of the state of the art in research in formal verification and testing.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `courses_persons`
--

CREATE TABLE IF NOT EXISTS `courses_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`,`person_id`,`role_id`),
  KEY `person_id` (`person_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `courses_persons`
--

INSERT INTO `courses_persons` (`id`, `course_id`, `person_id`, `role_id`) VALUES
(1, 1, 2, 1),
(6, 1, 6, 2),
(2, 2, 4, 1),
(7, 2, 6, 2),
(3, 3, 2, 1),
(8, 3, 6, 2),
(4, 4, 3, 1),
(9, 4, 6, 2),
(5, 5, 5, 1),
(10, 5, 6, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `organisations`
--

CREATE TABLE IF NOT EXISTS `organisations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_2` (`number`),
  KEY `number` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `organisations`
--

INSERT INTO `organisations` (`id`, `number`, `name`) VALUES
(1, 7060, 'Institute of Information Systems and Computer Media'),
(2, 7050, 'Institute of Applied Information Processing and Communications');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`id`, `username`, `password`, `first_name`, `last_name`, `title`, `admin`) VALUES
(1, 'admin', '*B551EB77BFD47D251D1CC5523BEA4904E54DBB03', '', '', NULL, 1),
(2, 'nscer', '*F5EE9D8A482215CFD4A9AD23D62C323654E193D9', 'Nikolai', 'Scerbakov', 'Ao.Univ.-Prof. Dipl.-Ing. Dr.techn.', 0),
(3, 'kandr', '*70494956400420A79B15D88F1EBE58CDC111868C', 'Keith', 'Andrews', 'Ao.Univ.-Prof. Dipl.-Ing. Dr.techn.', 0),
(4, 'dheli', '*4D7C1C4F88D3E987AAE50645A09136E0958D3D5A', 'Denis', 'Helic', 'Assoc.Prof. Dipl.-Ing. Dr.techn.', 0),
(5, 'rbloe', '*34032559D28AB9006F9A1175E228CF081208EA82', 'Roderick Paul', 'Bloem', 'Univ.-Prof. M.Sc. Ph.D.', 0),
(6, 'mplie', '*7F7399A37D9D2A0EA4AFE909FB262FF0C42A90C8', 'Markus', 'Plieschnegger', 'BSc', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `prerequisites`
--

CREATE TABLE IF NOT EXISTS `prerequisites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_target_id` int(10) unsigned NOT NULL,
  `course_required_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_target_id` (`course_target_id`),
  KEY `course_required_id` (`course_required_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `prerequisites`
--

INSERT INTO `prerequisites` (`id`, `course_target_id`, `course_required_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'lecturer'),
(2, 'student');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`);

--
-- Constraints der Tabelle `courses_persons`
--
ALTER TABLE `courses_persons`
  ADD CONSTRAINT `courses_persons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `courses_persons_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `courses_persons_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints der Tabelle `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD CONSTRAINT `prerequisites_ibfk_1` FOREIGN KEY (`course_target_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `prerequisites_ibfk_2` FOREIGN KEY (`course_required_id`) REFERENCES `courses` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
