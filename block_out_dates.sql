-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2022 at 08:38 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bike_hiring_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `block_out_dates`
--

CREATE TABLE `block_out_dates` (
  `date_id` int(10) NOT NULL,
  `date_value` varchar(11) NOT NULL,
  `date_day` int(2) NOT NULL,
  `date_month` int(2) NOT NULL DEFAULT 6,
  `date_year` int(4) NOT NULL DEFAULT 2022,
  `date_blockout` tinyint(1) NOT NULL DEFAULT 0,
  `date_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `block_out_dates`
--

INSERT INTO `block_out_dates` (`date_id`, `date_value`, `date_day`, `date_month`, `date_year`, `date_blockout`, `date_reason`) VALUES
(20220601, '2022-06-01', 1, 6, 2022, 0, ''),
(20220602, '2022-06-02', 2, 6, 2022, 0, ''),
(20220603, '2022-06-03', 3, 6, 2022, 1, ''),
(20220604, '2022-06-04', 4, 6, 2022, 1, ''),
(20220605, '2022-06-05', 5, 6, 2022, 0, ''),
(20220606, '2022-06-06', 6, 6, 2022, 0, ''),
(20220607, '2022-06-07', 7, 6, 2022, 0, ''),
(20220608, '2022-06-08', 8, 6, 2022, 0, ''),
(20220609, '2022-06-09', 9, 6, 2022, 0, ''),
(20220610, '2022-06-10', 10, 6, 2022, 1, ''),
(20220611, '2022-06-11', 11, 6, 2022, 1, ''),
(20220612, '2022-06-12', 12, 6, 2022, 0, ''),
(20220613, '2022-06-13', 13, 6, 2022, 0, ''),
(20220614, '2022-06-14', 14, 6, 2022, 0, ''),
(20220615, '2022-06-15', 15, 6, 2022, 0, ''),
(20220616, '2022-06-16', 16, 6, 2022, 0, ''),
(20220617, '2022-06-17', 17, 6, 2022, 1, ''),
(20220618, '2022-06-18', 18, 6, 2022, 1, ''),
(20220619, '2022-06-19', 19, 6, 2022, 0, ''),
(20220620, '2022-06-20', 20, 6, 2022, 0, ''),
(20220621, '2022-06-21', 21, 6, 2022, 0, ''),
(20220622, '2022-06-22', 22, 6, 2022, 0, ''),
(20220623, '2022-06-23', 23, 6, 2022, 0, ''),
(20220624, '20220624', 24, 6, 2022, 0, ''),
(20220625, '2022-06-25', 25, 6, 2022, 0, ''),
(20220626, '2022-06-26', 26, 6, 2022, 0, ''),
(20220627, '2022-06-27', 27, 6, 2022, 0, ''),
(20220628, '2022-06-28', 28, 6, 2022, 0, ''),
(20220629, '2022-06-29', 29, 6, 2022, 0, ''),
(20220630, '2022-06-30', 30, 6, 2022, 0, ''),
(20220631, '2022-06-31', 31, 6, 2022, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block_out_dates`
--
ALTER TABLE `block_out_dates`
  ADD PRIMARY KEY (`date_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
