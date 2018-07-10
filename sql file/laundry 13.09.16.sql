-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2016 at 08:26 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `catalog_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `wallet` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `crdate` datetime DEFAULT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `item_services`
--

CREATE TABLE `item_services` (
  `item_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `place_order_ids`
--

CREATE TABLE `place_order_ids` (
  `o_id` int(11) NOT NULL,
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
  `reFundAmount` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `process_order_addons`
--

CREATE TABLE `process_order_addons` (
  `prco_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `service_addons`
--

CREATE TABLE `service_addons` (
  `service_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD UNIQUE KEY `addons_name_uniq` (`name`);

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
  ADD KEY `customers_area_id_idx` (`area_id`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`ca_id`),
  ADD KEY `customer_address_area_id_idx` (`area_id`),
  ADD KEY `customer_address_cust_id_idx` (`cust_id`);

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
  ADD KEY `place_order_ids_pb_id_idx` (`pb_id`);

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
  MODIFY `addon_id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `catalogprice`
--
ALTER TABLE `catalogprice`
  MODIFY `cp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `catalog_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cc_camera`
--
ALTER TABLE `cc_camera`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `central_units`
--
ALTER TABLE `central_units`
  MODIFY `cu_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `cudo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cu_employees`
--
ALTER TABLE `cu_employees`
  MODIFY `cue_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cu_order_details`
--
ALTER TABLE `cu_order_details`
  MODIFY `cuod_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cu_order_messages`
--
ALTER TABLE `cu_order_messages`
  MODIFY `cuom_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cu_send_orders`
--
ALTER TABLE `cu_send_orders`
  MODIFY `cuso_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `itype_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pickup_boys`
--
ALTER TABLE `pickup_boys`
  MODIFY `pb_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `place_order`
--
ALTER TABLE `place_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `place_order_addons`
--
ALTER TABLE `place_order_addons`
  MODIFY `poa_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `place_order_ids`
--
ALTER TABLE `place_order_ids`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `process_orders`
--
ALTER TABLE `process_orders`
  MODIFY `prco_id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `th_id` int(11) NOT NULL AUTO_INCREMENT;
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
