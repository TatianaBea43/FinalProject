<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');
session_start();
if(isset($_POST['id_tutor'])){
	$id_tutor=$_POST['id_tutor'];
}else{
	$id_tutor=$_SESSION['id'];
}


$tutor=new Tutor($id_tutor);

$datos=$tutor->lista_alumnos($id_tutor);
echo json_encode($datos);



 ?>