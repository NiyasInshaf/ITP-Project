-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2021 at 05:56 PM
-- Server version: 5.7.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `niyas_insaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `seno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `delivery_address` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  UNIQUE KEY `seno` (`seno`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`seno`, `customer_id`, `date`, `delivery_address`, `status`) VALUES
(1, '1', '2021-04-18', '13, Dam Street, Colombo', 'pending'),
(2, '1', '2021-04-12', '13, Dam Street, Colombo', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `carts_items`
--

DROP TABLE IF EXISTS `carts_items`;
CREATE TABLE IF NOT EXISTS `carts_items` (
  `seno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) NOT NULL,
  `stock_id` bigint(20) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  UNIQUE KEY `seno` (`seno`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carts_items`
--

INSERT INTO `carts_items` (`seno`, `cart_id`, `stock_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 1),
(3, 2, 1, 3),
(4, 2, 3, 1),
(5, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cart_payment`
--

DROP TABLE IF EXISTS `cart_payment`;
CREATE TABLE IF NOT EXISTS `cart_payment` (
  `seno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(500) NOT NULL,
  `order_reference_number` varchar(500) NOT NULL,
  `date_time_transaction` varchar(500) NOT NULL,
  `status_code` varchar(500) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `payment_gateway_used` varchar(500) NOT NULL,
  PRIMARY KEY (`seno`),
  UNIQUE KEY `seno` (`seno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `seno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `l_name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  PRIMARY KEY (`seno`),
  UNIQUE KEY `seno` (`seno`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`seno`, `name`, `l_name`, `email`, `phone`, `username`, `password`) VALUES
(1, 'Mohamed', '', 'mohamed@gmail.com', '0772515454', 'mohamed', 'pass123');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `seno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `order_item_id` bigint(20) NOT NULL,
  `stock_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `rating` int(10) NOT NULL,
  `reaction` varchar(100) NOT NULL,
  `date` date NOT NULL,
  UNIQUE KEY `seno` (`seno`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`seno`, `order_id`, `order_item_id`, `stock_id`, `description`, `rating`, `reaction`, `date`) VALUES
(3, 1, 2, 2, 'dsf sdfdsfsdf sdf sd', 3, 'Perfectly Satisfied', '2021-04-18'),
(4, 2, 3, 1, 'sdgefdsgdfg', 3, 'Has to be Improved', '2021-04-18'),
(5, 2, 4, 3, 'sgs dfgsfg f', 3, 'Perfectly Satisfied', '2021-04-18'),
(6, 2, 5, 2, 'sdf gdfs gfdsg', 4, 'Has to be Improved', '2021-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `seno` varchar(255) NOT NULL,
  `name` varchar(250) NOT NULL,
  `qty_remaining` decimal(10,2) NOT NULL,
  `gty_type` varchar(20) NOT NULL,
  `price_buying` decimal(10,2) NOT NULL,
  `price_selling` decimal(10,2) NOT NULL,
  `price_last` decimal(10,2) NOT NULL,
  `discount_percent` decimal(10,2) NOT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  `qty_latest` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `cat_color` varchar(100) NOT NULL,
  `cat_size` varchar(100) NOT NULL,
  `cat_set` text NOT NULL,
  `image` text NOT NULL,
  `expiry` date NOT NULL,
  `supplier` varchar(400) NOT NULL,
  `printed` varchar(10) NOT NULL,
  `date_added` datetime NOT NULL,
  `invoice_id` varchar(20) NOT NULL,
  `views` int(20) NOT NULL,
  PRIMARY KEY (`seno`),
  UNIQUE KEY `seno_3` (`seno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`seno`, `name`, `qty_remaining`, `gty_type`, `price_buying`, `price_selling`, `price_last`, `discount_percent`, `last_modified`, `qty_latest`, `category`, `cat_color`, `cat_size`, `cat_set`, `image`, `expiry`, `supplier`, `printed`, `date_added`, `invoice_id`, `views`) VALUES
('1', 'Product 1', '1.00', 'pcs', '0.00', '5500.00', '0.00', '0.00', '2018-09-03 04:15:46', '1.00', 'Glossy Cotton Saree', 'women', 'default', 'Fabric:- Glossy Cotton\r\nWork:- Hand woven', ' ', '2018-09-03', 'default', 'n', '2018-09-03 15:13:10', 'master', 0),
('2', 'Product 2', '1.00', 'pcs', '0.00', '3200.00', '0.00', '0.00', '2018-09-03 04:23:50', '1.00', 'Glossy Cotton Saree', 'women', 'default', 'Fabric:- Glossy Cotton\r\nWork:- Hand woven', ' ', '2018-09-03', 'default', 'n', '2018-09-03 15:23:27', 'master', 0),
('3', 'Product 3', '1.00', 'pcs', '0.00', '1850.00', '0.00', '0.00', '2018-09-03 04:24:03', '1.00', 'Glossy Cotton Saree', 'women', 'default', 'Fabric:- Glossy Cotton\r\nWork:- Hand woven', ' ', '2018-09-03', 'default', 'n', '2018-09-03 15:23:50', 'master', 0),
('4', 'Product 4', '1.00', 'pcs', '0.00', '2500.00', '0.00', '0.00', '2018-09-03 04:24:33', '1.00', 'Glossy Cotton Saree', 'women', 'default', 'Fabric:- Glossy Cotton\r\nWork:- Hand woven', ' ', '2018-09-03', 'default', 'n', '2018-09-03 15:24:03', 'master', 0),
('5', 'Glossy Cotton Saree', '1.00', 'pcs', '0.00', '4000.00', '0.00', '0.00', '2018-09-03 04:28:03', '1.00', 'Glossy Cotton Saree', 'women', 'default', 'Fabric:- Glossy Cotton\r\nWork:- Hand woven', ' ', '2018-09-03', 'default', 'n', '2018-09-03 15:27:43', 'master', 0),
('6', 'gdfgdf', '50.00', 'pcs', '0.00', '2000.00', '0.00', '0.00', '2018-09-10 23:41:58', '50.00', 'Glossy Cotton Saree', 'women', 'default', 'sdfs dfsd fsdf\r\ndf sdf sdf sdf sdfsdf d', 'showroom', '2018-09-11', 'default', 'n', '2018-09-11 10:41:26', 'master', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE IF NOT EXISTS `tracking` (
  `tracking_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `updated_date` date NOT NULL,
  `description` text NOT NULL,
  `user` bigint(20) NOT NULL,
  UNIQUE KEY `tracking_id` (`tracking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`tracking_id`, `order_id`, `updated_date`, `description`, `user`) VALUES
(1, 1, '2021-04-12', 'Items Packed', 1),
(2, 1, '2021-04-13', 'Package is Warehouse', 1),
(3, 1, '2021-04-14', 'Package Shipped', 1),
(4, 1, '2021-04-18', 'Out for Delivery', 1),
(5, 1, '2021-04-18', 'Delivered', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `seno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `pword` text NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`seno`),
  UNIQUE KEY `seno` (`seno`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`seno`, `name`, `uname`, `pword`, `type`) VALUES
(1, 'Administrator', 'admin', 'pass', 'admin'),
(2, 'Master', 'master', 'pass', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
