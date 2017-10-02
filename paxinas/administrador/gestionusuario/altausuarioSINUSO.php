<?php 
define('RAIZ',$_SERVER['DOCUMENT_ROOT']); 
//Cargo el archivo de las funciones que voy a utilizar
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php');

//cargo las clases
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}

spl_autoload_register('mi_autocargador');


//recojo los datos del formulario
$apellidos=$_POST['apellidos'];
$nombre=$_POST['nombre'];
$dni=$_POST['dni'];
$direccion=$_POST['direccion'];
$telefono=$_POST['telefono'];
$email=$_POST['email'];
$estudios=$_POST['estudios'];
$tecnologias=$_POST['tecnologias'];
$preferencias=$_POST['preferencias'];

//Creo nombre de usuario
$str2=substr($apellidos, 0, 3);
$str3=substr($nombre, 0, 3);
$str2=sanear_string($str2);
$str3=sanear_string($str3);
$usuario="FCT".date('y').$str2.$str3;
//Genero contraseña aleatoria
$pass_usuario=generaPass();
//tipo de usuario 'alumno'
$tipo=2;
//genero la fecha de alta
$alta= date('Y-m-d H:i:s', time());

//creo un nuevo alumno
$alumno=new Alumno($usuario, $pass_usuario, $tipo, $alta, $activo=1, $apellidos, $nombre, $dni, $direccion, $telefono, $email, $estudios, $tecnologias, $preferencias);
//lo registro tanto en la tabla alumno como en la tabla de usuarios
$alumno->registro_alumno();
//recojo la información de la tabla alumno
$resultado=$alumno->recuperar_alumno();

//recojo en un objeto json
$jsondata = $resultado;
echo json_encode($jsondata);


 ?>