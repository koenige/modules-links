<?php 

/**
 * Zugzwang Project
 * Output of links
 *
 * http://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2014, 2016 Gustaf Mossakowski
 * @license http://opensource.org/licenses/lgpl-3.0.html LGPL-3.0
 */


function mod_links_links($params) {
	if (!empty($params)) return false;

	if (!empty($_GET['go'])) {
		$sql = 'SELECT link_url FROM links WHERE link_url = "%s"';
		$sql = sprintf($sql, wrap_db_escape($_GET['go']));
		$link = wrap_db_fetch($sql, '', 'single value');
		if ($link) {
			return brick_format('%%% redirect '.$link.' %%%');
		}
		$page['status'] = 404;
		$page['title'] = wrap_text('Link not found');
	}
	
	$sql = 'SELECT link_id
		, link_title, link_url, links.description
		, category
		FROM links
		LEFT JOIN categories USING (category_id)
		WHERE published = "yes"
		ORDER BY categories.sequence, categories.category, links.sequence
	';
	$links = wrap_db_fetch($sql, array('category', 'link_id'), 'list category links');
	$links = array_values($links);

	$page['text'] = wrap_template('links', $links);
	$page['query_strings'][] = 'go';
	return $page;
}
