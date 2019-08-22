DROP TABLE IF EXISTS `geo_import`
;

CREATE TABLE `geo_import_tmp` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`geoname_id` VARCHAR(255) DEFAULT NULL,
	`locale_code` VARCHAR(255) DEFAULT NULL,
	`continent_code` VARCHAR(255) DEFAULT NULL,
	`continent_name` VARCHAR(255) DEFAULT NULL,
	`country_iso_code` VARCHAR(255) DEFAULT NULL,
	`country_name` VARCHAR(255) DEFAULT NULL,
	`subdivision_1_iso_code` VARCHAR(255) DEFAULT NULL,
	`subdivision_1_name` VARCHAR(255) DEFAULT NULL,
	`subdivision_2_iso_code` VARCHAR(255) DEFAULT NULL,
	`subdivision_2_name` VARCHAR(255) DEFAULT NULL,
	`city_name` VARCHAR(255) DEFAULT NULL,
	`metro_code` VARCHAR(255) DEFAULT NULL,
	`time_zone` VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY (`id`),
	FULLTEXT KEY `continent_name` (`continent_name`),
	FULLTEXT KEY `subdivision_1_name` (`subdivision_1_name`),
	FULLTEXT KEY `country_name` (`country_name`),
	FULLTEXT KEY `subdivision_2_name` (`subdivision_2_name`),
	FULLTEXT KEY `city_name` (`city_name`)
)
	ENGINE = MyISAM
	AUTO_INCREMENT = 1
	DEFAULT CHARSET = `utf8`
