-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 04 月 28 日 16:01
-- 服务器版本: 5.5.27
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `news_monitor`
--

-- --------------------------------------------------------

--
-- 表的结构 `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(128) NOT NULL,
  `site_name` varchar(512) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `user_group`
--

INSERT INTO `user_group` (`ID`, `group_name`, `site_name`) VALUES
(1, 'jnxy', '%e6%b5%8e%e5%ae%81%e5%ad%a6%e9%99%a2'),
(2, 'admin', '%e6%b5%8e%e5%ae%81%e5%ad%a6%e9%99%a2'),
(3, 'admin', '%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD%E5%AE%9E%E9%AA%8C%E5%AE%A4'),
(4, 'admin', '%e6%b1%bd%e8%bd%a6%e4%b9%8b%e5%ae%b6'),
(5, 'admin', '%e6%b5%8e%e5%ae%81%e5%b8%82%e4%ba%ba%e6%b0%91%e6%94%bf%e5%ba%9c%e5%a4%96%e4%ba%8b%e4%be%a8%e5%8a%a1%e5%8a%9e%e5%85%ac%e5%ae%a4'),
(6, 'admin', '%e5%b1%b1%e4%b8%9c%e7%9c%81%e6%95%99%e8%82%b2%e5%8e%85'),
(7, 'admin', '%e9%9d%92%e5%b2%9b%e9%93%b6%e8%a1%8c'),
(8, 'jnxy', '%E4%BA%BA%E5%B7%A5%E6%99%BA%E8%83%BD%E5%AE%9E%E9%AA%8C%E5%AE%A4'),
(9, 'jnxy', '%e5%b1%b1%e4%b8%9c%e7%9c%81%e6%95%99%e8%82%b2%e5%8e%85'),
(10, 'jnxy', '%e5%b1%b1%e4%b8%9c%e7%9c%81%e7%a7%91%e5%ad%a6%e6%8a%80%e6%9c%af%e5%8e%85');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
