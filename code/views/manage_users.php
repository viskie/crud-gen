<?php
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	callheader("index.php");
	exit();
}
?>
	<!-- Content -->
    <div id="content" class="clearfix">
          <!-- Sidebar -->
         <div id="side-content-left">   
		 <?php  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
            <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
         <?php }  else  if($notificationArray['type'] == "Failed") { ?>
          <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
         <?php   } } ?>
           
            
            <!-- Add user Box -->
            <?php if($data['arr_permission'][0]['add_perm'] == 1 || (isset($data['userVariables']) && $data['arr_permission'][0]['edit_perm'] == 1)) { ?>
            <h3><? if(isset($data['userVariables'])){ echo "Edit User";}else { echo "Add User";}?></h3>
            <div class="body-con">
            <label for="sf-email">Name<span>*</span></label>
            <input type="text" id="name" name="name" class="validate[required,custom[onlyLetter]]" value="<?php if(isset($data['userVariables']))
                                                                    { echo $data['userVariables']['name']; }  ?>"/>            
            <label for="sf-username">Username<span>*</span></label>
            <?php
			if(isset($data['userVariables']))
			{
				echo "<label>".$data['userVariables']['user_name']."</label><br/><input type='hidden' id='user_name' name='user_name' value='".$data['userVariables']['user_name']."' >";
			}
			else
			{
			?>
            <input type="text" id="user_name" name="user_name" class="validate[required,custom[onlyAlphaNumeric]]" value="<?php if(isset($data['userVariables']))
                                                                                        { echo $data['userVariables']['user_name']; } ?>"/>
			<?php } ?>            
            <label for="sf-email">Email<span>*</span></label>
            <input type="text" id="user_email" name="user_email" class="validate[required,custom[email]]" value="<?php if(isset($data['userVariables']))
                                                                                { echo $data['userVariables']['user_email']; } ?>"/>
                     
            <label for="sf-password">Password<span>*</span></label>
            <input type="password" id="user_password" name="user_password" class="validate[required,length[6,20]]" value="<?php if(isset($data['userVariables']))
                                                                                            echo '********';  ?>" />            
            <label for="conf_password">Confirm Password<span>*</span></label>
            <input type="password" id="conf_password" class="validate[required,length[6,20],equals[user_password]]" value="<?php if(isset($data['userVariables']))
                                                                                            echo '********';  ?>"/>           
            <label for="sf-password">Phone<span>*</span></label>
            <input type="text" id="user_phone" name="user_phone" class="validate[required,length[8,15],custom[phone]]" value="<?php if(isset($data['userVariables']))
                                                                                 { echo $data['userVariables']['user_phone']; } ?>"/>          
           <label for="sf-role">Role</label>
           <?php 
            if((isset($data['userVariables'])))
            {
               $selected_val = $data['userVariables']['user_group'];
               createComboBox('user_group','group_id','group_name',  $data['allGroups'],true,$selected_val);
            }
            else
                createComboBox('user_group','group_id','group_name', $data['allGroups'],true);
            if(isset($data['userVariables']))
            {
            ?>
            <input type="button" value="Submit" class="green_button"  onclick="javascript:validateFormFields('<?php echo $data['userVariables']['user_id']; ?>','users','save')" />
            <?php 
            }
            else
            {
           ?>
           <input type="button" value="Insert" class="green_button" onClick="validateFormFields('','users','save')" />
            <?php } ?>
            </div>
            <!-- END Add user Box -->
             <?php 
				$div_id = 'main-content-right';
			} ?>       

        </div>
        <!-- END Sidebar -->

        <!-- Main Content -->
        <div id="<?php if(isset($div_id)) echo $div_id; else echo 'main-content'; ?>">

            <!-- All Users -->
            <h2>All Users (<?php echo sizeof($data['allUsers'])?>)</h2>
            <div class="show_links">
				<a href="javascript:show_records(2, 'users', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 2) {?>style="color:black;"<? } ?>>All(<?=$data['rec_counts']['all']?>)</a><span> | </span>
				<a href="javascript:show_records(1, 'users', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?=$data['rec_counts']['active']?>)</a><span> | </span>
				<a href="javascript:show_records(0, 'users', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?=$data['rec_counts']['deleted']?>)</a>
			</div>
            
            <div class="body-con">   
            <!-- Users table --> 
            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?
                       foreach($data['allUsers'] as $value)
                       {
                           ?>
                            <tr>
                                <td class="backcolor"><?=$value['user_name']; ?></td>
                                <td><?=$value['user_email']; ?></td>
                                <td><?=$value['name']; ?></td>
                                <td><?=$value['user_phone']; ?></td>
                                <td>
								<? if($value['is_active'] != 0){?> 
                                	<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
								<a href="javascript:setValueCallPage('<?=$value['user_id']?>','users','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
                                	<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
											&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?=$value['user_id']?>','users','delete','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
								
								<? 		}
								}else{
									if(isset($_REQUEST['show_status']))
										if($data['arr_permission'][0]['restore_perm'] == 1) {
											?>
                                            <a href="javascript:deleteRestoreEntry('<?=$value['user_id']?>','users','restore','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
                                            <?
										}
									}	
								?>
								</td>
                            </tr>								   
                           <?
                       }
                      ?>	
                </tbody>
				
            </table>
			<!-- END Users table -->                           
            </div>            
        </div>
        <!-- END Main Content -->
    </div>
    <!-- END Content -->