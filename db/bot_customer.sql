-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 24, 2019 at 10:11 PM
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
-- Table structure for table `bot_customer`
--

DROP TABLE IF EXISTS `bot_customer`;
CREATE TABLE `bot_customer` (
  `id` int(10) NOT NULL,
  `idCar` int(15) NOT NULL COMMENT 'id car from table bd',
  `carNumer` varchar(15) NOT NULL COMMENT 'number car from bd',
  `except` text,
  `konsultant` varchar(255) DEFAULT NULL,
  `send` datetime DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `category` varchar(1) NOT NULL COMMENT 'i-image, v- video',
  `image` varchar(255) DEFAULT NULL COMMENT 'name video s rascireniem .mp4',
  `keyController` varchar(10) NOT NULL COMMENT 'generator key',
  `published_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bot_customer`
--

INSERT INTO `bot_customer` (`id`, `idCar`, `carNumer`, `except`, `konsultant`, `send`, `email`, `category`, `image`, `keyController`, `published_at`) VALUES
(149, 1054, 'GB4166', '149', 'Panteleevs', '0000-00-00 00:00:00', 'sipkevich@inbox.lv', 'i', '61v14mcv417-14cv61m-4vmcv1417.jpg', 'EBFYT92288', '2019-08-24 16:25:00'),
(172, 1054, 'GB4166', '172', 'Pavlovs', '0000-00-00 00:00:00', 'sipkevich@inbox.lv', 'i', '35w11uvb019-11vb35u-0wuvb1119.gif', 'CMRBP55728', '2019-08-17 09:16:00'),
(178, 1054, 'GB4166', 'ghdfhfhfghf', 'Pavlovs', '0000-00-00 00:00:00', 'sipkevich@inbox.lv', 'i', '72c14rer1019-14er72r-10crer1419.jpg', 'JYPUW53653', '2019-08-22 06:52:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bot_customer`
--
ALTER TABLE `bot_customer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bot_customer`
--
ALTER TABLE `bot_customer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
