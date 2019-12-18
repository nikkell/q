<?php 
	require 'libs/rb.php';

	R::setup( 'mysql:host=localhost;dbname=u0796884_base', 'u0796_base', 'C!b07qu1' ); 

	if ( !R::testconnection() ) {
		exit ('Нет соединения с базой данных');
	}

	session_start();
?>