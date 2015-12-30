SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `User` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`fname` varchar(50) NOT NULL,
	`lname` varchar(50) NOT NULL,
	`email` varchar(50) NOT NULL,
	`telno` varchar(30),
	`user_name` varchar(50) NOT NULL,
	`privilege_level` int(2) NOT NULL,
	PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Login` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`username_hash` varchar(255) NOT NULL,
	`password_hash` varchar(255) NOT NULL,
	`personal_salt` varchar(255) NOT NULL,
	`disabled` boolean NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Ban` (
	`banned_at` int(10) NOT NULL,
	`banned_until` int(10) NOT NULL,
	`ip_address` varchar(45) NULL,
	`proxy_ip` varchar(255) NULL,
	`session_id` varchar(26) NULL,
	PRIMARY KEY (`ip_address`, `proxy_ip`, `session_id`)
);

CREATE TABLE `LoginAttempt` (
	`occurred_at` int(10) NOT NULL,
	`username_input` varchar(255) NOT NULL,
	`successful` boolean NOT NULL
);

CREATE TABLE `Administrator` (
	`user_id` int(10) NOT NULL AUTO_INCREMENT,
	`privilege_level` int(10),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`)
);

CREATE TABLE `Moderator` (
	`user_id` int(10) NOT NULL AUTO_INCREMENT,
	`privilege_level` int(10),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`)
);

CREATE TABLE `Picture` (
	`picture_id` int(10) NOT NULL AUTO_INCREMENT,
	`pic_path` int(50) NOT NULL,
	PRIMARY KEY (`picture_id`)
);

CREATE TABLE `Recipe` (
	`recipe_id` int(10) NOT NULL AUTO_INCREMENT,
	`picture_id` int(10) NOT NULL,
	`user_id` int(10) NOT NULL,
	`recipe_type` int(50) NOT NULL,
	`favorite_count` int(10),
	`disable` bit NOT NULL,
	PRIMARY KEY (`recipe_id`),
	FOREIGN KEY (`picture_id`) REFERENCES `Picture`(`picture_id`),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`)
);

CREATE TABLE `Favorite` (
	`user_id` int(10) NOT NULL AUTO_INCREMENT,
	`recipe_id` int(10) NOT NULL,
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY (`recipe_id`) REFERENCES `Recipe`(`recipe_id`)
);

CREATE TABLE `Step` (
	`recipe_id` int(10),
	`picture_id` int(10),
	FOREIGN KEY (`recipe_id`) REFERENCES `Recipe`(`recipe_id`),
	FOREIGN KEY (`picture_id`) REFERENCES `Picture`(`picture_id`)
);

CREATE TABLE `Message` (
	`message_id` int(10) NOT NULL AUTO_INCREMENT,
	`user_id` int(10) NOT NULL,
	`message_contents` varchar(255) NOT NULL,
	PRIMARY KEY (`message_id`),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`)
);

CREATE TABLE `RecipeComment` (
	`comment_id` int(10) NOT NULL AUTO_INCREMENT,
	`user_id` int(10) NOT NULL,
	`comment_contents` varchar(255) NOT NULL,
	PRIMARY KEY (`comment_id`),
	FOREIGN KEY (`user_id`) REFERENCES `User`(`user_id`)
);

CREATE TABLE `Report` (
	`banned_user_id` int(10) NOT NULL,
	`banned_by_user_id` int(10) NOT NULL,
	`report` varchar(255) NOT NULL,
	FOREIGN KEY (`banned_user_id`) REFERENCES `User`(`user_id`),
	FOREIGN KEY (`banned_by_user_id`) REFERENCES `User`(`user_id`)
);
