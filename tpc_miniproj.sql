-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 08:40 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpc_miniproj`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `username` char(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` char(32) NOT NULL,
  `com_name` varchar(256) NOT NULL,
  `rep_name` varchar(256) DEFAULT NULL,
  `phone` char(10) DEFAULT NULL,
  `recruit_yr` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`username`, `email`, `password`, `com_name`, `rep_name`, `phone`, `recruit_yr`) VALUES
('googs', 'google@gmail.com', 'a8cdd4f9ce6b0b3a1f18842fe173e985', 'Google', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `rollno` char(8) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` char(32) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone` char(10) NOT NULL,
  `course` enum('B.Tech.','B.S.','M.Tech.','Ph.D.') NOT NULL,
  `branch` char(2) NOT NULL,
  `grad_yr` year(4) NOT NULL,
  `is_alumnus` tinyint(1) NOT NULL,
  `grade10` float DEFAULT NULL,
  `grade12` float DEFAULT NULL,
  `CPI` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`rollno`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `phone`, `course`, `branch`, `grad_yr`, `is_alumnus`, `grade10`, `grade12`, `CPI`) VALUES
('1701CS32', 'sparsh_1701cs32@iitp.ac.in', '25f9e794323b453885f5181f1b624d0b', 'Sparsh', 'Saarubhai', 'Mittal', '1234567890', 'B.Tech.', 'CS', 2022, 1, NULL, NULL, NULL),
('2101CS32', 'harsh_2101cs32@iitp.ac.in', '31f5254220360cf7c2121f6e2e4fa9e4', 'Harsh', '', 'Loomba', '9414707653', 'B.Tech.', 'CS', 2025, 0, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`rollno`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
