<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');

$codigo=$_POST['valor'];

if ($codigo==1){
	$datos=Alumno::recuperar_alumnos();
}elseif($codigo==2){
	$datos=Alumno::recuperar_tutores();
}elseif($codigo==0){
	$datos="No se han seleccionado destinatarios";
}

echo json_encode($datos);



 ?>