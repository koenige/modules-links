SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `link_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_identifier` varchar(31) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `link_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `hits` int(10) unsigned DEFAULT '0',
  `published` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `sequence` smallint(6) NOT NULL DEFAULT '0',
  `foreign_source_id` int(10) unsigned DEFAULT NULL,
  `foreign_key` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  UNIQUE `foreign_key` (`foreign_source_id`,`foreign_key`),
  KEY `catid` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `links_logs`;
CREATE TABLE `links_logs` (
  `ll_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int(10) unsigned NOT NULL,
  `access_date` datetime NOT NULL,
  `access_ip` varbinary(16) DEFAULT NULL,
  `referer` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `links_events`;
CREATE TABLE `links_events` (
  `link_event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`link_event_id`),
  UNIQUE KEY `event_link` (`event_id`,`link_id`),
  KEY `link_id` (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `links_organisations`;
CREATE TABLE `links_organisations` (
  `link_org_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int(10) unsigned NOT NULL,
  `org_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`link_org_id`),
  UNIQUE KEY `org_link` (`org_id`,`link_id`),
  KEY `link_id` (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
