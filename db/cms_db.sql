-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 03:43 PM
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
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjourns`
--

CREATE TABLE IF NOT EXISTS `adjourns` (
  `adjourns_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `next_hearing_date` date NOT NULL,
  `next_hearing_time` time NOT NULL,
  `adjourn_comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`adjourns_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adjourns`
--

INSERT INTO `adjourns` (`adjourns_id`, `case_id`, `next_hearing_date`, `next_hearing_time`, `adjourn_comments`, `created_at`, `updated_at`) VALUES
(3, 3, '2025-04-05', '06:12:00', 'Time changed', '2025-03-20 05:07:58', '2025-04-23 05:09:53'),
(4, 3, '2025-04-23', '00:00:00', 'Wow', '2025-04-23 04:48:20', '2025-04-23 04:48:20'),
(5, 3, '2025-04-23', '10:55:00', 'Hello Mungwana', '2025-04-23 04:56:11', '2025-04-23 04:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `adjourn_attachments`
--

CREATE TABLE IF NOT EXISTS `adjourn_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `adjourns_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `adjourns_id` (`adjourns_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjourn_attachments`
--

INSERT INTO `adjourn_attachments` (`attachment_id`, `adjourns_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(3, 3, 'Admission_Letter.pdf', 'adjourn_attachments/0wM3taGwdPMEUaowc0F4oWT5HlOCW5NqZ7iU7pvQ.pdf', 'pdf', '2025-03-20 06:03:01', '2025-03-20 06:03:01', '2025-03-20 06:03:01'),
(4, 3, 'Drawing 3 (4).pdf', 'adjourn_attachments/jpMO3QQxfeTaGWfw4GrlLRsG9CdXSUrYRPkz2kIj.pdf', 'pdf', '2025-03-20 06:03:20', '2025-03-20 06:03:20', '2025-03-20 06:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `appeal`
--

CREATE TABLE IF NOT EXISTS `appeal` (
  `appeal_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `next_hearing_date` date NOT NULL,
  `next_hearing_time` time NOT NULL,
  `appeal_comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`appeal_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appeal`
--

INSERT INTO `appeal` (`appeal_id`, `case_id`, `next_hearing_date`, `next_hearing_time`, `appeal_comments`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-04-05', '00:06:00', 'Not good. coder', '2025-03-18 08:49:09', '2025-04-23 08:23:19'),
(2, 4, '2025-03-13', '00:00:00', 'Changing data', '2025-03-18 08:49:09', '2025-03-20 07:07:36'),
(3, 6, '2025-03-05', '00:00:00', 'Working on it', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(4, 9, '2025-03-04', '00:00:00', 'Cobo', '2025-03-18 08:49:09', '2025-03-20 07:08:39'),
(6, 11, '2025-03-22', '00:00:00', 'Juh', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(7, 11, '2025-03-07', '00:00:00', 'fd', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(8, 11, '2025-03-07', '00:00:00', 'deede', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(9, 11, '2025-03-22', '00:00:00', 'efrewdfv', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(10, 3, '2025-03-12', '00:00:00', 'I have come Lord to do your will.', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(11, 3, '2025-03-12', '00:00:00', 'ghfg', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(12, 3, '2025-03-14', '00:00:00', 'Loading', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(13, 3, '2025-03-04', '00:00:00', 'Trer', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(14, 3, '2025-03-06', '00:00:00', 'James', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(15, 3, '2025-03-18', '00:00:00', 'adasdsa', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(16, 3, '2025-03-06', '00:00:00', 'gfdgfg', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(17, 3, '2025-03-06', '00:00:00', 'Coding is smatter', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(18, 3, '2025-03-06', '00:00:00', 'ewew', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(19, 3, '2025-03-06', '00:00:00', 'Yawa', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(20, 3, '2025-03-13', '00:00:00', 'Creating systems', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(21, 3, '2025-03-13', '00:00:00', 'Appeal form.', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(22, 3, '2025-03-11', '00:00:00', 'fff', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(23, 3, '2025-03-06', '00:00:00', 'Hello', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(24, 3, '2025-03-20', '00:00:00', 'Hello', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(25, 3, '2025-03-14', '00:00:00', 'Hello', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(26, 3, '2025-03-06', '00:00:00', 'Guur', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(27, 3, '2025-03-07', '00:00:00', NULL, '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(28, 3, '2025-03-12', '00:00:00', 'Hi', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(29, 3, '2025-03-18', '00:00:00', 'Jambo Kenya', '2025-03-18 08:49:09', '2025-03-18 08:49:09'),
(30, 2, '2025-03-05', '00:00:00', 'Pangla Pungu', '2025-03-18 08:51:09', '2025-03-18 08:51:09'),
(31, 3, '2025-05-10', '11:25:00', 'Not good', '2025-04-23 08:20:02', '2025-04-23 08:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `appeal_attachments`
--

CREATE TABLE IF NOT EXISTS `appeal_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `appeal_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` datetime NOT NULL DEFAULT '2025-03-18 06:14:24',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attachment_id`),
  KEY `fk_appeal_attachments_appeal` (`appeal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appeal_attachments`
--

INSERT INTO `appeal_attachments` (`attachment_id`, `appeal_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(1, 24, 'Drawing 4 (2).pdf', 'appeal_attachments/Q5DrkUDfxocO00ZPn8zBzww4XdG94ggXtp8fQOoq.pdf', 'pdf', '2025-03-18 07:48:09', '2025-03-18 04:48:09', '2025-03-18 04:48:09'),
(2, 25, 'Drawing 4.pdf', 'appeal_attachments/VFbDESZ2ETRuN6QqvmEx97AnB56hrxsC2SBRjg8Q.pdf', 'pdf', '2025-03-18 08:06:00', '2025-03-18 05:06:00', '2025-03-18 05:06:00'),
(3, 26, 'Drawing 5 (1).pdf', 'appeal_attachments/cM59vNLGDvbdujmydKDtsfLYeGCtRMHUgtArptOZ.pdf', 'pdf', '2025-03-18 08:11:17', '2025-03-18 05:11:17', '2025-03-18 05:11:17'),
(4, 27, 'Drawing 3 (2).pdf', 'public/appeal_attachments/C5AR5F7g7OgOaVeAVRYPgushIYX0UJfmgqQWc1ai.pdf', 'pdf', '2025-03-18 08:26:55', '2025-03-18 05:26:55', '2025-03-18 05:26:55'),
(6, 29, 'Drawing 3 (2).pdf', 'storage/appeal_attachments/p2XdkJ7MoL2192olXpOBGXDnMAEu3EYWVvwHgw8V.pdf', 'pdf', '2025-03-18 08:46:32', '2025-03-18 05:46:32', '2025-03-18 05:46:32'),
(7, 30, '16.4.6-packet-tracer---configure-secure-passwords-and-ssh.pka', 'storage/appeal_attachments/AeaEGqxK6zOlCPw0zx452w0jk0OsX55sT1DIiJjX.bin', 'pka', '2025-03-18 08:51:13', '2025-03-18 05:51:13', '2025-03-18 05:51:13'),
(10, 2, 'Drawing 5 (2).pdf', 'appeal_attachments/PJUA1VVvA98t9BkPG4dDME9C3YGDeVJYjZWrE8Xg.pdf', 'pdf', '2025-03-20 05:52:52', '2025-03-20 02:52:52', '2025-03-20 02:52:52'),
(12, 4, 'Drawing 5 (5).pdf', 'appeal_attachments/KVYm1zN6GFa5bejEnbxcFaXE795UXavB41flbt6S.pdf', 'pdf', '2025-03-20 06:03:12', '2025-03-20 03:03:12', '2025-03-20 03:03:12'),
(13, 4, 'Drawing 5 (5).pdf', 'appeal_attachments/TCkWbgOsSMkSJV0Tyd0Zp2ibywYfq7L66pS9p6Tt.pdf', 'pdf', '2025-03-20 06:04:00', '2025-03-20 03:04:00', '2025-03-20 03:04:00'),
(14, 7, 'Drawing 3.pdf', 'appeal_attachments/NfOEcrO8mvZAY6J9ZepzOwflTv3OAYlaeQpiIoZS.pdf', 'pdf', '2025-03-20 06:10:15', '2025-03-20 03:10:15', '2025-03-20 03:10:15'),
(15, 7, 'Drawing 3.pdf', 'appeal_attachments/CMYcW1u4rHIQyd0NZRjLrj3PzDs2wRUJDdiPQcjt.pdf', 'pdf', '2025-03-20 06:10:18', '2025-03-20 03:10:18', '2025-03-20 03:10:18'),
(16, 7, 'Drawing 4.pdf', 'appeal_attachments/ExRjchWVZAHdY7dnGokFdp2X49WFKMBfFT1kr04E.pdf', 'pdf', '2025-03-20 06:11:53', '2025-03-20 03:11:53', '2025-03-20 03:11:53'),
(17, 8, 'Drawing 3 (3).pdf', 'appeal_attachments/69f4XVA8xxsAHmS21netyc7nZ5pRHwkGLIaG8jyn.pdf', 'pdf', '2025-03-20 06:13:09', '2025-03-20 03:13:09', '2025-03-20 03:13:09'),
(21, 8, 'Drawing1 (13).pdf', 'appeal_attachments/2NnzIQQOZvfzn17AOsiipmVd1nCAZ882fAfBGYWs.pdf', 'pdf', '2025-03-20 06:19:09', '2025-03-20 03:19:09', '2025-03-20 03:19:09'),
(23, 1, 'Drawing 3 (2).pdf', 'appeal_attachments/0tDBPMBwokhXwZTv67SbYicgzeFgBnZRx93x84VF.pdf', 'pdf', '2025-03-20 06:30:22', '2025-03-20 03:30:22', '2025-03-20 03:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `caseclosures`
--

CREATE TABLE IF NOT EXISTS `caseclosures` (
  `closure_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `closure_date` date NOT NULL,
  `final_outcome` text DEFAULT NULL,
  `follow_up_actions` text DEFAULT NULL,
  `lawyer_payment_confirmed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`closure_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `caseclosures`
--

INSERT INTO `caseclosures` (`closure_id`, `case_id`, `closure_date`, `final_outcome`, `follow_up_actions`, `lawyer_payment_confirmed`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-03-14', 'Loss', 'Not a single. Amen', 'Yes', '2025-03-24 06:26:00', '2025-03-25 03:13:47'),
(2, 3, '2025-03-20', 'Win', 'Hello', 'Yes', '2025-03-24 06:30:15', '2025-03-25 03:12:53'),
(3, 2, '2025-03-14', 'Loss', 'Jaba', 'Yes', '2025-03-24 06:30:51', '2025-03-24 06:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `caseclosure_attachments`
--

CREATE TABLE IF NOT EXISTS `caseclosure_attachments` (
  `attachment_id` int(20) NOT NULL AUTO_INCREMENT,
  `caseclosure_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `caseclosure_id` (`caseclosure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `caseclosure_attachments`
--

INSERT INTO `caseclosure_attachments` (`attachment_id`, `caseclosure_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(1, 2, 'Drawing 3 (3).pdf', 'storage/case_closure_attachments/PLVMaig7hfSjpWm3mLA7wuA7FO81idAg4dvSpUTi.pdf', 'pdf', '2025-03-24 06:30:15', '2025-03-24 06:30:15', '2025-03-24 06:30:15'),
(2, 3, 'Admission_Letter.pdf', 'storage/case_closure_attachments/swS2yTvd5c9hhfY70FUNEo7AXJbQavXZUnqeXyOP.pdf', 'pdf', '2025-03-24 06:30:51', '2025-03-24 06:30:51', '2025-03-24 06:30:51'),
(4, 1, 'Drawing 4 (3).pdf', 'case_closure_attachments/FArxhujoggnqPq8BDtZaSJk7ZnivdCYmlCpLY4za.pdf', 'pdf', '2025-03-24 08:58:41', '2025-03-24 08:58:41', '2025-03-24 08:58:41'),
(9, 3, 'Admission_Letter.pdf', 'case_closure_attachments/t29iURpynjJGmsZ2RLhJd58X9oUva4brd2WhXeUN.pdf', 'pdf', '2025-03-24 09:04:24', '2025-03-24 09:04:24', '2025-03-24 09:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE IF NOT EXISTS `cases` (
  `case_id` int(11) NOT NULL AUTO_INCREMENT,
  `track_number` varchar(255) DEFAULT NULL,
  `case_number` varchar(255) NOT NULL,
  `case_name` varchar(255) NOT NULL,
  `date_received` date NOT NULL,
  `time_received` time DEFAULT NULL,
  `case_description` text NOT NULL,
  `case_status` enum('Waiting for First Hearing','Under Review','Waiting for Panel Evaluation','Waiting for AG Advice','Forwarded to DVC','Under Trial','Judgement Rendered','Closed') DEFAULT 'Under Review',
  `case_category` enum('Academic','Disciplinary','Administrative','student','staff','supplier','staff union') NOT NULL,
  `initial_status` enum('Under Review','Approved','Rejected','Needs Negotiation') NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`case_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`case_id`, `track_number`, `case_number`, `case_name`, `date_received`, `time_received`, `case_description`, `case_status`, `case_category`, `initial_status`, `created_by`, `created_at`, `updated_at`) VALUES
(2, NULL, 'fbdhbdsh', 'Okiya Omtata Vs Genz', '0001-11-11', NULL, '1111', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-02-26 10:51:56', '2025-02-26 10:51:56'),
(3, NULL, 'CASE-2025001', 'John Doe vs University', '2025-02-28', NULL, '\'This is a test case description for a dispute.\',', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-02-26 11:14:38', '2025-02-26 11:14:38'),
(4, NULL, 'aereg', 'gfdgdf', '0001-11-11', NULL, '111', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-02-27 06:48:16', '2025-02-27 06:48:16'),
(5, NULL, '121212', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, '454545454', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-02-27 10:33:21', '2025-02-27 10:33:21'),
(6, NULL, 'fbdhbdshwewe', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, '11111', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-02-27 10:34:51', '2025-02-27 10:34:51'),
(7, NULL, '14235432f', 'fgfgfd', '1111-11-11', NULL, '1111', 'Waiting for First Hearing', 'Academic', 'Under Review', NULL, '2025-02-28 09:10:09', '2025-02-28 09:10:09'),
(8, NULL, 'Nyama Choma', 'weewe1', '1111-01-11', NULL, 'We eat nyama', 'Forwarded to DVC', 'Academic', 'Approved', NULL, '2025-02-28 09:16:03', '2025-03-06 04:56:31'),
(9, NULL, 'guuuuuuuut', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, 'fggfd', 'Waiting for First Hearing', 'Academic', 'Under Review', NULL, '2025-02-28 09:26:11', '2025-02-28 09:26:11'),
(10, NULL, 'rr11fgf', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, '1212', 'Closed', 'Disciplinary', 'Approved', NULL, '2025-02-28 09:36:23', '2025-02-28 09:36:23'),
(11, NULL, 'gury', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, '11111', 'Under Review', 'Administrative', 'Approved', NULL, '2025-02-28 09:40:09', '2025-02-28 09:40:09'),
(12, NULL, '111212', 'Okiya Omtata Vs Genz', '2222-02-22', NULL, '2222', 'Waiting for First Hearing', 'Academic', 'Under Review', NULL, '2025-02-28 10:07:07', '2025-02-28 10:07:07'),
(13, NULL, '12121', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, '1111', 'Judgement Rendered', 'staff union', 'Under Review', NULL, '2025-02-28 10:11:33', '2025-02-28 10:11:33'),
(14, NULL, 'thht', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, 'fdfrfg', 'Waiting for First Hearing', 'Academic', 'Under Review', NULL, '2025-02-28 10:29:35', '2025-02-28 10:29:35'),
(15, NULL, 'fbdhbdshewrwe', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, '11', 'Waiting for First Hearing', 'Academic', 'Under Review', NULL, '2025-03-03 05:45:32', '2025-03-03 05:45:32'),
(16, NULL, 'f3f', 'gfgfd', '1111-11-11', NULL, '111', 'Waiting for AG Advice', 'staff', 'Under Review', NULL, '2025-03-03 06:19:07', '2025-03-03 06:19:07'),
(17, NULL, '2232', 'Okiya Omtata Vs KU', '1111-11-11', NULL, 'Testing created by', 'Under Review', 'staff union', 'Under Review', 1, '2025-03-04 06:36:19', '2025-03-04 06:36:19'),
(18, NULL, '1234545654', 'Okiya Omtata Vs Genz', '2024-05-28', NULL, 'Bado', 'Waiting for Panel Evaluation', 'Academic', 'Approved', 1, '2025-03-10 06:53:22', '2025-03-10 06:53:22'),
(19, NULL, '31241234', 'Okiya Omtata Vs Genz', '1111-11-11', NULL, 'Bado', 'Under Review', 'Disciplinary', 'Approved', 1, '2025-03-10 07:14:56', '2025-03-10 07:14:56'),
(20, NULL, 'CASE-2025002', 'Okiya Omtata Vs Genz', '2025-04-14', NULL, 'Ngoka', 'Waiting for Panel Evaluation', 'Academic', 'Under Review', 1, '2025-04-14 09:45:28', '2025-04-14 09:45:28'),
(21, NULL, 'CASE-2025004', 'Okiya Omtata Vs KU', '2025-04-25', NULL, 'Hello', 'Under Review', 'Academic', 'Under Review', 1, '2025-04-14 09:48:50', '2025-04-14 09:48:50'),
(22, NULL, 'CASE-2025005', 'Okiya Omtata Vs Genz', '2025-05-09', NULL, 'Jaba', 'Under Review', 'Academic', 'Under Review', 1, '2025-04-14 09:52:05', '2025-04-14 09:52:05'),
(23, NULL, 'CASE-2025006', 'Okiya Omtata Vs Genz', '2025-04-23', NULL, 'Hello', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 09:54:04', '2025-04-14 09:54:04'),
(24, NULL, 'CASE-2025007', 'Okiya Omtata Vs Genz', '2025-04-14', NULL, 'He', 'Under Review', 'Academic', 'Under Review', 1, '2025-04-14 09:59:51', '2025-04-14 09:59:51'),
(25, NULL, 'CASE-2025008', 'Okiya Omtata Vs Genz', '2025-04-14', NULL, 'Jaba', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 10:05:00', '2025-04-14 10:05:00'),
(26, NULL, 'CASE-2025009', 'Okiya Omtata Vs Genz', '2025-04-14', NULL, 'Des', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 10:07:51', '2025-04-14 10:07:51'),
(27, NULL, 'CASE-2025001232', 'Okiya Omtata Vs Genz', '2025-04-14', NULL, 'ded', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 10:49:16', '2025-04-14 10:49:16'),
(28, NULL, 'CASE-2025001121', 'gfgfd', '2025-04-14', NULL, 'Jaba', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 10:56:01', '2025-04-14 10:56:01'),
(29, NULL, 'CASE-202500143434', 'gfgfd', '2025-04-14', NULL, 'fgrg', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 10:57:42', '2025-04-14 10:57:42'),
(30, NULL, 'CASE-2025001434', 'weewe1', '2025-04-14', NULL, 'Ha', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-14 11:00:59', '2025-04-14 11:00:59'),
(31, NULL, 'CASE-20250010223', 'Let see', '2025-04-16', NULL, 'Heelo', 'Under Review', 'Academic', 'Under Review', 1, '2025-04-16 04:58:46', '2025-04-16 04:58:46'),
(32, NULL, 'CASE-20250011112', 'Okiya Omtata Vs Genz', '2025-04-16', NULL, 'Required', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-16 05:02:06', '2025-04-16 05:02:06'),
(33, NULL, 'CASE-202500110', 'Okiya Omtata Vs Genz', '2025-04-26', NULL, 'Provide Details, my son.', 'Waiting for Panel Evaluation', 'Academic', 'Under Review', 1, '2025-04-16 05:12:12', '2025-04-16 05:12:12'),
(34, NULL, 'CASE-202500133', 'Okiya Omtata Vs Genz', '2025-04-16', NULL, 'Story', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-16 05:18:53', '2025-04-16 05:18:53'),
(35, NULL, 'CASE-2025001545', 'Okiya Omtata Vs Genz5', '2025-04-16', NULL, 'Jaba', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-16 05:26:20', '2025-04-16 05:26:20'),
(36, NULL, 'CASE-2026001', 'Okiya Omtata Vs Genz', '2025-04-16', NULL, 'Requies', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-16 06:31:50', '2025-04-16 06:31:50'),
(37, NULL, 'CASE-20250018898', 'Okiya Omtata Vs Genz', '2025-04-19', NULL, 'Papa', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-16 06:33:45', '2025-04-16 06:33:45'),
(38, '12', 'CASE-20250013234', 'Okiya Omtata Vs Genz', '2025-04-16', '17:25:00', 'Serious case', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-16 11:20:08', '2025-04-16 11:20:08'),
(39, '123', 'CASE-2025001223', 'KU Vs Onyango', '2025-04-17', '11:09:00', 'Onyango is complaining about low salary.', 'Under Review', 'Academic', 'Under Review', 1, '2025-04-17 05:04:54', '2025-04-17 05:04:54'),
(40, '1237', 'CASE-20250012237', 'KU Vs Onyango', '2025-04-17', '11:09:00', 'Onyango is complaining about low salary.', 'Under Review', 'Academic', 'Under Review', 1, '2025-04-17 05:07:01', '2025-04-17 05:07:01'),
(41, '123743', 'CASE-202500123fdgfd', 'KU Vs Onyango', '2025-04-17', '11:28:00', 'Onyango is complaining about being fired', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-17 05:24:06', '2025-04-17 05:24:06'),
(42, 'rtretre', 'CASE-2025001rtret', 'retr', '2025-04-17', '11:31:00', 'retret', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-17 05:25:49', '2025-04-17 05:25:49'),
(43, 'rtretreer', '121212rewr', 'Okiya Omtata Vs Genz', '2025-04-17', '11:37:00', 'rerew', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-17 05:32:18', '2025-04-17 05:32:18'),
(44, 'treter232', 'CASE-2025001retre', '323221312', '2025-04-17', '11:40:00', '3213213', 'Waiting for First Hearing', 'Academic', 'Under Review', 1, '2025-04-17 05:35:24', '2025-04-17 05:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `case_activities`
--

CREATE TABLE IF NOT EXISTS `case_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `type` enum('mention','application','hearing') NOT NULL,
  `sequence_number` int(11) NOT NULL,
  `court_room_number` varchar(100) NOT NULL,
  `court_name` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `hearing_type` enum('virtual','physical') NOT NULL,
  `virtual_link` varchar(512) DEFAULT NULL,
  `court_contacts` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_case_type_sequence` (`case_id`,`type`,`sequence_number`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_activities`
--

INSERT INTO `case_activities` (`id`, `case_id`, `type`, `sequence_number`, `court_room_number`, `court_name`, `time`, `date`, `hearing_type`, `virtual_link`, `court_contacts`, `created_at`, `updated_at`) VALUES
(1, 19, 'hearing', 1, '445', 'Appeal Court', '11:01:00', '2025-04-08', 'physical', NULL, 'Nyama Choma', '2025-04-07 09:06:53', '2025-04-08 09:27:50'),
(3, 19, 'mention', 1, '446', 'Appeal Court', '11:01:00', '2025-04-07', 'virtual', NULL, 'I am hiring.', '2025-04-07 09:47:19', '2025-04-08 09:57:19'),
(4, 19, 'application', 1, '445', 'Appeal Court', '16:08:00', '2025-04-26', 'virtual', NULL, NULL, '2025-04-07 10:05:27', '2025-04-07 10:05:27'),
(5, 3, 'hearing', 1, '44643', 'Appeal Court', '10:23:00', '2025-04-18', 'physical', NULL, '0746282760', '2025-04-10 04:22:49', '2025-04-10 04:22:49'),
(6, 3, 'mention', 1, '44643', 'Appeal Court', '10:30:00', '2025-04-10', 'virtual', NULL, NULL, '2025-04-10 04:26:53', '2025-04-10 04:26:53'),
(7, 3, 'hearing', 2, '445', 'Appeal Court', '14:29:00', '2025-04-11', 'virtual', NULL, NULL, '2025-04-11 08:29:30', '2025-04-11 08:29:30'),
(8, 3, 'mention', 2, '44643', 'Appeal Court', '17:39:00', '2025-04-11', 'virtual', NULL, NULL, '2025-04-11 08:30:13', '2025-04-11 09:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `case_documents`
--

CREATE TABLE IF NOT EXISTS `case_documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) NOT NULL,
  `document_uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `document_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `case_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`document_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_documents`
--

INSERT INTO `case_documents` (`document_id`, `document_name`, `document_uploaded_at`, `document_updated_at`, `case_id`, `created_at`, `updated_at`) VALUES
(1, '1740748293_11.6.6-lab---calculate-ipv4-subnets.pdf', '2025-02-28 13:11:33', '2025-02-28 13:11:33', 13, '2025-02-28 10:11:33', '2025-02-28 10:11:33'),
(2, '1740749376_11.7.5-packet-tracer---subnetting-scenario.pdf', '2025-02-28 13:29:36', '2025-02-28 13:29:36', 14, '2025-02-28 10:29:36', '2025-02-28 10:29:36'),
(3, '1740749377_11.6.6-lab---calculate-ipv4-subnets.docx', '2025-02-28 13:29:37', '2025-02-28 13:29:37', 14, '2025-02-28 10:29:37', '2025-02-28 10:29:37'),
(4, '1740749377_2024gra-letter-of-offer-9m.docx', '2025-02-28 13:29:37', '2025-02-28 13:29:37', 14, '2025-02-28 10:29:37', '2025-02-28 10:29:37'),
(5, '1740991533_TCG SCOPE OF WORK.docx', '2025-03-03 08:45:34', '2025-03-03 08:45:34', 15, '2025-03-03 05:45:34', '2025-03-03 05:45:34'),
(7, '1740991534_11.6.6-lab---calculate-ipv4-subnets.pdf', '2025-03-03 08:45:34', '2025-03-03 08:45:34', 15, '2025-03-03 05:45:34', '2025-03-03 05:45:34'),
(9, '1741080980_Drawing1 (23).pdf', '2025-03-04 09:36:21', '2025-03-04 09:36:21', NULL, '2025-03-04 06:36:21', '2025-03-04 06:36:21'),
(13, '1741092198_Drawing1 (19).pdf', '2025-03-04 12:43:18', '2025-03-04 12:43:18', 16, '2025-03-04 09:43:18', '2025-03-04 09:43:18'),
(16, '1741248030_Drawing 4 (1).pdf', '2025-03-06 08:00:31', '2025-03-06 08:00:31', 8, '2025-03-06 05:00:31', '2025-03-06 05:00:31'),
(18, '1741248464_Drawing 4.pdf', '2025-03-06 08:07:45', '2025-03-06 08:07:45', 8, '2025-03-06 05:07:44', '2025-03-06 05:07:44'),
(20, '1741250225_Drawing1 (23).pdf', '2025-03-06 08:37:05', '2025-03-06 08:37:05', 8, '2025-03-06 05:37:05', '2025-03-06 05:37:05'),
(21, '1741600404_Drawing 3 (3).pdf', '2025-03-10 09:53:26', '2025-03-10 09:53:26', NULL, '2025-03-10 06:53:26', '2025-03-10 06:53:26'),
(22, '1741601697_Drawing 5 (4).pdf', '2025-03-10 10:14:57', '2025-03-10 10:14:57', NULL, '2025-03-10 07:14:57', '2025-03-10 07:14:57'),
(23, '1742287274_Drawing 3 (3).pdf', '2025-03-18 08:41:14', '2025-03-18 08:41:14', 19, '2025-03-18 05:41:14', '2025-03-18 05:41:14'),
(24, '1744877094_application-new-i-20 (2).pdf', '2025-04-17 08:04:55', '2025-04-17 08:04:55', NULL, '2025-04-17 05:04:55', '2025-04-17 05:04:55'),
(25, '1744877135_CardStatement_A4_Landscape36827225_04APR2025_11261314.pdf', '2025-04-17 08:05:35', '2025-04-17 08:05:35', 39, '2025-04-17 05:05:35', '2025-04-17 05:05:35'),
(26, '1744877221_application-new-i-20 (2).pdf', '2025-04-17 08:07:01', '2025-04-17 08:07:01', NULL, '2025-04-17 05:07:01', '2025-04-17 05:07:01'),
(27, '1744877626_ELC_NO._37_OF_2020_RLNG.docx', '2025-04-17 08:13:47', '2025-04-17 08:13:47', 39, '2025-04-17 05:13:47', '2025-04-17 05:13:47'),
(28, '1744878246_AI----Report (2) (2).pdf', '2025-04-17 08:24:06', '2025-04-17 08:24:06', NULL, '2025-04-17 05:24:06', '2025-04-17 05:24:06'),
(29, '1744878350_Data Science Research Report_1 2.docx', '2025-04-17 08:25:50', '2025-04-17 08:25:50', NULL, '2025-04-17 05:25:50', '2025-04-17 05:25:50'),
(30, '1744878562_ELC_NO._37_OF_2020_RLNG.docx', '2025-04-17 08:29:22', '2025-04-17 08:29:22', 40, '2025-04-17 05:29:22', '2025-04-17 05:29:22'),
(31, '1744878600_Document.docx', '2025-04-17 08:30:00', '2025-04-17 08:30:00', 42, '2025-04-17 05:30:00', '2025-04-17 05:30:00'),
(32, '1744878630_application-new-i-20 (2) (1).pdf', '2025-04-17 08:30:30', '2025-04-17 08:30:30', 41, '2025-04-17 05:30:30', '2025-04-17 05:30:30'),
(33, '1744878738_Document (1).docx', '2025-04-17 08:32:18', '2025-04-17 08:32:18', NULL, '2025-04-17 05:32:18', '2025-04-17 05:32:18'),
(34, '1744878924_application-new-i-20 (2) (1).pdf', '2025-04-17 08:35:24', '2025-04-17 08:35:24', 44, '2025-04-17 05:35:24', '2025-04-17 05:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `case_lawyer`
--

CREATE TABLE IF NOT EXISTS `case_lawyer` (
  `assigned_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`assigned_id`),
  KEY `case_assignd_fk` (`case_id`),
  KEY `lawyer_assigned_fk` (`lawyer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_lawyer`
--

INSERT INTO `case_lawyer` (`assigned_id`, `case_id`, `lawyer_id`, `created_at`, `updated_at`) VALUES
(5, 19, 5, '2025-04-03', '2025-04-03'),
(9, 39, 5, '2025-04-17', '2025-04-17'),
(10, 39, 2, '2025-04-17', '2025-04-17');

-- --------------------------------------------------------

--
-- Table structure for table `complainants`
--

CREATE TABLE IF NOT EXISTS `complainants` (
  `Complainant_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  `complainant_name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`Complainant_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complainants`
--

INSERT INTO `complainants` (`Complainant_id`, `case_id`, `complainant_name`, `phone`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 8, 'Musa', '0746282760', 'isaiah132@gmail.com', 'wweewe', '2025-02-28 09:16:03', '2025-03-06 04:18:46'),
(2, 9, 'John', '0746282760', 'isaiah132@gmail.com', 'wweewe', '2025-02-28 09:26:13', '2025-02-28 09:26:13'),
(3, 10, 'John', '0746282760', 'isaiah132@gmail.com', 'wweewe', '2025-02-28 09:36:23', '2025-02-28 09:36:23'),
(4, 11, 'John', '0746282760', 'isaiah132@gmail.com', 'wweewe', '2025-02-28 09:40:09', '2025-02-28 09:40:09'),
(5, 12, 'John', '0746282760', 'isaiah@gmail.com', 'wweewe', '2025-02-28 10:07:09', '2025-02-28 10:07:09'),
(6, 13, 'John', '07462827601', 'isaiah1@gmail.com', 'wweewe', '2025-02-28 10:11:33', '2025-02-28 10:11:33'),
(7, 14, 'John', '7462827602', 'isaiah132@gmail.com', 'wweewe', '2025-02-28 10:29:36', '2025-02-28 10:29:36'),
(8, 15, 'John', '0746282760', '111@gmail.com', 'wweewe', '2025-03-03 05:45:33', '2025-03-03 05:45:33'),
(9, 16, 'Musa Omua', '7462827601', 'intern-ict@ku.ac.ke', '111343', '2025-03-03 06:19:07', '2025-03-05 10:23:30'),
(10, NULL, 'Musa', '0746282760', 'intern-ict@ku.ac.ke', 'wweewe', '2025-03-04 06:36:20', '2025-03-04 06:36:20'),
(11, NULL, 'Musa Omua', '7462827602', 'intern-ict@ku.ac.ke', '111343', '2025-03-10 06:53:24', '2025-03-10 06:53:24'),
(12, 19, 'John', '7462827602', '111@gmail.com', '1111', '2025-03-10 07:14:57', '2025-03-10 07:14:57'),
(13, 20, 'Joshua', '7462827602', 'omulodeveloper@gmail.com', '121212', '2025-04-14 09:45:30', '2025-04-14 09:45:30'),
(14, 21, 'Joshua', NULL, 'joshua@gmail.com', NULL, '2025-04-14 09:48:50', '2025-04-14 09:48:50'),
(15, 22, 'John', '0746282760', 'isaiah132@gmail.com', 'wweewe', '2025-04-14 09:52:05', '2025-04-14 09:52:05'),
(16, 23, 'John', '0746282760', 'admin@gmail.com', 'wweewe', '2025-04-14 09:54:04', '2025-04-14 09:54:04'),
(17, 24, 'Joshua', '0746282760', 'joshua@gmail.com', '1112', '2025-04-14 09:59:51', '2025-04-14 09:59:51'),
(18, 25, 'John', '0746282760', 'caroline@gmail.com', 'wweewe', '2025-04-14 10:05:00', '2025-04-14 10:05:00'),
(19, 26, 'John', '0746282760', 'intern-ict@ku.ac.ke', '1111', '2025-04-14 10:07:51', '2025-04-14 10:07:51'),
(20, 27, 'Joshua', NULL, NULL, NULL, '2025-04-14 10:49:16', '2025-04-14 10:49:16'),
(21, 28, 'Joshua', '0746282760', 'isaiah132@gmail.com', NULL, '2025-04-14 10:56:01', '2025-04-14 10:56:01'),
(22, 29, 'John', '0746282760', 'isaiah132@gmail.com', 'wweewe', '2025-04-14 10:57:42', '2025-04-14 10:57:42'),
(23, 30, 'Joshua', '0746282760', 'intern-ict@ku.ac.ke', '1112', '2025-04-14 11:00:59', '2025-04-14 11:00:59'),
(24, 31, 'Joshua', '0746282760', 'intern-ict@ku.ac.ke', '1112', '2025-04-16 04:58:47', '2025-04-16 04:58:47'),
(25, 32, 'hhtry', '2344365', 'admin@gmail.com', '121212', '2025-04-16 05:02:06', '2025-04-16 05:02:06'),
(26, 33, 'John', '7462827602', 'intern-ict@ku.ac.ke', '11123', '2025-04-16 05:12:12', '2025-04-16 05:12:12'),
(27, 34, 'John', '0746282760', 'isaiah132@gmail.com', '11123', '2025-04-16 05:18:53', '2025-04-16 05:18:53'),
(28, 35, 'Joshua', '2344365', 'intern-ict@ku.ac.ke', '111343', '2025-04-16 05:26:20', '2025-04-16 05:26:20'),
(29, 36, 'Musa Omua', '2344365', 'intern-ict@ku.ac.ke', '11123', '2025-04-16 06:31:56', '2025-04-16 06:31:56'),
(30, 37, 'Musa Omua', '7462827602', 'omulodeveloper@gmail.com', 'nm', '2025-04-16 06:33:45', '2025-04-16 06:33:45'),
(31, 38, 'Joshua', '0746282760', 'intern-ict@ku.ac.ke', '11123', '2025-04-16 11:20:08', '2025-04-16 11:20:08'),
(32, 39, 'Onyango', '0746282760', 'onyango@gmail.com', 'P.O BOX 38-40611', '2025-04-17 05:04:54', '2025-04-17 05:04:54'),
(33, 40, 'Onyango', '0746282760', 'onyango@gmail.com', 'P.O BOX 38-40611', '2025-04-17 05:07:01', '2025-04-17 05:07:01'),
(34, 41, 'Onyango Ramoko', '2344365', 'ramoko@gmail.com', 'P.O BOX 38-40611', '2025-04-17 05:24:06', '2025-04-17 05:24:06'),
(35, 42, 'trtret', 'rtretr', 'rtertre@gmail.com', 'trret', '2025-04-17 05:25:49', '2025-04-17 05:25:49'),
(36, 43, 'Joshua', '7462827602', 'intern-ict@ku.ac.ke', '111343', '2025-04-17 05:32:18', '2025-04-17 05:32:18'),
(37, 44, 'Joshua', '213213', '32123@gmail.com', '321321', '2025-04-17 05:35:24', '2025-04-17 05:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `documents_filing`
--

CREATE TABLE IF NOT EXISTS `documents_filing` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) NOT NULL,
  `document_type` enum('Defense','Claim') NOT NULL,
  `mention_date` date DEFAULT NULL,
  `hearing_date` date DEFAULT NULL,
  `filing_date` date DEFAULT NULL,
  `document_uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `document_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `case_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE IF NOT EXISTS `evaluations` (
  `evaluation_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) DEFAULT NULL,
  `lawyer_id` int(11) DEFAULT NULL,
  `evaluation_date` date NOT NULL,
  `evaluation_time` time NOT NULL,
  `comments` text DEFAULT NULL,
  `quote` varchar(200) DEFAULT NULL,
  `pager` varchar(200) DEFAULT NULL,
  `outcome` enum('Yes','No') NOT NULL,
  `worked_before` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`evaluation_id`),
  KEY `case_id` (`case_id`),
  KEY `evaluations_ibfk_2` (`lawyer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluations`
--

INSERT INTO `evaluations` (`evaluation_id`, `case_id`, `lawyer_id`, `evaluation_date`, `evaluation_time`, `comments`, `quote`, `pager`, `outcome`, `worked_before`, `created_at`, `updated_at`) VALUES
(2, 3, NULL, '2025-03-22', '00:00:00', '✅ Pre-filled form for editing evaluations\r\n✅ Styled properly using Color Admin\r\n✅ Uses Laravel validation to prevent bad inputs\r\n✅ Includes back button for better UX\r\n\r\nLet me know if you need further tweaks', NULL, 'Update', 'No', 'Yes', '2025-03-13 10:57:59', '2025-03-18 03:30:04'),
(3, 19, 5, '2025-04-03', '00:00:00', NULL, '5000', NULL, 'Yes', 'Yes', '2025-04-03 04:39:14', '2025-04-10 06:32:40'),
(7, 19, 1, '2025-05-10', '14:27:00', 'I am winning this case. Please assign. Do it faster.', '20', 'First add', 'Yes', 'Yes', '2025-04-23 08:21:35', '2025-04-23 08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_ag_advice`
--

CREATE TABLE IF NOT EXISTS `evaluation_ag_advice` (
  `ag_advice_id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) DEFAULT NULL,
  `advice_date` date NOT NULL,
  `advice_time` time NOT NULL,
  `ag_advice` text DEFAULT NULL,
  `case_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ag_advice_id`),
  KEY `evaluation_id` (`evaluation_id`),
  KEY `case_ag_fk` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation_ag_advice`
--

INSERT INTO `evaluation_ag_advice` (`ag_advice_id`, `evaluation_id`, `advice_date`, `advice_time`, `ag_advice`, `case_id`, `created_at`, `updated_at`) VALUES
(1, NULL, '2036-12-22', '00:00:00', 'Hello. Jaber', 3, '2025-03-27 11:19:24', '2025-03-27 12:18:40'),
(2, NULL, '2025-03-27', '00:00:00', 'Hello Jakom', 3, '2025-03-27 11:21:02', '2025-03-27 11:21:02'),
(3, NULL, '2025-05-10', '18:38:00', 'Get other lawyers who can handle the case successfully.', 2, '2025-04-23 09:33:08', '2025-04-23 09:33:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `uuid` char(36) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forwardings`
--

CREATE TABLE IF NOT EXISTS `forwardings` (
  `forwarding_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `lawyer_id` int(11) DEFAULT NULL,
  `dvc_appointment_date` date DEFAULT NULL,
  `briefing_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dvc_appointment_time` time DEFAULT NULL,
  PRIMARY KEY (`forwarding_id`),
  KEY `case_id` (`case_id`),
  KEY `lawyer_id` (`lawyer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forwardings`
--

INSERT INTO `forwardings` (`forwarding_id`, `case_id`, `lawyer_id`, `dvc_appointment_date`, `briefing_notes`, `created_at`, `updated_at`, `dvc_appointment_time`) VALUES
(1, 3, NULL, '2025-04-22', 'Hello. Yn', '2025-04-22 10:30:02', '2025-04-22 11:18:13', '16:35:00'),
(2, 3, NULL, '2025-04-22', 'Hello', '2025-04-22 10:37:50', '2025-04-22 10:37:50', '16:43:00'),
(3, 3, NULL, '2025-04-22', 'Hello. Updated', '2025-04-22 10:44:01', '2025-04-22 11:19:08', '16:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `fsd`
--

CREATE TABLE IF NOT EXISTS `fsd` (
  `id` int(11) NOT NULL,
  `case_number` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lawyers`
--

CREATE TABLE IF NOT EXISTS `lawyers` (
  `lawyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `license_number` varchar(50) NOT NULL,
  `area_of_expertise` varchar(255) DEFAULT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `years_experience` int(11) DEFAULT NULL,
  `working_hours` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`lawyer_id`),
  UNIQUE KEY `license_number` (`license_number`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lawyers`
--

INSERT INTO `lawyers` (`lawyer_id`, `user_id`, `license_number`, `area_of_expertise`, `firm_name`, `years_experience`, `working_hours`, `created_at`, `updated_at`) VALUES
(2, 2, 'LN1234568', 'Criminal Law', 'Example Law Firm', 2, '10 AM - 8 PM', '2025-03-17 04:36:27', '2025-03-17 05:21:00'),
(3, 3, 'LN1234569', 'Criminal Law', 'Aram Law Firm', 2, '9 AM - 5 PM', '2025-03-17 05:18:30', '2025-03-17 05:20:52'),
(4, 4, 'LN12345', 'Criminal Law', 'Mambo Law Firm', 2, '10 AM - 8 PM', '2025-03-17 05:20:40', '2025-03-17 05:20:40'),
(5, 5, 'LN12345610', 'Criminal Law', 'Jumbo', 101, '9 AM - 10 PM', '2025-04-01 08:41:31', '2025-04-04 04:03:09');

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_payments`
--

CREATE TABLE IF NOT EXISTS `lawyer_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `lawyer_id` int(11) NOT NULL,
  `transaction` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_time` time NOT NULL,
  `lawyer_payment_status` enum('Pending','Completed') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`payment_id`),
  KEY `lawyer_id` (`lawyer_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lawyer_payments`
--

INSERT INTO `lawyer_payments` (`payment_id`, `case_id`, `amount_paid`, `payment_method`, `lawyer_id`, `transaction`, `payment_date`, `payment_time`, `lawyer_payment_status`, `created_at`, `updated_at`) VALUES
(1, 3, 6000.00, 'Bank Transfer', 2, 'Updated. Time changed', '2025-03-25', '23:56:00', 'Pending', '2025-03-25 09:04:39', '2025-04-23 09:08:00'),
(2, 3, 5000.00, 'Credit Card', 2, NULL, '2025-03-12', '00:00:00', 'Completed', '2025-03-25 09:06:10', '2025-03-25 09:06:10'),
(3, 3, 7000.00, 'Credit Card', 3, NULL, '2025-03-25', '00:00:00', 'Completed', '2025-03-25 09:22:36', '2025-03-25 09:22:36'),
(5, 3, 40.00, 'Cash', 2, NULL, '2025-03-29', '00:00:00', 'Pending', '2025-03-26 08:50:07', '2025-03-26 08:50:07'),
(7, 3, 40.00, 'Bank Transfer', 3, NULL, '2025-03-28', '00:00:00', 'Pending', '2025-03-26 08:55:23', '2025-03-26 08:55:23'),
(8, 3, 6000.00, 'Cash', 2, NULL, '2025-04-03', '00:00:00', 'Pending', '2025-04-03 06:31:50', '2025-04-03 06:31:50'),
(9, 3, 60.00, 'Mpesa', 5, 'Jaba', '2025-04-26', '00:00:00', 'Pending', '2025-04-03 06:41:50', '2025-04-03 06:50:25'),
(10, 3, 23.00, 'Cash', 3, NULL, '2025-04-23', '15:09:00', 'Pending', '2025-04-23 09:03:21', '2025-04-23 09:03:21');

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_payment_attachments`
--

CREATE TABLE IF NOT EXISTS `lawyer_payment_attachments` (
  `attachment_id` int(20) NOT NULL AUTO_INCREMENT,
  `lawyer_payment_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `lawyer_payment_id` (`lawyer_payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lawyer_payment_attachments`
--

INSERT INTO `lawyer_payment_attachments` (`attachment_id`, `lawyer_payment_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(1, 7, 'AIReport.pdf', 'storage/lawyer_payment_attachments/MfEs0IRiYwsa8Go2E7cdHC09quWgv6r4zdAkZpAt.pdf', 'pdf', '2025-03-26 08:55:23', '2025-03-26 08:55:23', '2025-03-26 08:55:23'),
(3, 1, 'Document (1).docx', 'lawyer_payment_attachments/55sGjMyvBffjmph9XTCjl1AVNBWb5wT5M9ncpCZe.docx', 'docx', '2025-03-26 09:10:22', '2025-03-26 09:10:22', '2025-03-26 09:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_04_14_134239_create_jobs_table', 1),
(2, '2025_04_16_083321_create_failed_jobs_table', 2),
(3, '2025_04_16_091700_create_failed_jobs_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `negotiations`
--

CREATE TABLE IF NOT EXISTS `negotiations` (
  `negotiation_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `negotiator_id` int(11) DEFAULT NULL,
  `negotiation_method` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `initiation_datetime` datetime NOT NULL,
  `follow_up_date` date DEFAULT NULL,
  `follow_up_actions` text DEFAULT NULL,
  `final_resolution_date` datetime DEFAULT NULL,
  `additional_comments` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `outcome` enum('Resolved','Pending','Requires Further Action','Closed','Declined') DEFAULT NULL,
  `complainant_response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`negotiation_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negotiations`
--

INSERT INTO `negotiations` (`negotiation_id`, `case_id`, `negotiator_id`, `negotiation_method`, `subject`, `initiation_datetime`, `follow_up_date`, `follow_up_actions`, `final_resolution_date`, `additional_comments`, `notes`, `outcome`, `complainant_response`, `created_at`, `updated_at`) VALUES
(1, 17, 1, 'Email', 'Relax', '2025-03-07 13:19:00', '0001-11-11', NULL, '2025-03-08 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 07:18:01', '2025-03-07 07:18:01'),
(2, 17, 1, 'Email', 'Relax', '2025-03-07 13:41:00', '2025-03-21', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 07:40:28', '2025-03-07 07:40:28'),
(3, 17, 1, 'Email', 'Relax', '2025-03-07 13:44:00', '2025-03-29', NULL, '2025-03-20 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 07:42:05', '2025-03-07 07:42:05'),
(4, 16, 1, 'Email', 'Case 16', '2025-03-07 14:17:00', '2025-03-22', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 08:13:55', '2025-03-07 08:13:55'),
(5, 16, 1, 'Email', 'Jaba', '2025-03-07 14:20:00', '2025-03-29', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 08:16:13', '2025-03-07 08:16:13'),
(6, 16, 1, 'Phone', 'Relax', '2025-03-07 14:36:00', '2025-03-29', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 08:31:48', '2025-03-07 08:31:48'),
(7, 17, 1, 'Email', 'Case 17', '2025-03-07 14:58:00', '2025-04-05', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 08:53:59', '2025-03-07 08:53:59'),
(8, 17, 1, 'Email', 'Relax', '2025-03-07 14:04:00', '2025-03-29', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 08:59:43', '2025-03-07 08:59:43'),
(9, 17, 1, 'Email', 'Relax', '2025-03-07 15:11:00', '2025-03-29', NULL, '2025-03-12 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 09:06:58', '2025-03-07 09:06:58'),
(10, 17, 1, 'Email', 'Relax', '2025-03-07 15:14:00', '2025-03-29', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 09:09:39', '2025-03-07 09:09:39'),
(11, 17, 1, 'Email', 'Case 16', '2025-03-07 15:23:00', '2025-03-29', NULL, '2025-03-22 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 09:17:27', '2025-03-07 09:17:27'),
(12, 17, 1, 'Email', 'Relax', '2025-03-07 15:40:00', '1111-11-11', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 09:34:14', '2025-03-07 09:34:14'),
(13, 17, 1, 'Email', 'Case 16', '2025-03-07 15:55:00', '2025-03-29', 'I love God', '2025-03-29 00:00:00', 'I love God', 'I love God', NULL, 'I love God', '2025-03-07 09:50:17', '2025-03-10 06:40:03'),
(14, 17, 1, 'Phone', 'Relax', '2025-03-07 15:03:00', '2025-03-29', NULL, '2025-03-29 00:00:00', NULL, NULL, NULL, NULL, '2025-03-07 09:57:53', '2025-03-07 09:57:53'),
(15, 17, 1, 'Email', 'Case 16', '2025-03-07 15:04:00', '2025-03-29', NULL, '2025-03-29 00:00:00', NULL, NULL, 'Pending', NULL, '2025-03-07 09:59:25', '2025-03-25 03:17:49'),
(16, 12, 1, 'Phone', 'Relax', '2025-03-07 16:42:00', '2025-03-29', 'I love God', '2025-03-29 00:00:00', 'I love God', 'I love God', 'Resolved', 'I love God', '2025-03-07 10:37:03', '2025-03-11 06:36:50'),
(17, 3, 1, 'Phone', 'Case 16', '2025-03-28 09:17:00', '2025-03-29', 'Thank you Jesus', '2025-03-29 00:00:00', 'I love God. Thanks', 'I love God', 'Resolved', 'I love God', '2025-03-11 03:05:27', '2025-04-23 09:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `negotiation_attachments`
--

CREATE TABLE IF NOT EXISTS `negotiation_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `negotiation_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `negotiation_id` (`negotiation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negotiation_attachments`
--

INSERT INTO `negotiation_attachments` (`attachment_id`, `negotiation_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `updated_at`, `created_at`) VALUES
(1, 11, 'Drawing 3 (4).pdf', 'negotiation_attachments/nnUmYtoxRv6OHwv8QCeKovBXujmVV4lMhqLbWECK.pdf', 'application/pdf', '2025-03-07 15:20:56', '2025-03-07 09:20:56', '2025-03-07 09:20:56'),
(2, 12, 'Drawing 3 (2).pdf', 'negotiation_attachments/w5RpEiEeRIXWAIOvam36NSU5c5HnVbJcb5vUaHdY.pdf', 'application/pdf', '2025-03-07 15:34:41', '2025-03-07 09:34:41', '2025-03-07 09:34:41'),
(3, 13, 'Drawing 3 (2).pdf', 'negotiation_attachments/pIzxVuu2xTFIQhLlXlyVUg9fDX7LN760FAo8nKBH.pdf', 'application/pdf', '2025-03-07 15:50:41', '2025-03-07 09:50:41', '2025-03-07 09:50:41'),
(4, 13, 'Drawing 5 (3).pdf', 'negotiation_attachments/fkr6NH56A05DpnZWu6W99Qa2LdfaVZcXTL8NZJCk.pdf', 'application/pdf', '2025-03-10 12:06:40', '2025-03-10 06:06:39', '2025-03-10 06:06:39'),
(5, 17, 'Drawing 4 (1).pdf', 'negotiation_attachments/hKNvysl0JJ8UCvfTKuZIuuDze57BeBqw8iW9zcut.pdf', 'application/pdf', '2025-03-11 09:06:40', '2025-03-11 03:06:40', '2025-03-11 03:06:40'),
(6, 17, 'Drawing 5 (1).pdf', 'negotiation_attachments/1Z7qPIdxnQiDtxP1RmjkP5ngzPOHX9OwS2PFgmGv.pdf', 'application/pdf', '2025-03-11 09:18:04', '2025-03-11 03:18:04', '2025-03-11 03:18:04'),
(7, 17, 'Drawing1 (16).pdf', 'negotiation_attachments/QcySraXVqX9tXXx0H3mHfuB8fpPRMP83gNH3DoMX.pdf', 'application/pdf', '2025-03-11 10:01:09', '2025-03-11 04:01:09', '2025-03-11 04:01:09'),
(9, 16, 'Drawing 3 (2).pdf', 'negotiation_attachments/RgHkA9LzdOZJVd7UlS8oQuaCnaPEki2Z7faHb0vf.pdf', 'application/pdf', '2025-03-11 12:35:51', '2025-03-11 06:35:48', '2025-03-11 06:35:48'),
(10, 16, 'Drawing 3 (2).pdf', 'negotiation_attachments/i5U8ZSLMqbf9cRTWK2b3aIoozQrWbXlWjL7eVsnc.pdf', 'application/pdf', '2025-03-11 12:35:59', '2025-03-11 06:35:59', '2025-03-11 06:35:59'),
(11, 16, 'Drawing 3 (2).pdf', 'negotiation_attachments/ytmFFyPuWiFCe6USUCnJ5ck8NGhj1Uhk6XQ0I0W6.pdf', 'application/pdf', '2025-03-11 12:36:00', '2025-03-11 06:36:00', '2025-03-11 06:36:00'),
(12, 17, 'Drawing 5 (1).pdf', 'negotiation_attachments/MiPrsZYNRElw1JAFkNpVesIp2Z9ix6CnHjLKUvya.pdf', 'application/pdf', '2025-03-11 12:39:20', '2025-03-11 06:39:20', '2025-03-11 06:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `panel_evaluations`
--

CREATE TABLE IF NOT EXISTS `panel_evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `evaluator_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('Cash','Bank Transfer','Credit Card','Mpesa','Other') NOT NULL,
  `transaction` text DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_time` time NOT NULL,
  `auctioneer_involvement` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`payment_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `case_id`, `amount_paid`, `payment_method`, `transaction`, `payment_date`, `payment_time`, `auctioneer_involvement`, `created_at`, `updated_at`) VALUES
(1, 3, 4000.00, 'Other', 'Good cash.  Date year changed', '1998-11-23', '05:05:00', 'No', '2025-03-25 04:34:49', '2025-04-23 09:20:38'),
(2, 3, 4.00, 'Cash', 'Testing juf', '2025-03-25', '00:00:00', 'fg', '2025-03-25 05:30:19', '2025-03-25 05:30:55'),
(3, 3, 40000.00, 'Mpesa', 'It is not far', '2025-03-25', '00:00:00', 'They took my bike.', '2025-03-25 06:02:34', '2025-03-25 06:05:07'),
(4, 3, 4000.00, 'Cash', 'Good', '2025-03-25', '00:00:00', NULL, '2025-03-25 08:25:00', '2025-03-25 08:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_attachments`
--

CREATE TABLE IF NOT EXISTS `payment_attachments` (
  `attachment_id` int(20) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_attachments`
--

INSERT INTO `payment_attachments` (`attachment_id`, `payment_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(3, 1, 'Drawing 4 (2).pdf', 'payment_attachments/u9tilrJK30h2g9jj3XzKytuuRA4pyWPFX9aizR5l.pdf', 'pdf', '2025-03-25 04:54:35', '2025-03-25 04:54:35', '2025-03-25 04:54:35'),
(4, 1, 'Document.docx', 'payment_attachments/SP6bs5D0JUKAk1bPBDqx71KphcpZgxS0YTtAoVS2.docx', 'docx', '2025-03-25 04:58:30', '2025-03-25 04:58:30', '2025-03-25 04:58:30'),
(6, 1, 'ku_logo.png', 'payment_attachments/nGERVlhCKEtq0fzmsBN6hcAMx8yD8GfmWzYprDzQ.png', 'png', '2025-03-25 04:59:38', '2025-03-25 04:59:38', '2025-03-25 04:59:38'),
(7, 2, 'report not received.pdf', 'payment_attachments/CeVsKdaLNZ6ZCxtlYbsSOtv2ia7TNaaibPpBVPrR.pdf', 'pdf', '2025-03-25 05:30:40', '2025-03-25 05:30:40', '2025-03-25 05:30:40'),
(8, 3, 'Drawing 5 (1).pdf', 'storage/payment_attachments/IWiBGlsHLW193QreoNuQK1mZo6ZQ900XtcTuabqs.pdf', 'pdf', '2025-03-25 06:02:35', '2025-03-25 06:02:35', '2025-03-25 06:02:35'),
(9, 4, 'Drawing 3.pdf', 'storage/payment_attachments/xfTu2FeYC30M7lnZrvfAPxy7vwrJ7aFdl6MxNi3U.pdf', 'pdf', '2025-03-25 08:25:03', '2025-03-25 08:25:03', '2025-03-25 08:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `securitylogs`
--

CREATE TABLE IF NOT EXISTS `securitylogs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trials`
--

CREATE TABLE IF NOT EXISTS `trials` (
  `trial_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `trial_date` date NOT NULL,
  `trial_time` time NOT NULL,
  `judgement_details` text DEFAULT NULL,
  `judgement_date` date DEFAULT NULL,
  `judgement_time` time NOT NULL,
  `outcome` enum('Win','Loss','Adjourned','Dismissed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`trial_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trials`
--

INSERT INTO `trials` (`trial_id`, `case_id`, `trial_date`, `trial_time`, `judgement_details`, `judgement_date`, `judgement_time`, `outcome`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-03-21', '00:00:00', 'Good advocating', '2025-03-21', '05:05:00', 'Win', '2025-03-21 09:03:49', '2025-04-23 06:17:38'),
(3, 3, '2025-03-22', '00:00:00', 'Postponed to Tuesday next week', '2025-03-28', '00:00:00', 'Adjourned', '2025-03-21 09:18:33', '2025-03-21 09:31:56'),
(4, 3, '2025-03-26', '00:00:00', NULL, '2025-04-26', '12:15:00', 'Loss', '2025-03-26 11:24:30', '2025-04-23 06:15:25'),
(5, 2, '2025-04-26', '12:11:00', 'Not good', '2025-05-10', '12:17:00', 'Adjourned', '2025-04-23 06:12:12', '2025-04-23 06:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `trials_attachments`
--

CREATE TABLE IF NOT EXISTS `trials_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trial_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `trial_id` (`trial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trials_attachments`
--

INSERT INTO `trials_attachments` (`attachment_id`, `trial_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(2, 3, 'ku_logo.png', 'storage/trial_attachments/NexwoMf96fcEp2QUch2RFR9kLwPPuNPfA0RuYgh2.png', 'png', '2025-03-21 09:18:34', '2025-03-21 09:18:34', '2025-03-21 09:18:34'),
(4, 1, 'Admission_Letter.pdf', 'trial_attachments/2lim73pqGUbzWua5Zp381dATDPQ4Bg6R7m51Y3NY.pdf', 'pdf', '2025-03-21 09:25:01', '2025-03-21 09:25:01', '2025-03-21 09:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparations`
--

CREATE TABLE IF NOT EXISTS `trial_preparations` (
  `preparation_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `preparation_date` date DEFAULT NULL,
  `preparation_time` time NOT NULL,
  `briefing_notes` text DEFAULT NULL,
  `preparation_status` enum('Pending','Ongoing','Completed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`preparation_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trial_preparations`
--

INSERT INTO `trial_preparations` (`preparation_id`, `case_id`, `preparation_date`, `preparation_time`, `briefing_notes`, `preparation_status`, `created_at`, `updated_at`) VALUES
(1, 3, '2025-04-05', '06:06:00', 'Time changed for this', 'Completed', '2025-03-21 06:11:18', '2025-04-23 05:45:49'),
(3, 3, '2025-05-10', '11:48:00', NULL, 'Pending', '2025-04-23 05:42:17', '2025-04-23 05:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparation_attachments`
--

CREATE TABLE IF NOT EXISTS `trial_preparation_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `preparation_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `preparation_id` (`preparation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trial_preparation_attachments`
--

INSERT INTO `trial_preparation_attachments` (`attachment_id`, `preparation_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(2, 1, 'Admission_Letter.pdf', 'trial_preparation_attachments/dmMDqlKOJYWmJOu4LlzdoHpMAxph7qgD1EHCdn6Y.pdf', 'pdf', '2025-03-21 06:51:42', '2025-03-21 06:51:42', '2025-03-21 06:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparation_lawyer`
--

CREATE TABLE IF NOT EXISTS `trial_preparation_lawyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preparation_id` int(11) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_trial_preparation_lawyer_preparation` (`preparation_id`),
  KEY `fk_trial_preparation_lawyer_lawyer` (`lawyer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparation_witness`
--

CREATE TABLE IF NOT EXISTS `trial_preparation_witness` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preparation_id` int(11) NOT NULL,
  `witness_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_trial_preparation_witness_preparation` (`preparation_id`),
  KEY `fk_trial_preparation_witness_witness` (`witness_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('Lawyer','Admin','Case Manager','Evaluator','DVC','Other') NOT NULL,
  `account_status` enum('Active','Pending','Suspended') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `full_name`, `phone`, `role`, `account_status`, `created_at`, `last_login`) VALUES
(1, 'isaiahomulo', 'isaiah132@gmail.com', '$2y$12$cZK3oL7bnlxlzdxM0c7FEODtp8rjioENh9AzEAzLSO.mjNnjT46di', 'Isaiah Omulo', '0746282760', 'Admin', 'Pending', '2025-02-26 06:18:39', '2025-02-26 06:18:39'),
(2, 'isaiahomulo602', 'intern-ict@ku.ac.ke\r\n', '$2y$12$DAHQtUIdnN7vXlOt2jwAUelUEntKyYL98sDFuDmHINEwdEgI3QUci', 'Isaiah Omulo', '7462827602', 'Lawyer', 'Pending', '2025-03-17 07:36:27', '2025-03-17 07:36:27'),
(3, 'jamesowino444', 'omulodeveloper@gmail.com', '$2y$12$WAzExmBHtYstMoJ80YzSKO2MmMHqJkuW7v49nxkqzo3vpFUAg2waC', 'James Owino', '0702111444', 'Admin', 'Pending', '2025-03-17 08:18:30', '2025-03-17 08:18:30'),
(4, 'jamesomolo760', 'james@gmail.com', '$2y$12$bpwdU4xvL5Wy5utbyjRN0eBgZfyPd402Hmnh4B1mAHikmo1CQCFgK', 'James Omolo', '0742282760', 'Lawyer', 'Pending', '2025-03-17 08:20:40', '2025-03-17 08:20:40'),
(5, 'carolinemuthoni766', 'caroline@gmail.com', '$2y$12$mD5PafevnOwJaK0pcuQTtOB5Gb.pp7BosRjL5yi6YUf0Ex1Raz8IO', 'Caroline Muthoni', '0746282766', 'Lawyer', 'Pending', '2025-04-01 11:41:31', '2025-04-01 11:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `witnesses`
--

CREATE TABLE IF NOT EXISTS `witnesses` (
  `witness_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `witness_name` varchar(255) NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `availability` enum('Yes','No') NOT NULL,
  `witness_statement` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`witness_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `witnesses`
--

INSERT INTO `witnesses` (`witness_id`, `case_id`, `witness_name`, `phone`, `email`, `availability`, `witness_statement`, `created_at`, `updated_at`) VALUES
(1, 3, 'Onyango', '2344365', 'onyango@gmail.com', 'Yes', 'I saw him cooking poisonous food. Updated', '2025-03-20 09:36:09', '2025-03-20 10:22:57'),
(2, 3, 'Onyango', '2344365', NULL, 'No', NULL, '2025-04-10 06:31:52', '2025-04-10 06:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `witnesses_attachments`
--

CREATE TABLE IF NOT EXISTS `witnesses_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `witness_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `fk_witness_attachment` (`witness_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `witnesses_attachments`
--

INSERT INTO `witnesses_attachments` (`attachment_id`, `witness_id`, `file_name`, `file_path`, `file_type`, `upload_date`, `created_at`, `updated_at`) VALUES
(2, 1, 'Drawing 3 (1).pdf', 'witness_attachments/J6l6QvlqnWOvL2txdhtJsCkdgvbFdILkKuWderOW.pdf', 'pdf', '2025-03-20 09:59:04', '2025-03-20 09:59:04', '2025-03-20 09:59:04'),
(5, 1, 'Drawing 4 (2).pdf', 'witness_attachments/tQrgXrtUDavPmPHp3Y6H6UBfklsDDenSUl3W9SWo.pdf', 'pdf', '2025-03-20 10:00:09', '2025-03-20 10:00:09', '2025-03-20 10:00:09');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adjourns`
--
ALTER TABLE `adjourns`
  ADD CONSTRAINT `adjourns_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `adjourn_attachments`
--
ALTER TABLE `adjourn_attachments`
  ADD CONSTRAINT `adjourn_attachments_ibfk_1` FOREIGN KEY (`adjourns_id`) REFERENCES `adjourns` (`adjourns_id`) ON DELETE CASCADE;

--
-- Constraints for table `appeal`
--
ALTER TABLE `appeal`
  ADD CONSTRAINT `appeal_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `appeal_attachments`
--
ALTER TABLE `appeal_attachments`
  ADD CONSTRAINT `fk_appeal_attachments_appeal` FOREIGN KEY (`appeal_id`) REFERENCES `appeal` (`appeal_id`) ON DELETE CASCADE;

--
-- Constraints for table `caseclosures`
--
ALTER TABLE `caseclosures`
  ADD CONSTRAINT `caseclosures_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `caseclosure_attachments`
--
ALTER TABLE `caseclosure_attachments`
  ADD CONSTRAINT `fk_caseclosure_attachments` FOREIGN KEY (`caseclosure_id`) REFERENCES `caseclosures` (`closure_id`) ON DELETE CASCADE;

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `case_activities`
--
ALTER TABLE `case_activities`
  ADD CONSTRAINT `fk_case_activities_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `case_documents`
--
ALTER TABLE `case_documents`
  ADD CONSTRAINT `case_documents_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE SET NULL;

--
-- Constraints for table `case_lawyer`
--
ALTER TABLE `case_lawyer`
  ADD CONSTRAINT `case_assignd_fk` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lawyer_assigned_fk` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`lawyer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complainants`
--
ALTER TABLE `complainants`
  ADD CONSTRAINT `complainants_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE SET NULL;

--
-- Constraints for table `documents_filing`
--
ALTER TABLE `documents_filing`
  ADD CONSTRAINT `documents_filing_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE SET NULL;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_ibfk_2` FOREIGN KEY (`lawyer_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `evaluation_ag_advice`
--
ALTER TABLE `evaluation_ag_advice`
  ADD CONSTRAINT `case_ag_fk` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`),
  ADD CONSTRAINT `evaluation_ag_advice_ibfk_1` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`) ON DELETE CASCADE;

--
-- Constraints for table `forwardings`
--
ALTER TABLE `forwardings`
  ADD CONSTRAINT `forwardings_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forwardings_ibfk_2` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`lawyer_id`) ON DELETE CASCADE;

--
-- Constraints for table `lawyers`
--
ALTER TABLE `lawyers`
  ADD CONSTRAINT `lawyers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `lawyer_payments`
--
ALTER TABLE `lawyer_payments`
  ADD CONSTRAINT `lawyer_payments_ibfk_1` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`lawyer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lawyer_payments_ibfk_2` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `lawyer_payment_attachments`
--
ALTER TABLE `lawyer_payment_attachments`
  ADD CONSTRAINT `fk_lawyer_payment_attachments` FOREIGN KEY (`lawyer_payment_id`) REFERENCES `lawyer_payments` (`payment_id`) ON DELETE CASCADE;

--
-- Constraints for table `negotiations`
--
ALTER TABLE `negotiations`
  ADD CONSTRAINT `negotiations_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `negotiation_attachments`
--
ALTER TABLE `negotiation_attachments`
  ADD CONSTRAINT `fk_negotiation` FOREIGN KEY (`negotiation_id`) REFERENCES `negotiations` (`negotiation_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_attachments`
--
ALTER TABLE `payment_attachments`
  ADD CONSTRAINT `fk_payment_attachments` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE;

--
-- Constraints for table `securitylogs`
--
ALTER TABLE `securitylogs`
  ADD CONSTRAINT `securitylogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `trials`
--
ALTER TABLE `trials`
  ADD CONSTRAINT `trials_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `trials_attachments`
--
ALTER TABLE `trials_attachments`
  ADD CONSTRAINT `trials_attachments_ibfk_1` FOREIGN KEY (`trial_id`) REFERENCES `trials` (`trial_id`) ON DELETE CASCADE;

--
-- Constraints for table `trial_preparations`
--
ALTER TABLE `trial_preparations`
  ADD CONSTRAINT `trial_preparations_ibfk_2` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `trial_preparation_attachments`
--
ALTER TABLE `trial_preparation_attachments`
  ADD CONSTRAINT `trial_preparation_attachments_ibfk_1` FOREIGN KEY (`preparation_id`) REFERENCES `trial_preparations` (`preparation_id`) ON DELETE CASCADE;

--
-- Constraints for table `trial_preparation_lawyer`
--
ALTER TABLE `trial_preparation_lawyer`
  ADD CONSTRAINT `fk_trial_preparation_lawyer_lawyer` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`lawyer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_trial_preparation_lawyer_preparation` FOREIGN KEY (`preparation_id`) REFERENCES `trial_preparations` (`preparation_id`) ON DELETE CASCADE;

--
-- Constraints for table `trial_preparation_witness`
--
ALTER TABLE `trial_preparation_witness`
  ADD CONSTRAINT `fk_trial_preparation_witness_preparation` FOREIGN KEY (`preparation_id`) REFERENCES `trial_preparations` (`preparation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_trial_preparation_witness_witness` FOREIGN KEY (`witness_id`) REFERENCES `witnesses` (`witness_id`) ON DELETE CASCADE;

--
-- Constraints for table `witnesses`
--
ALTER TABLE `witnesses`
  ADD CONSTRAINT `witnesses_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `witnesses_attachments`
--
ALTER TABLE `witnesses_attachments`
  ADD CONSTRAINT `fk_witness_attachment` FOREIGN KEY (`witness_id`) REFERENCES `witnesses` (`witness_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
