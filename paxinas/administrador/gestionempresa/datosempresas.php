<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');


$datos=Empresa::recuperar_empresas();
echo json_encode($datos);



 ?>