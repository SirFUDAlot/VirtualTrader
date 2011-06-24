-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2011 at 02:37 PM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `u667856163_vtrad`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `action` varchar(1) NOT NULL,
  `stock` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `bankbalance` float NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=263 ;

-- --------------------------------------------------------

--
-- Table structure for table `stocks_available`
--

CREATE TABLE IF NOT EXISTS `stocks_available` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `price` varchar(20) NOT NULL DEFAULT '0',
  `diff` varchar(20) NOT NULL DEFAULT '0',
  `diff_perc` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_db`
--

CREATE TABLE IF NOT EXISTS `user_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(200) NOT NULL,
  `lastlogin` varchar(30) NOT NULL DEFAULT 'Never',
  `balance` double NOT NULL DEFAULT '200',
  `resethash` varchar(15) NOT NULL DEFAULT '0',
  `resetdate` datetime NOT NULL,
  `activationKey` varchar(32) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_stocks`
--

CREATE TABLE IF NOT EXISTS `user_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219 ;
