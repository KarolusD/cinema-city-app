-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               10.1.32-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win32
-- HeidiSQL Wersja:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Zrzut struktury bazy danych cinema_city
CREATE DATABASE IF NOT EXISTS `cinema_city` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `cinema_city`;

-- Zrzut struktury tabela cinema_city.cache_info
CREATE TABLE IF NOT EXISTS `cache_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cinema_id` varchar(255) NOT NULL DEFAULT '0',
  `data` varchar(255) NOT NULL DEFAULT '0',
  `time` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Zrzut struktury tabela cinema_city.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` varchar(255) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `cinema_id` varchar(255) NOT NULL DEFAULT '0',
  `length` varchar(255) NOT NULL DEFAULT '0',
  `time` varchar(255) NOT NULL DEFAULT '0',
  `data` varchar(255) NOT NULL DEFAULT '0',
  `booking_link` varchar(255) NOT NULL DEFAULT '0',
  `poster_link` varchar(255) NOT NULL DEFAULT '0',
  `attributeIds` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
