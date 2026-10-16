-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 09:21 AM
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
-- Database: `brcg1`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblfollowup`
--

CREATE TABLE `tblfollowup` (
  `id` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `eid` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `attach` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `add_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `follow` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfollowup`
--

INSERT INTO `tblfollowup` (`id`, `date`, `eid`, `method`, `attach`, `note`, `add_on`, `follow`) VALUES
(1, '2025-06-10', '1', 'Email', '', '', '2025-06-04 11:33:44', 'by Client'),
(2, '2025-06-19', '1', 'Email', '', '', '2025-06-04 11:34:11', 'by Us'),
(3, '2025-07-02', '1', 'Email', '', '', '2025-06-04 11:34:43', 'by Us'),
(4, '2025-06-24', '1', 'Email', '', 'dsds', '2025-06-04 11:37:42', 'by Us'),
(5, '2025-06-18', '1', 'Email', '', 'dfd', '2025-06-20 06:11:21', 'by Us');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblfollowup`
--
ALTER TABLE `tblfollowup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblfollowup`
--
ALTER TABLE `tblfollowup`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
