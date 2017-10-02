<?php 

define("DB_HOST","localhost" );  
define("DB_USER", "testuser");  
define("DB_PASS", "testpassword");  
define("DB_DATABASE", "proyecto" );   

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);   
if($mysqli->connect_errno > 0){   
  die("Error conectando a la BD: " . $mysqli->connect_error);   
}  


$id=$mysqli->real_escape_string($_POST['id']);



$sql = "DELETE FROM 
		PERSONAL WHERE id='$id'";  

$mysqli->query($sql);  
if($mysqli->errno) die($mysqli->error);


 ?>