<?php 


include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 

$data['body'] = 'vista/login.php';

load_view($data);

 ?>