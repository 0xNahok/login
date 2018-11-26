<?php 

include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start();
$email = $_REQUEST['email'];
$pass = $_REQUEST['password'];
$repass = $_REQUEST['repassword'];

$legit = true;

if ($email == '') 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'You must write a email.');
	header("Location: signup.php");
	$legit = false;
	exit();
}

if ($pass == '') 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'You must write a password.');
	header("Location: signup.php");
	$legit = false;
	exit();
}


if (strlen($pass) < 5 OR strlen($pass) > 15) 
{	
		
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Password must be between 5 and 15 characters long');
	header("Location: signup.php");
	$legit = false;
	exit();
}

if ( regex_check('/[^a-zA-Z0-9]/', $pass)) 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Only alphanumeric characters are allowed.');
	header("Location: signup.php");
	$legit = false;
	exit();
}

if ($pass != $repass) 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>"Passwords don't match");
	header("Location: signup.php");
	$legit = false;
	exit();
}

$query = "SELECT COUNT(1) as count FROM user WHERE email = '{$email}';";

if (!$result = $mysqli->query($query)) 
{
	
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Problems in the database.');
	header("Location: signup.php");
	$legit = false;
	exit();
}

if ($row = $result->fetch_assoc())
{

	if ($row['count'] > 0) 
	{
		$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Email used');
	header("Location: signup.php");
	$legit = false;
	exit();
		
	}
}
else
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Problems in the database.');
	header("Location: signup.php");
	$legit = false;
	exit();

}

if($legit){
	$hash = md5( rand(0,1000) ); 
	$UserIP= getUserIP();

	$q = "INSERT INTO user (email, password, hash) values ('{$email}','{$pass}','{$hash}')";

			if (!$mysqli->query($q)) 
		{
			$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Problems in the database.');
			header("Location: signup.php");
		}
		$Link = 'http://'.$_SERVER['HTTP_HOST'].'/login';

		$from = "no-reply@johanmarin.tech";
		$to      = $email; 
		$subject = 'Signup | Verification'; 
		$message = '
		
		Thanks for signing up!
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
		
		------------------------
		Username: '.$email.'
		Password: '.$pass.'
		------------------------
		
		Please click this link to activate your account:
		'.$Link.'/verify.php?email='.$email.'&hash='.$hash.'
		
		'; 
		$headers = 'From:'.$from ."\r\n"; 
		
		mail($to, $subject, $message, $headers); 
		//Select the last User register

$queryU = "SELECT * FROM user WHERE email = '$email' ORDER BY id DESC LIMIT 1";


if (!$resultado = $mysqli->query($queryU)) 
{
  $data['error'] = ' DB Error: '.$mysqli->error;
}

if ($resultado->num_rows == 0) 
{
  $data['error'] = 'No Record';
}

while ($row = $resultado->fetch_assoc()) 
{
  $data['User'][] = $row;

}
$UserId = $data['User'][0]['id'];

$queryIP = "INSERT INTO tip (ip, UserID) values ('{$UserIP}','{$UserId}')";
if (!$mysqli->query($queryIP)) 
{
	echo $queryIP;
	//echo $hash;
	echo $UserIP;
	//echo $email;
	//echo $pass;
	echo $UserId;
}
$_SESSION['error'] = array('clase'=>'alert-success','titulo'=>'Hey! ','mensaje'=>'Registration completed, Check email to validate');		
header("Location: signin.php");
//end
}else{

	header("Location: signup.php");
}

?>