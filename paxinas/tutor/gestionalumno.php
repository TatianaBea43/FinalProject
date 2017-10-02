<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');
//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');
session_start();
$id_tutor=$_SESSION['id'];
if(isset($_POST['selected'])){
	//Convierto string que envié en objeto JSON
	$arr=json_decode($_POST['selected'],true); 
	/***consulta preparada***/
	$conectar=new Conexion();
	$stmt= $conectar->basedatos->stmt_init();
	$sql="UPDATE alumno SET id_tutor=$id_tutor WHERE id=?";
	if($stmt->prepare($sql)){
		foreach ($arr as $key => $value) {
		$id= $value['id'];
		$stmt->bind_param("i", $id);
		$stmt->execute();
		if ($stmt->errno) {  
			$resultado="Error al ejecutar la consulta";
			echo json_encode($resultado);
		}
	}
	}else{
		$resultado="Error al preparar la consulta";
		echo json_encode($resultado);
	}

}
if(isset($_POST['alumnofct'])){
	$id=$_POST['alumnofct'];
	$usuario=new Usuario($id);
	$resultado=$usuario->ver_proyecto();
	echo json_encode($resultado);
}

if(isset($_POST['opcionFCT'])){
	$msg="Error en los siguientes campos:<br>";
	$bandera=true;

	$opcion=$_POST['opcionFCT'];
	$fecha=$_POST['fechainicio'];
	$empresa=$_POST['id_empresa'];
	$total_horas=$_POST['totalhoras'];
	$jornada=$_POST['jornada'];
	$id=$_POST['idalumnofct'];

	if(!validateDate($fecha, $formato='Y-m-d')){
	$bandera=false;
	$msg.="Fecha<br>";
	}
	if(!is_numeric($empresa)){
		$bandera=false;
		$msg.="Empresa<br>";
	}
	if(!is_numeric($total_horas)){
		$bandera=false;
		$msg.="Total horas<br>";
	}
	if(!is_numeric($jornada)){
		$bandera=false;
		$msg.="Jornada<br>";
	}
	if(!is_numeric($id)){
		$bandera=false;
		$msg.="Id alumno<br>";
	}

	if($bandera){
		$usuario=new Usuario($id);

		if($opcion=="modificarFCT"){
			$id_registro=$_POST['idregistro'];
			$resultado['alumno']=$usuario->modificar_proyecto($id_registro,$fecha,  $empresa, $total_horas, $jornada);
		}

		if($opcion=="anadirFCT"){
			
			$resultado['alumno']=$usuario->anadir_proyecto($id_tutor, $fecha,  $empresa, $total_horas, $jornada );
			
		}
	}else{
		$resultado['errores']=$msg;
		
	}
	echo json_encode($resultado);

}












 ?>