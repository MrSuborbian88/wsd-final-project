-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2011 at 07:25 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `websysfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `article_keywords`
--

CREATE TABLE IF NOT EXISTS `article_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `article_keywords`
--


-- --------------------------------------------------------

--
-- Table structure for table `clicks`
--

CREATE TABLE IF NOT EXISTS `clicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `clicktime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `keyword_id_2` (`user_id`),
  KEY `article_id` (`article_id`),
  KEY `article_id_2` (`article_id`),
  KEY `article_id_3` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2011 ;

--
-- Dumping data for table `clicks`
--


--
-- Triggers `clicks`
--
DROP TRIGGER IF EXISTS `clicks_INSERT`;
DELIMITER //
CREATE TRIGGER `clicks_INSERT` BEFORE INSERT ON `clicks`
 FOR EACH ROW BEGIN
    Set new.clicktime = now();
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(64) NOT NULL,
  `appearances` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `keywords`
--


-- --------------------------------------------------------

--
-- Table structure for table `rss_articles`
--

CREATE TABLE IF NOT EXISTS `rss_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(512) NOT NULL,
  `url` varchar(512) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `pubdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `guid` (`guid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2057 ;

--
-- Dumping data for table `rss_articles`
--


-- --------------------------------------------------------

--
-- Table structure for table `totalwords`
--

CREATE TABLE IF NOT EXISTS `totalwords` (
  `number` int(100) NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `totalwords`
--

INSERT INTO `totalwords` (`number`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `cluster` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2010 ;

--
-- Dumping data for table `users`
--

