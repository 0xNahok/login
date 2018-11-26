<?php 


include 'herramientas/cnx.php';
include 'herramientas/fcn.php';
session_start(); 



if( isset($_GET['email']) && !empty($_GET['email']) 
    AND isset($_GET['hash']) && !empty($_GET['hash']) 
    AND isset($_GET['id']) && !empty($_GET['id'])
    AND isset($_GET['password']) && !empty($_GET['password'])
    ){
    // Verify data
    $email = $_GET['email']; // Set 
    $hash =$_GET['hash']; // Set
    $id =$_GET['id']; // Set
    $password =$_GET['password']; // Set
    
}else{
    // Invalid approach
}


$query ="UPDATE user SET `password` = '".$password."', `email`= '".$email."' WHERE id = '".$id."' AND hash = '".$hash."'";
echo $query;
if (!$resultado = $mysqli->query($query)) 
{
	$data['error'] = 'DB Error: '.$mysqli->error;
}   
$_SESSION['userdata'] = array();

$_SESSION['error'] = array('clase'=>'alert-success','titulo'=>'Hey! ','mensaje'=>'Information Updated');
                     header("Location: signin.php");
            
?>