<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?>
	<link type="text/css" href="jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
	<style type="text/css" title="currentStyle">
		@import "dataTables/css/demo_page.css";
		@import "dataTables/css/demo_table.css";
	</style>
	<script type="text/javascript" language="javascript" src="dataTables/js/jquery.dataTables.js"></script>
		
		
		<script type="text/javascript" charset="utf-8">
		var oTable;
		
		$(document).ready(function(){ 
		/* Init the table */
		oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aoColumns": [
        /* WorkOfferId */{"bVisible": false },
        /* Product */null,
        /* Description */null,
        /* Rating */null,
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
		
		/* Add a click handler to the rows - this could be used as a callback */
		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
		});
		
		$('input:button').click(function()
		{
		var workid = fnGetSelected(oTable);
		if(workid!=null)
		{
			$.post(
			'workapp_form_processing.php',
			{ id : workid },
			function(data)
			{
			  alert(data);
			//$('.spacer').html(data);
			});
		}
		else//δεν έχει επιλέξει κάποια παροχή 
		{
			alert("Πρώτα πρέπει να επιλέξετε μια παροχή έργου");
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
					//aReturn.push( aTrs[i] );
				}
			}
			//return aReturn;
			return null;
		}
		
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
			
			<p>Οι γραμμές με <label class="high">αυτό το χρώμα</label> υποδηλώνουν ότι έχετε κάνει αίτηση στο παρελθόν για τις συγκεκριμένες παροχές</p>
			
			<form name="myForm" >
				<div id="demo" ></div>
				
				<?php
					$query = "SELECT * FROM work_offers WHERE is_available=true AND has_expired=false";//fere tis diathesimes paroxes
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
				?>
				
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
							extract($row);
							$workoffer_id = $id;
							$stud_id = 1;//tha pernei tin timi apo to session['id']
							$query1 = "SELECT * FROM work_applications WHERE user_id='$stud_id' AND work_id='$workoffer_id'";
							$result_set1 = mysql_query($query1,$con);
							confirm_query($result_set1);
							if(mysql_num_rows($result_set1)>0)//iparxei idi kataxwrimeni afti i aitisi
							{
								echo "<tr class = 'high'>";
							}
							else
							{
								echo "<tr>";
							}
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
				<input type="button" name="submit_btn" value="Καταχώρηση"  />
					
			</form>	
			
		</div>
			<div class="spacer"></div>
		

	</aside> 
	</div><!--/content--> 
	 
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
	 
	</div><!--/globalfooter--> 
</body> 
</html>