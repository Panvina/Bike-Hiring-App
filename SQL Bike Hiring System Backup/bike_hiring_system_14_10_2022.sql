-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2022 at 07:05 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
  `accessory_type_id` int(11) DEFAULT NULL,
  `price_ph` float NOT NULL,
  `safety_inspect` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessory_inventory_table`
--

INSERT INTO `accessory_inventory_table` (`accessory_id`, `name`, `accessory_type_id`, `price_ph`, `safety_inspect`) VALUES
(2, 'helmet one', 1, 10, 1),
(3, 'gloves one', 2, 10, 1),
(6, 'helmet two', 1, 10, 1),
(7, 'helmet three', 1, 10, 1),
(8, 'helmet four', 1, 10, 1),
(9, 'helmet five', 1, 10, 1),
(10, 'gloves two', 2, 10, 1),
(11, 'gloves three', 2, 10, 1),
(12, 'gloves four', 2, 10, 1),
(13, 'gloves five', 2, 10, 1),
(14, 'new helmet', 1, 25, 1);

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
(1, 'Helmet', 'Helmet that is used for protection of the head'),
(2, 'Gloves', 'Gloves that is used for protection of the hands');

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
('CU-ElizabethRules33', 3, '$2y$10$CrXQA/T.mFWOoKevHN4PNePu/Soddsh7hskQpcD2YlNDhrmE2C4V2'),
('CU-Jackson25', 3, '$2y$10$MGjigl6ep/MX.gs45RmmUOA9gtskgnd0gHFHMrPtADfSpko1OXgc.'),
('CU-JohnSmith01', 3, '$2y$10$yKJoH1SnlbauaTtGXbdGUeRZ/4Ybr/pidFeHRhG2cRKeth4O9OpwW'),
('CU-Marko4534', 3, '$2y$10$4myFZX44BOSi5Ncqx3ZKh.79WEwoWAF4VVxXc2WfrMZjLwbfZUO3G'),
('CU-Tess_2435', 3, '$2y$10$xSUAx.NrAge9b02V9EeWSelTF.YOtUnvQH6Lhb3ybSvAa.oJHnKU.'),
('EM-Chloe459', 2, 'RnjCDBp3'),
('EM-Zackery07', 2, 'IjyHu4mH'),
('inverlochbikes@gmail.com', 3, '$2y$10$6P2REhUOo93GcZann11Zueh7qaM482X3w2fMVM.X7E3Iw.AhR5vZS'),
('OwnerSenpai', 1, '123456789');

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
(318, 'E-Bike step through one', 57, 2, 25, 1, '1st E-Bike step through'),
(319, 'E-Bike step through two', 57, 2, 25, 1, '2nd E-Bike step through'),
(320, 'E-Bike step over one', 58, 2, 25, 1, '1st E-Bike step over'),
(321, 'E-Bike step over two', 58, 2, 25, 1, '2nd E-Bike step over'),
(322, 'Standard Step Through Bike one', 59, 2, 25, 1, '1st Standard step through bike'),
(323, 'Standard Step Through Bike two', 59, 2, 25, 1, '2nd Standard Step Through Bike'),
(324, 'Standard Step Over Bike one', 60, 2, 25, 1, '1st Standard Step Over Bike'),
(325, 'Standard Step Over Bike two', 60, 2, 25, 1, '2nd Standard Step Over Bike'),
(326, 'MOUNTAIN BIKE - HARD TAIL one', 61, 2, 25, 1, '1st MOUNTAIN BIKE - HARD TAIL'),
(327, 'MOUNTAIN BIKE - HARD TAIL two', 61, 2, 25, 1, '2nd MOUNTAIN BIKE - HARD TAIL'),
(329, 'Standard step over three', 60, 2, 25, 1, 'Colour red');

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
  `date_reason` varchar(255) NOT NULL,
  `date_day_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `block_out_dates`
--

INSERT INTO `block_out_dates` (`date_id`, `date_value`, `date_day`, `date_month`, `date_year`, `date_blockout`, `date_reason`, `date_day_name`) VALUES
(20220601, '2022-06-01', 1, 6, 2022, 0, '', 'Monday'),
(20220602, '2022-06-02', 2, 6, 2022, 0, '', 'Tuesday'),
(20220603, '2022-06-03', 3, 6, 2022, 0, '', 'Wednesday'),
(20220604, '2022-06-04', 4, 6, 2022, 0, '', 'Thursday'),
(20220605, '2022-06-05', 5, 6, 2022, 0, '', 'Friday'),
(20220606, '2022-06-06', 6, 6, 2022, 0, '', 'Saturday'),
(20220607, '2022-06-07', 7, 6, 2022, 0, '', 'Sunday'),
(20220608, '2022-06-08', 8, 6, 2022, 0, '', 'Monday'),
(20220609, '2022-06-09', 9, 6, 2022, 0, '', 'Tuesday'),
(20220610, '2022-06-10', 10, 6, 2022, 0, '', 'Wednesday'),
(20220611, '2022-06-11', 11, 6, 2022, 0, '', 'Thursday'),
(20220612, '2022-06-12', 12, 6, 2022, 0, '', 'Friday'),
(20220613, '2022-06-13', 13, 6, 2022, 0, '', 'Saturday'),
(20220614, '2022-06-14', 14, 6, 2022, 0, '', 'Sunday'),
(20220615, '2022-06-15', 15, 6, 2022, 0, '', 'Monday'),
(20220616, '2022-06-16', 16, 6, 2022, 0, '', 'Tuesday'),
(20220617, '2022-06-17', 17, 6, 2022, 0, '', 'Wednesday'),
(20220618, '2022-06-18', 18, 6, 2022, 0, '', 'Thursday'),
(20220619, '2022-06-19', 19, 6, 2022, 0, '', 'Friday'),
(20220620, '2022-06-20', 20, 6, 2022, 0, '', 'Saturday'),
(20220621, '2022-06-21', 21, 6, 2022, 0, '', 'Sunday'),
(20220622, '2022-06-22', 22, 6, 2022, 0, '', 'Monday'),
(20220623, '2022-06-23', 23, 6, 2022, 0, '', 'Tuesday'),
(20220624, '20220624', 24, 6, 2022, 0, '', 'Wednesday'),
(20220625, '2022-06-25', 25, 6, 2022, 0, '', 'Thursday'),
(20220626, '2022-06-26', 26, 6, 2022, 0, '', 'Friday'),
(20220627, '2022-06-27', 27, 6, 2022, 0, '', 'Saturday'),
(20220628, '2022-06-28', 28, 6, 2022, 0, '', 'Sunday'),
(20220629, '2022-06-29', 29, 6, 2022, 0, '', 'Monday'),
(20220630, '2022-06-30', 30, 6, 2022, 0, '', 'Tuesday'),
(20220631, '2022-06-31', 31, 6, 2022, 0, '', 'Wednesday');

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
(35, 33, 9);

-- --------------------------------------------------------

--
-- Table structure for table `booking_bike_table`
--

CREATE TABLE `booking_bike_table` (
  `booking_bike_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `bike_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_bike_table`
--

INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES
(47, 33, 318),
(48, 33, 326);

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
(33, 'inverlochbikes@gmail.com', '2022-06-26', '2022-06-26', '09:00:00', '17:00:00', 8, 100, 98, 480);

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
('CU-ElizabethRules33', 'Elizabeth murdock', '0475483351', 'ElizabethRules33@gmail.com', '18 King avenue', 'Carrum', '3478', '025987424', 'VIC'),
('CU-Jackson25', 'Jackston Stuart', '0454789142', 'Jacko25@gmail.com', '33 cool street', 'Hawthorn', '3674', '543247954', 'NSW'),
('CU-JohnSmith01', 'John Smith', '0412345678', 'JohnSmith@gmail.com', '2 John street', 'frankston', '1234', '123456789', 'VIC'),
('CU-Marko4534', 'Mark kenith', '0456874254', 'Marko45@gmail.com', '74 Elizabeth street', 'Bonbeach', '3574', '368754892', 'QLD'),
('CU-Tess_2435', 'Tess Mcbeth', '0358745185', 'Tess_2435@gmail.com', '4 Jackson court', 'skye', '3985', '014785412', 'VIC'),
('inverlochbikes@gmail.com', 'Danny Meika', '412345678', 'inverlochbikes@gmail.com', '321 Marry Street', 'inverloch', '3974', '123456789', 'VIC');

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
('EM-Chloe459', 'Chloe sunny', '48531685', 'Chloe459@gmail.com', '75 Queen street', 'Richmond', '3658', 'VIC'),
('EM-Zackery07', 'Zack zackerson', '0485321475', 'Zackery07@gmail.com', '35 Wellington avenue', 'SommerVill', '3785', 'VIC');

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
(98, 'Inverloch Beach', '12 Inverloch Beach', 'Inverloch', '3996', 1, 1),
(100, 'Inverloch Libary', '23 libary street', 'Inverloch', '3996', 1, 1),
(101, 'Inverloch new pier', 'Inverloch', 'Inverloch', '3974', 1, 1);

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
  MODIFY `accessory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `accessory_type_table`
--
ALTER TABLE `accessory_type_table`
  MODIFY `accessory_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `bike_type_table`
--
ALTER TABLE `bike_type_table`
  MODIFY `bike_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `booking_accessory_table`
--
ALTER TABLE `booking_accessory_table`
  MODIFY `booking_accessory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `booking_bike_table`
--
ALTER TABLE `booking_bike_table`
  MODIFY `booking_bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `booking_costs`
--
ALTER TABLE `booking_costs`
  MODIFY `booking_costs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  ADD CONSTRAINT `AccessoryTypeID` FOREIGN KEY (`accessory_type_id`) REFERENCES `accessory_type_table` (`accessory_type_id`) ON DELETE SET NULL ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `booking_bike_table_ibfk_2` FOREIGN KEY (`bike_id`) REFERENCES `bike_inventory_table` (`bike_id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `Bike ItemID` FOREIGN KEY (`bike_id`) REFERENCES `bike_inventory_table` (`bike_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `accessory_id` FOREIGN KEY (`accessory_id`) REFERENCES `accessory_inventory_table` (`accessory_id`),
  ADD CONSTRAINT `booking_id ` FOREIGN KEY (`booking_id`) REFERENCES `booking_table` (`booking_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
