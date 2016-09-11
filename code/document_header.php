<?php  
/* Choose Turboadmin layout
 * 
 * ''                     => leave empty for default fixed layout
 * 'fluid'                => fluid layout
 * 'fixed-adminbar'       => fixed layout + fixed adminbar
 * 'fluid-fixed-adminbar' => fluid layout + fixed adminbar
 * 
 */
$turboadmin_layout = 'fluid';
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $pageTitle; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="pixelcave" />
    <meta name="robots" content="nofollow" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" />
    <!-- Jquery plugins styles -->
    <!-- Include all the corresponding plugin styles depending on the plugins you would like to use -->
    <link type="text/css" rel="stylesheet" href="css/jquery-ui-1.8.11.custom.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.fullcalendar.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.fullcalendar.print.css" media="print" />
    <link type="text/css" rel="stylesheet" href="css/jquery.tiptip.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.uniform.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.apprise.css" />
    <link type="text/css" rel="stylesheet" href="css/jquery.datatables.css" />
	<link type="text/css" rel="stylesheet" href="css/colorbox.css" />
	<link type="text/css" rel="stylesheet" href="css/validationEngine.jquery.css" />
        <!-- TurboAdmin main style -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />
     
     <script src="js/jquery-1.5.2.min.js"></script>

<!-- Jquery UI, used for FullCalendar, Autocomplete & Datepicker-->
<script src="js/jquery-ui-1.8.11.custom.min.js"></script>

<!-- Flot, jquery plugin for graphs -->
<script src="js/jquery.flot.min.js"></script>

<!-- FullCalendar, jquery plugin for calendar -->
<script src="js/jquery.fullcalendar.js"></script>

<!-- WYSIWYG, jquery plugin for textarea wysiwyg editor -->
<script src="js/jquery.wysiwyg.js"></script>

<!-- Tabify, jquery plugin for tabs -->
<script src="js/jquery.tabify.js"></script>

<!-- Limit, jquery plugin for twitter limit character -->
<script src="js/jquery.limit.js"></script>

<!-- Tiptip, jquery plugin for tooltips -->
<script src="js/jquery.tiptip.js"></script>

<!-- Elastic, jquery plugin for auto expanding textareas -->
<script src="js/jquery.elastic.js"></script>

<!-- Uniform, jquery plugin for styling form elements -->
<script src="js/jquery.uniform.js"></script>

<!-- Apprise, jquery plugin for modals -->
<script src="js/jquery.apprise.js"></script>

<!-- DataTables, jquery plugin for table data handling -->
<script src="js/jquery.dataTables.min.js"></script>

<!-- Colorbox -->
<script src="js/jquery.colorbox.js"></script>

<!-- Validation Engine -->
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-en.js"></script>

<!-- Custom javascript code for TurboAdmin -->
<script src="js/page.js"></script>

<script type="text/javascript" src="js/main.js" ></script>

<!-- END Javascript code -->
</head>
    <body onload="updateClock(); setInterval('updateClock()', 1000 );" <?php if ($turboadmin_layout) echo ' class="'.$turboadmin_layout.'"'; ?>>
    <form action="" method="post" name="mainForm" id = "mainForm" enctype="multipart/form-data" />
	<input type="hidden" name="page" id="page" value="" />
	<input type="hidden" name="function" id="function" value="" />
	<input type="hidden" name="edit_id" id="edit_id" value="<?php if(isset($_POST['edit_id']) && ($_POST['edit_id'] != "")) echo $_POST['edit_id'];?>" />
    <input type="hidden" name="show_status" id="show_status" value="1" />
    <input type="hidden" name="mainfunction" id="mainfunction" value="<?php if(isset($data['mainfunction'])) echo $data['mainfunction']; elseif(isset($mainfunction)) echo $mainfunction; ?>" />
	<input type="hidden" name="subfunction_name" id="subfunction_name" value="<?php if(isset($data['subfunction_name'])) echo $data['subfunction_name'];  elseif(isset($subfunction_name))echo $subfunction_name; ?>" />
		<!-- Container -->
		<div id="container">