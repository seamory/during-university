-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-01-19 10:33:51
-- 服务器版本： 5.7.15-log
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmsystem`
--

-- --------------------------------------------------------

--
-- 表的结构 `dm_eclass`
--

CREATE TABLE `dm_eclass` (
  `uid` int(11) NOT NULL,
  `ecid` int(11) NOT NULL,
  `ecname` varchar(30) NOT NULL DEFAULT '空课表',
  `dt` varchar(20) NOT NULL,
  `sdb` int(11) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
---------------------

--
-- 表的结构 `dm_ecs`
--

CREATE TABLE `dm_ecs` (
  `ecid` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `sdb` int(2) DEFAULT NULL,
  `weekday` int(1) DEFAULT NULL,
  `class` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dm_form`
--

CREATE TABLE `dm_form` (
  `fmid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fmname` varchar(30) NOT NULL DEFAULT '问卷',
  `dt` varchar(20) NOT NULL,
  `state` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 表的结构 `dm_formbase`
--

CREATE TABLE `dm_formbase` (
  `fmid` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `topic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 表的结构 `dm_formresult`
--

CREATE TABLE `dm_formresult` (
  `fmid` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `topicid` int(11) NOT NULL,
  `topicresult` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- 表的结构 `dm_formstruct`
--

CREATE TABLE `dm_formstruct` (
  `fmid` int(11) NOT NULL,
  `topicID` int(11) NOT NULL,
  `type` varchar(15) NOT NULL,
  `value` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 表的结构 `dm_ip`
--

CREATE TABLE `dm_ip` (
  `fmid` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- 表的结构 `dm_notices`
--

CREATE TABLE `dm_notices` (
  `uid` int(11) NOT NULL,
  `dt` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `notice` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dm_option`
--

CREATE TABLE `dm_option` (
  `setting` varchar(20) DEFAULT NULL,
  `sel` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dm_user`
--

CREATE TABLE `dm_user` (
  `uid` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(33) NOT NULL,
  `usergroup` varchar(15) NOT NULL,
  `licence` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- 表的结构 `dm_userinfor`
--

CREATE TABLE `dm_userinfor` (
  `uid` int(11) NOT NULL,
  `name` varchar(10) DEFAULT NULL,
  `sex` varchar(2) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tel` varchar(13) DEFAULT NULL,
  `qq` varchar(12) DEFAULT NULL,
  `wechat` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dm_eclass`
--
ALTER TABLE `dm_eclass`
  ADD PRIMARY KEY (`ecid`);

--
-- Indexes for table `dm_form`
--
ALTER TABLE `dm_form`
  ADD PRIMARY KEY (`fmid`);

--
-- Indexes for table `dm_notices`
--
ALTER TABLE `dm_notices`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `dm_user`
--
ALTER TABLE `dm_user`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `dm_userinfor`
--
ALTER TABLE `dm_userinfor`
  ADD PRIMARY KEY (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dm_eclass`
--
ALTER TABLE `dm_eclass`
  MODIFY `ecid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `dm_form`
--
ALTER TABLE `dm_form`
  MODIFY `fmid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `dm_user`
--
ALTER TABLE `dm_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
