<?php 
	require 'db.php';
	unset($_SESSION['logged_user']);
	header('Location: /q'); // В конечном варианте "/"
?>

<script>	
	window.location = "/q"; // В конечном варианте "/"
</script>