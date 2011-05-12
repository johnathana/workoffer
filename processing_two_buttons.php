<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?>
	<title>Πίνακας παροχών</title>
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
        /* WorkAppId */{"bVisible": false },
        /* Product */null,
        /* Description */null,
        /* Rating */null,
        /* Price */null,
		/* Product */null,
        /* Description */null,
        /* Rating */null,
		/* Product */null,
        ]
		});
		
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

	<?php 
		if (isset($_POST['sent']) && $_POST['sent'] == "yes")//exei metavei se aftin tin selida apo to workoffer_list
		{
			if(isset($_POST['id']))//exei epilexsei kapoia paroxi
			{
				if($_POST['submit_btn'] == "Επεξεργασία")//patithike to button tis epexsergasias
				{
					$workoffer_id = $_POST['id'];
					$query = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
					$row = mysql_fetch_assoc($result_set);
					extract($row); ?>
					
					<h3>Επεξεργασία υπάρχουσας παροχής </h3>
					<form action="workoffer_update.php" method="post">
					<input type="hidden" name="id" value="<?php echo $_POST['id'];?>" />
					<table>
						<tr>
							<td>Τίτλος παροχής</td><td><input type="text" name="title" value="<?php echo $title;?>" /></td>
						</tr>
						<tr>
							<td>Τίτλος μαθήματος</td><td><input type="text" name="lesson" value="<?php echo $lesson;?>" /></td>
						</tr>
						<tr>
							<td>Αριθμός υποψηφίων</td>
							<td><select name="candidates">
							<?php for($i=1;$i<5;$i++)
									{
										?><option value="<?php echo $i; ?>"<?php if ($candidates == $i) { ?> selected="selected"<?php } ?>><?php echo $i; ?></option><?php
									}
							?>
							</select></td>
						</tr>
						<tr>
							<td>Απευθύνεται σε φοιτητή</td><td><select name="addressed">
							  <option value="0" <?php if ($addressed_for == 0) { ?> selected="selected"<?php } ?> >Μη εργαζόμενο</option>
							  <option value="1" <?php if ($addressed_for == 1) { ?> selected="selected"<?php } ?> >Μερικώς εργαζόμενο</option>
							  <option value="2" <?php if ($addressed_for == 2) { ?> selected="selected"<?php } ?> >Πλήρως εργαζόμενο</option>
							</select></td>
						</tr>
						<tr>
							<td>Απαιτήσεις γνώσεων</td><td> <textarea name="requirements" cols="40" rows="3" ><?php echo $requirements; ?></textarea></td>
						</tr>
						<tr>
						<td>Παραδοτέα</td><td> <textarea name="deliverables" cols="40" rows="3" ><?php echo $deliverables; ?></textarea></td>
						</tr>
						<tr>
						<td>Απαιτούμενες ώρες υλοποίησης</td><td> <input type="text" name="hours" value="<?php echo $hours; ?>"/></td>
						</tr>
						<tr>
						<td>Στο χώρο του di</td><td> <input type="checkbox" name="at_di" <?php if($at_di==true) echo "checked='true'"; ?>  /></td>
						</tr>
						<tr>
						<td>Χειμερινού εξαμήνου</td><td> <input type="checkbox" name="winter" <?php if($winter_semester==true) echo "checked='true'"; ?> /></td>
						</tr>
						<tr>
						<td>Απενεργοποίηση παροχής</td><td> <input type="checkbox" name="expired"  /></td>
						</tr>
						<tr>
						<td><p>Ημερομηνία λήξης</p></td><td><p><input id="deadline" name="deadline" type="text" value="<?php echo $deadline?>"></p></td>
						</tr>
						<tr>
						<td><input type="submit" name="submit" value="Καταχώρηση" /></td>
						</tr>
					</table>
					</form>
					
					<?php
				}
				else//patithike to button gia tin emfanisi tvn aitisevn gia aftin tin paroxi
				{
					$workid = $_POST['id'];
					$query = "SELECT * FROM work_applications WHERE work_id = '$workid'";
					$workapps = mysql_query("$query",$con);
					confirm_query($workapps);?>
					<div id="container">
						<form id="myForm" action="assign.php" method="POST" >
						<div id="demo" ></div>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
							<thead>
								<tr>
									<th>ID αίτησης</th>
									<th>Ημερ/νια αίτησης</th>
									<th>Του/Της έχει ανατεθεί</th>
									<th>Όνομα</th>
									<th>Επίθετο</th>
									<th>Αριθμός μητρώου</th>
									<th>Email</th>
									<th>Βιογραφικό</th>
									<th>Τηλέφωνο</th>
								</tr>
							</thead>
							<tbody>	
						<?php
						while($row = mysql_fetch_assoc($workapps))
						{
							extract($row);
							$info = get_user_info($user_id);
							if($accepted == 1)
								$accepted = "ΝΑΙ";
							else
								$accepted = "ΟΧΙ";
							echo "<tr>";	
							echo "<td>$id</td><td>$applied</td><td>$accepted</td><td>$info[name]</td><td>$info[surname]</td><td>$info[reg_numb]</td><td>$info[email]</td><td>$info[cv]</td><td>$info[phone]</td>";
							echo "</tr>";
						}
						?>
							</tbody>
							<tfoot>
							<tr>
								<th>ID αίτησης</th>
								<th>Ημερ/νια αίτησης</th>
								<th>Του/Της έχει ανατεθεί</th>
								<th>Όνομα</th>
								<th>Επίθετο</th>
								<th>Αριθμός μητρώου</th>
								<th>Email</th>
								<th>Βιογραφικό</th>
								<th>Τηλέφωνο</th>
							</tr>
							</tfoot>
							</table>
							
							<div>&nbsp;</div>
							<div>&nbsp;</div>
							<p><input type="submit" name="submit_btn" value="Ανάθεση παροχής στο φοιτητή"  />
						</form>
					</div>
					<?php
				}
			}
			else//validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποια παροχή!</p>";
				//header("Location: workoffer_list.php");
			}
		}
		mysql_close($con);
	 
	?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

