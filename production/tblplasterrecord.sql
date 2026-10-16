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
-- Table structure for table `tblplasterrecord`
--

CREATE TABLE `tblplasterrecord` (
  `id` int(255) NOT NULL,
  `dateissue` varchar(255) NOT NULL,
  `plasterissue` varchar(255) NOT NULL,
  `issueby` varchar(255) NOT NULL,
  `plaster` varchar(255) NOT NULL,
  `checkedby` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblplasterrecord`
--

INSERT INTO `tblplasterrecord` (`id`, `dateissue`, `plasterissue`, `issueby`, `plaster`, `checkedby`) VALUES
(1, '2025-07-22', 'saSA', 'SDASD', 'Sa', 'SASas'),
(2, '2025-07-30', 'asa', 'sasass', 'AA', 'aSasS'),
(3, '2025-07-25', 'gfghgh', 'gfhfgh', 'fhfgh', 'gfhfg'),
(4, '2025-07-15', 'hgfh', 'ghfghgh', 'fghfgh', 'fghfgh'),
(5, '2025-07-23', 'ghfgh', 'fghfghfg', 'fgh', 'hfghfgh'),
(6, '2025-07-27', 'gfhfg', 'gfgfgfg', 'hgfgf', 'hfghgf'),
(7, '2025-07-23', 'ghfh', 'fghgf', 'gffg', 'hgfgg'),
(8, '2025-07-16', 'rtrty', 'rtyrtyt', 'yrty', 'tyrtrt'),
(9, '2025-07-29', 'tyrt', 'yrtyrty', 'ry', 'rtyrty'),
(10, '2025-07-23', 'dfsdf', 'dfsdf', 'sdfsdf', 'sdsdfsdf'),
(11, '2025-07-30', 'sfdsd', 'fsdfsf', 'fsf', 'sdfs'),
(12, '2025-07-16', 'fsdfs', 'sdfs', 'fsf', 'fsdfs'),
(13, '2025-07-23', 'fdsf', 'sdfsdf', 'sdf', 'sfsfs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblplasterrecord`
--
ALTER TABLE `tblplasterrecord`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblplasterrecord`
--
ALTER TABLE `tblplasterrecord`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
