<?php 

define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');

session_start();

//cuando entro desde el alumno. El else es para cuando se entra desde tutor
//if (!isset($_POST['id_alumno'])){
	$alumno=new Alumno($_POST['opcion_alumno']);
	$resultado['eventos']=$alumno->ver_eventos();
	$resultado['horas']=$alumno->datos_fct();
	$resultado['proyecto']=$alumno->ver_proyecto();
	$alumno->close();
	echo json_encode($resultado);

//}else{

//}





 ?>