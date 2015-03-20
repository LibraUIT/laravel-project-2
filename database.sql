-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 13, 2015 at 02:50 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `larproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
`id` int(10) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  `correct` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `userID` int(10) unsigned NOT NULL DEFAULT '0',
  `questionID` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `content`, `votes`, `correct`, `userID`, `questionID`, `created_at`, `updated_at`) VALUES
(3, 'Vi Laravel Framework rat hay va thu vi', 3, '0', 1, 7, '2015-01-13 00:04:09', '2015-01-18 00:33:33'),
(4, 'http://laravel.com/docs/4.2/quick', 4, '1', 1, 12, '2015-01-13 00:11:29', '2015-01-13 01:01:24'),
(6, 'hay lam ban oi', 1, '0', 1, 12, '2015-01-13 00:18:30', '2015-01-13 01:01:24'),
(7, 'Nham nhi qua che oi :))', 2, '1', 1, 11, '2015-01-13 00:39:40', '2015-01-20 06:45:59'),
(8, 'Muốn làm một website thì điều cơ bản nhất chính là HTML', 0, '1', 1, 7, '2015-01-18 00:29:25', '2015-01-18 00:33:33'),
(9, 'Tuy ban thoi :v', 1, '0', 1, 13, '2015-01-18 00:33:57', '2015-01-18 00:34:03'),
(10, 'Tất nhiên bạn phải học các sử dụng HTML rồi :3', 2, '1', 1, 15, '2015-01-18 02:40:04', '2015-01-19 00:24:39'),
(11, 'up cho len nao :v', -1, '0', 2, 16, '2015-01-18 23:10:50', '2015-01-18 23:11:32'),
(12, 'ban ngay la luon :D', 2, '1', 1, 16, '2015-01-18 23:11:25', '2015-01-20 05:04:30'),
(13, 'Nói rõ hơn đi bạn :)', 0, '0', 2, 15, '2015-01-19 00:24:33', '2015-01-19 00:24:33'),
(14, 'kiem tra comment', 0, '0', 1, 16, '2015-01-20 05:11:05', '2015-01-20 05:11:05'),
(15, 'khong biet nua hjhj', 0, '0', 1, 15, '2015-01-20 05:28:15', '2015-01-20 05:28:15'),
(16, 'de minh tim hieu thu xem', 0, '0', 1, 15, '2015-01-20 05:30:08', '2015-01-20 05:30:08'),
(17, 'hen xui hong biet nua :D', 0, '0', 2, 15, '2015-01-20 05:44:27', '2015-01-20 05:44:27'),
(18, 'khong biet nua nha thot', 0, '0', 2, 15, '2015-01-20 05:47:44', '2015-01-20 05:47:44'),
(19, 'khoi hoc chi cho met', 0, '0', 2, 13, '2015-01-20 05:48:50', '2015-01-20 05:48:50'),
(20, 'dung co hoc java', 0, '0', 2, 13, '2015-01-20 05:49:16', '2015-01-20 05:49:16'),
(21, 'test comment', 0, '0', 2, 13, '2015-01-20 05:50:42', '2015-01-20 05:50:42'),
(22, 'hoc lam gi k bik', 0, '0', 2, 13, '2015-01-20 06:10:51', '2015-01-20 06:10:51'),
(23, 'sao lam hoai k dc', 0, '0', 2, 12, '2015-01-20 06:14:17', '2015-01-20 06:14:17'),
(24, 'choi lol di ba con', -1, '0', 2, 11, '2015-01-20 06:44:33', '2015-01-20 06:46:06'),
(25, 'hoc tot co ban truoc', 0, '0', 1, 16, '2015-01-20 06:46:38', '2015-01-20 06:46:38'),
(26, 'minh cung dang tim hieu', 0, '0', 1, 14, '2015-01-22 00:53:19', '2015-01-22 00:53:19'),
(27, 'hoc tu W3C do ban', 0, '0', 1, 17, '2015-01-22 00:53:40', '2015-01-22 00:53:40'),
(28, 'lam bai tap nhieu la se quen thoi ma', 1, '0', 1, 20, '2015-01-22 00:54:50', '2015-01-22 07:13:01'),
(29, 'Hoc Zend 2 di cho mau', 0, '0', 1, 19, '2015-01-22 00:55:16', '2015-01-22 00:55:16'),
(30, 'chua co tra loi ^_^', 0, '0', 1, 21, '2015-01-26 06:17:17', '2015-01-26 06:17:17'),
(31, 'Hoc di ban rat hay la khac :))', 0, '1', 1, 23, '2015-01-27 07:19:00', '2015-03-04 22:54:12'),
(32, 'postion:fixed', 2, '1', 1, 24, '2015-01-28 20:27:18', '2015-01-29 09:17:53'),
(33, 'cai nao cung co uu diem rieng :3', 2, '1', 1, 25, '2015-01-29 19:24:51', '2015-01-29 19:29:52'),
(34, 'khong biet :))', 0, '0', 1, 22, '2015-01-29 19:35:15', '2015-01-29 19:35:15'),
(35, 'kiem tra tra loi cau hoi', 1, '1', 1, 26, '2015-01-31 08:36:07', '2015-01-31 08:36:17'),
(36, 'PHP có 3 cách khai báo : \r\nCách chính thống :\r\n<?php \r\n\r\n?>\r\nCách 2 :\r\n<?\r\n\r\n?>\r\nCách 3 khai báo như ASP\r\n<%\r\n\r\n%>\r\n', 1, '0', 2, 27, '2015-03-02 20:15:16', '2015-03-02 20:18:15'),
(37, 'Cách chính thống : < ?php ? > ( bạn bỏ khoảng trắng giữa < & ? nhé  )', 2, '1', 2, 27, '2015-03-02 20:17:33', '2015-03-02 20:18:23'),
(38, 'Hằng được khai báo 1 lần & giá trị không đổi', 1, '1', 1, 28, '2015-03-02 20:19:24', '2015-03-02 20:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'PHP Basic', '2015-01-11 04:57:24', '2015-01-11 04:57:24'),
(3, 'PHP Framework', '2015-01-11 04:58:28', '2015-01-11 04:58:28'),
(4, 'Zend Framework', '2015-01-13 21:43:09', '2015-01-14 02:53:57'),
(5, 'HTML Căn bản', '2015-01-14 06:06:56', '2015-01-27 22:14:59'),
(6, 'CSS3', '2015-01-14 06:07:53', '2015-01-14 06:31:25');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '{"admin":1}', '2015-03-01 21:03:30', '2015-03-01 21:03:30'),
(2, 'Member', '{"users":1}', '2015-03-01 21:07:30', '2015-03-01 21:07:30'),
(4, 'Moderator', '{"mod":1}', '2015-03-04 23:00:18', '2015-03-04 23:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2012_12_06_225921_migration_cartalyst_sentry_install_users', 1),
('2012_12_06_225929_migration_cartalyst_sentry_install_groups', 1),
('2012_12_06_225945_migration_cartalyst_sentry_install_users_groups_pivot', 1),
('2012_12_06_225988_migration_cartalyst_sentry_install_throttle', 1),
('2015_01_11_114747_create_categories_table', 2),
('2015_01_11_120614_create_question_table', 3),
('2015_01_11_122136_create_tags_table', 4),
('2015_01_11_122643_create_question_tagstable', 5),
('2015_01_12_062619_create_answers_table', 6),
('2015_01_18_142715_add_avatar_to_users', 7),
('2015_01_19_165928_add_status_to_users', 8),
('2015_01_28_063641_create_pdf_table', 9),
('2015_01_28_064548_create_pdf_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pdfs`
--

CREATE TABLE IF NOT EXISTS `pdfs` (
`id` int(10) unsigned NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userID` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pdfs`
--

INSERT INTO `pdfs` (`id`, `data`, `name`, `title`, `userID`, `created_at`, `updated_at`) VALUES
(8, '[{"type":"chart1","dateFrom":"Jan 27, 2015 ","dateTo":"Jan 29 , 2015"},{"type":"chart6","dateFrom":"Jan 13 , 2015 ","dateTo":"Jan 29 , 2015","cate1":"1","cate2":"4"},{"type":"chart4","dateFrom":"Jan 17 , 2015 ","dateTo":"Feb 1 , 2015"},{"type":"chart6","dateFrom":"Jan 28 , 2015 ","dateTo":"Feb 12 , 2015","cate1":"1","cate2":"5"}]', 'tailieuso1', 'Kiểm tra cập nhật báo cáo', 1, '2015-01-28 00:02:23', '2015-02-12 07:05:32'),
(9, '[{"type":"chart2","dateFrom":"Jan 13 , 2015 ","dateTo":"Jan 30 , 2015"},{"type":"chart3","dateFrom":"Jan 13 , 2015 ","dateTo":"Jan 30 , 2015"},{"type":"chart6","dateFrom":"Jan 16 , 2015 ","dateTo":"Jan 31 , 2015","cate1":"1","cate2":"5"}]', 'tailieuso2', 'Kiểm tra tạo báo cáo lần thứ hai', 1, '2015-01-28 02:38:48', '2015-01-31 19:39:16');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `viewed` int(10) unsigned NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL DEFAULT '0',
  `categorieID` int(10) unsigned NOT NULL DEFAULT '0',
  `userID` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `content`, `viewed`, `votes`, `categorieID`, `userID`, `created_at`, `updated_at`) VALUES
(7, 'Tai sao phai hoc html', 'Tai sao phai hoc html', 178, 5, 1, 1, '2015-01-11 20:00:39', '2015-03-12 18:38:58'),
(10, 'Tai sao phai hoc html truoc', 'Vì sao phải học HTML trước tiên', 5, 0, 1, 1, '2015-01-13 00:09:47', '2015-01-17 23:10:02'),
(11, 'lollllllll', 'lolfghjkljkjghjg', 8, 2, 1, 1, '2015-01-13 00:10:31', '2015-01-29 19:34:33'),
(12, 'Laravel la gi', 'Laravel la gi', 56, 2, 1, 1, '2015-01-13 00:10:58', '2015-03-07 06:31:04'),
(13, 'Co ne hoc Java khong', 'Co ne hoc Java khong', 22, 2, 1, 1, '2015-01-13 00:58:18', '2015-03-07 05:32:42'),
(14, 'Cau hoi moi ve lap trinh ', 'Cach lay ip quoc gia nhu the nao ?', 16, 1, 3, 1, '2015-01-13 20:23:30', '2015-01-25 09:25:10'),
(15, 'Muốn tạo một trang web phải làm như thế nào ?', 'Mình chưa biết gì về lập trình , vậy mình cần gì để xay dựng được một trang web vậy mọi người ?', 17, 1, 1, 1, '2015-01-17 23:12:19', '2015-01-25 22:20:47'),
(16, 'Làm thế nào để học tốt OOP trong lập trình', 'Em vừa mới học PHP được 1 tháng.\r\nLàm thế nào để học tốt OOP trong lập trình ?', 10, 1, 1, 2, '2015-01-18 23:08:15', '2015-03-02 20:23:26'),
(17, 'Hello word', 'Bắt đầu học CSS như thế nào ạ ?', 5, 0, 6, 1, '2015-01-20 22:54:34', '2015-03-07 06:11:42'),
(18, 'Có cách nào để thành thạo CSS trong thời gian ngắn không ?', 'Có cách nào để thành thạo CSS trong thời gian ngắn không  các bạn ?', 3, 0, 6, 1, '2015-01-21 22:10:38', '2015-01-30 08:39:35'),
(19, 'Có nên học Zend 1 hay không ?', 'Có nên học Zend 1 hay không ?', 8, 1, 4, 1, '2015-01-21 23:38:56', '2015-03-07 06:11:36'),
(20, 'Làm thế nào để học tốt HTML', 'Làm thế nào để học tốt HTML ?', 12, 0, 5, 2, '2015-01-21 23:40:15', '2015-03-07 04:24:21'),
(21, 'Có cách nào để nhanh thành thạo Zend 2 vậy không các bác ?', 'Có cách nào để nhanh thành thạo Zend 2 vậy không các bác ?', 10, 2, 4, 1, '2015-01-25 22:20:40', '2015-03-08 20:02:48'),
(22, 'Front-end la lam gi ?', 'Front-end la lam gi ?', 5, 1, 5, 1, '2015-01-27 05:19:41', '2015-03-08 20:05:20'),
(23, 'Co bac nao hoc Laravel chua ?', 'Co bac nao hoc Laravel chua ?', 3, 1, 3, 1, '2015-01-27 07:18:15', '2015-03-08 19:06:27'),
(24, 'Muon cho the div dung yen mot cho phai lam sao', 'Muon cho the div dung yen mot cho phai lam sao', 6, 1, 6, 1, '2015-01-28 20:27:02', '2015-03-12 18:41:30'),
(25, 'Zend va Laravel cai nao hay hon ?', 'Zend & Laravel cai nao hay hon ?', 10, 2, 3, 2, '2015-01-29 19:23:21', '2015-03-08 20:05:26'),
(26, 'Yêu em mất rồi', 'Yêu em mất rồi <3 :x', 10, 1, 1, 1, '2015-01-31 08:07:50', '2015-03-12 18:41:19'),
(27, 'PHP có mấy cách khai báo ?', 'PHP có mấy cách khai báo ?. Những cách nào được xem là chính thống và không ảnh hưởng khi các phiên bản update sau này ?.', 4, 1, 1, 4, '2015-03-02 20:12:54', '2015-03-08 20:00:34'),
(28, 'Hằng trong PHP khác gì so với biến ?', 'Hằng trong PHP khác gì so với biến ?. Nếu 1 hằng được định nghĩa 2 lần, thì liệu có bị lỗi không ?. Cho ví dụ minh họa. Hằng có thể nội suy như biến hay không ?.', 11, 1, 1, 4, '2015-03-02 20:13:28', '2015-03-12 18:39:04'),
(29, 'PHP Frame work nào sẽ là xu hướng trong năm 2015 ?', 'PHP Frame work nào sẽ là xu hướng trong năm 2015 ?', 5, 0, 3, 2, '2015-03-07 07:50:16', '2015-03-09 01:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `question_tags`
--

CREATE TABLE IF NOT EXISTS `question_tags` (
`id` int(10) unsigned NOT NULL,
  `question_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_tags`
--

INSERT INTO `question_tags` (`id`, `question_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(6, 7, 8, '2015-01-11 20:00:40', '2015-01-11 20:00:40'),
(9, 10, 8, '2015-01-13 00:09:47', '2015-01-13 00:09:47'),
(10, 13, 11, '2015-01-13 00:58:18', '2015-01-13 00:58:18'),
(11, 15, 8, '2015-01-17 23:12:19', '2015-01-17 23:12:19'),
(12, 15, 9, '2015-01-17 23:12:19', '2015-01-17 23:12:19'),
(13, 15, 12, '2015-01-17 23:12:19', '2015-01-17 23:12:19'),
(14, 15, 13, '2015-01-17 23:12:19', '2015-01-17 23:12:19'),
(15, 16, 14, '2015-01-18 23:08:15', '2015-01-18 23:08:15'),
(16, 16, 9, '2015-01-18 23:08:15', '2015-01-18 23:08:15'),
(17, 17, 13, '2015-01-20 22:54:34', '2015-01-20 22:54:34'),
(18, 17, 15, '2015-01-20 22:54:34', '2015-01-20 22:54:34'),
(19, 18, 13, '2015-01-21 22:10:38', '2015-01-21 22:10:38'),
(20, 18, 8, '2015-01-21 22:10:38', '2015-01-21 22:10:38'),
(21, 19, 16, '2015-01-21 23:38:56', '2015-01-21 23:38:56'),
(22, 19, 17, '2015-01-21 23:38:56', '2015-01-21 23:38:56'),
(23, 20, 8, '2015-01-21 23:40:15', '2015-01-21 23:40:15'),
(24, 21, 18, '2015-01-25 22:20:40', '2015-01-25 22:20:40'),
(25, 22, 8, '2015-01-27 05:19:41', '2015-01-27 05:19:41'),
(26, 23, 10, '2015-01-27 07:18:15', '2015-01-27 07:18:15'),
(27, 25, 16, '2015-01-29 19:23:21', '2015-01-29 19:23:21'),
(28, 25, 10, '2015-01-29 19:23:21', '2015-01-29 19:23:21'),
(29, 27, 9, '2015-03-02 20:12:54', '2015-03-02 20:12:54'),
(30, 28, 9, '2015-03-02 20:13:28', '2015-03-02 20:13:28'),
(31, 29, 9, '2015-03-07 07:50:16', '2015-03-07 07:50:16');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`id` int(10) unsigned NOT NULL,
  `tag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `alias`, `created_at`, `updated_at`) VALUES
(8, 'html', 'html', '2015-01-11 20:00:40', '2015-01-11 20:00:40'),
(9, 'php', 'php', '2015-01-11 20:00:54', '2015-01-11 20:00:54'),
(10, 'laravel', 'laravel', '2015-01-11 22:46:35', '2015-01-11 22:46:35'),
(11, 'java', 'java', '2015-01-13 00:58:18', '2015-01-13 00:58:18'),
(12, 'javascript', 'javascript', '2015-01-17 23:12:19', '2015-01-17 23:12:19'),
(13, 'css', 'css', '2015-01-17 23:12:19', '2015-01-17 23:12:19'),
(14, 'oop', 'oop', '2015-01-18 23:08:15', '2015-01-18 23:08:15'),
(15, 'css3', 'css3', '2015-01-20 22:54:34', '2015-01-20 22:54:34'),
(16, 'zend', 'zend', '2015-01-21 23:38:56', '2015-01-21 23:38:56'),
(17, 'zend1', 'zend1', '2015-01-21 23:38:56', '2015-01-21 23:38:56'),
(18, 'zend 2', 'zend-2', '2015-01-25 22:20:40', '2015-01-25 22:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `banned_at`) VALUES
(1, 1, '::1', 0, 0, 0, NULL, NULL, NULL),
(2, 2, '::1', 0, 0, 0, NULL, NULL, NULL),
(3, 3, '::1', 0, 0, 0, NULL, NULL, NULL),
(4, 4, '::1', 0, 0, 0, NULL, NULL, NULL),
(5, 5, '::1', 0, 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `avatar` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `created_at`, `updated_at`, `avatar`, `status`) VALUES
(1, 'minhquan4080', 'quanmn.libra@gmail.com', '$2y$10$UqvR2rcskja1SdbA5aGvC.C0iff7XfFq0Qd1K2.cBnYe6yedu0tHy', '{"admin":1}', 1, NULL, NULL, '2015-03-08 20:07:20', '$2y$10$79MnOeKlzdEq122bkdPNb.YbBMnPBJU00pgBwOPJ/BWV8wh3XgSwe', NULL, 'Minh Quân', 'Nguyễn', '2015-01-09 06:08:40', '2015-03-08 20:11:26', 'uploads/crops/1minhquan4080tumblr_nkmjevxLES1qbd81ro1_1280.jpg', 1),
(2, 'tuannguyen', 'quan.li2609@gmail.com', '$2y$10$wo./b21bC8j36NFQJgOaG.//2EqiLtA.MV2B0K2zHzasCOeKsLTWm', NULL, 1, NULL, NULL, '2015-03-07 07:49:27', '$2y$10$FNKA3t.XTAoAweZVPizWL.hoonmNFBBW0cP6ON8O.7rphKgoNi6RC', NULL, 'Tuấn', 'Nguyễn', '2015-01-09 21:05:46', '2015-03-07 07:52:51', 'uploads/crops/2tuannguyen10410188_784175485003548_4163091812040926938_n.jpg', 0),
(3, 'minhquan8080', 'minhquan84080@gmail.com', '$2y$10$NFzWaAnNUVJ8K9azmCUjo.1sU/ZJK4dvlNUANQ0QC08hK7NcFuCQW', '{"admin":1}', 0, NULL, NULL, '2015-01-22 00:04:34', '$2y$10$GZLOaVgo.w6.b2uxBFO1euA2vzsUWwKYG2/DSy3fgMy.LnG.zKLoq', NULL, 'Minh Quan', 'Nguyen', '2015-01-19 20:34:08', '2015-01-20 00:04:34', 'uploads/crops/3minhquan80801488059_672234392798321_530097663_n.jpg', 1),
(4, 'nghiale', 'nghiale@mail.com', '$2y$10$bfmpsCHspdLX3f3ub0HJvexp3TpCi.WvVEp1BMe4SAWmQ2OFAKSoy', NULL, 1, NULL, NULL, '2015-03-04 23:57:41', '$2y$10$mERWWRPhcGUV.CBXRwk72e0JMkAkUVwnSRe9r8NzMtyLVFAeiqCdC', NULL, 'Hoang Nghia', 'Le', '2015-03-01 21:28:00', '2015-03-05 00:03:29', 'uploads/default.png', 0),
(5, 'tungle', 'tungle@mail.com', '$2y$10$RnVih1LUPlL8xAA7p8KKT.oFnr5NihFQmH1LP2BXHidLnS/Yfpa9y', NULL, 1, NULL, NULL, '2015-03-01 21:34:53', '$2y$10$I7Bvar6URckcYzv/f7asg.DafXqxXR/iQG79sfZO06MCwEOUpd666', NULL, 'Le', 'Tung', '2015-03-01 21:34:53', '2015-03-01 22:05:54', 'uploads/default.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 2),
(3, 1),
(4, 4),
(5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
 ADD PRIMARY KEY (`id`), ADD KEY `answers_userid_foreign` (`userID`), ADD KEY `answers_questionid_foreign` (`questionID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `groups_name_unique` (`name`);

--
-- Indexes for table `pdfs`
--
ALTER TABLE `pdfs`
 ADD PRIMARY KEY (`id`), ADD KEY `pdfs_userid_foreign` (`userID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
 ADD PRIMARY KEY (`id`), ADD KEY `questions_userid_foreign` (`userID`), ADD KEY `questions_categorieid_foreign` (`categorieID`);

--
-- Indexes for table `question_tags`
--
ALTER TABLE `question_tags`
 ADD PRIMARY KEY (`id`), ADD KEY `question_tags_question_id_foreign` (`question_id`), ADD KEY `question_tags_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
 ADD PRIMARY KEY (`id`), ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`), ADD KEY `users_activation_code_index` (`activation_code`), ADD KEY `users_reset_password_code_index` (`reset_password_code`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
 ADD PRIMARY KEY (`user_id`,`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pdfs`
--
ALTER TABLE `pdfs`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `question_tags`
--
ALTER TABLE `question_tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
ADD CONSTRAINT `answers_questionid_foreign` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`),
ADD CONSTRAINT `answers_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `pdfs`
--
ALTER TABLE `pdfs`
ADD CONSTRAINT `pdfs_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
ADD CONSTRAINT `questions_categorieid_foreign` FOREIGN KEY (`categorieID`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `questions_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_tags`
--
ALTER TABLE `question_tags`
ADD CONSTRAINT `question_tags_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `question_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
