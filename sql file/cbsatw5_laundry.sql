-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2016 at 12:35 PM
-- Server version: 5.6.31
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cbsatw5_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `aa_flat_notifications`
--

CREATE TABLE IF NOT EXISTS `aa_flat_notifications` (
  `aadn_id` int(11) NOT NULL,
  `flat_id` int(11) NOT NULL,
  PRIMARY KEY (`aadn_id`,`flat_id`),
  KEY `aa_flat_notifications_flat_id_idx` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE IF NOT EXISTS `addons` (
  `addon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`addon_id`),
  UNIQUE KEY `addons_name_uniq` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`addon_id`, `name`, `image`, `price`, `description`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Premium Packing', '', '5', 'Premium Packing', 1, '2016-07-21 11:31:24', '2016-07-21 11:31:24'),
(2, 'Quick Delivery', NULL, '6', 'Quick Delivery', 1, '2016-07-21 11:31:49', '2016-07-21 11:31:49'),
(3, 'Starch', NULL, '10', NULL, 1, '2016-07-21 11:31:57', '2016-07-21 11:31:57');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`ad_id`),
  KEY `ads_apt_id_idx` (`apt_id`),
  KEY `ads_faculty_id_idx` (`faculty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE IF NOT EXISTS `apartments` (
  `apt_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL,
  `catalog_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`apt_id`),
  UNIQUE KEY `apartments_code_uniq` (`code`),
  KEY `apartments_area_id_idx` (`area_id`),
  KEY `apartments_catalog_id_idx` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`apt_id`, `area_id`, `catalog_id`, `name`, `address`, `pincode`, `status`, `code`, `landmark`, `mobile`) VALUES
(1, 1, 2, 'Smr vinay Apts', 'Hafeezpet', 500033, 1, 'SMR', 'Hafeezpet', '1234567890'),
(2, 2, 2, 'MyHome Hub', 'Hitech City', 500019, 1, 'MHH', 'Hitex', '5432112345');

-- --------------------------------------------------------

--
-- Table structure for table `apartment_admin_notifications`
--

CREATE TABLE IF NOT EXISTS `apartment_admin_notifications` (
  `aadn_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`aadn_id`),
  KEY `apartment_admin_notifications_apt_id_idx` (`apt_id`),
  KEY `apartment_admin_notifications_block_id_idx` (`block_id`),
  KEY `apartment_admin_notifications_faculty_id_idx` (`faculty_id`),
  KEY `apartment_admin_notifications_aant_id_idx` (`aant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `apartment_an_types`
--

CREATE TABLE IF NOT EXISTS `apartment_an_types` (
  `aant_id` int(11) NOT NULL AUTO_INCREMENT,
  `apt_id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`aant_id`),
  KEY `apartment_an_types_apt_id_idx` (`apt_id`),
  KEY `apartment_an_types_faculty_id_idx` (`faculty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`area_id`),
  UNIQUE KEY `areas_code_uniq` (`code`),
  KEY `areas_city_id_idx` (`city_id`),
  KEY `areas_catalog_id_idx` (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `city_id`, `name`, `status`, `updated_at`, `created_at`, `code`, `address`, `landmark`, `pincode`, `mobile`, `catalog_id`) VALUES
(1, 1, 'Jubilee Hills', 1, '2016-08-31 14:20:25', '2016-08-31 14:20:25', 'JBL', 'Flat No:401, 4th Floor, Sri Sai Srinivasa Nilayam', 'Near Sai Temple', 500031, '9876543210', 1),
(2, 3, 'NungamBakam', 1, '2016-09-02 10:10:37', '2016-09-02 10:10:37', 'NB', 'Old Church Road, NungamBakam', 'Church', 500056, '1234554321', 3),
(3, 1, 'Srinagar Colony', 1, '2016-09-03 13:28:09', '2016-09-03 13:28:09', 'SC', 'Srinagar Colony', 'Srinagar Colpoiny', 123123123, '1431431430', 3);

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE IF NOT EXISTS `blocks` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `apt_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`block_id`),
  KEY `blocks_apt_id_idx` (`apt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`block_id`, `apt_id`, `name`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'A', 1, '2016-09-09 08:55:17', '2016-09-09 08:55:17'),
(2, 1, 'B', 1, '2016-09-09 08:55:24', '2016-09-09 08:55:24');

-- --------------------------------------------------------

--
-- Table structure for table `catalogprice`
--

CREATE TABLE IF NOT EXISTS `catalogprice` (
  `cp_id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `itype_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cost` smallint(6) NOT NULL,
  `discount` smallint(6) NOT NULL,
  `rpoints` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cp_id`),
  KEY `catalogprice_catalog_id_idx` (`catalog_id`),
  KEY `catalogprice_item_id_idx` (`item_id`),
  KEY `catalogprice_itype_id_idx` (`itype_id`),
  KEY `catalogprice_service_id_idx` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=234 ;

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
(233, 3, 22, 2, 3, 10, 0, 10, 1, '2016-09-03 13:29:34', '2016-09-03 13:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `catalogs`
--

CREATE TABLE IF NOT EXISTS `catalogs` (
  `catalog_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`catalog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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

CREATE TABLE IF NOT EXISTS `cc_camera` (
  `cc_id` int(11) NOT NULL AUTO_INCREMENT,
  `apt_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `ccscript` varchar(255) DEFAULT NULL,
  `accessPrivileges` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cc_id`),
  KEY `cc_camera_apt_id_idx` (`apt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `central_units`
--

CREATE TABLE IF NOT EXISTS `central_units` (
  `cu_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `address` longtext,
  `status` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cu_id`),
  UNIQUE KEY `central_units_city_id_uniq` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `central_units`
--

INSERT INTO `central_units` (`cu_id`, `city_id`, `name`, `address`, `status`, `updated_at`, `created_at`, `code`) VALUES
(1, 1, 'Mani', 'Plot Np: 101, 1st floor, Prashanth Nagar, Kukatpally, Hyderabad', 1, '2016-08-31 00:00:00', '2016-08-31 00:00:00', 'HYD');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`city_id`),
  UNIQUE KEY `cities_code_uniq` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `name`, `status`, `updated_at`, `created_at`, `code`) VALUES
(1, 'Hyderabad', 1, '2016-07-16 17:12:41', '2016-07-16 17:12:41', 'HY'),
(2, 'Bangloe', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'BL'),
(3, 'Chennai', 1, '2016-09-02 10:09:07', '2016-09-02 10:09:07', 'CH');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE IF NOT EXISTS `complaints` (
  `v_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`v_id`),
  KEY `complaints_apt_id_idx` (`apt_id`),
  KEY `complaints_block_id_idx` (`block_id`),
  KEY `complaints_flat_id_idx` (`flat_id`),
  KEY `complaints_cust_id_idx` (`cust_id`),
  KEY `complaints_faculty_id_idx` (`faculty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`cust_id`),
  UNIQUE KEY `customers_mobile_uniq` (`mobile`),
  KEY `customers_apt_id_idx` (`apt_id`),
  KEY `customers_block_id_idx` (`block_id`),
  KEY `customers_flat_id_idx` (`flat_id`),
  KEY `customers_owner_id_idx` (`owner_id`),
  KEY `customers_area_id_idx` (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `apt_id`, `block_id`, `flat_id`, `owner_id`, `area_id`, `firstname`, `lastname`, `gender`, `email`, `mobile`, `whatsapp`, `type`, `subType`, `password`, `passwordSalt`, `address`, `ownerName`, `ownerMobile`, `ownerAddress`, `ref_id`, `facebook`, `oauth_id`, `rpoints`, `firstOrder`, `resetPassword`, `showInTele`, `isStaying`, `status`, `dob`, `updated_at`, `created_at`, `wallet`) VALUES
(1, NULL, NULL, NULL, NULL, 1, 'Mani', '', NULL, 'mani@gmail.com', 9849367897, NULL, 'user', '', '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, '', NULL, 'e29465acdf17c17aa0b0facb5a64338a', 0, 1, 0, 1, 1, 1, NULL, '2016-08-31 14:54:25', '2016-08-31 14:54:25', '0'),
(2, NULL, NULL, NULL, NULL, 1, 'Naresh', 'R', NULL, 'naresh@gmail.com', 9703651416, NULL, 'user', NULL, '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, NULL, NULL, 'df054626bb967a88a99dc9426b2b2d62', 50, 1, 0, 1, 1, 1, NULL, '2016-08-31 15:03:38', '2016-08-31 15:03:38', '24'),
(3, NULL, NULL, NULL, NULL, 1, 'Sandy', 'Karnati', NULL, 'sandypublic@gmail.com', 9885698665, NULL, 'user', '', '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, '', NULL, '4d21bcb2d07bf8827bd469e46eda182d', 50, 1, 0, 1, 1, 1, NULL, '2016-09-12 11:05:54', '2016-09-12 11:05:54', '19');

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE IF NOT EXISTS `customer_address` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`ca_id`),
  KEY `customer_address_area_id_idx` (`area_id`),
  KEY `customer_address_cust_id_idx` (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`ca_id`, `area_id`, `cust_id`, `address`, `landmark`, `pincode`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 2, 'Flat No 401, 4th Floor , Sri Sai Nilayam', 'Near Sai Baba Temple', 500035, 1, '2016-08-31 15:03:38', '2016-08-31 15:03:38'),
(2, 1, 1, 'Plot no 3', 'Re restaurant', 500035, 1, '2016-09-02 12:05:44', '2016-09-02 12:05:44'),
(3, 1, 3, 'H.no: 6-230', 'Grammer', 78876, 1, '2016-09-12 11:06:45', '2016-09-12 11:06:45');

-- --------------------------------------------------------

--
-- Table structure for table `customer_idproof`
--

CREATE TABLE IF NOT EXISTS `customer_idproof` (
  `cip_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `enroll` varchar(22) NOT NULL,
  `type` varchar(18) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cip_id`),
  KEY `customer_idproof_customer_id_idx` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_requests`
--

CREATE TABLE IF NOT EXISTS `customer_requests` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `pb_id` int(11) DEFAULT NULL,
  `mobile` varchar(10) NOT NULL,
  `status` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `crdate` datetime DEFAULT NULL,
  PRIMARY KEY (`cr_id`),
  KEY `customer_requests_area_id_idx` (`area_id`),
  KEY `customer_requests_customer_id_idx` (`customer_id`),
  KEY `customer_requests_pb_id_idx` (`pb_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customer_requests`
--

INSERT INTO `customer_requests` (`cr_id`, `area_id`, `customer_id`, `pb_id`, `mobile`, `status`, `updated_at`, `created_at`, `crdate`) VALUES
(1, 1, 3, NULL, '9885698665', '0', '2016-09-12 18:53:38', '2016-09-12 18:53:38', '2016-09-13 18:54:00'),
(2, 1, 3, 1001, '9885698665', '2', '2016-09-12 18:58:59', '2016-09-12 18:58:59', '2016-09-12 18:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `cu_deliver_orders`
--

CREATE TABLE IF NOT EXISTS `cu_deliver_orders` (
  `cudo_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `cue_id` int(11) DEFAULT NULL,
  `cu_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `message` longtext,
  `status` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `apartment_store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cudo_id`),
  KEY `cu_deliver_orders_emp_id_idx` (`emp_id`),
  KEY `cu_deliver_orders_cue_id_idx` (`cue_id`),
  KEY `cu_deliver_orders_cu_id_idx` (`cu_id`),
  KEY `cu_deliver_orders_store_id_idx` (`store_id`),
  KEY `cu_deliver_orders_apartment_store_id_idx` (`apartment_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cu_employees`
--

CREATE TABLE IF NOT EXISTS `cu_employees` (
  `cue_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cue_id`),
  UNIQUE KEY `cu_employees_mobile_uniq` (`mobile`),
  KEY `cu_employees_role_id_idx` (`role_id`),
  KEY `cu_employees_city_id_idx` (`city_id`),
  KEY `cu_employees_cu_id_idx` (`cu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cu_employees`
--

INSERT INTO `cu_employees` (`cue_id`, `role_id`, `city_id`, `name`, `email`, `mobile`, `password`, `password_salt`, `status`, `updated_at`, `created_at`, `cu_id`) VALUES
(1, 3, 1, 'ravi', 'ravi@gmail.com', '9876543210', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-08-31 00:00:00', '2016-08-31 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cu_order_details`
--

CREATE TABLE IF NOT EXISTS `cu_order_details` (
  `cuod_id` int(11) NOT NULL AUTO_INCREMENT,
  `cudo_id` int(11) DEFAULT NULL,
  `cuso_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `message` longtext,
  `status` smallint(6) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cuod_id`),
  KEY `cu_order_details_cudo_id_idx` (`cudo_id`),
  KEY `cu_order_details_cuso_id_idx` (`cuso_id`),
  KEY `cu_order_details_order_id_idx` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cu_order_details`
--

INSERT INTO `cu_order_details` (`cuod_id`, `cudo_id`, `cuso_id`, `order_id`, `message`, `status`, `updated_at`, `created_at`) VALUES
(1, NULL, 1, 1000004, NULL, 0, '2016-09-12 12:11:12', '2016-09-12 12:11:12'),
(2, NULL, 2, 1000005, NULL, 0, '2016-09-12 19:15:18', '2016-09-12 19:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `cu_order_messages`
--

CREATE TABLE IF NOT EXISTS `cu_order_messages` (
  `cuom_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `cue_id` int(11) DEFAULT NULL,
  `message` longtext,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cuom_id`),
  KEY `cu_order_messages_emp_id_idx` (`emp_id`),
  KEY `cu_order_messages_cue_id_idx` (`cue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cu_send_orders`
--

CREATE TABLE IF NOT EXISTS `cu_send_orders` (
  `cuso_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `cue_id` int(11) DEFAULT NULL,
  `cu_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `message` longtext,
  `status` smallint(6) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`cuso_id`),
  KEY `cu_send_orders_emp_id_idx` (`emp_id`),
  KEY `cu_send_orders_cue_id_idx` (`cue_id`),
  KEY `cu_send_orders_cu_id_idx` (`cu_id`),
  KEY `cu_send_orders_store_id_idx` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cu_send_orders`
--

INSERT INTO `cu_send_orders` (`cuso_id`, `emp_id`, `cue_id`, `cu_id`, `store_id`, `order_id`, `message`, `status`, `updated_at`, `created_at`) VALUES
(1, 2, NULL, 1, NULL, '12092016-HY-CUS-JBL-3123', NULL, 0, '2016-09-12 12:11:00', '2016-09-12 12:11:00'),
(2, 2, NULL, 1, NULL, '12092016-HY-CUS-JBL-5656', NULL, 0, '2016-09-12 07:15:00', '2016-09-12 07:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `apt_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `employees_mobile_uniq` (`mobile`),
  KEY `employees_role_id_idx` (`role_id`),
  KEY `employees_area_id_idx` (`area_id`),
  KEY `employees_apt_id_idx` (`apt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `role_id`, `name`, `email`, `mobile`, `password`, `password_salt`, `status`, `updated_at`, `created_at`, `area_id`, `apt_id`) VALUES
(1, 1, 'Kishore', 'kishore@gmail.com', '1234567890', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-08-21 00:00:00', '2016-08-21 00:00:00', NULL, NULL),
(2, 2, 'Naresh', 'naresh@gmail.com', '1234567891', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-09-09 20:31:07', '2016-09-09 20:31:07', 1, NULL),
(3, 2, 'suresh', 'suresh@gmail.com', '1234567892', '900150983cd24fb0d6963f7d28e17f72', NULL, 1, '2016-09-11 11:46:39', '2016-09-11 11:46:39', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE IF NOT EXISTS `faculties` (
  `faculty_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`faculty_id`),
  UNIQUE KEY `faculties_mobile_uniq` (`mobile`),
  KEY `faculties_apt_id_idx` (`apt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `flats`
--

CREATE TABLE IF NOT EXISTS `flats` (
  `flat_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cntTwoMobile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`flat_id`),
  KEY `flats_block_id_idx` (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `flats`
--

INSERT INTO `flats` (`flat_id`, `block_id`, `name`, `status`, `updated_at`, `created_at`, `intercom`, `eusn`, `readyToSale`, `readyToOccupy`, `bhk`, `size`, `facing`, `salePrice`, `rentPrice`, `nofpplStay`, `cntOneName`, `cntOneMobile`, `cntTwoName`, `cntTwoMobile`) VALUES
(1, 1, '101-A', 1, '2016-09-09 08:55:48', '2016-09-09 08:55:48', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, '102-A', 1, '2016-09-09 08:56:01', '2016-09-09 08:56:01', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, '103-A', 1, '2016-09-09 08:56:21', '2016-09-09 08:56:21', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 2, '101-B', 1, '2016-09-09 08:56:33', '2016-09-09 08:56:33', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, '102-B', 1, '2016-09-09 08:56:47', '2016-09-09 08:56:47', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, '103-B', 1, '2016-09-09 08:57:01', '2016-09-09 08:57:01', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flat_gallery`
--

CREATE TABLE IF NOT EXISTS `flat_gallery` (
  `fg_id` int(11) NOT NULL AUTO_INCREMENT,
  `flat_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`fg_id`),
  KEY `flat_gallery_flat_id_idx` (`flat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `itype_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `items_itype_id_idx` (`itype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

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
(93, 1, 'Sherwani 2 Pcs', 'Sh2', '1-Sherwani 2 Pcs.png', 1, '2016-08-22 09:06:33', '2016-08-22 09:06:33');

-- --------------------------------------------------------

--
-- Table structure for table `item_services`
--

CREATE TABLE IF NOT EXISTS `item_services` (
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`,`service_id`),
  KEY `item_services_service_id_idx` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_services`
--

INSERT INTO `item_services` (`item_id`, `service_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(86, 3),
(87, 3),
(88, 3),
(89, 3),
(90, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(29, 4),
(30, 4),
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 4),
(38, 4),
(39, 4),
(40, 4),
(41, 4),
(42, 4),
(43, 4),
(44, 4),
(45, 4),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 4),
(52, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(58, 4),
(59, 4),
(61, 4),
(62, 4),
(63, 4),
(64, 4),
(65, 4),
(66, 4),
(67, 4),
(68, 4),
(69, 4),
(70, 4),
(71, 4),
(72, 4),
(73, 4),
(74, 4),
(75, 4),
(76, 4),
(77, 4),
(78, 4),
(79, 4),
(80, 4),
(81, 4),
(82, 4),
(83, 4),
(84, 4),
(85, 4),
(86, 4),
(87, 4),
(88, 4),
(89, 4),
(90, 4);

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE IF NOT EXISTS `item_types` (
  `itype_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`itype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
-- Table structure for table `pickup_boys`
--

CREATE TABLE IF NOT EXISTS `pickup_boys` (
  `pb_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pb_id`),
  UNIQUE KEY `pickup_boys_mobile_uniq` (`mobile`),
  KEY `pickup_boys_area_id_idx` (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

--
-- Dumping data for table `pickup_boys`
--

INSERT INTO `pickup_boys` (`pb_id`, `area_id`, `name`, `email`, `mobile`, `password`, `passwordSalt`, `token`, `status`, `updated_at`, `created_at`, `image`) VALUES
(1001, 1, 'Rajesh', 'rajesh@gmail.com', '1231231230', '900150983cd24fb0d6963f7d28e17f72', '', 'COcGl2a1EW6YLkodXBMz0q5fe', 1, '2016-09-12 09:49:19', '2016-09-12 09:49:19', 'boy1.png');

-- --------------------------------------------------------

--
-- Table structure for table `place_order`
--

CREATE TABLE IF NOT EXISTS `place_order` (
  `po_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`po_id`),
  KEY `place_order_item_id_idx` (`item_id`),
  KEY `place_order_service_id_idx` (`service_id`),
  KEY `place_order_cust_id_idx` (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `place_order`
--

INSERT INTO `place_order` (`po_id`, `item_id`, `service_id`, `cust_id`, `order_id`, `icount`, `cost`, `rpoints`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 2, 'JBL-SI-M-12092016-8816', 3, 24, 10, 0, '2016-09-12 11:03:08', '2016-09-12 11:03:08'),
(2, 2, 1, 2, 'JBL-SI-M-12092016-8816', 2, 16, 10, 0, '2016-09-12 11:03:08', '2016-09-12 11:03:08'),
(3, 1, 1, 2, 'JBL-SI-M-12092016-6915', 3, 24, 10, 0, '2016-09-12 11:05:32', '2016-09-12 11:05:32'),
(4, 1, 4, 3, 'JBL-WD-M-12092016-2133', 1, 50, 10, 0, '2016-09-12 11:06:47', '2016-09-12 11:06:47'),
(5, 1, 3, 2, 'JBL-WD-S-12092016-3909', 2, 60, 20, 1, '2016-09-12 12:10:30', '2016-09-12 12:10:30'),
(6, 1, 1, 3, 'JBL-SI-M-12092016-7320', 1, 19, 10, 1, '2016-09-12 18:19:03', '2016-09-12 18:19:03'),
(7, 2, 1, 3, 'JBL-SI-M-12092016-7320', 2, 16, 10, 1, '2016-09-12 18:19:04', '2016-09-12 18:19:04'),
(8, 1, 1, 3, 'JBL-SI-S-12092016-5128', 1, 8, 10, 0, '2016-09-12 19:11:09', '2016-09-12 19:11:09'),
(9, 2, 1, 3, 'JBL-SI-S-12092016-5128', 1, 8, 10, 0, '2016-09-12 19:11:09', '2016-09-12 19:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `place_order_addons`
--

CREATE TABLE IF NOT EXISTS `place_order_addons` (
  `poa_id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) DEFAULT NULL,
  `addon_id` int(11) DEFAULT NULL,
  `poa_count` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`poa_id`),
  KEY `place_order_addons_po_id_idx` (`po_id`),
  KEY `place_order_addons_addon_id_idx` (`addon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `place_order_addons`
--

INSERT INTO `place_order_addons` (`poa_id`, `po_id`, `addon_id`, `poa_count`, `updated_at`, `created_at`) VALUES
(1, 5, 1, 2, '2016-09-12 12:10:30', '2016-09-12 12:10:30'),
(2, 6, 1, 1, '2016-09-12 18:19:03', '2016-09-12 18:19:03'),
(3, 6, 2, 1, '2016-09-12 18:19:03', '2016-09-12 18:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `place_order_ids`
--

CREATE TABLE IF NOT EXISTS `place_order_ids` (
  `o_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) NOT NULL,
  `subtotal` varchar(18) DEFAULT NULL,
  `serviceTax` varchar(4) DEFAULT NULL,
  `totalAmount` varchar(18) DEFAULT NULL,
  `redeemAmount` varchar(18) DEFAULT NULL,
  `rPointsUsed` varchar(18) DEFAULT NULL,
  `balanceAmount` varchar(255) DEFAULT NULL,
  `paidAmount` varchar(255) DEFAULT NULL,
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
  `reFundAmount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`o_id`),
  KEY `place_order_ids_customer_id_idx` (`customer_id`),
  KEY `place_order_ids_address_id_idx` (`address_id`),
  KEY `place_order_ids_pb_id_idx` (`pb_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000007 ;

--
-- Dumping data for table `place_order_ids`
--

INSERT INTO `place_order_ids` (`o_id`, `customer_id`, `address_id`, `order_id`, `subtotal`, `serviceTax`, `totalAmount`, `redeemAmount`, `rPointsUsed`, `balanceAmount`, `paidAmount`, `adminDiscount`, `adminDiscountAmount`, `orderDate`, `firstPaidAmount`, `secondPaidAmount`, `thirdPaidAmount`, `status`, `updated_at`, `created_at`, `pb_id`, `deliveryDate`, `pickupBoyStatus`, `cuStatus`, `totalItems`, `poStatus`, `poStatusMessage`, `reFundAmount`) VALUES
(1000001, 2, 1, 'JBL-SI-M-12092016-8816', '40', '0', '40', NULL, '0', '40', '0', '0', '0', '2016-09-12 11:03:08', NULL, NULL, NULL, 0, '2016-09-12 11:03:08', '2016-09-12 11:03:08', NULL, NULL, '0', '0', 5, NULL, NULL, NULL),
(1000002, 2, 1, 'JBL-SI-M-12092016-6915', '24', '0', '24', NULL, '0', '24', '0', '0', '0', '2016-09-12 11:05:32', NULL, NULL, NULL, 0, '2016-09-12 11:05:32', '2016-09-12 11:05:32', NULL, NULL, '0', '0', 3, NULL, NULL, NULL),
(1000003, 3, 3, 'JBL-WD-M-12092016-2133', '50', '0', '50', NULL, '0', '50', '0', '0', '0', '2016-09-12 11:06:47', NULL, NULL, NULL, 0, '2016-09-12 11:06:47', '2016-09-12 11:06:47', 1001, NULL, 'recieved', '0', 1, NULL, NULL, NULL),
(1000004, 2, 1, 'JBL-WD-S-12092016-3909', '60', '0', '60', NULL, NULL, '60', '0', '0', '0', '2016-09-12 12:10:00', NULL, NULL, NULL, 1, '2016-09-12 12:10:30', '2016-09-12 12:10:30', NULL, '2016-09-12 12:10:00', '0', '1', 2, 'STCU', 'order send to CU', NULL),
(1000005, 3, 3, 'JBL-SI-M-12092016-7320', '35', '0', '35', NULL, '0', '35', '0', '0', '0', '2016-09-12 18:19:03', NULL, NULL, NULL, 1, '2016-09-12 18:19:03', '2016-09-12 18:19:03', 1001, NULL, 'recieved', '1', 3, 'STCU', 'order send to CU', '19'),
(1000006, 3, 3, 'JBL-SI-S-12092016-5128', '16', '0', '16', NULL, NULL, '16', NULL, '0', '0', '2016-09-12 19:11:09', NULL, NULL, NULL, 0, '2016-09-12 19:11:09', '2016-09-12 19:11:09', 1001, NULL, 'recieved', '0', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `process_orders`
--

CREATE TABLE IF NOT EXISTS `process_orders` (
  `prco_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `apartment_store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`prco_id`),
  KEY `process_orders_item_id_idx` (`item_id`),
  KEY `process_orders_service_id_idx` (`service_id`),
  KEY `process_orders_cust_id_idx` (`cust_id`),
  KEY `process_orders_po_id_idx` (`po_id`),
  KEY `process_orders_store_id_idx` (`store_id`),
  KEY `process_orders_apartment_store_id_idx` (`apartment_store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `process_orders`
--

INSERT INTO `process_orders` (`prco_id`, `item_id`, `service_id`, `cust_id`, `po_id`, `order_id`, `name`, `color`, `brand`, `inBarCode`, `outBarCode`, `status`, `updated_at`, `created_at`, `barCodeLabel`, `itemStatus`, `itemStatusMessage`, `store_id`, `returnGarmentStatus`, `returnGarmentStatusMessage`, `apartment_store_id`) VALUES
(1, 1, 3, 2, 5, 'JBL-WD-S-12092016-3909', 'JBL-WD-S-12092016-3909-WI-shirt-1 of 2', 'cvxcz', 'dvfsdv', '120916121054600', NULL, 0, '2016-09-12 12:11:03', '2016-09-12 12:11:03', 'JBL, Naresh R, 1000004, Wash & Iron, shirt, 1 of 2, 2', 'STCU', 'order send to CU', 1, NULL, NULL, NULL),
(2, 1, 3, 2, 5, 'JBL-WD-S-12092016-3909', 'JBL-WD-S-12092016-3909-WI-shirt-2 of 2', 'sdfvsadv', 'xcvxc', '120916121054235', NULL, 0, '2016-09-12 12:11:04', '2016-09-12 12:11:04', 'JBL, Naresh R, 1000004, Wash & Iron, shirt, 2 of 2, 2', 'STCU', 'order send to CU', 1, NULL, NULL, NULL),
(3, 1, 1, 3, 6, 'JBL-SI-M-12092016-7320', 'JBL-SI-M-12092016-7320-SI-shirt-1 of 1', NULL, NULL, '120916070201431', NULL, 0, '2016-09-12 19:02:07', '2016-09-12 19:02:07', 'JBL, Sandy Karnati, 1000005, Steam Iron, shirt, 1 of 1, 3', 'STCU', 'order send to CU', 1, NULL, NULL, NULL),
(4, 2, 1, 3, 7, 'JBL-SI-M-12092016-7320', 'JBL-SI-M-12092016-7320-SI-t-shirt-1 of 2', NULL, NULL, '120916070210234', NULL, 0, '2016-09-12 19:02:14', '2016-09-12 19:02:14', 'JBL, Sandy Karnati, 1000005, Steam Iron, t-shirt, 1 of 2, 3', 'STCU', 'order send to CU', 1, NULL, NULL, NULL),
(5, 2, 1, 3, 7, 'JBL-SI-M-12092016-7320', 'JBL-SI-M-12092016-7320-SI-t-shirt-2 of 2', NULL, NULL, '120916070210792', NULL, 0, '2016-09-12 19:02:14', '2016-09-12 19:02:14', 'JBL, Sandy Karnati, 1000005, Steam Iron, t-shirt, 2 of 2, 3', 'STCU', 'order send to CU', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `process_order_addons`
--

CREATE TABLE IF NOT EXISTS `process_order_addons` (
  `prco_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  PRIMARY KEY (`prco_id`,`addon_id`),
  KEY `process_order_addons_addon_id_idx` (`addon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `process_order_addons`
--

INSERT INTO `process_order_addons` (`prco_id`, `addon_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `products_service_id_idx` (`service_id`),
  KEY `products_item_id_idx` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `role_status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `short_name`, `role_status`, `updated_at`, `created_at`) VALUES
(1, 'SUPER_ADMIN', 'super admin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'STORE_ADMIN', 'store admin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'CENTRAL_UNIT', 'CU', 1, '2016-09-09 00:00:00', '2016-08-31 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext,
  `cost` smallint(6) DEFAULT NULL,
  `discount` smallint(6) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `services_name_uniq` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `code`, `image`, `description`, `cost`, `discount`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Steam Iron', 'SI', '1.jpg', 'Steam Iron', NULL, NULL, 1, '2016-07-21 11:32:46', '2016-07-21 11:32:46'),
(2, 'Wash & Fold', 'WF', '2.jpg', 'Wash and Fold', NULL, NULL, 0, '2016-07-21 11:33:02', '2016-07-21 11:33:02'),
(3, 'Wash & Iron', 'WI', '2.jpg', 'Wash & Iron', NULL, NULL, 1, '2016-07-21 11:33:24', '2016-07-21 11:33:24'),
(4, 'Dry Clean', 'DC', '3.jpg', 'Dry Cleaning', NULL, NULL, 1, '2016-07-21 11:33:46', '2016-07-21 11:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `service_addons`
--

CREATE TABLE IF NOT EXISTS `service_addons` (
  `service_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  PRIMARY KEY (`service_id`,`addon_id`),
  KEY `service_addons_addon_id_idx` (`addon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_addons`
--

INSERT INTO `service_addons` (`service_id`, `addon_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(1, 2),
(3, 2),
(4, 2),
(3, 3),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `refPoints` int(11) DEFAULT NULL,
  `regPoints` int(11) DEFAULT NULL,
  `minPoints` int(11) DEFAULT NULL,
  `rpointsCost` int(11) DEFAULT NULL,
  `serviceCharge` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`s_id`, `refPoints`, `regPoints`, `minPoints`, `rpointsCost`, `serviceCharge`, `status`, `updated_at`, `created_at`) VALUES
(1, 20, 20, 800, 10, 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `idProof` longtext,
  PRIMARY KEY (`staff_id`),
  KEY `staff_apt_id_idx` (`apt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `store_services`
--

CREATE TABLE IF NOT EXISTS `store_services` (
  `area_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`area_id`,`service_id`),
  KEY `store_services_service_id_idx` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_services`
--

INSERT INTO `store_services` (`area_id`, `service_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 3),
(2, 3),
(3, 3),
(1, 4),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `temp_orders`
--

CREATE TABLE IF NOT EXISTS `temp_orders` (
  `to_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`to_id`),
  KEY `temp_orders_item_id_idx` (`item_id`),
  KEY `temp_orders_service_id_idx` (`service_id`),
  KEY `temp_orders_cust_id_idx` (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_order_addons`
--

CREATE TABLE IF NOT EXISTS `temp_order_addons` (
  `poa_id` int(11) NOT NULL AUTO_INCREMENT,
  `to_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  `poa_count` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`poa_id`),
  KEY `temp_order_addons_to_id_idx` (`to_id`),
  KEY `temp_order_addons_addon_id_idx` (`addon_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_history`
--

CREATE TABLE IF NOT EXISTS `transactions_history` (
  `th_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` varchar(25) DEFAULT NULL,
  `paidAmount` varchar(255) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `usedAmount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`th_id`),
  KEY `transactions_history_customer_id_idx` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `transactions_history`
--

INSERT INTO `transactions_history` (`th_id`, `customer_id`, `order_id`, `paidAmount`, `updated_at`, `created_at`, `usedAmount`) VALUES
(1, 3, 'JBL-SI-M-12092016-7320', '-19', '2016-09-12 19:13:48', '2016-09-12 19:13:48', 'refunded amount');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
  `v_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`v_id`),
  KEY `vehicles_apt_id_idx` (`apt_id`),
  KEY `vehicles_block_id_idx` (`block_id`),
  KEY `vehicles_flat_id_idx` (`flat_id`),
  KEY `vehicles_cust_id_idx` (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `address` longtext,
  PRIMARY KEY (`vendor_id`),
  KEY `vendors_apt_id_idx` (`apt_id`),
  KEY `vendors_area_id_idx` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `v_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `flatApproval` int(11) DEFAULT NULL,
  PRIMARY KEY (`v_id`),
  KEY `visitors_apt_id_idx` (`apt_id`),
  KEY `visitors_block_id_idx` (`block_id`),
  KEY `visitors_flat_id_idx` (`flat_id`),
  KEY `visitors_cust_id_idx` (`cust_id`),
  KEY `visitors_faculty_id_idx` (`faculty_id`),
  KEY `visitors_facultyApproval_idx` (`facultyApproval`),
  KEY `visitors_flatApproval_idx` (`flatApproval`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `visitors_history`
--

CREATE TABLE IF NOT EXISTS `visitors_history` (
  `vh_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `flatApproval` int(11) DEFAULT NULL,
  PRIMARY KEY (`vh_id`),
  KEY `visitors_history_apt_id_idx` (`apt_id`),
  KEY `visitors_history_block_id_idx` (`block_id`),
  KEY `visitors_history_flat_id_idx` (`flat_id`),
  KEY `visitors_history_cust_id_idx` (`cust_id`),
  KEY `visitors_history_faculty_id_idx` (`faculty_id`),
  KEY `visitors_history_facultyApproval_idx` (`facultyApproval`),
  KEY `visitors_history_flatApproval_idx` (`flatApproval`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  ADD CONSTRAINT `customers_ibfk_5` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`);

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
  ADD CONSTRAINT `place_order_ids_ibfk_3` FOREIGN KEY (`pb_id`) REFERENCES `pickup_boys` (`pb_id`);

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
