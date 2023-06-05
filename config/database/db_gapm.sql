-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 05 juin 2023 à 09:02
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gapm`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

DROP TABLE IF EXISTS `administration`;
CREATE TABLE IF NOT EXISTS `administration` (
  `idAdministration` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `motDePasse` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAdministration`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`idAdministration`, `nom`, `prenom`, `login`, `motDePasse`, `email`, `isAdmin`) VALUES
(1, 'Dupont', 'Anne', 'admin', 'seA/6v3hNAL1.', 'anne.dupont@example.com', 0),
(2, 'Doe', 'John', 'jdoe', 'seA/6v3hNAL1.', 'john.doe@example.com', 0),
(3, 'Smith', 'Jane', 'jsmith', 'seA/6v3hNAL1.', 'jane.smith@example.com', 0),
(4, 'Brown', 'Robert', 'rbrown', 'seA/6v3hNAL1.', 'robert.brown@example.com', 0),
(5, 'Martin', 'Marie', 'mmartin', 'seA/6v3hNAL1.', 'marie.martin@example.com', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `idCommentaire` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(280) NOT NULL,
  `note` float NOT NULL,
  `idRdv` int(11) NOT NULL,
  `idDemandeur` int(11) NOT NULL,
  PRIMARY KEY (`idCommentaire`),
  KEY `idRdv` (`idRdv`),
  KEY `idDemandeur` (`idDemandeur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`idCommentaire`, `description`, `note`, `idRdv`, `idDemandeur`) VALUES
(1, 'Le médecin était très à l\'écoute et a pris le temps de m\'expliquer les différentes options de traitement', 4.5, 1, 1),
(2, 'Le rendez-vous a été très rapide, le médecin n\'a pas pris le temps de répondre à mes questions', 2, 2, 1),
(3, 'Le médecin était très compétent et a résolu mon problème de santé en un rien de temps', 5, 3, 2),
(5, 'L\'attente était un peu longue, mais le médecin était très professionnel et compétent', 3.5, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `demandeur`
--

DROP TABLE IF EXISTS `demandeur`;
CREATE TABLE IF NOT EXISTS `demandeur` (
  `idDemandeur` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `motDePasse` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `dateNaissance` date NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `sexe` varchar(1) NOT NULL,
  `idVille` int(11) NOT NULL,
  `type` varchar(50) DEFAULT 'demandeur',
  PRIMARY KEY (`idDemandeur`),
  KEY `idVille` (`idVille`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `demandeur`
--

INSERT INTO `demandeur` (`idDemandeur`, `email`, `login`, `motDePasse`, `nom`, `prenom`, `dateNaissance`, `adresse`, `telephone`, `sexe`, `idVille`, `type`) VALUES
(1, 'john.doe@example.com', 'john.doe', 'seA/6v3hNAL1.', 'Doe', 'John', '1990-01-01', '123 rue Principale', '555-5555', 'M', 1, 'intervenant'),
(2, 'jane.doe@example.com', 'jane.doe', 'seA/6v3hNAL1.', 'Doe', 'Jane', '1995-05-05', '456 rue Secondaire', '555-5555', 'F', 2, 'intervenant'),
(3, 'bob.smith@example.com', 'bob.smith', 'seA/6v3hNAL1.', 'Smith', 'Bob', '1985-02-10', '789 rue Tertiaire', '555-5555', 'M', 1, 'demandeur'),
(4, 'alice.white@example.com', 'alice.white', 'seA/6v3hNAL1.', 'White', 'Alice', '1999-12-25', '1011 rue Quaternaire', '555-5555', 'F', 3, 'demandeur'),
(5, 'jack.black@example.com', 'jack.black', 'seA/6v3hNAL1.', 'Black', 'Jack', '1978-06-30', '1213 rue Cinquième', '555-5555', 'M', 2, 'intervenant'),
(6, 'fred@fred', 'fred.fred', 'seA/6v3hNAL1.', 'Dabadie', 'Frédéric', '2002-04-21', '12 rue tire barbe', '0123456789', 'F', 8, 'intervenant');

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

DROP TABLE IF EXISTS `depense`;
CREATE TABLE IF NOT EXISTS `depense` (
  `idDepense` int(11) NOT NULL AUTO_INCREMENT,
  `nature` varchar(50) NOT NULL,
  `datePaiement` date NOT NULL,
  `montant` float NOT NULL,
  `fournisseur` varchar(50) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'À traiter',
  `dateCreation` date NOT NULL,
  `urlJustificatif` varchar(255) DEFAULT NULL,
  `idIntervenant` int(11) NOT NULL,
  `idNoteFrais` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDepense`),
  KEY `idIntervenant` (`idIntervenant`),
  KEY `idNoteFrais` (`idNoteFrais`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `depense`
--

INSERT INTO `depense` (`idDepense`, `nature`, `datePaiement`, `montant`, `fournisseur`, `commentaire`, `status`, `dateCreation`, `urlJustificatif`, `idIntervenant`, `idNoteFrais`) VALUES
(1, 'Transport', '2022-01-01', 100, 'SNCF', 'Paris - Lyon', 'déclarer', '2022-01-01', 'public/uploads/intervenants/docs/1-1357013fc451a6b9f39c.jpg', 1, 1),
(2, 'Transport', '2022-02-01', 200, 'SNCF', 'Paris - Lyon', 'déclarer', '2022-02-01', NULL, 2, 2),
(3, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'À traiter', '2023-05-17', NULL, 6, NULL),
(4, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'À déclarer', '2023-05-18', 'public/uploads/intervenants/docs/6-86a7f91489b52336caf3.jpg', 6, NULL),
(5, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'À déclarer', '2022-03-01', 'public/uploads/intervenants/docs/6-0e948b7ba1132ea8f2f8.jpg', 6, NULL),
(6, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'déclarer', '2022-03-01', 'public/uploads/intervenants/docs/6-deace0847a24453a851b.jpg', 6, 3);

-- --------------------------------------------------------

--
-- Structure de la table `empechement`
--

DROP TABLE IF EXISTS `empechement`;
CREATE TABLE IF NOT EXISTS `empechement` (
  `idEmpechement` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `idIntervenant` int(11) NOT NULL,
  PRIMARY KEY (`idEmpechement`),
  KEY `idIntervenant` (`idIntervenant`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `empechement`
--

INSERT INTO `empechement` (`idEmpechement`, `dateDebut`, `dateFin`, `idIntervenant`) VALUES
(1, '2022-01-01', '2022-01-05', 1),
(2, '2022-02-01', '2022-02-05', 2),
(3, '2022-03-01', '2022-03-05', 5);

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

DROP TABLE IF EXISTS `emprunt`;
CREATE TABLE IF NOT EXISTS `emprunt` (
  `idEmprunt` int(11) NOT NULL AUTO_INCREMENT,
  `dateFin` date NOT NULL,
  `dateDebut` date NOT NULL,
  `idIntervenant` int(11) NOT NULL,
  `idAdministration` int(11) DEFAULT NULL,
  `idVoiture` int(11) NOT NULL,
  PRIMARY KEY (`idEmprunt`),
  KEY `idIntervenant` (`idIntervenant`),
  KEY `idAdministration` (`idAdministration`),
  KEY `idVoiture` (`idVoiture`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`idEmprunt`, `dateFin`, `dateDebut`, `idIntervenant`, `idAdministration`, `idVoiture`) VALUES
(1, '2022-06-10', '2022-06-01', 1, 2, 1),
(2, '2022-07-15', '2022-07-01', 2, 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `exercer`
--

DROP TABLE IF EXISTS `exercer`;
CREATE TABLE IF NOT EXISTS `exercer` (
  `idIntervenant` int(11) NOT NULL,
  `idVille` int(11) NOT NULL,
  PRIMARY KEY (`idIntervenant`,`idVille`),
  KEY `idVille` (`idVille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `exercer`
--

INSERT INTO `exercer` (`idIntervenant`, `idVille`) VALUES
(1, 1),
(2, 2),
(5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `fichepaie`
--

DROP TABLE IF EXISTS `fichepaie`;
CREATE TABLE IF NOT EXISTS `fichepaie` (
  `idFichePaie` int(11) NOT NULL AUTO_INCREMENT,
  `URL` varchar(280) NOT NULL,
  `idIntervenant` int(11) NOT NULL,
  `idAdministration` int(11) NOT NULL,
  PRIMARY KEY (`idFichePaie`),
  KEY `idIntervenant` (`idIntervenant`),
  KEY `idAdministration` (`idAdministration`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fichepaie`
--

INSERT INTO `fichepaie` (`idFichePaie`, `URL`, `idIntervenant`, `idAdministration`) VALUES
(1, 'https://example.com/fichepaie1.pdf', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

DROP TABLE IF EXISTS `intervenant`;
CREATE TABLE IF NOT EXISTS `intervenant` (
  `idDemandeur` int(11) NOT NULL,
  `adressePro` varchar(255) DEFAULT NULL,
  `imgUrl` varchar(255) DEFAULT 'public/img/default.jpg',
  `idVillePro` int(11) DEFAULT NULL,
  `demandeSupp` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idDemandeur`),
  KEY `idVillePro` (`idVillePro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `intervenant`
--

INSERT INTO `intervenant` (`idDemandeur`, `adressePro`, `imgUrl`, `idVillePro`, `demandeSupp`, `status`) VALUES
(1, '100 rue des Intervenants', 'public/img/default.jpg', 26, 0, 1),
(2, '200 rue des Experts', 'public/img/default.jpg', 87, 0, 1),
(5, '500 chemin des Professionnels', 'public/img/default.jpg', 85, 0, 1),
(6, '500 chemin des Professionnels', 'public/uploads/intervenants/imgs/6-dbd94cb6b271525ffa5d.jpeg', 256, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `intervenant_specialite`
--

DROP TABLE IF EXISTS `intervenant_specialite`;
CREATE TABLE IF NOT EXISTS `intervenant_specialite` (
  `idIntervenant` int(11) NOT NULL,
  `idSpecialite` int(11) NOT NULL,
  PRIMARY KEY (`idIntervenant`,`idSpecialite`),
  KEY `idSpecialite` (`idSpecialite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `intervenant_specialite`
--

INSERT INTO `intervenant_specialite` (`idIntervenant`, `idSpecialite`) VALUES
(1, 1),
(1, 3),
(6, 4),
(2, 5),
(5, 5),
(2, 9);

-- --------------------------------------------------------

--
-- Structure de la table `notefrais`
--

DROP TABLE IF EXISTS `notefrais`;
CREATE TABLE IF NOT EXISTS `notefrais` (
  `idNoteFrais` int(11) NOT NULL AUTO_INCREMENT,
  `dateNote` date NOT NULL,
  `status` varchar(50) DEFAULT 'En attente',
  `idIntervenant` int(11) NOT NULL,
  `idAdministration` int(11) DEFAULT NULL,
  PRIMARY KEY (`idNoteFrais`),
  KEY `idIntervenant` (`idIntervenant`),
  KEY `idAdministration` (`idAdministration`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `notefrais`
--

INSERT INTO `notefrais` (`idNoteFrais`, `dateNote`, `status`, `idIntervenant`, `idAdministration`) VALUES
(1, '2022-01-01', 'en attente', 1, NULL),
(2, '2022-02-01', 'en attente', 2, NULL),
(3, '2022-03-01', 'validée', 6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `idRdv` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  `dateRDV` varchar(50) NOT NULL,
  `heureDebut` varchar(50) NOT NULL,
  `heureFin` varchar(50) NOT NULL,
  `idDemandeur` int(11) NOT NULL,
  `idSpecialite` int(11) NOT NULL,
  `idIntervenant` int(11) NOT NULL,
  `idCommentaire` int(11) DEFAULT NULL,
  PRIMARY KEY (`idRdv`),
  KEY `idDemandeur` (`idDemandeur`),
  KEY `idSpecialite` (`idSpecialite`),
  KEY `idIntervenant` (`idIntervenant`),
  KEY `idCommentaire` (`idCommentaire`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`idRdv`, `status`, `dateRDV`, `heureDebut`, `heureFin`, `idDemandeur`, `idSpecialite`, `idIntervenant`, `idCommentaire`) VALUES
(1, 'confirme', '2023-02-01', '10:00', '11:00', 6, 1, 1, NULL),
(2, 'effectue', '2023-02-02', '09:00', '10:00', 6, 2, 2, NULL),
(3, 'annule', '2023-02-03', '08:00', '09:00', 6, 3, 5, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

DROP TABLE IF EXISTS `specialite`;
CREATE TABLE IF NOT EXISTS `specialite` (
  `idSpecialite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  `description` varchar(280) NOT NULL,
  PRIMARY KEY (`idSpecialite`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`idSpecialite`, `libelle`, `description`) VALUES
(1, 'Généraliste', 'Medecin généraliste'),
(2, 'Ophtalmologie', 'ophtalmologues'),
(3, 'Chirurgie', 'chirurgiens'),
(4, 'Cardiologie', 'cardiologues'),
(5, 'Gastro-entérologie', 'gastro-enterologue'),
(6, 'Pédiatrie ', 'pédiatres'),
(7, 'Pneumologie ', 'Pneumologues'),
(8, 'Psychiatrie ', 'Psychiatre'),
(9, 'Oncologie ', 'Oncologue'),
(10, 'Gériatrie ', 'Gériatrie'),
(11, 'Allergologie', 'Medecin allergologue');

-- --------------------------------------------------------

--
-- Structure de la table `typevoiture`
--

DROP TABLE IF EXISTS `typevoiture`;
CREATE TABLE IF NOT EXISTS `typevoiture` (
  `idTypeVoiture` int(11) NOT NULL AUTO_INCREMENT,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  PRIMARY KEY (`idTypeVoiture`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `typevoiture`
--

INSERT INTO `typevoiture` (`idTypeVoiture`, `marque`, `modele`) VALUES
(1, 'Renault', 'Clio'),
(2, 'Peugeot', '3008'),
(3, 'Peugeot', '208'),
(4, 'Renault', 'Mégane'),
(5, 'Volkswagen', 'Tiguan');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
CREATE TABLE IF NOT EXISTS `voiture` (
  `idVoiture` int(11) NOT NULL AUTO_INCREMENT,
  `immatriculation` varchar(50) NOT NULL,
  `idTypeVoiture` int(11) NOT NULL,
  PRIMARY KEY (`idVoiture`),
  KEY `idTypeVoiture` (`idTypeVoiture`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`idVoiture`, `immatriculation`, `idTypeVoiture`) VALUES
(1, 'EM-007-LX', 1),
(2, 'AZ-452-SD', 2),
(3, 'RT-918-CD', 3),
(4, 'QD-885-AZ', 4),
(5, 'WC-478-BN', 5),
(6, 'WC-478-BN', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `Commentaire_ibfk_1` FOREIGN KEY (`idRdv`) REFERENCES `rdv` (`idRdv`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Commentaire_ibfk_2` FOREIGN KEY (`idDemandeur`) REFERENCES `demandeur` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `demandeur`
--
ALTER TABLE `demandeur`
  ADD CONSTRAINT `Demandeur_ibfk_1` FOREIGN KEY (`idVille`) REFERENCES `ville` (`idVille`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `depense`
--
ALTER TABLE `depense`
  ADD CONSTRAINT `Depense_ibfk_1` FOREIGN KEY (`idNoteFrais`) REFERENCES `notefrais` (`idNoteFrais`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `empechement`
--
ALTER TABLE `empechement`
  ADD CONSTRAINT `Empechement_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `Emprunt_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Emprunt_ibfk_2` FOREIGN KEY (`idAdministration`) REFERENCES `administration` (`idAdministration`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Emprunt_ibfk_3` FOREIGN KEY (`idVoiture`) REFERENCES `voiture` (`idVoiture`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `exercer`
--
ALTER TABLE `exercer`
  ADD CONSTRAINT `Exercer_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Exercer_ibfk_2` FOREIGN KEY (`idVille`) REFERENCES `ville` (`idVille`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fichepaie`
--
ALTER TABLE `fichepaie`
  ADD CONSTRAINT `FichePaie_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FichePaie_ibfk_2` FOREIGN KEY (`idAdministration`) REFERENCES `administration` (`idAdministration`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `intervenant`
--
ALTER TABLE `intervenant`
  ADD CONSTRAINT `Intervenant_ibfk_1` FOREIGN KEY (`idDemandeur`) REFERENCES `demandeur` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Intervenant_ibfk_2` FOREIGN KEY (`idVillePro`) REFERENCES `ville` (`idVille`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `intervenant_specialite`
--
ALTER TABLE `intervenant_specialite`
  ADD CONSTRAINT `Realiser_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Realiser_ibfk_2` FOREIGN KEY (`idSpecialite`) REFERENCES `specialite` (`idSpecialite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notefrais`
--
ALTER TABLE `notefrais`
  ADD CONSTRAINT `NoteFrais_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `NoteFrais_ibfk_2` FOREIGN KEY (`idAdministration`) REFERENCES `administration` (`idAdministration`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `RDV_ibfk_1` FOREIGN KEY (`idDemandeur`) REFERENCES `demandeur` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RDV_ibfk_2` FOREIGN KEY (`idSpecialite`) REFERENCES `specialite` (`idSpecialite`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RDV_ibfk_3` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RDV_ibfk_4` FOREIGN KEY (`idCommentaire`) REFERENCES `commentaire` (`idCommentaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Index pour la table `Ville`
--
ALTER TABLE `Ville`
    ADD PRIMARY KEY (`idVille`);
--

--
-- AUTO_INCREMENT pour la table `Ville`
--
ALTER TABLE `Ville`
    MODIFY `idVille` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 36209;
ALTER TABLE Ville
    ADD FULLTEXT(nom);
--

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `Voiture_ibfk_1` FOREIGN KEY (`idTypeVoiture`) REFERENCES `typevoiture` (`idTypeVoiture`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
