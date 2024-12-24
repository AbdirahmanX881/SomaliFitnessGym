
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 24, 2024 at 12:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SomaliFitnessGym`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `applicant_name` varchar(100) NOT NULL,
  `applicant_email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `application_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `course_id`, `applicant_name`, `applicant_email`, `phone_number`, `application_date`) VALUES
(1, 1, 'ahmed', 'ahmed@gmail.com', '907537965', '2024-12-24 13:57:18'),
(2, 1, 'ahmed', 'ahmed@gmail.com', '907537965', '2024-12-24 14:01:59'),
(3, 7, 'ahmed', 'ahmed@gmail.com', '907537965', '2024-12-24 14:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `p_no` int(11) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `price`, `icon`) VALUES
(1, 'Strength Training', 'Build muscle and increase strength.', 50.00, 'fa-dumbbell'),
(2, 'Cardio Fitness', 'Improve cardiovascular health and endurance.', 40.00, 'fa-running'),
(3, 'Weight Loss Program', 'Achieve weight loss goals with nutrition and exercise.', 60.00, 'fa-weight-scale'),
(4, 'Yoga Basics', 'Improve your flexibility and relieve stress with beginner yoga.', 25.00, 'fa-yoga'),
(5, 'Strength Training', 'Build muscle and strength with targeted exercises.', 30.00, 'fa-dumbbell'),
(6, 'Cardio Blast', 'Burn calories with high-intensity cardio workouts.', 20.00, 'fa-heartbeat'),
(7, 'Pilates', 'Enhance core strength and posture with Pilates.', 35.00, 'fa-person-running'),
(8, 'Zumba Dance', 'Have fun and stay fit with energetic dance routines.', 15.00, 'fa-music');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `m_no` int(11) NOT NULL,
  `p_no` int(11) NOT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `chest` decimal(5,2) DEFAULT NULL,
  `waist` decimal(5,2) DEFAULT NULL,
  `arms` decimal(5,2) DEFAULT NULL,
  `legs` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `measurements`
--

INSERT INTO `measurements` (`m_no`, `p_no`, `weight`, `height`, `chest`, `waist`, `arms`, `legs`, `created_at`) VALUES
(1, 2, 44.00, 180.00, 30.00, 40.00, 12.00, 34.00, '2024-12-24 08:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `p_no` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff','member') NOT NULL DEFAULT 'member',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `membership_end` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `membership_type` enum('strength','cardio','weighy_loss','yoga','other') NOT NULL DEFAULT 'other'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`p_no`, `fname`, `lname`, `phone`, `email`, `password`, `role`, `status`, `membership_end`, `created_at`, `updated_at`, `membership_type`) VALUES
(1, 'Admin', 'User', '123456789', 'admin@somalifitness.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', NULL, '2024-12-13 14:41:56', '2024-12-13 14:41:56', 'other'),
(2, 'abdirahman', 'abdalla', '0770555718', 'caalamisiciid111@gmail.com', '$2y$10$lTsqkweLcKAbsP8tkuLadORj7R1fbHQk/0VrFd6.FA0wH6fj6AfYq', 'member', 'active', '2025-04-24', '2024-12-23 19:11:08', '2024-12-24 08:55:53', 'other'),
(3, 'cali', 'said', '0660666666', 'cali@gmail.com', '$2y$10$FC4JUW54fxcaqzg6n4WxSeqVeHp4YcuzdMwKOysqnnPZ45rfEWUt2', 'member', 'active', NULL, '2024-12-24 10:59:26', '2024-12-24 10:59:26', 'other');

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `r_no` int(11) NOT NULL,
  `p_no` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_type` enum('cash','card','mobile') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`r_no`, `p_no`, `amount`, `payment_type`, `created_at`) VALUES
(1, 2, 33.00, 'card', '2024-12-23 21:05:19'),
(2, 2, 122.00, 'mobile', '2024-12-24 08:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_no` (`p_no`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`m_no`),
  ADD KEY `p_no` (`p_no`),
  ADD KEY `idx_measurements_date` (`created_at`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`p_no`),
  ADD KEY `idx_people_role` (`role`),
  ADD KEY `idx_people_status` (`status`),
  ADD KEY `idx_people_membership` (`membership_end`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`r_no`),
  ADD KEY `p_no` (`p_no`),
  ADD KEY `idx_receipts_date` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `m_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `p_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `r_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`p_no`) REFERENCES `people` (`p_no`) ON DELETE CASCADE;

--
-- Constraints for table `measurements`
--
ALTER TABLE `measurements`
  ADD CONSTRAINT `measurements_ibfk_1` FOREIGN KEY (`p_no`) REFERENCES `people` (`p_no`) ON DELETE CASCADE;

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`p_no`) REFERENCES `people` (`p_no`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
