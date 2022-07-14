<?php

class Wfmpanel_Public {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
		add_filter( 'the_content', array( $this, 'add_slidebox' ) );
	}

	public function add_slidebox( $content ) {
		if ( ! is_single() ) {
			return $content;
		}

		global $post;
		$slide_id = get_post_meta( $post->ID, 'wfm_panel', true );
		if ( ! $slide_id ) {
			return $content;
		}

		$slide = $this->get_slide( $slide_id );
		ob_start();
		require_once WFMPANEL_PLUGIN_DIR . 'public/templates/slide-template.php';
		$slide_html = ob_get_clean();

		return $content . $slide_html;
	}

	public function get_slide( $slide_id ) {
		global $wpdb;
		return $wpdb->get_row( "SELECT * FROM wfm_panel WHERE id = $slide_id", ARRAY_A );
	}

	public function enqueue_scripts_styles() {
		if ( ! is_single() ) {
			return;
		}
		wp_enqueue_style( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'public/css/wfmpanel-public.css' );
		wp_enqueue_script( 'slidebox', WFMPANEL_PLUGIN_URL . 'public/js/jquery.slideBox.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'public/js/wfmpanel-public.js', array( 'jquery' ), false, true );
	}

}
