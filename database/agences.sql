-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 juin 2025 à 17:35
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
-- Base de données : `agences`
--

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `id_agence` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `adress` varchar(100) NOT NULL,
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
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id_agence`, `nom`, `adress`, `logo`, `password`, `ville`, `numerotel`, `Horaired`, `Horairef`, `facebook`, `instagrame`, `linkedin`, `twiter`) VALUES
(1, 'fouad', 'bekkalifouad2@gmail.com', 'imgclient/logos/img_6858260c61e07.jpg', '123456', 'tanger', 664078018, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/'),
(2, 'test', 'bekkalifouad4@gmail.com', 'imgclient/logos/img_6858277e6815e.jpg', '123456', 'tanger', 664078018, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/'),
(4, 'hamza', 'sidifouadbekkali@gmail.com', 'imgclient/logos/img_6858f3f74a9ff.jfif', '123789', 'tanger', 634288921, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/'),
(5, 'hamid', 'hamidarj63@gmail.com', 'imgclient/logos/img_68596441b161f.jfif', '1234567', 'tanger', 776833341, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/', 'https://www.instagram.com/direct/inbox/');

-- --------------------------------------------------------

--
-- Structure de la table `article_location`
--

CREATE TABLE `article_location` (
  `id_article_location` int(11) NOT NULL,
  `categorie` enum('économique','moyenne','luxe') NOT NULL DEFAULT 'économique',
  `marque` varchar(100) NOT NULL,
  `type_marque` varchar(100) NOT NULL,
  `modele` int(11) NOT NULL,
  `couleur` varchar(30) NOT NULL,
  `carburant` enum('Essence','Diesel','Hybride','Électrique') NOT NULL,
  `type_boite` enum('Manuele','Automatique') NOT NULL,
  `kilometrage` int(11) NOT NULL,
  `nombre_place` int(11) NOT NULL,
  `nombre_porte` int(11) NOT NULL,
  `matricule` varchar(100) NOT NULL,
  `info_supplimentaire` varchar(255) DEFAULT NULL,
  `statut` enum('disponible','indisponible','reserve') NOT NULL DEFAULT 'disponible',
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `prix_location` decimal(10,2) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `id_agence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article_location`
--

INSERT INTO `article_location` (`id_article_location`, `categorie`, `marque`, `type_marque`, `modele`, `couleur`, `carburant`, `type_boite`, `kilometrage`, `nombre_place`, `nombre_porte`, `matricule`, `info_supplimentaire`, `statut`, `date_debut`, `date_fin`, `prix_location`, `date_creation`, `id_agence`) VALUES
(2, 'moyenne', 'Renault', '209', 2022, 'rouge', 'Essence', '', 45555, 5, 4, '40/b/5656', 'climatisation,gps,usb', 'disponible', '2025-06-26', '2025-06-26', 300.00, '2025-06-22 18:01:16', 1),
(3, 'moyenne', 'Dacia', '208', 2024, 'noir', 'Essence', '', 455122, 4, 4, '40/b/5656', 'gps,camera_recul', 'disponible', '2025-06-24', '2025-06-24', 665.00, '2025-06-22 19:40:07', 1),
(4, 'économique', 'Dacia', '208', 2025, 'bleu', 'Essence', '', 454545, 5, 4, '5454545454', 'climatisation,gps', 'disponible', '2025-06-24', '2025-06-24', 250.00, '2025-06-23 01:44:32', 1),
(5, 'moyenne', 'Dacia', '208', 2024, 'bleu', 'Diesel', '', 444444, 5, 4, 'Hhh / kk/ddv', 'climatisation,camera_recul,toit_ouvrant', 'disponible', '2025-06-25', '2025-06-25', 600.00, '2025-06-23 01:45:32', 1),
(6, 'économique', 'Peugeot', '208', 2022, 'bleu', 'Hybride', '', 55555, 5, 4, 'Hhh / kk/ddv', 'climatisation,gps,camera_recul,usb', 'disponible', '2025-07-04', '2025-07-04', 622.00, '2025-06-23 01:46:42', 1),
(9, 'moyenne', 'Dacia', 'cloio', 155, 'noir', 'Diesel', 'Automatique', 595452, 4, 4, 'Hhh / kk/ddv', 'climatisation,camera_recul', 'disponible', '2025-06-24', '2025-06-27', 300.00, '2025-06-23 15:35:04', 5);

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id_image` int(11) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `id_article_location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id_image`, `chemin`, `id_article_location`) VALUES
(19, 'uploads/agence_1/img_6858ab477f5c6.jpeg', 2),
(20, 'uploads/agence_1/img_6858ab478025b.jpeg', 2),
(21, 'uploads/agence_1/img_6858ab47810b2.jpeg', 2),
(22, 'uploads/agence_1/img_6858ab6211661.jpeg', 3),
(23, 'uploads/agence_1/img_6858ab621260d.jpeg', 3),
(24, 'uploads/agence_1/img_6858ab62131be.jpeg', 3),
(25, 'uploads/agence_1/img_6858ab7bd1156.jpeg', 4),
(26, 'uploads/agence_1/img_6858ab7bd1db6.jpeg', 4),
(27, 'uploads/agence_1/img_6858ab7bd2950.jpeg', 4),
(28, 'uploads/agence_1/img_6858ab9a16ab6.jpeg', 5),
(29, 'uploads/agence_1/img_6858abb1e9cb2.jpeg', 6),
(30, 'uploads/agence_1/img_6858abb1ead1d.jpeg', 6),
(31, 'uploads/agence_1/img_6858abb1ebd57.jpeg', 6),
(32, 'uploads/agence_5/img_68596619297b9.jpeg', 9),
(33, 'uploads/agence_5/img_685966192b08c.jpeg', 9);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`id_agence`),
  ADD UNIQUE KEY `adress` (`adress`);

--
-- Index pour la table `article_location`
--
ALTER TABLE `article_location`
  ADD PRIMARY KEY (`id_article_location`),
  ADD KEY `fk_agence_voiture` (`id_agence`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `fk_article_location` (`id_article_location`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `id_agence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `article_location`
--
ALTER TABLE `article_location`
  MODIFY `id_article_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article_location`
--
ALTER TABLE `article_location`
  ADD CONSTRAINT `fk_agence_voiture` FOREIGN KEY (`id_agence`) REFERENCES `agence` (`id_agence`) ON DELETE CASCADE;

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_article_location` FOREIGN KEY (`id_article_location`) REFERENCES `article_location` (`id_article_location`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
