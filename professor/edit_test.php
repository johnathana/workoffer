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

	if(isset($_GET['id']))//exei epilexsei kapoia paroxi
	{
			$workoffer_id = $_GET['id'];
			$query = "SELECT * FROM work_offers WHERE id='$workoffer_id'";
			$result_set = mysql_query($query,$con);
			confirm_query($result_set);
			$row = mysql_fetch_assoc($result_set);
			extract($row);
	}
?>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#title").val("<?php echo $title; ?>");
			$("#lesson").val("<?php echo $lesson; ?>");
			$("[name=candidates]").filter("[value=<?php echo $candidates; ?>]").attr("selected","selected");
			$("[name=addressed]").filter("[value=<?php echo $addressed_for; ?>]").attr("selected","selected");
			$("#requirements").val("<?php echo $requirements; ?>");
			$("#deliverables").val("<?php echo $deliverables; ?>");
			$("#hours").val("<?php echo $hours; ?>");
			<?php if($at_di == true){ ?> $('#at_di').prop('checked', true); <?php } ?>
			<?php if($winter_semester == true){ ?> $('#winter').prop('checked', true); <?php } ?>
			<?php if($has_expired == true){ ?> $('#disable').prop('checked', true); <?php } ?>
			$("#deadline").val("<?php echo $deadline; ?>");
			$( "#deadline" ).datepicker({ dateFormat: 'yy-mm-dd' });
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
            'title' => '<h2 style="margin-bottom: 10px;">Επεξεργασία Παροχής</h2>',
        ));

// Create the form section
$jFormSection1 = new JFormSection($registration->id . 'Section1', array(
        ));

// Create the form section
$jFormSection2 = new JFormSection($registration->id . 'Section2', array(
        ));

// Add components to the section
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentHidden('workoffer_id', '$_GET[\'id\']'),
    new JFormComponentSingleLineText('title', 'Τίτλος παροχής:', array(
        'validationOptions' => array('required')
    )),
    new JFormComponentSingleLineText('lesson', 'Τίτλος μαθήματος:', array(
        'validationOptions' => array('required')
    )),
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
			),
			'validationOptions' => array('required')
	)),
	new JFormComponentDropDown('addressed', 'Απευθύνεται σε φοιτητή:',
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
			'validationOptions' => array('required')
	)),
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
                array('value' => 'true', 'label' => 'Στο χώρο του di'),
    )),
	new JFormComponentMultipleChoice('winter', '',
            array(
                array('value' => 'true', 'label' => 'Χειμερινού εξαμήνου'),
    )),
	new JFormComponentMultipleChoice('disable', '',
            array(
                array('value' => 'true', 'label' => 'Απενεργοποίηση παροχής'),
    )),
	new JFormComponentDate('deadline', 'Ημερομηνία λήξης:', array(
		'validationOptions' => array('required'),
	)),
));

// Add the section to the page
$jFormPage1->addJFormSection($jFormSection1);

// Add the page to the form
$registration->addJFormPage($jFormPage1);


// Set the function for a successful form submission
function onSubmit($formValues) {
// 	return array('failureHtml' => json_encode($formValues));

	global $con;
	
	$id = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->workoffer_id));
	$title  = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->title));
	$lesson = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->lesson));
	$candidates = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->candidates));
	$requirements = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->requirements));
	$deliverables = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deliverables));
	$hours = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->hours));
	$addressed = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->addressed));
	$disable = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->disable));
	$deadline = trim(mysql_real_escape_string($formValues->registrationPage->registrationSection1->deadline));

	$query = "UPDATE work_offers SET title = '$title', lesson = '$lesson', candidates = '$candidates',  requirements = '$requirements', deliverables = '$deliverables', hours = '$hours', deadline = '$deadline', at_di = '$at_di', winter_semester = '$winter', has_expired = '$disable', addressed_for = '$addressed' WHERE id='$id'";
	$result_set = mysql_query($query,$con);
	confirm_query($result_set);

	return array(
		'successPageHtml' => '<script type="text/javascript">window.location.href="/index.php";</script>'
	);
}

// Process any request to the form
$registration->processRequest();

?>
	<div style="margin: 15px">
		<a href="/">Πίσω</a>
	</div>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
