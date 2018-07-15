-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2018 at 07:31 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demodb`
--

-- --------------------------------------------------------

--
-- Table structure for table `awesome`
--

CREATE TABLE `awesome` (
  `username` varchar(30) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `awesome`
--

INSERT INTO `awesome` (`username`, `comment_id`) VALUES
('anubhav', 9);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `message` varchar(400) NOT NULL,
  `time1` varchar(12) NOT NULL,
  `date1` varchar(12) NOT NULL,
  `seen` int(2) NOT NULL,
  `timestamp1` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`sender`, `receiver`, `message`, `time1`, `date1`, `seen`, `timestamp1`) VALUES
('ashish', 'anubhav', 'Hi', '04:36 pm', '08:Apr', 1, '2018-04-08 11:06:38'),
('ashish', 'anubhav', 'Sun', '04:37 pm', '08:Apr', 1, '2018-04-08 11:07:40'),
('ashish', 'anubhav', 'Hey', '04:38 pm', '08:Apr', 1, '2018-04-08 11:08:57'),
('anubhav', 'ashish', 'ky ahai', '04:40 pm', '08:Apr', 0, '2018-04-08 11:10:01'),
('ashish', 'anubhav', 'Hi', '04:45 pm', '08:Apr', 1, '2018-04-08 11:15:51'),
('ashish', 'anubhav', 'Oka', '04:47 pm', '08:Apr', 1, '2018-04-08 11:17:31'),
('ashish', 'anubhav', 'Abe oye', '04:54 pm', '08:Apr', 1, '2018-04-08 11:24:04'),
('anubhav', 'ashish', 'kya hai?', '04:54 pm', '08:Apr', 0, '2018-04-08 11:24:52'),
('ashish', 'anubhav', 'KosgueisBshevjwjdfbehbe', '04:55 pm', '08:Apr', 1, '2018-04-08 11:25:05'),
('ashish', 'anubhav', 'Pagal hai kya be', '04:55 pm', '08:Apr', 1, '2018-04-08 11:25:29'),
('anubhav', 'ashish', 'etyu', '05:00 pm', '08:Apr', 0, '2018-04-08 11:30:45'),
('anubhav', 'ajesh', 'Hey there,', '10:37 pm', '15:Jul', 1, '2018-07-15 17:07:20'),
('anubhav', 'ajesh', 'I have completed your project and uploaded all the files', '10:37 pm', '15:Jul', 1, '2018-07-15 17:07:58'),
('anubhav', 'ajesh', 'I hope you will make the payment soon :)', '10:38 pm', '15:Jul', 1, '2018-07-15 17:08:10');

-- --------------------------------------------------------

--
-- Table structure for table `circle_list`
--

CREATE TABLE `circle_list` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `creater` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circle_list`
--

INSERT INTO `circle_list` (`id`, `name`, `type`, `creater`) VALUES
(1, 'Bigdata developers', 'bigdata', 'anubhav'),
(2, 'Its\' Ethical hacking', 'Hackers', 'anubhav');

-- --------------------------------------------------------

--
-- Table structure for table `circle_mem`
--

CREATE TABLE `circle_mem` (
  `circle_id` int(11) NOT NULL,
  `member` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `circle_mem`
--

INSERT INTO `circle_mem` (`circle_id`, `member`) VALUES
(1, 'ajesh'),
(1, 'ashish'),
(1, 'rohit'),
(2, 'ajesh');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `username` varchar(30) NOT NULL,
  `discussion_id` bigint(20) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `message` varchar(400) NOT NULL,
  `code` varchar(2000) NOT NULL,
  `awesome` int(10) NOT NULL,
  `date1` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`username`, `discussion_id`, `comment_id`, `message`, `code`, `awesome`, `date1`) VALUES
('ajesh', 18, 9, 'No, it\'s perfect', '', 2, 'Jul 15 ,2018');

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `discussions` varchar(400) NOT NULL,
  `code` varchar(2000) NOT NULL,
  `circle_id` int(11) NOT NULL,
  `time1` varchar(12) NOT NULL,
  `date1` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `username`, `discussions`, `code`, `circle_id`, `time1`, `date1`) VALUES
(18, 'anubhav', 'Hello Friends , \nIs it the best way to find the prime numbers up to a limit with minimum time complexity or it can be more optimized ?', 'import math\nlists=[2]\ndef checkPrime(n):\n    isprime=1\n    for i in lists:\n        if n%i==0:\n            isprime=0\n        if i > int(math.sqrt(n)):\n            break\n    if isprime ==1:\n        lists.append(n)\n        print(n)\n\nn = int(input())\nif(n <2 ):\n    print(\"No prime numbers exist\")\nelse:\n    print(\"Prime Numbers : \")\n    print(2)\nfor i in range(3,n+1):\n    checkPrime(i)', 0, '12:40 pm', 'Jul 15,2018'),
(24, 'anubhav', 'Welcome to  Bigdata developers group', '', 1, '10:05 pm', 'Jul 15,2018');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `username` varchar(20) NOT NULL,
  `follower` varchar(20) NOT NULL,
  `talking` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`username`, `follower`, `talking`) VALUES
('anubhav', 'ajesh', 0),
('ajesh', 'anubhav', 1),
('rohit', 'anubhav', 0);

-- --------------------------------------------------------

--
-- Table structure for table `followings`
--

CREATE TABLE `followings` (
  `username` varchar(20) NOT NULL,
  `following` varchar(20) NOT NULL,
  `talking` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followings`
--

INSERT INTO `followings` (`username`, `following`, `talking`) VALUES
('ajesh', 'anubhav', 0),
('anubhav', 'ajesh', 1),
('anubhav', 'rohit', 0);

-- --------------------------------------------------------

--
-- Table structure for table `following_post`
--

CREATE TABLE `following_post` (
  `username` varchar(30) NOT NULL,
  `discussion_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `following_post`
--

INSERT INTO `following_post` (`username`, `discussion_id`) VALUES
('anubhav', 18);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `username` varchar(30) NOT NULL,
  `id` bigint(20) NOT NULL,
  `other_user` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`username`, `id`, `other_user`, `type`, `timestamp`, `seen`) VALUES
('anubhav', 21, 'ajesh', 'discussion', '2018-07-15 16:27:18', 1),
('anubhav', 22, 'ajesh', 'discussion', '2018-07-15 16:30:20', 1),
('ajesh', 23, 'anubhav', 'discussion', '2018-07-15 16:34:35', 1),
('ajesh', 24, 'anubhav', 'discussion', '2018-07-15 16:35:35', 1),
('anubhav', 2, 'ajesh', 'circle', '2018-07-15 16:41:09', 1),
('anubhav', 2, 'ajesh', 'circle', '2018-07-15 16:41:11', 1),
('anubhav', 2, 'ajesh', 'circle', '2018-07-15 16:41:15', 1),
('ajesh', 4, 'anubhav', 'project', '2018-07-15 16:49:53', 1),
('ajesh', 4, 'anubhav', 'project', '2018-07-15 16:52:05', 1),
('ajesh', 4, 'anubhav', 'project_complete', '2018-07-15 17:01:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `additional` varchar(500) DEFAULT NULL,
  `category` varchar(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `currency` varchar(15) NOT NULL,
  `postdate` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `receiver` varchar(30) NOT NULL,
  `iscompleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `username`, `title`, `description`, `additional`, `category`, `amount`, `currency`, `postdate`, `status`, `receiver`, `iscompleted`) VALUES
(4, 'ajesh', 'Design a java project ', 'I want a software for the student record keeping, that should be designed using java. It must use file handling to store the details permanently. No concept of database should be used in this.I require it to be completed this July.', 'hv', 'all', 100, 'INR', '2018-04-03', 0, 'anubhav', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `picture` varchar(40) NOT NULL DEFAULT 'default.jpg',
  `password` varchar(12) NOT NULL,
  `bio` varchar(400) NOT NULL DEFAULT 'NULL',
  `phone` bigint(12) NOT NULL DEFAULT '0',
  `country` varchar(30) NOT NULL DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `fullname`, `email`, `picture`, `password`, `bio`, `phone`, `country`) VALUES
('16bcs1011', 'Anubhav singh', 'a@gmail.com', 'default.jpg', '12345678', 'NULL', 0, 'NULL'),
('ajesh', 'Ajesh Yadav', 'ajesh@gmail.com', 'ajesh.jpg', '123456', '', 0, 'inda'),
('anubhav', 'Anubhav Singh', 'anubhav@gmail.com', 'anubhav.jpg', '12345', '', 0, 'india'),
('ashish', 'Ashish Pundir', 'ashish@gmail.com', 'default.jpg', '12345', 'NULL', 0, 'NULL'),
('dipesh', 'Dipesh Kumar', 'dipesh@gmail.com', 'default.jpg', '12345', 'NULL', 0, 'NULL'),
('rohit', 'Rohit Singh', 'ashish@gmail.com', 'rohit.jpg', '123456', 'NULL', 0, 'NULL');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `username` varchar(30) NOT NULL,
  `discussion_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`username`, `discussion_id`) VALUES
('anubhav', 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `circle_list`
--
ALTER TABLE `circle_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `circle_list`
--
ALTER TABLE `circle_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
