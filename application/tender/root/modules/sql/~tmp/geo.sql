/*
Navicat MySQL Data Transfer

Source Server         : Ivan PC at the Job
Source Server Version : 100110
Source Host           : 10.100.73.57:3306
Source Database       : tender.foxart.org

Target Server Type    : MYSQL
Target Server Version : 100110
File Encoding         : 65001

Date: 2017-03-01 16:46:57
*/

SET FOREIGN_KEY_CHECKS = 0
;

-- ----------------------------
-- Table structure for geo
-- ----------------------------
DROP TABLE IF EXISTS `geo`
;

CREATE TABLE `geo` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`geo_continent` INT(10) UNSIGNED DEFAULT NULL,
	`geo_country` INT(10) UNSIGNED DEFAULT NULL,
	`geo_city` INT(10) UNSIGNED DEFAULT NULL,
	`geo_region` INT(10) UNSIGNED DEFAULT NULL,
	`geo_division` INT(10) UNSIGNED DEFAULT NULL,
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
	KEY `geo_continent` (`geo_continent`),
	KEY `geo_country` (`geo_country`),
	KEY `geo_region` (`geo_region`),
	KEY `geo_division` (`geo_division`),
	KEY `geo_city` (`geo_city`),
	FULLTEXT KEY `continent_name` (`continent_name`),
	FULLTEXT KEY `subdivision_1_name` (`subdivision_1_name`),
	FULLTEXT KEY `country_name` (`country_name`),
	FULLTEXT KEY `subdivision_2_name` (`subdivision_2_name`),
	FULLTEXT KEY `city_name` (`city_name`)
)
	ENGINE = MyISAM
	AUTO_INCREMENT = 95549
	DEFAULT CHARSET = `utf8`
;
