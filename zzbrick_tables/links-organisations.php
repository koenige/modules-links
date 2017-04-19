<?php 

/**
 * Zugzwang Project
 * Table with links for organisations
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2017 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz_sub['title'] = 'Links/Organisations';
$zz_sub['table'] = '/*_PREFIX_*/links_organisations';

$zz_sub['fields'][1]['field_name'] = 'link_org_id';
$zz_sub['fields'][1]['type'] = 'id';

$zz_sub['fields'][2]['field_name'] = 'link_id';
$zz_sub['fields'][2]['type'] = 'select';
$zz_sub['fields'][2]['sql'] = 'SELECT link_id, link_url
	FROM /*_PREFIX_*/links
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)
	ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence';
$zz_sub['fields'][2]['display_field'] = 'link_url';

$zz_sub['fields'][3]['title'] = 'Organisation';
$zz_sub['fields'][3]['field_name'] = 'org_id';
$zz_sub['fields'][3]['type'] = 'select';
$zz_sub['fields'][3]['sql'] = 'SELECT org_id, organisation
	FROM /*_PREFIX_*/organisations
	ORDER BY organisation';
$zz_sub['fields'][3]['display_field'] = 'organisation';

$zz_sub['sql'] = 'SELECT /*_PREFIX_*/links_organisations.*
		, /*_PREFIX_*/links.link_url
		, /*_PREFIX_*/organisations.organisation
	FROM /*_PREFIX_*/links_organisations
	LEFT JOIN /*_PREFIX_*/links USING (link_id)
	LEFT JOIN /*_PREFIX_*/organisations USING (org_id)
';
$zz_sub['sqlorder'] = ' ORDER BY /*_PREFIX_*/links.sequence, /*_PREFIX_*/organisations.organisation';
