CREATE TABLE `%prefix%tables` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL,
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`settings` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
	COLLATE='utf8_general_ci'
	ENGINE=InnoDB
;


CREATE TABLE `%prefix%columns` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`table_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`index` INT(10) UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`)
)
	COLLATE='utf8_general_ci'
	ENGINE=InnoDB
;

CREATE TABLE `%prefix%rows` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`table_id` INT(10) UNSIGNED NULL DEFAULT NULL,
	`data` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
	COLLATE='utf8_general_ci'
	ENGINE=InnoDB
;

