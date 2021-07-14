/**
 * links module
 * SQL updates
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2019 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


/* 2019-04-08-1 */	ALTER TABLE `links` CHANGE `category_id` `category_id` int unsigned NOT NULL AFTER `link_id`, CHANGE `link_title` `link_title` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `category_id`, CHANGE `description` `description` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `link_url`, CHANGE `hits` `hits` int unsigned NULL DEFAULT '0' AFTER `created`, CHANGE `published` `published` enum('yes','no') COLLATE 'latin1_general_ci' NOT NULL DEFAULT 'yes' AFTER `hits`, CHANGE `sequence` `sequence` smallint NOT NULL AFTER `published`, COLLATE 'utf8mb4_unicode_ci';
/* 2019-04-08-2 */	ALTER TABLE `links_logs` CHANGE `referer` `referer` varchar(500) COLLATE 'latin1_general_cs' NULL AFTER `access_ip`, COLLATE 'utf8mb4_unicode_ci';
/* 2019-04-08-3 */	ALTER TABLE `links` ADD `foreign_source_id` int unsigned NULL, ADD `foreign_key` int unsigned NULL AFTER `foreign_source_id`;
/* 2019-04-08-4 */	ALTER TABLE `links` ADD UNIQUE `foreign_key` (`foreign_source_id`, `foreign_key`);
