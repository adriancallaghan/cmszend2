-- phpMyAdmin SQL Dump
-- version 4.0.0-rc4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2013 at 11:25 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created`) VALUES
(1, 'adrian', '9c33d89fc57e1f1e7567cad0b1e8d55a', '2013-06-06 15:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `artist` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`, `created`) VALUES
(16, 'Artist4', 'Title4', '2013-06-03 10:10:32'),
(21, 'AC DC', 'Dirty Deeds', '2013-06-03 10:15:57'),
(22, 'ftyfyt', 'TErt', '2013-06-03 12:10:18'),
(23, 'Artist4', 'Title1', '2013-06-03 15:49:43'),
(24, 'Artist4', 'Title2', '2013-06-03 15:49:47'),
(25, 'Artist4', 'Title4', '2013-06-03 15:49:48'),
(26, 'Artist1', 'Title3', '2013-06-03 15:56:10'),
(27, 'Artist1', 'Title1', '2013-06-03 15:58:10'),
(28, 'Artist1', 'Title4', '2013-06-03 16:06:52'),
(29, 'Artist2', 'Title2', '2013-06-03 16:06:53'),
(30, 'Artist2', 'Title3', '2013-06-03 16:06:53'),
(31, 'Artist1', 'Title1', '2013-06-03 16:06:53'),
(32, 'Artist2', 'Title1', '2013-06-03 16:06:53'),
(33, 'Artist1', 'Title4', '2013-06-03 16:06:54'),
(34, 'Artist4', 'Title3', '2013-06-03 16:06:54'),
(35, 'Artist2', 'Title1', '2013-06-03 16:06:54'),
(36, 'Artist4', 'Title3', '2013-06-03 16:06:54'),
(37, 'Artist2', 'Title1', '2013-06-03 16:06:54'),
(38, 'Artist1', 'Title3', '2013-06-03 16:06:57'),
(39, 'Artist1', 'Title2', '2013-06-03 16:06:57'),
(40, 'Artist3', 'Title4', '2013-06-03 16:06:57'),
(41, 'Artist1', 'Title2', '2013-06-03 16:06:57'),
(42, 'Artist3', 'Title3', '2013-06-03 16:17:37'),
(43, 'Artist4', 'Title1', '2013-06-04 09:21:46'),
(44, 'Artist4', 'Title1', '2013-06-04 09:36:51'),
(45, 'Artist2', 'Title1', '2013-06-04 09:36:58'),
(46, 'Artist4', 'Title1', '2013-06-04 09:37:53'),
(47, 'Artist4', 'Title1', '2013-06-04 09:37:55'),
(48, 'Artist3', 'Title2', '2013-06-04 09:53:35'),
(49, 'Artist3', 'Title1', '2013-06-04 10:00:36'),
(50, 'Artist1', 'Title4', '2013-06-05 09:04:54'),
(51, 'Artist3', 'Title2', '2013-06-05 12:39:42'),
(52, 'Artist4', 'Title2', '2013-06-06 16:16:42'),
(53, 'Artist1', 'Title4', '2013-06-06 16:16:44'),
(54, 'Artist3', 'Title3', '2013-06-06 16:16:45'),
(55, 'Artist4', 'Title1', '2013-06-06 16:16:45'),
(56, 'Artist2', 'Title1', '2013-06-07 09:28:43'),
(57, 'Artist4', 'Title2', '2013-06-07 09:29:41');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
