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
class pg360_generator{

    public $pg360_postInsert = false;

    public function pg360_generate_code(){
        //loader
        ?>
            <div class="loader"></div>
        <?php
        
        $pg360Project = array(
            // 'editID'    =>admin_url('admin-ajax.php?action=pg360_EditID'),
            'edit'      => admin_url('admin-ajax.php?action=pg360_project_edit'),
            'delete'    => admin_url('admin-ajax.php?action=pg360_project_delete'),
        );
        wp_localize_script('pg360_gallery', 'pg360Project', $pg360Project);
        
        global $wpdb;
        //extract data from DB:
        $pg360_table1Name = $wpdb->prefix . 'pg360_project';
        $pg360_table2Name = $wpdb->prefix . 'pg360_images';

        $pg360_projectNo = $wpdb->query(
            "SELECT ID FROM $pg360_table1Name"
        );//Number of project to display

        //for loop to get all values in array
        for ($i = 0; $i <$pg360_projectNo; $i++) {    
    
            $pg360_ProjectID[$i] = $wpdb->get_var(
                "SELECT ID FROM $pg360_table1Name",
                0,
                $i
            );//get project ID

            $pg360_ProjectImages[$i] = $wpdb->get_results(
                "SELECT ImageURL FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID[$i] "
            );// array contain last project all URI 

            if (count($pg360_ProjectImages[$i],0)!==0){
                
                $pg360_ProjectName[$i] = $wpdb->get_var(
                    "SELECT ProjectName FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i] "
                );//get Project Name
    
                $pg360_ProjectWidth[$i] = $wpdb->get_var(
                    "SELECT ProjectWidth FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"            );//get Project width
    
                $pg360_ProjectHeight[$i] = $wpdb->get_var(
                    "SELECT ProjectHeight FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get Project height
    
                $pg360_NoOfLayer[$i] = $wpdb->get_var(
                    "SELECT NoOfLayer FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//number of layer
    
                $pg360_CursorShape[$i] = $wpdb->get_var(
                    "SELECT CursorShape FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project CursorShape
    
                $pg360_Speed[$i] = $wpdb->get_var(
                    "SELECT Speed FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//Project Speed
    
                $pg360_CW[$i] = $wpdb->get_var(
                    "SELECT CW FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//inverse direction
    
                $pg360_Hint[$i] = $wpdb->get_var(
                    "SELECT Hint FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Hint
    
                $pg360_Interactive[$i] = $wpdb->get_var(
                    "SELECT Interactive FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Interactive
    
                $ImgColorFilter[$i]=$wpdb->get_var(
                    "SELECT ColorFilter FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project color filter
                
                if ($ImgColorFilter[$i]=='BW'){
                    $ClassColorFilter[$i]='ClassColorFilter_BW';
                }elseif($ImgColorFilter[$i]=='PGfilter1'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter1';
                }elseif($ImgColorFilter[$i]=='PGfilter2'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter2';
                }elseif($ImgColorFilter[$i]=='PGfilter3'){
                    $ClassColorFilter[$i]='ClassColorFilter_PGfilter3';
                }else{
                    $ClassColorFilter[$i]="";
                }            
                
                $pg360_Orientable[$i] = $wpdb->get_var(
                    "SELECT Orientable FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project Orientable
                
                $pg360_ClickFree[$i] = $wpdb->get_var(
                    "SELECT ClickFree FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//get project ClickFree
                
                $pg360_Shy[$i] = $wpdb->get_var(
                    "SELECT Shy FROM $pg360_table1Name WHERE ID=$pg360_ProjectID[$i]"
                );//Project Shy
    
                $pg360_ProjectImagesWidth[$i] = $wpdb->get_results(
                    "SELECT Width FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID[$i] "
                );// array contain last project all URI    
                $pg360_ProjectImagesHeight[$i] = $wpdb->get_results(
                    "SELECT Height FROM $pg360_table2Name WHERE ProjectID=$pg360_ProjectID[$i] "
                );// array contain last project all URI   
    
                /*-------------------------------------
                    *      Generate Gallery Page
                ----------------------------------------*/
                ?>
            <div class="pg360" >
                <div class="pg360_pack" id="<?php echo $pg360_ProjectName[$i]; ?>" > 
                    <img 
                        src             ='<?php echo $pg360_ProjectImages[$i][0]->ImageURL; ?>'
                        width           ='<?php echo $pg360_ProjectWidth[$i]/100 * $pg360_ProjectImagesWidth[$i][0]->Width; ?>'
                        height          ='<?php echo $pg360_ProjectHeight[$i] /100 * $pg360_ProjectImagesHeight[$i][0]->Height; ?>'
                        alt             ='Error Code PG360-404 :Can not find image to Display'
                        class           ='reel <?php echo $ClassColorFilter[$i]; ?>'
                        id              ='<?php echo 'pg360_'.$pg360_ProjectName[$i].$pg360_ProjectID[$i];?>'
                        data-images     ='<?php
                                        for ($j = 0; $j < count($pg360_ProjectImages[$i], 0); $j++) {
                                            if ($j < (count($pg360_ProjectImages[$i], 0) - 1))
                                                echo $pg360_ProjectImages[$i][$j]->ImageURL . ',';
                                            else
                                                echo $pg360_ProjectImages[$i][$j]->ImageURL;
                                        };
                                        ?>'
                        data-frames     ='<?php echo ((count($pg360_ProjectImages[$i], 0))/$pg360_NoOfLayer[$i]); ?>'
                        data-rows       ='1'
                        data-cw         ='<?php echo $pg360_CW[$i]; ?>'
                        data-speed      ='<?php echo ($pg360_Speed[$i]); ?>'
                        data-cursor     ='<?php echo $pg360_CursorShape[$i]; ?>'
                        data-shy        ='<?php echo $pg360_Shy[$i]; ?>'
                        data-clickfree  ='<?php echo $pg360_ClickFree[$i]; ?>'
                        data-suffix     =''
                        data-draggable  ='<?php echo $pg360_Interactive[$i]; ?>'
                        data-orientable ='<?php echo $pg360_Orientable[$i]; ?>'
                        data-preloader  ='<?php echo $pg360_Preloader[$i]; ?>'
                        data-hint       ='<?php echo $pg360_Hint[$i]; ?>'
                    >
                    <div class="pg360_watermark">
                            <font size="<?php echo (0.05)*$pg360_ProjectWidth[$i]; ?>">
                                <?php
                                if (get_option( 'pg360_watermark' )==''){
                                    echo'Powered By <span style="color:orangered">Prod</span>graphy.com';
                                }else{
                                    echo'Powered By <span style="color:orangered">Prod</span>graphy.com';
                                }       
                                ?>
                            </font> 
                    </div>
                    <div id="pg360_control" class="pg360_tooltip <?php echo 'pg360_'.$pg360_ProjectName[$i].$pg360_ProjectID[$i];?>">
                    
                        <span class="pg360_tooltiptext">Available only on premium version</span>

                        <button  class="pg360_btn_play" style="
                                color:<?php echo  get_option( 'pg360_ctl_btn_color', '#0073aa' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#ffffff,0.4');?>; "disabled>
                            <span class="dashicons dashicons-controls-play pg360_btn"></span>
                        </button>
                        
                        <button  class="pg360_btn_pause" style="
                                color:<?php echo  get_option( 'pg360_ctl_btn_color', '#0073aa' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#ffffff,0.4');  ?>;" disabled>

                            <span class="dashicons dashicons-controls-pause pg360_btn"></span>
                        </button>
                        
                        <button  class="pg360_btn_fullscreen" style="
                                color:<?php echo  get_option( 'pg360_ctl_btn_color', '#0073aa' )?>;background-color:<?php echo get_option('pg360_ctl_background_color','#ffffff,0.4');  ?>;" disabled>
                            <span class="dashicons dashicons-editor-expand pg360_btn"></span>
                        </button>

                    </div>
                </div>
                <?php //360 Name ?>
                <div class="pg360_name"><strong><?php echo $pg360_ProjectName[$i] ?></strong></div>
                <?php
                /**
                 * Select checkbox to insert 360 into post or page
                */
                if ($this->pg360_postInsert == true) {
                    ?>
                    <form name="chkbx_result">
                        <input type="checkbox" name="<?php echo $pg360_ProjectName[$i]; ?>" class="pg360_insert_chkbx" value="<?php echo $pg360_ProjectName[$i]; ?>"> 
                        <strong>Select</strong>
                    <form>
                <?php

                } 
                ?>
           
                <div class="edit_Parent" id="<?php echo $pg360_ProjectID[$i] ?>">
                    <span class="dashicons dashicons-edit pg360_edit"></span>
                    <a href="#" class="pg360_edit" > Edit Options</a>
                    </br>
                    <?php
                    // Edit div:    
                    ?>
                    <iframe name="pg360fake"></iframe>
                    <div class="pg360_edit_div">
                        <form method="post" class="pg360_form"  target="pg360fake" action="admin-ajax.php?action=pg360_project_edit" name="<?php echo 'pg360_form'.$pg360_ProjectID[$i];?>" id="<?php echo 'pg360_form'.$pg360_ProjectID[$i];?>">
                        
                        <input type="hidden" name='ToEditID' value='<?php echo $pg360_ProjectID[$i];?>'>

                            <div class=" pg360-row-one">
                                <div class="pg360-field">
                                    <label for="ProjectName" class="input_label">    
                                        360° Name <span class="pg360-danger">*</span>
                                    </label>
                                    <input class="user_input" type="text" name="ProjectName" placeholder="360&deg; Project Name" pattern="[A-Za-z0-9]{1,15}" title="Invalid input, only accept letters and/or numbers with maximum length 15 character" value="<?php echo $pg360_ProjectName[$i]; ?>" Required>
                                </div>
                            
                                
                                <div class="pg360-field ">
                                    <label for="Width" class="input_label">
                                        Image Width %                
                                    </label>                        
                                    <input class="user_input" type="number" name="Width" value="<?php echo $pg360_ProjectWidth[$i];?>" min="10" max="100" step="1">
                                </div>
                                
                                <div class="pg360-field ">
                                    <label for="Height" class="input_label">
                                        Image Height %
                                    </label>                        
                                    <input class="user_input" type="number" name="Height" value="<?php echo  $pg360_ProjectHeight[$i];?>" min="10" max="100" step="1">
                                </div>

                                <div class="pg360-field ">
                                    <label for="CursorShape" class="input_label">
                                        Cursor Shape
                                        </label>                        
                                    <select name="CursorShape" class="user_input" id="set2">
                                        <?php
                                        if ($pg360_CursorShape[$i]=='default'){
                                            echo "<option value='default' selected>Default</option>";
                                        }else{
                                            echo "<option value='default' >Default</option>";
                                        };
                                        if ($pg360_CursorShape[$i]=='hand'){
                                            echo "<option value='hand' selected>Hand</option>";
                                        }else{
                                            echo "<option value='hand'>Hand</option>";
                                        };
                                        if ($pg360_CursorShape[$i]=='none'){
                                            echo "<option value='none' selected>Hide Cursor</option>";
                                        }else{
                                            echo "<option value='none' >Hide Cursor</option>";
                                        };
                                        if ($pg360_CursorShape[$i]=='alias'){
                                            echo "<option value='alias' selected>Alias</option>";
                                        }else{
                                            echo "<option value='alias' >Alias</option>";
                                        };
                                        if ($pg360_CursorShape[$i]=='col-resize'){
                                            echo "<option value='col-resize' selected>Horizontal arrows</option>";
                                        }else{
                                            echo "<option value='col-resize' >Horizontal arrows</option>";
                                        };
                                        if ($pg360_CursorShape[$i]=='row-resize'){
                                            echo "<option value='row-resize'  selected>Vertical arrows</option>";
                                        }else{
                                            echo "<option value='row-resize' >Vertical arrows</option>";
                                        };
                                        if ($pg360_CursorShape[$i]==''){
                                            echo "<option value='' selected>Rotated Arrow</option>";
                                        }else{
                                            echo "<option value=''>Rotated Arrow</option>";
                                        };
                                                                    
                                        ?>
                                    </select>
                                </div>
                    
                                <div class="pg360-field ">
                                    <label for="Speed" class="input_label">
                                        Rotation Speed (0 to 1) *
                                    </label>                        
                                    <input class="user_input" type="number" name="Speed" value="<?php echo $pg360_Speed[$i]; ?>" min="0" max="1" step="0.1">
                                </div>
                                                    
                                <div class="pg360-field pg360_tooltip">
                                <span class="pg360_tooltiptext">Available only on premium version</span>
                                    <label style="color:gray" for="multi" class="input_label">
                                        Multi Vertical Layer? (3D)
                                    </label>    
                                    <select class="user_input" id="set1" disabled>
                                        <option value=0 selected>No</option>
                                        <option value=1 > Yes </option>
                                    </select>
                                </div>
                                    <div>    
                                    </div>                
                                <div class="pg360-field pg360_tooltip">
                                    <span class="pg360_tooltiptext">Available only on premium version</span>
                                    <input class="input_label hintchkbx" type="checkbox" name="Hint" id="pg360_hint" disabled>
                                    <label style="color:gray"  for="HintInput" class="user_input">
                                        Display Hint When Mouse Hover
                                    </label> 
                                    <input id="pg360_hint_input" class="user_input" type="text" name="HintInput" value="<?php echo $pg360_Hint[$i]; ?>" maxlength="25" disabled>      
                                </div>

                            </div>
                
                            <div class="pg360-row-two " >
                                
                                <h2 class="pg360_tip"><u>Quick Selection Options</u> </h2>
                            
                                <div class="pg360-field">
                                    <label for="ColorFilter" class="input_label">
                                        Color Filter                    
                                    </label>
                                    <select name="ColorFilter" class="user_input" id="set2">   
                                    <?php
                                    if ($ImgColorFilter[$i]=='default'){
                                        echo "<option value='default' selected> Default</option>";
                                    }else{
                                        echo "<option value='default' > Default</option>";
                                    }
                                    
                                    if ($ImgColorFilter[$i]=='BW'){
                                        echo "<option value='BW' selected> Black and white</option>";
                                    }else{
                                        echo "<option value='BW' > Black and white</option>";
                                    }
                                    if($ImgColorFilter[$i]=='PGfilter1'){
                                        echo "<option value='PGfilter1' selected>Old</option>";
                                    }else{
                                        echo "<option value='PGfilter1' >Old</option>";
                                    }
                                    if($ImgColorFilter[$i]=='PGfilter2'){
                                        echo "<option value='PGfilter2' selected>Saturated</option>";
                                    }else{ 
                                        echo "<option value='PGfilter2' >Saturated</option>";
                                    }
                                    if($ImgColorFilter[$i]=='PGfilter3'){
                                        echo "<option value='PGfilter3' selected>Pinky</option>";
                                    }else{
                                        echo "<option value='PGfilter3' >Pinky</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                                
                                <div class="pg360-field">
                                    <label for="Draggable" class="input_label interaction_class">
                                        Mouse/Touch Interactive
                                    </label> 
                                    <?php
                                    if ($pg360_Interactive[$i]==TRUE){
                                        echo '<input class="user_input" id="pg360_interactive" type="checkbox" name="Draggable" value="1" checked>';
                                    }else{
                                        echo '<input class="user_input" id="pg360_interactive" type="checkbox" name="Draggable" value="1" >';
                                    }
                                    ?>                        
                                </div>
                    
                                <div class="pg360-field">
                                    <label for="Orientable" class="input_label interaction_class">
                                        Gyroscope devices compatible (Mobile-Tablets ...)
                                    </label> 
                                    <?php
                                    if ($pg360_Orientable[$i]==TRUE){
                                        echo '<input class="user_input interaction" id="pg360_orientable" type="checkbox" name="Orientable" value="1" checked>';
                                    }else{
                                        echo '<input class="user_input interaction" id="pg360_orientable" type="checkbox" name="Orientable" value="1" >';
                                    }
                                    ?>                        
                                </div>
                    
                                <div class="pg360-field">
                                    <label for="ClickFree" class="input_label interaction_class">
                                        Click Free ( just mouse hover)
                                    </label> 
                                    <?php
                                    if ($pg360_ClickFree[$i]==TRUE){
                                        echo '<input class="user_input interaction" id="pg360_clickfree" type="checkbox" name="ClickFree" value="1" checked>';
                                    }else{
                                        echo '<input class="user_input interaction" id="pg360_clickfree" type="checkbox" name="ClickFree" value="1">';
                                    }
                                    ?>
                                </div>
                                
                                <div class="pg360-field pg360_tooltip">
                                    <span class="pg360_tooltiptext">Available only on premium version</span>
                                    <label for="DisplayControlBtn" class="input_label" style="color:gray">
                                        Display Control Button (Play-Pause-Full Screen)
                                    </label>  
                                    <input class="user_input" type="checkbox" name="DisplayControlBtn" value="1" checked disabled>
                                </div>
                    
                                <div class="pg360-field">
                                    <label for="Shy" class="input_label">
                                        Only Rotate After Click
                                    </label>  
                                    <?php
                                    if ($pg360_Shy[$i]==TRUE){
                                        echo '<input class="user_input" id="pg360_shy" type="checkbox" name="Shy" value="1" id="sh" checked>';
                                    }else{
                                        echo '<input class="user_input" id="pg360_shy" type="checkbox" name="Shy" value="1" id="sh" >';
                                    }
                                    ?>
                                </div>
                                
                                <div class="pg360-field">
                                    <label for="CW" class="input_label">
                                        Inverse Direction
                                    </label>  
                                    <?php
                                    if ($pg360_CW[$i]==TRUE){
                                        echo '<input class="user_input" id="pg360_CW" type="checkbox" name="CW" value="1" id="inv" checked>';
                                    }else{
                                        echo '<input class="user_input" id="pg360_CW" type="checkbox" name="CW" value="1" id="inv" >';
                                    }
                                    ?>
                                </div>

                                <div class="pg360-field pg360_tooltip" >
                                <span class="pg360_tooltiptext">Available only on premium version</span>

                                    <label style="color:gray"  for="DisableRightClick" class="input_label" disabled>
                                        Disable Right Click
                                    </label> 
                                    <input class="user_input" type="checkbox" name="DisableRightClick" value="1" disabled>                        
                                </div>
                    
                            </div>
                            <?php 
                                                        
                            submit_button(); 
                            ?>        
                        </form>
                        
                    </div>
                    <span class="dashicons dashicons-trash pg360_delete"></span>
                    <a href="#" class="pg360_delete">Permanently Delete </a>
                </div>
                
            </div>
        
            <?php
            // 360 delete empty project
            }else{
                $wpdb->query($wpdb->prepare("DELETE FROM $pg360_table1Name WHERE `ID` =%s",$pg360_ProjectID[$i])); 
                $pg360_projectNo=$pg360_projectNo-1; 
            }
        };
    }
};
