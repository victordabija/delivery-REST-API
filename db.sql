CREATE TABLE `delivery`.`user` ( 
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
    `username` VARCHAR(16) NOT NULL , 
    `password` VARCHAR(191) NOT NULL , PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `order` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `distance` int(10) UNSIGNED NOT NULL,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_cost` float UNSIGNED NOT NULL,
  `status` char(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'On the Way',
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;