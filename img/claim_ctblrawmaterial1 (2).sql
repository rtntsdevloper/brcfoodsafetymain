-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 05:53 AM
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
-- Table structure for table `tblrawmaterial1`
--

CREATE TABLE `tblrawmaterial1` (
  `id` int(11) NOT NULL,
  `category` enum('Raw Material','Primary Packaging','Secondary Packaging') NOT NULL,
  `pcode` varchar(50) NOT NULL,
  `pname` varchar(100) NOT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `supid` int(11) NOT NULL,
  `chiller` enum('Chilled','Ambient','Frozen','') DEFAULT NULL,
  `shelflife` enum('Yes','N/A') DEFAULT NULL,
  `cclaim` varchar(255) DEFAULT NULL COMMENT 'Claim certificate file path',
  `specdate` date DEFAULT NULL COMMENT 'Product Specification Date',
  `reviewdate` date DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL COMMENT 'Country of Origin',
  `pclaim` enum('Yes','No') DEFAULT NULL COMMENT 'Is there any claim?',
  `claimspecify` text DEFAULT NULL COMMENT 'Claim details if pclaim=Yes',
  `freeze` enum('Yes','No') DEFAULT NULL COMMENT 'Is product suitable for freezing?',
  `freezelife` varchar(50) DEFAULT NULL COMMENT 'Frozen shelf life if freeze=Yes',
  `purchase` enum('Yes','No') NOT NULL COMMENT 'Is product purchased from manufacturer?',
  `custody` enum('Yes','No') DEFAULT NULL COMMENT 'Is Chain of Custody applicable?',
  `chainspecify` text DEFAULT NULL COMMENT 'Chain of Custody details if custody=Yes',
  `upload_file` varchar(255) DEFAULT NULL COMMENT 'Chain of Custody document',
  `packaging_migration` enum('Yes','No','N/A') DEFAULT 'N/A' COMMENT 'Packaging migration certificate available',
  `migration_date` date DEFAULT NULL,
  `migration_certificate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `manuf_name` varchar(255) NOT NULL,
  `manuf_location` varchar(255) NOT NULL,
  `manuf_address` varchar(255) NOT NULL,
  `onceshelf` varchar(255) NOT NULL,
  `manfact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblrawmaterial1`
--

INSERT INTO `tblrawmaterial1` (`id`, `category`, `pcode`, `pname`, `pic`, `supid`, `chiller`, `shelflife`, `cclaim`, `specdate`, `reviewdate`, `origin`, `pclaim`, `claimspecify`, `freeze`, `freezelife`, `purchase`, `custody`, `chainspecify`, `upload_file`, `packaging_migration`, `migration_date`, `migration_certificate`, `created_at`, `updated_at`, `manuf_name`, `manuf_location`, `manuf_address`, `onceshelf`, `manfact`) VALUES
(1, 'Primary Packaging', 'aaaaa', 'aaaaa', 'WhatsApp Image 2024-12-23 at 15.00.03 2.jpeg', 10, '', '', 'claim_cbrcg(2).sql', '2025-07-14', '2025-07-22', 'indiaaa', 'Yes', '', 'Yes', 'efe', '', 'Yes', 'erferf', 'Work Update Dated  18 June 2025  2.docx', 'Yes', '2025-07-28', 'migration_12.png', '2025-07-09 09:25:23', '2025-07-09 09:25:23', '', '', '', '', ''),
(4, 'Raw Material', 'f', 'dfddf', 'image (2).jpg', 8, 'Chilled', 'Yes', 'claim_cWork Update Dated  07 July 2025 1.docx', '2025-07-27', '2025-07-28', 'fsdf', 'Yes', '', 'Yes', 'fef', 'No', 'Yes', 'refr', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (2).docx', 'N/A', '0000-00-00', '', '2025-07-09 09:29:12', '2025-07-09 09:29:12', '', '', '', '', ''),
(9, 'Raw Material', 'ert', 'aaaaa', 'image (2).jpg', 10, 'Chilled', 'Yes', 'claim_ctblrawsupplier(1).sql', '2025-07-27', '2025-07-18', 'tert', 'Yes', '', 'Yes', 'tretrt', 'No', 'Yes', 'rtet', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (1).docx', 'N/A', '0000-00-00', '', '2025-07-09 09:35:15', '2025-07-09 09:35:15', '', '', '', '', ''),
(10, 'Primary Packaging', 'ws', 'sss', 'image (2).jpg', 12, '', '', 'claim_ctblrawmaterial(1).sql', '2025-07-29', '2025-07-25', 'sss', 'Yes', '', 'Yes', 'sss', 'No', 'Yes', 'ss', 'observations_1735972781_0_1736337658_0 (1) (2).docx', 'No', '0000-00-00', '', '2025-07-09 09:44:25', '2025-07-09 09:44:25', '', '', '', '', ''),
(11, 'Raw Material', 'ewfdew', 'ffef', 'image (2).jpg', 9, 'Ambient', 'Yes', 'claim_ctblrawmaterial(1).sql', '2025-07-22', '2025-07-14', 'indiaaa', 'Yes', '', 'Yes', 'fewf', 'No', 'Yes', 'fefw', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (3).docx', 'N/A', '0000-00-00', '', '2025-07-09 09:52:54', '2025-07-09 09:52:54', '', '', '', '', ''),
(12, 'Raw Material', 'erfr', 'aaaaa', 'image (2).jpg', 8, 'Ambient', 'N/A', 'claim_ctblrawsupplier(1).sql', '2025-07-20', '2025-07-25', 'indiaaa', 'Yes', '', 'Yes', 'fer', 'Yes', 'Yes', 'ferf', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (4).docx', 'N/A', NULL, NULL, '2025-07-09 10:17:52', '2025-07-09 10:17:52', '', '', '', '', ''),
(14, 'Primary Packaging', 'dfd', 'ds', 'image (2).jpg', 2, '', '', 'claim_ctblrawsupplier(1).sql', '2025-07-07', '2025-07-14', 'india', 'Yes', '', 'Yes', 'fdsf', 'Yes', 'Yes', 'dsdssdf', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (5).docx', 'N/A', NULL, NULL, '2025-07-09 10:18:58', '2025-07-09 10:18:58', '', '', '', '', ''),
(16, 'Primary Packaging', 'xcvdf', 'ddfds', 'back.jpg', 3, '', '', '', '2025-07-24', '2025-07-18', 'dfd', 'Yes', '', 'Yes', '', 'Yes', 'Yes', 'fdfdf', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (3).docx', 'Yes', '2025-07-31', 'migration_SUP01150525006321.pdf', '2025-07-09 11:02:32', '2025-07-09 11:02:32', '', '', '', '', ''),
(19, 'Primary Packaging', 'xdc', 'sd', 'image (2).jpg', 13, '', '', 'claim_ctblrawmaterial(1).sql', '2025-07-30', '2025-07-17', 'sd', 'Yes', '', 'Yes', 'sdd', 'Yes', 'Yes', 'sdfcsd', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (3).docx', 'Yes', '2025-07-24', 'migration_SUP01150525006321.pdf', '2025-07-09 11:03:40', '2025-07-09 11:03:40', '', '', '', '', ''),
(21, 'Primary Packaging', 'freg', 'aaaaa', '', 2, '', '', 'claim_ctblrawmaterial(1).sql', '2025-07-13', '2025-07-17', 'grre', 'Yes', '', 'Yes', 'rgeg', 'Yes', 'Yes', 'reger', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (2).docx', 'Yes', '2025-07-29', 'migration_SUP01150525006321.pdf', '2025-07-09 11:07:44', '2025-07-09 11:07:44', '', '', '', 'trhgrt', ''),
(22, 'Raw Material', 'ee', 'feef', 'image (2).jpg', 9, 'Ambient', 'N/A', 'claim_cFinal SOPs 4.zip', '2025-07-25', '2025-07-29', 'sss', 'Yes', '', 'Yes', 'ferf', 'Yes', 'Yes', 'ferf', 'REC- 4.10.001 Metal Detection Record v1 1 1 1 (1) (1).docx', 'N/A', '0000-00-00', '', '2025-07-10 03:47:05', '2025-07-10 03:47:05', '', '', '', 'ewfe', ''),
(23, 'Primary Packaging', 'efer', 'aaaaa', 'image (2).jpg', 2, '', '', '', '2025-07-10', '2025-07-26', 'ferfer', 'Yes', '', 'Yes', 'fref', 'No', 'Yes', 'erfef', 'Work Update Dated  18 June 2025  2.docx', 'Yes', '2025-07-24', 'migration_SUP01150525006321.pdf', '2025-07-10 03:47:51', '2025-07-10 03:47:51', '', '', '', 'eferf', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblrawmaterial1`
--
ALTER TABLE `tblrawmaterial1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pcode` (`pcode`),
  ADD KEY `supid` (`supid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblrawmaterial1`
--
ALTER TABLE `tblrawmaterial1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
