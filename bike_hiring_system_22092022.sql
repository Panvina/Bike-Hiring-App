-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2022 at 02:00 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `accessory_inventory_table`
--

CREATE TABLE `accessory_inventory_table` (
  `accessory_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `accessory_type_id` int(11) NOT NULL,
  `price_ph` float NOT NULL,
  `safety_inspect` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessory_inventory_table`
--

INSERT INTO `accessory_inventory_table` (`accessory_id`, `name`, `accessory_type_id`, `price_ph`, `safety_inspect`) VALUES
(2, 'helmetus', 1, 10, 0),
(3, 'glovus', 2, 10, 0),
(5, 'New test accessory', 1, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `accessory_type_table`
--

CREATE TABLE `accessory_type_table` (
  `accessory_type_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessory_type_table`
--

INSERT INTO `accessory_type_table` (`accessory_type_id`, `name`, `description`) VALUES
(1, 'Helmet', ''),
(2, 'Gloves', 'gloves');

-- --------------------------------------------------------

--
-- Table structure for table `accounts_table`
--

CREATE TABLE `accounts_table` (
  `user_name` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts_table`
--

INSERT INTO `accounts_table` (`user_name`, `role_id`, `password`) VALUES
('account@gmail.com', 3, '$2y$10$KW/v0uQY8BLYpFmU5D1XGudIMeRRamSt6C6zRAwpIYYeKRrR/qpvm'),
('asdad@gmail.com', 3, '$2y$10$7RUerLc4Zs1BkXHXp1bC0OfOndYn5oW.cMfP/QgBdPhiZuRx7QypK'),
('CU-directoryTest', 3, '1895c0caa2f8173b8713fbc242835c06bd6b51de'),
('CU-ProperCustomer', 3, '$2y$10$/id0IwAl4RH5TaIw5u52VumduvW.8Szud4jCM3dF2hOobbvZzGkaK'),
('CU-SessionTest', 3, '$2y$10$py7LDUE.EBxY/bSIDpjzIOZezwQZDzIa9kZH71ZkI4bIQTkouHj0W'),
('CU-StateTest', 3, '$2y$10$.GDAQ/KuN.VdGo6RaKTtIuB2M0l7sWEd1Pa4Nb4X/XZ3zihyxPrPa'),
('CU-testInsert', 3, '$2y$10$wur9PjvfzT0sCG5z/fAZxOkxetDkgv3fwjJ4t1ujWhtJd.vk0L/ti'),
('CU-TestJake34', 3, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
('duplicateaccounttest@email.com', 3, '$2y$10$w3sVfNIj7hKtm.NQ99iU2eOiulkWk0oNqigX10CG.qY36JUXL87M2'),
('EM-AccountRoleTest', 3, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
('EM-AccountTest', 2, '7c222fb2927d828af22f592134e8932480637c0d'),
('EM-TestInsert', 2, 'btDiotf1'),
('EM-TESTINSERT2', 2, 'RTuhYL4F'),
('JAKE@GMAIL.COM', 1, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441'),
('loginaccount@gmail.com', 3, '$2y$10$zrKTx4MKpUkQGkQijLA6yuZ3f86aA3XnSm3tBB9JLtHtc23EKgGZe'),
('OwnerSenpai', 1, '123456789'),
('shakingscreen@gmail.com', 3, '$2y$10$4WGHQZYmiiTWeqqt3DeoMO9P8Wo90y3luHcphwOS/aU99NwM./QTS'),
('test@email.com', 3, '$2y$10$pD8cyT16d9mk91kay51kXOU7U/yXRNEy6XEl7A8hRXcwtlTQDHDTi');

-- --------------------------------------------------------

--
-- Table structure for table `authorisation_table`
--

CREATE TABLE `authorisation_table` (
  `role_id` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authorisation_table`
--

INSERT INTO `authorisation_table` (`role_id`, `description`) VALUES
(1, 'Owner'),
(2, 'Employee'),
(3, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `bike_inventory_table`
--

CREATE TABLE `bike_inventory_table` (
  `bike_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `bike_type_id` int(11) DEFAULT NULL,
  `helmet_id` int(11) NOT NULL,
  `price_ph` float NOT NULL,
  `safety_inspect` tinyint(1) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bike_inventory_table`
--

INSERT INTO `bike_inventory_table` (`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`) VALUES
(1, 'Bikarus', NULL, 2, 40, 0, 'FAST BOI'),
(2, 'Summer', NULL, 2, 50, 0, 'dasdasdasdasdas'),
(66, 'Kangokoo', NULL, 2, 10, 0, 'lalalalala'),
(301, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(302, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(303, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(304, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(305, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(306, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(307, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(308, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(309, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(310, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(311, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(312, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(313, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(314, 'BikeTest', NULL, 2, 40, 1, 'Description'),
(315, 'BikeTest', NULL, 2, 40, 0, 'Description'),
(316, 'BikeTest', NULL, 2, 40, 1, 'Description');

-- --------------------------------------------------------

--
-- Table structure for table `bike_type_table`
--

CREATE TABLE `bike_type_table` (
  `bike_type_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `picture_id` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bike_type_table`
--

INSERT INTO `bike_type_table` (`bike_type_id`, `name`, `picture_id`, `description`) VALUES
(57, 'E-Bike step through', '1', 'Electronic step through bike'),
(58, 'E-Bike step over', '2', 'Electronic step over bike'),
(59, 'Standard step through bike', '3', 'Standard step through bike that you can pedal'),
(60, 'Standard step over bike', '4', 'Standard step over bike that you can pedal'),
(61, 'Mountain Bike - Hard Tail', '5', 'Mountain Bike that can be used off track');

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
(20220603, '2022-06-03', 3, 6, 2022, 0, ''),
(20220604, '2022-06-04', 4, 6, 2022, 0, ''),
(20220605, '2022-06-05', 5, 6, 2022, 0, ''),
(20220606, '2022-06-06', 6, 6, 2022, 0, ''),
(20220607, '2022-06-07', 7, 6, 2022, 0, ''),
(20220608, '2022-06-08', 8, 6, 2022, 0, ''),
(20220609, '2022-06-09', 9, 6, 2022, 0, ''),
(20220610, '2022-06-10', 10, 6, 2022, 0, ''),
(20220611, '2022-06-11', 11, 6, 2022, 1, ''),
(20220612, '2022-06-12', 12, 6, 2022, 0, ''),
(20220613, '2022-06-13', 13, 6, 2022, 0, ''),
(20220614, '2022-06-14', 14, 6, 2022, 0, ''),
(20220615, '2022-06-15', 15, 6, 2022, 0, ''),
(20220616, '2022-06-16', 16, 6, 2022, 0, ''),
(20220617, '2022-06-17', 17, 6, 2022, 0, ''),
(20220618, '2022-06-18', 18, 6, 2022, 0, ''),
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
(20220630, '2022-06-30', 30, 6, 2022, 1, ''),
(20220631, '2022-06-31', 31, 6, 2022, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `booking_accessory_table`
--

CREATE TABLE `booking_accessory_table` (
  `booking_accessory_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `accessory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_accessory_table`
--

INSERT INTO `booking_accessory_table` (`booking_accessory_id`, `booking_id`, `accessory_id`) VALUES
(10, 14, 2),
(11, 14, 3),
(12, 15, 5),
(13, 15, 3),
(14, 16, 2),
(15, 16, 3),
(16, 17, 2),
(17, 18, 5),
(18, 19, 3),
(19, 20, 3),
(20, 21, 2),
(21, 21, 5),
(22, 22, 3),
(23, 23, 2),
(24, 23, 3),
(25, 24, 2),
(26, 25, 2),
(27, 25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `booking_bike_table`
--

CREATE TABLE `booking_bike_table` (
  `booking_bike_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `bike_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_bike_table`
--

INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES
(18, 14, 1),
(19, 14, 2),
(20, 15, 1),
(21, 15, 2),
(22, 16, 1),
(23, 16, 2),
(24, 17, 2),
(25, 18, 66),
(26, 19, 301),
(27, 20, 66),
(28, 21, 1),
(29, 21, 66),
(30, 22, 1),
(31, 23, 1),
(32, 23, 66),
(33, 24, 303),
(34, 25, 1),
(35, 25, 301),
(36, 25, 305),
(37, 25, 307);

-- --------------------------------------------------------

--
-- Table structure for table `booking_costs`
--

CREATE TABLE `booking_costs` (
  `booking_costs_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `booking_end_real_time` time NOT NULL,
  `lateness_fee` float DEFAULT NULL,
  `total_damage_fee` float DEFAULT NULL,
  `total_final_fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_table`
--

CREATE TABLE `booking_table` (
  `booking_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `expected_end_time` time NOT NULL,
  `duration_of_booking` int(11) NOT NULL,
  `pick_up_location` int(11) DEFAULT NULL,
  `drop_off_location` int(11) DEFAULT NULL,
  `booking_fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_table`
--

INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES
(14, 'CU-TestJake34', '2022-09-18', '2022-09-19', '09:00:00', '09:00:00', 24, NULL, NULL, 2640),
(15, 'account@gmail.com', '2022-06-03', '2022-06-05', '09:00:00', '10:00:00', 49, 98, 98, 2940),
(16, 'account@gmail.com', '2022-09-19', '2022-09-19', '09:00:00', '10:00:00', 1, 98, 98, 110),
(17, 'tpanvina@gmail.com', '2022-09-19', '2022-09-19', '11:00:00', '16:00:00', 5, 98, 98, 300),
(18, 'JAKE@GMAIL.COM', '2022-09-19', '2022-09-19', '14:00:00', '17:00:00', 3, 98, 98, 105),
(19, 'test2', '2022-09-19', '2022-09-19', '10:00:00', '14:00:00', 4, 98, 98, 200),
(20, 'account@gmail.com', '2022-09-19', '2022-09-19', '11:00:00', '13:00:00', 2, 98, 98, 40),
(21, 'test2', '2022-09-19', '2022-09-19', '09:00:00', '10:00:00', 1, 98, 98, 85),
(22, 'account@gmail.com', '2022-09-21', '2022-09-21', '09:00:00', '15:00:00', 6, 98, 99, 300),
(23, 'account@gmail.com', '2022-09-21', '2022-09-21', '09:00:00', '12:00:00', 3, 98, 99, 210),
(24, 'CU-directoryTest', '2022-09-21', '2022-09-21', '09:00:00', '16:00:00', 7, 98, 99, 350),
(25, 'JAKE@GMAIL.COM', '2022-09-21', '2022-09-21', '09:00:00', '13:00:00', 4, 98, 99, 720);

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
(1, 'home_about_us_text', 'Explore the area and Rail Trails in comfort and style on an electric bike. We also have a range of standard bikes to suit your needs with a range of accessories available. We are a local family owned and operated business and pride ourselves on providing you with a unique experience while you enjoy what Inverloch has to offer. Whether your family have been holidaying here for years, or having a weekend away or just simply visiting for the day we have an experience to suit everyone’s tastes and abilities.&nbsp;', 1, 0),
(2, 'home_about_us_image', './img/photos/5.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

CREATE TABLE `customer_table` (
  `user_name` varchar(100) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `suburb` varchar(45) NOT NULL,
  `post_code` varchar(4) NOT NULL,
  `licence_number` varchar(12) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`user_name`, `name`, `phone_number`, `email`, `street_address`, `suburb`, `post_code`, `licence_number`, `state`) VALUES
('account@gmail.com', 'Test', '412345678', 'account@gmail.com', '2 test street', 'asdd', '1234', '123456789', 'vic'),
('asdad@gmail.com', 'adad asdd', '412345678', 'asdad@gmail.com', '2 test street', 'asdd', '1234', '123456789', 'Vic'),
('CU-directoryTest', 'adasd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'asdd', '1234', '123456789', 'vic'),
('CU-ProperCustomer', 'asdd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'asdads', '1234', '123456789', 'vic'),
('CU-SessionTest', 'asd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'asddf', '1234', '123456789', 'vic'),
('CU-StateTest', 'asd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'asddf', '1234', '123456789', 'VIC'),
('CU-testInsert', 'asdd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'asdf', '1234', '123456789', 'vic'),
('CU-TestJake34', 'New Jake', '412345645', 'TestEmail@gmail.com', '2 test street', 'ghvghfv', '1234', '123456789', 'vic'),
('duplicateaccounttest@email.com', 'duplicateAccountTest asddd', '412345678', 'duplicateaccounttest@email.com', '2 test street', 'sddf', '1234', '123456789', 'vic'),
('JAKE@GMAIL.COM', 'NEW JAKE', '412345679', 'JAKE@GMAIL.COM', '3 test street', 'test', '1234', '123456789', 'Vic'),
('loginaccount@gmail.com', 'LoginAccount LoginAccount', '412345678', 'loginaccount@gmail.com', '2 test street', 'sdad', '1234', '123456789', 'vic'),
('shakingscreen@gmail.com', 'shaking  screen', 'null', 'shakingscreen@gmail.com', 'null', 'null', 'null', 'null', 'null'),
('test2', 'new test', 'test2', 'test2', 'test2', 'test2', 'test', 'test2', 'test2'),
('test@email.com', 'test test', 'null', 'test@email.com', 'null', 'null', 'null', 'null', 'null'),
('tpanvina@gmail.com', 'Vina Touch', 'null', 'tpanvina@gmail.com', 'null', 'null', 'null', 'null', 'null');

-- --------------------------------------------------------

--
-- Table structure for table `damaged_items_table`
--

CREATE TABLE `damaged_items_table` (
  `damaged_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `bike_id` int(11) DEFAULT NULL,
  `accessory_id` int(11) DEFAULT NULL,
  `damage_fee` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `damaged_items_table`
--

INSERT INTO `damaged_items_table` (`damaged_id`, `booking_id`, `bike_id`, `accessory_id`, `damage_fee`) VALUES
(1, 14, 315, 3, 25);

-- --------------------------------------------------------

--
-- Table structure for table `employee_table`
--

CREATE TABLE `employee_table` (
  `user_name` varchar(100) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(45) NOT NULL,
  `post_code` varchar(4) NOT NULL,
  `state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_table`
--

INSERT INTO `employee_table` (`user_name`, `name`, `phone_number`, `email`, `address`, `suburb`, `post_code`, `state`) VALUES
('EM-AccountRoleTest', 'Test', '412345678', 'TestEmail@gmail.com', '2 test street', 'asdd', '1234', 'vic'),
('EM-AccountTest', 'asdd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'asddf', '1234', 'Vic'),
('EM-TestInsert', 'asdd', '0412345678', 'TestEmail@gmail.com', '2 test street', 'addd', '1234', 'vic'),
('EM-TESTINSERT2', 'kkjkjh', '412345678', 'TestEmail@gmail.com', '2 test street', 'asddf', '1234', 'vic');

-- --------------------------------------------------------

--
-- Table structure for table `location_table`
--

CREATE TABLE `location_table` (
  `location_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(45) NOT NULL,
  `post_code` varchar(4) NOT NULL,
  `drop_off_location` tinyint(1) NOT NULL DEFAULT 0,
  `pick_up_location` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `location_table`
--

INSERT INTO `location_table` (`location_id`, `name`, `address`, `suburb`, `post_code`, `drop_off_location`, `pick_up_location`) VALUES
(98, 'New location', 'asdadd', '  asdd', ' 397', 0, 1),
(99, 'test location', 'adsad', 'asdad', '3977', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  ADD PRIMARY KEY (`accessory_id`),
  ADD KEY `AccessoryTypeID` (`accessory_type_id`);

--
-- Indexes for table `accessory_type_table`
--
ALTER TABLE `accessory_type_table`
  ADD PRIMARY KEY (`accessory_type_id`);

--
-- Indexes for table `accounts_table`
--
ALTER TABLE `accounts_table`
  ADD PRIMARY KEY (`user_name`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `authorisation_table`
--
ALTER TABLE `authorisation_table`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  ADD PRIMARY KEY (`bike_id`),
  ADD KEY `BikeID` (`bike_id`),
  ADD KEY `BikeTypeID` (`bike_type_id`),
  ADD KEY `HelmetID` (`helmet_id`);

--
-- Indexes for table `bike_type_table`
--
ALTER TABLE `bike_type_table`
  ADD PRIMARY KEY (`bike_type_id`);

--
-- Indexes for table `block_out_dates`
--
ALTER TABLE `block_out_dates`
  ADD PRIMARY KEY (`date_id`);

--
-- Indexes for table `booking_accessory_table`
--
ALTER TABLE `booking_accessory_table`
  ADD PRIMARY KEY (`booking_accessory_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `accessory_id` (`accessory_id`);

--
-- Indexes for table `booking_bike_table`
--
ALTER TABLE `booking_bike_table`
  ADD PRIMARY KEY (`booking_bike_id`),
  ADD KEY `booking_bike_id` (`booking_bike_id`,`booking_id`,`bike_id`),
  ADD KEY `bike_id` (`bike_id`),
  ADD KEY `booking_bike_table_ibfk_1` (`booking_id`);

--
-- Indexes for table `booking_costs`
--
ALTER TABLE `booking_costs`
  ADD PRIMARY KEY (`booking_costs_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `drop_off_location` (`drop_off_location`),
  ADD KEY `pick_up_location` (`pick_up_location`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `content_editing_table`
--
ALTER TABLE `content_editing_table`
  ADD PRIMARY KEY (`edit_id`);

--
-- Indexes for table `customer_table`
--
ALTER TABLE `customer_table`
  ADD PRIMARY KEY (`user_name`);

--
-- Indexes for table `damaged_items_table`
--
ALTER TABLE `damaged_items_table`
  ADD PRIMARY KEY (`damaged_id`),
  ADD KEY `Bike ItemID` (`bike_id`),
  ADD KEY `DamagedBookingID` (`booking_id`),
  ADD KEY `accessory_id` (`accessory_id`);

--
-- Indexes for table `employee_table`
--
ALTER TABLE `employee_table`
  ADD PRIMARY KEY (`user_name`);

--
-- Indexes for table `location_table`
--
ALTER TABLE `location_table`
  ADD PRIMARY KEY (`location_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  MODIFY `accessory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `accessory_type_table`
--
ALTER TABLE `accessory_type_table`
  MODIFY `accessory_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `bike_type_table`
--
ALTER TABLE `bike_type_table`
  MODIFY `bike_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `booking_accessory_table`
--
ALTER TABLE `booking_accessory_table`
  MODIFY `booking_accessory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `booking_bike_table`
--
ALTER TABLE `booking_bike_table`
  MODIFY `booking_bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `booking_costs`
--
ALTER TABLE `booking_costs`
  MODIFY `booking_costs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `content_editing_table`
--
ALTER TABLE `content_editing_table`
  MODIFY `edit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `damaged_items_table`
--
ALTER TABLE `damaged_items_table`
  MODIFY `damaged_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `location_table`
--
ALTER TABLE `location_table`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  ADD CONSTRAINT `AccessoryTypeID` FOREIGN KEY (`accessory_type_id`) REFERENCES `accessory_type_table` (`accessory_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `accounts_table`
--
ALTER TABLE `accounts_table`
  ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `authorisation_table` (`role_id`);

--
-- Constraints for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  ADD CONSTRAINT `HelmetID` FOREIGN KEY (`helmet_id`) REFERENCES `accessory_inventory_table` (`accessory_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bike_type_id` FOREIGN KEY (`bike_type_id`) REFERENCES `bike_type_table` (`bike_type_id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_accessory_table`
--
ALTER TABLE `booking_accessory_table`
  ADD CONSTRAINT `booking_accessory_table_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_table` (`booking_id`),
  ADD CONSTRAINT `booking_accessory_table_ibfk_2` FOREIGN KEY (`accessory_id`) REFERENCES `accessory_inventory_table` (`accessory_id`);

--
-- Constraints for table `booking_bike_table`
--
ALTER TABLE `booking_bike_table`
  ADD CONSTRAINT `booking_bike_table_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_table` (`booking_id`),
  ADD CONSTRAINT `booking_bike_table_ibfk_2` FOREIGN KEY (`bike_id`) REFERENCES `bike_inventory_table` (`bike_id`);

--
-- Constraints for table `booking_costs`
--
ALTER TABLE `booking_costs`
  ADD CONSTRAINT `ExtraCostsBookingID` FOREIGN KEY (`booking_id`) REFERENCES `booking_table` (`booking_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `booking_costs_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `damaged_items_table` (`booking_id`);

--
-- Constraints for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD CONSTRAINT `drop_off_location ` FOREIGN KEY (`drop_off_location`) REFERENCES `location_table` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pick_up_location` FOREIGN KEY (`pick_up_location`) REFERENCES `location_table` (`location_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_name` FOREIGN KEY (`user_name`) REFERENCES `customer_table` (`user_name`) ON DELETE SET NULL;

--
-- Constraints for table `damaged_items_table`
--
ALTER TABLE `damaged_items_table`
  ADD CONSTRAINT `Bike ItemID` FOREIGN KEY (`bike_id`) REFERENCES `bike_inventory_table` (`bike_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `accessory_id` FOREIGN KEY (`accessory_id`) REFERENCES `accessory_inventory_table` (`accessory_id`),
  ADD CONSTRAINT `booking_id ` FOREIGN KEY (`booking_id`) REFERENCES `booking_table` (`booking_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
