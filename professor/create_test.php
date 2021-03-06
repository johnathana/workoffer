<!DOCTYPE html> 
<html> 
<head> 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
	<style type="text/css" title="currentStyle">
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
	</style>
	
</head> 


<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/jFormer/jformer.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php');
	
	global $auth;
	$user_id = $auth->id;
?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#deadline").datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>

<body id="overview"> 

	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

<?php

// Create the form
$registration = new JFormer('registration', array(
            'submitButtonText' => 'Αποθήκευση',
        ));

// Create the form page
$jFormPage1 = new JFormPage($registration->id . 'Page', array(
            'title' => '<h2 style="margin-bottom: 10px;">Δημιουργία παροχής</h2>',
        ));

// Create the form section
$jFormSection1 = new JFormSection($registration->id . 'Section1', array(
        ));

// Create the form section
$jFormSection2 = new JFormSection($registration->id . 'Section2', array(
        ));

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('title', 'Τίτλος παροχής:', array(
        'validationOptions' => array('required')
    )),
    new JFormComponentSingleLineText('lesson', 'Τίτλος μαθήματος:'),
	new JFormComponentDropDown('candidates', 'Αριθμός υποψηφίων:',
		array(
			array(
				'value' => '1',
				'label' => '1'
			),
			array(
				'value' => '2',
				'label' => '2'
			),
			array(
				'value' => '3',
				'label' => '3'
			),
			array(
				'value' => '4',
				'label' => '4'
			)
		)
	),
	new JFormComponentDropDown('addressed_for', 'Απευθύνεται σε φοιτητή:',
		array(
			array(
				'value' => '0',
				'label' => 'Μη εργαζόμενο'
			),
			array(
				'value' => '1',
				'label' => 'Μερικώς εργαζόμενο'
			),
			array(
				'value' => '2',
				'label' => 'Πλήρως εργαζόμενο'
			),
		)
	),
	new JFormComponentTextArea('requirements', 'Απαιτήσεις γνώσεων:', array(
		'width' => 'medium',
        'height' => 'medium',
        'validationOptions' => array('required'),
	)),
	new JFormComponentTextArea('deliverables', 'Παραδοτέα:', array(
        'width' => 'medium',
        'height' => 'medium',
		'validationOptions' => array('required'),
	)),
	new JFormComponentSingleLineText('hours', 'Απαιτούμενες ώρες υλοποιήσης:', array(
        'validationOptions' => array('required','integer', 'maxLength' => 4),
    )),
	new JFormComponentMultipleChoice('at_di', '',
            array(
                array('value' => '1', 'label' => 'Στο χώρο του πανεπιστημίου'),
    )),
	new JFormComponentMultipleChoice('winter_semester', '',
            array(
                array('value' => '1', 'label' => 'Χειμερινού εξαμήνου'),
    )),
    new JFormComponentSingleLineText('deadline', 'Ημερομηνία λήξης:', array(
        'validationOptions' => array('required')
    )),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);


// Set the function for a successful form submission
function onSubmit($formValues) {
	//return array('failureHtml' => json_encode($formValues->registrationPage->registrationSection1->winter_semester[0]));

	global $con;
	global $auth;
	
	$title = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->title));
	$lesson = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->lesson));
	$candidates = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->candidates));
	$requirements = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->requirements));
	$deliverables = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deliverables));
	$hours = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->hours));
	$addressed = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->addressed_for));
	$at_di = $formValues->registrationPage->registrationSection1->at_di[0];
	$winter_semester = $formValues->registrationPage->registrationSection1->winter_semester[0];
	$deadline = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deadline));
	$year = get_current_year();
	$academic_year_id = $year['id'];
	
	$query = "INSERT INTO work_offers (professor_id, title, lesson, candidates, requirements, deliverables, hours, deadline, at_di, academic_year_id, winter_semester, is_available, has_expired, addressed_for) 
	VALUES ('".$auth->id."','".$title."','".$lesson."','".$candidates."','".$requirements."','".$deliverables."','".$hours."','".$deadline."','".$at_di."','".$academic_year_id."','".$winter_semester."', true, false,'".$addressed."')";
	$result_set = mysql_query($query,$con);
	confirm_query($result_set);

	return array(
		'successPageHtml' => '<h2>Η παροχή καταχωρήθηκε</h2><br>
		<input type="button" name="menu" value="Αρχικό μενού" class="button" onClick="window.location.href=\'/index.php\'"/>'
	);
}

// Process any request to the form
$registration->processRequest();

?>
	<div style="margin: 0px 0px 5px 10px">
		<input type="button" name="menu" value="Ακύρωση" class="button" onClick="window.location.href='/index.php'"/>
	</div>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
