-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 27, 2026 at 03:51 AM
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
-- Database: `tvlstc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$fclmpCBgKAISG7jDLGYDfujCqC9znRrhKC12OBFpTYHLcDKviq8x.', '2026-02-26 06:01:44');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `category`, `created_at`) VALUES
(1, 'Test', 'ww', 'assets/uploads/1772085747_logo.png', 'IT', '2026-02-26 06:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `time_limit` int(11) DEFAULT 20,
  `order_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `logo_initials` varchar(10) DEFAULT NULL,
  `color_class` varchar(50) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `services` text DEFAULT NULL,
  `social_fb` varchar(255) DEFAULT NULL,
  `social_web` varchar(255) DEFAULT NULL,
  `social_linkedin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `image_url`, `logo_initials`, `color_class`, `overview`, `description`, `mission`, `vision`, `services`, `social_fb`, `social_web`, `social_linkedin`) VALUES
(1, 'ATB Car Rental Services', 'assets/images/CAR_RENTAL_LOGO.png', 'ATB', 'bg-blue-600', 'Reliable car rental services for corporate and personal use.', 'Antonio T. Biñas (ATB) Car Rental Services is a customer-focused transportation company dedicated to providing secure, dependable, and practical mobility solutions. ATB Car Rental Services provides a varied fleet of well-maintained vehicles to fulfill the growing need for accessible and flexible travel options.', 'To offer comfortable, convenient, and reasonably priced transportation options while guaranteeing top-notch customer service on every journey.', 'To become the most reputable and preferred automobile rental company, known for dependability, cost-effectiveness, and first-rate service.', 'Short-term car rentals, Long-term rentals, Airport pick-up/drop-off services', '#', '#', '#'),
(2, 'ETB Industrial Facilities Construction', 'assets/images/ETB_logo.png', 'ETB', 'bg-slate-700', 'Trusted construction company specializing in high-quality industrial facilities.', 'ETB Industrial Facilities Construction is a trusted construction company specializing in the design, development, and construction of high-quality industrial facilities. We are committed to delivering safe, durable, and cost-efficient structures that support the operational success of our clients.', 'To deliver high-quality, safe, and cost-efficient industrial construction projects on time and within budget through reliable project management, skilled workmanship, and ethical business practices.', 'To deliver high-quality, safe, and cost-efficient industrial construction projects on time and within budget through reliable project management, skilled workmanship, and ethical business practices.', 'Warehouses and distribution centers, Manufacturing and production plants, Steel structure buildings, Factory and processing facilities', '#', '#', '#'),
(3, 'LABANGO LAUNDRY SERVICES', 'assets/images/laba_logo.png', 'LLS', 'bg-cyan-500', 'Modern laundromat redefining the everyday laundry experience.', 'LABANGO LAUNDRY SERVICES is a modern laundromat brand built to redefine the everyday laundry experience. Our mission is simple: provide fast, reliable, and hassle-free laundry services in a clean, comfortable, and technologically enhanced environment. LABANGO serves individuals, families, students, and local businesses that value quality, convenience, and affordability.', 'To provide clean, fast and reliable laundry solutions through modern equipment, exceptional customer service, and environmentally responsible practices making everyday life easier.', 'To Become the most trusted and recognized laundromat brand in the Philippines through consistent service, versatile solutions and a commitment to customer comfort and sustainability.', 'Wash, Fold, Dry, Ironing, Free Delivery Option', '#', '#', '#'),
(4, 'ATB Apartment', 'assets/images/apartment_logo.png', 'ATB', 'bg-blue-600', 'Affordable, practical, and secure living spaces for professionals and small families.', 'ATB Apartment offers affordable, practical, and comfortable living spaces specifically designed for individuals, small families, and starting professionals. Committed to providing a safe and clean environment, ATB offers budget-friendly units that maximize comfort and convenience for those beginning their independent journey.', 'To provide affordable, secure, and comfortable living spaces that support individuals and families in building a stable, convenient, and practical start in life.', 'To be a trusted apartment provider known for accessible rates, well-maintained units, and reliable service—helping more people find a comfortable home within their means.', 'Budget-friendly Units, Spacious Family Units, Secure & Maintained Facility', '#', '#', '#'),
(5, 'Biñas Travel & Leisure Resort', 'assets/images/binas_logo.png', 'BTL', 'bg-blue-500', 'Premium resort offering unforgettable travel and leisure experiences.', 'Biñas Travel & Leisure Resort is a premier vacation destination offering a perfect blend of relaxation, adventure, and world-class hospitality. Nestled in a serene environment, our resort is designed to be the ultimate getaway for families, couples, and corporate retreats.', 'To create memorable vacation experiences by providing luxurious accommodations, top-tier amenities, and heartfelt hospitality.', 'To be the destination of choice for travelers seeking unparalleled relaxation and world-class leisure facilities.', 'Luxury Accommodations, Event Hosting, Guided Tours', '#', '#', '#');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_items` int(11) NOT NULL,
  `date_taken` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','pending_approval','approved','rejected') DEFAULT 'active',
  `requirement_file` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `requested_category` varchar(50) DEFAULT NULL,
  `enrolled_category` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `requirement_file`, `avatar`, `requested_category`, `enrolled_category`, `created_at`) VALUES
(1, 'ww ww', 'jhon.emerwin05@gmail.com', '123', 'approved', 'assets/uploads/requirements/1772085846_1.pdf', NULL, 'IT', 'IT', '2026-02-26 06:03:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
