<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mail_functions.php'); ?>
	<?php require 'mail_form.libs.php'; ?>
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
	$errors=get_errors($_POST,$mail_form_rules);
	
	if(count($errors)){
	echo '<strong>Λάθη που βρέθηκαν στη φόρμα:</strong><ul><li>';
	echo join('</li><li>',$errors);
	echo '</li></ul><p>Διορθώστε τα λάθη και κάντε αποστολή!</p>';
	echo '<a href="mail_form.php">Επιστροφή στη φόρμα αποστολής e-mail</a>';
	}
	else {
	echo '<strong>Αποστολή e-mail</strong><ul><li>';
	// send mail
	// get from data
	    $mail_username = trim($_POST['mail_username']);
		$receivers = trim($_POST['receivers']);
		$mail_subject = trim($_POST['mail_subject']);
		$mail_contents = trim($_POST['mail_contents']);
		
		//echo $mail_username;
		
       $from=get_user_mail($mail_username);  //apostoleas
		
		//print_r($from);
		echo $from["name"];
		
		if (empty($from)) 
		{
		echo "Ο χρήστης δεν υπάρχει";
		echo '<a href="mail_form.php">Επιστροφή στη φόρμα αποστολής e-mail</a>';
		}
		else{
		echo " tha steilei mail";
		
		switch ($receivers) {
		       case 1:
			    $to=select_all_users_mail();
				print_r($to);
              //  echo $to["email"];
               break;
               case 2:
                echo "i equals 1";
               break;
               case 2:
                echo "i equals 2";
               break;
              }
		
		}
		
	
	}
	
	?> 

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
	
	