<?php
if(!defined('WPINC')) {
	exit;
}

require_once(EL_PATH.'includes/options.php');
require_once(EL_PATH.'admin/includes/admin-functions.php');
require_once(EL_PATH.'includes/db.php');
require_once(EL_PATH.'includes/categories.php');

// This class handles all data for the admin new event page
class EL_Admin_Import {
	private static $instance;
	private $options;
	private $functions;
	private $db;
	private $categories;
	private $import_data;
	private $example_file_path;

	public static function &get_instance() {
		// Create class instance if required
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		// Return class instance
		return self::$instance;
	}

	private function __construct() {
		$this->options = &EL_Options::get_instance();
		$this->functions = &EL_Admin_Functions::get_instance();
		$this->db = &EL_Db::get_instance();
		$this->categories = &EL_Categories::get_instance();
		$this->example_file_path = EL_URL.'/files/events-import-example.csv';
	}

	public function show_import() {
		if(!current_user_can('edit_posts')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
		echo '
			<div class="wrap">
				<div id="icon-edit-pages" class="icon32"><br /></div>
				<h2>'.__('Import Events','event-list').'</h2>';
		// Review import
		if(isset($_FILES['el_import_file'])) {
			$this->show_import_review();
		}
		// Finish import (add events)
		elseif(isset($_POST['reviewed_events'])) {
			$import_error = $this->import_events();
			$this->show_import_finished($import_error);
		}
		// Import form
		else {
			$this->show_import_form();
		}
		echo '
			</div>';
	}

	private function show_import_form() {
		echo '
				<h3>'.__('Step','event-list').' 1: '.__('Set import file and options','event-list').'</h3>
				<form action="" id="el_import_upload" method="post" enctype="multipart/form-data">
					'.$this->functions->show_option_table('import').'<br />
					<input type="submit" name="button-upload-submit" id="button-upload-submit" class="button" value="'.sprintf(__('Proceed with Step %1$s','event-list'), '2').' &gt;&gt;" />
				</form>
				<br /><br />
				<h3>'.__('Example file','event-list').'</h4>
				<p>'.sprintf(__('You can download an example file %1$shere%2$s (CSV delimiter is a comma!)','event-list'), '<a href="'.$this->example_file_path.'">', '</a>').'</p>
				<p><em>'.__('Note','event-list').':</em> '.__('Do not change the column header and separator line (first two lines), otherwise the import will fail!','event-list').'</p>';
	}

	private function show_import_review() {
		$file = $_FILES['el_import_file']['tmp_name'];
		// check for file existence (upload failed?)
		if(!is_file($file)) {
			echo '<h3>'.__('Sorry, there has been an error.','event-list').'</h3>';
			echo __('The file does not exist, please try again.','event-list').'</p>';
			return;
		}

		// check for file extension (csv) first
		$file_parts = pathinfo($_FILES['el_import_file']['name']);
		if($file_parts['extension'] !== "csv") {
			echo '<h3>'.__('Sorry, there has been an error.','event-list').'</h3>';
			echo __('The file is not a CSV file.','event-list').'</p>';
			return;
		}

		// safe settings
		$this->safe_import_settings();

		// parse file
		$this->import_data = $this->parseImportFile($file);

		// parsing failed?
		if(is_wp_error($this->import_data)) {
			echo '<h3>'.__('Sorry, there has been an error.','event-list').'</h3>';
			echo '<p>' . esc_html($this->import_data->get_error_message()).'</p>';
			return;
		}

		// Check categories
		$not_available_cats = array();
		foreach($this->import_data as $event) {
			foreach($event['categories'] as $cat) {
				if(!$this->categories->is_set($cat) && !in_array($cat, $not_available_cats)) {
					$not_available_cats[] = $cat;
				}
			}
		}

		// show review page
		echo '
			<h3>'.__('Step','event-list').' 2: '.__('Events review and additonal category selection','event-list').'</h3>';
		if(!empty($not_available_cats)) {
			echo '
				<div class="el-warning">'.__('Warning: The following category slugs are not available and will be removed from the imported events:','event-list').'
					<ul class="el-categories">';
			foreach($not_available_cats as $cat) {
				echo '<li><code>'.$cat.'</code></li>';
			}
			echo '</ul>
					'.__('If you want to keep these categories, please create these Categories first and do the import afterwards.','event-list').'</div>';
		}
		echo '
			<form method="POST" action="?page=el_admin_main&action=import">';
		wp_nonce_field('autosavenonce', 'autosavenonce', false, false);
		wp_nonce_field('closedpostboxesnonce', 'closedpostboxesnonce', false, false);
		wp_nonce_field('meta-box-order-nonce', 'meta-box-order-nonce', false, false);
		echo '
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">';
		foreach($this->import_data as $event) {
			$this->show_event($event);
		}
		echo '
					</div>
					<div id="postbox-container-1" class="postbox-container">
						<div id="side-sortables" class="meta-box-sortables ui-sortable">';
		add_meta_box('event-categories', __('Add additional categories','event-list'), array(&$this, 'render_category_metabox'),'event-list', 'advanced', 'default', null);
		add_meta_box('event-publish', __('Import events','event-list'), array(&$this, 'render_publish_metabox'), 'event-list');
		do_meta_boxes('event-list', 'advanced', null);
		echo '
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="reviewed_events" id="reviewed_events" value="'.esc_html(json_encode($this->import_data)).'" />
			</form>';
	}

	private function show_import_finished($with_error) {
		if(!$with_error) {
			echo '
				<h3>'.__('Import with errors!','event-list').'</h3>
				'.__('Sorry, an error occurred during import!','event-list');
		}
		else {
			echo '
				<h3>'.__('Import successful!','event-list').'</h3>
				<a href="?page=el_admin_main">'.__('Go back to All Events','event-list').'</a>';
		}
	}

	private function show_event($event) {
		echo '
				<p>
				<span class="el-event-header">'.__('Title','event-list').':</span> <span class="el-event-data">'.$event['title'].'</span><br />
				<span class="el-event-header">'.__('Start Date','event-list').':</span> <span class="el-event-data">'.$event['start_date'].'</span><br />
				<span class="el-event-header">'.__('End Date','event-list').':</span> <span class="el-event-data">'.$event['end_date'].'</span><br />
				<span class="el-event-header">'.__('Time','event-list').':</span> <span class="el-event-data">'.$event['time'].'</span><br />
				<span class="el-event-header">'.__('Location','event-list').':</span> <span class="el-event-data">'.$event['location'].'</span><br />
				<span class="el-event-header">'.__('Details','event-list').':</span> <span class="el-event-data">'.$event['details'].'</span><br />
				<span class="el-event-header">'.__('Category slugs','event-list').':</span> <span class="el-event-data">'.implode(', ', $event['categories']).'</span>
				</p>';
	}

	/**
	 * @return WP_Error
	 */
	private function parseImportFile($file) {
		$delimiter = ',';
		$header = array('title', 'start date', 'end date', 'time', 'location', 'details', 'category_slugs');
		$separator = array('sep=,');

		// list of events to import
		$events = array();

		$file_handle = fopen($file, 'r');
		$lineNum = 0;
		$emptyLines = 0;
		while(!feof($file_handle)) {
			$line = fgetcsv($file_handle, 0);

			// skip empty lines
			if(empty($line)) {
				$emptyLines += 1;
				continue;
			}
			// check header
			if(empty($lineNum)) {
				// check optional separator line
				if($line === $separator) {
					$emptyLines += 1;
					continue;
				}
				// check header line
				elseif($line === $header || $line === array_slice($header,0,-1)) {
					$lineNum += 1;
					continue;
				}
				else {
					return new WP_Error('CSV_parse_error', sprintf(__('There was an error at line %1$s when reading this CSV file: Header line is missing or not correct!','event-list'), $lineNum+$emptyLines));
				}
			}
			// handle lines with events
			$events[] = array(
				'title'      => $line[0],
				'start_date' => $line[1],
				'end_date'   => !empty($line[2]) ? $line[2] : $line[1],
				'time'       => $line[3],
				'location'   => $line[4],
				'details'    => $line[5],
				'categories' => isset($line[6]) ? explode('|', $line[6]) : array(),
			);
			$lineNum += 1;
		}
		//close file
		fclose($file_handle);
		return $events;
	}

	private function safe_import_settings() {
		foreach($this->options->options as $oname => $o) {
			// check used post parameters
			$ovalue = isset($_POST[$oname]) ? sanitize_text_field($_POST[$oname]) : '';

			if('import' == $o['section'] && !empty($ovalue)) {
				$this->options->set($oname, $ovalue);
			}
		}
	}

	public function render_publish_metabox() {
		echo '
			<div class="submitbox">
				<div id="delete-action"><a href="?page=el_admin_main" class="submitdelete deletion">'.__('Cancel').'</a></div>
				<div id="publishing-action"><input type="submit" class="button button-primary button-large" name="import" value="'.__('Import','event-list').'" id="import"></div>
				<div class="clear"></div>
			</div>';
	}

	public function render_category_metabox($post, $metabox) {
		echo '
			<div id="taxonomy-category" class="categorydiv">
			<div id="category-all" class="tabs-panel">';
		$cat_array = $this->categories->get_cat_array('name', 'asc');
		if(empty($cat_array)) {
			echo __('No categories available.');
		}
		else {
			echo '
				<ul id="categorychecklist" class="categorychecklist form-no-clear">';
			$level = 0;
			$event_cats = $this->categories->convert_db_string($metabox['args']['event_cats'], 'slug_array');
			foreach($cat_array as $cat) {
				if($cat['level'] > $level) {
					//new sub level
					echo '
						<ul class="children">';
					$level++;
				}
				while($cat['level'] < $level) {
					// finish sub level
					echo '
						</ul>';
					$level--;
				}
				$level = $cat['level'];
				$checked = in_array($cat['slug'], $event_cats) ? 'checked="checked" ' : '';
				echo '
						<li id="'.$cat['slug'].'" class="popular-catergory">
							<label class="selectit">
								<input value="'.$cat['slug'].'" type="checkbox" name="categories[]" id="categories" '.$checked.'/> '.$cat['name'].'
							</label>
						</li>';
			}
			echo '
					</ul>';
		}
		echo '
				</div>
			</div>';
	}

	private function import_events() {
		// check used post parameters
		$reviewed_events = json_decode(stripslashes($_POST['reviewed_events']), true);
		if(empty($reviewed_events)) {
			return false;
		}
		$additional_cat_array = isset($_POST['categories']) && is_array($_POST['categories']) ? array_map('sanitize_key', $_POST['categories']) : array();

		// Category handling
		foreach($reviewed_events as &$event) {
			// Remove not available categories of import file
			foreach($event['categories'] as $cat) {
				if(!$this->categories->is_set($cat)) {
					unset($event['categories'][$cat]);
				}
			}
			// Add the additionally specified categories to the event
			if(!empty($additional_cat_array)) {
				$event['categories'] = array_unique(array_merge($event['categories'], $additional_cat_array));
			}
		}
		$ret = array();
		foreach($reviewed_events as &$event) {
			// check if dates have correct formats
			$start_date = DateTime::createFromFormat($this->options->get('el_import_date_format'), $event['start_date']);
			$end_date = DateTime::createFromFormat($this->options->get('el_import_date_format'), $event['end_date']);
			if($start_date instanceof DateTime) {
				$event['start_date'] = $start_date->format('Y-m-d');
				if($end_date) {
					$event['end_date'] = $end_date->format('Y-m-d');
				}
				else {
					$event['end_date'] = '';
				}
				$ret[] = $this->db->update_event($event);
			}
			else {
				return false;
			}
		}
		// TODO: Improve error messages
		return $ret;
	}

	public function embed_import_scripts() {
		wp_enqueue_style('eventlist_admin_import', EL_URL.'admin/css/admin_import.css');
	}
}
?>
