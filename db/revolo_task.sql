-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2022 at 03:06 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `revolo_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` varchar(6) NOT NULL,
  `truck_id` varchar(6) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `loc_from` varchar(100) NOT NULL,
  `loc_to` varchar(100) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_weight` float NOT NULL COMMENT 'Capacity in Tons',
  `truck_owner_id` int(11) NOT NULL,
  `booked_by` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `id` int(11) NOT NULL,
  `truck_id` varchar(6) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `reg_no` varchar(10) NOT NULL,
  `capacity` float NOT NULL COMMENT 'Capacity in Tons',
  `mfg_year` year(4) NOT NULL,
  `availabilty_from` date NOT NULL,
  `availabilty_to` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trucks`
--

INSERT INTO `trucks` (`id`, `truck_id`, `owner_id`, `company_name`, `reg_no`, `capacity`, `mfg_year`, `availabilty_from`, `availabilty_to`, `added_by`, `updated_on`) VALUES
(1, '8ffb13', 1, 'KVC Travels', 'AP39GY2893', 50, 2019, '2022-05-20', '2022-05-26', 1, '2022-05-19 12:25:28'),
(2, '995ae1', 1, 'KVC Travels', 'AP39GY2897', 40, 2021, '2022-05-21', '2022-05-28', 1, '2022-05-19 12:25:44'),
(3, 'fcda11', 2, 'Chowdary Travels', 'AP39GY2896', 75, 2020, '2022-05-20', '2022-05-24', 2, '2022-05-19 13:05:03'),
(4, '954ac2', 2, 'Chowdary Travels', 'AP39GY2693', 40, 2019, '2022-05-20', '2022-05-22', 2, '2022-05-19 13:05:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `password`, `updated_on`) VALUES
(1, 'User One', 9553389171, 'userone@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '2022-05-19 13:05:58'),
(2, 'User Two', 8309558890, 'usertwo@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '2022-05-19 13:06:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
