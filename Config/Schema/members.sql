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
USE `infinitecake`;

/*Data for the table `members` */

insert  into `members`(`id`,`username`,`password`,`firstname`,`lastname`,`email`,`timezone`,`membership_id`,`created`,`modified`) values (1,'admin','fdeca8fe42efb6651d4e7a0845e422d63927119e','Infinite Rooms','Admin','support@infiniterooms.co.uk',NULL,1,'2012-12-24 07:16:47','2013-01-15 03:24:07');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
