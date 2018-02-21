
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Zrzut struktury tabela agihosting.domain
CREATE TABLE IF NOT EXISTS `domain` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domena` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `klientID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `dataUtworzenia` datetime NOT NULL,
  `dataWygasniecia` date NOT NULL,
  `aktywna` tinyint(3) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_polish_ci NOT NULL DEFAULT 'master' COMMENT 'master / slave',
  `masters` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'master servers ',
  `rekordA` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `rekordMX` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'oddzielone ;',
  `rekordNS` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL COMMENT 'oddzielone ;',
  `rekordCNAME` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `onCNAME` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'czy zamiast a i mx ma byc cname',
  `soaPrimary` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `soaEmail` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `soaSerial` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `soaRefresh` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `soaRetry` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `soaExpire` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `soaTTL` bigint(20) DEFAULT NULL,
  `checkResult` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'czy obslugujemy tę domenę',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Indeks 2` (`domena`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.


-- Zrzut struktury tabela agihosting.options
CREATE TABLE IF NOT EXISTS `options` (
  `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `options_name_uindex` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.


-- Zrzut struktury tabela agihosting.subdomain
CREATE TABLE IF NOT EXISTS `subdomain` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domainID` bigint(20) unsigned NOT NULL,
  `nazwa` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `typ` varchar(255) COLLATE utf8_polish_ci NOT NULL COMMENT 'A, MX, CNAME itd.',
  `wartosc` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__domain` (`domainID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.


-- Zrzut struktury tabela agihosting.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `isadmin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username_uindex` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
