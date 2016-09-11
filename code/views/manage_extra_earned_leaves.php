<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					//printr($data['allhrm']);exit;
					?>
						<!-- Content -->
						<div id='content' class='clearfix'><!-- Sidebar -->
							 <div id='side-content-left'>   
							 <?php  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == 'Success') { ?>
								<div class='msg-ok enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>  
							 <?php }  else  if($notificationArray['type'] == 'Failed') { ?>
							  <div class='msg-error enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>
							 <?php   } } ?>          
								<div id='main-content'>
								<!-- Add user Box -->							
								<h3><? if(isset($data['extra_earned_leavesVariables'])){ echo 'Edit Extra earned leaves';}else { echo 'Add Extra earned leaves';}?></h3>
								<div class='body-con'>
                                
                                <label for='employee_id'>Employee <span>*</span></label>
                                <?php 
									$selectedValue="";
									if(isset($data['extra_earned_leavesVariables']))
										{ $selectedValue=$data['extra_earned_leavesVariables']['id'];}
									
									createComboBox('employee_id','id','employee_name', $data['allhrm'], $blankField=true, $selectedValue,$display2="",$firstFieldValue='Please Select', $otherParameters = "class='validate[required]'")?>
                                
								                                          
                                  	<label for='date'>Date<span>*</span></label>
									<input type='text' id='date' name='date' class='validate[required] date_range' value='<?php if(isset($data['extra_earned_leavesVariables']))
                                                                                { echo $data['extra_earned_leavesVariables']['date']; } ?>'/>
                                    <input type="hidden" id="date_alt" name="date_alt" size="30" value='<?php if(isset($data['extra_earned_leavesVariables']))
                                                                             { echo date('Y-m-d',strtotime($data['extra_earned_leavesVariables']['date']));} ?>' class="date_range_alt">
                                                                                
                                    <label for='comment'>Comment<span></span></label>
									<textarea name="comment" id="comment" class=""><?php if(isset($data["extra_earned_leavesVariables"]))
                                                                                { echo $data["extra_earned_leavesVariables"]["comment"]; } ?></textarea> 
                                                                                
                                    <div style='margin-left:48%;'>
                                    <input type='button' value='Insert' class='green_button' onClick="validateFormFields('','hrm','save_extra_earned_leaves')" />
									<!--< ?php if(isset($data['extra_earned_leavesVariables']))
									{
									?>
									<input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('< ?php echo $data['extra_earned_leavesVariables']['id'];?>','test','save')" />
									< ?php 
									}
									else
									{
								    ?>
								   	<input type='button' value='Insert' class='green_button' onClick="validateFormFields('','extra_earned_leaves','save')" />
									< ?php } ?>-->
									
								</div></div>								
								</div>
                                </div>
								<!-- Main Content -->
								<div id="main-content-right"><!-- All Users -->
									<h2>All Extra Earned Leaves (<?php echo sizeof($data['allextra_earned_leaves'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'hrm', 'default_extra_earned_leaves')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'hrm', 'default_extra_earned_leaves')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'hrm', 'default_extra_earned_leaves')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class="body-con"><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr>
												<th>#</th><th>Employee </th><th>Date</th><th>Comment</th><th>Action</th></tr>
										</thead>										
										   <?php											  
											   for($i=0; $i<count($data['allextra_earned_leaves']); $i++)
											   {
												?>
												  	<tr>
														<td><?php echo ($i+1);?></td><td><?php echo $data['allextra_earned_leaves'][$i]['employee_name']; ?></td>
                                                        <td><?php echo formatDate($data['allextra_earned_leaves'][$i]['date']); ?></td>
                                                        <td><?php echo $data['allextra_earned_leaves'][$i]['comment']; ?></td><td>
														<? if($data['allextra_earned_leaves'][$i]['is_active'] != 0){?> 
                                                        
															<!--< ?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('< ?php echo $data['allextra_earned_leaves'][$i]['id']?>','extra_earned_leaves','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															
															< ?php 
															} 
															-->
                                                            <?php
															if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allextra_earned_leaves'][$i]['id']?>','hrm','delete_extra_earned_leaves','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															if(isset($_REQUEST['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allextra_earned_leaves'][$i]['id']?>','hrm','restore_extra_earned_leaves','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
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
							</div>