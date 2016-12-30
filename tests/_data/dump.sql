-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.9 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.2.0.4675
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table user_payments.account
DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `FK_account_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.account: ~6 rows (approximately)
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` (`id`, `user_id`, `amount`, `created_at`) VALUES
	(1, 7, 0.00, '2016-12-24 15:48:34'),
	(2, 1, 100.00, '2016-12-24 15:48:34'),
	(3, 2, 100.00, '2016-12-24 15:48:34'),
	(4, 8, -200.00, '2016-12-24 17:10:16'),
	(5, 9, 100.00, '2016-12-24 17:32:13'),
	(6, 10, -100.00, '2016-12-24 17:32:36');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;


-- Dumping structure for table user_payments.payment
DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`),
  KEY `FK_payment_payment_transaction` (`transaction_id`),
  KEY `FK_payment_payment_type` (`type_id`),
  KEY `FK_payment_account` (`account_id`),
  CONSTRAINT `FK_payment_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`),
  CONSTRAINT `FK_payment_payment_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `payment_transaction` (`id`),
  CONSTRAINT `FK_payment_payment_type` FOREIGN KEY (`type_id`) REFERENCES `payment_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.payment: ~30 rows (approximately)
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` (`id`, `transaction_id`, `account_id`, `type_id`, `amount`, `created_at`) VALUES
	(1, 2, 2, 1, 100.00, '2016-12-24 16:07:53'),
	(2, 2, 3, 2, 100.00, '2016-12-24 16:07:53'),
	(7, 5, 2, 1, 100.00, '2016-12-24 16:14:11'),
	(8, 5, 3, 2, 100.00, '2016-12-24 16:14:11'),
	(9, 6, 2, 1, 100.00, '2016-12-24 16:14:49'),
	(10, 6, 3, 2, 100.00, '2016-12-24 16:14:50'),
	(11, 7, 2, 1, 100.00, '2016-12-24 16:15:10'),
	(12, 7, 3, 2, 100.00, '2016-12-24 16:15:10'),
	(23, 13, 2, 1, 100.00, '2016-12-24 16:18:49'),
	(24, 13, 3, 2, 100.00, '2016-12-24 16:18:49'),
	(25, 14, 2, 1, 100.00, '2016-12-24 16:19:06'),
	(26, 14, 3, 2, 100.00, '2016-12-24 16:19:06'),
	(27, 15, 3, 1, 100.00, '2016-12-24 16:22:59'),
	(28, 15, 2, 2, 100.00, '2016-12-24 16:22:59'),
	(29, 16, 3, 1, 100.00, '2016-12-24 16:26:17'),
	(30, 16, 2, 2, 100.00, '2016-12-24 16:26:17'),
	(31, 17, 2, 1, 100.00, '2016-12-24 16:26:54'),
	(32, 17, 3, 2, 100.00, '2016-12-24 16:26:54'),
	(33, 18, 2, 1, 100.00, '2016-12-24 17:14:24'),
	(34, 18, 4, 2, 100.00, '2016-12-24 17:14:24'),
	(35, 19, 4, 1, 100.00, '2016-12-24 17:16:16'),
	(36, 19, 2, 2, 100.00, '2016-12-24 17:16:16'),
	(37, 20, 4, 1, 100.00, '2016-12-24 17:31:40'),
	(38, 20, 2, 2, 100.00, '2016-12-24 17:31:40'),
	(39, 21, 4, 1, 100.00, '2016-12-24 17:31:56'),
	(40, 21, 3, 2, 100.00, '2016-12-24 17:31:56'),
	(41, 22, 4, 1, 100.00, '2016-12-24 17:32:18'),
	(42, 22, 5, 2, 100.00, '2016-12-24 17:32:18'),
	(43, 23, 6, 1, 100.00, '2016-12-24 17:32:57'),
	(44, 23, 4, 2, 100.00, '2016-12-24 17:32:57');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;


-- Dumping structure for table user_payments.payment_transaction
DROP TABLE IF EXISTS `payment_transaction`;
CREATE TABLE IF NOT EXISTS `payment_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.payment_transaction: ~15 rows (approximately)
/*!40000 ALTER TABLE `payment_transaction` DISABLE KEYS */;
INSERT INTO `payment_transaction` (`id`) VALUES
	(2),
	(5),
	(6),
	(7),
	(13),
	(14),
	(15),
	(16),
	(17),
	(18),
	(19),
	(20),
	(21),
	(22),
	(23);
/*!40000 ALTER TABLE `payment_transaction` ENABLE KEYS */;


-- Dumping structure for table user_payments.payment_type
DROP TABLE IF EXISTS `payment_type`;
CREATE TABLE IF NOT EXISTS `payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.payment_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `payment_type` DISABLE KEYS */;
INSERT INTO `payment_type` (`id`, `name`) VALUES
	(1, 'Debet'),
	(2, 'Credit');
/*!40000 ALTER TABLE `payment_type` ENABLE KEYS */;


-- Dumping structure for table user_payments.transfer
DROP TABLE IF EXISTS `transfer`;
CREATE TABLE IF NOT EXISTS `transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `state_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`),
  KEY `FK_transfer_transfer_type` (`type_id`),
  KEY `FK_transfer_transfer_state` (`state_id`),
  KEY `FK_transfer_from_user` (`from_user_id`),
  KEY `FK_transfer_to_user` (`to_user_id`),
  CONSTRAINT `FK_transfer_from_user` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_transfer_to_user` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_transfer_transfer_state` FOREIGN KEY (`state_id`) REFERENCES `transfer_state` (`id`),
  CONSTRAINT `FK_transfer_transfer_type` FOREIGN KEY (`type_id`) REFERENCES `transfer_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.transfer: ~8 rows (approximately)
/*!40000 ALTER TABLE `transfer` DISABLE KEYS */;
INSERT INTO `transfer` (`id`, `type_id`, `from_user_id`, `to_user_id`, `amount`, `state_id`, `created_at`) VALUES
	(1, 1, 1, 2, 100.00, 1, '2016-12-24 15:03:24'),
	(2, 2, 1, 2, 100.00, 2, '2016-12-24 16:20:46'),
	(3, 1, 1, 8, 100.00, 2, '2016-12-24 17:14:11'),
	(4, 2, 1, 8, 100.00, 2, '2016-12-24 17:15:37'),
	(5, 1, 8, 1, 100.00, 2, '2016-12-24 17:31:36'),
	(6, 1, 8, 2, 100.00, 2, '2016-12-24 17:31:53'),
	(7, 1, 8, 9, 100.00, 2, '2016-12-24 17:32:13'),
	(8, 2, 8, 10, 100.00, 2, '2016-12-24 17:32:36');
/*!40000 ALTER TABLE `transfer` ENABLE KEYS */;


-- Dumping structure for table user_payments.transfer_state
DROP TABLE IF EXISTS `transfer_state`;
CREATE TABLE IF NOT EXISTS `transfer_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.transfer_state: ~3 rows (approximately)
/*!40000 ALTER TABLE `transfer_state` DISABLE KEYS */;
INSERT INTO `transfer_state` (`id`, `name`) VALUES
	(1, 'Awaiting'),
	(2, 'Accepted'),
	(3, 'Declined');
/*!40000 ALTER TABLE `transfer_state` ENABLE KEYS */;


-- Dumping structure for table user_payments.transfer_type
DROP TABLE IF EXISTS `transfer_type`;
CREATE TABLE IF NOT EXISTS `transfer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table user_payments.transfer_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `transfer_type` DISABLE KEYS */;
INSERT INTO `transfer_type` (`id`, `name`) VALUES
	(1, 'Send'),
	(2, 'Receive');
/*!40000 ALTER TABLE `transfer_type` ENABLE KEYS */;


-- Dumping structure for table user_payments.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table user_payments.user: ~6 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'test', 'test', 'test', NULL, 'test', 10, 1482581964, 1482581964),
	(2, 'test2', 'test2', 'test2', NULL, 'test2', 10, 1482581964, 1482581964),
	(7, 'test3', 'test', 'test', NULL, 'test3@test.test', 10, 1482594514, 1482594514),
	(8, 'abc', 'test', 'test', NULL, 'abc@test.test', 10, 1482599415, 1482599415),
	(9, 'testtest', 'test', 'test', NULL, 'testtest@test.test', 10, 1482600733, 1482600733),
	(10, 'testtest2', 'test', 'test', NULL, 'testtest2@test.test', 10, 1482600756, 1482600756);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
