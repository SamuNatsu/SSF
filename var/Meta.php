<?php
namespace SSF;

define('__SSF_META_POST__', 0);
define('__SSF_META_CATEGORY__', 1);
define('__SSF_META_TAG__', 2);
define('__SSF_META_LINK__', 3);

class Meta {
	static private $_posts = [];
	static private $_categories = [];
	static private $_tags = [];
	static private $_links = [];

	// Initialize
	static public function init(): void {
		$metas = \SSF\Database::getMetas();
		if ($metas === null)
			throw new \Exception("\SSF\Meta error, fail to get metas");

		foreach ($metas as $i)
			switch ($i['type']) {
				case __SSF_META_POST__: {
					$tmp = json_decode($i['data'], true);
					self::$_posts[$i['id']] = [
						'title' => $i['name'],
						'category' => $tmp['category'],
						'tags' => $tmp['tags'],
						'create_time' => $tmp['create_time'],
						'modify_time' => $tmp['modify_time'],
						'cid' => $tmp['cid']
					];
					break;
				}
				case __SSF_META_CATEGORY__:
					self::$_categories[$i['id']] = [
						'name' => $i['name'],
						'alias' => $i['data']
					];
					break;
				case __SSF_META_TAG__:
					self::$_tags[$i['id']] = [
						'name' => $i['name'],
						'alias' => $i['data']
					];
					break;
				case __SSF_META_LINK__: {
					$tmp = json_decode($i['data'], true);
					self::$_links[$i['id']] = [
						'name' => $i['name'],
						'description' => $tmp['description'],
						'url' => $tmp['url'],
						'gravatar' => $tmp['gravatar']
					];
					break;
				}
				default:
					break;
			}

			uasort(self::$_posts, function($a, $b) {
				return $a['create_time'] - $b['create_time'];
			});
	}

	// Get post table
	static public function getPosts(): array {
		return self::$_posts;
	}
	// Get post count
	static public function getPostCount(): int {
		return count(self::$_posts);
	}

	// Get category table
	static public function getCategories(): array {
		return self::$_categories;
	}
	// Get category count
	static public function getCategoryCount(): int {
		return count(self::$_categories);
	}
	// Get category by id
	static public function getCategoryById(int $id) {
		return array_key_exists($id, self::$_categories) ? self::$_categories[$id] : null;
	}

	// Get tag table
	static public function getTags(): array {
		return self::$_tags;
	}
	// Get tag count
	static public function getTagCount(): int {
		return count(self::$_tags);
	}
	// Get tag by id
	static public function getTagById(int $id) {
		return array_key_exists($id, self::$_tags) ? self::$_tags[$id] : null;
	}
	// Get tags string
	static public function getTagsString(array $arr, string $sep = ', '): string {
		foreach ($arr as &$i)
			$i = self::getTagById($i)['name'];
		return implode($sep, $arr);
	}

	// Get link table
	static public function getLinks(): array {
		return self::$_links;
	}
	// Get link count
	static public function getLinkCount(): int {
		return count(self::$_links);
	}
	// Get link by id
	static public function getLinkById(int $id) {
		return array_key_exists($id, self::$_links) ? self::$_links[$id] : null;
	}
};
