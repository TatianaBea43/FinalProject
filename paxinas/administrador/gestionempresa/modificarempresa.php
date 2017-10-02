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
$razonsocial=$_POST['razonsocial'];
$direccion=$_POST['direccion'];
$email=$_POST['email'];
$telefono=$_POST['telefono'];
$tutor=$_POST['tutor'];
$estado=$_POST['estado'];

if(!is_numeric($id)){
	$bandera=false;
	$msg.="ID<br>";
}

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
	$empresa=new Empresa($id);
	}catch(Exception $e){
		$respuesta=0;
	}
	$respuesta['empresa']=$empresa->modificar_empresa($id, $razonsocial, $direccion,  $email, $telefono, $tutor, $estado);
	$empresa->basedatos->close();

}else{
	$respuesta['errores']=$msg;
}
echo json_encode($respuesta);





 ?>