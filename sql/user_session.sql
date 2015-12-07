/*
SQLyog Community v11.52 (64 bit)
MySQL - 5.0.77 : Database - phn20_nightly
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `UserSession` */

DROP TABLE IF EXISTS `UserSession`;

CREATE TABLE `UserSession` (
  `SessionId` varchar(255) NOT NULL,
  `SessionData` longtext,
  `SessionTime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`SessionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `UserSession` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


// Chnages added for qst_1278 Start :: 1

// Chnages added for qst_1278 End :: 1