<?php

class Wfmpanel_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'admin/css/wfmpanel-admin.css' );
		wp_enqueue_script( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'admin/js/wfmpanel-admin.js', array( 'jquery' ) );
	}

}
