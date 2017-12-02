<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Pg360
 * @subpackage Pg360/includes
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360 {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pg360_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $pg360_loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $pg360_generator;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $pg360_generator_version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PG_360_GENERATOR_VERSION' ) ) {
			$this->pg360_generator_version = PG_360_GENERATOR_VERSION;
		} else {
			$this->pg360_generator_version = '1.1.0';
		}
		$this->pg360_generator = 'pg360';

		$this->pg360_load_dependencies();
		$this->pg360_set_locale();
		$this->pg360_define_admin_hooks();
		$this->pg360_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pg360_Loader. Orchestrates the hooks of the plugin.
	 * - Pg360_i18n. Defines internationalization functionality.
	 * - Pg360_Admin. Defines all hooks for the admin area.
	 * - Pg360_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pg360_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pg360-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pg360-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pg360-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pg360-public.php';
		
		/**
		 * The class responsible for handling dropped media,handle DB,collect data and generate 360
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pg360-handle-media.php';
		
		/**
		 * The class responsible for media button and generate shortCode
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pg360-shortcode-button.php';
		 
		/*
 		 * This class handle Edit/Delete Project in Gallery
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pg360-project-edit-delete.php';		
		
		/*
 		 * This class responsible about generate 360 code
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pg360-generator.php';		
		 

		$this->pg360_loader = new Pg360_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pg360_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pg360_set_locale() {

		$pg360_i18n = new Pg360_i18n();

		$this->pg360_loader->add_action( 'plugins_loaded', $pg360_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pg360_define_admin_hooks() {

		$pg360_admin = new Pg360_Admin( $this->get_pg360_generator(), $this->get_pg360_generator_version() );
		$pg360_handlemedia = new pg360_handle_media($this->get_pg360_generator(), $this->get_pg360_generator_version());
		$pg360ProjectED=new pg360_project_edit_delete($this->get_pg360_generator(), $this->get_pg360_generator_version());
		$pg360_button_shortcode=new pg360_gallery_shortcode_button($this->get_pg360_generator(), $this->get_pg360_generator_version());
		
		$this->pg360_loader->add_action( 'admin_enqueue_scripts', $pg360_admin , 'pg360_enqueue_styles' );
		$this->pg360_loader->add_action( 'admin_enqueue_scripts', $pg360_admin , 'pg360_enqueue_scripts' );
		
		//Admin Menu
		$this->pg360_loader->add_action( 'admin_menu', $pg360_admin , 'pg360_menu' );
		
		//setting
		$this->pg360_loader->add_action( 'admin_init',$pg360_admin , 'pg360_main_setting' );
		
		//Dropzone Work
		$this->pg360_loader->add_action( 'wp_ajax_pg360_handle_dropped_media',$pg360_handlemedia,'pg360_handle_dropped_media' );
		$this->pg360_loader->add_action( 'admin_post_pg360_handle_deleted_media',$pg360_handlemedia, 'pg360_handle_deleted_media');
		
		//DB Work
		$this->pg360_loader->add_action( 'wp_ajax_pg360_handle_project',$pg360_handlemedia,'pg360_handle_project');
		$this->pg360_loader->add_action( 'wp_ajax_pg360_delete_project',$pg360_handlemedia, 'pg360_delete_project');
		
		//reel jQuery
		$this->pg360_loader->add_action( 'wp_ajax_pg360_handle_reel',$pg360_handlemedia,'pg360_handle_reel');
		
		//gallery edit/delete
		$this->pg360_loader->add_action( 'wp_ajax_pg360_pass_id',$pg360ProjectED,'pg360_pass_id');		
		$this->pg360_loader->add_action( 'wp_ajax_pg360_project_edit',$pg360ProjectED,'pg360_project_edit');
		$this->pg360_loader->add_action( 'wp_ajax_pg360_project_delete',$pg360ProjectED, 'pg360_project_delete');
		
		//media button
		$this->pg360_loader->add_action('media_buttons',$pg360_button_shortcode,'pg360_button',11);
		$this->pg360_loader->add_action('wp_enqueue_media',$pg360_button_shortcode,'pg360_enqueue_shortcode_scripts');		
		
		//silence migrate Jquery
		add_action( 'wp_default_scripts', function( $scripts ) {
			if ( ! empty( $scripts->registered['jquery'] ) ) {
				$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
			}
		} );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pg360_define_public_hooks() {

		$pg360_public = new Pg360_Public( $this->get_pg360_generator(), $this->get_pg360_generator_version() );

		$this->pg360_loader->add_action( 'wp_enqueue_scripts', $pg360_public, 'pg360_enqueue_styles' );
		$this->pg360_loader->add_action( 'wp_enqueue_scripts', $pg360_public, 'pg360_enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->pg360_loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_pg360_generator() {
		return $this->pg360_generator;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Pg360_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_pg360_loader() {
		return $this->pg360_loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_pg360_generator_version() {
		return $this->pg360_generator_version;
	}

}
