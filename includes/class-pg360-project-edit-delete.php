<?php
/**
 *
 * @link       www.prodgraphy.com
 * @since      1.0.0
 *
 * @package    pg360
 * @subpackage pg360/includes
 *
 * This class handle Edit/Delete Project in Gallery
 */
// && wp_verify_nonce($_POST['nonce_edit'.$pg360_projectID_toEdit] )
class pg360_project_edit_delete{

    /**
     * Edit 360 
    */  
    public function pg360_project_edit(){
        
        if ( ($_SERVER["REQUEST_METHOD"] == "POST") &&! empty($_POST) ){            

            $pg360_projectID_toEdit=$_POST['ToEditID'];//hidden input value pass 360 ID to edit
        
            // form DB Work
            global $wpdb;
            $pg360_table1Name = $wpdb->prefix .'pg360_project';
            
            /**
             * collect Edited values:
            */

            if (isset($_POST['ProjectName'])){            
                
                //Check if project name exist or not:
                $pg360_name="'".sanitize_text_field($_POST['ProjectName'])."'";
                
                $pn_query=$wpdb->query(
                    "SELECT * FROM $pg360_table1Name WHERE ProjectName=$pg360_name AND ID <> $pg360_projectID_toEdit"
                );
    
                if ($pn_query){
                    $ProjectName=sanitize_text_field($_POST['ProjectName'].$pg360_projectID_toEdit);
                }else{
                    $ProjectName=sanitize_text_field($_POST['ProjectName']);
                } 
            }
            if (isset($_POST['Width'])):
                $Width=$_POST['Width'];
            endif;

            if (isset($_POST['Height'])):
                $Height=$_POST['Height'];
            endif;
            

            if (isset($_POST['NoOfLayer'])):
                $NoOfLayer=$_POST['NoOfLayer'];
            endif;
            
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

            if (isset($_POST['Hint'])){
                $Hint=$_POST['HintInput'];
            }else{
                $Hint="Powered by ProdGraphy";
            }
            $data=array(
                'ProjectName'       => $ProjectName,
                'ShortCode'         => ('prodgraphy-'.$ProjectName), 
                'CreationTime'      => current_time('mysql'),                 
                'ProjectWidth'      => $Width,
                'ProjectHeight'     => $Height,
                'NoOfLayer'         => $NoOfLayer,
                'CursorShape'       => $CursorShape,
                'ColorFilter'       => $ColorFilter,
                'Speed'             => $Speed,                
                'Hint'              => $Hint,
                'Interactive'       => $Interactive,                
                'Orientable'        => $Orientable,                
                'ClickFree'         => $ClickFree,                
                'CW'                => $CW,                
                'Shy'               => $Shy,                
            );
            $data=stripslashes_deep($data);
            
            $where=array(
                'ID'=>$pg360_projectID_toEdit,
            );

            $updated=$wpdb->update($pg360_table1Name,$data,$where);
        }
            wp_die();
    }
    
    /**
     *  Delete 360 
    */
    public function pg360_project_delete(){
        
        if (isset($_POST['pg360DelClickedID'])) {
            $pg360_projectID_toDel=$_POST['pg360DelClickedID'];

            global $wpdb;
            $pg360_table1Name = $wpdb->prefix .'pg360_project';
            $pg360_table2Name = $wpdb->prefix .'pg360_images'; 

            $pg360_ProjectImages=$wpdb->get_results(
                "SELECT ImageURL FROM $pg360_table2Name WHERE ProjectID=$pg360_projectID_toDel "
            );// array contain last project all URI 
            for ($i=0; $i < count($pg360_ProjectImages,0); $i++) { 
                $img_guid="'".$pg360_ProjectImages[$i]->ImageURL."'";
                $att_ID= $wpdb->get_var(
                    "SELECT ID FROM wp_posts WHERE guid=$img_guid" 
                );  
                wp_delete_attachment( $att_ID, true );        
            }
            $wpdb->query(
                "DELETE FROM $pg360_table1Name WHERE `ID` = $pg360_projectID_toDel"
            );  
        }
    }

}
