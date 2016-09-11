<?php 
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'>
							  <?php  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == 'Success') { ?>
                                <div class='msg-ok enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>  
                             <?php }  else  if($notificationArray['type'] == 'Failed') { ?>
                              <div class='msg-error enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>
                             <?php   } } ?>  	
								<!-- Main Content -->
								<div id="main-content">
						
									<!-- All Users -->
									<h2>All Employee (<?php echo sizeof($data['allhrm'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'hrm', 'default')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'hrm', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'hrm', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>
                                    <div class="for_links"><a href="javascript:setValueCallPage('','hrm','showform');">Add Employee</a></div>									
									<div class="body-con"><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr><?php foreach($data['fields'] as $k => $v)
									{ 
										$lable=str_replace("_"," ",$v);
									?>										
										<th><?php echo ucwords($lable); ?></th>									
									<?php	
									} ?>
                                    <th>Required Documents</th>
									<th>Action</th></tr>
										</thead>										
										   <?			
										   		$cnt=0;								  
											   for($i=0; $i<count($data['allhrm']); $i++)
											   {//printr($data['allhrm'][$i]); exit;
												?>
												  	<tr>
														<?php 
														foreach($data['fields'] as $k => $v)
														{
														?>
														<td><?php echo $data['allhrm'][$i][$v] ?></td>
                                                        <?php
														}
														?>
                                                        <td><?php 
																if(	$data['allhrm'][$i]['identity_proof']==0 || $data['allhrm'][$i]['address_proof']==0 ||
																	$data['allhrm'][$i]['ssc']==0 ||
																	$data['allhrm'][$i]['hsc']==0 || $data['allhrm'][$i]['graduation']==0 ||
																	$data['allhrm'][$i]['post_graduation']==0 || $data['allhrm'][$i]['salary_slip']==0 ||
																	$data['allhrm'][$i]['relieving_letter']==0 || $data['allhrm'][$i]['appoinment_letter']==0
																) 
																	echo "<span style='color: red;'>Not Cleared<span>"; 
																else 
																	echo "Cleared"; 
															?></td>																										
														<td>
                                                        <? if($data['allhrm'][$i]['is_active'] != 0){?> 
															<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('<?php echo $data['allhrm'][$i]['id']?>','hrm','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allhrm'][$i]['id']?>','hrm','delete','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															if(isset($_REQUEST['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allhrm'][$i]['id']?>','hrm','restore','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
																	<?
																}
															}	
														?>
                                                        <a href="javascript:setValueCallPage('<?php echo $data['allhrm'][$i]['id']?>','hrm','view_employee_leaves')" class="tiptip-top" title="view leaves details"><img src="img/icon_view.png" alt="view" /></a>
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