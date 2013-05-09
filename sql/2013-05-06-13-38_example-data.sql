-- Adminer 3.6.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `b52`;

TRUNCATE `annexes`;

TRUNCATE `categories`;
INSERT INTO `categories` (`id`, `id_categories`, `name`, `detail`, `icon`, `active`) VALUES
(1,	NULL,	'Jídla',	'',	'food',	1),
(2,	NULL,	'Nápoje',	'',	'glass',	1),
(3,	NULL,	'Dezerty',	'',	'coffee',	1),
(4,	1,	'Polévky',	'',	'',	1),
(5,	1,	'Saláty',	'',	'',	1),
(6,	1,	'Burgry',	'',	'',	1),
(7,	2,	'Horké nápoje',	'',	'',	1),
(8,	2,	'Piva',	'',	'',	1),
(9,	2,	'Vína',	'',	'',	1);

TRUNCATE `clients`;
INSERT INTO `clients` (`id`, `name`, `email`, `password`) VALUES
(1,	'Ladislav Vondráček',	'',	''),
(2,	'Radim Daniel Pánek',	'',	''),
(3,	'Léňa Lišková',	'',	''),
(4,	'Veronika Králová',	'',	'');

TRUNCATE `dips`;

TRUNCATE `flash_messages`;
INSERT INTO `flash_messages` (`id`, `posted`, `from`, `to`, `from_client`, `to_client`, `id_tables`, `message`, `unread`) VALUES
(1,	'2013-05-08 20:11:00',	'waitress',	'client',	NULL,	1,	NULL,	'Připravují objednávku: 1x Staropramen 11°',	1),
(2,	'2013-05-08 20:11:02',	'waitress',	'client',	NULL,	1,	NULL,	'Nesou objednávku: 1x Staropramen 11°',	1),
(3,	'2013-05-08 20:11:03',	'waitress',	'client',	NULL,	4,	NULL,	'Zrušili objednávku: 1x Rozlévaná vína',	1);

TRUNCATE `items`;
INSERT INTO `items` (`id`, `id_categories`, `type`, `name`, `detail`, `quantity`, `price`, `active`) VALUES
(1,	4,	'food',	'Tomatová s bazalkou a parmezánem',	'',	'',	45.00,	1),
(2,	4,	'food',	'Francouzská cibulačka se slaninou',	'',	'',	45.00,	1),
(3,	5,	'food',	'S flambovanými hruškami a vlašskými ořechy',	'',	'',	139.00,	1),
(4,	5,	'food',	'S grilovaným kuřecím masem',	'',	'',	139.00,	1),
(5,	5,	'food',	'S grilovanou vepřovou panenkou',	'',	'',	169.00,	1),
(6,	6,	'food',	'Hamburger',	'(hovězí, salát, rajče, cibule)',	'180g',	129.00,	1),
(7,	6,	'food',	'Cheeseburger',	'(hovězí, čedar, salát, rajče, cibule)',	'180g',	139.00,	1),
(8,	6,	'food',	'Cheese-Bacon burger',	'(hovězí, slanina, čedar, salát, rajče, cibule)',	'180g',	149.00,	1),
(9,	7,	'drink',	'Espresso Ristretto',	'1/2 malého šálku 8 gr/20 ml – krátké extra silné espreso.',	'',	35.00,	1),
(10,	7,	'drink',	'Espresso Piccolo',	'Malý šálek 8 gr/40 ml – silná aromatická káva.',	'',	35.00,	1),
(11,	7,	'drink',	'Latte Macchiato',	'sklo 1/3 horké mléko, 1/3 espreso, 1/3 mléčná pěna',	'',	47.00,	1),
(12,	8,	'drink',	'Staropramen 11°',	'',	'0,3l',	23.00,	1),
(14,	8,	'drink',	'Staropramen Granát',	'',	'0,4l',	29.00,	1),
(15,	9,	'drink',	'Rozlévaná vína',	'bílé, červené, růžové/bílé, červené, růžové',	'0,2l',	36.00,	1),
(16,	9,	'drink',	'Bohemia Demi sec',	'',	'0,75l',	235.00,	1),
(17,	9,	'drink',	'O´porto royal Ruby',	'',	'0,1l',	65.00,	1),
(18,	3,	'food',	'Brownie se zmrzlinou',	'',	'',	65.00,	1),
(19,	3,	'food',	'Tvarohový koláč',	'',	'',	75.00,	1),
(20,	3,	'food',	'Lívance s javorovým sirupem, zakysanou smetanou a ovocem',	'',	'',	105.00,	1);

TRUNCATE `items_variations`;
INSERT INTO `items_variations` (`id`, `id_items`, `quantity`, `price`, `active`) VALUES
(1,	12,	'0,3l',	23.000,	1),
(2,	12,	'0,5l',	29.000,	1),
(3,	6,	'180g',	129.000,	1),
(4,	6,	'250g',	159.000,	1),
(5,	7,	'180g',	139.000,	1),
(6,	7,	'250g',	169.000,	1),
(7,	8,	'180g',	149.000,	1),
(8,	8,	'250g',	179.000,	1);

TRUNCATE `main_menu`;
INSERT INTO `main_menu` (`id`, `name`, `route`, `icon`) VALUES
(1,	'Novinky',	'News:default',	'twitter');

TRUNCATE `orders`;
INSERT INTO `orders` (`id`, `id_items`, `id_items_variations`, `id_annexes`, `id_dips`, `id_tables`, `id_clients`, `ordered`, `count`, `status`) VALUES
(1,	1,	NULL,	NULL,	NULL,	1,	1,	'2013-05-08 15:36:59',	1,	'wait'),
(2,	12,	2,	NULL,	NULL,	1,	1,	'2013-05-08 15:37:00',	1,	'wait'),
(3,	6,	4,	NULL,	NULL,	1,	2,	'2013-05-08 15:38:37',	1,	'wait'),
(4,	14,	NULL,	NULL,	NULL,	1,	2,	'2013-05-08 15:39:46',	1,	'done'),
(5,	18,	NULL,	NULL,	NULL,	2,	3,	'2013-05-08 15:40:55',	1,	'wait'),
(6,	9,	NULL,	NULL,	NULL,	2,	3,	'2013-05-08 15:41:49',	1,	'done'),
(7,	19,	NULL,	NULL,	NULL,	2,	4,	'2013-05-08 15:43:07',	1,	'wait'),
(8,	15,	NULL,	NULL,	NULL,	2,	4,	'2013-05-08 15:43:48',	1,	'canceled');

TRUNCATE `tables`;
INSERT INTO `tables` (`id`, `number`, `name`, `detail`) VALUES
(1,	1,	'',	''),
(2,	2,	'',	''),
(3,	3,	'',	''),
(4,	4,	'',	''),
(5,	5,	'',	'');

-- 2013-05-09 13:42:51
