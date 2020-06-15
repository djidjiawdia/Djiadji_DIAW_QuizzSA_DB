-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: mysql-djiadjidiaw.alwaysdata.net
-- Generation Time: Jun 15, 2020 at 04:08 AM
-- Server version: 10.4.12-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `djiadjidiaw_sa_quizz`
--

-- --------------------------------------------------------

--
-- Table structure for table `jeu`
--

CREATE TABLE `jeu` (
  `id_jeu` int(11) NOT NULL,
  `nbr_question` int(11) NOT NULL DEFAULT 5
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jeu`
--

INSERT INTO `jeu` (`id_jeu`, `nbr_question`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id_question` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `question` text NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id_question`, `type`, `question`, `point`) VALUES
(1, 'radio', 'HTML est-il est un langage de programmation ?', 4),
(2, 'text', 'Que signifie PHP ?', 5),
(3, 'checkbox', 'Quels sont les frameworks JavaScript ?', 6),
(4, 'text', 'Que signifie HTML ?', 6),
(5, 'checkbox', 'Quels sont les langages de programmation Web ?', 5),
(6, 'radio', 'Comment peut-on empêcher l\'exécution d\'un lien cliqué ?', 4),
(8, 'radio', 'Java est un langage', 1),
(9, 'radio', 'En Java, la liaison dynamique est essentielle pour assurer', 2),
(10, 'radio', 'Que veut dire UML', 2),
(11, 'radio', 'En UML, l\'agrégation est il une association ?', 2),
(13, 'checkbox', 'En PHP, laquelle des variables suivantes peut-on lui attribuer une valeur?', 3),
(21, 'checkbox', 'Parmi ces frameworks lesquels des frameworks de PHP?', 4);

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `id_response` int(11) NOT NULL,
  `reponse` text NOT NULL,
  `correct` tinyint(4) NOT NULL DEFAULT 0,
  `id_question` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`id_response`, `reponse`, `correct`, `id_question`) VALUES
(1, 'OUI', 0, 1),
(2, 'NON', 1, 1),
(3, 'HyperText Preprocessor ', 1, 2),
(4, 'Angular', 1, 3),
(5, 'Bootstrap', 0, 3),
(6, 'Symfony', 0, 3),
(7, 'React', 1, 3),
(8, 'HyperText Markup Langage', 1, 4),
(9, 'HTML', 1, 5),
(10, 'R', 0, 5),
(11, 'PHP', 1, 5),
(12, '$(\"a\").click(function() { exit; });', 0, 6),
(13, '$(\"a\").click(function() { return true; });', 0, 6),
(14, '$(\"a\").click(function(e) { e.preventDefault; });', 0, 6),
(15, '$(\"a\").click(function(e) { e.preventDefault(); });', 1, 6),
(19, 'Interprété', 0, 8),
(18, 'Compilé', 0, 8),
(20, 'Ni Compilé ni Interprété', 0, 8),
(21, 'Compilé et Interprété', 1, 8),
(22, 'l\'encapsulation', 0, 9),
(23, 'le polymorphisme', 1, 9),
(24, 'l\'héritage', 0, 9),
(25, 'la marginalisation', 0, 9),
(26, 'Union mondiale de la lecture', 0, 10),
(27, 'Unified Modeling Language', 1, 10),
(28, 'Unité mesure libre', 0, 10),
(29, 'oui', 1, 11),
(30, 'non', 0, 11),
(36, '$var', 0, 13),
(35, '$_var', 1, 13),
(34, '$5var', 0, 13),
(37, '$This', 1, 13),
(47, 'Spring', 0, 21),
(48, 'Symphony', 1, 21),
(45, 'Bootstrap', 0, 21),
(46, 'Laravel', 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `libelle`) VALUES
(1, 'Admin'),
(2, 'Joueur');

-- --------------------------------------------------------

--
-- Table structure for table `trouver`
--

CREATE TABLE `trouver` (
  `id_user` int(11) NOT NULL,
  `id_question` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trouver`
--

INSERT INTO `trouver` (`id_user`, `id_question`) VALUES
(6, 1),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(14, 1),
(14, 2),
(14, 5),
(15, 3),
(15, 5),
(17, 5),
(17, 8),
(18, 5),
(18, 9),
(18, 11),
(19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `statut` int(11) DEFAULT 0,
  `id_role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `prenom`, `nom`, `login`, `password`, `avatar`, `score`, `statut`, `id_role`) VALUES
(1, 'Djiadji', 'Diaw', 'admin', 'Admin1@', '/uploads/admin.jpg', NULL, 0, 1),
(14, 'El Hadj Moussa', 'Ndiaye', 'eljee', 'Joueur1&', '/uploads/eljee.jpg', 14, 0, 2),
(6, 'Ismaila M', 'Guisse', 'coolblack', 'Joueur1&', '/uploads/iso.jpg', 15, 0, 2),
(4, 'Boubacar', 'Samb', 'boobs', 'Joueur1&', '/uploads/boobs.jpg', 0, 1, 2),
(10, 'Atou', 'Faye', 'atouman', 'Joueur1&', '/uploads/atouman.jpg', 0, 0, 2),
(9, 'Samba', 'Cisse', 'sampeuzi', 'Test123&', '/uploads/sampeuzi.jpg', NULL, 0, 1),
(11, 'Pape Sidy', 'Guisse', 'pasidy', 'Test1&', '/uploads/pasidy.jpg', NULL, 0, 1),
(13, 'Yaye Ngone', 'Samb', 'ngone', 'Test123&', '/uploads/ngone.jpg', NULL, 0, 1),
(15, 'Papa Djiby', 'Niang', 'ibnaliou', 'Aliou280294@', '/uploads/ibnaliou.jpeg', 11, 0, 2),
(18, 'Beni', 'DIOP', 'benito', 'Passer123@', '/uploads/benito.jpeg', 9, 0, 2),
(16, 'Aly', 'Sakho', 'Allysaxo', 'Alyshop2020´', '/uploads/Allysaxo.jpeg', 0, 0, 2),
(17, 'Fatou', 'DIENE', 'Fatou', 'Fatou15@', '/uploads/Fatou.jpg', 6, 0, 2),
(19, 'Mangane', 'GUISSE', 'Clairon', 'Cl@iron3', '/uploads/Clairon.jpg', 4, 0, 2),
(20, 'Joueur 1', 'Lamda', 'joueur', 'Joueur1&', '/uploads/joueur.jpg', 0, 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jeu`
--
ALTER TABLE `jeu`
  ADD PRIMARY KEY (`id_jeu`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id_response`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trouver`
--
ALTER TABLE `trouver`
  ADD PRIMARY KEY (`id_user`,`id_question`),
  ADD KEY `id_question` (`id_question`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jeu`
--
ALTER TABLE `jeu`
  MODIFY `id_jeu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `id_response` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
