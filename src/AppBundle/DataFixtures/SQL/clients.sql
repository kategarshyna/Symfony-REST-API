-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.63-MariaDB-1~trusty - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table symfony-test.client
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C7440455E7927C74` (`email`),
  UNIQUE KEY `UNIQ_C7440455979B1AD6` (`company_id`),
  CONSTRAINT `FK_C7440455979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony-test.client: ~11 rows (approximately)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT IGNORE INTO `client` (`id`, `name`, `email`, `phone`, `company_id`) VALUES
	(1, 'name1', 'emai+1@email.email', '1234567', NULL),
	(2, 'name2', 'emai+2@email.email', '1234567', NULL),
	(3, 'name3', 'emai+3@email.com', '1234567', 21),
	(4, 'test', 'test+6@test.test', '88888888', NULL),
	(5, 'tetsName6', 'emai+6@email.com', '110', 6),
	(6, 'test', 'test+8@test.test', '2147483647', NULL),
	(7, 'test', 'testt@test.test', '9999999999', NULL),
	(9, 'test', 'test+11@email.com', '9999999999', NULL),
	(10, 'test', 'test+12@email.com', '12345678', 1),
	(12, 'Violette', 'test+14@test.com', '6666666666666', 2),
	(13, 'test9', 'test+9@test.com', '9999999999', 9);
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
