/*
CREATE USER 'testUser'@'localhost' IDENTIFIED BY 'testPassword';
GRANT ALL PRIVILEGES ON *.* TO 'testUser'@'localhost';
FLUSH PRIVILEGES;
*/

CREATE DATABASE `Tournament-Management-System` DEFAULT CHARACTER SET utf8mb4;
USE `Tournament-Management-System`;

CREATE TABLE `Admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Day` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) unsigned NOT NULL,
  `day_number` int(11) unsigned NOT NULL,
  `done` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tournament_id` (`tournament_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Planning` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `day_id` int(11) unsigned NOT NULL,
  `teamA_name` varchar(255) NOT NULL,
  `teamB_name` varchar(255) NOT NULL,
  `teamA_nbGoal` int(10) unsigned DEFAULT NULL,
  `teamB_nbGoal` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `day_id` (`day_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tournament_id` int(10) unsigned NOT NULL,
  `nb_visit` int(10) unsigned DEFAULT NULL,
  `path_logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Tournament` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nb_team` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;