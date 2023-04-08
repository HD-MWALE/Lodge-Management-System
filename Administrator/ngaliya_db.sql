-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 23, 2022 at 09:19 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngaliya_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1 = Male, 2 = Female, 3 = Others',
  `email` varchar(250) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `avatar` varchar(250) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `position` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = Manager, 2 = Receptionist',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `firstname`, `lastname`, `gender`, `email`, `contact`, `address`, `username`, `password`, `avatar`, `last_login`, `position`, `date_added`, `date_updated`) VALUES
(1, 'Bright', 'Mwale', 1, 'bright@gmail.com', '0993979170', 'Blantyre', 'Hyber', '$2y$10$mksoxWfdp9sXhD6a4nNn9.ky/O9zQ3wqNmlUenKyEyxmpZGId.9e2', NULL, '2022-02-23 09:19:41', 1, '2022-02-16 23:32:02', '2022-02-23 11:19:41'),
(2, 'Pauline', 'Kapoli', 2, 'pauline@gmail.com', '0993979171', 'Lilongwe', 'Ketie', '$2y$10$Xx97hDfphTsKSYSf4.R8fueiBlnvjEp1defmoEFp3eHYMCbogTdSe', NULL, NULL, 2, '2022-02-16 23:32:02', NULL);
COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `national_id` varchar(150) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(50) NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1 = Male, 2 = Female, 3 = Others',
  `password` varchar(250) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(20) NOT NULL,
  `room_type` tinyint(1) DEFAULT 2 COMMENT '1 = Superior, 2 = Standard, 3 = Twin Bed, 4 = Single Bed',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Available, 2 = Unavailable',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `staff_id` int(11) NOT NULL,
  PRIMARY KEY (`room_id`),
  KEY `room_type` (`room_type`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

INSERT INTO `room` (`room_name`, `room_type`, `staff_id`)
VALUES  ('Mazembe1', 1, 1),
        ('Mazembe2', 2, 1),
        ('Mazembe3', 2, 1),
        ('Mazembe4', 3, 1),
        ('Mazembe5', 3, 1),
        ('Mazembe6', 4, 1),
        --
        ('Nsipe1', 1, 1),
        ('Nsipe2', 2, 1),
        ('Nsipe3', 2, 1),
        ('Nsipe4', 3, 1),
        ('Nsipe5', 3, 1),
        ('Nsipe6', 4, 1),
        --
        ('Ngoni1', 1, 1),
        ('Ngoni2', 2, 1),
        ('Ngoni3', 2, 1),
        ('Ngoni4', 3, 1),
        ('Ngoni5', 3, 1),
        ('Ngoni6', 4, 1),
        --
        ('Mdeka1', 1, 1),
        ('Mdeka2', 2, 1),
        ('Mdeka3', 2, 1),
        ('Mdeka4', 3, 1),
        ('Mdeka5', 3, 1),
        ('Mdeka6', 4, 1);
        COMMIT;

--
-- Table structure for table `roomtype`
--

DROP TABLE IF EXISTS `roomtype`;
CREATE TABLE IF NOT EXISTS `roomtype` (
  `room_type` tinyint(1) NOT NULL COMMENT '1 = Superior, 2 = Standard, 3 = Twin Bed, 4 = Single Bed',
  `description` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `upload_path` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`room_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`room_type`, `description`, `price`, `upload_path`, `date_created`, `date_updated`) VALUES
(1, 'King Size Bed with AC', 100000, NULL, '2022-02-16 23:29:43', NULL),
(2, '3 quarter Bed with self contained', 60000, NULL, '2022-02-16 23:29:43', NULL),
(3, 'Double Bed', 30000, NULL, '2022-02-16 23:29:43', NULL),
(4, 'Single Bed', 20000, NULL, '2022-02-16 23:29:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `date_in` datetime NOT NULL,
  `date_out` datetime NOT NULL,
  `total_amount` float NOT NULL,
  `paid_amount` float NULL,
  `adult_number` int(1) NULL,
  `kids_number` int(1) NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Checkouts, 1 = Checkins, 2 = Booking, 3 = Cancelled',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`booking_id`),
  KEY `customer_id` (`customer_id`),
  KEY `room_id` (`room_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roomtype`
--

-- --------------------------------------------------------



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
