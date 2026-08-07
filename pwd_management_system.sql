-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2026 at 10:52 AM
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
-- Database: `pwd_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `assistance_records`
--

CREATE TABLE `assistance_records` (
  `id` int(11) NOT NULL,
  `pwd_id` int(11) NOT NULL,
  `assistance_type` enum('Financial','Medical','Educational','Rehabilitation','Equipment','Other') NOT NULL,
  `assistance_date` date NOT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `description` text NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('completed','pending','cancelled') DEFAULT 'completed',
  `recorded_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `description`, `record_id`, `table_name`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(97, 8, 'REGISTER', 'New admin user registered: chardoxx', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-28 13:33:28'),
(98, 8, 'LOGIN', 'User logged into the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-28 13:33:34'),
(99, 8, 'LOGOUT', 'User logged out of the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-28 13:33:37'),
(115, 8, 'LOGIN', 'User logged into the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-07 08:43:22'),
(116, 8, 'LOGOUT', 'User logged out of the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-07 08:43:37'),
(117, 8, 'LOGIN', 'User logged into the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-07 08:44:50'),
(118, 8, 'UPDATE_PROFILE', 'Updated admin profile information', NULL, NULL, NULL, NULL, '::1', NULL, '2026-08-07 08:45:18'),
(119, 8, 'LOGOUT', 'User logged out of the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-07 08:45:22'),
(120, 8, 'LOGIN', 'User logged into the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-07 08:45:54'),
(121, 8, 'LOGOUT', 'User logged out of the system', NULL, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', '2026-08-07 08:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `disability_types`
--

CREATE TABLE `disability_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disability_types`
--

INSERT INTO `disability_types` (`id`, `type_name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Visual Impairment', 'Includes blindness and low vision', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(2, 'Hearing Impairment', 'Includes deafness and hard of hearing', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(3, 'Physical Disability', 'Mobility impairments and physical limitations', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(4, 'Intellectual Disability', 'Developmental and cognitive impairments', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(5, 'Mental Health Condition', 'Psychological and psychiatric disorders', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(6, 'Speech Disability', 'Communication and speech impairments', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(7, 'Multiple Disabilities', 'Combination of two or more disabilities', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(8, 'Autism Spectrum', 'Neurodevelopmental disorders', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(9, 'Cerebral Palsy', 'Group of disorders affecting movement and coordination', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(10, 'Down Syndrome', 'Genetic chromosome disorder', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31'),
(11, 'Other', 'Other types of disabilities not listed', 1, '2025-10-09 18:06:31', '2025-10-09 18:06:31');

-- --------------------------------------------------------

--
-- Table structure for table `pwd_profiles`
--

CREATE TABLE `pwd_profiles` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `age` int(11) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `disability_type` varchar(100) NOT NULL,
  `disability_level` enum('Mild','Moderate','Severe') DEFAULT NULL,
  `medical_notes` text DEFAULT NULL,
  `identification_number` varchar(50) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_number` varchar(20) DEFAULT NULL,
  `emergency_contact_relation` varchar(50) DEFAULT NULL,
  `status` enum('active','archived','inactive') DEFAULT 'active',
  `registration_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pwd_profiles`
--

INSERT INTO `pwd_profiles` (`id`, `full_name`, `gender`, `age`, `birth_date`, `address`, `contact_number`, `email`, `disability_type`, `disability_level`, `medical_notes`, `identification_number`, `emergency_contact_name`, `emergency_contact_number`, `emergency_contact_relation`, `status`, `registration_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'Aljunmar Cultura', 'Male', 21, NULL, 'Zone 3 Bonbon', '09273532291', NULL, 'Mental Health Condition', NULL, '', NULL, NULL, NULL, NULL, 'active', '2025-10-17', '2025-10-17 07:53:27', '2025-10-17 07:53:59', NULL),
(10, 'mjay jurado', 'Female', 21, NULL, 'Zone 3 Bonbon', '09273532291', NULL, 'Other', NULL, '', NULL, NULL, NULL, NULL, 'active', '2025-10-17', '2025-10-17 07:54:20', '2025-11-28 04:07:02', NULL),
(13, 'richard miculob', 'Male', 42, NULL, 'Zone 3 Bonbon', '09273532291', 'miculobrichardvictor@gmail.com', 'Mental Health Condition', 'Mild', 'Bad', '79874397-3626', NULL, NULL, NULL, 'active', '2025-11-28', '2025-11-28 13:10:40', '2025-11-28 13:10:40', NULL),
(14, 'noel rante', 'Male', 34, NULL, 'liong camiguin', '09518874506', 'noel@gmail.com', 'Down Syndrome', 'Mild', '', '', NULL, NULL, NULL, 'active', '2025-12-16', '2025-12-16 02:44:39', '2025-12-16 02:44:39', NULL),
(16, 'yidhahdkx', 'Female', 21, NULL, 'ywgwj', '098546354273', 'dudhuhd@gmail.com', 'Down Syndrome', 'Mild', 'sjkuahiycuhcsicsk', '123234', NULL, NULL, NULL, 'active', '2025-12-16', '2025-12-16 02:58:31', '2025-12-16 02:58:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `pwd_id` int(11) NOT NULL,
  `assistance_type` enum('Financial','Medical','Educational','Rehabilitation','Equipment','Other') NOT NULL,
  `reservation_date` date NOT NULL,
  `purpose` text NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','completed','cancelled') DEFAULT 'pending',
  `created_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `is_active`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'admin', '$2y$10$0OY3VyBrbqsB7wQSqi088uspWKBtywgizTJM8HBl/kBBgCiuQ46/G', 'Admin', 'admin@gmail.com', 1, NULL, '2025-11-28 13:33:28', '2026-08-07 16:45:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assistance_records`
--
ALTER TABLE `assistance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pwd_id` (`pwd_id`),
  ADD KEY `idx_assistance_type` (`assistance_type`),
  ADD KEY `idx_assistance_date` (`assistance_date`),
  ADD KEY `idx_recorded_by` (`recorded_by`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_action` (`action`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_record_id` (`record_id`);

--
-- Indexes for table `disability_types`
--
ALTER TABLE `disability_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `pwd_profiles`
--
ALTER TABLE `pwd_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identification_number` (`identification_number`),
  ADD KEY `idx_disability_type` (`disability_type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pwd_id` (`pwd_id`),
  ADD KEY `idx_reservation_date` (`reservation_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assistance_records`
--
ALTER TABLE `assistance_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `disability_types`
--
ALTER TABLE `disability_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pwd_profiles`
--
ALTER TABLE `pwd_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistance_records`
--
ALTER TABLE `assistance_records`
  ADD CONSTRAINT `assistance_records_ibfk_1` FOREIGN KEY (`pwd_id`) REFERENCES `pwd_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assistance_records_ibfk_2` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pwd_profiles`
--
ALTER TABLE `pwd_profiles`
  ADD CONSTRAINT `pwd_profiles_ibfk_1` FOREIGN KEY (`disability_type`) REFERENCES `disability_types` (`type_name`) ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`pwd_id`) REFERENCES `pwd_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
