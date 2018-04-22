-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  `author` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `id_post` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `reset_password` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `date_create` timestamp NOT NULL,
  `id_type` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type` (`id_type`),
  KEY `login` (`login`),
  CONSTRAINT `member_ibfk_3` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `lede` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  `date_update` timestamp NOT NULL,
  `img` varchar(128) COLLATE latin1_general_ci NOT NULL,
  `id_member` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `label` tinytext COLLATE latin1_danish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_danish_ci;


-- 2018-04-22 12:26:17
