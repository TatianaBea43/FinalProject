<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//Cargo el archivo de las funciones que voy a utilizar
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');

//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');
$msg="Error en los siguientes campos:<br>";
$bandera=true;

//recojo los datos del formulario
$apellidos=$_POST['apellidos'];
$nombre=$_POST['nombre'];
$dni=$_POST['dni'];
$telefono=$_POST['telefono'];
$email=$_POST['email'];

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
if(!validar_telefono($telefono)){
	$bandera=false;
	$msg.="Teléfono<br>";
}
if(!validar_mail($email)){
	$bandera=false;
	$msg.="Email<br>";
}

if($bandera){
	//Creo nombre de usuario
	$usuario=generaUsuario($apellidos,$nombre);
	//Genero contraseña aleatoria
	$pass_usuario=generaPass();
	//tipo de usuario 'tutor'
	$tipo=3;
	//genero la fecha de alta
	$alta= date('d/m/Y', time());

	try{
	//creo un nuevo tutor
	$tutor=new Tutor($usuario, $pass_usuario, $tipo, $alta, $activo=1, $apellidos, $nombre, $dni, $telefono, $email);
	}catch(Exception $e){
		$respuesta=0;
		echo json_encode($respuesta);
	}

	//lo registro tanto en la tabla tutor como en la tabla de usuarios
	$resultado=$tutor->registro_tutor();
	if($resultado==1){
		$tutor->close();
		echo json_encode($resultado);
	}else{
		//recojo la información de la tabla tutor
		$respuesta['tutor']=$tutor->recuperar_tutor();
		//envío email
		$respuesta['mail']=$tutor->enviar_email($email, $nombre, $usuario, $pass_usuario);
		$tutor->close();
		echo json_encode($respuesta);
	}
}
else{
	$respuesta['errores']=$msg;
	echo json_encode($respuesta);
}



 ?>