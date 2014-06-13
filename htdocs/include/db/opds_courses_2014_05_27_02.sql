-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 27. Mai 2014 um 14:53
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
  `main_lecturer` int(10) unsigned NOT NULL,
  `number` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `objectives` text NOT NULL,
  `last_time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `opds_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_2` (`number`),
  KEY `organisation_id` (`organisation_id`),
  KEY `number` (`number`),
  KEY `main_lecturer` (`main_lecturer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `courses`
--

INSERT INTO `courses` (`id`, `organisation_id`, `main_lecturer`, `number`, `name`, `content`, `objectives`, `last_time_modified`, `opds_id`) VALUES
(1, 1, 2, 706004, 'Databases 1', '1. Introduction to Database systems (architecture, data description and data manipulation languages, data models). \r\n2. Relational Data Model (Properties of Relations, Normalization, Relational Algebra, Relational Calculus, SQL, QBE, Integrity). \r\n3. Physical and Logical Integrity, Database recovering methods', 'The course provides students with a theoretical background and practical knowledge on Relational Database Systems', '2014-05-25 12:27:34', 'urn:uuid:d7bc35ec-e5c7-4c3e-ad67-fd7bd863e846'),
(2, 1, 4, 707030, 'Databases 2', 'Scalable and parallel parallel data processing\nNoSQL systems\nMap/Reduce\nGraph databases', 'Recently, new type of database systems has emerged as a response to huge amount of unstructured and semi-structured data that are available on the World Wide Web. Those systems differ from the traditional database systems as they offer flexibility, massive scalability, high performance and availability. These new systems are typically called nowadays "NoSQL" systems. The goal of this course is to give a theoritical introduction of NoSQL systems, as well as to gain a practical experience with these systems by implementing a NoSQL database. We will discuss in more details systems such as Map/Reduce and graph databases.', '2014-05-25 12:27:52', 'urn:uuid:666d1774-e98d-4d77-af69-6aab8416759f'),
(3, 1, 2, 706045, 'Structured Data-Management - Advanced Topics', '1. Introduction to Structured Data-Management (Well-Structured Data, Ill-structured Data, separating structure and content). \n2. Conventional Data Models (Relational, Network and Object-Oriented) \n3. Deductive Data Models \n4. Functional Data Models \n5. Semantic Data Models \n6. Hypermedia Data Models \n7. Document Management', 'The course provides students with a theoretical background and practical knowledge on modern Structured Data-Management Systems from Databases to Hypermedia and document management systems.', '2014-05-25 12:28:01', 'urn:uuid:17e99a40-e4a0-4842-909e-a06fa6de60f2'),
(4, 1, 3, 706057, 'Information Visualisation', '1. Introduction \n2. History of Information Visualisation \n3. Visualising Linear Structures \n4. Visualising Hierarchies \n5. Visualising Networks and Graphs \n6. Visualising Multidimensional Metadata \n7. Visualising Text and Object Collections \n8. Visualising Query Spaces', 'Participants will gain an understanding of the methods and \r\nprinciples of information visualisation. They will posess the \r\nbasic skills needed to develop their own visualisations.', '2014-05-25 12:28:08', 'urn:uuid:bb7d3c3a-5460-480f-bfd7-5d957c8d0276'),
(5, 2, 5, 705040, 'Verification and Testing', 'In this course we will discuss recent research in testing and verification of hardware and software. We will discuss advanced techniques such as model checking and delta debugging. SUch techniques are not yet in common use in industry, but that will change. The course will have a formal/theoretical slant.', 'Knowledge of the state of the art in research in formal verification and testing.', '2014-05-25 12:28:14', 'urn:uuid:20cfe308-e5a1-42e6-9e4c-e672f48fb712');

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
(6, 1, 6, 2),
(7, 2, 6, 2),
(8, 3, 6, 2),
(9, 4, 6, 2),
(10, 5, 6, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `course_resources`
--

CREATE TABLE IF NOT EXISTS `course_resources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(150) NOT NULL,
  `external` tinyint(1) NOT NULL,
  `type` varchar(50) NOT NULL,
  `rel` varchar(50) NOT NULL,
  `last_time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `opds_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `course_resources`
--

INSERT INTO `course_resources` (`id`, `course_id`, `author_id`, `name`, `url`, `external`, `type`, `rel`, `last_time_modified`, `opds_id`) VALUES
(1, 1, 2, 'Course information page', 'page.pdf', 0, 'application/pdf', 'http://opds-spec.org/acquisition', '2014-05-27 12:29:38', 'urn:uuid:b5fdead1-5a0b-41f8-aa4a-6bc27326e942'),
(2, 2, 4, 'Course information page', 'page.pdf', 0, 'application/pdf', 'http://opds-spec.org/acquisition', '2014-05-27 12:29:41', 'urn:uuid:d9da3cbf-8264-4222-bad4-4b746e7ab381'),
(3, 3, 2, 'Course information page', 'page.pdf', 0, 'application/pdf', 'http://opds-spec.org/acquisition', '2014-05-27 12:29:45', 'urn:uuid:eb635cc0-dc7a-4250-a36c-b952a72a028c'),
(4, 4, 3, 'Course information page', 'page.pdf', 0, 'application/pdf', 'http://opds-spec.org/acquisition', '2014-05-27 12:29:48', 'urn:uuid:911ab3ed-a48f-4355-b137-0a7fb348c015'),
(5, 5, 5, 'Course information page', 'page.pdf', 0, 'application/pdf', 'http://opds-spec.org/acquisition', '2014-05-27 12:29:52', 'urn:uuid:f73f1466-7816-4795-a97d-6c999c77a5ec');

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
  `last_time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `opds_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`id`, `username`, `password`, `first_name`, `last_name`, `title`, `admin`, `last_time_modified`, `opds_id`) VALUES
(1, 'admin', '*B551EB77BFD47D251D1CC5523BEA4904E54DBB03', 'Max', 'Mustermann', NULL, 1, '2014-05-25 12:51:00', 'urn:uuid:d687bcd1-6983-4d34-9d66-84d265d57bf8'),
(2, 'nscer', '*F5EE9D8A482215CFD4A9AD23D62C323654E193D9', 'Nikolai', 'Scerbakov', 'Ao.Univ.-Prof. Dipl.-Ing. Dr.techn.', 0, '2014-05-24 16:45:56', 'urn:uuid:b88a3ca3-30c0-404c-83b9-3f1555e003f6'),
(3, 'kandr', '*70494956400420A79B15D88F1EBE58CDC111868C', 'Keith', 'Andrews', 'Ao.Univ.-Prof. Dipl.-Ing. Dr.techn.', 0, '2014-05-24 16:46:07', 'urn:uuid:1d2e7a3f-db10-4b94-898c-9a4fd5b56b05'),
(4, 'dheli', '*4D7C1C4F88D3E987AAE50645A09136E0958D3D5A', 'Denis', 'Helic', 'Assoc.Prof. Dipl.-Ing. Dr.techn.', 0, '2014-05-24 16:46:24', 'urn:uuid:ca936875-0521-4205-9b7c-23e83d4f0394'),
(5, 'rbloe', '*34032559D28AB9006F9A1175E228CF081208EA82', 'Roderick Paul', 'Bloem', 'Univ.-Prof. M.Sc. Ph.D.', 0, '2014-05-24 16:46:30', 'urn:uuid:35a908fc-66e9-40ce-a558-7cb7a98a4147'),
(6, 'mplie', '*7F7399A37D9D2A0EA4AFE909FB262FF0C42A90C8', 'Markus', 'Plieschnegger', 'BSc', 0, '2014-05-24 16:46:40', 'urn:uuid:15677aa2-d71e-42f9-8beb-5c58570a1f83');

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

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`main_lecturer`) REFERENCES `persons` (`id`);

--
-- Constraints der Tabelle `courses_persons`
--
ALTER TABLE `courses_persons`
  ADD CONSTRAINT `courses_persons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `courses_persons_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `courses_persons_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints der Tabelle `course_resources`
--
ALTER TABLE `course_resources`
  ADD CONSTRAINT `course_resources_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `persons` (`id`),
  ADD CONSTRAINT `course_resources_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints der Tabelle `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD CONSTRAINT `prerequisites_ibfk_1` FOREIGN KEY (`course_target_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `prerequisites_ibfk_2` FOREIGN KEY (`course_required_id`) REFERENCES `courses` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
