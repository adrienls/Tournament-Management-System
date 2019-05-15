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

INSERT INTO `Admin` (`id`, `username`, `password`) VALUES
(3, 'admin', '$2y$10$VfEiSbv/Ja9ZRzSOlHCAn.2tnUa2uIRuPbERHSKsIpAq06ctW7HWi');

-- --------------------------------------------------------
--
-- Contenu de la table `Day`
--

INSERT INTO `Day` (`id`, `tournament_id`, `day_number`, `done`) VALUES
(262, 22, 1, 1),
(263, 22, 2, 1),
(264, 22, 3, 1),
(265, 22, 4, 1),
(266, 22, 5, 1),
(267, 22, 6, 1),
(268, 22, 7, 1),
(269, 22, 8, 1),
(270, 22, 9, 1),
(271, 23, 1, 1),
(272, 23, 2, 1),
(273, 23, 3, 1),
(274, 23, 4, 0),
(275, 23, 5, 0),
(276, 23, 6, 0),
(277, 23, 7, 0),
(278, 24, 1, 0),
(279, 24, 2, 0),
(280, 24, 3, 0),
(281, 24, 4, 0),
(282, 24, 5, 0),
(283, 24, 6, 0),
(284, 24, 7, 0);

-- --------------------------------------------------------
--
-- Contenu de la table `Planning`
--

INSERT INTO `Planning` (`id`, `day_id`, `teamA_name`, `teamB_name`, `teamA_nbGoal`, `teamB_nbGoal`) VALUES
(487, 262, 'Nantes', 'Monaco', 4, 1),
(488, 262, 'Bordeaux', 'Montpellier', 3, 1),
(489, 262, 'Marseille', 'Paris', 1, 0),
(490, 262, 'Lille', 'Toulouse', 0, 7),
(491, 262, 'Lyon', 'Saint-Etienne', 2, 0),
(492, 263, 'Nantes', 'Bordeaux', 7, 0),
(493, 263, 'Marseille', 'Monaco', 4, 2),
(494, 263, 'Lille', 'Montpellier', 8, 2),
(495, 263, 'Lyon', 'Paris', 3, 0),
(496, 263, 'Saint-Etienne', 'Toulouse', 1, 0),
(497, 264, 'Nantes', 'Marseille', 3, 2),
(498, 264, 'Lille', 'Bordeaux', 1, 1),
(499, 264, 'Lyon', 'Monaco', 1, 3),
(500, 264, 'Saint-Etienne', 'Montpellier', 1, 6),
(501, 264, 'Toulouse', 'Paris', 3, 0),
(502, 265, 'Nantes', 'Lille', 6, 2),
(503, 265, 'Lyon', 'Marseille', 1, 1),
(504, 265, 'Saint-Etienne', 'Bordeaux', 1, 3),
(505, 265, 'Toulouse', 'Monaco', 0, 3),
(506, 265, 'Paris', 'Montpellier', 5, 1),
(507, 266, 'Nantes', 'Lyon', 2, 0),
(508, 266, 'Saint-Etienne', 'Lille', 4, 3),
(509, 266, 'Toulouse', 'Marseille', 2, 1),
(510, 266, 'Paris', 'Bordeaux', 2, 4),
(511, 266, 'Montpellier', 'Monaco', 2, 1),
(512, 267, 'Nantes', 'Saint-Etienne', 2, 3),
(513, 267, 'Toulouse', 'Lyon', 2, 0),
(514, 267, 'Paris', 'Lille', 3, 1),
(515, 267, 'Montpellier', 'Marseille', 1, 2),
(516, 267, 'Monaco', 'Bordeaux', 2, 4),
(517, 268, 'Nantes', 'Toulouse', 2, 3),
(518, 268, 'Paris', 'Saint-Etienne', 4, 0),
(519, 268, 'Montpellier', 'Lyon', 6, 7),
(520, 268, 'Monaco', 'Lille', 3, 0),
(521, 268, 'Bordeaux', 'Marseille', 2, 0),
(522, 269, 'Nantes', 'Paris', 2, 2),
(523, 269, 'Montpellier', 'Toulouse', 1, 4),
(524, 269, 'Monaco', 'Saint-Etienne', 2, 2),
(525, 269, 'Bordeaux', 'Lyon', 2, 1),
(526, 269, 'Marseille', 'Lille', 0, 3),
(527, 270, 'Nantes', 'Montpellier', 2, 3),
(528, 270, 'Monaco', 'Paris', 0, 4),
(529, 270, 'Bordeaux', 'Toulouse', 3, 1),
(530, 270, 'Marseille', 'Saint-Etienne', 2, 0),
(531, 270, 'Lille', 'Lyon', 0, 1),
(532, 271, 'CarlJR', 'Nyco', 2, 0),
(533, 271, 'Bren', 'Papou', 0, 3),
(534, 271, 'PA', 'Pac', 8, 1),
(535, 271, 'wingo', 'exempt', NULL, NULL),
(536, 272, 'CarlJR', 'Bren', 5, 1),
(537, 272, 'PA', 'Nyco', 1, 2),
(538, 272, 'wingo', 'Papou', 1, 5),
(539, 272, 'exempt', 'Pac', NULL, NULL),
(540, 273, 'CarlJR', 'PA', 3, 6),
(541, 273, 'wingo', 'Bren', 6, 6),
(542, 273, 'exempt', 'Nyco', NULL, NULL),
(543, 273, 'Pac', 'Papou', 1, 3),
(544, 274, 'CarlJR', 'wingo', NULL, NULL),
(545, 274, 'exempt', 'PA', NULL, NULL),
(546, 274, 'Pac', 'Bren', NULL, NULL),
(547, 274, 'Papou', 'Nyco', NULL, NULL),
(548, 275, 'CarlJR', 'exempt', NULL, NULL),
(549, 275, 'Pac', 'wingo', NULL, NULL),
(550, 275, 'Papou', 'PA', NULL, NULL),
(551, 275, 'Nyco', 'Bren', NULL, NULL),
(552, 276, 'CarlJR', 'Pac', NULL, NULL),
(553, 276, 'Papou', 'exempt', NULL, NULL),
(554, 276, 'Nyco', 'wingo', NULL, NULL),
(555, 276, 'Bren', 'PA', NULL, NULL),
(556, 277, 'CarlJR', 'Papou', NULL, NULL),
(557, 277, 'Nyco', 'Pac', NULL, NULL),
(558, 277, 'Bren', 'exempt', NULL, NULL),
(559, 277, 'PA', 'wingo', NULL, NULL),
(560, 278, 'Bucks', '76ers', NULL, NULL),
(561, 278, 'Warriors', 'Celtics', NULL, NULL),
(562, 278, 'Bulls', 'Hornets', NULL, NULL),
(563, 278, 'Raptors', 'heat', NULL, NULL),
(564, 279, 'Bucks', 'Warriors', NULL, NULL),
(565, 279, 'Bulls', '76ers', NULL, NULL),
(566, 279, 'Raptors', 'Celtics', NULL, NULL),
(567, 279, 'heat', 'Hornets', NULL, NULL),
(568, 280, 'Bucks', 'Bulls', NULL, NULL),
(569, 280, 'Raptors', 'Warriors', NULL, NULL),
(570, 280, 'heat', '76ers', NULL, NULL),
(571, 280, 'Hornets', 'Celtics', NULL, NULL),
(572, 281, 'Bucks', 'Raptors', NULL, NULL),
(573, 281, 'heat', 'Bulls', NULL, NULL),
(574, 281, 'Hornets', 'Warriors', NULL, NULL),
(575, 281, 'Celtics', '76ers', NULL, NULL),
(576, 282, 'Bucks', 'heat', NULL, NULL),
(577, 282, 'Hornets', 'Raptors', NULL, NULL),
(578, 282, 'Celtics', 'Bulls', NULL, NULL),
(579, 282, '76ers', 'Warriors', NULL, NULL),
(580, 283, 'Bucks', 'Hornets', NULL, NULL),
(581, 283, 'Celtics', 'heat', NULL, NULL),
(582, 283, '76ers', 'Raptors', NULL, NULL),
(583, 283, 'Warriors', 'Bulls', NULL, NULL),
(584, 284, 'Bucks', 'Celtics', NULL, NULL),
(585, 284, '76ers', 'Hornets', NULL, NULL),
(586, 284, 'Warriors', 'heat', NULL, NULL),
(587, 284, 'Bulls', 'Raptors', NULL, NULL);

-- --------------------------------------------------------
--
-- Contenu de la table `Team`
--

INSERT INTO `Team` (`id`, `name`, `tournament_id`, `nb_visit`, `path_logo`) VALUES
(66, 'Nantes', 22, 0, '../Images/1557955466.jpg'),
(67, 'Bordeaux', 22, 0, '../Images/1557955478.jpg'),
(68, 'Marseille', 22, 0, '../Images/1557955488.jpg'),
(69, 'Lille', 22, 0, '../Images/1557955497.jpg'),
(71, 'Lyon', 22, 0, '../Images/1557955597.jpg'),
(72, 'Monaco', 22, 0, '../Images/1557955611.jpg'),
(73, 'Montpellier', 22, 0, '../Images/1557955628.jpg'),
(74, 'Paris', 22, 0, '../Images/1557955640.jpg'),
(75, 'Toulouse', 22, 0, '../Images/1557955689.jpg'),
(76, 'Saint-Etienne', 22, 0, '../Images/1557955742.jpg'),
(77, 'CarlJR', 23, 0, '../Images/1557955992.png'),
(78, 'Bren', 23, 0, '../Images/1557956011.png'),
(79, 'PA', 23, 0, '../Images/1557956031.png'),
(80, 'wingo', 23, 0, '../Images/1557956067.png'),
(81, 'Nyco', 23, 0, '../Images/1557956080.png'),
(82, 'Papou', 23, 0, '../Images/1557956104.png'),
(83, 'Pac', 23, 0, '../Images/1557956129.png'),
(84, 'Bucks', 24, 0, '../Images/1557956440.png'),
(85, 'Warriors', 24, 0, '../Images/1557956476.png'),
(86, 'Bulls', 24, 0, '../Images/1557956521.jpg'),
(87, 'Raptors', 24, 0, '../Images/1557956562.png'),
(88, '76ers', 24, 0, '../Images/1557956597.png'),
(89, 'Celtics', 24, 0, '../Images/1557956654.png'),
(90, 'Hornets', 24, 0, '../Images/1557956746.jpg'),
(91, 'heat', 24, 0, '../Images/1557956782.jpg');

-- --------------------------------------------------------
--
-- Contenu de la table `Tournament`
--

INSERT INTO `Tournament` (`id`, `name`, `nb_team`) VALUES
(22, 'Ligue 1', 10),
(23, 'TMCUP-2019', 7),
(24, 'Nba', 8);