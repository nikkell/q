<?php 
	require 'libs/rb.php';

	R::setup( 'mysql:host=localhost;dbname=u0796884_q', 'u0796_1', 'i~d4O44h' ); 

	if ( !R::testconnection() ) {
		exit ('Нет соединения с базой данных');
	}

	session_start();
?>