<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'><div id='main-content'><!-- All Users -->
							 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>
                            <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  
                          <? }  else  if($notificationArray['type'] == "Failed") { ?>
                          <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>
                          <?   } } ?>
                          		<!-- Main Content -->
								<div id="main-content">
									<h2>All candidates (<?php echo sizeof($data['allcandidates'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'candidates', 'default')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'candidates', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'candidates', 'default')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class="body-con"><div class='for_links'><a href='javascript:setValueCallPage("","candidates","showform");'>Add Candidate</a></div><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr>
												<th>#</th><th>Name</th><th>Interview Date Time</th><th>Position</th><th>Experience</th><th>Phone Number</th><th>Current Ctc</th><th>Expected Ctc</th><th>Notice Period</th><th>Email</th><th>Status</th><th>Action</th></tr>
										</thead>										
										   <?php											  
											   for($i=0; $i<count($data['allcandidates']); $i++)
											   { 
												?>
												  	<tr>
														<td><?php echo ($i+1);?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['name']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['interview_date_time']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['position_name']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['experience']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['phone_number']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['current_ctc']; ?></td><td><?php echo $data['allcandidates'][$i]['expected_ctc']; ?></td><td><?php echo $data['allcandidates'][$i]['notice_period']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['email']; ?></td>
                                                        <td><?php echo $data['allcandidates'][$i]['status_name']; ?></td>
                                                        <td>
														<? if($data['allcandidates'][$i]['is_active'] != 0){?> 
															<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('<?php echo $data['allcandidates'][$i]['id']?>','candidates','showform')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allcandidates'][$i]['id']?>','candidates','delete','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															if(isset($_REQUEST['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allcandidates'][$i]['id']?>','candidates','restore','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
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