<?php  
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
<?php
	if(isset($_POST['id']))
	{
		$workapp_id = $_POST['id'];
		$query = "SELECT user_id FROM work_applications WHERE id = '$workapp_id'";
		$res = mysql_query($query,$con);
		confirm_query($res);
		$row = mysql_fetch_assoc($res);
		$user_id = $row['user_id'];
		$query1 = "SELECT work_id FROM work_applications WHERE user_id = '$user_id'";
		$res1 = mysql_query($query1,$con);
		confirm_query($res1);
		echo "Ο φοιτητής έχει κάνει αίτηση στις εξής παροχές:"."<br />";
		while($row = mysql_fetch_assoc($res1))
		{
			$work_id = $row['work_id'];
			$query2 = "SELECT title FROM work_offers WHERE id = '$work_id'";
			$res2 = mysql_query($query2,$con);
			confirm_query($res2);
			$row1 = mysql_fetch_assoc($res2);
			$title = $row1['title'];
			echo "$title"."<br />";
		}
		$query1 = "SELECT work_id FROM work_applications WHERE user_id = '$user_id' AND accepted = true";
		$res1 = mysql_query($query1,$con);
		confirm_query($res1);
		if(mysql_num_rows($res1) > 0)
		{
			echo "Ο φοιτητής έχει γίνει δεκτός στις εξής παροχές:\n";
			$total_hours = 0;
			while($row = mysql_fetch_assoc($res1))
			{
				$work_id = $row['work_id'];
				$query2 = "SELECT title, hours FROM work_offers WHERE id = '$work_id'";
				$res2 = mysql_query($query2,$con);
				confirm_query($res2);
				$row1 = mysql_fetch_assoc($res2);
				extract($row1);
				echo "$title"."<br />";
				$total_hours+=$hours;
			}
			echo "Ο φοιτητής έχει εξασφαλίσει ".$total_hours." ώρες παροχής έργου.";
		}
		else
			echo "Δεν έχει γίνει δεκτός σε κάποια παροχή.\n";
	}
?>