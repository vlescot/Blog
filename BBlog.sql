SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  `likes` smallint(6) NOT NULL,
  `dislikes` smallint(6) NOT NULL,
  `author` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `validated` tinyint(4) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `validated` tinyint(4) NOT NULL,
  `date_create` timestamp NOT NULL,
  `id_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_type` (`id_type`),
  CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `lede` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `content` text COLLATE latin1_general_ci NOT NULL,
  `date_create` timestamp NOT NULL,
  `date_update` timestamp NOT NULL,
  `img` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `id_member` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_member` (`id_member`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;