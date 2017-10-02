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

$id_alumno=$_SESSION['id'];
$fecha=$_POST['fecha'];
$horas=$_POST['horas'];
$observaciones=$_POST['observaciones'];

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
	$resultado=$alumno->inserta_horas($fecha, $horas, $observaciones);
	
	if($resultado==1){
		$alumno->close();
		echo json_encode($resultado);
	}else{
		$respuesta['alumno']=$alumno->recuperadatos_fct($resultado);
		$alumno->close();
		echo json_encode($respuesta);
	}

}else{
	$respuesta['errores']=$msg;
	echo json_encode($respuesta);
}

//echo $fecha;*/




 ?>