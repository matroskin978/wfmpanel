<?php

/*
Plugin Name: WFM Post Panel
Plugin URI: https://webformyself.com
Description: Плагин позволяет добавить слайд с необходимым контентом для выбранных статей
Version: 1.0
Author: Andrey Kudlay
Author URI: https://webformyself.com
Text Domain: wfmpanel
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die;
define( 'WFMPANEL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WFMPANEL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WFMPANEL_PLUGIN_NAME', dirname( plugin_basename( __FILE__ ) ) );

function wfmpanel_activate() {
	require_once WFMPANEL_PLUGIN_DIR . 'includes/class-wfmpanel-activate.php';
	Wfmpanel_Activate::activate();
}

register_activation_hook( __FILE__, 'wfmpanel_activate' );

require_once WFMPANEL_PLUGIN_DIR . 'includes/class-wfmpanel.php';

function run_wfmpanel() {
	$plugin = new Wfmpanel();
}

run_wfmpanel();
