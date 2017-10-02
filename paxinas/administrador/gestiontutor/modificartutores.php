<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//Cargo el archivo de las funciones que voy a utilizar
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');

//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}
session_start();
if($_SESSION['tipo']==3){
	$id=$_POST['idperfil'];
	$apellidos=$_POST['apellidosperfil'];
	$nombre=$_POST['nombreperfil'];
	$dni=$_POST['dniperfil'];
	$telefono=$_POST['telefonoperfil'];
	$email=$_POST['emailperfil'];
}

if($_SESSION['tipo']==1){
	$id=$_POST['id'];
	$apellidos=$_POST['apellidos'];
	$nombre=$_POST['nombre'];
	$dni=$_POST['dni'];
	$telefono=$_POST['telefono'];
	$email=$_POST['email'];
}

spl_autoload_register('mi_autocargador');
$msg="Error en los siguientes campos:<br>";
$bandera=true;


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
if(!validar_dni($dni)){
	$bandera=false;
	$msg.="DNI<br>";
}
if(!validar_telefono($telefono)){
	$bandera=false;
	$msg.="Teléfono<br>";
}
if(!validar_mail($email)){
	$bandera=false;
	$msg.="Email<br>";
}

if($bandera){ 
	try{
	$tutor=new Tutor($id);
	}catch(Exception $e){
		$respuesta=0;
	}
	$respuesta['tutor']=$tutor->modificar_tutor($id, $apellidos, $nombre, $dni, $telefono, $email);
	$tutor->close();

}else{
	$respuesta['errores']=$msg;
}

echo json_encode($respuesta);



 ?>