/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 100128
Source Host           : localhost:3306
Source Database       : ajax_crud_ci_db

Target Server Type    : MYSQL
Target Server Version : 100128
File Encoding         : 65001

Date: 2017-11-23 18:10:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for books
-- ----------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_isbn` varchar(100) DEFAULT NULL,
  `book_title` varchar(100) DEFAULT NULL,
  `book_author` varchar(100) DEFAULT NULL,
  `book_category` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`book_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of books
-- ----------------------------
INSERT INTO `books` VALUES ('2', '7893', 'Laravel Tiger', 'Samnang', 'Programming');
INSERT INTO `books` VALUES ('3', '8934', 'Android Programming', 'Farrukh', 'Programming');
INSERT INTO `books` VALUES ('6', '8902', 'Intro to Psychology', 'Ayesha', 'Psychology');
INSERT INTO `books` VALUES ('7', '2345', 'Calculus-1', 'John doe', 'Math');
INSERT INTO `books` VALUES ('8', '8927', 'Chemistry Part-1', 'Aliza Mam', 'Chemistry');
INSERT INTO `books` VALUES ('9', '6723', 'Math Part-1', 'Sir Sohail Amanat', 'Math');
INSERT INTO `books` VALUES ('10', '7896', 'Javascript for begginners', 'Shami ', 'Programming');
INSERT INTO `books` VALUES ('11', '8978', 'iOS App ', 'Ehtesham Mehmood', 'Mobile Programming');
INSERT INTO `books` VALUES ('12', '8987', 'Physics', 'Sir Waqas', 'Physics');
INSERT INTO `books` VALUES ('13', '7890', 'HTML for dummies', 'Ehtesham Shami', 'Programming');
INSERT INTO `books` VALUES ('14', '1234', 'CodeIgniter Framework Introduction', 'Mutafaf', 'Programming');
INSERT INTO `books` VALUES ('15', '3143', 'Samnang Book', 'Im Samnang', 'Programming');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) NOT NULL,
  `cate_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`cate_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Programming', 'C#');
INSERT INTO `categories` VALUES ('2', 'Accounting', 'Account');
INSERT INTO `categories` VALUES ('6', 'Management', 'Management');
INSERT INTO `categories` VALUES ('7', 'English', 'English');

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id_item` varchar(12) NOT NULL,
  `title_item` varchar(80) NOT NULL,
  `content_item` text NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES ('5a16ac77afd8', 'chou kokpheng', 'chou kokpheng');

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES ('1', 'Samnang', 'Im', '39', '078343143', 'Siem Reap');
INSERT INTO `members` VALUES ('2', 'Same', 'Ratha', '29', '0936532118', 'Battambang');
INSERT INTO `members` VALUES ('3', 'Han', 'Siek Heng', '26', '012658423', 'Bakong');

-- ----------------------------
-- Table structure for persons
-- ----------------------------
DROP TABLE IF EXISTS `persons`;
CREATE TABLE `persons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of persons
-- ----------------------------
INSERT INTO `persons` VALUES ('1', 'Airi', 'Satou', 'female', 'Tokyo', '1964-03-04');
INSERT INTO `persons` VALUES ('2', 'Garrett', 'Winters', 'male', 'Tokyo', '1988-09-02');
INSERT INTO `persons` VALUES ('3', 'John', 'Doe', 'male', 'Kansas', '1972-11-02');
INSERT INTO `persons` VALUES ('4', 'Tatyana', 'Fitzpatrick', 'male', 'London', '1989-01-01');
INSERT INTO `persons` VALUES ('5', 'Quinn', 'Flynn', 'male', 'Edinburgh', '1977-03-24');
INSERT INTO `persons` VALUES ('6', 'Samnang', 'Im', 'female', 'Siem Reap', '1978-07-07');

-- ----------------------------
-- Table structure for programmer
-- ----------------------------
DROP TABLE IF EXISTS `programmer`;
CREATE TABLE `programmer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `skill` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of programmer
-- ----------------------------

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id_tag` varchar(12) NOT NULL,
  `name_tag` varchar(80) NOT NULL,
  PRIMARY KEY (`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tags
-- ----------------------------
INSERT INTO `tags` VALUES ('Anchor5a16ac', 'Anchor');
INSERT INTO `tags` VALUES ('Angkor5a16ac', 'Angkor');
INSERT INTO `tags` VALUES ('Bayon5a16ac7', 'Bayon');
INSERT INTO `tags` VALUES ('Tiger5a16ac7', 'Tiger');

-- ----------------------------
-- Table structure for tag_items
-- ----------------------------
DROP TABLE IF EXISTS `tag_items`;
CREATE TABLE `tag_items` (
  `id_item` varchar(12) NOT NULL,
  `id_tag` varchar(12) NOT NULL,
  PRIMARY KEY (`id_item`,`id_tag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tag_items
-- ----------------------------
INSERT INTO `tag_items` VALUES ('5a16ac77afd8', 'Anchor5a16ac');
INSERT INTO `tag_items` VALUES ('5a16ac77afd8', 'Angkor5a16ac');
INSERT INTO `tag_items` VALUES ('5a16ac77afd8', 'Bayon5a16ac7');
INSERT INTO `tag_items` VALUES ('5a16ac77afd8', 'Tiger5a16ac7');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Samnang', 'Im', 'Ami Haruna.jpg');
INSERT INTO `users` VALUES ('2', 'Same', 'Ratha', 'Haruna Kojima.PNG');
INSERT INTO `users` VALUES ('3', 'Han', 'Siekheng', 'Heng Kimlong.jpg');
INSERT INTO `users` VALUES ('4', 'Soun', 'Gnoun 2017', '2060781018.jpg');
INSERT INTO `users` VALUES ('5', 'Sok', 'Somalay', '188216794.jpg');
INSERT INTO `users` VALUES ('11', 'Kong', 'Pen', '552246052.jpg');
