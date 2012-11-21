/*
SQLyog Community v10.4 Beta1
MySQL - 5.5.24 : Database - infinitecake
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`infinitecake` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `infinitecake`;

/*Table structure for table `action` */

DROP TABLE IF EXISTS `action`;

CREATE TABLE `action` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `time` bigint(10) unsigned DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `module` varchar(20) DEFAULT NULL,
  `user` bigint(10) unsigned DEFAULT NULL,
  `group` bigint(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=491506 DEFAULT CHARSET=utf8;

/*Table structure for table `action_by_user_day` */

DROP TABLE IF EXISTS `action_by_user_day`;

CREATE TABLE `action_by_user_day` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint(10) unsigned DEFAULT NULL,
  `group` bigint(10) unsigned DEFAULT NULL,
  `module` varchar(20) DEFAULT NULL,
  `action` varchar(60) DEFAULT NULL,
  `time` bigint(10) unsigned DEFAULT NULL,
  `total` bigint(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `day_add_ix` (`user`,`group`,`module`,`action`,`time`),
  KEY `user_ix` (`user`,`time`),
  KEY `group_ix` (`group`,`time`),
  KEY `user_group_ix` (`user`,`group`,`time`)
) ENGINE=MyISAM AUTO_INCREMENT=104381 DEFAULT CHARSET=utf8;

/*Table structure for table `action_by_user_hour` */

DROP TABLE IF EXISTS `action_by_user_hour`;

CREATE TABLE `action_by_user_hour` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint(10) unsigned DEFAULT NULL,
  `group` bigint(10) unsigned DEFAULT NULL,
  `module` varchar(20) DEFAULT NULL,
  `action` varchar(60) DEFAULT NULL,
  `hour` bigint(2) unsigned DEFAULT NULL,
  `time` bigint(10) unsigned DEFAULT NULL,
  `total` bigint(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hour_add_ix` (`user`,`group`,`module`,`action`,`hour`,`time`),
  KEY `user_ix` (`user`,`hour`),
  KEY `group_ix` (`group`,`hour`),
  KEY `user_group_ix` (`user`,`group`,`hour`)
) ENGINE=MyISAM AUTO_INCREMENT=140957 DEFAULT CHARSET=utf8;

/*Table structure for table `action_by_user_month` */

DROP TABLE IF EXISTS `action_by_user_month`;

CREATE TABLE `action_by_user_month` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint(10) unsigned DEFAULT NULL,
  `group` bigint(10) unsigned DEFAULT NULL,
  `module` varchar(20) DEFAULT NULL,
  `action` varchar(60) DEFAULT NULL,
  `time` bigint(10) unsigned DEFAULT NULL,
  `total` bigint(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `month_add_ix` (`user`,`group`,`module`,`action`,`time`),
  KEY `user_ix` (`user`,`time`),
  KEY `group_ix` (`group`,`time`),
  KEY `user_group_ix` (`user`,`group`,`time`)
) ENGINE=MyISAM AUTO_INCREMENT=60429 DEFAULT CHARSET=utf8;

/*Table structure for table `action_by_user_week` */

DROP TABLE IF EXISTS `action_by_user_week`;

CREATE TABLE `action_by_user_week` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint(10) unsigned DEFAULT NULL,
  `group` bigint(10) unsigned DEFAULT NULL,
  `module` varchar(20) DEFAULT NULL,
  `action` varchar(60) DEFAULT NULL,
  `year` bigint(4) unsigned DEFAULT NULL,
  `week` bigint(2) unsigned DEFAULT NULL,
  `total` bigint(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `week_add_ix` (`user`,`group`,`module`,`action`,`year`,`week`),
  KEY `user_ix` (`user`,`year`,`week`),
  KEY `group_ix` (`group`,`year`,`week`),
  KEY `user_group_ix` (`user`,`group`,`year`,`week`)
) ENGINE=MyISAM AUTO_INCREMENT=77053 DEFAULT CHARSET=utf8;

/*Table structure for table `artefact` */

DROP TABLE IF EXISTS `artefact`;

CREATE TABLE `artefact` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `idnumber` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `group` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `community` */

DROP TABLE IF EXISTS `community`;

CREATE TABLE `community` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `customer` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `condition` */

DROP TABLE IF EXISTS `condition`;

CREATE TABLE `condition` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `group` */

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idnumber` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `system` bigint(20) unsigned DEFAULT NULL,
  `community` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `person` */

DROP TABLE IF EXISTS `person`;

CREATE TABLE `person` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `ethnicity` varchar(255) DEFAULT NULL,
  `disability` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `user` bigint(20) unsigned DEFAULT NULL,
  `group` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `system` */

DROP TABLE IF EXISTS `system`;

CREATE TABLE `system` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idnumber` varchar(255) DEFAULT NULL,
  `person` bigint(20) unsigned DEFAULT NULL,
  `system` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Trigger structure for table `action` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `aggregrate_action_by_user` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `aggregrate_action_by_user` BEFORE INSERT ON `action` FOR EACH ROW BEGIN
	DECLARE hour_id INTEGER;
	DECLARE hour_total INTEGER;
	DECLARE day_id INTEGER;
	DECLARE day_total INTEGER;
	DECLARE week_id INTEGER;
	DECLARE week_total INTEGER;
	DECLARE month_id INTEGER;
	DECLARE month_total INTEGER;
	
	SELECT id INTO hour_id
	  FROM action_by_user_hour
	  WHERE `user` = new.user AND
		`group` = new.group AND
		`module` = new.module AND
		`action` = new.name AND
		`time` = UNIX_TIMESTAMP(FROM_UNIXTIME(new.time, '%Y-%m-%d %H:00:00')) AND
                `hour` = FROM_UNIXTIME(new.time, '%H');	
        
        SELECT total INTO hour_total
	    FROM action_by_user_hour
	    WHERE `id` = hour_id;
                
        IF hour_total > 0 THEN 
	  UPDATE action_by_user_hour
	    SET total = hour_total+1
	    WHERE `id` = hour_id;
	
	ELSE
	  INSERT INTO action_by_user_hour
	    (`user`, `group`, `module`, `action`, `time`, `hour`, `total`)
	    VALUES (new.user, new.group, new.module, new.name, UNIX_TIMESTAMP(FROM_UNIXTIME(new.time, '%Y-%m-%d %H:00:00')), FROM_UNIXTIME(new.time, '%H'), 1);   
	END IF;
	
	SELECT id INTO day_id
	  FROM action_by_user_day
	  WHERE `user` = new.user AND
		`group` = new.group AND
		`module` = new.module AND
		`action` = new.name AND
		`time` = UNIX_TIMESTAMP(FROM_UNIXTIME(new.time, '%Y-%m-%d'));	
        
        SELECT total INTO day_total
	    FROM action_by_user_day
	    WHERE `id` = day_id;
                
        IF day_total > 0 THEN 
	  UPDATE action_by_user_day
	    SET total = day_total+1
	    WHERE `id` = day_id;
	
	ELSE
	  INSERT INTO action_by_user_day
	    (`user`, `group`, `module`, `action`, `time`, `total`)
	    VALUES (new.user, new.group, new.module, new.name, UNIX_TIMESTAMP(FROM_UNIXTIME(new.time, '%Y-%m-%d')), 1);   
	END IF;
	
	SELECT id INTO week_id
	  FROM action_by_user_week
	  WHERE `user` = new.user AND
		`group` = new.group AND
		`module` = new.module AND
		`action` = new.name AND
		`year` = FROM_UNIXTIME(new.time, '%x') AND
                `week` = FROM_UNIXTIME(new.time, '%v');	
        
        SELECT total INTO week_total
	    FROM action_by_user_week
	    WHERE `id` = week_id;
                
        IF week_total > 0 THEN 
	  UPDATE action_by_user_week
	    SET total = week_total+1
	    WHERE `id` = week_id;
	
	ELSE
	  INSERT INTO action_by_user_week
	    (`user`, `group`, `module`, `action`, `year`, `week`, `total`)
	    VALUES (new.user, new.group, new.module, new.name, FROM_UNIXTIME(new.time, '%x'), FROM_UNIXTIME(new.time, '%v'), 1);   
	END IF;
	
	SELECT id INTO month_id
	  FROM action_by_user_month
	  WHERE `user` = new.user AND
		`group` = new.group AND
		`module` = new.module AND
		`action` = new.name AND
		`time` = UNIX_TIMESTAMP(FROM_UNIXTIME(new.time, '%Y-%m-01'));	
        
        SELECT total INTO month_total
	    FROM action_by_user_month
	    WHERE `id` = month_id;
                
        IF month_total > 0 THEN 
	  UPDATE action_by_user_month
	    SET total = month_total+1
	    WHERE `id` = month_id;
	
	ELSE
	  INSERT INTO action_by_user_month
	    (`user`, `group`, `module`, `action`, `time`, `total`)
	    VALUES (new.user, new.group, new.module, new.name, UNIX_TIMESTAMP(FROM_UNIXTIME(new.time, '%Y-%m-01')), 1);   
	END IF;
	
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
