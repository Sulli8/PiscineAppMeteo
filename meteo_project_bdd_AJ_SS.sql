-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 15 oct. 2021 à 13:18
-- Version du serveur : 5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Weatherdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `City`
--

CREATE TABLE `City` (
  `idCity` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `City`
--

INSERT INTO `City` (`idCity`, `name`) VALUES
(38, 'truc'),
(39, 'lisbonne'),
(40, 'paris'),
(41, 'lyon'),
(42, 'bordeaux'),
(43, 'nantes');

-- --------------------------------------------------------

--
-- Structure de la table `favourite`
--

CREATE TABLE `favourite` (
  `id` int(11) NOT NULL,
  `User_idUser` int(11) NOT NULL,
  `City_idCity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Historical`
--

CREATE TABLE `Historical` (
  `idHistorical` int(11) NOT NULL,
  `Time` datetime DEFAULT NULL,
  `City_idCity` int(11) NOT NULL,
  `Weather_idWeather` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Historical`
--

INSERT INTO `Historical` (`idHistorical`, `Time`, `City_idCity`, `Weather_idWeather`, `idUser`) VALUES
(63, '2021-10-15 12:03:00', 43, 31, 5);

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `idUser` int(11) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `passwd` varchar(70) NOT NULL,
  `SessionId` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`idUser`, `last_name`, `first_name`, `mail`, `passwd`, `SessionId`) VALUES
(5, 'SEXTIUS', 'Sullivan', 's.sextius@gmail.com', 'dYZ/rZ3jLEKxwhxyvBDXpz5LycQTvI3s/Yg=', '0'),
(7, 'sextius', 'sullivan', 's.sextius@lprs.fr', '53ojS3n9QG/ACB4VM+AfP83S+z/Gw/AWXIdm', '0');

-- --------------------------------------------------------

--
-- Structure de la table `Weather`
--

CREATE TABLE `Weather` (
  `idWeather` int(11) NOT NULL,
  `tmp` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `humidity` varchar(45) NOT NULL,
  `time_zone` varchar(45) NOT NULL,
  `latitude` varchar(45) NOT NULL,
  `longitude` varchar(45) NOT NULL,
  `speed_wind` float NOT NULL,
  `deg_wind` int(11) NOT NULL,
  `City_idCity` int(11) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Weather`
--

INSERT INTO `Weather` (`idWeather`, `tmp`, `description`, `humidity`, `time_zone`, `latitude`, `longitude`, `speed_wind`, `deg_wind`, `City_idCity`, `icon`) VALUES
(26, '3.47', 'ciel dégagé', '90', '7200', '45.8517', '5.6701', 1.27, 62, 38, '01n'),
(27, '17.68', 'ciel dégagé', '47', '3600', '38.7167', '-9.1333', 0, 0, 39, '01n'),
(28, '6.92', 'ciel dégagé', '92', '7200', '48.8534', '2.3488', 0.51, 0, 40, '01n'),
(29, '0.79', 'ciel dégagé', '93', '7200', '45.75', '4.5833', 0.86, 195, 41, '01n'),
(30, '7.31', 'ciel dégagé', '93', '7200', '44.8404', '-0.5805', 1.54, 120, 42, '01n'),
(31, '5.96', 'couvert', '93', '7200', '47.1667', '-1.5833', 0, 0, 43, '04d');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `City`
--
ALTER TABLE `City`
  ADD PRIMARY KEY (`idCity`);

--
-- Index pour la table `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_User_has_City_City1_idx` (`City_idCity`),
  ADD KEY `fk_User_has_City_User1_idx` (`User_idUser`);

--
-- Index pour la table `Historical`
--
ALTER TABLE `Historical`
  ADD PRIMARY KEY (`idHistorical`,`City_idCity`,`Weather_idWeather`),
  ADD KEY `fk_Historical_City1_idx` (`City_idCity`),
  ADD KEY `fk_Historical_Weather1_idx` (`Weather_idWeather`),
  ADD KEY `fk_User_Historical1` (`idUser`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`idUser`);

--
-- Index pour la table `Weather`
--
ALTER TABLE `Weather`
  ADD PRIMARY KEY (`idWeather`,`City_idCity`),
  ADD KEY `fk_Weather_City1_idx` (`City_idCity`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `City`
--
ALTER TABLE `City`
  MODIFY `idCity` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `favourite`
--
ALTER TABLE `favourite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `Historical`
--
ALTER TABLE `Historical`
  MODIFY `idHistorical` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `Weather`
--
ALTER TABLE `Weather`
  MODIFY `idWeather` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `favourite`
--
ALTER TABLE `favourite`
  ADD CONSTRAINT `fk_User_has_City_City1` FOREIGN KEY (`City_idCity`) REFERENCES `City` (`idCity`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_has_City_User1` FOREIGN KEY (`User_idUser`) REFERENCES `User` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Historical`
--
ALTER TABLE `Historical`
  ADD CONSTRAINT `fk_Historical_City1` FOREIGN KEY (`City_idCity`) REFERENCES `City` (`idCity`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Historical_Weather1` FOREIGN KEY (`Weather_idWeather`) REFERENCES `Weather` (`idWeather`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_Historical1` FOREIGN KEY (`idUser`) REFERENCES `User` (`idUser`);

--
-- Contraintes pour la table `Weather`
--
ALTER TABLE `Weather`
  ADD CONSTRAINT `fk_Weather_City1` FOREIGN KEY (`City_idCity`) REFERENCES `City` (`idCity`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
