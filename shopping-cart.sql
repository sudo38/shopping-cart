-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 09:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopping_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `discount_coupons`
--

CREATE TABLE `discount_coupons` (
  `id` bigint(20) NOT NULL,
  `code` varchar(100) NOT NULL,
  `type` enum('percent','fixed') NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `discount_coupons`
--

INSERT INTO `discount_coupons` (`id`, `code`, `type`, `amount`) VALUES
(1, 'PROMO50', 'percent', 50),
(2, 'PROMO100', 'fixed', 100);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `shipping_charge` int(11) NOT NULL,
  `discount_amount` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `wilaya` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `notes` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `subtotal`, `shipping_charge`, `discount_amount`, `total`, `coupon_code`, `first_name`, `last_name`, `email`, `mobile`, `wilaya`, `address`, `notes`) VALUES
(30, 2500, 50, 0, 2550, '', 'Rayan', '28', 'rayan@example.com', '+123-456-789', '50', 'Algers - 16000', ''),
(31, 200, 50, 0, 250, '', 'Rayan', '16', 'rayan@example.com', '123-456-789', '50', 'Algers - 16 000', ''),
(32, 1800, 50, 0, 1850, '', 'Isahk', '16', 'ishak@example.com', '123-456-789', '50', 'Algers - 16000', ''),
(33, 1800, 50, 0, 1850, '', 'nvlns', 'njxlj', 'xjnl ', 'xkn xq', '50', 'jlqj', 'knq'),
(34, 1000, 50, 0, 1050, '', 'jhjbkkb', 'knlknk', 'knk', 'kljnl', '50', 'jnlj', ''),
(35, 1000, 50, 0, 1050, '', 'jhjbkkb', 'knlknk', 'knk', 'kljnl', '50', 'jnlj', ''),
(36, 900, 50, 0, 950, '', 'jjnnjl', 'knlkkn', 'kk,,kmm,', 'k,mmkk', 'Alger', 'lnk', ''),
(37, 1400, 50, 0, 1450, '', 'jjjbjb', 'knnl', 'k,mmmk,', 'knnkl', 'Alger', 'jlj', 'knn'),
(38, 300, 50, 0, 350, '', 'l,m,', 'k,mmk,', 'nln', 'knn', 'Alger', 'pnn', ''),
(39, 2000, 50, 0, 2050, '', 'schksusc', 'knclnk', 'xkcnl', 'knlx ', 'Alger', 'jxw lnn', 'x k,w'),
(40, 2000, 50, 0, 2050, '', 'schksusc', 'knclnk', 'xkcnl', 'knlx ', 'Alger', 'jxw lnn', 'x k,w'),
(41, 2000, 50, 0, 2050, '', 'schksusc', 'knclnk', 'xkcnl', 'knlx ', 'Alger', 'jxw lnn', 'x k,w'),
(42, 1200, 50, 0, 1250, '', 'hkbh', 'kn', 'njnk', 'kmmk', 'Alger', 'k,m,k', 'njnl'),
(43, 1000, 50, 500, 550, '', 'kn', 'll;', 'k,,', 'll,', 'Alger', ',k,l,', ''),
(44, 1500, 50, 750, 800, 'PROMO50', 'l,,lml,l', 'km,l,m,l', 'lùl;;', 'llm;ù;', 'Alger', 'k,kmm,ll,', ''),
(45, 600, 50, 0, 650, '', 'k,k,m', 'l,,', 'll', 'm;;m', 'Alger', 'mkm,kk,', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `cost`) VALUES
(42, 30, 2, 5, 1000),
(43, 30, 3, 5, 1500),
(44, 31, 2, 1, 200),
(45, 32, 2, 2, 400),
(46, 32, 3, 3, 900),
(47, 32, 1, 5, 500),
(48, 33, 2, 3, 600),
(49, 33, 3, 3, 900),
(50, 33, 1, 3, 300),
(51, 35, 2, 2, 400),
(52, 35, 3, 2, 600),
(53, 36, 1, 5, 500),
(54, 36, 2, 2, 400),
(55, 37, 1, 2, 200),
(56, 37, 3, 4, 1200),
(57, 38, 3, 1, 300),
(59, 41, 1, 1, 100),
(60, 41, 3, 3, 900),
(61, 41, 2, 5, 1000),
(62, 42, 3, 3, 900),
(63, 42, 1, 3, 300),
(64, 43, 2, 2, 400),
(65, 43, 3, 2, 600),
(66, 44, 2, 3, 600),
(67, 44, 3, 3, 900),
(68, 45, 2, 2, 400),
(69, 45, 1, 2, 200);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `thumbnail`) VALUES
(1, 'Iphone', '100', '/iphone.jpg'),
(2, 'Airpods', '200', '/airpods.jpg'),
(3, 'Headphone', '300', '/headphone.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_charges`
--

CREATE TABLE `shipping_charges` (
  `id` bigint(20) NOT NULL,
  `wilaya` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shipping_charges`
--

INSERT INTO `shipping_charges` (`id`, `wilaya`, `slug`, `code`, `amount`) VALUES
(1, 'Alger', 'alger', 16, 50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`order_id`),
  ADD KEY `products_ibfk_1` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
