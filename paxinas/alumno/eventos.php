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

$id_alumno=$_POST['id_alumnoModal'];
$fecha=$_POST['fecha'];
$titulo=$_POST['tituloevento'];
$descripcion=$_POST['descripcion'];

//echo json_encode($id_alumno);

if(!validateDate($fecha, $formato='Y-m-d')){
	$bandera=false;
	$msg.="Fecha<br>";
}
if(!is_numeric($id_alumno)){
	$bandera=false;
	$msg.="ID<br>";
}
if(!validar_texto($descripcion)){
	$bandera=false;
	$msg.="Descripción<br>";
}
if(!validar_texto($titulo)){
	$bandera=false;
	$msg.="Título<br>";
}

if($bandera){
	try{
		$usuario=new Usuario($id_alumno);
	}catch (Exception $e){
		$respuesta=3;
	}
	
	$respuesta['evento']=$usuario->introducir_eventos($fecha, $titulo, $descripcion);
}else{
	$respuesta['errores']=$msg;
	
}
echo json_encode($respuesta);

 ?>