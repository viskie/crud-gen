<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'>
                         <div id='side-content-left'>
                         <?php  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == 'Success') { ?>
								<div class='msg-ok enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>  
							 <?php }  else  if($notificationArray['type'] == 'Failed') { ?>
							  <div class='msg-error enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>
							 <?php   } } ?>  
                                     <h2><?php if(isset($data['leave_typeVariables'])){ echo 'Edit Leave Type';}else { echo 'Add Leave Type';}?></h2><div class='body-con'><label for='leave_type'>Leave Type<span>*</span></label>
							<input type='text' id='leave_type' name='leave_type' class='validate[required]' value='<?php if(isset($data['leave_typeVariables']))
							{ echo $data['leave_typeVariables']['leave_type']; } ?>'/><?php if(isset($data['leave_typeVariables']))
								{
								?>
								<input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['leave_typeVariables']['id'];?>','settings','save')" />
								<?php 
								}
								else
								{
								?>
									<input type='button' value='Insert' class='green_button' onClick="validateFormFields('','settings','save')" />
								<?php } ?>
							</div></div>
                            
                        			<div id='main-content-right'><!-- All Users -->
									<h2>All Leave types (<?php echo sizeof($data['allleave_type'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'settings', 'default')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'settings', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'settings', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class="body-con"><div class='for_links'><a href='javascript:setValueCallPage("","settings","showform");'>Add Leave Type</a></div><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr>
												<th>#</th><th>Leave Type</th><th>Action</th></tr>
										</thead>										
										   <?php											  
											   for($i=0; $i<count($data['allleave_type']); $i++)
											   {
												?>
												  	<tr>
														<td><?php echo ($i+1);?></td><td><?php echo $data['allleave_type'][$i]['leave_type']; ?></td><td>
														<? if($data['allleave_type'][$i]['is_active'] != 0){?> 
															<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('<?php echo $data['allleave_type'][$i]['id']?>','settings','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allleave_type'][$i]['id']?>','settings','delete','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															if(isset($_REQUEST['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allleave_type'][$i]['id']?>','settings','restore','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
																	<?
																}
															}	
														?>
														</td>
													</tr>								   
												   <?
											   }
											  ?>
																			
									</table>
									<!-- END Users table -->                           
									</div>            
								</div>								
							</div></div>