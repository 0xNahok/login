<?php 
	
	include 'herramientas/cnx.php';
	include 'herramientas/fcn.php';
	session_start();

    $email = $_REQUEST['email'];
    $pass = $_REQUEST['password'];

    $currentIP =getUserIP();
	
	date_default_timezone_set('America/Caracas');
	$date = date('Y-m-d h:i:s', time());

if ($email == '') 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'You must write a email.');
	header("Location: signin.php");
	$legit = false;
	exit();
}

if ($pass == '') 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'You must write a password.');
	header("Location: signin.php");
	$legit = false;
	exit();
}


if (strlen($pass) < 5 OR strlen($pass) > 15) 
{	
		
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Password must be between 5 and 15 characters long');
	header("Location: signin.php");
	$legit = false;
	exit();
}

if ( regex_check('/[^a-zA-Z0-9]/', $pass)) 
{
	$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Only alphanumeric characters are allowed.');
	header("Location: signin.php");
	$legit = false;
	exit();
}


$query = "SELECT * FROM user INNER JOIN tip on user.id = tip.UserID WHERE email = '{$email}' AND password = '{$pass}' LIMIT 1;";



if (!$result = $mysqli->query($query)) 
{
	$_SESSION['error'] = array('clase'=>'alert-danger','titulo'=>'Error! ','mensaje'=>'Problems in the database.');
	header("Location: signin.php");
	exit();
}



if ($result->num_rows == 1) 
{
	if ($row = $result->fetch_assoc())
	{		$id_user = $row['id'];
			$hash_user =$row['hash'];
			
		if ($row['active']==0){
		$_SESSION['error'] = array('clase'=>'alert-danger','titulo'=>'Error! ','mensaje'=>'Ops..Check your email and verify your account.');
		header("Location: signin.php");
		exit();
		}

		$queryIP= "SELECT * FROM tip Where UserID = '{$id_user}'";

			if (!$rip = $mysqli->query($queryIP)) 
			{
				$data['error'] = ' DB Error: '.$mysqli->error;
			}

			if ($rip->num_rows == 0) 
			{
				$data['error'] = 'No record';
			}

			while ($r2 = $rip->fetch_assoc()) 
			{
				$data['tip'][] = $r2;
			}
	

		$trustedIP = false;
		foreach ($data['tip'] as $tip) {
		
			if($currentIP == $tip['ip'])
			{	$trustedIP= true;
				
			}else{
				
			}
		}

		if ($trustedIP) {
			echo $trustedIP;
				do_login($row);
				$q = "INSERT INTO login_attempt (ip, ts,valid, id_user) values ('{$currentIP}','{$date}','1','".$id_user."')";
			
				if (!$mysqli->query($q)) 
				{
					$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Problems in the database');
					header("Location: signin.php");
				}
				header("Location: index.php");
			}

		if (!$trustedIP) {
		
			echo $currentIP.'<br>';
			echo $row['ip'].'<br>';
		
			$q = "INSERT INTO login_attempt (ip, ts, id_user) values ('{$currentIP}','{$date}', '".$id_user."')";
			echo $trustedIP;
			if (!$mysqli->query($q)) 
			{
				$_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'Problems in the database');
				header("Location: signin.php");
			}
			
			echo $q;
			$ValidateIPLink = 'http://'.$_SERVER['HTTP_HOST'].'/login/verifyip.php';
			
			$from = "no-reply@johanmarin.tech";
			$to      = $email; 
			$subject = 'IP | Verification'; 
			$message = '
			
			Attempted to log into your account from a new IP!
			
			------------------------
			Email: '.$email.'
			New IP detected: '.$currentIP.'
			------------------------
			
			Please click this link to accept this new ip
				'.$ValidateIPLink.'?email='.$email.'&hash='.$hash_user.'&newip='.$currentIP.'&id_user='.$id_user.'
			'; 
								
			$headers = 'From:'.$from ."\r\n"; 
			mail($to, $subject, $message, $headers); 
			$_SESSION['error'] = array('clase'=>'alert-danger','titulo'=>'Hey! ','mensaje'=>'Ops..New IP? Check your email.');
			header("Location: signin.php");
			exit();
			}

		
		exit();
	}
	else
	{

		$_SESSION['error'] = array('clase'=>'alert-danger','titulo'=>'Error! ','mensaje'=>'Problems in the database.');
        header("Location: signin.php");
		exit();
	}
}
else
{
	$_SESSION['error'] = array('clase'=>'alert-danger','titulo'=>'Error! ','mensaje'=>'Incorrect email or password');
	header("Location: signin.php");
	exit();
}


 ?>