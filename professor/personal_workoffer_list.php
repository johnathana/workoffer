<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	
	<style type="text/css" title="currentStyle">
		@import "../dataTables/css/demo_page.css";
		@import "../dataTables/css/demo_table_jui.css";
		@import "../jquery-ui-1.8.11.custom/css/redmond/jquery-ui-1.8.11.custom.css";
		@import "../media/css/TableTools.css";
	</style>
	<script type="text/javascript" language="javascript" src="../dataTables/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" language="javascript" src="../media/js/TableTools.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		
		var oTable;
		
		$(document).ready(function(){ 
		/* Init the table */
		oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"sScrollX": "100%",
			//"sScrollXInner": "850px",
			"bScrollCollapse": true,
			"aoColumns": [
					/* WorkOfferId */{"bVisible": false },
					/* Professor */null,
					/* Title */null,
					/* Lesson */null,
					/* Candidates */null,
					/* Requirements*/null,
					/* Deliverables */null,
					/* Hours */null,
					/* Deadline */null,
					/* At_di */null,
					/* Acad_year */null,
					/* Winter */null,
					/* Addressed */null
			]
		});
		
		var oTableTools = new TableTools( oTable, {
			"sSwfPath": "../media/swf/copy_cvs_xls_pdf.swf"
        } );
		
		$('#demo_jui').before( oTableTools.dom.container );		
		
		/* Add a click handler to the rows - this could be used as a callback */
		$("#example tbody").click(function(event) {
			$(oTable.fnSettings().aoData).each(function (){
				$(this.nTr).removeClass('row_selected');
			});
			$(event.target.parentNode).addClass('row_selected');
			var workid = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+workid+'"/>';
			$('#demo').html(str);
		});
		
		}); 
		function radio_click()
		{
			
			if($('input[name=myradio]:checked').val() == "live")
			{
				window.location.href="personal_workoffer_list.php?check=live";
			}
			else
				window.location.href="personal_workoffer_list.php?check=notlive"; 
		}
		function check_redirect1()
		{
			var workid = (fnGetSelected(oTable));
			
			if (workid == null)//δεν έχει επιλέξει κάποια παροχή
			{
				alert("Πρέπει πρώτα να επιλέξετε μια παροχή έργου");
				return false;
			}
			else //έχει επιλεγεί κάποια παροχή
			{
				window.location.href="edit_workoffer.php?id="+workid+"";
			}
		}
		function check_redirect2()
		{
			var workid = (fnGetSelected(oTable));
			
			if (workid == null)//δεν έχει επιλέξει κάποια παροχή
			{
				alert("Πρέπει πρώτα να επιλέξετε μια παροχή έργου");
				return false;
			}
			else //έχει επιλεγεί κάποια παροχή
			{
				window.location.href="show_apps.php?id="+workid+"";
			}
		}
		function redirect_create()
		{
			window.location.href = "/professor/create_workoffer.php";
		}
		/* Get the rows which are currently selected */
		function fnGetSelected( oTableLocal )
		{
			var aReturn = new Array();
			var aTrs = oTableLocal.fnGetNodes();
			
			for ( var i=0 ; i<aTrs.length ; i++ )
			{
				if ( $(aTrs[i]).hasClass('row_selected') )
				{
					var aRowData = new Array();
					aRowData = oTable.fnGetData(aTrs[i]);

					return aRowData[0];
				}
			}
			return null;
		}

	</script>
</head> 

<body id="overview"> 
	
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>


	<div id="globalfooter"> 

	<div class="content promos grid2col"> 
		<aside class="column first" id="optimized">

	<?php	
		if (isset($_POST['id']))//exei ginei edit i paroxi kai twra kanoume update sti vasi prin ti fortwsi tou pinaka
		{
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
			}
		}
	?>
		<div id="container">
			<div class="full_width big">
				<i>Πίνακας Παροχών</i> 
			</div>

			<p>Επιλέξτε μια παροχή και στη συνέχεια πατήστε επεξεργασία για τροποποίηση της συγκεκριμένης παροχής ή επιλέξτε αιτήσεις για να δείτε τις αιτήσεις των φοιτητών</p>
			<form id="myForm"  method="POST" >
				<div id="demo" ></div>
				<div class="demo_jui" id="demo_jui">
				
				<?php   
				if (isset($_GET['check']) && $_GET['check'] == "notlive"){  ?>
				<table style="width: 150px">
				<tr>
					<td><label><h4>Ενεργές παροχές</h4></td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="live" /></label></td>
				</tr>
				<tr>
					<td><label><h4>Ανενεργές παροχές</h4></td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="dead" checked="true" /></label></td>
				</tr>
				</table>
				<?php
					switch ($auth->is_admin) {
					case "0":
						die("Unauthorized access");
					case "1":
						$query = "SELECT * FROM work_offers WHERE has_expired = true";//fere tis anenerges paroxes olwn twn kathigitwn 
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					case "2":
						$qr = "SELECT id FROM users WHERE email = '".$auth->email."'";
						$set = mysql_query($qr,$con);
						confirm_query($set);
						$row = mysql_fetch_assoc($set);
						$query = "SELECT * FROM work_offers WHERE professor_id = '".$row['id']."' AND has_expired = true";//fere tis anenerges paroxes enos kathigiti
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					}
				}
				else { 
				?>
				<table style="width: 150px">
				<tr>
					<td><label><h4>Ενεργές παροχές</h4></td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="live" checked="true" /></label></td>
				</tr>
				<tr>
					<td><label><h4>Ανενεργές παροχές</h4></td>
					<td><input type="radio" name="myradio" onClick="radio_click();" value="dead"  /></label></td>
				</tr>
				</table>
				<?php
					switch ($auth->is_admin) {
					case "0":
						die("Unauthorized access");
					case "1":
						$query = "SELECT * FROM work_offers WHERE has_expired = false";//fere tis energes paroxes olwn twn kathigitwn 
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					case "2":
						$qr = "SELECT id FROM users WHERE email = '".$auth->email."'";
						$set = mysql_query($qr,$con);
						confirm_query($set);
						$row = mysql_fetch_assoc($set);
						$query = "SELECT * FROM work_offers WHERE professor_id = '".$row['id']."' AND has_expired = false";//fere tis anenerges paroxes enos kathigiti
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						break;
					}
				}
				?>
				
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
				<thead>
					<tr>
						<th>ID παροχής</th>
						<th>Καθηγητής</th>
						<th>Τίτλος παροχής</th>
						<th>Τίτλος μαθήματος</th>
						<th>Αριθμός υποψηφίων</th>
						<th>Απαιτήσεις γνώσεων</th>
						<th>Παραδοτέα </th>
						<th>Απαιτούμενες ώρες υλοποίησης</th>
						<th>Λήξη προθεσμίας</th>
						<th>Στο χώρο του di</th>
						<th>Ακαδημαϊκό έτος</th>
						<th>Χειμερινού εξαμήνου</th>
						<th>Απευθύνεται σε φοιτητή</th>
					</tr>
				</thead>
				<tbody>	
				<?php	while($row = mysql_fetch_assoc($result_set))
						{
							echo "<tr>";
							extract($row);
							if($addressed_for==0)
								{$student_type="Μη εργαζόμενο";}
							elseif($addressed_for==1)
								{$student_type="Μερικώς εργαζόμενο";}
							else
								{$student_type="Πλήρως εργαζόμενο";}
							/*Βρίσκουμε τις τιμές που θέλουμε μέσω των ξένων κλειδιών*/
							$row1 = get_surname_from_professor_id($professor_id);
							$row2 = get_ayear_from_academic_year_id($academic_year_id);
							echo "<td>$id</td><td>$row1[surname]</td>
								<td>$title</td><td>$lesson</td><td>$candidates</td><td>$requirements</td><td>$deliverables</td>
								<td>$hours</td><td>$deadline</td><td>";
							if($at_di==false)
								echo "<input type='checkbox' disabled='true'>";
							else
								echo"<input type='checkbox' disabled='true' checked='true'>";
							echo "</td><td>$row2[ayear]</td><td>";
							if($winter_semester==false)
								echo "<input type='checkbox' disabled='true'>";
							else
								echo"<input type='checkbox' disabled='true' checked='true'>";
							echo"</td><td>$student_type</td>";
							echo "</tr>";
						}			
				?>	
				</tbody>
				</table>
				
				<br />
				<p>
					<input class="button" type="button" id="edit_btn" onClick="redirect_create();" value="Δημιουργία"  />
					<input class="button" type="button" id="edit_btn" onClick="check_redirect1();" value="Επεξεργασία"  />
					<input class="button" type="button" id="apps_btn" onClick="check_redirect2();" value="Αιτήσεις για αυτήν την παροχή"  />
				</p>
				</div>
			</form>	
				
			<div class="spacer"></div>
		</div>
	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 
