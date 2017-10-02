<?php 

	class Usuario extends Conexion{
		protected $id;
		protected $usuario;
		protected $password_usuario;
		protected $tipo;
		protected $alta;
		protected $baja;
		protected $activo;

		function registro_usuario($usuario, $passwd, $tipousuario, $alta){
			$pass=password_hash($passwd, PASSWORD_DEFAULT);
			$sql = "INSERT INTO usuario (usuario, passwd, tipousuario, alta, activo) VALUES ('$usuario', '$pass', '$tipousuario', '$alta', '1')";
			$this->basedatos->query($sql); 
			if($this->basedatos->errno) {
				return 0;
			}else{
				$id=$this->basedatos->insert_id;
				$this->id=$id;
				return 1;
			}
			
		}

		function __construct(){
			$argumentos = func_get_args();
			if (func_num_args() == 1) {
				parent::__construct();
				$this->id=$this->basedatos->real_escape_string(func_get_arg(0));
			}elseif (func_num_args() == 2) {
				parent::__construct();
				$this->usuario=$this->basedatos->real_escape_string(func_get_arg(0));
				$this->password_usuario=$this->basedatos->real_escape_string(func_get_arg(1));
			}elseif (func_num_args() == 3) {
				parent::__construct();
				$this->id=$this->basedatos->real_escape_string(func_get_arg(0));
				$this->usuario=$this->basedatos->real_escape_string(func_get_arg(1));
				$this->tipo=$this->basedatos->real_escape_string(func_get_arg(2));
			}elseif(func_num_args() == 5){
				parent::__construct();
				$this->usuario=$this->basedatos->real_escape_string(func_get_arg(0));
				$this->password_usuario=$this->basedatos->real_escape_string(func_get_arg(1));
				$this->tipo=$this->basedatos->real_escape_string(func_get_arg(2));
				$this->alta=$this->basedatos->real_escape_string(func_get_arg(3));
				$this->activo=$this->basedatos->real_escape_string(func_get_arg(4));
			}
			
		    
		}

		 public function __set($atributo, $valor) {  
	      if (property_exists(__CLASS__, $atributo)) {  
	        $this->$atributo = $valor;  
	      } else {  
	        echo "No existe el atributo $atributo.";  
	      }  
	    }  
	    public function __get($atributo) {  
	      if (property_exists(__CLASS__, $atributo)) {  
	        return $this->$atributo;  
	      }  
	      return NULL;  
	    } 

	    public function acceder(){
	    	$sql = "SELECT * FROM usuario WHERE usuario='$this->usuario'";
		    $resultado=$this->basedatos->query($sql); 
		    if ($resultado->num_rows == 0){
		    	$respuesta=0;
		    }
		    else{
		    	$fila = $resultado -> fetch_assoc();
				if (password_verify($this->password_usuario, $fila['passwd'])){
					$respuesta=$fila;
				}else{
					$respuesta=1;				}
		    }

		    return $respuesta;
	    }


	    public static function recuperar_usuarios(){
		  	$conectar=new Conexion();
		  	$sql="SELECT U.id, usuario , A.apellidos, A.nombre,  A.email, tipousuario, alta, baja, activo   
		  	FROM usuario U INNER JOIN alumno A ON U.id = A.id";
		  	$resultado = $conectar->basedatos->query($sql); 
			if($conectar->basedatos->errno){
			    die("Error conectando a la BD: " . $mysqli->connect_error);
			}

			$datos['data']=array();

			while($fila = $resultado -> fetch_assoc()){
			  $datos['data'][]=$fila;
			      
			}
			$sql="SELECT U.id, usuario , T.apellidos, T.nombre,  T.email, tipousuario, alta, baja, activo   
		  	FROM usuario U INNER JOIN tutor T ON U.id = T.id";
		  	$resultado = $conectar->basedatos->query($sql); 
			if($conectar->basedatos->errno){
			    return 0;
			}

			while($fila = $resultado -> fetch_assoc()){
			  $datos['data'][]=$fila;
			      
			}
			$conectar->basedatos->close();
			return $datos;
		  }

		public function recuperar_usuario(){
			if($this->tipo=='2'){
				$sql="SELECT U.id, usuario , A.apellidos, A.nombre, A.email, tipousuario, alta, baja, activo   
			  	FROM usuario U INNER JOIN alumno A ON U.id = A.id WHERE U.id='$this->id'";
			  	$resultado = $this->basedatos->query($sql); 
				if($this->basedatos->errno){
				    return 0;
				}
				$fila = $resultado -> fetch_assoc();
			
			}elseif($this->tipo=='3'){
				$sql="SELECT U.id, usuario , T.apellidos, T.nombre, T.email, tipousuario, alta, baja, activo   
		  		FROM usuario U INNER JOIN tutor T ON U.id = T.id WHERE U.id='$this->id'";
			  	$resultado = $this->basedatos->query($sql); 
				if($this->basedatos->errno){
			    return 0;
				}
				$fila = $resultado -> fetch_assoc();

			}
		  	
			return $fila;
		}



		function __call($method_name, $arguments) {
		    $accepted_methods = array("cambiar_pass");
		    /*/if(!in_array($method_name, $accepted_methods)) {
		      throw new Exception('Este método no existe');
		    }*/
		    if(count($arguments) == 1) {
		        $pass=password_hash($arguments[0], PASSWORD_DEFAULT);
				return $pass;
		    } elseif(count($arguments) == 2) {
		    	$respuesta="";
		    	$sql = "SELECT * FROM usuario WHERE id='$this->id'";
		    	$resultado=$this->basedatos->query($sql);
		    	$fila = $resultado -> fetch_assoc();
				if (password_verify($arguments[0], $fila['passwd'])){
					$pass=password_hash($arguments[1], PASSWORD_DEFAULT);
			      	$sql = "UPDATE usuario SET  passwd='$pass'  WHERE id='$this->id'"; 
					$this->basedatos->query($sql);
					if($this->basedatos->errno){
				    return 0;
					}
					$respuesta=1;
				}else{
					$respuesta=2;	
				}
				return $respuesta;
		      	
		    } 
		  }
	  

		function enviar_email($email, $nombre, $usuario, $passwd ){
			$destinatario = $email; 
			  $asunto = "Alta en el programa de FCT"; 
			  $cuerpo = ' 
			  <html> 
			  <head> 
			     <title>Claves de usuario</title> 
			  </head> 
			  <body> 
			  <h1>Hola '. $nombre.'</h1> 
			  <p> 
			  <b>Bienvenidos a la aplicación para la gestión de FCT</b>. Estas son tus claves para acceder al programa
			  </p> 
			  <p>Nombre usuario: '.$usuario.'</p>
			  <p>Contraseña: '.$passwd.'</p>
			  </body> 
			  </html> 
			  '; 

			  //para el envío en formato HTML 
			  $headers = "MIME-Version: 1.0\r\n"; 
			  $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
			  if(mail($destinatario,$asunto,$cuerpo,$headers)){
			      return 1;
			  } else {
				  return 0;
			  }

		}


		function alta_usuario($nombre, $passwd){
			$nombre=$this->basedatos->real_escape_string($nombre);
			$passwd=$this->basedatos->real_escape_string($passwd);
			$fechaalta=date('d/m/Y', time());
			$pass=$this->cambiar_pass($passwd);

			$sql = "UPDATE usuario SET usuario='$this->usuario', passwd='$pass', alta='$fechaalta', baja='', activo=1  WHERE id='$this->id'"; 
			$this->basedatos->query($sql);
			if($this->basedatos->errno){
			    return 0;
			} 
			
			//$this->enviar_email($email, $nombre, $this->usuario, $passwd);
			$resultado=$this->recuperar_usuario();
  			return $resultado;
		} 

		function baja_usuario(){
			$fechabaja=date('d/m/Y', time());

			$sql = "UPDATE usuario SET alta='', baja='$fechabaja', activo=0  WHERE id='$this->id'"; 
			$this->basedatos->query($sql); 
			if($this->basedatos->errno){
			    return 0;
			}
			if($this->tipo==2){
				$sql = "UPDATE alumno SET id_tutor=0 WHERE id='$this->id'"; 
				$this->basedatos->query($sql);
				if($this->basedatos->errno){
			    	return 0;
				} 
			}
			
			/*$resultado=$this->recuperar_usuario();
  			return $resultado;*/

		}
		function anadir_avisos($destino, $fecha, $texto, $estado){
			
			$sql="INSERT INTO avisos (id_alumno, fecha, aviso, estado) VALUES ('$destino','$fecha','$texto','$estado')";
			$this->basedatos->query($sql);
			if($this->basedatos->errno){
			    return 0;
			}else{
				return 1;
			}
			
		}

		function leer_avisos(){
			$sql="SELECT * FROM avisos WHERE id_alumno='$this->id'";
			$resultado = $this->basedatos->query($sql); 
			if($this->basedatos->errno){
			    return 0;
			}
			$datos['data']=array();

			while($fila = $resultado -> fetch_assoc()){
		 	 $datos['data'][]=$fila;
		      
			}

			return $datos;
		}

		function actualiza_avisos($id_aviso){
			$id=$id_aviso;
			$sql="UPDATE 
					avisos SET 
			        estado=1 WHERE id='$id'"; 
			$this->basedatos->query($sql);
			$sql="SELECT * FROM avisos WHERE estado=0 AND id_alumno='$this->id'";
			
			$resultado=$this->basedatos->query($sql);
			$numregs = $resultado->num_rows;
			
			return $numregs;
		}

		function introducir_eventos($fecha, $titulo,  $descripcion){
			 $sql = "INSERT INTO 
		      evento (id_alumno, evento, fecha_evento, descripcion) 
		      VALUES 
		          ('$this->id', '$titulo','$fecha','$descripcion')";  

		      $this->basedatos->query($sql);
		      if($this->basedatos->errno){
		        return 0;
		      }
		      $id=$this->basedatos->insert_id;
		      $sql="SELECT * FROM evento WHERE id='$id'";
		      $resultado=$this->basedatos->query($sql);
		      if($this->basedatos->errno){
		        return 1;
		      }
		      $fila = $resultado -> fetch_assoc();
			  return $fila;
		      
		}

		function ver_eventos(){
			$sql="SELECT * FROM evento WHERE id_alumno='$this->id'";
			$resultado = $this->basedatos->query($sql); 
			if($this->basedatos->errno){
			    return 1;
			}
			$datos['data']=array();

			while($fila = $resultado -> fetch_assoc()){
		 	 $datos['data'][]=$fila;
		      
			}

			return $datos;
		}

		function ver_proyecto(){
			$sql="SELECT empresa from fct WHERE id_alumno='$this->id'";
			$resultado = $this->basedatos->query($sql);
			$fila = $resultado -> fetch_array();
			if($fila[0]==0){
				$sql="SELECT * FROM fct WHERE id_alumno='$this->id'";
			}else{
				$sql="SELECT F.id, F.id_alumno, F.tutor, F.inicio,F.fin, F.empresa, F.total_horas, F.jornada, E.razon_social, E.email FROM fct F INNER JOIN empresas E
					ON F.empresa=E.id
					WHERE id_alumno='$this->id'";
			}

			$resultado = $this->basedatos->query($sql); 
			if($this->basedatos->errno){
			    return 1;
			}

			$fila = $resultado -> fetch_assoc();
			return $fila;
		}

		function anadir_proyecto($id_tutor, $fecha,  $empresa, $total_horas, $jornada ){
			$fechafin=actualiza_fecha($fecha, 0, $jornada, $total_horas);
			$fechafin=date_format($fechafin, 'Y-m-d');
			$sql="INSERT INTO fct( id_alumno, tutor, inicio, fin, empresa, total_horas, jornada) VALUES ('$this->id','$id_tutor','$fecha','$fechafin','$empresa','$total_horas','$jornada') ";
			$this->basedatos->query($sql);
			if($this->basedatos->errno){
			    return 0;
			}

			$resultado=$this->ver_proyecto();
			return $resultado;

		}

		function modificar_proyecto($id_registro, $fecha,  $empresa, $total_horas, $jornada){
			$fechafin=actualiza_fecha($fecha, 0, $jornada, $total_horas);
			$fechafin=date_format($fechafin, 'Y-m-d');
			$sql="UPDATE fct SET inicio='$fecha', fin='$fechafin', empresa='$empresa',total_horas='$total_horas', jornada='$jornada' WHERE id='$id_registro'";
			$resultado = $this->basedatos->query($sql);
			if($this->basedatos->errno){
			    return 0;
			}

			$resultado=$this->ver_proyecto();
			return $resultado;
		}
	}

	




 ?>