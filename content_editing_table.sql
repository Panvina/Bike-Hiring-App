-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2022 at 08:39 AM
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
-- Table structure for table `content_editing_table`
--

CREATE TABLE `content_editing_table` (
  `edit_id` int(11) NOT NULL,
  `edit_name` varchar(255) NOT NULL,
  `edit_content` longtext NOT NULL,
  `edit_is_text` tinyint(1) NOT NULL,
  `edit_is_image` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `content_editing_table`
--

INSERT INTO `content_editing_table` (`edit_id`, `edit_name`, `edit_content`, `edit_is_text`, `edit_is_image`) VALUES
(1, 'home_about_us_text', 'Explore the area and Rail Trails in comfort and style on an electric bike. We also have a range of standard bikes to suit your needs with a range of accessories available. We are a local family owned and operated business and pride ourselves on providing you with a unique experience while you enjoy what Inverloch and the sounding region has to offer. Whether your family have been holidaying here for years, you’re are having a weekend away or just simply visiting for the day we have an experience to suit everyone’s tastes and abilities.', 1, 0),
(2, 'home_about_us_image', './img/photos/5.jpg', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content_editing_table`
--
ALTER TABLE `content_editing_table`
  ADD PRIMARY KEY (`edit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content_editing_table`
--
ALTER TABLE `content_editing_table`
  MODIFY `edit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
