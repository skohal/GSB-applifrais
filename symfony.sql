-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 03 Juin 2018 à 09:03
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE `etat` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(1, 'Fiche créée, saisie en cours'),
(2, 'Saisie cloturée'),
(3, 'Validée');

-- --------------------------------------------------------

--
-- Structure de la table `fiche_frais`
--

CREATE TABLE `fiche_frais` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `etat_id` int(11) DEFAULT NULL,
  `mois` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` double DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `dateModif` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `fiche_frais`
--

INSERT INTO `fiche_frais` (`id`, `user_id`, `etat_id`, `mois`, `annee`, `nbJustificatifs`, `montantValide`, `dateCreation`, `dateModif`) VALUES
(9, 45, 2, 4, 2018, NULL, NULL, '2018-03-24', '2018-06-01'),
(10, 45, 3, 5, 2018, NULL, NULL, '2018-04-12', '2018-06-01'),
(11, 49, 3, 4, 2018, NULL, NULL, '2018-04-13', '2018-06-01'),
(12, 49, 1, 5, 2018, NULL, NULL, '2018-05-31', '2018-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `frais_forfait`
--

CREATE TABLE `frais_forfait` (
  `id` int(11) NOT NULL,
  `frais_type_id` int(11) DEFAULT NULL,
  `fiche_id` int(11) NOT NULL,
  `etat_id` int(11) DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `frais_forfait`
--

INSERT INTO `frais_forfait` (`id`, `frais_type_id`, `fiche_id`, `etat_id`, `quantite`, `date`) VALUES
(22, 50, 10, 3, 100, '2018-04-12'),
(24, 49, 9, 1, 2, '2018-04-25'),
(25, 49, 10, 3, 2, '2018-05-02'),
(26, 54, 10, 3, 4, '2018-05-02'),
(27, 50, 10, 3, 7, '2018-05-02'),
(28, 54, 10, 3, 4, '2018-05-02'),
(29, 49, 10, 3, 6, '2018-05-02'),
(30, 49, 12, 1, 3, '2018-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `frais_forfait_type`
--

CREATE TABLE `frais_forfait_type` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `montant` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `frais_forfait_type`
--

INSERT INTO `frais_forfait_type` (`id`, `libelle`, `montant`) VALUES
(49, 'Repas restaurant', 25),
(50, 'Forfait kilométrique', 0.62),
(54, 'Nuit d\'hotel', 70);

-- --------------------------------------------------------

--
-- Structure de la table `frais_hors_forfait`
--

CREATE TABLE `frais_hors_forfait` (
  `id` int(11) NOT NULL,
  `fiche_id` int(11) NOT NULL,
  `etat_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `montant` double NOT NULL,
  `quantite` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `frais_hors_forfait`
--

INSERT INTO `frais_hors_forfait` (`id`, `fiche_id`, `etat_id`, `libelle`, `montant`, `quantite`, `date`) VALUES
(7, 10, 3, 'Taxi', 34, 1, '2018-04-13'),
(8, 9, 3, 'voiture', 20, 1, '2018-04-25'),
(9, 10, 3, 'Dépanneur', 234, 1, '2018-05-02'),
(10, 10, 3, 'Taxi', 67, 1, '2018-05-02'),
(12, 12, 1, 'Taxi', 35, 1, '2018-05-31');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateModif` datetime DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `nom`, `prenom`, `adresse`, `cp`, `ville`, `dateModif`, `dateCreation`, `dateEmbauche`) VALUES
(44, 'admin', 'admin', 'yolo@email.com', 'yolo@email.com', 1, NULL, '$2y$13$1xYM8QouLcxH9RccWgRpVOavQoL36Qtx3mtjzRHcciCJhNr4Hs.5.', '2018-06-03 08:56:11', NULL, NULL, 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 'Dupin', 'Jacques-Admin', '3 rue Dupin', '69001', 'Lyon', NULL, '2018-03-22 15:31:32', '2012-04-27'),
(45, 'user', 'user', 'user@user.com', 'user@user.com', 1, NULL, '$2y$13$tLKjHdxldLL.pI91wAJ8nOtsB1JnR/as03r7RL/2MsIeclQpLcM8y', '2018-06-01 11:22:07', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_UTILISATEUR";}', 'user', 'user', 'user city', '69009', 'userville', NULL, '2018-03-22 15:36:42', '2017-07-04'),
(46, 'user2', 'user2', 'user2@user.com', 'user2@user.com', 1, NULL, '$2y$13$V5EMjJvjgTH33tYVkwqVJuVyYYVTw88bxyLoXU.sydlM8..UkcAEi', NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_UTILISATEUR";}', 'user', 'Francis', '10 rue du user', '69008', 'Lyon', '2018-06-03 08:59:21', '2018-03-26 11:55:10', '2017-09-13'),
(47, 'user3', 'user3', 'user3@user.com', 'user3@user.com', 1, NULL, '$2y$13$9UpXlGHR7wgz.y7ASOz.7.Alw5C.9QUCHXa4XOPHytSmbCjjf/94K', NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_UTILISATEUR";}', 'Merle', 'Alain', '9 rue du bien cuit', '69005', 'Lyon', NULL, '2018-03-26 11:58:15', '2017-07-12'),
(48, 'user4', 'user4', 'user4@user.com', 'user4@user.com', 1, NULL, '$2y$13$nZ9Y2X2bvHT9aeCycPU/eu41ppmCQOk701XJQsguwMDlwM6sQ6j/G', NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_UTILISATEUR";}', 'user', 'José', '89 rue du user', '69006', 'Lyon', '2018-06-03 08:59:53', '2018-03-26 11:59:25', '2017-05-16'),
(49, 'user5', 'user5', 'user5@user.com', 'user5@user.com', 1, NULL, '$2y$13$DW/.gmSq8bSfc1lUDb2tDuMwZsX68kXM7Gaqpy1vf5D.oSmj/nwWW', '2018-05-31 18:46:16', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_UTILISATEUR";}', 'user', 'Thomas', '67 Rue du user', '69007', 'Lyon', '2018-06-03 09:00:49', '2018-03-26 12:02:02', '2017-03-13'),
(51, 'comptable', 'comptable', 'lessous@argent.fr', 'lessous@argent.fr', 1, NULL, '$2y$13$OklfiL8TYpBXw//qvxCgKu6LqElvP5a4oc5Mx/.XgtRuSBqg.4H4.', '2018-06-01 12:30:06', NULL, NULL, 'a:1:{i:0;s:14:"ROLE_COMPTABLE";}', 'Leboulier', 'Francis', '32 rue de la calculatrice', '69006', 'LYON', NULL, '2018-04-12 15:00:51', '2017-03-09'),
(53, 'corzio', 'corzio', 'footix@lefoot.com', 'footix@lefoot.com', 1, NULL, '$2y$13$Dm6ClYFbpJczeW.MK49jZeksikEkDa0IRSMtMlffxO/QeZHAOlhgS', NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_UTILISATEUR";}', 'Monteu-Nana', 'MaRRRc', '19 rue du trickshot', '69194', 'Crapon', '2018-04-13 08:46:45', '2018-04-13 08:39:18', '2017-11-30');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fiche_frais`
--
ALTER TABLE `fiche_frais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5FC0A6A7D5E86FF` (`etat_id`),
  ADD KEY `IDX_5FC0A6A7A76ED395` (`user_id`);

--
-- Index pour la table `frais_forfait`
--
ALTER TABLE `frais_forfait`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B64A3FAEC8B377BF` (`frais_type_id`),
  ADD KEY `IDX_B64A3FAEDF522508` (`fiche_id`),
  ADD KEY `IDX_B64A3FAED5E86FF` (`etat_id`);

--
-- Index pour la table `frais_forfait_type`
--
ALTER TABLE `frais_forfait_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `frais_hors_forfait`
--
ALTER TABLE `frais_hors_forfait`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_598AF747DF522508` (`fiche_id`),
  ADD KEY `IDX_598AF747D5E86FF` (`etat_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `etat`
--
ALTER TABLE `etat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `fiche_frais`
--
ALTER TABLE `fiche_frais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `frais_forfait`
--
ALTER TABLE `frais_forfait`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `frais_forfait_type`
--
ALTER TABLE `frais_forfait_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT pour la table `frais_hors_forfait`
--
ALTER TABLE `frais_hors_forfait`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fiche_frais`
--
ALTER TABLE `fiche_frais`
  ADD CONSTRAINT `FK_5FC0A6A7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5FC0A6A7D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`);

--
-- Contraintes pour la table `frais_forfait`
--
ALTER TABLE `frais_forfait`
  ADD CONSTRAINT `FK_B64A3FAEC8B377BF` FOREIGN KEY (`frais_type_id`) REFERENCES `frais_forfait_type` (`id`),
  ADD CONSTRAINT `FK_B64A3FAED5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FK_B64A3FAEDF522508` FOREIGN KEY (`fiche_id`) REFERENCES `fiche_frais` (`id`);

--
-- Contraintes pour la table `frais_hors_forfait`
--
ALTER TABLE `frais_hors_forfait`
  ADD CONSTRAINT `FK_598AF747D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FK_598AF747DF522508` FOREIGN KEY (`fiche_id`) REFERENCES `fiche_frais` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
