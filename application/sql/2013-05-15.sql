ALTER TABLE `orders`
CHANGE `status` `status` enum('wait','in progress','done','paid') COLLATE 'utf8_czech_ci' NOT NULL DEFAULT 'wait' AFTER `count`,
COMMENT='';

ALTER TABLE `clients`
ADD UNIQUE `email` (`email`),
DROP INDEX `name`;

ALTER TABLE `clients`
CHANGE `password` `password` varchar(255) COLLATE 'utf8_czech_ci' NOT NULL AFTER `email`,
COMMENT='';