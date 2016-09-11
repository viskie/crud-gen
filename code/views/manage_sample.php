<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
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
								<h3><? if(isset($data['sampleVariables'])){ echo 'Edit Sample';}else { echo 'Add Sample';}?></h3>
								<div class='body-con'><label for='name'>Name<span>*</span></label>
<input type='text' id='name' name='name' class='validate[required]' value='<?php if(isset($data['sampleVariables']))
                                                                                { echo $data['sampleVariables']['name']; } ?>'/> <div style='margin-left:48%;'><?php if(isset($data['sampleVariables']))
									{
									?>
									<input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['sampleVariables']['id'];?>','test','save')" />
									<?php 
									}
									else
									{
								    ?>
								   	<input type='button' value='Insert' class='green_button' onClick="validateFormFields('','sample','save')" />
									<?php } ?>
									<input type='button' value='Cancel' class='green_button' onclick='javascript:callPage(\'sample\',\'default\')'>
								</div></div>								
								</div>
								<!-- Main Content -->
								<div id="main-content-right"><!-- All Users -->
									<h2>All sample (<?php echo sizeof($data['allsample'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'sample', 'default')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'sample', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'sample', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class="body-con"><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr>
												<th>#</th><th>Name</th><th>Action</th></tr>
										</thead>										
										   <?php											  
											   for($i=0; $i<count($data['allsample']); $i++)
											   {
												?>
												  	<tr>
														<td><?php echo ($i+1);?></td><td><?php echo $data['allsample'][$i]['name']; ?></td><td>
														<? if($data['allsample'][$i]['is_active'] != 0){?> 
															<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('<?php echo $data['allsample'][$i]['id']?>','sample','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allsample'][$i]['id']?>','sample','delete','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															if(isset($_REQUEST['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allsample'][$i]['id']?>','sample','restore','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
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