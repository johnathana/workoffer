<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	<title>Πίνακας παροχών</title>
	<style type="text/css" title="currentStyle">
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
	</style>
	
	<script type="text/javascript" charset="utf-8">
		var oTable;
		
		$(document).ready(function(){ 
		
		$('#myForm').submit(function()
		{
			var workapp_id = (fnGetSelected(oTable));
			
			if (workapp_id != null)//έχει επιλεγεί κάποια παροχή
			{
				return true;
			}
			else//δεν έχει επιλέξει κάποια παροχή 
			{
				alert("Πρέπει πρώτα να επιλέξετε έναν φοιτητή για την ανάθεση");
				return false;
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

	<?php 
			if(isset($_GET['id']))//exei epilexsei kapoia paroxi
			{
					$workoffer_id = $_GET['id'];
					$query = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
					$result_set = mysql_query($query,$con);
					confirm_query($result_set);
					$row = mysql_fetch_assoc($result_set);
					extract($row); ?>
					
					<h3>Επεξεργασία υπάρχουσας παροχής </h3>
					<form action="personal_workoffer_list.php" method="post">
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
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
						<td><input class="button" type="submit" name="submit" value="Καταχώρηση" /></td>
						</tr>
					</table>
					</form>
					
					<?php			
			}
			else//validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποια παροχή!</p>";
				?><p>Επιστροφή στις <a href="personal_workoffer_list.php">παροχές μου</a></p>
				<?php
				
			}
		mysql_close($con);
	 
	?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

