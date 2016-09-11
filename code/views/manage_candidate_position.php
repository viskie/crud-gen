<?
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
{
	header("location: index.php");
	exit();
}

extract($data);
?>
				<!-- Content -->

					<div id="content" class="clearfix">

						<!-- Sidebar -->

                        <div id="side-content-left">   

							 <?  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == "Success") { ?>

                        <div class="msg-ok enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>  

                      <? }  else  if($notificationArray['type'] == "Failed") { ?>

                      <div class="msg-error enable-close" style="cursor: pointer;"><?=$notificationArray['message'] ?></div>

                      <?   } } ?>

                            <!-- Add user Box -->

                            <h3><? if(isset($data['candidate_positionVariables'])) { echo "Edit Candidate Position";} else{ echo "Add Candidate Position"; }?></h3>

                            <div class="body-con">                    

                                    <label for="sf-username">Candidate Position Name<span> *</span></label>

                                    <input type="text" id="position_name" name="position_name" value='<?php if(isset($data['candidate_positionVariables'])) echo $data['candidate_positionVariables']['position_name'] ?>' />

                                    <?php

									if(isset($data['candidate_positionVariables'])) 

									{

									?>

                                     <input type="button" value="Update" class="green_button"  onclick="javascript:validateFormFields('<?php echo $data['candidate_positionVariables']['position_id']?>','settings','save_position')" > 

                                    <?php 

									}

									else

									{

									?>

                                    <input type="button" value="Insert" class="green_button" onClick="javascript:validateFormFields('','settings','save_position')">

                                    <?php } ?>

                            </div>

                            <!-- END Add user Box -->

                        </div>

                        <!-- END Sidebar -->

						<!-- Main Content -->

                        <div id="main-content-right">

							<!-- All Users -->

                            <h2>All Candidate Positions (<?=count($allcandidate_position)?>)</h2>

                            <div class='show_links'>
										<a href="javascript:show_records(2, 'settings', 'default_position')" <?php if(isset($_REQUEST['show_status'])) if($_REQUEST['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'settings', 'default_position')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'settings', 'default_position')" <? if(isset($_REQUEST['show_status']))if($_REQUEST['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
							</div>	

                            

                            <div class="body-con">       

                            <!-- Users table --> 

                            <table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">

                                <thead>

                                    <tr>

                                    	<th>Sr. No</th>

                                        <th>Candidate Position Name</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                   <?	for($i=0;$i<count($allcandidate_position);$i++)

									   {?>

										    <tr>

                                            	<td class="backcolor"><?=$i+1 ?></td>

												<td ><?=$allcandidate_position[$i]['position_name']; ?></td>

                                                <td>

												<?php if($allcandidate_position[$i]['is_active'] != 0) {?>

                                                <a href="javascript:setValueCallPage(<?php echo $allcandidate_position[$i]['position_id']; ?>,'settings','showform_position')" class="tiptip-top" title="Edit">

                                                        <img src="img/icon_edit.png" alt="edit" />

                                                    </a>

                                                &nbsp;&nbsp;&nbsp;

                                                <a href="javascript:deleteRestoreEntry(<?php echo $allcandidate_position[$i]['position_id']; ?>,'settings','delete_position','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>

                                                 <?php } 

                                                 else {?>

                                                &nbsp;&nbsp;&nbsp;

                                                <a href="javascript:deleteRestoreEntry(<?php echo $allcandidate_position[$i]['position_id']; ?>,'settings','restore_position','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="Restore"></a>

                                                <?php } ?>

                                                </td>   
											</tr>								   

										   <?

									   }

									  ?>	

                                </tbody>

                            </table> <!-- END Users table -->
							</div>
						</div>
						<!-- END Main Content -->
					</div>
					<!-- END Content -->