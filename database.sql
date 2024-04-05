-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Versie:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Databasestructuur van 2324_wittekip wordt geschreven
CREATE DATABASE IF NOT EXISTS `2324_wittekip` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `2324_wittekip`;

-- Structuur van  tabel 2324_wittekip.cart wordt geschreven
CREATE TABLE IF NOT EXISTS `cart` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) unsigned NOT NULL,
  `ordered` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.cart: ~0 rows (ongeveer)

-- Structuur van  tabel 2324_wittekip.cart_items wordt geschreven
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.cart_items: ~0 rows (ongeveer)

-- Structuur van  tabel 2324_wittekip.categories wordt geschreven
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.categories: ~2 rows (ongeveer)
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Kippen', '2024-02-18 18:16:51', NULL),
	(2, 'Kuikens', '2024-02-27 10:19:22', NULL);

-- Structuur van  tabel 2324_wittekip.customers wordt geschreven
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prefixes` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `street` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `house_number` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `addition` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `zipcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.customers: ~1 rows (ongeveer)

-- Structuur van  tabel 2324_wittekip.orders wordt geschreven
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `order_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.orders: ~0 rows (ongeveer)

-- Structuur van  tabel 2324_wittekip.order_items wordt geschreven
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.order_items: ~0 rows (ongeveer)

-- Structuur van  tabel 2324_wittekip.products wordt geschreven
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT 0.00,
  `image` varchar(255) NOT NULL DEFAULT 'https://placehold.co/600x600',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.products: ~3 rows (ongeveer)
INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
	(1, 0, 'Legkippen', 'Lorem ipsum dolor sit amet. Eum odit eaque aut internos quia sit minus dolore qui dolorem praesentium. Et nesciunt reiciendis et quam repudiandae ea dolorem quis ut dolor voluptas.', 25.00, 'background.png', '2024-02-27 10:20:32', NULL),
	(2, 1, 'Kip', 'Lorem ipsum dolor sit amet. Eum odit eaque aut internos quia sit minus dolore qui dolorem praesentium. Et nesciunt reiciendis et quam repudiandae ea dolorem quis ut dolor voluptas.', 25.00, 'background.png', '2024-02-18 17:32:26', NULL),
	(3, 2, 'Kuiken', 'Lorem ipsum dolor sit amet. Eum odit eaque aut internos quia sit minus dolore qui dolorem praesentium. Et nesciunt reiciendis et quam repudiandae ea dolorem quis ut dolor voluptas.', 25.00, 'background.png', '2024-02-18 17:48:40', NULL);

-- Structuur van  tabel 2324_wittekip.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel 2324_wittekip.users: ~0 rows (ongeveer)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
