<script src="js/DateTimePicker.js"></script>
<?php
	if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
	{
		callheader('index.php');
		exit();
	}
?>
<!-- Content -->

<div id='content' class='clearfix'>
  <div id='main-content' class='twocolm_form'>
    <h2>
      <?php if(isset($data['candidatesVariables'])){ echo 'Edit Candidate';}else { echo 'Add Candidate';}?>
    </h2>
    <div class='body-con'>
      <label for='name'>Name<span>*</span></label>
      <input type='text' id='name' name='name' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['name']; } ?>'/>
      <label for='interview_date_time'>Interview Date Time<span>*</span></label>
      <input type='text' id='interview_date_time' name='interview_date_time' class='validate[required] date_time_picker' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['interview_date_time']; } ?>'/>
      <label for='name'>Reference<span></span></label>
      <input type='text' id='reference' name='reference' class='' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['reference']; } ?>'/>
                                                                            
      <label for='interviewed_by'>Interviewed By<span></span></label>
      <input type='text' id='interviewed_by' name='interviewed_by' class='' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['interviewed_by']; } ?>'/>
      <label for='position'>Position<span>*</span></label>
       <?php
			if(isset($data['candidatesVariables'])){
				createComboBox('position','position_id','position_name',$data['allposition'],true,$data['candidatesVariables']['position']);
			}else{
				createComboBox('position','position_id','position_name',$data['allposition'],true);
			}
		  
		?>
      <label for='experience'>Experience<span>*</span></label>
      <input type='text' id='experience' name='experience' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['experience']; } ?>'/>
      <label for='previous_company'>Previous Company<span></span></label>
      <input type='text' id='previous_company' name='previous_company' class='' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['previous_company']; } ?>'/>
      <label for='phone_number'>Phone Number<span>*</span></label>
      <input type='text' id='phone_number' name='phone_number' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['phone_number']; } ?>'/>
      <label for='current_ctc'>Current Ctc<span>*</span></label>
      <input type='text' id='current_ctc' name='current_ctc' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['current_ctc']; } ?>'/>
      <label for='expected_ctc'>Expected Ctc<span>*</span></label>
      <input type='text' id='expected_ctc' name='expected_ctc' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['expected_ctc']; } ?>'/>
      <label for='notice_period'>Notice Period<span>*</span></label>
      <input type='text' id='notice_period' name='notice_period' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['notice_period']; } ?>'/>
      <label for='email'>Email<span>*</span></label>
      <input type='text' id='email' name='email' class='validate[required]' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['email']; } ?>'/>
      <label for='score'>Score<span></span></label>
      <input type='text' id='score' name='score' class='' value='<?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['score']; } ?>'/>
      <label for='remarks'>Remarks<span></span></label>
      <textarea name="remarks" id="remarks" class="validate[required]"><?php if(isset($data['candidatesVariables']))
																			{ echo $data['candidatesVariables']['remarks']; } ?></textarea>                                                                      
                                                                            
      <label for='status'>Status<span>*</span></label>
     	<?php
			if(isset($data['candidatesVariables'])){
				createComboBox('status','status_id','status_name',$data['allstatus'],true,$data['candidatesVariables']['status']);
			}else{
				createComboBox('status','status_id','status_name',$data['allstatus'],true);
			}
		  
		?>
        <div style="margin-left:48%;">
      <?php if(isset($data['candidatesVariables']))
								{
								?>
      <input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['candidatesVariables']['id'];?>','candidates','save')" />
      <?php 
								}
								else
								{
								?>
      <input type='button' value='Insert' class='green_button' onClick="validateFormFields('','candidates','save')" />      
      <?php } ?>
      <input type="button" value="Cancel" class="green_button" onclick="javascript:callPage('candidates','default')">
      </div>
    </div>
  </div>
</div>
</div>

 <script type="text/javascript">
	$(document).ready( function () {
		$(".date_time_picker").datetimepicker(
			{ dateFormat: 'yy-mm-dd', 
				timeFormat: 'hh:mm:ss',
				
			}
		); 
	});
</script>