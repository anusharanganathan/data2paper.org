<?php
if( !defined( 'ABSPATH' ) ) {
	exit;
}

require_once( EL_PATH.'includes/options.php' );

// Class to manage categories
class EL_Categories {
	private static $instance;
	private $options;
	private $db;
	private $cat_array;

	public static function &get_instance() {
		// Create class instance if required
		if( !isset( self::$instance ) ) {
			self::$instance = new EL_Categories();
		}
		// Return class instance
		return self::$instance;
	}

	private function __construct() {
		$this->options = &EL_Options::get_instance();
		$this->db = &EL_Db::get_instance();
		$this->initalize_cat_array();
	}

	private function initalize_cat_array() {
		$cat_array = $this->options->get('el_categories');
		$this->cat_array = array();
		if(!empty($cat_array)) {
			foreach($cat_array as $cat) {
				// check if "parent" field is available (required due to old version without parent field)
				// this can be removed in a later version
				if(!isset($cat['parent']) || !isset($cat['level'])) {
					$cat['parent'] = '';
					$cat['level'] = 0;
				}
				$this->cat_array[$cat['slug']] = $cat;
			}
		}
	}

	public function is_set($category_slug) {
		return isset($this->cat_array[$category_slug]);
	}

	public function add_category($cat_data, $allow_duplicate_names=false) {
		$this->add_cat_to_array($cat_data, $allow_duplicate_names);
		return  $this->safe_categories();
	}

	public function edit_category($cat_data, $old_slug, $allow_duplicate_names=false) {
		// check if slug already exists
		if(!$this->is_set($old_slug)) {
			return false;
		}
		// delete old category
		unset($this->cat_array[$old_slug]);
		// create new category
		$new_slug = $this->add_cat_to_array($cat_data, $allow_duplicate_names);
		// required modifications if slug was changed
		if($old_slug != $new_slug) {
			// update slug in events if slug has changed
			$this->db->change_category_slug_in_events($old_slug, $new_slug);
			// update parent slug in sub-categories
			$subcats = $this->get_children($old_slug);
			foreach($subcats as $subcat) {
				$this->cat_array[$subcat]['parent'] = $new_slug;
			}
		}
		// safe category
		return $this->safe_categories();
	}

	public function remove_categories($slugs, $remove_cats_in_events=true) {
		if($remove_cats_in_events) {
			$this->db->remove_category_in_events($slugs);
		}
		foreach($slugs as $slug) {
			// check for subcategories and set their parent to the parent of the cat to delete
			$children = $this->get_children($slug);
			foreach($children as $child) {
				$this->set_parent($child, $this->cat_array[$slug]['parent']);
			}
			// unset category
			unset($this->cat_array[$slug]);
		}
		return $this->safe_categories();
	}

	private function safe_categories() {
		if(empty($this->cat_array)) {
			$cat_array = '';
		}
		else {
			$cat_array = $this->get_cat_array('slug', true);
			if(!is_array($cat_array) || empty($cat_array)) {
				return false;
			}
		}
		if(!$this->options->set('el_categories', $cat_array)) {
			return false;
		}
		return true;
	}

	private function add_cat_to_array($cat_data, $allow_duplicate_names=false) {
		// sanitize cat_data
		$cat['name'] = isset($cat_data['name']) ? sanitize_text_field($cat_data['name']) : '';
		$cat['slug'] = isset($cat_data['slug']) ? sanitize_title($cat_data['slug']) : '';
		$cat['desc'] = isset($cat_data['desc']) ? sanitize_text_field($cat_data['desc']) : '';
		$parent = isset($cat_data['parent']) ? sanitize_key($cat_data['parent']) : '';

		// check if name was set
		if(empty($cat['name'])) {
			return false;
		}
		// check if name already exists
		if(!$allow_duplicate_names) {
			foreach( $this->cat_array as $category ) {
				if($category['name'] === $cat['name']) {
					return false;
				}
			}
		}
		// prepare slug
		$cat['slug'] = $this->prepare_slug($cat['slug'], $cat['name']);
		if(empty($cat['slug'])) {
			return false;
		}
		// add category
		$this->cat_array[$cat['slug']] = $cat;
		// set parent and level
		$this->set_parent($cat['slug'], $parent);
		return $cat['slug'];
	}

	public function sync_with_post_cats() {
		$post_cats = get_categories(array('type'=>'post', 'orderby'=>'slug', 'hide_empty'=>0));
		// delete not available categories(compare categories by slug)
		$cats_to_delete = array();
		foreach($this->cat_array as $event_cat) {
			$in_array = false;
			foreach($post_cats as $post_cat) {
				if($post_cat->slug === $event_cat['slug']) {
					$in_array = true;
					break;
				}
			}
			if(!$in_array) {
				$cats_to_delete[] = $event_cat['slug'];
			}
		}
		$this->remove_categories($cats_to_delete);
		// update existing and add not existing categories
		$this->update_post_cats_children(0);
	}

	private function update_post_cats_children($parent_id) {
		$post_cats = get_categories(array('type'=>'post', 'parent'=>$parent_id, 'orderby'=>'slug', 'hide_empty'=>0));
		// add not existing categories, update existing categories
		if(!empty($post_cats)) {
			foreach($post_cats as $post_cat) {
				$in_array = false;
				foreach($this->cat_array as $event_cat) {
					if($event_cat['slug'] === $post_cat->slug) {
						$in_array = true;
						// update an already existing category
						$cat_data = $this->get_cat_data_from_post_cat($post_cat);
						$this->edit_category($cat_data, $event_cat['slug'], true);
						break;
					}
				}
				// add a new category
				if(!$in_array) {
					$cat_data = $this->get_cat_data_from_post_cat($post_cat);
					$this->add_category($cat_data, true);
				}
				// update the children of the actual category
				$this->update_post_cats_children($post_cat->cat_ID);
			}
		}
	}

	private function get_cat_data_from_post_cat($post_cat) {
		$cat['name'] = $post_cat->name;
		$cat['slug'] = $post_cat->slug;
		$cat['desc'] = $post_cat->description;
		if(0 != $post_cat->parent) {
			$cat['parent'] = get_category($post_cat->parent)->slug;
		}
		return $cat;
	}

	public function add_post_category($cat_id) {
		$cat_data = $this->get_cat_data_from_post_cat(get_category($cat_id));
		$this->add_category($cat_data, true);
	}

	public function edit_post_category($cat_id) {
		// the get_category still holds the old cat_data
		// the new data is available in $_POST

		// check used post parameters
		$cat_data['name'] = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';

		if(!empty($cat_data['name'])) {
			// check used post parameters
			$cat_data['slug'] = isset($_POST['slug']) ? sanitize_title($_POST['slug']) : '';
			$cat_data['desc'] = isset($_POST['description']) ? sanitize_text_field($_POST['description']) : '';
			$parent_id = isset($_POST['parent']) ? intval($_POST['parent']) : 0;

			$old_slug = get_category($cat_id)->slug;
			$cat_data['slug'] = $this->prepare_slug($cat_data['slug'], $cat_data['name'], $old_slug);
			if(0 <= $parent_id) {
				$cat_data['parent'] = get_category($parent_id)->slug;
			}
			// edit event category
			$this->edit_category($cat_data, $old_slug, true);
		}
	}

	public function delete_post_category($cat_id) {
		// search for deleted categories
		foreach($this->cat_array as $event_cat) {
			if(false == get_category_by_slug($event_cat['slug'])) {
				$this->remove_categories(array($event_cat['slug']));
				break;
			}
		}
	}

	public function get_cat_array($sort_key='name', $sort_order='asc', $slug_filter=null) {
		if(empty($this->cat_array)) {
			return array();
		}
		else {
			return $this->get_cat_child_array('', $sort_key, $sort_order, $slug_filter);
		}
	}

	private function get_cat_child_array($slug, $sort_key, $sort_order, $slug_filter=null) {
		$children = $this->get_children($slug, $sort_key, $sort_order, $slug_filter);
		if(empty($children)) {
			return null;
		}
		$ret = array();
		foreach($children as $child) {
			$ret[] = $this->cat_array[$child];
			$grandchilds = $this->get_cat_child_array($child, $sort_key, $sort_order, $slug_filter);
			if(is_array($grandchilds)) {
				$ret = array_merge($ret, $grandchilds);
			}
		}
		return $ret;
	}

	private function get_children($slug='', $sort_key='slug', $sort_order='asc', $slug_filter=null) {
		// filter initialization
		if($slug_filter === '') {
			$slug_filter = null;
		}
		// create array with slugs
		$ret = array();
		foreach($this->cat_array as $cat) {
			if($slug == $cat['parent'] && $slug_filter !== $cat['slug']) {
				$ret[] = $cat['slug'];
			}
		}
		// sort array
		if('slug' == $sort_key) {
			if('desc' == $sort_order) {
				rsort($ret);
			}
			else {
				sort($ret);
			}
			return $ret;
		}
		else {
			$sort_key_array = array();
			foreach($ret as $cat_slug) {
				$sort_key_array[] = strtolower($this->cat_array[$cat_slug][$sort_key]);
			}
			asort($sort_key_array);
			$ret_sorted = array();
			foreach($sort_key_array as $key => $value) {
				$ret_sorted[] = $ret[$key];
			}
			return $ret_sorted;
		}
	}

	private function set_parent($cat_slug, $parent_slug) {
		if($this->is_set($parent_slug)) {
			// set parent and level
			$this->cat_array[$cat_slug]['parent'] = $parent_slug;
			$this->cat_array[$cat_slug]['level'] = $this->cat_array[$parent_slug]['level'] + 1;
		}
		else {
			// set to first level category
			$this->cat_array[$cat_slug]['parent'] = '';
			$this->cat_array[$cat_slug]['level'] = 0;
		}
		// check and update children
		$children = $this->get_children($cat_slug);
		foreach($children as $child) {
			$this->set_parent($child, $cat_slug);
		}
	}

	private function prepare_slug($slug, $name=null, $old_slug=null) {
		// generate slug from name if no slug was given
		if(empty($slug)) {
			if(is_null($name)) {
				return false;
			}
			else {
				$slug = sanitize_title($name);
				if(empty($slug)) {
					return false;
				}
			}
		}
		// no action if slug is same as old_slug
		if($slug === $old_slug) {
			return $slug;
		}
		// make slug unique
		if($this->is_set($slug)) {
			$tmpslug = $slug.'-';
			$num = 1;
			while($this->is_set($slug)) {
				$slug = $tmpslug.$num;
				$num++;
			}
		}
		return $slug;
	}

	public function get_category_data($slug) {
		if(isset($this->cat_array[$slug])) {
			return $this->cat_array[$slug];
		}
		return false;
	}

	/**
	 * Convert the slugs-string (e.g. "|slug-1|slug-2|") to another string or a slug array
	 *
	 * @param string $slug_string  The slug string to convert
	 * @param string $return_type  The type to return. Possible values are:
	 *                               "name_string" ... to return a string with the category names
	 *                               "name_array"  ... to return an array with the category names
	 *                               "slug_string" ... to return a string with the category slugs
	 *                               "slug_array"  ... to return an array with the category slugs
	 * @param string $glue         The glue or separator when a string should be returned
	 */
	public function convert_db_string($slug_string, $return_type='name_string', $glue=', ') {
		if(2 >= strlen($slug_string)) {
			return (strpos($return_type, 'array') !== false) ? array() : '';
		}
		$slug_array = explode('|', substr($slug_string, 1, -1));
		switch($return_type) {
			case 'slug_array':
			case 'slug_string':
				$ret_array = $slug_array;
				break;
			case 'name_array':
			default:   // name_string
				$ret_array = array();
				foreach($slug_array as $slug) {
					$ret_array[] = $this->cat_array[$slug]['name'];
				}
		}
		sort($ret_array, SORT_STRING);
		if(strpos($return_type, 'array') !== false) {
			return $ret_array;
		}
		else {
			return implode($glue, $ret_array);
		}
	}
}
