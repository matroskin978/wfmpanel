<?php

class Wfmpanel {

	public function __construct() {
		$this->load_dependencies();
		$this->init_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once WFMPANEL_PLUGIN_DIR . 'admin/class-wfmpanel-admin.php';
		require_once WFMPANEL_PLUGIN_DIR . 'public/class-wfmpanel-public.php';
	}

	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'wfmpanel', false, WFMPANEL_PLUGIN_NAME . '/languages/' );
	}

	private function define_admin_hooks() {
		$plugin_admin = new Wfmpanel_Admin();
	}

	private function define_public_hooks() {
		$plugin_public = new Wfmpanel_Public();
	}

}
