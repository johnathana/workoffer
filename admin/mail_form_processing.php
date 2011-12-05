<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'../includes/head.php');?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'../includes/connection.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'../includes/functions.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'../admin/mail_functions.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'../PEAR/Mail/mime.php'); ?>
	<?php require 'admins_form.libs.php'; ?>
</head> 

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'../includes/header.php');?>

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
		
		echo $mail_username; 
		
       $sender=get_user_mail($mail_username);  //apostoleas
		
		
		if (empty($sender)) 
		{
		echo "Ο χρήστης δεν υπάρχει";
		echo '<a href="mail_form.php">Επιστροφή στη φόρμα αποστολής e-mail</a>';
		}
		else{
		
		//tha ginei apostoli mail
		
		switch ($receivers) {	       
		       case 1:
			    $addresses=select_all_users_mail();
				$recvs = implode(',', $addresses);
               break;
               case 2:
			    $addresses=select_all_professors_mail();
			    $recvs = implode(',', $addresses);
               break;
               case 3:
			    $addresses=select_all_students_mail();
			    $recvs = implode(',', $addresses);
               break;
			   case 4:
			    $addresses=select_all_admins_mail();
			    $recvs = implode(',', $addresses);
               break;
              }
			  
 		//Get Attachment
		//Get the uploaded file information
        $name_of_uploaded_file = basename($_FILES['uploaded_file']['name']);
        $upload_folder = '../upload_folder';
		
        //get the file extension of the file
        $type_of_uploaded_file = substr($name_of_uploaded_file,strrpos($name_of_uploaded_file, '.') + 1);
 
        $size_of_uploaded_file = $_FILES["uploaded_file"]["size"]/1024;//size in KBs
		
		//copy the temp. uploaded file to uploads folder
        $path_of_uploaded_file = $upload_folder . $name_of_uploaded_file;
        $tmp_path = $_FILES["uploaded_file"]["tmp_name"];
 
        if(is_uploaded_file($tmp_path))
          {
           if(!copy($tmp_path,$path_of_uploaded_file))
           {
           $errors .= '\n error while copying the uploaded file';
           }
         }
		 
		$attach = new Mail_mime();
        $attach->addAttachment($path_of_uploaded_file);
        $file = $attach->get();
		//end of attachment proccess
		
			  
			  $to = $recvs . "\r\n";
		      $subject = $mail_subject . "\r\n";
		      $message = $mail_contents . "\r\n";
			  $from = 'From: ' . $sender['name'] . ' ' . $sender['surname'] . " .< ". $sender['email'] . ">\r\n";
		
			  // echo tests
			 /* echo $from;
			  echo $to;
		      echo $subject;
		      echo $message; */
		
		     ini_set('SMTP','mailhost.di.uoa.gr');
		     if (mail($to, $subject, $message, $from, $file)) {
             echo("<p>Το μύνημά σας εστάλθηκε επιτυχώς!</p>");
             } 
		     else {
             echo("<p>Message delivery failed...</p>");
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
	
	