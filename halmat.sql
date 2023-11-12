-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 05:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `halmat`
--

-- --------------------------------------------------------

--
-- Table structure for table `rgm_admin`
--

CREATE TABLE `rgm_admin` (
  `id` varchar(40) NOT NULL,
  `role` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rgm_admin`
--

INSERT INTO `rgm_admin` (`id`, `role`, `name`, `phone`, `username`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
('ae2ebb96-b104-f3dd-4fa0-30a44e1c789d', 'Admin', 'Administrator', '00000000000', 'admin', '$2y$10$uILG/LDLClpu.isskQWDa.ggDM47z.RX8UJdFOMUJNF1ajB3GzbBi', '2023-11-12 05:44:44', '2023-11-12 05:46:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rgm_categories`
--

CREATE TABLE `rgm_categories` (
  `id` varchar(40) NOT NULL,
  `name` varchar(50) NOT NULL,
  `more` tinytext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rgm_expenses`
--

CREATE TABLE `rgm_expenses` (
  `id` varchar(40) NOT NULL,
  `category` varchar(40) NOT NULL,
  `more` tinytext NOT NULL,
  `amount` decimal(9,1) NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rgm_log`
--

CREATE TABLE `rgm_log` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `proxie` varchar(20) NOT NULL,
  `named` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `done_by` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rgm_payments`
--

CREATE TABLE `rgm_payments` (
  `id` varchar(40) NOT NULL,
  `service` varchar(40) NOT NULL,
  `amount` decimal(9,1) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rgm_services`
--

CREATE TABLE `rgm_services` (
  `id` varchar(40) NOT NULL,
  `name` varchar(50) NOT NULL,
  `more` tinytext NOT NULL,
  `price` decimal(9,1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rgm_tasks`
--

CREATE TABLE `rgm_tasks` (
  `id` varchar(40) NOT NULL,
  `voucher` varchar(8) NOT NULL,
  `task_id` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'customer name',
  `phone` varchar(15) NOT NULL COMMENT 'customer phone number',
  `remark` tinytext NOT NULL,
  `service` varchar(40) NOT NULL,
  `price` decimal(9,1) NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `author` varchar(40) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rgm_admin`
--
ALTER TABLE `rgm_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rgm_categories`
--
ALTER TABLE `rgm_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rgm_expenses`
--
ALTER TABLE `rgm_expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rgm_log`
--
ALTER TABLE `rgm_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `rgm_payments`
--
ALTER TABLE `rgm_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rgm_services`
--
ALTER TABLE `rgm_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rgm_tasks`
--
ALTER TABLE `rgm_tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rgm_log`
--
ALTER TABLE `rgm_log`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
