-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2024 at 12:00 PM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techshdd_garments`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(100) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pin_code` int(10) NOT NULL,
  `country` varchar(255) NOT NULL,
  `cus_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `address`, `city`, `state`, `pin_code`, `country`, `cus_id`, `name`) VALUES
(11, 'chanditala', 'chanditala', 'WB', 712702, 'india', 13, 'Shankar Ghosh');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cus_id` int(255) NOT NULL,
  `pro_id` int(255) NOT NULL,
  `selected_color_id` int(255) NOT NULL,
  `selected_size_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cus_id`, `pro_id`, `selected_color_id`, `selected_size_id`, `quantity`) VALUES
(1, 5, 4, 4, 1),
(1, 5, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `category`) VALUES
(1, 'MEN'),
(2, 'WOMEN'),
(3, 'KIDS');

-- --------------------------------------------------------

--
-- Table structure for table `down_categories`
--

CREATE TABLE `down_categories` (
  `down_cat_id` int(255) NOT NULL,
  `down_category` varchar(255) NOT NULL,
  `cat_id` int(255) NOT NULL,
  `sub_cat_id` int(255) NOT NULL,
  `under_cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `down_categories`
--

INSERT INTO `down_categories` (`down_cat_id`, `down_category`, `cat_id`, `sub_cat_id`, `under_cat_id`) VALUES
(3, 'Stripet Tshirts', 1, 19, 4);

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `cus_id` int(255) NOT NULL,
  `pro_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`cus_id`, `pro_id`) VALUES
(14, 5),
(13, 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(255) NOT NULL,
  `pro_id` int(255) NOT NULL,
  `quantity` int(255) NOT NULL DEFAULT '1',
  `cus_id` int(255) NOT NULL,
  `order_date` datetime NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(255) NOT NULL,
  `address_id` int(255) NOT NULL,
  `selected_color_id` int(255) NOT NULL,
  `selected_size_id` int(255) NOT NULL,
  `order_no` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `pro_id`, `quantity`, `cus_id`, `order_date`, `tracking_number`, `delivery_status`, `address_id`, `selected_color_id`, `selected_size_id`, `order_no`) VALUES
(1, 1, 111, 1, '2024-08-09 12:01:58', NULL, 'Order placed', 10, 1, 1, 411),
(2, 2, 1122, 1, '2024-08-09 12:01:58', NULL, 'Order placed', 10, 2, 2, 411),
(11, 11, 121, 1, '2024-08-09 12:15:25', NULL, 'Order placed', 10, 2, 2, 17),
(12, 12, 1, 1, '2024-08-09 12:15:25', NULL, 'Order placed', 10, 2, 2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `payment_method_id` int(255) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `exp_date` date NOT NULL,
  `card_no` int(255) NOT NULL,
  `cus_id` int(255) NOT NULL,
  `cvv` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pro_id` int(255) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_image` varchar(255) DEFAULT NULL,
  `pro_description` text NOT NULL,
  `price` int(255) NOT NULL,
  `discount` int(101) DEFAULT NULL,
  `cat_id` int(255) NOT NULL,
  `sub_cat_id` int(255) NOT NULL,
  `under_cat_id` int(255) NOT NULL,
  `down_cat_id` int(255) NOT NULL,
  `seller_id` int(255) NOT NULL,
  `stock_quantity` int(255) DEFAULT NULL,
  `added_time` date NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pro_id`, `pro_name`, `pro_image`, `pro_description`, `price`, `discount`, `cat_id`, `sub_cat_id`, `under_cat_id`, `down_cat_id`, `seller_id`, `stock_quantity`, `added_time`, `brand_name`) VALUES
(4, 'Hawai tshirt', NULL, 'tshist', 100, NULL, 1, 19, 1, 1, 1, 10, '2024-08-16', NULL),
(5, 'polo tshirt', NULL, 'polo', 200, NULL, 1, 19, 4, 1, 1, 20, '2024-08-16', 'adidas');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `cus_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_id` int(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `payment_method_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`cus_id`, `name`, `email`, `address_id`, `password`, `dob`, `payment_method_id`) VALUES
(13, 'Samapon Ghosh', 'samaponghosh2002@gmail.com', NULL, '25d55ad283aa400af464c76d713c07ad', NULL, NULL),
(14, '', '', NULL, '25d55ad283aa400af464c76d713c07ad', NULL, NULL),
(15, 'Samapon Ghosh', 'samaponghosh@gmail.com', NULL, '25d55ad283aa400af464c76d713c07ad', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_colors`
--

CREATE TABLE `pro_colors` (
  `pro_id` int(255) NOT NULL,
  `color_id` int(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pro_colors`
--

INSERT INTO `pro_colors` (`pro_id`, `color_id`, `color`) VALUES
(5, 4, 'Yellow'),
(5, 5, 'Green');

-- --------------------------------------------------------

--
-- Table structure for table `pro_reviews`
--

CREATE TABLE `pro_reviews` (
  `pro_id` int(255) NOT NULL,
  `review_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'Customer',
  `cus_id` int(255) NOT NULL,
  `created_at` date NOT NULL,
  `review` text,
  `rating` int(10) NOT NULL,
  `review_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pro_reviews`
--

INSERT INTO `pro_reviews` (`pro_id`, `review_id`, `name`, `cus_id`, `created_at`, `review`, `rating`, `review_image`) VALUES
(5, 14, 'Samapon Ghosh', 13, '2024-08-19', '', 1, 'review_images/sweter.jpeg'),
(5, 15, '', 14, '2024-08-19', '', 1, 'review_images/66c356410909a.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `pro_sizes`
--

CREATE TABLE `pro_sizes` (
  `pro_id` int(255) NOT NULL,
  `size_id` int(255) NOT NULL,
  `size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pro_sizes`
--

INSERT INTO `pro_sizes` (`pro_id`, `size_id`, `size`) VALUES
(5, 4, 'XL'),
(5, 5, 'XXL'),
(5, 6, 'XXL');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `sub_category` varchar(255) NOT NULL,
  `sub_cat_id` int(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cat_id` int(255) NOT NULL,
  `sub_cat_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`sub_category`, `sub_cat_id`, `image`, `cat_id`, `sub_cat_description`) VALUES
('Tshirts', 19, NULL, 1, 'These are goddam men tshirts'),
('Trousers', 20, NULL, 1, 'I bet you will not like roaming around naked from bottom. Get some nice pants.'),
('Top', 21, NULL, 2, 'You\'ll look as pretty as butterfly'),
('Handbag', 22, NULL, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `under_categories`
--

CREATE TABLE `under_categories` (
  `under_cat_id` int(255) NOT NULL,
  `under_category` varchar(255) NOT NULL,
  `cat_id` int(255) DEFAULT NULL,
  `sub_cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `under_categories`
--

INSERT INTO `under_categories` (`under_cat_id`, `under_category`, `cat_id`, `sub_cat_id`) VALUES
(4, 'Striped Tshirts', 1, 19),
(5, 'Plain tshirts', 1, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `down_categories`
--
ALTER TABLE `down_categories`
  ADD PRIMARY KEY (`down_cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `pro_colors`
--
ALTER TABLE `pro_colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `pro_reviews`
--
ALTER TABLE `pro_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `pro_sizes`
--
ALTER TABLE `pro_sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`sub_cat_id`);

--
-- Indexes for table `under_categories`
--
ALTER TABLE `under_categories`
  ADD PRIMARY KEY (`under_cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `down_categories`
--
ALTER TABLE `down_categories`
  MODIFY `down_cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `payment_method_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pro_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `cus_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pro_colors`
--
ALTER TABLE `pro_colors`
  MODIFY `color_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pro_reviews`
--
ALTER TABLE `pro_reviews`
  MODIFY `review_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pro_sizes`
--
ALTER TABLE `pro_sizes`
  MODIFY `size_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `sub_cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `under_categories`
--
ALTER TABLE `under_categories`
  MODIFY `under_cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
