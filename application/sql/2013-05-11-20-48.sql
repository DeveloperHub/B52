ALTER TABLE `tables`
CHANGE `name` `name` varchar(100) COLLATE 'utf8_czech_ci' NULL AFTER `number`,
COMMENT='';


ALTER TABLE `orders`
DROP FOREIGN KEY `orders_ibfk_15`,
DROP FOREIGN KEY `orders_ibfk_14`;


ALTER TABLE `orders`
DROP `id_annexes`,
DROP `id_dips`,
ADD `extras_items` varchar(50) NULL AFTER `id_clients`,
CHANGE `id_tables` `id_tables` int(10) unsigned NULL AFTER `id_items_variations`,
CHANGE `ordered` `ordered` datetime NULL AFTER `extras_items`,
CHANGE `status` `status` enum('in basket','wait','in progress','done','cancel','canceled') COLLATE 'utf8_czech_ci' NOT NULL DEFAULT 'in basket' AFTER `count`,
COMMENT='';
