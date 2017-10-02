<?php 

define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//Cargo el archivo de las funciones que voy a utilizar
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');

//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}
session_start();

spl_autoload_register('mi_autocargador');

	$msg="Error en los siguientes campos:<br>";
	$bandera=true;

	$id=$_POST['id'];
	$usuario=$_POST['usuario'];
	$tipo=$_POST['tipo'];

	if(!is_numeric($id)){
		$bandera=false;
		$msg.="ID<br>";
	}
	if(!validar_texto($usuario)){
		$bandera=false;
		$msg.="Usuario<br>";
	}
	if(!is_numeric($tipo)){
		$bandera=false;
		$msg.="Tipo usuario<br>";
	}

	if ($bandera){
		try{
			$usuario=new Usuario($id, $usuario, $tipo);
		}catch(Exception $e){
			$res=0;
			echo json_encode($res);
		}

		$usuario->baja_usuario();
		$respuesta['usuario']=$usuario->recuperar_usuario();
		$usuario->close();

	}else{
		$respuesta['errores']=$msg;
		
	}
	echo json_encode($respuesta);









 ?>