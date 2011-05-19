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
		//echo $_POST['id'];
		$workoffer_id = $_POST['id'];
		$title = trim($_POST['title']);
		$lesson = trim($_POST['lesson']);
		$candidates = trim($_POST['candidates']);
		$requirements = trim($_POST['requirements']);
		$deliverables = trim($_POST['deliverables']);
		$hours = trim($_POST['hours']);
		$addressed = ($_POST['addressed']);
		$deadline = ($_POST['deadline']);
		if (isset($_POST['at_di']))
			$at_di = ($_POST['at_di'] == "on"  ? 1 : 0);
		else
			$at_di = 0;	
		if (isset($_POST['winter'])) 
			$winter = ($_POST['winter'] == "on" ? 1 : 0);
		else 
			$winter = 0;
		if (isset($_POST['expired'])) 
			$expired = ($_POST['expired'] == "on" ? 1 : 0);
		else 
			$expired = 0;
		
		if (isset($_POST['submit']) && $_POST['submit'] == "Καταχώρηση")
		{
			$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', has_expired = '$expired', addressed_for = '$addressed' WHERE id='$workoffer_id'";
			$result_set = mysql_query($query,$con);
			confirm_query($result_set);
			echo "Οι τροποποιήσεις πραγματοποιήθηκαν με επιτυχία";
			?><p>Πατήστε <a href="workoffer_list.php">εδώ</a> για επιστροφή στον πίνακα των παροχών</p> <?php
		}
		?>
		<?php mysql_close($con); ?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

