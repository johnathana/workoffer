<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?>
	<?php require 'form.libs.php'; ?>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

<?php   function get_errors($form_data,$rules){
		//returns an array of errors
		$errors=array();

		//validate each existing input
		foreach($form_data as $name=>$value){
			if(!isset($rules[$name]))continue;
			$hname=htmlspecialchars($name);
			$rule=$rules[$name];

			//make sure that 'required' values are set
			if(isset($rule['required']) && $rule['required'] && !$value)
			$errors[]='Field '.$hname.' is required.';

			$rules[$name]['found']=true;
		}
		//check for missing inputs
		foreach($rules as $name=>$values){
			if(!isset($values['found']) && isset($values['required']) && $values['required'])
			$errors[]='Field '.htmlspecialchars($name).' is required.';
		}
		//return array of errors
		return $errors;
	}
	$errors=get_errors($_POST,$form_rules);
	if(!count($errors)){
	//save the data into the database
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
		
		$year = get_current_year();
		$academic_year_id = $year['id'];
		
		
		$sql="INSERT INTO work_offers (professor_id, title, lesson, candidates, requirements, deliverables, hours, deadline, at_di, academic_year_id, winter_semester, is_available, has_expired, addressed_for)
		VALUES
		(5,'$title','$lesson','$candidates', '$requirements','$deliverables','$hours','$deadline','$at_di','$academic_year_id','$winter',true,'$expired','$addressed')";

		//echo $sql;
		
		if (!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		
		mysql_close($con);

	echo "Επιτυχής καταχώρηση";
	echo '<a href="workoffer_form.php">Επιστροφή στην αρχική φόρμα</a>';
	}
	else{
	echo '<strong>Λάθη που βρέθηκαν στη φόρμα:</strong><ul><li>';
	echo join('</li><li>',$errors);
	echo '</li></ul><p>Διορθώστε τα λάθη και κάντε καταχώρηση!</p>';
	echo '<a href="workoffer_form.php">Επιστροφή στην αρχική φόρμα</a>';
	}
	?> 

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
