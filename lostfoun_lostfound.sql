-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 21, 2019 at 11:20 PM
-- Server version: 5.6.43
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lostfoun_lostfound`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`) VALUES
(2, 'กระเป๋าสะพาย'),
(3, 'กระเป๋าตังค์'),
(4, 'เครื่องเขียน'),
(5, 'โทรศัพท์'),
(6, 'โน้ตบุ๊ค'),
(7, 'เสื้อผ้า'),
(8, 'รองเท้า'),
(9, 'ยานพาหนะ'),
(10, 'เครื่องใช้ไฟฟ้า'),
(11, 'หมวดหมู่อื่นๆ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_color`
--

CREATE TABLE `tb_color` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_color`
--

INSERT INTO `tb_color` (`color_id`, `color_name`) VALUES
(1, 'ดำ'),
(3, 'ขาว'),
(4, 'เหลือง'),
(5, 'เขียว'),
(6, 'แดง'),
(7, 'ส้ม'),
(8, 'น้ำเงิน'),
(9, 'ฟ้า'),
(10, 'อื่นๆ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_comment`
--

CREATE TABLE `tb_comment` (
  `comment_id` int(11) NOT NULL,
  `comment_parent_id` int(11) DEFAULT '0',
  `comment_text` text,
  `comment_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `comment_user_id` int(11) NOT NULL,
  `comment_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_post`
--

CREATE TABLE `tb_post` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(100) DEFAULT NULL,
  `post_type` enum('lost','found') DEFAULT NULL,
  `post_description` text,
  `post_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `post_updated` datetime DEFAULT CURRENT_TIMESTAMP,
  `post_expire` datetime DEFAULT CURRENT_TIMESTAMP,
  `post_imgurl1` text,
  `post_imgurl2` text,
  `post_status` enum('Wait','OK') NOT NULL DEFAULT 'Wait',
  `post_approve` enum('Approve','Unapprove') NOT NULL DEFAULT 'Unapprove',
  `post_is_expire` int(11) NOT NULL DEFAULT '0',
  `post_user_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `post_color_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_post`
--

INSERT INTO `tb_post` (`post_id`, `post_name`, `post_type`, `post_description`, `post_created`, `post_updated`, `post_expire`, `post_imgurl1`, `post_imgurl2`, `post_status`, `post_approve`, `post_is_expire`, `post_user_id`, `post_category_id`, `post_color_id`) VALUES
(17, 'กระเป๋า', 'lost', 'สีขาวมากก', '2019-02-18 03:16:43', '2019-02-18 03:16:43', '2019-03-20 03:16:43', 'shop.png', '', 'Wait', 'Unapprove', 1, 24, 3, 3),
(18, 'กระเป๋า', 'lost', 'พบหน้าตึก', '2019-02-18 16:42:44', '2019-02-18 16:42:44', '2019-03-20 16:42:44', 'E1A96AF5-4DC7-4F3C-A4EC-DA2EEAE258C6.png', '', 'Wait', 'Unapprove', 1, 10, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_mobile` varchar(20) DEFAULT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_type` enum('Member','Admin') NOT NULL DEFAULT 'Member',
  `user_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `user_facebook_id` varchar(100) DEFAULT NULL,
  `user_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_updated` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_email`, `user_mobile`, `user_password`, `user_type`, `user_status`, `user_facebook_id`, `user_created`, `user_updated`) VALUES
(1, 'jamesphijak@hotmail.com', '0879723879', 'e9ffe1e8a0d5015e2342dbe622e453f687b4b40edc6aa1e5624f4f06f294d9ca1b725f6d31ce9d97e8323d3ee244f41a41ef36edd7f95b77f68c147fbf62bb27', 'Admin', 'Active', '2070376473019416', '2018-11-04 20:34:03', '2018-11-29 11:14:00'),
(3, 'karnsarunya@gmail.com', NULL, NULL, 'Member', 'Active', '1073405519503904', '2018-11-04 20:37:28', '2018-11-28 13:57:52'),
(4, 'bj.fortis.vitaz@hotmail.com', NULL, NULL, 'Member', 'Active', NULL, '2018-11-04 20:44:30', '2018-11-04 20:44:59'),
(5, '59011449@kmitl.ac.th', '0924018225', '074379a491a362136d1f161c441e1dc2d34ef73a34c636e5cac0f7a69afbb02aa23a788af4812b95a4aef9565b5789500048d28f715ecef132223aa95e8f912a', 'Member', 'Active', NULL, '2018-11-05 12:56:42', '2018-11-30 16:48:14'),
(6, 'step_dek_lnw@hotmail.com', '0924018225', '074379a491a362136d1f161c441e1dc2d34ef73a34c636e5cac0f7a69afbb02aa23a788af4812b95a4aef9565b5789500048d28f715ecef132223aa95e8f912a', 'Admin', 'Active', '1945148748897237', '2018-11-05 13:04:26', '2018-11-30 16:46:36'),
(7, 'pisith2541@hotmail.com', NULL, '9cd4e6c997a9db6a713948539a011ca3108b25efef9f84bb2128f14f3b1ee901d12d48c7fd3ee90354cc7269d3fdf2e27afd05b891566008622296d3a26ee611', 'Admin', 'Active', '2288868594520107', '2018-11-05 16:35:18', '2019-02-24 18:43:09'),
(8, '59010980@kmitl.ac.th', '0972345667', '848e57c6d2c09f4e0acc638a98b83ae6baf9a489e6e781242fa866c70d41c3330ad29b9ed599747ce0ecc4f93518b144d3ddb5959fd3d9070b0217e2d1cb9f24', 'Admin', 'Active', NULL, '2018-11-05 16:37:55', '2018-11-29 00:38:01'),
(10, 'dream_penpich@hotmail.com', '0956575772', '074379a491a362136d1f161c441e1dc2d34ef73a34c636e5cac0f7a69afbb02aa23a788af4812b95a4aef9565b5789500048d28f715ecef132223aa95e8f912a', 'Member', 'Active', '1872553629465841', '2018-11-07 15:42:38', '2018-11-26 18:44:24'),
(11, 'ruji-tan@hotmail.com', NULL, NULL, 'Member', 'Active', '2079284345469387', '2018-11-07 20:54:46', '2018-11-07 20:54:46'),
(12, 'pisith@otmail.com', '0999777777', 'a11abd819e9f86ae56abca4f092dcd635f3de785ed1aff8e7025a4f33da5057baed59c9527b8f3e4fa86f5f02ea5959739f9fa91975fe9cfa4ccc1cd102b2ccd', 'Member', 'Active', NULL, '2018-11-08 14:19:29', '2018-11-08 14:19:29'),
(13, 'pisith@hotmail.com', '0987765432', '5355c689a1057833cd91ac36daf3454fc345d5bd6a26c3663d1cda6996ce45e1584a823752f10d7cbcd693c3935e44e3bb203b55efc444119ab5805c559e7d2f', 'Member', 'Active', NULL, '2018-11-08 14:20:49', '2018-11-08 14:20:49'),
(14, 'nitinon556@hotmail.com', NULL, NULL, 'Member', 'Active', '1843654409016557', '2018-11-23 12:15:03', '2018-11-23 12:15:03'),
(15, 'pisith1998@hotmail.com', '0819000868', '848e57c6d2c09f4e0acc638a98b83ae6baf9a489e6e781242fa866c70d41c3330ad29b9ed599747ce0ecc4f93518b144d3ddb5959fd3d9070b0217e2d1cb9f24', 'Admin', 'Active', NULL, '2018-11-27 15:06:41', '2018-11-27 15:07:25'),
(16, 'por@hotmail.com', '0819000868', '97f78ccd80b8de8af0e98458fb4cdf32538315f04a13acaf9d4a4efe707bdf47ebd0c6976c99ef5665229f31f44cc87f3216819356c32e6127ebc572c4388fe4', 'Member', 'Active', NULL, '2018-11-27 15:10:48', '2018-11-27 21:13:06'),
(17, 'pisith.por@hotmail.com', '0819000868', '6bb4f4ae1a926882de969239d59daab757662d4b6f734f9b29d3502a99952d393b5a1ef5f320aefcb640fee76fef0040595142f196a148034e9377864349cc8b', 'Member', 'Inactive', NULL, '2018-11-28 12:28:42', '2018-11-29 13:22:04'),
(18, 'aaaaaa@ggg.com', '0811132415', '11a0f234ceadf30241c877229bf2cde92cdafe91158fab1ddfa29e1bb49d2c1a3293b3f4f62cb77f56c17689e0b3094b9db5471b34e451c1856a085966a63f33', 'Member', 'Active', NULL, '2018-11-28 14:46:26', '2018-11-28 14:46:26'),
(19, 'satit26@gmail.com', '0863592750', 'aff42acf9de44f5afc6f33f0166e2f927a1902e8e3d852ef11d2b3190f1a649f0a6ecc0263d15407b65a30c6bd14234e90b402912878f6becc3d7c4819566b0b', 'Member', 'Active', '2050563631669153', '2018-11-28 19:02:04', '2018-11-28 19:02:09'),
(20, 'rathachai.ch@kmitl.ac.th', '0123456789', 'da7a799d3c8903532d2f45d10ba3e56d013c42a845328fc76ee4738ba3322b6db17d7401fa303ae1fbecbe00561b4d0b2a05dc598b200f94c8f132be445262c4', 'Member', 'Active', NULL, '2018-11-29 13:22:21', '2018-11-29 13:22:21'),
(21, 'user@lostfound.tech', '0899999999', '0b5f2bec88ae2dad8689fbd548505da5f0276e591719cda447dd7ca0d99d915048875e5d476d20b687c5a3986c4396b59204206bb5771f353108f75bc23e85fa', 'Member', 'Active', NULL, '2018-11-30 16:40:42', '2018-11-30 16:40:42'),
(22, 'admin@lostfound.tech', '0899999999', '2b774d577a9d87a20e6abf3d5b694e5aa3004d4c45265d14d9594d58cd5622fe475c65fb351a3264765a94f2a73fad556a221a6723bb6bcc2956ba0ae3ff0337', 'Admin', 'Active', NULL, '2018-11-30 16:41:00', '2018-11-30 16:41:17'),
(23, 'twcvtslluq_1534165454@tfbnw.net', NULL, NULL, 'Member', 'Active', '10150051516699810', '2018-12-01 22:10:22', '2018-12-01 22:10:22'),
(24, 'settakarn.beam2540@hotmail.com', NULL, 'aff42acf9de44f5afc6f33f0166e2f927a1902e8e3d852ef11d2b3190f1a649f0a6ecc0263d15407b65a30c6bd14234e90b402912878f6becc3d7c4819566b0b', 'Member', 'Active', '1263384733809227', '2019-02-15 15:13:52', '2019-02-17 18:43:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_color`
--
ALTER TABLE `tb_color`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `tb_comment`
--
ALTER TABLE `tb_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tb_post`
--
ALTER TABLE `tb_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_color`
--
ALTER TABLE `tb_color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_comment`
--
ALTER TABLE `tb_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_post`
--
ALTER TABLE `tb_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
