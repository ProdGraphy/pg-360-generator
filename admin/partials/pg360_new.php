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

$pg360Param = array(

    //dropzone handle
    'upload'=>admin_url( 'admin-ajax.php?action=pg360_handle_dropped_media' ),
    'delete'=>admin_url( 'admin-ajax.php?action=pg360_handle_deleted_media' ),

    //for database
    'update'=>admin_url( 'admin-ajax.php?action=pg360_handle_project' ),
);

//localize script in this file:
wp_localize_script('pg360_handle_media','pg360Param', $pg360Param);

$pg360_title="Create New 360&deg;";
?>
<h1><?php echo $pg360_title; ?></h1>
<!-- set this iframe as target to submit form-target by form to take response and not update the hole page -->
<iframe name="pg360Hollow"></iframe> <!--check if u really need-->

<div class="wrap" id="pg360Form">
    
    <form method="post" class="pg360_form" target="pg360Hollow" action="admin-ajax.php?action=pg360_handle_project" id="pg360Form">
        
        <?php 
        //nonce field
        wp_nonce_field( 'admin-ajax.php?action=pg360_handle_project','nonce_create_new' ); 
        ?>

        <h4 class="pg360-danger">* Required Fields</h4>
        <p class="pg360_p">
            Just in 2 simple clicks you can achieve awesome interactive 360° ,just put new 360° name then press next and upload your photos then boom you there it's your awesome 360°.
            <strong class="pg360_tip">You can edit all option later.</strong> 
        </p>
        
        <div class=" pg360-row-one">
            <div class="pg360-field">
                <label for="ProjectName" class="input_label">                        
                    360° Name <span class="pg360-danger">*</span>
                </label>
                <input class="user_input" type="text" name="ProjectName" placeholder="360&deg; Project Name" pattern="[A-Za-z0-9]{1,15}" title="Invalid input, only accept letters and/or numbers with maximum length 15 character" Required>
            </div>
            
            <div>
                <button type="button" class="button button-secondary " id="more-btn"> <strong>+ More Options</strong></button>
            </div>
            <div class="pg360-field more-option">
                <label for="Height" class="input_label">
                    Image Height %
                </label>                        
                <input class="user_input" type="number" name="Height" value="25" min="10" max="100" step="1">
            </div>
            <div class="pg360-field more-option">
                <label for="Width" class="input_label">
                    Image Width %                
                </label>                        
                <input class="user_input" type="number" name="Width" value="25" min="10" max="100" step="1">
            </div>

            <div class="pg360-field more-option">
                <label for="CursorShape" class="input_label">
                    Cursor Shape
                    </label>                        
                <select name="CursorShape" class="user_input" id="set2">
                    <option value='default' >Default</option> 
                    <option value='hand' selected>Hand</option>
                    <option value='none' >Hide Cursor</option>
                    <option value='alias' >Alias</option> 
                    <option value='col-resize' >Horizontal arrows</option> 
                    <option value='row-resize' >Vertical arrows</option>  
                    <option value=''>Rotated Arrow</option>
                </select>
            </div>

            <div class="pg360-field more-option">
                <label for="Speed" class="input_label">
                    Rotation Speed (0 to 1) *
                </label>                        
                <input class="user_input" type="number" name="Speed" value="0.5" min="0" max="1" step="0.1">
            </div>
            
            <div class="pg360-field more-option">
                <div class="pg360_tooltip">
                    <span class="pg360_tooltiptext">Available only on premium version</span>
                    <label style="color:gray" for="multi" class="input_label">
                        Multi Vertical Layer? (3D)
                    </label>    
                    <select class="user_input" id="set1" disabled>
                        <option value=0 selected>No</option>
                        <option value=1 > Yes </option>
                    </select>
                </div>
            </div>

            <div class="pg360-field more-option">
                <div class="pg360_tooltip">
                    <span class="pg360_tooltiptext">Available only on premium version</span>
                    <input class="input_label hintchkbx" type="checkbox" name="Hint" id="pg360_hint" disabled>
                    <label style="color:gray" for="HintInput" class="user_input">
                        Display Hint When Mouse Hover
                    </label> 
                    <input id="pg360_hint_input" class="user_input" type="text" name="HintInput" value="Powered by ProdGraphy.com" maxlength="25" disabled>      
                </div>

            </div>

        </div>

        <div class="pg360-row-two more-option" >
            <h2 class="pg360_tip"><u>Quick Selection Options</u> </h2>
            
            <div class="pg360-field">
                <label for="ColorFilter" class="input_label">
                    Color Filter                    
                </label>                        
                <select name="ColorFilter" class="user_input" id="set2">
                    <option value='default' selected> Default</option> 
                    <option value='BW' > Black and white</option>
                    <option value='PGfilter1' >Old</option>
                    <option value='PGfilter2' >Saturated</option> 
                    <option value='PGfilter3' >Pinky</option> 
                </select>
            </div>

            <div class="pg360-field">
                <label for="Draggable" class="input_label interaction_class">
                    Mouse/Touch Interactive
                </label>                         
                <input class="user_input" id="pg360_interactive" type="checkbox" name="Draggable" value="1" checked>
            </div>

            <div class="pg360-field">
                <label for="Orientable" class="input_label interaction_class">
                    Gyroscope devices compatible (Mobile-Tablets ...)
                </label>                         
                <input class="user_input interaction" id="pg360_orientable" type="checkbox" name="Orientable" value="1" checked>
            </div>

            <div class="pg360-field">
                <label for="ClickFree" class="input_label interaction_class">
                    Click Free ( just mouse hover)
                </label>                         
                <input class="user_input interaction" id="pg360_clickfree" type="checkbox" name="ClickFree" value="1">
            </div>

            <div class="pg360-field">
                <label for="DisplayControlBtn" class="input_label">
                    Display Control Button (Play-Pause-Full Screen)
                </label>                         
                <input class="user_input" type="checkbox" name="DisplayControlBtn" value="1" checked>
            </div>

            <div class="pg360-field">
                <label for="Shy" class="input_label">
                    Only Rotate After Click
                </label>                         
                <input class="user_input" id="pg360_shy" type="checkbox" name="Shy" value="1" id="sh" >
            </div>

            <div class="pg360-field">
                <label for="CW" class="input_label">
                    Inverse Direction
                </label>                         
                <input class="user_input" id="pg360_CW" type="checkbox" name="CW" value="1" id="inv">
            </div>

            <div class="pg360-field pg360_tooltip">
                <span class="pg360_tooltiptext">Available only on premium version</span>
                <label style="color:gray" for="DisableRightClick" class="input_label">
                    Disable Right Click
                </label>                         
                <input class="user_input" type="checkbox" name="DisableRightClick" value="1" disabled>
            </div>

        </div>
        <?php submit_button( 'Next' ,'primary', 'form-submit'); ?>        
    </form>
</div>

<div id="pg360Dz">
    <div id="my-awesome-dropzone" enctype="multipart/form-data" name="file" type="file">  
        <div class="fallback">    			
            <div id="pg360-media-uploader" class="dropzone">
            </div>
        </div>
        <button  class="button button-primary" id="next2">Save To Gallery</button>
    </div>
</div>