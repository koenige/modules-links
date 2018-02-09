<?php 

/**
 * Zugzwang Project
 * Table with links for events
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2017-2018 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz_sub['title'] = 'Links/Events';
$zz_sub['table'] = '/*_PREFIX_*/links_events';

$zz_sub['fields'][1]['field_name'] = 'link_event_id';
$zz_sub['fields'][1]['type'] = 'id';

$zz_sub['fields'][2]['field_name'] = 'link_id';
$zz_sub['fields'][2]['type'] = 'select';
$zz_sub['fields'][2]['sql'] = 'SELECT link_id, link_url
	FROM /*_PREFIX_*/links
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)
	ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence';
$zz_sub['fields'][2]['display_field'] = 'link_url';

$zz_sub['fields'][3]['field_name'] = 'event_id';
$zz_sub['fields'][3]['type'] = 'select';
$zz_sub['fields'][3]['type'] = 'select';
$zz_sub['fields'][3]['sql'] = 'SELECT event_id
	, CONCAT(/*_PREFIX_*/events.event, " (", DATE_FORMAT(/*_PREFIX_*/events.date_begin, "%d.%m.%Y")
		, IFNULL(CONCAT(", ", place), ""), ")") AS event 
	FROM /*_PREFIX_*/events
	WHERE ISNULL(main_event_id)
	ORDER BY date_begin DESC';
$zz_sub['fields'][3]['display_field'] = 'event';
$zz_sub['fields'][3]['search'] = 'CONCAT(/*_PREFIX_*/events.event, " (", 
	DATE_FORMAT(/*_PREFIX_*/events.date_begin, "%d.%m.%Y"), IFNULL(CONCAT(", ", place), ""), ")")';

$zz_sub['sql'] = 'SELECT /*_PREFIX_*/links_events.*
		, /*_PREFIX_*/links.link_url
		, CONCAT(/*_PREFIX_*/events.event, " (", DATE_FORMAT(/*_PREFIX_*/events.date_begin, "%d.%m.%Y")
			, IFNULL(CONCAT(", ", place), ""), ")") AS event 
	FROM /*_PREFIX_*/links_events
	LEFT JOIN /*_PREFIX_*/links USING (link_id)
	LEFT JOIN /*_PREFIX_*/events USING (event_id)
';
$zz_sub['sqlorder'] = ' ORDER BY /*_PREFIX_*/links.sequence, IFNULL(/*_PREFIX_*/events.date_begin, /*_PREFIX_*/events.date_end)';
