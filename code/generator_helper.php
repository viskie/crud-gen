<?php 
include_once('library/config/Config.php'); 
include_once('library/commonManager.php'); 
include_once('library/applicationManager.php'); 
$applnObject = new applicationManager();
$app_title = $applnObject->getAppTitle();

function get_controller()
{
	$data = '<?php
			switch($function)
			{
				case "default":
				break;
				
				case "showform":
				break;
				
				case "save":
				break;
				
				case "delete":
				break;
				
				case "restore":
				break;
			}
			?>';
	return $data;	
}
function get_model($model_name,$table_name)
{
	$data = '<?php
			if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false)
			{
				callheader("index.php");
				exit();
			}
			
			class '.ucfirst($model_name).'Manager extends CommonManager
			{
				public $tb1_name;
				public $tb1_fields; 
				function __construct()
				{
					$this->tb1_name = "'.$table_name.'";
					$this->tb1_fields = $this->getTableColms($this->tb1_name);
					$primary_key = $this->getPrimaryKey($this->tb1_name);					
					$edit_except = array($primary_key,"added_by","added_date","modified_by","modified_date","is_active");
					$this->edit_fields = getFields($this->tb1_fields,$edit_except); 
				}
			}?>';
	return $data;	
}
function get_crud_controller($post)
{
	$contrl_data = "<?php ";
	$contrl_data .= "include_once('library/".$post['txtmodel']."Manager.php');
					 $".$post['txtmodel']."Object= new ".ucfirst($post['txtmodel'])."Manager();\r\n";
	if(isset($post['sup_model']) && count($post['sup_model']) > 0)
	{
		$sup_model = array_diff($post['sup_model'],array($post['txtmodel']));		
		foreach($sup_model as $k => $v)
		{	
		$contrl_data .= "include_once('library/".$v."Manager.php');
						 \$".$v."Object= new ".ucfirst($v)."Manager();\r\n";
		}
	}
	$contrl_data .= "switch(\$function){\r\n";
	// default case
	$contrl_data .= "case 'default':
						\$data['show_status']=isset(\$_POST['show_status'])?\$_POST['show_status']:1;		
						\$data['all".$post['txtmodel']."'] = \$".$post['txtmodel']."Object->getAll(\$".$post['txtmodel']."Object->tb1_name,'*','',\$data['show_status']);		
						\$data['rec_counts'] = \$".$post['txtmodel']."Object->getRecordCounts(\$".$post['txtmodel']."Object->tb1_name);							
						\$page='manage_".$post['txtmodel'].".php';						
					break;\r\n";
	// add and edit case
	$contrl_data .= "case 'showform':
						if(\$_POST['edit_id']!==''){  
						   \$primary_key = \$".$post['txtmodel']."Object->getPrimaryKey(\$".$post['txtmodel']."Object->tb1_name);        
						   \$data['".$post['txtmodel']."Variables']=\$".$post['txtmodel']."Object->getRow(\$".$post['txtmodel']."Object->tb1_name,'*',\$primary_key.'= \"'.\$_POST['edit_id'].'\"');
						}";
	if($_POST['coloum'] == 2)
	{ 
		$contrl_data .= "\$data['show_status']=isset(\$_POST['show_status'])?\$_POST['show_status']:1;		
						\$data['all".$post['txtmodel']."'] = \$".$post['txtmodel']."Object->getAll(\$".$post['txtmodel']."Object->tb1_name,'*','',\$data['show_status']);		
						\$data['rec_counts'] = \$".$post['txtmodel']."Object->getRecordCounts(\$".$post['txtmodel']."Object->tb1_name);									
						\$page='manage_".$post['txtmodel'].".php';";
	}
	elseif($_POST['coloum'] == 1)
	{	
		$contrl_data .= "\$page='add_edit_".$post['txtmodel'].".php';";
	}
	$contrl_data .= "break;\r\n";
	// save case
	$contrl_data .= "case 'save':
						\$".$post['txtmodel']."Variables =  \$".$post['txtmodel']."Object->getVariables(\$_POST);
						\$primary_key = \$".$post['txtmodel']."Object->getPrimaryKey(\$".$post['txtmodel']."Object->tb1_name);        
						\$".$post['txtmodel']."Variables[\$primary_key] = \$_POST['edit_id']; 						
						if(\$_POST['edit_id']!=='')
						{
							$".$post['txtmodel']."Variables['modified_by']=\$_SESSION['user_id'];
							$".$post['txtmodel']."Variables['modified_date']=date('Y-m-d H:i:s');							
							$".$post['txtmodel']."Object->update($".$post['txtmodel']."Object->tb1_name,$".$post['txtmodel']."Variables,\$primary_key);
							\$notificationArray['type'] = 'Success';
							\$notificationArray['message'] =  showmsg('".$post['txtmodel']."','update');
						}
						else
						{							
							$".$post['txtmodel']."Variables['added_by']=\$_SESSION['user_id'];							
							$".$post['txtmodel']."Variables['is_active']=1;
							\$primary_key=$".$post['txtmodel']."Object->insert(\$".$post['txtmodel']."Object->tb1_name,\$".$post['txtmodel']."Variables);
							\$notificationArray['type'] = 'Success';
							\$notificationArray['message'] = showmsg('".$post['txtmodel']."','add');
						}
						\$data['show_status']=isset(\$_POST['show_status'])?\$_POST['show_status']:1;		
						\$data['all".$post['txtmodel']."'] = \$".$post['txtmodel']."Object->getAll(\$".$post['txtmodel']."Object->tb1_name,'*','',\$data['show_status']);		
						\$data['rec_counts'] = \$".$post['txtmodel']."Object->getRecordCounts(\$".$post['txtmodel']."Object->tb1_name);									
						\$page='manage_".$post['txtmodel'].".php';						
					break;\r\n";
	// delete case
	$contrl_data .= "case 'delete':
						\$primary_key = \$".$post['txtmodel']."Object->getPrimaryKey(\$".$post['txtmodel']."Object->tb1_name); 
						\$".$post['txtmodel']."Object->delete(\$".$post['txtmodel']."Object->tb1_name,\$primary_key,\$_POST['edit_id']);
						\$notificationArray['type'] = 'Success';
						\$notificationArray['message'] = showmsg('".$post['txtmodel']."','delete');
						\$data['show_status']=isset(\$_POST['show_status'])?\$_POST['show_status']:1;		
						\$data['all".$post['txtmodel']."'] = \$".$post['txtmodel']."Object->getAll(\$".$post['txtmodel']."Object->tb1_name,'*','',\$data['show_status']);		
						\$data['rec_counts'] = \$".$post['txtmodel']."Object->getRecordCounts(\$".$post['txtmodel']."Object->tb1_name);								
						\$page='manage_".$post['txtmodel'].".php';						
					break;\r\n";
	// restore case
	$contrl_data .= "case 'restore':
						\$primary_key = \$".$post['txtmodel']."Object->getPrimaryKey(\$".$post['txtmodel']."Object->tb1_name); 
						\$".$post['txtmodel']."Object->restore(\$".$post['txtmodel']."Object->tb1_name,\$primary_key,\$_POST['edit_id']);
						\$notificationArray['type'] = 'Success';
						\$notificationArray['message'] = showmsg('".$post['txtmodel']."','restore');
						\$data['show_status']=isset(\$_POST['show_status'])?\$_POST['show_status']:1;		
						\$data['all".$post['txtmodel']."'] = \$".$post['txtmodel']."Object->getAll(\$".$post['txtmodel']."Object->tb1_name,'*','',\$data['show_status']);		
						\$data['rec_counts'] = \$".$post['txtmodel']."Object->getRecordCounts(\$".$post['txtmodel']."Object->tb1_name);								
						\$page='manage_".$post['txtmodel'].".php';						
					break;\r\n";					
	$contrl_data .= "}?>";	
	return $contrl_data;
}
function get_crud_model($post)
{
	$model_file = DOC_ROOT.'library/'.strtolower($post['txtmodel']).'Manager.php';
	$handle = fopen($model_file, 'r'); 
	$model_data = fread($handle, filesize($model_file));	
	fclose($handle);
	$model_data = trim($model_data,"}?>");
	$pos = strpos($model_data,'getVariables');
	if($pos === false)
	{ 
	/* \$primary_key = \$this->getPrimaryKey(\$this->tb1_name); 
	\$except = array(\$primary_key,'added_by','added_date','modified_by','modified_date','is_active');*/
	$model_data .= "function getVariables(\$arr_post)
					{						
						\$fields = \$this->edit_fields;
						\$arr_variable = array();
						foreach(\$fields as \$k=>\$v)
						{	
							if(array_key_exists(\$v,\$arr_post))
								\$arr_variable[\$v] = \$arr_post[\$v];
						}
						return \$arr_variable;		
					}\n";
	}
	$model_data .= "}?>";
	return $model_data;		
}
function get_crud_view($post)
{
	$view_data = "<?php
					if (strpos(\$_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'>";
			if($_POST['coloum'] == 2)
			{
			   $view_data .="<!-- Sidebar -->
							 <div id='side-content-left'>   
							 <?php  if(array_key_exists('type',\$notificationArray)) { if(\$notificationArray['type'] == 'Success') { ?>
								<div class='msg-ok enable-close' style='cursor: pointer;'><?php echo \$notificationArray['message']; ?></div>  
							 <?php }  else  if(\$notificationArray['type'] == 'Failed') { ?>
							  <div class='msg-error enable-close' style='cursor: pointer;'><?php echo \$notificationArray['message']; ?></div>
							 <?php   } } ?>          
								<div id='main-content'>
								<!-- Add user Box -->							
								<h3><? if(isset(\$data['".$post['txtmodel']."Variables'])){ echo 'Edit ".ucwords($post['txtmodel'])."';}else { echo 'Add ".ucwords($post['txtmodel'])."';}?></h3>
								<div class='body-con'>";
						for($i=0;$i<count($_POST['field']); $i++)
						{
							$lable=ucwords(str_replace("_"," ",$_POST['field'][$i]));
							$class = "";
							$mand_sign = '';
							if(in_array($_POST['field'][$i],$_POST['mandatory']))
							{
								$class="validate[required]";
								$mand_sign ="*";
							}
							$view_data .="<label for='".$_POST['field'][$i]."'>".$lable."<span>".$mand_sign."</span></label>\r\n";
							if($_POST['type'][$i] == 'text')
							{
								$view_data .="<input type='text' id='".$_POST['field'][$i]."' name='".$_POST['field'][$i]."' class='".$class."' value='<?php if(isset(\$data['".$post['txtmodel']."Variables']))
                                                                                { echo \$data['".$post['txtmodel']."Variables']['".$_POST['field'][$i]."']; } ?>'/>";
							}
							elseif($_POST['type'][$i] == 'textarea')
							{
								$view_data .='<textarea name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" class="'.$class.'"><?php if(isset($data["'.$post['txtmodel'].'Variables"]))
                                                                                { echo $data["'.$post['txtmodel'].'Variables"]["'.$_POST['field'][$i].'"]; } ?></textarea>';
							}
							elseif($_POST['type'][$i] == 'dropdown')
							{								
								$view_data .='<select name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" class="'.$class.'">
											<option value="">Please Select</option>
										  </select>';
							}
							elseif($_POST['type'][$i] == 'checkbox')
							{
								$view_data .='<input type="checkbox" name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" class="'.$class.'"/>';
							}
							elseif($_POST['type'][$i] == 'radio')
							{
								$view_data .='<input type="radio" name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" value="1" class="'.$class.'" />Yes
                                			  <input type="radio" name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" value="0" class="'.$class.'" />No';
							}
						}
					$view_data .= " <div style='margin-left:48%;'><?php if(isset(\$data['".$post['txtmodel']."Variables']))
									{
									?>
									<input type='button' value='Submit' class='green_button'  onclick=\"javascript:validateFormFields('<?php echo \$data['".$post['txtmodel']."Variables']['id'];?>','test','save')\" />
									<?php 
									}
									else
									{
								    ?>
								   	<input type='button' value='Insert' class='green_button' onClick=\"validateFormFields('','".$post['txtmodel']."','save')\" />
									<?php } ?>
									<input type='button' value='Cancel' class='green_button' onclick='javascript:callPage(\'".$post['txtmodel']."\',\'default\')'>
								</div></div>								
								</div>
								<!-- Main Content -->
								<div id=\"main-content-right\">";
				}  
				if($_POST['coloum'] == 1)
				{
					$view_data .="<div id='main-content'>";
				}
					$view_data .="<!-- All Users -->
									<h2>All ".$post['txtmodel']." (<?php echo sizeof(\$data['all".$post['txtmodel']."'])?>)</h2>
									<div class='show_links'>
										<a href=\"javascript:show_records(2, '".$post['txtmodel']."', 'default')\" <?php if(isset(\$_REQUEST['show_status'])) if(\$_REQUEST['show_status'] == 2) {?>style=\"color:black;\" <? } ?>>All(<?php echo \$data['rec_counts']['all']?>)</a><span> | </span>
										<a href=\"javascript:show_records(1, '".$post['txtmodel']."', 'default')\" <? if(isset(\$_REQUEST['show_status']))if(\$_REQUEST['show_status'] == 1) {?>style=\"color:black;\"<? } ?>>Active(<?php echo \$data['rec_counts']['active']?>)</a><span> | </span>
										<a href=\"javascript:show_records(0, '".$post['txtmodel']."', 'default')\" <? if(isset(\$_REQUEST['show_status']))if(\$_REQUEST['show_status'] == 0) {?>style=\"color:black;\"<? } ?>>Deleted(<?php echo \$data['rec_counts']['deleted']?>)</a>										
									</div>									
									<div class=\"body-con\">";
					if($_POST['coloum'] == 1)
					{ 
						$view_data .= "<div class='for_links'><a href='javascript:setValueCallPage(\"\",\"".$post['txtmodel']."\",\"showform\");'>Add ".ucwords($post['txtmodel'])."</a></div>";
					}
					$view_data .= "<!-- Users table --> 
									<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"user-table\" width=\"100%\" aria-describedby=\"example_info\" style=\"width: 100%;\">
										<thead>
											<tr>
												<th>#</th>";					
					foreach($post['tbl_field'] as $k=>$v)
					{
						$lable=ucwords(str_replace("_"," ",$v));
						$view_data .= "<th>".$lable."</th>";
					}				
					$view_data .= "<th>Action</th>";
					$view_data .=	"</tr>
										</thead>										
										   <?php											  
											   for(\$i=0; \$i<count(\$data['all".$post['txtmodel']."']); \$i++)
											   {
												?>
												  	<tr>
														<td><?php echo (\$i+1);?></td>";
									foreach($post['tbl_field'] as $k=>$v)
									{
										$view_data .= "<td><?php echo \$data['all".$post['txtmodel']."'][\$i]['".$v."']; ?></td>";
									}																														
									$view_data .=	"<td>
														<? if(\$data['all".$post['txtmodel']."'][\$i]['is_active'] != 0){?> 
															<?php if(\$data['arr_permission'][0]['edit_perm'] == 1) { ?>
														<a href=\"javascript:setValueCallPage('<?php echo \$data['all".$post['txtmodel']."'][\$i]['id']?>','".$post['txtmodel']."','showform')\" class=\"tiptip-top\" title=\"Edit\"><img src=\"img/icon_edit.png\" alt=\"edit\" /></a>
															<?php } if(\$data['arr_permission'][0]['delete_perm'] == 1) {  ?>
																	&nbsp;&nbsp;&nbsp;<a href=\"javascript:deleteRestoreEntry('<?php echo \$data['all".$post['txtmodel']."'][\$i]['id']?>','".$post['txtmodel']."','delete','delete')\" class=\"tiptip-top\" title=\"Delete\"><img src=\"img/icon_bad.png\" alt=\"delete\"></a>
														
														<? 		}
														}else{
															if(isset(\$_REQUEST['show_status']))
																if(\$data['arr_permission'][0]['restore_perm'] == 1) {
																	?>
																	<a href=\"javascript:deleteRestoreEntry('<?php echo \$data['all".$post['txtmodel']."'][\$i]['id']?>','".$post['txtmodel']."','restore','restore')\" class=\"tiptip-top\" title=\"Restore\"><img src=\"img/Restore_Value.png\" alt=\"restore\"></a>
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
							</div>";							
			if($_POST['coloum'] == 1)
				{
					$view_data .="</div>";
				}
									
	return $view_data;
}
function get_crud_view_single($post)
{
	$view_data = "<?php
					if (strpos(\$_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
					{
						callheader('index.php');
						exit();
					}
					?>
						<!-- Content -->
						<div id='content' class='clearfix'>
						 <div id='main-content' class='twocolm_form'>";
	$view_data .="<h2><?php if(isset(\$data['".$post['txtmodel']."Variables'])){ echo 'Edit Test';}else { echo 'Add Test';}?></h2>";
	//$view_data .= "<div class='for_links'><a href=\"javascript:setValueCallPage('','".$post['txtmodel']."','showform');\">Add ".ucwords($post['txtmodel'])."</a></div>	";
	$view_data .= "<div class='body-con'>";
	
				  for($i=0;$i<count($_POST['field']); $i++)
					{
						$lable=ucwords(str_replace("_"," ",$_POST['field'][$i]));
						$class = "";
						$mand_sign = '';
						if(in_array($_POST['field'][$i],$_POST['mandatory']))
						{
							$class="validate[required]";
							$mand_sign ="*";
						}
						$view_data .="<label for='".$_POST['field'][$i]."'>".$lable."<span>".$mand_sign."</span></label>\r\n";
						if($_POST['type'][$i] == 'text')
						{
							$view_data .="<input type='text' id='".$_POST['field'][$i]."' name='".$_POST['field'][$i]."' class='".$class."' value='<?php if(isset(\$data['".$post['txtmodel']."Variables']))
																			{ echo \$data['".$post['txtmodel']."Variables']['".$_POST['field'][$i]."']; } ?>'/>";
						}
						elseif($_POST['type'][$i] == 'textarea')
						{
							$view_data .='<textarea name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" class="'.$class.'"><?php if(isset($data["'.$post['txtmodel'].'Variables"]))
																			{ echo $data["'.$post['txtmodel'].'Variables"]["'.$_POST['field'][$i].'"]; } ?></textarea>';
						}
						elseif($_POST['type'][$i] == 'dropdown')
						{								
							$view_data .='<select name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" class="'.$class.'">
										<option value="">Please Select</option>
									  </select>';
						}
						elseif($_POST['type'][$i] == 'checkbox')
						{
							$view_data .='<input type="checkbox" name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" class="'.$class.'"/>';
						}
						elseif($_POST['type'][$i] == 'radio')
						{
							$view_data .='<input type="radio" name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" value="1" class="'.$class.'" />Yes
										  <input type="radio" name="'.$_POST['field'][$i].'" id="'.$_POST['field'][$i].'" value="0" class="'.$class.'" />No';
						}
					}
				$view_data .= "<?php if(isset(\$data['".$post['txtmodel']."Variables']))
								{
								?>
								<input type='button' value='Submit' class='green_button'  onclick=\"javascript:validateFormFields('<?php echo \$data['".$post['txtmodel']."Variables']['id'];?>','".$post['txtmodel']."','save')\" />
								<?php 
								}
								else
								{
								?>
									<input type='button' value='Insert' class='green_button' onClick=\"validateFormFields('','".$post['txtmodel']."','save')\" />
								<?php } ?>
							</div>";					
	$view_data .= "</div></div></div>";
	return $view_data;
}
?>
