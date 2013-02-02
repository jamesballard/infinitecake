/*
SQLyog Community v10.5 Beta1
MySQL - 5.5.27-log 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

insert into `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) values('1',NULL,'Membership','1','Membership::Administrators','1','4');
insert into `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) values('2',NULL,'Membership','2','Membership::Managers','5','10');
insert into `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) values('3',NULL,'Membership','3','Membership::Users','11','12');
insert into `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) values('4','1','Member','1','Member::admin','2','3');
