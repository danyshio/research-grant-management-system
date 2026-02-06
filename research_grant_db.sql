-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 06, 2026 at 10:37 PM
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `research_grant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `budgetId` int NOT NULL,
  `proposalId` int NOT NULL,
  `item` varchar(200) NOT NULL,
  `cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`budgetId`, `proposalId`, `item`, `cost`) VALUES
(1, 1, 'Equipment Purchase', 20000),
(2, 1, 'Research Assistant Salary', 30000);

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `documentId` int NOT NULL,
  `proposalId` int NOT NULL,
  `submissionDate` date NOT NULL,
  `status` enum('Uploaded','Reviewed') NOT NULL,
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`documentId`, `proposalId`, `submissionDate`, `status`, `comments`) VALUES
(1, 1, '2026-02-05', 'Uploaded', 'Proposal document uploaded.');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackId` int NOT NULL,
  `proposalId` int NOT NULL,
  `content` text NOT NULL,
  `feedbackDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackId`, `proposalId`, `content`, `feedbackDate`) VALUES
(1, 1, 'Minor improvements required in methodology section.', '2026-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `grant_funding`
--

CREATE TABLE `grant_funding` (
  `grantId` int NOT NULL,
  `proposalId` int NOT NULL,
  `amount` double NOT NULL,
  `allocationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grant_funding`
--

INSERT INTO `grant_funding` (`grantId`, `proposalId`, `amount`, `allocationDate`) VALUES
(1, 1, 50000, '2026-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notificationId` int NOT NULL,
  `userId` int NOT NULL,
  `message` text NOT NULL,
  `dateTime` datetime NOT NULL,
  `status` enum('Read','Unread') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationId`, `userId`, `message`, `dateTime`, `status`) VALUES
(1, 1, 'Your proposal has been submitted successfully.', '2026-02-05 22:57:41', 'Unread'),
(2, 2, 'New proposal assigned to you for review', '2026-02-06 17:46:48', 'Unread'),
(3, 3, 'A review has been submitted and waiting for approval', '2026-02-07 03:25:04', 'Unread'),
(4, 2, 'Your proposal has been Approved by HOD', '2026-02-07 03:28:46', 'Unread'),
(5, 1, 'Your proposal has been Approved by HOD', '2026-02-07 05:48:17', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `progress_report`
--

CREATE TABLE `progress_report` (
  `reportId` int NOT NULL,
  `proposalId` int NOT NULL,
  `submissionDate` date NOT NULL,
  `status` enum('Submitted','Reviewed') NOT NULL,
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `progress_report`
--

INSERT INTO `progress_report` (`reportId`, `proposalId`, `submissionDate`, `status`, `comments`) VALUES
(1, 1, '2026-02-05', 'Submitted', 'Initial progress completed.');

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `proposalId` int NOT NULL,
  `userId` int NOT NULL,
  `title` varchar(200) NOT NULL,
  `abstract` text NOT NULL,
  `submissionDate` date NOT NULL,
  `status` enum('Submitted','Pending','Reviewed','Approved','Rejected') NOT NULL,
  `reviewerId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`proposalId`, `userId`, `title`, `abstract`, `submissionDate`, `status`, `reviewerId`) VALUES
(1, 1, 'AI-Based Flood Prediction System', 'This research proposes an AI-based system to predict floods using real-time data.', '2026-02-05', 'Approved', NULL),
(2, 2, 'AI CANCER DETECTION', 'Using AI to detect cancer early.', '2026-02-06', 'Approved', 2);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewId` int NOT NULL,
  `proposalId` int NOT NULL,
  `decision` enum('Approve','Reject','Request Changes') NOT NULL,
  `comments` text NOT NULL,
  `reviewDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewId`, `proposalId`, `decision`, `comments`, `reviewDate`) VALUES
(1, 1, 'Approve', 'The proposal is well-structured and feasible.', '2026-02-05'),
(2, 1, 'Approve', 'kumbaya', '2026-02-06'),
(3, 1, 'Approve', 'blabka', '2026-02-06'),
(4, 2, 'Approve', 'lock in', '2026-02-06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Researcher','Reviewer','HOD','Admin') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'Iliya Researcher', 'iliya@uni.edu', '12345', 'Researcher', 'Active'),
(2, 'Dr Danysh Reviewer', 'danysh@uni.edu', '12345', 'Reviewer', 'Active'),
(3, 'Prof Thash HOD', 'tan@uni.edu', '12345', 'HOD', 'Active'),
(4, 'Admin Mustafa', 'admin@uni.edu', '12345', 'Admin', 'Active'),
(6, '', 'test1@uni.edu', '12345', 'Researcher', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`budgetId`),
  ADD KEY `proposalId` (`proposalId`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`documentId`),
  ADD KEY `proposalId` (`proposalId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `proposalId` (`proposalId`);

--
-- Indexes for table `grant_funding`
--
ALTER TABLE `grant_funding`
  ADD PRIMARY KEY (`grantId`),
  ADD KEY `proposalId` (`proposalId`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `progress_report`
--
ALTER TABLE `progress_report`
  ADD PRIMARY KEY (`reportId`),
  ADD KEY `proposalId` (`proposalId`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`proposalId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `proposalId` (`proposalId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `budgetId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `documentId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grant_funding`
--
ALTER TABLE `grant_funding`
  MODIFY `grantId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `progress_report`
--
ALTER TABLE `progress_report`
  MODIFY `reportId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `proposalId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`proposalId`) REFERENCES `proposal` (`proposalId`);

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`proposalId`) REFERENCES `proposal` (`proposalId`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`proposalId`) REFERENCES `proposal` (`proposalId`);

--
-- Constraints for table `grant_funding`
--
ALTER TABLE `grant_funding`
  ADD CONSTRAINT `grant_funding_ibfk_1` FOREIGN KEY (`proposalId`) REFERENCES `proposal` (`proposalId`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `progress_report`
--
ALTER TABLE `progress_report`
  ADD CONSTRAINT `progress_report_ibfk_1` FOREIGN KEY (`proposalId`) REFERENCES `proposal` (`proposalId`);

--
-- Constraints for table `proposal`
--
ALTER TABLE `proposal`
  ADD CONSTRAINT `proposal_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`proposalId`) REFERENCES `proposal` (`proposalId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
