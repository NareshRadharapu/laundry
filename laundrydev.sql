-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2017 at 04:04 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundrydev`
--

-- --------------------------------------------------------

--
-- Table structure for table `aa_flat_notifications`
--

CREATE TABLE `aa_flat_notifications` (
  `aadn_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `addon_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`addon_id`, `name`, `image`, `price`, `description`, `status`, `updated_at`, `created_at`, `code`) VALUES
(1, 'Premium Packing', '', '5', 'Premium Packing', 1, '2016-07-21 11:31:24', '2016-07-21 11:31:24', 'PP'),
(2, 'Quick Delivery', NULL, '6', 'Quick Delivery', 1, '2016-07-21 11:31:49', '2016-07-21 11:31:49', 'QD'),
(3, 'Starch', NULL, '10', NULL, 1, '2016-07-21 11:31:57', '2016-07-21 11:31:57', 'ST'),
(4, 'Medium Starch', '', '8', '', 1, '2016-11-02 11:30:55', '2016-11-02 11:30:55', 'MS'),
(5, 'Low Starch', NULL, '6', NULL, 1, '2016-11-02 11:31:14', '2016-11-02 11:31:14', 'LS'),
(6, 'No Starch', NULL, '0', NULL, 1, '2016-11-02 11:31:43', '2016-11-02 11:31:43', 'NS');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `adType` varchar(255) DEFAULT NULL,
  `adCategory` varchar(255) DEFAULT NULL,
  `adPlan` varchar(255) DEFAULT NULL,
  `description` longtext,
  `image` longtext,
  `link` longtext,
  `views` int(11) DEFAULT NULL,
  `viewsLimit` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  `clicksLimit` int(11) DEFAULT NULL,
  `toDate` datetime DEFAULT NULL,
  `fromDate` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `adminStatus` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `apt_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `catalog_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apartment_admin_notifications`
--

CREATE TABLE `apartment_admin_notifications` (
  `aadn_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `block_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `aant_id` int(11) DEFAULT NULL,
  `message` longtext,
  `ntype` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `nfile` longtext,
  `ndate` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `subject` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apartment_an_types`
--

CREATE TABLE `apartment_an_types` (
  `aant_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `area_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `code` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `catalog_id` int(11) DEFAULT NULL,
  `isServiceTax` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `city_id`, `name`, `status`, `updated_at`, `created_at`, `code`, `address`, `landmark`, `pincode`, `mobile`, `catalog_id`, `isServiceTax`) VALUES
(1, 1, 'Miyapur', 1, '2016-08-31 14:20:25', '2016-08-31 14:20:25', 'MP', '2nd floor SMR commercial complex, Opp Srila Balaji Temple, Miyapur.', 'SMR Commercial Complex', 500049, '9014840202', 1, 1),
(2, 1, 'Manikonda', 1, '2016-09-02 10:10:37', '2016-09-02 10:10:37', 'MK', 'Flat no: 201, B.R.S Plaza, Harivillu Road.', 'Near Marrichettu', 500056, '9885698665', 1, 0),
(3, 1, 'Srinagar Colony', 1, '2016-09-03 13:28:09', '2016-09-03 13:28:09', 'SC', '17.4304467,78.4411074, Srinagar Colony Main Rd, Sri Nagar Colony, Yella Reddy Guda, Hyderabad, Telangana', 'Beside Indian Bank ATM', 500073, '7997245678', 1, 0),
(4, 1, 'Kukatpally', 1, '2016-10-13 10:31:20', '2016-10-13 10:31:20', 'KU', '1st Floor, Plot no 12A& 12B, Industrial Estate, Kukatpally, IDA Kukatpally, Kukatpally, Hyderabad, Telangana.', 'Industrial Estate', 500072, '8019945678', 1, 1),
(5, 1, 'East Maredpally', 1, '2016-10-13 10:36:06', '2016-10-13 10:36:06', 'EM', '#10-3-64 & 65/G/1, Jewel Residency, Opp Andhra bank, Teachers colony, East Maredpally, Secunderabad', 'Opp Andhra bank', 500026, '8019945678', 1, 1),
(6, 1, 'Chandanagar', 1, '2016-11-18 10:40:07', '2016-11-18 10:40:07', 'CN', 'Aparna Hill Park Lake Breeze, Hill Park Road', 'Beside Vijetha Super Market', 500050, '040 46005657', 1, 0),
(7, 1, 'Rainbow Vistas', 1, '2016-12-12 13:16:25', '2016-12-12 13:16:25', 'RW', 'Green Hills, Moosapet, Hyderabad', 'Green Hills', 500018, '7995066143', 1, 0),
(8, 1, 'Divyasree Miyapur', 1, '2016-12-16 12:03:51', '2016-12-16 12:03:51', 'DM', 'Mayuri Nagar', 'Opp. TSRTC Bus Body Unit', 500049, '7997093456', 1, 0),
(9, 1, 'Venagal rao nagar', 1, '2016-12-17 10:43:01', '2016-12-17 10:43:01', 'VR', 'Shop no - 2,22/c,\nVengal rao Nagar,', 'opp to Bhavani  primary school', 500038, '7995066146', 1, 0),
(10, 1, 'Aparna Cyber Zone', 1, '2016-12-17 10:56:13', '2016-12-17 10:56:13', 'AC', 'Aparna cyber zone', 'Nallagandla', 500019, '040-67642324', 1, 0),
(11, 1, 'Aparna Grande', 1, '2016-12-17 10:58:52', '2016-12-17 10:58:52', 'AG', 'Aparna Grande', 'Nallagandla,', 500019, '040-67485615', 1, 0),
(12, 1, 'Nizampet store', 1, '2016-12-17 11:01:43', '2016-12-17 11:01:43', 'NS', 'Shop no -10, Sai\nkrupa lake ridge\napartments,', 'Opp Siri balaji  towers', 500072, '7995066144', 1, 0),
(13, 1, 'Nizampet Pickup Point', 1, '2016-12-19 16:22:49', '2016-12-19 16:22:49', 'NP', 'Nizampet Road', 'Nizampet', 500072, '7995066145', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `block_id` int(11) NOT NULL,
  `apt_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `catalogprice`
--

CREATE TABLE `catalogprice` (
  `cp_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `itype_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cost` smallint(6) NOT NULL,
  `discount` smallint(6) NOT NULL,
  `rpoints` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catalogprice`
--

INSERT INTO `catalogprice` (`cp_id`, `catalog_id`, `item_id`, `itype_id`, `service_id`, `cost`, `discount`, `rpoints`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, 1, 8, 0, 10, 1, '2016-07-21 11:37:58', '2016-07-21 11:37:58'),
(2, 1, 2, 1, 1, 8, 0, 10, 1, '2016-07-21 11:38:19', '2016-07-21 11:38:19'),
(3, 1, 3, 1, 1, 8, 0, 10, 1, '2016-07-21 11:38:33', '2016-07-21 11:38:33'),
(4, 1, 4, 1, 1, 8, 0, 10, 1, '2016-07-21 11:38:59', '2016-07-21 11:38:59'),
(5, 1, 5, 1, 1, 16, 0, 10, 1, '2016-07-21 11:39:14', '2016-07-21 11:39:14'),
(6, 1, 6, 1, 1, 10, 0, 10, 1, '2016-07-21 11:39:26', '2016-07-21 11:39:26'),
(7, 1, 7, 1, 1, 8, 0, 10, 1, '2016-07-21 11:39:56', '2016-07-21 11:39:56'),
(8, 1, 8, 1, 1, 8, 0, 10, 1, '2016-07-21 11:40:10', '2016-07-21 11:40:10'),
(9, 1, 9, 1, 1, 60, 0, 10, 1, '2016-07-21 11:40:24', '2016-07-21 11:40:24'),
(10, 1, 10, 1, 1, 100, 0, 10, 1, '2016-07-21 11:40:53', '2016-07-21 11:40:53'),
(11, 1, 11, 1, 1, 80, 0, 10, 1, '2016-07-21 11:41:06', '2016-07-21 11:41:06'),
(12, 1, 12, 1, 1, 5, 0, 10, 1, '2016-07-21 11:41:19', '2016-07-21 11:41:19'),
(13, 1, 13, 1, 1, 10, 0, 10, 1, '2016-07-21 11:41:34', '2016-07-21 11:41:34'),
(14, 1, 15, 1, 1, 8, 0, 10, 1, '2016-07-21 11:41:45', '2016-07-21 11:41:45'),
(15, 1, 16, 1, 1, 55, 0, 10, 1, '2016-07-29 11:11:18', '2016-07-29 11:11:18'),
(16, 1, 17, 1, 1, 30, 0, 10, 1, '2016-07-29 11:11:49', '2016-07-29 11:11:49'),
(17, 1, 18, 1, 1, 8, 0, 10, 1, '2016-07-29 11:12:15', '2016-07-29 11:12:15'),
(18, 1, 19, 1, 1, 8, 0, 10, 1, '2016-07-29 11:12:38', '2016-07-29 11:12:38'),
(19, 1, 1, 1, 3, 25, 0, 10, 1, '2016-07-29 11:18:32', '2016-07-29 11:18:32'),
(20, 1, 2, 1, 3, 25, 0, 10, 1, '2016-07-29 11:19:12', '2016-07-29 11:19:12'),
(21, 1, 3, 1, 3, 25, 0, 10, 1, '2016-07-29 11:19:39', '2016-07-29 11:19:39'),
(22, 1, 4, 1, 3, 25, 0, 10, 1, '2016-07-29 11:20:27', '2016-07-29 11:20:27'),
(23, 1, 5, 1, 3, 100, 0, 10, 1, '2016-07-29 11:20:59', '2016-07-29 11:20:59'),
(24, 1, 6, 1, 3, 25, 0, 10, 1, '2016-07-29 11:21:22', '2016-07-29 11:21:22'),
(25, 1, 7, 1, 3, 15, 0, 10, 1, '2016-07-29 11:22:18', '2016-07-29 11:22:18'),
(26, 1, 8, 1, 3, 35, 0, 10, 1, '2016-07-29 11:22:41', '2016-07-29 11:22:41'),
(27, 1, 13, 1, 3, 25, 0, 10, 1, '2016-07-29 11:23:06', '2016-07-29 11:23:06'),
(28, 1, 15, 1, 3, 25, 0, 10, 1, '2016-07-29 11:23:35', '2016-07-29 11:23:35'),
(29, 1, 17, 1, 3, 80, 0, 10, 1, '2016-07-29 11:24:00', '2016-07-29 11:24:00'),
(30, 1, 18, 1, 3, 20, 0, 10, 1, '2016-07-29 11:24:24', '2016-07-29 11:24:24'),
(31, 1, 19, 1, 3, 20, 0, 10, 1, '2016-07-29 11:24:49', '2016-07-29 11:24:49'),
(32, 1, 1, 1, 4, 50, 0, 10, 1, '2016-07-29 11:27:06', '2016-07-29 11:27:06'),
(33, 1, 2, 1, 4, 50, 0, 10, 1, '2016-07-29 11:28:31', '2016-07-29 11:28:31'),
(34, 1, 3, 1, 4, 50, 0, 10, 1, '2016-07-29 11:28:52', '2016-07-29 11:28:52'),
(35, 1, 4, 1, 4, 40, 0, 10, 1, '2016-07-29 11:29:31', '2016-07-29 11:29:31'),
(36, 1, 5, 1, 4, 150, 0, 10, 1, '2016-07-29 11:30:13', '2016-07-29 11:30:13'),
(37, 1, 6, 1, 4, 60, 0, 10, 1, '2016-07-29 11:30:47', '2016-07-29 11:30:47'),
(38, 1, 7, 1, 4, 30, 0, 10, 1, '2016-07-29 11:35:26', '2016-07-29 11:35:26'),
(39, 1, 8, 1, 4, 60, 0, 10, 1, '2016-07-29 11:35:45', '2016-07-29 11:35:45'),
(40, 1, 9, 1, 4, 200, 0, 10, 1, '2016-07-29 11:36:51', '2016-07-29 11:36:51'),
(41, 1, 10, 1, 4, 300, 0, 10, 1, '2016-07-29 11:37:14', '2016-07-29 11:37:14'),
(42, 1, 11, 1, 4, 250, 0, 10, 1, '2016-07-29 11:37:51', '2016-07-29 11:37:51'),
(43, 1, 12, 1, 4, 20, 0, 10, 1, '2016-07-29 11:38:16', '2016-07-29 11:38:16'),
(44, 1, 13, 1, 4, 60, 0, 10, 1, '2016-08-01 09:24:57', '2016-08-01 09:24:57'),
(45, 1, 14, 1, 4, 100, 0, 10, 1, '2016-08-01 09:25:26', '2016-08-01 09:25:26'),
(46, 1, 15, 1, 4, 40, 0, 10, 1, '2016-08-01 09:25:53', '2016-08-01 09:25:53'),
(47, 1, 16, 1, 4, 175, 0, 10, 1, '2016-08-01 09:34:23', '2016-08-01 09:34:23'),
(48, 1, 17, 1, 4, 170, 0, 10, 1, '2016-08-01 09:34:41', '2016-08-01 09:34:41'),
(49, 1, 18, 1, 4, 40, 0, 10, 1, '2016-08-01 09:35:02', '2016-08-01 09:35:02'),
(50, 1, 19, 1, 4, 40, 0, 10, 1, '2016-08-01 09:35:27', '2016-08-01 09:35:27'),
(51, 1, 20, 2, 1, 6, 0, 10, 1, '2016-08-01 10:12:07', '2016-08-01 10:12:07'),
(52, 1, 21, 2, 1, 15, 0, 10, 1, '2016-08-01 10:12:35', '2016-08-01 10:12:35'),
(53, 1, 23, 2, 1, 10, 0, 10, 1, '2016-08-01 10:22:13', '2016-08-01 10:22:13'),
(54, 1, 25, 2, 1, 8, 0, 10, 1, '2016-08-01 10:22:42', '2016-08-01 10:22:42'),
(55, 1, 26, 2, 1, 12, 0, 10, 1, '2016-08-01 10:23:03', '2016-08-01 10:23:03'),
(56, 1, 27, 2, 1, 14, 0, 10, 1, '2016-08-01 10:23:24', '2016-08-01 10:23:24'),
(57, 1, 28, 2, 1, 10, 0, 10, 1, '2016-08-01 10:23:53', '2016-08-01 10:23:53'),
(58, 1, 29, 2, 1, 8, 0, 10, 1, '2016-08-01 10:24:18', '2016-08-01 10:24:18'),
(59, 1, 30, 2, 1, 20, 0, 10, 1, '2016-08-01 10:24:41', '2016-08-01 10:24:41'),
(60, 1, 31, 2, 1, 20, 0, 10, 1, '2016-08-01 10:25:33', '2016-08-01 10:25:33'),
(61, 1, 32, 2, 1, 25, 0, 10, 1, '2016-08-01 10:26:08', '2016-08-01 10:26:08'),
(62, 1, 35, 2, 1, 8, 0, 10, 1, '2016-08-01 10:26:34', '2016-08-01 10:26:34'),
(63, 1, 36, 2, 1, 15, 0, 10, 1, '2016-08-01 10:26:56', '2016-08-01 10:26:56'),
(64, 1, 39, 2, 1, 40, 0, 10, 1, '2016-08-01 10:27:20', '2016-08-01 10:27:20'),
(65, 1, 40, 2, 1, 35, 0, 10, 1, '2016-08-01 10:27:46', '2016-08-01 10:27:46'),
(66, 1, 42, 2, 1, 10, 0, 10, 1, '2016-08-01 10:28:09', '2016-08-01 10:28:09'),
(67, 1, 44, 2, 1, 8, 0, 10, 1, '2016-08-01 10:30:59', '2016-08-01 10:30:59'),
(68, 1, 45, 2, 1, 8, 0, 10, 1, '2016-08-01 10:31:23', '2016-08-01 10:31:23'),
(69, 1, 46, 2, 1, 8, 0, 10, 1, '2016-08-01 10:31:51', '2016-08-01 10:31:51'),
(70, 1, 47, 2, 1, 8, 0, 10, 1, '2016-08-01 10:32:09', '2016-08-01 10:32:09'),
(71, 1, 48, 2, 1, 8, 0, 10, 1, '2016-08-01 10:32:28', '2016-08-01 10:32:28'),
(72, 1, 49, 2, 1, 8, 0, 10, 1, '2016-08-01 10:34:00', '2016-08-01 10:34:00'),
(73, 1, 50, 2, 1, 10, 0, 10, 1, '2016-08-01 10:34:16', '2016-08-01 10:34:16'),
(74, 1, 51, 2, 1, 8, 0, 10, 1, '2016-08-01 10:34:38', '2016-08-01 10:34:38'),
(75, 1, 52, 2, 1, 6, 0, 10, 1, '2016-08-01 10:35:04', '2016-08-01 10:35:04'),
(76, 1, 53, 2, 1, 6, 0, 10, 1, '2016-08-01 10:35:24', '2016-08-01 10:35:24'),
(77, 1, 54, 2, 1, 6, 0, 10, 1, '2016-08-01 10:35:42', '2016-08-01 10:35:42'),
(78, 1, 55, 2, 1, 40, 0, 10, 1, '2016-08-01 10:36:14', '2016-08-01 10:36:14'),
(79, 1, 20, 2, 3, 15, 0, 10, 1, '2016-08-01 10:38:49', '2016-08-01 10:38:49'),
(80, 1, 22, 2, 3, 20, 0, 10, 1, '2016-08-01 10:51:31', '2016-08-01 10:51:31'),
(81, 1, 23, 2, 3, 25, 0, 10, 1, '2016-08-01 10:51:51', '2016-08-01 10:51:51'),
(82, 1, 25, 2, 3, 25, 0, 10, 1, '2016-08-01 10:52:16', '2016-08-01 10:52:16'),
(83, 1, 26, 2, 3, 25, 0, 10, 1, '2016-08-01 10:52:41', '2016-08-01 10:52:41'),
(84, 1, 27, 2, 3, 25, 0, 10, 1, '2016-08-01 10:53:06', '2016-08-01 10:53:06'),
(85, 1, 28, 2, 3, 20, 0, 10, 1, '2016-08-01 10:53:30', '2016-08-01 10:53:30'),
(86, 1, 29, 2, 3, 15, 0, 10, 1, '2016-08-01 10:53:50', '2016-08-01 10:53:50'),
(87, 1, 30, 2, 3, 45, 0, 10, 1, '2016-08-01 10:54:11', '2016-08-01 10:54:11'),
(88, 1, 31, 2, 3, 60, 0, 10, 1, '2016-08-01 10:54:31', '2016-08-01 10:54:31'),
(89, 1, 35, 2, 3, 15, 0, 10, 1, '2016-08-01 10:54:58', '2016-08-01 10:54:58'),
(90, 1, 40, 2, 3, 75, 0, 10, 1, '2016-08-01 10:55:16', '2016-08-01 10:55:16'),
(91, 1, 42, 2, 3, 30, 0, 10, 1, '2016-08-01 10:58:22', '2016-08-01 10:58:22'),
(92, 1, 44, 2, 3, 25, 0, 10, 1, '2016-08-01 10:59:12', '2016-08-01 10:59:12'),
(93, 1, 45, 2, 3, 20, 0, 10, 1, '2016-08-01 10:59:42', '2016-08-01 10:59:42'),
(94, 1, 46, 2, 3, 25, 0, 10, 1, '2016-08-01 11:08:39', '2016-08-01 11:08:39'),
(95, 1, 47, 2, 3, 25, 0, 10, 1, '2016-08-01 11:09:03', '2016-08-01 11:09:03'),
(96, 1, 48, 2, 3, 25, 0, 10, 1, '2016-08-01 11:09:21', '2016-08-01 11:09:21'),
(97, 1, 49, 2, 3, 30, 0, 10, 1, '2016-08-01 11:10:01', '2016-08-01 11:10:01'),
(98, 1, 50, 2, 3, 35, 0, 10, 1, '2016-08-01 11:10:17', '2016-08-01 11:10:17'),
(99, 1, 51, 2, 3, 25, 0, 10, 1, '2016-08-01 11:10:33', '2016-08-01 11:10:33'),
(100, 1, 52, 2, 3, 18, 0, 10, 1, '2016-08-01 11:10:52', '2016-08-01 11:10:52'),
(101, 1, 53, 2, 3, 15, 0, 10, 1, '2016-08-01 11:11:19', '2016-08-01 11:11:19'),
(102, 1, 54, 2, 3, 15, 0, 10, 1, '2016-08-01 11:11:36', '2016-08-01 11:11:36'),
(103, 1, 55, 2, 3, 80, 0, 10, 1, '2016-08-01 11:11:55', '2016-08-01 11:11:55'),
(104, 1, 20, 2, 4, 30, 0, 10, 1, '2016-08-01 11:12:41', '2016-08-01 11:12:41'),
(105, 1, 21, 2, 4, 40, 0, 10, 1, '2016-08-01 11:13:06', '2016-08-01 11:13:06'),
(106, 1, 22, 2, 4, 40, 0, 10, 1, '2016-08-01 11:13:33', '2016-08-01 11:13:33'),
(107, 1, 23, 2, 4, 40, 0, 10, 1, '2016-08-01 11:13:53', '2016-08-01 11:13:53'),
(108, 1, 24, 2, 4, 80, 0, 10, 1, '2016-08-01 11:14:22', '2016-08-01 11:14:22'),
(109, 1, 25, 2, 4, 40, 0, 10, 1, '2016-08-01 11:14:44', '2016-08-01 11:14:44'),
(110, 1, 26, 2, 4, 50, 0, 10, 1, '2016-08-01 11:15:17', '2016-08-01 11:15:17'),
(111, 1, 27, 2, 4, 40, 0, 10, 1, '2016-08-01 11:15:43', '2016-08-01 11:15:43'),
(112, 1, 28, 2, 4, 40, 0, 10, 1, '2016-08-01 11:16:25', '2016-08-01 11:16:25'),
(113, 1, 29, 2, 4, 30, 0, 10, 1, '2016-08-01 11:16:50', '2016-08-01 11:16:50'),
(114, 1, 30, 2, 4, 65, 0, 10, 1, '2016-08-01 11:17:10', '2016-08-01 11:17:10'),
(115, 1, 31, 2, 4, 90, 0, 10, 1, '2016-08-01 11:17:29', '2016-08-01 11:17:29'),
(116, 1, 32, 2, 4, 150, 0, 10, 1, '2016-08-01 11:17:54', '2016-08-01 11:17:54'),
(117, 1, 33, 2, 4, 50, 0, 10, 1, '2016-08-01 11:18:23', '2016-08-01 11:18:23'),
(118, 1, 34, 2, 4, 35, 0, 10, 1, '2016-08-01 11:18:43', '2016-08-01 11:18:43'),
(119, 1, 35, 2, 4, 25, 0, 10, 1, '2016-08-01 11:19:09', '2016-08-01 11:19:09'),
(120, 1, 36, 2, 4, 45, 0, 10, 1, '2016-08-01 11:19:37', '2016-08-01 11:19:37'),
(121, 1, 37, 2, 4, 225, 0, 10, 1, '2016-08-01 11:19:56', '2016-08-01 11:19:56'),
(122, 1, 38, 2, 4, 275, 0, 10, 1, '2016-08-01 11:20:20', '2016-08-01 11:20:20'),
(123, 1, 39, 2, 4, 150, 0, 10, 1, '2016-08-01 11:20:40', '2016-08-01 11:20:40'),
(124, 1, 40, 2, 4, 150, 0, 10, 1, '2016-08-01 11:21:23', '2016-08-01 11:21:23'),
(125, 1, 42, 2, 4, 80, 0, 10, 1, '2016-08-01 11:22:13', '2016-08-01 11:22:13'),
(126, 1, 43, 2, 4, 120, 0, 10, 1, '2016-08-01 11:22:55', '2016-08-01 11:22:55'),
(127, 1, 44, 2, 4, 50, 0, 10, 1, '2016-08-01 11:23:20', '2016-08-01 11:23:20'),
(128, 1, 45, 2, 4, 40, 0, 10, 1, '2016-08-01 11:24:04', '2016-08-01 11:24:04'),
(129, 1, 46, 2, 4, 50, 0, 10, 1, '2016-08-01 11:24:56', '2016-08-01 11:24:56'),
(130, 1, 47, 2, 4, 50, 0, 10, 1, '2016-08-01 11:25:17', '2016-08-01 11:25:17'),
(131, 1, 48, 2, 4, 50, 0, 10, 1, '2016-08-01 11:25:37', '2016-08-01 11:25:37'),
(132, 1, 49, 2, 4, 60, 0, 10, 1, '2016-08-01 11:26:10', '2016-08-01 11:26:10'),
(133, 1, 50, 2, 4, 75, 0, 10, 1, '2016-08-01 11:26:30', '2016-08-01 11:26:30'),
(134, 1, 51, 2, 4, 50, 0, 10, 1, '2016-08-01 11:26:56', '2016-08-01 11:26:56'),
(135, 1, 52, 2, 4, 40, 0, 10, 1, '2016-08-01 11:27:23', '2016-08-01 11:27:23'),
(136, 1, 53, 2, 4, 20, 0, 10, 1, '2016-08-01 11:27:55', '2016-08-01 11:27:55'),
(137, 1, 54, 2, 4, 30, 0, 10, 1, '2016-08-01 11:28:13', '2016-08-01 11:28:13'),
(138, 1, 55, 2, 4, 120, 0, 10, 1, '2016-08-01 11:28:39', '2016-08-01 11:28:39'),
(139, 1, 56, 2, 4, 40, 0, 10, 1, '2016-08-01 11:28:59', '2016-08-01 11:28:59'),
(140, 1, 57, 2, 4, 60, 0, 10, 1, '2016-08-01 11:29:21', '2016-08-01 11:29:21'),
(141, 1, 58, 3, 1, 5, 0, 10, 1, '2016-08-01 11:33:46', '2016-08-01 11:33:46'),
(142, 1, 59, 3, 1, 5, 0, 10, 1, '2016-08-01 11:34:17', '2016-08-01 11:34:17'),
(143, 1, 60, 3, 1, 5, 0, 10, 1, '2016-08-01 11:34:32', '2016-08-01 11:34:32'),
(144, 1, 61, 3, 1, 5, 0, 10, 1, '2016-08-01 11:34:56', '2016-08-01 11:34:56'),
(145, 1, 62, 3, 1, 5, 0, 10, 1, '2016-08-01 11:35:16', '2016-08-01 11:35:16'),
(146, 1, 63, 3, 1, 5, 0, 10, 1, '2016-08-01 11:35:34', '2016-08-01 11:35:34'),
(147, 1, 64, 3, 1, 5, 0, 10, 1, '2016-08-01 11:35:55', '2016-08-01 11:35:55'),
(148, 1, 65, 3, 1, 12, 0, 10, 1, '2016-08-01 11:36:20', '2016-08-01 11:36:20'),
(149, 1, 66, 3, 1, 10, 0, 10, 1, '2016-08-01 11:36:36', '2016-08-01 11:36:36'),
(150, 1, 67, 3, 1, 10, 0, 10, 1, '2016-08-01 11:36:55', '2016-08-01 11:36:55'),
(151, 1, 68, 3, 1, 5, 0, 10, 1, '2016-08-01 11:37:11', '2016-08-01 11:37:11'),
(152, 1, 69, 3, 1, 10, 0, 10, 1, '2016-08-01 11:37:38', '2016-08-01 11:37:38'),
(153, 1, 70, 3, 1, 10, 0, 10, 1, '2016-08-01 11:37:57', '2016-08-01 11:37:57'),
(154, 1, 58, 3, 3, 15, 0, 10, 1, '2016-08-01 11:39:10', '2016-08-01 11:39:10'),
(155, 1, 59, 3, 3, 15, 0, 10, 1, '2016-08-01 11:39:25', '2016-08-01 11:39:25'),
(156, 1, 60, 3, 3, 15, 0, 10, 1, '2016-08-01 11:39:44', '2016-08-01 11:39:44'),
(157, 1, 61, 3, 3, 20, 0, 10, 1, '2016-08-01 11:40:24', '2016-08-01 11:40:24'),
(158, 1, 62, 3, 3, 18, 0, 10, 1, '2016-08-01 11:41:12', '2016-08-01 11:41:12'),
(159, 1, 63, 3, 3, 15, 0, 10, 1, '2016-08-01 11:41:35', '2016-08-01 11:41:35'),
(160, 1, 64, 3, 3, 15, 0, 10, 1, '2016-08-01 11:41:53', '2016-08-01 11:41:53'),
(161, 1, 65, 3, 3, 15, 0, 10, 1, '2016-08-01 11:42:14', '2016-08-01 11:42:14'),
(162, 1, 66, 3, 3, 15, 0, 10, 1, '2016-08-01 11:42:41', '2016-08-01 11:42:41'),
(163, 1, 67, 3, 3, 25, 0, 10, 1, '2016-08-01 11:43:02', '2016-08-01 11:43:02'),
(164, 1, 68, 3, 3, 15, 0, 10, 1, '2016-08-01 11:43:34', '2016-08-01 11:43:34'),
(165, 1, 69, 3, 3, 15, 0, 10, 1, '2016-08-01 11:43:50', '2016-08-01 11:43:50'),
(166, 1, 70, 3, 3, 15, 0, 10, 1, '2016-08-01 11:44:08', '2016-08-01 11:44:08'),
(167, 1, 58, 3, 4, 30, 0, 10, 1, '2016-08-01 11:44:42', '2016-08-01 11:44:42'),
(168, 1, 59, 3, 4, 30, 0, 10, 1, '2016-08-01 11:45:03', '2016-08-01 11:45:03'),
(169, 1, 60, 3, 4, 30, 0, 10, 1, '2016-08-01 11:45:20', '2016-08-01 11:45:20'),
(170, 1, 61, 3, 4, 40, 0, 10, 1, '2016-08-01 11:45:36', '2016-08-01 11:45:36'),
(171, 1, 62, 3, 4, 30, 0, 10, 1, '2016-08-01 11:46:06', '2016-08-01 11:46:06'),
(172, 1, 63, 3, 4, 30, 0, 10, 1, '2016-08-01 11:46:24', '2016-08-01 11:46:24'),
(173, 1, 64, 3, 4, 30, 0, 10, 1, '2016-08-01 11:46:40', '2016-08-01 11:46:40'),
(174, 1, 65, 3, 4, 30, 0, 10, 1, '2016-08-01 11:46:56', '2016-08-01 11:46:56'),
(175, 1, 66, 3, 4, 30, 0, 10, 1, '2016-08-01 11:47:12', '2016-08-01 11:47:12'),
(176, 1, 67, 3, 4, 50, 0, 10, 1, '2016-08-01 11:47:30', '2016-08-01 11:47:30'),
(177, 1, 68, 3, 4, 30, 0, 10, 1, '2016-08-01 11:47:53', '2016-08-01 11:47:53'),
(178, 1, 69, 3, 4, 50, 0, 10, 1, '2016-08-01 11:48:07', '2016-08-01 11:48:07'),
(179, 1, 70, 3, 4, 50, 0, 10, 1, '2016-08-01 11:48:22', '2016-08-01 11:48:22'),
(180, 1, 71, 3, 4, 100, 0, 10, 1, '2016-08-01 11:48:42', '2016-08-01 11:48:42'),
(181, 1, 72, 3, 4, 150, 0, 10, 1, '2016-08-01 11:48:59', '2016-08-01 11:48:59'),
(182, 1, 73, 5, 1, 6, 0, 10, 1, '2016-08-01 11:49:35', '2016-08-01 11:49:35'),
(183, 1, 74, 5, 1, 20, 0, 10, 1, '2016-08-01 11:49:55', '2016-08-01 11:49:55'),
(184, 1, 75, 5, 1, 15, 0, 10, 1, '2016-08-01 11:50:11', '2016-08-01 11:50:11'),
(185, 1, 86, 5, 1, 6, 0, 10, 1, '2016-08-01 11:50:38', '2016-08-01 11:50:38'),
(186, 1, 90, 5, 1, 15, 0, 10, 1, '2016-08-01 11:51:13', '2016-08-01 11:51:13'),
(187, 1, 73, 5, 3, 20, 0, 10, 1, '2016-08-01 11:51:56', '2016-08-01 11:51:56'),
(188, 1, 74, 5, 3, 80, 0, 10, 1, '2016-08-01 11:52:11', '2016-08-01 11:52:11'),
(189, 1, 75, 5, 3, 60, 0, 10, 1, '2016-08-01 11:52:29', '2016-08-01 11:52:29'),
(190, 1, 79, 5, 3, 260, 0, 10, 1, '2016-08-01 11:52:55', '2016-08-01 11:52:55'),
(191, 1, 80, 5, 3, 180, 0, 10, 1, '2016-08-01 11:53:25', '2016-08-01 11:53:25'),
(192, 1, 81, 5, 3, 130, 0, 10, 1, '2016-08-01 11:53:42', '2016-08-01 11:53:42'),
(193, 1, 82, 5, 3, 110, 0, 10, 1, '2016-08-01 11:54:02', '2016-08-01 11:54:02'),
(194, 1, 84, 5, 3, 180, 0, 10, 1, '2016-08-01 11:54:26', '2016-08-01 11:54:26'),
(195, 1, 85, 5, 3, 225, 0, 10, 1, '2016-08-01 11:54:49', '2016-08-01 11:54:49'),
(196, 1, 86, 5, 3, 15, 0, 10, 1, '2016-08-01 11:55:12', '2016-08-01 11:55:12'),
(197, 1, 90, 5, 3, 25, 0, 10, 1, '2016-08-01 11:55:26', '2016-08-01 11:55:26'),
(198, 1, 73, 5, 4, 40, 0, 10, 1, '2016-08-01 11:56:00', '2016-08-01 11:56:00'),
(199, 1, 74, 5, 4, 120, 0, 10, 1, '2016-08-01 11:56:17', '2016-08-01 11:56:17'),
(200, 1, 75, 5, 4, 80, 0, 10, 1, '2016-08-01 11:56:36', '2016-08-01 11:56:36'),
(201, 1, 76, 5, 4, 150, 0, 10, 1, '2016-08-01 11:56:54', '2016-08-01 11:56:54'),
(202, 1, 77, 5, 4, 125, 0, 10, 1, '2016-08-01 11:57:14', '2016-08-01 11:57:14'),
(203, 1, 78, 5, 4, 450, 0, 10, 1, '2016-08-01 11:57:36', '2016-08-01 11:57:36'),
(204, 1, 79, 5, 4, 300, 0, 10, 1, '2016-08-01 11:58:01', '2016-08-01 11:58:01'),
(205, 1, 80, 5, 4, 200, 0, 10, 1, '2016-08-01 11:58:21', '2016-08-01 11:58:21'),
(206, 1, 81, 5, 4, 150, 0, 10, 1, '2016-08-01 11:58:42', '2016-08-01 11:58:42'),
(207, 1, 82, 5, 4, 125, 0, 10, 1, '2016-08-01 11:59:00', '2016-08-01 11:59:00'),
(208, 1, 83, 5, 4, 50, 0, 10, 1, '2016-08-01 11:59:18', '2016-08-01 11:59:18'),
(209, 1, 84, 5, 4, 200, 0, 10, 1, '2016-08-01 11:59:39', '2016-08-01 11:59:39'),
(210, 1, 85, 5, 4, 250, 0, 10, 1, '2016-08-01 11:59:58', '2016-08-01 11:59:58'),
(211, 1, 86, 5, 4, 20, 0, 10, 1, '2016-08-01 12:00:15', '2016-08-01 12:00:15'),
(212, 1, 87, 5, 4, 100, 0, 10, 1, '2016-08-01 12:00:33', '2016-08-01 12:00:33'),
(213, 1, 88, 5, 4, 140, 0, 10, 1, '2016-08-01 12:00:54', '2016-08-01 12:00:54'),
(214, 1, 89, 5, 4, 250, 0, 10, 1, '2016-08-01 12:01:10', '2016-08-01 12:01:10'),
(215, 1, 90, 5, 4, 80, 0, 10, 1, '2016-08-01 12:01:30', '2016-08-01 12:01:30'),
(216, 1, 12, 1, 3, 10, 0, 10, 1, '2016-08-22 08:58:03', '2016-08-22 08:58:03'),
(217, 1, 91, 1, 1, 10, 0, 10, 1, '2016-08-22 09:02:11', '2016-08-22 09:02:11'),
(218, 1, 91, 1, 3, 30, 0, 10, 1, '2016-08-22 09:02:34', '2016-08-22 09:02:34'),
(219, 1, 91, 1, 4, 50, 0, 10, 1, '2016-08-22 09:02:56', '2016-08-22 09:02:56'),
(220, 1, 93, 1, 1, 80, 0, 10, 1, '2016-08-22 09:07:03', '2016-08-22 09:07:03'),
(221, 1, 93, 1, 4, 250, 0, 10, 1, '2016-08-22 09:07:29', '2016-08-22 09:07:29'),
(222, 1, 41, 2, 4, 200, 0, 10, 1, '2016-08-22 09:28:14', '2016-08-22 09:28:14'),
(223, 1, 92, 2, 1, 8, 0, 10, 1, '2016-08-22 09:37:22', '2016-08-22 09:37:22'),
(224, 1, 92, 2, 3, 30, 0, 10, 1, '2016-08-22 09:37:44', '2016-08-22 09:37:44'),
(225, 1, 92, 2, 4, 50, 0, 10, 1, '2016-08-22 09:38:06', '2016-08-22 09:38:06'),
(226, 1, 83, 5, 1, 8, 0, 10, 1, '2016-08-22 10:06:31', '2016-08-22 10:06:31'),
(227, 1, 83, 5, 3, 40, 0, 10, 1, '2016-08-22 10:06:52', '2016-08-22 10:06:52'),
(228, 1, 87, 5, 3, 80, 0, 10, 1, '2016-08-22 10:08:35', '2016-08-22 10:08:35'),
(229, 1, 88, 5, 3, 125, 0, 10, 1, '2016-08-22 10:08:58', '2016-08-22 10:08:58'),
(230, 3, 1, 1, 1, 5, 0, 5, 1, '2016-09-03 13:28:36', '2016-09-03 13:28:36'),
(231, 3, 20, 2, 1, 5, 0, 5, 1, '2016-09-03 13:28:54', '2016-09-03 13:28:54'),
(232, 3, 2, 1, 3, 5, 0, 5, 1, '2016-09-03 13:29:13', '2016-09-03 13:29:13'),
(233, 3, 22, 2, 3, 10, 0, 10, 1, '2016-09-03 13:29:34', '2016-09-03 13:29:34'),
(234, 1, 94, 2, 4, 60, 0, 10, 1, '2016-10-28 15:24:23', '2016-10-28 15:24:23'),
(235, 1, 95, 1, 4, 75, 0, 10, 1, '2016-10-28 18:05:16', '2016-10-28 18:05:16'),
(236, 1, 96, 2, 4, 80, 0, 10, 1, '2016-11-29 09:38:59', '2016-11-29 09:38:59'),
(237, 1, 99, 5, 4, 500, 0, 25, 1, '2016-11-29 14:46:06', '2016-11-29 14:46:06'),
(238, 1, 98, 5, 4, 700, 0, 30, 1, '2016-11-29 14:46:33', '2016-11-29 14:46:33'),
(239, 1, 97, 5, 4, 1000, 0, 40, 1, '2016-11-29 14:46:55', '2016-11-29 14:46:55'),
(240, 1, 100, 5, 4, 1700, 0, 30, 1, '2016-12-03 13:51:45', '2016-12-03 13:51:45'),
(241, 1, 101, 5, 4, 2500, 0, 50, 1, '2016-12-03 13:52:14', '2016-12-03 13:52:14'),
(242, 1, 102, 2, 4, 175, 0, 10, 1, '2016-12-16 15:20:59', '2016-12-16 15:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `catalogs`
--

CREATE TABLE `catalogs` (
  `catalog_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catalogs`
--

INSERT INTO `catalogs` (`catalog_id`, `name`, `description`, `status`, `updated_at`, `created_at`) VALUES
(1, 'default', '', 1, '2016-07-21 11:30:56', '2016-07-21 11:30:56'),
(2, 'SMR Vinay Fountainhead', '', 1, '2016-07-21 23:20:22', '2016-07-21 23:20:22'),
(3, 'Srinagar Catalog', 'Srinagar', 1, '2016-09-03 13:27:11', '2016-09-03 13:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `cc_camera`
--

CREATE TABLE `cc_camera` (
  `cc_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `ccscript` varchar(255) DEFAULT NULL,
  `accessPrivileges` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `central_units`
--

CREATE TABLE `central_units` (
  `cu_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `address` longtext,
  `status` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `central_units`
--

INSERT INTO `central_units` (`cu_id`, `city_id`, `name`, `address`, `status`, `updated_at`, `created_at`, `code`) VALUES
(1, 1, 'Mani', 'Plot Np: 101, 1st floor, Prashanth Nagar, Kukatpally, Hyderabad', 1, '2016-08-31 00:00:00', '2016-08-31 00:00:00', 'HYD');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `name`, `status`, `updated_at`, `created_at`, `code`) VALUES
(1, 'Hyderabad', 1, '2016-07-16 17:12:41', '2016-07-16 17:12:41', 'HY'),
(2, 'Bangalore', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'BL'),
(3, 'Chennai', 1, '2016-09-02 10:09:07', '2016-09-02 10:09:07', 'CH');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `v_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `ctype` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` bigint(20) NOT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `subType` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `passwordSalt` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `ownerName` varchar(255) DEFAULT NULL,
  `ownerMobile` varchar(255) DEFAULT NULL,
  `ownerAddress` varchar(255) DEFAULT NULL,
  `ref_id` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `oauth_id` varchar(255) DEFAULT NULL,
  `rpoints` smallint(6) DEFAULT NULL,
  `firstOrder` smallint(6) DEFAULT NULL,
  `resetPassword` tinyint(1) NOT NULL,
  `showInTele` tinyint(1) NOT NULL,
  `isStaying` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dob` date DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `refundAmount` varchar(255) DEFAULT NULL,
  `os_player_id` varchar(255) DEFAULT NULL,
  `os_push_token` longtext,
  `agent_id` int(11) DEFAULT NULL,
  `package` varchar(255) DEFAULT NULL,
  `packageCode` varchar(255) DEFAULT NULL,
  `packageStatus` tinyint(1) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `packageDetails` longtext,
  `packageUsedDetails` longtext,
  `isStarch` tinyint(1) NOT NULL,
  `isProblematic` tinyint(1) NOT NULL,
  `isPerfume` tinyint(1) NOT NULL,
  `minOrderValue` varchar(255) DEFAULT NULL,
  `maxOrderValue` varchar(255) DEFAULT NULL,
  `lattitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `damageAmountTill` varchar(255) DEFAULT NULL,
  `referralAmountTill` varchar(255) DEFAULT NULL,
  `avarageProcessingDelay` int(11) DEFAULT NULL,
  `aniversaryDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `apt_id`, `block_id`, `flat_id`, `owner_id`, `area_id`, `firstname`, `lastname`, `gender`, `email`, `mobile`, `whatsapp`, `type`, `subType`, `password`, `passwordSalt`, `address`, `ownerName`, `ownerMobile`, `ownerAddress`, `ref_id`, `facebook`, `oauth_id`, `rpoints`, `firstOrder`, `resetPassword`, `showInTele`, `isStaying`, `status`, `dob`, `updated_at`, `created_at`, `wallet`, `refundAmount`, `os_player_id`, `os_push_token`, `agent_id`, `package`, `packageCode`, `packageStatus`, `package_id`, `packageDetails`, `packageUsedDetails`, `isStarch`, `isProblematic`, `isPerfume`, `minOrderValue`, `maxOrderValue`, `lattitude`, `longitude`, `damageAmountTill`, `referralAmountTill`, `avarageProcessingDelay`, `aniversaryDate`) VALUES
(1, NULL, NULL, NULL, NULL, 1, 'Naresh', 'R', NULL, 'naresh@gmail.com', 9703651416, NULL, 'user', NULL, '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, NULL, NULL, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MX0.rgj31GzZcpHVa2jdeufup398BCMmRC1ZqSHc8G36Auk', 220, 1, 0, 1, 1, 1, '2016-12-15', '2016-12-30 11:29:21', '2016-12-30 11:29:21', '0', '0', '', '', NULL, '', NULL, 0, NULL, NULL, NULL, 1, 0, 1, '18.32', '1116.38', '14.22', '55.99', NULL, NULL, NULL, '2016-12-13'),
(2, NULL, NULL, NULL, NULL, 1, 'ambadas', 'k', NULL, 'ambadaspk@gmail.com', 9701888878, NULL, 'user', NULL, '0a3e6b2c6e4c41f625579e4475cdb15e', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 1, '2016-12-31', '2017-01-02 09:40:13', '2017-01-02 09:40:13', '16.03', '0', NULL, NULL, NULL, '', NULL, 0, NULL, NULL, NULL, 0, 1, 0, '120.23', '1075.16', '75', '45', NULL, NULL, NULL, '2016-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `ca_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`ca_id`, `area_id`, `cust_id`, `address`, `landmark`, `pincode`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 1, '6-1-283/1 Baburao Colony', 'near Park', 500053, 1, '2016-12-30 11:29:21', '2016-12-30 11:29:21'),
(2, 1, 2, 'miyapur bus depot', 'bus depot', 500075, 1, '2017-01-02 09:40:13', '2017-01-02 09:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `customer_idproof`
--

CREATE TABLE `customer_idproof` (
  `cip_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `enroll` varchar(22) NOT NULL,
  `type` varchar(18) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_requests`
--

CREATE TABLE `customer_requests` (
  `cr_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `pb_id` int(11) DEFAULT NULL,
  `mobile` varchar(10) NOT NULL,
  `status` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `crdate` datetime DEFAULT NULL,
  `slot` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cu_deliver_orders`
--

CREATE TABLE `cu_deliver_orders` (
  `cudo_id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `cue_id` int(11) DEFAULT NULL,
  `cu_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `message` longtext,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `apartment_store_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cu_deliver_orders`
--

INSERT INTO `cu_deliver_orders` (`cudo_id`, `emp_id`, `cue_id`, `cu_id`, `store_id`, `order_id`, `message`, `status`, `updated_at`, `created_at`, `apartment_store_id`) VALUES
(1, NULL, 1, 1, 1, '02012017-HY-CUD-MP-6511', NULL, 'CUPA', '2017-01-02 09:39:56', '2017-01-02 09:39:56', NULL),
(2, NULL, 1, 1, 1, '03012017-HY-CUD-MP-6533', NULL, 'CUPA', '2017-01-03 10:37:35', '2017-01-03 10:37:35', NULL),
(3, NULL, 1, 1, 1, '03012017-HY-CUD-MP-7333', NULL, 'CUPA', '2017-01-03 10:40:01', '2017-01-03 10:40:01', NULL),
(4, NULL, 1, 1, 1, '04012017-HY-CUD-MP-4992', NULL, 'SADA', '2017-01-04 12:27:44', '2017-01-04 12:27:44', NULL),
(5, NULL, 1, 1, 1, '11012017-HY-CUD-MP-1911', NULL, 'CUPA', '2017-01-11 09:52:53', '2017-01-11 09:52:53', NULL),
(6, NULL, NULL, 1, 1, '11012017-HY-CUD-MP-1491', NULL, '', '2017-01-11 10:08:57', '2017-01-11 10:08:57', NULL),
(7, NULL, 1, 1, 1, '11012017-HY-CUD-MP-7064', NULL, 'SADA', '2017-01-11 10:09:36', '2017-01-11 10:09:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cu_employees`
--

CREATE TABLE `cu_employees` (
  `cue_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `cu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cu_employees`
--

INSERT INTO `cu_employees` (`cue_id`, `role_id`, `city_id`, `name`, `email`, `mobile`, `password`, `password_salt`, `status`, `updated_at`, `created_at`, `cu_id`) VALUES
(1, 3, 1, 'ravi', 'ravi@gmail.com', '9876543210', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-08-31 00:00:00', '2016-08-31 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cu_order_details`
--

CREATE TABLE `cu_order_details` (
  `cuod_id` int(11) NOT NULL,
  `cudo_id` int(11) DEFAULT NULL,
  `cuso_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `message` longtext,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cu_order_details`
--

INSERT INTO `cu_order_details` (`cuod_id`, `cudo_id`, `cuso_id`, `order_id`, `message`, `status`, `updated_at`, `created_at`) VALUES
(1, NULL, 1, 4, NULL, '0', '2017-01-02 09:36:21', '2017-01-02 09:36:21'),
(2, NULL, 1, 3, NULL, '0', '2017-01-02 09:36:21', '2017-01-02 09:36:21'),
(3, 1, NULL, 4, 'Delivered', '0', '2017-01-02 09:39:56', '2017-01-02 09:39:56'),
(4, 1, NULL, 3, 'Delivered', '0', '2017-01-02 09:39:56', '2017-01-02 09:39:56'),
(5, NULL, 2, 8, NULL, 'CPBA', '2017-01-02 09:53:20', '2017-01-02 09:53:20'),
(6, NULL, 2, 7, NULL, 'CPBA', '2017-01-02 09:53:21', '2017-01-02 09:53:21'),
(7, NULL, 2, 6, NULL, 'CPBA', '2017-01-02 09:53:21', '2017-01-02 09:53:21'),
(8, NULL, 2, 5, NULL, 'CPBA', '2017-01-02 09:53:21', '2017-01-02 09:53:21'),
(9, NULL, 3, 1000022, NULL, '0', '2017-01-03 10:34:38', '2017-01-03 10:34:38'),
(10, NULL, 3, 21, NULL, '0', '2017-01-03 10:34:39', '2017-01-03 10:34:39'),
(11, 2, NULL, 21, 'Delivered', '0', '2017-01-03 10:37:35', '2017-01-03 10:37:35'),
(12, 2, NULL, 1000022, 'Delivered', '0', '2017-01-03 10:37:35', '2017-01-03 10:37:35'),
(13, 3, NULL, 21, 'Delivered', '0', '2017-01-03 10:40:01', '2017-01-03 10:40:01'),
(14, 3, NULL, 1000022, 'Delivered', '0', '2017-01-03 10:40:01', '2017-01-03 10:40:01'),
(15, NULL, 4, 1000024, NULL, 'CPBA', '2017-01-04 12:23:23', '2017-01-04 12:23:23'),
(16, 4, NULL, 1000024, 'Delivered', '0', '2017-01-04 12:27:44', '2017-01-04 12:27:44'),
(17, NULL, 5, 1000027, NULL, 'CUAA', '2017-01-11 09:47:55', '2017-01-11 09:47:55'),
(18, NULL, NULL, 1000027, 'Delivered', '0', '2017-01-11 09:52:53', '2017-01-11 09:52:53'),
(19, NULL, NULL, 1000027, 'Delivered', '0', '2017-01-11 10:08:57', '2017-01-11 10:08:57'),
(20, 7, NULL, 1000027, 'Delivered', '0', '2017-01-11 10:09:36', '2017-01-11 10:09:36'),
(21, NULL, 6, 1000026, NULL, 'CPBA', '2017-01-18 08:26:28', '2017-01-18 08:26:28'),
(22, NULL, 6, 1000025, NULL, 'CPBA', '2017-01-18 08:26:28', '2017-01-18 08:26:28'),
(23, NULL, 7, 1000023, NULL, 'CPBA', '2017-01-18 08:59:29', '2017-01-18 08:59:29'),
(24, NULL, 7, 20, NULL, 'CPBA', '2017-01-18 08:59:29', '2017-01-18 08:59:29'),
(25, NULL, 8, 19, NULL, 'CPBA', '2017-01-18 09:02:01', '2017-01-18 09:02:01'),
(26, NULL, 9, 14, NULL, 'CPBA', '2017-01-18 09:04:52', '2017-01-18 09:04:52'),
(27, NULL, 10, 13, NULL, '0', '2017-01-18 09:21:08', '2017-01-18 09:21:08'),
(28, NULL, 11, 17, NULL, '0', '2017-01-18 09:21:53', '2017-01-18 09:21:53'),
(29, NULL, 12, 18, NULL, '0', '2017-01-18 09:23:16', '2017-01-18 09:23:16'),
(30, NULL, 13, 15, NULL, '0', '2017-01-18 09:23:58', '2017-01-18 09:23:58'),
(31, NULL, 14, 16, NULL, '0', '2017-01-18 09:40:33', '2017-01-18 09:40:33'),
(32, NULL, 15, 12, NULL, '0', '2017-01-18 09:41:04', '2017-01-18 09:41:04'),
(33, NULL, 16, 11, NULL, '0', '2017-01-18 09:55:38', '2017-01-18 09:55:38'),
(34, NULL, 17, 1000031, NULL, '0', '2017-01-18 10:33:24', '2017-01-18 10:33:24'),
(35, NULL, 17, 1000030, NULL, '0', '2017-01-18 10:33:25', '2017-01-18 10:33:25'),
(36, NULL, 18, 1000029, NULL, '0', '2017-01-18 10:33:53', '2017-01-18 10:33:53'),
(37, NULL, 18, 1000028, NULL, '0', '2017-01-18 10:33:53', '2017-01-18 10:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `cu_order_messages`
--

CREATE TABLE `cu_order_messages` (
  `cuom_id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `cue_id` int(11) DEFAULT NULL,
  `message` longtext,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cu_send_orders`
--

CREATE TABLE `cu_send_orders` (
  `cuso_id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `cue_id` int(11) DEFAULT NULL,
  `cu_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `message` longtext,
  `status` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cu_send_orders`
--

INSERT INTO `cu_send_orders` (`cuso_id`, `emp_id`, `cue_id`, `cu_id`, `store_id`, `order_id`, `message`, `status`, `updated_at`, `created_at`) VALUES
(1, 2, NULL, 1, NULL, '02012017-HY-CUS-MP-6495', NULL, '', '2017-01-02 09:36:21', '2017-01-02 09:36:21'),
(2, 2, 1, 1, NULL, '02012017-HY-CUS-MP-6012', NULL, 'CPBA', '2017-01-02 09:53:20', '2017-01-02 09:53:20'),
(3, 2, NULL, 1, NULL, '03012017-HY-CUS-MP-3321', NULL, '', '2017-01-03 10:34:38', '2017-01-03 10:34:38'),
(4, 2, 1, 1, NULL, '04012017-HY-CUS-MP-5980', NULL, 'CPBA', '2017-01-04 12:23:23', '2017-01-04 12:23:23'),
(5, 2, 1, 1, NULL, '11012017-HY-CUS-MP-8143', NULL, 'CUAA', '2017-01-11 09:47:55', '2017-01-11 09:47:55'),
(6, 2, 1, 1, NULL, '18012017-HY-CUS-MP-1238', NULL, 'CPBA', '2017-01-18 08:26:28', '2017-01-18 08:26:28'),
(7, 2, 1, 1, NULL, '18012017-HY-CUS-MP-3697', NULL, 'CPBA', '2017-01-18 08:59:29', '2017-01-18 08:59:29'),
(8, 2, 1, 1, NULL, '18012017-HY-CUS-MP-2790', NULL, 'CPBA', '2017-01-18 09:02:01', '2017-01-18 09:02:01'),
(9, 2, 1, 1, NULL, '18012017-HY-CUS-MP-2243', NULL, 'CPBA', '2017-01-18 09:04:52', '2017-01-18 09:04:52'),
(10, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-3142', NULL, '', '2017-01-18 09:21:08', '2017-01-18 09:21:08'),
(11, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-3236', NULL, '', '2017-01-18 09:21:53', '2017-01-18 09:21:53'),
(12, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-2996', NULL, '', '2017-01-18 09:23:16', '2017-01-18 09:23:16'),
(13, NULL, NULL, NULL, NULL, '18012017-HY-CUS-cbs-4167', NULL, '', '2017-01-18 09:23:58', '2017-01-18 09:23:58'),
(14, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-3994', NULL, '', '2017-01-18 09:40:33', '2017-01-18 09:40:33'),
(15, NULL, NULL, NULL, NULL, '18012017-HY-CUS-cbs-1592', NULL, '', '2017-01-18 09:41:04', '2017-01-18 09:41:04'),
(16, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-8416', NULL, '', '2017-01-18 09:55:38', '2017-01-18 09:55:38'),
(17, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-6330', NULL, '', '2017-01-18 10:33:24', '2017-01-18 10:33:24'),
(18, 2, NULL, 1, NULL, '18012017-HY-CUS-MP-4783', NULL, '', '2017-01-18 10:33:53', '2017-01-18 10:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `apt_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `role_id`, `name`, `email`, `mobile`, `password`, `password_salt`, `status`, `updated_at`, `created_at`, `area_id`, `apt_id`) VALUES
(1, 1, 'Kishore', 'kishore@gmail.com', '1234567890', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-08-21 00:00:00', '2016-08-21 00:00:00', NULL, NULL),
(2, 2, 'Naresh', 'miyapur@gmail.com', '9014840202', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-12-30 11:14:51', '2016-12-30 11:14:51', 1, NULL),
(3, 2, 'Suresh', 'manikonda@gmail.com', '1234567892', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-12-30 11:18:04', '2016-12-30 11:18:04', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `passwordSalt` varchar(255) NOT NULL,
  `oauth_id` varchar(255) DEFAULT NULL,
  `resetPassword` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flats`
--

CREATE TABLE `flats` (
  `flat_id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `intercom` varchar(255) DEFAULT NULL,
  `eusn` varchar(255) DEFAULT NULL,
  `readyToSale` tinyint(1) NOT NULL,
  `readyToOccupy` tinyint(1) NOT NULL,
  `bhk` varchar(5) DEFAULT NULL,
  `size` smallint(6) DEFAULT NULL,
  `facing` varchar(255) DEFAULT NULL,
  `salePrice` int(11) DEFAULT NULL,
  `rentPrice` int(11) DEFAULT NULL,
  `nofpplStay` smallint(6) DEFAULT NULL,
  `cntOneName` varchar(255) DEFAULT NULL,
  `cntOneMobile` varchar(255) DEFAULT NULL,
  `cntTwoName` varchar(255) DEFAULT NULL,
  `cntTwoMobile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `flat_gallery`
--

CREATE TABLE `flat_gallery` (
  `fg_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `itype_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `itype_id`, `name`, `code`, `image`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Shirt', 'SH', '1-Shirt.png', 1, '2016-07-21 11:35:09', '2016-07-21 11:35:09'),
(2, 1, 'T Shirt', 'TS', '1-T Shirt.png', 1, '2016-07-21 11:35:26', '2016-07-21 11:35:26'),
(3, 1, 'Trouser', 'Tr', '1-Trouser.png', 1, '2016-07-21 11:35:42', '2016-07-21 11:35:42'),
(4, 1, 'Shorts', 'Sh', '1-Shorts.png', 1, '2016-07-21 11:35:57', '2016-07-21 11:35:57'),
(5, 1, 'Safari Suit', 'SS', '1-Safari Suit.png', 1, '2016-07-21 11:36:23', '2016-07-21 11:36:23'),
(6, 1, 'Pyjama Heavy', 'Ph', '1-Pyjama Heavy.png', 1, '2016-07-21 11:36:40', '2016-07-21 11:36:40'),
(7, 1, 'Nightwear', 'Ng', '1-Nightwear.png', 1, '2016-07-21 11:37:19', '2016-07-21 11:37:19'),
(8, 1, 'Jeans', 'Je', '1-Jeans.png', 1, '2016-07-21 11:37:39', '2016-07-21 11:37:39'),
(9, 1, 'Sherwani', 'Sh', '1-Sherwani.png', 1, '2016-07-29 10:00:26', '2016-07-29 10:00:26'),
(10, 1, 'Suit 3 Pcs', 'Su', '1-Suit 3 Pcs.png', 1, '2016-07-29 10:58:51', '2016-07-29 10:58:51'),
(11, 1, 'Suit 2 Pcs', 'Su2', '1-Suit 2 Pcs.png', 1, '2016-07-29 10:59:13', '2016-07-29 10:59:13'),
(12, 1, 'Tie', 'Ti', '1-Tie.png', 1, '2016-07-29 10:59:34', '2016-07-29 10:59:34'),
(13, 1, 'Kurta Normal', 'Kn', '1-Kurta Normal.png', 1, '2016-07-29 10:59:52', '2016-07-29 10:59:52'),
(14, 1, 'Kurta Heavy', 'Kh', '1-Kurta Heavy.png', 1, '2016-07-29 11:00:11', '2016-07-29 11:00:11'),
(15, 1, 'Pyjama Normal', 'Pn', '1-Pyjama Normal.png', 1, '2016-07-29 11:00:30', '2016-07-29 11:00:30'),
(16, 1, 'Blazer', 'Bl', '1-Blazer.png', 1, '2016-07-29 11:00:47', '2016-07-29 11:00:47'),
(17, 1, 'Jacket', 'Jc', '1-Jacket.png', 1, '2016-07-29 11:01:11', '2016-07-29 11:01:11'),
(18, 1, 'Dhoti', 'Dh', '1-Dhoti.png', 1, '2016-07-29 11:01:29', '2016-07-29 11:01:29'),
(19, 1, 'Lalchi Cotton', 'Lc', '1-Lalchi Cotton.png', 1, '2016-07-29 11:01:56', '2016-07-29 11:01:56'),
(20, 2, 'Dupatta Normal', 'DUPN', '2-Dupatta Normal.png', 1, '2016-08-01 09:33:27', '2016-08-01 09:33:27'),
(21, 2, 'Dupatta Heavy', 'DUPH', '2-Dupatta Heavy.png', 1, '2016-08-01 09:34:00', '2016-08-01 09:34:00'),
(22, 2, 'Scarf', 'Sca', '2-Scarf.png', 1, '2016-08-01 09:34:20', '2016-08-01 09:34:20'),
(23, 2, 'Kameez Normal', 'KA', '2-Kameez Normal.png', 1, '2016-08-01 09:34:45', '2016-08-01 09:34:45'),
(24, 2, 'kameez Heavy', 'KAH', '2-kameez Heavy.png', 1, '2016-08-01 09:35:13', '2016-08-01 09:35:13'),
(25, 2, 'Pyjama', 'PYJ', '2-Pyjama.png', 1, '2016-08-01 09:35:56', '2016-08-01 09:35:56'),
(26, 2, 'Pyjama Heavy Or Silk', 'PYJS', '2-Pyjama Heavy Or Silk.png', 1, '2016-08-01 09:36:13', '2016-08-01 09:36:13'),
(27, 2, 'Salwar', 'SAL', '2-Salwar.png', 1, '2016-08-01 09:36:26', '2016-08-01 09:36:26'),
(28, 2, 'Shawl', 'SHA', '2-Shawl.png', 1, '2016-08-01 09:36:40', '2016-08-01 09:36:40'),
(29, 2, 'Nightwear Per Piece', 'NWPP', '2-Nightwear Per Piece.png', 1, '2016-08-01 09:37:00', '2016-08-01 09:37:00'),
(30, 2, 'Saree Cotton', 'SA', '2-Saree Cotton.png', 1, '2016-08-01 09:37:36', '2016-08-01 09:37:36'),
(31, 2, 'Saree Silk', 'SSI', '2-Saree Silk.png', 1, '2016-08-01 09:39:26', '2016-08-01 09:39:26'),
(32, 2, 'Saree Heavy Or Designer', 'SAH', '2-Saree Heavy Or Designer.png', 1, '2016-08-01 09:39:42', '2016-08-01 09:39:42'),
(33, 2, 'Saree Polishing', 'SAP', '2-Saree Polishing.png', 1, '2016-08-01 09:40:20', '2016-08-01 09:40:20'),
(34, 2, 'Saree Rolling', 'SR', '2-Saree Rolling.png', 1, '2016-08-01 09:40:53', '2016-08-01 09:40:53'),
(35, 2, 'Blouse Normal', 'BLN', '2-Blouse Normal.png', 1, '2016-08-01 09:41:04', '2016-08-01 09:41:04'),
(36, 2, 'Blouse Heavy', 'BH', '2-Blouse Heavy.png', 1, '2016-08-01 09:41:18', '2016-08-01 09:41:18'),
(37, 2, 'Ghagra Normal', 'GHN', '2-Ghagra Normal.png', 1, '2016-08-01 09:41:37', '2016-08-01 09:41:37'),
(38, 2, 'Ghagra Heavy', 'GHH', '2-Ghagra Heavy.png', 1, '2016-08-01 09:41:50', '2016-08-01 09:41:50'),
(39, 2, 'Lehnga', 'L', '2-Lehnga.png', 1, '2016-08-01 09:42:05', '2016-08-01 09:42:05'),
(40, 2, 'Long Dress Normal', 'DL', '2-Long Dress Normal.png', 1, '2016-08-01 09:42:19', '2016-08-01 09:42:19'),
(41, 2, 'Long Dress Heavy', 'LDH', '2-Long Dress Heavy.png', 1, '2016-08-01 09:42:32', '2016-08-01 09:42:32'),
(42, 2, 'Frock Normal', 'FN', '2-Frock Normal.png', 1, '2016-08-01 09:42:46', '2016-08-01 09:42:46'),
(43, 2, 'Frock Heavy', 'FHY', '2-Frock Heavy.png', 1, '2016-08-01 09:43:03', '2016-08-01 09:43:03'),
(44, 2, 'Shirt', 'Shi', '2-Shirt.png', 1, '2016-08-01 09:43:27', '2016-08-01 09:43:27'),
(45, 2, 'Shorts', 'SHW', '2-Shorts.png', 1, '2016-08-01 09:43:42', '2016-08-01 09:43:42'),
(46, 2, 'Skirt', 'SKI', '2-Skirt.png', 1, '2016-08-01 09:43:57', '2016-08-01 09:43:57'),
(47, 2, 'T Shirt', 'T', '2-T Shirt.png', 1, '2016-08-01 09:44:13', '2016-08-01 09:44:13'),
(48, 2, 'Trouser', 'TW', '2-Trouser.png', 1, '2016-08-01 09:44:27', '2016-08-01 09:44:27'),
(49, 2, 'Jeans', 'JeF', '2-Jeans.png', 1, '2016-08-01 09:44:42', '2016-08-01 09:44:42'),
(50, 2, 'Sweater', 'SW', '2-Sweater.png', 1, '2016-08-01 09:44:57', '2016-08-01 09:44:57'),
(51, 2, 'Waist Coat', 'WCT', '2-Waist Coat.png', 1, '2016-08-01 09:45:10', '2016-08-01 09:45:10'),
(52, 2, 'Pants', 'PF', '2-Pants.png', 1, '2016-08-01 09:45:25', '2016-08-01 09:45:25'),
(53, 2, 'Kurti', 'KUR', '2-Kurti.png', 1, '2016-08-01 09:45:39', '2016-08-01 09:45:39'),
(54, 2, 'Leggings', 'LEG', '2-Leggings.png', 1, '2016-08-01 09:45:55', '2016-08-01 09:45:55'),
(55, 2, 'Jacket', 'JCKW', '2-Jacket.png', 1, '2016-08-01 09:46:07', '2016-08-01 09:46:07'),
(56, 2, 'Party Top', 'Ptop', '2-Party Top.png', 1, '2016-08-01 09:46:26', '2016-08-01 09:46:26'),
(57, 2, 'Saree Rolling Iron and Roll', 'SRIR', '2-Saree Rolling Iron and Roll.png', 1, '2016-08-01 09:46:48', '2016-08-01 09:46:48'),
(58, 3, 'Shirt', 'SK', '3-Shirt.png', 1, '2016-08-01 09:48:05', '2016-08-01 09:48:05'),
(59, 3, 'T Shirt', 'TK', '3-T Shirt.png', 1, '2016-08-01 09:48:23', '2016-08-01 09:48:23'),
(60, 3, 'Trouser', 'PK', '3-Trouser.png', 1, '2016-08-01 09:49:21', '2016-08-01 09:49:21'),
(61, 3, 'Jeans', 'JeK', '3-Jeans.png', 1, '2016-08-01 09:49:37', '2016-08-01 09:49:37'),
(62, 3, 'Skirt', 'SHKT', '3-Skirt.png', 1, '2016-08-01 09:49:55', '2016-08-01 09:49:55'),
(63, 3, 'Shorts', 'SHK', '3-Shorts.png', 1, '2016-08-01 09:50:11', '2016-08-01 09:50:11'),
(64, 3, 'Schooluniform Per Piece', 'PSK', '3-Schooluniform Per Piece.png', 1, '2016-08-01 09:50:25', '2016-08-01 09:50:25'),
(65, 3, 'Pyjama', 'PY', '3-Pyjama.png', 1, '2016-08-01 09:50:40', '2016-08-01 09:50:40'),
(66, 3, 'Salwar', 'SLW', '3-Salwar.png', 1, '2016-08-01 09:50:55', '2016-08-01 09:50:55'),
(67, 3, 'Frock', 'DRL', '3-Frock.png', 1, '2016-08-01 09:51:13', '2016-08-01 09:51:13'),
(68, 3, 'Nightwear Perpiece', 'NPP', '3-Nightwear Perpiece.png', 1, '2016-08-01 09:51:32', '2016-08-01 09:51:32'),
(69, 3, 'Kids Tops', 'KT', '3-Kids Tops.png', 1, '2016-08-01 09:51:45', '2016-08-01 09:51:45'),
(70, 3, 'Kids Lowers', 'KL', '3-Kids Lowers.png', 1, '2016-08-01 09:52:01', '2016-08-01 09:52:01'),
(71, 3, 'Kids Mat Single', 'KDMS', '3-Kids Mat Single.png', 1, '2016-08-01 09:52:19', '2016-08-01 09:52:19'),
(72, 3, 'Kids Mat Double', 'KDMD', '3-Kids Mat Double.png', 1, '2016-08-01 09:52:33', '2016-08-01 09:52:33'),
(73, 5, 'Bath Towel', 'TO', '5-Bath Towel.png', 1, '2016-08-01 09:52:58', '2016-08-01 09:52:58'),
(74, 5, 'Bed Sheet Double', 'BSDD', '5-Bed Sheet Double.png', 1, '2016-08-01 09:53:12', '2016-08-01 09:53:12'),
(75, 5, 'Bed Sheet Single', 'BSS', '5-Bed Sheet Single.png', 1, '2016-08-01 09:53:26', '2016-08-01 09:53:26'),
(76, 5, 'Blanket Double', 'BD', '5-Blanket Double.png', 1, '2016-08-01 09:53:39', '2016-08-01 09:53:39'),
(77, 5, 'Blanket Single', 'BS', '5-Blanket Single.png', 1, '2016-08-01 09:53:56', '2016-08-01 09:53:56'),
(78, 5, 'Curtain HPlus', 'CURT', '5-Curtain HPlus.png', 1, '2016-08-01 09:54:14', '2016-08-01 09:54:14'),
(79, 5, 'Curtain H', 'Cur', '5-Curtain H.png', 1, '2016-08-01 09:54:29', '2016-08-01 09:54:29'),
(80, 5, 'Curtain L', 'CUL', '5-Curtain L.png', 1, '2016-08-01 09:54:53', '2016-08-01 09:54:53'),
(81, 5, 'Curtain M', 'CUM', '5-Curtain M.png', 1, '2016-08-01 09:55:11', '2016-08-01 09:55:11'),
(82, 5, 'Curtain S', 'CUS', '5-Curtain S.png', 1, '2016-08-01 09:55:27', '2016-08-01 09:55:27'),
(83, 5, 'Cushion Covers', 'CUC', '5-Cushion Covers.png', 1, '2016-08-01 09:55:43', '2016-08-01 09:55:43'),
(84, 5, 'Duvet Or Quilt S', 'DU', '5-Duvet Or Quilt S.png', 1, '2016-08-01 09:56:01', '2016-08-01 09:56:01'),
(85, 5, 'Duvet Or Quilt D', 'DUV', '5-Duvet Or Quilt D.png', 1, '2016-08-01 09:56:18', '2016-08-01 09:56:18'),
(86, 5, 'Pillow Cover', 'Pco', '5-Pillow Cover.png', 1, '2016-08-01 09:56:36', '2016-08-01 09:56:36'),
(87, 5, 'Sofa Cover Normal', 'CHC', '5-Sofa Cover Normal.png', 1, '2016-08-01 09:56:49', '2016-08-01 09:56:49'),
(88, 5, 'Sofa Cover Heavy', 'SCHE', '5-Sofa Cover Heavy.png', 1, '2016-08-01 09:57:06', '2016-08-01 09:57:06'),
(89, 5, 'Soft Toy', 'ST', '5-Soft Toy.png', 1, '2016-08-01 09:57:19', '2016-08-01 09:57:19'),
(90, 5, 'Table Cloth', 'TCH', '5-Table Cloth.png', 1, '2016-08-01 09:57:36', '2016-08-01 09:57:36'),
(91, 1, 'Lab Coat', 'LAC', '1-Lab Coat.png', 1, '2016-08-22 09:00:50', '2016-08-22 09:00:50'),
(92, 2, 'Lab Coat', 'LAC', '1-Lab Coat.png', 1, '2016-08-22 09:01:36', '2016-08-22 09:01:36'),
(93, 1, 'Sherwani 2 Pcs', 'Sh2', '1-Sherwani 2 Pcs.png', 1, '2016-08-22 09:06:33', '2016-08-22 09:06:33'),
(94, 2, 'Saree Rolling Silk', 'SRS', '2-Saree Rolling Silk.png', 1, '2016-10-28 15:23:37', '2016-10-28 15:23:37'),
(95, 1, 'Sweater', 'SWM', '1-Sweater.png', 1, '2016-10-28 18:04:33', '2016-10-28 18:04:33'),
(96, 2, 'Kameez Heavy', 'KZH', '2-Kameez Heavy.png', 1, '2016-11-29 09:36:00', '2016-11-29 09:36:00'),
(97, 5, 'Carpet Large', 'CL', '5-Carpet Large.png', 1, '2016-11-29 14:44:48', '2016-11-29 14:44:48'),
(98, 5, 'Carpet Medium', 'CM', '5-Carpet Medium.png', 1, '2016-11-29 14:45:16', '2016-11-29 14:45:16'),
(99, 5, 'Carpet Small', 'CS', '5-Carpet Small.png', 1, '2016-11-29 14:45:29', '2016-11-29 14:45:29'),
(100, 5, 'Carpet XL', 'CXL', '5-Carpet XL.png', 1, '2016-12-03 13:49:18', '2016-12-03 13:49:18'),
(101, 5, 'Carpet XXL', 'CXX', '5-Carpet XXL.png', 1, '2016-12-03 13:50:11', '2016-12-03 13:50:11'),
(102, 2, 'Blazer', 'BW', '2-Blazer.png', 1, '2016-12-16 15:19:37', '2016-12-16 15:19:37');

-- --------------------------------------------------------

--
-- Table structure for table `item_services`
--

CREATE TABLE `item_services` (
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_services`
--

INSERT INTO `item_services` (`item_id`, `service_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(19, 1),
(19, 3),
(19, 4),
(20, 1),
(20, 3),
(20, 4),
(21, 1),
(21, 3),
(21, 4),
(22, 1),
(22, 3),
(22, 4),
(23, 1),
(23, 3),
(23, 4),
(24, 1),
(24, 3),
(24, 4),
(25, 1),
(25, 3),
(25, 4),
(26, 1),
(26, 3),
(26, 4),
(27, 1),
(27, 3),
(27, 4),
(28, 1),
(28, 3),
(28, 4),
(29, 1),
(29, 3),
(29, 4),
(30, 1),
(30, 3),
(30, 4),
(31, 1),
(31, 3),
(31, 4),
(32, 1),
(32, 3),
(32, 4),
(33, 1),
(33, 3),
(33, 4),
(34, 1),
(34, 3),
(34, 4),
(35, 1),
(35, 3),
(35, 4),
(36, 1),
(36, 3),
(36, 4),
(37, 1),
(37, 3),
(37, 4),
(38, 1),
(38, 3),
(38, 4),
(39, 1),
(39, 3),
(39, 4),
(40, 1),
(40, 3),
(40, 4),
(41, 1),
(41, 3),
(41, 4),
(42, 1),
(42, 3),
(42, 4),
(43, 1),
(43, 3),
(43, 4),
(44, 1),
(44, 3),
(44, 4),
(45, 1),
(45, 3),
(45, 4),
(46, 1),
(46, 3),
(46, 4),
(47, 1),
(47, 3),
(47, 4),
(48, 1),
(48, 3),
(48, 4),
(49, 1),
(49, 3),
(49, 4),
(50, 1),
(50, 3),
(50, 4),
(51, 1),
(51, 3),
(51, 4),
(52, 1),
(52, 3),
(52, 4),
(53, 1),
(53, 3),
(53, 4),
(54, 1),
(54, 3),
(54, 4),
(55, 1),
(55, 3),
(55, 4),
(56, 1),
(56, 3),
(56, 4),
(57, 1),
(57, 3),
(57, 4),
(58, 1),
(58, 3),
(58, 4),
(59, 1),
(59, 3),
(59, 4),
(60, 1),
(60, 3),
(61, 1),
(61, 3),
(61, 4),
(62, 1),
(62, 3),
(62, 4),
(63, 1),
(63, 3),
(63, 4),
(64, 1),
(64, 3),
(64, 4),
(65, 1),
(65, 3),
(65, 4),
(66, 1),
(66, 3),
(66, 4),
(67, 1),
(67, 3),
(67, 4),
(68, 1),
(68, 3),
(68, 4),
(69, 1),
(69, 3),
(69, 4),
(70, 1),
(70, 3),
(70, 4),
(71, 1),
(71, 3),
(71, 4),
(72, 1),
(72, 3),
(72, 4),
(73, 1),
(73, 3),
(73, 4),
(74, 1),
(74, 3),
(74, 4),
(75, 1),
(75, 3),
(75, 4),
(76, 1),
(76, 3),
(76, 4),
(77, 1),
(77, 3),
(77, 4),
(78, 1),
(78, 3),
(78, 4),
(79, 1),
(79, 3),
(79, 4),
(80, 1),
(80, 3),
(80, 4),
(81, 1),
(81, 3),
(81, 4),
(82, 1),
(82, 3),
(82, 4),
(83, 1),
(83, 3),
(83, 4),
(84, 1),
(84, 3),
(84, 4),
(85, 1),
(85, 3),
(85, 4),
(86, 1),
(86, 3),
(86, 4),
(87, 1),
(87, 3),
(87, 4),
(88, 1),
(88, 3),
(88, 4),
(89, 1),
(89, 3),
(89, 4),
(90, 1),
(90, 3),
(90, 4),
(94, 4),
(95, 4),
(96, 4),
(97, 4),
(98, 4),
(99, 4),
(100, 4),
(101, 4),
(102, 4);

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `itype_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`itype_id`, `name`, `code`, `image`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Men', 'M', NULL, 1, '2016-07-21 11:34:13', '2016-07-21 11:34:13'),
(2, 'Women', 'W', NULL, 1, '2016-07-21 11:34:21', '2016-07-21 11:34:21'),
(3, 'Kids', 'K', NULL, 1, '2016-07-21 11:34:30', '2016-07-21 11:34:30'),
(4, 'Infants', 'I', NULL, 1, '2016-07-21 11:34:36', '2016-07-21 11:34:36'),
(5, 'Utilities', 'U', NULL, 1, '2016-07-21 11:34:44', '2016-07-21 11:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `cost` int(11) NOT NULL,
  `durationInDays` int(11) NOT NULL,
  `packageDetails` longtext,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `package_details`
--

CREATE TABLE `package_details` (
  `pd_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `packageDetails` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `resource` varchar(255) NOT NULL,
  `roles` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `ptype` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `rlabel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `resource`, `roles`, `status`, `ptype`, `updated_at`, `created_at`, `rlabel`) VALUES
(1, 'app.employee-registration', '', 1, 'state', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Laundry Employee Registration '),
(2, 'un-authorized', 'STORE_ADMIN,CBS_ADMIN', 0, 'state', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(3, 'app.faculty-registration', '', 1, 'state', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Apartment Faculty Registration'),
(4, 'app.city', '', 1, 'state', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Cities'),
(5, 'app.pickupboy-registration', '', 1, 'state', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'Pickupboy Registration'),
(6, 'app.area', '', 1, 'state', '2016-10-14 10:57:08', '2016-10-14 10:57:08', 'Areas(Stores)'),
(7, 'app.apartment', '', 1, 'state', '2016-10-14 11:03:24', '2016-10-14 11:03:24', 'Apartments'),
(8, 'app.block', '', 1, 'state', '2016-10-15 07:42:01', '2016-10-15 07:42:01', 'Blocks'),
(9, 'app.flat', '', 1, 'state', '2016-10-15 08:18:35', '2016-10-15 08:18:35', 'Flats'),
(10, 'app.vehicle-registration', '', 1, 'state', '2016-10-15 08:18:41', '2016-10-15 08:18:41', 'Add Vehicles to Flat'),
(11, 'app.catalog', '', 1, 'state', '2016-10-17 09:44:43', '2016-10-17 09:44:43', 'Catalog'),
(12, 'app.addon', '', 1, 'state', '2016-10-17 09:45:04', '2016-10-17 09:45:04', 'Create Addons'),
(13, 'app.service', '', 1, 'state', '2016-10-17 09:45:20', '2016-10-17 09:45:20', 'Create Services'),
(14, 'app.itemtype', '', 1, 'state', '2016-10-17 09:45:47', '2016-10-17 09:45:47', 'Create Item TYpes'),
(15, 'app.item', '', 1, 'state', '2016-10-17 09:46:00', '2016-10-17 09:46:00', 'Create Items'),
(16, 'app.additemstocatlog', '', 1, 'state', '2016-10-17 09:46:28', '2016-10-17 09:46:28', 'Add Items to Catalog'),
(17, 'app.customerusers', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:47:34', '2016-10-17 09:47:34', 'Register Users'),
(18, 'app.processorddders', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:48:06', '2016-10-17 09:48:06', 'Order Proces'),
(19, 'app.processoddrderfrdsehrkji', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:49:16', '2016-10-17 09:49:16', 'Process Order '),
(20, 'app.orderprint', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:49:40', '2016-10-17 09:49:40', 'Order Print'),
(21, 'app.individualuserorders', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:50:39', '2016-10-17 09:50:39', 'Customer Transaction Details'),
(22, 'app.order-details-only', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:51:22', '2016-10-17 09:51:22', 'Complete Order Details'),
(23, 'app.returngarment', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:51:54', '2016-10-17 09:51:54', 'Return Garments'),
(24, 'app.holdgarment', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:52:38', '2016-10-17 09:52:38', 'Hold Garments'),
(25, 'app.cu-send-orders', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:53:22', '2016-10-17 09:53:22', 'CU Send Order'),
(26, 'app.cus-order-details', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:54:09', '2016-10-17 09:54:09', 'CU Order Details'),
(27, 'app.cu-delivery-orders', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:54:58', '2016-10-17 09:54:58', 'CU Delivery Orders'),
(28, 'app.cud-order-details', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:55:35', '2016-10-17 09:55:35', 'CU Delivery Oder Details'),
(29, 'app.placeorders', 'STORE_ADMIN', 1, 'state', '2016-10-17 09:56:50', '2016-10-17 09:56:50', 'Order History'),
(30, 'app.customerenquiry', 'STORE_ADMIN,CALL_CENTER', 1, 'state', '2016-10-17 09:57:41', '2016-10-17 09:57:41', 'Customer Enquiry OR Place Order'),
(31, 'app.customerRequests', 'STORE_ADMIN,CALL_CENTER', 1, 'state', '2016-10-17 09:58:13', '2016-10-17 09:58:13', 'Customer Requests'),
(32, 'app.placeorder', 'STORE_ADMIN', 1, 'state', '2016-10-17 10:13:42', '2016-10-17 10:13:42', 'Placeorder'),
(33, 'app.global-search', 'STORE_ADMIN,CALL_CENTER,CU_ADMIN', 1, 'state', '2016-10-17 10:15:58', '2016-10-17 10:15:58', 'Global Search'),
(34, 'cu.cu-send-orders', 'CU_ADMIN', 1, 'state', '2016-10-17 10:56:22', '2016-10-17 10:56:22', 'Central Unit Send Orders'),
(35, 'cu.cus-orderdetails', 'CU_ADMIN', 1, 'state', '2016-10-17 10:57:01', '2016-10-17 10:57:01', 'Central Unit Send Order Details'),
(36, 'cu.order-details-only', 'CU_ADMIN', 1, 'state', '2016-10-17 10:57:36', '2016-10-17 10:57:36', 'Central Unit Order Item Details'),
(37, 'cu.cu-delivery-orders', 'CU_ADMIN', 1, 'state', '2016-10-17 10:58:04', '2016-10-17 10:58:04', 'Central Unit Delivery Orders'),
(38, 'cu.cud-orderdetails', 'CU_ADMIN', 1, 'state', '2016-10-17 10:58:50', '2016-10-17 10:58:50', 'Central Unit Delivery Order Details'),
(39, 'cu.cu-process-orders', 'CU_ADMIN', 1, 'state', '2016-10-17 10:59:55', '2016-10-17 10:59:55', 'Cental Unit Process Orders'),
(40, 'cu.cu-return-garments', 'CU_ADMIN', 1, 'state', '2016-10-17 11:00:36', '2016-10-17 11:00:36', 'Central Unit Return Garments'),
(41, 'cu.cu-hold-garments', '', 1, 'state', '2016-10-17 11:01:13', '2016-10-17 11:01:13', 'Central Unit Hold Garments'),
(42, 'cu.pickupboy-registration', 'CU_ADMIN', 1, 'state', '2016-10-17 11:02:18', '2016-10-17 11:02:18', 'Central Unit Pickup Boys'),
(43, 'app.orderdetails', 'STORE_ADMIN', 1, 'state', '2016-10-17 11:39:43', '2016-10-17 11:39:43', 'Process Order Details'),
(45, 'app.placeorderf', 'STORE_ADMIN', 1, 'state', '2016-10-18 08:04:00', '2016-10-18 08:04:00', 'Edit Order');

-- --------------------------------------------------------

--
-- Table structure for table `pickup_boys`
--

CREATE TABLE `pickup_boys` (
  `pb_id` int(11) NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passwordSalt` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pickup_boys`
--

INSERT INTO `pickup_boys` (`pb_id`, `area_id`, `name`, `email`, `mobile`, `password`, `passwordSalt`, `token`, `status`, `updated_at`, `created_at`, `image`) VALUES
(1, 1, 'Raju', 'raju@gmail.com', '1231231230', '900150983cd24fb0d6963f7d28e17f72', '', NULL, 1, '2016-12-30 11:19:47', '2016-12-30 11:19:47', NULL),
(2, 1, 'balu', 'balu@gmail.com', '1241241240', '900150983cd24fb0d6963f7d28e17f72', '', NULL, 1, '2016-12-30 11:20:17', '2016-12-30 11:20:17', NULL),
(3, 2, 'Ramu', 'ramu@gmail.com', '3213213210', '900150983cd24fb0d6963f7d28e17f72', '', NULL, 1, '2016-12-30 11:20:43', '2016-12-30 11:20:43', NULL),
(4, 2, 'raghu', 'raghu@gmail.com', '4214214210', '900150983cd24fb0d6963f7d28e17f72', '', NULL, 1, '2016-12-30 11:21:21', '2016-12-30 11:21:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `place_order`
--

CREATE TABLE `place_order` (
  `po_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `icount` smallint(6) NOT NULL,
  `cost` smallint(6) NOT NULL,
  `rpoints` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `ricount` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place_order`
--

INSERT INTO `place_order` (`po_id`, `item_id`, `service_id`, `cust_id`, `order_id`, `icount`, `cost`, `rpoints`, `status`, `updated_at`, `created_at`, `ricount`) VALUES
(1, 1, 3, 1, 'MP-WD-S-30122016-4397', 2, 50, 20, 0, '2016-12-30 11:29:44', '2016-12-30 11:29:44', NULL),
(3, 3, 4, 1, 'MP-WD-S-30122016-8032', 5, 250, 50, 0, '2016-12-30 11:32:27', '2016-12-30 11:32:27', NULL),
(4, 33, 4, 1, 'MP-WD-S-02012017-9904', 5, 250, 50, 1, '2017-01-02 09:32:45', '2017-01-02 09:32:45', NULL),
(5, 87, 4, 1, 'MP-WD-S-02012017-9904', 5, 500, 50, 1, '2017-01-02 09:32:45', '2017-01-02 09:32:45', NULL),
(6, 6, 1, 1, 'MP-SI-S-02012017-2410', 5, 50, 50, 1, '2017-01-02 09:32:47', '2017-01-02 09:32:47', NULL),
(7, 26, 1, 1, 'MP-SI-S-02012017-2410', 8, 96, 80, 1, '2017-01-02 09:32:47', '2017-01-02 09:32:47', NULL),
(8, 1, 1, 2, 'MP-SI-S-02012017-9268', 5, 40, 50, 1, '2017-01-02 09:41:13', '2017-01-02 09:41:13', NULL),
(9, 23, 1, 2, 'MP-SI-S-02012017-9268', 4, 40, 40, 1, '2017-01-02 09:41:14', '2017-01-02 09:41:14', NULL),
(10, 61, 1, 2, 'MP-SI-S-02012017-9268', 5, 25, 50, 1, '2017-01-02 09:41:14', '2017-01-02 09:41:14', NULL),
(11, 26, 3, 2, 'MP-WD-S-02012017-2938', 4, 162, 40, 1, '2017-01-02 09:44:33', '2017-01-02 09:44:33', NULL),
(12, 1, 4, 2, 'MP-WD-S-02012017-2938', 5, 307, 50, 1, '2017-01-02 09:44:34', '2017-01-02 09:44:34', NULL),
(13, 74, 4, 2, 'MP-WD-S-02012017-2938', 4, 480, 40, 1, '2017-01-02 09:44:34', '2017-01-02 09:44:34', NULL),
(14, 60, 3, 2, 'MP-WD-S-02012017-2567', 4, 80, 40, 1, '2017-01-02 09:45:54', '2017-01-02 09:45:54', NULL),
(15, 40, 3, 2, 'MP-WD-S-02012017-2567', 6, 450, 60, 1, '2017-01-02 09:45:54', '2017-01-02 09:45:54', NULL),
(16, 8, 3, 2, 'MP-WD-S-02012017-2567', 3, 105, 30, 1, '2017-01-02 09:45:54', '2017-01-02 09:45:54', NULL),
(17, 3, 1, 2, 'MP-SI-S-02012017-5547', 12, 96, 120, 1, '2017-01-02 09:47:20', '2017-01-02 09:47:20', NULL),
(18, 27, 1, 2, 'MP-SI-S-02012017-5547', 9, 126, 90, 1, '2017-01-02 09:47:20', '2017-01-02 09:47:20', 1),
(19, 61, 1, 2, 'MP-SI-S-02012017-5547', 5, 25, 50, 1, '2017-01-02 09:47:20', '2017-01-02 09:47:20', NULL),
(20, 1, 1, 2, 'MP-SI-S-02012017-5547', 10, 80, 100, 1, '2017-01-02 09:47:20', '2017-01-02 09:47:20', NULL),
(21, 74, 1, 2, 'MP-SI-S-02012017-5547', 2, 40, 20, 1, '2017-01-02 09:47:20', '2017-01-02 09:47:20', NULL),
(22, 1, 1, 1, 'MP-SI-M-02012017-3811', 2, 16, 10, 0, '2017-01-02 10:22:20', '2017-01-02 10:22:20', NULL),
(23, 2, 1, 1, 'MP-SI-M-02012017-3811', 2, 16, 10, 0, '2017-01-02 10:22:20', '2017-01-02 10:22:20', NULL),
(24, 3, 1, 1, 'MP-SI-M-02012017-3811', 3, 24, 10, 0, '2017-01-02 10:22:21', '2017-01-02 10:22:21', NULL),
(25, 1, 3, 1, 'MP-WD-M-02012017-3810', 2, 50, 10, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL),
(26, 2, 3, 1, 'MP-WD-M-02012017-3810', 2, 50, 10, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL),
(27, 3, 3, 1, 'MP-WD-M-02012017-3810', 3, 75, 10, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL),
(28, 1, 1, 1, 'MP-SI-M-02012017-9324', 2, 16, 10, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL),
(29, 2, 1, 1, 'MP-SI-M-02012017-9324', 2, 16, 10, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL),
(30, 4, 1, 1, 'MP-SI-M-02012017-9324', 2, 16, 10, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL),
(31, 3, 1, 1, 'MP-SI-M-02012017-7933', 2, 16, 10, 1, '2017-01-02 10:29:41', '2017-01-02 10:29:41', NULL),
(32, 4, 1, 1, 'MP-SI-M-02012017-2182', 5, 40, 10, 1, '2017-01-02 10:31:05', '2017-01-02 10:31:05', NULL),
(33, 4, 3, 1, 'MP-WD-M-02012017-2673', 3, 75, 10, 1, '2017-01-02 10:35:41', '2017-01-02 10:35:41', NULL),
(34, 5, 3, 1, 'MP-WD-M-02012017-6450', 2, 200, 10, 1, '2017-01-02 11:00:30', '2017-01-02 11:00:30', NULL),
(35, 5, 4, 1, 'MP-WD-M-02012017-4070', 2, 300, 10, 1, '2017-01-02 11:06:46', '2017-01-02 11:06:46', NULL),
(36, 3, 1, 1, 'MP-SI-M-02012017-9349', 2, 16, 10, 1, '2017-01-02 11:09:32', '2017-01-02 11:09:32', NULL),
(37, 32, 4, 1, 'MP-WD-S-03012017-7752', 4, 600, 40, 1, '2017-01-03 08:02:34', '2017-01-03 08:02:34', NULL),
(38, 88, 3, 1, 'MP-WD-S-03012017-7752', 3, 375, 30, 1, '2017-01-03 08:02:34', '2017-01-03 08:02:34', NULL),
(39, 64, 1, 1, 'MP-SI-S-03012017-1256', 5, 25, 50, 1, '2017-01-03 08:02:35', '2017-01-03 08:02:35', NULL),
(40, 75, 1, 1, 'MP-SI-S-03012017-1256', 5, 75, 50, 1, '2017-01-03 08:02:35', '2017-01-03 08:02:35', NULL),
(50, 4, 4, 1, 'MP-WD-M-03012017-5108', 1, 40, 10, 1, '2017-01-03 09:30:56', '2017-01-03 09:30:56', NULL),
(51, 5, 4, 1, 'MP-WD-M-03012017-5108', 1, 150, 10, 1, '2017-01-03 09:30:57', '2017-01-03 09:30:57', NULL),
(57, 3, 1, 1, 'MP-SI-M-03012017-6187', 2, 16, 10, 1, '2017-01-03 09:34:39', '2017-01-03 09:34:39', NULL),
(58, 23, 1, 1, 'MP-SI-M-03012017-6187', 2, 20, 10, 1, '2017-01-03 09:34:40', '2017-01-03 09:34:40', NULL),
(59, 61, 1, 1, 'MP-SI-M-03012017-6187', 2, 10, 10, 1, '2017-01-03 09:34:41', '2017-01-03 09:34:41', NULL),
(60, 74, 1, 1, 'MP-SI-M-03012017-6187', 2, 40, 10, 1, '2017-01-03 09:34:41', '2017-01-03 09:34:41', NULL),
(61, 5, 1, 1, 'MP-SI-M-03012017-5743', 4, 64, 10, 1, '2017-01-03 09:43:31', '2017-01-03 09:43:31', NULL),
(62, 1, 3, 1, 'MP-WD-S-04012017-6324', 3, 75, 30, 1, '2017-01-04 12:22:04', '2017-01-04 12:22:04', NULL),
(63, 2, 1, 1, 'MP-SI-S-04012017-4315', 4, 32, 40, 1, '2017-01-04 12:22:05', '2017-01-04 12:22:05', NULL),
(64, 1, 3, 1, 'MP-WD-S-10012017-5433', 5, 125, 50, 1, '2017-01-10 09:20:34', '2017-01-10 09:20:34', NULL),
(65, 20, 3, 1, 'MP-WD-S-10012017-5433', 3, 67, 30, 1, '2017-01-10 09:20:34', '2017-01-10 09:20:34', NULL),
(66, 2, 1, 1, 'MP-SI-S-10012017-7884', 4, 32, 40, 1, '2017-01-10 09:20:35', '2017-01-10 09:20:35', NULL),
(67, 58, 1, 1, 'MP-SI-S-10012017-7884', 5, 35, 50, 1, '2017-01-10 09:20:35', '2017-01-10 09:20:35', NULL),
(68, 1, 1, 1, 'MP-SI-S-11012017-5563', 2, 26, 20, 1, '2017-01-11 09:47:05', '2017-01-11 09:47:05', NULL),
(69, 2, 3, 1, 'MP-WD-S-18012017-7183', 5, 125, 50, 1, '2017-01-18 10:31:41', '2017-01-18 10:31:41', NULL),
(70, 22, 4, 1, 'MP-WD-S-18012017-7183', 3, 120, 30, 1, '2017-01-18 10:31:41', '2017-01-18 10:31:41', NULL),
(71, 21, 1, 1, 'MP-SI-S-18012017-2114', 4, 60, 40, 1, '2017-01-18 10:31:43', '2017-01-18 10:31:43', NULL),
(72, 23, 3, 1, 'MP-WD-S-18012017-4160', 4, 100, 40, 1, '2017-01-18 10:32:18', '2017-01-18 10:32:18', NULL),
(73, 75, 1, 1, 'MP-SI-S-18012017-5559', 2, 30, 20, 1, '2017-01-18 10:32:19', '2017-01-18 10:32:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `place_order_addons`
--

CREATE TABLE `place_order_addons` (
  `poa_id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `poa_count` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place_order_addons`
--

INSERT INTO `place_order_addons` (`poa_id`, `po_id`, `addon_id`, `poa_count`, `updated_at`, `created_at`) VALUES
(1, 11, 1, 2, '2017-01-02 09:44:34', '2017-01-02 09:44:34'),
(2, 11, 2, 2, '2017-01-02 09:44:34', '2017-01-02 09:44:34'),
(3, 11, 3, 4, '2017-01-02 09:44:34', '2017-01-02 09:44:34'),
(4, 12, 1, 5, '2017-01-02 09:44:34', '2017-01-02 09:44:34'),
(5, 12, 4, 4, '2017-01-02 09:44:34', '2017-01-02 09:44:34'),
(6, 13, 6, 4, '2017-01-02 09:44:34', '2017-01-02 09:44:34'),
(7, 14, 1, 4, '2017-01-02 09:45:54', '2017-01-02 09:45:54'),
(8, 65, 1, 2, '2017-01-10 09:20:34', '2017-01-10 09:20:34'),
(9, 65, 2, 2, '2017-01-10 09:20:34', '2017-01-10 09:20:34'),
(10, 67, 1, 2, '2017-01-10 09:20:35', '2017-01-10 09:20:35'),
(11, 68, 1, 2, '2017-01-11 09:47:05', '2017-01-11 09:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `place_order_ids`
--

CREATE TABLE `place_order_ids` (
  `o_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `subtotal` varchar(18) DEFAULT NULL,
  `serviceTax` varchar(8) DEFAULT NULL,
  `totalAmount` varchar(18) DEFAULT NULL,
  `balanceAmount` varchar(255) DEFAULT NULL,
  `paidAmount` varchar(255) DEFAULT NULL,
  `closingBalance` varchar(255) DEFAULT NULL,
  `reFundAmount` varchar(255) DEFAULT NULL,
  `adminDiscount` varchar(255) DEFAULT NULL,
  `adminDiscountAmount` varchar(255) DEFAULT NULL,
  `orderDate` datetime DEFAULT NULL,
  `firstPaidAmount` int(11) DEFAULT NULL,
  `secondPaidAmount` int(11) DEFAULT NULL,
  `thirdPaidAmount` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `pb_id` int(11) DEFAULT NULL,
  `deliveryDate` datetime DEFAULT NULL,
  `pickupBoyStatus` varchar(255) DEFAULT NULL,
  `cuStatus` varchar(4) DEFAULT NULL,
  `totalItems` int(11) DEFAULT NULL,
  `poStatus` varchar(255) DEFAULT NULL,
  `poStatusMessage` varchar(255) DEFAULT NULL,
  `redeemAmount` varchar(18) DEFAULT NULL,
  `rPointsUsed` varchar(18) DEFAULT NULL,
  `isDelete` tinyint(1) NOT NULL,
  `db_id` int(11) DEFAULT NULL,
  `qd` tinyint(1) DEFAULT NULL,
  `qdAmount` varchar(255) DEFAULT NULL,
  `paymentType` varchar(255) DEFAULT NULL,
  `transactionNumber` varchar(255) DEFAULT NULL,
  `isPackageOrder` tinyint(1) NOT NULL,
  `processDelayInDays` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place_order_ids`
--

INSERT INTO `place_order_ids` (`o_id`, `customer_id`, `address_id`, `order_id`, `store_id`, `subtotal`, `serviceTax`, `totalAmount`, `balanceAmount`, `paidAmount`, `closingBalance`, `reFundAmount`, `adminDiscount`, `adminDiscountAmount`, `orderDate`, `firstPaidAmount`, `secondPaidAmount`, `thirdPaidAmount`, `status`, `updated_at`, `created_at`, `pb_id`, `deliveryDate`, `pickupBoyStatus`, `cuStatus`, `totalItems`, `poStatus`, `poStatusMessage`, `redeemAmount`, `rPointsUsed`, `isDelete`, `db_id`, `qd`, `qdAmount`, `paymentType`, `transactionNumber`, `isPackageOrder`, `processDelayInDays`) VALUES
(1, 1, 1, 'MP-WD-S-30122016-4397', 1, '50.00', '7.25', '57.25', '57.25', NULL, '57.25', '0', '0.00', '0.00', '2016-12-30 11:29:00', NULL, NULL, NULL, 0, '2016-12-30 11:29:44', '2016-12-30 11:29:44', NULL, '2017-01-04 18:01:00', '0', '0', 2, NULL, NULL, '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 5),
(2, 1, 1, 'MP-WD-S-30122016-8032', 1, '245.00', '35.53', '280.53', '280.53', NULL, '280.53', '0', '2.00', '5.00', '2016-12-30 11:31:00', NULL, NULL, NULL, 0, '2016-12-30 11:31:10', '2016-12-30 11:31:10', NULL, '2016-12-29 18:12:00', '0', '0', 5, NULL, NULL, '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 0),
(3, 1, 1, 'MP-WD-S-02012017-9904', 1, '750.00', '108.75', '858.75', '858.75', NULL, '858.75', '0', '0.00', '0.00', '2017-01-02 09:32:00', NULL, NULL, NULL, 1, '2017-01-02 09:32:45', '2017-01-02 09:32:45', NULL, '2017-01-11 18:01:00', 'assigned', '1', 10, 'DOA', 'Delivery Order Approved', '0', '0', 0, 1, 0, NULL, NULL, NULL, 0, 9),
(4, 1, 1, 'MP-SI-S-02012017-2410', 1, '146.00', '21.17', '167.17', '167.17', NULL, '167.17', '0', '0.00', '0.00', '2017-01-02 09:32:00', NULL, NULL, NULL, 1, '2017-01-02 09:32:47', '2017-01-02 09:32:47', NULL, '2017-01-11 18:01:00', 'assigned', '1', 13, 'DOA', 'Delivery Order Approved', '0', '0', 0, 1, 0, NULL, NULL, NULL, 0, 9),
(5, 2, 2, 'MP-SI-S-02012017-9268', 1, '105.00', '15.23', '120.23', '120.23', NULL, '120.23', '0', '0.00', '0.00', '2017-01-02 09:41:00', NULL, NULL, NULL, 1, '2017-01-02 09:41:13', '2017-01-02 09:41:13', NULL, '2017-01-04 18:01:00', 'assigned', '1', 14, 'DOA', 'Delivery Order Approved', '0', '0', 0, 1, 0, NULL, NULL, NULL, 0, 2),
(6, 2, 2, 'MP-WD-S-02012017-2938', 1, '939.00', '136.16', '1075.16', '74.38', '1000.78', '1075.16', '0', '1.05', '10.00', '2017-01-02 09:44:00', NULL, NULL, NULL, 1, '2017-01-02 09:44:33', '2017-01-02 09:44:33', NULL, '2017-01-05 18:01:00', '0', '1', 13, 'ORD', 'Order Ready To Deliver', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 3),
(7, 2, 2, 'MP-WD-S-02012017-2567', 1, '635.00', '92.08', '727.08', '727.08', NULL, '727.08', '0', '0.00', '0.00', '2017-01-02 09:45:00', NULL, NULL, NULL, 1, '2017-01-02 09:45:54', '2017-01-02 09:45:54', NULL, '2017-01-06 18:01:00', 'assigned', '1', 13, 'DOA', 'Delivery Order Approved', '0', '0', 0, 1, 0, NULL, NULL, NULL, 0, 4),
(8, 2, 2, 'MP-SI-S-02012017-5547', 1, '367.00', '53.22', '420.22', '0', '420.22', '404.19', '16.03', '0.00', '0.00', '2017-01-02 09:47:00', NULL, NULL, NULL, 1, '2017-01-02 09:47:20', '2017-01-02 09:47:20', NULL, '2017-01-05 18:01:00', 'assigned', '1', 38, 'DOA', 'Delivery Order Approved', '0', '0', 0, 1, 0, NULL, NULL, NULL, 0, 3),
(9, 1, 1, 'MP-SI-M-02012017-3811', 1, '56', '8.12', '64.12', '64.12', '0', '64.12', '0', '0', '0', '2017-01-02 10:22:20', NULL, NULL, NULL, 0, '2017-01-02 10:22:20', '2017-01-02 10:22:20', NULL, NULL, '0', '0', 7, NULL, NULL, '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(10, 1, 1, 'MP-WD-M-02012017-3810', 1, '175', '25.375', '200.375', '200.375', '0', '200.375', '0', '0', '0', '2017-01-02 10:23:43', NULL, NULL, NULL, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL, NULL, '0', '0', 7, 'PO', 'Process Order', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(11, 1, 1, 'MP-SI-M-02012017-9324', 1, '48', '6.96', '54.96', '54.96', '0', '54.96', '0', '0', '0', '2017-01-02 10:23:43', NULL, NULL, NULL, 1, '2017-01-02 10:23:43', '2017-01-02 10:23:43', NULL, NULL, '0', '1', 6, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(12, 1, 1, 'MP-SI-M-02012017-7933', 1, '16', '2.32', '18.32', '18.32', '0', '18.32', '0', '0', '0', '2017-01-02 10:29:41', NULL, NULL, NULL, 1, '2017-01-02 10:29:41', '2017-01-02 10:29:41', NULL, NULL, '0', '1', 2, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(13, 1, 1, 'MP-SI-M-02012017-2182', 1, '40', '5.8', '45.8', '45.8', '0', '45.8', '0', '0', '0', '2017-01-02 10:31:05', NULL, NULL, NULL, 1, '2017-01-02 10:31:05', '2017-01-02 10:31:05', NULL, NULL, '0', '1', 5, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(14, 1, 1, 'MP-WD-M-02012017-2673', 1, '75', '10.875', '85.875', '85.875', '0', '85.875', '0', '0', '0', '2017-01-02 10:35:41', NULL, NULL, NULL, 1, '2017-01-02 10:35:41', '2017-01-02 10:35:41', NULL, NULL, '0', '1', 3, 'CPBA', 'Central Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(15, 1, 1, 'MP-WD-M-02012017-6450', 1, '200', '29', '229', '229', '0', '229', '0', '0', '0', '2017-01-02 11:00:30', NULL, NULL, NULL, 1, '2017-01-02 11:00:30', '2017-01-02 11:00:30', NULL, NULL, '0', '1', 2, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(16, 1, 1, 'MP-WD-M-02012017-4070', 1, '300', '43.5', '343.5', '343.5', '0', '343.5', '0', '0', '0', '2017-01-02 11:06:46', NULL, NULL, NULL, 1, '2017-01-02 11:06:46', '2017-01-02 11:06:46', NULL, NULL, '0', '1', 2, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(17, 1, 1, 'MP-SI-M-02012017-9349', 1, '16', '2.32', '18.32', '18.32', '0', '18.32', '0', '0', '0', '2017-01-02 11:09:32', NULL, NULL, NULL, 1, '2017-01-02 11:09:32', '2017-01-02 11:09:32', NULL, NULL, '0', '1', 2, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, NULL),
(18, 1, 1, 'MP-WD-S-03012017-7752', 1, '975.00', '141.38', '1116.38', '1116.38', NULL, '1116.38', '0', '0.00', '0.00', '2017-01-03 08:02:00', NULL, NULL, NULL, 1, '2017-01-03 08:02:34', '2017-01-03 08:02:34', NULL, '2017-01-10 18:01:00', '0', '1', 7, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(19, 1, 1, 'MP-SI-S-03012017-1256', 1, '100.00', '14.50', '114.50', '114.50', NULL, '114.50', '0', '0.00', '0.00', '2017-01-03 08:02:00', NULL, NULL, NULL, 1, '2017-01-03 08:02:35', '2017-01-03 08:02:35', NULL, '2017-01-10 18:01:00', '0', '1', 10, 'CPBA', 'Central Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(20, 1, 1, 'MP-SI-M-03012017-6187', 1, '86', '12.47', '98.47', '98.47', '0', '98.47', '0', '0', '0', '2017-01-03 08:55:47', NULL, NULL, NULL, 1, '2017-01-03 08:55:47', '2017-01-03 08:55:47', NULL, '2017-01-10 18:01:00', '0', '1', 8, 'CPBA', 'Central Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(21, 1, 1, 'MP-SI-M-03012017-5743', 1, '64', '9.28', '73.28', '73.28', '0', '73.28', '0', '0', '0', '2017-01-03 08:57:34', NULL, NULL, NULL, 1, '2017-01-03 08:57:34', '2017-01-03 08:57:34', NULL, '2017-01-09 18:01:00', '0', '1', 4, 'CUPA', ' Central Unit Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 6),
(1000022, 1, 1, 'MP-WD-M-03012017-5108', 1, '190', '27.55', '217.55', '217.55', '0', '217.55', '0', '0', '0', '2017-01-03 09:00:06', NULL, NULL, NULL, 1, '2017-01-03 09:00:06', '2017-01-03 09:00:06', NULL, '2017-01-10 18:01:00', '0', '1', 2, 'CUPA', ' Central Unit Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(1000023, 1, 1, 'MP-WD-S-04012017-6324', 1, '75.00', '10.88', '85.88', '85.88', NULL, '85.88', '0', '0.00', '0.00', '2017-01-04 12:22:00', NULL, NULL, NULL, 1, '2017-01-04 12:22:04', '2017-01-04 12:22:04', NULL, '2017-01-11 18:01:00', '0', '1', 3, 'CPBA', 'Central Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(1000024, 1, 1, 'MP-SI-S-04012017-4315', 1, '32.00', '4.64', '36.64', '36.64', NULL, '36.64', '0', '0.00', '0.00', '2017-01-04 12:22:00', NULL, NULL, NULL, 1, '2017-01-04 12:22:05', '2017-01-04 12:22:05', NULL, '2017-01-11 18:01:00', '0', '1', 4, 'CUPA', ' Central Unit Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(1000025, 1, 1, 'MP-WD-S-10012017-5433', 1, '182.00', '26.39', '208.39', '208.39', NULL, '208.39', '0', '9.90', '20.00', '2017-01-10 09:20:00', NULL, NULL, NULL, 1, '2017-01-10 09:20:34', '2017-01-10 09:20:34', NULL, '2017-01-17 18:01:00', '0', '1', 8, 'CPBA', 'Central Pickup Boy Approved', '0', '0', 0, NULL, 1, '10.00', NULL, NULL, 0, 7),
(1000026, 1, 1, 'MP-SI-S-10012017-7884', 1, '57.00', '8.27', '65.27', '65.27', NULL, '65.27', '0', '25.97', '20.00', '2017-01-10 09:20:00', NULL, NULL, NULL, 1, '2017-01-10 09:20:35', '2017-01-10 09:20:35', NULL, '2017-01-17 18:01:00', '0', '1', 9, 'CPBA', 'Central Pickup Boy Approved', '0', '0', 0, NULL, 1, '10.00', NULL, NULL, 0, 7),
(1000027, 1, 1, 'MP-SI-S-11012017-5563', 1, '26.00', '3.77', '29.77', '29.77', NULL, '29.77', '0', '0.00', '0.00', '2017-01-11 09:47:00', NULL, NULL, NULL, 1, '2017-01-11 09:47:05', '2017-01-11 09:47:05', NULL, '2017-01-18 18:01:00', '0', '1', 2, 'CUPA', ' Central Unit Pickup Boy Approved', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 7),
(1000028, 1, 1, 'MP-WD-S-18012017-7183', 1, '245.00', '35.53', '280.53', '280.53', NULL, '280.53', '0', '0.00', '0.00', '2017-01-18 10:31:00', NULL, NULL, NULL, 1, '2017-01-18 10:31:41', '2017-01-18 10:31:41', NULL, '2017-01-20 18:01:00', '0', '1', 8, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 2),
(1000029, 1, 1, 'MP-SI-S-18012017-2114', 1, '60.00', '8.70', '68.70', '68.70', NULL, '68.70', '0', '0.00', '0.00', '2017-01-18 10:31:00', NULL, NULL, NULL, 1, '2017-01-18 10:31:43', '2017-01-18 10:31:43', NULL, '2017-01-20 18:01:00', '0', '1', 4, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 2),
(1000030, 1, 1, 'MP-WD-S-18012017-4160', 1, '100.00', '14.50', '114.50', '114.50', NULL, '114.50', '0', '0.00', '0.00', '2017-01-18 10:32:00', NULL, NULL, NULL, 1, '2017-01-18 10:32:18', '2017-01-18 10:32:18', NULL, '2017-01-27 18:01:00', '0', '1', 4, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 9),
(1000031, 1, 1, 'MP-SI-S-18012017-5559', 1, '30.00', '4.35', '34.35', '34.35', NULL, '34.35', '0', '0.00', '0.00', '2017-01-18 10:32:00', NULL, NULL, NULL, 1, '2017-01-18 10:32:19', '2017-01-18 10:32:19', NULL, '2017-01-27 18:01:00', '0', '1', 2, 'STCU', 'Send to Central Unit', '0', '0', 0, NULL, 0, NULL, NULL, NULL, 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `process_orders`
--

CREATE TABLE `process_orders` (
  `prco_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `inBarCode` varchar(255) DEFAULT NULL,
  `outBarCode` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `barCodeLabel` varchar(255) DEFAULT NULL,
  `itemStatus` varchar(255) DEFAULT NULL,
  `itemStatusMessage` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `returnGarmentStatus` varchar(255) DEFAULT NULL,
  `returnGarmentStatusMessage` varchar(255) DEFAULT NULL,
  `apartment_store_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `process_orders`
--

INSERT INTO `process_orders` (`prco_id`, `item_id`, `service_id`, `cust_id`, `po_id`, `order_id`, `name`, `color`, `brand`, `inBarCode`, `outBarCode`, `status`, `updated_at`, `created_at`, `barCodeLabel`, `itemStatus`, `itemStatusMessage`, `store_id`, `returnGarmentStatus`, `returnGarmentStatusMessage`, `apartment_store_id`) VALUES
(1, 87, 4, 1, 5, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-U-sofa-cover-normal-1 of 5', NULL, NULL, '020117093504219', '020117093504219', 0, '2017-01-02 09:35:05', '2017-01-02 09:35:05', 'MP, Naresh R, 3, DC,U, sofa-cover-normal, 1 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(2, 87, 4, 1, 5, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-U-sofa-cover-normal-2 of 5', NULL, NULL, '020117093504411', '020117093504411', 0, '2017-01-02 09:35:05', '2017-01-02 09:35:05', 'MP, Naresh R, 3, DC,U, sofa-cover-normal, 2 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(3, 87, 4, 1, 5, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-U-sofa-cover-normal-3 of 5', NULL, NULL, '020117093504881', '020117093504881', 0, '2017-01-02 09:35:05', '2017-01-02 09:35:05', 'MP, Naresh R, 3, DC,U, sofa-cover-normal, 3 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(4, 87, 4, 1, 5, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-U-sofa-cover-normal-4 of 5', NULL, NULL, '020117093504442', '020117093504442', 0, '2017-01-02 09:35:06', '2017-01-02 09:35:06', 'MP, Naresh R, 3, DC,U, sofa-cover-normal, 4 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(5, 87, 4, 1, 5, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-U-sofa-cover-normal-5 of 5', NULL, NULL, '020117093504792', '020117093504792', 0, '2017-01-02 09:35:06', '2017-01-02 09:35:06', 'MP, Naresh R, 3, DC,U, sofa-cover-normal, 5 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(6, 33, 4, 1, 4, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-W-saree-polishing-1 of 5', NULL, NULL, '020117093508736', '020117093508736', 0, '2017-01-02 09:35:10', '2017-01-02 09:35:10', 'MP, Naresh R, 3, DC,W, saree-polishing, 1 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(7, 33, 4, 1, 4, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-W-saree-polishing-2 of 5', NULL, NULL, '020117093508821', '020117093508821', 0, '2017-01-02 09:35:10', '2017-01-02 09:35:10', 'MP, Naresh R, 3, DC,W, saree-polishing, 2 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(8, 33, 4, 1, 4, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-W-saree-polishing-3 of 5', NULL, NULL, '020117093508544', '020117093508544', 0, '2017-01-02 09:35:10', '2017-01-02 09:35:10', 'MP, Naresh R, 3, DC,W, saree-polishing, 3 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(9, 33, 4, 1, 4, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-W-saree-polishing-4 of 5', NULL, NULL, '020117093508346', '020117093508346', 0, '2017-01-02 09:35:10', '2017-01-02 09:35:10', 'MP, Naresh R, 3, DC,W, saree-polishing, 4 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(10, 33, 4, 1, 4, 'MP-WD-S-02012017-9904', 'MP-WD-S-02012017-9904-DC-W-saree-polishing-5 of 5', NULL, NULL, '020117093508441', '020117093508441', 0, '2017-01-02 09:35:10', '2017-01-02 09:35:10', 'MP, Naresh R, 3, DC,W, saree-polishing, 5 of 5, 10', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(11, 6, 1, 1, 6, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-M-pyjama-heavy-1 of 5', NULL, NULL, '020117093539436', '020117093539436', 0, '2017-01-02 09:35:41', '2017-01-02 09:35:41', 'MP, Naresh R, 4, SI,M, pyjama-heavy, 1 of 5, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(12, 6, 1, 1, 6, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-M-pyjama-heavy-2 of 5', NULL, NULL, '020117093539338', '020117093539338', 0, '2017-01-02 09:35:41', '2017-01-02 09:35:41', 'MP, Naresh R, 4, SI,M, pyjama-heavy, 2 of 5, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(13, 6, 1, 1, 6, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-M-pyjama-heavy-3 of 5', NULL, NULL, '020117093539782', '020117093539782', 0, '2017-01-02 09:35:41', '2017-01-02 09:35:41', 'MP, Naresh R, 4, SI,M, pyjama-heavy, 3 of 5, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(14, 6, 1, 1, 6, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-M-pyjama-heavy-4 of 5', NULL, NULL, '020117093539803', '020117093539803', 0, '2017-01-02 09:35:41', '2017-01-02 09:35:41', 'MP, Naresh R, 4, SI,M, pyjama-heavy, 4 of 5, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(15, 6, 1, 1, 6, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-M-pyjama-heavy-5 of 5', NULL, NULL, '020117093539143', '020117093539143', 0, '2017-01-02 09:35:41', '2017-01-02 09:35:41', 'MP, Naresh R, 4, SI,M, pyjama-heavy, 5 of 5, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(16, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-1 of 8', NULL, NULL, '020117093543158', '020117093543158', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 1 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(17, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-2 of 8', NULL, NULL, '020117093543987', '020117093543987', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 2 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(18, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-3 of 8', NULL, NULL, '020117093543492', '020117093543492', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 3 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(19, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-4 of 8', NULL, NULL, '020117093543923', '020117093543923', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 4 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(20, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-5 of 8', NULL, NULL, '020117093543945', '020117093543945', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 5 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(21, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-6 of 8', NULL, NULL, '020117093543565', '020117093543565', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 6 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(22, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-7 of 8', NULL, NULL, '020117093543180', '020117093543180', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 7 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(23, 26, 1, 1, 7, 'MP-SI-S-02012017-2410', 'MP-SI-S-02012017-2410-SI-W-pyjama-heavy-or-silk-8 of 8', NULL, NULL, '020117093543612', '020117093543612', 0, '2017-01-02 09:35:48', '2017-01-02 09:35:48', 'MP, Naresh R, 4, SI,W, pyjama-heavy-or-silk, 8 of 8, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(24, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-1 of 12', NULL, 'Rock Star', '020117094820748', '020117094820748', 0, '2017-01-02 09:48:47', '2017-01-02 09:48:47', 'MP, ambadas k, 8, SI,M, trouser, 1 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(25, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-2 of 12', NULL, 'Gadwal', '020117094820389', '020117094820389', 0, '2017-01-02 09:48:47', '2017-01-02 09:48:47', 'MP, ambadas k, 8, SI,M, trouser, 2 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(26, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-3 of 12', NULL, 'Colors', '020117094820679', '020117094820679', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 3 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(27, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-4 of 12', NULL, 'Pan America', '020117094820356', '020117094820356', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 4 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(28, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-5 of 12', NULL, 'Rock Star', '020117094820981', '020117094820981', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 5 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(29, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-6 of 12', NULL, 'Colors', '020117094820620', '020117094820620', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 6 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(30, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-7 of 12', NULL, 'Pan America', '020117094820542', '020117094820542', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 7 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(31, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-8 of 12', NULL, 'Rock Star', '020117094820306', '020117094820306', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 8 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(32, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-9 of 12', NULL, 'No Brand', '020117094820242', '020117094820242', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 9 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(33, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-10 of 12', NULL, 'Rock Star', '020117094820196', '020117094820196', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 10 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(34, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-11 of 12', NULL, 'Pan America', '020117094820937', '020117094820937', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 11 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(35, 3, 1, 2, 17, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-trouser-12 of 12', NULL, 'Colors', '020117094820710', '020117094820710', 0, '2017-01-02 09:48:48', '2017-01-02 09:48:48', 'MP, ambadas k, 8, SI,M, trouser, 12 of 12, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(36, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-1 of 9', NULL, NULL, '020117094850528', '020117094850528', 0, '2017-01-02 09:48:54', '2017-01-02 09:48:54', 'MP, ambadas k, 8, SI,W, salwar, 1 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(37, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-2 of 9', NULL, NULL, '020117094850775', '020117094850775', 0, '2017-01-02 09:48:54', '2017-01-02 09:48:54', 'MP, ambadas k, 8, SI,W, salwar, 2 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(38, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-3 of 9', NULL, NULL, '020117094850937', '020117094850937', 0, '2017-01-02 09:48:54', '2017-01-02 09:48:54', 'MP, ambadas k, 8, SI,W, salwar, 3 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(39, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-4 of 9', NULL, NULL, '020117094850305', '020117094850305', 0, '2017-01-02 09:48:54', '2017-01-02 09:48:54', 'MP, ambadas k, 8, SI,W, salwar, 4 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(40, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-5 of 9', NULL, NULL, '020117094850685', '020117094850685', 0, '2017-01-02 09:48:54', '2017-01-02 09:48:54', 'MP, ambadas k, 8, SI,W, salwar, 5 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(41, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-6 of 9', NULL, NULL, '020117094850868', '020117094850868', 0, '2017-01-02 09:48:54', '2017-01-02 09:48:54', 'MP, ambadas k, 8, SI,W, salwar, 6 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(42, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-7 of 9', NULL, NULL, '020117094850963', '020117094850963', 0, '2017-01-02 09:48:55', '2017-01-02 09:48:55', 'MP, ambadas k, 8, SI,W, salwar, 7 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(43, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-8 of 9', NULL, NULL, '020117094850972', '020117094850972', 0, '2017-01-02 09:48:55', '2017-01-02 09:48:55', 'MP, ambadas k, 8, SI,W, salwar, 8 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(44, 27, 1, 2, 18, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-W-salwar-9 of 9', NULL, NULL, '020117094850910', '020117094850910', 0, '2017-01-02 09:48:55', '2017-01-02 09:48:55', 'MP, ambadas k, 8, SI,W, salwar, 9 of 9, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(45, 61, 1, 2, 19, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-K-jeans-1 of 5', NULL, 'Gadwal', '020117094857333', '020117094857333', 0, '2017-01-02 09:49:10', '2017-01-02 09:49:10', 'MP, ambadas k, 8, SI,K, jeans, 1 of 5, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(46, 61, 1, 2, 19, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-K-jeans-2 of 5', NULL, 'Gadwal', '020117094857987', '020117094857987', 0, '2017-01-02 09:49:10', '2017-01-02 09:49:10', 'MP, ambadas k, 8, SI,K, jeans, 2 of 5, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(47, 61, 1, 2, 19, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-K-jeans-3 of 5', NULL, 'Rock Star', '020117094857549', '020117094857549', 0, '2017-01-02 09:49:10', '2017-01-02 09:49:10', 'MP, ambadas k, 8, SI,K, jeans, 3 of 5, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(48, 61, 1, 2, 19, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-K-jeans-4 of 5', NULL, 'Colors', '020117094857951', '020117094857951', 0, '2017-01-02 09:49:10', '2017-01-02 09:49:10', 'MP, ambadas k, 8, SI,K, jeans, 4 of 5, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(49, 61, 1, 2, 19, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-K-jeans-5 of 5', NULL, 'Pan America', '020117094857380', '020117094857380', 0, '2017-01-02 09:49:10', '2017-01-02 09:49:10', 'MP, ambadas k, 8, SI,K, jeans, 5 of 5, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(50, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-1 of 10', NULL, NULL, '020117094913532', '020117094913532', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 1 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(51, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-2 of 10', NULL, NULL, '020117094913918', '020117094913918', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 2 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(52, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-3 of 10', NULL, NULL, '020117094913106', '020117094913106', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 3 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(53, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-4 of 10', NULL, NULL, '020117094913868', '020117094913868', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 4 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(54, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-5 of 10', NULL, NULL, '020117094913469', '020117094913469', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 5 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(55, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-6 of 10', NULL, NULL, '020117094913815', '020117094913815', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 6 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(56, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-7 of 10', NULL, NULL, '020117094913818', '020117094913818', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 7 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(57, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-8 of 10', NULL, NULL, '020117094913307', '020117094913307', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 8 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(58, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-9 of 10', NULL, NULL, '020117094913320', '020117094913320', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 9 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(59, 1, 1, 2, 20, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-M-shirt-10 of 10', NULL, NULL, '020117094913324', '020117094913324', 0, '2017-01-02 09:49:19', '2017-01-02 09:49:19', 'MP, ambadas k, 8, SI,M, shirt, 10 of 10, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(60, 74, 1, 2, 21, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-U-bed-sheet-double-1 of 2', 'pink', 'Gadwal', '020117094922587', '020117094922587', 0, '2017-01-02 09:49:34', '2017-01-02 09:49:34', 'MP, ambadas k, 8, SI,U, bed-sheet-double, 1 of 2, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(61, 74, 1, 2, 21, 'MP-SI-S-02012017-5547', 'MP-SI-S-02012017-5547-SI-U-bed-sheet-double-2 of 2', 'green', 'Colors', '020117094922356', '020117094922356', 0, '2017-01-02 09:49:34', '2017-01-02 09:49:34', 'MP, ambadas k, 8, SI,U, bed-sheet-double, 2 of 2, 38', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(62, 60, 3, 2, 14, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-K-trouser-1 of 4', NULL, 'Rock Star', '020117094951331', '020117094951331', 0, '2017-01-02 09:50:09', '2017-01-02 09:50:09', 'MP, ambadas k, 7, WI,K, trouser, 1 of 4, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(63, 60, 3, 2, 14, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-K-trouser-2 of 4', NULL, 'Rock Star', '020117094951422', '020117094951422', 0, '2017-01-02 09:50:09', '2017-01-02 09:50:09', 'MP, ambadas k, 7, WI,K, trouser, 2 of 4, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(64, 60, 3, 2, 14, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-K-trouser-3 of 4', NULL, 'Pan America', '020117094951808', '020117094951808', 0, '2017-01-02 09:50:09', '2017-01-02 09:50:09', 'MP, ambadas k, 7, WI,K, trouser, 3 of 4, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(65, 60, 3, 2, 14, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-K-trouser-4 of 4', NULL, 'Gadwal', '020117094951577', '020117094951577', 0, '2017-01-02 09:50:09', '2017-01-02 09:50:09', 'MP, ambadas k, 7, WI,K, trouser, 4 of 4, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(66, 40, 3, 2, 15, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-W-long-dress-normal-1 of 6', NULL, NULL, '020117095012911', '020117095012911', 0, '2017-01-02 09:50:21', '2017-01-02 09:50:21', 'MP, ambadas k, 7, WI,W, long-dress-normal, 1 of 6, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(67, 40, 3, 2, 15, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-W-long-dress-normal-2 of 6', NULL, 'No Brand', '020117095012790', '020117095012790', 0, '2017-01-02 09:50:21', '2017-01-02 09:50:21', 'MP, ambadas k, 7, WI,W, long-dress-normal, 2 of 6, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(68, 40, 3, 2, 15, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-W-long-dress-normal-3 of 6', NULL, 'No Brand', '020117095012316', '020117095012316', 0, '2017-01-02 09:50:21', '2017-01-02 09:50:21', 'MP, ambadas k, 7, WI,W, long-dress-normal, 3 of 6, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(69, 40, 3, 2, 15, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-W-long-dress-normal-4 of 6', NULL, 'Rock Star', '020117095012523', '020117095012523', 0, '2017-01-02 09:50:21', '2017-01-02 09:50:21', 'MP, ambadas k, 7, WI,W, long-dress-normal, 4 of 6, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(70, 40, 3, 2, 15, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-W-long-dress-normal-5 of 6', NULL, 'Colors', '020117095012689', '020117095012689', 0, '2017-01-02 09:50:22', '2017-01-02 09:50:22', 'MP, ambadas k, 7, WI,W, long-dress-normal, 5 of 6, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(71, 40, 3, 2, 15, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-W-long-dress-normal-6 of 6', NULL, NULL, '020117095012897', '020117095012897', 0, '2017-01-02 09:50:22', '2017-01-02 09:50:22', 'MP, ambadas k, 7, WI,W, long-dress-normal, 6 of 6, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(72, 8, 3, 2, 16, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-M-jeans-1 of 3', 'red', 'Colors', '020117095024974', '020117095024974', 0, '2017-01-02 09:50:40', '2017-01-02 09:50:40', 'MP, ambadas k, 7, WI,M, jeans, 1 of 3, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(73, 8, 3, 2, 16, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-M-jeans-2 of 3', 'yellow', 'Gadwal', '020117095024868', '020117095024868', 0, '2017-01-02 09:50:40', '2017-01-02 09:50:40', 'MP, ambadas k, 7, WI,M, jeans, 2 of 3, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(74, 8, 3, 2, 16, 'MP-WD-S-02012017-2567', 'MP-WD-S-02012017-2567-WI-M-jeans-3 of 3', 'blue', 'Gadwal', '020117095024760', '020117095024760', 0, '2017-01-02 09:50:40', '2017-01-02 09:50:40', 'MP, ambadas k, 7, WI,M, jeans, 3 of 3, 13', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(75, 26, 3, 2, 11, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-WI-W-pyjama-heavy-or-silk-1 of 4', NULL, 'Rock Star', '020117095052684', '020117095052684', 0, '2017-01-02 09:51:29', '2017-01-02 09:51:29', 'MP, ambadas k, 6, WI,W, pyjama-heavy-or-silk, 1 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(76, 26, 3, 2, 11, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-WI-W-pyjama-heavy-or-silk-2 of 4', NULL, 'Pan America', '020117095052962', '020117095052962', 0, '2017-01-02 09:51:29', '2017-01-02 09:51:29', 'MP, ambadas k, 6, WI,W, pyjama-heavy-or-silk, 2 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(77, 26, 3, 2, 11, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-WI-W-pyjama-heavy-or-silk-3 of 4', NULL, 'Rock Star', '020117095052921', '020117095052921', 0, '2017-01-02 09:51:30', '2017-01-02 09:51:30', 'MP, ambadas k, 6, WI,W, pyjama-heavy-or-silk, 3 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(78, 26, 3, 2, 11, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-WI-W-pyjama-heavy-or-silk-4 of 4', NULL, 'Colors', '020117095052526', '020117095052526', 0, '2017-01-02 09:51:30', '2017-01-02 09:51:30', 'MP, ambadas k, 6, WI,W, pyjama-heavy-or-silk, 4 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(79, 1, 4, 2, 12, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-M-shirt-1 of 5', NULL, 'Gadwal', '020117095132267', '020117095132267', 0, '2017-01-02 09:51:56', '2017-01-02 09:51:56', 'MP, ambadas k, 6, DC,M, shirt, 1 of 5, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(80, 1, 4, 2, 12, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-M-shirt-2 of 5', NULL, 'Rock Star', '020117095132324', '020117095132324', 0, '2017-01-02 09:51:56', '2017-01-02 09:51:56', 'MP, ambadas k, 6, DC,M, shirt, 2 of 5, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(81, 1, 4, 2, 12, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-M-shirt-3 of 5', NULL, 'Rock Star', '020117095132264', '020117095132264', 0, '2017-01-02 09:51:56', '2017-01-02 09:51:56', 'MP, ambadas k, 6, DC,M, shirt, 3 of 5, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(82, 1, 4, 2, 12, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-M-shirt-4 of 5', NULL, 'Colors', '020117095132284', '020117095132284', 0, '2017-01-02 09:51:57', '2017-01-02 09:51:57', 'MP, ambadas k, 6, DC,M, shirt, 4 of 5, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(83, 1, 4, 2, 12, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-M-shirt-5 of 5', NULL, 'Pan America', '020117095132965', '020117095132965', 0, '2017-01-02 09:51:57', '2017-01-02 09:51:57', 'MP, ambadas k, 6, DC,M, shirt, 5 of 5, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(84, 74, 4, 2, 13, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-U-bed-sheet-double-1 of 4', NULL, 'Rock Star', '020117095159955', '020117095159955', 0, '2017-01-02 09:52:18', '2017-01-02 09:52:18', 'MP, ambadas k, 6, DC,U, bed-sheet-double, 1 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(85, 74, 4, 2, 13, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-U-bed-sheet-double-2 of 4', NULL, 'Gadwal', '020117095159877', '020117095159877', 0, '2017-01-02 09:52:18', '2017-01-02 09:52:18', 'MP, ambadas k, 6, DC,U, bed-sheet-double, 2 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(86, 74, 4, 2, 13, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-U-bed-sheet-double-3 of 4', NULL, 'Pan America', '020117095159958', '020117095159958', 0, '2017-01-02 09:52:18', '2017-01-02 09:52:18', 'MP, ambadas k, 6, DC,U, bed-sheet-double, 3 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(87, 74, 4, 2, 13, 'MP-WD-S-02012017-2938', 'MP-WD-S-02012017-2938-DC-U-bed-sheet-double-4 of 4', NULL, 'Pan America', '020117095159424', '020117095159424', 0, '2017-01-02 09:52:18', '2017-01-02 09:52:18', 'MP, ambadas k, 6, DC,U, bed-sheet-double, 4 of 4, 13', 'ORD', 'Order Ready To Deliver', 1, NULL, NULL, NULL),
(88, 1, 1, 2, 8, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-M-shirt-1 of 5', NULL, NULL, '020117095237999', '020117095237999', 0, '2017-01-02 09:52:44', '2017-01-02 09:52:44', 'MP, ambadas k, 5, SI,M, shirt, 1 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(89, 1, 1, 2, 8, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-M-shirt-2 of 5', NULL, NULL, '020117095237762', '020117095237762', 0, '2017-01-02 09:52:44', '2017-01-02 09:52:44', 'MP, ambadas k, 5, SI,M, shirt, 2 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(90, 1, 1, 2, 8, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-M-shirt-3 of 5', NULL, NULL, '020117095237330', '020117095237330', 0, '2017-01-02 09:52:44', '2017-01-02 09:52:44', 'MP, ambadas k, 5, SI,M, shirt, 3 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(91, 1, 1, 2, 8, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-M-shirt-4 of 5', NULL, NULL, '020117095237370', '020117095237370', 0, '2017-01-02 09:52:44', '2017-01-02 09:52:44', 'MP, ambadas k, 5, SI,M, shirt, 4 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(92, 1, 1, 2, 8, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-M-shirt-5 of 5', NULL, NULL, '020117095237423', '020117095237423', 0, '2017-01-02 09:52:44', '2017-01-02 09:52:44', 'MP, ambadas k, 5, SI,M, shirt, 5 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(93, 23, 1, 2, 9, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-W-kameez-normal-1 of 4', NULL, NULL, '020117095247652', '020117095247652', 0, '2017-01-02 09:52:49', '2017-01-02 09:52:49', 'MP, ambadas k, 5, SI,W, kameez-normal, 1 of 4, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(94, 23, 1, 2, 9, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-W-kameez-normal-2 of 4', NULL, NULL, '020117095247884', '020117095247884', 0, '2017-01-02 09:52:49', '2017-01-02 09:52:49', 'MP, ambadas k, 5, SI,W, kameez-normal, 2 of 4, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(95, 23, 1, 2, 9, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-W-kameez-normal-3 of 4', NULL, NULL, '020117095247185', '020117095247185', 0, '2017-01-02 09:52:50', '2017-01-02 09:52:50', 'MP, ambadas k, 5, SI,W, kameez-normal, 3 of 4, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(96, 23, 1, 2, 9, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-W-kameez-normal-4 of 4', NULL, NULL, '020117095247662', '020117095247662', 0, '2017-01-02 09:52:50', '2017-01-02 09:52:50', 'MP, ambadas k, 5, SI,W, kameez-normal, 4 of 4, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(97, 61, 1, 2, 10, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-K-jeans-1 of 5', NULL, NULL, '020117095251760', '020117095251760', 0, '2017-01-02 09:52:59', '2017-01-02 09:52:59', 'MP, ambadas k, 5, SI,K, jeans, 1 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(98, 61, 1, 2, 10, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-K-jeans-2 of 5', NULL, NULL, '020117095251835', '020117095251835', 0, '2017-01-02 09:53:00', '2017-01-02 09:53:00', 'MP, ambadas k, 5, SI,K, jeans, 2 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(99, 61, 1, 2, 10, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-K-jeans-3 of 5', NULL, NULL, '020117095251714', '020117095251714', 0, '2017-01-02 09:53:00', '2017-01-02 09:53:00', 'MP, ambadas k, 5, SI,K, jeans, 3 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(100, 61, 1, 2, 10, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-K-jeans-4 of 5', NULL, NULL, '020117095251151', '020117095251151', 0, '2017-01-02 09:53:00', '2017-01-02 09:53:00', 'MP, ambadas k, 5, SI,K, jeans, 4 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(101, 61, 1, 2, 10, 'MP-SI-S-02012017-9268', 'MP-SI-S-02012017-9268-SI-K-jeans-5 of 5', NULL, NULL, '020117095251944', '020117095251944', 0, '2017-01-02 09:53:00', '2017-01-02 09:53:00', 'MP, ambadas k, 5, SI,K, jeans, 5 of 5, 14', 'DOA', 'Delivery Order Approved', 1, NULL, NULL, NULL),
(102, 4, 4, 1, 50, 'MP-WD-M-03012017-5108', 'MP-WD-M-03012017-5108-DC-M-shorts-1 of 1', NULL, NULL, '030117103411126', NULL, 0, '2017-01-03 10:34:13', '2017-01-03 10:34:13', 'MP, Naresh R, 1000022, DC,M, shorts, 1 of 1, 2', 'return', 'return', 1, 'return', NULL, NULL),
(103, 5, 4, 1, 51, 'MP-WD-M-03012017-5108', 'MP-WD-M-03012017-5108-DC-M-safari-suit-1 of 1', NULL, NULL, '030117103415182', NULL, 0, '2017-01-03 10:34:16', '2017-01-03 10:34:16', 'MP, Naresh R, 1000022, DC,M, safari-suit, 1 of 1, 2', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(104, 5, 1, 1, 61, 'MP-SI-M-03012017-5743', 'MP-SI-M-03012017-5743-SI-M-safari-suit-1 of 4', NULL, NULL, '030117103428741', NULL, 0, '2017-01-03 10:34:29', '2017-01-03 10:34:29', 'MP, Naresh R, 21, SI,M, safari-suit, 1 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(105, 5, 1, 1, 61, 'MP-SI-M-03012017-5743', 'MP-SI-M-03012017-5743-SI-M-safari-suit-2 of 4', NULL, NULL, '030117103428263', NULL, 0, '2017-01-03 10:34:29', '2017-01-03 10:34:29', 'MP, Naresh R, 21, SI,M, safari-suit, 2 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(106, 5, 1, 1, 61, 'MP-SI-M-03012017-5743', 'MP-SI-M-03012017-5743-SI-M-safari-suit-3 of 4', NULL, NULL, '030117103428441', NULL, 0, '2017-01-03 10:34:30', '2017-01-03 10:34:30', 'MP, Naresh R, 21, SI,M, safari-suit, 3 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(107, 5, 1, 1, 61, 'MP-SI-M-03012017-5743', 'MP-SI-M-03012017-5743-SI-M-safari-suit-4 of 4', NULL, NULL, '030117103428595', NULL, 0, '2017-01-03 10:34:30', '2017-01-03 10:34:30', 'MP, Naresh R, 21, SI,M, safari-suit, 4 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(108, 2, 1, 1, 63, 'MP-SI-S-04012017-4315', 'MP-SI-S-04012017-4315-SI-M-t-shirt-1 of 4', NULL, NULL, '040117122252512', NULL, 0, '2017-01-04 12:22:55', '2017-01-04 12:22:55', 'MP, Naresh R, 1000024, SI,M, t-shirt, 1 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(109, 2, 1, 1, 63, 'MP-SI-S-04012017-4315', 'MP-SI-S-04012017-4315-SI-M-t-shirt-2 of 4', NULL, NULL, '040117122252243', NULL, 0, '2017-01-04 12:22:56', '2017-01-04 12:22:56', 'MP, Naresh R, 1000024, SI,M, t-shirt, 2 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(110, 2, 1, 1, 63, 'MP-SI-S-04012017-4315', 'MP-SI-S-04012017-4315-SI-M-t-shirt-3 of 4', NULL, NULL, '040117122252861', NULL, 0, '2017-01-04 12:22:56', '2017-01-04 12:22:56', 'MP, Naresh R, 1000024, SI,M, t-shirt, 3 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(111, 2, 1, 1, 63, 'MP-SI-S-04012017-4315', 'MP-SI-S-04012017-4315-SI-M-t-shirt-4 of 4', NULL, NULL, '040117122252280', NULL, 0, '2017-01-04 12:22:56', '2017-01-04 12:22:56', 'MP, Naresh R, 1000024, SI,M, t-shirt, 4 of 4, 4', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(112, 1, 1, 1, 68, 'MP-SI-S-11012017-5563', 'MP-SI-S-11012017-5563-SI-M-shirt-1 of 2', NULL, NULL, '110117094729648', NULL, 0, '2017-01-11 09:47:36', '2017-01-11 09:47:36', 'MP, Naresh R, 1000027, SI,M, shirt, 1 of 2, 2', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(113, 1, 1, 1, 68, 'MP-SI-S-11012017-5563', 'MP-SI-S-11012017-5563-SI-M-shirt-2 of 2', NULL, NULL, '110117094729413', NULL, 0, '2017-01-11 09:47:37', '2017-01-11 09:47:37', 'MP, Naresh R, 1000027, SI,M, shirt, 2 of 2, 2', 'CUPA', ' Central Unit Pickup Boy Approved', 1, NULL, NULL, NULL),
(114, 2, 1, 1, 66, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-M-t-shirt-1 of 4', NULL, NULL, '180117082307168', NULL, 0, '2017-01-18 08:23:15', '2017-01-18 08:23:15', 'MP, Naresh R, 1000026, SI,M, t-shirt, 1 of 4, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(115, 2, 1, 1, 66, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-M-t-shirt-2 of 4', NULL, NULL, '180117082307546', NULL, 0, '2017-01-18 08:23:15', '2017-01-18 08:23:15', 'MP, Naresh R, 1000026, SI,M, t-shirt, 2 of 4, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(116, 2, 1, 1, 66, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-M-t-shirt-3 of 4', NULL, NULL, '180117082307714', NULL, 0, '2017-01-18 08:23:15', '2017-01-18 08:23:15', 'MP, Naresh R, 1000026, SI,M, t-shirt, 3 of 4, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(117, 2, 1, 1, 66, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-M-t-shirt-4 of 4', NULL, NULL, '180117082307354', NULL, 0, '2017-01-18 08:23:15', '2017-01-18 08:23:15', 'MP, Naresh R, 1000026, SI,M, t-shirt, 4 of 4, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(118, 58, 1, 1, 67, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-K-shirt-1 of 5', NULL, NULL, '180117082317416', NULL, 0, '2017-01-18 08:23:26', '2017-01-18 08:23:26', 'MP, Naresh R, 1000026, SI,K, shirt, 1 of 5, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(119, 58, 1, 1, 67, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-K-shirt-2 of 5', NULL, NULL, '180117082317878', NULL, 0, '2017-01-18 08:23:26', '2017-01-18 08:23:26', 'MP, Naresh R, 1000026, SI,K, shirt, 2 of 5, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(120, 58, 1, 1, 67, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-K-shirt-3 of 5', NULL, NULL, '180117082317168', NULL, 0, '2017-01-18 08:23:27', '2017-01-18 08:23:27', 'MP, Naresh R, 1000026, SI,K, shirt, 3 of 5, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(121, 58, 1, 1, 67, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-K-shirt-4 of 5', NULL, NULL, '180117082317837', NULL, 0, '2017-01-18 08:23:27', '2017-01-18 08:23:27', 'MP, Naresh R, 1000026, SI,K, shirt, 4 of 5, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(122, 58, 1, 1, 67, 'MP-SI-S-10012017-7884', 'MP-SI-S-10012017-7884-SI-K-shirt-5 of 5', NULL, NULL, '180117082317500', NULL, 0, '2017-01-18 08:23:27', '2017-01-18 08:23:27', 'MP, Naresh R, 1000026, SI,K, shirt, 5 of 5, 9', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(123, 1, 3, 1, 64, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-M-shirt-1 of 5', NULL, NULL, '180117082359426', NULL, 0, '2017-01-18 08:24:00', '2017-01-18 08:24:00', 'MP, Naresh R, 1000025, WI,M, shirt, 1 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(124, 1, 3, 1, 64, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-M-shirt-2 of 5', NULL, NULL, '180117082359691', NULL, 0, '2017-01-18 08:24:00', '2017-01-18 08:24:00', 'MP, Naresh R, 1000025, WI,M, shirt, 2 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(125, 1, 3, 1, 64, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-M-shirt-3 of 5', NULL, NULL, '180117082359246', NULL, 0, '2017-01-18 08:24:00', '2017-01-18 08:24:00', 'MP, Naresh R, 1000025, WI,M, shirt, 3 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(126, 1, 3, 1, 64, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-M-shirt-4 of 5', NULL, NULL, '180117082359288', NULL, 0, '2017-01-18 08:24:00', '2017-01-18 08:24:00', 'MP, Naresh R, 1000025, WI,M, shirt, 4 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(127, 1, 3, 1, 64, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-M-shirt-5 of 5', NULL, NULL, '180117082359620', NULL, 0, '2017-01-18 08:24:00', '2017-01-18 08:24:00', 'MP, Naresh R, 1000025, WI,M, shirt, 5 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(128, 20, 3, 1, 65, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-W-dupatta-normal-1 of 3', NULL, NULL, '180117082402308', NULL, 0, '2017-01-18 08:24:07', '2017-01-18 08:24:07', 'MP, Naresh R, 1000025, WI,W, dupatta-normal, 1 of 3, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(129, 20, 3, 1, 65, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-W-dupatta-normal-2 of 3', NULL, NULL, '180117082402548', NULL, 0, '2017-01-18 08:24:07', '2017-01-18 08:24:07', 'MP, Naresh R, 1000025, WI,W, dupatta-normal, 2 of 3, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(130, 20, 3, 1, 65, 'MP-WD-S-10012017-5433', 'MP-WD-S-10012017-5433-WI-W-dupatta-normal-3 of 3', NULL, NULL, '180117082402438', NULL, 0, '2017-01-18 08:24:07', '2017-01-18 08:24:07', 'MP, Naresh R, 1000025, WI,W, dupatta-normal, 3 of 3, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(131, 1, 3, 1, 62, 'MP-WD-S-04012017-6324', 'MP-WD-S-04012017-6324-WI-M-shirt-1 of 3', NULL, NULL, '180117085806537', NULL, 0, '2017-01-18 08:58:07', '2017-01-18 08:58:07', 'MP, Naresh R, 1000023, WI,M, shirt, 1 of 3, 3', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(132, 1, 3, 1, 62, 'MP-WD-S-04012017-6324', 'MP-WD-S-04012017-6324-WI-M-shirt-2 of 3', NULL, NULL, '180117085806131', NULL, 0, '2017-01-18 08:58:08', '2017-01-18 08:58:08', 'MP, Naresh R, 1000023, WI,M, shirt, 2 of 3, 3', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(133, 1, 3, 1, 62, 'MP-WD-S-04012017-6324', 'MP-WD-S-04012017-6324-WI-M-shirt-3 of 3', NULL, NULL, '180117085806788', NULL, 0, '2017-01-18 08:58:08', '2017-01-18 08:58:08', 'MP, Naresh R, 1000023, WI,M, shirt, 3 of 3, 3', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(134, 3, 1, 1, 57, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-M-trouser-1 of 2', NULL, NULL, '180117085847436', NULL, 0, '2017-01-18 08:58:48', '2017-01-18 08:58:48', 'MP, Naresh R, 20, SI,M, trouser, 1 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(135, 3, 1, 1, 57, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-M-trouser-2 of 2', NULL, NULL, '180117085847281', NULL, 0, '2017-01-18 08:58:49', '2017-01-18 08:58:49', 'MP, Naresh R, 20, SI,M, trouser, 2 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(136, 23, 1, 1, 58, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-W-kameez-normal-1 of 2', NULL, NULL, '180117085850754', NULL, 0, '2017-01-18 08:58:52', '2017-01-18 08:58:52', 'MP, Naresh R, 20, SI,W, kameez-normal, 1 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(137, 23, 1, 1, 58, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-W-kameez-normal-2 of 2', NULL, NULL, '180117085850469', NULL, 0, '2017-01-18 08:58:52', '2017-01-18 08:58:52', 'MP, Naresh R, 20, SI,W, kameez-normal, 2 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(138, 61, 1, 1, 59, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-K-jeans-1 of 2', NULL, NULL, '180117085854176', NULL, 0, '2017-01-18 08:58:56', '2017-01-18 08:58:56', 'MP, Naresh R, 20, SI,K, jeans, 1 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(139, 61, 1, 1, 59, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-K-jeans-2 of 2', NULL, NULL, '180117085854318', NULL, 0, '2017-01-18 08:58:56', '2017-01-18 08:58:56', 'MP, Naresh R, 20, SI,K, jeans, 2 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(140, 74, 1, 1, 60, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-U-bed-sheet-double-1 of 2', NULL, NULL, '180117085857595', NULL, 0, '2017-01-18 08:59:00', '2017-01-18 08:59:00', 'MP, Naresh R, 20, SI,U, bed-sheet-double, 1 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(141, 74, 1, 1, 60, 'MP-SI-M-03012017-6187', 'MP-SI-M-03012017-6187-SI-U-bed-sheet-double-2 of 2', NULL, NULL, '180117085857274', NULL, 0, '2017-01-18 08:59:00', '2017-01-18 08:59:00', 'MP, Naresh R, 20, SI,U, bed-sheet-double, 2 of 2, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(142, 64, 1, 1, 39, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-K-schooluniform-per-piece-1 of 5', NULL, NULL, '180117090041493', NULL, 0, '2017-01-18 09:00:46', '2017-01-18 09:00:46', 'MP, Naresh R, 19, SI,K, schooluniform-per-piece, 1 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(143, 64, 1, 1, 39, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-K-schooluniform-per-piece-2 of 5', NULL, NULL, '180117090041455', NULL, 0, '2017-01-18 09:00:46', '2017-01-18 09:00:46', 'MP, Naresh R, 19, SI,K, schooluniform-per-piece, 2 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(144, 64, 1, 1, 39, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-K-schooluniform-per-piece-3 of 5', NULL, NULL, '180117090041531', NULL, 0, '2017-01-18 09:00:46', '2017-01-18 09:00:46', 'MP, Naresh R, 19, SI,K, schooluniform-per-piece, 3 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(145, 64, 1, 1, 39, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-K-schooluniform-per-piece-4 of 5', NULL, NULL, '180117090041955', NULL, 0, '2017-01-18 09:00:46', '2017-01-18 09:00:46', 'MP, Naresh R, 19, SI,K, schooluniform-per-piece, 4 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(146, 64, 1, 1, 39, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-K-schooluniform-per-piece-5 of 5', NULL, NULL, '180117090041934', NULL, 0, '2017-01-18 09:00:46', '2017-01-18 09:00:46', 'MP, Naresh R, 19, SI,K, schooluniform-per-piece, 5 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(147, 75, 1, 1, 40, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-U-bed-sheet-single-1 of 5', NULL, NULL, '180117090048986', NULL, 0, '2017-01-18 09:01:19', '2017-01-18 09:01:19', 'MP, Naresh R, 19, SI,U, bed-sheet-single, 1 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(148, 75, 1, 1, 40, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-U-bed-sheet-single-2 of 5', NULL, NULL, '180117090048758', NULL, 0, '2017-01-18 09:01:19', '2017-01-18 09:01:19', 'MP, Naresh R, 19, SI,U, bed-sheet-single, 2 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(149, 75, 1, 1, 40, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-U-bed-sheet-single-3 of 5', NULL, NULL, '180117090048966', NULL, 0, '2017-01-18 09:01:20', '2017-01-18 09:01:20', 'MP, Naresh R, 19, SI,U, bed-sheet-single, 3 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(150, 75, 1, 1, 40, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-U-bed-sheet-single-4 of 5', NULL, NULL, '180117090048601', NULL, 0, '2017-01-18 09:01:20', '2017-01-18 09:01:20', 'MP, Naresh R, 19, SI,U, bed-sheet-single, 4 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(151, 75, 1, 1, 40, 'MP-SI-S-03012017-1256', 'MP-SI-S-03012017-1256-SI-U-bed-sheet-single-5 of 5', NULL, NULL, '180117090048723', NULL, 0, '2017-01-18 09:01:20', '2017-01-18 09:01:20', 'MP, Naresh R, 19, SI,U, bed-sheet-single, 5 of 5, 10', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(152, 4, 3, 1, 33, 'MP-WD-M-02012017-2673', 'MP-WD-M-02012017-2673-WI-M-shorts-1 of 3', NULL, NULL, '180117090428589', NULL, 0, '2017-01-18 09:04:29', '2017-01-18 09:04:29', 'MP, Naresh R, 14, WI,M, shorts, 1 of 3, 3', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(153, 4, 3, 1, 33, 'MP-WD-M-02012017-2673', 'MP-WD-M-02012017-2673-WI-M-shorts-2 of 3', NULL, NULL, '180117090428168', NULL, 0, '2017-01-18 09:04:30', '2017-01-18 09:04:30', 'MP, Naresh R, 14, WI,M, shorts, 2 of 3, 3', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(154, 4, 3, 1, 33, 'MP-WD-M-02012017-2673', 'MP-WD-M-02012017-2673-WI-M-shorts-3 of 3', NULL, NULL, '180117090428140', NULL, 0, '2017-01-18 09:04:30', '2017-01-18 09:04:30', 'MP, Naresh R, 14, WI,M, shorts, 3 of 3, 3', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(155, 4, 1, 1, 32, 'MP-SI-M-02012017-2182', 'MP-SI-M-02012017-2182-SI-M-shorts-1 of 5', NULL, NULL, '180117092046681', NULL, 0, '2017-01-18 09:20:47', '2017-01-18 09:20:47', 'MP, Naresh R, 13, SI,M, shorts, 1 of 5, 5', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(156, 4, 1, 1, 32, 'MP-SI-M-02012017-2182', 'MP-SI-M-02012017-2182-SI-M-shorts-2 of 5', NULL, NULL, '180117092046168', NULL, 0, '2017-01-18 09:20:48', '2017-01-18 09:20:48', 'MP, Naresh R, 13, SI,M, shorts, 2 of 5, 5', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(157, 4, 1, 1, 32, 'MP-SI-M-02012017-2182', 'MP-SI-M-02012017-2182-SI-M-shorts-3 of 5', NULL, NULL, '180117092046166', NULL, 0, '2017-01-18 09:20:48', '2017-01-18 09:20:48', 'MP, Naresh R, 13, SI,M, shorts, 3 of 5, 5', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(158, 4, 1, 1, 32, 'MP-SI-M-02012017-2182', 'MP-SI-M-02012017-2182-SI-M-shorts-4 of 5', NULL, NULL, '180117092046614', NULL, 0, '2017-01-18 09:20:48', '2017-01-18 09:20:48', 'MP, Naresh R, 13, SI,M, shorts, 4 of 5, 5', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(159, 4, 1, 1, 32, 'MP-SI-M-02012017-2182', 'MP-SI-M-02012017-2182-SI-M-shorts-5 of 5', NULL, NULL, '180117092046929', NULL, 0, '2017-01-18 09:20:48', '2017-01-18 09:20:48', 'MP, Naresh R, 13, SI,M, shorts, 5 of 5, 5', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(160, 3, 1, 1, 36, 'MP-SI-M-02012017-9349', 'MP-SI-M-02012017-9349-SI-M-trouser-1 of 2', NULL, NULL, '180117092133649', NULL, 0, '2017-01-18 09:21:34', '2017-01-18 09:21:34', 'MP, Naresh R, 17, SI,M, trouser, 1 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(161, 3, 1, 1, 36, 'MP-SI-M-02012017-9349', 'MP-SI-M-02012017-9349-SI-M-trouser-2 of 2', NULL, NULL, '180117092133933', NULL, 0, '2017-01-18 09:21:34', '2017-01-18 09:21:34', 'MP, Naresh R, 17, SI,M, trouser, 2 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(162, 32, 4, 1, 37, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-DC-W-saree-heavy-or-designer-1 of 4', NULL, NULL, '180117092214789', NULL, 0, '2017-01-18 09:22:15', '2017-01-18 09:22:15', 'MP, Naresh R, 18, DC,W, saree-heavy-or-designer, 1 of 4, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(163, 32, 4, 1, 37, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-DC-W-saree-heavy-or-designer-2 of 4', NULL, NULL, '180117092214727', NULL, 0, '2017-01-18 09:22:16', '2017-01-18 09:22:16', 'MP, Naresh R, 18, DC,W, saree-heavy-or-designer, 2 of 4, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(164, 32, 4, 1, 37, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-DC-W-saree-heavy-or-designer-3 of 4', NULL, NULL, '180117092214909', NULL, 0, '2017-01-18 09:22:16', '2017-01-18 09:22:16', 'MP, Naresh R, 18, DC,W, saree-heavy-or-designer, 3 of 4, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(165, 32, 4, 1, 37, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-DC-W-saree-heavy-or-designer-4 of 4', NULL, NULL, '180117092214864', NULL, 0, '2017-01-18 09:22:16', '2017-01-18 09:22:16', 'MP, Naresh R, 18, DC,W, saree-heavy-or-designer, 4 of 4, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(166, 88, 3, 1, 38, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-WI-U-sofa-cover-heavy-1 of 3', NULL, NULL, '180117092217175', NULL, 0, '2017-01-18 09:22:19', '2017-01-18 09:22:19', 'MP, Naresh R, 18, WI,U, sofa-cover-heavy, 1 of 3, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(167, 88, 3, 1, 38, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-WI-U-sofa-cover-heavy-2 of 3', NULL, NULL, '180117092217760', NULL, 0, '2017-01-18 09:22:19', '2017-01-18 09:22:19', 'MP, Naresh R, 18, WI,U, sofa-cover-heavy, 2 of 3, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(168, 88, 3, 1, 38, 'MP-WD-S-03012017-7752', 'MP-WD-S-03012017-7752-WI-U-sofa-cover-heavy-3 of 3', NULL, NULL, '180117092217367', NULL, 0, '2017-01-18 09:22:19', '2017-01-18 09:22:19', 'MP, Naresh R, 18, WI,U, sofa-cover-heavy, 3 of 3, 7', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(169, 5, 3, 1, 34, 'MP-WD-M-02012017-6450', 'MP-WD-M-02012017-6450-WI-M-safari-suit-1 of 2', NULL, NULL, '180117092255740', NULL, 0, '2017-01-18 09:23:01', '2017-01-18 09:23:01', 'MP, Naresh R, 15, WI,M, safari-suit, 1 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL);
INSERT INTO `process_orders` (`prco_id`, `item_id`, `service_id`, `cust_id`, `po_id`, `order_id`, `name`, `color`, `brand`, `inBarCode`, `outBarCode`, `status`, `updated_at`, `created_at`, `barCodeLabel`, `itemStatus`, `itemStatusMessage`, `store_id`, `returnGarmentStatus`, `returnGarmentStatusMessage`, `apartment_store_id`) VALUES
(170, 5, 3, 1, 34, 'MP-WD-M-02012017-6450', 'MP-WD-M-02012017-6450-WI-M-safari-suit-2 of 2', NULL, NULL, '180117092255331', NULL, 0, '2017-01-18 09:23:01', '2017-01-18 09:23:01', 'MP, Naresh R, 15, WI,M, safari-suit, 2 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(171, 5, 4, 1, 35, 'MP-WD-M-02012017-4070', 'MP-WD-M-02012017-4070-DC-M-safari-suit-1 of 2', NULL, NULL, '180117093658713', NULL, 0, '2017-01-18 09:37:00', '2017-01-18 09:37:00', 'MP, Naresh R, 16, DC,M, safari-suit, 1 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(172, 5, 4, 1, 35, 'MP-WD-M-02012017-4070', 'MP-WD-M-02012017-4070-DC-M-safari-suit-2 of 2', NULL, NULL, '180117093658739', NULL, 0, '2017-01-18 09:37:00', '2017-01-18 09:37:00', 'MP, Naresh R, 16, DC,M, safari-suit, 2 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(173, 3, 1, 1, 31, 'MP-SI-M-02012017-7933', 'MP-SI-M-02012017-7933-SI-M-trouser-1 of 2', NULL, NULL, '180117094006542', NULL, 0, '2017-01-18 09:40:07', '2017-01-18 09:40:07', 'MP, Naresh R, 12, SI,M, trouser, 1 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(174, 3, 1, 1, 31, 'MP-SI-M-02012017-7933', 'MP-SI-M-02012017-7933-SI-M-trouser-2 of 2', NULL, NULL, '180117094006799', NULL, 0, '2017-01-18 09:40:07', '2017-01-18 09:40:07', 'MP, Naresh R, 12, SI,M, trouser, 2 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(175, 1, 1, 1, 28, 'MP-SI-M-02012017-9324', 'MP-SI-M-02012017-9324-SI-M-shirt-1 of 2', NULL, NULL, '180117095402871', NULL, 0, '2017-01-18 09:54:04', '2017-01-18 09:54:04', 'MP, Naresh R, 11, SI,M, shirt, 1 of 2, 6', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(176, 1, 1, 1, 28, 'MP-SI-M-02012017-9324', 'MP-SI-M-02012017-9324-SI-M-shirt-2 of 2', NULL, NULL, '180117095402447', NULL, 0, '2017-01-18 09:54:05', '2017-01-18 09:54:05', 'MP, Naresh R, 11, SI,M, shirt, 2 of 2, 6', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(177, 2, 1, 1, 29, 'MP-SI-M-02012017-9324', 'MP-SI-M-02012017-9324-SI-M-t-shirt-1 of 2', NULL, NULL, '180117095407442', NULL, 0, '2017-01-18 09:54:09', '2017-01-18 09:54:09', 'MP, Naresh R, 11, SI,M, t-shirt, 1 of 2, 6', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(178, 2, 1, 1, 29, 'MP-SI-M-02012017-9324', 'MP-SI-M-02012017-9324-SI-M-t-shirt-2 of 2', NULL, NULL, '180117095407647', NULL, 0, '2017-01-18 09:54:09', '2017-01-18 09:54:09', 'MP, Naresh R, 11, SI,M, t-shirt, 2 of 2, 6', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(179, 4, 1, 1, 30, 'MP-SI-M-02012017-9324', 'MP-SI-M-02012017-9324-SI-M-shorts-1 of 2', NULL, NULL, '180117095411393', NULL, 0, '2017-01-18 09:54:12', '2017-01-18 09:54:12', 'MP, Naresh R, 11, SI,M, shorts, 1 of 2, 6', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(180, 4, 1, 1, 30, 'MP-SI-M-02012017-9324', 'MP-SI-M-02012017-9324-SI-M-shorts-2 of 2', NULL, NULL, '180117095411302', NULL, 0, '2017-01-18 09:54:12', '2017-01-18 09:54:12', 'MP, Naresh R, 11, SI,M, shorts, 2 of 2, 6', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(181, 1, 3, 1, 25, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-shirt-1 of 2', NULL, NULL, '180117095438656', NULL, 0, '2017-01-18 09:54:41', '2017-01-18 09:54:41', 'MP, Naresh R, 10, WI,M, shirt, 1 of 2, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(182, 1, 3, 1, 25, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-shirt-2 of 2', NULL, NULL, '180117095438565', NULL, 0, '2017-01-18 09:54:41', '2017-01-18 09:54:41', 'MP, Naresh R, 10, WI,M, shirt, 2 of 2, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(183, 2, 3, 1, 26, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-t-shirt-1 of 2', NULL, NULL, '180117095443382', NULL, 0, '2017-01-18 09:54:44', '2017-01-18 09:54:44', 'MP, Naresh R, 10, WI,M, t-shirt, 1 of 2, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(184, 2, 3, 1, 26, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-t-shirt-2 of 2', NULL, NULL, '180117095443983', NULL, 0, '2017-01-18 09:54:45', '2017-01-18 09:54:45', 'MP, Naresh R, 10, WI,M, t-shirt, 2 of 2, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(185, 3, 3, 1, 27, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-trouser-1 of 3', NULL, NULL, '180117095446603', NULL, 0, '2017-01-18 09:54:50', '2017-01-18 09:54:50', 'MP, Naresh R, 10, WI,M, trouser, 1 of 3, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(186, 3, 3, 1, 27, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-trouser-2 of 3', NULL, NULL, '180117095446711', NULL, 0, '2017-01-18 09:54:51', '2017-01-18 09:54:51', 'MP, Naresh R, 10, WI,M, trouser, 2 of 3, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(187, 3, 3, 1, 27, 'MP-WD-M-02012017-3810', 'MP-WD-M-02012017-3810-WI-M-trouser-3 of 3', NULL, NULL, '180117095446402', NULL, 0, '2017-01-18 09:54:51', '2017-01-18 09:54:51', 'MP, Naresh R, 10, WI,M, trouser, 3 of 3, 7', 'PO', 'Process Order', 1, NULL, NULL, NULL),
(188, 75, 1, 1, 73, 'MP-SI-S-18012017-5559', 'MP-SI-S-18012017-5559-SI-U-bed-sheet-single-1 of 2', NULL, NULL, '180117103238289', NULL, 0, '2017-01-18 10:32:39', '2017-01-18 10:32:39', 'MP, Naresh R, 1000031, SI,U, bed-sheet-single, 1 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(189, 75, 1, 1, 73, 'MP-SI-S-18012017-5559', 'MP-SI-S-18012017-5559-SI-U-bed-sheet-single-2 of 2', NULL, NULL, '180117103238963', NULL, 0, '2017-01-18 10:32:40', '2017-01-18 10:32:40', 'MP, Naresh R, 1000031, SI,U, bed-sheet-single, 2 of 2, 2', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(190, 23, 3, 1, 72, 'MP-WD-S-18012017-4160', 'MP-WD-S-18012017-4160-WI-W-kameez-normal-1 of 4', NULL, NULL, '180117103247995', NULL, 0, '2017-01-18 10:32:49', '2017-01-18 10:32:49', 'MP, Naresh R, 1000030, WI,W, kameez-normal, 1 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(191, 23, 3, 1, 72, 'MP-WD-S-18012017-4160', 'MP-WD-S-18012017-4160-WI-W-kameez-normal-2 of 4', NULL, NULL, '180117103247847', NULL, 0, '2017-01-18 10:32:49', '2017-01-18 10:32:49', 'MP, Naresh R, 1000030, WI,W, kameez-normal, 2 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(192, 23, 3, 1, 72, 'MP-WD-S-18012017-4160', 'MP-WD-S-18012017-4160-WI-W-kameez-normal-3 of 4', NULL, NULL, '180117103247376', NULL, 0, '2017-01-18 10:32:49', '2017-01-18 10:32:49', 'MP, Naresh R, 1000030, WI,W, kameez-normal, 3 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(193, 23, 3, 1, 72, 'MP-WD-S-18012017-4160', 'MP-WD-S-18012017-4160-WI-W-kameez-normal-4 of 4', NULL, NULL, '180117103247244', NULL, 0, '2017-01-18 10:32:49', '2017-01-18 10:32:49', 'MP, Naresh R, 1000030, WI,W, kameez-normal, 4 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(194, 21, 1, 1, 71, 'MP-SI-S-18012017-2114', 'MP-SI-S-18012017-2114-SI-W-dupatta-heavy-1 of 4', NULL, NULL, '180117103256532', NULL, 0, '2017-01-18 10:32:57', '2017-01-18 10:32:57', 'MP, Naresh R, 1000029, SI,W, dupatta-heavy, 1 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(195, 21, 1, 1, 71, 'MP-SI-S-18012017-2114', 'MP-SI-S-18012017-2114-SI-W-dupatta-heavy-2 of 4', NULL, NULL, '180117103256633', NULL, 0, '2017-01-18 10:32:57', '2017-01-18 10:32:57', 'MP, Naresh R, 1000029, SI,W, dupatta-heavy, 2 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(196, 21, 1, 1, 71, 'MP-SI-S-18012017-2114', 'MP-SI-S-18012017-2114-SI-W-dupatta-heavy-3 of 4', NULL, NULL, '180117103256863', NULL, 0, '2017-01-18 10:32:57', '2017-01-18 10:32:57', 'MP, Naresh R, 1000029, SI,W, dupatta-heavy, 3 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(197, 21, 1, 1, 71, 'MP-SI-S-18012017-2114', 'MP-SI-S-18012017-2114-SI-W-dupatta-heavy-4 of 4', NULL, NULL, '180117103256997', NULL, 0, '2017-01-18 10:32:57', '2017-01-18 10:32:57', 'MP, Naresh R, 1000029, SI,W, dupatta-heavy, 4 of 4, 4', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(198, 22, 4, 1, 70, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-DC-W-scarf-1 of 3', NULL, NULL, '180117103308342', NULL, 0, '2017-01-18 10:33:09', '2017-01-18 10:33:09', 'MP, Naresh R, 1000028, DC,W, scarf, 1 of 3, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(199, 22, 4, 1, 70, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-DC-W-scarf-2 of 3', NULL, NULL, '180117103308671', NULL, 0, '2017-01-18 10:33:09', '2017-01-18 10:33:09', 'MP, Naresh R, 1000028, DC,W, scarf, 2 of 3, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(200, 22, 4, 1, 70, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-DC-W-scarf-3 of 3', NULL, NULL, '180117103308116', NULL, 0, '2017-01-18 10:33:09', '2017-01-18 10:33:09', 'MP, Naresh R, 1000028, DC,W, scarf, 3 of 3, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(201, 2, 3, 1, 69, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-WI-M-t-shirt-1 of 5', NULL, NULL, '180117103311686', NULL, 0, '2017-01-18 10:33:13', '2017-01-18 10:33:13', 'MP, Naresh R, 1000028, WI,M, t-shirt, 1 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(202, 2, 3, 1, 69, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-WI-M-t-shirt-2 of 5', NULL, NULL, '180117103311191', NULL, 0, '2017-01-18 10:33:13', '2017-01-18 10:33:13', 'MP, Naresh R, 1000028, WI,M, t-shirt, 2 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(203, 2, 3, 1, 69, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-WI-M-t-shirt-3 of 5', NULL, NULL, '180117103311534', NULL, 0, '2017-01-18 10:33:13', '2017-01-18 10:33:13', 'MP, Naresh R, 1000028, WI,M, t-shirt, 3 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(204, 2, 3, 1, 69, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-WI-M-t-shirt-4 of 5', NULL, NULL, '180117103311242', NULL, 0, '2017-01-18 10:33:13', '2017-01-18 10:33:13', 'MP, Naresh R, 1000028, WI,M, t-shirt, 4 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL),
(205, 2, 3, 1, 69, 'MP-WD-S-18012017-7183', 'MP-WD-S-18012017-7183-WI-M-t-shirt-5 of 5', NULL, NULL, '180117103311576', NULL, 0, '2017-01-18 10:33:13', '2017-01-18 10:33:13', 'MP, Naresh R, 1000028, WI,M, t-shirt, 5 of 5, 8', 'STCU', 'Send to Central Unit', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `process_order_addons`
--

CREATE TABLE `process_order_addons` (
  `prco_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `process_order_addons`
--

INSERT INTO `process_order_addons` (`prco_id`, `addon_id`) VALUES
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(75, 1),
(75, 2),
(75, 3),
(76, 1),
(76, 2),
(76, 3),
(77, 3),
(78, 3),
(79, 1),
(80, 1),
(80, 4),
(81, 1),
(81, 4),
(82, 1),
(82, 4),
(83, 1),
(83, 4),
(84, 6),
(85, 6),
(86, 6),
(87, 6),
(112, 1),
(113, 1),
(118, 1),
(119, 1),
(128, 1),
(128, 2),
(129, 1),
(129, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `role_status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `short_name`, `role_status`, `updated_at`, `created_at`) VALUES
(1, 'SUPER_ADMIN', 'super admin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'STORE_ADMIN', 'store admin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'CENTRAL_UNIT', 'CU', 1, '2016-09-09 00:00:00', '2016-08-31 00:00:00'),
(4, 'CALL_CENTER', 'CC', 1, '2016-09-29 00:00:00', '2016-09-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext,
  `cost` smallint(6) DEFAULT NULL,
  `discount` smallint(6) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `code`, `image`, `description`, `cost`, `discount`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Steam Iron', 'SI', '1.jpg', 'Steam Iron', NULL, NULL, 1, '2016-07-21 11:32:46', '2016-07-21 11:32:46'),
(2, 'Wash & Fold', 'WF', '4.jpg', 'Wash and Fold', NULL, NULL, 0, '2016-07-21 11:33:02', '2016-07-21 11:33:02'),
(3, 'Wash & Iron', 'WI', '2.jpg', 'Wash & Iron', NULL, NULL, 1, '2016-07-21 11:33:24', '2016-07-21 11:33:24'),
(4, 'Dry Clean', 'DC', '3.jpg', 'Dry Cleaning', NULL, NULL, 1, '2016-07-21 11:33:46', '2016-07-21 11:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `service_addons`
--

CREATE TABLE `service_addons` (
  `service_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_addons`
--

INSERT INTO `service_addons` (`service_id`, `addon_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `s_id` int(11) NOT NULL,
  `refPoints` int(11) DEFAULT NULL,
  `regPoints` int(11) DEFAULT NULL,
  `minPoints` int(11) DEFAULT NULL,
  `rpointsCost` int(11) DEFAULT NULL,
  `serviceCharge` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`s_id`, `refPoints`, `regPoints`, `minPoints`, `rpointsCost`, `serviceCharge`, `status`, `updated_at`, `created_at`) VALUES
(1, 20, 20, 800, 10, '14.5', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `image` longtext,
  `address` longtext,
  `idProofType` varchar(255) DEFAULT NULL,
  `idProof` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store_services`
--

CREATE TABLE `store_services` (
  `area_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_services`
--

INSERT INTO `store_services` (`area_id`, `service_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(3, 3),
(3, 4),
(4, 1),
(4, 3),
(4, 4),
(5, 1),
(5, 3),
(5, 4),
(6, 1),
(6, 3),
(6, 4),
(7, 1),
(7, 3),
(7, 4),
(8, 1),
(8, 3),
(8, 4),
(9, 1),
(9, 3),
(9, 4),
(10, 1),
(10, 3),
(10, 4),
(11, 1),
(11, 3),
(11, 4),
(12, 1),
(12, 3),
(12, 4),
(13, 1),
(13, 3),
(13, 4);

-- --------------------------------------------------------

--
-- Table structure for table `temp_orders`
--

CREATE TABLE `temp_orders` (
  `to_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `icount` smallint(6) NOT NULL,
  `cost` smallint(6) NOT NULL,
  `rpoints` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_order_addons`
--

CREATE TABLE `temp_order_addons` (
  `poa_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  `poa_count` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_history`
--

CREATE TABLE `transactions_history` (
  `th_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) DEFAULT NULL,
  `paidAmount` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `usedAmount` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions_history`
--

INSERT INTO `transactions_history` (`th_id`, `customer_id`, `order_id`, `paidAmount`, `updated_at`, `created_at`, `usedAmount`) VALUES
(1, 2, 'MP-SI-S-02012017-5547', '421', '2017-01-02 09:55:25', '2017-01-02 09:55:25', '420.22'),
(2, 2, 'MP-WD-S-02012017-2938', '1000', '2017-01-02 09:55:51', '2017-01-02 09:55:51', '1000.78'),
(3, 2, 'MP-SI-S-02012017-5547', '-16.03', '2017-01-02 09:57:47', '2017-01-02 09:57:47', 'refunded amount');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `v_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `regNumber` varchar(255) NOT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `vtype` varchar(255) DEFAULT NULL,
  `rfid` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `vtype` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `area_id` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `v_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `vtype` varchar(255) DEFAULT NULL,
  `vehicle` varchar(255) DEFAULT NULL,
  `vcount` smallint(6) DEFAULT NULL,
  `vdate` datetime DEFAULT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `facultyApprovalStatus` smallint(6) NOT NULL,
  `flatApprovalStatus` smallint(6) NOT NULL,
  `facultyApproval` int(11) DEFAULT NULL,
  `flatApproval` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visitors_history`
--

CREATE TABLE `visitors_history` (
  `vh_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `vtype` varchar(255) DEFAULT NULL,
  `vehicle` varchar(255) DEFAULT NULL,
  `vcount` smallint(6) DEFAULT NULL,
  `vdate` datetime DEFAULT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `facultyApprovalStatus` smallint(6) NOT NULL,
  `flatApprovalStatus` smallint(6) NOT NULL,
  `facultyApproval` int(11) DEFAULT NULL,
  `flatApproval` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aa_flat_notifications`
--
ALTER TABLE `aa_flat_notifications`
  ADD PRIMARY KEY (`aadn_id`,`flat_id`),
  ADD KEY `aa_flat_notifications_flat_id_idx` (`flat_id`);

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`addon_id`),
  ADD UNIQUE KEY `addons_name_uniq` (`name`),
  ADD UNIQUE KEY `addons_code_uniq` (`code`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `ads_apt_id_idx` (`apt_id`),
  ADD KEY `ads_faculty_id_idx` (`faculty_id`);

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`apt_id`),
  ADD UNIQUE KEY `apartments_code_uniq` (`code`),
  ADD KEY `apartments_area_id_idx` (`area_id`),
  ADD KEY `apartments_catalog_id_idx` (`catalog_id`);

--
-- Indexes for table `apartment_admin_notifications`
--
ALTER TABLE `apartment_admin_notifications`
  ADD PRIMARY KEY (`aadn_id`),
  ADD KEY `apartment_admin_notifications_apt_id_idx` (`apt_id`),
  ADD KEY `apartment_admin_notifications_block_id_idx` (`block_id`),
  ADD KEY `apartment_admin_notifications_faculty_id_idx` (`faculty_id`),
  ADD KEY `apartment_admin_notifications_aant_id_idx` (`aant_id`);

--
-- Indexes for table `apartment_an_types`
--
ALTER TABLE `apartment_an_types`
  ADD PRIMARY KEY (`aant_id`),
  ADD KEY `apartment_an_types_apt_id_idx` (`apt_id`),
  ADD KEY `apartment_an_types_faculty_id_idx` (`faculty_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`area_id`),
  ADD UNIQUE KEY `areas_code_uniq` (`code`),
  ADD KEY `areas_city_id_idx` (`city_id`),
  ADD KEY `areas_catalog_id_idx` (`catalog_id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`block_id`),
  ADD KEY `blocks_apt_id_idx` (`apt_id`);

--
-- Indexes for table `catalogprice`
--
ALTER TABLE `catalogprice`
  ADD PRIMARY KEY (`cp_id`),
  ADD KEY `catalogprice_catalog_id_idx` (`catalog_id`),
  ADD KEY `catalogprice_item_id_idx` (`item_id`),
  ADD KEY `catalogprice_itype_id_idx` (`itype_id`),
  ADD KEY `catalogprice_service_id_idx` (`service_id`);

--
-- Indexes for table `catalogs`
--
ALTER TABLE `catalogs`
  ADD PRIMARY KEY (`catalog_id`);

--
-- Indexes for table `cc_camera`
--
ALTER TABLE `cc_camera`
  ADD PRIMARY KEY (`cc_id`),
  ADD KEY `cc_camera_apt_id_idx` (`apt_id`);

--
-- Indexes for table `central_units`
--
ALTER TABLE `central_units`
  ADD PRIMARY KEY (`cu_id`),
  ADD UNIQUE KEY `central_units_city_id_uniq` (`city_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD UNIQUE KEY `cities_code_uniq` (`code`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `complaints_apt_id_idx` (`apt_id`),
  ADD KEY `complaints_block_id_idx` (`block_id`),
  ADD KEY `complaints_flat_id_idx` (`flat_id`),
  ADD KEY `complaints_cust_id_idx` (`cust_id`),
  ADD KEY `complaints_faculty_id_idx` (`faculty_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`),
  ADD UNIQUE KEY `customers_mobile_uniq` (`mobile`),
  ADD KEY `customers_apt_id_idx` (`apt_id`),
  ADD KEY `customers_block_id_idx` (`block_id`),
  ADD KEY `customers_flat_id_idx` (`flat_id`),
  ADD KEY `customers_owner_id_idx` (`owner_id`),
  ADD KEY `customers_area_id_idx` (`area_id`),
  ADD KEY `customers_agent_id_idx` (`agent_id`),
  ADD KEY `customers_package_id_idx` (`package_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`ca_id`),
  ADD UNIQUE KEY `customer_address_cust_id_uniq` (`cust_id`),
  ADD KEY `customer_address_area_id_idx` (`area_id`);

--
-- Indexes for table `customer_idproof`
--
ALTER TABLE `customer_idproof`
  ADD PRIMARY KEY (`cip_id`),
  ADD KEY `customer_idproof_customer_id_idx` (`customer_id`);

--
-- Indexes for table `customer_requests`
--
ALTER TABLE `customer_requests`
  ADD PRIMARY KEY (`cr_id`),
  ADD KEY `customer_requests_area_id_idx` (`area_id`),
  ADD KEY `customer_requests_customer_id_idx` (`customer_id`),
  ADD KEY `customer_requests_pb_id_idx` (`pb_id`);

--
-- Indexes for table `cu_deliver_orders`
--
ALTER TABLE `cu_deliver_orders`
  ADD PRIMARY KEY (`cudo_id`),
  ADD KEY `cu_deliver_orders_emp_id_idx` (`emp_id`),
  ADD KEY `cu_deliver_orders_cue_id_idx` (`cue_id`),
  ADD KEY `cu_deliver_orders_cu_id_idx` (`cu_id`),
  ADD KEY `cu_deliver_orders_store_id_idx` (`store_id`),
  ADD KEY `cu_deliver_orders_apartment_store_id_idx` (`apartment_store_id`);

--
-- Indexes for table `cu_employees`
--
ALTER TABLE `cu_employees`
  ADD PRIMARY KEY (`cue_id`),
  ADD UNIQUE KEY `cu_employees_mobile_uniq` (`mobile`),
  ADD KEY `cu_employees_role_id_idx` (`role_id`),
  ADD KEY `cu_employees_city_id_idx` (`city_id`),
  ADD KEY `cu_employees_cu_id_idx` (`cu_id`);

--
-- Indexes for table `cu_order_details`
--
ALTER TABLE `cu_order_details`
  ADD PRIMARY KEY (`cuod_id`),
  ADD KEY `cu_order_details_cudo_id_idx` (`cudo_id`),
  ADD KEY `cu_order_details_cuso_id_idx` (`cuso_id`),
  ADD KEY `cu_order_details_order_id_idx` (`order_id`);

--
-- Indexes for table `cu_order_messages`
--
ALTER TABLE `cu_order_messages`
  ADD PRIMARY KEY (`cuom_id`),
  ADD KEY `cu_order_messages_emp_id_idx` (`emp_id`),
  ADD KEY `cu_order_messages_cue_id_idx` (`cue_id`);

--
-- Indexes for table `cu_send_orders`
--
ALTER TABLE `cu_send_orders`
  ADD PRIMARY KEY (`cuso_id`),
  ADD KEY `cu_send_orders_emp_id_idx` (`emp_id`),
  ADD KEY `cu_send_orders_cue_id_idx` (`cue_id`),
  ADD KEY `cu_send_orders_cu_id_idx` (`cu_id`),
  ADD KEY `cu_send_orders_store_id_idx` (`store_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `employees_mobile_uniq` (`mobile`),
  ADD KEY `employees_role_id_idx` (`role_id`),
  ADD KEY `employees_area_id_idx` (`area_id`),
  ADD KEY `employees_apt_id_idx` (`apt_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`),
  ADD UNIQUE KEY `faculties_mobile_uniq` (`mobile`),
  ADD KEY `faculties_apt_id_idx` (`apt_id`);

--
-- Indexes for table `flats`
--
ALTER TABLE `flats`
  ADD PRIMARY KEY (`flat_id`),
  ADD KEY `flats_block_id_idx` (`block_id`);

--
-- Indexes for table `flat_gallery`
--
ALTER TABLE `flat_gallery`
  ADD PRIMARY KEY (`fg_id`),
  ADD KEY `flat_gallery_flat_id_idx` (`flat_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `items_itype_id_idx` (`itype_id`);

--
-- Indexes for table `item_services`
--
ALTER TABLE `item_services`
  ADD PRIMARY KEY (`item_id`,`service_id`),
  ADD KEY `item_services_service_id_idx` (`service_id`);

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`itype_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`),
  ADD UNIQUE KEY `packages_name_uniq` (`name`);

--
-- Indexes for table `package_details`
--
ALTER TABLE `package_details`
  ADD PRIMARY KEY (`pd_id`),
  ADD KEY `package_details_package_id_idx` (`package_id`),
  ADD KEY `package_details_customer_id_idx` (`customer_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `pickup_boys`
--
ALTER TABLE `pickup_boys`
  ADD PRIMARY KEY (`pb_id`),
  ADD UNIQUE KEY `pickup_boys_mobile_uniq` (`mobile`),
  ADD KEY `pickup_boys_area_id_idx` (`area_id`);

--
-- Indexes for table `place_order`
--
ALTER TABLE `place_order`
  ADD PRIMARY KEY (`po_id`),
  ADD KEY `place_order_item_id_idx` (`item_id`),
  ADD KEY `place_order_service_id_idx` (`service_id`),
  ADD KEY `place_order_cust_id_idx` (`cust_id`);

--
-- Indexes for table `place_order_addons`
--
ALTER TABLE `place_order_addons`
  ADD PRIMARY KEY (`poa_id`),
  ADD KEY `place_order_addons_po_id_idx` (`po_id`),
  ADD KEY `place_order_addons_addon_id_idx` (`addon_id`);

--
-- Indexes for table `place_order_ids`
--
ALTER TABLE `place_order_ids`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `place_order_ids_customer_id_idx` (`customer_id`),
  ADD KEY `place_order_ids_address_id_idx` (`address_id`),
  ADD KEY `place_order_ids_pb_id_idx` (`pb_id`),
  ADD KEY `place_order_ids_store_id_idx` (`store_id`),
  ADD KEY `place_order_ids_db_id_idx` (`db_id`);

--
-- Indexes for table `process_orders`
--
ALTER TABLE `process_orders`
  ADD PRIMARY KEY (`prco_id`),
  ADD KEY `process_orders_item_id_idx` (`item_id`),
  ADD KEY `process_orders_service_id_idx` (`service_id`),
  ADD KEY `process_orders_cust_id_idx` (`cust_id`),
  ADD KEY `process_orders_po_id_idx` (`po_id`),
  ADD KEY `process_orders_store_id_idx` (`store_id`),
  ADD KEY `process_orders_apartment_store_id_idx` (`apartment_store_id`);

--
-- Indexes for table `process_order_addons`
--
ALTER TABLE `process_order_addons`
  ADD PRIMARY KEY (`prco_id`,`addon_id`),
  ADD KEY `process_order_addons_addon_id_idx` (`addon_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_service_id_idx` (`service_id`),
  ADD KEY `products_item_id_idx` (`item_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD UNIQUE KEY `services_name_uniq` (`name`);

--
-- Indexes for table `service_addons`
--
ALTER TABLE `service_addons`
  ADD PRIMARY KEY (`service_id`,`addon_id`),
  ADD KEY `service_addons_addon_id_idx` (`addon_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `staff_apt_id_idx` (`apt_id`);

--
-- Indexes for table `store_services`
--
ALTER TABLE `store_services`
  ADD PRIMARY KEY (`area_id`,`service_id`),
  ADD KEY `store_services_service_id_idx` (`service_id`);

--
-- Indexes for table `temp_orders`
--
ALTER TABLE `temp_orders`
  ADD PRIMARY KEY (`to_id`),
  ADD KEY `temp_orders_item_id_idx` (`item_id`),
  ADD KEY `temp_orders_service_id_idx` (`service_id`),
  ADD KEY `temp_orders_cust_id_idx` (`cust_id`);

--
-- Indexes for table `temp_order_addons`
--
ALTER TABLE `temp_order_addons`
  ADD PRIMARY KEY (`poa_id`),
  ADD KEY `temp_order_addons_to_id_idx` (`to_id`),
  ADD KEY `temp_order_addons_addon_id_idx` (`addon_id`);

--
-- Indexes for table `transactions_history`
--
ALTER TABLE `transactions_history`
  ADD PRIMARY KEY (`th_id`),
  ADD KEY `transactions_history_customer_id_idx` (`customer_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `vehicles_apt_id_idx` (`apt_id`),
  ADD KEY `vehicles_block_id_idx` (`block_id`),
  ADD KEY `vehicles_flat_id_idx` (`flat_id`),
  ADD KEY `vehicles_cust_id_idx` (`cust_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`),
  ADD KEY `vendors_apt_id_idx` (`apt_id`),
  ADD KEY `vendors_area_id_idx` (`area_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `visitors_apt_id_idx` (`apt_id`),
  ADD KEY `visitors_block_id_idx` (`block_id`),
  ADD KEY `visitors_flat_id_idx` (`flat_id`),
  ADD KEY `visitors_cust_id_idx` (`cust_id`),
  ADD KEY `visitors_faculty_id_idx` (`faculty_id`),
  ADD KEY `visitors_facultyApproval_idx` (`facultyApproval`),
  ADD KEY `visitors_flatApproval_idx` (`flatApproval`);

--
-- Indexes for table `visitors_history`
--
ALTER TABLE `visitors_history`
  ADD PRIMARY KEY (`vh_id`),
  ADD KEY `visitors_history_apt_id_idx` (`apt_id`),
  ADD KEY `visitors_history_block_id_idx` (`block_id`),
  ADD KEY `visitors_history_flat_id_idx` (`flat_id`),
  ADD KEY `visitors_history_cust_id_idx` (`cust_id`),
  ADD KEY `visitors_history_faculty_id_idx` (`faculty_id`),
  ADD KEY `visitors_history_facultyApproval_idx` (`facultyApproval`),
  ADD KEY `visitors_history_flatApproval_idx` (`flatApproval`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `addon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `apt_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `apartment_admin_notifications`
--
ALTER TABLE `apartment_admin_notifications`
  MODIFY `aadn_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `apartment_an_types`
--
ALTER TABLE `apartment_an_types`
  MODIFY `aant_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `catalogprice`
--
ALTER TABLE `catalogprice`
  MODIFY `cp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;
--
-- AUTO_INCREMENT for table `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cc_camera`
--
ALTER TABLE `cc_camera`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `central_units`
--
ALTER TABLE `central_units`
  MODIFY `cu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customer_idproof`
--
ALTER TABLE `customer_idproof`
  MODIFY `cip_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_requests`
--
ALTER TABLE `customer_requests`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cu_deliver_orders`
--
ALTER TABLE `cu_deliver_orders`
  MODIFY `cudo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `cu_employees`
--
ALTER TABLE `cu_employees`
  MODIFY `cue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cu_order_details`
--
ALTER TABLE `cu_order_details`
  MODIFY `cuod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `cu_order_messages`
--
ALTER TABLE `cu_order_messages`
  MODIFY `cuom_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cu_send_orders`
--
ALTER TABLE `cu_send_orders`
  MODIFY `cuso_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `flats`
--
ALTER TABLE `flats`
  MODIFY `flat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `flat_gallery`
--
ALTER TABLE `flat_gallery`
  MODIFY `fg_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `itype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `package_details`
--
ALTER TABLE `package_details`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `pickup_boys`
--
ALTER TABLE `pickup_boys`
  MODIFY `pb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `place_order`
--
ALTER TABLE `place_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `place_order_addons`
--
ALTER TABLE `place_order_addons`
  MODIFY `poa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `place_order_ids`
--
ALTER TABLE `place_order_ids`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000032;
--
-- AUTO_INCREMENT for table `process_orders`
--
ALTER TABLE `process_orders`
  MODIFY `prco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `temp_orders`
--
ALTER TABLE `temp_orders`
  MODIFY `to_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `temp_order_addons`
--
ALTER TABLE `temp_order_addons`
  MODIFY `poa_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions_history`
--
ALTER TABLE `transactions_history`
  MODIFY `th_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visitors_history`
--
ALTER TABLE `visitors_history`
  MODIFY `vh_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `aa_flat_notifications`
--
ALTER TABLE `aa_flat_notifications`
  ADD CONSTRAINT `aa_flat_notifications_ibfk_1` FOREIGN KEY (`aadn_id`) REFERENCES `apartment_admin_notifications` (`aadn_id`),
  ADD CONSTRAINT `aa_flat_notifications_ibfk_2` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`);

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `ads_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `apartments`
--
ALTER TABLE `apartments`
  ADD CONSTRAINT `apartments_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `apartments_ibfk_2` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`catalog_id`);

--
-- Constraints for table `apartment_admin_notifications`
--
ALTER TABLE `apartment_admin_notifications`
  ADD CONSTRAINT `apartment_admin_notifications_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `apartment_admin_notifications_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `apartment_admin_notifications_ibfk_3` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `apartment_admin_notifications_ibfk_4` FOREIGN KEY (`aant_id`) REFERENCES `apartment_an_types` (`aant_id`);

--
-- Constraints for table `apartment_an_types`
--
ALTER TABLE `apartment_an_types`
  ADD CONSTRAINT `apartment_an_types_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `apartment_an_types_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `areas_ibfk_2` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`catalog_id`);

--
-- Constraints for table `blocks`
--
ALTER TABLE `blocks`
  ADD CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `catalogprice`
--
ALTER TABLE `catalogprice`
  ADD CONSTRAINT `catalogprice_ibfk_1` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`catalog_id`),
  ADD CONSTRAINT `catalogprice_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `catalogprice_ibfk_3` FOREIGN KEY (`itype_id`) REFERENCES `item_types` (`itype_id`),
  ADD CONSTRAINT `catalogprice_ibfk_4` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `cc_camera`
--
ALTER TABLE `cc_camera`
  ADD CONSTRAINT `cc_camera_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `central_units`
--
ALTER TABLE `central_units`
  ADD CONSTRAINT `central_units_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `complaints_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `complaints_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `complaints_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `customers_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `customers_ibfk_4` FOREIGN KEY (`owner_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `customers_ibfk_5` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `customers_ibfk_6` FOREIGN KEY (`agent_id`) REFERENCES `pickup_boys` (`pb_id`),
  ADD CONSTRAINT `customers_ibfk_7` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`);

--
-- Constraints for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `customer_address_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `customer_address_ibfk_2` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `customer_idproof`
--
ALTER TABLE `customer_idproof`
  ADD CONSTRAINT `customer_idproof_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `customer_requests`
--
ALTER TABLE `customer_requests`
  ADD CONSTRAINT `customer_requests_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `customer_requests_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `customer_requests_ibfk_3` FOREIGN KEY (`pb_id`) REFERENCES `pickup_boys` (`pb_id`);

--
-- Constraints for table `cu_deliver_orders`
--
ALTER TABLE `cu_deliver_orders`
  ADD CONSTRAINT `cu_deliver_orders_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`),
  ADD CONSTRAINT `cu_deliver_orders_ibfk_2` FOREIGN KEY (`cue_id`) REFERENCES `cu_employees` (`cue_id`),
  ADD CONSTRAINT `cu_deliver_orders_ibfk_3` FOREIGN KEY (`cu_id`) REFERENCES `central_units` (`cu_id`),
  ADD CONSTRAINT `cu_deliver_orders_ibfk_4` FOREIGN KEY (`store_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `cu_deliver_orders_ibfk_5` FOREIGN KEY (`apartment_store_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `cu_employees`
--
ALTER TABLE `cu_employees`
  ADD CONSTRAINT `cu_employees_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `cu_employees_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `cu_employees_ibfk_3` FOREIGN KEY (`cu_id`) REFERENCES `central_units` (`cu_id`);

--
-- Constraints for table `cu_order_details`
--
ALTER TABLE `cu_order_details`
  ADD CONSTRAINT `cu_order_details_ibfk_1` FOREIGN KEY (`cudo_id`) REFERENCES `cu_deliver_orders` (`cudo_id`),
  ADD CONSTRAINT `cu_order_details_ibfk_2` FOREIGN KEY (`cuso_id`) REFERENCES `cu_send_orders` (`cuso_id`),
  ADD CONSTRAINT `cu_order_details_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `place_order_ids` (`o_id`);

--
-- Constraints for table `cu_order_messages`
--
ALTER TABLE `cu_order_messages`
  ADD CONSTRAINT `cu_order_messages_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`),
  ADD CONSTRAINT `cu_order_messages_ibfk_2` FOREIGN KEY (`cue_id`) REFERENCES `cu_employees` (`cue_id`);

--
-- Constraints for table `cu_send_orders`
--
ALTER TABLE `cu_send_orders`
  ADD CONSTRAINT `cu_send_orders_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`),
  ADD CONSTRAINT `cu_send_orders_ibfk_2` FOREIGN KEY (`cue_id`) REFERENCES `cu_employees` (`cue_id`),
  ADD CONSTRAINT `cu_send_orders_ibfk_3` FOREIGN KEY (`cu_id`) REFERENCES `central_units` (`cu_id`),
  ADD CONSTRAINT `cu_send_orders_ibfk_4` FOREIGN KEY (`store_id`) REFERENCES `areas` (`area_id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `faculties_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `flats`
--
ALTER TABLE `flats`
  ADD CONSTRAINT `flats_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`);

--
-- Constraints for table `flat_gallery`
--
ALTER TABLE `flat_gallery`
  ADD CONSTRAINT `flat_gallery_ibfk_1` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`itype_id`) REFERENCES `item_types` (`itype_id`);

--
-- Constraints for table `item_services`
--
ALTER TABLE `item_services`
  ADD CONSTRAINT `item_services_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `item_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `package_details`
--
ALTER TABLE `package_details`
  ADD CONSTRAINT `package_details_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`),
  ADD CONSTRAINT `package_details_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `pickup_boys`
--
ALTER TABLE `pickup_boys`
  ADD CONSTRAINT `pickup_boys_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`);

--
-- Constraints for table `place_order`
--
ALTER TABLE `place_order`
  ADD CONSTRAINT `place_order_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `place_order_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `place_order_ibfk_3` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `place_order_addons`
--
ALTER TABLE `place_order_addons`
  ADD CONSTRAINT `place_order_addons_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `place_order` (`po_id`),
  ADD CONSTRAINT `place_order_addons_ibfk_2` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`addon_id`);

--
-- Constraints for table `place_order_ids`
--
ALTER TABLE `place_order_ids`
  ADD CONSTRAINT `place_order_ids_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `place_order_ids_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `customer_address` (`ca_id`),
  ADD CONSTRAINT `place_order_ids_ibfk_3` FOREIGN KEY (`pb_id`) REFERENCES `pickup_boys` (`pb_id`),
  ADD CONSTRAINT `place_order_ids_ibfk_4` FOREIGN KEY (`store_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `place_order_ids_ibfk_5` FOREIGN KEY (`db_id`) REFERENCES `pickup_boys` (`pb_id`);

--
-- Constraints for table `process_orders`
--
ALTER TABLE `process_orders`
  ADD CONSTRAINT `process_orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `process_orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `process_orders_ibfk_3` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `process_orders_ibfk_4` FOREIGN KEY (`po_id`) REFERENCES `place_order` (`po_id`),
  ADD CONSTRAINT `process_orders_ibfk_5` FOREIGN KEY (`store_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `process_orders_ibfk_6` FOREIGN KEY (`apartment_store_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `process_order_addons`
--
ALTER TABLE `process_order_addons`
  ADD CONSTRAINT `process_order_addons_ibfk_1` FOREIGN KEY (`prco_id`) REFERENCES `process_orders` (`prco_id`),
  ADD CONSTRAINT `process_order_addons_ibfk_2` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`addon_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `service_addons`
--
ALTER TABLE `service_addons`
  ADD CONSTRAINT `service_addons_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `service_addons_ibfk_2` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`addon_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`);

--
-- Constraints for table `store_services`
--
ALTER TABLE `store_services`
  ADD CONSTRAINT `store_services_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `store_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `temp_orders`
--
ALTER TABLE `temp_orders`
  ADD CONSTRAINT `temp_orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `temp_orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `temp_orders_ibfk_3` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `temp_order_addons`
--
ALTER TABLE `temp_order_addons`
  ADD CONSTRAINT `temp_order_addons_ibfk_1` FOREIGN KEY (`to_id`) REFERENCES `temp_orders` (`to_id`),
  ADD CONSTRAINT `temp_order_addons_ibfk_2` FOREIGN KEY (`addon_id`) REFERENCES `addons` (`addon_id`);

--
-- Constraints for table `transactions_history`
--
ALTER TABLE `transactions_history`
  ADD CONSTRAINT `transactions_history_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `vehicles_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `vehicles_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `vehicles_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `vendors_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`);

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `visitors_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `visitors_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `visitors_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `visitors_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `visitors_ibfk_6` FOREIGN KEY (`facultyApproval`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `visitors_ibfk_7` FOREIGN KEY (`flatApproval`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `visitors_history`
--
ALTER TABLE `visitors_history`
  ADD CONSTRAINT `visitors_history_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `visitors_history_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `visitors_history_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `visitors_history_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `visitors_history_ibfk_5` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `visitors_history_ibfk_6` FOREIGN KEY (`facultyApproval`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `visitors_history_ibfk_7` FOREIGN KEY (`flatApproval`) REFERENCES `customers` (`cust_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
