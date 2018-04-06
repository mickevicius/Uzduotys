-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 06, 2018 at 02:07 PM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Transportas`
--
CREATE DATABASE IF NOT EXISTS `Transportas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Transportas`;

-- --------------------------------------------------------

--
-- Table structure for table `data_sheet`
--

CREATE TABLE IF NOT EXISTS `data_sheet` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `date_` date NOT NULL,
  `route` varchar(255) NOT NULL,
  `departure` time NOT NULL,
  `speedoTripStart` int(10) NOT NULL,
  `arrivalToClient` time NOT NULL,
  `unloading` smallint(6) NOT NULL,
  `departureFromClient` time NOT NULL,
  `arrival` time NOT NULL,
  `speedoTripEnd` int(10) NOT NULL,
  `distance` smallint(6) NOT NULL,
  `consumptions` smallint(6) NOT NULL,
  `driver` char(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_sheet`
--

INSERT INTO `data_sheet` (`id`, `date_`, `route`, `departure`, `speedoTripStart`, `arrivalToClient`, `unloading`, `departureFromClient`, `arrival`, `speedoTripEnd`, `distance`, `consumptions`, `driver`) VALUES
(1, '2018-04-03', 'kazlu ruda', '05:05:00', 15, '06:06:00', 15, '07:00:00', '08:00:00', 55, 77, 66, 'Petras'),
(3, '0000-00-00', '', '00:00:00', 0, '00:00:00', 0, '00:00:00', '00:00:00', 0, 77, 66, 'Petras'),
(4, '2018-04-12', 'ghjhgfghjk', '06:06:00', 3333, '06:43:00', 44, '07:56:00', '09:00:00', 3434, 101, 70, 'Petras'),
(5, '2018-04-04', 'kazlu ruda', '04:04:00', 4444, '05:05:00', 55, '07:07:00', '08:08:00', 4666, 222, 36, 'Petras'),
(6, '2018-04-20', 'Madrid', '02:02:00', 22222, '10:10:00', 89, '12:00:00', '23:55:00', 30000, 7778, 327, 'Petras'),
(7, '2018-04-05', 'Kauno grudai', '06:06:00', 88777, '07:07:00', 35, '08:08:00', '09:09:00', 88999, 222, 30, 'Jonas'),
(8, '2018-04-06', 'grazu grazu', '04:04:00', 55667, '05:05:00', 22, '06:06:00', '07:07:00', 55777, 110, 0, 'Jonas'),
(9, '2018-04-09', 'graziai grazu', '03:03:00', 3333, '04:04:00', 33, '05:05:00', '05:05:00', 3666, 333, 0, 'Jonas'),
(10, '2018-04-01', 'grazu grazu', '01:01:00', 1111, '02:02:00', 33, '03:03:00', '04:04:00', 1222, 111, 0, 'Jonas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(20) NOT NULL DEFAULT 'driver',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `userType`, `createdAt`) VALUES
(1, 'Petras', '$2y$10$Gj7x09qU2O4twbLq3Fpyq.rQBZ7VCZ1LmcuOv85MlA3/SW3UVpSwO', 'manager', '2018-04-02 21:25:36'),
(2, 'Jonas', '$2y$10$Gj7x09qU2O4twbLq3Fpyq.rQBZ7VCZ1LmcuOv85MlA3/SW3UVpSwO', 'driver', '2018-04-03 17:21:32'),
(3, 'Maryte', '$2y$10$Gj7x09qU2O4twbLq3Fpyq.rQBZ7VCZ1LmcuOv85MlA3/SW3UVpSwO', 'accountant', '2018-04-05 07:41:26'),
(4, 'testing', '$2y$10$Gj7x09qU2O4twbLq3Fpyq.rQBZ7VCZ1LmcuOv85MlA3/SW3UVpSwO', 'driver', '2018-04-06 12:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `make` varchar(12) NOT NULL,
  `model` varchar(12) NOT NULL,
  `plateNumber` varchar(7) NOT NULL,
  `standingFuelCon` smallint(3) NOT NULL COMMENT 'l/h',
  `drivingFuelCon` smallint(3) NOT NULL COMMENT 'l/h',
  `loadingFuelCon` smallint(3) NOT NULL COMMENT 'l/h',
  `speedo` int(10) NOT NULL COMMENT 'km',
  `drivingDate` date NOT NULL,
  `drivedBy` varchar(25) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plateNumber` (`plateNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `make`, `model`, `plateNumber`, `standingFuelCon`, `drivingFuelCon`, `loadingFuelCon`, `speedo`, `drivingDate`, `drivedBy`, `createdAt`) VALUES
(5, 'Fiat', 'Ducato', 'DDD333', 5, 12, 7, 33433, '0000-00-00', 'New Car', '2018-04-02 21:00:00'),
(6, 'FORD', 'TRANSIT', 'DDD336', 5, 12, 7, 88999, '2018-04-05', 'Jonas', '2018-04-03 16:14:44'),
(7, 'Renault', 'Trafic', 'GGG222', 1, 16, 4, 30000, '2018-04-04', 'Petras', '2018-04-04 17:30:58'),
(8, 'Re', 'Megane', 'CCC223', 6, 6, 6, 77777, '0000-00-00', 'New Car', '2018-04-06 11:41:06');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
