-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 31, 2011 at 10:00 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `virtualtrader`
--

-- --------------------------------------------------------

--
-- Table structure for table `stocks_available`
--

CREATE TABLE IF NOT EXISTS `stocks_available` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `price` varchar(20) NOT NULL,
  `diff` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_db`
--

CREATE TABLE IF NOT EXISTS `user_db` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(200) NOT NULL,
  `lastlogin` varchar(30) NOT NULL default 'Never',
  `balance` varchar(1000) NOT NULL default '200',
  `resethash` varchar(15) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_stocks`
--

CREATE TABLE IF NOT EXISTS `user_stocks` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(30) NOT NULL,
  `stock` varchar(30) NOT NULL,
  `quantity` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

