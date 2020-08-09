
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `addresses`;

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

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('all','billing','shipping') NOT NULL DEFAULT 'all',
  `default` tinyint(1) DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `company` varchar(120) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `neighborhood` varchar(120) DEFAULT NULL,
  `postcode` varchar(15) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created` varchar(45) DEFAULT 'CURRENT_TIMESTAMP',
  PRIMARY KEY (`address_id`),
  KEY `fk_addresses_1_idx` (`user_id`),
  CONSTRAINT `fk_addresses_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


