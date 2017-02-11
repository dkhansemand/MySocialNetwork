CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(256) NOT NULL,
  `email` VARCHAR(256) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  PRIMARY KEY(`user_id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `relationship` (
  `user_one_id` INT(10) UNSIGNED NOT NULL,
  `user_two_id` INT(10) UNSIGNED NOT NULL,
  `status` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `action_user_id` INT(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`user_one_id`) REFERENCES users(`user_id`),
  FOREIGN KEY (`user_two_id`) REFERENCES users(`user_id`),
  FOREIGN KEY (`action_user_id`) REFERENCES users(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `relationship`
ADD UNIQUE KEY `unique_users_id` (`user_one_id`,`user_two_id`);

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(1, 'user1', 'user1@gmail.com', sha2('password', 256)),
(2, 'user2', 'user2@gmail.com', sha2('password', 256)),
(3, 'user3', 'user3@gmail.com', sha2('password', 256)),
(4, 'user4', 'user4@gmail.com', sha2('password', 256)),
(5, 'user5', 'user5@gmail.com', sha2('password', 256)),
(6, 'user6', 'user6@gmail.com', sha2('password', 256));

INSERT INTO `relationship` (`user_one_id`, `user_two_id`, `status`, `action_user_id`) VALUES
(1, 2, 1, 1),
(1, 3, 1, 3),
(1, 4, 1, 4),
(1, 5, 0, 5),
(1, 6, 3, 1),
(2, 3, 1, 2),
(2, 4, 1, 4),
(3, 5, 1, 3),
(1, 7, 0, 1);