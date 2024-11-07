-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2024 at 02:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deefy`
--

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`id`, `nom`) VALUES
(1, 'Best of rock'),
(2, 'Musique classique'),
(3, 'Best of country music'),
(4, 'Best of Elvis Presley'),
(17, 'My new playlist'),
(18, 'encore une nouvelle playlist'),
(19, 'et encore'),
(20, 'Bonjour'),
(21, 'nouvelle playlist pour user7'),
(22, 'zzz'),
(23, 'Une nouvelle playlist user1');

-- --------------------------------------------------------

--
-- Table structure for table `playlist2track`
--

CREATE TABLE `playlist2track` (
  `id_pl` int(11) NOT NULL,
  `id_track` int(11) NOT NULL,
  `no_piste_dans_liste` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `playlist2track`
--

INSERT INTO `playlist2track` (`id_pl`, `id_track`, `no_piste_dans_liste`) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 3, 1),
(2, 4, 2),
(3, 5, 1),
(3, 6, 2),
(4, 7, 1),
(4, 8, 2),
(17, 16, 1),
(17, 17, 2),
(17, 18, 3),
(17, 19, 4),
(17, 20, 5),
(17, 21, 6),
(20, 11, 1),
(20, 12, 2),
(21, 14, 1),
(21, 15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `genre` varchar(30) DEFAULT NULL,
  `duree` int(3) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `artiste_album` varchar(30) DEFAULT NULL,
  `titre_album` varchar(30) DEFAULT NULL,
  `annee_album` int(4) DEFAULT NULL,
  `numero_album` int(11) DEFAULT NULL,
  `auteur_podcast` varchar(100) DEFAULT NULL,
  `date_posdcast` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`id`, `titre`, `genre`, `duree`, `filename`, `type`, `artiste_album`, `titre_album`, `annee_album`, `numero_album`, `auteur_podcast`, `date_posdcast`) VALUES
(1, 'Wish You Were Here', 'rock', 334, 'pink_wish.mp3', 'A', 'Pink Floyd', 'Wish You Were Here', 1975, 1, NULL, NULL),
(2, 'Samba Pati', 'rock', 300, 'santana_abra.mp3', 'A', 'Santana', 'Abraxas', 1970, 1, NULL, NULL),
(3, 'Danube Bleu', 'musique classique', 300, 'straus_danube.mp3', 'A', 'Johann Strauss', 'Valses', 2000, 1, NULL, NULL),
(4, 'Lettre à Elise', 'musique classique', 400, 'beethoven_elise.mp3', 'A', 'Beethoven', 'Piano', 1966, 1, NULL, NULL),
(5, 'Annie song', 'country', 200, 'denver_annie.mp3', 'A', 'John Denver', 'Best of J. Denver', 2001, 1, NULL, NULL),
(6, 'Tequila sunrise', 'country', 300, 'eagles_teq.mp3', 'A', 'Eagles', 'Best of Eagles', 2007, 1, NULL, NULL),
(7, 'In the ghetto', 'country', 200, 'elvis_annie.mp3', 'A', 'Elvis Presley', 'Best of E. Presley', 2002, 1, NULL, NULL),
(8, 'La vie des papillons', 'docu', 200, 'papillons.mp3', 'P', NULL, NULL, NULL, NULL, 'Bolo', '2004-10-12'),
(9, 'La vie des libellules', 'docu', 200, 'libellules.mp3', 'P', NULL, NULL, NULL, NULL, 'Bolo', '2004-10-12'),
(10, 'aaa', NULL, 555, 'audio/67223cae8c24a.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(11, 'yeat', NULL, 555, 'audio/6722401acfc59.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(12, 'yeat2', NULL, 658, 'audio/6722405c949c4.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(13, 'kfhaiuf', NULL, 98, 'audio/672240c173493.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(14, 'aaaaaaaa', NULL, 888, 'audio/6722418bee344.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(15, 'eahifhaih', NULL, 585, 'audio/6722419a732ff.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(16, 'aaez', NULL, 555, 'audio/67234fc1599dd.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(17, 'aruia', NULL, 545, 'audio/67234fcb88a6d.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(18, 'dqzdzq5', NULL, 555, 'audio/67234fd9d2da2.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(19, 'cakhbdiahdiza5', NULL, 989, 'audio/67234fe5744b0.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(20, 'dqzdqzdqzd', NULL, 88, 'audio/67234fef0cae8.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL),
(21, 'feihdq', NULL, 754, 'audio/67234ffaaa3fb.mp3', NULL, 'Inconnu', NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `passwd` varchar(256) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `passwd`, `role`) VALUES
(1, 'user1@mail.com', '$2y$12$e9DCiDKOGpVs9s.9u2ENEOiq7wGvx7sngyhPvKXo2mUbI3ulGWOdC', 1),
(2, 'user2@mail.com', '$2y$12$4EuAiwZCaMouBpquSVoiaOnQTQTconCP9rEev6DMiugDmqivxJ3AG', 1),
(3, 'user3@mail.com', '$2y$12$5dDqgRbmCN35XzhniJPJ1ejM5GIpBMzRizP730IDEHsSNAu24850S', 1),
(4, 'user4@mail.com', '$2y$12$ltC0A0zZkD87pZ8K0e6TYOJPJeN/GcTSkUbpqq0kBvx6XdpFqzzqq', 1),
(5, 'admin@mail.com', '$2y$12$JtV1W6MOy/kGILbNwGR2lOqBn8PAO3Z6MupGhXpmkeCXUPQ/wzD8a', 100),
(6, 'cyprian.chailan@icloud.com', '$2y$10$jLBj2ci1HOelUISAzByX7uQ//R9DF2Mbegl8ltpyZeiYNb5x6l.ri', 1),
(7, 'user7@mail.com', '$2y$10$o4/U1b6qThlnAtxdV5hfHOfo3enoXSCQJRgXkdeqTjonxQU8eN/mu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user2playlist`
--

CREATE TABLE `user2playlist` (
  `id_user` int(11) NOT NULL,
  `id_pl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user2playlist`
--

INSERT INTO `user2playlist` (`id_user`, `id_pl`) VALUES
(1, 1),
(1, 2),
(1, 17),
(1, 18),
(1, 19),
(1, 23),
(2, 3),
(3, 4),
(7, 20),
(7, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlist2track`
--
ALTER TABLE `playlist2track`
  ADD PRIMARY KEY (`id_pl`,`id_track`),
  ADD KEY `id_track` (`id_track`);

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user2playlist`
--
ALTER TABLE `user2playlist`
  ADD PRIMARY KEY (`id_user`,`id_pl`),
  ADD KEY `id_pl` (`id_pl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `playlist2track`
--
ALTER TABLE `playlist2track`
  ADD CONSTRAINT `playlist2track_ibfk_1` FOREIGN KEY (`id_pl`) REFERENCES `playlist` (`id`),
  ADD CONSTRAINT `playlist2track_ibfk_2` FOREIGN KEY (`id_track`) REFERENCES `track` (`id`);

--
-- Constraints for table `user2playlist`
--
ALTER TABLE `user2playlist`
  ADD CONSTRAINT `user2playlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user2playlist_ibfk_2` FOREIGN KEY (`id_pl`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
