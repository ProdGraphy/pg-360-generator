<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Pg360
 * @subpackage Pg360/public
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string       The ID of this plugin.
	 */
	private $pg360_generator;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $pg360_generator_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string      The name of the plugin.
	 * @param      string      The version of this plugin.
	 */
	public function __construct( $pg360_generator, $pg360_generator_version ) {

		$this->pg360_generator = $pg360_generator;
		$this->pg360_generator_version = $pg360_generator_version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function pg360_enqueue_styles() {

		wp_enqueue_style( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'css/pg360-public.css', array(), $this->pg360_generator_version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function pg360_enqueue_scripts() {

		wp_enqueue_script( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'js/pg360-public.js', array( 'jquery' ), $this->pg360_generator_version, true );
		
		wp_enqueue_script( 'pg360_reel', plugins_url('pg-360-generator/admin/js/jquery.reel-min.js'), array('jquery'),'' ,true );
		
	}

}
