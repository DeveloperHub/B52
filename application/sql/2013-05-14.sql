ALTER TABLE `orders`
CHANGE `status` `status` enum('in basket','wait','in progress','done','cancel','canceled','paid') COLLATE 'utf8_czech_ci' NOT NULL DEFAULT 'in basket' AFTER `count`,
COMMENT='';