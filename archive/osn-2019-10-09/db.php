<?php 
require 'libs/rb.php';

R::setup( 'mysql:host=localhost;dbname=u0796884_123', 'u0796_123', 'EbGeaxRowch0OcO' ); 

if ( !R::testconnection() ) {
	exit ('Нет соединения с базой данных');
}

session_start();
?>