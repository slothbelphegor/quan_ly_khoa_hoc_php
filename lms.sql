-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2024 at 08:42 AM
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
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Lập trình'),
(2, 'Thiết kế'),
(3, 'Khoa học dữ liệu'),
(4, 'Kinh doanh'),
(5, 'Kỹ năng cá nhân'),
(6, 'Trí tuệ nhân tạo'),
(7, 'Âm nhạc');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `price`, `image`, `video`, `duration`, `category_id`, `deleted`) VALUES
('1', 'Lập trình Web đơn giản với HTML và CSS', 'Học cách tạo và thiết kế trang web đơn giản bằng HTML và CSS', 2000000, 'html_css.jpg', 'https://example.com/videos/html_css_intro.mp4', 8, 1, 0),
('2', 'Phát triển ứng dụng di động với React Native', 'Học cách xây dựng ứng dụng di động đa nền tảng sử dụng React Native', 3500000, 'react_native.jpg', 'https://example.com/videos/react_native_course.mp4', 12, 1, 0),
('3', 'Machine Learning cơ bản với Python', 'Học cách triển khai các mô hình machine learning đơn giản bằng Python', 4000000, 'machine_learning.jpg', 'https://example.com/videos/ml_python.mp4', 10, 1, 0),
('4', 'Thiết kế đồ họa với Adobe Illustrator', 'Học cách tạo ra các hình vẽ vector và biểu đồ bằng Adobe Illustrator', 3000000, 'illustrator.jpg', 'https://example.com/videos/illustrator_course.mp4', 10, 2, 0),
('5', 'Xây dựng trang web động với JavaScript và jQuery', 'Học cách thêm hiệu ứng động và tương tác vào trang web bằng JavaScript và jQuery', 2500000, 'javascript_jquery.jpg', 'https://example.com/videos/js_jquery_course.mp4', 8, 2, 0),
('6', 'Học biểu đồ hoá dữ liệu với Matplotlib', 'Học cách tạo ra các biểu đồ và biểu đồ tương tác bằng thư viện Matplotlib trong Python', 3000000, 'matplotlib.jpg', 'https://example.com/videos/matplotlib_course.mp4', 10, 3, 0),
('7', 'Học cơ bản về Big Data và Apache Hadoop', 'Học cách xử lý và phân tích dữ liệu lớn với Apache Hadoop', 4500000, 'hadoop.jpg', 'https://example.com/videos/hadoop_course.mp4', 12, 3, 0),
('8', 'Kỹ năng quản lý dự án hiệu quả', 'Học cách lập kế hoạch, tổ chức và quản lý dự án một cách hiệu quả', 3500000, 'project_management.jpg', 'https://example.com/videos/project_management_course.mp4', 12, 4, 0),
('9', 'Marketing kỹ thuật số: Chiến lược và Thực hiện', 'Học cách thiết kế và thực thi các chiến lược marketing kỹ thuật số hiệu quả', 4000000, 'digital_marketing.jpg', 'https://example.com/videos/digital_marketing_course.mp4', 10, 4, 0),
('10', 'Cơ bản về Kế toán và Tài chính', 'Học cách quản lý và phân tích tài chính cá nhân và doanh nghiệp', 3500000, 'accounting.jpg', 'https://example.com/videos/accounting_course.mp4', 10, 4, 0),
('11', 'Hướng dẫn sử dụng Photoshop cho người mới bắt đầu', 'Học cách sử dụng công cụ và tính năng cơ bản của Adobe Photoshop', 2500000, 'photoshop_beginner.jpg', 'https://example.com/videos/photoshop_beginner_course.mp4', 8, 2, 0),
('12', 'Giới thiệu về Hệ điều hành Linux', 'Học cách sử dụng và quản lý hệ thống với Linux', 3000000, 'linux_intro.jpg', 'https://example.com/videos/linux_intro_course.mp4', 10, 1, 0),
('13', 'Thiết kế đồ họa cho thiết bị di động', 'Học cách thiết kế giao diện người dùng đẹp và thân thiện trên thiết bị di động', 3500000, 'mobile_design.jpg', 'https://example.com/videos/mobile_design_course.mp4', 12, 2, 0),
('14', 'Học kỹ thuật chụp ảnh chân dung', 'Học cách chụp ảnh chân dung chuyên nghiệp với các kỹ thuật ánh sáng và sắp đặt', 3000000, 'portrait_photography.jpg', 'https://example.com/videos/portrait_photography_course.mp4', 10, 2, 0),
('15', 'Tổ chức sự kiện và quản lý không gian', 'Học cách tổ chức và quản lý sự kiện đa dạng từ hội thảo đến tiệc cưới', 3500000, 'event_management.jpg', 'https://example.com/videos/event_management_course.mp4', 12, 2, 0),
('16', 'Phát triển khả năng giao tiếp hiệu quả', 'Học cách nói và nghe hiệu quả, cung cấp phản hồi và xử lý xung đột', 2500000, 'communication_skills.jpg', 'https://example.com/videos/communication_skills_course.mp4', 8, 5, 0),
('17', 'Quản lý thời gian và công việc', 'Học cách sắp xếp thời gian và ưu tiên công việc một cách hiệu quả', 2000000, 'time_management.jpg', 'https://example.com/videos/time_management_course.mp4', 8, 5, 0),
('18', 'Giới thiệu về Machine Learning và Deep Learning', 'Học cách xây dựng và triển khai mô hình machine learning và deep learning', 4000000, 'machine_learning_intro.jpg', 'https://example.com/videos/ml_dl_intro_course.mp4', 10, 6, 0),
('19', 'Ứng dụng Trí tuệ nhân tạo trong kinh doanh', 'Học cách áp dụng các công nghệ AI và machine learning vào kinh doanh', 4500000, 'ai_in_business.jpg', 'https://example.com/videos/ai_business_course.mp4', 12, 6, 0),
('20', 'Học guitar cơ bản cho người mới bắt đầu', 'Học cách chơi guitar từ các khái niệm cơ bản đến các bài hát đầu tiên', 3000000, 'guitar_beginner.jpg', 'https://example.com/videos/guitar_beginner_course.mp4', 10, 7, 0),
('21', 'Hướng dẫn sử dụng phần mềm làm nhạc', 'Học cách tạo và sửa các bản nhạc với các phần mềm chỉnh sửa âm nhạc phổ biến', 3500000, 'music_production.jpg', 'https://example.com/videos/music_production_course.mp4', 12, 7, 0);

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
(6, 5, 5, 4500000, 'cancel'),
(7, 1, 1, 3000000, 'complete'),
(8, 1, 1, 3000000, 'complete'),
(9, 1, 1, 3000000, 'complete'),
(10, 1, 1, 3000000, 'complete'),
(11, 1, 1, 3000000, 'complete'),
(12, 1, 1, 3000000, 'complete'),
(13, 1, 1, 3000000, 'complete'),
(14, 1, 1, 3000000, 'complete'),
(15, 1, 1, 3000000, 'complete'),
(16, 1, 1, 3000000, 'complete'),
(17, 2, 1, 3000000, 'complete'),
(18, 2, 2, 4000000, 'complete'),
(19, 2, 3, 2000000, 'complete'),
(20, 1, 1, 3000000, 'complete'),
(21, 2, 1, 3000000, 'complete'),
(22, 2, 1, 3000000, 'complete'),
(23, 2, 1, 3000000, 'complete'),
(24, 2, 2, 4000000, 'complete'),
(25, 3, 1, 3000000, 'complete'),
(26, 3, 1, 3000000, 'complete'),
(27, 2, 3, 2000000, 'complete'),
(28, 2, 4, 3500000, 'complete'),
(29, 2, 4, 3500000, 'complete'),
(30, 2, 4, 3500000, 'complete'),
(31, 2, 4, 3500000, 'complete'),
(32, 2, 4, 3500000, 'complete'),
(33, 2, 3, 2000000, 'complete'),
(34, 2, 2, 4000000, 'complete'),
(35, 2, 2, 4000000, 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
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
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `role_id` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `address`, `password`, `is_active`, `role_id`) VALUES
(1, 'admin', 'admin@example.com', 'admin', '111 Obama Street', '$2y$10$mKVg36SL1pjGLW5gLmIk1Ou9NUMx5LGfUdjTBYlE8TFIb01QSqxki', 1, 1),
(2, 'John Doe', 'johndoe@example.com', 'user1', '123 Main Street', '$2y$10$JpeWWj4gls01f/shEHR0su2cz6ySoiiNwkEfnwrNJmPZz.N2yWakW', 1, 2),
(3, 'Jane Doe', 'janedoe@example.com', 'user2', '456 Elm Street', '$2y$10$9KGvn9zXqcWD3wRu.kFjNuDD6IV0gRZMOW5LVt4R1DJ.YZ2u.a6FS', 0, 2),
(4, 'Peter Smith', 'petersmith@example.com', '1234567890', '789 Oak Street', '$2y$10$VHFYNdT23SD2HtIUQCM.aO81xLFQNtj6n/YCfff8gaQ0A2bh2BvgW', 1, 2),
(5, 'Mary Johnson', 'maryjohnson@example.com', '0987654321', '101 Pine Street', '$2y$10$sNo9.8s2gjmO756QtZExeeFhw8ViLGb3HXuE6DwQky8js2KIg.1Sq', 1, 2),
(6, 'David Brown', 'davidbrown@example.com', '1111111111', '555 Maple Street', '$2y$10$K4xXOPhz2k8n5HqOZDUiB.HM4dEXl6yfLDO3n3nOgHiG0oTZQlUAi', 0, 2),
(7, 'Susan Williams', 'susanwilliams@example.com', '2222222222', '999 Birch Street', '$2y$10$3I9E6Faed0PmFk/TAS743O10diXCxXErdOL9OGhRkeY7LW.z7T7kK', 1, 2),
(8, 'Robert Jones', 'robertjones@example.com', '3333333333', '333 Cedar Street', '$2y$10$c5D51ywxAgcrGSHu3s0jqOCm5HNHYP6tRqhaktw0BG.nUja7tDB0O', 1, 2),
(9, 'Michael Miller', 'michaelmiller@example.com', '4444444444', '666 Oakwood Street', '$2y$10$ArNMDreqweumVTjf8Gy0s.0DS80PLoetgYZxKqcL/jlPbZjCmpqBy', 1, 2),
(10, 'Lisa Jackson', 'lisajackson@example.com', '5555555555', '888 Willow Street', '$2y$10$tE2W5P5y67e9Ae5Al4e8TOQ7VdtNUySMe2u0l8xGTZoc9.1JESQcS', 1, 2),
(11, 'Sarah Thompson', 'sarahthompson@example.com', '6666666666', '222 Park Street', '$2y$10$wWBaIGQZA1.ZGhC9JzZOue0mmvvrqwasBzHeh3rbgNuMcHlXD0tDe', 1, 2),
(12, '123', 'daylaemail@gmail.com', '123', '123', '123', 1, 2),
(13, '123', 'root@example.com', '123', '123', '$2y$10$dmjMi.MRkido/NJiN1J1n.cbyseccLLOpQJduHPSMlcRyK4OZ2tGG', 1, 2),
(15, 'Vi Du', 'email@example.com', '0123456654', 'hcmc', '$2y$10$P7LyqfSu40yZeI5b8pO3y.S8D0jVt695ZZTa.o0WtR62fINSJHyMm', 1, 2),
(17, 'test1', 'test1@example.com', '0987456321', 'test1', '$2y$10$ByEK/4EPcewKapexb0dpVeTOFmb5.x3NlSNBfcIxksa.vlbneu3pG', 1, 2),
(18, 'test2', 'test2@example.com', '0456879213', 'test2', '$2y$10$Ilyc9xG3nP50Jq1QARYYk.R8GG94li/fO8Q288fSMZFYHVLh2IpQq', 1, 2),
(19, 'test3', 'test3@example.com', 'test3', 'test3', '$2y$10$QKmhiMEv1pvxF8HjgswVo.gq4VZwfVFKnTd8O92ABKGgZNhtdC3Na', 1, 2),
(35, 'hmm', 'hmm@hmm.com', 'hmm', 'hmm', '$2y$10$XhdI2l.DvSqHm.rc78RZd.YQnQ8j.zJ3NENnmKysHTN.82ARDcQaC', 1, 2),
(38, 'admin1', 'admin@test.com', 'admin1', 'admin', '$2y$10$73oB2O97x91eVTDShZScY.k2ucFIO91RHu4LsLYywGUkmw0Bi7qHW', 1, 1),
(39, 'admin2', 'admin2@d.d', 'admin2', 'admin2', '$2y$10$HomJMcstMDNy3XfG7kOQHOOfepM3hIhTV5f0/gNEw0/PBQd.BrU2e', 1, 1),
(40, 'user1', 'user1@test.example', 'user3', 'user3', '$2y$10$wes/wa9CpHFzQOeZfhyNY.2bXIUo4NDmOjo69fNXNfUXx.1cbVEfy', 1, 2),
(41, 'user10', 'user10@gmail.com', 'user10', 'ádfasdfasdf', '$2y$10$5LSiNCk5UfYTyr5o0G1o.eFz5qS3xlrhOr9cdi5RamPJ.1.MRPdAe', 1, 2);

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
  ADD UNIQUE KEY `username` (`username`),
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
