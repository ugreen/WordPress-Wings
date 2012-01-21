<?php
/*
Plugin Name: WordPress Wings
Plugin URI: http://wpwings.com/
Version: 0.1
Author: Ulrich Green
Description: What does your plugin do and what features does it offer...
*/

class Wings {
	protected $pluginPath;
	protected $pluginUrl;

	function Wings() {
		$this->__construct();
	}
	function __construct() {
		// Set Plugin Path
		$this->pluginPath = dirname(__FILE__);

		// Set Plugin URL
		$this->pluginUrl = WP_PLUGIN_URL . '/wings';
		
		// Turn on features
		add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
		
		add_action('login_head', array($this, 'login_head'));
		add_action('admin_menu', array($this, 'admin_menu'));
		add_action('wp_dashboard_setup', array($this, 'wp_dashboard_setup'));
		
		add_filter('admin_footer_text', array($this, 'admin_footer_text'));
		add_filter('mce_buttons_3', array($this, 'add_more_buttons'));
		
		add_shortcode('code', array($this, 'bbcode'));
	}

	// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
	function admin_menu() {
		add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
	}
	
	function login_head() { 
		echo '<style type="text/css">';
		echo '	.login h1 a {';
		echo '		background: url('.$this->pluginUrl.'/images/login-logo.png) no-repeat top center;';
		echo '		margin-bottom: 10px;';
		echo '	}';
		echo '</style>';
	}
	function add_more_buttons($buttons) {
		$buttons[] = 'hr';
		$buttons[] = 'del';
		$buttons[] = 'sub';
		$buttons[] = 'sup';
		$buttons[] = 'fontselect';
		$buttons[] = 'fontsizeselect';
		$buttons[] = 'cleanup';
		$buttons[] = 'styleselect';
		$buttons[] = 'wp_page';
		return $buttons;
	}
	function bbcode( $attr, $content = null ) {
		$content = clean_pre($content); // Clean pre-tags
		return '<pre"><code>' .
				str_replace('<', '<', $content) . // Escape < chars
				'</code></pre>';
	}
	function wings_dashboard_widget() {
		echo '<h4>WordPress Wings Dashboard Widget</h4>';
		echo '<p>Some content.</p>';
	}
	function wp_dashboard_setup() {
		wp_add_dashboard_widget('dashboard_wings', __( 'WordPress Wings' ), array($this, 'wings_dashboard_widget'));
	}
	function admin_footer_text () {
		echo 'Awesome! This WordPress site has <a href="http://wpwings.com">Wings</a>';
	}
}
new Wings;