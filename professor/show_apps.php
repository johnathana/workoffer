<!DOCTYPE html> 
<html> 
<head>
	<?php 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); 
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'); 
	 ?>
	<title>Πίνακας παροχών</title>
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
        /* WorkAppId */{"bVisible": false },
        /* Applied */null,
        /* Accepted */null,
        /* Name */null,
        /* Surname */null,
		/* A.M. */null,
        /* Email */null,
        /* CV */null,
		/* Phone */null,
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
			var workapp_id = (fnGetSelected(oTable));
			var str = '<input type="hidden" name="id" value="'+workapp_id+'"/>';
			$('#demo').html(str);
		});
		
		$('#myForm').submit(function()
		{
			var workapp_id = (fnGetSelected(oTable));
			
			if (workapp_id != null)//έχει επιλεγεί κάποιος φοιτητής
			{
				return true;
			}
			else//δεν έχει επιλέξει κάποιο φοιτητή
			{
				alert("Πρέπει πρώτα να επιλέξετε έναν φοιτητή για την ανάθεση");
				return false;
			}
		});
		
		$('input[name=back]').click(function()
		{
			window.location.href="personal_workoffer_list.php";
		});
		
		$('input[name=btn]').click(function()
		{
		var userid = fnGetSelected(oTable);
		if(userid!=null)
		{
			$( "#dialog:ui-dialog" ).dialog( "destroy" );

			$.post('user_processing.php',{ id : userid },
			function(data)
			{
			  $("#dialog-message").html(data);
			});

			$( "#dialog-message" ).dialog({
					modal: true,
					buttons: {
							Ok: function() {
									$( this ).dialog( "close" );
							}
					}
			});	
		}
		else//δεν έχει επιλέξει κάποια παροχή 
		{
			alert("Πρώτα πρέπει να επιλέξετε μια παροχή έργου");
		}
		});
		
		}); 
		
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
		<div id="dialog-message" title="Πληροφορίες φοιτητή" hidden></div>

	<?php 
		
			if(isset($_GET['id']))//exei epilexsei kapoia paroxi apo to personal workoffer list
			{
				$workid = $_GET['id'];
				$query1 = "SELECT is_available, title FROM work_offers WHERE id = '$workid'";
				$res = mysql_query($query1,$con);
				confirm_query($res);
				$row = mysql_fetch_assoc($res);
				echo "Παρακάτω φαίνεται ο πίνακας με τις αιτήσεις των φοιτητών για την παροχή με τίτλο ".$row['title'];
				if($row['is_available'] == 0)
					echo "Η παροχή δεν είναι διαθέσιμη για ανάθεση"."<br />";
				
				$query = "SELECT * FROM work_applications WHERE work_id = '$workid'";
				$workapps = mysql_query($query,$con);
				confirm_query($workapps);?>
				<div id="container">
					<form id="myForm" action="show_apps.php" method="POST" >
					<input type="hidden" name="workoffer_id" value="<?php echo $_GET['id'];?>" />
					<div id="demo" ></div>
					<div class="demo_jui" id="demo_jui"></div>
						<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
						<thead>
							<tr>
								<th>ID αίτησης</th>
								<th>Ημερ/νια αίτησης</th>
								<th>Του/Της έχει ανατεθεί</th>
								<th>Όνομα</th>
								<th>Επίθετο</th>
								<th>Αριθμός μητρώου</th>
								<th>Email</th>
								<th>Βιογραφικό</th>
								<th>Τηλέφωνο</th>
							</tr>
						</thead>
						<tbody>	
					<?php
					while($row = mysql_fetch_assoc($workapps))
					{
						extract($row);
						$info = get_user_info($user_id);
						if($accepted == 1)
							$accepted = "ΝΑΙ";
						else
							$accepted = "ΟΧΙ";
						echo "<tr>";	
						echo "<td>$id</td><td>$applied</td><td>$accepted</td><td>$info[name]</td><td>$info[surname]</td><td>$info[reg_numb]</td><td>$info[email]</td><td>$info[cv]</td><td>$info[phone]</td>";
						echo "</tr>";
					}
					?>
						</tbody>
						</table>
						<br />
						<p><input class="button" type="button" name="back" value="Πίσω"  />
						<input class="button" type="submit" name="submit_btn" value="Ανάθεση παροχής στο φοιτητή"  />
						<input class="button" type="button" name="btn" value="Πληροφορίες"  /></p>
						
					</form>
					<a href="personal_workoffer_list.php">Πίσω στις παροχές μου</a>
				</div>
				<?php		
			}
			
			elseif (isset($_POST['workoffer_id']))//to id ths work-offer
			{
				if (isset($_POST['id']))//to id ths work-application
				{
					$workoffer_id = $_POST['workoffer_id'];
					$workapp_id = $_POST['id'];
					
					$query1 = "SELECT candidates FROM work_offers WHERE id='$workoffer_id'";
					$result_set1 = mysql_query($query1,$con);
					confirm_query($result_set1);
					$row = mysql_fetch_assoc($result_set1);
					$max_candidates = $row['candidates'];
					
					$query2 = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id' AND accepted = '1'";
					$workapps = mysql_query($query2,$con);
					confirm_query($workapps);
					if (mysql_num_rows($workapps) >= $max_candidates)
					{
						echo "Δεν μπορεί να γίνει η παραπάνω ανάθεση"."<br />";
						echo "Ο μέγιστος επιτρεπόμενος αριθμός φοιτητών είναι $max_candidates και τους έχετε ήδη επιλέξει"."<br />";
					}
					else
					{
						$query = "UPDATE work_applications SET accepted = '1' WHERE id='$workapp_id'";
						$result_set = mysql_query($query,$con);
						confirm_query($result_set);
						if(mysql_affected_rows() > 0)
							echo "Επιτυχής καταχώρηση στη βάση δεδομένων";
						$query3 = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id' AND accepted = '1'";
						$workapps = mysql_query($query3,$con);
						confirm_query($workapps);
						if (mysql_num_rows($workapps) == $max_candidates)
						{
							$que = "UPDATE work_offers SET is_available = '0' WHERE id='$workoffer_id'";
							$result_set = mysql_query($que,$con);
							confirm_query($result_set);
						}				
					}
					//$workid = $_GET['id'];
					$query1 = "SELECT is_available, title FROM work_offers WHERE id = '$workoffer_id'";
					$res = mysql_query($query1,$con);
					confirm_query($res);
					$row = mysql_fetch_assoc($res);
					echo "Παρακάτω φαίνεται ο πίνακας με τις αιτήσεις των φοιτητών για την παροχή με τίτλο ".$row['title'];
					//if($row['is_available'] == 0)
						//echo "Η παροχή έχει ήδη ανατεθεί στον μέγιστο επιτρεπόμενο αριθμό φοιτητών"."<br />";
					
					$query = "SELECT * FROM work_applications WHERE work_id = '$workoffer_id'";
					$workapps = mysql_query($query,$con);
					confirm_query($workapps);?>
					<div id="container">
						<form id="myForm" action="show_apps.php" method="POST" >
						<input type="hidden" name="workoffer_id" value="<?php echo $_POST['workoffer_id'];?>" />
						<div id="demo" ></div>
						<div class="demo_jui" id="demo_jui"></div>
							<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" >
							<thead>
								<tr>
									<th>ID αίτησης</th>
									<th>Ημερ/νια αίτησης</th>
									<th>Του/Της έχει ανατεθεί</th>
									<th>Όνομα</th>
									<th>Επίθετο</th>
									<th>Αριθμός μητρώου</th>
									<th>Email</th>
									<th>Βιογραφικό</th>
									<th>Τηλέφωνο</th>
								</tr>
							</thead>
							<tbody>	
						<?php
						while($row = mysql_fetch_assoc($workapps))
						{
							extract($row);
							$info = get_user_info($user_id);
							if($accepted == 1)
								$accepted = "ΝΑΙ";
							else
								$accepted = "ΟΧΙ";
							echo "<tr>";	
							echo "<td>$id</td><td>$applied</td><td>$accepted</td><td>$info[name]</td><td>$info[surname]</td><td>$info[reg_numb]</td><td>$info[email]</td><td>$info[cv]</td><td>$info[phone]</td>";
							echo "</tr>";
						}
						?>
							</tbody>
							</table>
							<br />
							<p><input class="button" type="button" name="back" value="Πίσω"  />
							<input class="button" type="submit" name="submit_btn" value="Ανάθεση παροχής στο φοιτητή"  />
							<input class="button" type="button" name="btn" value="Πληροφορίες"  /></p>
						
						</form>
						<a href="personal_workoffer_list.php">Πίσω στις παροχές μου</a>
					</div><?php
				}
			}
			else//validation
			{
				echo "<p>Δεν έχετε επιλέξει κάποια παροχή!</p>";
				?><p>Επιστροφή στις <a href="personal_workoffer_list.php">παροχές μου</a></p>
				<?php
			}
		
		mysql_close($con);
	 
	?>

	</aside> 
	</div><!--/content--> 
 
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
 
	</div><!--/globalfooter--> 
</body> 
</html> 

