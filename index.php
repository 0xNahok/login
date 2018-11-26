<?php
include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 

$data['body'] = 'vista/index.php';

if(!isset($_SESSION['userdata']))
{
	header("Location: signin.php");
}

$UserdID=$_SESSION['userdata']['id'];


$q = "SELECT * FROM login_attempt where id_user = '$UserdID' ";

if (!$resultado = $mysqli->query($q)) 
{
	$data['error'] = 'DB Error: '.$mysqli->error;
}

if ($resultado->num_rows == 0) 
{
	$data['error'] = 'No Record';
}

while ($row = $resultado->fetch_assoc()) 
{
	$data['Attempt'][] = $row;
}


load_view($data);

?>