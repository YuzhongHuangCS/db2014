-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-04-21 11:38:50
-- 服务器版本: 5.5.35-0ubuntu0.13.10.2
-- PHP 版本: 5.5.3-1ubuntu2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `db2014`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loginName` varchar(32) NOT NULL,
  `password` char(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `privilege` tinyint(4) NOT NULL,
  PRIMARY KEY (`adminID`),
  UNIQUE KEY `loginName` (`loginName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `bookID` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `categoryID` int(10) unsigned NOT NULL,
  `press` varchar(64) NOT NULL,
  `year` year(4) NOT NULL,
  `author` varchar(64) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`bookID`),
  KEY `category_foreign` (`categoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 触发器 `book`
--
DROP TRIGGER IF EXISTS `zero_check`;
DELIMITER //
CREATE TRIGGER `zero_check` BEFORE UPDATE ON `book`
 FOR EACH ROW IF (NEW.stock < 0) THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "This book has been borrowed over.";
END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `borrow`
--

CREATE TABLE IF NOT EXISTS `borrow` (
  `borrowID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookID` int(10) unsigned NOT NULL,
  `cardID` int(10) unsigned NOT NULL,
  `adminID` int(10) unsigned NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`borrowID`),
  KEY `book_foreign` (`bookID`),
  KEY `card_foreign` (`cardID`),
  KEY `admin_foreign` (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 触发器 `borrow`
--
DROP TRIGGER IF EXISTS `borrow_map`;
DELIMITER //
CREATE TRIGGER `borrow_map` BEFORE INSERT ON `borrow`
 FOR EACH ROW UPDATE `book` SET `stock` = `stock`-1 WHERE `bookID` = NEW.bookID
//
DELIMITER ;
DROP TRIGGER IF EXISTS `return_checkmap`;
DELIMITER //
CREATE TRIGGER `return_checkmap` BEFORE UPDATE ON `borrow`
 FOR EACH ROW IF (OLD.return_date) THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "This book has already been returned.";
ELSE
	UPDATE `book` SET `stock` = `stock`+1 WHERE `bookID` = NEW.bookID;
END IF
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `card`
--

CREATE TABLE IF NOT EXISTS `card` (
  `cardID` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `department` varchar(64) NOT NULL,
  `privilege` tinyint(4) NOT NULL,
  PRIMARY KEY (`cardID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(64) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `age` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 限制导出的表
--

--
-- 限制表 `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `category_foreign` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`);

--
-- 限制表 `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `admin_foreign` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`),
  ADD CONSTRAINT `card_foreign` FOREIGN KEY (`cardID`) REFERENCES `card` (`cardID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
