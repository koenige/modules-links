<?php 

/**
 * Zugzwang Project
 * Table with log for links
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2014-2016 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz['title'] = 'Link Logs';
$zz['table'] = '/*_PREFIX_*/links_logs';

$zz['fields'][1]['field_name'] = 'll_id';
$zz['fields'][1]['type'] = 'id';

$zz['fields'][2]['field_name'] = 'link_id';
$zz['fields'][2]['type'] = 'select';
$zz['fields'][2]['sql'] = 'SELECT link_id, link_url
	FROM /*_PREFIX_*/links
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)
	ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence';
$zz['fields'][2]['display_field'] = 'link_url';

$zz['fields'][3]['title'] = 'Access Date';
$zz['fields'][3]['field_name'] = 'access_date';
$zz['fields'][3]['type'] = 'hidden';
$zz['fields'][3]['type_detail'] = 'datetime';
$zz['fields'][3]['default'] = date('Y-m-d H:i:s');

$zz['fields'][4]['title'] = 'Access IP';
$zz['fields'][4]['field_name'] = 'access_ip';
$zz['fields'][4]['type'] = 'hidden';
$zz['fields'][4]['type_detail'] = 'ip';
$zz['fields'][4]['default'] = $_SERVER['REMOTE_ADDR'];

$zz['fields'][5]['field_name'] = 'referer';
$zz['fields'][5]['default'] = $_SERVER['HTTP_REFERER'];

$zz['sql'] = 'SELECT /*_PREFIX_*/links_logs.*, /*_PREFIX_*/links.link_url
	FROM /*_PREFIX_*/links_logs
	LEFT JOIN /*_PREFIX_*/links
		USING (link_id)
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)
';
$zz['sqlorder'] = ' ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence, access_date';
