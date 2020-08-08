
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) CHARACTER SET utf8 NOT NULL,
  `profile_id` int(11) NOT NULL,
  `email` varchar(160) CHARACTER SET utf8 NOT NULL,
  `birth` date DEFAULT NULL,
  `document` varchar(45) NOT NULL,
  `ddd` varchar(3) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `password` varchar(90) NOT NULL,
  `token` varchar(160) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `fk_users_1_idx` (`profile_id`),
  CONSTRAINT `fk_users_1` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

