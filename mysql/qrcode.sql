-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: houtelechf0.mysql.db
-- Generation Time: Nov 26, 2014 at 12:40 AM
-- Server version: 5.1.73-2+squeeze+build1+1-log
-- PHP Version: 5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `houtelechf0`
--

-- --------------------------------------------------------

--
-- Table structure for table `gpslocations`
--

CREATE TABLE IF NOT EXISTS `gpslocations` (
  `GPSLocationID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Latitude` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `Longitude` decimal(10,6) NOT NULL DEFAULT '0.000000',
  `phoneNumber` varchar(50) NOT NULL DEFAULT '',
  `sessionID` varchar(50) NOT NULL DEFAULT '',
  `speed` int(10) unsigned NOT NULL DEFAULT '0',
  `direction` int(10) unsigned NOT NULL DEFAULT '0',
  `distance` decimal(10,1) NOT NULL DEFAULT '0.0',
  `gpsTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LocationMethod` varchar(50) NOT NULL DEFAULT '',
  `accuracy` int(10) unsigned NOT NULL DEFAULT '0',
  `extraInfo` varchar(255) NOT NULL DEFAULT '',
  `eventType` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`GPSLocationID`),
  KEY `sessionIDIndex` (`sessionID`),
  KEY `phoneNumberIndex` (`phoneNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9018 ;

--
-- Dumping data for table `gpslocations`
--

INSERT INTO `gpslocations` (`GPSLocationID`, `LastUpdate`, `Latitude`, `Longitude`, `phoneNumber`, `sessionID`, `speed`, `direction`, `distance`, `gpsTime`, `LocationMethod`, `accuracy`, `extraInfo`, `eventType`) VALUES
(1187, '2014-08-05 17:47:58', '35.751303', '5.839405', 'younes', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '0.0', '2014-08-05 22:47:58', 'fused', 36, '0.0', 'android'),
(1188, '2014-08-05 17:48:19', '35.751275', '-5.839347', 'saad', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 99, '0.0', '2014-08-05 22:48:19', 'fused', 27, '0.0', 'android'),
(1189, '2014-08-05 19:19:24', '15.750318', '5.838489', 'sara', '1073d9bb-f309-4ddd-bde8-e6c586192777', 2, 155, '0.1', '2014-08-06 00:19:22', 'fused', 5, '92.0', 'android'),
(1190, '2014-08-05 19:20:07', '35.750033', '5.837737', 'younes', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '0.2', '2014-08-06 00:20:04', 'fused', 38, '0.0', 'android'),
(1191, '2014-08-05 19:23:49', '15.750311', '-5.835198', 'younes', '1073d9bb-f309-4ddd-bde8-e6c586192777', 2, 55, '0.3', '2014-08-06 00:23:47', 'fused', 18, '141.0', 'android'),
(1192, '2014-08-05 19:25:51', '5.751766', '-5.834201', 'test', '1073d9bb-f309-4ddd-bde8-e6c586192777', 1, 67, '0.4', '2014-08-06 00:25:50', 'fused', 11, '124.0', 'android'),
(1193, '2014-08-05 19:27:15', '25.752581', '-5.833968', 'saad', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '0.5', '2014-08-06 00:27:14', 'fused', 68, '0.0', 'android'),
(1194, '2014-08-05 19:28:35', '15.751724', '5.834396', 'test', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '0.6', '2014-08-06 00:28:32', 'fused', 14, '101.0', 'android'),
(1195, '2014-08-05 19:30:12', '35.752250', '5.833657', 'test', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '0.6', '2014-08-06 00:30:04', 'fused', 41, '0.0', 'android'),
(1196, '2014-08-05 19:32:10', '11.751724', '-5.834348', 'younes', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 214, '0.7', '2014-08-06 00:32:06', 'fused', 6, '102.0', 'android'),
(1197, '2014-08-05 19:33:41', '8.749240', '-5.839108', 'sara', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '1.0', '2014-08-06 00:33:39', 'fused', 25, '0.0', 'android'),
(1198, '2014-08-05 19:40:08', '3.751278', '-5.839430', 'younes', '1073d9bb-f309-4ddd-bde8-e6c586192777', 0, 0, '1.2', '2014-08-06 00:40:04', 'fused', 41, '0.0', 'android');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
