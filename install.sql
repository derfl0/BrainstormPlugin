-- SQL
CREATE TABLE `brainstorm_votes` (
  `brainstorm_id` varchar(32) NOT NULL DEFAULT '',
  `user_id` varchar(32) NOT NULL DEFAULT '',
  `vote` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`brainstorm_id`,`user_id`)
);



CREATE TABLE `brainstorms` (
  `brainstorm_id` varchar(32) NOT NULL DEFAULT '',
  `range_id` varchar(32) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`brainstorm_id`),
  KEY `range_id` (`range_id`)
);