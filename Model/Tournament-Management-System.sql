--
-- Base de données :  `Tournament-Management-System`
--
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

-- --------------------------------------------------------
--
-- Contenu de la table `Admin`
--
INSERT INTO `Admin` (`username`, `password`) VALUES
('admin', '$2y$10$VfEiSbv/Ja9ZRzSOlHCAn.2tnUa2uIRuPbERHSKsIpAq06ctW7HWi');

-- --------------------------------------------------------
--
-- Contenu de la table `Day`
--
INSERT INTO `Day` (`tournament_id`, `day_number`, `done`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(2, 1, 1),
(2, 2, 1),
(2, 3, 1),
(2, 4, 0),
(2, 5, 0),
(2, 6, 0),
(2, 7, 0),
(3, 1, 0),
(3, 2, 0),
(3, 3, 0),
(3, 4, 0),
(3, 5, 0),
(3, 6, 0),
(3, 7, 0);

-- --------------------------------------------------------
--
-- Contenu de la table `Planning`
--
INSERT INTO `Planning` (`day_id`, `teamA_name`, `teamB_name`, `teamA_nbGoal`, `teamB_nbGoal`) VALUES
(1, 'Nantes', 'Monaco', 4, 1),
(1, 'Bordeaux', 'Montpellier', 3, 1),
(1, 'Marseille', 'Paris', 1, 0),
(1, 'Lille', 'Toulouse', 0, 7),
(1, 'Lyon', 'Saint-Etienne', 2, 0),
(2, 'Nantes', 'Bordeaux', 7, 0),
(2, 'Marseille', 'Monaco', 4, 2),
(2, 'Lille', 'Montpellier', 8, 2),
(2, 'Lyon', 'Paris', 3, 0),
(2, 'Saint-Etienne', 'Toulouse', 1, 0),
(3, 'Nantes', 'Marseille', 3, 2),
(3, 'Lille', 'Bordeaux', 1, 1),
(3, 'Lyon', 'Monaco', 1, 3),
(3, 'Saint-Etienne', 'Montpellier', 1, 6),
(3, 'Toulouse', 'Paris', 3, 0),
(4, 'Nantes', 'Lille', 6, 2),
(4, 'Lyon', 'Marseille', 1, 1),
(4, 'Saint-Etienne', 'Bordeaux', 1, 3),
(4, 'Toulouse', 'Monaco', 0, 3),
(4, 'Paris', 'Montpellier', 5, 1),
(5, 'Nantes', 'Lyon', 2, 0),
(5, 'Saint-Etienne', 'Lille', 4, 3),
(5, 'Toulouse', 'Marseille', 2, 1),
(5, 'Paris', 'Bordeaux', 2, 4),
(5, 'Montpellier', 'Monaco', 2, 1),
(6, 'Nantes', 'Saint-Etienne', 2, 3),
(6, 'Toulouse', 'Lyon', 2, 0),
(6, 'Paris', 'Lille', 3, 1),
(6, 'Montpellier', 'Marseille', 1, 2),
(6, 'Monaco', 'Bordeaux', 2, 4),
(7, 'Nantes', 'Toulouse', 2, 3),
(7, 'Paris', 'Saint-Etienne', 4, 0),
(7, 'Montpellier', 'Lyon', 6, 7),
(7, 'Monaco', 'Lille', 3, 0),
(7, 'Bordeaux', 'Marseille', 2, 0),
(8, 'Nantes', 'Paris', 2, 2),
(8, 'Montpellier', 'Toulouse', 1, 4),
(8, 'Monaco', 'Saint-Etienne', 2, 2),
(8, 'Bordeaux', 'Lyon', 2, 1),
(8, 'Marseille', 'Lille', 0, 3),
(9, 'Nantes', 'Montpellier', 2, 3),
(9, 'Monaco', 'Paris', 0, 4),
(9, 'Bordeaux', 'Toulouse', 3, 1),
(9, 'Marseille', 'Saint-Etienne', 2, 0),
(9, 'Lille', 'Lyon', 0, 1),
(10, 'CarlJR', 'Nyco', 2, 0),
(10, 'Bren', 'Papou', 0, 3),
(10, 'PA', 'Pac', 8, 1),
(10, 'wingo', 'exempt', NULL, NULL),
(10, 'CarlJR', 'Bren', 5, 1),
(10, 'PA', 'Nyco', 1, 2),
(10, 'wingo', 'Papou', 1, 5),
(10, 'exempt', 'Pac', NULL, NULL),
(11, 'CarlJR', 'PA', 3, 6),
(11, 'wingo', 'Bren', 6, 6),
(11, 'exempt', 'Nyco', NULL, NULL),
(11, 'Pac', 'Papou', 1, 3),
(12, 'CarlJR', 'wingo', NULL, NULL),
(12, 'exempt', 'PA', NULL, NULL),
(12, 'Pac', 'Bren', NULL, NULL),
(12, 'Papou', 'Nyco', NULL, NULL),
(13, 'CarlJR', 'exempt', NULL, NULL),
(13, 'Pac', 'wingo', NULL, NULL),
(13, 'Papou', 'PA', NULL, NULL),
(13, 'Nyco', 'Bren', NULL, NULL),
(14, 'CarlJR', 'Pac', NULL, NULL),
(14, 'Papou', 'exempt', NULL, NULL),
(14, 'Nyco', 'wingo', NULL, NULL),
(14, 'Bren', 'PA', NULL, NULL),
(15, 'CarlJR', 'Papou', NULL, NULL),
(15, 'Nyco', 'Pac', NULL, NULL),
(15, 'Bren', 'exempt', NULL, NULL),
(15, 'PA', 'wingo', NULL, NULL),
(16, 'Bucks', '76ers', NULL, NULL),
(16, 'Warriors', 'Celtics', NULL, NULL),
(16, 'Bulls', 'Hornets', NULL, NULL),
(16, 'Raptors', 'heat', NULL, NULL),
(17, 'Bucks', 'Warriors', NULL, NULL),
(17, 'Bulls', '76ers', NULL, NULL),
(17, 'Raptors', 'Celtics', NULL, NULL),
(17, 'heat', 'Hornets', NULL, NULL),
(18, 'Bucks', 'Bulls', NULL, NULL),
(18, 'Raptors', 'Warriors', NULL, NULL),
(18, 'heat', '76ers', NULL, NULL),
(18, 'Hornets', 'Celtics', NULL, NULL),
(19, 'Bucks', 'Raptors', NULL, NULL),
(19, 'heat', 'Bulls', NULL, NULL),
(19, 'Hornets', 'Warriors', NULL, NULL),
(19, 'Celtics', '76ers', NULL, NULL),
(20, 'Bucks', 'heat', NULL, NULL),
(20, 'Hornets', 'Raptors', NULL, NULL),
(20, 'Celtics', 'Bulls', NULL, NULL),
(20, '76ers', 'Warriors', NULL, NULL),
(21, 'Bucks', 'Hornets', NULL, NULL),
(21, 'Celtics', 'heat', NULL, NULL),
(21, '76ers', 'Raptors', NULL, NULL),
(21, 'Warriors', 'Bulls', NULL, NULL),
(22, 'Bucks', 'Celtics', NULL, NULL),
(22, '76ers', 'Hornets', NULL, NULL),
(22, 'Warriors', 'heat', NULL, NULL),
(22, 'Bulls', 'Raptors', NULL, NULL);

-- --------------------------------------------------------
--
-- Contenu de la table `Team`
--
INSERT INTO `Team` (`name`, `tournament_id`, `nb_visit`, `path_logo`) VALUES
('Nantes', 1, 0, '../Images/1557955466.jpg'),
('Bordeaux', 1, 0, '../Images/1557955478.jpg'),
('Marseille', 1, 0, '../Images/1557955488.jpg'),
('Lille', 1, 0, '../Images/1557955497.jpg'),
('Lyon', 1, 0, '../Images/1557955597.jpg'),
('Monaco', 1, 0, '../Images/1557955611.jpg'),
('Montpellier', 1, 0, '../Images/1557955628.jpg'),
('Paris', 1, 0, '../Images/1557955640.jpg'),
('Toulouse', 1, 0, '../Images/1557955689.jpg'),
('Saint-Etienne', 1, 0, '../Images/1557955742.jpg'),
('CarlJR', 2, 0, '../Images/1557955992.png'),
('Bren', 2, 0, '../Images/1557956011.png'),
('PA', 2, 0, '../Images/1557956031.png'),
('wingo', 2, 0, '../Images/1557956067.png'),
('Nyco', 2, 0, '../Images/1557956080.png'),
('Papou', 2, 0, '../Images/1557956104.png'),
('Pac', 2, 0, '../Images/1557956129.png'),
('Bucks', 3, 0, '../Images/1557956440.png'),
('Warriors', 3, 0, '../Images/1557956476.png'),
('Bulls', 3, 0, '../Images/1557956521.jpg'),
('Raptors', 3, 0, '../Images/1557956562.png'),
('76ers', 3, 0, '../Images/1557956597.png'),
('Celtics', 3, 0, '../Images/1557956654.png'),
('Hornets', 3, 0, '../Images/1557956746.jpg'),
('heat', 3, 0, '../Images/1557956782.jpg');

-- --------------------------------------------------------
--
-- Contenu de la table `Tournament`
--
INSERT INTO `Tournament` (`name`, `nb_team`) VALUES
('Ligue 1', 10),
('TMCUP-2019', 7),
('Nba', 8);