-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2022 at 11:07 AM
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
  `AccessoryID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `AccessoryTypeID` int(11) NOT NULL,
  `Price p/h` float NOT NULL,
  `Safety Inspect` tinyint(4) NOT NULL DEFAULT 0,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `accessory_type_table`
--

CREATE TABLE `accessory_type_table` (
  `AccessoryTypeID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bike_inventory_table`
--

CREATE TABLE `bike_inventory_table` (
  `BikeID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `BikeTypeID` int(11) NOT NULL,
  `HelmetID` int(11) NOT NULL,
  `Price p/h` float NOT NULL,
  `Safety Inspect` tinyint(4) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bike_type_table`
--

CREATE TABLE `bike_type_table` (
  `BikeTypeID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_extra_costs`
--

CREATE TABLE `booking_extra_costs` (
  `Extra Costs ID` int(11) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `Booking Real End Time` time NOT NULL,
  `Lateness Fee` float NOT NULL,
  `Damaged Fee` float NOT NULL,
  `Final Fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `booking_table`
--

CREATE TABLE `booking_table` (
  `BookingID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `BikeID` int(11) NOT NULL,
  `Start Date` date NOT NULL,
  `End Date` date NOT NULL,
  `Start Time` time NOT NULL,
  `Expected End Time` time NOT NULL,
  `Duration Of Booking` int(11) NOT NULL,
  `Pick Up Location` int(11) NOT NULL,
  `Drop Off Location` int(11) NOT NULL,
  `Final Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_account_table`
--

CREATE TABLE `customer_account_table` (
  `AccountID` int(11) NOT NULL,
  `CustID` int(11) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

CREATE TABLE `customer_table` (
  `CustID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Phone Number` varchar(9) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Street Address` varchar(255) NOT NULL,
  `Suburb` varchar(45) NOT NULL,
  `Post Code` varchar(4) NOT NULL,
  `Licence Number` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `damaged_items_table`
--

CREATE TABLE `damaged_items_table` (
  `DamagedID` int(11) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Total Damaged Cost` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employee_table`
--

CREATE TABLE `employee_table` (
  `EmpID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Phone Number` varchar(9) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Suburb` varchar(45) NOT NULL,
  `Post Code` varchar(4) NOT NULL,
  `UserName` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Administrator` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `extra_booking_accessories_table`
--

CREATE TABLE `extra_booking_accessories_table` (
  `Extra Booking Accessories ID` int(11) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `AccessoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `location_table`
--

CREATE TABLE `location_table` (
  `LocationID` int(11) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Suburb` varchar(45) NOT NULL,
  `Post Code` varchar(4) NOT NULL,
  `Drop Off Location` tinyint(4) NOT NULL DEFAULT 0,
  `Pick Up Location` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  ADD PRIMARY KEY (`AccessoryID`),
  ADD KEY `AccessoryTypeID` (`AccessoryTypeID`);

--
-- Indexes for table `accessory_type_table`
--
ALTER TABLE `accessory_type_table`
  ADD PRIMARY KEY (`AccessoryTypeID`);

--
-- Indexes for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  ADD PRIMARY KEY (`BikeID`),
  ADD KEY `BikeTypeID` (`BikeTypeID`),
  ADD KEY `HelmetID` (`HelmetID`);

--
-- Indexes for table `bike_type_table`
--
ALTER TABLE `bike_type_table`
  ADD PRIMARY KEY (`BikeTypeID`);

--
-- Indexes for table `booking_extra_costs`
--
ALTER TABLE `booking_extra_costs`
  ADD PRIMARY KEY (`Extra Costs ID`),
  ADD KEY `ExtraCostsBookingID` (`BookingID`);

--
-- Indexes for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `CustomerID` (`CustID`),
  ADD KEY `BikeID` (`BikeID`),
  ADD KEY `Pick Up Location` (`Pick Up Location`),
  ADD KEY `Drop Off Location` (`Drop Off Location`);

--
-- Indexes for table `customer_account_table`
--
ALTER TABLE `customer_account_table`
  ADD PRIMARY KEY (`AccountID`),
  ADD KEY `CustID` (`CustID`);

--
-- Indexes for table `customer_table`
--
ALTER TABLE `customer_table`
  ADD PRIMARY KEY (`CustID`);

--
-- Indexes for table `damaged_items_table`
--
ALTER TABLE `damaged_items_table`
  ADD PRIMARY KEY (`DamagedID`),
  ADD KEY `DamagedBookingID` (`BookingID`),
  ADD KEY `Accessory ItemID` (`ItemID`);

--
-- Indexes for table `employee_table`
--
ALTER TABLE `employee_table`
  ADD PRIMARY KEY (`EmpID`);

--
-- Indexes for table `extra_booking_accessories_table`
--
ALTER TABLE `extra_booking_accessories_table`
  ADD PRIMARY KEY (`Extra Booking Accessories ID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `AccessoryID` (`AccessoryID`);

--
-- Indexes for table `location_table`
--
ALTER TABLE `location_table`
  ADD PRIMARY KEY (`LocationID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  MODIFY `AccessoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accessory_type_table`
--
ALTER TABLE `accessory_type_table`
  MODIFY `AccessoryTypeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  MODIFY `BikeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bike_type_table`
--
ALTER TABLE `bike_type_table`
  MODIFY `BikeTypeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_extra_costs`
--
ALTER TABLE `booking_extra_costs`
  MODIFY `Extra Costs ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_table`
--
ALTER TABLE `booking_table`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_account_table`
--
ALTER TABLE `customer_account_table`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_table`
--
ALTER TABLE `customer_table`
  MODIFY `CustID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damaged_items_table`
--
ALTER TABLE `damaged_items_table`
  MODIFY `DamagedID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_table`
--
ALTER TABLE `employee_table`
  MODIFY `EmpID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extra_booking_accessories_table`
--
ALTER TABLE `extra_booking_accessories_table`
  MODIFY `Extra Booking Accessories ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_table`
--
ALTER TABLE `location_table`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessory_inventory_table`
--
ALTER TABLE `accessory_inventory_table`
  ADD CONSTRAINT `AccessoryTypeID` FOREIGN KEY (`AccessoryTypeID`) REFERENCES `accessory_type_table` (`AccessoryTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bike_inventory_table`
--
ALTER TABLE `bike_inventory_table`
  ADD CONSTRAINT `BikeTypeID` FOREIGN KEY (`BikeTypeID`) REFERENCES `bike_type_table` (`BikeTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `HelmetID` FOREIGN KEY (`HelmetID`) REFERENCES `accessory_inventory_table` (`AccessoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `booking_extra_costs`
--
ALTER TABLE `booking_extra_costs`
  ADD CONSTRAINT `ExtraCostsBookingID` FOREIGN KEY (`BookingID`) REFERENCES `booking_table` (`BookingID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `booking_table`
--
ALTER TABLE `booking_table`
  ADD CONSTRAINT `BikeID` FOREIGN KEY (`BikeID`) REFERENCES `bike_inventory_table` (`BikeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `CustomerID` FOREIGN KEY (`CustID`) REFERENCES `customer_table` (`CustID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Drop Off Location` FOREIGN KEY (`Drop Off Location`) REFERENCES `location_table` (`LocationID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Pick Up Location` FOREIGN KEY (`Pick Up Location`) REFERENCES `location_table` (`LocationID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customer_account_table`
--
ALTER TABLE `customer_account_table`
  ADD CONSTRAINT `CustID` FOREIGN KEY (`CustID`) REFERENCES `customer_table` (`CustID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `damaged_items_table`
--
ALTER TABLE `damaged_items_table`
  ADD CONSTRAINT `Accessory ItemID` FOREIGN KEY (`ItemID`) REFERENCES `accessory_inventory_table` (`AccessoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Bike ItemID` FOREIGN KEY (`ItemID`) REFERENCES `bike_inventory_table` (`BikeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `DamagedBookingID` FOREIGN KEY (`BookingID`) REFERENCES `booking_table` (`BookingID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `extra_booking_accessories_table`
--
ALTER TABLE `extra_booking_accessories_table`
  ADD CONSTRAINT `AccessoryID` FOREIGN KEY (`AccessoryID`) REFERENCES `accessory_inventory_table` (`AccessoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `BookingID` FOREIGN KEY (`BookingID`) REFERENCES `booking_table` (`BookingID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
