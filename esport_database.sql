-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2024 at 08:37 AM
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
-- Database: `esport_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_news`
--

CREATE TABLE `tbl_news` (
  `newsDate` datetime NOT NULL DEFAULT current_timestamp(),
  `newsId` int(11) NOT NULL,
  `newsHeading` varchar(100) NOT NULL,
  `newsBody` varchar(1000) NOT NULL,
  `newsFootage` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_news`
--

INSERT INTO `tbl_news` (`newsDate`, `newsId`, `newsHeading`, `newsBody`, `newsFootage`) VALUES
('2024-06-15 17:03:53', 9, 'Breaking News: Cyberattack Shuts Down Major Financial Institutions', 'In a stunning development, a sophisticated cyberattack has paralyzed leading global banks, disrupting financial transactions worldwide. Hackers infiltrated banking systems, causing widespread panic among investors and account holders. Authorities are scrambling to contain the breach, suspecting a state-sponsored group behind the attack. Financial markets are reeling from the unprecedented cyber assault, with fears of significant economic repercussions looming large. Stay tuned for updates on thi', 'Cyber atk news test.jpg'),
('2024-06-16 21:28:24', 11, 'The International 2024 Dota 2 Championships', 'The International Dota 2 Championships 2024 (also commonly called TI 2024 or TI 13) is the thirteenth annual edition of The International which will take place in Copenhagen, Denmark.\r\n\r\nSimilar to previous year, The International 2024 was split into two distinct phases: The qualifiers, group stage and playoffs (until top 8) were branded as part of The Road to The International, while the playoffs for the remaining 8 teams were branded as The International itself. It is also the first edition of the tournament since 2017 to select one or more participating teams through a direct invite process, and the first since 2019 to feature open qualifiers.', 'ti2024.jpg'),
('2024-06-17 10:04:49', 12, 'CRYONICS COMPANY FREEZES ITS FIRST CLIENT IN AUSTRALIA', 'n this lesson, students will learn about cryonics, and how it is becoming increasingly popular. A listening task revolves around the first case of someone being cryogenically frozen in Australia. This is followed by a reading comprehension that looks at four stories relating to this topic. There are also opportunities to discuss the issues raised at different points in the class. Finally, there is an optional extension in the form of a writing exercise – students will watch a video about a cryonics facility in Arizona and answer an essay question.  by Joey Vaughan-Birch    *Note: This lesson contains information about cryonics - the practice of deep-freezing the bodies of people who have just died - which some students might find distressing.', 'cryo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_player`
--

CREATE TABLE `tbl_player` (
  `playerId` int(11) NOT NULL,
  `playerName` varchar(100) NOT NULL,
  `playerFblink` varchar(50) NOT NULL,
  `playerEmail` varchar(300) NOT NULL,
  `playerPhno` varchar(100) NOT NULL,
  `playerIgn` varchar(50) NOT NULL,
  `playerIgid` int(11) NOT NULL,
  `roleId` int(50) NOT NULL,
  `teamId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_player`
--

INSERT INTO `tbl_player` (`playerId`, `playerName`, `playerFblink`, `playerEmail`, `playerPhno`, `playerIgn`, `playerIgid`, `roleId`, `teamId`) VALUES
(33, '43wesrdtfgyhbu', 'https://www.example.com/page.html:', 'sdrtfgvbhjnk@gmail.com', '23456789', 'All About \"Ei\"', 1562596, 1, 16),
(34, 'Honey Bo Bo', 'https://www.youtube.com/', 'honeybo@gmail.com', '12345678', 'ms.Schnell', 78893345, 1, 21),
(35, 'MSI Newest GF63 Thin', 'https://www.youtube.com/', 'UGGIUHIUHI@gmail.com', '123456789', 'ms.Schnell', 3456789, 5, 21);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `roleId` int(11) NOT NULL,
  `roleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`roleId`, `roleName`) VALUES
(1, 'Gold Lane'),
(2, 'Mid Lane'),
(3, 'Exp Lane'),
(4, 'Roam'),
(5, 'Jungling');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_team`
--

CREATE TABLE `tbl_team` (
  `teamId` int(11) NOT NULL,
  `teamName` varchar(50) NOT NULL,
  `teamEmail` varchar(50) NOT NULL,
  `teamPhno` varchar(50) NOT NULL,
  `teamImage` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_team`
--

INSERT INTO `tbl_team` (`teamId`, `teamName`, `teamEmail`, `teamPhno`, `teamImage`, `date`) VALUES
(1, 'Galatic Guardians', 'alexwanachangefuture@gmail.com', '1234567', 'Hyper.jpg', '2024-06-21 12:57:55'),
(16, 'Pro Lay Myar', 'arkarmyo2804@gmail.com', '34567890', 'ALPHA GENES.jpg', '2024-06-21 12:57:55'),
(20, 'Galatic Guardians', 'alexwanachangefuture@gmail.com', '3456789', 'thumbnailobrightthing.jpg', '2024-06-21 12:57:55'),
(21, 'KTV Go Mal', 'mthantzaw946@gmail.com', '123456789', 'es moji.jpg', '2024-06-21 12:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tour`
--

CREATE TABLE `tbl_tour` (
  `tourId` int(11) NOT NULL,
  `tourName` varchar(300) NOT NULL,
  `tourDesc` varchar(500) NOT NULL,
  `tourPrizepool` varchar(20) NOT NULL,
  `tourLocation` varchar(200) NOT NULL,
  `tourStartDate` date NOT NULL,
  `tourEndDate` date NOT NULL,
  `createdat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tour`
--

INSERT INTO `tbl_tour` (`tourId`, `tourName`, `tourDesc`, `tourPrizepool`, `tourLocation`, `tourStartDate`, `tourEndDate`, `createdat`) VALUES
(1, 'The International 2024', 'The International Dota 2 Championships 2024 (also commonly called TI 2024 or TI 13) is the thirteenth annual edition of The International which will take place in Copenhagen, Denmark.\r\n\r\nSimilar to previous year, The International 2024 was split into two distinct phases: The qualifiers, group stage and playoffs (until top 8) were branded as part of The Road to The International, while the playoffs for the remaining 8 teams were branded as The International itself. It is also the first edition of', '2,400,000 Kyats', 'Copenhagen, Denark', '2024-09-04', '2024-09-15', '2024-06-21 12:58:31'),
(2, 'Winter Esport', 'rgergghghwoighewrgwoigjowi', '234567345', 'SFU', '2024-06-15', '2024-06-17', '2024-06-21 12:58:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tour_team`
--

CREATE TABLE `tbl_tour_team` (
  `tour_teamId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  `tourId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userId` int(11) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(50) NOT NULL,
  `userRoleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userId`, `userEmail`, `userPassword`, `userRoleId`) VALUES
(5, 'rurehgggh@gmail.com', 'adffdj4899', 0),
(6, 'admin@gmail.com', 'test1234', 1),
(7, 'user@gmail.com', 'test1234', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`newsId`);

--
-- Indexes for table `tbl_player`
--
ALTER TABLE `tbl_player`
  ADD PRIMARY KEY (`playerId`),
  ADD KEY `rolefk` (`roleId`),
  ADD KEY `teamId_fk` (`teamId`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`roleId`);

--
-- Indexes for table `tbl_team`
--
ALTER TABLE `tbl_team`
  ADD PRIMARY KEY (`teamId`);

--
-- Indexes for table `tbl_tour`
--
ALTER TABLE `tbl_tour`
  ADD PRIMARY KEY (`tourId`);

--
-- Indexes for table `tbl_tour_team`
--
ALTER TABLE `tbl_tour_team`
  ADD PRIMARY KEY (`tour_teamId`),
  ADD KEY `tourId` (`tourId`),
  ADD KEY `teamId` (`teamId`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `newsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_player`
--
ALTER TABLE `tbl_player`
  MODIFY `playerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `roleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_team`
--
ALTER TABLE `tbl_team`
  MODIFY `teamId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_tour`
--
ALTER TABLE `tbl_tour`
  MODIFY `tourId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_tour_team`
--
ALTER TABLE `tbl_tour_team`
  MODIFY `tour_teamId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_player`
--
ALTER TABLE `tbl_player`
  ADD CONSTRAINT `teamId_fk` FOREIGN KEY (`teamId`) REFERENCES `tbl_team` (`teamId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_tour_team`
--
ALTER TABLE `tbl_tour_team`
  ADD CONSTRAINT `tbl_tour_team_ibfk_1` FOREIGN KEY (`tourId`) REFERENCES `tbl_tour` (`tourId`),
  ADD CONSTRAINT `tbl_tour_team_ibfk_2` FOREIGN KEY (`teamId`) REFERENCES `tbl_team` (`teamId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
