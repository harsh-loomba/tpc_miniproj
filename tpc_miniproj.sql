-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 08:48 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'e64b78fc3bc91bcbc7dc232ba8ec59e0');

-- --------------------------------------------------------

--
-- Table structure for table `alumni_placement`
--

CREATE TABLE `alumni_placement` (
  `rollno` char(8) NOT NULL,
  `com_name` varchar(256) NOT NULL,
  `CTC` bigint(20) DEFAULT NULL,
  `field_of_work` varchar(256) NOT NULL,
  `position` varchar(256) NOT NULL,
  `location` varchar(256) NOT NULL,
  `from_yr` year(4) NOT NULL,
  `to_yr` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `username` varchar(50) NOT NULL,
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
('googs', 'google@gmail.com', '589065d67d5a557898f4183950ec58cf', 'Google', 'hui hiu', '1234567890', 2010);

-- --------------------------------------------------------

--
-- Table structure for table `company_cutoff`
--

CREATE TABLE `company_cutoff` (
  `username` varchar(50) NOT NULL,
  `course` enum('B.Tech. / B.S.','M.Tech.','Ph.D.') NOT NULL,
  `branch` char(2) NOT NULL,
  `cutoff` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_interview`
--

CREATE TABLE `company_interview` (
  `username` varchar(50) NOT NULL,
  `round` tinyint(4) NOT NULL,
  `mode` enum('Online','Offline') NOT NULL,
  `type` enum('Written','Coding','Interview') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_job`
--

CREATE TABLE `company_job` (
  `username` varchar(50) NOT NULL,
  `field` varchar(256) NOT NULL,
  `position` varchar(256) NOT NULL,
  `package` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('2101AI42', 'tejas_2101ai42@iitp.ac.in', '25f9e794323b453885f5181f1b624d0b', 'Tejas', '', 'Budhwal', '1234567890', 'B.Tech.', 'AI', 2025, 0, NULL, NULL, NULL),
('2101CS32', 'harsh_2101cs32@iitp.ac.in', '31f5254220360cf7c2121f6e2e4fa9e4', 'Harsh', '', 'Loomba', '9414707653', 'B.Tech.', 'CS', 2025, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_aoi`
--

CREATE TABLE `student_aoi` (
  `rollno` char(8) NOT NULL,
  `AOI` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_placement`
--

CREATE TABLE `student_placement` (
  `rollno` char(8) NOT NULL,
  `is_intern` tinyint(1) NOT NULL,
  `com_name` varchar(256) NOT NULL,
  `CTC` bigint(20) NOT NULL,
  `field_of_work` varchar(256) NOT NULL,
  `position` varchar(256) NOT NULL,
  `location` varchar(256) NOT NULL,
  `year` year(4) NOT NULL,
  `offcampus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni_placement`
--
ALTER TABLE `alumni_placement`
  ADD KEY `alumni_placement_fk1` (`rollno`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `company_cutoff`
--
ALTER TABLE `company_cutoff`
  ADD PRIMARY KEY (`username`,`course`,`branch`);

--
-- Indexes for table `company_interview`
--
ALTER TABLE `company_interview`
  ADD PRIMARY KEY (`username`,`round`);

--
-- Indexes for table `company_job`
--
ALTER TABLE `company_job`
  ADD KEY `company_job_fk1` (`username`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`rollno`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_aoi`
--
ALTER TABLE `student_aoi`
  ADD UNIQUE KEY `rollno` (`rollno`);

--
-- Indexes for table `student_placement`
--
ALTER TABLE `student_placement`
  ADD KEY `student_placement_fk1` (`rollno`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni_placement`
--
ALTER TABLE `alumni_placement`
  ADD CONSTRAINT `alumni_placement_fk1` FOREIGN KEY (`rollno`) REFERENCES `student` (`rollno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_cutoff`
--
ALTER TABLE `company_cutoff`
  ADD CONSTRAINT `company_cutoff_fk1` FOREIGN KEY (`username`) REFERENCES `company` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_interview`
--
ALTER TABLE `company_interview`
  ADD CONSTRAINT `company_interview_fk1` FOREIGN KEY (`username`) REFERENCES `company` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_job`
--
ALTER TABLE `company_job`
  ADD CONSTRAINT `company_job_fk1` FOREIGN KEY (`username`) REFERENCES `company` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_aoi`
--
ALTER TABLE `student_aoi`
  ADD CONSTRAINT `student_AOI_fk1` FOREIGN KEY (`rollno`) REFERENCES `student` (`rollno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_placement`
--
ALTER TABLE `student_placement`
  ADD CONSTRAINT `student_placement_fk1` FOREIGN KEY (`rollno`) REFERENCES `student` (`rollno`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
