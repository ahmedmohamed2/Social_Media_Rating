-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2022 at 02:19 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_media_rating`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_agents`
--

CREATE TABLE `app_agents` (
  `agent_id` int(11) NOT NULL,
  `agent_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_rating`
--

CREATE TABLE `app_rating` (
  `rating_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(100) NOT NULL,
  `agent_rate` int(1) NOT NULL,
  `company_nomination` int(1) NOT NULL,
  `customer_comment` text NOT NULL,
  `rating_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `task_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_tasks`
--

CREATE TABLE `app_tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_tasks`
--

INSERT INTO `app_tasks` (`task_id`, `task_name`) VALUES
(2, 'تليجرام'),
(3, 'فيس بوك'),
(1, 'واتس اب');

-- --------------------------------------------------------

--
-- Table structure for table `app_tasks_agents`
--

CREATE TABLE `app_tasks_agents` (
  `task_agent_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `task_started_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_rank` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`user_id`, `user_name`, `user_password`, `user_rank`) VALUES
(1, 'admin', '$2y$10$oSj3Fvb6n6XtdrwEzhX6Puv6gTNhW4QXd/Pe.7z1Ie5DF30REXKO6', 1),
(2, 'agent', '$2y$10$3cHie6MqAu1Uk3UfQOVhAe36ud3mnPSAKoBH7c0wlzxTperZzWuAe', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_agents`
--
ALTER TABLE `app_agents`
  ADD PRIMARY KEY (`agent_id`),
  ADD UNIQUE KEY `user_name` (`agent_name`);

--
-- Indexes for table `app_rating`
--
ALTER TABLE `app_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `task_relation_review` (`task_id`),
  ADD KEY `user_relation_review` (`agent_id`);

--
-- Indexes for table `app_tasks`
--
ALTER TABLE `app_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `task_name` (`task_name`);

--
-- Indexes for table `app_tasks_agents`
--
ALTER TABLE `app_tasks_agents`
  ADD PRIMARY KEY (`task_agent_id`),
  ADD KEY `task_relation` (`task_id`),
  ADD KEY `user_relation` (`agent_id`);

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_agents`
--
ALTER TABLE `app_agents`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `app_rating`
--
ALTER TABLE `app_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_tasks`
--
ALTER TABLE `app_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_tasks_agents`
--
ALTER TABLE `app_tasks_agents`
  MODIFY `task_agent_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_rating`
--
ALTER TABLE `app_rating`
  ADD CONSTRAINT `task_relation_review` FOREIGN KEY (`task_id`) REFERENCES `app_tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_relation_review` FOREIGN KEY (`agent_id`) REFERENCES `app_agents` (`agent_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_tasks_agents`
--
ALTER TABLE `app_tasks_agents`
  ADD CONSTRAINT `task_relation` FOREIGN KEY (`task_id`) REFERENCES `app_tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_relation` FOREIGN KEY (`agent_id`) REFERENCES `app_agents` (`agent_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
