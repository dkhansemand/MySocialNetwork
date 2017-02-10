ALTER TABLE `mysocialnetwork`.`posts` 
ADD COLUMN `PostPicture` INT NULL AFTER `Post`,
ADD INDEX `fk_post_picture_idx` (`PostPicture` ASC);
ALTER TABLE `mysocialnetwork`.`posts` 
ADD CONSTRAINT `fk_post_picture`
  FOREIGN KEY (`PostPicture`)
  REFERENCES `mysocialnetwork`.`pictures` (`Id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;
