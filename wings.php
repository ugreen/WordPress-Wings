<?php
/*
Plugin Name: Test plugin
Plugin URI: http://wpwings.com/
Version: 0.1
Author: Ulrich Green
Description: What does your plugin do and what features does it offer...
*/
new Wings;
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
		$this->pluginUrl = WP_PLUGIN_URL;

		add_action('admin_menu', array($this, 'admin_menu'));
	}

	// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
	function admin_menu() {
		add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
	}
}