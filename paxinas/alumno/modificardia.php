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

$opcion=$_POST['opcion'];
$id_registro=$_POST['id_registro'];
$fecha=$_POST['fecha'];
$horas=$_POST['horas'];
$observaciones=$_POST['observaciones'];
$id_alumno=$_SESSION['id'];


if(!is_numeric($id_registro)){
	$bandera=false;
	$msg.="ID<br>";
}
if(!validateDate($fecha, $formato='Y-m-d')){
	$bandera=false;
	$msg.="Fecha<br>";
}
if(!is_numeric($horas)){
	$bandera=false;
	$msg.="Horas<br>";
}
if(!validar_texto($observaciones)){
	$bandera=false;
	$msg.="Observaciones<br>";
}



if($bandera){
	try{
	$alumno=new Alumno($id_alumno);
	
	}catch(Exception $e){
		$respuesta=0;
		echo json_encode($respuesta);
	}

	if($opcion==='cambiar'){
		
		$respuesta['alumno']=$alumno->modificardatos_fct($id_registro, $fecha, $horas, $observaciones);
		$alumno->close();

	}

	if($opcion==='eliminar'){
		$respuesta['alumno']=$alumno->eliminardatos_fct($id_registro);
		$alumno->close();

	}


}else{
	$respuesta['errores']=$msg;
	
}
echo json_encode($respuesta);









 ?>