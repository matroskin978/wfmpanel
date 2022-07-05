<?php

class Wfmpanel_Activate {

	public static function activate() {
		global $wpdb;
		$wpdb->query( "CREATE TABLE IF NOT EXISTS `wfm_panel` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci" );
	}

}
