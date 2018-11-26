<?php 

$mysqli = new mysqli("localhost", "root", "", "prueba");

if ($mysqli->connect_errno) 
{
	exit('Fallo al conectarse a MySQL Error: '.$mysqli->connect_error);
}

if (!$mysqli->set_charset('utf8')) 
{
	exit('Fallo al establecer UTF8 Error: '.$mysqli->error);
}