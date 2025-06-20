-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 08:53 AM
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
-- Database: `cms_db_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjourns`
--

CREATE TABLE `adjourns` (
  `adjourns_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `next_hearing_date` date NOT NULL,
  `next_hearing_time` time NOT NULL,
  `adjourn_comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adjourn_attachments`
--

CREATE TABLE `adjourn_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `adjourns_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appeal`
--

CREATE TABLE `appeal` (
  `appeal_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `next_hearing_date` date NOT NULL,
  `next_hearing_time` time NOT NULL,
  `appeal_comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appeal_attachments`
--

CREATE TABLE `appeal_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `appeal_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` datetime NOT NULL DEFAULT '2025-03-18 06:14:24',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caseclosures`
--

CREATE TABLE `caseclosures` (
  `closure_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `closure_date` date NOT NULL,
  `final_outcome` text DEFAULT NULL,
  `follow_up_actions` text DEFAULT NULL,
  `lawyer_payment_confirmed` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `caseclosure_attachments`
--

CREATE TABLE `caseclosure_attachments` (
  `attachment_id` int(20) NOT NULL,
  `caseclosure_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `case_id` int(11) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_activities`
--

CREATE TABLE `case_activities` (
  `id` int(11) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_documents`
--

CREATE TABLE `case_documents` (
  `document_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `document_uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `document_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `case_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_lawyer`
--

CREATE TABLE `case_lawyer` (
  `assigned_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complainants`
--

CREATE TABLE `complainants` (
  `Complainant_id` int(11) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `complainant_name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents_filing`
--

CREATE TABLE `documents_filing` (
  `document_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `document_type` enum('Defense','Claim') NOT NULL,
  `mention_date` date DEFAULT NULL,
  `hearing_date` date DEFAULT NULL,
  `filing_date` date DEFAULT NULL,
  `document_uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `document_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `case_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dvc_appointment`
--

CREATE TABLE `dvc_appointment` (
  `appointment_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `appointment_time` time NOT NULL,
  `appointment_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `forwarding_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dvc_appointment_attachment`
--

CREATE TABLE `dvc_appointment_attachment` (
  `attachment_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(512) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `evaluation_id` int(11) NOT NULL,
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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_ag_advice`
--

CREATE TABLE `evaluation_ag_advice` (
  `ag_advice_id` int(11) NOT NULL,
  `evaluation_id` int(11) DEFAULT NULL,
  `advice_date` date NOT NULL,
  `advice_time` time NOT NULL,
  `ag_advice` text DEFAULT NULL,
  `case_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `uuid` char(36) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forwardings`
--

CREATE TABLE `forwardings` (
  `forwarding_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `dvc_appointment_date` date DEFAULT NULL,
  `briefing_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dvc_appointment_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fsd`
--

CREATE TABLE `fsd` (
  `id` int(11) NOT NULL,
  `case_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `google_users`
--

CREATE TABLE `google_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `logged_out_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lawyers`
--

CREATE TABLE `lawyers` (
  `lawyer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `license_number` varchar(50) NOT NULL,
  `area_of_expertise` varchar(255) DEFAULT NULL,
  `firm_name` varchar(255) DEFAULT NULL,
  `years_experience` int(11) DEFAULT NULL,
  `working_hours` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_payments`
--

CREATE TABLE `lawyer_payments` (
  `payment_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `lawyer_id` int(11) NOT NULL,
  `transaction` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_time` time NOT NULL,
  `lawyer_payment_status` enum('Pending','Completed') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_payment_attachments`
--

CREATE TABLE `lawyer_payment_attachments` (
  `attachment_id` int(20) NOT NULL,
  `lawyer_payment_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `negotiations`
--

CREATE TABLE `negotiations` (
  `negotiation_id` int(11) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `negotiation_attachments`
--

CREATE TABLE `negotiation_attachments` (
  `attachment_id` int(11) NOT NULL,
  `negotiation_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_evaluations`
--

CREATE TABLE `panel_evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `case_id` bigint(20) UNSIGNED NOT NULL,
  `evaluator_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` text DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
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
  `payment_type` enum('deposit','final') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_attachments`
--

CREATE TABLE `payment_attachments` (
  `attachment_id` int(20) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_trials`
--

CREATE TABLE `pre_trials` (
  `pretrial_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `pretrial_date` date NOT NULL,
  `pretrial_time` time NOT NULL,
  `comments` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_trial_attachments`
--

CREATE TABLE `pre_trial_attachments` (
  `attachment_id` int(11) NOT NULL,
  `pretrial_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `upload_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_trial_members`
--

CREATE TABLE `pre_trial_members` (
  `member_id` int(11) NOT NULL,
  `pretrial_id` int(11) NOT NULL,
  `member_type` enum('lawyer','witness','dvc','other') NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role_or_position` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `securitylogs`
--

CREATE TABLE `securitylogs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trials`
--

CREATE TABLE `trials` (
  `trial_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `trial_date` date NOT NULL,
  `trial_time` time NOT NULL,
  `judgement_details` text DEFAULT NULL,
  `judgement_date` date DEFAULT NULL,
  `judgement_time` time NOT NULL,
  `outcome` enum('Win','Loss','Adjourned','Dismissed') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trials_attachments`
--

CREATE TABLE `trials_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `trial_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparations`
--

CREATE TABLE `trial_preparations` (
  `preparation_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `preparation_date` date DEFAULT NULL,
  `preparation_time` time NOT NULL,
  `briefing_notes` text DEFAULT NULL,
  `preparation_status` enum('Pending','Ongoing','Completed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparation_attachments`
--

CREATE TABLE `trial_preparation_attachments` (
  `attachment_id` bigint(20) UNSIGNED NOT NULL,
  `preparation_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `upload_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparation_lawyer`
--

CREATE TABLE `trial_preparation_lawyer` (
  `id` int(11) NOT NULL,
  `preparation_id` int(11) NOT NULL,
  `lawyer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trial_preparation_witness`
--

CREATE TABLE `trial_preparation_witness` (
  `id` int(11) NOT NULL,
  `preparation_id` int(11) NOT NULL,
  `witness_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `full_name`, `phone`, `role`, `account_status`, `created_at`, `last_login`, `google_id`, `logged_in_at`, `logged_out_at`, `updated_at`) VALUES
(3, 'jamesowino444', 'omulodeveloper@gmail.com', '$2y$12$WAzExmBHtYstMoJ80YzSKO2MmMHqJkuW7v49nxkqzo3vpFUAg2waC', 'James Owino', '0702111444', 'Admin', 'Pending', '2025-03-17 08:18:30', '2025-03-17 08:18:30', '103535761912352333445', '2025-06-17 02:33:06', '2025-06-16 06:48:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `witnesses`
--

CREATE TABLE `witnesses` (
  `witness_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `witness_name` varchar(255) NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `availability` enum('Yes','No') NOT NULL,
  `witness_statement` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `witnesses_attachments`
--

CREATE TABLE `witnesses_attachments` (
  `attachment_id` int(11) NOT NULL,
  `witness_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adjourns`
--
ALTER TABLE `adjourns`
  ADD PRIMARY KEY (`adjourns_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `adjourn_attachments`
--
ALTER TABLE `adjourn_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `adjourns_id` (`adjourns_id`);

--
-- Indexes for table `appeal`
--
ALTER TABLE `appeal`
  ADD PRIMARY KEY (`appeal_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `appeal_attachments`
--
ALTER TABLE `appeal_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `fk_appeal_attachments_appeal` (`appeal_id`);

--
-- Indexes for table `caseclosures`
--
ALTER TABLE `caseclosures`
  ADD PRIMARY KEY (`closure_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `caseclosure_attachments`
--
ALTER TABLE `caseclosure_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `caseclosure_id` (`caseclosure_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`case_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `case_activities`
--
ALTER TABLE `case_activities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_case_type_sequence` (`case_id`,`type`,`sequence_number`);

--
-- Indexes for table `case_documents`
--
ALTER TABLE `case_documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `case_lawyer`
--
ALTER TABLE `case_lawyer`
  ADD PRIMARY KEY (`assigned_id`),
  ADD KEY `case_assignd_fk` (`case_id`),
  ADD KEY `lawyer_assigned_fk` (`lawyer_id`);

--
-- Indexes for table `complainants`
--
ALTER TABLE `complainants`
  ADD PRIMARY KEY (`Complainant_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `documents_filing`
--
ALTER TABLE `documents_filing`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `dvc_appointment`
--
ALTER TABLE `dvc_appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `fk_evaluation` (`evaluation_id`),
  ADD KEY `fk_dvc_appointment_forwarding` (`forwarding_id`);

--
-- Indexes for table `dvc_appointment_attachment`
--
ALTER TABLE `dvc_appointment_attachment`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `fk_dvc_appointment` (`appointment_id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`evaluation_id`),
  ADD KEY `case_id` (`case_id`),
  ADD KEY `evaluations_ibfk_2` (`lawyer_id`);

--
-- Indexes for table `evaluation_ag_advice`
--
ALTER TABLE `evaluation_ag_advice`
  ADD PRIMARY KEY (`ag_advice_id`),
  ADD KEY `evaluation_id` (`evaluation_id`),
  ADD KEY `case_ag_fk` (`case_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `forwardings`
--
ALTER TABLE `forwardings`
  ADD PRIMARY KEY (`forwarding_id`),
  ADD KEY `case_id` (`case_id`),
  ADD KEY `evaluation_id_fk1` (`evaluation_id`);

--
-- Indexes for table `fsd`
--
ALTER TABLE `fsd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_users`
--
ALTER TABLE `google_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `lawyers`
--
ALTER TABLE `lawyers`
  ADD PRIMARY KEY (`lawyer_id`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `lawyer_payments`
--
ALTER TABLE `lawyer_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `lawyer_id` (`lawyer_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `lawyer_payment_attachments`
--
ALTER TABLE `lawyer_payment_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `lawyer_payment_id` (`lawyer_payment_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `negotiations`
--
ALTER TABLE `negotiations`
  ADD PRIMARY KEY (`negotiation_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `negotiation_attachments`
--
ALTER TABLE `negotiation_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `negotiation_id` (`negotiation_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `panel_evaluations`
--
ALTER TABLE `panel_evaluations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `payment_attachments`
--
ALTER TABLE `payment_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `pre_trials`
--
ALTER TABLE `pre_trials`
  ADD PRIMARY KEY (`pretrial_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `pre_trial_attachments`
--
ALTER TABLE `pre_trial_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `pretrial_id` (`pretrial_id`);

--
-- Indexes for table `pre_trial_members`
--
ALTER TABLE `pre_trial_members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `pretrial_id` (`pretrial_id`);

--
-- Indexes for table `securitylogs`
--
ALTER TABLE `securitylogs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trials`
--
ALTER TABLE `trials`
  ADD PRIMARY KEY (`trial_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `trials_attachments`
--
ALTER TABLE `trials_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `trial_id` (`trial_id`);

--
-- Indexes for table `trial_preparations`
--
ALTER TABLE `trial_preparations`
  ADD PRIMARY KEY (`preparation_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `trial_preparation_attachments`
--
ALTER TABLE `trial_preparation_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `preparation_id` (`preparation_id`);

--
-- Indexes for table `trial_preparation_lawyer`
--
ALTER TABLE `trial_preparation_lawyer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trial_preparation_lawyer_preparation` (`preparation_id`),
  ADD KEY `fk_trial_preparation_lawyer_lawyer` (`lawyer_id`);

--
-- Indexes for table `trial_preparation_witness`
--
ALTER TABLE `trial_preparation_witness`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trial_preparation_witness_preparation` (`preparation_id`),
  ADD KEY `fk_trial_preparation_witness_witness` (`witness_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`user_id`,`notification_id`),
  ADD KEY `fk_user_notification_notification` (`notification_id`);

--
-- Indexes for table `witnesses`
--
ALTER TABLE `witnesses`
  ADD PRIMARY KEY (`witness_id`),
  ADD KEY `case_id` (`case_id`);

--
-- Indexes for table `witnesses_attachments`
--
ALTER TABLE `witnesses_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `fk_witness_attachment` (`witness_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adjourns`
--
ALTER TABLE `adjourns`
  MODIFY `adjourns_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjourn_attachments`
--
ALTER TABLE `adjourn_attachments`
  MODIFY `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appeal`
--
ALTER TABLE `appeal`
  MODIFY `appeal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appeal_attachments`
--
ALTER TABLE `appeal_attachments`
  MODIFY `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caseclosures`
--
ALTER TABLE `caseclosures`
  MODIFY `closure_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caseclosure_attachments`
--
ALTER TABLE `caseclosure_attachments`
  MODIFY `attachment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_activities`
--
ALTER TABLE `case_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_documents`
--
ALTER TABLE `case_documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `case_lawyer`
--
ALTER TABLE `case_lawyer`
  MODIFY `assigned_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complainants`
--
ALTER TABLE `complainants`
  MODIFY `Complainant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents_filing`
--
ALTER TABLE `documents_filing`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dvc_appointment`
--
ALTER TABLE `dvc_appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dvc_appointment_attachment`
--
ALTER TABLE `dvc_appointment_attachment`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `evaluation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluation_ag_advice`
--
ALTER TABLE `evaluation_ag_advice`
  MODIFY `ag_advice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forwardings`
--
ALTER TABLE `forwardings`
  MODIFY `forwarding_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `google_users`
--
ALTER TABLE `google_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lawyers`
--
ALTER TABLE `lawyers`
  MODIFY `lawyer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lawyer_payments`
--
ALTER TABLE `lawyer_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lawyer_payment_attachments`
--
ALTER TABLE `lawyer_payment_attachments`
  MODIFY `attachment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `negotiations`
--
ALTER TABLE `negotiations`
  MODIFY `negotiation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `negotiation_attachments`
--
ALTER TABLE `negotiation_attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_evaluations`
--
ALTER TABLE `panel_evaluations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_attachments`
--
ALTER TABLE `payment_attachments`
  MODIFY `attachment_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_trials`
--
ALTER TABLE `pre_trials`
  MODIFY `pretrial_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_trial_attachments`
--
ALTER TABLE `pre_trial_attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_trial_members`
--
ALTER TABLE `pre_trial_members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `securitylogs`
--
ALTER TABLE `securitylogs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trials`
--
ALTER TABLE `trials`
  MODIFY `trial_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trials_attachments`
--
ALTER TABLE `trials_attachments`
  MODIFY `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trial_preparations`
--
ALTER TABLE `trial_preparations`
  MODIFY `preparation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trial_preparation_attachments`
--
ALTER TABLE `trial_preparation_attachments`
  MODIFY `attachment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trial_preparation_lawyer`
--
ALTER TABLE `trial_preparation_lawyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trial_preparation_witness`
--
ALTER TABLE `trial_preparation_witness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `witnesses`
--
ALTER TABLE `witnesses`
  MODIFY `witness_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `witnesses_attachments`
--
ALTER TABLE `witnesses_attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

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
