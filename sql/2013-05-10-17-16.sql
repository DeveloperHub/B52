SET NAMES utf8;
SET foreign_key_checks = 0;


DROP TABLE `annexes`, `dips`;


ALTER TABLE `items`
CHANGE `quantity` `quantity` varchar(25) COLLATE 'utf8_czech_ci' NULL AFTER `detail`,
CHANGE `price` `price` decimal(13,2) NULL AFTER `quantity`,
COMMENT='';


CREATE TABLE `extras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `extras_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_extras` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  `quantity` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `price` decimal(13,2) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_extras` (`id_extras`),
  CONSTRAINT `extras_items_ibfk_2` FOREIGN KEY (`id_extras`) REFERENCES `extras` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `keys_categories_and_item_and_extras_items` (
  `id_categories` int(11) unsigned DEFAULT NULL,
  `id_items` int(10) unsigned DEFAULT NULL,
  `id_extras_items` int(10) unsigned NOT NULL,
  KEY `id_extras_items` (`id_extras_items`),
  KEY `id_items` (`id_items`),
  KEY `id_categories` (`id_categories`),
  CONSTRAINT `keys_categories_and_item_and_extras_items_ibfk_7` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `keys_categories_and_item_and_extras_items_ibfk_6` FOREIGN KEY (`id_items`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
