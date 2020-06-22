-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 18 juin 2020 à 10:59
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `clap`
--

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Animation'),
(3, 'Aventure'),
(4, 'Comédie'),
(5, 'Drame'),
(6, 'Epouvante-horreur'),
(7, 'Famille'),
(8, 'Fantastique'),
(9, 'Guerre'),
(10, 'Historique'),
(11, 'Policier'),
(12, 'Romance'),
(13, 'Science fiction'),
(14, 'Thriller');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200608132528', '2020-06-08 13:25:49'),
('20200608133520', '2020-06-08 13:35:26'),
('20200608134220', '2020-06-08 13:42:27'),
('20200608142229', '2020-06-08 14:22:47'),
('20200608143337', '2020-06-08 14:34:13'),
('20200610151234', '2020-06-10 17:28:46'),
('20200611074025', '2020-06-11 07:41:33');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(2, 1, 'zz8EZA24mDwSO0m6Qva9', 'MVcJta/gLRza3a8dSTKDZz5OpwsJnN8bMSCRHTqE378=', '2020-06-16 18:31:52', '2020-06-16 19:31:52'),
(3, 2, '4Pp2SwE9D3AdBFt2IuOB', 'csdhsN6jJ2I3KYGXTqBmZI9uijlSMSmmzZNWR6GytsI=', '2020-06-16 18:39:33', '2020-06-16 19:39:33'),
(4, 10, 'cTvDhMbMlntVIJ6wFKEH', 'yF75TI1AZxWO50LaOOAYS+jxEufeV0G2OjQYhQmDAWQ=', '2020-06-17 09:41:50', '2020-06-17 10:41:50'),
(5, 2, 'rPoD335EJFMzhKZXI7Ty', 'LFE4SO2JaRC6GncOLj+iWZ6yDCzbU7gMYTqkqu8qJFk=', '2020-06-17 09:44:33', '2020-06-17 10:44:33'),
(6, 4, 'W0aH0pO2vdSVKcD1BpsK', 'RPTkyBfUQ040T0WBoVRiujKvmACh4vqNh/3FkTKRY+g=', '2020-06-17 09:57:31', '2020-06-17 10:57:31');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `pseudo`) VALUES
(1, 'allain.susan@dupre.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$NXdiUlVkdlNkekI2LkxCUw$SRGwyMYxhIJpGEFnbhkaLwj876czrmH+bI/iAhDP3rk', 'Zoé', 'Labbe', 'pierre37'),
(2, 'franck79@bouygtel.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$eVJPZUsyOG14S25aMDNiMQ$9srPEniBjWvoM1zJRLcbub078B1HbCeRIzugbsqJSGY', 'Juliette', 'Gimenez', 'guillaume67'),
(3, 'leon.leblanc@ifrance.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$Mkp2UFR5UjMzTzBSQW9rbQ$QE/F3fy8aNE9DYUMgaJPcw4TFyfwtJla6zPlPdjP6gk', 'Charles', 'Costa', 'allard.raymond'),
(4, 'isabelle.lambert@free.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$NGRxRTB0MVR0YXBHcGVJdg$m1VhYnXsZh9XGROkn+f26gb2KS6cGlVZMxhL8JYL/UU', 'Laurence', 'Raynaud', 'iberthelot'),
(5, 'martin17@vallee.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$TkcyTWM1NWg5aERZcHVNZw$8VF1PY4f2tsL1TKROIvcDhpmVdAtf2pYe8Owzrg8LvE', 'Clémence', 'Julien', 'nadam'),
(6, 'nraymond@club-internet.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$djhBeVhPUk9XSkJidjFnQw$ctM8EsA0LnqC/n0Dc/NLJUciGmtALmfFgqr59lXwWEw', 'Paul', 'Leveque', 'lgregoire'),
(7, 'walexandre@sfr.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$MEpRSG5VYnZHLkV2eXI4cQ$vvbArrXDwUYm7SoUSTYVfTKekrdRpPOrxxvbDnyT7Vo', 'Clémence', 'Dumont', 'jlacombe'),
(8, 'gerard.lorraine@bouygtel.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$OERCbkZ4SzNEUWpHeEZIag$cmVjX4rP/tYIOT9JbsAXM37ryMrNVSO9we3wftS4fK4', 'Henriette', 'Ledoux', 'legrand.suzanne'),
(9, 'ksamson@bodin.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$V0dsRk9iZjZ3enVjODZpVQ$qWjwmRFZFmsLm6GXw0DX1RLUJvx8FbSOYNU77uDOW5w', 'Henri', 'Guillou', 'daniel42'),
(10, 'pauline56@sfr.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$d2dLSVUuemovZW1NQVBiYg$dAui3vvx03OEeCp3xYpXCvVtdi6Xe5kOG2a8mRKuN6E', 'Thérèse', 'Techer', 'edith55'),
(11, 'aureliedutrey@hotmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$OTV6VjRJNXpjRDZqUzU4WA$NfTNznsch+0VodkQ1tROR/TQs1hQD5LpV3uQvy7TXwY', 'aure', 'dutrey', 'lala'),
(12, 'analiadutrey@hotmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$TC42a0xOdjJXdlVWY201MA$Ny2wq90kEWbZnLIywq8CLOdZUSJ+NKuPlk+SzYzIUa0', 'chris', 'tophe', 'toto'),
(13, 'aaa@hotmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$R1l4Vk1NR0ZySWc5RjJVcw$RtG25qdisEZbSWxnmKfdrrTk0y/ju0vtThWHdkry0PE', 'chris', 'tophe', 'lala'),
(14, 'anali@hotmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$cXNMcEw4RmRtYnliYkFWbQ$L/8g9wwSaBwvs7Q7WgrGZzc89UcvWl6hpMuBFuxOwIE', 'chris', 'dutrey', 'lala'),
(18, 'contact@clap.fr', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$ekxSQWQ3dml4ZlZveGtnMQ$0fTrLXp7PSZq5DJqWjXduqk0kNoTPIcwgnrPPtYHOKE', 'Crousti', 'Bat', 'Croustibat'),
(19, 'cyrielle@contact.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$NC9kLmhMbmNQSklmcE5aTQ$AnQVIC4PRAhVvLBupmC++AC4NhOu1Ti0OuwGEKye9pA', 'Cyrielle', 'Touton', 'Cyrielbat');

-- --------------------------------------------------------

--
-- Structure de la table `user_genres`
--

DROP TABLE IF EXISTS `user_genres`;
CREATE TABLE `user_genres` (
  `user_id` int(11) NOT NULL,
  `genres_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_genres`
--

INSERT INTO `user_genres` (`user_id`, `genres_id`) VALUES
(1, 12),
(2, 13),
(4, 1),
(4, 8),
(6, 14),
(8, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `user_genres`
--
ALTER TABLE `user_genres`
  ADD PRIMARY KEY (`user_id`,`genres_id`),
  ADD KEY `IDX_CDB9FE2BA76ED395` (`user_id`),
  ADD KEY `IDX_CDB9FE2B6A3B2603` (`genres_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user_genres`
--
ALTER TABLE `user_genres`
  ADD CONSTRAINT `FK_CDB9FE2B6A3B2603` FOREIGN KEY (`genres_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CDB9FE2BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
