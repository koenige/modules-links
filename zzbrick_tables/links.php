<?php 

/**
 * Zugzwang Project
 * Table with links
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2014-2017 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


$zz['title'] = 'Links';
$zz['table'] = '/*_PREFIX_*/links';

$zz['fields'][1]['field_name'] = 'link_id';
$zz['fields'][1]['type'] = 'id';

$zz['fields'][3]['title'] = 'Title';
$zz['fields'][3]['field_name'] = 'link_title';
$zz['fields'][3]['list_append_next'] = true;
$zz['fields'][3]['list_suffix'] = '<br>';

$zz['fields'][9]['field_name'] = 'link_identifier';
$zz['fields'][9]['type'] = 'identifier';
$zz['fields'][9]['fields'] = ['link_title'];
$zz['fields'][9]['hide_in_form'] = true;
$zz['fields'][9]['hide_in_list'] = true;

$zz['fields'][4]['title'] = 'URL';
$zz['fields'][4]['field_name'] = 'link_url';
$zz['fields'][4]['type'] = 'url';
$zz['fields'][4]['list_append_next'] = true;

$zz['fields'][5]['field_name'] = 'description';
$zz['fields'][5]['list_prefix'] = '<div><small>';
$zz['fields'][5]['list_suffix'] = '</small></div>';
$zz['fields'][5]['type'] = 'memo';
$zz['fields'][5]['rows'] = 5;

$zz['fields'][2]['field_name'] = 'category_id';
$zz['fields'][2]['type'] = 'select';
$zz['fields'][2]['sql'] = 'SELECT category_id, category, description, main_category_id
	FROM /*_PREFIX_*/categories
	ORDER BY sequence, category';
$zz['fields'][2]['display_field'] = 'category';
$zz['fields'][2]['show_hierarchy'] = 'main_category_id';
$zz['fields'][2]['show_hierarchy_subtree'] = $zz_setting['category_ids']['links'];
$zz['fields'][2]['group_in_list'] = true;

$zz['fields'][8]['title_tab'] = 'Seq.';
$zz['fields'][8]['field_name'] = 'sequence';
$zz['fields'][8]['type'] = 'number';
$zz['fields'][8]['dont_sort'] = true;

$zz['fields'][6]['field_name'] = 'created';
$zz['fields'][6]['type'] = 'hidden';
$zz['fields'][6]['type_detail'] = 'datetime';
$zz['fields'][6]['default'] = date('Y-m-d H:i:s');
$zz['fields'][6]['hide_in_list'] = true;

$zz['fields'][7]['field_name'] = 'hits';
$zz['fields'][7]['type'] = 'hidden';
$zz['fields'][7]['type_detail'] = 'number';

$zz['fields'][10]['field_name'] = 'published';
$zz['fields'][10]['type'] = 'select';
$zz['fields'][10]['enum'] = ['yes', 'no'];
$zz['fields'][10]['default'] = 'yes';
$zz['fields'][10]['hide_in_list'] = true;

$zz['fields'][11]['title'] = 'Foreign Source';
$zz['fields'][11]['field_name'] = 'foreign_source_id';
$zz['fields'][11]['type'] = 'number';
$zz['fields'][11]['hide_in_list'] = true;

$zz['fields'][12]['title'] = 'Foreign Key';
$zz['fields'][12]['field_name'] = 'foreign_key';
$zz['fields'][12]['type'] = 'number';
$zz['fields'][12]['hide_in_list'] = true;

include __DIR__.'/links-events.php';
$zz['fields'][13] = $zz_sub;
$zz['fields'][13]['type'] = 'subtable';
$zz['fields'][13]['min_records'] = 0;
$zz['fields'][13]['max_records'] = 20;
$zz['fields'][13]['form_display'] = 'lines';
$zz['fields'][13]['title'] = 'Events';
$zz['fields'][13]['hide_in_list'] = true;
$zz['fields'][13]['fields'][2]['type'] = 'foreign_key';
unset($zz_sub);

include __DIR__.'/links-organisations.php';
$zz['fields'][14] = $zz_sub;
$zz['fields'][14]['type'] = 'subtable';
$zz['fields'][14]['min_records'] = 0;
$zz['fields'][14]['max_records'] = 20;
$zz['fields'][14]['form_display'] = 'lines';
$zz['fields'][14]['title'] = 'Organisations';
$zz['fields'][14]['hide_in_list'] = true;
$zz['fields'][14]['fields'][2]['type'] = 'foreign_key';
unset($zz_sub);


$zz['sql'] = 'SELECT /*_PREFIX_*/links.*, /*_PREFIX_*/categories.category
		, (SELECT COUNT(link_id) 
			FROM /*_PREFIX_*/links_logs
			WHERE /*_PREFIX_*/links_logs.link_id = /*_PREFIX_*/links.link_id) + IFNULL(hits, 0) AS hits
	FROM /*_PREFIX_*/links
	LEFT JOIN /*_PREFIX_*/categories
		USING (category_id)';
$zz['sqlorder'] = ' ORDER BY /*_PREFIX_*/categories.sequence, /*_PREFIX_*/links.sequence';

$zz['filter'][1]['title'] = 'Web';
$zz['filter'][1]['type'] = 'list';
$zz['filter'][1]['where'] = 'IF(STRCMP(published, "yes"), 2, 1)';
$zz['filter'][1]['selection'][1] = wrap_text('yes');
$zz['filter'][1]['selection'][2] = wrap_text('no');
