-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 13. 02 2017 kl. 10:19:44
-- Serverversion: 5.6.24
-- PHP-version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mysocialnetwork`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `Id` int(11) NOT NULL,
  `RequestDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusConfirm` tinyint(1) NOT NULL DEFAULT '0',
  `RelationStatus` varchar(45) DEFAULT NULL,
  `UserOneId` int(11) NOT NULL,
  `UserTwoId` int(11) NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `Action_userId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `friends`
--

INSERT INTO `friends` (`Id`, `RequestDate`, `StatusConfirm`, `RelationStatus`, `UserOneId`, `UserTwoId`, `ConfirmDate`, `Action_userId`) VALUES
(11, '2017-02-11 15:55:02', 1, NULL, 4, 5, '2017-02-11 15:55:17', 5),
(17, '2017-02-11 16:20:15', 1, NULL, 4, 3, '2017-02-11 16:59:28', 3),
(21, '2017-02-11 21:47:49', 0, NULL, 3, 5, NULL, 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `Id` int(11) NOT NULL,
  `Filename` varchar(128) NOT NULL,
  `Title` varchar(45) DEFAULT NULL,
  `PictureDesc` text,
  `Owner` int(11) DEFAULT NULL,
  `DateAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `pictures`
--

INSERT INTO `pictures` (`Id`, `Filename`, `Title`, `PictureDesc`, `Owner`, `DateAdded`) VALUES
(1, 'avatar.jpg', 'Default Profile picture', 'Profile picture', NULL, '2017-02-09 20:05:40'),
(2, '10021711043400000066136966.jpg', 'Default Profile picture', 'Profile picture', 4, '2017-02-10 11:04:34'),
(3, '11021721014700000062774473.jpg', NULL, NULL, 3, '2017-02-11 21:01:47');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `Id` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` datetime DEFAULT NULL,
  `Title` varchar(45) NOT NULL,
  `SubmittedBy` int(11) NOT NULL,
  `Post` text NOT NULL,
  `PostPicture` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `posts`
--

INSERT INTO `posts` (`Id`, `DateCreated`, `DateModified`, `Title`, `SubmittedBy`, `Post`, `PostPicture`) VALUES
(2, '2017-02-11 20:57:24', NULL, 'En mere', 3, '<p>En mere post taks!</p>', NULL),
(3, '2017-02-11 21:01:47', NULL, 'En post med billede!', 3, '<p>Der skal jo et billede p&aring;!</p>', 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `userdetails`
--

CREATE TABLE IF NOT EXISTS `userdetails` (
  `Id` int(11) NOT NULL,
  `ProfileText` text,
  `Firstname` varchar(45) DEFAULT NULL,
  `Surname` varchar(45) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Gender` varchar(10) DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Employment` varchar(64) DEFAULT NULL,
  `Hobbies` varchar(256) DEFAULT NULL,
  `City` varchar(45) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `ProfilePictureId` int(11) DEFAULT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `userdetails`
--

INSERT INTO `userdetails` (`Id`, `ProfileText`, `Firstname`, `Surname`, `Age`, `DateCreated`, `Gender`, `Status`, `Employment`, `Hobbies`, `City`, `Country`, `ProfilePictureId`, `UserId`) VALUES
(1, NULL, NULL, NULL, NULL, '2017-02-09 20:05:40', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(3, 'Dette er min profiltekst', 'Test', 'Bruger', 69, '2017-02-10 08:01:22', 'Male', NULL, NULL, NULL, 'Roskilde', 'Danmark', 1, 3),
(4, NULL, NULL, NULL, NULL, '2017-02-10 11:03:45', NULL, NULL, NULL, NULL, NULL, NULL, 2, 4),
(5, NULL, NULL, NULL, NULL, '2017-02-10 12:52:55', NULL, NULL, NULL, NULL, NULL, NULL, 1, 5);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(64) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Password` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Password`) VALUES
(1, 'System', 'admin@system.dk', '1234root'),
(3, 'test', 'test@test.dk', '$2y$10$Gkm7KHI2VsYHuTlJJPOtc.nEvOeU5ESFPTS0OJYRohzCpjG9eLXf.'),
(4, 'admin', 'admin@admin.dk', '$2y$10$DoiUBdQfqNQjKumHyLoZGeR0vXuW.GDS99B2ZCubQuf3h7ySk2VsG'),
(5, 'hejsa', 'hejsa@hej.dk', '$2y$10$FYUZ.QbAW.LeQym5pFALaOZ0vgtV7PuiMf1/4xzmvzIrT1GA.bMnK');

--
-- Triggers/udløsere `users`
--
DELIMITER $$
CREATE TRIGGER `users_AFTER_INSERT` AFTER INSERT ON `users`
 FOR EACH ROW BEGIN
INSERT INTO `mysocialnetwork`.`Userdetails` (ProfilePictureId, UserId)VALUES(1, NEW.Id);
END
$$
DELIMITER ;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `unique_friends_id` (`UserOneId`,`UserTwoId`), ADD KEY `fk_FriendOne_idx` (`UserOneId`), ADD KEY `fk_FriendTwo_idx` (`UserTwoId`), ADD KEY `fk_UserAction_idx` (`Action_userId`);

--
-- Indeks for tabel `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`Id`), ADD KEY `fk_Pictures_Users1_idx` (`Owner`);

--
-- Indeks for tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`), ADD KEY `fk_post_user_idx` (`SubmittedBy`), ADD KEY `fk_post_picture_idx` (`PostPicture`);

--
-- Indeks for tabel `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`Id`), ADD KEY `fk_UserId_idx` (`UserId`), ADD KEY `fk_ProfilePicture_idx` (`ProfilePictureId`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `username_UNIQUE` (`Username`), ADD UNIQUE KEY `email_UNIQUE` (`Email`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `friends`
--
ALTER TABLE `friends`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- Tilføj AUTO_INCREMENT i tabel `pictures`
--
ALTER TABLE `pictures`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `friends`
--
ALTER TABLE `friends`
ADD CONSTRAINT `fk_FriendOne` FOREIGN KEY (`UserOneId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_FriendTwo` FOREIGN KEY (`UserTwoId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_userAction` FOREIGN KEY (`Action_userId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `pictures`
--
ALTER TABLE `pictures`
ADD CONSTRAINT `fk_Pictures_Users1` FOREIGN KEY (`Owner`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `fk_post_picture` FOREIGN KEY (`PostPicture`) REFERENCES `pictures` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`SubmittedBy`) REFERENCES `userdetails` (`UserId`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `userdetails`
--
ALTER TABLE `userdetails`
ADD CONSTRAINT `fk_ProfilePicture` FOREIGN KEY (`ProfilePictureId`) REFERENCES `pictures` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_UserId` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
