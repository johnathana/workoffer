
<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/auth.php');
	global $auth;
?>

<div class="content promos grid2col"> 
	<aside class="column first" id="optimized">
		<div><?php echo $auth->email;?></div>
		<div><p><a href="/account.php">Επεξεργασία</a></p></div>
		<div><p><a href="/logout.php">Αποσύνδεση</a></p></div>
	</aside> 
</div>
