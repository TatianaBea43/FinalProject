<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//Cargo el archivo de las funciones que voy a utilizar
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');

//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');
$msg="Error en los siguientes campos:<br>";
$bandera=true;

$id=$_POST['id'];
$apellidos=$_POST['apellidos'];
$nombre=$_POST['nombre'];
$email=$_POST['email'];
$tipo=$_POST['tipo'];

if(!is_numeric($id)){
	$bandera=false;
	$msg.="ID<br>";
}

if(!validar_texto($apellidos)){
	$bandera=false;
	$msg.="Apellidos<br>";
}
if(!validar_texto($nombre)){
	$bandera=false;
	$msg.="Nombre<br>";
}
if(!validar_mail($email)){
	$bandera=false;
	$msg.="Email<br>";
}
if(!is_numeric($tipo)){
	$bandera=false;
	$msg.="ID<br>";
}

if($bandera){
	$usuario=generaUsuario($apellidos,$nombre);
	$pass=generaPass();

	try{
		$usuario=new Usuario($id, $usuario, $tipo);
	}catch(Exception $e){
		$res=0;
		echo json_encode($res);
	}

	$resultado['usuario']=$usuario->alta_usuario($nombre, $pass);
	$resultado['mail']=$usuario->enviar_email($email,$nombre,$usuario->usuario, $pass);
	$usuario->close();

	echo json_encode($resultado);

}else{
	$respuesta['errores']=$msg;
	echo json_encode($respuesta);
}








 ?>