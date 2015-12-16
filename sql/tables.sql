-- Database creation script for securipe

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username_hash` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `personal_salt` varchar(255) NOT NULL,
  `disabled` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `login`
  ADD UNIQUE KEY `user_id` (`user_id`);

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `privilege_level` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`);