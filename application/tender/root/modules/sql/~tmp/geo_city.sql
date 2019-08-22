/*
Navicat MySQL Data Transfer

Source Server         : Ivan PC at the Job
Source Server Version : 100110
Source Host           : 10.100.73.57:3306
Source Database       : tender.foxart.org

Target Server Type    : MYSQL
Target Server Version : 100110
File Encoding         : 65001

Date: 2017-03-02 18:06:36
*/

SET FOREIGN_KEY_CHECKS = 0
;

-- ----------------------------
-- Table structure for geo_city
-- ----------------------------
DROP TABLE IF EXISTS `geo_city`
;

CREATE TABLE `geo_city` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`geo_continent_id` INT(10) UNSIGNED DEFAULT NULL,
	`geo_country_id` INT(10) UNSIGNED DEFAULT NULL,
	`geo_region_id` INT(10) UNSIGNED DEFAULT NULL,
	`geo_division_id` INT(10) UNSIGNED DEFAULT NULL,
	`geo_timezone_id` INT(10) UNSIGNED DEFAULT NULL,
	`geo` INT(10) DEFAULT NULL,
	`name` VARCHAR(100) DEFAULT NULL,
	PRIMARY KEY (`id`)
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 94172
	DEFAULT CHARSET = `utf8`
;
