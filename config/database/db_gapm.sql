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
-- Base de données : `gapm`
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
VALUES (1, 'Très bon rendez-vous, le médecin était compétent et attentif.', 4.5, 1, 1),
       (2, 'Le rendez-vous s''est bien passé, le médecin a répondu à toutes mes questions.', 4.0, 2, 2),
       (3, 'Le médecin était professionnel et le rendez-vous s''est déroulé sans problème.', 4.2, 3, 3),
       (4, 'J''ai été satisfait du rendez-vous, le médecin a pris le temps de m''écouter.', 4.3, 6, 6),
       (5, 'Le rendez-vous s''est bien passé, le médecin était aimable et compétent.', 4.4, 7, 7),
       (6, 'Très bon rendez-vous, le médecin a été attentif à mes préoccupations.', 4.5, 9, 9),
       (7, 'Le rendez-vous s''est bien déroulé, le médecin a répondu à toutes mes questions.', 4.0, 10, 10),
       (8, 'Le rendez-vous était satisfaisant, le médecin a été à l''écoute de mes symptômes.', 4.2, 11, 1),
       (9, 'J''ai été satisfait du rendez-vous, le médecin a pris le temps de m''expliquer.', 4.3, 13, 3),
       (10, 'Le rendez-vous s''est bien déroulé, le médecin a été professionnel.', 4.0, 14, 4),
       (11, 'Très bon rendez-vous, le médecin a été attentif à mes besoins.', 4.5, 15, 5),
       (12, 'Le rendez-vous s''est bien passé, le médecin était compétent.', 4.4, 17, 7),
       (13, 'Le médecin était professionnel et le rendez-vous s''est déroulé sans problème.', 4.2, 18, 8),
       (14, 'J''ai été satisfait du rendez-vous, le médecin a pris le temps de m''écouter.', 4.3, 20, 10),
       (15, 'Le rendez-vous s''est bien passé, le médecin était aimable et compétent.', 4.4, 21, 1),
       (16, 'Très bon rendez-vous, le médecin a été attentif à mes préoccupations.', 4.5, 23, 3),
       (17, 'Le rendez-vous s''est bien déroulé, le médecin a répondu à toutes mes questions.', 4.0, 24, 4),
       (18, 'Le rendez-vous était satisfaisant, le médecin a été à l''écoute de mes symptômes.', 4.2, 26, 6),
       (19, 'J''ai été satisfait du rendez-vous, le médecin a pris le temps de m''expliquer.', 4.3, 27, 7),
       (20, 'Le rendez-vous s''est bien déroulé, le médecin a été professionnel.', 4.0, 28, 8),
       (21, 'Très bon rendez-vous, le médecin a été attentif à mes besoins.', 4.5, 30, 10),
       (22, 'Le rendez-vous s''est bien passé, le médecin était compétent.', 4.4, 31, 1),
       (23, 'Le médecin était professionnel et le rendez-vous s''est déroulé sans problème.', 4.2, 33, 3),
       (24, 'J''ai été satisfait du rendez-vous, le médecin a pris le temps de m''écouter.', 4.3, 34, 4),
       (25, 'Le rendez-vous s''est bien passé, le médecin était aimable et compétent.', 4.4, 36, 6),
       (26, 'Très bon rendez-vous, le médecin a été attentif à mes préoccupations.', 4.5, 37, 7),
       (27, 'Le rendez-vous s''est bien déroulé, le médecin a répondu à toutes mes questions.', 4.0, 38, 8),
       (28, 'Le rendez-vous était satisfaisant, le médecin a été à l''écoute de mes symptômes.', 4.2, 40, 10),
       (29, 'J''ai été satisfait du rendez-vous, le médecin a pris le temps de m''expliquer.', 4.3, 41, 1),
       (30, 'L''intervention s''est très bien passée, le médecin a été à l''écoute de mes symptômes.', 4, 76, 26);



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
        '0105040708', 'M', 1, 'demandeur'),
       (2, 'jane.doe@example.com', 'jane.doe', 'seA/6v3hNAL1.', 'Doe', 'Jane', '1995-05-05', '456 rue Secondaire',
        '555-5555', 'F', 2, 'demandeur'),
       (3, 'bob.smith@example.com', 'bob.smith', 'seA/6v3hNAL1.', 'Smith', 'Bob', '1985-02-10', '789 rue Tertiaire',
        '555-5555', 'M', 1, 'demandeur'),
       (4, 'alice.white@example.com', 'alice.white', 'seA/6v3hNAL1.', 'White', 'Alice', '1999-12-25',
        '1011 rue Quaternaire', '555-5555', 'F', 3, 'demandeur'),
       (5, 'frederic.dupont@u-sa.com', 'frederic.dupont', 'seA/6v3hNAL1.', 'Fréderic', 'Dupont', '1978-06-30',
        '1213 rue Cinquième', '0504090806', 'M', 2, 'intervenant'),
       (6, 'stephanie.leroux@u-sa.com', 'stephanie.leroux', 'seA/6v3hNAL1.', 'Stéphanie', 'Leroux', '1985-09-12',
        '45 avenue Principale', '0612345678', 'F', 1, 'intervenant'),
       (7, 'alexandre.martin@u-sa.com', 'alexandre.martin', 'seA/6v3hNAL1.', 'Alexandre', 'Martin', '1990-03-22',
        '17 rue des Lilas', '0702030405', 'M', 3, 'intervenant'),
       (8, 'sophie.dubois@u-sa.com', 'sophie.dubois', 'seA/6v3hNAL1.', 'Sophie', 'Dubois', '1982-07-16',
        '9 chemin de la Colline', '0765432109', 'F', 2, 'intervenant'),
       (9, 'nicolas.robert@u-sa.com', 'nicolas.robert', 'seA/6v3hNAL1.', 'Nicolas', 'Robert', '1987-12-09',
        '23 boulevard Central', '0601020304', 'M', 1, 'intervenant'),
       (10, 'sandrine.leclerc@u-sa.com', 'sandrine.leclerc', 'seA/6v3hNAL1.', 'Sandrine', 'Leclerc', '1995-04-18',
        '8 rue de l''Église', '0678901234', 'F', 3, 'intervenant'),
       (11, 'jean.dupuis@u-sa.com', 'jean.dupuis', 'seA/6v3hNAL1.', 'Jean', 'Dupuis', '1980-08-25', '12 avenue du Parc',
        '0622334455', 'M', 2, 'intervenant'),
       (12, 'marie.dumas@u-sa.com', 'marie.dumas', 'seA/6v3hNAL1.', 'Marie', 'Dumas', '1993-01-03', '5 rue des Roses',
        '0712345678', 'F', 1, 'intervenant'),
       (13, 'antoine.leroy@u-sa.com', 'antoine.leroy', 'seA/6v3hNAL1.', 'Antoine', 'Leroy', '1989-05-15',
        '19 avenue des Champs', '0798765432', 'M', 3, 'intervenant'),
       (14, 'laura.martin@u-sa.com', 'laura.martin', 'seA/6v3hNAL1.', 'Laura', 'Martin', '1991-11-27',
        '14 rue de la Fontaine', '0687654321', 'F', 2, 'intervenant'),
       (15, 'thomas.girard@u-sa.com', 'thomas.girard', 'seA/6v3hNAL1.', 'Thomas', 'Girard', '1984-02-08',
        '7 chemin des Peupliers', '0755512345', 'M', 1, 'intervenant'),
       (16, 'celine.moreau@u-sa.com', 'celine.moreau', 'seA/6v3hNAL1.', 'Céline', 'Moreau', '1996-06-19',
        '30 avenue Victor Hugo', '0632109876', 'F', 3, 'intervenant'),
       (17, 'pierre.dupont@u-sa.com', 'pierre.dupont', 'seA/6v3hNAL1.', 'Pierre', 'Dupont', '1983-10-05',
        '11 rue Saint-Michel', '0765432109', 'M', 2, 'intervenant'),
       (18, 'isabelle.rousseau@u-sa.com', 'isabelle.rousseau', 'seA/6v3hNAL1.', 'Isabelle', 'Rousseau', '1992-02-14',
        '25 boulevard des Fleurs', '0623456789', 'F', 1, 'intervenant'),
       (19, 'christophe.martin@u-sa.com', 'christophe.martin', 'seA/6v3hNAL1.', 'Christophe', 'Martin', '1986-06-27',
        '13 rue de la Paix', '0708091011', 'M', 3, 'intervenant'),
       (20, 'emilie.lefevre@u-sa.com', 'emilie.lefevre', 'seA/6v3hNAL1.', 'Émilie', 'Lefèvre', '1994-12-08',
        '6 avenue du Soleil', '0601020304', 'F', 2, 'intervenant'),
       (21, 'michel.dubois@dm.com', 'michel.dubois', 'seA/6v3hNAL1.', 'Michel', 'Dubois', '1982-09-14',
        '10 rue Principale', '0654321098', 'M', 1, 'demandeur'),
       (22, 'sophie.martin@dm.com', 'sophie.martin', 'seA/6v3hNAL1.', 'Sophie', 'Martin', '1990-05-22',
        '5 avenue des Roses', '0765432109', 'F', 2, 'demandeur'),
       (23, 'jean.dupont@dm.com', 'jean.dupont', 'seA/6v3hNAL1.', 'Jean', 'Dupont', '1975-12-01', '8 rue du Commerce',
        '0612345678', 'M', 3, 'demandeur'),
       (24, 'marie.dumas@dm.com', 'marie.dumas', 'seA/6v3hNAL1.', 'Marie', 'Dumas', '1988-03-18',
        '15 boulevard Central', '0708091011', 'F', 1, 'demandeur'),
       (25, 'thomas.girard@dm.com', 'thomas.girard', 'seA/6v3hNAL1.', 'Thomas', 'Girard', '1993-07-09',
        '12 avenue des Lilas', '0755554444', 'M', 2, 'demandeur'),
       (26, 'philipe.clairon@exemple.fr', 'philipe.clairon', 'seA/6v3hNAL1.', 'Philipe', 'Clairon', '1992-09-23',
        '20 rue des libraires', '0766664444', 'M', 35801, 'demandeur'),
       (27, 'maurice.lefebre@exemple.fr', 'maurice.lefebre', 'seA/6v3hNAL1.', 'Maurice', 'Lefebre', '1970-02-15',
        '24 rue de la tourte', '0766665555', 'M', 35801, 'intervenant');

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
    `heureDebut`    time DEFAULT '00:00:00',
    `heureFin`      time DEFAULT '00:00:00',
    `idIntervenant` int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Empechement`
--

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
VALUES (1, '2023-06-10', '2023-06-15', 10, null, 1),
       (2, '2023-06-15', '2023-06-21', 8, null, 3),
       (3, '2023-06-20', '2023-06-25', 12, null, 2),
       (4, '2023-06-30', '2023-06-31', 9, null, 4),
       (5, '2023-06-25', '2023-06-27', 11, null, 1);



-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table `Intervenant`
--

DROP TABLE IF EXISTS `Intervenant`;
CREATE TABLE `Intervenant`
(
    `idDemandeur`   int(11) NOT NULL,
    `adressePro`    varchar(255) DEFAULT NULL,
    `imgUrl`        varchar(255) DEFAULT 'public/img/default.jpg',
    `idVillePro`    int(11) DEFAULT NULL,
    `travailSamedi` tinyint(1) DEFAULT 0,
    `demandeSupp`   tinyint(1) DEFAULT 0,
    `application`   varchar(255) DEFAULT 'waiting'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;


--
-- Déchargement des données de la table `Intervenant`
--

INSERT INTO `Intervenant` (`idDemandeur`, `adressePro`, `imgUrl`, `idVillePro`, `travailSamedi`, `demandeSupp`,
                           `application`)
VALUES (5, '100 rue des Intervenants', 'public/uploads/intervenants/imgs/6-dbd94cb6b271525ffa5d.jpeg', 26, 0, 0,
        'passed'),
       (6, '45 avenue du Commerce', 'public/uploads/intervenants/imgs/6-ea8e77eac1743c2c834f.jpeg', 18, 0, 0, 'passed'),
       (7, '72 boulevard des Artisans', 'public/uploads/intervenants/imgs/7-65450f711369b958ee44.jpeg', 9, 0, 0,
        'passed'),
       (8, '29 rue des Experts', 'public/uploads/intervenants/imgs/8-5508773a374b909eae8f.jpeg', 33, 0, 0, 'passed'),
       (9, '53 avenue des Spécialistes', 'public/uploads/intervenants/imgs/9-9e491fed649282e5a04c.jpeg', 14, 0, 0,
        'passed'),
       (10, '88 rue de l''Industrie', 'public/uploads/intervenants/imgs/10-df871b1ce4d82b4e0e81.jpeg', 27, 0, 0,
        'passed'),
       (11, '21 boulevard des Consultants', 'public/uploads/intervenants/imgs/11-ff540dac550069d720e9.jpeg', 10, 0, 0,
        'passed'),
       (12, '36 avenue des Ingénieurs', 'public/uploads/intervenants/imgs/12-a27aa5f5b988857e0550.jpeg', 21, 0, 0,
        'passed'),
       (13, '64 rue des Techniciens', 'public/uploads/intervenants/imgs/13-666b4e2ff8fa957c14eb.jpeg', 12, 0, 0,
        'passed'),
       (14, '97 boulevard des Experts', 'public/uploads/intervenants/imgs/14-975a5703d46c5b5b822a.jpeg', 31, 0, 0,
        'passed'),
       (15, '14 avenue du Savoir', 'public/uploads/intervenants/imgs/15-b1d4fa2d7b616fdee35d.jpeg', 16, 0, 1, 'passed'),
       (16, '39 rue des Spécialistes', 'public/uploads/intervenants/imgs/16-7fd972715789e9467b8a.jpeg', 25, 0, 0,
        'passed'),
       (17, '77 boulevard des Consultants', 'public/uploads/intervenants/imgs/17-be6b0c7f58ddc126c4db.jpeg', 17, 0, 0,
        'passed'),
       (18, '22 avenue des Ingénieurs', 'public/uploads/intervenants/imgs/18-131d84e673384b291f5d.jpeg', 28, 0, 0,
        'passed'),
       (19, '55 rue de l''Industrie', 'public/uploads/intervenants/imgs/19-83cfc336c53e26aec69c.jpeg', 8, 0, 0,
        'passed'),
       (20, '69 avenue de la République', 'public/uploads/intervenants/imgs/20-00c86fb8566e12286ea5.jpeg', 150, 1, 0,
        'passed'),
       (27, '50 avenue du chou', 'public/img/default.jpg', 35801, 0, 0,
        'passed');


-- --------------------------------------------------------

--
-- Structure de la table `NoteFrais`
--

DROP TABLE IF EXISTS `NoteFrais`;
CREATE TABLE `NoteFrais`
(
    `idNoteFrais`      int(11) NOT NULL,
    `dateNote`         date NOT NULL,
    `status`           varchar(50)  DEFAULT 'En attente',
    `idIntervenant`    int(11) NOT NULL,
    `idAdministration` int(11) DEFAULT NULL,
    `message`          varchar(255) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `NoteFrais`
--

-- Liste des status possibles : en attente, validée, refusée , payée

INSERT INTO `NoteFrais` (`idNoteFrais`, `dateNote`, `status`, `idIntervenant`, `idAdministration`, `message`)
VALUES (4, '2023-06-12', 'en attente', 14, NULL, NULL),
       (5, '2023-06-12', 'en attente', 15, NULL, NULL),
       (6, '2023-06-12', 'en attente', 16, NULL, NULL),
       (7, '2023-06-12', 'Refusée', 17, 5, 'Note de frais refusée par Marie Martin. Motif : Refusé'),
       (8, '2023-06-12', 'en attente', 17, NULL, NULL),
       (9, '2023-06-12', 'en attente', 18, NULL, NULL),
       (10, '2023-06-12', 'en attente', 19, NULL, NULL);


-- --------------------------------------------------------


--
-- Structure de la table `NoteFrais`
--

DROP TABLE IF EXISTS `Depense`;
CREATE TABLE `Depense`
(
    `idDepense`       int(11) NOT NULL,
    `nature`          varchar(50)  NOT NULL,
    `datePaiement`    date         NOT NULL,
    `montant`         float        NOT NULL,
    `fournisseur`     varchar(50)  NOT NULL,
    `commentaire`     varchar(255) NOT NULL,
    `status`          varchar(50)  NOT NULL DEFAULT 'À traiter',
    `dateCreation`    date         NOT NULL,
    `urlJustificatif` varchar(255)          DEFAULT NULL,
    `idIntervenant`   int(11) NOT NULL,
    `idNoteFrais`     int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `Depense`
--

INSERT INTO `Depense` (`idDepense`, `nature`, `datePaiement`, `montant`, `fournisseur`, `commentaire`, `status`,
                       `dateCreation`, `urlJustificatif`, `idIntervenant`, `idNoteFrais`)
VALUES (3, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'À traiter', '2023-05-17', NULL, 6, NULL),
       (4, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'À déclarer', '2023-05-18',
        'public/uploads/intervenants/docs/6-86a7f91489b52336caf3.jpg', 6, NULL),
       (5, 'Transport', '2022-03-01', 300, 'SNCF', 'Paris - Lyon', 'À déclarer', '2022-03-01',
        'public/uploads/intervenants/docs/6-0e948b7ba1132ea8f2f8.jpg', 6, NULL),
       (7, 'essence', '2023-06-13', 7, 'Essence', 'Essence', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/14-46ae514f3abf17024189.jpeg', 14, 4),
       (8, 'essence', '2023-06-21', 10, 'Gazole', 'Essence', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/14-61eb8184baee6ae53f9b.jpeg', 14, 4),
       (9, 'essence', '2023-06-21', 55, 'Peugeot', 'Essence trajet', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/15-a0e375c6fbcfd28d5059.jpg', 15, 5),
       (10, 'repas', '2023-06-12', 150, 'Restaurant fouquets', 'Restaurant pro', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/16-b89e7aab83f523417c19.jpeg', 16, 6),
       (11, 'hebergement', '2023-06-12', 189, 'Ibis Budget', 'Nuit du 12 juin réunion', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/17-d295f9f14fea2b7a050e.jpeg', 17, 8),
       (12, 'essence', '2023-06-13', 90, 'Gazole', 'Voiture de fonction essence', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/18-69c06f621ce84ba7ec08.jpeg', 18, 9),
       (13, 'repas', '2023-06-13', 25, 'Flunch', 'Repas du midi', 'déclarer', '2023-06-12',
        'public/uploads/intervenants/docs/19-2a4700eda4846641b9a8.jpeg', 19, 10);

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
VALUES (1, 'Dupont', 'Anne', 'admin', 'seA/6v3hNAL1.', 'anne.dupont@example.com', 1),
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
                   `idIntervenant`, `idCommentaire`)
VALUES (1, 'effectue', DATE_SUB(CURDATE(), INTERVAL 49 DAY), '10:30', '11:00', 1, 1, 5, 1),
       (2, 'effectue', DATE_SUB(CURDATE(), INTERVAL 48 DAY), '14:30', '15:00', 2, 2, 8, 2),
       (3, 'effectue', DATE_SUB(CURDATE(), INTERVAL 47 DAY), '12:00', '12:30', 3, 3, 12, 3),
       (4, 'annule', DATE_SUB(CURDATE(), INTERVAL 46 DAY), '09:30', '10:00', 4, 4, 7, NULL),
       (5, 'annule', DATE_SUB(CURDATE(), INTERVAL 45 DAY), '16:00', '16:30', 5, 5, 14, NULL),
       (6, 'effectue', DATE_SUB(CURDATE(), INTERVAL 44 DAY), '12:30', '13:00', 6, 6, 11, 4),
       (7, 'effectue', DATE_SUB(CURDATE(), INTERVAL 43 DAY), '16:30', '17:00', 7, 7, 13, 5),
       (8, 'annule', DATE_SUB(CURDATE(), INTERVAL 42 DAY), '14:00', '14:30', 8, 8, 10, NULL),
       (9, 'effectue', DATE_SUB(CURDATE(), INTERVAL 41 DAY), '10:30', '11:00', 9, 9, 9, 6),
       (10, 'effectue', DATE_SUB(CURDATE(), INTERVAL 40 DAY), '14:30', '15:00', 10, 10, 6, 7),
       (11, 'effectue', DATE_SUB(CURDATE(), INTERVAL 39 DAY), '11:30', '12:00', 11, 1, 14, 8),
       (12, 'annule', DATE_SUB(CURDATE(), INTERVAL 38 DAY), '17:30', '18:00', 12, 2, 10, NULL),
       (13, 'effectue', DATE_SUB(CURDATE(), INTERVAL 37 DAY), '12:30', '13:00', 13, 3, 16, 9),
       (14, 'effectue', DATE_SUB(CURDATE(), INTERVAL 36 DAY), '09:30', '10:00', 14, 4, 6, 10),
       (15, 'effectue', DATE_SUB(CURDATE(), INTERVAL 35 DAY), '16:30', '17:00', 15, 5, 11, 11),
       (16, 'annule', DATE_SUB(CURDATE(), INTERVAL 34 DAY), '13:30', '14:00', 16, 6, 8, NULL),
       (17, 'effectue', DATE_SUB(CURDATE(), INTERVAL 33 DAY), '10:30', '11:00', 17, 7, 9, 12),
       (18, 'annule', DATE_SUB(CURDATE(), INTERVAL 32 DAY), '15:30', '16:00', 18, 8, 11, NULL),
       (19, 'annule', DATE_SUB(CURDATE(), INTERVAL 31 DAY), '11:00', '11:30', 19, 9, 13, NULL),
       (20, 'effectue', DATE_SUB(CURDATE(), INTERVAL 30 DAY), '14:00', '14:30', 20, 10, 7, 13),
       (21, 'annule', DATE_SUB(CURDATE(), INTERVAL 29 DAY), '16:00', '16:30', 21, 1, 5, NULL),
       (22, 'effectue', DATE_SUB(CURDATE(), INTERVAL 28 DAY), '12:30', '13:00', 22, 2, 12, 14),
       (23, 'effectue', DATE_SUB(CURDATE(), INTERVAL 27 DAY), '14:30', '15:00', 23, 3, 19, 15),
       (24, 'annule', DATE_SUB(CURDATE(), INTERVAL 26 DAY), '09:30', '10:00', 24, 4, 6, NULL),
       (25, 'effectue', DATE_SUB(CURDATE(), INTERVAL 25 DAY), '16:00', '16:30', 25, 5, 9, 16),
       (26, 'annule', DATE_SUB(CURDATE(), INTERVAL 24 DAY), '12:00', '12:30', 1, 6, 16, NULL),
       (27, 'annule', DATE_SUB(CURDATE(), INTERVAL 23 DAY), '14:30', '15:00', 2, 7, 13, NULL),
       (28, 'effectue', DATE_SUB(CURDATE(), INTERVAL 22 DAY), '16:30', '17:00', 3, 8, 18, 17),
       (29, 'annule', DATE_SUB(CURDATE(), INTERVAL 21 DAY), '10:00', '10:30', 4, 9, 11, NULL),
       (30, 'annule', DATE_SUB(CURDATE(), INTERVAL 20 DAY), '13:30', '14:00', 5, 10, 10, NULL),
       (31, 'effectue', DATE_SUB(CURDATE(), INTERVAL 19 DAY), '11:30', '12:00', 6, 1, 5, 18),
       (32, 'effectue', DATE_SUB(CURDATE(), INTERVAL 18 DAY), '17:30', '18:00', 7, 2, 9, 19),
       (33, 'annule', DATE_SUB(CURDATE(), INTERVAL 17 DAY), '12:30', '13:00', 8, 3, 12, NULL),
       (34, 'annule', DATE_SUB(CURDATE(), INTERVAL 16 DAY), '14:30', '15:00', 9, 4, 17, NULL),
       (35, 'effectue', DATE_SUB(CURDATE(), INTERVAL 15 DAY), '09:30', '10:00', 10, 5, 19, 20),
       (36, 'effectue', DATE_SUB(CURDATE(), INTERVAL 14 DAY), '16:30', '17:00', 11, 6, 8, 21),
       (37, 'annule', DATE_SUB(CURDATE(), INTERVAL 13 DAY), '13:30', '14:00', 12, 7, 10, NULL),
       (38, 'effectue', DATE_SUB(CURDATE(), INTERVAL 12 DAY), '10:30', '11:00', 13, 8, 15, 22),
       (39, 'effectue', DATE_SUB(CURDATE(), INTERVAL 11 DAY), '14:00', '14:30', 14, 9, 6, 23),
       (40, 'effectue', DATE_SUB(CURDATE(), INTERVAL 10 DAY), '11:30', '12:00', 15, 10, 14, 24),
       (41, 'effectue', DATE_SUB(CURDATE(), INTERVAL 9 DAY), '17:30', '18:00', 16, 1, 7, 25),
       (42, 'annule', DATE_SUB(CURDATE(), INTERVAL 8 DAY), '12:30', '13:00', 17, 2, 16, NULL),
       (43, 'effectue', DATE_SUB(CURDATE(), INTERVAL 7 DAY), '09:30', '10:00', 18, 3, 13, 26),
       (44, 'annule', DATE_SUB(CURDATE(), INTERVAL 6 DAY), '16:00', '16:30', 19, 4, 9, NULL),
       (45, 'annule', DATE_SUB(CURDATE(), INTERVAL 5 DAY), '12:00', '12:30', 20, 5, 14, NULL),
       (46, 'effectue', DATE_SUB(CURDATE(), INTERVAL 4 DAY), '14:30', '15:00', 21, 6, 11, 27),
       (47, 'effectue', DATE_SUB(CURDATE(), INTERVAL 3 DAY), '09:30', '10:00', 22, 7, 8, 28),
       (48, 'annule', DATE_SUB(CURDATE(), INTERVAL 2 DAY), '16:00', '16:30', 23, 8, 17, NULL),
       (49, 'annule', DATE_SUB(CURDATE(), INTERVAL 1 DAY), '12:30', '13:00', 24, 9, 10, NULL),
       (50, 'effectue', CURDATE(), '10:30', '11:00', 25, 10, 6, 29);

INSERT INTO `RDV` (`idRdv`, `status`, `dateRDV`, `heureDebut`, `heureFin`, `idDemandeur`, `idSpecialite`,
                   `idIntervenant`, `idCommentaire`)
VALUES (51, 'confirme', '2023-06-16', '10:30', '11:00', 2, 2, 8, NULL),
       (52, 'confirme', '2023-06-17', '12:00', '12:30', 3, 3, 12, NULL),
       (53, 'confirme', '2023-06-18', '09:30', '10:00', 4, 4, 7, NULL),
       (54, 'annule', '2023-06-19', '16:00', '16:30', 5, 5, 14, NULL),
       (55, 'confirme', '2023-06-20', '12:30', '13:00', 6, 6, 11, NULL),
       (56, 'confirme', '2023-06-21', '16:30', '17:00', 7, 7, 13, NULL),
       (57, 'annule', '2023-06-22', '14:00', '14:30', 8, 8, 10, NULL),
       (58, 'confirme', '2023-06-23', '10:30', '11:00', 9, 9, 9, NULL),
       (59, 'confirme', '2023-06-24', '14:30', '15:00', 10, 10, 6, NULL),
       (60, 'confirme', '2023-06-25', '11:30', '12:00', 11, 1, 14, NULL),
       (61, 'annule', '2023-06-26', '17:30', '18:00', 12, 2, 10, NULL),
       (62, 'confirme', '2023-06-27', '12:30', '13:00', 13, 3, 16, NULL),
       (63, 'confirme', '2023-06-28', '09:30', '10:00', 14, 4, 6, NULL),
       (64, 'confirme', '2023-06-29', '16:30', '17:00', 15, 5, 11, NULL),
       (65, 'annule', '2023-06-30', '13:30', '14:00', 16, 6, 8, NULL),
       (66, 'confirme', '2023-07-01', '10:30', '11:00', 17, 7, 9, NULL),
       (67, 'annule', '2023-07-02', '15:30', '16:00', 18, 8, 11, NULL),
       (68, 'annule', '2023-07-03', '11:00', '11:30', 19, 9, 13, NULL),
       (69, 'confirme', '2023-07-04', '09:30', '10:00', 20, 10, 7, NULL),
       (70, 'confirme', '2023-07-05', '14:30', '15:00', 21, 1, 15, NULL),
       (71, 'confirme', '2023-07-06', '10:00', '10:30', 22, 2, 9, NULL),
       (72, 'confirme', '2023-07-07', '15:00', '15:30', 23, 3, 11, NULL),
       (73, 'annule', '2023-07-08', '12:30', '13:00', 24, 4, 13, NULL),
       (74, 'confirme', '2023-07-09', '09:30', '10:00', 25, 5, 7, NULL),
       (75, 'annule', '2023-07-10', '16:00', '16:30', 25, 6, 15, NULL),
       (76, 'annule', '2023-06-10', '09:00', '09:30', 26, 1, 27, NULL),
       (77, 'effectue', '2023-06-10', '16:00', '16:30', 26, 1, 27, 30),
       (78, 'annule', '2023-06-15', '09:00', '09:30', 26, 1, 27, NULL),
       (79, 'confirme', '2023-06-15', '16:00', '16:30', 26, 1, 27, NULL);

insert into RDV values (81, 'effectue', '2023-06-13', '09:00', '09:30', 26, 1, 27, NULL);

insert into RDV values (82, 'confirme', '2023-06-14', '10:00', '10:30', 24, 1, 27, NULL);
insert into RDV values (83, 'confirme', '2023-06-14', '18:00', '18:30', 25, 1, 27, NULL);


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

INSERT INTO Intervenant_Specialite (idIntervenant, idSpecialite)
VALUES (5, 1),
       (8, 2),
       (12, 3),
       (7, 4),
       (14, 5),
       (11, 6),
       (13, 7),
       (10, 8),
       (9, 9),
       (6, 10),
       (17, 7),
       (15, 5),
       (18, 8),
       (19, 9),
       (8, 7),
       (9, 7),
       (11, 8),
       (10, 9),
       (5, 10),
       (12, 2),
       (19, 3),
       (6, 4),
       (9, 5),
       (16, 6),
       (9, 8),
       (14, 9),
       (11, 10),
       (7, 1),
       (9, 2),
       (17, 4),
       (19, 5),
       (8, 6),
       (11, 7),
       (15, 9),
       (15, 2),
       (9, 3),
       (10, 5),
       (27,1);

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
    ADD KEY `idIntervenant` (`idIntervenant`),
    ADD KEY `idAdministration` (`idAdministration`);

--
-- Index pour la table `Depense`
--
ALTER TABLE `Depense`
    ADD PRIMARY KEY (`idDepense`),
    ADD KEY `idIntervenant` (`idIntervenant`),
    ADD KEY `idNoteFrais` (`idNoteFrais`);

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
-- AUTO_INCREMENT pour la table `NoteFrais`
--
ALTER TABLE `NoteFrais`
    MODIFY `idNoteFrais` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT pour la table `Depense`
--
ALTER TABLE `Depense`
    MODIFY `idDepense` int (11) NOT NULL AUTO_INCREMENT,
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
-- Contraintes pour la table `Intervenant`
--
ALTER TABLE `Intervenant`
    ADD CONSTRAINT `Intervenant_ibfk_1` FOREIGN KEY (`idDemandeur`) REFERENCES `Demandeur` (`idDemandeur`) ON UPDATE CASCADE ON DELETE CASCADE,
    ADD CONSTRAINT `Intervenant_ibfk_2` FOREIGN KEY (`idVillePro`) REFERENCES `Ville` (`idVille`) ON
DELETE
CASCADE ON
UPDATE CASCADE;


--
-- Contraintes pour la table `NoteFrais`
--
ALTER TABLE `NoteFrais`
    ADD CONSTRAINT `NoteFrais_ibfk_1` FOREIGN KEY (`idIntervenant`) REFERENCES `Intervenant` (`idDemandeur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `NoteFrais_ibfk_2` FOREIGN KEY (`idAdministration`) REFERENCES `Administration` (`idAdministration`) ON
DELETE
CASCADE ON
UPDATE CASCADE;


--
-- Contraintes pour la table `Depense`
--
ALTER TABLE `Depense`
    ADD CONSTRAINT `Depense_ibfk_1` FOREIGN KEY (`idNoteFrais`) REFERENCES `NoteFrais` (`idNoteFrais`) ON DELETE CASCADE ON UPDATE CASCADE;


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
