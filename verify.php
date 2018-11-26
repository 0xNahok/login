<?php 


include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 



if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash =$_GET['hash']; // Set hash variable
}
$query = "SELECT * FROM user WHERE email='".$email."' AND hash='".$hash."'";

if (!$resultado = $mysqli->query($query)) 
{
	$data['error'] = 'DB Error: '.$mysqli->error;
}

if ($resultado->num_rows == 0) 
{
	$data['error'] = 'No record';
}

while ($row = $resultado->fetch_assoc()) 
{   
    $data['users'][] = $row;
            if($data['users'][0]['active']==0){
             
                $queryA = "UPDATE user SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'";
                $resultado2 = $mysqli->query($queryA);
                
                $_SESSION['error'] = array('clase'=>'alert-success','titulo'=>'Hey! ','mensaje'=>'Account activated');
                header("Location: signin.php");
            }else{
                $_SESSION['error'] = array('clase'=>'alert-success','titulo'=>'Hey! ','mensaje'=>'Account-already active');
                header("Location: signin.php");
            }

}


 ?>