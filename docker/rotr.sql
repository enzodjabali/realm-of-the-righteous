-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: May 10, 2023 at 09:38 AM
-- Server version: 8.0.32
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rotr`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `player_id` int NOT NULL,
  `map_id` int NOT NULL,
  `difficulty` int NOT NULL DEFAULT '1',
  `matrix` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `current_wave` int DEFAULT '1',
  `is_over` tinyint(1) DEFAULT '0',
  `is_won` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `name`, `player_id`, `map_id`, `difficulty`, `matrix`, `current_wave`, `is_over`, `is_won`) VALUES
(1, 'My test game', 1, 1, 1, '[[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeast\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"southwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordernorth\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"northeastcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"northwestcorner\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[{\"id\":0,\"max_life\":10,\"curent_life\":10,\"armor\":0,\"position\":{\"x\":18,\"y\":5},\"path_img\":\"../../assets/images/mobs/batvol.gif\",\"path\":[[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[1,0],[1,0],[1,0],[0,-1],[0,-1],[1,0],[1,0],[1,0],[0,1],[0,1],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[0,-1],[0,-1],[0,-1],[-1,0],[-1,0],[-1,0],[-1,0],[0,-1],[0,-1],[0,-1],[1,0],[1,0],[1,0],[1,0],[1,0]],\"typeOfEnemies\":\"bat\",\"step\":0,\"speed\":20}],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}],[{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"borderwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"basepath\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordereast\",\"enemies\":[],\"tower\":null},{\"tile\":\"southwest\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"bordersouth\",\"enemies\":[],\"tower\":null},{\"tile\":\"southeast\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null},{\"tile\":\"basegrass\",\"enemies\":[],\"tower\":null}]]', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `game_event`
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
-- Table structure for table `maps`
--

CREATE TABLE `maps` (
  `id` int NOT NULL,
  `name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `matrix` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `maps`
--

INSERT INTO `maps` (`id`, `name`, `matrix`) VALUES
(1, 'Example Map', '[[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,2,2,2,2,2,2,2],[2,1,1,1,1,1,1,1,1,2],[2,2,2,2,2,2,2,2,1,2],[2,1,1,1,1,1,1,1,1,2],[2,1,2,2,2,2,2,2,2,2],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0],[2,1,2,0,0,0,0,0,0,0]]');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `username`, `password`, `email`) VALUES
(1, 'test', '$2y$10$wJr6X64xIQ.CRJ9NneBmfuvzPhc6Ped4/7rGzq8yS40gGfd2XhkNC', 'test@test.dev');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_event`
--
ALTER TABLE `game_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indexes for table `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
