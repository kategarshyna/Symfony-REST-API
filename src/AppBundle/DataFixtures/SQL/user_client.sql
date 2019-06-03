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

-- Dumping structure for table symfony-test.user_client
CREATE TABLE IF NOT EXISTS `user_client` (
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`client_id`),
  KEY `IDX_A2161F68A76ED395` (`user_id`),
  KEY `IDX_A2161F6819EB6921` (`client_id`),
  CONSTRAINT `FK_A2161F6819EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A2161F68A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table symfony-test.user_client: ~2 rows (approximately)
/*!40000 ALTER TABLE `user_client` DISABLE KEYS */;
INSERT IGNORE INTO `user_client` (`user_id`, `client_id`) VALUES
	(3, 3),
	(3, 5);
/*!40000 ALTER TABLE `user_client` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
