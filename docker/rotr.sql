-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : sam. 10 juin 2023 à 21:40
-- Version du serveur : 8.0.33
-- Version de PHP : 8.1.19

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
-- Structure de la table `chat`
--

CREATE TABLE `chat` (
  `id` int NOT NULL,
  `player_id` int NOT NULL,
  `message` varchar(100) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `player_id` int NOT NULL,
  `map_id` int NOT NULL,
  `difficulty` int NOT NULL DEFAULT '1',
  `model` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `current_wave` int DEFAULT '1',
  `is_over` tinyint(1) DEFAULT '0',
  `is_won` tinyint(1) DEFAULT '0',
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `name`, `player_id`, `map_id`, `difficulty`, `model`, `current_wave`, `is_over`, `is_won`, `date`) VALUES
(1, 'My test game', 1, 1, 1, '{\n            \"matrice\": [[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"southwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[{\"id\":0,\"max_life\":10,\"curent_life\":10,\"armor\":0,\"position\":{\"x\":18,\"y\":5},\"path_img\":\"../../assets/images/mobs/batvol.gif\",\"path\":[[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[1,0],[1,0],[1,0],[0,-1],[0,-1],[1,0],[1,0],[1,0],[0,1],[0,1],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[0,-1],[0,-1],[0,-1],[-1,0],[-1,0],[-1,0],[-1,0],[0,-1],[0,-1],[0,-1],[1,0],[1,0],[1,0],[1,0],[1,0]],\"typeOfEnemies\":\"bat\",\"step\":0,\"speed\":20}],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}]],\n            \"waves\" : {\n                \"easy\" : [[[10,\"golem\"]]],\n                \"medium\" : [[[1,\"bat\"],[2,\"golem\"],[2,\"knight\"],[2,\"witch\"],[2,\"wolf\"]], [[2,\"bat\"],[4,\"golem\"],[4,\"knight\"],[4,\"witch\"],[4,\"wolf\"]]],\n                \"hard\" : [[[1,100],[0,110]]] },\n            \"timeBetweenWaves\" : 1000,\n            \"timeBetweenGroups\" : 500,\n            \"difficulty\" : \"easy\",\n            \"timeBeforeStart\" : 1000,\n            \"currentWave\" : 0,\n            \"currentGroup\" : 0,\n            \"mobId\" : 0,\n            \"towerId\" : 0,\n            \"towerWeaponId\" : 0,\n            \"entryPoints\" : [[19,5]],\n            \"endPoints\" : [[19,8]] }', 1, 0, 0, '2023-06-10');

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `xp` int NOT NULL DEFAULT '0',
  `last_activity` bigint NOT NULL DEFAULT '0',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `player`
--

INSERT INTO `player` (`id`, `username`, `password`, `email`, `xp`, `last_activity`, `is_verified`, `is_admin`) VALUES
(1, 'test', '$2y$10$jCoM/1zBhr/BnHW8u5temuqgesr0Vc0bLXMzyo.cBhFrB1uXZ3316', 'test@test.dev', 100, 1686433247, 1, 1),
(2, 'test2', '$2y$10$YKx.8E2SVlk4vF.3j20zTu3EeIuIk06yWZPbdIQkBmcMT940hMwmm', 'test2@test.dev', 10, 1686427934, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_link`
--

CREATE TABLE `reset_password_link` (
  `player_email` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `verification_link`
--

CREATE TABLE `verification_link` (
  `player_email` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id_constraint` (`player_id`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id_constraint2` (`player_id`);

--
-- Index pour la table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT pour la table `player`
--
ALTER TABLE `player`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `player_id_constraint` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `player_id_constraint2` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
