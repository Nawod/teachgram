-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2020 at 11:09 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teachgram`
--

-- --------------------------------------------------------

--
-- Table structure for table `5_magicpoison_details`
--

CREATE TABLE `5_magicpoison_details` (
  `class_user_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `5_magicpoison_details`
--

INSERT INTO `5_magicpoison_details` (`class_user_id`, `std_id`) VALUES
(1, 5),
(3, 7),
(4, 4),
(5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `5_magicpoison_msgs`
--

CREATE TABLE `5_magicpoison_msgs` (
  `msg_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `messages` varchar(40000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `5_magicpoison_msgs`
--

INSERT INTO `5_magicpoison_msgs` (`msg_id`, `sender_id`, `messages`, `time`) VALUES
(1, 4, 'TFc3IEZyS8yyzJoIASxl/clJYlMGmfOhRJy25qXafuUGVPks3SfA7ZNYvVhEPPJhnyOPi+Re5a4x722gNHZK8g==?wg1LZooT/KYQgbixLLedeKBl/la5ewd+TMDszCo9E13owJ+cx52pDDzNiMOaAoBm', '2020-04-26 15:44:51'),
(2, 7, 'HtZor8LVJnWQXmYGGXIBuuUaTlmxnzc665tRE3SvbnzA0T8DtOH0SC0+nuIxCPX8cXb9my9dtoVkkM+btgeRIA==?MyO1aHP89fsoCMcBaji8rd41k97Ee1KGAwT76sKeOGg=', '2020-04-26 15:50:29'),
(3, 4, 'DQuhzyupxbnCwDQps9BvJlVgZlj0zVimzcnThgEOxdyrppGoMUQnM2Y4YIZwlUYcIc51rEu4LuwdtsZJ9oY/Yw==?Ke1OliDSublW4kZE0eqocSDzV4xZ9hr67fZ8PBu1kko=', '2020-04-26 15:50:58'),
(4, 7, 'QlGDjtlkeUn8DDvZy5qKAn31syH837Nse7FgwpOawlSPzoZDxMt985fGLJLJFJRc6OF74JWFM3L9JT/cQA9RWQ==?tWKHklVf3SxJBXYdUcAuYEz1GjDjqDXV0C3q9WXVWms=', '2020-04-26 15:51:15'),
(5, 4, 'nKwaRE2z5J6KqFdZSIQACE7ZAwvEjDJYFrJUtNCwt/Y9gukjpBPZdmmY58DZJbGDdjrRPMnM4RT0mSo3UVVtHQ==?mT7jqK5Wwpq9MRJhhY2Pz4I2mXvF2lZXlGVpgXtbSX4=', '2020-04-26 16:00:44'),
(6, 7, 'LHnflVP8sg+Ra+XwGee8OCrUoP0iYEwhb2kbYcWcWL66gEZa4zg9/yOHFp5sNrCDRXM4PBtDoPHyiNq0MvuPNw==?o/kWHI+6kIHeI1E16pf6NDvzXs6A3aoGUKIVzgiAgSko4w7CVE0wJABZfFVYkpnc', '2020-04-26 17:42:45'),
(7, 5, 'GgibYw+DsPWXXOkD+FNhhOF5IE34fkvD/3g/Y0uz6guML/QLZ6+OFkabdjptTQC3wGgwMysYgZhW96DWUK0KlA==?rfCK2V1GPt3EpYg3ZObVA2pMXn9pMjjVaf4E/7LtDYPx5ab+8yvbexfo3DgRkUEN', '2020-04-26 17:43:22'),
(10, 8, 'AoeqqP6o7JZL8qx/g0K4HEcnOEfpdSReTOg9Trh42oov7dPZPPzWrIKKLLEGMPLjgpfWwUbspyzmPqMhCNI0DQ==?966cNr8KWVFfupK1hJdyfzkXzPP7CIpRDwyU6bD1WGF39nLk4l1axgDGJbZ7s3Qe', '2020-04-29 19:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `5_php_class_details`
--

CREATE TABLE `5_php_class_details` (
  `class_user_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `5_php_class_details`
--

INSERT INTO `5_php_class_details` (`class_user_id`, `std_id`) VALUES
(1, 5),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `5_php_class_msgs`
--

CREATE TABLE `5_php_class_msgs` (
  `msg_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `messages` varchar(40000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `5_qudich_details`
--

CREATE TABLE `5_qudich_details` (
  `class_user_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `5_qudich_details`
--

INSERT INTO `5_qudich_details` (`class_user_id`, `std_id`) VALUES
(1, 5),
(3, 4),
(4, 6),
(5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `5_qudich_msgs`
--

CREATE TABLE `5_qudich_msgs` (
  `msg_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `messages` varchar(40000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `5_qudich_msgs`
--

INSERT INTO `5_qudich_msgs` (`msg_id`, `sender_id`, `messages`, `time`) VALUES
(2, 5, 'XO1oy7tOQ6GhwgXiKcjK0etGYwu6U6aOVL8FsBiPDWBWgUDMjldkuqC8v7iyjovgBDeI0mNABhPLZFCgkeZgtw==?BJzxIEq4nv0ttZZMULpLB0qD3khguFstOjtDJvUBpvY=', '0000-00-00 00:00:00'),
(4, 4, 'dyAK3+YWA0g0UK4/A4T19bwsERVhdK0ElEHLKkNxtlQiz3zzY86nuSRWG2w0HnVn/erR8Ce/THzxBilkoXd6LQ==?iwojOs6hhpsYJlw3QBzRAVENmMjwpWqoUCFalPJ4XME=', '2020-04-26 10:32:00'),
(5, 5, 'Phu8hRJpqj3So0hYSgIR39Bcy5fnPzGNn8Th8jp3cc4lomCyV8P9L+/QD0d+moqyYkNmdElf0JG9cuGOpab5kg==?4lYsZAnKjquBl9MHbcycD7LwjiUkjf2VRsE4BGQ3OtQ=', '2020-04-26 11:32:37'),
(6, 4, 'efQ9na4KJBM49xrsGJ0wSCTGzfZwu2pZRKEoObyiZyTbshW85pjtZbycRcJcjtwZVTqRp1JkTXwU3S6auxnqsg==?CfaYniUTtue7FsY0blYfvIS9weNkW3KqG4qb37IsaDo=', '2020-04-26 11:32:52'),
(8, 6, 'RsX60HAH0jafCEscNsXHySwjYV9vzMdFBLFGJCsPAbtg7Zn5yPukoh1s5AMgHBSfE9c9p8P3piMQIdxAv+jSLg==?Ld0lCl7/f0ca6weC4qEHLjFgaXvU1UxzeiMAPGk4J3I=', '2020-04-26 11:58:48'),
(9, 7, 'bIi/MKsSUkIuLBYwuk5Ry7KeMMVqyAm8odto5CjG+mnuJya4/y0cyvcz/yLQhbI+QzBFmruItqnAOjJRmaelBg==?OAxnfzo8Ecc2fH+256f844jC0UU3JipmWfdWPqJZR/0=', '2020-04-26 11:59:50'),
(10, 4, 'AcmSfrl+1BVVLRvGf3VIGlt/TEOeo7eVAYerfJh5JWC2UCc61HQ+fzLXy6bDiaRANt9AntKnDH0FNvxABM3YbQ==?uYW3MaTAeQ/QARDgS2SHmrBAEVu6olXG3d6gVcLxDzU=', '2020-04-26 15:33:02'),
(11, 7, 'Fg06XcweXU752nyPgMRDNXbN+Q3etE9nPAjEsrT/aTX0oCkVJHx+L55gfLzlTzOefJN+DD8fHWFCeMDE3Zqi+Q==?7u100egI4pMwvzRJCWIBCqCBrwGvHs/AJWruofgn1ZvK0hSTKU5c4k9jjtl7HLwO', '2020-04-26 15:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `7_network_security_details`
--

CREATE TABLE `7_network_security_details` (
  `class_user_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `7_network_security_details`
--

INSERT INTO `7_network_security_details` (`class_user_id`, `std_id`) VALUES
(1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `7_network_security_msgs`
--

CREATE TABLE `7_network_security_msgs` (
  `msg_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `messages` varchar(40000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `7_securesoftwaresystem_details`
--

CREATE TABLE `7_securesoftwaresystem_details` (
  `class_user_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `7_securesoftwaresystem_details`
--

INSERT INTO `7_securesoftwaresystem_details` (`class_user_id`, `std_id`) VALUES
(1, 7),
(7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `7_securesoftwaresystem_msgs`
--

CREATE TABLE `7_securesoftwaresystem_msgs` (
  `msg_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `messages` varchar(40000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `7_web_development_details`
--

CREATE TABLE `7_web_development_details` (
  `class_user_id` int(11) NOT NULL,
  `std_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `7_web_development_details`
--

INSERT INTO `7_web_development_details` (`class_user_id`, `std_id`) VALUES
(1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `7_web_development_msgs`
--

CREATE TABLE `7_web_development_msgs` (
  `msg_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `messages` varchar(40000) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `recv_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sent_msg` varchar(30000) NOT NULL,
  `recv_msg` varchar(30000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `recv_id`, `sender_id`, `sent_msg`, `recv_msg`, `timestamp`, `status`) VALUES
(72, 6, 5, 'AwA6r8FeuGhrN7Kp+clViVFmHysdjsLZB9TGT9CT36g2jAOTVTjpKi4FtLwvauGSRv1RojgQo5NUHJTDOi6ZmQ==?tsn5drjJEAq/KoxseRGXXAlaw7TqyqAy65FGKT6NVeI=', 'QvBSe175iaflyGHqRvjaCcfqLhysZm6VJo/FfxLY4XIufKA3gTdIUBiriYtqnDIk/bxWB5XLY0ra+N5qzFj7cw==?iJZCa4W1EzfmbL6eN8/oriBS9VOeOWMNdeorPP7t9+E=', '2020-04-21 16:58:09', 0),
(73, 5, 6, 'Ex7hXuDWrhMEV/mEFpOqCHH67Uk/NOx8cvnXdjJyDmSnrwE8yVRwE+YQhojHYVhbuTtH4RBUKdA1S+vqz3EUFQ==?vQJMkvOVQFHmkUYw8gSwSCZ2G20suNOAMM4IzbST4Tk=', 'fH+SI1+ljrdoxnMKBJsXF80mcBb7FeCJb+7hF4zdoPJzBDe+vSnIklSW3S7e5njL2p1cymeip0oHG+w/muEgVQ==?CQUCQQUQvc00WZXMPSBSYFiTT26haAZl7ePM7tFuTP8=', '2020-04-21 16:58:37', 0),
(74, 6, 5, 'JzITHgxtH0TW6lRqWJ4yTsnHH1yuktJZ0GPqNl3eZxa/7YMKx/vzu7XfhhKMN4GVklK2Y1uJTBzaTEhAg8wnnQ==?oj4GpTwTiIAwzoAj4eSmyRXhkhU9UnYf360pqVMJJ+M=', 'Ts2tcjrNsz60G+boJdnoZLoDlve+5P4WAv1mYU9Bw7qdCek30CzZZBIFnngmeKHtNqI/OSwnt09c7axYmpjTgQ==?9IdLylPPLjdpj8xHZccwxR7C04sbmfc5PWk86Ejgd0o=', '2020-04-21 16:59:43', 0),
(75, 6, 5, 'LkyUV5R8eYsvmzmM8nxH1QEhXnKa+FpmEfXF8J6U/CHQ3wCmJE565JmJGyq0cXhXg5sEbtSDWXH4u4E7oYYxkA==?c1IBcxtEcUswkVLdFtGqcLu6yVyhYXrgeEeXfEm6MfI=', 'bSVbMcuFtcBvWbZXyH/BexrZ+KLfDrGIh+pw5ct2qTxs9xitra1HWcKEW8yGz5wEfC6AbF0hq9NpUZ9vNAMrgw==?9l4VUL7uWD64bS4XQNteTyIAy8Ur0d5hJayleoZ6FRg=', '2020-04-21 17:13:29', 0),
(76, 5, 6, 'TScU1D9z8SKbI1U54hI26SGGhP5VqnFln0w0zDKxOyEbS5CvyrNKRm/Zfx9FpD0oGE0+mP+Bmewrdz0Ze9NgyA==?3OO8DpoCfbD4WnljlBCdb32TZ1KcalVuoZ9oYUKLZpY=', 'ZDVnVIQPHCqOBkqY8h5WOw/m3k8E7vaOHphMw/6OoQ+GvWEU3t70v+5C104IXbFBV7Pldt1nKd4pIv8mP7POAQ==?USS+GAlQYsrBdwfCsyOPpwLBlHrKDfhZcTLGCOK56Xc=', '2020-04-21 17:14:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `class_details`
--

CREATE TABLE `class_details` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(250) NOT NULL,
  `creater_id` int(11) NOT NULL,
  `enrollment_key` varchar(250) NOT NULL,
  `class_pbk` varchar(10000) NOT NULL,
  `status` int(11) NOT NULL,
  `add_std` int(11) NOT NULL,
  `class_dp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_details`
--

INSERT INTO `class_details` (`class_id`, `class_name`, `creater_id`, `enrollment_key`, `class_pbk`, `status`, `add_std`, `class_dp`) VALUES
(1, 'SecureSoftwareSystem', 7, 'sss2020', 'h98rrpGiSjyM9v2J6ygEtoJXovRmIletmQFl+6AfR7BiKp3P0FOsU7Sj/BGOpovb3yy0fdziF87lJiEtmvAzMw==', 1, 0, ''),
(2, 'MagicPoison', 5, 'mp_2020', 'oUTPuyzXhntfJKy0kJiNUfbPkrb1kgmkgc7ogCLvx2H05/kCd3bgTnrmYTkjJnZ3wQgwemEdyXTf6d6AtqI+Hw==', 1, 0, ''),
(3, 'Qudich', 5, 'qd_1234', 'fPdlTniw415gD6yNJn35qwEsXHu20yPfGnROHsqLeyoej0zFwsI4nGbf1Vqx/vw5ASiK9Sx9/4vDiY5jxcp4Kw==', 1, 0, ''),
(4, 'web_development', 7, 'wd1234', 'boGUjTfeh1OApvL4WU4eYUjO9bFRS9ciugkQu4frfTXWmzGNtdELU9G2gXYebBD8pN63YR0TnuiDoDCT+X+wcQ==', 1, 0, ''),
(5, 'php_class', 5, 'php_123', '3n1xlfCFoxsHWCaYswhJvDSRKj1BMoDS9I29nd5n4F/wWFvO9lnYcnyJ6VZN02glYYoDQEbuX6t/qCcNNKBJGw==', 1, 0, ''),
(6, 'Network_Security', 7, 'ns_2222', 'h51iYmycPRd2A92VvPp0JImmRGXtSk0QHhUBysxP7qVV0WyIAfy3Me8XnHgD6AbSLdgxYMtohdmTVMkvE3luOQ==', 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Profile_Picture` varchar(500) NOT NULL,
  `activation_code` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `public_key` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `first_name`, `last_name`, `email`, `user_type`, `password`, `Profile_Picture`, `activation_code`, `status`, `public_key`) VALUES
(4, 'Nawod', 'Madhuvantha', 'nawod@gmail.com', 'Student', '2dbd269dd7d0a67538aae6dda53d29f8', 'Different-Types-of-Software-Testing.png', 'aeafd578038e4e009b5a743187949117', 1, 'pYZ49PBTIbrIX3s0UlQ/gxOP4NUMUGCCJkAJHMTnSeP0BiS984pSK5EkKCqd73jTvVCghJCzn0ceiMWw/rHgeQ=='),
(5, 'Albus', 'Dumbledore ', 'albus@gmail.com', 'Teacher', 'cab26858e261da0508783d5e14788d8a', '95e38f62008f2b51e827061f6ef5d945_library-of-sinhala-and-tamil-new-year-games-banner-royalty-free-_315-400.gif', '3f8fffd364e8a11fdfe41afdf0393693', 1, 'gpUksVha5JSZWzthwfpUeSw9npCapRsoVu4VlFMgUJSz+LpbvUmicKj6TH6iYWZuOhPz58kpVIDGcbb/cFsfIQ=='),
(6, 'Alexander ', 'Grahambell', 'alex@gmail.com', 'Student', 'c539c3403f67199091f3b8207cbcfa0c', 'd2682763168473.5aa85b275dbff.jpg', '9d306b81cf5fba489a1a06a85d7b97c3', 1, 'cx3TXKKukrHDECGhwCy+4Mbw7rbYndrpDGeRhi5qaMdlAVRvdvEy+osMIXK8Zn/Gf2FjGKqL2FysvuNwJJ1Elw=='),
(7, 'David', 'Rathnayake', 'david@gmail.com', 'Teacher', 'd2b2f3b1be7eeab4bf927b1606f7dbdc', '', '72d4a6ec3141cb4a21a80c679bd9eb27', 1, 'nsgNjSW/w6lghdl9njDMNqxKFyG0yP9c3uPODrASrs+kHMUNDwex7p307eDdT8oOaCDno/bKMzmcTCc6GP19ew=='),
(8, 'Tony', 'Stark', 'tony@gmail.com', 'Student', 'c108b40a7a16af3f321320177b84eefe', 'OIP.jpg', '31ff9cefaeeac0e95c1284d0dab28e7a', 1, 'dN3DBJdu+pc0+sA8JW4bQkpyT05nfxR6DQ+K3cdp61Pteu2lrKhUFIeqtqtEXaY2r6fACYcQQBJgDdxDzPMXEQ==');

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 4, '2020-04-26 16:10:38', 'no'),
(3, 5, '2020-04-29 20:42:41', 'no'),
(4, 6, '2020-04-28 21:51:20', 'no'),
(5, 7, '0000-00-00 00:00:00', 'no'),
(6, 8, '0000-00-00 00:00:00', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `user_4`
--

CREATE TABLE `user_4` (
  `en_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_4`
--

INSERT INTO `user_4` (`en_id`, `class_id`) VALUES
(2, 3),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_5`
--

CREATE TABLE `user_5` (
  `en_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_5`
--

INSERT INTO `user_5` (`en_id`, `class_id`) VALUES
(1, 2),
(2, 1),
(3, 3),
(4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_6`
--

CREATE TABLE `user_6` (
  `en_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_6`
--

INSERT INTO `user_6` (`en_id`, `class_id`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_7`
--

CREATE TABLE `user_7` (
  `en_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_7`
--

INSERT INTO `user_7` (`en_id`, `class_id`) VALUES
(1, 1),
(8, 2),
(9, 4),
(10, 3),
(11, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_8`
--

CREATE TABLE `user_8` (
  `en_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_8`
--

INSERT INTO `user_8` (`en_id`, `class_id`) VALUES
(1, 2),
(2, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `5_magicpoison_details`
--
ALTER TABLE `5_magicpoison_details`
  ADD PRIMARY KEY (`class_user_id`);

--
-- Indexes for table `5_magicpoison_msgs`
--
ALTER TABLE `5_magicpoison_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `5_php_class_details`
--
ALTER TABLE `5_php_class_details`
  ADD PRIMARY KEY (`class_user_id`);

--
-- Indexes for table `5_php_class_msgs`
--
ALTER TABLE `5_php_class_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `5_qudich_details`
--
ALTER TABLE `5_qudich_details`
  ADD PRIMARY KEY (`class_user_id`);

--
-- Indexes for table `5_qudich_msgs`
--
ALTER TABLE `5_qudich_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `7_network_security_details`
--
ALTER TABLE `7_network_security_details`
  ADD PRIMARY KEY (`class_user_id`);

--
-- Indexes for table `7_network_security_msgs`
--
ALTER TABLE `7_network_security_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `7_securesoftwaresystem_details`
--
ALTER TABLE `7_securesoftwaresystem_details`
  ADD PRIMARY KEY (`class_user_id`);

--
-- Indexes for table `7_securesoftwaresystem_msgs`
--
ALTER TABLE `7_securesoftwaresystem_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `7_web_development_details`
--
ALTER TABLE `7_web_development_details`
  ADD PRIMARY KEY (`class_user_id`);

--
-- Indexes for table `7_web_development_msgs`
--
ALTER TABLE `7_web_development_msgs`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `class_details`
--
ALTER TABLE `class_details`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Indexes for table `user_4`
--
ALTER TABLE `user_4`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `user_5`
--
ALTER TABLE `user_5`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `user_6`
--
ALTER TABLE `user_6`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `user_7`
--
ALTER TABLE `user_7`
  ADD PRIMARY KEY (`en_id`);

--
-- Indexes for table `user_8`
--
ALTER TABLE `user_8`
  ADD PRIMARY KEY (`en_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `5_magicpoison_details`
--
ALTER TABLE `5_magicpoison_details`
  MODIFY `class_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `5_magicpoison_msgs`
--
ALTER TABLE `5_magicpoison_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `5_php_class_details`
--
ALTER TABLE `5_php_class_details`
  MODIFY `class_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `5_php_class_msgs`
--
ALTER TABLE `5_php_class_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `5_qudich_details`
--
ALTER TABLE `5_qudich_details`
  MODIFY `class_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `5_qudich_msgs`
--
ALTER TABLE `5_qudich_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `7_network_security_details`
--
ALTER TABLE `7_network_security_details`
  MODIFY `class_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `7_network_security_msgs`
--
ALTER TABLE `7_network_security_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `7_securesoftwaresystem_details`
--
ALTER TABLE `7_securesoftwaresystem_details`
  MODIFY `class_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `7_securesoftwaresystem_msgs`
--
ALTER TABLE `7_securesoftwaresystem_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `7_web_development_details`
--
ALTER TABLE `7_web_development_details`
  MODIFY `class_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `7_web_development_msgs`
--
ALTER TABLE `7_web_development_msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `class_details`
--
ALTER TABLE `class_details`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_4`
--
ALTER TABLE `user_4`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_5`
--
ALTER TABLE `user_5`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_6`
--
ALTER TABLE `user_6`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_7`
--
ALTER TABLE `user_7`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_8`
--
ALTER TABLE `user_8`
  MODIFY `en_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
