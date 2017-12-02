<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.ProdGraphy.com
 * @since      1.0.0
 *
 * @package    Pg360
 * @subpackage Pg360/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pg360
 * @subpackage Pg360/admin
 * @author     Ibrahim Ezzat <Ibrahim.Ezzat@ProdGraphy.com>
 */
class Pg360_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $pg360_generator;
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $pg360_version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pg360_generator, $pg360_version ) {

		$this->pg360_generator = $pg360_generator;
		$this->pg360_version = $pg360_version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function pg360_enqueue_styles($hook_suffix) { 
		
		//"Create New " page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_new.php') {
			wp_enqueue_style( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'css/pg360-admin.css', array(), $this->pg360_version, 'all' );
						
			wp_enqueue_style('dropzone',plugin_dir_url( __FILE__ ).'css/pg360_dropzone.css', array(), $this->pg360_version, 'all' );
		
		}

		//Help page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_help.php') {
			wp_enqueue_style( 'ui_style', plugin_dir_url( __FILE__ ) . 'css/pg360_ui.css', array(), $this->pg360_version, 'all' );
			wp_enqueue_style( 'pg360_gallery', plugin_dir_url( __FILE__ ) . 'css/pg360_help.css', array(), $this->pg360_version, 'all' );
			
		}

		//gallery page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_gallery.php') {
			
			wp_enqueue_style( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'css/pg360-admin.css', array(), $this->pg360_version, 'all' );

			wp_enqueue_style( 'pg360_gallery',plugin_dir_url( __FILE__ ) . 'css/pg360_gallery.css' , array(), $this->pg360_version, 'all' );
			
		}

		//setting page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_setting.php') {
			wp_enqueue_style( 'pg360_setting', plugin_dir_url( __FILE__ ) .'css/pg360_setting.css', array(), $this->pg360_version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function pg360_enqueue_scripts($hook_suffix) {
		
		//create new page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_new.php') {
			
			wp_enqueue_script( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'js/pg360-admin.js', array( 'jquery' ), $this->pg360_version, false );
						
			wp_enqueue_script('pg360_dropzone',plugin_dir_url( __FILE__ ) . 'js/dropzone.min.js', array(),$this->pg360_version,true);
			
			wp_enqueue_script('pg360_handle_media',plugin_dir_url( __FILE__ ) . 'js/pg360_handle_media.js',array('jquery'),$this->pg360_version,true);
		
		}
		//help page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_help.php') {
			
			wp_enqueue_script('pg360_tabs',plugin_dir_url( __FILE__ ) . 'js/pg360_help.js', array('jquery','jquery-ui-tabs'),$this->pg360_version,true);					
		}

		//gallery page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_gallery.php') {
			
			wp_enqueue_script( $this->pg360_generator, plugin_dir_url( __FILE__ ) . 'js/pg360-admin.js', array( 'jquery' ), $this->pg360_version, false );
						
			wp_enqueue_script('pg360_reel',plugin_dir_url( __FILE__ ) . 'js/jquery.reel-min.js', array('jquery'),$this->pg360_version,true);
			
			wp_enqueue_script('pg360_gallery',plugin_dir_url( __FILE__ ) . 'js/pg360_gallery.js', array('jquery'),$this->pg360_version,true);
	
		}

		//setting page
		if($hook_suffix == 'pg-360-generator/admin/partials/pg360_setting.php') {
			wp_enqueue_script( 'pg360_setting', plugin_dir_url( __FILE__ ) . 'js/pg360_setting.js', array( 'jquery' ,'wp-color-picker'), $this->pg360_version, false );
			
		}	
		
	}
	
	// Create Menu Pages    
	public function pg360_menu() {
		
		$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';
		$pg360_create_new='/pg-360-generator/admin/partials/pg360_new.php';
		$pg360_help='/pg-360-generator/admin/partials/pg360_help.php';
		$pg360_gallery='/pg-360-generator/admin/partials/pg360_gallery.php';

		add_menu_page('pg360_admin_menu','360° Generator','manage_options',$pg360_create_new,'',plugins_url('pg-360-generator/images/PG20.png'),10);	

			add_submenu_page($pg360_create_new,'360° Generator','Create 360°','manage_options',$pg360_create_new);
			
			add_submenu_page($pg360_create_new,'360° Gallery','360° Gallery','manage_options',$pg360_gallery);				

			add_submenu_page($pg360_create_new,'360° Settings','Settings','manage_options',$pg360_general_setting);		
			
			add_submenu_page($pg360_create_new,'360° help','Help/Feedback','manage_options',$pg360_help);	
	}

	/*-------------------------------------------
	 *			Handle setting page :
	---------------------------------------------*/
	public function pg360_main_setting(){

		$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';
		
		//register setting into options table
		register_setting('pg360_view_settings','pg360_watermark_chkbox');
		register_setting('pg360_view_settings','pg360_watermark');	
		register_setting('pg360_view_settings','pg360_ctl_btn_color');
		register_setting('pg360_view_settings','pg360_ctl_background_color');
		register_setting('pg360_view_settings','pg360_loading_bar_thickness');				
		register_setting('pg360_view_settings','pg360_loading_bar_color');		
		
		/**---------------------------------------------------
		 * 					Setting Section
		------------------------------------------------------*/
		
		add_settings_section('pg360_view_settings_section','View  Settings', 'pg360_setting_section_cb', $pg360_general_setting );
		//setting section callback function 
		function pg360_setting_section_cb(){
			//put check code and switch interface by if condition
			echo '<p>this section include advanced setting to adjust your 360 as you like to see </p>';
		}

		/**---------------------------------------------------
		 * 					Setting Field
		------------------------------------------------------*/

		//360_Watermark
		add_settings_field('pg360_wm','Display Water Mark','pg360_setting_watermark_cb',$pg360_general_setting,'pg360_view_settings_section');
		
		//Control buttons color
		add_settings_field('pg360_ctl_btn_color','Control Button Color','pg360_setting_ctlcolor_cb',$pg360_general_setting,'pg360_view_settings_section');
		
		//Control Buttons Background Color
		add_settings_field('pg360_ctl_background_color','Control Button Background Color','pg360_setting_ctl_backcolor_cb',$pg360_general_setting,'pg360_view_settings_section');
		
		//loading bar thickness
		add_settings_field('pg360_loading_bar_thickness','Loading Bar Thickness (Pixel)','pg360_loading_bar_thickness_cb',$pg360_general_setting,'pg360_view_settings_section');
		
		// loading bar Color
		add_settings_field('pg360_loading_bar_color','360 Pre-loader Color','pg360_loading_bar_color_cb',$pg360_general_setting,'pg360_view_settings_section');
		
		/**-----------------------------------------------------
		 * 		Callback function for setting field
		--------------------------------------------------------*/
		
		//Watermark
		function pg360_setting_watermark_cb(){
			// $new_value=('Powered By ProdGraphy.com');
			// update_option( 'pg360_watermark', $new_value) ;
			
			echo '<input id="pg360_watermark_chkbox" name="pg360_watermark_chkbox"  type="checkbox" checked />';
			
			echo '<input id="pg360_watermark" name="pg360_watermark"  type="text" placeholder="Water Mark Text" value="'.get_option('pg360_watermark').'"/>';

		}

		//Control buttons color
		function pg360_setting_ctlcolor_cb(){
			echo '<input id="pg360_ctl_btn_color" class="pg360_color " name="pg360_ctl_btn_color" value="'.get_option('pg360_ctl_btn_color','#0073aa').'"/>';
			echo '<div class="pg360_setting_ctrlbtn ">';
			echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#0073aa" ) . '; background-color:'.get_option('pg360_ctl_background_color','#ffffff,0.4').';"'.'>';
			
			echo '<span class="dashicons dashicons-controls-play pg360_btn"></span>';
			echo '</button>';
			
			echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#0073aa" ) . '; background-color:'.get_option('pg360_ctl_background_color','#ffffff,0.4').';"'.'>';
			
			echo '<span class="dashicons dashicons-controls-pause pg360_btn"></span>';
			echo '</button>';

			echo '<button  class="pg360_btn_a" id="fullscreen" style="color: '.  get_option( "pg360_ctl_btn_color", "#0073aa" ) . '; background-color:'.get_option('pg360_ctl_background_color','#ffffff,0.4').';"'.'>';
			
			echo '<span class="dashicons dashicons-editor-expand pg360_btn"></span>';
			echo '</button>';
			echo '</div>';

		}

		//Control Buttons Background Color
		function pg360_setting_ctl_backcolor_cb(){
			echo '<input id="pg360_ctl_background_color" name="pg360_ctl_background_color" class="pg360_color" value="'.get_option('pg360_ctl_background_color','#0073aa').'"/>';
		}
		
		// loading bar thickness
		function pg360_loading_bar_thickness_cb(){
			echo '<input id="loading_bar_thickness" name="pg360_loading_bar_thickness"  type="number"  class="user_input" value="'.get_option('pg360_loading_bar_thickness','1').'"/>';
			
		}
		// 360 Pre-loader Color
		function pg360_loading_bar_color_cb(){
			echo '<input id="pg360_preloader_color" name="pg360_preloader_color"  class="pg360_color"  value="'.get_option('pg360_preloader_color','#0073aa').'"/>';
		}


	}
}