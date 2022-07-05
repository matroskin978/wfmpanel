<?php

class Wfmpanel_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'admin/css/wfmpanel-admin.css' );
		wp_enqueue_script( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'admin/js/wfmpanel-admin.js', array( 'jquery' ) );
	}

	public function admin_menu() {
		add_menu_page( __( 'WFM Panel Main', 'wfmpanel' ), __( 'WFM Panel', 'wfmpanel' ), 'manage_options', 'wfmpanel-main', array( $this, 'render_main_page' ), 'dashicons-embed-photo' );

		add_submenu_page( 'wfmpanel-main', __( 'WFM Panel Main', 'wfmpanel' ), __( 'Set slide', 'wfmpanel' ), 'manage_options', 'wfmpanel-main' );
		add_submenu_page( 'wfmpanel-main', __( 'Slides management', 'wfmpanel' ), __( 'Slides management', 'wfmpanel' ), 'manage_options', 'wfmpanel-slides', array( $this, 'render_slides_page' ) );
	}

	public function render_main_page() {
		require_once WFMPANEL_PLUGIN_DIR . 'admin/templates/main-page-template.php';
	}

	public function render_slides_page() {
		require_once WFMPANEL_PLUGIN_DIR . 'admin/templates/slides-page-template.php';
	}

}
