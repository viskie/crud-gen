<input type="hidden" name="year" id="year" value="<?=date('Y')?>" />
<!-- Content -->
					<div id="content" class="clearfix">
                        
                        <!-- Sidebar -->
                        <div id="side-content-right">
                            
                         
                            
                            <!-- Search box -->
                            <h3>Search</h3>
                            <div class="body-con">
                                <form action="javascript: void(0)" method="post" id="search-form" name="search-form" class="pos-rel">
                                    <input type="text" id="search-keyword" name="search-keyword" value="Search.." onfocus="this.value = '';" class="search" />
                                    <input type="submit" value="Go" id="search-btn" name="search-btn" class="grey search" />
                                </form>
                            </div>
                            <!-- END Search box -->
                            
                            <!-- Updates & Notifications -->
                            
                            <!-- Sidebar tabs -->
                            <ul id="s-tabs" class="content-tabs clearfix">
                                <li class="active"><a href="#s-updates">Updates</a></li>
                                <li><a href="#s-notifications">Notifications</a></li>
                            </ul>
                            <!-- END Sidebar tabs -->

                            <div class="body-con">
                           

                            </div>
                            <!-- END Updates & Notifications -->
                            
                     
                        
                        
                            
                        </div>
                        <!-- END Sidebar -->
                        
                        <!-- Main Content -->
                        <div id="main-content-left">
                        
                        	<? 
									if(isset($_REQUEST['year']))
									{	$year = $_REQUEST['year'];
									} 
									else
									{	$year = date('Y');
									}
									
								?>
                     
                            <!-- Statistics example with Flot plugin -->
                            <h2>Statistics (Visits) - <? echo " ".$year; ?></h2>

                            <div class="body-con">
                            	<a href="javascript:setValueCallPage({year:<?=$year-1?>},'dashboard','default');">Previous Year</a>
								<a href="javascript:setValueCallPage({year:<?=$year+1?>},'dashboard','default');" style="float:right;" class="year-link">Next Year</a>
                                <div id="flot-custom" class="flot-con"></div>
                            </div>
                            <!-- END Statistics example with Flot plugin -->

                           
                            
                        </div>
                        <!-- END Main Content -->
                        
					</div>
					<!-- END Content -->

		 <script>
			$(document).ready(function(e) {
                <? if($year == date('Y')) {?>
					$('.year-link').bind('click', false);
					$('.year-link').css({
						'color' : '#CDE0EB',
						'text-decoration' : 'none'	
					});
				<? } ?>
            });     
			
            $(function(){
                /* Initialize Flot */
                // for advanced usage and customization you can check out the documentation and examples at http://code.google.com/p/flot/
                var d1 = [ [1, <? echo $income_statistics['1']; ?>], [2, <? echo $income_statistics['2']; ?>], [3, <? echo $income_statistics['3']; ?>], [4, <? echo $income_statistics['4']; ?>], [5, <? echo $income_statistics['5']; ?>], [6, <? echo $income_statistics['6']; ?>], [7, <? echo $income_statistics['7']; ?>],
                        [8, <? echo $income_statistics['8']; ?>], [9, <? echo $income_statistics['9']; ?>], [10, <? echo $income_statistics['10']; ?>], [11, <? echo $income_statistics['11']; ?>], [12, <? echo $income_statistics['12']; ?>] ];
						
				var d2 = [ [1, <? echo $expense_statistics['1']; ?>], [2, <? echo $expense_statistics['2']; ?>], [3, <? echo $expense_statistics['3']; ?>], [4, <? echo $expense_statistics['4']; ?>], [5, <? echo $expense_statistics['5']; ?>], [6, <? echo $expense_statistics['6']; ?>], [7, <? echo $expense_statistics['7']; ?>],
                        [8, <? echo $expense_statistics['8']; ?>], [9, <? echo $expense_statistics['9']; ?>], [10, <? echo $expense_statistics['10']; ?>], [11, <? echo $expense_statistics['11']; ?>], [12, <? echo $expense_statistics['12']; ?>] ];	
						
				var d3 = [ [1, <? echo $income_expense_statistics['1']; ?>], [2, <? echo $income_expense_statistics['2']; ?>], [3, <? echo $income_expense_statistics['3']; ?>], [4, <? echo $income_expense_statistics['4']; ?>], [5, <? echo $income_expense_statistics['5']; ?>], [6, <? echo $income_expense_statistics['6']; ?>], [7, <? echo $income_expense_statistics['7']; ?>],
                        [8, <? echo $income_expense_statistics['8']; ?>], [9, <? echo $income_expense_statistics['9']; ?>], [10, <? echo $income_expense_statistics['10']; ?>], [11, <? echo $income_expense_statistics['11']; ?>], [12, <? echo $income_expense_statistics['12']; ?>] ];

                // Visits statistics
                $.plot($("#flot-custom"), [
                    {
						label: "Income",
                        data: d1,
                        lines: {show: true, fill: 0},
                        points: {show: true}
                    },
					 {
						label: "Expense",
                        data: d2,
                        lines: {show: true, fill: 0},
                        points: {show: true}
                    },
					 {
						label: "Profit", 
                        data: d3,
                        lines: {show: true, fill: 0},
                        points: {show: true}
                    }
                ], {
                    xaxis: {
                        ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"], [7, "Jul"],
                                   [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]]
                    },
                    yaxis: {
                        ticks: 10,
                        min: 0
                    },
                    grid: {
						hoverable: true,
                        backgroundColor: {colors: ["#FFFFFF", "#EEEEEE"]}
                    }
                });
                
				function showTooltip(x, y, contents) {
					$('<div id="tooltip">'+contents+'</div>').css( {
						position: 'absolute',
						display: 'none',
						top: y + 10,
						left: x + 10,
						border: '1px solid #fdd',
						padding: '4px',
						'font-weight':'bold',
						'background-color': '#fee',
						opacity: 0.80
					}).appendTo("body").fadeIn(200);
				}
				
				var previousPoint = null;
				$("#flot-custom").bind("plothover", function (event, pos, item) {
						if (item) {
							if (previousPoint != item.datapoint) {
								previousPoint = item.datapoint;
								
								$("#tooltip").remove();
								var x = item.datapoint[0].toFixed(2),
									y = item.datapoint[1].toFixed(2);
								
								showTooltip(item.pageX, item.pageY,y);
							}
						}
						else {
							$("#tooltip").remove();
							clicksYet = false;
							previousPoint = null;            
						}
				});
            
            })
        </script>