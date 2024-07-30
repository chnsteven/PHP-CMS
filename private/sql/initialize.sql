-- initialize
CREATE DATABASE IF NOT EXISTS portfolio_cms;

-- use database
USE portfolio_cms;

-- create table
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(20) UNIQUE NOT NULL,
    `post_content` TEXT NOT NULL,
    `post_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_uuid` CHAR(36) UNIQUE NOT NULL, 
    `is_posted` TINYINT(1) DEFAULT 1,
    KEY `index_username` (`username`)
);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` INT(2) PRIMARY KEY AUTO_INCREMENT,
  `page_name` varchar(255) DEFAULT NULL,
  `position` INT(2) DEFAULT NULL,
  `visible` TINYINT(1) DEFAULT NULL,
  `content` TEXT,
  KEY `index_page_name` (`page_name`)
);

INSERT INTO `pages` VALUES (1,'Education',1,true, 'Education content');
INSERT INTO `pages` VALUES (2,'Experience',2,true, 'Experience content');

UPDATE `users`
SET 
    `username` = 'new_username',
    `post_content` = 'Updated content',
    `post_date` = '2024-07-30 12:00:00', -- This will override the default timestamp
    `user_uuid` = 'new-uuid-value', 
    `is_posted` = 0 -- Use 0 or 1 based on whether you want to set it as posted or not
WHERE `id` = 2; -- Replace with the ID of the record you want to update
