-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2022 at 10:18 PM
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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` int NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '.',
  `admin` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `firstname`, `lastname`, `email`, `mobile`, `password`, `admin`) VALUES
(2, 'Desiree', 'Collier', 'Maecenas@non.co.uk', 0, '.', 0),
(3, 'Irene', 'Walker', 'id.erat.Etiam@id.org', 0, '.', 0),
(4, 'Forrest', 'Baldwin', 'eget.nisi.dictum@a.com', 0, '.', 0),
(5, 'Beverly', 'Sellers', 'ultricies.sem@pharetraQuisqueac.co.uk', 0, '.', 0),
(6, 'Glenna', 'Kinney', 'dolor@orcilobortisaugue.org', 0, '.', 0),
(7, 'Montana', 'Gallagher', 'sapien.cursus@ultriciesdignissimlacus.edu', 0, '.', 0),
(8, 'Harlan', 'Lara', 'Duis@aliquetodioEtiam.edu', 0, '.', 0),
(9, 'Benjamin', 'King', 'mollis@Nullainterdum.org', 0, '.', 0),
(10, 'Rajah', 'Olsen', 'Vestibulum.ut.eros@nequevenenatislacus.ca', 0, '.', 0),
(11, 'Castor', 'Kelly', 'Fusce.feugiat.Lorem@porta.co.uk', 0, '.', 0),
(12, 'Omar', 'Oconnor', 'eu.turpis@auctorvelit.co.uk', 0, '.', 0),
(13, 'Porter', 'Leonard', 'dui.Fusce@accumsanlaoreet.net', 0, '.', 0),
(14, 'Buckminster', 'Gaines', 'convallis.convallis.dolor@ligula.co.uk', 0, '.', 0),
(15, 'Hunter', 'Rodriquez', 'ridiculus.mus.Donec@est.co.uk', 0, '.', 0),
(16, 'Zahir', 'Harper', 'vel@estNunc.com', 0, '.', 0),
(17, 'Sopoline', 'Warner', 'vestibulum.nec.euismod@sitamet.co.uk', 0, '.', 0),
(18, 'Burton', 'Parrish', 'consequat.nec.mollis@nequenonquam.org', 0, '.', 0),
(19, 'Abbot', 'Rose', 'non@et.ca', 0, '.', 0),
(20, 'Barry', 'Burks', 'risus@libero.net', 0, '.', 0),
(24, 'wes', 'wes', 'wesde66@gmail.com', 274974300, '$2y$10$bYuIP5dazbVNTw76sD/90.92DRpvjkyO31MDv6FKZXQTq2ReGXd7u', 0),
(40, 'Thomas', 'First', 'thomas@first.com', 211232652, '$2y$10$imLzMdCIusvcG/Z9/dcpC.Po/YtZshNEb0sEK2ADt.X7NdnGLblJK', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
