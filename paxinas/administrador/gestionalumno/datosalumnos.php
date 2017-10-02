<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');

$datos=Alumno::recuperar_alumnos();
echo json_encode($datos);



 ?>