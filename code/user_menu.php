<?php 
$permissionArray = $applnObject->getAllMenu($logArray['user_id']);
//printr($permissionArray); exit;
?>
<!-- Panel Outer -->
<div id="panel-outer" class="radius">
<!-- Panel -->
<div id="panel" class="radius">
<!-- Include main menu -->
<!-- Main menu -->
<!-- This is the structure of main menu -->
<ul id="main-menu" class="radius-top clearfix" >
   <?php    
    
	$tabindex = 1;
	$arr_functions = $applnObject->getAllSubMenu($logArray['user_id'], $current_pageid);
	foreach($permissionArray as $key=>$value)
	{
		?>
        <li>
        <a href="javascript:callPage('<?php echo $value['module_name']; ?>','show_box_view')" <?php if ( $module == $value['module_name'] ) 
																				{ echo 'class="active submenu-active"';
																					$tabindex_sub = $tabindex; 
																				} ?> tabindex="<?php echo $tabindex++; ?>" >
            <img src="<?php echo $value['img_url']; ?>" alt="<?php echo $value['description']?>" />
            <span><?=$value['description']?></span>
			<span class="submenu-arrow"></span><!-- Also this is required for the submenu -->
        </a>
    </li>        
        <?php	
		if ( $module == $value['module_name'] ) 
		{
			if(count($arr_functions) > 1)
				$tabindex = $tabindex+count($arr_functions);
		}
	}	
	
?> 
</ul>
<!-- END Main menu -->
<!-- Submenu -->
<!-- Depending on the page we are, we make visible the submenu we need -->
<!-- displya submenus dynamically -->
<input type="hidden" name="tabindex_val" id="tabindex_val" value="<?php echo ($tabindex_sub++); ?>" />
<!--<input type="hidden" name="from_menu" id="from_menu" value="">-->
<ul id="sub-menu" class="clearfix">
<?php 
foreach($arr_functions as $k=>$v)
{
	?>
    <li><a href="javascript:menuCallPage('<?php echo $module?>','<?php echo $v['function_name']; ?>')"><?php echo $v['friendly_name']; ?></a></li>
    <?php 		
}
?>
</ul>
