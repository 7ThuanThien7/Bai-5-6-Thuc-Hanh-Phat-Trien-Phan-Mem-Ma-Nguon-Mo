-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for my_store
CREATE DATABASE IF NOT EXISTS `my_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `my_store`;

-- Dumping structure for table my_store.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~2 rows (approximately)
INSERT INTO `account` (`id`, `username`, `fullname`, `password`, `role`) VALUES
	(2, 'thuanthientest', 'buithuanthienn', '$2y$10$6aVUE53UGfFNFTmfczaRq.IkayUsKl4rkmeCJ/kasNz8UXaW17bpG', 'user'),
	(3, 'thuanthienadmin', 'buithuanthien', '$2y$10$BzTugvVe0R1wyWaTUCgzM.geN7nPx5QigJjUSchoZFzX1furGf2gq', 'admin');

-- Dumping structure for table my_store.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~4 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Điện Thoại', 'điện thoại thông minh'),
	(2, 'Laptop', 'laptop gaming'),
	(3, 'Phụ Kiện', 'mới nhất hiện tại'),
	(4, 'Tivi', 'sắc nét');

-- Dumping structure for table my_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~0 rows (approximately)

-- Dumping structure for table my_store.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~0 rows (approximately)

-- Dumping structure for table my_store.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~8 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(5, 'Iphone 15 pro max 256gb dark-blue', 'thời thượng hiện đại', 29999999.00, 'uploads/10056335-dien-thoai-iphone-15-pro-max-256gb-dark-blue-1.jpg', 1),
	(6, 'chuột logitech-g502-x-plus-lightspeed-wireless-rgb-black', 'G502 X PLUS là sự bổ sung mới nhất cho dòng G502 huyền thoại. Được chế tạo lại với các phím switch lai LIGHTFORCE đầu tiên của chúng tôi, LIGHTSPEED không dây cấp độ chuyên nghiệp, LIGHTSYNC RGB, cảm biến HERO 25K v.v.', 3500000.00, 'uploads/chuot-logitech-g502-x-plus-lightspeed-wireless-rgb-black.jpg', 3),
	(7, 'Laptop Gaming Victus', 'công nghệ hiện đại', 35000000.00, 'uploads/Screenshot 2025-03-05 191629.png', 2),
	(8, 'Tivi QLED', 'sắc màu rực rỡ', 15000000.00, 'uploads/tivi-QLED-tao-mau-sac-ruc-ro.jpg', 4),
	(9, 'Tai Nghe g733-lightspeed-wireless-black', 'Âm thanh sống động', 5000000.00, 'uploads/ch-g733-lightspeed-wireless-black-666_2eb1a71d562e4a6d853a0f086723cbe3_f7f15fa3c25c4d6190c05c6db168fbf7_1024x1024.jpg', 3),
	(10, 'Iphone 16 Pro Max 256GB', 'Hiện đại thời thượng', 35000000.00, 'uploads/Screenshot 2025-03-05 191111.png', 1),
	(11, 'Bộ Mở Rộng Màn Hình Cho Laptop', 'tiện lợi hữu ích', 7999999.00, 'uploads/67512_67510_bo_mo_rong_man_hinh_danh_cho_laptop_e_tech_13.jpg', 3),
	(12, 'Asus ROG Strix SCAR 17 (G733PY-XS96) (2023)', 'CPU: AMD Ryzen™ 9 7945HX Up To 5.4GHz (16 Cores, 32 Threads, 80MB Cache)\r\nRAM: DDR5 32GB 4800MHz\r\nSSD: 1TB PCIe Gen4 M.2 SSD\r\nVGA: NVIDIA® GeForce RTX™ 4090 16GB GDDR6\r\nDISPLAY: 17″ IPS QHD+ (2560*1440), 240Hz, 3ms, 100% DCI-P3, NVIDIA® G-Sync, Dolby Vision® HDR', 79999999.00, 'uploads/Asus-ROG-Strix-SCAR-17-G733PY-XS96-2023-H1-450x450.jpg', 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
