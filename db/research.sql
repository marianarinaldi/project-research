-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2021 at 10:26 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `research`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_dimensions`
--

CREATE TABLE `tb_dimensions` (
  `id_dimension` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `delete_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dimensions`
--

INSERT INTO `tb_dimensions` (`id_dimension`, `name`, `delete_date`) VALUES
(1, 'Bem-estar', NULL),
(2, 'Carreira', NULL),
(3, 'Estrutura', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_questions`
--

CREATE TABLE `tb_questions` (
  `id_question` int(11) NOT NULL,
  `question` varchar(250) NOT NULL,
  `status` varchar(1) NOT NULL,
  `delete_date` timestamp NULL DEFAULT NULL,
  `id_dimension` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for table `tb_dimensions`
--
ALTER TABLE `tb_dimensions`
  ADD PRIMARY KEY (`id_dimension`);

--
-- Indexes for table `tb_questions`
--
ALTER TABLE `tb_questions`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_dimension` (`id_dimension`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_dimensions`
--
ALTER TABLE `tb_dimensions`
  MODIFY `id_dimension` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_questions`
--
ALTER TABLE `tb_questions`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_questions`
--
ALTER TABLE `tb_questions`
  ADD CONSTRAINT `tb_questions_ibfk_1` FOREIGN KEY (`id_dimension`) REFERENCES `tb_dimensions` (`id_dimension`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
