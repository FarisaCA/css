-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 03:20 AM
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
  `book_id` int(11) NOT NULL,
  `flight_id` int(11) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `class` varchar(30) NOT NULL,
  `seat` varchar(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `cancel` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`book_id`, `flight_id`, `name`, `gender`, `dob`, `email`, `class`, `seat`, `status`, `cancel`) VALUES
(19, 1, 'Fairoosa', 'female', '2024-12-18', 'fairo@gmail.com', 'economy', 'A1', 1, 1),
(25, 1, 'Sana ', 'female', '2024-12-11', 'sana@gmail.com', 'economy', 'D10', 1, 0),
(27, 12, 'Aysha', 'female', '2017-12-07', 'aysha@gmail.com', 'economy', 'C1', 1, 0),
(30, 19, 'Farisa CA', 'female', '2024-12-04', 'aysha@gmail.com', 'economy', 'A1', 1, 0),
(31, 1, 'Nihal Sidheek', 'male', '2024-12-03', 'nihal@gmail.com', 'economy', 'C1', 1, 0),
(33, 12, 'Fairoosa', 'female', '2024-12-20', 'fairu@gmail.com', 'economy', 'F16', 1, 0),
(40, 16, 'Aysha', 'female', '2024-12-11', 'fairo@gmail.com', 'economy', 'Q5', 1, 0),
(41, 20, 'Nihal Sidheek', 'male', '2024-12-02', 'nihal@gmail.com', 'economy', 'F20', 1, 0);

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
  `status` tinyint(1) DEFAULT 1,
  `f_status` enum('Pending','Departed','Delayed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `flight_no`, `departure`, `d_datetime`, `arrival`, `r_datetime`, `baggage`, `price`, `status`, `f_status`) VALUES
(1, 'ATR', 'Pune,pune International Airport', '2024-11-13 00:00:00', 'Kochi, Kochi International Airport', '2024-11-01 03:20:00', 'Cabin:2kg', 10000.00, 1, 'Departed'),
(12, 'A12', 'Pune,pune International Airport', '2024-12-11 22:18:00', 'kochi,kochi International Airport', '2024-12-20 22:19:00', 'Cabin:8kg', 2900.00, 1, 'Pending'),
(13, 'ATR', 'Kochi,kochi International Airport', '2024-12-13 21:20:00', 'Pune,Pune International Airport', '2024-12-20 22:20:00', 'check-in:8', 4000.00, 1, 'Pending'),
(14, 'A320', 'Agra civil Airport,kheria', '2024-12-20 10:04:00', 'Kozhikode,Calicut International Airport', '2024-12-21 05:06:00', 'Cabin:4kg,', 1350.00, 1, 'Pending'),
(15, 'ATR90', 'Chennai,Chennai International Airport', '2024-12-09 16:06:00', 'kochi,kochi International Airport', '2024-12-31 07:00:00', 'Cabin:4kg,', 450.00, 1, 'Pending'),
(16, ' atr70', 'Bhubaneswar,Biju Patnaik Airport', '2024-12-15 10:00:00', 'Pune,Pune International Airport', '2024-12-22 10:00:00', 'cabin:8 kg', 4900.00, 1, 'Pending'),
(17, 'ATR 1', 'Kochi,kochi International Airport', '2024-12-25 03:00:00', 'Agra civil Airport,kheria', '2024-12-30 04:00:00', 'cabin:7kg', 7000.00, 1, 'Pending'),
(18, 'ATR50', 'Pune,pune International Airport', '2024-12-08 10:00:00', 'kochi,kochi International Airport', '2024-12-22 04:00:00', 'cabin:9 k ', 6700.00, 1, 'Pending'),
(19, 'ATR20', 'Bhubaneswar,Biju Patnaik Airport', '2024-12-20 03:05:00', 'Agra civil Airport,kheria', '2024-12-04 09:08:00', 'Cabin:4kg', 1233.00, 1, 'Pending'),
(20, 'art4', 'Kozhikode,Calicut International Airport', '2024-12-25 20:00:00', 'Pune,Pune International Airport', '2024-12-28 09:00:00', 'Cabin:5 kg', 50000.00, 1, 'Pending'),
(21, 'art40', 'Chennai,Chennai International Airport', '2024-12-17 10:00:00', 'Pune,Pune International Airport', '2024-12-29 03:00:00', 'cabin:80 k', 90000.00, 1, 'Pending');

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
('aysha@gmail.com', 'aysha1111', 'user'),
('fairo@gmail.com', 'fairu1111', 'user'),
('farisa@gmail.com', 'farisa1111', 'fmanager'),
('kaiju@gmail.com', 'kaiju1111', 'fmanager'),
('nihal@gmail.com', 'nihal1111', 'user'),
('safna@gmail.com', 'safna1111', 'fmanager'),
('sana@gmail.com', 'sana1111', 'user'),
('shemeena@gmail.com', 'shemi1111', 'fmanager');

-- --------------------------------------------------------

--
-- Table structure for table `manager_reg`
--

CREATE TABLE `manager_reg` (
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` bigint(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager_reg`
--

INSERT INTO `manager_reg` (`name`, `email`, `number`, `address`, `user_type`, `status`) VALUES
('farisa C A', 'farisa@gmail.com', 5498756545, 'aluva p.o,aluva', 'fmanager', 1),
('Kadeeja', 'kaiju@gmail.com', 6543287965, 'Okkal', 'fmanager', 1),
('Safna V A', 'safna@gmail.com', 9876543210, 'Ponjasserry p.o Perumbavoor', 'fmanager', 1),
('Shemeena', 'shemeena@gmail.com', 8765432187, 'perumbavoor', 'fmanager', 1);

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
('Aysha ', 'aysha@gmail.com', 4567893425, 'Aluva', 'user', 'female'),
('Fairoosa C A', 'fairo@gmail.com', 9876543214, 'prbvr', 'user', 'female'),
('Nihal Sidheek', 'nihal@gmail.com', 8075433096, 'perumbavoor', 'user', 'male'),
('sana', 'sana@gmail.com', 9526278593, 'vadayath', 'user', 'female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `flight_id` (`flight_id`);

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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`flight_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
