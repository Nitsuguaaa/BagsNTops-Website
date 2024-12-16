-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 05:36 PM
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
-- Database: `bagsntopsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountstb`
--

CREATE TABLE `accountstb` (
  `accountId` varchar(7) NOT NULL,
  `accountName` varchar(30) NOT NULL,
  `accountEmail` varchar(50) NOT NULL,
  `accountPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountstb`
--

INSERT INTO `accountstb` (`accountId`, `accountName`, `accountEmail`, `accountPassword`) VALUES
('AD-0000', 'Admin', 'admin@admin.com', '$2y$10$ANh9nztRcr2mAfBQX2jWQ.vXUJevfGUp5A6hEzsytg7B3a1bz1qrO'),
('UI-5135', 'Christian Ken Tan', 'ken.05@gmail.com', '$2y$10$p2MZwefc2W3mf2y.jYw.4.I1qrLo50siKdjPGPz.cYZtwQ0PRproO'),
('UI-5466', 'Pyr Paulo Faltado', 'pyr.05@gmail.com', '$2y$10$4jHeEeCRS5yns.ixdtmhlOL7kmhT3G8Tm2BdZgPZr7buXa4fKYLIq'),
('UI-6382', 'Rafael Matthew Libio', 'rafael.05@gmail.com', '$2y$10$BR8qXNDJRPfR27.pX6DRFO2KpWte55VlEI9923FNbTGDHZOmKJosy'),
('UI-8332', 'Augustin Christian de la Peña', 'augustin.05@gmail.com', '$2y$10$CuleKYPyLTKG9.qRebjXgunTwkIRM49A1j7klUszXJsaXDmLFrAgK'),
('UI-9964', 'Ivan Miguel Doller', 'miguel.05@gmail.com', '$2y$10$0F8QMs63S94.kwyUCqJLmOEB6IkUjp27iuhUBy.rdeSsgRr9Dpkyy');

-- --------------------------------------------------------

--
-- Table structure for table `productstb`
--

CREATE TABLE `productstb` (
  `productId` varchar(7) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productPrice` decimal(10,2) NOT NULL,
  `productStock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productstb`
--

INSERT INTO `productstb` (`productId`, `productName`, `productPrice`, `productStock`) VALUES
('PD-1221', 'Puffer jacket with recycled wadding', 3460.00, 32),
('PD-1578', 'Giorgio Armani Embroidered Logo T-Shirt Black', 1999.00, 10),
('PD-1943', 'Adidas Essentials 3-Stripes Tee', 1300.00, 100),
('PD-4108', 'Poplin Tuxedo Shirtdress', 11670.00, 3),
('PD-4681', 'L.12.12 Blanc Eau de Toilette 50ml', 3950.00, 50),
('PD-5292', 'Versace Tag Bowling Shoulder Bag', 31000.00, 2),
('PD-8267', 'GUESS Originals Rugby Stripe Tee', 1699.00, 67),
('PD-9084', 'Versace Eros Eau de Toilette', 6200.00, 78),
('PD-9804', 'Adidas Adilette 22 Slides (Crystal White)', 3000.00, 13);

-- --------------------------------------------------------

--
-- Table structure for table `transactionstb`
--

CREATE TABLE `transactionstb` (
  `transactionId` varchar(7) NOT NULL,
  `accountId` varchar(7) NOT NULL,
  `productId` varchar(7) NOT NULL,
  `orderQuantity` int(11) NOT NULL,
  `accountAddress` varchar(255) NOT NULL,
  `accountPNum` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountstb`
--
ALTER TABLE `accountstb`
  ADD PRIMARY KEY (`accountId`);

--
-- Indexes for table `productstb`
--
ALTER TABLE `productstb`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `transactionstb`
--
ALTER TABLE `transactionstb`
  ADD KEY `accountId` (`accountId`),
  ADD KEY `productId` (`productId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactionstb`
--
ALTER TABLE `transactionstb`
  ADD CONSTRAINT `transactionstb_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `accountstb` (`accountId`),
  ADD CONSTRAINT `transactionstb_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `productstb` (`productId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
