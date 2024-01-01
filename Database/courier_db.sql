-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2024 at 09:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courier_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `BranchID` int(11) NOT NULL,
  `BranchName` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `ContactPerson` varchar(255) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`BranchID`, `BranchName`, `Location`, `ContactPerson`, `ContactNumber`) VALUES
(1, 'Jampur Branch', 'Jampur', 'Haider Ali', '0312055562');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text DEFAULT NULL,
  `sent_datetime` datetime DEFAULT current_timestamp(),
  `reply_text` text DEFAULT NULL,
  `reply_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message_text`, `sent_datetime`, `reply_text`, `reply_datetime`) VALUES
(4, 1, 0, 'Hello', '2024-01-01 13:11:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parcels`
--

CREATE TABLE `parcels` (
  `ParcelID` int(11) NOT NULL,
  `SenderName` varchar(255) NOT NULL,
  `SenderAddress` varchar(255) NOT NULL,
  `RecipientName` varchar(255) NOT NULL,
  `RecipientAddress` varchar(255) NOT NULL,
  `Weight` decimal(10,2) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Status` enum('In Transit','Delivered','Pending','Delayed','Returned') NOT NULL,
  `EstimatedDeliveryTime` int(11) NOT NULL,
  `DeliveryRequested` enum('Yes','No') NOT NULL,
  `BranchID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `SenderEmail` varchar(255) NOT NULL,
  `RecipientEmail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parcels`
--

INSERT INTO `parcels` (`ParcelID`, `SenderName`, `SenderAddress`, `RecipientName`, `RecipientAddress`, `Weight`, `Date`, `Time`, `Amount`, `Status`, `EstimatedDeliveryTime`, `DeliveryRequested`, `BranchID`, `UserID`, `SenderEmail`, `RecipientEmail`) VALUES
(2, 'Husan', 'BAsti Cheena', 'ALi', 'Multan', 2.00, '2024-01-01', '12:19:00', 300.00, 'In Transit', 3, 'Yes', 1, 1, 'nasiryt.827@gmail.com', 'saifx280@gmail.com'),
(3, 'Husan', 'BAsti Cheena', 'ALi', 'Multan', 2.00, '2024-01-01', '12:19:00', 300.00, 'In Transit', 3, 'Yes', 1, 1, 'nasiryt.827@gmail.com', 'saifx280@gmail.com'),
(4, 'Husan', 'BAsti Cheena', 'ALi', 'Multan', 2.00, '2024-01-01', '12:19:00', 300.00, 'In Transit', 3, 'Yes', 1, 1, 'nasiryt.827@gmail.com', 'saifx280@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `BranchID`, `Username`, `Password`, `Name`, `Email`, `Phone`) VALUES
(1, 1, 'Nasir12', '$2y$10$zaokJmoHIOMEc7gwGV5oQuLlxuSgOD91pn9sHfGl4PVMoaNpXbBIq', 'NASIR ABBAS', 'nasiryt.827@gmail.com', '3176526827');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`BranchID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcels`
--
ALTER TABLE `parcels`
  ADD PRIMARY KEY (`ParcelID`),
  ADD KEY `BranchID` (`BranchID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `BranchID` (`BranchID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `BranchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parcels`
--
ALTER TABLE `parcels`
  MODIFY `ParcelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parcels`
--
ALTER TABLE `parcels`
  ADD CONSTRAINT `parcels_ibfk_1` FOREIGN KEY (`BranchID`) REFERENCES `branches` (`BranchID`),
  ADD CONSTRAINT `parcels_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`BranchID`) REFERENCES `branches` (`BranchID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
