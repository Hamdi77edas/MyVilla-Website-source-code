-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2024 at 10:22 PM
-- Server version: 8.0.36-0ubuntu0.23.10.1
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_villa`
--

-- --------------------------------------------------------

--
-- Table structure for table `adv`
--

CREATE TABLE `adv` (
  `id` int NOT NULL,
  `topic` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `adv`
--

INSERT INTO `adv` (`id`, `topic`, `img`) VALUES
(2, 'صالة ملكية للحفلات ', '1439695783_image_upload_1711583663.jpg'),
(3, 'منتجع للايجار اليومي - منطقة جبلية رائعة في الخليل', '892381553_image_upload_1711583603.png'),
(4, 'منزل للايجار في حلحول', '273382284_image_upload_1711583552.png');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sort` int NOT NULL DEFAULT '1',
  `delete_area` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `sort`, `delete_area`) VALUES
(1, 'الخليل', 1, 0),
(2, 'بيت لحم', 1, 0),
(3, 'القدس', 1, 0),
(4, 'رام الله', 1, 0),
(5, 'سلفيت', 1, 0),
(6, 'نابلس', 1, 0),
(7, 'قلقيلية', 1, 0),
(8, 'طوباس', 1, 0),
(9, 'جنين', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int NOT NULL,
  `first_name` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `family_name` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `title` text,
  `content` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `del` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_list`
--

CREATE TABLE `reservation_list` (
  `id` int UNSIGNED NOT NULL,
  `sent_datetime` datetime DEFAULT NULL,
  `villa_id` int DEFAULT NULL,
  `by_user_id` int DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `payment_status` int NOT NULL DEFAULT '0' COMMENT '0.no payment 1.payment done',
  `owner_response` int DEFAULT '0' COMMENT '0.wait 1.accept 2.reject',
  `owner_evaluation` int DEFAULT NULL COMMENT '1-5 star',
  `renter_evaluation` int DEFAULT NULL COMMENT '1-5 star',
  `del` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `reservation_list`
--

INSERT INTO `reservation_list` (`id`, `sent_datetime`, `villa_id`, `by_user_id`, `from_date`, `to_date`, `payment_status`, `owner_response`, `owner_evaluation`, `renter_evaluation`, `del`) VALUES
(4, '2024-03-24 02:07:00', 1, 1, '2024-03-26', '2024-03-28', 1, 2, 3, 2, 0),
(5, '2024-03-24 02:07:00', 2, 2, '2024-03-18', '2024-03-19', 0, 1, 2, 2, 0),
(6, '2024-03-24 02:13:00', 3, 1, '2024-03-11', '2024-04-01', 1, 2, NULL, 1, 0),
(7, '2024-03-24 02:19:00', 4, 2, '2024-04-01', '2024-04-01', 0, 0, NULL, NULL, 0),
(8, '2024-04-02 01:47:00', 1, 5, '2024-05-09', '2024-05-23', 0, 1, 3, 3, 0),
(24, '2024-04-20 23:07:00', 4, 5, '2024-04-30', '2024-04-30', 0, 0, NULL, 3, 0),
(25, '2024-04-21 12:24:00', 1, 5, '2024-04-08', '2024-04-08', 0, 1, 2, 3, 0),
(26, '2024-04-21 12:25:00', 1, 5, '2024-04-01', '2024-04-02', 0, 1, 4, 3, 0),
(27, '2024-04-21 12:26:00', 1, 5, '2024-04-09', '2024-04-26', 0, 1, 2, 2, 0),
(28, '2024-05-27 00:12:00', 1, 1, '2024-05-28', '2024-05-28', 0, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_info`
--

CREATE TABLE `site_info` (
  `id` int NOT NULL,
  `info_key` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `info_value` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `site_info`
--

INSERT INTO `site_info` (`id`, `info_key`, `info_value`) VALUES
(1, 'about', 'شركة مختصة بالتسويق لتاجير الفلل في فلسطين باقل الاسعار وافضل المساحات واعلى امكانيات\n\n\n\n\n'),
(2, 'goal', 'هدف موقع بيع وشراء يتمثل في توفير منصة إلكترونية موثوقة وموثوقة تسمح للمستخدمين بعرض منتجاتهم للبيع والشراء بطريقة سهلة وآمنة. يهدف الموقع إلى توفير تجربة تسوق مريحة وموثوقة للمشترين، بالإضافة إلى توفير فرص للبائعين لعرض منتجاتهم بشكل فعال وزيادة مبيعاتهم عبر الإنترنت.\n\n\n\n\n\n'),
(3, 'team', 'فقط نحن الشركاء في مشروع التخرج'),
(4, 'audience', 'جمهورنا جميع فئات المجتمع في بلدنا فلسطين'),
(5, 'facebook', NULL),
(6, 'telegram', NULL),
(7, 'whatsapp', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `family_name` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `img` varchar(55) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `address` text,
  `user_type` int NOT NULL DEFAULT '3' COMMENT '1.admin 2.villa_owner 3.renter',
  `is_blocked` int NOT NULL DEFAULT '0',
  `blocked_note` text,
  `del` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `family_name`, `img`, `phone`, `password`, `city_id`, `address`, `user_type`, `is_blocked`, `blocked_note`, `del`) VALUES
(1, 'خالد', 'علي', NULL, '0592222222', '2a9a1a3b4348684bc4d74a09ec19735e4049ed8fabb44a022317f287c1966296', 1, NULL, 3, 0, NULL, 0),
(2, 'حسن', 'عيسى', NULL, '0591111111', 'dc66be22af29dac5906888614d662cd6023a2e3ab7c85893d41506c0a1d6422a', 1, NULL, 2, 0, NULL, 0),
(3, 'مدير', 'مدير', '924801170_image_upload_1713697967.webp', '0599999999', '789ee6e924eedb1e7a2404a668598004fe1f3fe199c0b42803a6504072ecb84c', 1, NULL, 1, 0, NULL, 0),
(4, 'منير', 'جبر', '753918664_image_upload_1713698010.png', '0593333333', '48288fe745d35190bf83973f97e6d92473715b2aa349dc52e15bcf9dfdba56e6', 8, NULL, 2, 1, 'طلبات متكررة', 0),
(5, 'يوسف', 'نوح', NULL, '0590000000', '60bc2eb2f5898456e04ae7d9c3670be679337ea4824d03c8de4e05b623677661', 2, '', 3, 0, '', 0),
(6, '333a', 'a333', NULL, '235235235', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', 4, '', 3, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `villas`
--

CREATE TABLE `villas` (
  `id` int NOT NULL,
  `insert_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `img` varchar(50) DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `description` mediumtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `city_id` int DEFAULT NULL,
  `latitude` varchar(33) DEFAULT NULL,
  `longitude` varchar(33) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `by_user_id` int DEFAULT NULL,
  `area` int DEFAULT NULL COMMENT '1.big 2.medium 3.small',
  `del` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `villas`
--

INSERT INTO `villas` (`id`, `insert_datetime`, `title`, `img`, `video`, `price`, `description`, `city_id`, `latitude`, `longitude`, `by_user_id`, `area`, `del`) VALUES
(1, '2024-03-20 11:32:10', 'فيلا كويين', '118947827_image_upload_1711582774.jpg', '1945427516_file_upload_1713704560.webm', 2000, '4 غرف\r\n1 مطبخ\r\n2 حمامات\r\nمسبح', 8, NULL, NULL, 2, 1, 0),
(2, '2024-03-20 11:32:28', 'فيلا النجوم', '397121842_image_upload_1711583221.jpeg', NULL, 999, 'اطلالة مميزة ومبني رائع', 4, '31.53256800', '35.09982700', 2, 2, 0),
(3, '2024-03-20 11:32:37', 'قصر فلسطين الذهبي', '1037209361_image_upload_1711583326.jpg', NULL, 2000, 'يوجد ساحة كبيرة لعمل حفلة او اجتماعي كبير', 2, NULL, NULL, 4, 1, 0),
(4, '2024-03-20 11:37:27', 'فيلا وفندق النخلة', '264417790_image_upload_1711583441.jpeg', NULL, 1499, 'اجواء مميزة ومناظر طبيعية ويوجد مسبح', 1, NULL, NULL, 4, 2, 0),
(5, '2024-04-21 13:12:45', 'فندق قصر يلدز نابلس', '1251656100_image_upload_1713694365.jpeg', NULL, 900, NULL, 6, NULL, NULL, 2, 1, 0),
(6, '2024-05-01 12:18:48', 'فيلا القصر الحديث', NULL, NULL, 240, NULL, 1, NULL, NULL, 2, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adv`
--
ALTER TABLE `adv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation_list`
--
ALTER TABLE `reservation_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_from_user_id` (`by_user_id`),
  ADD KEY `fk_order_villa_id` (`villa_id`);

--
-- Indexes for table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loginname` (`phone`);

--
-- Indexes for table `villas`
--
ALTER TABLE `villas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_villa_category_id` (`city_id`),
  ADD KEY `fk_villa_by_user_id` (`by_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adv`
--
ALTER TABLE `adv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_list`
--
ALTER TABLE `reservation_list`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `villas`
--
ALTER TABLE `villas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation_list`
--
ALTER TABLE `reservation_list`
  ADD CONSTRAINT `fk_order_from_user_id` FOREIGN KEY (`by_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_order_villa_id` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id`);

--
-- Constraints for table `villas`
--
ALTER TABLE `villas`
  ADD CONSTRAINT `fk_villa_by_user_id` FOREIGN KEY (`by_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_villas_city_id` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
