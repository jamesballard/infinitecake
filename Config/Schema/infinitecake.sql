/*
SQLyog Community v10.5 Beta1
MySQL - 5.5.27-log : Database - infinitecake
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`infinitecake` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `infinitecake`;

/*Table structure for table `_conditions` */

DROP TABLE IF EXISTS `_conditions`;

CREATE TABLE `_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dimension_verb_id` int(11) unsigned DEFAULT NULL,
  `condition_id` int(11) unsigned DEFAULT NULL,
  `weight` int(5) DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verb_ix` (`dimension_verb_id`),
  KEY `condition_ix` (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acos` */

DROP TABLE IF EXISTS `acos`;

CREATE TABLE `acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alias_ix` (`alias`),
  KEY `left` (`lft`),
  KEY `right` (`rght`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `action_conditions` */

DROP TABLE IF EXISTS `action_conditions`;

CREATE TABLE `action_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(11) unsigned DEFAULT NULL,
  `condition_id` int(11) unsigned DEFAULT NULL,
  `weight` int(5) DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_ix` (`action_id`),
  KEY `condition_ix` (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `actions` */

DROP TABLE IF EXISTS `actions`;

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  `module_id` int(11) unsigned DEFAULT NULL,
  `dimension_verb_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `time_ix` (`time`),
  KEY `user_ix` (`user_id`),
  KEY `group_ix` (`group_id`),
  KEY `module_ix` (`module_id`),
  KEY `user_time_ix` (`user_id`,`time`),
  KEY `group_time_ix` (`group_id`,`time`),
  KEY `module_time_ix` (`module_id`,`time`),
  KEY `verb_ix` (`dimension_verb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `aros` */

DROP TABLE IF EXISTS `aros`;

CREATE TABLE `aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `aros_acos` */

DROP TABLE IF EXISTS `aros_acos`;

CREATE TABLE `aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) NOT NULL,
  `aco_id` int(11) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `artefact_conditions` */

DROP TABLE IF EXISTS `artefact_conditions`;

CREATE TABLE `artefact_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `artefact_id` int(11) unsigned DEFAULT NULL,
  `condition_id` int(11) unsigned DEFAULT NULL,
  `weight` int(5) DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_ix` (`condition_id`),
  KEY `artefact_ix` (`artefact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `artefacts` */

DROP TABLE IF EXISTS `artefacts`;

CREATE TABLE `artefacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idnumber` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` bigint(2) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idnumber` (`idnumber`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `conditions` */

DROP TABLE IF EXISTS `conditions`;

CREATE TABLE `conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `dimension_date` */

DROP TABLE IF EXISTS `dimension_date`;

CREATE TABLE `dimension_date` (
  `id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `day_of_week` int(11) NOT NULL,
  `day_of_week_name` char(10) NOT NULL,
  `day_of_month` int(11) NOT NULL,
  `day_of_year` int(11) NOT NULL,
  `weekend` int(2) NOT NULL DEFAULT '0',
  `month` int(11) NOT NULL,
  `month_name` char(10) NOT NULL,
  `month_day` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `week_starting_monday` int(11) NOT NULL,
  `week_starting_sunday` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`),
  KEY `year_week` (`year`,`week_starting_monday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `dimension_time` */

DROP TABLE IF EXISTS `dimension_time`;

CREATE TABLE `dimension_time` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fulltime` time NOT NULL,
  `hour` int(11) NOT NULL,
  `minute` int(11) NOT NULL,
  `ampm` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fulltime` (`fulltime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `dimension_verb` */

DROP TABLE IF EXISTS `dimension_verb`;

CREATE TABLE `dimension_verb` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sysname` char(100) NOT NULL,
  `name` char(100) DEFAULT NULL,
  `type` int(4) unsigned NOT NULL,
  `uri` char(255) DEFAULT NULL,
  `artefact_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sys_name` (`artefact_id`,`sysname`),
  KEY `artefact_ix` (`artefact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `fact_summed_actions_date` */

DROP TABLE IF EXISTS `fact_summed_actions_date`;

CREATE TABLE `fact_summed_actions_date` (
  `system_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `artefact_id` int(11) unsigned NOT NULL,
  `dimension_date_id` int(11) unsigned NOT NULL,
  `total` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`artefact_id`,`dimension_date_id`,`system_id`,`group_id`),
  KEY `user_ix` (`user_id`),
  KEY `artefact_ix` (`artefact_id`),
  KEY `date_ix` (`dimension_date_id`),
  KEY `system_ix` (`system_id`),
  KEY `group_ix` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `fact_summed_actions_datetime` */

DROP TABLE IF EXISTS `fact_summed_actions_datetime`;

CREATE TABLE `fact_summed_actions_datetime` (
  `system_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `artefact_id` int(11) unsigned NOT NULL,
  `dimension_date_id` int(11) unsigned NOT NULL,
  `dimension_time_id` int(11) unsigned NOT NULL,
  `total` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`artefact_id`,`dimension_date_id`,`system_id`,`group_id`,`dimension_time_id`),
  KEY `user_ix` (`user_id`),
  KEY `artefact_ix` (`artefact_id`),
  KEY `date_ix` (`dimension_date_id`),
  KEY `system_ix` (`system_id`),
  KEY `group_ix` (`group_id`),
  KEY `time_ix` (`dimension_time_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `fact_summed_verb_rule_date` */

DROP TABLE IF EXISTS `fact_summed_verb_rule_date`;

CREATE TABLE `fact_summed_verb_rule_date` (
  `system_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `rule_id` int(11) unsigned NOT NULL,
  `condition_id` int(11) unsigned NOT NULL,
  `dimension_date_id` int(11) unsigned NOT NULL,
  `total` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`system_id`,`group_id`,`user_id`,`rule_id`,`condition_id`,`dimension_date_id`),
  KEY `user_ix` (`user_id`),
  KEY `date_ix` (`dimension_date_id`),
  KEY `condition_ix` (`condition_id`),
  KEY `rule_ix` (`rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `fact_summed_verb_rule_datetime` */

DROP TABLE IF EXISTS `fact_summed_verb_rule_datetime`;

CREATE TABLE `fact_summed_verb_rule_datetime` (
  `system_id` int(11) unsigned NOT NULL,
  `rule_id` int(11) unsigned NOT NULL,
  `condition_id` int(11) unsigned NOT NULL,
  `dimension_time_id` int(11) unsigned NOT NULL,
  `total` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`rule_id`,`condition_id`,`dimension_time_id`,`system_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Table structure for table `group_conditions` */

DROP TABLE IF EXISTS `group_conditions`;

CREATE TABLE `group_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `condition_id` int(11) unsigned DEFAULT NULL,
  `weight` int(5) DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_ix` (`condition_id`),
  KEY `group_ix` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sysid` varchar(255) DEFAULT NULL,
  `idnumber` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `system_id` int(11) unsigned DEFAULT NULL,
  `community_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_group` (`system_id`,`sysid`),
  KEY `community_ix` (`community_id`),
  KEY `system_ix` (`system_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `members` */

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(40) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `membership_ix` (`membership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `memberships` */

DROP TABLE IF EXISTS `memberships`;

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `module_conditions` */

DROP TABLE IF EXISTS `module_conditions`;

CREATE TABLE `module_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) unsigned DEFAULT NULL,
  `condition_id` int(11) unsigned DEFAULT NULL,
  `weight` int(5) DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `condition_ix` (`condition_id`),
  KEY `module_ix` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sysid` varchar(255) DEFAULT NULL,
  `idnumber` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `artefact_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  `system_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_module` (`system_id`,`sysid`),
  KEY `artefact_ix` (`artefact_id`),
  KEY `group_ix` (`group_id`),
  KEY `system_ix` (`system_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `numbers` */

DROP TABLE IF EXISTS `numbers`;

CREATE TABLE `numbers` (
  `number` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `numbers_small` */

DROP TABLE IF EXISTS `numbers_small`;

CREATE TABLE `numbers_small` (
  `number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `persons` */

DROP TABLE IF EXISTS `persons`;

CREATE TABLE `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `ethnicity` varchar(255) DEFAULT NULL,
  `disability` varchar(255) DEFAULT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_ix` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sysid` varchar(255) DEFAULT NULL,
  `idnumber` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `group_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_ix` (`user_id`),
  KEY `group_ix` (`group_id`),
  KEY `role_ix` (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `rule_conditions` */

DROP TABLE IF EXISTS `rule_conditions`;

CREATE TABLE `rule_conditions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) unsigned DEFAULT NULL,
  `condition_id` int(11) unsigned DEFAULT NULL,
  `weight` int(5) DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rule_ix` (`rule_id`),
  KEY `condition_ix` (`condition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `rules` */

DROP TABLE IF EXISTS `rules`;

CREATE TABLE `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `type` int(2) unsigned DEFAULT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artefact_ix` (`type`),
  KEY `community_ix` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `systems` */

DROP TABLE IF EXISTS `systems`;

CREATE TABLE `systems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` bigint(4) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `certificate` text,
  `site_name` varchar(200) DEFAULT NULL,
  `contact_email` varchar(200) DEFAULT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `certificate` text,
  `site_name` varchar(200) DEFAULT NULL,
  `contact_email` varchar(200) DEFAULT NULL
  PRIMARY KEY (`id`),
  KEY `customer_ix` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sysid` varchar(255) DEFAULT NULL,
  `idnumber` varchar(255) DEFAULT NULL,
  `person_id` int(11) unsigned DEFAULT NULL,
  `system_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_user` (`system_id`,`sysid`),
  KEY `person_ix` (`person_id`),
  KEY `system_ix` (`system_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
