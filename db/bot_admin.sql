-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 24, 2019 at 07:37 PM
-- Server version: 5.5.58
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvcbotik`
--

-- --------------------------------------------------------

--
-- Table structure for table `bot_admin`
--

DROP TABLE IF EXISTS `bot_admin`;
CREATE TABLE `bot_admin` (
  `id` int(5) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `idn` varchar(15) NOT NULL,
  `roles` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bot_admin`
--

INSERT INTO `bot_admin` (`id`, `login`, `password`, `lastname`, `avatar`, `status`, `idn`, `roles`) VALUES
(2, '11', '22', 'Natalija Sipkevica', 'avatarPusja.jpg', 1, '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bot_admin`
--
ALTER TABLE `bot_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bot_admin`
--
ALTER TABLE `bot_admin`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
