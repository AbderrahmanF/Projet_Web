-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 mai 2024 à 14:13
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `authentification`
--

INSERT INTO `authentification` (`id_mot_passe`, `mot_passe`) VALUES
(1, 'a.Foullous2024'),
(2, 'a.Kamerer2024'),
(3, 'v.Angoulvant2024');

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
-- Structure de la table `offres`
--

DROP TABLE IF EXISTS `offres`;
CREATE TABLE IF NOT EXISTS `offres` (
  `id_offre` int NOT NULL AUTO_INCREMENT,
  `id_secteur` int NOT NULL,
  `nom_poste` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id_offre`),
  KEY `id_secteur` (`id_secteur`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id_offre`, `id_secteur`, `nom_poste`) VALUES
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
-- Structure de la table `secteurs`
--

DROP TABLE IF EXISTS `secteurs`;
CREATE TABLE IF NOT EXISTS `secteurs` (
  `id_secteur` int NOT NULL AUTO_INCREMENT,
  `nom_secteur` varchar(42) DEFAULT NULL,
  PRIMARY KEY (`id_secteur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `secteurs`
--

INSERT INTO `secteurs` (`id_secteur`, `nom_secteur`) VALUES
(1, 'cybersécurité'),
(2, 'centre_de_contact'),
(3, 'lab_recherche');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(42) DEFAULT NULL,
  `droits` varchar(42) DEFAULT NULL,
  `id_mot_passe` int NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_mot_passe` (`id_mot_passe`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `username`, `droits`, `id_mot_passe`) VALUES
(1, 'abdelo', 'Admin', 1),
(2, 'amauKame', 'Admin', 2),
(3, 'vincenzo', 'Admin', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
