// JavaScript Document
var month=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

var error = {
 	"User": {
		
	},

};

function updateClock (){
	var d=new Date();
	var n = month[d.getMonth()]; 
	
	var currentTime = new Date ( );
	
	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
//	var currentSeconds = currentTime.getSeconds( );
	
	var currentDate = currentTime.getDate( );
	var currentMonth = currentTime.getMonth( );
	var currentYear = currentTime.getFullYear();
	
	// Pad the minutes and seconds with leading zeros, if required
	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
//	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
	
	// Choose either "AM" or "PM" as appropriate
	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
	
	// Convert the hours component to 12-hour format if needed
	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
	
	// Convert an hours component of "0" to "12"
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;
	
	// Compose the string for display
	var currentTimeString =currentDate +"-"+ n +"-" + currentYear+"   "+currentHours + ":" + currentMinutes +" " + timeOfDay;
	
	// Update the time display
	document.getElementById("clock").firstChild.nodeValue = currentTimeString;
	var attendance_clock=document.getElementById("clock1");
	if(attendance_clock){
		attendance_clock.firstChild.nodeValue = currentTimeString;
	}
}
function startClock(){
	setInterval('updateClock()', 60000);
}
function convertToDataTables(selector,option_obj){
	if(typeof selector=== "undefined" || $.trim(selector)==='')
	{
		selector='.data-table';
	}
	
	var default_option_obj=
	{
		"iDisplayLength":15,
		"aLengthMenu":[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]],
		"sPaginationType":"full_numbers",
		"oLanguage": {"sLengthMenu": "Show:_MENU_"}
	}
	
	if(typeof option_obj=== "object")
	{
		for(prop in default_option_obj)
		{
			if(typeof option_obj[prop]==="undefined")
			{
				option_obj[prop]=default_option_obj[prop];
			}
		}
	}
	else
	{
		option_obj=default_option_obj;
	}
		
	$(selector).dataTable(option_obj);
}
/**********************************
* A generalized function to convert input into datepicker
* 
* Argument explaination
*	selector 			=	jQuery selector for an element which we have to make datepicker(".datepicker" if not supplied)
*	alt_selector		=	jQuery selector for an element which holds the alternate date(".datepicker_alt" if not supplied, use '' to omit)
*	date_from_selector	=	If current datepicker is part of date range and current datepicker is for 'to' part of range, this will be the jQuery selector for 'from' datepicker(Nothing happens if not supplied, use '' to omit)
*	date_to_selector	=	If current datepicker is part of date range and current datepicker is for 'from' part of range, this will be the jQuery selector for 'to' datepicker(Nothing happens if not supplied, use '' to omit)
*	option_obj 			=	JSON object of different configuration of datepicker element(default_option_obj, defined in method is used if not supplied)
*							You can use "new Object()" or simply '' to omit this argument
*
* Some examples
*	convertToDatePicker('#id_of_input');
*
*	convertToDatePicker('.class_of_input','.class_of_alt_field');
*
*	convertToDatePicker('#from_date','','#to_date');
*	convertToDatePicker('#to_date','','','#from_date');	
*
*	convertToDatePicker('.class_of_input','','','',	{
*														"numberOfMonths":	3,
*														"defaultDate"	:	+7
*													});
**********************************/
function convertToDatePicker(selector,alt_selector,date_from_selector,date_to_selector,option_obj){
	if(typeof selector=== "undefined" || $.trim(selector)==='')
	{
		selector='.datepicker';
	}
	
	var default_option_obj=
	{
		dateFormat: "d-M-yy",
		altFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		yearRange: "-100:+0"
	}
	
	if(typeof option_obj=== "object")
	{
		for(prop in default_option_obj)
		{
			if(typeof option_obj[prop]==="undefined")
			{
				option_obj[prop]=default_option_obj[prop];
			}
		}
	}
	else
	{
		option_obj=default_option_obj;
	}
	
	option_obj.altField=(typeof alt_selector==="undefined")?".datepicker_alt":alt_selector;
	
	if(typeof date_from_selector!=="undefined" || $.trim(date_from_selector)!=='')
	{	
		option_obj.onClose=function(selectedDate){
			$(date_from_selector).datepicker( "option", "maxDate", selectedDate );			
      	}
	}
	
	if(typeof date_to_selector!=="undefined" || $.trim(date_to_selector)!=='')
	{
		option_obj.onClose=function(selectedDate){
			$(date_to_selector).datepicker( "option", "minDate", selectedDate );			
      	}
	}
	
	$(selector).datepicker(option_obj);
}
function ymdToObj(dateStringInRange) {
	var isoExp = /^\s*(\d{4})-(\d\d)-(\d\d)\s*$/,
		date = new Date(NaN), month,
		parts = isoExp.exec(dateStringInRange);

	if(parts) {
	  month = +parts[2];
	  date.setFullYear(parts[1], month - 1, parts[3]);
	  if(month != date.getMonth() + 1) {
		date.setTime(NaN);
	  }
	}
	return date;
}
function setDatepickerDate(selector,date_to_set,alt_selector){
	if(date_to_set!==null){
		$(selector).datepicker('setDate', ymdToObj(date_to_set));
	}
}

function callPage(page,function_name)
{
	if(page != "")
	{
		$('#page').val(page);
		if(function_name==""){
			$('#function').val("default");
		}else{
			$('#function').val(function_name);
		}
		$('#mainForm').validationEngine('hideAll'); // To hide the error messages
		$('#mainForm').validationEngine('detach');  // To remove the validationEngine		
		$('#mainForm').submit();
	}
}
function menuCallPage(page,function_name)
{	
	if(page != "")
	{
		document.getElementById('page').value = page;
		if(function_name==""){
			document.getElementById('function').value = "view";
		}else{
			document.getElementById('function').value = function_name;
		}
		$("#show_status").val('1');
		$('#from_menu').val('function'); //alert (('#from_menu').val()); 
		$('#mainForm').validationEngine('hideAll'); // To hide the error messages
		$('#mainForm').validationEngine('detach');  // To remove the validationEngine
		document.getElementById('mainForm').submit();
	}
}
function setValueCallPage(values,page,func)
{
	if(typeof values === "object")
	{
		for(prop in values)
		{
			$("#"+prop).val(values[prop]);
		}
	}else{
		$("#edit_id").val(values);
	}
	$('#mainForm').validationEngine('hideAll'); // To hide the error messages
	$('#mainForm').validationEngine('detach');  // To remove the validationEngine
	callPage(page,func);
}

function deleteRestoreEntry(id,page,func,entry_name)
{	
	if(confirm("Do you want to "+entry_name+" this record ?"))
	{	setValueCallPage(id,page,func);}
	
}
function validateFormFields(id,page,func)
{
	if(typeof CKEDITOR !== "undefined")	{
		if(CKEDITOR.instances['ckeditor-instance']){
			var value = CKEDITOR.instances['ckeditor-instance'].getData();
			$("#ckeditor-instance").val(value);
		}
	}
	$('#mainForm').validationEngine();
	$("#edit_id").val(id);
	validation_callPage(page,func);	
}

function validation_callPage(page,function_name)
{
	if(page != "")
	{
		$('#page').val(page);
		if(function_name==""){
			$('#function').val("default");
		}else{
			$('#function').val(function_name);
		}	
				
		$('#mainForm').submit();
	}
}
function show_records(setval, page, func)
{
	$("#show_status").val(setval);
	callPage(page,func);
}

function updateGlobalSettings(page, func)
{
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if($('#admin_email_address').val() == "")
		{
        	alert(error.Setting.admin_email_address);			
			$('#admin_email_address').focus();
		}
		else if(!filter.test($('#admin_email_address').val()))
		{
        	alert(error.Setting.valid_admin_email);			
			$('#admin_email_address').focus();
		}
		else if($('#application_title').val() == "")
		{
        	alert(error.Setting.application_title);			
			$('#application_title').focus();
		}
		else if($('#footer_text ').val() == "")
		{
        	alert(error.Setting.footer_text);			
			$('#footer_text').focus();
		}
		else if(confirm(error.Setting.global_setting_change))
		{
			$('#page').val(page);
			$('#function').val(func);
			$('#mainForm').submit();
		}
}
// all doucment.ready functions
$(document).ready( function () {
		
		$("select.less_width").closest('.selector').addClass('small_sel');
		
		updateClock();		
		var curr_time=new Date();
		setTimeout('startClock()',(60-curr_time.getSeconds())*1000);
		
		$('.data-table').dataTable({
			"iDisplayLength": 15,
			"aLengthMenu": [[15,30,100,-1], [15,30,100,"All"]],
			"sPaginationType": "full_numbers",
			"oLanguage": {"sLengthMenu": "Show:_MENU_"},
			
		});
		
		$('.user-table').dataTable({
			"iDisplayLength": 10,
			"aLengthMenu": [[10,20,100,-1], [10,20,100,"All"]],
			"sPaginationType": "full_numbers",
		});
		
		convertToDatePicker('.datepicker','.datepicker_alt');
		convertToDatePicker('.date_range','.date_range_alt');
		convertToDatePicker('.date_range_from','.date_range_from_alt','','.date_range_to');
		convertToDatePicker('.date_range_to','.date_range_to_alt','.date_range_from');		
		
		$('select').change(function(){
			var this_select=$(this);
			if($(this).parent().hasClass('selector')){
				$(this_select).parent().find('span').html($(this).find(':selected').html());
			}
		}); 
		$('input:checkbox').change(function(){
			var this_check=$(this);
			if($(this_check).is(':checked')){
				if(!$(this_check).parent().hasClass('checked')){
					$(this_check).parent().addClass('checked');
				}
			}else{
				if($(this_check).parent().hasClass('checked')){
					$(this_check).parent().removeClass('checked');
				}
			}
		});
		
		var tabindex_val = $("#tabindex_val").val();
		$('a[tabindex="'+parseInt(tabindex_val)+'"]').focus();
	});
	
	function goToTab(tab_number){
		
		var activeTab = $(".emp_second").find("a").attr("href"); //Find the rel attribute value to identify the active tab + content 
		$(activeTab).fadeIn();
		//$("ul.tabs li:nth-child(2n)").addClass("active").show(); 
		//$("#tab"+tab_number).closest("li").addClass("active").show(); 
		//$(".tab_content:first").show();
		//$(".tab_content:first").show();
		//$('.active').removeClass('active');
		//$("#tab"+tab_number).closest("li").addClass("active");
		//$(".ui-tabs-panel.ui-widget-content.ui-corner-bottom").addClass('ui-tabs-hide');
		//$("#tab-"+tab_number).removeClass('ui-tabs-hide');
		/*$('.ui-tabs-selected').removeClass('ui-tabs-selected');
		$('.ui-state-active').removeClass('ui-state-active');
		$("#tab_title"+tab_number).closest("li").addClass("ui-tabs-selected ui-state-active");
		$(".ui-tabs-panel.ui-widget-content.ui-corner-bottom").addClass('ui-tabs-hide');
		$("#tab-"+tab_number).removeClass('ui-tabs-hide');*/
	}  