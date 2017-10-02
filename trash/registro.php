<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="registro.php" method="post" accept-charset="utf-8">
	<input type="text" name="nombre">
	<input type="text" name="password">
	<input type="text" name="tipo">
	<input type="submit" name="enviar">
</form>

<?php 
define("DB_HOST","localhost" );  
define("DB_USER", "testuser");  
define("DB_PASS", "testpassword");  
define("DB_DATABASE", "proyecto" );  

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);   
if($mysqli->connect_errno > 0){   
  die("Error conectando a la BD: " . $mysqli->connect_error);   
} 

if (isset($_POST['enviar'])){
		$nombre=$mysqli->real_escape_string($_POST["nombre"]);
		$pass=password_hash($mysqli->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
		$tipo=$mysqli->real_escape_string($_POST["tipo"]);
		$alta= date('Y-m-d H:i:s', time());
		$sql = "INSERT INTO usuario (usuario, passwd, tipousuario, alta, activo) VALUES ('$nombre', '$pass', '$tipo', '$alta', '1')";
		echo $sql;
	    $resultado=$mysqli->query($sql); 
	    if($mysqli->errno) die($mysqli->error); 


}

 ?>

</body>
</html>