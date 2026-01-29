-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 14 juin 2025 à 22:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reda`
--

-- --------------------------------------------------------

--
-- Structure de la table `agencform`
--
CREATE TABLE `agencform` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `adress` varchar(20) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `ville` varchar(40) NOT NULL,
  `numerotel` int(11) NOT NULL,
  `Horaired` datetime DEFAULT NULL,
  `Horairef` datetime DEFAULT NULL,
  `facebook` varchar(70) DEFAULT NULL,
  `instagrame` varchar(70) DEFAULT NULL,
  `linkedin` varchar(70) DEFAULT NULL,
  `twiter` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agencform`
--

INSERT INTO `agencform` (`id`, `nom`, `adress`, `logo`, `password`, `ville`, `numerotel`, `Horaired`, `Horairef`, `facebook`, `instagrame`, `linkedin`, `twiter`) VALUES
(1, 'fouad', 'bekkalifouad268@gmai', 'imgclient/logos/Screenshot 2024-11-25 234205.png', 'bnimakada9dima', 'tanger', 664078018, '2025-05-25 07:39:00', '2025-05-25 02:39:00', 'https://www.youtube.com/watch?v=IzxG_fZmxuU&list=PLxbVBWjVdAEjom8KOV1c', 'https://www.youtube.com/watch?v=IzxG_fZmxuU&list=PLxbVBWjVdAEjom8KOV1c', 'https://www.youtube.com/watch?v=IzxG_fZmxuU&list=PLxbVBWjVdAEjom8KOV1c', 'https://www.youtube.com/watch?v=IzxG_fZmxuU&list=PLxbVBWjVdAEjom8KOV1c');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agencform`
--
ALTER TABLE `agencform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adress` (`adress`),
  ADD UNIQUE KEY `numerotel` (`numerotel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agencform`
--
ALTER TABLE `agencform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
