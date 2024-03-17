/*
Created: 13. 02. 2024
Modified: 13. 02. 2024
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table users

CREATE TABLE `users`
(
  `id` Int NOT NULL,
  `first_name` Varchar(100),
  `last_name` Varchar(100),
  `email` Varchar(100),
  `password` Varchar(255),
  `telephone` Varchar(20),
  `it` Int
)
;

ALTER TABLE `users` ADD PRIMARY KEY (`id`)
;

-- Table applications

CREATE TABLE `applications`
(
  `id` Int NOT NULL,
  `name` Varchar(100)
)
;

ALTER TABLE `applications` ADD PRIMARY KEY (`id`)
;

-- Table screenshots

CREATE TABLE `screenshots`
(
  `id` Int NOT NULL,
  `url` Varchar(255),
  `description` Text,
  `rfc_id` Int NOT NULL
)
;

CREATE INDEX `IX_Relationship9` ON `screenshots` (`rfc_id`)
;

ALTER TABLE `screenshots` ADD PRIMARY KEY (`id`)
;

-- Table rfc

CREATE TABLE `rfc`
(
  `id` Int NOT NULL,
  `short_description` Varchar(200),
  `long_description` Text,
  `date_add` Timestamp NULL,
  `date_end` Timestamp NULL,
  `priority` Varchar(100),
  `reasons` Varchar(200),
  `risks` Varchar(200),
  `status` Varchar(100),
  `contractor_id` Int NOT NULL,
  `application_id` Int NOT NULL,
  `user_id` Int NOT NULL
)
;

CREATE INDEX `IX_Relationship3` ON `rfc` (`application_id`)
;

CREATE INDEX `IX_Relationship4` ON `rfc` (`user_id`)
;

CREATE INDEX `IX_Relationship7` ON `rfc` (`contractor_id`)
;

ALTER TABLE `rfc` ADD PRIMARY KEY (`id`)
;

-- Table comments

CREATE TABLE `comments`
(
  `id` Int NOT NULL,
  `description` Text,
  `date_add` Timestamp NULL,
  `user_id` Int NOT NULL,
  `rfc_id` Int NOT NULL
)
;

CREATE INDEX `IX_Relationship2` ON `comments` (`user_id`)
;

CREATE INDEX `IX_Relationship8` ON `comments` (`rfc_id`)
;

ALTER TABLE `comments` ADD PRIMARY KEY (`id`)
;

-- Table contractor

CREATE TABLE `contractor`
(
  `id` Int NOT NULL,
  `name` Varchar(200)
)
;

ALTER TABLE `contractor` ADD PRIMARY KEY (`id`)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `comments` ADD CONSTRAINT `Relationship2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `rfc` ADD CONSTRAINT `Relationship3` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `rfc` ADD CONSTRAINT `Relationship4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `rfc` ADD CONSTRAINT `Relationship7` FOREIGN KEY (`contractor_id`) REFERENCES `contractor` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `comments` ADD CONSTRAINT `Relationship8` FOREIGN KEY (`rfc_id`) REFERENCES `rfc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `screenshots` ADD CONSTRAINT `Relationship9` FOREIGN KEY (`rfc_id`) REFERENCES `rfc` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;


