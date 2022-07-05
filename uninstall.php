<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS `wfm_panel`" );

delete_metadata( 'post', '', 'wfm_panel', '', true );
