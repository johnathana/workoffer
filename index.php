<!DOCTYPE html> 
<html> 
<head>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php');
?>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">
		   

<?php

// Create the form
$login = new JFormer('loginForm', array(
    'submitButtonText' => 'Είσοδος',
));

// Create the form page
$jFormPage1 = new JFormPage($login->id.'Page', array(
    'title' => '<h2 style="margin-bottom: 10px;">Σύνδεση</h2>',
));

// Create the form section
$jFormSection1 = new JFormSection($login->id.'Section', array());

// Check to see if the remember me checkbox should be checked by default

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('email', 'Email:', array(
        'validationOptions' => array('required', 'email'),
        'tip' => '<p>Παρακαλώ πληκρολογήστε το <b>email</b> σας</p>',
    )),

    new JFormComponentSingleLineText('password', 'Κωδικός:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password'),
        'tip' => '<p>Παρακαλώ πληκρολογήστε το <b>password</b> σας</p>',
    )),

    new JFormComponentMultipleChoice('rememberMe', '', 
        array(
            array('value' => 'remember', 'label' => 'Διατήρηση σύνδεσης σε αυτόν τον υπολογιστή'),
        ),
        array(
        'tip' => '<p></p>',
        )
    ),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$login->addJFormPage($jFormPage1);

// Set the function for a successful form submission
function onSubmit($formValues) {
    $formValues = $formValues->loginFormPage->loginFormSection;

    echo $formValues->email . " ". $formValues->password;
	
	global $con;	
	$sql = "select * from users where email = '". mysql_real_escape_string($formValues->email) . "'";
		
    mysql_query($sql, $con) || die('Error: ' . mysql_error());
	
	$result = mysql_query($sql, $con);

	$row = mysql_fetch_array($result);
	
    if($formValues->email == $row['email'] && sha1($formValues->password) == $row['passwd'] ) {
        if(!empty($formValues->rememberMe)) {
            $response = array('successPageHtml' => '<p>Login Successful</p><p>We\'ll keep you logged in on this computer.</p>');
        }
        else {
            $response = array('successPageHtml' => '<p>Login Successful</p><p>We won\'t keep you logged in on this computer.</p>');
        }
    }
    else {
        $response = array('failureNoticeHtml' => 'Invalid username or password.' , 'failureJs' => "$('#password').val('').focus();");
    }
	
	mysql_close($con);
	
    return $response;
}

// Process any request to the form
$login->processRequest();

?>
	<div style="margin: 15px"><a href="register.php">Δημιουργία λογαρισμού</a></div>
	</aside> 
</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
