<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	<title>Πίνακας παροχών</title>
	<link type="text/css" href="jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css" rel="Stylesheet" />
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
<?php 
	if (isset($_POST['workoffer_id']))//einai to hidden input
	{
		if (isset($_POST['id']))
		{
			$workoffer_id = $_POST['workoffer_id'];
			$workapp_id = $_POST['id'];
			
			$query1 = "SELECT candidates FROM work_offers WHERE id='$workoffer_id'";
			$result_set1 = mysql_query($query1,$con);
			confirm_query($result_set1);
			$row = mysql_fetch_assoc($result_set1);
			$max_candidates = $row['candidates'];
			
			
			$query2 = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id' AND accepted = '1'";
			$workapps = mysql_query($query2,$con);
			confirm_query($workapps);
			if (mysql_num_rows($workapps) == $max_candidates)
			{
				echo "Δεν μπορεί να γίνει η παραπάνω ανάθεση"."<br />";
				echo "Ο μέγιστος επιτρεπόμενος αριθμός φοιτητών είναι $max_candidates και τους έχετε ήδη επιλέξει";
			}
			else
			{
				$query = "UPDATE work_applications SET accepted = '1' WHERE id='$workapp_id'";
				$result_set = mysql_query($query,$con);
				confirm_query($result_set);
				if(mysql_affected_rows() > 0)
					echo "Επιτυχής καταχώρηση στη βάση δεδομένων";
				$query3 = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id' AND accepted = '1'";
				$workapps = mysql_query($query3,$con);
				confirm_query($workapps);
				if (mysql_num_rows($workapps) == $max_candidates)
				{
					$que = "UPDATE work_offers SET is_available = '0' WHERE id='$workoffer_id'";
					$result_set = mysql_query($que,$con);
					confirm_query($result_set);
				}				
			}
			/*Ta parakatv hidden elements ta xreiazomai gia na fortwsei o pinakas me tis aitiseis sto processing_two_buttons*/
			?>
			<form action="processing_two_buttons.php" method="POST">
			<input type='hidden' name='sent' value='yes' />
			<input type='hidden' name='id' value='<?php echo $_POST['workoffer_id'];?>' />
			<input type='hidden' name='submit_btn' value='Αιτήσεις για αυτήν την παροχή' />
			<label>Πατήστε το παρακάτω κουμπί για επιστροφή στον πίνακα με τις αιτήσεις των φοιτητών <input class="button" type="submit" name="btn" value="Πίνακας αιτήσεων" /></label>
			</form>
			<?php
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