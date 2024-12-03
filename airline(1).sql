-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 04:23 AM
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
-- Database: `airline`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `name` varchar(50) NOT NULL,
  `email` int(50) NOT NULL,
  `flight` varchar(5) NOT NULL,
  `seat` int(5) NOT NULL,
  `price` int(5) NOT NULL,
  `type` int(15) NOT NULL,
  `date` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`name`, `email`, `flight`, `seat`, `price`, `type`, `date`) VALUES
('Nihal Sidheek', 0, '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `flight_no` varchar(10) NOT NULL,
  `departure` varchar(150) NOT NULL,
  `d_datetime` datetime NOT NULL,
  `arrival` varchar(150) NOT NULL,
  `r_datetime` datetime NOT NULL,
  `baggage` varchar(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `flight_no`, `departure`, `d_datetime`, `arrival`, `r_datetime`, `baggage`, `price`, `status`) VALUES
(1, 'ATR', 'Pune, Pune International Airport', '2024-11-13 00:00:00', 'Kochi, Kochi International Airport', '2024-11-13 00:00:00', '07:08:00', 1234.00, 1),
(2, 'A320', 'Chennai, Chennai International Airport', '2024-11-14 00:00:00', 'Delhi, Indiragandhi International Airport', '0000-00-00 00:00:00', '05:06:00', 1000.00, 0),
(9, 'A320', 'kochi', '2024-12-20 02:05:00', 'Agra civil Airport,kheria', '2024-12-21 05:06:00', 'Cabin:2kg,', 1500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `user_type`) VALUES
('admin@gmail.com', 'admin1111', 'admin'),
('farisa@gmail.com', 'farisa1111', 'fmanager'),
('nihal@gmail.com', 'nihal1111', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `manager_reg`
--

CREATE TABLE `manager_reg` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` bigint(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_reg`
--

INSERT INTO `manager_reg` (`name`, `email`, `number`, `address`, `user_type`) VALUES
('farisa', 'farisa@gmail.com', 5498756546, 'aluva p.o,aluva', 'fmanager');

-- --------------------------------------------------------

--
-- Table structure for table `user_reg`
--

CREATE TABLE `user_reg` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` bigint(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reg`
--

INSERT INTO `user_reg` (`name`, `email`, `number`, `address`, `user_type`, `gender`) VALUES
('Nihal Sidheek', 'nihal@gmail.com', 8075433096, 'perumbavoor', 'user', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `manager_reg`
--
ALTER TABLE `manager_reg`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `user_reg`
--
ALTER TABLE `user_reg`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `number` (`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
