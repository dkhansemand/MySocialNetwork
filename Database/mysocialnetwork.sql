-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 09. 02 2017 kl. 20:12:03
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
CREATE DATABASE IF NOT EXISTS `mysocialnetwork` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mysocialnetwork`;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `friends`
--
-- Oprettelse: 09. 02 2017 kl. 19:06:31
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `Id` int(11) NOT NULL,
  `RequestDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusConfirm` tinyint(1) NOT NULL DEFAULT '0',
  `RelationStatus` varchar(45) DEFAULT NULL,
  `UserOneId` int(11) NOT NULL,
  `UserTwoId` int(11) NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE (Relationer for tabellen) `friends`:
--   `UserOneId`
--       `users` -> `Id`
--   `UserTwoId`
--       `users` -> `Id`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pictures`
--
-- Oprettelse: 09. 02 2017 kl. 19:07:05
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `Id` int(11) NOT NULL,
  `Filename` varchar(128) NOT NULL,
  `Title` varchar(45) DEFAULT NULL,
  `PictureDesc` text,
  `Owner` int(11) DEFAULT NULL,
  `DateAdded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE (Relationer for tabellen) `pictures`:
--   `Owner`
--       `users` -> `Id`
--

--
-- Data dump for tabellen `pictures`
--

INSERT INTO `pictures` (`Id`, `Filename`, `Title`, `PictureDesc`, `Owner`, `DateAdded`) VALUES
(1, 'avatar.jpg', 'Default Profile picture', 'Profile picture', NULL, '2017-02-09 20:05:40');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `posts`
--
-- Oprettelse: 09. 02 2017 kl. 19:07:30
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `Id` int(11) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` datetime DEFAULT NULL,
  `Title` varchar(45) NOT NULL,
  `SubmittedBy` int(11) NOT NULL,
  `Post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE (Relationer for tabellen) `posts`:
--   `SubmittedBy`
--       `userdetails` -> `UserId`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `userdetails`
--
-- Oprettelse: 09. 02 2017 kl. 19:05:39
--

DROP TABLE IF EXISTS `userdetails`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE (Relationer for tabellen) `userdetails`:
--   `ProfilePictureId`
--       `pictures` -> `Id`
--   `UserId`
--       `users` -> `Id`
--

--
-- Data dump for tabellen `userdetails`
--

INSERT INTO `userdetails` (`Id`, `ProfileText`, `Firstname`, `Surname`, `Age`, `DateCreated`, `Gender`, `Status`, `Employment`, `Hobbies`, `City`, `Country`, `ProfilePictureId`, `UserId`) VALUES
(1, NULL, NULL, NULL, NULL, '2017-02-09 20:05:40', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--
-- Oprettelse: 09. 02 2017 kl. 19:05:39
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(64) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Password` varchar(256) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE (Relationer for tabellen) `users`:
--

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Password`) VALUES
(1, 'System', 'admin@system.dk', '1234root');

--
-- Triggers/udløsere `users`
--
DROP TRIGGER IF EXISTS `users_AFTER_INSERT`;
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
  ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `UserOneId_UNIQUE` (`UserOneId`), ADD UNIQUE KEY `UserTwoId_UNIQUE` (`UserTwoId`), ADD KEY `fk_FriendOne_idx` (`UserOneId`), ADD KEY `fk_FriendTwo_idx` (`UserTwoId`);

--
-- Indeks for tabel `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`Id`), ADD KEY `fk_Pictures_Users1_idx` (`Owner`);

--
-- Indeks for tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Id`), ADD KEY `fk_post_user_idx` (`SubmittedBy`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `pictures`
--
ALTER TABLE `pictures`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tilføj AUTO_INCREMENT i tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `friends`
--
ALTER TABLE `friends`
ADD CONSTRAINT `fk_FriendOne` FOREIGN KEY (`UserOneId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_FriendTwo` FOREIGN KEY (`UserTwoId`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `pictures`
--
ALTER TABLE `pictures`
ADD CONSTRAINT `fk_Pictures_Users1` FOREIGN KEY (`Owner`) REFERENCES `users` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `posts`
--
ALTER TABLE `posts`
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
