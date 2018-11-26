<?php 


include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 



if( isset($_GET['email']) && !empty($_GET['email']) 
    AND isset($_GET['hash']) && !empty($_GET['hash']) 
    AND isset($_GET['newip']) && !empty($_GET['newip'])
    AND isset($_GET['id_user']) && !empty($_GET['id_user'])
    ){
    // Verify data
    $email = $_GET['email']; // Set 
    $hash =$_GET['hash']; // Set
    $ip =$_GET['newip']; // Set
    $id =$_GET['id_user']; // Set
    
}else{
    // Invalid approach
}

//Get user Trusted-Ip

$queryIP= "SELECT * FROM tip Where UserID = '{$id}'";

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
	
            echo $queryIP;
		$newIP = false;
		foreach ($data['tip'] as $tip) {
            
			if($ip == $tip['ip'])
			{	$newIP= true;
               
			}else{
				
			}
        }
        echo $newIP;
if ($newIP) {
    $_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'IP is already registered');
    header("Location: signin.php");
} else {
    $query = "SELECT * FROM user WHERE email='".$email."' AND hash='".$hash."' AND id='".$id."' LIMIT 1";

    if (!$resultado = $mysqli->query($query)) 
    {
        $data['error'] = 'DB Error: '.$mysqli->error;
    }
    
    if ($resultado->num_rows != 0) 
    {   
        $q = "INSERT INTO tip(ip, UserID) VALUES ('{$ip}','{$id}')";
        echo $q;
    
            if (!$mysqli->query($q)) 
                {
                    $_SESSION['error'] = array('clase'=>'alert-warning','titulo'=>'Hey! ','mensaje'=>'A problem has occurred');
                    header("Location: signin.php");
                }else {
                    $_SESSION['error'] = array('clase'=>'alert-success','titulo'=>'Hey! ','mensaje'=>'New Ip added');
                   header("Location: signin.php");
            }
    }

}



 ?>