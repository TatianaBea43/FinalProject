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
$id_usuario=$_SESSION['id'];
$tipo=$_SESSION['tipo'];

switch ($tipo) {
	case '2':
	$alumno=new Alumno($id_usuario);
	if (!isset($_POST['idaviso'])){
		$datos=$alumno->leer_avisos();
		echo json_encode($datos);
	}else{
		if(is_numeric($_POST['idaviso'])){
			$respuesta=$alumno->actualiza_avisos($_POST['idaviso']);
			echo json_encode($respuesta);
		}
		
	}
	    
	break;

	case '3':
	$destino=$_POST['destinatarios'];
	$fecha=new DateTime();
	$fecha=date_format($fecha, 'Y-m-d');
	$texto=$_POST['textoaviso'];
	$estado=0;
	$msg="Error en los siguientes campos:<br>";
	$bandera=true;

	if(!is_numeric($destino)){
		$bandera=false;
		$msg.="Destinatario<br>";
	}
	if(!validar_texto($texto)){
		$bandera=false;
		$msg.="Texto del aviso<br>";
	}

	if($bandera){
		if($destino==0){
			//Convierto string que envié en objeto JSON
		 $arr=json_decode($_POST['arraydestinatarios'],true); 

			/***consulta preparada***/
			$conectar=new Conexion();
			$stmt= $conectar->basedatos->stmt_init();
			$sql="INSERT INTO avisos (id_alumno, fecha, aviso, estado) VALUES (?,?,?,?)";
			if($stmt->prepare($sql)){
				foreach ($arr as $value) {
				$id_alumno=$value;
				$stmt->bind_param("issi", $id_alumno, $fecha, $texto, $estado);
				$stmt->execute();
				if ($stmt->errno) {  
					$resultado['errores']="Error al ejecutar la consulta";
					
				}else{
					$resultado['usuario']=1;
				}
				

			}
			}else{
				$resultado['errores']="Error al preparar la consulta";
				
			}
			echo json_encode($resultado);

			
		}else{
			try{
				$usuario=new Usuario($id_usuario);
			}catch(Exception $e){
				$respuesta=0;
				echo json_encode($respuesta);
			}
			$resultado['usuario']=$usuario->anadir_avisos($destino, $fecha, $texto, $estado);
			echo json_encode($resultado);
	
		}

	}else{
		$respuesta['errores']=$msg;
		echo json_encode($respuesta);
	}

	//echo json_encode($destino);


	break;
	
}




 ?>