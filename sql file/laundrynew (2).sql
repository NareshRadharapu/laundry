-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2016 at 08:44 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundrynew`
--

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addons`
--

INSERT INTO `addons` (`addon_id`, `name`, `image`, `price`, `description`, `status`, `updated_at`, `created_at`) VALUES
(1, 'premium packing', '', '10', '', 1, '2016-06-03 10:48:15', '2016-06-03 10:48:15'),
(2, 'quick delivery', NULL, '5', 'asdf', 1, '2016-06-03 10:48:30', '2016-06-03 10:48:30'),
(3, 'premium folding', NULL, '5', 'adfasdf', 1, '2016-06-03 10:48:45', '2016-06-03 10:48:45');

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
  `pincode` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`apt_id`, `area_id`, `catalog_id`, `name`, `address`, `pincode`, `status`) VALUES
(1, 1, 2, 'SMR Vinay', 'sdfasdf', 500038, 1),
(2, 1, 2, 'Lanco Hills500083', NULL, 500083, 1);

-- --------------------------------------------------------

--
-- Table structure for table `apartment_visitors`
--

CREATE TABLE `apartment_visitors` (
  `av_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `v_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `vehicleNumber` varchar(255) DEFAULT NULL,
  `vcount` smallint(6) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `vdate` datetime DEFAULT NULL,
  `facultyApproval` int(11) DEFAULT NULL,
  `customerApproval` int(11) DEFAULT NULL,
  `facultyApprovalStatus` tinyint(1) NOT NULL,
  `flatApprovalStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apartment_visitors`
--

INSERT INTO `apartment_visitors` (`av_id`, `apt_id`, `block_id`, `flat_id`, `cust_id`, `v_id`, `faculty_id`, `purpose`, `vehicleNumber`, `vcount`, `updated_at`, `created_at`, `in_time`, `out_time`, `vdate`, `facultyApproval`, `customerApproval`, `facultyApprovalStatus`, `flatApprovalStatus`) VALUES
(1, 1, 2, 2, NULL, 5, 1, 'this is purpose', 'ts 08 ab 1334', 6, '2016-06-21 12:09:42', '2016-06-21 12:09:42', '2016-06-22 15:25:19', NULL, '2016-06-21 12:09:42', NULL, NULL, 0, 0);

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`area_id`, `city_id`, `name`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Jublihills', 1, '2016-06-03 10:42:47', '2016-06-03 10:42:47');

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

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`block_id`, `apt_id`, `name`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'A', 1, '2016-06-03 10:52:24', '2016-06-03 10:52:24'),
(2, 1, 'B', 1, '2016-06-03 10:52:27', '2016-06-03 10:52:27'),
(3, 2, 'A', 1, '2016-06-16 07:27:39', '2016-06-16 07:27:39'),
(4, 2, 'B', 1, '2016-06-16 07:28:21', '2016-06-16 07:28:21');

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
(1, 1, 2, 1, 1, 12, 2, 2, 1, '2016-06-03 10:50:45', '2016-06-03 10:50:45'),
(2, 1, 2, 1, 2, 12, 1, 2, 1, '2016-06-03 10:51:01', '2016-06-03 10:51:01');

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
(1, 'default', '', 1, '2016-06-03 10:43:09', '2016-06-03 10:43:09'),
(2, 'catalog one', NULL, 1, '2016-06-03 10:43:19', '2016-06-03 10:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `name`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Hyderabad', 1, '2016-06-03 10:42:30', '2016-06-03 10:42:30'),
(2, 'Banglore', 1, '2016-06-08 09:19:54', '2016-06-08 09:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `passwordSalt` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `ref_id` varchar(255) DEFAULT NULL,
  `oauth_id` varchar(255) DEFAULT NULL,
  `rpoints` smallint(6) DEFAULT NULL,
  `firstOrder` smallint(6) DEFAULT NULL,
  `resetPassword` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `ownerName` varchar(255) DEFAULT NULL,
  `ownerMobile` varchar(255) DEFAULT NULL,
  `ownerAddress` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `showInTele` tinyint(1) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `subType` varchar(255) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `apt_id`, `block_id`, `flat_id`, `area_id`, `firstname`, `lastname`, `email`, `type`, `password`, `passwordSalt`, `address`, `ref_id`, `oauth_id`, `rpoints`, `firstOrder`, `resetPassword`, `status`, `updated_at`, `created_at`, `ownerName`, `ownerMobile`, `ownerAddress`, `whatsapp`, `dob`, `showInTele`, `mobile`, `subType`, `owner_id`) VALUES
(1, 1, 1, 2, NULL, 'Ramakrishna', 'Reddy', 'rkreddy.gouni@gmail.com', 'apartment', '090dd2057a49cccab84f66772449d4af', '', 'sdfasdf', NULL, '523312c78f9c3ade90d555daa4c4075e', 0, 1, 0, 1, '2016-06-03 10:55:02', '2016-06-03 10:55:02', NULL, NULL, NULL, NULL, NULL, 0, 9553834830, 'owner', NULL),
(2, 1, 2, 7, NULL, 'Chanti', 'chinna chanti', 'chanti@gmail.com', 'apartment', '257555eb7a5cf0fedc38231cadab76a1', '', 'sdfasdf', NULL, NULL, NULL, 1, 0, 0, '2016-06-11 08:34:50', '2016-06-11 08:34:50', NULL, NULL, NULL, NULL, NULL, 0, 8140809740, 'owner', NULL),
(9, 1, 2, 2, NULL, 'Sandy', 'jh', 'hgf@dgd', 'apartment', '1e928e1d80fb6b966fe5ac39e0f75bcd', '', 'sdfasdf', NULL, NULL, NULL, 1, 0, 1, '2016-06-14 09:19:43', '2016-06-14 09:19:43', NULL, NULL, NULL, '5635632355', NULL, 1, 5635632355, 'owner', NULL),
(10, 1, 2, 2, NULL, 'kish', NULL, 'kish@gmail.com', 'normal', '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, 1, 0, 0, '2016-06-14 09:21:38', '2016-06-14 09:21:38', NULL, NULL, NULL, NULL, NULL, 0, 5561764025, 'owner', NULL),
(11, 1, 2, 6, NULL, 'First', 'Name', 'sand@sk.com', 'apartment', '8d2b277bc549460e6ad4021a783a4ee1', '', 'sdfasdf', NULL, NULL, NULL, 1, 0, 1, '2016-06-14 09:21:38', '2016-06-14 09:21:38', NULL, NULL, NULL, '358545246', NULL, 1, 358545246, 'tenant', 10),
(14, 1, 2, 2, NULL, 'Sandy new', 'jh', 'hgf@dgd', 'apartment', '1e928e1d80fb6b966fe5ac39e0f75bcd', '', 'sdfasdf', NULL, NULL, NULL, 1, 0, 1, '2016-06-14 09:19:43', '2016-06-14 09:19:43', NULL, NULL, NULL, '5635632355', NULL, 1, 5635632353, 'family member', NULL),
(17, 1, 1, 2, NULL, 'fm first name', 'fm last name', 'fm@gmail.com', 'apartment', '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, 1, 0, 1, '2016-06-15 08:31:13', '2016-06-15 08:31:13', NULL, NULL, NULL, NULL, NULL, 0, 5487963265, 'family member', NULL),
(19, 1, 1, 2, NULL, 'fm first second', 'fm last name', 'fm@gmail.com', 'apartment', '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, 1, 0, 1, '2016-06-15 08:34:01', '2016-06-15 08:34:01', NULL, NULL, NULL, NULL, NULL, 0, 548796265, 'family member', NULL),
(21, 1, 1, 2, NULL, 'fm first name', 'fm last name', 'fm@gmail.com', 'apartment', '900150983cd24fb0d6963f7d28e17f72', '', NULL, NULL, NULL, NULL, 1, 0, 1, '2016-06-17 07:37:42', '2016-06-17 07:37:42', NULL, NULL, NULL, NULL, NULL, 0, 548796223, 'family member', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `ca_id` int(11) NOT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `pincode` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`ca_id`, `cust_id`, `address`, `landmark`, `status`, `updated_at`, `created_at`, `pincode`, `area_id`) VALUES
(1, 1, 'updated', 'updated land', 0, '2016-06-11 10:01:19', '2016-06-11 10:01:19', 46465, 1);

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

--
-- Dumping data for table `customer_idproof`
--

INSERT INTO `customer_idproof` (`cip_id`, `customer_id`, `enroll`, `type`, `image`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, '68946148974632', 'aadhar card', 'adsfasfadsfasfasdf.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `apt_id`, `firstname`, `lastname`, `email`, `mobile`, `designation`, `password`, `passwordSalt`, `oauth_id`, `resetPassword`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 'Ramakrishna', 'Gouni', 'rkreddy.gouni@gmail.com', '9553834830', 'Array', '235ecaeea6949f8aeaac55480ab8d905', '', NULL, 0, 1, '2016-06-14 08:03:59', '2016-06-14 08:03:59');

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

--
-- Dumping data for table `flats`
--

INSERT INTO `flats` (`flat_id`, `block_id`, `name`, `status`, `updated_at`, `created_at`, `intercom`, `eusn`, `readyToSale`, `readyToOccupy`, `bhk`, `size`, `facing`, `salePrice`, `rentPrice`, `nofpplStay`, `cntOneName`, `cntOneMobile`, `cntTwoName`, `cntTwoMobile`) VALUES
(1, 1, '101', 1, '2016-06-03 10:52:44', '2016-06-03 10:52:44', NULL, NULL, 0, 1, '0', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 1, '102', 1, '2016-06-03 10:52:44', '2016-06-03 10:52:44', NULL, NULL, 0, 0, '0', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 1, '103', 1, '2016-06-03 10:52:44', '2016-06-03 10:52:44', NULL, NULL, 0, 0, '0', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, '104', 1, '2016-06-03 10:52:44', '2016-06-03 10:52:44', NULL, NULL, 0, 0, '0', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, '101', 1, '2016-06-03 10:52:58', '2016-06-03 10:52:58', NULL, NULL, 0, 0, '0', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 2, '102', 1, '2016-06-03 10:52:58', '2016-06-03 10:52:58', '101', '123456789', 0, 0, '1BHK', 2000, 'east', 120000, 50000, 5, 'Naresh', '9014840202', 'Raju', '9703651416'),
(7, 2, '103', 1, '2016-06-03 10:52:58', '2016-06-03 10:52:58', 'dasd', 'asdasdasd', 1, 0, '3BHK', 32767, 'west', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, '104', 1, '2016-06-03 10:52:58', '2016-06-03 10:52:58', '164113', 'safasdf', 1, 0, '1BHK', 2500, 'west', 123, 233, 2, 'dfasdf', '123123', 'adfasdf', '12312'),
(9, 4, '101', 1, '2016-06-16 07:47:45', '2016-06-16 07:47:45', NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flat_freq_visitors`
--

CREATE TABLE `flat_freq_visitors` (
  `flat_id` int(11) NOT NULL,
  `v_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flat_freq_visitors`
--

INSERT INTO `flat_freq_visitors` (`flat_id`, `v_id`) VALUES
(2, 7),
(5, 5);

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
(1, 1, 'shirt', 'srt', '', 1, '2016-06-03 10:49:55', '2016-06-03 10:49:55'),
(2, 1, 'pant', 'pnt', NULL, 1, '2016-06-03 10:50:10', '2016-06-03 10:50:10'),
(3, 2, 'saree', 'sre', NULL, 1, '2016-06-03 10:50:23', '2016-06-03 10:50:23');

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
(2, 1),
(2, 2),
(3, 1),
(3, 2);

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
(1, 'men', 'm', NULL, 1, '2016-06-03 10:49:34', '2016-06-03 10:49:34'),
(2, 'Women', 'w', NULL, 1, '2016-06-03 10:49:41', '2016-06-03 10:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `place_order`
--

CREATE TABLE `place_order` (
  `po_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `order_id` varchar(18) NOT NULL,
  `icount` smallint(6) NOT NULL,
  `cost` smallint(6) NOT NULL,
  `rpoints` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place_order`
--

INSERT INTO `place_order` (`po_id`, `item_id`, `service_id`, `cust_id`, `order_id`, `icount`, `cost`, `rpoints`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 1, '201606031055P', 4, 30, 0, 0, '2016-06-03 10:55:58', '2016-06-03 10:55:58'),
(2, 2, 1, 1, '201606031055P', 2, 0, 0, 0, '2016-06-03 10:55:58', '2016-06-03 10:55:58'),
(3, 3, 2, 1, '201606031055P', 4, 0, 0, 0, '2016-06-03 10:55:58', '2016-06-03 10:55:58'),
(4, 2, 2, 1, '201606031055P', 4, 0, 0, 0, '2016-06-03 10:55:58', '2016-06-03 10:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `place_order_addons`
--

CREATE TABLE `place_order_addons` (
  `poa_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  `poa_count` smallint(6) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place_order_addons`
--

INSERT INTO `place_order_addons` (`poa_id`, `po_id`, `addon_id`, `poa_count`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 2, '2016-06-03 10:55:58', '2016-06-03 10:55:58'),
(2, 1, 2, 2, '2016-06-03 10:55:58', '2016-06-03 10:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `place_order_ids`
--

CREATE TABLE `place_order_ids` (
  `o_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `order_id` varchar(18) NOT NULL,
  `subtotal` varchar(18) DEFAULT NULL,
  `vat` varchar(18) DEFAULT NULL,
  `totalAmount` varchar(18) DEFAULT NULL,
  `rPointsUsed` varchar(18) DEFAULT NULL,
  `totalAmountPaid` varchar(18) DEFAULT NULL,
  `balanceAmount` int(11) DEFAULT NULL,
  `firstPaidAmount` int(11) DEFAULT NULL,
  `secondPaidAmount` int(11) DEFAULT NULL,
  `thirdPaidAmount` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `place_order_ids`
--

INSERT INTO `place_order_ids` (`o_id`, `customer_id`, `address_id`, `order_id`, `subtotal`, `vat`, `totalAmount`, `rPointsUsed`, `totalAmountPaid`, `balanceAmount`, `firstPaidAmount`, `secondPaidAmount`, `thirdPaidAmount`, `status`, `updated_at`, `created_at`) VALUES
(1, 1, NULL, '201606031055P', '30', '1.5', '31.5', NULL, '31.5', NULL, NULL, NULL, NULL, 0, '2016-06-03 10:55:57', '2016-06-03 10:55:57');

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
(1, 'wash', 'ws', '1.jpg', '', NULL, NULL, 1, '2016-06-03 10:48:59', '2016-06-03 10:48:59'),
(2, 'Iron', 'IRN', '1.jpg', NULL, NULL, NULL, 1, '2016-06-03 10:49:23', '2016-06-03 10:49:23'),
(3, 'dry clean', 'd', 'logoweb.png', 'dsx', NULL, NULL, 1, '2016-06-18 12:01:15', '2016-06-18 12:01:15');

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
(2, 1),
(2, 2),
(2, 3),
(3, 1);

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
  `serviceCharge` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vechicles`
--

CREATE TABLE `vechicles` (
  `v_id` int(11) NOT NULL,
  `apt_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `regNumber` varchar(255) NOT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `vtype` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `rfid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vechicles`
--

INSERT INTO `vechicles` (`v_id`, `apt_id`, `block_id`, `flat_id`, `cust_id`, `regNumber`, `make`, `model`, `vtype`, `status`, `updated_at`, `created_at`, `rfid`) VALUES
(1, 1, 1, 2, 1, 'asdfasd43423', 'honda 2012', NULL, 'car', 1, '2016-06-16 08:53:50', '2016-06-16 08:53:50', 'car'),
(2, 1, 1, 2, 9, 'sadf', 'maruthi 2016', NULL, 'car', 1, '2016-06-16 09:21:25', '2016-06-16 09:21:25', 'car');

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
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `v_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `vehicle` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`v_id`, `name`, `mobile`, `updated_at`, `created_at`, `vehicle`, `image`) VALUES
(5, 'rk', '9553834830', '2016-06-21 12:09:42', '2016-06-21 12:09:42', NULL, NULL),
(7, 'Ramarkishna', '9885227810', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ts 05 cs 1234', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`addon_id`),
  ADD UNIQUE KEY `addons_name_uniq` (`name`);

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`apt_id`),
  ADD KEY `apartments_area_id_idx` (`area_id`),
  ADD KEY `apartments_catalog_id_idx` (`catalog_id`);

--
-- Indexes for table `apartment_visitors`
--
ALTER TABLE `apartment_visitors`
  ADD PRIMARY KEY (`av_id`),
  ADD KEY `apartment_visitors_apt_id_idx` (`apt_id`),
  ADD KEY `apartment_visitors_block_id_idx` (`block_id`),
  ADD KEY `apartment_visitors_flat_id_idx` (`flat_id`),
  ADD KEY `apartment_visitors_cust_id_idx` (`cust_id`),
  ADD KEY `apartment_visitors_v_id_idx` (`v_id`),
  ADD KEY `apartment_visitors_faculty_id_idx` (`faculty_id`),
  ADD KEY `apartment_visitors_facultyApproval_idx` (`facultyApproval`),
  ADD KEY `apartment_visitors_customerApproval_idx` (`customerApproval`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`area_id`),
  ADD KEY `areas_city_id_idx` (`city_id`);

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
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`),
  ADD UNIQUE KEY `customers_mobile_uniq` (`mobile`),
  ADD KEY `customers_apt_id_idx` (`apt_id`),
  ADD KEY `customers_block_id_idx` (`block_id`),
  ADD KEY `customers_flat_id_idx` (`flat_id`),
  ADD KEY `customers_area_id_idx` (`area_id`),
  ADD KEY `customers_owner_id_idx` (`owner_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`ca_id`),
  ADD KEY `customer_address_cust_id_idx` (`cust_id`),
  ADD KEY `customer_address_area_id_idx` (`area_id`);

--
-- Indexes for table `customer_idproof`
--
ALTER TABLE `customer_idproof`
  ADD PRIMARY KEY (`cip_id`),
  ADD KEY `customer_idproof_customer_id_idx` (`customer_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `employees_email_uniq` (`email`),
  ADD KEY `employees_role_id_idx` (`role_id`);

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
-- Indexes for table `flat_freq_visitors`
--
ALTER TABLE `flat_freq_visitors`
  ADD PRIMARY KEY (`flat_id`,`v_id`),
  ADD KEY `flat_freq_visitors_v_id_idx` (`v_id`);

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
  ADD KEY `place_order_ids_address_id_idx` (`address_id`);

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
-- Indexes for table `vechicles`
--
ALTER TABLE `vechicles`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `vechicles_apt_id_idx` (`apt_id`),
  ADD KEY `vechicles_block_id_idx` (`block_id`),
  ADD KEY `vechicles_flat_id_idx` (`flat_id`),
  ADD KEY `vechicles_cust_id_idx` (`cust_id`);

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
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`v_id`),
  ADD UNIQUE KEY `visitors_mobile_uniq` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `addon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `apt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `apartment_visitors`
--
ALTER TABLE `apartment_visitors`
  MODIFY `av_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `catalogprice`
--
ALTER TABLE `catalogprice`
  MODIFY `cp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer_idproof`
--
ALTER TABLE `customer_idproof`
  MODIFY `cip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `flats`
--
ALTER TABLE `flats`
  MODIFY `flat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `flat_gallery`
--
ALTER TABLE `flat_gallery`
  MODIFY `fg_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `itype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `place_order`
--
ALTER TABLE `place_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `place_order_addons`
--
ALTER TABLE `place_order_addons`
  MODIFY `poa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `place_order_ids`
--
ALTER TABLE `place_order_ids`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vechicles`
--
ALTER TABLE `vechicles`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `apartments`
--
ALTER TABLE `apartments`
  ADD CONSTRAINT `apartments_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `apartments_ibfk_2` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`catalog_id`);

--
-- Constraints for table `apartment_visitors`
--
ALTER TABLE `apartment_visitors`
  ADD CONSTRAINT `apartment_visitors_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_5` FOREIGN KEY (`v_id`) REFERENCES `visitors` (`v_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_6` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_7` FOREIGN KEY (`facultyApproval`) REFERENCES `faculties` (`faculty_id`),
  ADD CONSTRAINT `apartment_visitors_ibfk_8` FOREIGN KEY (`customerApproval`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);

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
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `customers_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `customers_ibfk_4` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`),
  ADD CONSTRAINT `customers_ibfk_5` FOREIGN KEY (`owner_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `customer_address_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `customer_address_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`area_id`);

--
-- Constraints for table `customer_idproof`
--
ALTER TABLE `customer_idproof`
  ADD CONSTRAINT `customer_idproof_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

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
-- Constraints for table `flat_freq_visitors`
--
ALTER TABLE `flat_freq_visitors`
  ADD CONSTRAINT `flat_freq_visitors_ibfk_1` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `flat_freq_visitors_ibfk_2` FOREIGN KEY (`v_id`) REFERENCES `visitors` (`v_id`);

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
  ADD CONSTRAINT `place_order_ids_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `customer_address` (`ca_id`);

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
-- Constraints for table `vechicles`
--
ALTER TABLE `vechicles`
  ADD CONSTRAINT `vechicles_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `vechicles_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `vechicles_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `vechicles_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`apt_id`) REFERENCES `apartments` (`apt_id`),
  ADD CONSTRAINT `vehicles_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `blocks` (`block_id`),
  ADD CONSTRAINT `vehicles_ibfk_3` FOREIGN KEY (`flat_id`) REFERENCES `flats` (`flat_id`),
  ADD CONSTRAINT `vehicles_ibfk_4` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
