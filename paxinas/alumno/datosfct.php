<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');

session_start();

$id=$_SESSION['id'];

$alumno=new Alumno($id);

$datos=$alumno->datos_fct();
$alumno->close();

echo json_encode($datos);



 ?>