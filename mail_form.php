<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<link type="text/css" href="jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<script type="text/javascript" src="jquery-validation-1.8.0/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function(){
		$('#myForm').validate({
				'rules':{
						'title':'required',
						'lesson':'required',
						'requirements':'required',
						'deliverables':'required',
						'deadline':'required',
						'hours':'required'
						}
						});
						});
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

		<h4> Αποστολή ενημερωτικών e-mail </h4>
		<form id="myMailForm" action="mail_form_processing.php" method="post">
		<table>
		    <tr>
				<td>ΑΠΟ(εισάγετε όνομα χρήστη)</td><td><input type="text" name="mail_subject" size="40"/></td>
			</tr>
			<tr>
				<td>ΠΡΟΣ</td><td> <select name="receivers">
				  <option value="1">Όλους τους εγγεγραμένους χρήστες</option>
				  <option value="2">Διδάσκοντες</option>
				  <option value="3">Φοιτητές</option>
				  <option value="3">Διαχειριστές Συστήματος</option>
				</select></td>
			</tr>
			<tr>
				<td>Θέμα</td><td><input type="text" name="mail_subject" size="80"/></td>
			</tr>
			<tr>
				<td>Κείμενο Περιεχομένου</td><td> <textarea name="mail_contents" cols="60" rows="5"></textarea></td>
			</tr>
			<tr>
			<td align="center"><input type="submit" name="sent_mail" value="Αποστολή"/></td>
			</tr>
		</table>
		</form>
		
		
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

 
</html>