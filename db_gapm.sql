-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 21 fév. 2023 à 09:42
-- Version du serveur :  10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `prj-prism-vchreti`
--

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

DROP TABLE IF EXISTS `Commentaire`;
CREATE TABLE `Commentaire`
(
    `idCommentaire` int(11) NOT NULL,
    `description`   varchar(280) NOT NULL,
    `note`          float        NOT NULL,
    `idRdv`         int(11) NOT NULL,
    `idDemandeur`   int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Commentaire`
--

INSERT INTO `Commentaire` (`idCommentaire`, `description`, `note`, `idRdv`, `idDemandeur`)
VALUES (1, 'Le médecin était très à l\'écoute et a pris le temps de m\'expliquer les différentes options de traitement',
        4.5, 1, 1),
       (2, 'Le rendez-vous a été très rapide, le médecin n\'a pas pris le temps de répondre à mes questions', 2, 2, 1),
       (3, 'Le médecin était très compétent et a résolu mon problème de santé en un rien de temps', 5, 3, 2),
       (5, 'L\'attente était un peu longue, mais le médecin était très professionnel et compétent', 3.5, 3, 5);

-- --------------------------------------------------------n

--
-- Structure de la table `Demandeur`
--

DROP TABLE IF EXISTS `Demandeur`;
CREATE TABLE `Demandeur`
(
    `idDemandeur`   int(11) NOT NULL,
    `email`         varchar(50) NOT NULL,
    `login`         varchar(50) NOT NULL,
    `motDePasse`    varchar(50) NOT NULL,
    `nom`           varchar(50) NOT NULL,
    `prenom`        varchar(50) NOT NULL,
    `dateNaissance` date        NOT NULL,
    `adresse`       varchar(50) NOT NULL,
    `telephone`     varchar(50) NOT NULL,
    `sexe`          varchar(1)  NOT NULL,
    `idVille`       int(11) NOT NULL,
    `type`          varchar(50) DEFAULT 'demandeur'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Demandeur`
--

INSERT INTO `Demandeur` (`idDemandeur`, `email`, `login`, `motDePasse`, `nom`, `prenom`, `dateNaissance`, `adresse`,
                         `telephone`, `sexe`, `idVille`, `type`)
VALUES (1, 'john.doe@example.com', 'john.doe', 'seA/6v3hNAL1.', 'Doe', 'John', '1990-01-01', '123 rue Principale',
        '555-5555', 'M', 1, 'intervenant'),
       (2, 'jane.doe@example.com', 'jane.doe', 'seA/6v3hNAL1.', 'Doe', 'Jane', '1995-05-05', '456 rue Secondaire',
        '555-5555', 'F', 2, 'intervenant'),
       (3, 'bob.smith@example.com', 'bob.smith', 'seA/6v3hNAL1.', 'Smith', 'Bob', '1985-02-10', '789 rue Tertiaire',
        '555-5555', 'M', 1, 'demandeur'),
       (4, 'alice.white@example.com', 'alice.white', 'seA/6v3hNAL1.', 'White', 'Alice', '1999-12-25',
        '1011 rue Quaternaire', '555-5555', 'F', 3, 'demandeur'),
       (5, 'jack.black@example.com', 'jack.black', 'seA/6v3hNAL1.', 'Black', 'Jack', '1978-06-30', '1213 rue Cinquième',
        '555-5555', 'M', 2, 'intervenant'),
       (6, 'fred@fred', 'fred.fred', 'seA/6v3hNAL1.', 'Dabadie', 'Frédéric', '2002-04-21', '12 rue tire barbe',
        '0123456789', 'F', 8, 'intervenant');
-- --------------------------------------------------------

--
-- Structure de la table `Emet`
--

DROP TABLE IF EXISTS `Emet`;
CREATE TABLE `Emet`
(
    `idIntervenant` int(11) NOT NULL,
    `idNoteFrais`   int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Emet`
--

INSERT INTO `Emet` (`idIntervenant`, `idNoteFrais`)
VALUES (1, 1),
       (2, 2),
       (5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `Empechement`
--

DROP TABLE IF EXISTS `Empechement`;
CREATE TABLE `Empechement`
(
    `idEmpechement` int(11) NOT NULL,
    `dateDebut`     date NOT NULL,
    `dateFin`       date NOT NULL,
    `idIntervenant` int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Empechement`
--

INSERT INTO `Empechement` (`idEmpechement`, `dateDebut`, `dateFin`, `idIntervenant`)
VALUES (1, '2022-01-01', '2022-01-05', 1),
       (2, '2022-02-01', '2022-02-05', 2),
       (3, '2022-03-01', '2022-03-05', 5);

-- --------------------------------------------------------

--
-- Structure de la table `Emprunt`
--

DROP TABLE IF EXISTS `Emprunt`;
CREATE TABLE `Emprunt`
(
    `idEmprunt`        int(11) NOT NULL,
    `dateFin`          date NOT NULL,
    `dateDebut`        date NOT NULL,
    `idIntervenant`    int(11) NOT NULL,
    `idAdministration` int(11) DEFAULT NULL,
    `idVoiture`        int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Emprunt`
--

INSERT INTO `Emprunt` (`idEmprunt`, `dateFin`, `dateDebut`, `idIntervenant`, `idAdministration`, `idVoiture`)
VALUES (1, '2022-06-10', '2022-06-01', 1, 2, 1),
       (2, '2022-07-15', '2022-07-01', 2, 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Exercer`
--

DROP TABLE IF EXISTS `Exercer`;
CREATE TABLE `Exercer`
(
    `idIntervenant` int(11) NOT NULL,
    `idVille`       int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Exercer`
--

INSERT INTO `Exercer` (`idIntervenant`, `idVille`)
VALUES (1, 1),
       (2, 2),
       (5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `FichePaie`
--

DROP TABLE IF EXISTS `FichePaie`;
CREATE TABLE `FichePaie`
(
    `idFichePaie`      int(11) NOT NULL,
    `URL`              varchar(280) NOT NULL,
    `idIntervenant`    int(11) NOT NULL,
    `idAdministration` int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Exercer`
--

INSERT INTO `FichePaie` (`idFichePaie`, `URL`, `idIntervenant`, `idAdministration`)
VALUES (1, 'https://example.com/fichepaie1.pdf', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Intervenant`
--

DROP TABLE IF EXISTS `Intervenant`;
CREATE TABLE `Intervenant`
(
    `idDemandeur` int(11) NOT NULL,
    `adressePro`  varchar(255) DEFAULT NULL,
    `idVillePro`  int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;



--
-- Déchargement des données de la table `Intervenant`
--

INSERT INTO `Intervenant` (`idDemandeur`, `adressePro`, `idVillePro`)
VALUES (1, '100 rue des Intervenants', 26),
       (2, '200 rue des Experts', 874),
       (5, '500 chemin des Professionnels', 852),
       (6, '500 chemin des Professionnels', 2569);

-- --------------------------------------------------------

--
-- Structure de la table `NoteFrais`
--

DROP TABLE IF EXISTS `NoteFrais`;
CREATE TABLE `NoteFrais`
(
    `idNoteFrais`      int(11) NOT NULL,
    `dateNote`         date         NOT NULL,
    `description`      varchar(280) NOT NULL,
    `urlJustificatif`  varchar(280) NOT NULL,
    `montant`          float        NOT NULL,
    `status`           varchar(50)  NOT NULL,
    `idAdministration` int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `NoteFrais`
--

INSERT INTO `NoteFrais` (`idNoteFrais`, `dateNote`, `description`, `urlJustificatif`, `montant`, `status`,
                         `idAdministration`)
VALUES (1, '2022-01-01', 'Frais 1', 'justificatif1.pdf', 100, 'Valider', 1),
       (2, '2022-02-01', 'Frais 2', 'justificatif2.pdf', 200, 'Validation', 2),
       (3, '2022-03-01', 'Frais 3', 'justificatif3.pdf', 300, 'Annuler', 3);

-- --------------------------------------------------------


--
-- Structure de la table `idAdministration`
--

DROP TABLE IF EXISTS `Administration`;
CREATE TABLE `Administration`
(
    `idAdministration` int(11) NOT NULL,
    `nom`              varchar(50) NOT NULL,
    `prenom`           varchar(50) NOT NULL,
    `login`            varchar(50) NOT NULL,
    `motDePasse`       varchar(50) NOT NULL,
    `email`            varchar(50) NOT NULL,
    `isAdmin`          tinyint(1) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Administration`
--

INSERT INTO `Administration` (`idAdministration`, `nom`, `prenom`, `login`, `motDePasse`, `email`, `isAdmin`)
VALUES (1, 'Dupont', 'Anne', 'admin', 'seA/6v3hNAL1.', 'anne.dupont@example.com', 0),
       (2, 'Doe', 'John', 'jdoe', 'seA/6v3hNAL1.', 'john.doe@example.com', 0),
       (3, 'Smith', 'Jane', 'jsmith', 'seA/6v3hNAL1.', 'jane.smith@example.com', 0),
       (4, 'Brown', 'Robert', 'rbrown', 'seA/6v3hNAL1.', 'robert.brown@example.com', 0),
       (5, 'Martin', 'Marie', 'mmartin', 'seA/6v3hNAL1.', 'marie.martin@example.com', 0);

-- --------------------------------------------------------

--
-- Structure de la table `RDV`
--

DROP TABLE IF EXISTS `RDV`;
CREATE TABLE `RDV`
(
    `idRdv`         int(11) NOT NULL,
    `status`        varchar(50) NOT NULL,
    `dateRDV`       varchar(50) NOT NULL,
    `heureDebut`    varchar(50) NOT NULL,
    `heureFin`      varchar(50) NOT NULL,
    `idDemandeur`   int(11) NOT NULL,
    `idSpecialite`  int(11) NOT NULL,
    `idIntervenant` int(11) NOT NULL,
    `idCommentaire` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `RDV`
--

INSERT INTO `RDV` (`idRdv`, `status`, `dateRDV`, `heureDebut`, `heureFin`, `idDemandeur`, `idSpecialite`,
                   `idIntervenant`)
VALUES (1, 'confirme', '2023-02-01', '10:00', '11:00', 6, 1, 1),
       (2, 'effectue', '2023-02-02', '09:00', '10:00', 6, 2, 2),
       (3, 'annule', '2023-02-03', '08:00', '09:00', 6, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Realiser`
--

DROP TABLE IF EXISTS `Intervenant_Specialite`;
CREATE TABLE `Intervenant_Specialite`
(
    `idIntervenant` int(11) NOT NULL,
    `idSpecialite`  int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Realiser`
--

INSERT INTO Intervenant_Specialite (`idIntervenant`, `idSpecialite`)
VALUES (1, 1),
       (1, 3),
       (2, 5),
       (2, 9),
       (5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Specialite`
--

DROP TABLE IF EXISTS `Specialite`;
CREATE TABLE `Specialite`
(
    `idSpecialite` int(11) NOT NULL,
    `libelle`      varchar(50)  NOT NULL,
    `description`  varchar(280) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Specialite`
--

INSERT INTO `Specialite` (`idSpecialite`, `libelle`, `description`)
VALUES (1, 'Généraliste', 'Medecin généraliste'),
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
-- Structure de la table `TypeVoiture`
--

DROP TABLE IF EXISTS `TypeVoiture`;
CREATE TABLE `TypeVoiture`
(
    `idTypeVoiture` int(11) NOT NULL,
    `marque`        varchar(50) NOT NULL,
    `modele`        varchar(50) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `TypeVoiture`
--


INSERT INTO `TypeVoiture` (`idTypeVoiture`, `marque`, `modele`)
VALUES (1, 'Renault', 'Clio'),
       (2, 'Peugeot', '3008'),
       (3, 'Peugeot', '208'),
       (4, 'Renault', 'Mégane'),
       (5, 'Volkswagen', 'Tiguan');

-- --------------------------------------------------------

--
-- Déchargement des données de la table `Ville`
--


-- --------------------------------------------------------

--
-- Structure de la table `Voiture`
--

DROP TABLE IF EXISTS `Voiture`;
CREATE TABLE `Voiture`
(
    `idVoiture`       int(11) NOT NULL,
    `immatriculation` varchar(50) NOT NULL,
    `idTypeVoiture`   int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Voiture`
--

INSERT INTO `Voiture` (`idVoiture`, `immatriculation`, `idTypeVoiture`)
VALUES (1, 'EM-007-LX', 1),
       (2, 'AZ-452-SD', 2),
       (3, 'RT-918-CD', 3),
       (4, 'QD-885-AZ', 4),
       (5, 'WC-478-BN', 5),
        (6, 'WC-478-BN', 1);

--
-- Index pour les tables déchargées
--

-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
    ADD PRIMARY KEY (`idCommentaire`),
    ADD KEY `idRdv` (`idRdv`),
    ADD KEY `idDemandeur` (`idDemandeur`);

--
-- Index pour la table `Demandeur`
--
ALTER TABLE `Demandeur`
    ADD PRIMARY KEY (`idDemandeur`),
    ADD KEY `idVille` (`idVille`);

--
-- Index pour la table `Emet`
--
ALTER TABLE `Emet`
    ADD PRIMARY KEY (`idIntervenant`, `idNoteFrais`),
    ADD KEY `idNoteFrais` (`idNoteFrais`);

--
-- Index pour la table `Empechement`
--
ALTER TABLE `Empechement`
    ADD PRIMARY KEY (`idEmpechement`),
    ADD KEY `idIntervenant` (`idIntervenant`);

--
-- Index pour la table `Emprunt`
--
ALTER TABLE `Emprunt`
    ADD PRIMARY KEY (`idEmprunt`),
    ADD KEY `idIntervenant` (`idIntervenant`),
    ADD KEY `idAdministration` (`idAdministration`),
    ADD KEY `idVoiture` (`idVoiture`);

--
-- Index pour la table `Exercer`
--
ALTER TABLE `Exercer`
    ADD PRIMARY KEY (`idIntervenant`, `idVille`),
    ADD KEY `idVille` (`idVille`);

--
-- Index pour la table `FichePaie`
--
ALTER TABLE `FichePaie`
    ADD PRIMARY KEY (`idFichePaie`),
    ADD KEY `idIntervenant` (`idIntervenant`),
    ADD KEY `idAdministration` (`idAdministration`);

--
-- Index pour la table `Intervenant`
--
ALTER TABLE `Intervenant`
    ADD PRIMARY KEY (`idDemandeur`),
    ADD KEY `idVillePro` (`idVillePro`);

--
-- Index pour la table `NoteFrais`
--
ALTER TABLE `NoteFrais`
    ADD PRIMARY KEY (`idNoteFrais`),
    ADD KEY `idAdministration` (`idAdministration`);

--
-- Index pour la table `Administration`
--
ALTER TABLE `Administration`
    ADD PRIMARY KEY (`idAdministration`);

--
-- Index pour la table `RDV`
--
ALTER TABLE `RDV`
    ADD PRIMARY KEY (`idRdv`),
    ADD KEY `idDemandeur` (`idDemandeur`),
    ADD KEY `idSpecialite` (`idSpecialite`),
    ADD KEY `idIntervenant` (`idIntervenant`),
    ADD KEY `idCommentaire` (`idCommentaire`);

--
-- Index pour la table `Realiser`
--
ALTER TABLE `Intervenant_Specialite`
    ADD PRIMARY KEY (`idIntervenant`, `idSpecialite`),
    ADD KEY `idSpecialite` (`idSpecialite`);

--
-- Index pour la table `Specialite`
--
ALTER TABLE `Specialite`
    ADD PRIMARY KEY (`idSpecialite`);

--
-- Index pour la table `TypeVoiture`
--
ALTER TABLE `TypeVoiture`
    ADD PRIMARY KEY (`idTypeVoiture`);

--
-- Index pour la table `Ville`
--
ALTER TABLE `Ville`
    ADD PRIMARY KEY (`idVille`);
--
-- Index pour la table `Voiture`
--
ALTER TABLE `Voiture`
    ADD PRIMARY KEY (`idVoiture`),
    ADD KEY `idTypeVoiture` (`idTypeVoiture`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
    MODIFY `idCommentaire` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT pour la table `Demandeur`
--
ALTER TABLE `Demandeur`
    MODIFY `idDemandeur` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 7;


--
-- AUTO_INCREMENT pour la table `Empechement`
--
ALTER TABLE `Empechement`
    MODIFY `idEmpechement` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT pour la table `Emprunt`
--
ALTER TABLE `Emprunt`
    MODIFY `idEmprunt` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT pour la table `FichePaie`
--
ALTER TABLE `FichePaie`
    MODIFY `idFichePaie` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;


--
-- AUTO_INCREMENT pour la table `NoteFrais`
--
ALTER TABLE `NoteFrais`
    MODIFY `idNoteFrais` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT pour la table `Administration`
--
ALTER TABLE `Administration`
    MODIFY `idAdministration` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT pour la table `RDV`
--
ALTER TABLE `RDV`
    MODIFY `idRdv` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT pour la table `Specialite`
--
ALTER TABLE `Specialite`
    MODIFY `idSpecialite` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 23;

--
-- AUTO_INCREMENT pour la table `TypeVoiture`
--
ALTER TABLE `TypeVoiture`
    MODIFY `idTypeVoiture` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 21;

--
-- AUTO_INCREMENT pour la table `Ville`
--
ALTER TABLE `Ville`
    MODIFY `idVille` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 36209;
ALTER TABLE Ville
    ADD FULLTEXT(nom);
--
-- AUTO_INCREMENT pour la table `Voiture`
--
ALTER TABLE `Voiture`
    MODIFY `idVoiture` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
    ADD CONSTRAINT `Commentaire_ibfk_1` FOREIGN KEY (`idRdv`) REFERENCES `RDV` (`idRdv`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Commentaire_ibfk_2` FOREIGN KEY (`idDemandeur`) REFERENCES `Demandeur` (`idDemandeur`) ON
DELETE
CASCADE ON
UPDATE CASCADE;
--
-- Contraintes pour la table `Demandeur`
--
ALTER TABLE `Demandeur`
    ADD CONSTRAINT `Demandeur_ibfk_1` FOREIGN KEY (`idVille`) REFERENCES `Ville` (`idVille`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Emet`
--
ALTER TABLE `Emet`
    ADD CONSTRAINT `Emet_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Emet_ibfk_2` FOREIGN KEY (`idNoteFrais`) REFERENCES `NoteFrais` (`idNoteFrais`) ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Contraintes pour la table `Empechement`
--
ALTER TABLE `Empechement`
    ADD CONSTRAINT `Empechement_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Emprunt`
--
ALTER TABLE `Emprunt`
    ADD CONSTRAINT `Emprunt_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Emprunt_ibfk_2` FOREIGN KEY (`idAdministration`) REFERENCES `Administration` (`idAdministration`) ON
DELETE
CASCADE ON
UPDATE CASCADE,
    ADD CONSTRAINT `Emprunt_ibfk_3` FOREIGN KEY (`idVoiture`) REFERENCES `Voiture` (`idVoiture`)
ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Contraintes pour la table `Exercer`
--
ALTER TABLE `Exercer`
    ADD CONSTRAINT `Exercer_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Exercer_ibfk_2` FOREIGN KEY (`idVille`) REFERENCES `Ville` (`idVille`) ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Contraintes pour la table `FichePaie`
--
ALTER TABLE `FichePaie`
    ADD CONSTRAINT `FichePaie_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FichePaie_ibfk_2` FOREIGN KEY (`idAdministration`) REFERENCES `Administration` (`idAdministration`) ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Contraintes pour la table `Intervenant`
--
ALTER TABLE `Intervenant`
    ADD CONSTRAINT `Intervenant_ibfk_1` FOREIGN KEY (`idDemandeur`) REFERENCES `Demandeur` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Intervenant_ibfk_2` FOREIGN KEY (`idVillePro`) REFERENCES `Ville` (`idVille`) ON
DELETE
CASCADE ON
UPDATE CASCADE;


--
-- Contraintes pour la table `NoteFrais`
--
ALTER TABLE `NoteFrais`
    ADD CONSTRAINT `NoteFrais_ibfk_1` FOREIGN KEY (`idAdministration`) REFERENCES `Administration` (`idAdministration`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `RDV`
--
ALTER TABLE `RDV`
    ADD CONSTRAINT `RDV_ibfk_1` FOREIGN KEY (`idDemandeur`) REFERENCES `Demandeur` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `RDV_ibfk_2` FOREIGN KEY (`idSpecialite`) REFERENCES `Specialite` (`idSpecialite`) ON
DELETE
CASCADE ON
UPDATE CASCADE,
    ADD CONSTRAINT `RDV_ibfk_3` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`)
ON
DELETE
CASCADE ON
UPDATE CASCADE,
    ADD CONSTRAINT `RDV_ibfk_4` FOREIGN KEY (`idCommentaire`) REFERENCES `Commentaire` (`idCommentaire`)
ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Contraintes pour la table `Realiser`
--
ALTER TABLE `Intervenant_Specialite`
    ADD CONSTRAINT `Realiser_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Realiser_ibfk_2` FOREIGN KEY (`idSpecialite`) REFERENCES `Specialite` (`idSpecialite`) ON
DELETE
CASCADE ON
UPDATE CASCADE;

--
-- Contraintes pour la table `Voiture`
--
ALTER TABLE `Voiture`
    ADD CONSTRAINT `Voiture_ibfk_1` FOREIGN KEY (`idTypeVoiture`) REFERENCES `TypeVoiture` (`idTypeVoiture`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
