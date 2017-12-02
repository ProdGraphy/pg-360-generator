<?php

/**
 * Fired during plugin activation
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pg360
 * @subpackage Pg360/includes
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function pg360_activate() {
		//define database version:
		global $pg360_db_version;
		$pg360_db_version="1.0";

		//foreign key for int only 
		add_option( 'pg360_db_version', $pg360_db_version );

		//DB
		global $wpdb;
		$pg360_table1Name = $wpdb->prefix .'pg360_project';
		if($wpdb->get_var("SHOW TABLES LIKE '$pg360_table1Name'") !== $pg360_table1Name) {
			
			$charset_collate = $wpdb->get_charset_collate();// see how to be truly written

			//Create DB Table to store each project data :

			$pg360_addNew_sql="CREATE TABLE $pg360_table1Name (
				`ID` int(11) NOT NULL AUTO_INCREMENT,
				`ProjectName` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
				`ShortCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
				`CreationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`ProjectWidth` mediumint(8) NOT NULL,
				`ProjectHeight` mediumint(8) NOT NULL,
				`NoPerLayer` tinyint(3) unsigned NOT NULL,
				`NoOfLayer` tinyint(3) unsigned NOT NULL,
				`CursorShape` enum('hand','','default','none','alias','col-resize','row-resize') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
				`ColorFilter` enum('default','BW','PGfilter1','PGfilter2','PGfilter3') CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
				`Speed` decimal(2,1) unsigned NOT NULL,
				`Hint` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
				`Interactive` bit(1) NOT NULL,
				`Orientable` bit(1) NOT NULL,
				`ClickFree` bit(1) NOT NULL,
				`CW` bit(1) NOT NULL,
				`Shy` bit(1) NOT NULL,
				PRIMARY KEY (`ID`),
				UNIQUE KEY `projectName` (`projectName`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );							
			dbDelta( $pg360_addNew_sql );			
		}
		//Create DB Table to store images URI W.R.T Project table  :
		$pg360_table2Name = $wpdb->prefix .'pg360_images';
		if($wpdb->get_var("SHOW TABLES LIKE '$pg360_table2Name'") !== $pg360_table2Name) {
						
			$pg360_images_sql="CREATE TABLE $pg360_table2Name (
				`ImageID` int(11) NOT NULL AUTO_INCREMENT,
				`ProjectID` int(11) NOT NULL,
				`ImageURL` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
				`Width` mediumint(8) NOT NULL,
				`Height` mediumint(8) NOT NULL,
				`UploadTime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`ImageID`),
				KEY `pg360Relations` (`projectID`),
				CONSTRAINT `pg360Relations` 
				FOREIGN KEY (`projectID`) REFERENCES $pg360_table1Name (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=UTF8";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );							
			dbDelta( $pg360_images_sql );		
		}
	}
}