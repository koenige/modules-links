/**
 * Zugzwang Project
 * SQL for installation of links module
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2018-2021 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


CREATE TABLE `links` (
  `link_id` int unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int unsigned NOT NULL,
  `link_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_identifier` varchar(31) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `link_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `hits` int unsigned DEFAULT '0',
  `published` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'yes',
  `sequence` smallint NOT NULL,
  `foreign_source_id` int unsigned DEFAULT NULL,
  `foreign_key` int unsigned DEFAULT NULL,
  PRIMARY KEY (`link_id`),
  UNIQUE KEY `foreign_key` (`foreign_source_id`,`foreign_key`),
  KEY `catid` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO _relations (`master_db`, `master_table`, `master_field`, `detail_db`, `detail_table`, `detail_id_field`, `detail_field`, `delete`) VALUES ((SELECT DATABASE()), 'categories', 'category_id', (SELECT DATABASE()), 'links', 'link_id', 'category_id', 'no-delete');


CREATE TABLE `links_contacts` (
  `link_contact_id` int unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int unsigned NOT NULL,
  `contact_id` int unsigned NOT NULL,
  PRIMARY KEY (`link_contact_id`),
  UNIQUE KEY `contact_link` (`contact_id`,`link_id`),
  KEY `link_id` (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO _relations (`master_db`, `master_table`, `master_field`, `detail_db`, `detail_table`, `detail_id_field`, `detail_field`, `delete`) VALUES ((SELECT DATABASE()), 'links', 'link_id', (SELECT DATABASE()), 'links_contacts', 'link_contact_id', 'link_id', 'delete');
INSERT INTO _relations (`master_db`, `master_table`, `master_field`, `detail_db`, `detail_table`, `detail_id_field`, `detail_field`, `delete`) VALUES ((SELECT DATABASE()), 'contacts', 'contact_id', (SELECT DATABASE()), 'links_contacts', 'link_contact_id', 'contact_id', 'no-delete');


CREATE TABLE `links_events` (
  `link_event_id` int unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int unsigned NOT NULL,
  `event_id` int unsigned NOT NULL,
  PRIMARY KEY (`link_event_id`),
  UNIQUE KEY `event_link` (`event_id`,`link_id`),
  KEY `link_id` (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO _relations (`master_db`, `master_table`, `master_field`, `detail_db`, `detail_table`, `detail_id_field`, `detail_field`, `delete`) VALUES ((SELECT DATABASE()), 'links', 'link_id', (SELECT DATABASE()), 'links_events', 'link_event_id', 'link_id', 'delete');
INSERT INTO _relations (`master_db`, `master_table`, `master_field`, `detail_db`, `detail_table`, `detail_id_field`, `detail_field`, `delete`) VALUES ((SELECT DATABASE()), 'events', 'event_id', (SELECT DATABASE()), 'links_events', 'link_event_id', 'event_id', 'no-delete');


CREATE TABLE `links_logs` (
  `ll_id` int unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int unsigned NOT NULL,
  `access_date` datetime NOT NULL,
  `access_ip` varbinary(16) DEFAULT NULL,
  `referer` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`ll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO _relations (`master_db`, `master_table`, `master_field`, `detail_db`, `detail_table`, `detail_id_field`, `detail_field`, `delete`) VALUES ((SELECT DATABASE()), 'links', 'link_id', (SELECT DATABASE()), 'links_logs', 'll_id', 'link_id', 'delete');
