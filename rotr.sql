-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : jeu. 23 mars 2023 à 23:29
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
-- Structure de la table `game_state`
--

CREATE TABLE `game_state` (
  `id` int NOT NULL,
  `map_id` int DEFAULT NULL,
  `current_wave` int DEFAULT NULL,
  `game_over` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maps`
--

CREATE TABLE `maps` (
  `id` int NOT NULL,
  `map_name` varchar(50) DEFAULT NULL,
  `map_matrix` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `maps`
--

INSERT INTO `maps` (`id`, `map_name`, `map_matrix`) VALUES
(1, 'Example Map', '[[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,2,2,2,2,2,2,2],[2,1,1,1,1,1,1,1,1,2],[2,2,2,2,2,2,2,2,1,2],[2,1,1,1,1,1,1,1,1,2],[2,1,2,2,2,2,2,2,2,2],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0]]');

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `score` int DEFAULT NULL,
  `level` int DEFAULT NULL,
  `coins` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `game_event`
--
ALTER TABLE `game_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Index pour la table `game_state`
--
ALTER TABLE `game_state`
  ADD PRIMARY KEY (`id`),
  ADD KEY `map_id` (`map_id`);

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
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `game_event`
--
ALTER TABLE `game_event`
  ADD CONSTRAINT `game_event_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `game_state` (`id`),
  ADD CONSTRAINT `game_event_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`);

--
-- Contraintes pour la table `game_state`
--
ALTER TABLE `game_state`
  ADD CONSTRAINT `game_state_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `maps` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
