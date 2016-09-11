<!-- Main Content -->
<div id="content" class="clearfix">
	<div id="main-content" style="width:100%;">
      
    <!-- Messages --> 
    	<!--<h2></h2>-->
    	<div class="view_maindiv" style="margin-top:0%;">
        	
               <!-- <input type="hidden" name="from_menu" id="from_menu" value="< ?php if(isset($check_from)) echo $check_from; ?>" />-->
                <?php 
                foreach($arr_alldata as $k=>$v)
                {					
					$arr_subfunctions = $applnObject->getMenuData($logArray['user_id'], $v['function_name'] ,'function_name',$current_pageid); 
					$class = '';					
					if(count($arr_subfunctions) > 1)
					{
						if($function == 'show_box_view')
							$class = "dark_view_box";
					}
                ?>
                <div style="float:left">
                <a href="javascript:callPage('<?php echo $module; ?>','<?php echo $v['function_name'] ?>')" tabindex="<?php echo $tabindex_sub++; ?>">
                	<div class="view_box <?php echo $class; ?>">
                    	<div><img src="img/icon1.png" width="15px" height="15px"/></div>
						<div><?php echo $v['friendly_name']; ?></div>
                        <div style="clear:both;"></div>
                    </div>
                </a>
                </div>
                <?php 
                }
                ?>               
    			<div style="clear:both;"></div>
 		 </div>
       </div>
</div>
                          
