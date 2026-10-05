-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2026 at 02:21 AM
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
-- Database: `complaint_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `ComplaintID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ComplaintTypeID` int(11) NOT NULL,
  `TechnicianID` int(11) DEFAULT NULL,
  `Description` text NOT NULL,
  `ImageFile` varchar(255) DEFAULT NULL,
  `Status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `ResolutionDate` datetime DEFAULT NULL,
  `ResolutionNotes` text DEFAULT NULL,
  `DateUpdated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`ComplaintID`, `CustomerID`, `ProductID`, `ComplaintTypeID`, `TechnicianID`, `Description`, `ImageFile`, `Status`, `DateCreated`, `ResolutionDate`, `ResolutionNotes`, `DateUpdated`) VALUES
(1, 2, 3, 2, 2, 'Payment method was charged but did not receive goods (TEST)', NULL, 'Closed', '2026-09-20 13:07:54', '2026-09-20 14:09:53', 'Customer issue has been reviewed. Troubleshooting is currently in progress.', '2026-09-20 14:09:53'),
(2, 3, 3, 4, 2, 'test is a test for the technical technicians', NULL, 'Open', '2026-09-27 05:07:31', NULL, NULL, '2026-09-27 05:08:52'),
(3, 3, 6, 2, 2, 'didn\'t receive a a invoice for my product i bought through my email.', NULL, 'Open', '2026-10-04 19:19:18', NULL, NULL, '2026-10-04 19:26:58'),
(4, 3, 6, 2, 2, 'cats', NULL, 'Open', '2026-10-04 19:19:34', NULL, NULL, '2026-10-04 19:26:52'),
(5, 3, 6, 2, 2, 'cxats', NULL, 'Open', '2026-10-04 19:20:30', NULL, NULL, '2026-10-04 19:28:14'),
(6, 4, 2, 1, 4, 'last test', NULL, 'Closed', '2026-10-04 19:59:52', '2026-10-04 20:02:06', 'this message has been resolved', '2026-10-04 20:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_images`
--

CREATE TABLE `complaint_images` (
  `ImageID` int(11) NOT NULL,
  `ComplaintID` int(11) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `UploadDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_images`
--

INSERT INTO `complaint_images` (`ImageID`, `ComplaintID`, `FileName`, `UploadDate`) VALUES
(1, 5, 'complaint_5_6ac2df3ed2253.png', '2026-10-04 19:20:30'),
(2, 6, 'complaint_6_6ac2e878980c6.png', '2026-10-04 19:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_messages`
--

CREATE TABLE `complaint_messages` (
  `MessageID` int(11) NOT NULL,
  `ComplaintID` int(11) NOT NULL,
  `SenderType` enum('Customer','Technician') NOT NULL,
  `SenderID` int(11) NOT NULL,
  `MessageText` text NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_messages`
--

INSERT INTO `complaint_messages` (`MessageID`, `ComplaintID`, `SenderType`, `SenderID`, `MessageText`, `DateCreated`) VALUES
(1, 5, 'Customer', 3, 'i also want to add another order complaint', '2026-10-04 19:34:10'),
(2, 5, 'Customer', 3, 'hello can i get an update on my complaint?', '2026-10-04 19:34:27'),
(3, 5, 'Technician', 2, 'yes you may and im am here sorry looking at your order one second please!', '2026-10-04 19:35:13'),
(4, 6, 'Customer', 4, 'also check message test', '2026-10-04 20:00:06'),
(5, 6, 'Technician', 4, 'test for tech message\r\n\'', '2026-10-04 20:01:23');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_types`
--

CREATE TABLE `complaint_types` (
  `ComplaintTypeID` int(11) NOT NULL,
  `TypeName` varchar(100) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_types`
--

INSERT INTO `complaint_types` (`ComplaintTypeID`, `TypeName`, `Description`, `Active`) VALUES
(1, 'Product/Service Defect', 'Problem involving a defective or improperly functioning product or service', 1),
(2, 'Billing Issue', 'Problem involving billing, charges, or payments', 1),
(3, 'Technical Support Issue', 'Problem requiring technical assistance or troubleshooting', 1),
(4, 'Test Complaint', 'Temporary complaint type for testing', 0),
(5, 'Employee Service Complaint', 'Customer has issues with employees services.', 1),
(6, 'Test Complaint', 'testt', 0),
(7, 'tes', 'tes', 0),
(8, 'tes', 'tes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `StreetAddress` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` char(2) NOT NULL,
  `ZipCode` varchar(10) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `Email`, `FirstName`, `LastName`, `StreetAddress`, `City`, `State`, `ZipCode`, `PhoneNumber`, `Password`, `DateCreated`) VALUES
(2, 'princess@test.com', 'Princess', 'Ellis', '123 Main Street', 'Norfolk', 'VA', '23510', '7575551234', '$2y$10$RvmogKVdT58kEFFB2qQt2eOGtQav9Iu6rUFqv/CNgAGIIDwptX9QO', '2026-09-20 12:51:24'),
(3, 'princesstest@test.com', 'princess', 'ellis', '123 Lucky Lane', 'Virginia Beach', 'VA', '23462', '7575551238', '$2y$10$LjoVNUDjN.ABHwV16.MR3OUWuBwxcmi9UL3FgHSYmRIybyqjoLPDi', '2026-09-27 05:06:42'),
(4, 'Lasttest@lasttest.com', 'last', 'test', '2232 Test Ave', 'Norfolk', 'VA', '23708', '7575551333', '$2y$10$nmsSPw6JCRKUPC31GqOtn.n5pRxAob5n6ECVqDDoOyFr14BjBLMsC', '2026-10-04 19:59:20');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneExtension` varchar(10) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Level` enum('Administrator','Technician') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeID`, `UserID`, `FirstName`, `LastName`, `Email`, `PhoneExtension`, `Password`, `Level`) VALUES
(2, 'tech1', 'Princess', 'Ellis', 'technician@test.com', '101', '$2y$10$Yt6tAY9eBq4CzWvnfNcTIuAfvCrcwQR4xoU.B1fvn4/nonLdilsq6', 'Technician'),
(3, 'admin1', 'Princess', 'Ellis', 'admin@test.com', '100', '$2y$10$Yt6tAY9eBq4CzWvnfNcTIuAfvCrcwQR4xoU.B1fvn4/nonLdilsq6', 'Administrator'),
(4, 'tech2', 'test2', 'technician', 'tech2@test.com', '108', '$2y$10$1mtHDKKNhEQMMaC/sNh0C.WoQy8Pexd3zKexv/XXf2cLkyPhbnCuu', 'Technician');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(111) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `Description`, `Active`) VALUES
(1, 'Website Hosting', 'Website hosting and server services', 1),
(2, 'Website Design', 'Professional website design services', 1),
(3, 'Technical Support', 'Technical assistance and troubleshooting', 1),
(4, 'Cloud Backup', 'Cloud-based data backup services', 1),
(5, 'Domain Registration', 'Domain name registration and management', 1),
(6, 'Email Support', 'Email support and troubleshooting services', 1),
(7, 'Customer Satisfaction', 'Support for unsatisfied customers.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `technician_notes`
--

CREATE TABLE `technician_notes` (
  `NoteID` int(11) NOT NULL,
  `ComplaintID` int(11) NOT NULL,
  `TechnicianID` int(11) NOT NULL,
  `NoteText` text NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technician_notes`
--

INSERT INTO `technician_notes` (`NoteID`, `ComplaintID`, `TechnicianID`, `NoteText`, `DateCreated`) VALUES
(1, 1, 2, 'Hi, can you give me the invoice or order number you received when payment was received?', '2026-09-20 14:08:13'),
(2, 2, 2, 'This is technician speaking from test are you seeing these messages?', '2026-09-27 05:09:40'),
(3, 2, 2, 'make sure you are allowed to respond back to me', '2026-09-27 05:15:03'),
(4, 6, 4, 'will be adding and fixing test message if needed', '2026-10-04 20:01:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`ComplaintID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `ComplaintTypeID` (`ComplaintTypeID`),
  ADD KEY `TechnicianID` (`TechnicianID`);

--
-- Indexes for table `complaint_images`
--
ALTER TABLE `complaint_images`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `ComplaintID` (`ComplaintID`);

--
-- Indexes for table `complaint_messages`
--
ALTER TABLE `complaint_messages`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `ComplaintID` (`ComplaintID`);

--
-- Indexes for table `complaint_types`
--
ALTER TABLE `complaint_types`
  ADD PRIMARY KEY (`ComplaintTypeID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `technician_notes`
--
ALTER TABLE `technician_notes`
  ADD PRIMARY KEY (`NoteID`),
  ADD KEY `ComplaintID` (`ComplaintID`),
  ADD KEY `TechnicianID` (`TechnicianID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `ComplaintID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaint_images`
--
ALTER TABLE `complaint_images`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaint_messages`
--
ALTER TABLE `complaint_messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `complaint_types`
--
ALTER TABLE `complaint_types`
  MODIFY `ComplaintTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `technician_notes`
--
ALTER TABLE `technician_notes`
  MODIFY `NoteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `fk_complaints_customer` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `fk_complaints_product` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`),
  ADD CONSTRAINT `fk_complaints_technician` FOREIGN KEY (`TechnicianID`) REFERENCES `employees` (`EmployeeID`),
  ADD CONSTRAINT `fk_complaints_type` FOREIGN KEY (`ComplaintTypeID`) REFERENCES `complaint_types` (`ComplaintTypeID`);

--
-- Constraints for table `complaint_images`
--
ALTER TABLE `complaint_images`
  ADD CONSTRAINT `fk_images_complaint` FOREIGN KEY (`ComplaintID`) REFERENCES `complaints` (`ComplaintID`);

--
-- Constraints for table `complaint_messages`
--
ALTER TABLE `complaint_messages`
  ADD CONSTRAINT `fk_message_complaint` FOREIGN KEY (`ComplaintID`) REFERENCES `complaints` (`ComplaintID`) ON DELETE CASCADE;

--
-- Constraints for table `technician_notes`
--
ALTER TABLE `technician_notes`
  ADD CONSTRAINT `fk_notes_complaint` FOREIGN KEY (`ComplaintID`) REFERENCES `complaints` (`ComplaintID`),
  ADD CONSTRAINT `fk_notes_technician` FOREIGN KEY (`TechnicianID`) REFERENCES `employees` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
