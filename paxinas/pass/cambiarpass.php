<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//Cargo el archivo de las funciones que voy a utilizar
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');

//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');

session_start();
$msg="Error en los siguientes campos:<br>";
$bandera=true;

$usuario=$_POST['usuario'];
$oldpass=$_POST['pass1'];
$newpass=$_POST['pass2'];

if(!validar_texto($usuario)){
	$bandera=false;
	$msg.="Nombre<br>";
}
if(!validar_texto($oldpass)){
	$bandera=false;
	$msg.="Contraseña antigua<br>";
}
if(!validar_texto($newpass)){
	$bandera=false;
	$msg.="Contraseña nueva<br>";
}

if($bandera){
	if($usuario!=$_SESSION['usuario']){
	$resultado['errores']="El nombre de usuario no es correcto";

	}else{
		try{
			$usu=new Usuario($_SESSION['id']);
		}catch(Exception $e){
			$resultado=0;
		}

	    $resultado['usuario']=$usu->cambiar_pass($oldpass, $newpass);	
	}

}else{
	$resultado['errores']=$msg;
}
		
echo json_encode($resultado);
			

		











 ?>