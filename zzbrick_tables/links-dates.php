<?php 

/**
 * Zugzwang Project
 * Table with links for dates
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2017 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz_sub['title'] = 'Links/Dates';
$zz_sub['table'] = '/*_PREFIX_*/links_dates';

$zz_sub['fields'][1]['field_name'] = 'link_date_id';
$zz_sub['fields'][1]['type'] = 'id';

$zz_sub['fields'][2]['field_name'] = 'link_id';
$zz_sub['fields'][2]['type'] = 'select';
$zz_sub['fields'][2]['sql'] = 'SELECT link_id, link_url
	FROM /*_PREFIX_*/links
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)
	ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence';
$zz_sub['fields'][2]['display_field'] = 'link_url';

$zz_sub['fields'][3]['field_name'] = 'date_id';
$zz_sub['fields'][3]['type'] = 'select';
$zz_sub['fields'][3]['type'] = 'select';
$zz_sub['fields'][3]['sql'] = 'SELECT date_id
	, CONCAT(/*_PREFIX_*/dates.date_title, " (", DATE_FORMAT(/*_PREFIX_*/dates.date_begin, "%d.%m.%Y")
		, IFNULL(CONCAT(", ", place), ""), ")") AS date 
	FROM /*_PREFIX_*/dates
	WHERE ISNULL(main_date_id)
	ORDER BY date_begin DESC';
$zz_sub['fields'][3]['display_field'] = 'date';
$zz_sub['fields'][3]['search'] = 'CONCAT(/*_PREFIX_*/dates.date_title, " (", 
	DATE_FORMAT(/*_PREFIX_*/dates.date_begin, "%d.%m.%Y"), IFNULL(CONCAT(", ", place), ""), ")")';

$zz_sub['sql'] = 'SELECT /*_PREFIX_*/links_dates.*
		, /*_PREFIX_*/links.link_url
		, CONCAT(/*_PREFIX_*/dates.date_title, " (", DATE_FORMAT(/*_PREFIX_*/dates.date_begin, "%d.%m.%Y")
			, IFNULL(CONCAT(", ", place), ""), ")") AS date 
	FROM /*_PREFIX_*/links_dates
	LEFT JOIN /*_PREFIX_*/links USING (link_id)
	LEFT JOIN /*_PREFIX_*/dates USING (date_id)
';
$zz_sub['sqlorder'] = ' ORDER BY /*_PREFIX_*/links.sequence, IFNULL(/*_PREFIX_*/dates.date_begin, /*_PREFIX_*/dates.date_end)';
