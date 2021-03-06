<?php
if(!defined('ABSPATH')) {
	exit;
}

require_once(EL_PATH.'includes/db.php');
require_once(EL_PATH.'includes/options.php');
require_once(EL_PATH.'includes/categories.php');

// This class handles rss feeds
class EL_Feed {

	private static $instance;
	private $db;
	private $options;
	private $categories;

	public static function &get_instance() {
		// Create class instance if required
		if(!isset(self::$instance)) {
			self::$instance = new self();
		}
		// Return class instance
		return self::$instance;
	}

	private function __construct() {
		$this->db = EL_Db::get_instance();
		$this->options = EL_Options::get_instance();
		$this->categories = EL_Categories::get_instance();
		$this->init();
	}

	public function init() {
		add_feed($this->options->get('el_feed_name'), array(&$this, 'print_eventlist_feed'));
		if($this->options->get('el_head_feed_link')) {
			add_action('wp_head', array(&$this, 'print_head_feed_link'));
		}
	}

	public function print_head_feed_link() {
		echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo_rss('name').' &raquo; '.$this->options->get('el_feed_description').'" href="'.$this->eventlist_feed_url().'" />';
	}

	public function print_eventlist_feed() {
		header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
		$events = $this->db->get_events(($this->options->get('el_feed_upcoming_only') ? 'upcoming' : null), null, 0, array('start_date DESC', 'time DESC', 'end_date DESC'));

		// Print feeds
		echo
'<?xml version="1.0" encoding="'.get_option('blog_charset').'"?>
	<rss version="2.0"
		xmlns:content="http://purl.org/rss/1.0/modules/content/"
		xmlns:wfw="http://wellformedweb.org/CommentAPI/"
		xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:atom="http://www.w3.org/2005/Atom"
		xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
		xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>
		<channel>
			<title>'.get_bloginfo_rss('name').'</title>
			<atom:link href="'.apply_filters('self_link', get_bloginfo()).'" rel="self" type="application/rss+xml" />
			<link>'.get_bloginfo_rss('url').'</link>
			<description>'.$this->options->get('el_feed_description').'</description>
			<lastBuildDate>'.mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false).'</lastBuildDate>
			<language>'.get_option('rss_language').'</language>
			<sy:updatePeriod>'.apply_filters('rss_update_period', 'hourly').'</sy:updatePeriod>
			<sy:updateFrequency>'.apply_filters('rss_update_frequency', '1').'</sy:updateFrequency>
			'; do_action('rss2_head');
		if(!empty($events)) {
			foreach ($events as $event) {
				echo '
			<item>
				<title>'.$this->format_date($event->start_date, $event->end_date).' - '.$this->sanitize_feed_text($event->title).'</title>
				<pubDate>'.mysql2date('D, d M Y H:i:s +0000', $event->start_date, false).'</pubDate>';
				// Feed categories
				$cats = $this->categories->convert_db_string($event->categories, 'name_array');
				foreach ($cats as $cat) {
					echo '
				<category>'.$this->sanitize_feed_text($cat).'</category>';
				}
				echo '
				<description>
					'.$this->feed_description($event).'
				</description>';
				if(!empty($event->details)) {
					echo '
				<content:encoded>
					'.$this->feed_description($event).':
					'.$this->sanitize_feed_text(do_shortcode($event->details)).'
				</content:encoded>';
				}
				echo '
			</item>';
			}
		}
		echo '
		</channel>
	</rss>';
	}

	public function eventlist_feed_url() {
		if(get_option('permalink_structure')) {
			$feed_link = get_bloginfo('url').'/feed/';
		}
		else {
			$feed_link = get_bloginfo('url').'/?feed=';
		}
		return $feed_link.$this->options->get('el_feed_name');
	}

	public function update_feed_rewrite_status() {
		$feeds = array_keys((array)get_option('rewrite_rules'), 'index.php?&feed=$matches[1]');
		$feed_rewrite_status = (0 < count(preg_grep('@[(\|]'.$this->options->get('el_feed_name').'[\|)]@', $feeds))) ? true : false;
		if('1' == $this->options->get('el_enable_feed') && !$feed_rewrite_status) {
			// add eventlist feed to rewrite rules
			flush_rewrite_rules(false);
		}
		elseif('1' != $this->options->get('el_enable_feed') && $feed_rewrite_status) {
			// remove eventlist feed from rewrite rules
			flush_rewrite_rules(false);
		}
	}

	private function feed_description(&$event) {
		return $this->format_date($event->start_date, $event->end_date). (empty($event->time) ? '' : ' '.$this->sanitize_feed_text($event->time)).(empty($event->location) ? '' : ' - '.$this->sanitize_feed_text($event->location));
	}

	private function sanitize_feed_text($text) {
		return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}

	private function format_date($start_date, $end_date) {
		$startArray = explode("-", $start_date);
		$start_date = mktime(0,0,0,$startArray[1],$startArray[2],$startArray[0]);

		$endArray = explode("-", $end_date);
		$end_date = mktime(0,0,0,$endArray[1],$endArray[2],$endArray[0]);

		$event_date = '';

		if ($start_date == $end_date) {
			if ($startArray[2] == "00") {
				$start_date = mktime(0,0,0,$startArray[1],15,$startArray[0]);
				$event_date .= date("F, Y", $start_date);
				return $event_date;
			}
			$event_date .= date("M j, Y", $start_date);
			return $event_date;
		}

		if ($startArray[0] == $endArray[0]) {
			if ($startArray[1] == $endArray[1]) {
				$event_date .= date("M j", $start_date) . "-" . date("j, Y", $end_date);
				return $event_date;
			}
			$event_date .= date("M j", $start_date) . "-" . date("M j, Y", $end_date);
			return $event_date;

		}

		$event_date .= date("M j, Y", $start_date) . "-" . date("M j, Y", $end_date);
		return $event_date;
	}
}
?>
