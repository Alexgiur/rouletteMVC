CREATE DATABASE IF NOT EXISTS roulette_cybersecu CHARACTER SET utf8 COLLATE utf8_general_ci;

USE roulette_cybersecu;

DROP TABLE IF EXISTS `roulette_partie`;
DROP TABLE IF EXISTS `roulette_joueur`;

CREATE TABLE `roulette_joueur` (
  `identifiant` int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `argent` int(11) NOT NULL
);

CREATE TABLE `roulette_partie` (
  `identifiant` int(50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `joueur` int(50) NOT NULL,
  `date` datetime NOT NULL,
  `mise` int(50) NOT NULL,
  `gain` int(50) NOT NULL,
  FOREIGN KEY (joueur) REFERENCES roulette_joueur(identifiant)
);

INSERT INTO roulette_joueur VALUES (null, "login", "password", 500);