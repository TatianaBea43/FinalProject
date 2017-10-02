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
if($_SESSION['tipo']==3){
	$id_tutor=$_SESSION['id'];
}else{
	$id_tutor=0;
}
$msg="Error en los siguientes campos:<br>";
$bandera=true;

/*************UN SOLO ALUMNO****************/
//recojo los datos del formulario
$apellidos=$_POST['apellidos'];
$nombre=$_POST['nombre'];
$dni=$_POST['dni'];
$direccion=$_POST['direccion'];
$telefono=$_POST['telefono'];
$email=$_POST['email'];
if (isset($_POST['estudios'])){
	$estudios=$_POST['estudios'];
}else{
	$estudios=null;
}

if (isset($_POST['tecnologias'])){
	$tecnologias=$_POST['tecnologias'];
}else{
	$tecnologias=null;
}

if (isset($_POST['preferencias'])){
	$preferencias=$_POST['preferencias'];
}else{
	$preferencias=null;
}

if(!validar_texto($apellidos)){
	$bandera=false;
	$msg.="Apellidos<br>";
}
if(!validar_texto($nombre)){
	$bandera=false;
	$msg.="Nombre<br>";
}
if(!validar_dni($dni)){
	$bandera=false;
	$msg.="DNI<br>";
}
if(!validar_direccion($direccion)){
	$bandera=false;
	$msg.="Dirección<br>";
}
if(!validar_telefono($telefono)){
	$bandera=false;
	$msg.="Teléfono<br>";
}
if(!validar_mail($email)){
	$bandera=false;
	$msg.="Email<br>";
}
if($preferencias!=null && !validar_texto($preferencias)){
	$bandera=false;
	$msg.="Preferencias<br>";
}
if($estudios!=null && !validar_texto($estudios)){
	$bandera=false;
	$msg.="Estudios<br>";
}
if($tecnologias!=null && !validar_texto($tecnologias)){
	$bandera=false;
	$msg.="Tecnologías<br>";
}


if($bandera){
	//Creo nombre de usuario
	$usuario=generaUsuario($apellidos,$nombre);
	//Genero contraseña aleatoria
	$pass_usuario=generaPass();
	//tipo de usuario 'alumno'
	$tipo=2;
	//genero la fecha de alta
	$alta= date('d/m/Y', time());

	//creo un nuevo alumno
	try{
		$alumno=new Alumno($usuario, $pass_usuario, $tipo, $alta, $activo=1, $apellidos, $nombre, $dni, $direccion, $telefono, $email, $estudios, $tecnologias, $preferencias, $id_tutor);
	}catch(Exception $e){
		$respuesta=0;
		echo json_encode($respuesta);
	}

	$resultado=$alumno->registro_alumno();
	if($resultado==1){
		$alumno->close();
		echo json_encode($resultado);
	}else{
		$respuesta['alumno']=$alumno->recuperar_alumno();
		$respuesta['mail']=$alumno->enviar_email($email, $nombre, $usuario, $pass_usuario);
		$alumno->close();
		echo json_encode($respuesta);
	}
}else{
	$respuesta['errores']=$msg;
	echo json_encode($respuesta);
}


 ?>