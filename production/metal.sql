-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 08:39 AM
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
-- Table structure for table `metal`
--

CREATE TABLE `metal` (
  `id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `checked` varchar(255) NOT NULL,
  `rejected` varchar(255) NOT NULL,
  `signed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metal`
--

INSERT INTO `metal` (`id`, `date`, `batch`, `checked`, `rejected`, `signed`) VALUES
(1, '2025-07-22', '123ff', '2025-07-24', 'yes', 'balu'),
(5, '2025-07-30', 'sfdsdf', '2025-07-15', 'sdfs', 'sdfsdf'),
(6, '2025-07-15', 'sddfs', '2025-07-20', 'sdf', 'sdfsdf'),
(7, '2025-07-23', 'fsdf', '2025-07-29', 'sdfs', 'fsdfsd'),
(8, '2025-07-25', 'dfsf', '2025-07-21', 'sdfsd', 'dfsdf'),
(9, '2025-07-23', 'sdfsdd', '2025-07-21', 'fsdf', 'fdsfsdd'),
(10, '2025-07-23', 'dsfsd', '2025-07-23', 'fsdf', 'dsfsd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `metal`
--
ALTER TABLE `metal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `metal`
--
ALTER TABLE `metal`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
