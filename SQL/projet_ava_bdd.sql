-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 mai 2024 à 13:24
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_ava_bdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `authentification`
--

DROP TABLE IF EXISTS `authentification`;
CREATE TABLE IF NOT EXISTS `authentification` (
  `id_mot_passe` int NOT NULL AUTO_INCREMENT,
  `mot_passe` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id_mot_passe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE IF NOT EXISTS `cv` (
  `id_cv` varchar(25) NOT NULL,
  `pdf` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

DROP TABLE IF EXISTS `offre`;
CREATE TABLE IF NOT EXISTS `offre` (
  `id_offre` int NOT NULL AUTO_INCREMENT,
  `id_secteur` int NOT NULL,
  `nom_poste` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id_offre`),
  KEY `id_secteur` (`id_secteur`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `offre`
--

INSERT INTO `offre` (`id_offre`, `id_secteur`, `nom_poste`) VALUES
(1, 2, NULL),
(2, 1, NULL),
(3, 1, NULL),
(4, 3, NULL),
(5, 3, NULL),
(6, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `postulant`
--

DROP TABLE IF EXISTS `postulant`;
CREATE TABLE IF NOT EXISTS `postulant` (
  `id_postulant` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(42) DEFAULT NULL,
  `prenom` varchar(42) DEFAULT NULL,
  `telephone` varchar(42) DEFAULT NULL,
  `email` varchar(42) DEFAULT NULL,
  `id_cv` int NOT NULL,
  PRIMARY KEY (`id_postulant`),
  UNIQUE KEY `id_cv` (`id_cv`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `postulant`
--

INSERT INTO `postulant` (`id_postulant`, `nom`, `prenom`, `telephone`, `email`, `id_cv`) VALUES
(2, 'Angoulvant', 'Vincent', '0609675617', 'vincent.angoulvant@esme.fr', 2),
(1, 'Kamerer', 'Amaury', '0782452705', 'amaury.kamerer@esme.fr', 1),
(3, 'Foullous', 'Abderrahman', '0762729630', 'abderrahman.foullous@esme.fr', 3);

-- --------------------------------------------------------

--
-- Structure de la table `postuler`
--

DROP TABLE IF EXISTS `postuler`;
CREATE TABLE IF NOT EXISTS `postuler` (
  `id_postulant` int NOT NULL AUTO_INCREMENT,
  `id_offre` int NOT NULL,
  PRIMARY KEY (`id_postulant`,`id_offre`),
  KEY `id_offre` (`id_offre`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `postuler`
--

INSERT INTO `postuler` (`id_postulant`, `id_offre`) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 1),
(4, 2),
(4, 3),
(5, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

DROP TABLE IF EXISTS `secteur`;
CREATE TABLE IF NOT EXISTS `secteur` (
  `id_secteur` int NOT NULL AUTO_INCREMENT,
  `nom_secteur` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id_secteur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `secteur`
--

INSERT INTO `secteur` (`id_secteur`, `nom_secteur`) VALUES
(1, 'cybersécurité'),
(2, 'centre_de_contact'),
(3, 'lab_recherche');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(42) DEFAULT NULL,
  `droits` varchar(42) DEFAULT NULL,
  `id_mot_passe` int NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_mot_passe` (`id_mot_passe`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `username`, `droits`, `id_mot_passe`) VALUES
(1, 'kamaury', 'super_admin', 1),
(2, 'avincent', 'normal', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
