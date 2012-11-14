-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2012 at 02:59 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shopping_cart2`
--

-- --------------------------------------------------------

--
-- Table structure for table `itm_categories`
--

CREATE TABLE IF NOT EXISTS `itm_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` varchar(512) NOT NULL DEFAULT 'Description not added yet.',
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `itm_products`
--

CREATE TABLE IF NOT EXISTS `itm_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(512) NOT NULL DEFAULT 'Description not provided yet.',
  `unit` varchar(32) NOT NULL DEFAULT 'Units',
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `odr_carts`
--

CREATE TABLE IF NOT EXISTS `odr_carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `units` int(11) NOT NULL,
  `cart_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`,`user_id`,`product_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `odr_orders`
--

CREATE TABLE IF NOT EXISTS `odr_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `odr_order_list`
--

CREATE TABLE IF NOT EXISTS `odr_order_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `units` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`,`order_status_id`),
  KEY `product_id` (`product_id`),
  KEY `order_status_id` (`order_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `odr_order_statuses`
--

CREATE TABLE IF NOT EXISTS `odr_order_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` int(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usr_addresses`
--

CREATE TABLE IF NOT EXISTS `usr_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(32) NOT NULL,
  `state` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `street` varchar(32) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usr_phone_numbers`
--

CREATE TABLE IF NOT EXISTS `usr_phone_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `number_type` varchar(16) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usr_profiles`
--

CREATE TABLE IF NOT EXISTS `usr_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL DEFAULT 'Anonymous',
  `last_name` varchar(64) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Gender','male','female') DEFAULT NULL,
  `work` varchar(256) DEFAULT NULL,
  `marital_status` varchar(256) DEFAULT NULL,
  `about` varchar(512) DEFAULT 'Description not added yet.',
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usr_roles_sd`
--

CREATE TABLE IF NOT EXISTS `usr_roles_sd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usr_users`
--

CREATE TABLE IF NOT EXISTS `usr_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usr_user_role`
--

CREATE TABLE IF NOT EXISTS `usr_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `itm_categories`
--
ALTER TABLE `itm_categories`
  ADD CONSTRAINT `itm_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `itm_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `itm_products`
--
ALTER TABLE `itm_products`
  ADD CONSTRAINT `itm_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `itm_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `odr_carts`
--
ALTER TABLE `odr_carts`
  ADD CONSTRAINT `odr_carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `itm_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odr_carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odr_orders`
--
ALTER TABLE `odr_orders`
  ADD CONSTRAINT `odr_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `odr_order_list`
--
ALTER TABLE `odr_order_list`
  ADD CONSTRAINT `odr_order_list_ibfk_3` FOREIGN KEY (`order_status_id`) REFERENCES `odr_order_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odr_order_list_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `odr_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `odr_order_list_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `itm_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usr_addresses`
--
ALTER TABLE `usr_addresses`
  ADD CONSTRAINT `usr_addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usr_phone_numbers`
--
ALTER TABLE `usr_phone_numbers`
  ADD CONSTRAINT `usr_phone_numbers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usr_profiles`
--
ALTER TABLE `usr_profiles`
  ADD CONSTRAINT `usr_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usr_user_role`
--
ALTER TABLE `usr_user_role`
  ADD CONSTRAINT `usr_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `usr_roles_sd` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usr_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
