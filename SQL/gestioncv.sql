-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 mai 2024 à 09:39
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
-- Base de données : `gestioncv`
--

-- --------------------------------------------------------

--
-- Structure de la table `authentification`
--

CREATE TABLE `authentification` (
  `Id_Mdp` int(11) NOT NULL,
  `Mdp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `authentification`
--

INSERT INTO `authentification` (`Id_Mdp`, `Mdp`) VALUES
(1, 'a.Foullous2024'),
(2, 'a.Kamerer2024'),
(3, 'v.Angoulvant2024');

-- --------------------------------------------------------

--
-- Structure de la table `cv`
--

CREATE TABLE `cv` (
  `ID_CV` int(11) NOT NULL,
  `PDF` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

CREATE TABLE `offres` (
  `Id_Offre` int(11) NOT NULL,
  `Nom_Offre` varchar(100) DEFAULT NULL,
  `Id_secteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `postulant`
--

CREATE TABLE `postulant` (
  `Id_Postulant` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Telephone` varchar(20) DEFAULT NULL,
  `Email` varchar(70) DEFAULT NULL,
  `Id_Cv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `postuler`
--

CREATE TABLE `postuler` (
  `Id_postulant` int(11) DEFAULT NULL,
  `Id_offre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `secteurs`
--

CREATE TABLE `secteurs` (
  `Id_Secteur` int(11) NOT NULL,
  `Nom_Secteur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `Id_User` int(11) NOT NULL,
  `Username` varchar(30) DEFAULT NULL,
  `Droits` varchar(50) DEFAULT NULL,
  `Id_MDP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`Id_User`, `Username`, `Droits`, `Id_MDP`) VALUES
(1, 'abdelo', 'Admin', 1),
(2, 'amauKame', 'Admin', 2),
(3, 'vincenzo', 'Admin', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `authentification`
--
ALTER TABLE `authentification`
  ADD PRIMARY KEY (`Id_Mdp`);

--
-- Index pour la table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`ID_CV`);

--
-- Index pour la table `offres`
--
ALTER TABLE `offres`
  ADD PRIMARY KEY (`Id_Offre`),
  ADD KEY `Id_secteur` (`Id_secteur`);

--
-- Index pour la table `postulant`
--
ALTER TABLE `postulant`
  ADD PRIMARY KEY (`Id_Postulant`),
  ADD KEY `Id_Cv` (`Id_Cv`);

--
-- Index pour la table `postuler`
--
ALTER TABLE `postuler`
  ADD KEY `Id_postulant` (`Id_postulant`),
  ADD KEY `Id_offre` (`Id_offre`);

--
-- Index pour la table `secteurs`
--
ALTER TABLE `secteurs`
  ADD PRIMARY KEY (`Id_Secteur`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`Id_User`),
  ADD KEY `Id_MDP` (`Id_MDP`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `authentification`
--
ALTER TABLE `authentification`
  MODIFY `Id_Mdp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cv`
--
ALTER TABLE `cv`
  MODIFY `ID_CV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `offres`
--
ALTER TABLE `offres`
  MODIFY `Id_Offre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `postulant`
--
ALTER TABLE `postulant`
  MODIFY `Id_Postulant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `secteurs`
--
ALTER TABLE `secteurs`
  MODIFY `Id_Secteur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `offres`
--
ALTER TABLE `offres`
  ADD CONSTRAINT `offres_ibfk_1` FOREIGN KEY (`Id_secteur`) REFERENCES `secteurs` (`Id_Secteur`);

--
-- Contraintes pour la table `postulant`
--
ALTER TABLE `postulant`
  ADD CONSTRAINT `postulant_ibfk_1` FOREIGN KEY (`Id_Cv`) REFERENCES `cv` (`ID_CV`);

--
-- Contraintes pour la table `postuler`
--
ALTER TABLE `postuler`
  ADD CONSTRAINT `postuler_ibfk_1` FOREIGN KEY (`Id_postulant`) REFERENCES `postulant` (`Id_Postulant`),
  ADD CONSTRAINT `postuler_ibfk_2` FOREIGN KEY (`Id_offre`) REFERENCES `offres` (`Id_Offre`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`Id_MDP`) REFERENCES `authentification` (`Id_Mdp`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
