-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 14, 2026 alle 18:22
-- Versione del server: 10.11.14-MariaDB-0ubuntu0.24.04.1
-- Versione PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_lilisheng5ie`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_commenti`
--

CREATE TABLE `WorldGO_commenti` (
  `id` varchar(30) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_post` bigint(20) NOT NULL,
  `testo` text NOT NULL,
  `data_pubblicazione` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_GANTT_RELAZIONI`
--

CREATE TABLE `WorldGO_GANTT_RELAZIONI` (
  `Task1` char(15) NOT NULL,
  `Task2` char(15) NOT NULL,
  `Tipo` enum('int-int','int-end') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_GANTT_TASK`
--

CREATE TABLE `WorldGO_GANTT_TASK` (
  `COD` char(15) NOT NULL,
  `Titolo` varchar(100) NOT NULL,
  `Data_inizio` date NOT NULL,
  `Durata` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_GANTT_TASK`
--

INSERT INTO `WorldGO_GANTT_TASK` (`COD`, `Titolo`, `Data_inizio`, `Durata`) VALUES
('1', 'Pianificazione', '2025-09-19', 30),
('2', 'Analisi requisiti', '2025-10-19', 26),
('3', 'Progettazione', '2025-11-14', 14),
('4', 'Codifica', '2025-11-28', 150),
('5', 'Test e Debug', '2026-04-27', 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_likes`
--

CREATE TABLE `WorldGO_likes` (
  `id_utente` int(11) NOT NULL,
  `id_post` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_permissions`
--

CREATE TABLE `WorldGO_permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_permissions`
--

INSERT INTO `WorldGO_permissions` (`id`, `permission`) VALUES
(3, 'commento'),
(1, 'CRUD_permissions'),
(2, 'pubblica_post');

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_posts`
--

CREATE TABLE `WorldGO_posts` (
  `id` bigint(20) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `titolo` varchar(30) NOT NULL,
  `descrizione` text NOT NULL,
  `tipo_media` int(11) NOT NULL,
  `url_media` varchar(255) NOT NULL,
  `data_pubblicazione` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_posts`
--

INSERT INTO `WorldGO_posts` (`id`, `id_utente`, `titolo`, `descrizione`, `tipo_media`, `url_media`, `data_pubblicazione`) VALUES
(1, 1, 'titolo', 'testo', 0, 'url', '2026-02-06 11:35:59'),
(2, 1, 'prova2', 'testo_prova2', 0, 'url 2', '2026-02-06 11:43:47');

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_roles`
--

CREATE TABLE `WorldGO_roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_roles`
--

INSERT INTO `WorldGO_roles` (`id`, `role`) VALUES
(1, 'CRUD'),
(2, 'admin'),
(3, 'user');

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_role_permissions`
--

CREATE TABLE `WorldGO_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_role_permissions`
--

INSERT INTO `WorldGO_role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_users`
--

CREATE TABLE `WorldGO_users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profilo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_users`
--

INSERT INTO `WorldGO_users` (`id`, `username`, `email`, `password`, `foto_profilo`, `bio`, `data_creazione`) VALUES
(1, 'admin-CRUD', 'admin', '$2y$12$ElNkaa0ypXjkm5I8gLs/FOCfzmxNLEVPeLkFysEB4VrA5YwJwDzSy', NULL, NULL, '2026-02-06 09:03:37'),
(2, 'aaa', 'aaa', '$2y$10$UDaHQAYC4P.qoRl9jcSfgu9QrQo0l.IKplpvVYHMyTK0PVPyp4b9m', NULL, NULL, '2026-01-29 18:43:21'),
(3, 'a', 'a', '$2y$10$s8qAUjmM7/.V7u2B1sAKQu133H2dahIzdSrkFK1pGmAGzZSJHVaNK', NULL, NULL, '2026-01-29 18:44:39'),
(32, 'prova', 'prova', '$2y$12$7tGT13DMDpTV1/FyYacsnunbRVdjTk7VFBY4eRfaZCyUjB1fSQB6.', NULL, NULL, '2026-03-20 11:39:50'),
(34, 'prova1', 'prova1', '$2y$12$n.rU.fPMdbgMB9.BQ7yXHuD4PB1RhK8in4Vh5HXZIWoPTLCbE8S5q', NULL, NULL, '2026-03-20 11:43:06'),
(35, 'utente_test', 'test@example.com', '$2y$12$96qS5k.RYWGy5zJ/qLu7.u28n/uiu39xWnxg5dhZS5/AbcAPEoF32', NULL, NULL, '2026-03-20 11:49:57'),
(37, 'prova2', 'prova2', '$2y$12$s3kp1HRGldo34Kf7hU7gm.VZYfG7Fga4VhnWIZ5cUMSzQ5sCBlyLS', NULL, NULL, '2026-03-20 11:50:23'),
(38, 'prova3', 'prova3', '$2y$12$HFOFdpGzJTVWGORV61LveuF0BgVxHWlc/TrxWKxAfqZBkBXs2VkVS', NULL, NULL, '2026-03-20 11:50:41'),
(39, 'prova4', 'prova4', '$2y$12$ea9UxMaXUBCdoQpcCOs6zOWduA/RnDDGGFgFdA7XcH03v4vG.KL8y', NULL, NULL, '2026-03-20 11:52:56');

-- --------------------------------------------------------

--
-- Struttura della tabella `WorldGO_user_roles`
--

CREATE TABLE `WorldGO_user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dump dei dati per la tabella `WorldGO_user_roles`
--

INSERT INTO `WorldGO_user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `WorldGO_commenti`
--
ALTER TABLE `WorldGO_commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_commenti_users` (`id_utente`),
  ADD KEY `fk_commenti_posts` (`id_post`);

--
-- Indici per le tabelle `WorldGO_GANTT_RELAZIONI`
--
ALTER TABLE `WorldGO_GANTT_RELAZIONI`
  ADD PRIMARY KEY (`Task1`,`Task2`),
  ADD KEY `TASK1` (`Task1`),
  ADD KEY `TASK2` (`Task2`);

--
-- Indici per le tabelle `WorldGO_GANTT_TASK`
--
ALTER TABLE `WorldGO_GANTT_TASK`
  ADD PRIMARY KEY (`COD`);

--
-- Indici per le tabelle `WorldGO_likes`
--
ALTER TABLE `WorldGO_likes`
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_post` (`id_post`);

--
-- Indici per le tabelle `WorldGO_permissions`
--
ALTER TABLE `WorldGO_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission` (`permission`);

--
-- Indici per le tabelle `WorldGO_posts`
--
ALTER TABLE `WorldGO_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`) USING BTREE;

--
-- Indici per le tabelle `WorldGO_roles`
--
ALTER TABLE `WorldGO_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `WorldGO_role_permissions`
--
ALTER TABLE `WorldGO_role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`) USING BTREE,
  ADD KEY `permission_id` (`permission_id`);

--
-- Indici per le tabelle `WorldGO_users`
--
ALTER TABLE `WorldGO_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `WorldGO_user_roles`
--
ALTER TABLE `WorldGO_user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `WorldGO_user_roles_ibfk_2` (`role_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `WorldGO_permissions`
--
ALTER TABLE `WorldGO_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `WorldGO_roles`
--
ALTER TABLE `WorldGO_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `WorldGO_users`
--
ALTER TABLE `WorldGO_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `WorldGO_commenti`
--
ALTER TABLE `WorldGO_commenti`
  ADD CONSTRAINT `fk_commenti_posts` FOREIGN KEY (`id_post`) REFERENCES `WorldGO_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commenti_users` FOREIGN KEY (`id_utente`) REFERENCES `WorldGO_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `WorldGO_GANTT_RELAZIONI`
--
ALTER TABLE `WorldGO_GANTT_RELAZIONI`
  ADD CONSTRAINT `TASK1` FOREIGN KEY (`Task1`) REFERENCES `WorldGO_GANTT_TASK` (`COD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TASK2` FOREIGN KEY (`Task2`) REFERENCES `WorldGO_GANTT_TASK` (`COD`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `WorldGO_likes`
--
ALTER TABLE `WorldGO_likes`
  ADD CONSTRAINT `fk_likes_posts` FOREIGN KEY (`id_post`) REFERENCES `WorldGO_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_likes_users` FOREIGN KEY (`id_utente`) REFERENCES `WorldGO_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `WorldGO_posts`
--
ALTER TABLE `WorldGO_posts`
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`id_utente`) REFERENCES `WorldGO_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `WorldGO_role_permissions`
--
ALTER TABLE `WorldGO_role_permissions`
  ADD CONSTRAINT `WorldGO_role_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `WorldGO_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `WorldGO_role_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `WorldGO_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `WorldGO_user_roles`
--
ALTER TABLE `WorldGO_user_roles`
  ADD CONSTRAINT `WorldGO_user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `WorldGO_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `WorldGO_user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `WorldGO_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
