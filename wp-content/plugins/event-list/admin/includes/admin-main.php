<?php
if(!defined('WPINC')) {
	exit;
}

require_once(EL_PATH.'includes/db.php');
require_once(EL_PATH.'admin/includes/event_table.php');
require_once(EL_PATH.'includes/filterbar.php');

// This class handles all data for the admin main page
class EL_Admin_Main {
	private static $instance;
	private $db;
	private $filterbar;
	private $event_table;
	private $action;

	public static function &get_instance() {
		// Create class instance if required
		if(!isset(self::$instance)) {
			self::$instance = new EL_Admin_Main();
		}
		// Return class instance
		return self::$instance;
	}

	private function __construct() {
		$this->db = &EL_Db::get_instance();
		$this->filterbar = &EL_Filterbar::get_instance();
		$this->event_table = new EL_Event_Table();
		$this->action = $this->event_table->current_action();

		// check for real actions
		if($this->action) {
			// check used post parameters
			$title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';

			switch($this->action) {
				// real actions (redirect when finished)
				case 'new':
					if(!empty($_POST)) {
						$id = $this->update_event();
						$error = !$id;
						$this->redirect('added', $error, array('title' => urlencode($title), 'id' => $id));
					}
					break;
				case 'edited':
					if(!empty($_POST)) {
						$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
						$error = !$this->update_event();
						$this->redirect('modified', $error, array('title' => urlencode($title), 'id' => $id));
					}
					break;
				case 'delete':
					$ids_string = isset($_GET['id']) ? preg_replace('/[^0-9,]/', '', $_GET['id']) : '';
					$id_array = explode(',', $ids_string);
					$error = !$this->db->delete_events($id_array);
					$this->redirect('deleted', $error, array('id' => implode(',', $id_array)));
					break;
				// proceed with header if a bulk action was triggered (required due to "noheader" attribute for all action above)
				case 'delete_bulk':
					require_once(ABSPATH.'wp-admin/admin-header.php');
					break;
			}
		}
		// check used get parameters
		$action1 = isset($_REQUEST['action']) ? intval($_REQUEST['action']) : 0;
		$action2 = isset($_REQUEST['action2']) ? intval($_REQUEST['action2']) : 0;

		// cleanup query args if the button for bulk action was clicked, but no bulk action was selected
		if(-1 == $action1 && -1 == $action2) {
			$this->redirect();
		}
	}

	// show the main admin page
	public function show_main() {
		// check permissions
		if(!current_user_can('edit_posts')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
		// TODO: add check_admin_referer to improve security (see /wp-admin/edit.php)
		// is there POST data an event was edited must be updated

		// check for actions
		if($this->action) {
			switch($this->action) {
				// actions showing edit view
				case 'edit':
				case 'added':
				case 'modified':
					$this->show_edit_view($this->action);
					return;
				// actions showing import view
				case 'import':
					EL_Admin_Import::get_instance()->show_import();
					return;
				// actions showing event list
				case 'deleted':
					// nothing to do
					break;
			}
		}

		$this->show_page_header($this->action);
		echo $this->show_event_table();
		echo '</div>';
	}

	private function show_page_header($action, $editview=false) {
		if($editview) {
			// check used get parameters
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

			$duplicate_link = add_query_arg(array('id'=>$id, 'action'=>'copy'), '?page=el_admin_new');
			$header = __('Edit Event','event-list').' <a href="'.$duplicate_link.'" class="add-new-h2">'.__('Duplicate','event-list').'</a>';
		}
		else {
			$header = __('Events','event-list');
		}
		$new_link = '<a href="?page=el_admin_new" class="add-new-h2">'.__('Add New','event-list').'</a>';
		$import_link = $editview ? '' : '<a href="?page=el_admin_main&action=import" class="add-new-h2">'.__('Import','event-list').'</a>';
		echo '
			<div class="wrap">
				<div id="icon-edit-pages" class="icon32"><br /></div><h2>'.$header.' '.$new_link.' '.$import_link.'</h2>';
		$this->show_message($action);
	}

	private function show_edit_view($action) {
		$this->show_page_header($action, true);
		require_once(EL_PATH.'admin/includes/admin-new.php');
		echo EL_Admin_New::get_instance()->edit_event();
		echo '</div>';
	}

	public function embed_main_scripts() {
		// If edit event is selected switch to embed admin_new
		switch($this->action) {
			case 'edit':
			case 'added':
			case 'modified':
				// embed admin new script
				require_once(EL_PATH.'admin/includes/admin-new.php');
				EL_Admin_New::get_instance()->embed_new_scripts();
				break;
			case 'import':
				require_once(EL_PATH.'admin/includes/admin-import.php');
				EL_Admin_Import::get_instance()->embed_import_scripts();
				break;
			default:
				// embed admin_main script
				wp_enqueue_script('eventlist_admin_main_js', EL_URL.'admin/js/admin_main.js');
				wp_enqueue_style('eventlist_admin_main', EL_URL.'admin/css/admin_main.css');
		}
	}

	private function show_event_table() {
		// check used parameters
		$page = isset($_REQUEST['page']) ? sanitize_key($_REQUEST['page']) : '';

		// show event table
		// the form is required for bulk actions, the page field is required for plugins to ensure that the form posts back to the current page
		$out = '<form id="event-filter" method="get">
				<input type="hidden" name="page" value="'.$page.'" />';
		// show table
		$this->event_table->prepare_items();
		ob_start();
			$this->event_table->display();
			$out .= ob_get_contents();
		ob_end_clean();
		$out .= '</form>';
		return $out;
	}

	private function show_message($action) {
		if(empty($action)) {
			return;
		}

		// check used get parameters
		$error = isset($_GET['error']) ? 0 < intval($_GET['error']) : false;
		$title = isset($_GET['title']) ? sanitize_text_field($_GET['title']) : 'No title available!';

		switch($action) {
			case 'added':
				if(!$error)
					$this->show_update_message('New Event "'.esc_html(stripslashes($title)).'" was added.');
				else
					$this->show_error_message('Error: New Event "'.esc_html(stripslashes($title)).'" could not be added.');
				break;
			case 'modified':
				// check used get parameters
				$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

				if(!$error)
					$this->show_update_message('Event "'.esc_html(stripslashes($title)).'" (id: '.$id.') was modified.');
				else
					$this->show_error_message('Error: Event "'.esc_html(stripslashes($title)).'" (id: '.$id.') could not be modified.');
				break;
			case 'deleted':
				// check used get parameters
				$ids_string = isset($_GET['id']) ? preg_replace('/[^0-9,]/', '', $_GET['id']) : '';

				$num_deleted = count(explode(',', $ids_string));
				$plural = ($num_deleted > 1) ? 's' : '';
				if(!$error)
					$this->show_update_message($num_deleted.' Event'.$plural.' deleted (id'.$plural.': '.htmlentities($ids_string).').');
				else
					$this->show_error_message('Error: Deleting failed (Event id'.$plural.': '.htmlentities($ids_string).')!');
				break;
		}
	}

	private function show_update_message($text) {
		echo '
			<div id="message" class="updated below-h2"><p><strong>'.$text.'</strong></p></div>';
	}

	private function show_error_message($text) {
		echo '
			<div id="message" class="error below-h2"><p><strong>'.$text.'</strong></p></div>';
	}

	private function update_event() {
		$eventdata = $_POST;
		// provide correct sql start- and end-date
		if(!empty($eventdata['sql_start_date'])) {
			$eventdata['start_date'] = $eventdata['sql_start_date'];
		}
		if(!empty($eventdata['sql_end_date'])) {
			$eventdata['end_date'] = $eventdata['sql_end_date'];
		}
		// set end_date to start_date if multiday is not selected
		if(empty($eventdata['multiday'])) {
			$eventdata['end_date'] = $eventdata['start_date'];
		}
		return $this->db->update_event($eventdata);
	}

	private function redirect($action=false, $error=false, $query_args=array()) {
		$url = remove_query_arg(array('noheader', 'action', 'action2', 'filter', '_wpnonce', '_wp_http_referer'), $_SERVER['REQUEST_URI']);
		if($action) {
			$url = add_query_arg('action', $action, $url);
		}
		if($error) {
			$url = add_query_arg('error', '1', $url);
		}
		$url = add_query_arg($query_args, $url);
		wp_redirect($url);
		exit;
	}
}
?>
