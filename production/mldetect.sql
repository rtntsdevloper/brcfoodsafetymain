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
-- Table structure for table `mldetect`
--

CREATE TABLE `mldetect` (
  `id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `checked` varchar(255) NOT NULL,
  `rejected` varchar(255) NOT NULL,
  `checkedby` varchar(255) NOT NULL,
  `signed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mldetect`
--

INSERT INTO `mldetect` (`id`, `date`, `batch`, `checked`, `rejected`, `checkedby`, `signed`) VALUES
(1, '2025-07-16', 'dffdg', '2025-07-15', 'dgfdf', 'gdfg', 'fdgdf'),
(3, '2025-07-31', 'fdgfgfhfgh', '2025-07-23', 'fghfg', 'hfgfh', 'fghfg'),
(4, '2025-08-06', 'fhfgh', '2025-07-17', 'ghfh', 'fgh', 'fghfg'),
(5, '2025-07-31', 'fgh', '2025-07-22', 'fhg', 'fghg', 'gf'),
(6, '2025-07-24', 'gfhgf', '2025-07-17', 'gfhf', 'hfgh', 'gf'),
(7, '2025-07-24', 'fdgdfg', '2025-07-21', 'fdf', 'dfgdfg', 'gdfg'),
(8, '2025-07-30', 'dfgg', '2025-07-21', 'fdfdg', 'dfgdfg', 'fdg'),
(9, '2025-07-30', 'fdg', '2025-07-23', 'fg', 'dfgdfg', 'dfgd'),
(10, '2025-08-01', 'dgf', '2025-07-15', 'gfdg', 'dfgdf', 'dfgdfg'),
(11, '2025-07-25', 'gdfg', '2025-07-22', 'dfgdf', 'dfg', 'fd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mldetect`
--
ALTER TABLE `mldetect`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mldetect`
--
ALTER TABLE `mldetect`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
