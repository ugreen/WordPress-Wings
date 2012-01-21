<?php
/*
Plugin Name: Test plugin
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
		add_action('login_head', array($this, 'login_head'));
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
	function admin_menu() {
		add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
	}
	
	function login_head() { 
		?><style type="text/css">
			.login h1 a {
				background: url(<?php echo $this->pluginUrl.'/images/logo.png'; ?>) no-repeat top center;
				margin-bottom: 10px;
			}
		</style><?php
	}
}
new Wings;