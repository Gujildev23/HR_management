-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 03:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `factory_workers`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee_records`
--

CREATE TABLE `employee_records` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_records`
--

INSERT INTO `employee_records` (`id`, `name`, `position`, `address`, `phone_number`, `age`, `email`, `photo`) VALUES
(1, 'Caballo, Margie', 'Finishing', '', 0, 0, '', ''),
(2, 'Lacaden, Janice', 'Warehouse', '', 0, 0, '', ''),
(3, 'Abay, Ruben S.', 'Diecut Operator', '', 0, 0, '', ''),
(4, 'Antiola, Marvin', 'Driver', '', 0, 0, '', ''),
(5, 'Ayroso, Diazy', 'Quality Control', '', 0, 0, '', ''),
(6, 'Baldonado, Julito', 'Production Supervisor', '', 0, 0, '', ''),
(7, 'Bolante, Lea G.', 'Human Resources', '', 0, 0, '', ''),
(8, 'Callo, Jonathan C.', 'Driver', '', 0, 0, '', ''),
(9, 'Castillo, Melibeth L.', 'Artisit/PDD', '', 0, 0, '', ''),
(10, 'Corpin, Domingo L.', 'Flexo Operator', '', 0, 0, '', ''),
(11, 'Cresencio, Michael Z. ', 'Glueing Machine Operator', '', 0, 0, '', ''),
(12, 'Cabrito, Ranniel B.', 'Sales', '', 0, 0, '', ''),
(13, 'Lacaden, Jorjin', 'Assistant Flex Operator', '', 0, 0, '', ''),
(14, 'Pacana, Junard M.', 'Diecut Operator', '', 0, 0, '', ''),
(15, 'Recto, Magdalino Jr. I.', 'Driver', '', 0, 0, '', ''),
(16, 'Tabamo, Nancy M.', 'Logistic Head', '', 0, 0, '', ''),
(17, 'Bagongon, Bernard', 'Courier', '', 0, 0, '', ''),
(18, 'Catalan, Cris A.', 'Stitching Machine Operator', '', 0, 0, '', ''),
(19, 'Pacana, Leo M.', 'Courier', '', 0, 0, '', ''),
(20, 'Tabamo, Jaymar H.', 'Production Helper', '', 0, 0, '', ''),
(21, 'Tabamo, Rico M.', 'Flexo Operator', '', 0, 0, '', ''),
(22, 'Pasores, Jomar', 'Production Helper', '', 0, 0, '', ''),
(23, 'Lonzagon, Maylene', 'Finishing', '', 0, 0, '', ''),
(24, 'Zapico, Julito Jr. E.', 'Flexo Helper', '', 0, 0, '', ''),
(25, 'Balibes, JR', 'Production Helper', '', 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `daily_rate` int(11) NOT NULL,
  `basic_pay` int(11) NOT NULL,
  `reg_OT` int(11) NOT NULL,
  `late_deduction` int(11) NOT NULL,
  `gross_pay` int(11) NOT NULL,
  `sss_deduction` int(11) NOT NULL,
  `pagibig_deduction` int(11) NOT NULL,
  `philhealth_deduction` int(11) NOT NULL,
  `total_deduction` int(11) NOT NULL,
  `net_salary` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `name`, `position`, `salary`, `daily_rate`, `basic_pay`, `reg_OT`, `late_deduction`, `gross_pay`, `sss_deduction`, `pagibig_deduction`, `philhealth_deduction`, `total_deduction`, `net_salary`, `date`) VALUES
(2, 'Tabamo', 'Delivery', 35000, 1167, 8167, 700, 400, 8467, 250, 1000, 1000, 2250, 24283, '2024-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee_records`
--
ALTER TABLE `employee_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
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
-- AUTO_INCREMENT for table `employee_records`
--
ALTER TABLE `employee_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
