-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:52748
-- Generation Time: Apr 20, 2020 at 12:10 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `localdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `id19ce`
--

CREATE TABLE `id19ce` (
  `id` varchar(50) NOT NULL,
  `fname1` varchar(15) NOT NULL,
  `lname1` varchar(15) NOT NULL,
  `college1` varchar(100) NOT NULL,
  `branch1` varchar(7) NOT NULL,
  `year1` int(1) NOT NULL,
  `fname2` varchar(15) NOT NULL,
  `lname2` varchar(15) NOT NULL,
  `college2` varchar(100) NOT NULL,
  `branch2` varchar(10) NOT NULL,
  `year2` int(1) NOT NULL,
  `phn2` bigint(10) NOT NULL,
  `txn` varchar(30) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `phn1` bigint(10) NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `fee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `id` int(11) NOT NULL,
  `fname` varchar(15) DEFAULT NULL,
  `lname` varchar(15) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phn` bigint(10) DEFAULT NULL,
  `switch` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
