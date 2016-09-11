<?php
	if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
	{
		callheader("index.php");
		exit();
	}
?>
<style>
ul.tabs {
margin: 0;
padding: 0;
float: left;
list-style: none;
height: 32px; /*--Set height of tabs--*/
border-bottom: 1px solid #999;
border-left: 1px solid #999;
width: 100%;
}

ul.tabs li {
float: left;
margin: 0;
padding: 0;
height: 31px; /*--Subtract 1px from the height of the unordered list--*/
line-height: 31px; /*--Vertically aligns the text within the tab--*/
border: 1px solid #999;
border-left: none;
margin-bottom: -1px; /*--Pull the list item down 1px--*/
overflow: hidden;
position: relative;
background: #e0e0e0;
}

ul.tabs li a {
text-decoration: none;
color: #000;
display: block;
font-size: 1.2em;
padding: 0 20px;
border: 1px solid #fff; /*--Gives the bevel look with a 1px white border inside the list item--*/
outline: none;
}

ul.tabs li a:hover {
background: #ccc;
}

html ul.tabs li.active, html ul.tabs li.active a:hover  { /*--Makes sure that the active tab does not listen to the hover properties--*/
background: #fff;
border-bottom: 1px solid #fff; /*--Makes the active tab look like it's connected with its content--*/
}

.tab_container {
border: 1px solid #999;
border-top: none;
overflow: hidden;
clear: both;
float: left; width: 100%;
background: #fff;
}

.tab_content {
padding: 20px;
font-size: 1.2em;
color:#333;
}
.doc_ul li
{
	list-style:none;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	//Default Action
	$(".tab_content").hide(); //Hide all content
	//$("ul.tabs li:first").addClass("active").show();
	
	<?php
	if(isset($data['save_emp']) && ($data['save_emp'] == 1))
	{
		?>		
		$("ul.tabs li:nth-child(2)").addClass("active").show(); 
		//$("ul.tabs li:nth-child(1)").removeClass("active");
		$("#tab2").show();
		<?php
	}
	elseif(isset($data['save_emp']) && ($data['save_emp'] == 2))
	{
		?>
		$("ul.tabs li:nth-child(3)").addClass("active").show(); 		
		$("#tab3").show();
		<?php
	}
	else
	{
	?>
	//Activate first tab 
	$("ul.tabs li:first").addClass("active").show();
	$(".tab_content:first").show(); //Show first tab content 
	<?php } ?>
	
	//On Click Event 
	$("ul.tabs li").click(function() 
	{	
		$("ul.tabs li").removeClass("active"); //Remove any "active" class 
		$(this).addClass("active"); 
		//Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content 
		
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content 
		$(activeTab).fadeIn(); //Fade in the active content 
		return false; 
	}); 
}); 

</script>

<div id='content' class='clearfix'>
    <!-- Add user Box -->
    <?php if($data['arr_permission'][0]['add_perm'] == 1 || (isset($data['hrmVariables']) && $data['arr_permission'][0]['edit_perm'] == 1)) { ?>
    <h3><?php if(isset($data['hrmVariables'])){ echo 'Edit Employee';}else { echo 'Add Employee';}?></h3>
  <div class='body-con' style="min-height:540px;">
  		<ul class="tabs">
            <li><a href="#tab1">Personal Details</a></li>
            <li><a href="#tab2">Document Details</a></li>
            <li><a href="#tab3">Leaves</a></li>
        </ul>
  		<div class="tab_container">
            <div id="tab1" class="tab_content">
               <ul class="align-list">        
                    <li>
                         <label for="employee_name">Employee Name <span>*</span></label>
                         <input type="text" id="employee_name" name="employee_name" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['employee_name']; } ?>" class="validate[required]">
                         
                         <label for="joining_date">Date Of Joining <span>*</span></label>
                         <input type="text" id="joining_date" name="joining_date" value="<?php if(isset($data['hrmVariables'])){ echo formatDate($data['hrmVariables']['joining_date']); } ?>" class="date_range_to validate[required]" >
                         <input type="hidden" id="joining_date_alt" name="joining_date_alt" size="30" class="date_range_to_alt" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['joining_date']; } ?>" class="date_range_alt">
                    </li>
                    <li>
                        <label for="photo_img">Select Photo</label>
                        <input type="file" id="photo_img" name="photo_img" value="<?php if(isset($data['hrmVariables']) && isset($data['hrmVariables']['photo_img'])){ echo $data['hrmVariables']['photo_img']; } ?>" />
                     </li>
                     <li>   
                        <label for="sign_img">Select CV</label>
                        <input type="file" id="sign_img" name="sign_img" value="<?php if(isset($data['hrmVariables']) && isset($data['hrmVariables']['sign_img'])){ echo $data['hrmVariables']['sign_img']; } ?>" />
                    </li>
                    <li>
                        <label for="designation">Designation <span>*</span></label>
                        <input type="text" id="designation" name="designation" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['designation']; } ?>" class="validate[required]">
                    
                        <label for="department">Department <span></span></label>
                        <input type="text" id="department" name="department" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['department']; } ?>">
                    </li>
                     <li>
                        <label for="per_address">Permanent Address <span>*</span></label>
                        <textarea id="per_address" name="per_address" class="validate[required]"><?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['per_address']; } ?></textarea>
                    
                        <label for="cur_address">Current Address</label>
                        <textarea id="cur_address" name="cur_address"><?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['cur_address']; } ?></textarea>
                    </li>
                    <li>
                        <label for="personal_phone1">Personal Number #1<span>*</span></label>
                        <input type="text" id="personal_phone1" name="personal_phone1" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['personal_phone1']; } ?>" class="validate[required,custom[integer]]">
                        
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
                        <input type="text" id="personal_email" name="personal_email" class="validate[required,custom[email]]" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['personal_email']; } ?>">
                    
                        <label for="company_email">Company Email <span></span></label>
                        <input type="text" id="company_email" name="company_email" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['company_email']; } ?>">
                    </li>
                    <li>
                    	<label for="alternate_email">Alternate Email <span></span></label>
                        <input type="text" id="alternate_email" name="alternate_email" class="validate[custom[email]]" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['alternate_email']; } ?>">
                    
                    
                        <label for="date_of_birth">Date Of Birth <span></span></label>
                        <input type="text" id="date_of_birth" name="date_of_birth" class="date_range_from" value="<?php if(isset($data['hrmVariables'])){ echo formatDate($data['hrmVariables']['date_of_birth']); } ?>">
                        <input type="hidden" id="dob_alt" name="dob_alt" size="30" class="date_range_from_alt" value="<?php if(isset($data['hrmVariables'])){ echo $data['hrmVariables']['date_of_birth']; } ?>">
                    </li>
                    <li>
                        <label for="emp_status">Status <span>*</span></label>
                        <select name="employee_status" id="employee_status" class="validate[required]">
                        <option value="0" <?php if(isset($data['hrmVariables']) && $data['hrmVariables']['employee_status']==0){ echo 'selected="selected"'; } ?>>Past Employee</option>
                        <option value="1" <?php if(isset($data['hrmVariables']) && $data['hrmVariables']['employee_status']==1){ echo 'selected="selected"'; } ?>>Current Employee</option>
                        </select>
                    </li>
                    <li style=" text-align:center">
                    	<?php 
						if(isset($data['hrmVariables']))
						{
						?>
						<input type='button' value='Submit' class='green_button'  onclick="javascript:save_employee(1,'<?php echo $data['hrmVariables']['id']; ?>','hrm','save')" />
						<?php 
						}
						else
						{
						?>
						<input type='button' value='Insert' class='green_button' onClick="save_employee(1,'','hrm','save')" />
						<?php } ?>
						<input type="button" value="Cancel" class="green_button" onclick="javascript:save_employee(1,'hrm','default')">
                    </li>
                </ul>
            </div>
            <div id="tab2" class="tab_content">
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
                                <ul class="doc_ul">
                                  <li>
                                    <input type="checkbox" name="identity_proof" id="identity_proof" value="1" class="chk_docs" <?php if(isset($data['hrmVariables']['identity_proof']) && $data['hrmVariables']['identity_proof']==1){ echo 'checked="checked"'; } ?> />
                                    Identity Proof                  
                                    <span style="text-align:ri">
                                    <input type="checkbox" id="ip_na" name="identity_proof" class="na" value="2" <?php if(isset($data['hrmVariables']['identity_proof']) && $data['hrmVariables']['identity_proof']==2){ echo 'checked="checked"'; } ?>/>
                                  NA</span> </li>
                                  <li>
                                    <input type="checkbox" name="address_proof"  id="address_proof"  value="1" class="chk_docs"<?php if(isset($data['hrmVariables']['address_proof']) && $data['hrmVariables']['address_proof']==1){ echo 'checked="checked"'; } ?>/>
                                    Adress Proof                                    
                                     <input type="checkbox" id="ap_na" name="address_proof" class="na" value="2" <?php if(isset($data['hrmVariables']['address_proof']) && $data['hrmVariables']['address_proof']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                  </ul>
                              </div>
                              </td>
                          </tr>
                          <tr>
                            <td>Educational Qualification</td>
                            <td>
                              <div align="left">
                                <ul class="doc_ul">
                                  <li>
                                    <input type="checkbox" name="ssc"  id="ssc" class="chk_docs" value="1" <?php if(isset($data['hrmVariables']['ssc']) && $data['hrmVariables']['ssc']==1){ echo 'checked="checked"'; } ?>/>
                                    S.S.C                                    
                                     <input type="checkbox" id="ssc_na" name="ssc" class="na" value="2" <?php if(isset($data['hrmVariables']['ssc']) && $data['hrmVariables']['ssc']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                  <li>
                                    <input type="checkbox" name="hsc"  id="hsc" class="chk_docs" value="1" <?php if(isset($data['hrmVariables']['hsc']) && $data['hrmVariables']['hsc']==1){ echo 'checked="checked"'; } ?>/>
                                  H.S.C
                                   <input type="checkbox" id="hsc_na" name="hsc" class="na" value="2" <?php if(isset($data['hrmVariables']['hsc']) && $data['hrmVariables']['hsc']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                  <li>
                                    <input type="checkbox" name="graduation"  id="graduation" class="chk_docs"  value="1" <?php if(isset($data['hrmVariables']['graduation']) && $data['hrmVariables']['graduation']==1){ echo 'checked="checked"'; } ?>/>
                                  Graduation
                                   <input type="checkbox" id="g_na" name="graduation" class="na" value="2" <?php if(isset($data['hrmVariables']['graduation']) && $data['hrmVariables']['graduation']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                  <li>
                                    <input type="checkbox" name="post_graduation"  id="post_graduation" class="chk_docs" value="1" <?php if(isset($data['hrmVariables']['post_graduation']) && $data['hrmVariables']['post_graduation']==1){ echo 'checked="checked"'; } ?>/>
                                  Post Graduation
                                   <input type="checkbox" id="pg_na" name="post_graduation" class="na" value="2" <?php if(isset($data['hrmVariables']['post_graduation']) && $data['hrmVariables']['post_graduation']==2){ echo 'checked="checked"'; } ?>/>
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
                                <ul class="doc_ul">
                                  <li>
                                    <input type="checkbox" name="salary_slip"  id="salary_slip" class="chk_docs" value="1" <?php if(isset($data['hrmVariables']['salary_slip']) && $data['hrmVariables']['salary_slip']==1){ echo 'checked="checked"'; } ?>/>
                                    Last three moths salary slips of previos company                                    
                                     <input type="checkbox" id="ss_na" name="salary_slip" class="na" value="2" <?php if(isset($data['hrmVariables']['salary_slip']) && $data['hrmVariables']['salary_slip']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                  <li>
                                    <input type="checkbox" name="relieving_letter"  id="relieving_letter" class="chk_docs" value="1" <?php if(isset($data['hrmVariables']['relieving_letter']) && $data['hrmVariables']['relieving_letter']==1){ echo 'checked="checked"'; } ?>/>
                                    Relieving letter
                                     <input type="checkbox" id="rl_na" name="relieving_letter" class="na" value="2" <?php if(isset($data['hrmVariables']['relieving_letter']) && $data['hrmVariables']['relieving_letter']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                  <li>
                                    <input type="checkbox" name="appoinment_letter"  id="appoinment_letter" class="chk_docs" value="1" <?php if(isset($data['hrmVariables']['appoinment_letter']) && $data['hrmVariables']['appoinment_letter']==1){ echo 'checked="checked"'; } ?> />
                                    Appointment letter od previous company
                                    <input type="checkbox" id="al_na" name="appoinment_letter" class="na" value="2" <?php if(isset($data['hrmVariables']['appoinment_letter']) && $data['hrmVariables']['appoinment_letter']==2){ echo 'checked="checked"'; } ?>/>
                NA </li>
                                </ul>
                              </div>
                              </td>
                          </tr>
                           <tr>
                            <td colspan="2">
                                <?php 
                                if(isset($data['hrmVariables']))
                                {
                                ?>
                                <input type='button' value='Submit' class='green_button'  onclick="javascript:save_employee(2,'<?php echo $data['hrmVariables']['id']; ?>','hrm','save')" />
                                <?php 
                                }
                                else
                                {
                                ?>
                                <input type='button' value='Insert' class='green_button' onClick="save_employee(2,'','hrm','save')" />
                                <?php } ?>
                                <input type="button" value="Cancel" class="green_button" onclick="javascript:save_employee(2,'hrm','default')">
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
            </div>
            <div id="tab3" class="tab_content">
                 <ul class="align-list"> 
                    <?php
                    for($i=0;$i<count($data['leave_type']);$i++)
                    { 
                    ?>       
                        <li>
                            <label for="leaves">Total <?php echo ucfirst($data['leave_type'][$i]['leave_type']);?> leaves <span>*</span></label>
                            <input type="text" id="total_<?php echo $data['leave_type'][$i]['id']; ?>" name="total_<?php echo $data['leave_type'][$i]['id']; ?>" value="<?php if(isset($data['total_leaves'])){ echo $data['total_leaves'][$data['leave_type'][$i]['id']]; } ?>">                    
                        </li>
                     <?php
                    }
                    ?>
                    <li style="margin-left:200px;">
                    	<input type="hidden" name="save_emp" id="save_emp" value="" />
                    	<?php 
						if(isset($data['hrmVariables']))
						{
						?>
						<input type='button' value='Submit' class='green_button'  onclick="javascript:save_employee(3,'<?php echo $data['hrmVariables']['id']; ?>','hrm','save')" />
						<?php 
						}
						else
						{
						?>
						<input type='button' value='Insert' class='green_button' onClick="save_employee(3,'','hrm','save')" />
						<?php } ?>
						<input type="button" value="Cancel" class="green_button" onclick="javascript:callPage('hrm','default')">
                    </li>
                  </ul>                               
    		</div>  
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
function save_employee(set_val,id,page,func)
{
	$("#save_emp").val(set_val);
	$('#mainForm').validationEngine();
	$("#edit_id").val(id);
	validation_callPage(page,func);	
} 

</script>