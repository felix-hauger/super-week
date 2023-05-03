CREATE DATABASE `superweek`;

USE `superweek`;

CREATE TABLE `user` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `book` (
    `id` INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `summary` TEXT DEFAULT NULL,
    `content` LONGTEXT NOT NULL,
    `user_id` INT(11) UNSIGNED,
    PRIMARY KEY(`id`),
    CONSTRAINT `fk_user_book` FOREIGN KEY(`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;