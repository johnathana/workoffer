<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	 ?>
	
	<style type="text/css" title="currentStyle">
		@import "dataTables/css/demo_page.css";
		@import "dataTables/css/demo_table_jui.css";
		@import "jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
		@import "media/css/TableTools.css";
	</style>
	<script type="text/javascript" language="javascript" src="dataTables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8"></script>
	<script>
		$(function() {
			$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>

	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
         
		<p>
        <h2>ΚΕΝΤΡΙΚΗ ΟΘΟΝΗ ΔΙΑΧΕΙΡΙΣΤΩΝ ΣΥΣΤΗΜΑΤΟΣ</h2>
		</p>
       	<form id="myProfForm" action="prof_form_processing.php" method="post">
		<table>
			<tr>
			<td>Για τη διαχείριση των διδασκόντων πατήστε: </td>
			<td align="center"><input class="button" type="submit" name="Profs" value="Διδάσκοντες"/></td>
			</tr>
		</table>
		</form> 	
		
		<form id="myStudentForm" action="student_form_processing.php" method="post">
		<table>
			<tr>
			<td>Για τη διαχείριση των φοιτητών πατήστε: </td>
			<td align="center"><input class="button" type="submit" name="Students" value="Φοιτητές"/></td>
			</tr>
		</table>
		</form> 	
		
		<form id="myWorkListForm" action="/professor/personal_workoffer_list.php" method="post">
		<table>
			<tr>
			<td>Για τη διαχείριση των παροχών πατήστε: </td>
			<td align="center"><input class="button" type="submit" name="workoffer_list" value="Παροχές"/></td>
			</tr>
		</table>
		</form> 
		

	<!--	<form id="myReportsForm" action="Reports_form_processing.php" method="post">
		<table>
			<tr>
			<td>Για την επισκόπηση παροχών και δημιουργία αναφορών πατήστε: </td>
			<td align="center"><input class="button" type="submit" name="Reports" value="Αναφορές"/></td>
			</tr>
		</table>
		</form> -->
		
		<form id="myMailForm" action="mail_form.php" method="post">
		<table>
			<tr>
			<td>Για την αποστολή μαζικών μηνυμάτων σε διδάσκοντες- φοιτητές πατήστε: </td>
			<td align="center"><input class="button" type="submit" name="mail" value="E-mail"/></td>
			</tr>
		</table>
		</form> 
		
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
	
	
	
	
	
	
	
	
	
	
	


