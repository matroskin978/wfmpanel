<?php

class Wfmpanel_Admin {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_post_save_slide', array( $this, 'save_slide' ) );
		add_action( 'wp_ajax_wfmpanel_change_slide', array( $this, 'change_slide' ) );
	}

	public static function debug( $data ) {
		echo "<pre>" . print_r( $data, 1 ) . "</pre>";
	}

	public static function get_slides( $all = false ) {
		global $wpdb;
		if ( $all ) {
			return $wpdb->get_results( "SELECT * FROM wfm_panel ORDER BY title ASC", ARRAY_A );
		}
		$slides = $wpdb->get_results( "SELECT id, title FROM wfm_panel ORDER BY title ASC", ARRAY_A );
		$data   = array();
		foreach ( $slides as $slide ) {
			$data[ $slide['id'] ] = $slide['title'];
		}

		return $data;
	}

	public function change_slide() {
		if ( ! isset( $_POST['wfmpanel_change_slide'] ) || ! wp_verify_nonce( $_POST['wfmpanel_change_slide'], 'wfmpanel_action' ) ) {
			echo json_encode( array( 'answer' => 'error', 'text' => __( 'Security error!', 'wfmpanel' ) ) );
			wp_die();
		}

		global $wpdb;
		$slide_id = isset( $_POST['slide_id'] ) ? (int) $_POST['slide_id'] : 0;
		$article_id = isset( $_POST['article_id'] ) ? (int) $_POST['article_id'] : 0;

		if ( ! $article_id ) {
			echo json_encode( array( 'answer' => 'error', 'text' => __( 'Error article ID', 'wfmpanel' ) ) );
			wp_die();
		}

		if ( $slide_id ) {
			if ( update_post_meta( $article_id, 'wfm_panel', $slide_id ) ) {
				echo json_encode( array( 'answer' => 'success', 'text' => __( 'Saved successfully', 'wfmpanel' ) ) );
			} else {
				echo json_encode( array( 'answer' => 'error', 'text' => __( 'Save error', 'wfmpanel' ) ) );
			}
		} else {
			delete_post_meta( $article_id, 'wfm_panel' );
			echo json_encode( array( 'answer' => 'success', 'text' => __( 'Saved successfully', 'wfmpanel' ) ) );
		}

		wp_die();
	}

	public function save_slide() {
		if ( ! isset( $_POST['wfmpanel_add_slide'] ) || ! wp_verify_nonce( $_POST['wfmpanel_add_slide'], 'wfmpanel_action' ) ) {
			wp_die( __( 'Error!', 'wfmpanel' ) );
		}

		$slide_title   = isset( $_POST['slide_title'] ) ? trim( $_POST['slide_title'] ) : '';
		$slide_content = isset( $_POST['slide_content'] ) ? trim( $_POST['slide_content'] ) : '';
		$slide_id      = isset( $_POST['slide_id'] ) ? (int) $_POST['slide_id'] : 0;

		if ( empty( $slide_title ) || empty( $slide_content ) ) {
			set_transient( 'wfmpanel_form_errors', __( 'Form fields are required', 'wfmpanel' ), 30 );
		} else {
			$slide_title   = wp_unslash( $slide_title );
			$slide_content = wp_unslash( $slide_content );
			global $wpdb;

			if ( $slide_id ) {
				$query = "UPDATE wfm_panel SET title = %s, content = %s WHERE id = $slide_id";
			} else {
				$query = "INSERT INTO wfm_panel (title, content) VALUES (%s, %s)";
			}

			if ( false !== $wpdb->query( $wpdb->prepare(
					$query, $slide_title, $slide_content
				) ) ) {
				set_transient( 'wfmpanel_form_success', __( 'Slide saved', 'wfmpanel' ), 30 );
			} else {
				set_transient( 'wfmpanel_form_errors', __( 'Error saving slide', 'wfmpanel' ), 30 );
			}
		}
		wp_redirect( $_POST['_wp_http_referer'] );
	}

	public function enqueue_scripts_styles() {
		wp_enqueue_style( 'wfmpanel-jquery-ui', WFMPANEL_PLUGIN_URL . 'admin/assets/jquery-ui-accordion/jquery-ui.css' );
		wp_enqueue_style( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'admin/css/wfmpanel-admin.css' );

		wp_enqueue_script( 'sweetalert', WFMPANEL_PLUGIN_URL . 'admin/js/sweetalert2.js' );
		wp_register_script( 'wfmpanel-jquery-ui', WFMPANEL_PLUGIN_URL . 'admin/assets/jquery-ui-accordion/jquery-ui.js' );
		wp_enqueue_script( 'wfmpanel', WFMPANEL_PLUGIN_URL . 'admin/js/wfmpanel-admin.js', array(
			'jquery',
			'wfmpanel-jquery-ui'
		) );
		wp_localize_script( 'wfmpanel', 'wfmpanelSlide', array( 'nonce' => wp_create_nonce( 'wfmpanel_action' ) ) );
	}

	public function admin_menu() {
		add_menu_page( __( 'WFM Panel Main', 'wfmpanel' ), __( 'WFM Panel', 'wfmpanel' ), 'manage_options', 'wfmpanel-main', array(
			$this,
			'render_main_page'
		), 'dashicons-embed-photo' );

		add_submenu_page( 'wfmpanel-main', __( 'WFM Panel Main', 'wfmpanel' ), __( 'Set slide', 'wfmpanel' ), 'manage_options', 'wfmpanel-main' );
		add_submenu_page( 'wfmpanel-main', __( 'Slides management', 'wfmpanel' ), __( 'Slides management', 'wfmpanel' ), 'manage_options', 'wfmpanel-slides', array(
			$this,
			'render_slides_page'
		) );
	}

	public function render_main_page() {
		require_once WFMPANEL_PLUGIN_DIR . 'admin/templates/main-page-template.php';
	}

	public function render_slides_page() {
		require_once WFMPANEL_PLUGIN_DIR . 'admin/templates/slides-page-template.php';
	}

	public static function get_posts() {

		return new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 10,
			'orderby'        => 'ID',
			'order'          => 'DESC',
			'paged'          => $_GET['paged'] ?? 1,
		) );
	}

}
