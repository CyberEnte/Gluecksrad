-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server-Version:               10.11.3-MariaDB-1:10.11.3+maria~ubu2204 - mariadb.org binary distribution
-- Server-Betriebssystem:        debian-linux-gnu
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportiere Daten aus Tabelle dcshop.shop_category: ~1 rows (ungefähr)
INSERT INTO `shop_category` (`id`, `shop`, `title`, `short_description`, `active`) VALUES
	(1, 1, 'Food & Drinks', 'Ob gemütlicher Teegenuss oder Pizza backen mit Freund:innen – diese Produkte werden deinen Hunger stillen und deinen Durst löschen! Lass deinen Tag mit einem kühlen Wein oder einem Glas Bier ausklingen.', 1);

-- Exportiere Daten aus Tabelle dcshop.shop_item: ~1 rows (ungefähr)
INSERT INTO `shop_item` (`id`, `shop`, `item_no`, `title`, `short_description`, `long_description`, `base_price`, `inventory`, `always_available`, `active`) VALUES
	(1, 1, 'A0001', 'Energy Drink', 'Batterien Leer? Kein Problem! Mit dem Energydrink von dc werden müde Geister munter und können auch in langen Meetings voll durchpowern.', '<h2>Weitere Informationen</h2>\r\n<ul>\r\n	<li>koffeinhaltiges Erfrischungsgetränk</li>\r\n	<li>im einzigartigen dc Design</li>\r\n	<li>eiskalt genießen</li>\r\n</ul>', 1.5, 100, 0, 1);

-- Exportiere Daten aus Tabelle dcshop.shop_item_category: ~1 rows (ungefähr)
INSERT INTO `shop_item_category` (`id`, `shop_item`, `shop_category`) VALUES
	(1, 1, 1);

-- Exportiere Daten aus Tabelle dcshop.shop_sales_header: ~0 rows (ungefähr)

-- Exportiere Daten aus Tabelle dcshop.shop_sales_line: ~0 rows (ungefähr)

-- Exportiere Daten aus Tabelle dcshop.shop_setup: ~0 rows (ungefähr)
INSERT INTO `shop_setup` (`id`, `shop_code`, `title`, `alert`, `shipping_cost`) VALUES
	(1, 'b2c', 'TinyShop', '+++ Neue Artikel verfügbar +++', 5.99);

-- Exportiere Daten aus Tabelle dcshop.shop_user_basket_header: ~0 rows (ungefähr)

-- Exportiere Daten aus Tabelle dcshop.shop_user_basket_line: ~0 rows (ungefähr)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
