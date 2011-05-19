<?php header('Content-Type: text/html ; charset=utf-8'); ?>
<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
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
		
		<script>
		var oTable;
		
		$(document).ready(function(){
			$( "#tabs" ).tabs();
			/* Init the table */
			oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sScrollX": "100%",
			//"sScrollXInner": "850px",
			"bScrollCollapse": true,
			"aoColumns": [
			/* WorkOfferId */{"bVisible": false },
			/* Proffesor */null,
			/* Title */null,
			/* Lesson */null,
			/* Price */null,
			/* Product */null,
			/* Description */null,
			/* Rating */null,
			/* Product */null,
			/* Description */null,
			/* Rating */null,
			/* Product */null,
			/* Rating */null,
			]
			});
			
			var oTableTools = new TableTools( oTable, {
			"sSwfPath": "media/swf/copy_cvs_xls_pdf.swf"
			} );
			
			$('#demo_jui').before( oTableTools.dom.container );
			
			/* Add a click handler to the rows - this could be used as a callback */
			$("#example tbody").click(function(event) {
				$(oTable.fnSettings().aoData).each(function (){
					$(this.nTr).removeClass('row_selected');
				});
				$(event.target.parentNode).addClass('row_selected');
				var workid = (fnGetSelected(oTable));
				var str = '<input type="hidden" name="id" value="'+workid+'"/>';
				$('#demo').html(str);
			});
			
			
			
			$('#myForm').submit(function()
			{
				var workid = (fnGetSelected(oTable));
				
				if (workid != null)//έχει επιλεγεί κάποια παροχή
				{
					return true;
				}
				else//δεν έχει επιλέξει κάποια παροχή 
				{
					alert("Πρέπει πρώτα να επιλέξετε μια παροχή έργου");
					return false;
				}
			});
		
		});
			/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal )
		{
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ )
			{
				if ( $(aTrs[i]).hasClass('row_selected') )
				{
					var aRowData = new Array();
					aRowData = oTable.fnGetData(aTrs[i]);

					return aRowData[0];
				}
			}
			return null;
		}
		
		</script>
	</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		<div id="myDiv" style="width:900px;">
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Προσωπικές ενεργές παροχές</a></li>
				<li><a href="#tabs-2">Προσωπικές ανενεργές παροχές</a></li>
			</ul>
			<div id="tabs-1">
				<?php
					$query = "SELECT * FROM work_offers WHERE professor_id=5 AND has_expired=false";//fere tis diathesimes paroxes
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				<form id="myForm" action="processing_two_buttons.php" method="POST" >
					<div id="demo" ></div>
					<div class="demo_jui" id="demo_jui"></div>
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
					<input class="button" type="submit" name="submit_btn" value="Επεξεργασία"  />
			
				</form>
			</div>
			<div id="tabs-2">
				<?php
					$query = "SELECT * FROM work_offers WHERE professor_id=5 AND has_expired=true";//fere tis diathesimes paroxes
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				<form id="myForm" action="edit_workoffer.php" method="POST" >
					<div id="demo" ></div>
					
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
					<tfoot>
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
					</tfoot>
					</table>
					<div>&nbsp;</div>
					<input type="submit" name="submit_btn" value="Επεξεργασία"  />
			
				</form>
			</div>
	    </div>
		</div>
    </aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>