<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'>
							  <!-- Sidebar -->
							 <div id='side-content-left'>   
							 <?php  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == 'Success') { ?>
								<div class='msg-ok enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>  
							 <?php }  else  if($notificationArray['type'] == 'Failed') { ?>
							  <div class='msg-error enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>
							 <?php   } } ?>          
								
								<!-- Add user Box -->
								<?php if($data['arr_permission'][0]['add_perm'] == 1 || (isset($data['Select ModelVariables']) && $data['arr_permission'][0]['edit_perm'] == 1)) { ?>
								<h3><?php if(isset($data['Select ModelVariables'])){ echo 'Edit Select Model';}else { echo 'Add Select Model';}?></h3>
								<div class='body-con'><?php foreach($data['fields'] as $k => $v)
									{ ?>
										<label for='sf-<?php echo $v; ?>'><?php echo ucfirst($v); ?></label>
            							<input type='text' id='<?php echo $v; ?>' name='<?php echo $v; ?>' value='<?php if(isset($data['Select ModelVariables']))
                                                                                { echo $data['Select ModelVariables'][$v]; } ?>'/>
							<?php }if(isset($data['Select ModelVariables']))
									{
									?>
									<input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['Select ModelVariables'][$data['fields'][0]]; ?>','Select Model','save')" />
									<?php 
									}
									else
									{
								    ?>
								   		<input type='button' value='Insert' class='green_button' onClick="validateFormFields('','Select Model','save')" />
									<?php } ?>
								</div>
								<?php 
									$div_id = 'main-content-right';
								} ?> 
								</div>
								<!-- Main Content -->
								<div id="<?php if(isset($div_id)) echo $div_id; else echo 'main-content'; ?>">
						
									<!-- All Users -->
									<h2>All Select Model (<?php echo sizeof($data['allSelect Model'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'Select Model', 'default')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'Select Model', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'Select Model', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class="body-con"><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr><?php foreach($data['fields'] as $k => $v)
									{ ?>										
										<th><?php echo ucfirst($v); ?></th>									
									<?php	
									} ?>
									<th>Action</th></tr>
										</thead>										
										   <?											  
											   for($i=0; $i<count($data['allSelect Model']); $i++)
											   {
												?>
												  	<tr>
														<?php 
														foreach($data['fields'] as $k => $v)
														{ 
														?>
															<td><?php echo $data['allSelect Model'][$i][$v] ?></td>										
														<?php
														}
														?>																										
														<td>
														<? if($data['alltest'][$i]['is_active'] != 0){?> 
															<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('<?php echo $data['allSelect Model'][$i]['id']?>','Select Model','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allSelect Model'][$i]['id']?>','Select Model','delete','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															if(isset($_REQUEST['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allSelect Model'][$i]['id']?>','Select Model','restore','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
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
								<!-- END Main Content -->
							</div>
							<!-- END Content -->