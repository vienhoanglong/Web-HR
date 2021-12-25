
CREATE DATABASE IF NOT EXISTS `product_management` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `product_management`;


CREATE TABLE `product` (
  `id` int PRIMARY KEY auto_increment NOT NULL,
  `name` varchar(128) NOT NULL,
  `price` int DEFAULT 0,
  `description` varchar(255) DEFAULT NULL
);

INSERT INTO `product` (`name`, `price`, `description`) VALUES
('Macbook Pro', 1500, '16 inch, 32GB RAM'),
('iPhone X', 1100, 'No Adapter');
