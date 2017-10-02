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
$dni=$_POST['dni'];
$direccion=$_POST['direccion'];
$telefono=$_POST['telefono'];
$email=$_POST['email'];
$estudios=$_POST['estudios'];
$tecnologias=$_POST['tecnologias'];
$preferencias=$_POST['preferencias'];

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
if(!validar_direccion($direccion)){
	$bandera=false;
	$msg.="Dirección<br>";
}
if(!validar_telefono($telefono)){
	$bandera=false;
	$msg.="Teléfono<br>";
}
if(!validar_mail($email)){
	$bandera=false;
	$msg.="Email<br>";
}
if(!empty($preferencias) && !validar_texto($preferencias)){
	$bandera=false;
	$msg.="Preferencias<br>";
}
if(!empty($estudios) && !validar_texto($estudios)){
	$bandera=false;
	$msg.="Estudios<br>";
}
if(!empty($tecnologias) && !validar_texto($tecnologias)){
	$bandera=false;
	$msg.="Tecnologías<br>";
}

if($bandera){
	try{
	    $alumno=new Alumno($id);
	}catch(Exception $e){
		$respuesta=0;
		//echo json_encode($respuesta);
	}

	$respuesta['alumno']=$alumno->modificar_alumno($id, $apellidos, $nombre, $dni, $direccion, $telefono, $email, $estudios, $tecnologias, $preferencias);
	$alumno->close();
	//echo json_encode($respuesta);
}else{
	$respuesta['errores']=$msg;
	//echo json_encode($respuesta);
}
echo json_encode($respuesta);





 ?>