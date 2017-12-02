<?php
/**
 *
 * @link       www.prodgraphy.com
 * @since      1.0.0
 *
 * @package    pg360
 * @subpackage pg360/includes
 *
 * this class handle media button
 */
 
class pg360_gallery_shortcode_button{
    
    protected $pg360_ShortCode;
    protected $pg360_ShortCodes;
    protected $pg360_SelectedProject;

    public function __construct(){

        global $wpdb;
        //extract data from DB:
        $pg360_table1Name = $wpdb->prefix .'pg360_project';
        $pg360_table2Name = $wpdb->prefix .'pg360_images';
        
        //check table exist (to prevent activate plugin error)
        if($wpdb->get_var("SHOW TABLES LIKE '$pg360_table1Name'") == $pg360_table1Name) {
            
            $this->pg360_ShortCodes=$wpdb->get_results(
                "SELECT ShortCode FROM $pg360_table1Name"
            );// array contain  short codes
        
            for ($i=0; $i <count($this->pg360_ShortCodes,0) ; $i++) { 
                
                $this->pg360_ShortCode=$this->pg360_ShortCodes[$i]->ShortCode;
                add_shortcode($this->pg360_ShortCode,array($this,'pg360_shortcode_generator'));
            };         
        }
    }
    
    /** 
     * Short Code Generator
     * this function to return what shorcode represent
    */
    public function pg360_shortcode_generator($atts,$content=NULL,$tag){        
        
        $tag="'".$tag."'";
        global $wpdb;
        
        /**
         * extract data from DB:
        */
        $pg360_table1Name = $wpdb->prefix .'pg360_project';

        $pg360_ProjectName=$wpdb->get_var(
            "SELECT ProjectName FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project name
        
        $pg360_ProjectWidth = $wpdb->get_var(
            "SELECT ProjectWidth FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get Project width
        
        $pg360_ProjectHeight = $wpdb->get_var(
            "SELECT ProjectHeight FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get Project height

        $pg360_NoOfLayer=1;
        
        $pg360_CursorShape=$wpdb->get_var(
            "SELECT CursorShape FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project CursorShape
        
        $pg360_Speed=$wpdb->get_var(
            "SELECT Speed FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project Speed
        
        $pg360_CW=$wpdb->get_var(
            "SELECT CW FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//inverse direction
        
        $pg360_Preloader=1;
        
        $pg360_Hint=$wpdb->get_var(
            "SELECT Hint FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Hint
        
        $pg360_Interactive=$wpdb->get_var(
            "SELECT Interactive FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Interactive
        
        $pg360_Orientable=$wpdb->get_var(
            "SELECT Orientable FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project Orientable
        
        $pg360_ClickFree=$wpdb->get_var(
            "SELECT ClickFree FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project ClickFree
                
        $pg360_Shy=$wpdb->get_var(
            "SELECT Shy FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project Shy
        $pg360_ProjectID=$wpdb->get_var(
            "SELECT ID FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//Project id
        
        $ImgColorFilter=$wpdb->get_var(
            "SELECT ColorFilter FROM $pg360_table1Name WHERE ShortCode=$tag"
        );//get project color filter
        
        if ($ImgColorFilter=='BW'){
            $ClassColorFilter='ClassColorFilter_BW';
        }elseif($ImgColorFilter=='PGfilter1'){
            $ClassColorFilter='ClassColorFilter_PGfilter1';
        }elseif($ImgColorFilter=='PGfilter2'){
            $ClassColorFilter='ClassColorFilter_PGfilter2';
        }elseif($ImgColorFilter=='PGfilter3'){
            $ClassColorFilter='ClassColorFilter_PGfilter3';
        }else{
            $ClassColorFilter="";
        }            
    
        /** 
         * From Image Table:
        */

        $pg360_table2Name = $wpdb->prefix .'pg360_images';
        
        $pg360_ProjectImages=$wpdb->get_results(
            "SELECT ImageURL FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID "
        );// array contain last project all URI 
        
        $pg360_ProjectImagesWidth=$wpdb->get_results(
            "SELECT Width FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID "
        );// array contain last project all URI    

        $pg360_ProjectImagesHeight=$wpdb->get_results(
            "SELECT Height FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID "
        );// array contain last project all URI    
        

        /**
         * Returned HTML :
        */  

        $content.= '<div class="grid-item pg360 " >';
            $content.='<div class="pg360_pack">';
            $content.= '<img src="' . $pg360_ProjectImages[0]->ImageURL.'"';
                $content.= 'width="'.$pg360_ProjectWidth/100*$pg360_ProjectImagesWidth[0]->Width.'"';
                $content.= 'height="'.$pg360_ProjectHeight/100*$pg360_ProjectImagesHeight[0]->Height.'"';
                $content.= 'alt="Error Code PG360-404 :Can not find image to Display"';
                $content.= "class='reel ". $ClassColorFilter."'";
                $content.= "id='".'pg360_'. $pg360_ProjectName.$pg360_ProjectID."'";//to disable right click with
                $content.= "data-images='";
                    for ($j=0; $j < count($pg360_ProjectImages,0) ; $j++) { 
                        if ($j<(count($pg360_ProjectImages,0)-1))
                            $content.= $pg360_ProjectImages[$j]->ImageURL.',';
                        else
                            $content.= $pg360_ProjectImages[$j]->ImageURL."'"; 
                    };
                $content.= "data-frames='". (count($pg360_ProjectImages,0)/$pg360_NoOfLayer)."'";
                $content.= "data-rows='".($pg360_NoOfLayer)."'";
                $content.= "data-cw='".$pg360_CW."'";
                $content.= "data-speed='".($pg360_Speed)."'" ;
                $content.= "data-cursor='".$pg360_CursorShape."'";
                $content.= "data-shy='" .$pg360_Shy."'";
                $content.= "data-clickfree='".$pg360_ClickFree."'";
                $content.= "data-suffix=' '";
                $content.= "data-draggable='". $pg360_Interactive."'";
                $content.= "data-orientable='".$pg360_Orientable."'";
                $content.= "data-preloader='".$pg360_Preloader."'";
                $content.= "data-hint='".$pg360_Hint."'";
                $content.= "data-responsive=false";
                $content.= ">";
            $content.= "<div class='pg360_watermark'>";
                $content.="<font size='".(0.05)*$pg360_ProjectWidth."'>";
                if (get_option( 'pg360_watermark' )==''){
                    $content.="<span style='color :grey;'>Powered By <span style='color:orangered'>Prod</span>Graphy.com</span>";
                }else{
                    $content.= "<span style='color :grey;'>Powered By <span style='color:orangered'>Prod</span>Graphy.com</span>";     
                }
                $content.="</font>"; 
            $content.="</div>";//wtr mrk
        $content.= " </div>";
        $content.= " </div>";//pg360_pack
        
        return ($content);
    }
    
    //Use action media_buttons
    public function pg360_button() {
        ?>
        <a href="#TB_inline?width=753&height=532&inlineId=pg360TB_content" class="button button-secondary thickbox" type="button" id="pg360-add" class="button" data-editor="content" name="Select 360° to Insert">
            <span class="dashicons dashicons-images-alt2" style="padding-top: 2px;">
            </span> 
            PG Add <span style=" font-weight:bold;">360°</span>
        </a>
        <?php
        add_thickbox();
        $this->pg360_inside_thickbox(); 
    }

    public function pg360_inside_thickbox(){
        global $wpdb;       
        $pg360_table1Name = $wpdb->prefix .'pg360_project';
        $pg360_table2Name = $wpdb->prefix .'pg360_images';
        
        $pg360_ProjectNames=$wpdb->get_results(
            "SELECT ProjectName FROM $pg360_table1Name"
        );// array contain  project name

        for ($i=0; $i <count($pg360_ProjectNames,0) ; $i++) { 
            $pg360_ProjectName[$i]=$wpdb->get_var(
                "SELECT ProjectName FROM $pg360_table1Name",
                0,
                $i
            );
            if (isset($_POST[$pg360_ProjectName[$i]])){
                echo $pg360_ProjectName[$i];
            }
        };           
        ?>
        <!-- what inside the thickbox -->
        <div id="pg360TB_content" style="display:none">

            <div class="pg360_mainContent">
                <?php
                    $pg360_genrator=new pg360_generator();
                    $pg360_genrator->pg360_postInsert=true;
                    $pg360_genrator->pg360_generate_code();
                ?>
            </div>

            <div class="pg360_bottom_toolBar">

                <div class="pg360_ControlButtons">

                    <input class="button button-primary " id="pg360Insert" type="submit" name="submit" value="Insert" form="chkbx_result"></input>
                    <button class="button button-primary " id="pg360Cancel">Cancel</button>            
                </div>
            </div>
        </div>

        <?php
    }
    //to use with action wp_enqueue_media
    public function pg360_enqueue_shortcode_scripts(){
        wp_enqueue_script( 'media_button', plugins_url('pg-360-generator/admin/js/pg360_shortcode.js'), array('jquery'),'1.0' ,true );
       
        wp_enqueue_script( 'pg360_reel', plugins_url('pg-360-generator/admin/js/jquery.reel-min.js'), array('jquery'),'' ,true );
        
        wp_enqueue_style( 'admin_css', plugins_url( 'pg-360-generator/admin/css/pg360-admin.css' ), array(), '1', 'all' );
        wp_enqueue_style( 'pg360_gallery', plugins_url('pg-360-generator/admin/css/pg360_gallery.css'), array(), '1', 'all' );
        wp_enqueue_style( 'pg360_shortcode', plugins_url('pg-360-generator/admin/css/pg360_shortcode.css'), array(), '1', 'all' );
    }
}