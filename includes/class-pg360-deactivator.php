<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Pg360
 * @subpackage Pg360/includes
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function pg360_deactivate() {
		delete_option( 'pg360_db_version');
	}

}
