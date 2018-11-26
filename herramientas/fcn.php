<?php 
include 'cnx.php';

function mostrar($variable, $nombre = '')
{
	echo "<pre>";
	if ($nombre == '') 
	{		
		print_r($variable);		
	} 
	else 
	{
		print_r(array($nombre => $variable));
	}
	echo "</pre>";
}

function regex_check($regex, $variable)
{
	if (1 !== preg_match($regex, $variable)) 
	{
		return FALSE;
	}
	return TRUE;
}

function do_login($data = '')
{
		$_SESSION['userdata'] = $data;
		$_SESSION['userdata']['time'] = microtime(TRUE);
		return TRUE;
}

function logout()
{
	session_destroy();
	header("Location: signin.php");
	exit;
}

function is_logged_in()
{
	if (!isset($_SESSION['logged_in'])) 
	{
		return FALSE;	
	}

	if ((microtime(TRUE) - $_SESSION['time'])  > LOGGING_TIMEOUT) 
	{
		logout();
		return FALSE;
	}

	$_SESSION['time'] = microtime(TRUE);
	return TRUE;
}

function load_view($data)
{
	include 'librerias/View.php';

	if (!isset($data['url'])) 
	{
		$v = new View('layout/temamaterial.php');
		$f = $v->fetch($data);
		echo $f;
	}
	else
	{
		$v = new View($data['url']);
		$f = $v->fetch($data);

		echo $f;
	}
}
function getUserIP()
{
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}



?>