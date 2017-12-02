<?php
/**
 * The file Handles dropped and deleted images with wordpress ajax
 *
 * @link       www.prodgraphy.com
 * @since      1.0.0
 * 
 * @package    pg360
 * @subpackage pg360/includes
 */

class pg360_handle_media{
    
    public function pg360_handle_project() {
        
        // form DB Work
        if ( ! empty( $_POST ) && check_admin_referer( 'admin-ajax.php?action=pg360_handle_project', 'nonce_create_new' ) ){
            
            global $wpdb;                    
            $pg360_table1Name = $wpdb->prefix .'pg360_project';
            $pg360_table2Name = $wpdb->prefix .'pg360_images'; 
            
            //Check if project name exist or not:
            $pg360_name="'".sanitize_text_field($_POST['ProjectName'])."'";
            $pn_query=$wpdb->query(
                "SELECT * FROM $pg360_table1Name WHERE ProjectName=$pg360_name"
            );

            if ($pn_query){
                $pg360_LastProjectID=$wpdb->get_var(
                    "SELECT ID FROM $pg360_table1Name WHERE ID =  (SELECT MAX(ID) FROM $pg360_table1Name)"
                );//variable contain last constructed project ID

                $ProjectName=sanitize_text_field($_POST['ProjectName']).$pg360_LastProjectID;
            }else{
                //collect values of input fields
                $ProjectName=sanitize_text_field($_POST['ProjectName']);
            } 
            if (isset($_POST['Height'])):
                $Height=$_POST['Height'];
            endif;
            if (isset($_POST['Width'])):
                $Width=$_POST['Width'];
            endif;

            $NoOfLayer=1;
            
            if (isset($_POST['Speed'])):
                $Speed=$_POST['Speed'];
            endif;
            
            if(isset($_POST['CursorShape'])):
                $CursorShape=$_POST['CursorShape'];
            endif;
            if(isset($_POST['ColorFilter'])):
                $ColorFilter=$_POST['ColorFilter'];
            endif;

            if (isset($_POST['Draggable'])){
                $Interactive=true;
            }else{
                $Interactive=false;
            }
            $Hint="Powered by ProdGraphy.com";
            if (isset($_POST['Orientable'])){
                $Orientable=true;
            }else{
                $Orientable=false;
            }

            if (isset($_POST['ClickFree'])){
                $ClickFree=true;
            }else{
                $ClickFree=false;
            }

            if (isset($_POST['CW'])){
                $CW=true;
            }else{
                $CW=false;
            }

            if (isset($_POST['Shy'])){
                $Shy=true;
            }else{
                $Shy=false;
            }

            $wpdb->insert( $pg360_table1Name, 
                array( 
                'ProjectName'       => $ProjectName, 
                'ProjectWidth'      => $Width,
                'ProjectHeight'     => $Height,
                'ShortCode'         => ('prodgraphy-'.$ProjectName),
                'CreationTime'      => current_time('mysql'), 
                'NoOfLayer'         => $NoOfLayer,
                'Speed'             => $Speed,
                'CursorShape'       => $CursorShape,
                'ColorFilter'       => $ColorFilter,
                'Interactive'       => $Interactive,
                'Orientable'        => $Orientable,
                'ClickFree'         => $ClickFree,
                'CW'                => $CW,
                'Shy'               => $Shy,
                'Hint'              => $Hint,
                )
            );
        }
        wp_die();
    }
            
    //The following function will take care of the uploading the image and saving as an attachment in the WordPress library.

    public function pg360_handle_dropped_media() {

        status_header(200);      //Set HTTP status header.   
        global $wpdb;//enter DB
        $pg360_table2Name = $wpdb->prefix .'pg360_images'; 
        $pg360_table1Name = $wpdb->prefix .'pg360_project';

        $upload_dir = wp_upload_dir();
        $upload_url = $upload_dir['url'] . '/';
        $upload_base=$upload_dir['basedir'] . '/';
        $upload_base_url=content_url($upload_base);
        $num_files = count($_FILES['file']['tmp_name']);

        $newupload = 0;

        if (!empty($_FILES) ) {
            $files = $_FILES;
            foreach($files as $file) {
                $newfile = array (
                        'name' => $file['name'],
                        'type' => $file['type'],
                        'tmp_name' => $file['tmp_name'],
                        'error' => $file['error'],
                        'size' => $file['size'],
                );

                $_FILES = array('upload'=>$newfile);
                foreach($_FILES as $filepg360 => $array) {                    
                    $newupload = media_handle_upload( $filepg360, 0 );
                    
                    if($newupload){

                        $req= $wpdb->get_var(
                            "SELECT ID FROM $pg360_table1Name WHERE ID = ( SELECT MAX(ID) FROM $pg360_table1Name)"
                        );// variable contain project ID to make relation with project images
                        
                        $pg360_guid= $wpdb->get_var(
                            "SELECT guid FROM wp_posts WHERE ID =$newupload"
                        );// variable contain guid from wp_posts table
        
                        $fileinfo=getimagesize($pg360_guid);//get image width-height and type
                        
                        $wpdb->insert(
                            $pg360_table2Name,
                            array( 
                                'ProjectID'=>$req,                        
                                'ImageURL' =>$pg360_guid,
                                'Width'=>$fileinfo[0],
                                'Height'=>$fileinfo[1],
                            )
                        );
        
                    }
                    
                }                
            }
        }
        /** 
         * number of image per 360 update
         */
        $NOL= $wpdb->get_var(
            "SELECT NoOfLayer FROM $pg360_table1Name WHERE ID = ( SELECT MAX(ID) FROM $pg360_table1Name)"
        );// variable contain project number of vertical layer
        $NP360= count($wpdb->get_results(
            "SELECT ProjectID FROM $pg360_table2Name WHERE projectID = ( SELECT MAX(ID) FROM $pg360_table1Name)"
        ),0);// variable contain image count for current project
        
        //Update no of image per 360
        $wpdb->update(
        $pg360_table1Name,
        array(
            'NoPerLayer'=>($NP360/$NOL)
        ),
        array(
        'ID'=>$req
            )
        );
        
        wp_die();
    }

    public function pg360_handle_deleted_media(){

        if( isset($_REQUEST['media_id']) ){
            $post_id = absint( $_REQUEST['media_id'] );

            global $wpdb;//enter DB
            $pg360_table2Name = $wpdb->prefix .'pg360_images'; 

            $post_URL=$wpdb->get_var(
                "SELECT guid FROM 'wp_posts' WHERE ID = $post_id"
            );

            $wpdb->query(
                'DELETE FROM $pg360_table2Name WHERE imageURI=$post_URL'
            );

            $status = wp_delete_attachment($post_id, true);
            
            if( $status )
                echo json_encode(array('status' => 'OK'));
            else
                echo json_encode(array('status' => 'FAILED'));
        }
        wp_die();
    }        
}