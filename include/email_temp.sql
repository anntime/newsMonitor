-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 05 月 23 日 09:51
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `news_monitor`
--

-- --------------------------------------------------------

--
-- 表的结构 `email_temp`
--

CREATE TABLE IF NOT EXISTS `email_temp` (
  `ID` int(11) NOT NULL auto_increment,
  `user_name` varchar(128) NOT NULL,
  `user_mail` varchar(50) NOT NULL,
  `email_title` varchar(20480) NOT NULL,
  `send_time` datetime NOT NULL,
  `is_send` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `email_temp`
--

INSERT INTO `email_temp` (`ID`, `user_name`, `user_mail`, `email_title`, `send_time`, `is_send`) VALUES
(1, '1', '1', '1', '2013-05-23 17:28:19', 1);
