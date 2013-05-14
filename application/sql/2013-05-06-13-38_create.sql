-- Adminer 3.6.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `b52` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `b52`;

CREATE TABLE `annexes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categories` int(11) unsigned DEFAULT NULL,
  `id_items` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  `quantity` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `price` decimal(13,2) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_categories` (`id_categories`),
  KEY `id_items` (`id_items`),
  CONSTRAINT `annexes_ibfk_4` FOREIGN KEY (`id_items`) REFERENCES `items` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `annexes_ibfk_3` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_categories` int(11) unsigned DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  `icon` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_categories` (`id_categories`),
  CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `dips` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categories` int(11) unsigned DEFAULT NULL,
  `id_items` int(10) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  `quantity` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `price` decimal(13,2) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_categories` (`id_categories`),
  KEY `id_items` (`id_items`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `flash_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `posted` datetime NOT NULL,
  `from` enum('system','waitress','client') COLLATE utf8_czech_ci NOT NULL,
  `to` enum('system','waitress','client') COLLATE utf8_czech_ci NOT NULL,
  `from_client` int(10) unsigned DEFAULT NULL,
  `to_client` int(10) unsigned DEFAULT NULL,
  `id_tables` int(10) unsigned DEFAULT NULL,
  `message` text COLLATE utf8_czech_ci NOT NULL,
  `unread` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_tables` (`id_tables`),
  KEY `from_client` (`from_client`),
  KEY `to_client` (`to_client`),
  CONSTRAINT `flash_messages_ibfk_9` FOREIGN KEY (`to_client`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `flash_messages_ibfk_7` FOREIGN KEY (`id_tables`) REFERENCES `tables` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `flash_messages_ibfk_8` FOREIGN KEY (`from_client`) REFERENCES `clients` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categories` int(11) unsigned NOT NULL,
  `type` enum('food','drink') COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  `quantity` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_categories` (`id_categories`),
  CONSTRAINT `items_ibfk_2` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `items_variations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_items` int(10) unsigned NOT NULL,
  `quantity` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `price` decimal(13,3) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_items` (`id_items`),
  CONSTRAINT `items_variations_ibfk_2` FOREIGN KEY (`id_items`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `route` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `icon` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_items` int(10) unsigned NOT NULL,
  `id_items_variations` int(10) unsigned DEFAULT NULL,
  `id_annexes` int(10) unsigned DEFAULT NULL,
  `id_dips` int(10) unsigned DEFAULT NULL,
  `id_tables` int(10) unsigned NOT NULL,
  `id_clients` int(10) unsigned NOT NULL,
  `ordered` datetime NOT NULL,
  `count` tinyint(3) unsigned NOT NULL,
  `status` enum('wait','in progress','done','cancel','canceled') COLLATE utf8_czech_ci NOT NULL DEFAULT 'wait',
  PRIMARY KEY (`id`),
  KEY `id_tables` (`id_tables`),
  KEY `id_items` (`id_items`),
  KEY `id_clients` (`id_clients`),
  KEY `id_items_variations` (`id_items_variations`),
  KEY `id_annexes` (`id_annexes`),
  KEY `id_dips` (`id_dips`),
  CONSTRAINT `orders_ibfk_15` FOREIGN KEY (`id_dips`) REFERENCES `dips` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_11` FOREIGN KEY (`id_items_variations`) REFERENCES `items_variations` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_14` FOREIGN KEY (`id_annexes`) REFERENCES `annexes` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_7` FOREIGN KEY (`id_tables`) REFERENCES `tables` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_8` FOREIGN KEY (`id_items`) REFERENCES `items` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_9` FOREIGN KEY (`id_clients`) REFERENCES `clients` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE `tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` tinyint(3) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `detail` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2013-05-09 13:36:19
