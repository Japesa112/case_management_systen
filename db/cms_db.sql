-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 01:01 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `case_status` varchar(255) DEFAULT 'Under Review',
  `case_category` enum('Academic','Disciplinary','Administrative','student','staff','supplier','staff union') NOT NULL,
  `initial_status` enum('Under Review','Approved','Rejected','Needs Negotiation') NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`case_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `dvc_appointment`
--

CREATE TABLE IF NOT EXISTS `dvc_appointment` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `evaluation_id` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `appointment_time` time NOT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `forwarding_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `fk_evaluation` (`evaluation_id`),
  KEY `fk_dvc_appointment_forwarding` (`forwarding_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dvc_appointment_attachment`
--

CREATE TABLE IF NOT EXISTS `dvc_appointment_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(512) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `fk_dvc_appointment` (`appointment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `evaluation_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `dvc_appointment_date` date DEFAULT NULL,
  `briefing_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dvc_appointment_time` time DEFAULT NULL,
  PRIMARY KEY (`forwarding_id`),
  KEY `case_id` (`case_id`),
  KEY `evaluation_id_fk1` (`evaluation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `google_users`
--

CREATE TABLE IF NOT EXISTS `google_users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `logged_out_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `google_id` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `payee` enum('kenyatta_university','complainant','lawyer','other') NOT NULL,
  `payee_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('Cash','Bank Transfer','Credit Card','Mpesa','Other') NOT NULL,
  `transaction` text DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_time` time NOT NULL,
  `due_date` date DEFAULT NULL,
  `due_time` time DEFAULT NULL,
  `auctioneer_involvement` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `payment_status` enum('pending','completed') NOT NULL,
  `payment_type` enum('deposit','final') DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `pre_trials`
--

CREATE TABLE IF NOT EXISTS `pre_trials` (
  `pretrial_id` int(11) NOT NULL AUTO_INCREMENT,
  `case_id` int(11) NOT NULL,
  `pretrial_date` date NOT NULL,
  `pretrial_time` time NOT NULL,
  `comments` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pretrial_id`),
  KEY `case_id` (`case_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_trial_attachments`
--

CREATE TABLE IF NOT EXISTS `pre_trial_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `pretrial_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`attachment_id`),
  KEY `pretrial_id` (`pretrial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_trial_members`
--

CREATE TABLE IF NOT EXISTS `pre_trial_members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `pretrial_id` int(11) NOT NULL,
  `member_type` enum('lawyer','witness','dvc','other') NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role_or_position` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`member_id`),
  KEY `pretrial_id` (`pretrial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `google_id` varchar(255) DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `logged_out_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `google_id` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `full_name`, `phone`, `role`, `account_status`, `created_at`, `last_login`, `google_id`, `logged_in_at`, `logged_out_at`, `updated_at`) VALUES
(1, 'Abang', 'isaiah132@gmail.com', '$2y$12$8WsXuplEKOyasszBHfWozOqwK5FbbYhUjyg5ovIRN5nOEJ/CJ.3i6', 'Isaiah Omulo', '0746282760', 'Admin', 'Pending', '2025-02-26 06:18:39', '2025-02-26 06:18:39', NULL, NULL, '2025-05-26 04:28:02', NULL),
(2, 'isaiahomulo602', 'intern-ict@ku.ac.ke', '$2y$12$DAHQtUIdnN7vXlOt2jwAUelUEntKyYL98sDFuDmHINEwdEgI3QUci', 'Isaiah Omulo', '7462827602', 'Lawyer', 'Pending', '2025-03-17 07:36:27', '2025-03-17 07:36:27', '116680174322884546765', '2025-06-10 08:33:05', '2025-06-10 08:33:53', NULL),
(3, 'jamesowino444', 'omulodeveloper@gmail.com', '$2y$12$WAzExmBHtYstMoJ80YzSKO2MmMHqJkuW7v49nxkqzo3vpFUAg2waC', 'James Owino', '0702111444', 'Admin', 'Pending', '2025-03-17 08:18:30', '2025-03-17 08:18:30', '103535761912352333445', '2025-06-13 03:02:52', '2025-06-10 08:32:59', NULL),
(4, 'jamesomolo760', 'james@gmail.com', '$2y$12$bpwdU4xvL5Wy5utbyjRN0eBgZfyPd402Hmnh4B1mAHikmo1CQCFgK', 'James Omolo', '0742282760', 'Lawyer', 'Pending', '2025-03-17 08:20:40', '2025-03-17 08:20:40', NULL, NULL, NULL, NULL),
(5, 'carolinemuthoni766', 'caroline@gmail.com', '$2y$12$mD5PafevnOwJaK0pcuQTtOB5Gb.pp7BosRjL5yi6YUf0Ex1Raz8IO', 'Caroline Waweru', '0746282766', 'Lawyer', 'Pending', '2025-04-01 11:41:31', '2025-04-01 11:41:31', NULL, NULL, NULL, NULL),
(6, 'johnsonsakaja121', 'sakajaaa@gmail.com', '$2y$12$HRsjVrLz5VzlSv73aethdeyJV/CZWxm7jPFugS959O8iXtR8ixfYK', 'Johnson Sakaja', '0702111442121', 'Admin', 'Pending', '2025-04-29 12:23:50', '2025-04-29 12:23:50', NULL, NULL, NULL, NULL),
(7, 'johnsonsakaja243', 'sakajaSQa@gmail.com', '$2y$12$WWSAx8mvpT1xW6SabxI2EeUrLS9.AJ4bTOxdxyo2uIZZ1ZH2gPCsi', 'Johnson Sakaja', '07021114443243', 'Admin', 'Pending', '2025-04-29 12:24:31', '2025-04-29 12:24:31', NULL, NULL, NULL, NULL),
(8, 'johnsonsakaja322', 'johnsohn@gmail.com', '$2y$12$bI450jRlfMyhmDAuT4TPIucQ9Q89irDfnLzvSf.LFum8b7TQAW8t2', 'Johnson Sakaja', '07462827322', 'Admin', 'Pending', '2025-04-29 12:27:58', '2025-04-29 12:27:58', NULL, NULL, NULL, NULL),
(9, 'kevinwaweru255', 'kevinwaweru31@gmail.com', '$2y$12$gyKlTmhFmCWCEooUZFVqmevnsIuVEBY6qvh8bO7EYhJSLiFb2i8kG', 'Kevin Onyango', '0700332255', 'Lawyer', 'Pending', '2025-05-08 12:47:21', '2025-05-08 12:47:21', NULL, NULL, NULL, NULL),
(10, 'victorwanyama522', 'victorwanyama12@gmail.com', '$2y$12$ryrUXr9/W5HFuhV..vKF9.DeT6KX/rrwe0rRxhNLMrJJp1J3hsMja', 'Victor Wanyama', '0746885522', 'Lawyer', 'Pending', '2025-05-21 06:45:27', '2025-05-21 06:45:27', NULL, NULL, NULL, NULL),
(11, 'brianwaweru322', 'wawerubrian@gmail.com', '$2y$12$iubCWkBXRx1eAMtUSfHapOZ7S1FbbPOrFKgcMfn.SS3n9aUXFvE2G', 'Brian Waweru', '0755443322', 'Lawyer', 'Pending', '2025-05-21 07:20:34', '2025-05-21 07:20:34', NULL, NULL, NULL, NULL),
(12, 'jeremyombe890', 'jeremy@gmail.com', '$2y$12$wrqSRzh38Yyg.y7C88RNje3HuFXh9Ag8/OfTVk3RHc8MJMQAiKnnG', 'Jeremy Ombe', '071234567890', 'Lawyer', 'Pending', '2025-06-03 05:51:59', '2025-06-03 05:51:59', NULL, '2025-06-03 03:01:07', '2025-06-03 03:08:13', NULL),
(13, 'jeremywaweru891', 'jeremywaweu@gmail.com', '$2y$12$2YzFkkaQo.5fCBhG6IipjuEsS3IGIpPeapAQIcld3f7WfXo/khpQq', 'Jeremy Waweru', '071234567891', 'Lawyer', 'Pending', '2025-06-03 07:06:18', '2025-06-03 07:06:18', NULL, NULL, NULL, NULL),
(14, 'jamesomolo445', 'admin123@gmail.com', '$2y$12$MFJYygbARyeTT6sptv58YeSlalaJrjYyqo7N0SKDZifAkg/AJPTeu', 'James Omolo', '0702111445', 'Admin', 'Pending', '2025-06-10 05:59:33', '2025-06-10 05:59:33', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE IF NOT EXISTS `user_notification` (
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`user_id`,`notification_id`),
  KEY `fk_user_notification_notification` (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Constraints for table `dvc_appointment`
--
ALTER TABLE `dvc_appointment`
  ADD CONSTRAINT `fk_dvc_appointment_forwarding` FOREIGN KEY (`forwarding_id`) REFERENCES `forwardings` (`forwarding_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_evaluation` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`) ON DELETE CASCADE;

--
-- Constraints for table `dvc_appointment_attachment`
--
ALTER TABLE `dvc_appointment_attachment`
  ADD CONSTRAINT `fk_dvc_appointment` FOREIGN KEY (`appointment_id`) REFERENCES `dvc_appointment` (`appointment_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `evaluation_id_fk1` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluations` (`evaluation_id`),
  ADD CONSTRAINT `forwardings_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

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
-- Constraints for table `pre_trials`
--
ALTER TABLE `pre_trials`
  ADD CONSTRAINT `pre_trials_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`case_id`) ON DELETE CASCADE;

--
-- Constraints for table `pre_trial_attachments`
--
ALTER TABLE `pre_trial_attachments`
  ADD CONSTRAINT `pre_trial_attachments_ibfk_1` FOREIGN KEY (`pretrial_id`) REFERENCES `pre_trials` (`pretrial_id`) ON DELETE CASCADE;

--
-- Constraints for table `pre_trial_members`
--
ALTER TABLE `pre_trial_members`
  ADD CONSTRAINT `pre_trial_members_ibfk_1` FOREIGN KEY (`pretrial_id`) REFERENCES `pre_trials` (`pretrial_id`) ON DELETE CASCADE;

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
-- Constraints for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD CONSTRAINT `fk_user_notification_notification` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_notification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

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
