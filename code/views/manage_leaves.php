<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					//echo $data['show_status'];
					?>
						<!-- Content -->
						<div id='content' class='clearfix'><!-- Sidebar -->
							 <div id='side-content-left'>   
							 <?php  if(array_key_exists('type',$notificationArray)) { if($notificationArray['type'] == 'Success') { ?>
								<div class='msg-ok enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>  
							 <?php }  else  if($notificationArray['type'] == 'Failed') { ?>
							  <div class='msg-error enable-close' style='cursor: pointer;'><?php echo $notificationArray['message']; ?></div>
							 <?php   } } ?>          
								
								<!-- Add user Box -->							
								<h3><? if(isset($data['leavesVariables'])){ echo 'Edit Leaves';}else { echo 'Add Leaves';}?></h3>
								<div class='body-con'>
                                
                                <label for='employee_id'>Employee <span>*</span></label>
									<?php 
									$selectedValue="";
									if(isset($data['leavesVariables']))
										{ $selectedValue=$data['leavesVariables']['employee_id'];}
									
									createComboBox('employee_id','id','employee_name', $data['allhrm'], $blankField=true, $selectedValue,$display2="",$firstFieldValue='Please Select', $otherParameters = "class='validate[required]'")?>
                                
                                
                                <label for='leave_type'>Leave Type<span>*</span></label>
                                <?php 
								$selectedValue="";
									if(isset($data['leavesVariables']))
										{ $selectedValue=$data['leavesVariables']['leave_type'];}
								createComboBox('leave_type','id','leave_type', $data['allleave_type'], $blankField=true, $selectedValue,$display2="",$firstFieldValue='Please Select', $otherParameters = "class='validate[required]'")?>
                                

								<label for='leave_from'>Leave From<span>*</span></label>
								<input type='text' id='leave_from' name='leave_from' class='validate[required] date_range_from' value='<?php if(isset($data['leavesVariables']))
                                                                             { echo date('j-M-Y',strtotime($data['leavesVariables']['leave_from']));} ?>' onchange="no_of_days();"/>
                                <input type="hidden" id="leave_from_alt" name="leave_from_alt" size="30" value='<?php if(isset($data['leavesVariables']))
                                                                             { echo date('Y-m-d',strtotime($data['leavesVariables']['leave_from']));} ?>' class="date_range_from_alt">
                                
                                <label for='leave_to'>Leave To<span>*</span></label>
								<input type='text' id='leave_to' name='leave_to' class='validate[required] date_range_to' value='<?php if(isset($data['leavesVariables']))
                                                                             { echo date('j-M-Y',strtotime($data['leavesVariables']['leave_to']));} ?>' onchange="no_of_days();"/>
                                <input type="hidden" id="leave_to_alt" name="leave_to_alt" size="30" value='<?php if(isset($data['leavesVariables']))
                                                                             { echo date('Y-m-d',strtotime($data['leavesVariables']['leave_to']));} ?>' class="date_range_to_alt">
                                                                               
                                <label for='total_days'>Total Days<span></span></label>
								<input type='text' id='total_days' name='total_days' class='validate[required]' readonly="readonly" value='<?php if(isset($data['leavesVariables']))
                                                                                { echo $data['leavesVariables']['total_days']; } ?>'/>
                                                                                
                                <label for='comment'>Comment<span>*</span></label>
								<textarea name="comment" id="comment" class="validate[required]"><?php if(isset($data["leavesVariables"]))
                                                                                { echo $data["leavesVariables"]["comment"]; } ?></textarea>
                               																				
									<?php if(isset($data['leavesVariables']))
									{
										
									?>
									<input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['leavesVariables']['id'];?>','hrm','save_leaves')" />
									<?php 
									}
									else
									{
								    ?>
								   		<input type='button' value='Insert' class='green_button' onClick="validateFormFields('','hrm','save_leaves')" />
									<?php } ?>
								</div>								
								</div>
								<!-- Main Content -->
								<div id="main-content-right"><!-- All Users -->
									<h2>All leaves (<?php echo sizeof($data['allleaves'])?>)</h2>
									<div class='show_links'>
										<a href="javascript:show_records(2, 'hrm', 'default_leaves')" <?php if(isset($data['show_status'])) if($data['show_status'] == 2) {?>style="color:black;" <? } ?>>All(<?php echo $data['rec_counts']['all']?>)</a><span> | </span>
										<a href="javascript:show_records(1, 'hrm', 'default_leaves')" <? if(isset($data['show_status']))if($data['show_status'] == 1) {?>style="color:black;"<? } ?>>Active(<?php echo $data['rec_counts']['active']?>)</a><span> | </span>
										<a href="javascript:show_records(0, 'hrm', 'default_leaves')" <? if(isset($data['show_status']))if($data['show_status'] == 0) {?>style="color:black;"<? } ?>>Deleted(<?php echo $data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class="body-con"><!-- Users table --> 
									<table cellpadding="0" cellspacing="0" border="0" class="user-table" width="100%" aria-describedby="example_info" style="width: 100%;">
										<thead>
											<tr>
												<th>Sr No</th><th>Employee Name</th><th>Leave Type</th><th>Leave From</th><th>Leave To</th><th>Total Days</th><th>Comment</th><th>Action</th></tr>
										</thead>										
										   <?php											  
											   for($i=0; $i<count($data['allleaves']); $i++)
											   {
												   
												?>
												  	<tr>
														<td><?php echo ($i+1);?></td>
                                                        <td><?php echo $data['allleaves'][$i]['employee_name'];?></td>
                                                        <td><?php echo $data['allleaves'][$i]['leave_type']; ?></td><td><?php echo date('j-M-Y',strtotime($data['allleaves'][$i]['leave_from'])); ?></td><td><?php echo date('j-M-Y',strtotime($data['allleaves'][$i]['leave_to'])); ?></td><td><?php echo $data['allleaves'][$i]['total_days']; ?></td><td><?php echo $data['allleaves'][$i]['comment']; ?></td><td>
														<? if($data['allleaves'][$i]['is_active'] != 0){
															//echo "in if";	
															?> 
															<?php if($data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href="javascript:setValueCallPage('<?php echo $data['allleaves'][$i]['id']?>','hrm','showform_leaves')" class="tiptip-top" title="Edit"><img src="img/icon_edit.png" alt="edit" /></a>
															<?php } if($data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href="javascript:deleteRestoreEntry('<?php echo $data['allleaves'][$i]['id']?>','hrm','delete_leaves','delete')" class="tiptip-top" title="Delete"><img src="img/icon_bad.png" alt="delete"></a>
														
														<? 		}
														}else{
															//if(isset($data['show_status']))
																if($data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href="javascript:deleteRestoreEntry('<?php echo $data['allleaves'][$i]['id']?>','hrm','restore_leaves','restore')" class="tiptip-top" title="Restore"><img src="img/Restore_Value.png" alt="restore"></a>
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
<script>
function no_of_days()
{
	var from = $("#leave_from_alt").val();
	var to = $("#leave_to_alt").val();
	if(from && to)
	{
		var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
		var frm_date = new Date(from);
		var to_date = new Date(to);
		//alert(frm_date);
		//alert(to_date);
		//return false;
		var diffDays = Math.round(Math.abs((frm_date.getTime() - to_date.getTime())/(oneDay)));
		
		$("#total_days").val(diffDays);
		
		
	}
	
}


$(document).ready(function(){
	    $("#leave_from").datepicker({
	        numberOfMonths: 2,
	        onSelect: function(selected) {
	          $("#leave_to").datepicker("option","minDate", selected)
	        }
	    });
	    $("#leave_to").datepicker({
	        numberOfMonths: 2,
	        onSelect: function(selected) {
	           $("#leave_from").datepicker("option","maxDate", selected)
	        }
	    }); 
		
		//convertToDatePicker('#leave_from','#leave_from_alt','','#leave_to');
		//convertToDatePicker('#leave_to','#leave_to_alt','#leave_from');
	});
	
function ready_dates()
{
	$("#leave_from").datepicker({
	        
	        onSelect: function(selected) {
	          $("#leave_to").datepicker("option","minDate", selected)
	        }
	    });
	    $("#leave_to").datepicker({
	        
	        onSelect: function(selected) {
	           $("#leave_from").datepicker("option","maxDate", selected)
	        }
	    }); 
}
</script>                            