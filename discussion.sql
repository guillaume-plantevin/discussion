-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 04, 2021 at 09:02 AM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `discussion`
--
CREATE DATABASE IF NOT EXISTS `discussion` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `discussion`;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` varchar(140) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `id_utilisateur`, `date`) VALUES
(1, 'Super match, mais pas beaucoup de buts...', 18, '2021-01-01'),
(4, 'Le meilleur supporter, c\'est Keany!', 18, '2021-01-01'),
(6, 'Souvenir de coupe du monde, quelles regrets quand même\r\n', 26, '2021-01-02'),
(7, '&lt;b&gt;Fini le beau jeu... &lt;/b&gt;', 27, '2021-01-02'),
(11, 'Robert`); DROP table utilisateurs; --', 27, '2021-01-02'),
(12, 'Robert\'); DROP TABLE Students;--', 28, '2021-01-03'),
(13, 'Robert\'); DROP TABLE utilisateurs;--', 28, '2021-01-03');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(18, 'johndoe', '$2y$10$f6ABloJ4acDv0hKQJLkBgOBQKur3rZKqZaSYYBnr2juWAznfraBne'),
(26, 'footix', '$2y$10$A8cQE8I1PgtoXG4t5JjKv.cD.xbjIVCBeyEBgzUhk0NsHJQTgceAu'),
(27, 'jacquet', '$2y$10$QFZzU/gcN30XSOsAOfApFeoMyXYnCBJodZ9wUrGSQELJ6LFJ4OW92'),
(28, 'Mrs Roberts', '$2y$10$kL.Tq7xlxDFp6SiYS5iZ9e63SdUfGasDWDjDfrmvgqDhwOo1EIPya'),
(29, 'gainsbarre', '$2y$10$xJ4hV.h3WuxINe6b3Vurp.WGqRocHA8L1LwxTzkHcTDb2tjxT1QZq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
