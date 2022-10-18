-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2022 at 07:19 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guest_record`
--

-- --------------------------------------------------------

--
-- Table structure for table `approval`
--

CREATE TABLE `approval` (
  `id` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `approval`
--

INSERT INTO `approval` (`id`, `name`) VALUES
('AQ23F', 'Pa Endo'),
('BH8N8', 'Pa Eko'),
('D42FV', 'Bu Rosi'),
('DMKL2', 'Pa Sapto'),
('LIFN3', 'Pa Molas'),
('M14FC', 'Pa Noor'),
('PLW24', '-');

-- --------------------------------------------------------

--
-- Table structure for table `db_users`
--

CREATE TABLE `db_users` (
  `id` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `db_users`
--

INSERT INTO `db_users` (`id`, `name`, `email`, `password`, `img`, `status`, `created`) VALUES
('NDVRT', 'Utac Indonesia', 'guest@utac-indonesia.com', '$2y$10$04rO01Cn5l8GZMf5CnVJU.WctB1rlRB9fuUCvT78YEwWdbLrhwalG', 'default.jpg', 1, 1645428188);

-- --------------------------------------------------------

--
-- Table structure for table `guest_user_record`
--

CREATE TABLE `guest_user_record` (
  `id` varchar(255) NOT NULL,
  `gz_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `identity` varchar(20) NOT NULL,
  `temp` varchar(5) NOT NULL,
  `vaksin` varchar(255) NOT NULL,
  `card_numb` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `guest_zone_record`
--

CREATE TABLE `guest_zone_record` (
  `id` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `relation` varchar(5) NOT NULL,
  `other_relation` varchar(255) NOT NULL,
  `bussines` varchar(255) NOT NULL,
  `area` varchar(5) NOT NULL,
  `other_area` varchar(255) NOT NULL,
  `total_guest` int(3) NOT NULL,
  `date_in` int(20) NOT NULL,
  `date_out` int(20) NOT NULL,
  `date_created` int(20) NOT NULL,
  `pic_name` varchar(255) NOT NULL,
  `pic_dept` varchar(255) NOT NULL,
  `pic_agree` int(1) NOT NULL,
  `pic_note` varchar(1000) NOT NULL,
  `in_by` varchar(5) NOT NULL,
  `out_by` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE `header` (
  `id` varchar(5) NOT NULL,
  `title` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `header`
--

INSERT INTO `header` (`id`, `title`, `brand`, `img`, `description`) VALUES
('VHJAV', 'UTAC - Utac Indonesia', 'UTAC INDONESIA', '9YbL0McORgOV3rPsurP0EZzQdHY219DlOEEY1XpkuIIQ9R9UZ6.png', 'UTAC - Utac Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `history_login`
--

CREATE TABLE `history_login` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `device` varchar(1000) NOT NULL,
  `created` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE `relation` (
  `id` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relation`
--

INSERT INTO `relation` (`id`, `name`) VALUES
('CUSTO', 'Customer'),
('GOVER', 'Government'),
('OTHER', 'Others'),
('SUPPL', 'Supplier'),
('VENDO', 'Vendor');

-- --------------------------------------------------------

--
-- Table structure for table `zone_access`
--

CREATE TABLE `zone_access` (
  `id` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `zone` varchar(5) NOT NULL,
  `appr` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zone_access`
--

INSERT INTO `zone_access` (`id`, `name`, `zone`, `appr`) VALUES
('23FSF', 'Finishgood Inlet Out', 'FSDSX', 'LIFN3'),
('28SDK', 'Server out', 'FSDSX', 'D42FV'),
('345FS', 'Conference Room 1', 'NF8DV', 'BH8N8'),
('34F7F', 'Smartcard Out', 'FSDSX', 'M14FC'),
('34FCS', 'Finishgood Inlet In', 'FSDSX', 'LIFN3'),
('398FX', 'Turnstile Kanan', 'FSDSX', 'M14FC'),
('3C56F', 'Klinik Area', 'NF8DV', 'BH8N8'),
('ACASF', 'Lobby', 'NF8DV', 'PLW24'),
('AD23G', 'Reject Room In', 'FSDSX', 'LIFN3'),
('BCHJS', 'CCTV Room', 'FSDSX', 'BH8N8'),
('BCI3S', 'Reject Room Out', 'FSDSX', 'LIFN3'),
('C34GD', 'Conference Room 2', 'NF8DV', 'BH8N8'),
('CADGD', 'WH Shiping', 'NF8DV', 'DMKL2'),
('CAF4G', 'Locker Shoes 1 - Kiri', 'NF8DV', 'BH8N8'),
('CARE3', 'Finishgood Shipping In', 'NF8DV', 'LIFN3'),
('CAS34', 'Inlet Out', 'FSDSX', 'M14FC'),
('CAST4', 'HRD-GA', 'NF8DV', 'BH8N8'),
('CDSF3', 'Die bank Out', 'FSDSX', 'DMKL2'),
('CV3FZ', 'Finishgood In', 'NF8DV', 'LIFN3'),
('CVSD4', 'Locker Shoes 3', 'NF8DV', 'BH8N8'),
('CVSDF', 'Exit Factory C Areas', 'FSDSX', 'M14FC'),
('DFV21', 'Information System', 'NF8DV', 'D42FV'),
('F242F', 'Die bank In', 'FSDSX', 'DMKL2'),
('FN4TD', 'Smartcard In', 'FSDSX', 'M14FC'),
('G4V5D', 'Scrap Room In', 'NF8DV', 'M14FC'),
('GER42', 'Scrap Room Out', 'NF8DV', 'M14FC'),
('JIF93', 'Server IN', 'FSDSX', 'D42FV'),
('JMTYH', 'Lactase Room', 'NF8DV', 'BH8N8'),
('KJTYH', 'Inlet In', 'FSDSX', 'M14FC'),
('LF903', 'Accounting', 'NF8DV', 'AQ23F'),
('NFSO4', 'Turnstile Kiri ', 'FSDSX', 'M14FC'),
('OTHER', 'Other', 'B823F', 'DMKL2'),
('SDCSG', 'WH In', 'NF8DV', 'DMKL2'),
('SDFV4', 'Locker Shoes Tengah', 'NF8DV', 'BH8N8'),
('VE44G', 'Finishgood Shipping Out', 'NF8DV', 'LIFN3');

-- --------------------------------------------------------

--
-- Table structure for table `zone_area`
--

CREATE TABLE `zone_area` (
  `id` varchar(5) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zone_area`
--

INSERT INTO `zone_area` (`id`, `name`) VALUES
('B823F', 'ZONE C'),
('FSDSX', 'ZONE A'),
('NF8DV', 'ZONE B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approval`
--
ALTER TABLE `approval`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `db_users`
--
ALTER TABLE `db_users`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `guest_user_record`
--
ALTER TABLE `guest_user_record`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `guest_zone_record`
--
ALTER TABLE `guest_zone_record`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `header`
--
ALTER TABLE `header`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `history_login`
--
ALTER TABLE `history_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relation`
--
ALTER TABLE `relation`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `zone_access`
--
ALTER TABLE `zone_access`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `zone_area`
--
ALTER TABLE `zone_area`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_login`
--
ALTER TABLE `history_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
