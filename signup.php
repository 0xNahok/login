<?php 


include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 

$data['body'] = 'vista/reg.php';

load_view($data);


 ?>