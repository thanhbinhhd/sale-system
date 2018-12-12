# ************************************************************
# Sequel Pro SQL dump
# Version 5425
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.13)
# Database: team_collaborate
# Generation Time: 2018-12-12 15:35:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`id`, `name`, `username`, `password`, `remember_token`, `status`, `created_at`, `updated_at`)
VALUES
	(1,NULL,'asAdmin','$2y$10$RqJdzTbVgIQ3EAI.uu3cJeF7.zkk6XZRsfus29d0vKX5msn2PuYo.',NULL,1,NULL,NULL),
	(2,NULL,'testadmin01','$2y$10$/3VqL3kDowlIecsVF1hYYOEYR9fHvG6BAuyWrIY8CBdCQMK.NZnn6',NULL,1,NULL,NULL);

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table channels
# ------------------------------------------------------------

DROP TABLE IF EXISTS `channels`;

CREATE TABLE `channels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: public, 1:private, 2: protected',
  `creator` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: active, 0: inactive',
  `channel_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;

INSERT INTO `channels` (`id`, `type`, `creator`, `name`, `purpose`, `description`, `status`, `channel_id`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,0,1,'General','This channel is for workspace-wide communication and announcements. All members are in this channel.','No description',1,'#ASTEAMK60',NULL,NULL,NULL),
	(3,2,2,'Hoang Quang','Direct Messages between Hoang Quang',NULL,1,'7LN3XOBVXU3',NULL,'2018-12-12 16:30:14','2018-12-12 16:30:14'),
	(4,2,3,'Hoang QuangQuang Hoàng','Direct Messages between Hoang QuangQuang Hoàng',NULL,1,'ZWE9DECD1N4',NULL,'2018-12-12 16:35:25','2018-12-12 16:35:25'),
	(7,0,1,'quangdeptrai','ahdadasndasd',NULL,1,'IF365MYVGT7',NULL,'2018-12-12 18:26:13','2018-12-12 18:26:13');

/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_first_id` int(11) NOT NULL COMMENT 'Id of relating user',
  `user_second_id` int(11) NOT NULL COMMENT 'Id of related user',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'friend: 0, block: 1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table facebook_social_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facebook_social_accounts`;

CREATE TABLE `facebook_social_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_image` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not image, 1: image',
  `creator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;

INSERT INTO `files` (`id`, `file_path`, `file_name`, `is_image`, `creator`, `channel_id`, `post_id`, `created_at`, `updated_at`)
VALUES
	(1,'/admin/images/avatar.jpg','admin-image',1,'1',1,1,NULL,NULL),
	(2,'/admin/css/bootstrap.min.css','boostrap',0,'1',1,2,NULL,NULL),
	(3,'/admin/images/avatar.jpg','admin-image',1,'2',1,3,NULL,NULL);

/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table follows
# ------------------------------------------------------------

DROP TABLE IF EXISTS `follows`;

CREATE TABLE `follows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table invites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invites`;

CREATE TABLE `invites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `invited_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invite_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: pending, 1: success, 2: reject',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2018_10_01_144045_create_contacts_table',1),
	(4,'2018_10_01_144115_create_invites_table',1),
	(5,'2018_10_01_144130_create_reacts_table',1),
	(6,'2018_10_01_144149_create_participations_table',1),
	(7,'2018_10_01_144209_create_channels_table',1),
	(8,'2018_10_01_144221_create_files_table',1),
	(9,'2018_10_01_144229_create_posts_table',1),
	(10,'2018_10_01_144254_create_unreads_table',1),
	(11,'2018_10_01_155205_create_push_subscriptions_table',1),
	(12,'2018_10_01_155225_create_notifications_table',1),
	(13,'2018_10_01_163144_create_facebook_social_accounts_table',1),
	(14,'2018_10_22_042133_create_social_accounts_table',1),
	(15,'2018_11_07_075009_create_admins_table',1),
	(16,'2018_11_13_025408_create_reports_table',1),
	(17,'2018_11_26_022319_create_follows_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not_read||1: read',
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table participations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `participations`;

CREATE TABLE `participations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: active, 0:inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `participations` WRITE;
/*!40000 ALTER TABLE `participations` DISABLE KEYS */;

INSERT INTO `participations` (`id`, `user_id`, `channel_id`, `display_name`, `status`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'Hoang Quang',1,NULL,NULL),
	(2,2,1,'Quang Hoàng',1,NULL,NULL),
	(3,2,2,'Quang Hoàng',1,NULL,NULL),
	(4,1,2,'Hoang Quang',1,NULL,NULL),
	(5,1,3,'Hoang Quang',1,NULL,NULL),
	(6,2,3,'Quang Hoàng',1,NULL,NULL),
	(7,3,1,'quang pro',1,NULL,NULL),
	(8,1,4,'Hoang Quang',1,NULL,NULL),
	(9,2,4,'Quang Hoàng',1,NULL,NULL),
	(10,3,4,'quang pro',1,NULL,NULL),
	(11,2,5,'Quang Hoàng',1,NULL,NULL),
	(12,3,5,'quang pro',1,NULL,NULL),
	(13,1,5,'Hoang Quang',1,NULL,NULL),
	(14,2,6,'Quang Hoàng',1,NULL,NULL),
	(15,3,6,'quang pro',1,NULL,NULL),
	(16,1,6,'Hoang Quang',1,NULL,NULL),
	(17,2,7,'Quang Hoàng',1,NULL,NULL);

/*!40000 ALTER TABLE `participations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'false: parent post, true: children post',
  `channel_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `creator` int(11) NOT NULL,
  `user_following_post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: normal post, 1: pinned post',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0: block, 1: active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table push_subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `push_subscriptions`;

CREATE TABLE `push_subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `endpoint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`),
  KEY `push_subscriptions_user_id_index` (`user_id`),
  CONSTRAINT `push_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table reacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reacts`;

CREATE TABLE `reacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `react_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reports`;

CREATE TABLE `reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_creator_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: incomplete, 1: complete, 2:pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table social_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `social_accounts`;

CREATE TABLE `social_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `social_accounts` WRITE;
/*!40000 ALTER TABLE `social_accounts` DISABLE KEYS */;

INSERT INTO `social_accounts` (`id`, `user_id`, `google_id`, `access_token`, `refresh_token`, `created_at`, `updated_at`)
VALUES
	(1,1,'109512382891889970351','ya29.GlxwBpFATqzfYXEZdTkIoZZHVT84NYlaBeX8t-7pDLWdWjGP-nK4Mwk7rvSqa1FCFtg0R9JzGMWNVEUh_NsSN0FGCJjWETSGHRpG2IqTZCFwTMN5PVa9mjFffyYPsQ',NULL,'2018-12-12 16:27:32','2018-12-12 16:27:32'),
	(2,2,'110380554348141833395','ya29.GltwBg7SFSFlXme_VBgC_xjOIn1WPNaNUAy1LrnXKDhhtYvsnxlsNFFdZkrqsMtUHPNc8JmZ5wVnx005Lk--V0BH9_GfPCbmzDih8PHSwqbikXmOBd1V9vK4GYZO',NULL,'2018-12-12 16:28:25','2018-12-12 16:28:25');

/*!40000 ALTER TABLE `social_accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table unreads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unreads`;

CREATE TABLE `unreads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: normal, 1: online, 2: sleep, 3:offline',
  `gender` tinyint(4) DEFAULT NULL COMMENT '0: male, 1: female, 2:others',
  `birthday` date DEFAULT NULL,
  `japanese_level` tinyint(4) DEFAULT NULL,
  `japanese_certificate` text COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `university` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_teacher` tinyint(1) DEFAULT NULL,
  `is_bachelor` tinyint(1) NOT NULL DEFAULT '1',
  `grade` tinyint(4) NOT NULL DEFAULT '1',
  `about_me` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: active, 0:blocked',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `address`, `email_verified_at`, `password`, `avatar`, `status`, `gender`, `birthday`, `japanese_level`, `japanese_certificate`, `facebook_url`, `university`, `is_teacher`, `is_bachelor`, `grade`, `about_me`, `active`, `deleted_at`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'Hoang Quang','quanghoang4334@gmail.com',NULL,NULL,NULL,'$2y$10$dUjzgDMQbgAexi5587.nwObxnisJGNg5uLFciK7U3imXURTcPshiC','https://lh5.googleusercontent.com/-hH9OuxSbzvU/AAAAAAAAAAI/AAAAAAAAAAA/AGDgw-h6TgA9FC3zS5EwML5WB7j2CGorwg/mo/photo.jpg?sz=50',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,1,NULL,NULL,'2018-12-12 16:27:32','2018-12-12 16:27:32'),
	(2,'Quang Hoàng','minhquang4334@gmail.com',NULL,NULL,NULL,'$2y$10$AQPTxJVFeO7HkpCEbOUoCOn5Rt.9wUPL.naF1rvE.Wo1JLcSQekAe','https://lh6.googleusercontent.com/-hM6sI4TEIPQ/AAAAAAAAAAI/AAAAAAAAAJU/oVK9yuvQjXw/photo.jpg?sz=50',0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,1,NULL,NULL,'2018-12-12 16:28:25','2018-12-12 16:28:25'),
	(3,'quang pro','leconghau.hit@gmail.com',NULL,NULL,NULL,'$2y$10$jHFUIRS51zXG2B3xi6CQ9uDSvm/aoZh748Mo5duRw4eB13gQXLUBW',NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,1,1,NULL,1,NULL,NULL,'2018-12-12 16:35:12','2018-12-12 16:35:12');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
