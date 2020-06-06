-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2020 at 11:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fighters`
--

-- --------------------------------------------------------

--
-- Table structure for table `fighters`
--

CREATE TABLE `fighters` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `info` varchar(256) DEFAULT NULL,
  `wins` int(11) DEFAULT NULL,
  `loss` int(11) DEFAULT NULL,
  `path` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fighters`
--

INSERT INTO `fighters` (`id`, `name`, `age`, `info`, `wins`, `loss`, `path`) VALUES
(11, 'Caterson CatSpyder Silva', 5, 'Slim, broke leg in past years', 37, 16, 'img/cat02.png'),
(12, 'Firko Cro Cat', 5, 'Past his prime, doing seminars', 50, 20, 'img/cat03.png'),
(13, 'Catbib Furwmagomedov', 2, 'Current champion, wrestle and catmbo is his style', 34, 3, 'img/cat04.png'),
(14, 'Kit Kitty Kones', 3, 'Bad kitty, loves to use dog food better strength', 29, 2, 'img/cat05.png'),
(15, 'Coy BigCat Meowson', 5, 'Big kitty, loves to fight', 25, 25, 'img/cat06.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fighters`
--
ALTER TABLE `fighters`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
