<?php 

/**
 * links module
 * Output of links
 *
 * Part of »Zugzwang Project«
 * https://www.zugzwang.org/modules/links
 *
 * @author Gustaf Mossakowski <gustaf@koenige.org>
 * @copyright Copyright © 2014, 2016, 2018, 2021-2025 Gustaf Mossakowski
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
	$sql = 'SELECT link_id, link_url FROM /*_PREFIX_*/links WHERE link_url = _latin1"%s"';
	$sql_1 = sprintf($sql, wrap_db_escape($_GET['go']));
	$link = wrap_db_fetch($sql_1);
	if (!$link) {
		// test if it's something with %url% in it which is replaced with real URL
		$qs = parse_url($_GET['go'], PHP_URL_QUERY);
		if ($qs) {
			parse_str($qs, $qs_parsed);
			foreach ($qs_parsed as $qs_key => $qs_value) {
				if (is_array($qs_value)) continue;
				if (!strstr($qs_value, wrap_setting('hostname'))) continue;
				$qs_parsed[$qs_key] = '%url%';
				$replace = rawurlencode($qs_value);
			}
			$qs_new = http_build_query($qs_parsed);
			$go = str_replace($qs, $qs_new, $_GET['go']);
			$go = str_replace('%25', '%', $go);
		}
		if (!empty($go)) {
			// check if hostname is canonical
			// because a) some bots try out hostnames as they like
			// and b) links with hostname where the hostname is not canonical do not work anyways
			if (wrap_setting('canonical_hostname')) {
				if (wrap_setting('canonical_hostname') !== wrap_setting('hostname'))
					wrap_quit(400, 'This URL parameter only works with the canonical hostname.');
			}
			$sql_2 = sprintf($sql, wrap_db_escape($go));
			$link = wrap_db_fetch($sql_2);
			if ($link) {
				$link['link_url'] = str_replace('%url%', $replace, $link['link_url']);
				wrap_setting('cache', false); // do not cache these links, too many
			}
		}
	}
	if ($link) {
		wrap_setting('zzform_logging', false); // it does not make sense to log a log
		if (empty($_SERVER['HTTP_USER_AGENT']) OR !strstr($_SERVER['HTTP_USER_AGENT'], 'bot'))
			zzform_insert('links-logs', ['link_id' => $link['link_id']]);
		wrap_redirect($link['link_url']);
	}
	$page['status'] = 404;
	$page['title'] = wrap_text('Link not found');
	$links = mod_links_get_links();
	$links['not_found'] = true;
	$page['text'] = wrap_template('links', $links);
	return $page;
}

/**
 * get links from database
 *
 * @param array $params
 *		[0]: path of link category
 * @return array $links
 */
function mod_links_get_links($params = []) {
	if (!is_array($params)) $params = [$params];
	if (count($params) > 1) return false;

	$condition = !empty($params[0]) ? sprintf(' AND categories.path = "%s"', wrap_db_escape($params[0])) : '';
	$self = wrap_setting('host_base').wrap_setting('request_uri');

	$sql = 'SELECT link_id
			, REPLACE(link_url, "%%url%%", "%s") AS link_url
			, link_title, links.description, link_identifier
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
		$links = wrap_translate($links, 'links');
	} else {
		$links = wrap_db_fetch($sql, ['category', 'link_id'], 'list category links');
		$links = array_values($links);
	}
	return $links;
}
