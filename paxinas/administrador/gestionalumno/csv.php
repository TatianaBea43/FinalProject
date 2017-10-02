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
$resultado['alumnos']=0;
if($_SESSION['tipo']==3){
	$id_tutor=$_SESSION['id'];
}else{
	$id_tutor=0;
}



	$nombrearchivo = $_FILES[0]['name']; //nombre del fichero
	$nombre_tmp = $_FILES[0]['tmp_name']; //nombre temporal del fichero
	$tipo = $_FILES[0]['type']; //tipo del fichero que le pasa el navegador (varias opciones, más abajo)
	$tamano = $_FILES[0]['size']; //tamaño del fichero en bytes

	$ext_permitidas = array('csv');
	$partes_nombre = explode('.', $nombrearchivo);
	$extension = end($partes_nombre);

	//Comprobamos si la extensión es correcta. Variable booleana
	$ext_correcta = in_array($extension, $ext_permitidas);

	//Comprobamos si el tipo es correcto (en función de los navegadores, será un tipo u otro)
	$tipos_posibles_csv = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
	$tipo_correcto = in_array($tipo,$tipos_posibles_csv);//Variable booleana

	$limite = 2 * 1024; //Máximo 2MB

	if($ext_correcta && $tipo_correcto && $tamano <= $limite){
		if($_FILES[0]['error'] > 0){ //Error en el fichero
			$resultado['errores']='Error: ' . $_FILES['0']['error'];
		} else {
			
			
			$conectar=new Conexion();
			$stmt1 = $conectar->basedatos->stmt_init();
			$stmt2 = $conectar->basedatos->stmt_init();

			$sql = "INSERT INTO usuario (usuario, passwd, tipousuario, alta, activo) VALUES (?, ?, 2, ?, 1)"; 
			$sql2 = "INSERT INTO alumno (id, apellidos, nombre, dni, direccion, telefono, email, estudios, tecnologias, preferencias, id_tutor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
			if($stmt1->prepare($sql) && $stmt2->prepare($sql2)){
				$fichero = fopen($nombre_tmp, "r");
				$contador=0;
				while (!feof($fichero)) {
				$linea = utf8_encode(fgets($fichero));
				if (!empty($linea)) {
					$matriz = explode(",", $linea);
					
					$flag=true;

					$apellidos = $matriz[0]." ".$matriz[1];
					$nombre = $matriz[2];
					$dni = $matriz[3];
					$direccion = $matriz[4];
					$telefono = $matriz[5];
					$email = $matriz[6];
					$estudios = $matriz[7];
					$tecnologias = $matriz[8];
					$preferencias = $matriz[9];


					$usuario=generaUsuario($apellidos,$nombre);
							//Genero contraseña aleatoria
							$pass_usuario=generaPass();
							$pass_hash=password_hash($pass_usuario, PASSWORD_DEFAULT);
							//tipo de usuario 'alumno'
							//genero la fecha de alta
							$alta= date('Y-m-d', time());
					
					$contador++;

					$respuesta=verificardatos($nombre,$apellidos,$dni,$telefono,$email,$contador);
					
					if($respuesta==null){
						$conectar->basedatos->autocommit(false);
						$conectar->basedatos->begin_transaction();

						$stmt1->bind_param("sss", $usuario, $pass_hash, $alta);
							$stmt1->execute();
							if ($stmt1->errno) {  
							  $flag = false;  
							}
							
							$id=$stmt1->insert_id;
							
							$stmt2->bind_param("isssssssssi", $id, $apellidos,$nombre, $dni, $direccion,$telefono, $email, $estudios, $tecnologias, $preferencias, $id_tutor);
							$stmt2->execute();
								if ($stmt2->errno) {  
								  $flag = false;  
								}
						
						if (!$flag) { 

						$conectar->basedatos->rollback(); 
					    $resultado['errores'][]="El usuario ".$nombre." ".$apellidos." ya existe";  
					    
					    }else{
					    $conectar->basedatos->commit();
						if(!enviar_email($email, $nombre, $usuario, $pass_usuario )){
							$resultado['errores'][]="No se ha podido enviar el email a ".$nombre." ".$apellidos;
						}
						
						
						}


					}else{
						$resultado['errores'][]=$respuesta;
					}
					
				}
					
				}
	
			}
				
		}
		
	} else {
		$resultado['errores']='Archivo inválido';
	}
	$stmt1->close();
	$stmt2->close();
	fclose($fichero);
	echo json_encode($resultado);
	





 ?>