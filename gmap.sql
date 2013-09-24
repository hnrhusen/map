-- phpMyAdmin SQL Dump
-- version 3.4.3deb1.lucid~ppa.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2011 at 01:22 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gmap`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`) VALUES
(1, 'Petrol Stations', 1),
(2, 'Leisure Centre', 1),
(3, 'Railway Stations', 1);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `default` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `latitude`, `longitude`, `default`, `status`) VALUES
(6, 'Carlisle', 54.894351392018, -2.9352534179687, 1, 1),
(7, 'Penrith', 54.6632791211221, -2.75260571289061, 0, 1),
(8, 'Keswick', 54.5988910884153, -3.13232067871093, 0, 1),
(9, 'Kendal', 54.3247040040354, -2.74367932128905, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE IF NOT EXISTS `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `name`, `description`, `longitude`, `latitude`, `status`) VALUES
(12, 'Golden Fleece Garage', 'Golden Fleece Garage', -2.87577275085448, 54.8573267127907, 1),
(11, 'Corby Hill Garage', 'Corby Hill Garage', -2.81468812274932, 54.9047110359937, 1),
(10, 'Sands Garage', 'Sands Garage', -2.7238953475952, 54.9425349409009, 1),
(9, 'Low Row Garage', 'Low Row Garage', -2.64686230468749, 54.9592568101133, 1),
(8, 'Henshaw Garage', 'Collect points every time you clean your car at a BP service station', -2.37632397460936, 54.9742352724781, 1),
(13, 'Carisle Railway Station', 'Carlisle Railway Station', -2.93315056610106, 54.8906615615622, 1),
(14, 'Wetheral Railway Station', 'Wetheral Railway Station', -2.83234242248534, 54.88391039488, 1),
(15, 'Brampton Railway Station', 'Brampton Railway Station', -2.7024805908203, 54.932389990392, 1),
(16, 'Haltwhistle Railway Station', 'Haltwhistle Railway Station', -2.4636996154785, 54.967756787544, 1),
(17, 'Newcastle Central Station', 'Newcastle Central Station', -1.61732319641112, 54.9682002152645, 1),
(18, 'The Sands Centre', 'The Sands Centre', -2.93381575393676, 54.8989601201245, 1),
(19, 'Haltwhistle Pool', 'Haltwhistle Pool', -2.46794823455809, 54.9695674199197, 1),
(20, 'Team Northumbria', 'Team Northumbria', -1.60710934448241, 54.9777511989164, 1);

-- --------------------------------------------------------

--
-- Table structure for table `point_categories`
--

CREATE TABLE IF NOT EXISTS `point_categories` (
  `point_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`point_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `point_categories`
--

INSERT INTO `point_categories` (`point_id`, `category_id`) VALUES
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 2),
(19, 2),
(20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('6fae30a2d2df778bee4b05d525be3e56', '91.125.157.48', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:5.', 1311680202, ''),
('69a1c6360d7a97af4eae0ecf1cd8981f', '91.125.157.48', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) App', 1311682892, 'a:2:{s:14:"selected_place";s:1:"6";s:2:"id";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) NOT NULL,
  `password` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`) VALUES
(1, 'admin', '3316bd543b6a060190802e8f84c39c16e06b351a', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
