-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2016 at 11:20 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teamio`
--
CREATE DATABASE IF NOT EXISTS `teamio` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE `teamio`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `diary_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `diary_id`, `name`, `body`, `posted`) VALUES
(1, 1, 'Joe Shmoe', 'First!', '2012-08-18 08:32:52'),
(2, 2, 'TestName', 'Test Message', '2016-02-18 10:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `diaries`
--

DROP TABLE IF EXISTS `diaries`;
CREATE TABLE IF NOT EXISTS `diaries` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL DEFAULT '',
  `slug` varchar(25) NOT NULL,
  `body` text NOT NULL,
  `published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `diaries`
--

INSERT INTO `diaries` (`id`, `title`, `slug`, `body`, `published`) VALUES
(1, 'First Post', 'first-post', 'This is the first post for Teamio. Hello, world?', '2012-08-18 08:28:10'),
(2, 'Second Post', 'second-post', 'Just another post to test out some features.\n\nLine break and *asterisks* to show Markdown integration.', '2012-08-18 08:39:03'),
(14, 'One More Post', 'one-more-post', 'No need Content-Type, Posted from my browser', '2016-02-18 14:44:03'),
(16, 'One More Post', 'one-more-post2', 'No need Content-Type, Posted from my browser', '2016-02-18 14:57:03');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
