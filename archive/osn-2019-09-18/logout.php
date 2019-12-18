<?php 
	require 'db.php';
	unset($_SESSION['logged_user']);
	header('Location: /');
?>
<script>
	
window.location = "/";
	</script>