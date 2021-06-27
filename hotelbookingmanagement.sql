-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2021 at 05:58 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotelbookingmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `checkInDate` date NOT NULL,
  `checkOutDate` date NOT NULL,
  `room_no` int(11) NOT NULL,
  `room_type` varchar(25) NOT NULL,
  `checked_in` varchar(3) NOT NULL DEFAULT 'NO',
  `reserved_on` datetime NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contactform`
--

CREATE TABLE `contactform` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `recieved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `replied` varchar(3) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loginform`
--

CREATE TABLE `loginform` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `admin` varchar(3) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loginform`
--

INSERT INTO `loginform` (`id`, `fname`, `lname`, `email`, `username`, `password`, `created_at`, `admin`) VALUES
(1, 'Admin', '1', 'admin@gmail.com', 'admin', '$2y$10$hhfdE3DZIMYCs.TUwr2lY.02ybw9G4.ph7QmMfs3St7196jkgcZ..', '2021-05-29 21:24:35', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` int(11) NOT NULL,
  `room_type` varchar(25) NOT NULL,
  `price` int(11) NOT NULL,
  `discountedPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `room_type`, `price`, `discountedPrice`) VALUES
(1, 101, 'Standard Single', 600, 0),
(2, 102, 'Standard Single', 600, 0),
(3, 103, 'Standard Single', 600, 0),
(4, 104, 'Standard Single', 600, 0),
(5, 105, 'Standard Single', 600, 0),
(6, 201, 'Standard Double', 800, 0),
(7, 202, 'Standard Double', 800, 0),
(8, 203, 'Standard Double', 800, 0),
(9, 204, 'Standard Double', 800, 0),
(10, 205, 'Standard Double', 800, 0),
(11, 301, 'Deluxe Single', 1100, 0),
(12, 302, 'Deluxe Single', 1100, 0),
(13, 303, 'Deluxe Single', 1100, 0),
(14, 304, 'Deluxe Single', 1100, 0),
(15, 305, 'Deluxe Single', 1100, 0),
(16, 401, 'Deluxe Double', 1500, 0),
(17, 402, 'Deluxe Double', 1500, 0),
(18, 403, 'Deluxe Double', 1500, 0),
(19, 404, 'Deluxe Double', 1500, 0),
(20, 405, 'Deluxe Double', 1500, 0),
(21, 501, 'Deluxe Suite', 2000, 0),
(22, 502, 'Deluxe Suite', 2000, 0),
(23, 503, 'Deluxe Suite', 2000, 0),
(24, 504, 'Deluxe Suite', 2000, 0),
(25, 505, 'Deluxe Suite', 2000, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactform`
--
ALTER TABLE `contactform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loginform`
--
ALTER TABLE `loginform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contactform`
--
ALTER TABLE `contactform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loginform`
--
ALTER TABLE `loginform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
