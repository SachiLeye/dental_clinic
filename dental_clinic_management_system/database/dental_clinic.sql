-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 05:18 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dental_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `appointment_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `service_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `appointment_date`, `created_at`, `service_id`, `status`) VALUES
(4, 4, '2024-10-17 17:22:00', '2024-10-13 17:22:06', 3, 'Done'),
(5, 5, '2024-10-31 17:24:00', '2024-10-13 17:24:38', 6, 'Pending'),
(6, 6, '2024-10-31 17:24:00', '2024-10-13 17:26:02', 6, 'Pending'),
(7, 7, '2024-10-25 17:26:00', '2024-10-13 17:26:18', 6, 'Pending'),
(8, 8, '2024-10-16 13:30:00', '2024-10-13 17:30:29', 7, 'Pending'),
(9, 9, '2024-10-16 14:00:00', '2024-10-13 23:11:54', 7, 'Pending'),
(10, 10, '2024-10-17 09:48:00', '2024-10-14 16:49:00', 1, 'Done'),
(11, 11, '2024-10-28 09:00:00', '2024-10-14 18:32:07', 2, 'Done'),
(12, 12, '2024-11-18 08:30:00', '2024-10-14 19:29:43', 7, 'Follow Up'),
(13, 13, '2024-10-14 08:00:00', '2024-10-14 19:45:43', 5, 'Pending'),
(14, 14, '2024-10-14 00:00:00', '2024-10-14 19:50:53', 4, 'Postponed'),
(15, 15, '2024-10-14 00:00:00', '2024-10-14 19:52:11', 2, 'Pending'),
(16, 16, '2024-10-14 00:00:00', '2024-10-14 19:52:30', 4, 'Follow Up'),
(17, 17, '2024-10-14 00:00:00', '2024-10-14 19:52:51', 4, 'Done'),
(18, 18, '2024-11-21 08:00:00', '2024-10-14 19:53:32', 2, 'Pending'),
(19, 19, '2024-11-21 08:00:00', '2024-10-14 19:57:52', 2, 'Pending'),
(20, 20, '2024-10-17 13:00:00', '2024-10-15 11:17:59', 3, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `user_id`) VALUES
(1, 'Ma. Sachilette', 'Leyesa', 'saaach25@gmail.com', '09301952078', '2024-10-13 15:41:48', 0),
(2, 'Sachi', 'Leyesa', 'sach@gmail.com', '09301952078', '2024-10-13 16:43:59', 0),
(3, 'lans', 'lorence', 'sakdnwk4@gmal.com', '12d45', '2024-10-13 16:59:22', 0),
(4, 'Lans Lorence ', 'Hernandez', 'lanslorence@gmail.com', '09639447150', '2024-10-13 17:22:06', 0),
(5, 'dsadas', 'jttfgh', 'fhfg@gmail.com', '345678', '2024-10-13 17:24:38', 0),
(6, 'dsadas', 'jttfgh', 'fhfg@gmail.com', '345678', '2024-10-13 17:26:02', 0),
(7, 'dsadasdbsahdashg', 'hgdsaghfgashfjgj', 'dsladkas@gmail.com', '3124', '2024-10-13 17:26:18', 0),
(8, 'Sachi', 'Maria', 'sach@gmail.com', '09354651542', '2024-10-13 17:30:29', 0),
(9, 'Lorence', 'Hernandez', 'lans@gmail.com', '09127649805', '2024-10-13 23:11:54', 0),
(10, 'LAaaans', 'Hernandez', 'lans@gmail.com', '09127649805', '2024-10-14 16:49:00', 0),
(11, 'LAaaans', 'Hernandez', 'lans@gmail.com', '09127649805', '2024-10-14 18:32:07', 0),
(12, 'MA. SACHILETTE', 'LEYESA', 'maria@gmail.com', '09301648307', '2024-10-14 19:29:43', 0),
(13, 'Yessah', 'Vibas', 'ysa@gmail.com', '095462317651', '2024-10-14 19:45:43', 0),
(14, 'qfws', 'fcds', 'fvdfdx@gmail.com', '0216214864', '2024-10-14 19:50:53', 0),
(15, 'asdf', 'qwerty', 'vfdgr@gmail.com', '095489147412', '2024-10-14 19:52:11', 0),
(16, 'wfdsczdc', 'dsva', 'maria@gmail.com', '0948765124', '2024-10-14 19:52:30', 0),
(17, 'wfdsczdc', 'dsva', 'maria@gmail.com', '0948765124', '2024-10-14 19:52:51', 0),
(18, 'wertyy', 'sfacsa', 'asd@gmail.com', '09462178541', '2024-10-14 19:53:32', 0),
(19, 'wertyy', 'sfacsa', 'asd@gmail.com', '09462178541', '2024-10-14 19:57:52', 0),
(20, 'Marilou', 'Leyesa', 'malou@gmail.com', '09309146122', '2024-10-15 11:17:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`) VALUES
(1, 'Dental Checkup'),
(2, 'Teeth Cleaning'),
(3, 'Filling'),
(4, 'Root Canal Treatment'),
(5, 'Teeth Whitening'),
(6, 'Orthodontics'),
(7, 'Extraction');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'maria', '$2y$10$YEVECdjd5AqGAHxOAgtECuHsMFVtntnlG27N4wtIrJylih6E8.q7C', 'maria@gmail.com', '2024-10-14 19:28:08'),
(2, 'lans', '$2y$10$QDQfvd59gitA7kMqQp/Me.1a3vkQnSFYNDMOdGAKmk/qLKSfnO/oO', 'lans@gmail.com', '2024-10-14 23:51:56'),
(3, 'sachi', '$2y$10$O98U8RLtLm5u4T3amzdFyO6FkS8MxvRRFqXuyJiJnsAeloMjx3f46', 'sach@gmail.com', '2024-10-14 23:56:45'),
(4, 'yessah', '$2y$10$6oxWxnbqPuyEf7LZ3FzvhOzZe1z1rhY/V/5bDJWrPbs5QO5sntSjq', 'ysa@gmail.com', '2024-10-14 23:59:49'),
(5, 'yessah', '$2y$10$O5AySaWffPX9LYuz.3l3kOlcaRrPX5e6gowsLq34LjMLBZPvC8x/m', 'ysa@gmail.com', '2024-10-15 00:01:10'),
(6, 'Sachi', '$2y$10$7EoxoW68YsIiiWqOmbKkxOVB7lAWMAZk8HwXYjcJ2QSgs825LCVES', 'sach@gmail.com', '2024-10-15 09:07:42'),
(7, 'Calvin', '$2y$10$pVQ/3UUXN/ICjkbArWk3JOvh0kBpnNnqWiiC2vRcNePmTHq24stu2', 'calvin@gmail.com', '2024-10-15 09:12:58'),
(8, 'Calvin', '$2y$10$xELDMw33mv0djDdkwvTKSu2HFicbLnxcloFmNS5zvk8NNJoW5Ikh6', 'ckiev@gmail.com', '2024-10-15 09:25:34'),
(9, 'Calvin', '$2y$10$Aak7c2P/DwcUZ1tN4jES8uV70YYX/0tv9J7r5D64vj6mYMOZQc1hi', 'ckiev@gmail.com', '2024-10-15 09:42:23'),
(10, 'Mark', '$2y$10$CjapmxSks5AsrlHmMX0dou4z01SJ0XFw47gq6lpTKfl1pDfTp4WNu', 'mark@gmail.com', '2024-10-15 09:43:34'),
(11, 'Malou', '$2y$10$ZiubSTGR1NnV9NQcCLWlSe7nGWVBAxPNITQ5PqSWyANvCiB1BO4LW', 'malou@gmail.com', '2024-10-15 11:17:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
