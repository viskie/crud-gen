<?php
	if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
	{
		callheader("index.php");
		exit();
	}
?>
<div id='content' class='clearfix'>
    <!-- Add user Box -->
    <?php if($data['arr_permission'][0]['add_perm'] == 1 || (isset($data['hrmVariables']) && $data['arr_permission'][0]['edit_perm'] == 1)) { ?>
    <h3><?php if(isset($data['hrmVariables'])){ echo 'Edit Employee';}else { echo 'Add Employee';}?></h3>
  <div class='body-con'>
    	<ul class="align-list">
            <li>
                 <label for="employee_name">Employee Name <span>*</span></label>
                 <input type="text" id="employee_name" name="employee_name" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['employee_name']; } ?>">
                 
                 <label for="joining_date">Date Of Joining <span>*</span></label>
                 <input type="text" id="joining_date" name="joining_date" value="" class="date_range">
                 <input type="hidden" id="joining_date_alt" name="joining_date_alt" size="30" value="" class="date_range_alt">
            </li>
            <li>
            	<label for="photo_img">Select Photo</label>
                <input type="file" id="photo_img" name="photo_img" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['photo_img']; } ?>" />
             </li>
             <li>   
                <label for="sign_img">Select CV</label>
                <input type="file" id="sign_img" name="sign_img" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['sign_img']; } ?>" />
            </li>
            <li>
                <label for="designation">Designation <span>*</span></label>
        		<input type="text" id="designation" name="designation" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['designation']; } ?>">
            
                <label for="department">Department <span></span></label>
        		<input type="text" id="department" name="department" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['department']; } ?>">
            </li>
             <li>
                <label for="per_address">Permanent Address <span>*</span></label>
        		<textarea id="per_address" name="per_address"><?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['per_address']; } ?></textarea>
            
                <label for="cur_address">Current Address</label>
        		<textarea id="cur_address" name="cur_address"><?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['cur_address']; } ?></textarea>
            </li>
            <li>
                <label for="personal_phone1">Personal Number #1<span>*</span></label>
        		<input type="text" id="personal_phone1" name="personal_phone1" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['personal_phone1']; } ?>">
                
                <label for="personal_phone2">Personal Number #2</label>
        		<input type="text" id="personal_phone2" name="personal_phone2" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['personal_phone2']; } ?>">
           
            </li>
             <li>
                <label for="parent_phone">Parents/Gaurdian Number</label>
        		<input type="text" id="parent_phone" name="parent_phone" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['parent_phone']; } ?>">
                
                <label for="landline">Landline</label>
        		<input type="text" id="landline" name="landline" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['landline']; } ?>">
           
            </li>
            <li>
            	<label for="personal_email">Personal Email <span>*</span></label>
        		<input type="text" id="personal_email" name="personal_email" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['personal_email']; } ?>">
            
            	<label for="company_email">Company Email <span></span></label>
        		<input type="text" id="company_email" name="company_email" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['company_email']; } ?>">
            </li>
            <li>
               	<label for="date_of_birth">Date Of Birth <span></span></label>
        		<input type="text" id="date_of_birth" name="date_of_birth" class="date_range">
        		<input type="hidden" id="dob_alt" name="dob_alt" size="30" class="date_range_alt" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['date_of_birth']; } ?>">
            </li>
           	<li>
           		<label for="emp_status">Status <span>*</span></label>
               	<select name="employee_status" id="employee_status" style="opacity: 0;">
               	<option value="0" <?php if(isset($data['hrmVariables']) && $data['hrmVariables']['employee_status']==0){ echo 'selected="selected"'; } ?>>Past Employee</option>
               	<option value="1" <?php if(isset($data['hrmVariables']) && $data['hrmVariables']['employee_status']==1){ echo 'selected="selected"'; } ?>>Current Employee</option>
            	</select>
          	</li>
        </ul>
    <div style="text-align: center;font-size: 14px;font-weight: bold;margin-top: 4%;">	
            <span>List Of Documents Required</span>
      </div>
    <div align="center" style="width:60%;margin:auto">
      <div align="center">
        <table width="450" height="83">
          <tr>
            <td width="167">Personal Documents</td>
            <td width="280" height="35">
              <div align="left">
                <ul>
                  <li>
                    <input type="checkbox" name="identity_proof" id="identity_proof" class="chk_docs" <?php if(isset($data['hrmVariables']['identity_proof']) && $data['hrmVariables']['identity_proof']==1){ echo 'checked="checked"'; } ?> />
                    Identitt Proof                  
                    <input type="checkbox" id="input" name="input" class="na"/>
                    NA
                  </li>
                  <li>
                    <input type="checkbox" name="address_proof"  id="address_proof" <?php if(isset($data['hrmVariables']['address_proof']) && $data['hrmVariables']['address_proof']==1){ echo 'checked="checked"'; } ?>/>
                    Adress Proof                                    
                     <input type="checkbox" id="input2" name="input2" class="na"/>
NA </li>
                  </ul>
              </div>
              </td>
          </tr>
          <tr>
            <td>Educational Qualification</td>
            <td>
              <div align="left">
                <ul>
                  <li>
                    <input type="checkbox" name="ssc"  id="ssc" <?php if(isset($data['hrmVariables']['ssc']) && $data['hrmVariables']['ssc']==1){ echo 'checked="checked"'; } ?>/>
                    S.S.C                                    
                     <input type="checkbox" id="input3" name="input3" class="na"/>
NA </li>
                  <li>
                    <input type="checkbox" name="hsc"  id="hsc" <?php if(isset($data['hrmVariables']['hsc']) && $data['hrmVariables']['hsc']==1){ echo 'checked="checked"'; } ?>/>
                  H.S.C
                   <input type="checkbox" id="input4" name="input4" class="na"/>
NA </li>
                  <li>
                    <input type="checkbox" name="graduation"  id="graduation" <?php if(isset($data['hrmVariables']['graduation']) && $data['hrmVariables']['graduation']==1){ echo 'checked="checked"'; } ?>/>
                  Graduation
                   <input type="checkbox" id="input5" name="input5" class="na"/>
NA </li>
                  <li>
                    <input type="checkbox" name="post_graduation"  id="post_graduation" <?php if(isset($data['hrmVariables']['post_graduation']) && $data['hrmVariables']['post_graduation']==1){ echo 'checked="checked"'; } ?>/>
                  Post Graduation
                   <input type="checkbox" id="input6" name="input6" class="na"/>
NA </li>
                  <li>other 
                    <input type="text" name="other_doc" id="other_doc" value="<?php if(isset($data['hrmVariables']['other_doc'])){ echo $data['hrmVariables']['other_doc']; } ?>" />
                  </li>
                </ul>
              </div>
              </td>
          </tr>
          <tr>
            <td>Official Documents</td>
            <td>
              <div align="left">
                <ul>
                  <li>
                    <input type="checkbox" name="salary_slip"  id="salary_slip" <?php if(isset($data['hrmVariables']['salary_slip']) && $data['hrmVariables']['salary_slip']==1){ echo 'checked="checked"'; } ?>/>
                    Last three moths salary slips of previos company                                    
                     <input type="checkbox" id="input7" name="input7" class="na"/>
NA </li>
                  <li>
                    <input type="checkbox" name="relieving_letter"  id="relieving_letter" <?php if(isset($data['hrmVariables']['relieving_letter']) && $data['hrmVariables']['relieving_letter']==1){ echo 'checked="checked"'; } ?>/>
                    Relieving letter
                     <input type="checkbox" id="input8" name="input8" class="na"/>
NA </li>
                  <li>
                    <input type="checkbox" name="appoinment_letter"  id="appoinment_letter" <?php if(isset($data['hrmVariables']['appoinment_letter']) && $data['hrmVariables']['appoinment_letter']==1){ echo 'checked="checked"'; } ?> />
                    Appointment letter of previous company
                    <input type="checkbox" id="input9" name="input9" class="na"/>
NA </li>
                </ul>
              </div>
              </td>
          </tr>
        </table>
        
        <?php 
		if(isset($data['hrmVariables']))
        {
        ?>
        <input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['hrmVariables']['id']; ?>','hrm','save')" />
        <?php 
        }
        else
        {
        ?>
        <input type='button' value='Insert' class='green_button' onClick="validateFormFields('','hrm','save')" />
        <?php } ?>
        <input type="button" value="Cancel" class="green_button" onclick="javascript:callPage('hrm','default')">
      </div>
    </div>
  </div>
    <?php 
   } ?> 
</div>

<script>
$(".na").click(function(){
	$(this).closest("li").find("div span .chk_docs").attr('disabled',true);	
	//console.log($(this).closest("li").find("div span .chk_docs"));
});
</script>