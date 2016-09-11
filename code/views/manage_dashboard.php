<style>
.space_none
{	
	margin:0px;
	padding:0px;
}
.remove_all
{	
	margin:0px;
	padding:0px;
	border:none;
}
.border_none
{
	border:none;
}
.remove_btmargin
{
	margin-bottom:0px;
}
.width_29
{
	width:29%;
}
</style>
<!-- Content -->
<div id="content" class="clearfix">
	<table cellpadding="0" cellspacing="0" align="center" width="90%" border="1">    	
    	<tr>
        	<td>Sr. No.</td>
        	<td>Employee Name</td>
            <td>Date Of Joining</td>
            <td class="space_none">
            	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="remove_btmargin">
                	<tr>
                    	<td class="border_none">Total Leaves</td>
                    </tr>
                    <tr>
                    	<td class="remove_all">
                        	<table cellpadding="0" cellspacing="0" width="100%" class="remove_btmargin">
                            	<tr>
                                	<?php 
									for($i=0; $i<count($data['leave_type']); $i++)
									{
										if($data['leave_type'][$i]['leave_type'] != 'LOP')
										{
									?>
                                	<td class="width_29"><?php echo ucfirst($data['leave_type'][$i]['leave_type']); ?></td>
                                	<?php } } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>           
            <td class="space_none">
            	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="remove_btmargin">
                	<tr>
                    	<td class="border_none">Leaves Taken</td>
                    </tr>
                    <tr>
                    	<td class="remove_all">
                        	<table cellpadding="0" cellspacing="0" width="100%" class="remove_btmargin">
                            	<tr>
                                	<?php 
									for($i=0; $i<count($data['leave_type']); $i++)
									{
									?>
                                	<td class="width_29"><?php echo ucfirst($data['leave_type'][$i]['leave_type']); ?></td>
                                	<?php } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="space_none">
            	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="remove_btmargin">
                	<tr>
                    	<td class="border_none">Remaining</td>
                    </tr>
                    <tr>
                    	<td class="remove_all">
                        	<table cellpadding="0" cellspacing="0" width="100%" class="remove_btmargin">
                            	<tr>
                                	<?php 
									for($i=0; $i<count($data['leave_type']); $i++)
									{
										if($data['leave_type'][$i]['leave_type'] != 'LOP')
										{
									?>
                                	<td class="width_29"><?php echo ucfirst($data['leave_type'][$i]['leave_type']); ?></td>
                                	<?php } } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>            
        </tr>
        <?php
		for($j=0; $j<count($data['allemp']); $j++)
		{
			extract($data['total_leaves']);
			extract($data['leaves_taken']);
			?>
            <tr>
            <td><?php echo ($j+1); ?></td>
            <td><?php echo $data['allemp'][$j]['employee_name']; ?></td>
            <td><?php echo date('d-m-Y',strtotime($data['allemp'][$j]['joining_date'])); ?></td>
            <td class="remove_all">
                <table cellpadding="0" cellspacing="0" width="100%" class="remove_btmargin">
                    <tr>
                    	<?php  
						for($i=0; $i<count($data['leave_type']); $i++)
						{	
							if($data['leave_type'][$i]['leave_type'] != 'LOP')
							{
						?>
						 <td class="width_29"><?php echo $total_leaves[$data['allemp'][$j]['id']][$data['leave_type'][$i]['leave_type']];?></td>
						<?php } } ?>                        
                    </tr>
                </table>
            </td>           
            <td class="remove_all">
                <table cellpadding="0" cellspacing="0" width="100%" class="remove_btmargin">
                    <tr>
                        <?php 
						for($i=0; $i<count($data['leave_type']); $i++)
						{ 
						?>
						 <td class="width_29"><?php echo $leaves_taken[$data['allemp'][$j]['id']][$data['leave_type'][$i]['leave_type']];?></td>
						<?php } ?> 
                    </tr>
                </table>
            </td>
            <td class="remove_all">
                <table cellpadding="0" cellspacing="0" width="100%" class="remove_btmargin">
                    <tr>
                        <?php 
						for($i=0; $i<count($data['leave_type']); $i++)
						{	
							if($data['leave_type'][$i]['leave_type'] != 'LOP')
							{
							$leaves_remain = ($total_leaves[$data['allemp'][$j]['id']][$data['leave_type'][$i]['leave_type']])-($leaves_taken[$data['allemp'][$j]['id']][$data['leave_type'][$i]['leave_type']]);
						?>
						 <td class="width_29"><?php echo $leaves_remain; ?></td>
						<?php } } ?> 
                    </tr>
                </table>
            </td>
            </tr> 
            <?php
		}
		?>       
    </table>
</div>