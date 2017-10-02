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



//recojo los datos del formulario
$razonsocial=$_POST['razonsocial'];
$direccion=$_POST['direccion'];
$email=$_POST['email'];
$telefono=$_POST['telefono'];
$tutor=$_POST['tutor'];
$estado=$_POST['estado'];

if(!validar_texto($razonsocial)){
	$bandera=false;
	$msg.="Nombre<br>";
}
if(!validar_direccion($direccion)){
	$bandera=false;
	$msg.="Dirección<br>";
}
if(!validar_mail($email)){
	$bandera=false;
	$msg.="Email<br>";
}
if(!validar_telefono($telefono)){
	$bandera=false;
	$msg.="Teléfono<br>";
}
if(!validar_texto($tutor)){
	$bandera=false;
	$msg.="Tutor<br>";
}
if(!is_numeric($estado)){
	$bandera=false;
	$msg.="Estado<br>";
}

if($bandera){
	try{

	$empresa=new Empresa($razonsocial, $direccion, $email, $telefono, $tutor, $estado);
	}catch(Exception $e){
		$respuesta=0;
		echo json_encode($respuesta);
	}

	$resultado=$empresa->registro_empresa();
	if($resultado==1){
		$empresa->basedatos->close();
		echo json_encode($resultado);
	}else{
		$respuesta['empresa']=$empresa->recuperar_empresa();
		$empresa->basedatos->close();
		echo json_encode($respuesta);
	}
}else{
	$respuesta['errores']=$msg;
	echo json_encode($respuesta);
}


 ?>