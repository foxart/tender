/*
Navicat MySQL Data Transfer

Source Server         : local@tender
Source Server Version : 100110
Source Host           : 10.100.73.57:3306
Source Database       : tender.foxart.org

Target Server Type    : MYSQL
Target Server Version : 100110
File Encoding         : 65001

Date: 2017-01-04 18:27:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_type_id` int(10) unsigned DEFAULT NULL,
  `authentication_id` int(10) unsigned DEFAULT NULL,
  `authorization_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_type_id` (`account_type_id`),
  KEY `authentication_id` (`authentication_id`),
  KEY `authorization_id` (`authorization_id`),
  CONSTRAINT `account_ibfk_1` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `account_ibfk_2` FOREIGN KEY (`authentication_id`) REFERENCES `authentication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `account_ibfk_3` FOREIGN KEY (`authorization_id`) REFERENCES `authorization` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', '1', '1', '1');
INSERT INTO `account` VALUES ('2', '1', '2', '2');
INSERT INTO `account` VALUES ('3', '2', '3', '3');
INSERT INTO `account` VALUES ('4', '3', '4', '4');
INSERT INTO `account` VALUES ('5', '1', '5', '5');
INSERT INTO `account` VALUES ('6', '2', '6', '6');
INSERT INTO `account` VALUES ('7', '2', '7', '7');
INSERT INTO `account` VALUES ('8', '2', '8', '8');
INSERT INTO `account` VALUES ('9', '2', '9', '1');
INSERT INTO `account` VALUES ('10', '3', '10', '2');
INSERT INTO `account` VALUES ('11', '3', '11', '3');
INSERT INTO `account` VALUES ('12', '2', '12', '4');
INSERT INTO `account` VALUES ('13', '2', '13', '5');
INSERT INTO `account` VALUES ('14', '1', '14', '6');
INSERT INTO `account` VALUES ('15', '2', '15', '7');
INSERT INTO `account` VALUES ('16', '1', '16', '8');
INSERT INTO `account` VALUES ('17', '1', '17', '1');
INSERT INTO `account` VALUES ('18', '2', '18', '2');

-- ----------------------------
-- Table structure for account_type
-- ----------------------------
DROP TABLE IF EXISTS `account_type`;
CREATE TABLE `account_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_type
-- ----------------------------
INSERT INTO `account_type` VALUES ('1', 'admin');
INSERT INTO `account_type` VALUES ('2', 'vendor');
INSERT INTO `account_type` VALUES ('3', 'purchaser');

-- ----------------------------
-- Table structure for authentication
-- ----------------------------
DROP TABLE IF EXISTS `authentication`;
CREATE TABLE `authentication` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` enum('true','false') DEFAULT 'false',
  `registered` enum('true','false') DEFAULT 'false',
  `login` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email_key` varchar(255) DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of authentication
-- ----------------------------
INSERT INTO `authentication` VALUES ('1', 'false', 'true', 'root@tender.com', 'root@tender.com', '6784e2ff9ecf064c1f3e473374c318e0', 'CfhQvKiverfim3sF0ONC', null, '2016-12-13 18:17:08');
INSERT INTO `authentication` VALUES ('2', 'true', 'true', 'admin@tender.com', 'admin@tender.com', '6784e2ff9ecf064c1f3e473374c318e0', 'CfhQvKiverfim3sF0ONC', null, '2016-12-14 11:01:36');
INSERT INTO `authentication` VALUES ('3', 'true', 'true', 'vendor@tender.com', 'vendor@tender.com', '6784e2ff9ecf064c1f3e473374c318e0', 'CfhQvKiverfim3sF0ONC', null, '2016-12-14 11:01:57');
INSERT INTO `authentication` VALUES ('4', 'false', 'true', 'purchaser@tender.com', 'purchaser@tender.com', '6784e2ff9ecf064c1f3e473374c318e0', 'CfhQvKiverfim3sF0ONC', null, '2016-12-13 18:14:48');
INSERT INTO `authentication` VALUES ('5', 'true', '', 'test-user-1@tender.com', 'test-user-1@tender.com', 'bdbb7de7bae81e7d7befc8337cea5f46', 'mAqMSL9VJcMVUuZ8RI2p', '', '2016-12-22 10:43:56');
INSERT INTO `authentication` VALUES ('6', 'false', '', 'test-user-2@tender.com', 'test-user-2@tender.com', '17fcdc8b1ad29ee1472046b15a54ab71', 'AQZAGC0Fj4BxqPuywXTz', '', '2016-12-22 11:00:29');
INSERT INTO `authentication` VALUES ('7', 'false', 'false', null, null, null, null, null, null);
INSERT INTO `authentication` VALUES ('8', 'false', 'true', 'raibeh@gmail.com111', 'raibeh@gmail.com111', '55d2262b04e17e30b7455064a6e22814', 'Dx63lvU4N1fusal8jxWn', 'XqDprCuAQois6jLlIv86', '2016-12-22 11:53:05');
INSERT INTO `authentication` VALUES ('9', 'false', '', 'purchaser-1@tender.com', 'purchaser-1@tender.com', '3a6a3c44b1c739223bb252a6bff92b80', 'wnp17qIfHgP6LZWsfbNE', '', '2016-12-22 11:54:51');
INSERT INTO `authentication` VALUES ('10', 'false', '', 'purchaser-2@tender.com', 'purchaser-2@tender.com', '3b26e2e7fb121760b7891442b9068ce6', '4ras6p794d8BAyygJFc7', '', '2016-12-22 11:55:03');
INSERT INTO `authentication` VALUES ('11', 'false', '', 'purchaser-3@tender.com', 'purchaser-3@tender.com', '0248cf3bdc32a456d1e02b63ac740c40', 'fxY0BAgcjB46ApnhamER', '', '2016-12-22 11:55:09');
INSERT INTO `authentication` VALUES ('12', 'false', '', 'vendor-1@tender.com', 'vendor-1@tender.com', '9138ec2631cb3e3bc93daaaec32c2b1b', '3thi2ijDoWG4rRvQ31mE', '', '2016-12-22 11:55:19');
INSERT INTO `authentication` VALUES ('13', 'false', '', 'vendor-2@tender.com', 'vendor-2@tender.com', 'b94dd8c7d97e617f89ff2c2cd1fb040f', 'cB2o3xdUuZxyuxIFwhX4', '', '2016-12-22 11:55:24');
INSERT INTO `authentication` VALUES ('14', 'true', 'true', 'admin@dd.com1', 'admin@dd.com1', '4ca71397798fd636bb39350e9aa50bd4', '1YRDc8U978SdZPHswwSX', null, '2016-12-22 12:29:15');
INSERT INTO `authentication` VALUES ('15', 'true', 'true', 'test-user-3@tender.com', 'test-user-3@tender.com', 'e7513f3c2b3bdd10fc1a5a11cf07fb72', '3d9pue4lpxgrjeZv9UVU', null, '2016-12-22 16:13:05');
INSERT INTO `authentication` VALUES ('16', 'true', 'false', 'test-user-1231@tender.com1', 'test-user-1231@tender.com1', '6c2623d8d6dfe7c193b73535fb758adf', 'S6wn0klVp8FCVv5aUVIN', 'bj7d7boExuaOMHuWIMYJ', '2016-12-23 17:09:34');
INSERT INTO `authentication` VALUES ('17', 'true', 'true', 'admin@txt.com', 'admin@txt.com', 'b3f06c9bea523a07216dfc82bb98584f', 'QRdZq0G1dMVicLDaP53s', null, '2016-12-27 11:12:03');
INSERT INTO `authentication` VALUES ('18', 'true', 'true', 'admin@txt.com1', 'admin@txt.com1', 'b19f7a2ea5004ccca10e8364b719f815', 'c5b77s25NVTG6slDmwua', 'BAXRlst03Iv8HWLBKetg', '2016-12-27 13:00:37');
INSERT INTO `authentication` VALUES ('19', 'true', 'true', 'admin@txt.com2', 'admin@txt.com2', '3356dbee8c66997719033d60e7690077', 'a0balxCCFbCaPiEU5HFr', null, '2016-12-27 17:28:46');
INSERT INTO `authentication` VALUES ('20', 'true', 'false', null, 'test-user@tender.com', 'aa4eee1a0c2f9cce2315afa0c22d4f6b', 'VvSzsUk0gBUpsPtKChou', 'RatBKf4ypH3jpgJmR9XE', '2017-01-03 14:56:09');
INSERT INTO `authentication` VALUES ('21', 'true', 'false', null, 'test-user-4@tender.com', '6b731f6704ab93fcc67ec5f1ef494260', '2oKAXyoc6UghQUr40xyh', 'WgE8u2ml0lL7j9rcLVvM', '2017-01-03 15:11:50');
INSERT INTO `authentication` VALUES ('22', 'true', 'false', null, 'test-user-5@tender.com', '87e2058efe595bb1cf19356fcc205229', 'XdJoSE6bOyTrtjBg5Kbg', 'nc7vyvlBl2mDXC7d6A6q', '2017-01-03 15:43:25');

-- ----------------------------
-- Table structure for authorization
-- ----------------------------
DROP TABLE IF EXISTS `authorization`;
CREATE TABLE `authorization` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of authorization
-- ----------------------------
INSERT INTO `authorization` VALUES ('1', 'root');
INSERT INTO `authorization` VALUES ('2', 'admin');
INSERT INTO `authorization` VALUES ('3', 'vendor');
INSERT INTO `authorization` VALUES ('4', 'purchaser');
INSERT INTO `authorization` VALUES ('5', 'qa');
INSERT INTO `authorization` VALUES ('6', 'section of head');
INSERT INTO `authorization` VALUES ('7', 'head of department');
INSERT INTO `authorization` VALUES ('8', 'test');

-- ----------------------------
-- Table structure for material
-- ----------------------------
DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `material_group_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uom` varchar(255) DEFAULT NULL,
  `po` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_group` (`material_group_id`),
  CONSTRAINT `material_fk_material_group` FOREIGN KEY (`material_group_id`) REFERENCES `material_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of material
-- ----------------------------
INSERT INTO `material` VALUES ('1', '1', 'd12345', 'sdfg', 'uom 123', 'po 777');
INSERT INTO `material` VALUES ('2', '1', 'test', 'qwer', 'uom 123', 'po 666');
INSERT INTO `material` VALUES ('3', '1', 'dsfg', 'qwer', 'wer', 'qwer');
INSERT INTO `material` VALUES ('4', '3', 'test1234', '1rew1', 'wertwert', 'erwtwret');
INSERT INTO `material` VALUES ('5', '3', 'test1', 'rewer', 'wqer', 'qwer');
INSERT INTO `material` VALUES ('6', '5', 'yrsdfg', 'sdfg', 'dsfg', 'dfsg');
INSERT INTO `material` VALUES ('7', '2', 'my full name', '123', '123', '123');
INSERT INTO `material` VALUES ('8', '5', 'wert', 'wert', 'wert', 'wert');

-- ----------------------------
-- Table structure for material_group
-- ----------------------------
DROP TABLE IF EXISTS `material_group`;
CREATE TABLE `material_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `material_group_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of material_group
-- ----------------------------
INSERT INTO `material_group` VALUES ('1', '1', 'material_group2');
INSERT INTO `material_group` VALUES ('2', '1', 'group1234');
INSERT INTO `material_group` VALUES ('3', null, 'mega group');
INSERT INTO `material_group` VALUES ('4', null, 'group3');
INSERT INTO `material_group` VALUES ('5', null, 'group2');
INSERT INTO `material_group` VALUES ('6', null, 'group');
INSERT INTO `material_group` VALUES ('7', null, 'group12');
INSERT INTO `material_group` VALUES ('8', null, 'group1');
INSERT INTO `material_group` VALUES ('9', null, 'group443');

-- ----------------------------
-- Table structure for procurex_admin
-- ----------------------------
DROP TABLE IF EXISTS `procurex_admin`;
CREATE TABLE `procurex_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profile_admin_fk_account` (`account_id`) USING BTREE,
  CONSTRAINT `profile_admin_fk_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of procurex_admin
-- ----------------------------
INSERT INTO `procurex_admin` VALUES ('1', '2', 'Ivan');
INSERT INTO `procurex_admin` VALUES ('2', '13', 'my full name');
INSERT INTO `procurex_admin` VALUES ('3', '14', 'my name');
INSERT INTO `procurex_admin` VALUES ('4', '15', 'name');
INSERT INTO `procurex_admin` VALUES ('8', '17', '1');
INSERT INTO `procurex_admin` VALUES ('9', '16', '2');
INSERT INTO `procurex_admin` VALUES ('10', '5', '3');

-- ----------------------------
-- Table structure for procurex_purchaser
-- ----------------------------
DROP TABLE IF EXISTS `procurex_purchaser`;
CREATE TABLE `procurex_purchaser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of procurex_purchaser
-- ----------------------------
INSERT INTO `procurex_purchaser` VALUES ('1', '4', 'Purchaser Name');

-- ----------------------------
-- Table structure for procurex_vendor
-- ----------------------------
DROP TABLE IF EXISTS `procurex_vendor`;
CREATE TABLE `procurex_vendor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `procurex_vendor_fk11_account` (`account_id`),
  CONSTRAINT `procurex_vendor_fk11_account` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of procurex_vendor
-- ----------------------------
INSERT INTO `procurex_vendor` VALUES ('1', '3', 'test name');
INSERT INTO `procurex_vendor` VALUES ('2', '9', 'Vendor Name 2');
INSERT INTO `procurex_vendor` VALUES ('3', '10', 'Vendor Name 3');
INSERT INTO `procurex_vendor` VALUES ('4', '11', 'Vendor Name 4');
INSERT INTO `procurex_vendor` VALUES ('5', '12', 'Vendor Name 5');

-- ----------------------------
-- Table structure for procurex_vendor_company
-- ----------------------------
DROP TABLE IF EXISTS `procurex_vendor_company`;
CREATE TABLE `procurex_vendor_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `procurex_vendor_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `procurex_vendor_company_fk1n_procurex_vendor` (`procurex_vendor_id`),
  CONSTRAINT `procurex_vendor_company_fk1n_procurex_vendor` FOREIGN KEY (`procurex_vendor_id`) REFERENCES `procurex_vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of procurex_vendor_company
-- ----------------------------
INSERT INTO `procurex_vendor_company` VALUES ('1', '1', 'Company1');
INSERT INTO `procurex_vendor_company` VALUES ('2', '1', 'Company2');
INSERT INTO `procurex_vendor_company` VALUES ('3', '2', 'Vendor Name 2');
INSERT INTO `procurex_vendor_company` VALUES ('4', '3', 'Vendor Name 3');
INSERT INTO `procurex_vendor_company` VALUES ('5', '4', 'Vendor Name 4');
INSERT INTO `procurex_vendor_company` VALUES ('6', '5', 'Vendor Name 5');
