ALTER TABLE `orders`
CHANGE `status` `status` enum('wait','in progress','done','paid') COLLATE 'utf8_czech_ci' NOT NULL DEFAULT 'wait' AFTER `count`,
COMMENT='';