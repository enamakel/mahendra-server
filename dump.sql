# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.29)
# Database: mahendra
# Generation Time: 2016-06-18 20:49:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table chat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `chat`;

CREATE TABLE `chat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table job_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_roles`;

CREATE TABLE `job_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `job_roles` WRITE;
/*!40000 ALTER TABLE `job_roles` DISABLE KEYS */;

INSERT INTO `job_roles` (`id`, `name`)
VALUES
    (1,'CEO'),
    (2,'CTO'),
    (3,'CMD'),
    (4,'GM'),
    (5,'Finance Manager');

/*!40000 ALTER TABLE `job_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table job_sectors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_sectors`;

CREATE TABLE `job_sectors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `job_sectors` WRITE;
/*!40000 ALTER TABLE `job_sectors` DISABLE KEYS */;

INSERT INTO `job_sectors` (`id`, `name`)
VALUES
    (1,'Oil & Petrochemicals'),
    (2,'Audit & Assurance'),
    (3,'FMCG'),
    (4,'Pharmaceutical'),
    (5,'Banking Finance Service');

/*!40000 ALTER TABLE `job_sectors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) unsigned NOT NULL,
  `need` varchar(30) DEFAULT NULL,
  `job` varchar(30) DEFAULT NULL,
  `description` text,
  `location_id` int(11) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;

INSERT INTO `jobs` (`id`, `creator_id`, `need`, `job`, `description`, `location_id`, `type`)
VALUES
    (12,24,'Plumber','Water Proofing','for 2.5k ',1,NULL);

/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table leads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `leads`;

CREATE TABLE `leads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `job_sector_id` int(11) DEFAULT NULL,
  `job_role_id` int(11) DEFAULT NULL,
  `service_occupation_id` int(11) DEFAULT NULL,
  `service_name_id` int(11) DEFAULT NULL,
  `product_name_id` int(11) DEFAULT NULL,
  `product_channel_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `position` point DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;

INSERT INTO `leads` (`id`, `type_id`, `creator_id`, `description`, `job_sector_id`, `job_role_id`, `service_occupation_id`, `service_name_id`, `product_name_id`, `product_channel_id`, `location_id`, `position`, `created_at`)
VALUES
    (1,1,1,'I need a plumber',1,1,NULL,NULL,NULL,NULL,2,NULL,NULL),
    (3,2,3,'I need a dog',1,1,NULL,NULL,NULL,NULL,2,NULL,'2016-06-19 02:10:48');

/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `name`)
VALUES
    (1,'Dadar'),
    (2,'Mahim'),
    (3,'Andheri'),
    (4,'Borivali'),
    (5,'Mumbai'),
    (6,'Goregaon'),
    (7,'Churchgate'),
    (8,'Virar');

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `bizType` varchar(20) NOT NULL DEFAULT '',
  `location_id` int(11) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `job_sector_id` int(11) DEFAULT NULL,
  `job_role_id` int(11) DEFAULT NULL,
  `service_occupation_id` int(11) DEFAULT NULL,
  `service_name_id` int(11) DEFAULT NULL,
  `product_channel_id` int(11) DEFAULT NULL,
  `product_name_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;

INSERT INTO `login` (`id`, `name`, `email`, `phone`, `bizType`, `location_id`, `password`, `job_sector_id`, `job_role_id`, `service_occupation_id`, `service_name_id`, `product_channel_id`, `product_name_id`, `created_at`)
VALUES
    (24,'Bob','h','958588885','Individual',2,'h',1,1,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table postings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `postings`;

CREATE TABLE `postings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) unsigned NOT NULL,
  `need` varchar(30) DEFAULT NULL,
  `job` varchar(30) DEFAULT NULL,
  `description` text,
  `location_id` int(11) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table product_channels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_channels`;

CREATE TABLE `product_channels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_channels` WRITE;
/*!40000 ALTER TABLE `product_channels` DISABLE KEYS */;

INSERT INTO `product_channels` (`id`, `name`)
VALUES
    (1,'Producer Company'),
    (2,'Wholesaler'),
    (3,'Dealer'),
    (4,'Distributor'),
    (5,'Retailer'),
    (6,'Online Ecommerce');

/*!40000 ALTER TABLE `product_channels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_names`;

CREATE TABLE `product_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_names` WRITE;
/*!40000 ALTER TABLE `product_names` DISABLE KEYS */;

INSERT INTO `product_names` (`id`, `name`)
VALUES
    (1,'Computers'),
    (2,'Mobiles'),
    (3,'Automobiles'),
    (4,'Bike Scooter'),
    (5,'Printers');

/*!40000 ALTER TABLE `product_names` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table proposals
# ------------------------------------------------------------

DROP TABLE IF EXISTS `proposals`;

CREATE TABLE `proposals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `target_user_id` int(11) DEFAULT NULL,
  `req_user_id` int(11) DEFAULT NULL,
  `post_type` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table service_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service_names`;

CREATE TABLE `service_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `service_names` WRITE;
/*!40000 ALTER TABLE `service_names` DISABLE KEYS */;

INSERT INTO `service_names` (`id`, `name`)
VALUES
    (1,'Accounting'),
    (2,'Tax Return Filing'),
    (3,'Waterproofing'),
    (4,'Repairs & Maintenance'),
    (5,'Wiring');

/*!40000 ALTER TABLE `service_names` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table service_occupations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service_occupations`;

CREATE TABLE `service_occupations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `service_occupations` WRITE;
/*!40000 ALTER TABLE `service_occupations` DISABLE KEYS */;

INSERT INTO `service_occupations` (`id`, `name`)
VALUES
    (1,'Plumber'),
    (2,'Carpenter'),
    (3,'Charted Accountant'),
    (4,'Mechanic'),
    (5,'Electrician');

/*!40000 ALTER TABLE `service_occupations` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
