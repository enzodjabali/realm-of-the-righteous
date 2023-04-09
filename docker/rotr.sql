-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : dim. 09 avr. 2023 à 12:44
-- Version du serveur : 8.0.32
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rotr`
--

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `player_id` int NOT NULL,
  `map_id` int NOT NULL,
  `current_wave` int DEFAULT '1',
  `is_over` tinyint(1) DEFAULT '0',
  `is_won` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `name`, `player_id`, `map_id`, `current_wave`, `is_over`, `is_won`) VALUES
(2, 'My test game', 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `game_event`
--

CREATE TABLE `game_event` (
  `id` int NOT NULL,
  `game_id` int DEFAULT NULL,
  `player_id` int DEFAULT NULL,
  `event_type` varchar(50) DEFAULT NULL,
  `event_data` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maps`
--

CREATE TABLE `maps` (
  `id` int NOT NULL,
  `name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `matrix` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `maps`
--

INSERT INTO `maps` (`id`, `name`, `matrix`) VALUES
(1, 'Example Map', '[[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,2,2,2,2,2,2,2],[2,1,1,1,1,1,1,1,1,2],[2,2,2,2,2,2,2,2,1,2],[2,1,1,1,1,1,1,1,1,2],[2,1,2,2,2,2,2,2,2,2],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0]]');

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `player`
--

INSERT INTO `player` (`id`, `username`, `password`, `email`) VALUES
(1, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test@test.dev'),
(2, 'test2', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test2@dev.dev'),
(3, 'test3', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test3@dev.fr'),
(4, 'test4', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'test4@dev.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `game_event`
--
ALTER TABLE `game_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Index pour la table `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `player`
--
ALTER TABLE `player`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
