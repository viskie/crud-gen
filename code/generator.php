<?php 
include_once('library/config/Config.php');	
include_once('library/commonManager.php'); 
include_once('library/applicationManager.php'); 
include_once('generator_helper.php');

$applnObject = new applicationManager();
$app_title = $applnObject->getAppTitle();

if(isset($_POST['action']) && ($_POST['action']=='GENERATE'))
{
	$affected_files = array();
	if($_POST['gentype'] == "model")
	{	
		$table_name = $_POST['txttable'];
		$model_name = strtolower($_POST['txtmodel']);
		if($table_name == "" || $_POST['txtmodel'] == "")
		{
			$msg = "Please fill all the fields!";  			
		}
		else
		{
			$data = $applnObject->getData("SHOW TABLES LIKE '".$table_name."'"); 
			if(count($data) > 0) 
			{	
				$check = $applnObject->getData("SHOW KEYS FROM `".$table_name."` WHERE Key_name = 'PRIMARY'");
				$check_compl_fields = $applnObject->getData("SHOW COLUMNS FROM `".$table_name."` WHERE `field` in('added_by','added_date','modified_by','modified_date','is_active')");				
				if(count($check)> 0 && (count($check_compl_fields)> 0)) 
				{ 				
					$file = DOC_ROOT.'library/'.$model_name.'Manager.php';	
					if(file_exists($file))
					{
						$msg = "Model already exist!"; 						
					}
					else
					{
						$handle = fopen($file, 'w');
						$data = get_model($model_name,$table_name); 								
						fwrite($handle, $data);
						fclose($handle); 
						// insert model table entry in database
						$chk_exist = $applnObject->getRow('model_table','*',"model = '".trim($model_name)."' AND table_name = '".trim($table_name)."'");
						if($chk_exist == "")
						{			
							$model_table_data = array(									
										'model' => trim($model_name),
										'table_name'=> trim($table_name),
										'is_active' => 1									
										);
							$applnObject->insert('model_table',$model_table_data);
						}   
						$msg = "Model generated successfully!"; 
						$affected_files[] =  $file;
					}
				}
				else
				{
					if(count($check) == 0)
						$msg = "Table does not contain primary key!"; 
					elseif(count($check_compl_fields) == 0)
						$msg = "Table must contains following fields : added_by,added_date,modified_by,modified_date,is_active";					
				}
			}
			else
			{	
				$msg = "Table does not exist!";				
			}	
		}
	}
	elseif($_POST['gentype'] == "controller")
	{
		if($_POST['txtcontroller'] == "")
		{
			$msg = "Please fill all the fields!";  			
		}
		else
		{
			$file = DOC_ROOT.'sub_controllers/sc_'.strtolower($_POST['txtcontroller']).'.php';	
			if(file_exists($file))
			{
				$msg = "Controller already exist!"; 						
			}
			else
			{
				$handle = fopen($file, 'w');
				$data = get_controller(); 					
				fwrite($handle, $data);
				fclose($handle);
				$msg = "Controller generated successfully!"; 
				$affected_files[] = $file;
			}
		}
	}
	elseif($_POST['gentype'] == "crud")
	{	
		//printr($_POST); exit;		
		$contrl_file = DOC_ROOT.'sub_controllers/sc_'.strtolower($_POST['txtcontroller']).'.php';		
		$model_file = DOC_ROOT.'library/'.strtolower($_POST['txtmodel']).'Manager.php';	
		$view_file = DOC_ROOT.'views/manage_'.strtolower($_POST['txtmodel']).'.php';
		$view_file2 = DOC_ROOT.'views/add_edit_'.strtolower($_POST['txtmodel']).'.php';
		/*if(file_exists($contrl_file) && file_exists($model_file) && file_exists($view_file))
		{
			$msg = "CRUD already exist!"; 	
		}
		else
		{*/				
			// create controller file
			$handle = fopen($contrl_file, 'w'); 
			$contrl_data = get_crud_controller($_POST);		
			fwrite($handle, $contrl_data);
			fclose($handle);	
			// create model file
			$model_data = get_crud_model($_POST);		
			$handle1 = fopen($model_file, 'w'); 	
			fwrite($handle1, $model_data);
			fclose($handle1);
			// create view file
			$handle2 = fopen($view_file, 'w');
			$view_data = get_crud_view($_POST);			
			fwrite($handle2, $view_data);
			fclose($handle2);
			
			$affected_files = array($contrl_file,$model_file,$view_file);
			// for sigle coloum view file create add edit file			
			if($_POST['coloum'] == 1)
			{
				$handle3 = fopen($view_file2, 'w');
				$view_data = get_crud_view_single($_POST);			
				fwrite($handle3, $view_data);
				fclose($handle3);
				$affected_files[] =	$view_file2;			
			}
			elseif($_POST['coloum'] == 2)
			{
				// check delete add_edit file if present
				if(file_exists($view_file2))
					unlink($view_file2);
			}
			$msg = "Crud generated successfully!"; 			
			// page,function,subfunction entry			
			$subfunction_data = array(									
									'page_id' => 15,
									'function_name' => 'default',						
									'friendly_name'=> ucfirst($_POST['txtmodel']),
									'menu_order' => 1,
									'is_crud' => 1
									);
			$chk_exist = $applnObject->getRow('functions','*',"page_id = 15 AND function_name = 'default' AND friendly_name = '".ucfirst($_POST['txtmodel'])."'");			
			if($chk_exist == "")
			{
				$function_data = array(
									'page_id' => 15,
									'function_name' => 'default',
									'friendly_name'=> ucfirst($_POST['txtmodel']),
									'menu_order' => 1
									);
				$function_id = $applnObject->insert('functions',$function_data);
				$chk_sub_exist = $applnObject->getRow('sub_functions','*',"page_id = 15 AND main_function_id = '".$function_id."' AND function_name = 'default' AND friendly_name = '".ucfirst($_POST['txtmodel'])."'");
				if($chk_sub_exist == "")
				{	
					$subfunction_data['main_function_id'] = $function_id;
					$applnObject->insert('sub_functions',$subfunction_data);				
				}
			}
			else
			{
				$chk_sub_exist = $applnObject->getRow('sub_functions','*',"page_id = 15 AND main_function_id = '".$chk_exist['function_id']."' AND function_name = 'default' AND friendly_name = '".ucfirst($_POST['txtmodel'])."'");
				if($chk_sub_exist == "")
				{	
					$subfunction_data['main_function_id'] = $chk_exist['function_id'];
					$applnObject->insert('sub_functions',$subfunction_data);
				}
			}			
		//}		
	}	
}
if(isset($_POST['gentype']) && $_POST['gentype'] == "fields")
{	
	$model = $_POST['model'];
	$table = $applnObject->getOne('model_table','table_name','model="'.$_POST['model'].'"');
	$table_fields = $applnObject->getTableColms($table);
	$primary_key = $applnObject->getPrimaryKey($table); 
	$except = array($primary_key,"added_by","added_date","modified_by","modified_date","is_active");
	$fields = getFields($table_fields,$except);
	//printr($fields); exit;
	echo json_encode($fields); 
	exit;
}
if(isset($_POST['action']) && ($_POST['action']=='DOWNLOAD'))
{
	$model = 'library/'.$_POST['txtcrud'].'Manager.php';	
	$view = 'views/manage_'.$_POST['txtcrud'].'.php';
	$controller = 'sub_controllers/sc_'.$_POST['txtcrud'].'.php';
	$files = array($model,$view,$controller);

	$zipname = 'crud.zip';
	$zip = new ZipArchive;		
	$zip->open($zipname, ZipArchive::OVERWRITE);
	foreach ($files as $file) {
		// following 2 lines are required if we directly want files in zip without folder
		// $new_filename = substr($file,strrpos($file,'/') + 1);
	 	// file_put_contents($new_filename, file_get_contents($file));
		$zip->addFile($file);		
	}
	$zip->close();
	//unlink(DOC_ROOT.$zipname);
	header('Content-Type: application/zip');
	header("Content-Disposition: attachment; filename='".$zipname."'");
	//header('Content-Length: ' . filesize($zipname));
	header("Pragma: no-cache"); 
    header("Expires: 0"); 
	header("Location: ".$zipname);	
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Code Generator</title>
</head>
<style>
body
{
	font-family:calibri;;
	font-size:16px;
	background-color:#EFEFEF;
}
.tbmain
{
	margin-top:10%;
}
.frmtable
{
	padding:5px;
	border:1px solid #BBBBBB;
	margin:30px;
}
.frmhead
{
	background-color:#f5f5f5;	
}
.tblleft
{
	margin:10px;
}
.page
{
	margin-top:5px;
	border:1px solid #CCC;
	background-color:#FFFFFF;
}
#heading
{
	font-size:20px;	
	padding-top:50px;
}
a
{
	text-decoration:none;
}
.error
{
	color:#008000;
	font-size:12px;
}
.btngenerate{
border:1px solid #15aeec; -webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:12px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;
 background-color: #49c0f0; background-image: -webkit-gradient(linear, left top, left bottom, from(#49c0f0), to(#2CAFE3));
 background-image: -webkit-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: -moz-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: -ms-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: -o-linear-gradient(top, #49c0f0, #2CAFE3);
 background-image: linear-gradient(to bottom, #49c0f0, #2CAFE3);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#49c0f0, endColorstr=#2CAFE3);
}

.btngenerate:hover{
 border:1px solid #1090c3;
 background-color: #1ab0ec; background-image: -webkit-gradient(linear, left top, left bottom, from(#1ab0ec), to(#1a92c2));
 background-image: -webkit-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: -moz-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: -ms-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: -o-linear-gradient(top, #1ab0ec, #1a92c2);
 background-image: linear-gradient(to bottom, #1ab0ec, #1a92c2);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#1ab0ec, endColorstr=#1a92c2);
}
</style>
<script language="javascript" type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
<script language="javascript" type="text/javascript">
function show_fields(model)
{	
	$.ajax({
			type: "POST",
			//dataType: "json",
			url: "generator.php",
			data:  {
					'gentype' : 'fields',
					'model' : model
					},			
			success: function(result){				
				var arr_fields = JSON.parse(result);				
				var html = '<table cellpadding="5" cellspacing="0" align="center" width="100%">';
				html += '<tr>\
								<td colspan="2"></td>\
								<td>Show in table</td>\
								<td>Is mandatory</td>\
							</tr>';
				for(var i=0;i<arr_fields.length;i++)
				{					
					html += '<tr><td width="25%">'+arr_fields[i]+'<input type="hidden" name="field[]" id="field" value="'+arr_fields[i]+'"/></td><td width="27%">';
					html += '<select name="type[]" id="sel_type">\
								<option value="text">Text</option>\
								<option value="textarea">Textarea</option>\
								<option value="dropdown">Dropdown</option>\
								<option value="checkbox">Checkbox</option>\
								<option value="radio">Radio Button</option>\
							</select>\
							<td width="23%"><input type="checkbox" name="tbl_field[]" id="tbl_field" value="'+arr_fields[i]+'" /></td>\
							<td width="25%"><input type="checkbox" name="mandatory[]" id="mandatory" value="'+arr_fields[i]+'"/></td>';
					html += '</td></tr>';
				}
				html += '</table>';
				$("#dspl_field").html(html);						
			}
		});
}
</script>
<body>

<table cellpadding="0" cellspacing="0" align="center" width="70%" class="page">
	<tr>
    	<td>
        	<table cellpadding="0" cellspacing="0" align="center" width="90%">
            	<tr>
                	<td colspan="2" id="heading">Welcome to Code Generator!</td>
                   
                </tr>
                <tr>
                	<td colspan="2" id="top_line">You may use the following generators to quickly build up application.</td>
                </tr>
            	<tr>
                	<td width="30%" valign="top">
                    	<table cellpadding="2px" cellspacing="0" align="center" width="100%" class="tblleft">
                        	<tr>
                            	<td>
                                	<ul>
                                    	<li><a href="<?php echo PATH;?>generator.php?w=model">Generate Model</a></li>
                                        <li><a href="<?php echo PATH;?>generator.php?w=controller">Generate Controller</a></li>
                                        <li><a href="<?php echo PATH;?>generator.php?w=crud">Generate Crud</a></li>
                                        <li><a href="<?php echo PATH;?>generator.php?w=download">Download Crud</a></li>
                                    </ul>
                                </td>
                            </tr>                            
                        </table>
                    </td>
                    <td>
                    	<?php  if(isset($_GET['w'])) { ?>
                    	<form name="frmgenerator" id="frmgenerator" action="" method="post">
                        <table cellpadding="5" cellspacing="0" align="center" width="80%" class="frmtable">
                            <tr class="frmhead">
                                <td colspan="2" align="center"><?php echo ucfirst($_GET['w']);?> Generator
                                    <input type="hidden" name="gentype" id="gentype" value="<?php echo $_GET['w'];?>" />
                                </td>
                            </tr>
                            <?php
                                if(isset($msg))
                                {
                                ?>
                                <tr>
                                    <td colspan="2" align="center" class="error"><?php echo $msg; ?></td>
                                </tr>
                                <?php 
                                }
                                if(isset($_GET['w']) && ($_GET['w'] == "model"))
                                {						
                                    ?>                                   
                                    <tr>
                                        <td>Model Name</td>
                                        <td><input type="text" name="txtmodel" id="txtmodel" value="<?php if(isset($_POST['txtmodel'])) echo $_POST['txtmodel'];?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Table Name</td>
                                        <td><input type="text" name="txttable" id="txttable" value="<?php if(isset($_POST['txttable'])) echo $_POST['txttable'];?>" /></td>
                                    </tr> 
                                    <tr>
                                    	<td colspan="2">
	                                       	<table cellpadding="2" cellspacing="0" border="0" align="center" width="70%" style="border:1px solid #33B3E6;">
                                            	<tr>
                                                	<td>
                                                    	<ul><span style="color:#217394;">Note : </span>
                                                        	<li>Table must contain Primary Key.</li>
                                                            <li>Table must contains following fields : added_by,added_date,modified_by,modified_date,is_active.</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            	
                                            </table>
                                        </td>
                                    </tr>                       
                                    <?php
                                }
                                elseif(isset($_GET['w']) && ($_GET['w'] == "controller"))
                                {
                                    ?>                                  
                                    <tr>
                                        <td>Controller Name</td>
                                        <td><input type="text" name="txtcontroller" id="txtcontroller" value="<?php if(isset($_POST['txtcontroller'])) echo $_POST['txtcontroller'];?>" /></td>
                                    </tr>                        
                                    <?php
                                }
                                elseif(isset($_GET['w']) && ($_GET['w'] == "crud"))
                                {
									// get all controllers
									$dir_path = DOC_ROOT.'sub_controllers';
									$arr_files = array_diff(scandir($dir_path), array('..', '.'));
									$arr_controller = array();
									foreach($arr_files as $k=>$v)
									{
										$controller = str_replace('sc_',"",$v);
										$arr_controller[] = str_replace('.php',"",$controller);
									}
									// get all models
									$dir_path_model = DOC_ROOT.'library';
									$arr_model_files = array_diff(scandir($dir_path_model), array('..', '.'));
									$arr_model_files = array_diff($arr_model_files, array('applicationManager.php', 'commonManager.php', 'commonFunctions.php', 'config'));
									
									foreach($arr_model_files as $k=>$v)
									{
										$model = str_replace('Manager.php',"",$v);
										$arr_model[] = str_replace('.php',"",$model);
									}									
                                    ?>                                   
                                    <tr>
                                        <td>Controller Name</td>
                                        <td>
                                        	<select name="txtcontroller" id="txtcontroller">
                                            	<option>Select Controller</option>
                                                <?php
												foreach($arr_controller as $k=>$v)
												{
												?>
                                                <option value="<?php echo $v;?>"><?php echo ucfirst($v);?></option>
                                                <?php 	
												}
												?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Main Model</td>
                                        <td>
                                        	<select name="txtmodel" id="txtmodel" onchange="show_fields(this.value)">
                                            	<option>Select Model</option>
                                                <?php
												foreach($arr_model as $k=>$v)
												{
												?>
                                                <option value="<?php echo $v;?>"><?php echo ucfirst($v);?></option>
                                                <?php 	
												}
												?>
                                            </select>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td valign="top">Supporting Models</td>
                                        <td>
                                        	<?php
												foreach($arr_model as $k=>$v)
												{
												?>                                                
                                                <input type="checkbox" name="sup_model[]" id="sup_model" value="<?php echo $v;?>" /><?php echo $v;?></br>
                                                <?php 	
												}
												?>                                        	
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td valign="top">View Display</td>
                                        <td>
                                        	<input type="radio" name="coloum" id="coloum" value="1" />Single Coloum
                                            <input type="radio" name="coloum" id="coloum" value="2" checked="checked" />Two Coloum
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2" id="dspl_field">                                        	
                                        </td>
                                    </tr>
                                    <?php
                                }
								if(isset($_GET['w']) && ($_GET['w'] == "download"))
                                {
									//if(file_exists(DOC_ROOT.'crud.zip'))
										//unlink(DOC_ROOT.'crud.zip');	
									// get all controllers
									$dir_path = DOC_ROOT.'sub_controllers';
									$arr_files = array_diff(scandir($dir_path), array('..', '.'));
									$arr_controller = array();
									$arr_crud = array();
									foreach($arr_files as $k=>$v)
									{
										$controller = str_replace('sc_',"",$v);
										$controller = str_replace('.php',"",$controller);	
										if(file_exists(DOC_ROOT.'library/'.$controller.'Manager.php') && file_exists(DOC_ROOT.'views/manage_'.$controller.'.php'))
										{	
											$arr_crud[] = $controller;
										}
									}									
								?>
                                <tr>
                                    <td>CRUD</td>
                                    <td>
                                        <select name="txtcrud" id="txtcrud">
                                            <option>Select CRUD</option>
                                            <?php
                                            foreach($arr_crud as $k=>$v)
                                            {
                                            ?>
                                            <option value="<?php echo $v;?>"><?php echo ucfirst($v);?></option>
                                            <?php 	
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center"><input type="submit" name="action" id="action" value="DOWNLOAD" class="btngenerate" /></td>
                                </tr>
                                <?php	
								}
                                if(isset($_GET['w']) && ($_GET['w'] != "download"))
                                {
                            ?>
                            <tr>
                                <td colspan="2" align="center"><input type="submit" name="action" id="action" value="GENERATE" class="btngenerate" /></td>
                            </tr>
                            <?php if(isset($affected_files) && count($affected_files) > 0) { ?>
                            <tr>
                            	<td colspan="2"> Affected files are : </br>                                
								<?php 
                                for($i=0; $i<count($affected_files); $i++)
                                {	
                                    echo ($i+1).". ".$affected_files[$i]."</br>";
                                }
                                ?>
                            	</td>
                            </tr>  
                            <?php } } ?>             
                        </table>
                        </form>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </td>        
    </tr>
</table>


</body>
</html>