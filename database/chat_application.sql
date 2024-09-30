-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Sep 30, 2024 at 04:02 PM
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
-- Database: `chat_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `userid`, `msg`, `createdOn`) VALUES
(1, 1, 'Hello everyone!', '2024-09-01 08:20:00'),
(2, 2, 'Good morning!', '2024-09-01 09:35:00'),
(3, 3, 'How are you all?', '2024-09-01 10:50:00'),
(4, 4, 'I am excited to join this chatroom.', '2024-09-01 11:05:00'),
(5, 5, 'Does anyone need help with the project?', '2024-09-01 12:35:00'),
(6, 6, 'I am working on a new web app.', '2024-09-01 13:50:00'),
(7, 7, 'The meeting is at 2 PM.', '2024-09-01 14:05:00'),
(8, 8, 'Please check your emails for updates.', '2024-09-01 15:20:00'),
(9, 9, 'What is the deadline for the submission?', '2024-09-01 16:35:00'),
(10, 10, 'Great to be a part of this team!', '2024-09-01 17:50:00'),
(11, 11, 'I will send the files shortly.', '2024-09-01 18:05:00'),
(12, 12, 'Looking forward to collaborating with everyone.', '2024-09-01 19:20:00'),
(13, 13, 'I need assistance with the database.', '2024-09-01 20:35:00'),
(14, 14, 'Can we schedule a call?', '2024-09-01 21:50:00'),
(15, 15, 'I have uploaded the documents.', '2024-09-01 22:05:00'),
(16, 16, 'Thank you for the support!', '2024-09-01 23:20:00'),
(17, 17, 'I will review the code tonight.', '2024-09-01 23:50:00'),
(18, 18, 'Let’s finalize the design by tomorrow.', '2024-09-02 00:35:00'),
(19, 19, 'Can someone share the presentation slides?', '2024-09-02 01:50:00'),
(20, 20, 'I appreciate all your efforts.', '2024-09-02 02:20:00'),
(67, 7, 'Hi ', '2024-09-17 14:43:29'),
(68, 3, 'Hi bilal', '2024-09-17 14:44:55'),
(69, 7, 'Hi hassan', '2024-09-17 14:45:01'),
(70, 7, 'how are you', '2024-09-17 14:45:06'),
(71, 6, 'Hi bilal', '2024-09-17 14:46:39'),
(72, 7, 'hi ayesha', '2024-09-17 14:46:59'),
(73, 13, 'Hi ayesha', '2024-09-17 14:47:43'),
(74, 6, 'How are you', '2024-09-17 14:48:14'),
(75, 13, 'i\'m good', '2024-09-17 14:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `login_status` tinyint(4) NOT NULL DEFAULT 0,
  `last_login` datetime NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `login_status`, `last_login`, `created_on`) VALUES
(1, 'Ali Khan', 'ali.khan@example.com', 0, '2024-09-01 08:15:00', '2024-08-31 10:00:00'),
(2, 'Fatima Noor', 'fatima.noor@example.com', 0, '2024-09-01 09:30:00', '2024-08-31 11:00:00'),
(3, 'Hassan Ahmed', 'hassan.ahmed@example.com', 0, '2024-09-17 14:45:17', '2024-08-31 12:00:00'),
(4, 'Sara Malik', 'sara.malik@example.com', 0, '2024-09-01 11:00:00', '2024-08-31 13:00:00'),
(5, 'Ahmed Raza', 'ahmed.raza@example.com', 0, '2024-09-01 12:30:00', '2024-08-31 14:00:00'),
(6, 'Ayesha Tariq', 'ayesha.tariq@example.com', 1, '2024-09-17 02:46:27', '2024-08-31 15:00:00'),
(7, 'Bilal Sheikh', 'bilal.sheikh@example.com', 0, '2024-09-17 14:47:23', '2024-08-31 16:00:00'),
(8, 'Zainab Iqbal', 'zainab.iqbal@example.com', 0, '2024-09-01 15:15:00', '2024-08-31 17:00:00'),
(9, 'Hamza Javed', 'hamza.javed@example.com', 0, '2024-09-01 16:30:00', '2024-08-31 18:00:00'),
(10, 'Maryam Ali', 'maryam.ali@example.com', 0, '2024-09-01 17:45:00', '2024-08-31 19:00:00'),
(11, 'Imran Hussain', 'imran.hussain@example.com', 0, '2024-09-01 18:00:00', '2024-08-31 20:00:00'),
(12, 'Sana Riaz', 'sana.riaz@example.com', 0, '2024-09-01 19:15:00', '2024-08-31 21:00:00'),
(13, 'Usman Farooq', 'usman.farooq@example.com', 1, '2024-09-17 02:47:29', '2024-08-31 22:00:00'),
(14, 'Rabia Yousaf', 'rabia.yousaf@example.com', 0, '2024-09-01 21:45:00', '2024-08-31 23:00:00'),
(15, 'Kamran Qadir', 'kamran.qadir@example.com', 0, '2024-09-01 22:00:00', '2024-09-01 00:00:00'),
(16, 'Nida Ahmed', 'nida.ahmed@example.com', 0, '2024-09-01 23:15:00', '2024-09-01 01:00:00'),
(17, 'Shahbaz Aslam', 'shahbaz.aslam@example.com', 0, '2024-09-01 23:45:00', '2024-09-01 02:00:00'),
(18, 'Kiran Bashir', 'kiran.bashir@example.com', 0, '2024-09-02 00:30:00', '2024-09-01 03:00:00'),
(19, 'Farhan Khan', 'farhan.khan@example.com', 0, '2024-09-02 01:45:00', '2024-09-01 04:00:00'),
(20, 'Laiba Qasim', 'laiba.qasim@example.com', 0, '2024-09-02 02:15:00', '2024-09-01 05:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
