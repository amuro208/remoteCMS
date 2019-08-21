-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2015 at 09:27 PM
-- Server version: 5.6.23
-- PHP Version: 5.5.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tcscms`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `firstName` varchar(64) DEFAULT NULL,
  `lastName` varchar(64) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `approval` char(1) DEFAULT 'N',
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `email`, `firstName`, `lastName`, `password`, `approval`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(1, 'admin@thecreativeshop.com.au', 'Admin', 'TCS', 'f26cea7ff09c4e1e6b094844ed4d1c8d', 'Y', '2015-06-04 04:02:59', NULL, '2015-06-05 07:06:34', 1, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `accountrole`
--

CREATE TABLE IF NOT EXISTS `accountrole` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accountrole`
--

INSERT INTO `accountrole` (`id`, `aid`, `roleId`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `activitylog`
--

CREATE TABLE IF NOT EXISTS `activitylog` (
  `id` int(11) NOT NULL,
  `emailLogId` int(11) NOT NULL,
  `activityType` varchar(10) NOT NULL,
  `platform` varchar(45) DEFAULT NULL,
  `browser` varchar(45) DEFAULT NULL,
  `version` varchar(45) DEFAULT NULL,
  `referer` varchar(64) DEFAULT NULL,
  `clicked` int(11) NOT NULL DEFAULT '0',
  `downloaded` int(11) NOT NULL DEFAULT '0',
  `shared1` int(11) NOT NULL DEFAULT '0',
  `shared2` int(11) NOT NULL,
  `shared3` int(11) NOT NULL DEFAULT '0',
  `reserve1` varchar(64) DEFAULT NULL,
  `reserve2` varchar(64) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `code`
--

CREATE TABLE IF NOT EXISTS `code` (
  `id` int(11) NOT NULL,
  `category` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `note` varchar(45) DEFAULT NULL,
  `reserve1` varchar(64) DEFAULT NULL,
  `reserve2` varchar(64) DEFAULT NULL,
  `reserve3` varchar(64) DEFAULT NULL,
  `reserve4` varchar(64) DEFAULT NULL,
  `reserve5` varchar(64) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `code`
--

INSERT INTO `code` (`id`, `category`, `code`, `name`, `note`, `reserve1`, `reserve2`, `reserve3`, `reserve4`, `reserve5`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(3, 'SITE', '1', 'Site1', NULL, 'Y', NULL, NULL, NULL, NULL, '2015-06-07 04:30:39', 1, '2015-06-13 23:21:29', 1, 'Y'),
(4, 'SITE', '2', 'Site2', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:30:51', 1, NULL, NULL, 'Y'),
(5, 'SITE', '3', 'Site3', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:31:12', 1, NULL, NULL, 'Y'),
(6, 'SITE', '4', 'Site4', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:31:24', 1, NULL, NULL, 'Y'),
(7, 'SITE', '5', 'Site5', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:31:35', 1, NULL, NULL, 'Y'),
(8, 'EVENT', 'PP', 'Pepper Photo', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:32:28', 1, '2015-12-11 00:34:59', 1, 'Y'),
(9, 'EVENT', 'QS', 'Cover The Court', NULL, '', NULL, NULL, NULL, NULL, '2015-06-07 04:32:45', 1, '2015-07-02 01:24:54', 1, 'Y'),
(10, 'EVENT', 'MVP', 'Fans MVP', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:33:08', 1, '2015-07-03 00:57:10', 1, 'Y'),
(11, 'EVENT', 'VV', 'Pepper Video', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:33:26', 1, '2015-12-11 00:34:45', 1, 'Y'),
(12, 'EVENT', 'SR', 'Cheer Cam', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:33:51', 1, '2015-07-03 00:56:56', 1, 'Y'),
(13, 'TEAM', 'AUS', 'AUS', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:34:55', 1, NULL, NULL, 'Y'),
(14, 'TEAM', 'NZL', 'NZL', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:35:17', 1, NULL, NULL, 'Y'),
(15, 'TEAM', 'ENG', 'ENG', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:35:34', 1, NULL, NULL, 'Y'),
(16, 'TEAM', 'JAM', 'JAM', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:35:58', 1, NULL, NULL, 'Y'),
(17, 'TEAM', 'MAW', 'MAW', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:36:14', 1, NULL, NULL, 'Y'),
(18, 'TEAM', 'RSA', 'RSA', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:36:28', 1, NULL, NULL, 'Y'),
(19, 'TEAM', 'FIJ', 'FIJ', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:36:44', 1, NULL, NULL, 'Y'),
(20, 'TEAM', 'WAL', 'WAL', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:36:58', 1, NULL, NULL, 'Y'),
(21, 'TEAM', 'TTO', 'TTO', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:37:24', 1, NULL, NULL, 'Y'),
(22, 'TEAM', 'BAR', 'BAR', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:37:36', 1, NULL, NULL, 'Y'),
(23, 'TEAM', 'SCO', 'SCO', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:37:53', 1, NULL, NULL, 'Y'),
(24, 'TEAM', 'SAM', 'SAM', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:38:14', 1, NULL, NULL, 'Y'),
(25, 'TEAM', 'UGA', 'UGA', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:38:30', 1, NULL, NULL, 'Y'),
(26, 'TEAM', 'SIN', 'SIN', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:38:41', 1, NULL, NULL, 'Y'),
(27, 'TEAM', 'ZAM', 'ZAM', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:38:55', 1, NULL, NULL, 'Y'),
(28, 'TEAM', 'SRI', 'SRI', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-07 04:39:06', 1, NULL, NULL, 'Y'),
(29, 'EVENT', 'TP', 'Team Photo', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-15 08:05:21', 1, '2015-06-29 01:13:50', 1, 'N'),
(30, 'EVENT', 'VK', 'Virtual Kick', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-15 08:05:32', 1, NULL, NULL, 'Y'),
(31, 'EVENT', 'SR', 'Score&Roar', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-15 08:05:46', 1, '2015-06-29 01:13:46', 1, 'N'),
(32, 'EVENT', 'FP', 'Face Painting', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-15 08:05:55', 1, '2015-06-29 01:14:02', 1, 'N'),
(33, 'EVENT', 'FT', 'Foosball Table', NULL, NULL, NULL, NULL, NULL, NULL, '2015-06-15 08:06:05', 1, '2015-06-29 01:13:59', 1, 'N'),
(34, 'EVENT', 'FC', 'Fancam', NULL, NULL, NULL, NULL, NULL, NULL, '2015-08-17 05:17:39', 1, NULL, NULL, 'Y'),
(35, 'EVENT', 'NRL', 'NRL Final Series', NULL, NULL, NULL, NULL, NULL, NULL, '2015-08-30 23:55:07', 1, NULL, NULL, 'Y'),
(36, 'EVENT', 'PD', 'Photo Direct Upload', NULL, NULL, NULL, NULL, NULL, NULL, '2015-12-18 04:13:03', 1, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `emaillog`
--

CREATE TABLE IF NOT EXISTS `emaillog` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `accessCode` varchar(128) DEFAULT NULL,
  `shareAccessCode` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `isValidEmail` char(1) NOT NULL DEFAULT 'N',
  `isSent` char(1) DEFAULT 'N',
  `sentDate` timestamp NULL DEFAULT NULL,
  `isOpened` char(1) DEFAULT 'N',
  `shortUrl` varchar(256) DEFAULT NULL,
  `openedDate` timestamp NULL DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL,
  `eventCode` varchar(10) DEFAULT NULL,
  `siteCode` varchar(10) DEFAULT NULL,
  `startDate` varchar(19) DEFAULT NULL,
  `endDate` varchar(19) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `eventCode`, `siteCode`, `startDate`, `endDate`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(4, 'VK', '1', '2015-06-01 00:00:00', '2015-07-31 00:00:00', '2015-06-19 04:37:07', 1, '2015-07-02 01:26:40', 1, 'Y'),
(6, 'PP', '1', '2015-07-01 00:00:00', '2015-08-31 00:00:00', '2015-07-02 01:27:12', 1, NULL, NULL, 'Y'),
(7, 'QS', '1', '2015-07-01 00:00:00', '2015-08-31 00:00:00', '2015-07-02 01:27:39', 1, '2015-07-02 01:28:55', 1, 'Y'),
(8, 'MVP', '1', '2015-07-01 00:00:00', '2015-08-31 00:00:00', '2015-07-02 01:27:49', 1, '2015-07-02 01:29:03', 1, 'Y'),
(9, 'LK', '1', '2015-07-01 00:00:00', '2015-08-31 00:00:00', '2015-07-02 01:28:00', 1, '2015-07-02 01:29:10', 1, 'Y'),
(10, 'SR', '1', '2015-07-01 00:00:00', '2015-08-31 00:00:00', '2015-07-02 01:28:12', 1, '2015-07-02 01:29:17', 1, 'Y'),
(11, 'FC', '1', '2015-01-01 00:00:00', '2016-01-01 00:00:00', '2015-08-17 05:18:10', 1, NULL, NULL, 'Y'),
(12, 'NRL', '1', '2015-08-01', '2015-12-31', '2015-08-30 23:55:37', 1, NULL, NULL, 'Y'),
(13, 'PD', '1', '2015-12-01 00:00:00', '2016-12-31 00:00:00', '2015-12-18 04:14:43', 1, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `localmedia`
--

CREATE TABLE IF NOT EXISTS `localmedia` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `typeCode` varchar(20) DEFAULT NULL,
  `filePath` varchar(128) DEFAULT NULL,
  `fileName` varchar(128) DEFAULT NULL,
  `thumbFilePath` varchar(128) DEFAULT NULL,
  `Mimetype` varchar(64) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `localrfidscan`
--

CREATE TABLE IF NOT EXISTS `localrfidscan` (
  `id` int(11) NOT NULL,
  `rfid` varchar(64) DEFAULT NULL,
  `localUserId` int(11) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `localuser`
--

CREATE TABLE IF NOT EXISTS `localuser` (
  `id` int(11) NOT NULL,
  `siteCode` varchar(10) DEFAULT NULL,
  `eventCode` varchar(10) DEFAULT NULL,
  `firstName` varchar(64) DEFAULT NULL,
  `lastName` varchar(64) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `gameCode` varchar(10) DEFAULT NULL,
  `teamCode` varchar(10) DEFAULT NULL,
  `teamPlayerCode` varchar(10) DEFAULT NULL,
  `isRemoteSynced` char(1) DEFAULT 'N',
  `reserve1` varchar(64) DEFAULT NULL,
  `reserve2` varchar(64) DEFAULT NULL,
  `reserve3` varchar(64) DEFAULT NULL,
  `reserve4` varchar(64) DEFAULT NULL,
  `reserve5` varchar(64) DEFAULT NULL,
  `videoId` varchar(64) DEFAULT NULL,
  `photoId` varchar(64) DEFAULT NULL,
  `isApproved` char(1) DEFAULT NULL,
  `approvedDate` timestamp NULL DEFAULT NULL,
  `approvedUser` int(11) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `typeCode` varchar(20) DEFAULT NULL,
  `filePath` varchar(128) DEFAULT NULL,
  `fileName` varchar(128) DEFAULT NULL,
  `thumbFilePath` varchar(128) DEFAULT NULL,
  `Mimetype` varchar(64) DEFAULT NULL,
  `shortUrl` varchar(128) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `menuorder` int(11) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `pid`, `name`, `url`, `menuorder`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(1, NULL, 'System', '/system', 1, NULL, NULL, NULL, NULL, 'Y'),
(2, 1, 'Code', '/system/code', 1, NULL, NULL, NULL, NULL, 'Y'),
(3, 1, 'Role', '/system/role', 2, NULL, NULL, NULL, NULL, 'Y'),
(4, 1, 'System User', '/system/user', 4, NULL, NULL, '2015-06-04 22:53:23', 1, 'Y'),
(5, 1, 'Menu', '/system/menu', 3, NULL, NULL, NULL, NULL, 'Y'),
(8, NULL, 'Total Event', '/user/total', 3, '2015-06-04 06:55:30', 1, '2015-06-17 03:19:23', 1, 'Y'),
(9, NULL, 'Perfect Passing', '/user/pp', 4, '2015-06-04 06:56:18', 1, '2015-06-17 03:19:33', 1, 'Y'),
(10, NULL, 'Cover The Court', '/user/qs', 4, '2015-06-04 06:56:30', 1, '2015-07-01 03:17:51', 1, 'Y'),
(11, NULL, 'MVP', '/user/mvp', 5, '2015-06-04 06:57:03', 1, '2015-06-05 05:54:33', 1, 'Y'),
(12, NULL, 'Lypsync Karaoke', '/user/lk', 6, '2015-06-04 06:57:23', 1, '2015-06-26 05:46:38', 1, 'Y'),
(13, NULL, 'Score&Roar', '/user/sr', 7, '2015-06-04 06:57:36', 1, '2015-07-01 03:17:15', 1, 'Y'),
(14, 1, 'System Option', '/system/systemoption', 8, '2015-06-04 22:52:41', 1, '2015-06-04 23:10:57', 1, 'Y'),
(15, 1, 'Event', '/system/event', 8, '2015-06-05 04:06:58', 1, NULL, NULL, 'Y'),
(16, NULL, 'Team Photo', '/user/tp', 10, '2015-06-15 07:27:19', 1, NULL, NULL, 'Y'),
(17, NULL, 'Virtual Kick', '/user/vk', 11, '2015-06-15 07:28:05', 1, NULL, NULL, 'Y'),
(18, NULL, 'Face Painting', '/user/fp', 12, '2015-06-15 07:28:32', 1, NULL, NULL, 'Y'),
(19, NULL, 'Foosball Table', '/user/ft', 13, '2015-06-15 07:28:48', 1, NULL, NULL, 'Y'),
(20, NULL, 'Local Maderation', '/localmaderation', 2, '2015-06-17 03:17:57', 1, '2015-06-17 03:18:23', 1, 'Y'),
(21, NULL, 'Maderation', '/maderation', 3, '2015-06-17 03:18:43', 1, NULL, NULL, 'Y'),
(22, NULL, 'Statistics', '/statistic', 2, '2015-06-18 07:09:38', 1, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `menurole`
--

CREATE TABLE IF NOT EXISTS `menurole` (
  `id` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `menuId` int(11) NOT NULL,
  `accessable` char(1) DEFAULT 'N',
  `readable` char(1) DEFAULT 'N',
  `writable` char(1) DEFAULT 'N',
  `confirmable` char(1) DEFAULT 'N',
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menurole`
--

INSERT INTO `menurole` (`id`, `roleId`, `menuId`, `accessable`, `readable`, `writable`, `confirmable`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(1, 1, 1, 'Y', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, 'Y'),
(2, 1, 2, 'Y', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, 'Y'),
(3, 1, 3, 'Y', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, 'Y'),
(4, 1, 4, 'Y', 'Y', 'Y', 'Y', NULL, NULL, NULL, NULL, 'Y'),
(5, 1, 5, 'Y', 'Y', 'Y', 'Y', NULL, NULL, '2015-06-04 04:52:55', 1, 'Y'),
(6, 1, 8, 'N', 'Y', 'Y', 'Y', '2015-06-04 06:58:08', 1, '2015-06-15 07:37:35', 1, 'Y'),
(7, 1, 9, 'N', 'Y', 'Y', 'Y', '2015-06-04 06:58:11', 1, '2015-06-29 01:18:10', 1, 'Y'),
(8, 1, 10, 'N', 'Y', 'Y', 'Y', '2015-06-04 06:58:13', 1, '2015-06-29 01:18:09', 1, 'Y'),
(9, 1, 11, 'N', 'Y', 'Y', 'Y', '2015-06-04 06:58:15', 1, '2015-06-29 01:18:08', 1, 'Y'),
(10, 1, 12, 'N', 'Y', 'Y', 'Y', '2015-06-04 06:58:17', 1, '2015-06-29 01:18:07', 1, 'Y'),
(11, 1, 13, 'N', 'Y', 'Y', 'Y', '2015-06-04 06:58:19', 1, '2015-06-16 01:25:09', 1, 'Y'),
(12, 1, 14, 'N', 'Y', 'Y', 'Y', '2015-06-04 22:55:43', 1, '2015-06-04 22:55:47', 1, 'Y'),
(13, 1, 15, 'N', 'Y', 'Y', 'Y', '2015-06-05 04:09:33', 1, '2015-06-05 04:09:39', 1, 'Y'),
(14, 1, 16, 'N', 'N', 'N', 'N', '2015-06-15 07:29:11', 1, '2015-06-29 01:18:04', 1, 'Y'),
(15, 1, 17, 'N', 'N', 'N', 'N', '2015-06-15 07:29:12', 1, '2015-07-23 23:58:30', 1, 'Y'),
(16, 1, 18, 'N', 'N', 'N', 'N', '2015-06-15 07:29:13', 1, '2015-06-29 01:18:05', 1, 'Y'),
(17, 1, 19, 'N', 'N', 'N', 'N', '2015-06-15 07:29:14', 1, '2015-06-29 01:18:06', 1, 'Y'),
(18, 1, 21, 'N', 'Y', 'Y', 'Y', '2015-06-17 05:51:35', 1, '2015-06-17 05:51:38', 1, 'Y'),
(19, 1, 22, 'N', 'Y', 'N', 'N', '2015-06-18 07:10:00', 1, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `rfid`
--

CREATE TABLE IF NOT EXISTS `rfid` (
  `id` int(11) NOT NULL,
  `firstName` varchar(64) DEFAULT NULL,
  `lastName` varchar(64) DEFAULT NULL,
  `BOD` varchar(10) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `rfid` varchar(64) DEFAULT NULL,
  `fbUserId` varchar(64) DEFAULT NULL,
  `accessCode` varchar(128) DEFAULT NULL,
  `reserve1` varchar(64) DEFAULT NULL,
  `reserve2` varchar(64) DEFAULT NULL,
  `reserve3` varchar(64) DEFAULT NULL,
  `reserve4` varchar(64) DEFAULT NULL,
  `reserve5` varchar(64) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rfidscan`
--

CREATE TABLE IF NOT EXISTS `rfidscan` (
  `id` int(11) NOT NULL,
  `rfidId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `mediaId` int(11) NOT NULL,
  `RFID` varchar(64) DEFAULT NULL,
  `fbId` varchar(64) DEFAULT NULL,
  `fbUrl` varchar(128) DEFAULT NULL,
  `fbShortUrl` varchar(128) DEFAULT NULL,
  `isSent` char(1) DEFAULT 'N',
  `sentDate` varchar(10) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `note` varchar(128) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `note`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(1, 'Admin', 'Admin''s Role', NULL, NULL, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `sendsns`
--

CREATE TABLE IF NOT EXISTS `sendsns` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `snsTypeCode` varchar(10) DEFAULT NULL,
  `snsId` varchar(128) DEFAULT NULL,
  `snsUrl` varchar(128) DEFAULT NULL,
  `snsShortUrl` varchar(128) DEFAULT NULL,
  `isSent` char(1) DEFAULT 'N',
  `sentDate` timestamp NULL DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `systemoption`
--

CREATE TABLE IF NOT EXISTS `systemoption` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `value` varchar(512) DEFAULT NULL,
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `systemoption`
--

INSERT INTO `systemoption` (`id`, `name`, `value`, `createDate`, `createUser`, `updateDate`, `updateUser`, `valid`) VALUES
(2, 'is_local_server', 'Y', '2015-06-04 23:15:45', 1, '2015-08-19 07:37:37', 1, 'Y'),
(3, 'agent_url', 'http://203.191.181.166:8082/wordpress/cmd/agent/', '2015-06-04 23:17:03', 1, NULL, NULL, 'Y'),
(4, 'kiosk_code', 'f1_1', '2015-06-04 23:18:01', 1, '2015-12-18 03:59:32', 1, 'Y'),
(5, 'ping', 'Y', '2015-06-04 23:18:22', 1, NULL, NULL, 'Y'),
(6, 'remote_sync', 'Y', '2015-06-04 23:18:37', 1, NULL, NULL, 'Y'),
(7, 'reverse_sync', 'N', '2015-06-04 23:18:56', 1, NULL, NULL, 'Y'),
(8, 'sync_path', 'N', '2015-06-04 23:19:16', 1, '2015-06-11 01:18:56', 1, 'Y'),
(9, 'daily_backup', 'Y', '2015-06-04 23:19:35', 1, '2015-06-10 06:42:16', 1, 'Y'),
(10, 'daily_backup_path', '.', '2015-06-04 23:19:51', 1, NULL, NULL, 'Y'),
(11, 'git_pull', 'N', '2015-06-04 23:20:08', 1, NULL, NULL, 'Y'),
(12, 'git_command', 'git pull origin master', '2015-06-04 23:20:25', 1, NULL, NULL, 'Y'),
(13, 'ftp_server', '103.18.109.66', '2015-06-04 23:20:59', 1, '2015-09-09 01:27:31', 1, 'Y'),
(14, 'ftp_user', 'ftpuser@pepperfanzone.com.au', '2015-06-04 23:21:11', 1, '2015-12-18 00:43:54', 1, 'Y'),
(15, 'ftp_password', 'Ev0lUt10N', '2015-06-04 23:21:24', 1, '2015-07-24 01:12:16', 1, 'Y'),
(17, 'upload_url', 'http://www.f1forreal.com.au/framework/index.php/remote', '2015-06-04 23:22:22', 1, '2015-08-17 01:37:27', 1, 'Y'),
(18, 'post_url', 'http://www.f1forreal.com.au/framework/index.php/remote', '2015-06-04 23:22:39', 1, '2015-08-17 01:37:38', 1, 'Y'),
(19, 'get_url', 'http://www.f1forreal.com.au/framework/index.php/remote', '2015-06-04 23:22:48', 1, '2015-08-17 01:37:48', 1, 'Y'),
(20, 'list_url', '.', '2015-06-04 23:23:01', 1, NULL, NULL, 'Y'),
(21, 'sendmail_url', '.', '2015-06-04 23:23:11', 1, NULL, NULL, 'Y'),
(22, 'server_port', '80', '2015-06-04 23:36:23', 1, NULL, NULL, 'Y'),
(25, 'PP_root_path', 'C:\\Pepper\\Photo\\', '2015-06-09 06:48:25', 1, '2015-12-17 22:51:11', 1, 'Y'),
(26, 'PP_file_ext', '.png|.gif|.jpg', '2015-06-09 06:49:48', 1, '2015-06-09 06:55:30', 1, 'Y'),
(27, 'QS_file_upload_count', '1', '2015-06-09 07:00:18', 1, '2015-06-26 07:15:57', 1, 'Y'),
(28, 'QS_root_path', 'C:\\NBW\\CoverTheCourt\\', '2015-06-09 07:00:49', 1, '2015-07-01 02:58:15', 1, 'Y'),
(29, 'QS_file_ext', '.png|.gif|.jpg', '2015-06-09 07:01:24', 1, '2015-06-09 07:03:25', 1, 'Y'),
(33, 'begin_remotesync', '0', '2015-06-09 23:51:23', 1, NULL, NULL, 'Y'),
(34, 'begin_remotesync_time', '', '2015-06-09 23:51:36', 1, NULL, NULL, 'Y'),
(35, 'sync_server_url', 'http://localhost/codeigniter/index.php/system/', '2015-06-11 01:40:07', 1, NULL, NULL, 'Y'),
(36, 'PP_auto_approval', 'Y', '2015-06-15 04:42:41', 1, '2015-06-26 07:23:46', 1, 'Y'),
(43, 'VK_uploadmethod', 'post', '2015-06-15 08:00:03', 1, NULL, NULL, 'Y'),
(44, 'VK_root_path', 'C:\\NBW\\LiverPoolVirtualKick\\', '2015-06-15 08:00:18', 1, '2015-07-01 03:02:51', 1, 'Y'),
(45, 'VK_remotesync', 'Y', '2015-06-15 08:00:33', 1, NULL, NULL, 'Y'),
(46, 'VK_file_ext', '.png|.gif|.jpg', '2015-06-15 08:00:48', 1, NULL, NULL, 'Y'),
(54, 'default_event_code', 'SR', '2015-06-16 04:18:27', 1, '2015-06-29 04:31:04', 1, 'Y'),
(55, 'default_site_code', 'B1', '2015-06-16 04:18:35', 1, '2015-12-16 00:11:24', 1, 'Y'),
(56, 'VK_file_upload_count', '2', '2015-06-16 04:56:41', 1, NULL, NULL, 'Y'),
(57, 'VK_must_field', 'eventCode,userFirstName,userLastName,userEmail,photoId', '2015-06-16 05:14:19', 1, '2015-06-29 03:58:21', 1, 'Y'),
(62, 'SR_root_path', 'C:\\NBW\\FanCam\\', '2015-06-16 05:45:02', 1, '2015-07-01 02:57:03', 1, 'Y'),
(63, 'SR_file_ext', '.mp4', '2015-06-16 05:45:21', 1, NULL, NULL, 'Y'),
(64, 'SR_uploadmethod', 'ftp', '2015-06-16 05:45:33', 1, NULL, NULL, 'Y'),
(65, 'SR_remotesync', 'Y', '2015-06-16 05:45:44', 1, NULL, NULL, 'Y'),
(66, 'SR_must_field', 'eventCode,userFirstName,userLastName,userEmail,videoId,FileData00,choosenYear', '2015-06-16 05:46:02', 1, '2015-07-29 07:52:46', 1, 'Y'),
(73, 'max_maderated_id', '478', '2015-06-17 03:50:51', 1, '2015-06-17 05:37:30', 1, 'Y'),
(75, 'VK_auto_approval', 'Y', '2015-06-17 05:29:19', 1, '2015-06-17 06:03:03', 1, 'Y'),
(76, 'max_local_maderated_id', '29', NULL, NULL, '2015-08-17 05:27:53', 1, 'Y'),
(77, 'cms_home_url', 'http://192.168.204.147/codeigniter/index.php/', '2015-06-18 03:57:48', 1, '2015-06-22 04:49:24', 1, 'Y'),
(78, 'home_url', 'http://192.168.204.147/index.php', '2015-06-18 04:03:04', 1, '2015-07-02 05:25:47', 1, 'Y'),
(79, 'email_test_data', '이메일 테스트 데이타 입니다.', '2015-06-18 23:28:22', 1, NULL, NULL, 'Y'),
(80, 'MVP_uploadmethod', 'post', '2015-06-23 04:41:24', 1, NULL, NULL, 'Y'),
(82, 'MVP_remotesync', 'Y', '2015-06-23 04:41:57', 1, NULL, NULL, 'Y'),
(83, 'MVP_email_title', 'MVP Email Title', '2015-06-23 04:42:21', 1, NULL, NULL, 'Y'),
(87, 'MVP_file_ext', '.png|.jpg|.gif', '2015-06-23 04:54:25', 1, '2015-06-30 08:12:57', 1, 'Y'),
(88, 'QS_must_field', 'eventCode,userFirstName,userLastName,userEmail,userScore,userCountryId,photoId', '2015-06-26 07:07:31', 1, '2015-06-29 03:56:33', 1, 'Y'),
(90, 'QS_remotesync', 'Y', '2015-06-26 07:15:23', 1, NULL, NULL, 'Y'),
(91, 'QS_auto_approval', 'Y', '2015-06-26 07:15:42', 1, NULL, NULL, 'Y'),
(92, 'PP_must_field', 'eventCode,userFirstName,userLastName,userEmail,photoId', '2015-06-26 07:24:09', 1, '2015-06-29 03:56:53', 1, 'Y'),
(93, 'PP_remotesync', 'Y', '2015-06-26 07:24:27', 1, NULL, NULL, 'Y'),
(95, 'PP_uploadmethod', 'post', '2015-06-26 07:27:05', 1, NULL, NULL, 'Y'),
(96, 'PP_copy_photoId', 'Y', '2015-06-26 07:27:41', 1, NULL, NULL, 'Y'),
(97, 'QS_copy_photoId', 'Y', '2015-06-26 07:27:57', 1, NULL, NULL, 'Y'),
(98, 'QS_uploadmethod', 'post', '2015-06-26 07:29:14', 1, NULL, NULL, 'Y'),
(99, 'PP_file_upload_count', '1', '2015-06-26 07:30:19', 1, NULL, NULL, 'Y'),
(100, 'SR_auto_approval', 'Y', '2015-06-26 07:31:57', 1, NULL, NULL, 'Y'),
(101, 'SR_file_upload_count', '1', '2015-06-26 07:32:16', 1, NULL, NULL, 'Y'),
(102, 'SR_copy_videoId', 'Y', '2015-06-26 07:32:56', 1, NULL, NULL, 'Y'),
(103, 'VV_root_path', 'C:\\Pepper\\Video\\', '2015-06-29 01:15:08', 1, '2015-12-17 22:50:55', 1, 'Y'),
(104, 'VV_uploadmethod', 'ftp', '2015-06-29 01:15:32', 1, NULL, NULL, 'Y'),
(105, 'VV_remotesync', 'Y', '2015-06-29 01:15:46', 1, '2015-09-21 01:06:12', 1, 'Y'),
(106, 'VV_must_field', 'eventCode,userFirstName,userLastName,userEmail,videoId,FileData00', '2015-06-29 01:16:02', 1, '2015-12-18 00:07:02', 1, 'Y'),
(107, 'VV_file_upload_count', '1', '2015-06-29 01:16:28', 1, NULL, NULL, 'Y'),
(108, 'VV_file_ext', '.mp4', '2015-06-29 01:16:41', 1, NULL, NULL, 'Y'),
(109, 'VV_copy_videoId', 'Y', '2015-06-29 01:16:53', 1, NULL, NULL, 'Y'),
(110, 'VV_auto_approval', 'Y', '2015-06-29 01:17:05', 1, '2015-09-22 06:51:10', 1, 'Y'),
(111, 'QS_rank_query', 'SELECT @rank:=@rank+1 rank,\n         reserve3 country,\n         '''' id,\n         LTRIM(CONCAT(firstName,'' '',lastName)) name, \n         reserve2 score \n    FROM `localuser` a,(SELECT @rank:=0) b \n WHERE a.valid = ''Y'' and eventCode=''QS'' \n ORDER BY reserve2 + 0  DESC', '2015-06-29 02:04:23', 1, '2015-07-24 07:52:38', 1, 'Y'),
(112, 'SR_has_thumbnail', 'N', '2015-06-29 03:14:59', 1, '2015-07-29 07:50:08', 1, 'Y'),
(113, 'SR_thumbnail_ext', '.png|.jpg|.gif', '2015-06-29 03:15:19', 1, '2015-06-29 03:16:59', 1, 'Y'),
(114, 'VV_has_thumbnail', 'Y', '2015-06-29 03:21:25', 1, NULL, NULL, 'Y'),
(115, 'VV_thumbnail_ext', '.png|.gif|.jpg', '2015-06-29 03:22:00', 1, NULL, NULL, 'Y'),
(116, 'VV_edm_ext', '.png|.jpg|.gif', '2015-06-29 03:22:39', 1, NULL, NULL, 'Y'),
(117, 'VV_has_edm', 'N', '2015-06-29 03:22:52', 1, '2015-07-01 01:28:00', 1, 'Y'),
(118, 'MVP_must_field', 'eventCode,userFirstName,userLastName,userEmail,userSelectPlayer,userPostcode,FileData00', '2015-06-29 03:46:37', 1, '2015-12-18 03:47:33', 1, 'Y'),
(119, 'MVP_rank_query', 'SELECT @rn:=@rn+1 rank,country country,\n       pcode id,\n       '''' name,\n       cnt score \n  FROM (\n		SELECT `teamPlayerCode` pcode,\n               `teamCode` country,\n               count(*) cnt\n  		  FROM `localuser` a\n  		 WHERE eventCode = ''MVP''\n 		 GROUP BY `teamPlayerCode`\n        ) x,(SELECT @rn:=0) y\n ORDER BY cnt DESC', '2015-06-29 04:41:01', 1, '2015-06-30 23:46:34', 1, 'Y'),
(120, 'MVP_rank_limit', '5', '2015-06-30 23:47:16', 1, NULL, NULL, 'Y'),
(121, 'MVP_current_rank', 'Y', '2015-06-30 23:47:34', 1, NULL, NULL, 'Y'),
(122, 'MVP_current_rank_field', 'userSelectPlayer', '2015-06-30 23:49:36', 1, '2015-06-30 23:49:56', 1, 'Y'),
(123, 'MVP_edm_media', 'FileData00', '2015-07-01 00:54:14', 1, NULL, NULL, 'Y'),
(128, 'QS_edm_media', 'photoId', '2015-07-01 01:03:49', 1, NULL, NULL, 'Y'),
(131, 'PP_edm_media', 'photoId', '2015-07-01 01:06:24', 1, '2015-07-01 01:07:08', 1, 'Y'),
(133, 'SR_has_edm', 'N', '2015-07-01 01:08:48', 1, '2015-07-01 01:24:55', 1, 'Y'),
(136, 'SR_edm_media', 'FileData00', '2015-07-01 01:10:02', 1, '2015-07-01 01:27:11', 1, 'Y'),
(138, 'SR_edm_ext', '.png|.gif|.jpg', '2015-07-01 01:12:22', 1, NULL, NULL, 'Y'),
(141, 'VV_edm_media', 'FileData00', '2015-07-01 01:27:24', 1, NULL, NULL, 'Y'),
(143, 'PP_email_template', 'netball_email', '2015-07-23 23:52:27', 1, NULL, NULL, 'Y'),
(144, 'PP_email_title', 'Perfect Pass!', '2015-07-23 23:52:58', 1, NULL, NULL, 'Y'),
(145, 'QS_email_template', 'netball_email', '2015-07-23 23:53:45', 1, NULL, NULL, 'Y'),
(146, 'QS_email_title', 'Cover The Court!', '2015-07-23 23:54:02', 1, NULL, NULL, 'Y'),
(147, 'MVP_email_template', 'netball_email', '2015-07-23 23:54:31', 1, NULL, NULL, 'Y'),
(148, 'MVP_email_title', 'MVP!', '2015-07-23 23:54:48', 1, NULL, NULL, 'Y'),
(149, 'VV_email_template', 'netball_email', '2015-07-23 23:55:46', 1, NULL, NULL, 'Y'),
(150, 'VV_email_title', 'Lipsync!', '2015-07-23 23:56:02', 1, NULL, NULL, 'Y'),
(151, 'SR_email_template', 'netball_email', '2015-07-23 23:57:54', 1, NULL, NULL, 'Y'),
(152, 'SR_email_title', 'Fan Cam!', '2015-07-23 23:58:10', 1, NULL, NULL, 'Y'),
(153, 'VV_late_upload', 'Y', '2015-07-28 06:37:39', 1, NULL, NULL, 'Y'),
(154, 'FC_must_field', 'eventCode,videoId', '2015-08-17 05:20:46', 1, NULL, NULL, 'Y'),
(155, 'FC_remotesync', 'Y', '2015-08-17 05:21:03', 1, '2015-08-17 05:21:09', 1, 'Y'),
(156, 'FC_late_upload', 'N', '2015-08-17 05:21:38', 1, '2015-08-17 05:22:44', 1, 'Y'),
(157, 'FC_has_thumbnail', 'N', '2015-08-17 05:21:52', 1, NULL, NULL, 'Y'),
(158, 'FC_auto_approval', 'N', '2015-08-17 05:22:33', 1, NULL, NULL, 'Y'),
(159, 'FC_copy_videoId', 'Y', '2015-08-17 05:23:02', 1, NULL, NULL, 'Y'),
(160, 'FC_file_ext', '.mp4', '2015-08-17 05:23:36', 1, NULL, NULL, 'Y'),
(161, 'FC_file_upload_count', '1', '2015-08-17 05:23:48', 1, NULL, NULL, 'Y'),
(162, 'FC_root_path', 'C:\\NBW\\LipsyncKaraoke\\', '2015-08-17 05:24:38', 1, '2015-08-17 05:25:06', 1, 'Y'),
(163, 'FC_uploadmethod', 'post', '2015-08-17 05:24:48', 1, '2015-08-31 04:52:09', 1, 'Y'),
(164, 'cms_name', 'TCS Local CMS', '2015-08-17 23:20:45', 1, '2015-08-19 07:36:02', 1, 'Y'),
(165, 'cms_version', '?v=1_1_105', '2015-08-17 23:21:10', 1, '2015-08-19 04:41:02', 1, 'Y'),
(177, 'NRL_remotesync', 'N', '2015-08-30 23:57:53', 1, NULL, NULL, 'Y'),
(178, 'NRL_auto_approval', 'N', '2015-08-30 23:58:21', 1, NULL, NULL, 'Y'),
(179, 'NRL_must_field', 'eventCode,userFirstName,userLastName,userEmail,userPostcode,userSelectTeam,userScore,userAgreeTNC', '2015-08-30 23:58:48', 1, '2015-08-31 00:11:47', 1, 'Y'),
(180, 'lateupload_delayseconds', '30', '2015-09-01 07:16:18', 1, '2015-09-22 06:03:46', 1, 'Y'),
(181, 'ftp_root_url', 'http://www.pepperfanzone.com.au/framework/uploads/', '2015-09-09 03:42:22', 1, '2015-12-18 00:44:11', 1, 'Y'),
(184, 'test_test_test1', 'N', NULL, NULL, NULL, NULL, 'Y'),
(185, 'test_test_test2', 'N', NULL, NULL, NULL, NULL, 'Y'),
(186, 'test_test_test3', 'N', NULL, NULL, NULL, NULL, 'Y'),
(187, 'MVP_reserve_field', 'userAgreeTNC,userEDMTNC', '2015-12-07 05:21:58', 1, '2015-12-18 03:55:07', 1, 'N'),
(188, 'MVP_make_localthumbnail', 'Y', '2015-12-07 22:33:59', 1, NULL, NULL, 'Y'),
(189, 'PD_edm_media', 'FileData00', '2015-12-18 04:04:27', 1, '2015-12-18 04:05:17', 1, 'Y'),
(190, 'PD_email_template', 'f1_email', '2015-12-18 04:04:49', 1, '2015-12-18 04:05:28', 1, 'Y'),
(191, 'PD_email_title', 'MVP Email Title', '2015-12-18 04:05:51', 1, NULL, NULL, 'Y'),
(192, 'PD_email_title', 'PD!', '2015-12-18 04:06:10', 1, NULL, NULL, 'Y'),
(193, 'PD_file_ext', '.png|.jpg|.gif', '2015-12-18 04:06:25', 1, NULL, NULL, 'Y'),
(194, 'PD_make_localthumbnail', 'Y', '2015-12-18 04:06:40', 1, NULL, NULL, 'Y'),
(195, 'PD_must_field', 'eventCode,userFirstName,userLastName,userEmail,FileData00', '2015-12-18 04:07:03', 1, NULL, NULL, 'Y'),
(196, 'PD_remotesync', 'Y', '2015-12-18 04:07:19', 1, NULL, NULL, 'Y'),
(197, 'PD_uploadmethod', 'post', '2015-12-18 04:07:40', 1, NULL, NULL, 'Y'),
(198, 'PD_auto_approval', 'Y', '2015-12-18 04:07:57', 1, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `siteCode` varchar(10) DEFAULT NULL,
  `eventCode` varchar(10) DEFAULT NULL,
  `firstName` varchar(64) DEFAULT NULL,
  `lastName` varchar(64) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `gameCode` varchar(10) DEFAULT NULL,
  `teamCode` varchar(10) DEFAULT NULL,
  `teamPlayerCode` varchar(10) DEFAULT NULL,
  `isRemoteSynced` char(1) DEFAULT 'N',
  `reserve1` varchar(64) DEFAULT NULL,
  `reserve2` varchar(64) DEFAULT NULL,
  `reserve3` varchar(64) DEFAULT NULL,
  `reserve4` varchar(64) DEFAULT NULL,
  `reserve5` varchar(64) DEFAULT NULL,
  `videoId` varchar(64) DEFAULT NULL,
  `photoId` varchar(64) DEFAULT NULL,
  `localId` int(11) DEFAULT NULL,
  `localCreateDate` timestamp NULL DEFAULT NULL,
  `localSiteCode` varchar(10) DEFAULT NULL,
  `isApproved` char(1) NOT NULL DEFAULT 'N',
  `approvedDate` timestamp NULL DEFAULT NULL,
  `approvedUser` int(11) DEFAULT NULL,
  `isSentEmail` char(1) NOT NULL DEFAULT 'N',
  `isSentSNS` char(1) NOT NULL DEFAULT 'N',
  `createDate` timestamp NULL DEFAULT NULL,
  `createUser` int(11) DEFAULT NULL,
  `updateDate` timestamp NULL DEFAULT NULL,
  `updateUser` int(11) DEFAULT NULL,
  `valid` char(1) DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accountrole`
--
ALTER TABLE `accountrole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_AccountRole_Account1_idx` (`aid`),
  ADD KEY `fk_AccountRole_Role1_idx` (`roleId`);

--
-- Indexes for table `activitylog`
--
ALTER TABLE `activitylog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_table1_EmailLog1_idx` (`emailLogId`);

--
-- Indexes for table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emaillog`
--
ALTER TABLE `emaillog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_accesscode` (`accessCode`),
  ADD KEY `fk_EmailLog_User1_idx` (`userId`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `localmedia`
--
ALTER TABLE `localmedia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid_typecode_index` (`userId`,`typeCode`),
  ADD KEY `fk_LocalMedia_LocalUser1_idx` (`userId`);

--
-- Indexes for table `localrfidscan`
--
ALTER TABLE `localrfidscan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ScannedRFID_LocalUser1_idx` (`localUserId`);

--
-- Indexes for table `localuser`
--
ALTER TABLE `localuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Media_LocalUser1_idx` (`userId`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Menu_Menu1_idx` (`pid`);

--
-- Indexes for table `menurole`
--
ALTER TABLE `menurole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_RoleMenu_Menu1_idx` (`menuId`),
  ADD KEY `fk_RoleMenu_Role1_idx` (`roleId`);

--
-- Indexes for table `rfid`
--
ALTER TABLE `rfid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfidscan`
--
ALTER TABLE `rfidscan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ScannedRFID_User1_idx` (`userId`),
  ADD KEY `fk_ScannedRFID_RFID1_idx` (`rfidId`),
  ADD KEY `fk_ScannedRFID_Media1_idx` (`mediaId`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sendsns`
--
ALTER TABLE `sendsns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_SNS_User1_idx` (`userId`);

--
-- Indexes for table `systemoption`
--
ALTER TABLE `systemoption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `accountrole`
--
ALTER TABLE `accountrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `activitylog`
--
ALTER TABLE `activitylog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `code`
--
ALTER TABLE `code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `emaillog`
--
ALTER TABLE `emaillog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `localmedia`
--
ALTER TABLE `localmedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `localrfidscan`
--
ALTER TABLE `localrfidscan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `localuser`
--
ALTER TABLE `localuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `menurole`
--
ALTER TABLE `menurole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `rfid`
--
ALTER TABLE `rfid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rfidscan`
--
ALTER TABLE `rfidscan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sendsns`
--
ALTER TABLE `sendsns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `systemoption`
--
ALTER TABLE `systemoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=199;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accountrole`
--
ALTER TABLE `accountrole`
  ADD CONSTRAINT `fk_AccountRole_Account1` FOREIGN KEY (`aid`) REFERENCES `account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_AccountRole_Role1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `activitylog`
--
ALTER TABLE `activitylog`
  ADD CONSTRAINT `fk_table1_EmailLog1` FOREIGN KEY (`emailLogId`) REFERENCES `emaillog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `emaillog`
--
ALTER TABLE `emaillog`
  ADD CONSTRAINT `fk_EmailLog_User1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `localmedia`
--
ALTER TABLE `localmedia`
  ADD CONSTRAINT `fk_LocalMedia_LocalUser1` FOREIGN KEY (`userId`) REFERENCES `localuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `localrfidscan`
--
ALTER TABLE `localrfidscan`
  ADD CONSTRAINT `fk_ScannedRFID_LocalUser1` FOREIGN KEY (`localUserId`) REFERENCES `localuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `fk_Media_LocalUser1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_Menu_Menu1` FOREIGN KEY (`pid`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `menurole`
--
ALTER TABLE `menurole`
  ADD CONSTRAINT `fk_RoleMenu_Menu1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_RoleMenu_Role1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rfidscan`
--
ALTER TABLE `rfidscan`
  ADD CONSTRAINT `fk_ScannedRFID_Media1` FOREIGN KEY (`mediaId`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ScannedRFID_RFID1` FOREIGN KEY (`rfidId`) REFERENCES `rfid` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ScannedRFID_User1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sendsns`
--
ALTER TABLE `sendsns`
  ADD CONSTRAINT `fk_SNS_User1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
