-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2022 at 02:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motueka`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `bookingID` int NOT NULL,
  `checkIn` date NOT NULL,
  `checkout` date NOT NULL,
  `contactNum` int NOT NULL,
  `extras` varchar(255) DEFAULT NULL,
  `roomReview` varchar(255) DEFAULT NULL,
  `roomID` int UNSIGNED NOT NULL,
  `customerID` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingID`, `checkIn`, `checkout`, `contactNum`, `extras`, `roomReview`, `roomID`, `customerID`) VALUES
(1, '2022-11-22', '2022-12-01', 274976325, 'HHHH', 'KKKKK', 12, 18),
(2, '2022-12-21', '2023-01-23', 212321321, 'These are the extras that will be required', 'Have not stayed yet', 9, 2),
(6, '2022-12-01', '2022-12-02', 274974300, 'Hello', 'Hello', 10, 24),
(9, '2022-12-14', '2022-12-21', 211232652, 'Hats', NULL, 11, 24),
(10, '2022-12-14', '2022-12-21', 211232652, '', NULL, 8, 40),
(11, '2022-12-14', '2022-12-21', 211232652, '', NULL, 4, 40),
(12, '2022-12-14', '2022-12-21', 211232652, '', NULL, 5, 40),
(13, '2022-12-14', '2022-12-15', 211232652, '', NULL, 2, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `bookings_ibfk_1` (`roomID`),
  ADD KEY `customerID` (`customerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
