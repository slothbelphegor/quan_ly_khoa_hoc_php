-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2024 at 03:42 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Lập trình'),
(2, 'Thiết kế');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `price`, `image`, `video`, `duration`, `category_id`) VALUES
(1, 'Lập trình Python', 'Khóa học lập trình Python từ cơ bản đến nâng cao', 3000000, 'https://example.com/images/python-course.jpg', 'https://example.com/videos/python-course.mp4', 10, 1),
(2, 'Lập trình Java', 'Khóa học lập trình Java từ cơ bản đến nâng cao', 4000000, 'https://example.com/images/java-course.jpg', 'https://example.com/videos/java-course.mp4', 15, 1),
(3, 'Thiết kế web với HTML và CSS', 'Khóa học thiết kế web cơ bản với HTML và CSS', 2000000, 'https://example.com/images/html-css-course.jpg', 'https://example.com/videos/html-css-course.mp4', 8, 2),
(4, 'Thiết kế đồ họa với Photoshop', 'Khóa học thiết kế đồ họa với Photoshop', 3500000, 'https://example.com/images/photoshop-course.jpg', 'https://example.com/videos/photoshop-course.mp4', 12, 2),
(5, 'Lập trình C++', 'Khóa học lập trình C++ từ cơ bản đến nâng cao', 4500000, 'https://example.com/images/cpp-course.jpg', 'https://example.com/videos/cpp-course.mp4', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `total_amount` float NOT NULL,
  `status` enum('pending','complete','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `course_id`, `total_amount`, `status`) VALUES
(1, 1, 1, 3000000, 'pending'),
(2, 1, 1, 3000000, 'pending'),
(3, 2, 2, 4000000, 'complete'),
(4, 3, 3, 2000000, 'pending'),
(5, 4, 4, 3500000, 'pending'),
(6, 5, 5, 4500000, 'cancel');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `role_id` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `is_active`, `role_id`) VALUES
(1, 'admin', 'admin@example.com', '0123456777', '111 Obama Street', '$2y$10$iL0qIkarMyFMSS/bolABg..hBIQzvjPqqNsNFZU.83uX7uyao9xie', 1, 1),
(2, 'John Doe', 'johndoe@example.com', '0123456789', '123 Main Street', '$2y$10$JpeWWj4gls01f/shEHR0su2cz6ySoiiNwkEfnwrNJmPZz.N2yWakW', 1, 2),
(3, 'Jane Doe', 'janedoe@example.com', '9876543210', '456 Elm Street', '$2y$10$9KGvn9zXqcWD3wRu.kFjNuDD6IV0gRZMOW5LVt4R1DJ.YZ2u.a6FS', 0, 2),
(4, 'Peter Smith', 'petersmith@example.com', '1234567890', '789 Oak Street', '$2y$10$VHFYNdT23SD2HtIUQCM.aO81xLFQNtj6n/YCfff8gaQ0A2bh2BvgW', 1, 2),
(5, 'Mary Johnson', 'maryjohnson@example.com', '0987654321', '101 Pine Street', '$2y$10$sNo9.8s2gjmO756QtZExeeFhw8ViLGb3HXuE6DwQky8js2KIg.1Sq', 1, 2),
(6, 'David Brown', 'davidbrown@example.com', '1111111111', '555 Maple Street', '$2y$10$K4xXOPhz2k8n5HqOZDUiB.HM4dEXl6yfLDO3n3nOgHiG0oTZQlUAi', 0, 2),
(7, 'Susan Williams', 'susanwilliams@example.com', '2222222222', '999 Birch Street', '$2y$10$3I9E6Faed0PmFk/TAS743O10diXCxXErdOL9OGhRkeY7LW.z7T7kK', 1, 2),
(8, 'Robert Jones', 'robertjones@example.com', '3333333333', '333 Cedar Street', '$2y$10$c5D51ywxAgcrGSHu3s0jqOCm5HNHYP6tRqhaktw0BG.nUja7tDB0O', 1, 2),
(9, 'Michael Miller', 'michaelmiller@example.com', '4444444444', '666 Oakwood Street', '$2y$10$ArNMDreqweumVTjf8Gy0s.0DS80PLoetgYZxKqcL/jlPbZjCmpqBy', 1, 2),
(10, 'Lisa Jackson', 'lisajackson@example.com', '5555555555', '888 Willow Street', '$2y$10$tE2W5P5y67e9Ae5Al4e8TOQ7VdtNUySMe2u0l8xGTZoc9.1JESQcS', 1, 2),
(11, 'Sarah Thompson', 'sarahthompson@example.com', '6666666666', '222 Park Street', '$2y$10$wWBaIGQZA1.ZGhC9JzZOue0mmvvrqwasBzHeh3rbgNuMcHlXD0tDe', 1, 2),
(12, '123', '123', '', '123', '123', 1, 2),
(13, '123', 'root@example.com', '123', '123', '$2y$10$dmjMi.MRkido/NJiN1J1n.cbyseccLLOpQJduHPSMlcRyK4OZ2tGG', 1, 2),
(15, 'Vi Du', 'email@example.com', '0123456654', 'hcmc', '$2y$10$P7LyqfSu40yZeI5b8pO3y.S8D0jVt695ZZTa.o0WtR62fINSJHyMm', 1, 2),
(17, 'test1', 'test1@example.com', '0987456321', 'test1', '$2y$10$ByEK/4EPcewKapexb0dpVeTOFmb5.x3NlSNBfcIxksa.vlbneu3pG', 1, 2),
(18, 'test2', 'test2@example.com', '0456879213', 'test2', '$2y$10$Ilyc9xG3nP50Jq1QARYYk.R8GG94li/fO8Q288fSMZFYHVLh2IpQq', 1, 2),
(19, 'test3', 'test3@example.com', 'test3', 'test3', '$2y$10$QKmhiMEv1pvxF8HjgswVo.gq4VZwfVFKnTd8O92ABKGgZNhtdC3Na', 1, 2),
(20, 'test4', 'test4@example.com', 'test4', 'test4', '$2y$10$jQFCt2eqRm6eFepa6c5aAuE5QfctVvgdi96ZYYn6mlJMGSnA.ghmS', 1, 2),
(21, 'test5', 'test5@example.com', 'test5', 'test5', '$2y$10$g725TPcaIRWNE8cuKLja4ep7m7XDfOafjepwMnpEi4Cs.au9ceK/C', 1, 2),
(32, 'test6', 'test6@example.com', 'test6', 'test6', '$2y$10$4kbujTSuo0w7KTlGeIIN2.YvDdtAQej7tPrk65EjATxi.LlA2FhOy', 1, 2),
(33, 'test7', 'test7@example.com', 'test7', 'test7', '$2y$10$WDPZCD2YZpSSWIws.fgiYeN3ooojs8pJd5eyhQWo6NWGgpfFqqJVG', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
