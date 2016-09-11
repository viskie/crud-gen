<?php
					if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'>
						 <div id='main-content' class='twocolm_form'><h2><?php if(isset($data['leave_typeVariables'])){ echo 'Edit Leave Type';}else { echo 'Add Leave Type';}?></h2><div class='body-con'><label for='leave_type'>Leave Type<span>*</span></label>
<input type='text' id='leave_type' name='leave_type' class='validate[required]' value='<?php if(isset($data['leave_typeVariables']))
																			{ echo $data['leave_typeVariables']['leave_type']; } ?>'/><?php if(isset($data['leave_typeVariables']))
								{
								?>
								<input type='button' value='Submit' class='green_button'  onclick="javascript:validateFormFields('<?php echo $data['leave_typeVariables']['id'];?>','settings','save')" />
								<?php 
								}
								else
								{
								?>
									<input type='button' value='Insert' class='green_button' onClick="validateFormFields('','settings','save')" />
								<?php } ?>
							</div></div></div></div>