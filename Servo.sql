-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 18, 2017 at 04:28 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Servo`
--

-- --------------------------------------------------------

--
-- Table structure for table `AdminBan`
--

CREATE TABLE `AdminBan` (
  `adminID` int(20) NOT NULL,
  `bannedID` int(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AdminHistory`
--

CREATE TABLE `AdminHistory` (
  `adminID` int(20) NOT NULL,
  `instanceID` int(20) NOT NULL,
  `oldValue` varchar(140) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isInstanceTopic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`name`) VALUES
('cats'),
('dogs'),
('lol'),
('politics'),
('sport'),
('whatever');

-- --------------------------------------------------------

--
-- Table structure for table `Entry`
--

CREATE TABLE `Entry` (
  `ID` int(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(140) NOT NULL,
  `userID` int(20) NOT NULL,
  `topicsID` int(20) NOT NULL,
  `rating` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Entry`
--

INSERT INTO `Entry` (`ID`, `date`, `content`, `userID`, `topicsID`, `rating`) VALUES
(3, '2017-11-18 15:22:06', 'abc', 1, 3, 0),
(4, '2017-11-18 15:22:06', 'abcD', 1, 3, 0),
(6, '2017-12-16 21:16:54', 'ashsdsdsdsd', 1, 11, 0),
(7, '2017-12-16 21:17:11', 'wazzup dsdsd', 2, 11, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `Entry_Combined_View`
--
CREATE TABLE `Entry_Combined_View` (
`rating` int(20)
,`content` varchar(140)
,`ID` int(20)
,`userID` int(20)
,`username` varchar(20)
,`date` datetime
,`topicsID` int(20)
,`topicName` varchar(140)
);

-- --------------------------------------------------------

--
-- Table structure for table `Favorite`
--

CREATE TABLE `Favorite` (
  `userID` int(20) NOT NULL,
  `contentID` int(20) NOT NULL,
  `isInstanceTopic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Favorite`
--

INSERT INTO `Favorite` (`userID`, `contentID`, `isInstanceTopic`) VALUES
(1, 3, 1),
(1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE `Rating` (
  `userID` int(20) NOT NULL,
  `entryID` int(20) NOT NULL,
  `value` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`userID`, `entryID`, `value`) VALUES
(1, 3, 1),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Report`
--

CREATE TABLE `Report` (
  `userID` int(20) NOT NULL,
  `reportedID` int(20) NOT NULL,
  `message` varchar(140) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reportType` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Topic`
--

CREATE TABLE `Topic` (
  `ID` int(20) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(140) NOT NULL,
  `userID` int(20) NOT NULL,
  `categoryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Topic`
--

INSERT INTO `Topic` (`ID`, `date`, `content`, `userID`, `categoryName`) VALUES
(3, '2017-11-18 12:13:51', 'yeye', 1, 'lol'),
(4, '2017-11-18 12:13:52', 'rr', 1, 'lol'),
(8, '2017-12-16 17:42:10', 'dssf', 1, 'cats'),
(9, '2017-12-16 17:42:44', 'dssf', 1, 'cats'),
(10, '2017-12-16 17:42:46', 'dssf', 1, 'dogs'),
(11, '2017-12-16 17:43:02', 'ds', 1, 'politics'),
(17, '2017-12-16 21:00:15', '', 8, 'cats');

-- --------------------------------------------------------

--
-- Stand-in structure for view `Topic_Combined_View`
--
CREATE TABLE `Topic_Combined_View` (
`username` varchar(20)
,`ID` int(20)
,`content` varchar(140)
,`categoryName` varchar(20)
,`userID` int(20)
,`date` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `ID` int(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(10) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isBanned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`ID`, `username`, `email`, `password`, `isAdmin`, `isBanned`) VALUES
(1, 'mehmet', 'lidl', 'yeye', 1, 0),
(2, 'mehmer', 'lidl1', 'yeye', 1, 0),
(3, 'kafka9', 'xheni_caka@hotmail.com', 'albania123', 0, 0),
(8, 'ali', 'ali@bilkent.edu.tr', 'aliali', 0, 0),
(9, 'dsdds', 'dsdsd', 'aadsdas', 0, 0),
(10, 'mamed', 'mamedmamed', 'dsafsaf', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `UserBlock`
--

CREATE TABLE `UserBlock` (
  `blockerID` int(20) NOT NULL,
  `blockedID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserFollow`
--

CREATE TABLE `UserFollow` (
  `followerID` int(20) NOT NULL,
  `followedID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserMessage`
--

CREATE TABLE `UserMessage` (
  `messageContent` varchar(140) NOT NULL,
  `messageDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `senderID` int(20) NOT NULL,
  `receiverID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `Entry_Combined_View`
--
DROP TABLE IF EXISTS `Entry_Combined_View`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `Entry_Combined_View`  AS  select `Entry`.`rating` AS `rating`,`Entry`.`content` AS `content`,`Entry`.`ID` AS `ID`,`User`.`ID` AS `userID`,`User`.`username` AS `username`,`Entry`.`date` AS `date`,`Topic`.`ID` AS `topicsID`,`Topic`.`content` AS `topicName` from ((`User` join `Topic`) join `Entry`) where ((`Entry`.`userID` = `User`.`ID`) and (`Entry`.`topicsID` = `Topic`.`ID`)) group by `Entry`.`ID` ;

-- --------------------------------------------------------

--
-- Structure for view `Topic_Combined_View`
--
DROP TABLE IF EXISTS `Topic_Combined_View`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `Topic_Combined_View`  AS  select `User`.`username` AS `username`,`Topic`.`ID` AS `ID`,`Topic`.`content` AS `content`,`Topic`.`categoryName` AS `categoryName`,`Topic`.`userID` AS `userID`,`Topic`.`date` AS `date` from (`Topic` join `User`) where (`User`.`ID` = `Topic`.`userID`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AdminBan`
--
ALTER TABLE `AdminBan`
  ADD KEY `adminID` (`adminID`),
  ADD KEY `bannedID` (`bannedID`);

--
-- Indexes for table `AdminHistory`
--
ALTER TABLE `AdminHistory`
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Entry`
--
ALTER TABLE `Entry`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `topicsID` (`topicsID`);

--
-- Indexes for table `Favorite`
--
ALTER TABLE `Favorite`
  ADD PRIMARY KEY (`userID`,`contentID`,`isInstanceTopic`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`userID`,`entryID`),
  ADD KEY `entryID` (`entryID`);

--
-- Indexes for table `Report`
--
ALTER TABLE `Report`
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `Topic`
--
ALTER TABLE `Topic`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `categoryName` (`categoryName`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `UserBlock`
--
ALTER TABLE `UserBlock`
  ADD KEY `blockerID` (`blockerID`),
  ADD KEY `blockedID` (`blockedID`);

--
-- Indexes for table `UserFollow`
--
ALTER TABLE `UserFollow`
  ADD KEY `followerID` (`followerID`),
  ADD KEY `followedID` (`followedID`);

--
-- Indexes for table `UserMessage`
--
ALTER TABLE `UserMessage`
  ADD KEY `receiverID` (`receiverID`),
  ADD KEY `senderID` (`senderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Entry`
--
ALTER TABLE `Entry`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `Topic`
--
ALTER TABLE `Topic`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `AdminBan`
--
ALTER TABLE `AdminBan`
  ADD CONSTRAINT `AdminBan_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `User` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `AdminBan_ibfk_2` FOREIGN KEY (`bannedID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `AdminHistory`
--
ALTER TABLE `AdminHistory`
  ADD CONSTRAINT `AdminHistory_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `Entry`
--
ALTER TABLE `Entry`
  ADD CONSTRAINT `Entry_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`ID`),
  ADD CONSTRAINT `Entry_ibfk_2` FOREIGN KEY (`topicsID`) REFERENCES `Topic` (`ID`);

--
-- Constraints for table `Favorite`
--
ALTER TABLE `Favorite`
  ADD CONSTRAINT `Favorite_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`ID`);

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
  ADD CONSTRAINT `Rating_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`ID`),
  ADD CONSTRAINT `Rating_ibfk_2` FOREIGN KEY (`entryID`) REFERENCES `Entry` (`ID`);

--
-- Constraints for table `Report`
--
ALTER TABLE `Report`
  ADD CONSTRAINT `Report_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `Topic`
--
ALTER TABLE `Topic`
  ADD CONSTRAINT `Topic_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `User` (`ID`),
  ADD CONSTRAINT `Topic_ibfk_2` FOREIGN KEY (`categoryName`) REFERENCES `Category` (`name`);

--
-- Constraints for table `UserBlock`
--
ALTER TABLE `UserBlock`
  ADD CONSTRAINT `UserBlock_ibfk_1` FOREIGN KEY (`blockerID`) REFERENCES `User` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `UserBlock_ibfk_2` FOREIGN KEY (`blockedID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `UserFollow`
--
ALTER TABLE `UserFollow`
  ADD CONSTRAINT `UserFollow_ibfk_1` FOREIGN KEY (`followerID`) REFERENCES `User` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `UserFollow_ibfk_2` FOREIGN KEY (`followedID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `UserMessage`
--
ALTER TABLE `UserMessage`
  ADD CONSTRAINT `UserMessage_ibfk_1` FOREIGN KEY (`receiverID`) REFERENCES `User` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `UserMessage_ibfk_2` FOREIGN KEY (`senderID`) REFERENCES `User` (`ID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
