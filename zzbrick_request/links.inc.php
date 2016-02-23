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

	// follow a link?
	if (!empty($_GET['go'])) {
		return mod_links_links_follow();
	}

	// show links
	$links = mod_links_get_links($params);
	$page['text'] = wrap_template('links', $links);
	$page['query_strings'][] = 'go';
	return $page;
}

/**
 * follow a link, test if it is a valid link
 *
 * @return array $page
 */
function mod_links_links_follow() {
	global $zz_setting;
	global $zz_conf;
	
	$sql = 'SELECT link_id, link_url FROM /*_PREFIX_*/links WHERE link_url = "%s"';
	$sql_1 = sprintf($sql, wrap_db_escape($_GET['go']));
	$link = wrap_db_fetch($sql_1);
	if (!$link) {
		// test if it's something with %url% in it which is replaced with real URL
		$qs = parse_url($_GET['go'], PHP_URL_QUERY);
		if ($qs) {
			parse_str($qs, $qs_parsed);
			foreach ($qs_parsed as $qs_key => $qs_value) {
				if (!strstr($qs_value, $zz_setting['hostname'])) continue;
				$qs_parsed[$qs_key] = '%url%';
				$replace = rawurlencode($qs_value);
			}
			$qs_new = http_build_query($qs_parsed);
			$go = str_replace($qs, $qs_new, $_GET['go']);
			$go = str_replace('%25', '%', $go);
		}
		$sql_2 = sprintf($sql, wrap_db_escape($go));
		$link = wrap_db_fetch($sql_2);
		if ($link) {
			$link['link_url'] = str_replace('%url%', $replace, $link['link_url']);
		}
	}
	if ($link) {
		require $zz_conf['dir'].'/zzform.php';
		$zz_conf['logging'] = false; // it does not make sense to log a log
		$values = array();
		$values['action'] = 'insert';
		$values['POST']['link_id'] = $link['link_id'];
		$ops = zzform_multi('links-logs', $values);
		return brick_format('%%% redirect '.$link['link_url'].' %%%');
	}
	$page['status'] = 404;
	$page['title'] = wrap_text('Link not found');
	return $page;
}

/**
 * get links from database
 *
 * @param array $params
 *		[0]: path of link category
 * @return array $links
 */
function mod_links_get_links($params) {
	global $zz_setting;
	if (count($params) > 1) return false;
	if (!is_array($params)) $params = array($params);

	$condition = !empty($params[0]) ? sprintf(' AND categories.path = "%s"', wrap_db_escape($params[0])) : '';
	$self = $zz_setting['host_base'].$zz_setting['base'].$_SERVER['REQUEST_URI'];

	$sql = 'SELECT link_id
			, REPLACE(link_url, "%%url%%", "%s") AS link_url
			, link_title, links.description
			, category
		FROM /*_PREFIX_*/links
		LEFT JOIN /*_PREFIX_*/categories USING (category_id)
		WHERE published = "yes"
		%s
		ORDER BY categories.sequence, categories.category, links.sequence
	';
	$sql = sprintf($sql, rawurlencode($self), $condition);
	if ($condition) {
		$links = wrap_db_fetch($sql, 'link_id');
	} else {
		$links = wrap_db_fetch($sql, array('category', 'link_id'), 'list category links');
		$links = array_values($links);
	}
	return $links;
}
