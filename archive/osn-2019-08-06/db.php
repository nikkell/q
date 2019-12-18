<?php 
require 'libs/rb.php';
R::setup( 'mysql:host=localhost;dbname=nikkill_users','root', '' ); 

if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}

session_start();