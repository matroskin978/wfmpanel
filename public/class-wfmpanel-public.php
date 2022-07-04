<?php

class Wfmpanel_Public {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'public/css/wfmpanel-public.css' );
		wp_enqueue_script( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'public/js/wfmpanel-public.js', array( 'jquery' ), false, true );
	}

}
