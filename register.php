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
$registration = new JFormer('registration', array(
            'submitButtonText' => 'Δημιουργία',
        ));

// Create the form page
$jFormPage1 = new JFormPage($registration->id . 'Page', array(
            'title' => '<h2 style="margin-bottom: 10px;">Δημιουργία λογαρισμού</h2>',
        ));

// Create the form section
$jFormSection1 = new JFormSection($registration->id . 'Section1', array(
        ));

// Create the form section
$jFormSection2 = new JFormSection($registration->id . 'Section2', array(
        ));

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('email', 'E-mail:', array(
        'validationOptions' => array('required', 'email'),
    )),
    new JFormComponentSingleLineText('emailConfirm', 'Επιβεβαίωση e-mail:', array(
        'validationOptions' => array('required', 'email', 'matches' => 'email'),
    )),
    new JFormComponentSingleLineText('password', 'Κωδικός:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password'),
    )),
    new JFormComponentSingleLineText('passwordConfirm', 'Επιβεβαίωση κωδικού:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password', 'matches' => 'password'),
    )),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);

// Set the function for a successful form submission
function onSubmit($formValues) {
	//return array('failureHtml' => json_encode($formValues));
    $email = $formValues->registrationPage->registrationSection1->email;
	$passwd = $formValues->registrationPage->registrationSection1->passwd;
	
	global $con;
	$sql = "select * from users where email = '". mysql_real_escape_string($email) . "'";
	mysql_query($sql, $con) || die('Error: ' . mysql_error());
	$result = mysql_query($sql, $con);
	
	if (mysql_num_rows($result) > 0) {
		$response = array('failureNoticeHtml' => 'Email in use' , 'failureJs' => "$('#password').val('').focus();");
		return $response;
	}
	
    

	
    if ($formValues->registrationPage->registrationSection1->updates[0] == 'signup') {
        $updates = 'yes';
        // type, and detail
        $type = $formValues->registrationPage->registrationSection1->update_type;
        $secondary = '<p>Update Type: ' . $type . '</p>';
        if ($type == 'phone') {
            $secondary .= '<p>Phone Number: ' . $formValues->registrationPage->registrationSection1->phone . '</p>';
        }
    } else {
        $updates = 'no';
    }


    return array(
        'successPageHtml' => '<p></p>
            <p>E-mail: ' . $formValues->registrationPage->registrationSection1->email . '</p>
            <p>Updates</p>
            '.$secondary,
    );
}

// Process any request to the form
$registration->processRequest();


?>

	</aside> 
</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
