-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema mysocialnetwork
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mysocialnetwork
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mysocialnetwork` DEFAULT CHARACTER SET utf8 ;
USE `mysocialnetwork` ;

-- -----------------------------------------------------
-- Table `mysocialnetwork`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`users` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(64) NOT NULL,
  `Email` VARCHAR(128) NOT NULL,
  `Password` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `username_UNIQUE` (`Username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`Email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mysocialnetwork`.`friends`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`friends` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `RequestDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `StatusConfirm` TINYINT(1) NOT NULL DEFAULT '0',
  `RelationStatus` VARCHAR(45) NULL DEFAULT NULL,
  `UserOneId` INT(11) NOT NULL,
  `UserTwoId` INT(11) NOT NULL,
  `ConfirmDate` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `UserOneId_UNIQUE` (`UserOneId` ASC),
  UNIQUE INDEX `UserTwoId_UNIQUE` (`UserTwoId` ASC),
  INDEX `fk_FriendOne_idx` (`UserOneId` ASC),
  INDEX `fk_FriendTwo_idx` (`UserTwoId` ASC),
  CONSTRAINT `fk_FriendOne`
    FOREIGN KEY (`UserOneId`)
    REFERENCES `mysocialnetwork`.`users` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_FriendTwo`
    FOREIGN KEY (`UserTwoId`)
    REFERENCES `mysocialnetwork`.`users` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mysocialnetwork`.`pictures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`pictures` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Filename` VARCHAR(128) NOT NULL,
  `Title` VARCHAR(45) NULL DEFAULT NULL,
  `PictureDesc` TEXT NULL DEFAULT NULL,
  `Owner` INT(11) NULL DEFAULT NULL,
  `DateAdded` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  INDEX `fk_Pictures_Users1_idx` (`Owner` ASC),
  CONSTRAINT `fk_Pictures_Users1`
    FOREIGN KEY (`Owner`)
    REFERENCES `mysocialnetwork`.`users` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mysocialnetwork`.`userdetails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`userdetails` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `ProfileText` TEXT NULL DEFAULT NULL,
  `Firstname` VARCHAR(45) NULL DEFAULT NULL,
  `Surname` VARCHAR(45) NULL DEFAULT NULL,
  `Age` INT(11) NULL DEFAULT NULL,
  `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Gender` VARCHAR(10) NULL DEFAULT NULL,
  `Status` VARCHAR(45) NULL DEFAULT NULL,
  `Employment` VARCHAR(64) NULL DEFAULT NULL,
  `Hobbies` VARCHAR(256) NULL DEFAULT NULL,
  `City` VARCHAR(45) NULL DEFAULT NULL,
  `Country` VARCHAR(45) NULL DEFAULT NULL,
  `ProfilePictureId` INT(11) NULL DEFAULT NULL,
  `UserId` INT(11) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_UserId_idx` (`UserId` ASC),
  INDEX `fk_ProfilePicture_idx` (`ProfilePictureId` ASC),
  CONSTRAINT `fk_ProfilePicture`
    FOREIGN KEY (`ProfilePictureId`)
    REFERENCES `mysocialnetwork`.`pictures` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserId`
    FOREIGN KEY (`UserId`)
    REFERENCES `mysocialnetwork`.`users` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mysocialnetwork`.`posts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mysocialnetwork`.`posts` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `DateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateModified` DATETIME NULL DEFAULT NULL,
  `Title` VARCHAR(45) NOT NULL,
  `SubmittedBy` INT(11) NOT NULL,
  `Post` TEXT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `fk_Posts_User_idx` (`SubmittedBy` ASC),
  CONSTRAINT `fk_Pots_User`
    FOREIGN KEY (`SubmittedBy`)
    REFERENCES `mysocialnetwork`.`userdetails` (`UserId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Data for table `mysocialnetwork`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `mysocialnetwork`;
INSERT INTO `mysocialnetwork`.`users` (`Id`, `Username`, `Email`, `Password`) VALUES (1, 'System', 'system@admin.dk', '1234root');

COMMIT;


-- -----------------------------------------------------
-- Data for table `mysocialnetwork`.`pictures`
-- -----------------------------------------------------
START TRANSACTION;
USE `mysocialnetwork`;
INSERT INTO `mysocialnetwork`.`pictures` (`Id`, `Filename`, `Title`, `PictureDesc`, `Owner`, `DateAdded`) VALUES (1, 'avatar.jpg', 'Profile picture', 'Default Profile Picture', NULL, DEFAULT);

COMMIT;


USE `mysocialnetwork`;

DELIMITER $$
USE `mysocialnetwork`$$
CREATE
DEFINER=`root`@`localhost`
TRIGGER `mysocialnetwork`.`Users_AFTER_INSERT`
AFTER INSERT ON `mysocialnetwork`.`users`
FOR EACH ROW
BEGIN
	INSERT INTO `mysocialnetwork`.`Userdetails` (ProfilePictureId, UserId)VALUES(1, NEW.Id);
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


