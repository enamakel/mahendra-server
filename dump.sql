# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.29)
# Database: mahendra
# Generation Time: 2016-06-30 10:50:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table business_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `business_types`;

CREATE TABLE `business_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table job_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_roles`;

CREATE TABLE `job_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT '',
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `job_roles` WRITE;
/*!40000 ALTER TABLE `job_roles` DISABLE KEYS */;

INSERT INTO `job_roles` (`id`, `name`, `description`)
VALUES
    (1,'CEO','Chief Executive Officer'),
    (2,'CTO',NULL),
    (3,'CMD',NULL),
    (4,'GM',NULL),
    (5,'Finance Manager',NULL);

/*!40000 ALTER TABLE `job_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table job_sectors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `job_sectors`;

CREATE TABLE `job_sectors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `job_sectors` WRITE;
/*!40000 ALTER TABLE `job_sectors` DISABLE KEYS */;

INSERT INTO `job_sectors` (`id`, `name`, `description`)
VALUES
    (1,'Oil & Petrochemicals',NULL),
    (2,'Audit & Assurance',NULL),
    (3,'FMCG',NULL),
    (4,'Pharmaceutical',NULL),
    (5,'Banking Finance Service',NULL);

/*!40000 ALTER TABLE `job_sectors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table leads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `leads`;

CREATE TABLE `leads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `is_job_seeker` tinyint(1) DEFAULT NULL,
  `job_sector_id` int(11) DEFAULT NULL,
  `job_role_id` int(11) DEFAULT NULL,
  `is_product_seeker` tinyint(1) DEFAULT NULL,
  `product_channel_id` int(11) DEFAULT NULL,
  `product_name_id` int(11) DEFAULT NULL,
  `is_service_seeker` tinyint(1) DEFAULT NULL,
  `service_name_id` int(11) DEFAULT NULL,
  `service_occupation_id` int(11) DEFAULT NULL,
  `position` point DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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
  `phone` varchar(30) NOT NULL,
  `bizType` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `position` point DEFAULT NULL,
  `app_version` int(11) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `text` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `proposal_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table product_channels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_channels`;

CREATE TABLE `product_channels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_channels` WRITE;
/*!40000 ALTER TABLE `product_channels` DISABLE KEYS */;

INSERT INTO `product_channels` (`id`, `name`, `description`)
VALUES
    (1,'Producer Company',NULL),
    (2,'Wholesaler',NULL),
    (3,'Dealer',NULL),
    (4,'Distributor',NULL),
    (5,'Retailer',NULL),
    (6,'Online Ecommerce',NULL);

/*!40000 ALTER TABLE `product_channels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_names`;

CREATE TABLE `product_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_names` WRITE;
/*!40000 ALTER TABLE `product_names` DISABLE KEYS */;

INSERT INTO `product_names` (`id`, `name`, `description`)
VALUES
    (1,'Computers',NULL),
    (2,'Mobiles',NULL),
    (3,'Automobiles',NULL),
    (4,'Bike Scooter',NULL),
    (5,'Printers',NULL);

/*!40000 ALTER TABLE `product_names` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table proposals
# ------------------------------------------------------------

DROP TABLE IF EXISTS `proposals`;

CREATE TABLE `proposals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `engaging_user_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_lead` (`engaging_user_id`,`lead_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table relations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `relations`;

CREATE TABLE `relations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `proposal_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `job_role_id` int(11) DEFAULT NULL,
  `job_sector_id` int(11) DEFAULT NULL,
  `product_channel_id` int(11) DEFAULT NULL,
  `product_name_id` int(11) DEFAULT NULL,
  `service_name_id` int(11) DEFAULT NULL,
  `service_occupation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ujr` (`user_id`,`job_role_id`),
  KEY `ujss` (`user_id`,`job_sector_id`),
  KEY `upc` (`user_id`,`product_channel_id`),
  KEY `usn` (`user_id`,`service_name_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table service_names
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service_names`;

CREATE TABLE `service_names` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `service_names` WRITE;
/*!40000 ALTER TABLE `service_names` DISABLE KEYS */;

INSERT INTO `service_names` (`id`, `name`, `description`)
VALUES
    (1,'Accounting',NULL),
    (2,'Tax Return Filing',NULL),
    (3,'Waterproofing',NULL),
    (4,'Repairs & Maintenance',NULL),
    (5,'Wiring',NULL);

/*!40000 ALTER TABLE `service_names` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table service_occupations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service_occupations`;

CREATE TABLE `service_occupations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `service_occupations` WRITE;
/*!40000 ALTER TABLE `service_occupations` DISABLE KEYS */;

INSERT INTO `service_occupations` (`id`, `name`, `description`)
VALUES
    (1,'Plumber',NULL),
    (2,'Carpenter',NULL),
    (3,'Charted Accountant',NULL),
    (4,'Mechanic',NULL),
    (5,'Electrician',NULL);

/*!40000 ALTER TABLE `service_occupations` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
