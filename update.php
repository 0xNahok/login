<?php 


include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 


$id = $_POST['id'];
$email = $_POST['email'];
$password = $_POST['password'];
$hash = $_POST['hash'];



$q = "SELECT * FROM user where id = '$id' ";

if (!$resultado = $mysqli->query($q)) 
{
	$data['error'] = ' DB Error: '.$mysqli->error;
}

if ($resultado->num_rows != 0) 
{		$Link = 'http://'.$_SERVER['HTTP_HOST'].'/login';
	$from = "no-reply@johanmarin.tech";
		$to      = $email; 
		$subject = 'Update | Verification'; 
		$message = '
		
	
		An attempt has been made to make a change to your account, click on the following URL to verify and apply the changes.
		
		
		Please click this link to apply the changes:
		'.$Link.'/updateverify.php?email='.$email.'&hash='.$hash.'&id='.$id.'&password='.$password.'
		
		'; 
		$headers = 'From:'.$from ."\r\n";  
		
        mail($to, $subject, $message, $headers); 
        echo "Sent";
}

 ?>