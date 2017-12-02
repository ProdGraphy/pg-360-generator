<?php
/**
 *
 * @link              http://ProdGraphy.com
 * @since             1.0.0
 * @package           ProdGraphy
 *
 * @wordpress-plugin
 * Plugin Name:       pg360
 * Plugin URI:        http://prodgraphy.com
 * Version:           1.1.0
*/
//This file for making settings page(main setting page) 
$pg360_general_setting='/pg-360-generator/admin/partials/pg360_setting.php';

?>
<div id="overlay">
	<h2 class="overlay_text">Available only on premium version  <a href="http://www.prodgraphy.com"> ProdGraphy.com</h2></a>
</div>
<div class="wrap" >
	<div class="head">
		<h1><strong>
			<span style="color:#ff9700">Prod</span>Graphy 360&deg; General Settings
		</strong></h1>
	</div>
	<form method="POST" action="options.php" enctype="multipart/form-data" >
		<?php 
			settings_fields( 'pg360_view_settings' ); //pass slug name of page,
			do_settings_sections( $pg360_general_setting );  //pass slug name of page
			submit_button();
		?>
	</form>
</div>
