<?php 

/**
 * links module
 * Table with links for contacts
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2017, 2020-2021 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz['title'] = 'Links/Contacts';
$zz['table'] = '/*_PREFIX_*/links_contacts';

$zz['fields'][1]['field_name'] = 'link_contact_id';
$zz['fields'][1]['type'] = 'id';

$zz['fields'][2]['field_name'] = 'link_id';
$zz['fields'][2]['type'] = 'select';
$zz['fields'][2]['sql'] = 'SELECT link_id, link_url
	FROM /*_PREFIX_*/links
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)
	ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence';
$zz['fields'][2]['display_field'] = 'link_url';

$zz['fields'][3]['title'] = 'Contact';
$zz['fields'][3]['field_name'] = 'contact_id';
$zz['fields'][3]['type'] = 'select';
$zz['fields'][3]['sql'] = 'SELECT contact_id, contact
	FROM /*_PREFIX_*/contacts
	ORDER BY contact';
$zz['fields'][3]['display_field'] = 'contact';

$zz['sql'] = 'SELECT /*_PREFIX_*/links_contacts.*
		, /*_PREFIX_*/links.link_url
		, /*_PREFIX_*/contacts.contact
	FROM /*_PREFIX_*/links_contacts
	LEFT JOIN /*_PREFIX_*/links USING (link_id)
	LEFT JOIN /*_PREFIX_*/contacts USING (contact_id)
';
$zz['sqlorder'] = ' ORDER BY /*_PREFIX_*/links.sequence, /*_PREFIX_*/contacts.contact';
