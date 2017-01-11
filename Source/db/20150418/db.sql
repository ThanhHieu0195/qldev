ALTER TABLE `donhang`  ADD `checked` TINYINT NOT NULL DEFAULT '0' COMMENT '-1: Invalid; 0: Unchecked; 1: Checked' ;
Update donhang set checked = -1;
Update donhang set checked = 0 where trangthai = 0;


-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2015 at 09:48 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ho08061_banhang`
--

-- --------------------------------------------------------

--
-- Table structure for table `danhgiadonhang`
--

CREATE TABLE IF NOT EXISTS `danhgiadonhang` (
  `order_id` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `quality` int(11) NOT NULL COMMENT '1/2/3: Tốt/TB/Kém',
  `quality_note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `price_note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `sell` int(11) NOT NULL,
  `sell_note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `delivery` int(11) NOT NULL,
  `delivery_note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `introduce` int(11) NOT NULL,
  `introduce_note` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `danhgiadonhang`
--
ALTER TABLE `danhgiadonhang`
 ADD PRIMARY KEY (`order_id`);


INSERT INTO account_function VALUES('orders_unchecked_list', 'orders', 'Đơn hàng chờ kiểm tra', 'Quản lý danh sách đơn hàng chờ kiểm tra', 1);
INSERT INTO account_function VALUES('orders_checked_list', 'orders', 'Đơn hàng đã kiểm tra', 'Quản lý danh sách đơn hàng đã kiểm tra', 1);

INSERT INTO account_function_of_role VALUES('admin', 'orders_unchecked_list');
INSERT INTO account_function_of_role VALUES('admin', 'orders_checked_list');

-- 20150503
/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50621
 Source Host           : localhost
 Source Database       : ho08061_banhang

 Target Server Type    : MySQL
 Target Server Version : 50621
 File Encoding         : utf-8

 Date: 05/03/2015 10:48:21 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `orders_question`
-- ----------------------------
DROP TABLE IF EXISTS `orders_question`;
CREATE TABLE `orders_question` (
  `question_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `enable` tinyint(4) NOT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;


DROP TABLE IF EXISTS `orders_question_option`;
CREATE TABLE `orders_question_option` (
  `uid` varchar(50) NOT NULL,
  `question_id` varchar(50) NOT NULL,
  `no` tinyint NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=`InnoDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT='';

DROP TABLE IF EXISTS `orders_question_result`;
CREATE TABLE `orders_question_result` (
  `order_id` varchar(11) NOT NULL,
  `question_id` varchar(50) NOT NULL,
  `option` varchar(50) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`order_id`, `question_id`)
) ENGINE=`InnoDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT='';


INSERT INTO account_function VALUES('orders_questions_list', 'system_admin', 'Quản lý câu hỏi đơn hàng', 'Quản lý câu hỏi đơn hàng', 1);
INSERT INTO account_function_of_role VALUES('admin', 'orders_questions_list');


DROP TABLE `danhgiadonhang`;