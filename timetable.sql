-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2019 at 11:53 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timetable`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(255) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `department`) VALUES
(1, 'BACHELOR OF INFORMATION TECHNOLOGY', 'Department of Computing & Information Technology'),
(2, 'BACHELOR OF COMPUTER SCIENCE', 'Department of Computing & Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(2) DEFAULT NULL,
  `name` varchar(93) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'Department of Agricultural Economics'),
(2, 'Department of Animal Science'),
(3, 'Department of Agricultural Sciences and Technology'),
(4, 'Department of Architecture and interior design'),
(5, 'Department of Spatial Planning and Urban Management'),
(6, 'Department of Real Estate and Construction Management'),
(7, 'Department of Business Administration'),
(8, 'Department of Management Science'),
(9, 'Department of Accounting and Finance'),
(10, 'Department of Communication, Media, Film & Theatre Studies'),
(11, 'Department of Fine Art and Design'),
(12, 'Department of Music and Dance'),
(13, 'Department of Fashion Design & Marketing '),
(14, 'Department of Applied Economics'),
(15, 'Department of Econometrics & Statistics'),
(16, 'Department of Economic Theory'),
(17, 'Department of Computing & Information Technology'),
(18, 'Department of Mechanical Engineering'),
(19, 'Department of Energy Engineering'),
(20, 'Department of Civil Engineering'),
(21, 'Department of Electrical & Electronic Engineering'),
(22, 'Department of Agricultural and Biosystems Engineering'),
(23, 'Department of Environmental Planning and Management'),
(24, 'Department of Environmental Science and Education'),
(25, 'Department of Environmental Studies and Community Development'),
(26, 'Department of Educational Psychology'),
(27, 'Department of Educational Management Policy & Curriculum Studies'),
(28, 'Department of Educational Communication & Technology'),
(29, 'Department of Educational Foundations'),
(30, 'Department of Library & Information Science'),
(31, 'Department of Early Childhood & Special Needs'),
(32, 'Department of Hospitality and Tourism Management'),
(33, 'Department of Recreation and Sports Management'),
(34, 'Department of Literature Languages And Linguistics'),
(35, 'Department of Geography'),
(36, 'Department of Sociology Gender & Development Studies'),
(37, 'Department of History, Archeology & Political Studies'),
(38, 'Department of Kiswahili and African Language'),
(39, 'Department of Philosophy and Religious Studies'),
(40, 'Department of Psychology'),
(41, 'Department of Public Policy and Administration (PPA)'),
(42, 'Department of Public Law'),
(43, 'Department of Private Law'),
(44, 'Department of Human Anatomy'),
(45, 'Department of Pathology'),
(46, 'Department of Medical Physiology'),
(47, 'Department of Medical Laboratory Sciences'),
(48, 'Department of Paediatrics and Child Health'),
(49, 'Department of Obstetrics and Gynaecology'),
(50, 'Department of Medicine, Therapeutics, Dermatology and Psychiatry'),
(51, 'Department of Surgery and Orthopaedics'),
(52, 'Department of Medical Surgical Nursing and Pre-clinical Services'),
(53, 'Department of Community and Reproductive Health Nursing'),
(54, 'Students practicum in the medicinal garden'),
(55, 'Department of Pharmacognosy, Pharmaceutical Chemistry And Pharmaceutics & Industrial Pharmacy'),
(56, 'Department Of Pharmacology And Clinical Pharmacy'),
(57, 'Department of Community Health and Epidemiology'),
(58, 'Department of Environmental & Occupational Health'),
(59, 'Department of Health Management and Informatics'),
(60, 'Department of Population, Reproductive Health & Community Resource Management'),
(61, 'Department of Food, Nutrition And Dietetics'),
(62, 'Department of Physical Education, Exercise & Sports Science'),
(63, 'Department of Conflict Resolution And International Relations'),
(64, 'Department of Security and Correction Science'),
(65, 'Department of Biochemistry, Microbiology and Biotechnology'),
(66, 'Department of Chemistry'),
(67, 'Department of Mathematics & Actuarial Science'),
(68, 'Department of Plant Sciences'),
(69, 'Department of Physics'),
(70, 'Department of Zoological Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year_of_study` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `supervisor` varchar(30) NOT NULL,
  `date` varchar(50) NOT NULL,
  `from_time` varchar(50) NOT NULL,
  `to_time` varchar(50) NOT NULL,
  `room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `id` int(255) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year_of_study` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `fragment` varchar(30) NOT NULL,
  `lecturer` varchar(30) NOT NULL,
  `room` varchar(10) NOT NULL,
  `from_time` varchar(10) NOT NULL,
  `to_time` varchar(10) NOT NULL,
  `color` varchar(5) NOT NULL,
  `course_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`id`, `lesson_name`, `code`, `department`, `course`, `year_of_study`, `semester`, `fragment`, `lecturer`, `room`, `from_time`, `to_time`, `color`, `course_id`) VALUES
(1, 'development studies', 'sit 203', 'Department of Computing & Information Technology', 'BACHELOR OF INFORMATION TECHNOLOGY', 'Year 1', 'Semester 1', 'Monday', 'kandiri', 'elh4', '11:21 PM', '12:12 AM', '-1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `department`) VALUES
(1, 'eric', '1234', 'Department of Computing & Information Technology');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
