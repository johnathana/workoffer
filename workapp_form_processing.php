	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?> 
<?php 
	if (isset($_POST['id']))
	{
		$workoffer_id = $_POST['id'];
		$stud_id = 1;//tha pernei tin timi apo to session['id']
		$query1 = "SELECT * FROM work_applications WHERE user_id='$stud_id' AND work_id='$workoffer_id'";
		$result_set1 = mysql_query($query1,$con);
		confirm_query($result_set1);
		if(mysql_num_rows($result_set1)>0)//iparxei idi kataxwrimeni afti i aitisi
		{
			echo "Είναι ήδη καταχωρημένη η συγκεκριμένη αίτησή σας!";
			exit();
		}
		$query = "INSERT INTO work_applications (user_id, work_id) values (1, '$workoffer_id')";
		if (!mysql_query($query,$con))
		{
			die('Error: ' . mysql_error());
		}
		echo "Επιτυχής καταχώρηση στη βάση δεδομένων";
	}
	mysql_close($con);
?>

	  
