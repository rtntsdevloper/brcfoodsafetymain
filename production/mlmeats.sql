-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 08:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brcg`
--

-- --------------------------------------------------------

--
-- Table structure for table `mlmeats`
--

CREATE TABLE `mlmeats` (
  `id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `disc` varchar(255) NOT NULL,
  `stationary` varchar(255) NOT NULL,
  `stationaryby` varchar(255) NOT NULL,
  `returned` varchar(255) NOT NULL,
  `sign` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mlmeats`
--

INSERT INTO `mlmeats` (`id`, `date`, `disc`, `stationary`, `stationaryby`, `returned`, `sign`) VALUES
(1, '2025-07-22', '2025-07-28', 'sdfdsd', 'dfg', 'Yes', 'fgdfgdfgfd'),
(2, '2025-07-29', '2025-07-22', 'fdg', 'dfgd', 'Yes', 'fgdfgd'),
(3, '2025-07-24', '2025-07-22', 'dfg', 'dfgdfg', 'Yes', 'gdfgg'),
(4, '2025-07-21', '2025-07-28', 'gfhfgh', 'rtrgf', 'No', 'ghfgh'),
(5, '2025-07-31', '2025-07-21', 'hfgh', 'ghfh', 'Yes', 'hfgh'),
(6, '2025-07-25', '2025-07-21', 'fhgh', 'fghf', 'Yes', 'fghfgh'),
(7, '2025-07-23', '2025-07-22', 'fgh', 'fgh', 'Yes', 'ghfghgf'),
(8, '2025-07-24', '2025-07-22', 'ghfhfgh', 'fghg', 'Yes', 'fghg'),
(9, '2025-07-24', '2025-07-20', 'dsdsd', 'sdf', 'Yes', 'sdsaf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mlmeats`
--
ALTER TABLE `mlmeats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mlmeats`
--
ALTER TABLE `mlmeats`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
