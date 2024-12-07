-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 11:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ztobcs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `PasswordHash` varchar(250) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Email`, `PasswordHash`, `FirstName`) VALUES
(1, 'fahmidadipty550@gmail.com', 'hos@dipty', 'Fahmida');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `ServiceID` int(11) DEFAULT NULL,
  `AppointmentDate` varchar(50) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`AppointmentID`, `CustomerID`, `StaffID`, `ServiceID`, `AppointmentDate`, `Status`) VALUES
(1, 1, 3, 2, '2024-12-03', 'Completed'),
(2, 2, 2, 1, '2024-12-03', 'Pending'),
(3, 3, 3, 6, '2024-12-04', 'Pending'),
(4, 5, 1, 1, '2024-12-03', 'Pending'),
(5, 6, 3, 5, '2024-12-04', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `PasswordHash` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `FirstName`, `LastName`, `Phone`, `Email`, `Address`, `City`, `Gender`, `PasswordHash`) VALUES
(1, 'Forida', 'Parvin', '01785623753', 'foridaparvin1122@gmail.com', 'Panchbibi', 'Joypurhut', 'Female', '$2y$10$lyP3jlttpCCDbA8.9USEI.CxxG.eydgxymSoJzvkh/TDoyp594yYC'),
(2, 'Hossain', 'Ahmed', '01746896556', 'hossainahmde132@gmail.com', NULL, NULL, NULL, '$2y$10$Mi5hhC3k4A4T.6nQU6rWgOqqRDAB2n0Tb7LEe1Vg8rChlCb8Afcvi'),
(3, 'Joti', 'sorkar', '017583749348', 'jotisorkar1@gmial.com', 'Joypurhat', 'joypurhat', 'female', '$2y$10$4/sqeVltbUOG9Gh25tXKZuQ9Xg44vwYcqezEZWSNCESs5od67NdkG'),
(4, 'Imtiaz', 'uddin', NULL, 'umtiaz11@gmail.cpm', NULL, NULL, NULL, '$2y$10$j.WhJz3D1yCyIqQGbxAeruF95.6se7eQTUhP3JJPA2BC6lQ9ubW9G'),
(5, 'dipty', 'Chowdhury', '01914479163', 'dipty@gmail.com', 'notunbazar', 'dhaka', 'female', '$2y$10$jn6yccdqLC9v4dR/Msu98OW4f9R95yJiJEnCbFMGL49pk6X5nkQta'),
(6, 'shadhin', 'hossain', '017635746849', 'shadhin11@gmail.com', 'Basgtola', 'dhaka', 'male', '$2y$10$AwgHHDkGJM0gj46LkkhG2uTy7MOcGHIJ0bN61vhchQilqqnUpqcFm');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `QuantityInStock` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Description`, `QuantityInStock`, `Price`) VALUES
(1, 'Bremod keratin silky straight', 'Soft hair, healty and long lasting straight. ', 10, 280.00),
(2, 'Loreal Xtenso Oil', 'Trio extra  resistant hair straightening cream', 20, 120.00),
(3, 'Milk protein  hair Rebonding cream', 'Special straightening treatment cream', 15, 300.00),
(4, 'Foundation', 'All skin types ', 22, 20.00),
(5, 'lipstick ', 'provides maximum coverage ', 30, 150.00),
(6, 'Mascara', 'For  darkening, lengthening, curling, coloring and thickeing eyelashes', 30, 10.00),
(7, 'Facewash', 'use it for clean your skin', 17, 110.00),
(8, 'Moisturizer', 'Basic need for your skin moisturize', 25, 200.00),
(9, 'Shampoo', 'Wash your hair', 30, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `PromotionID` int(11) NOT NULL,
  `PromotionName` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `DiscountPercentage` decimal(5,2) DEFAULT NULL,
  `StartDate` varchar(50) DEFAULT NULL,
  `EndDate` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`PromotionID`, `PromotionName`, `Description`, `DiscountPercentage`, `StartDate`, `EndDate`) VALUES
(1, 'winters offer', 'enjoy our winter offer', 10.00, '2024-12-01', '2024-12-15'),
(2, 'summer offer', 'enjoy summer', 10.00, '2024-12-03', '2024-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `ServiceID` int(11) NOT NULL,
  `ServiceName` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `DurationMinutes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`ServiceID`, `ServiceName`, `Description`, `Price`, `DurationMinutes`) VALUES
(1, 'Bio-Hydra Facial Treatments', 'Rejuvenate  your skin with our range of  facial', 4000.00, 60),
(2, 'Hair Rebounding Treatments', 'Get the best haircuts, styles and treatment\'s ', 12000.00, 120),
(3, 'Bridal Makeup ', 'make your special day more beautiful  with us', 20000.00, 120),
(5, 'Hair cutting  Man', 'Style of hair', 1200.00, 60),
(6, 'Hair Cutting for Female ', 'styling  hair', 1800.00, 80);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `HireDate` date DEFAULT NULL,
  `Salary` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `FirstName`, `LastName`, `Phone`, `Email`, `Position`, `HireDate`, `Salary`) VALUES
(1, 'Mysha', 'Akter', '017535367872', 'myshaakter11@gmail.com', 'Managing director', '2024-10-01', 50000.00),
(2, 'Rubaiya', 'Jannat', '0134678736', 'rubaiya22@gmail.com', 'Makeup artist', '2024-10-01', 25500.00),
(3, 'Atif', 'Islam', '01457678987', 'atifislam33@gmail.com', 'Hair Stylist', '2024-10-01', 30500.00),
(5, 'Mohona', 'Akanda', '0192786348', 'mohona11@gmail.com', 'hair stylist ', '2024-10-01', 20000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `StaffID` (`StaffID`),
  ADD KEY `ServiceID` (`ServiceID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`PromotionID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ServiceID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `PromotionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `ServiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`ServiceID`) REFERENCES `services` (`ServiceID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
