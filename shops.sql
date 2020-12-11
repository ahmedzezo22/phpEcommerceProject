-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2020 at 06:09 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shops`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `ordering` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `allow_Comments` tinyint(4) NOT NULL DEFAULT '0',
  `allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `parent`, `ordering`, `visibility`, `allow_Comments`, `allow_Ads`) VALUES
(1, 'Hand Made', 'Hand made items', 0, '1', 1, 1, 1),
(2, 'Computers', 'computers', 0, '2', 0, 0, 0),
(3, 'Cell Phone', 'Cell Phone', 0, '3', 0, 0, 0),
(4, 'Clothes and fashion', 'Clothes and fashion', 0, '4', 0, 0, 0),
(5, 'Home Tools', 'Home Tools', 0, '5', 0, 0, 0),
(7, 'Nokia', 'good phone with good cell', 5, '6', 0, 0, 0),
(9, 'redmi', 'good mobile phone', 3, '1', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT '0',
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `name`, `description`, `price`, `date`, `country_made`, `image`, `status`, `rating`, `approve`, `cat_id`, `member_id`, `tags`) VALUES
(27, 'iphone 6', 'good mobile with high quality', '100', '2020-10-25', 'america', '486084_yalla636046278galaxy-s8.jpg', '1', 0, 1, 3, 1, 'good,cheap'),
(28, 't-shirt', 'good t-shirt', '50', '2020-10-25', 'Egypt', '556702_Image_Guide_Clothes_3a.jpg', '1', 0, 1, 4, 1, 'good,cheap'),
(29, 'model ', 'model for women', '100', '2020-10-25', 'america', '697418_Image_Guide_Clothes_6a.jpg', '1', 0, 1, 4, 1, 'cheap,fantastic'),
(31, 'sweet-shirt', 'sweet-chirt for winter', '50', '2020-10-25', 'Egypt', '691467_Image_Guide_Clothes_8a.jpg', '1', 0, 1, 4, 1, 'cheap,good'),
(33, 'good dress for woman', 'dress for romantic woman', '100', '2020-10-25', 'Egypt', '420257_best-summer-clothing-amazon-287587-1591289885036-promo.700x0c.jpg', '1', 0, 1, 4, 1, 'fantastic,cheap'),
(36, 'good dress', 'dress with high quality', '200$', '2020-10-25', 'Egypt', '35644_51vaSXnVAAL._AC_UX385_.jpg', '1', 0, 1, 4, 9, 'cheap,good'),
(37, 'jacket', '2016-New-Thick-Hooded-Winter-Coat-Men-Fashion-Slim-Men-Jacket-Winter-Good-Quality-Warm-Men', '100', '2020-10-26', 'america', '955719_jacket.jpg', '1', 0, 1, 4, 1, 'highquality,good'),
(38, 'laptop', 'laptop with high qulaity', '1000', '2020-10-26', 'china', '259613_2.jpg', '2', 0, 1, 2, 1, 'cheap,highquality'),
(40, 'apple laptop', 'The iMac \"Core i5\" 2.7 21.5-Inch Aluminum (Late 2013/Haswell) features a 22 nm Quad Core 2.7 GHz Intel \"Core i5\" (4570R) ...', '4000$', '2020-10-26', 'america', '51_71pheYd9W0L._AC_SX466_.jpg', '1', 0, 1, 2, 14, 'cheap,highquality'),
(41, 'Dell laptop', 'Dell Inspiron 15 7567 Laptop: Core i5-7300HQ, 256GB SSD, 8GB RAM, GTX 1050Ti, 15.6inch Full HD Display:', '2000', '2020-10-26', 'Hind', '588776_images.jpg', '1', 0, 1, 2, 14, 'cheap,highquality'),
(42, 'vivo mobile phone', 'The company has launched the smartphon vivo mobile with high quality', '500$', '2020-10-26', 'Egypt', '35_73078527.jpg', '1', 0, 1, 3, 14, 'cheap,highquality'),
(43, 'oppo f11 mobile', 'good phone with 64 Gb and hgh quality camera', '200$', '2020-10-26', 'korea', '22_133188-v4-oppo-f11-mobile-phone-large-1.jpg', '1', 0, 1, 3, 13, 'cheap,highquality'),
(44, 'Xiomai MI A3', 'is the company’s third-generation Android One phone. It runs on stock Android operating system out-of-the-box', '200', '2020-10-26', 'vitnam', '627686_imgggg.jpg', '1', 0, 1, 3, 14, 'cheap,highquality'),
(45, 'tools and equipment ', 'tools and equipment for home use', '100', '2020-10-26', 'vitnam', '569641_download.jpg', '1', 0, 1, 5, 14, 'cheap,highquality,good'),
(50, 'shoes for woman', 'beautiful', '100$', '2020-10-29', 'Egypt', '94_shoes.jpg', '1', 0, 1, 4, 9, 'cheap,highquality');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `groupID` int(11) NOT NULL DEFAULT '0',
  `registerStatus` int(11) NOT NULL DEFAULT '0',
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `email`, `fullName`, `date`, `groupID`, `registerStatus`, `images`) VALUES
(1, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmedelmajek2000@gmail.com', 'ahmed', '2020-10-06', 1, 1, ''),
(9, 'may1', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'may@gmail.com', 'mayHelmy1', '2020-10-05', 0, 1, ''),
(12, 'ali', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ali@gmail.com', 'ali', '2020-10-21', 0, 1, '534363_20170524_005353.jpg'),
(13, 'laila', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ali@gmail.com', 'lailalail', '2020-10-21', 0, 1, '91888_12417988_1707627856180539_5425474747523873808_n.jpg'),
(14, 'mayada', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mayada@m.com', 'mayada', '2020-10-23', 0, 1, '204345_1935307_981626148577328_479613392171342153_n.jpg'),
(15, 'noura', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nour@noura.com', 'noura', '2020-10-25', 0, 1, '589417_10458008_664071080347296_3660971889424613089_n.jpg'),
(16, 'farah mohamed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'farah@gmail.com', 'faraj', '2020-11-13', 0, 1, '563965_577634_449691658451907_161767868_n.jpg'),
(17, 'israa ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'israa@gmail.com', 'israa', '2020-11-13', 0, 1, '514008_408545_455700877850985_963484968_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `item_co` (`item_id`),
  ADD KEY `user_co` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `member_1` (`member_id`),
  ADD KEY `cat_1` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `item_co` FOREIGN KEY (`item_id`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_co` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`cat_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`member_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
