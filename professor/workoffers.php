<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	
	<style type="text/css" title="currentStyle">
		@import "../dataTables/css/demo_page.css";
		@import "../dataTables/css/demo_table_jui.css";
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
		@import "../media/css/TableTools.css";
	</style>
	<script type="text/javascript" language="javascript" src="../dataTables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		
		var oTable;
		
		$(document).ready(function(){ 
		/* Init the table */
		oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sScrollX": "100%",
			//"sScrollXInner": "850px",
			"bScrollCollapse": true,
			"aoColumns": [
					/* WorkOfferId */{"bVisible": false },
					/* Professor */null,
					/* Title */null,
					/* Lesson */null,
					/* Candidates */null,
					/* Requirements*/null,
					/* Deliverables */null,
					/* Hours */null,
					/* Deadline */null,
					/* At_di */null,
					/* Acad_year */null,
					/* Winter */null,
					/* Addressed */null
			]
		});
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "../media/swf/copy_cvs_xls_pdf.swf"
        } );
		
		$('#demo_jui').before( oTableTools.dom.container );		
		
		});

	</script>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

		<div id="container">
			<div class="full_width big">
				<i>Πίνακας Παροχών</i> 
			</div>

			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				
				<?php
					$query = "SELECT * FROM work_offers WHERE is_available=true AND has_expired=false";//fere tis diathesimes paroxes
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				
				<div class="demo_jui" id="demo_jui">
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Τίτλος μαθήματος</th>
						<th>Αριθμός υποψηφίων</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα </th>
						<th>Απαιτούμενες ώρες υλοποίησης</th>
						<th>Λήξη προθεσμίας</th>
						<th>Στο χώρο του di</th>
						<th>Ακαδημαϊκό έτος</th>
						<th>Χειμερινού εξαμήνου</th>
						<th>Απευθύνεται σε φοιτητή</th>
					</tr>
				</thead>
				<tbody>	
				<?php	while($row = mysql_fetch_assoc($result_set))
						{
							echo "<tr>";
							extract($row);
							if($addressed_for==0)
								{$student_type="Μη εργαζόμενο";}
							elseif($addressed_for==1)
								{$student_type="Μερικώς εργαζόμενο";}
							else
								{$student_type="Πλήρως εργαζόμενο";}
							/*Βρίσκουμε τις τιμές που θέλουμε μέσω των ξένων κλειδιών*/
							$row1 = get_surname_from_professor_id($professor_id);
							$row2 = get_ayear_from_academic_year_id($academic_year_id);
							echo "<td>$id</td><td>$row1[surname]</td>
								<td>$title</td><td>$lesson</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td>
								<td>$hours</td><td>$deadline</td><td>";
							if($at_di==false)
								echo "<input type='checkbox' disabled='true'>";
							else
								echo"<input type='checkbox' disabled='true' checked='true'>";
							echo "</td><td>$row2[ayear]</td><td>";
							if($winter_semester==false)
								echo "<input type='checkbox' disabled='true'>";
							else
								echo"<input type='checkbox' disabled='true' checked='true'>";
							echo"</td><td>$student_type</td>";
							echo "</tr>";
						}			
				?>	
				</tbody>
				</table>
				
				<br />
				</div>
			</form>	
		
			<div class="spacer"></div>
		</div>
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
