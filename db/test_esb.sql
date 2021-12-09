-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 06:13 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_esb`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `subject`, `issue_date`, `due_date`) VALUES
(1, 'invoice desember', '2021-12-08 10:34:57', '2021-12-31'),
(2, 'invoice januari', '2021-12-09 04:28:04', '2021-12-23');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_amount`
--

CREATE TABLE `invoice_amount` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `amount_due` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_amount`
--

INSERT INTO `invoice_amount` (`id`, `invoice_id`, `subtotal`, `tax`, `total`, `amount_paid`, `amount_due`, `created_date`) VALUES
(1, 1, 2500000, 250000, 2750000, 2500000, 250000, '2021-12-08 10:32:22'),
(2, 2, 270000, 27000, 297000, 297000, 0, '2021-12-09 04:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_heading`
--

CREATE TABLE `invoice_heading` (
  `heading_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `sender` varchar(150) NOT NULL,
  `sender_address` text NOT NULL,
  `receiver` varchar(150) NOT NULL,
  `receiver_address` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_heading`
--

INSERT INTO `invoice_heading` (`heading_id`, `invoice_id`, `sender`, `sender_address`, `receiver`, `receiver_address`, `created_date`) VALUES
(1, 1, 'firhan', 'Jl. Keramat No.3C, RT.12/RW.1, Cilandak Tim., Kec. Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12560', 'aldo', 'Filosofi Kopi Pos Bloc, Jl. Pos No.2, Ps. Baru, Kecamatan Sawah Besar, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10710', '2021-12-08 10:32:22'),
(2, 2, 'aldo', 'Jl. Keramat No.3C, RT.12/RW.1, Cilandak Tim., Kec. Ps. Minggu, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12560', 'firhan', 'Filosofi Kopi Pos Bloc, Jl. Pos No.2, Ps. Baru, Kecamatan Sawah Besar, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10710', '2021-12-09 04:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_type` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_item`
--

INSERT INTO `invoice_item` (`item_id`, `invoice_id`, `item_type`, `description`, `quantity`, `unit_price`, `created_date`) VALUES
(1, 1, 'service', 'design', 2, 500000, '2021-12-08 10:32:22'),
(2, 1, 'service', 'marketing', 3, 500000, '2021-12-08 10:32:22'),
(3, 2, 'kopi', 'kopi', 10, 12000, '2021-12-09 04:28:04'),
(4, 2, 'gelas', 'gelas', 100, 1500, '2021-12-09 04:28:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_amount`
--
ALTER TABLE `invoice_amount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `invoice_heading`
--
ALTER TABLE `invoice_heading`
  ADD PRIMARY KEY (`heading_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_amount`
--
ALTER TABLE `invoice_amount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_heading`
--
ALTER TABLE `invoice_heading`
  MODIFY `heading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_amount`
--
ALTER TABLE `invoice_amount`
  ADD CONSTRAINT `invoice_amount_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`);

--
-- Constraints for table `invoice_heading`
--
ALTER TABLE `invoice_heading`
  ADD CONSTRAINT `invoice_heading_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`);

--
-- Constraints for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD CONSTRAINT `invoice_item_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
