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
//this file for gallery preview
$pg360_gallery_title='<h1><span style="color:orangered">360° </span> Gallery</h1> ';
$pg360_powered='<h4 style="color:darkred"> Powered By ProdGraphy</h4>';
echo $pg360_gallery_title;
echo $pg360_powered;
echo '<p>Can adjust almost all options just click <strong style="color:#0073aa;">Edit Options</strong> found under each 360°</p>' ;
$pg360_genrator=new pg360_generator();
$pg360_genrator->pg360_postInsert=false;
$pg360_genrator->pg360_generate_code(); 