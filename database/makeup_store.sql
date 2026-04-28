-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 28 أبريل 2026 الساعة 07:35
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `makeup_store`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`) VALUES
(1, 'admin', '123456', 'admin@makeup.com');

-- --------------------------------------------------------

--
-- بنية الجدول `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Lips'),
(2, 'Face'),
(3, 'Eyes');

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_email`, `customer_address`, `product_id`, `product_name`, `quantity`, `unit_price`, `total_price`, `order_date`) VALUES
(1, '', 'rori@gmail.com', 'khobar', 5, 'Glow & Glam Soft Matte Lip Pen Collection', 30, 15.00, 450.00, '2026-04-28 04:01:02'),
(2, 'REHAM', 'alshehri.r.k.a@gmail.com', 'abha', 5, 'Glow & Glam Soft Matte Lip Pen Collection', 1, 15.00, 15.00, '2026-04-28 04:06:26'),
(3, 'toto', 'toto@gmail.com', 'abha', 4, 'Glow & Glam Hydra-Gloss Lip Collection', 1, 18.00, 18.00, '2026-04-28 04:56:42'),
(4, 'dana', 'dana@gmail.com', 'taif', 3, 'Organic Mascara', 1, 60.00, 60.00, '2026-04-28 05:02:04'),
(5, 'reem', 'reem@gmail.com', 'jeddah', 4, 'Glow & Glam Hydra-Gloss Lip Collection', 2, 18.00, 36.00, '2026-04-28 05:07:17');

-- --------------------------------------------------------

--
-- بنية الجدول `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `skin_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock`, `image_name`, `category_id`, `skin_type`) VALUES
(1, 'Natural Pink Lipstick', 'Long-lasting natural lipstick', 85.00, 15, 'pink_lipstick.jpg', 1, 'All Skins'),
(3, 'Organic Mascara', 'Waterproof organic mascara', 60.00, 8, 'mascara.png', 3, 'Sensitive Eyes'),
(4, 'Glow & Glam Hydra-Gloss Lip Collection', 'The Glow & Glam Hydra-Gloss Lip Collection delivers intense hydration with a high-shine finish. Its lightweight, non-sticky formula glides smoothly onto the lips, providing long-lasting moisture and vibrant color payoff. Available in six beautiful shades: Vanilla Peach, Berry Bliss, Solar Flame, Chilled Blush, Velvet Berry, and Crystal Dew. Perfect for daily wear or special occasions.', 18.00, 17, '1.jfif', 1, 'All skin types'),
(5, 'Glow & Glam Soft Matte Lip Pen Collection', 'The Glow & Glam Soft Matte Lip Pen Collection offers precise application with a smooth, creamy texture that dries to a soft matte finish. Designed for comfort and long wear, it defines and enhances the lips without dryness. Available in six elegant shades: Soft, Rose, Spiced, Mauve, Cocoa, and Mulled. Ideal for bold and natural looks alike.', 15.00, 19, '2.jfif', 1, 'All skin types');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- قيود الجداول `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
