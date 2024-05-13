-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 09:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `godrive`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `license_number` varchar(20) DEFAULT NULL,
  `car_model` varchar(50) DEFAULT NULL,
  `car_registration` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `user_id`, `license_number`, `car_model`, `car_registration`) VALUES
(1, 1, 'DL12345', 'Toyota', 'ABC123'),
(2, 2, 'DL54321', 'Honda', 'XYZ789');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `ride_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `ride_id`, `amount`, `payment_date`) VALUES
(2, 2, 15.00, '2024-04-30 12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `ride_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `review_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `ride_id`, `user_id`, `rating`, `comment`, `review_date`) VALUES
(1, 1, 3, 5, 'Great ride!', '2024-04-30 11:30:00'),
(2, 2, 4, 4, 'Good service', '2024-04-30 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `rider_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riders`
--

INSERT INTO `riders` (`rider_id`, `user_id`, `payment_method`) VALUES
(0, 0, 'Cash'),
(1, 3, 'Credit Card'),
(2, 4, 'PayPal'),
(3, 5, 'Cash'),
(66301985, 66301985, 'Bkash');

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `ride_id` int(11) NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `rider_id` int(11) DEFAULT NULL,
  `pickup_location` varchar(100) DEFAULT NULL,
  `dropoff_location` varchar(100) DEFAULT NULL,
  `ride_status` varchar(20) DEFAULT NULL,
  `ride_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rides`
--

INSERT INTO `rides` (`ride_id`, `driver_id`, `rider_id`, `pickup_location`, `dropoff_location`, `ride_status`, `ride_date`) VALUES
(1, 1, 1, 'Location A', 'Location B', 'completed', '2024-04-30 10:00:00'),
(2, 2, 2, 'Location C', 'Location D', 'completed', '2024-04-30 11:00:00'),
(4, NULL, 1, 'Gulisthan', 'Notunbazar', 'pending', '2024-05-13 20:11:05'),
(5, NULL, 1, 'Gulisthan', 'Notunbazar', 'pending', '2024-05-13 20:11:21'),
(6, NULL, 1, 'Khilagaon', 'Kakrail', 'pending', '2024-05-13 20:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone_number`) VALUES
(0, 'jun43d', '123456789', 'asdajshjak@jkasfa.com', '+5648464584798'),
(1, 'user1', 'password1', 'user1@example.com', '+1234567890'),
(2, 'user2', 'password2', 'user2@example.com', '+1987654321'),
(3, 'user3', 'password3', 'user3@example.com', '+1122334455'),
(4, 'user4', 'password4', 'user4@example.com', '+1555666777'),
(5, 'user5', 'password5', 'user5@example.com', '+1888999900'),
(66301985, 'zun43d', '555555', 'aksdnja!@hmail.com', '+5997451587');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `ride_id` (`ride_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `ride_id` (`ride_id`),
  ADD KEY `FK_Reviews_Users` (`user_id`);

--
-- Indexes for table `riders`
--
ALTER TABLE `riders`
  ADD PRIMARY KEY (`rider_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`ride_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `rider_id` (`rider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `ride_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_Reviews_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`ride_id`);

--
-- Constraints for table `riders`
--
ALTER TABLE `riders`
  ADD CONSTRAINT `riders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rides`
--
ALTER TABLE `rides`
  ADD CONSTRAINT `rides_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`),
  ADD CONSTRAINT `rides_ibfk_2` FOREIGN KEY (`rider_id`) REFERENCES `riders` (`rider_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
