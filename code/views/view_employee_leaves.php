<?php 
if (strpos($_SERVER['SCRIPT_NAME'],basename(__FILE__)) !== false)
{
	callheader('index.php');
	exit();
}
?>
<style>
.tbl_leaves
{
	border:1px solid #CDCDCD;
	margin:10px;
}
.border_none
{
	border:none;
}
</style>
<!-- Content -->
<div id='content' class='clearfix'>
        
    <!-- Main Content -->
    <div id="main-content">

            <!-- All Users -->
            <h2>Leave Details Of <?php echo ($data['employee_details'][0]['employee_name'])?></h2>
            <table border="0" width="100%" >
            	<tr>
            		<td width="40%" class="border_none">
                        <table cellpadding="6" cellspacing="0" align="center" style="width:90%" border="1" class="tbl_leaves">
                            <tr>
                                <th>&nbsp;</th><th>Total</th><th>Taken</th><th>Remaining</th>
                            </tr>
                            <?php
                            //for($i=0;$i<count($data['leave_type']);$i++)
                            foreach($data['leave_type'] as $key=>$value)
                            {	$remaining = ($data['total_leaves'][$data['employee_id']][$value['leave_type']] - $data['leaves_taken'][$data['employee_id']][$value['leave_type']]);
                                echo "<tr>
                                        <th>".$value['leave_type']."</th>
                                        <td>".$data['total_leaves'][$data['employee_id']][$value['leave_type']]."</td>
                                        <td>".$data['leaves_taken'][$data['employee_id']][$value['leave_type']]."</td>
                                        <td>".$remaining."</td>
                                     </tr>";
                            }
                            ?>
                        </table>
            		</td>
            		<td width="60%" class="border_none">
            
                        <table cellpadding="6" cellspacing="0" align="center" style="width:90%" border="1" class="tbl_leaves">
                            <tr>
                                <th>Sr.No</th><th>Leave Date</th><th>Leave Type</th><th>Remarks</th>
                            </tr>
							<?php
                            $cnt=1;
                            foreach($data['employee_details'] as $key=>$value)
                            {
								if(isset($value['id']))
								{
                                echo "<tr>
                                        <td>".$cnt."</td>
                                        <td>".date('j-M-Y',strtotime($value['leave_from']))." to ".date('j-M-Y',strtotime($value['leave_to']))."</td>
                                        <td>".$value['leave_type']."</td>
                                        <td>".$value['comment']."</td>
                                    </tr>";
                                $cnt++;
							}
                            }
                            ?>
            			</table>
            		</td>
            	</tr>
            	<tr>
            		<td colspan="2" class="border_none"><input type="button" value="Cancel" class="green_button" onclick="javascript:callPage('hrm','default')"></td>
            	</tr>
            </table>
    </div>
    <!-- END Main Content -->
</div>
<!-- END Content -->
                            
                            