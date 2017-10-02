<?php 

	class Empresa extends Conexion{
		protected $id;
		protected $razonsocial;
		protected $direccion;
		protected $email;
		protected $telefono;
		protected $tutor;
		protected $estado;


		function __construct(){
			$argumentos = func_get_args();
			if (func_num_args() == 1) {
				parent::__construct();
				$this->id=$this->basedatos->real_escape_string(func_get_arg(0));
			/*}elseif (func_num_args() == 2) {
				parent::__construct();
				$this->usuario=$this->basedatos->real_escape_string(func_get_arg(0));
				$this->password_usuario=$this->basedatos->real_escape_string(func_get_arg(1));
			}elseif (func_num_args() == 3) {
				parent::__construct();
				$this->id=$this->basedatos->real_escape_string(func_get_arg(0));
				$this->usuario=$this->basedatos->real_escape_string(func_get_arg(1));
				$this->tipo=$this->basedatos->real_escape_string(func_get_arg(2));*/
			}elseif(func_num_args() == 6){
				parent::__construct();
				$this->razonsocial=$this->basedatos->real_escape_string(func_get_arg(0));
				$this->direccion=$this->basedatos->real_escape_string(func_get_arg(1));
				$this->email=$this->basedatos->real_escape_string(func_get_arg(2));
				$this->telefono=$this->basedatos->real_escape_string(func_get_arg(3));
				$this->tutor=$this->basedatos->real_escape_string(func_get_arg(4));
				$this->estado=$this->basedatos->real_escape_string(func_get_arg(5));
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

	    public static function recuperar_empresas(){
		  	$conectar=new Conexion();
		  	$sql="SELECT * FROM empresas";
		  	$resultado = $conectar->basedatos->query($sql); 
			if($conectar->basedatos->errno){
			    die("Error conectando a la BD: " . $mysqli->connect_error);
			}

			$datos['data']=array();

			while($fila = $resultado -> fetch_assoc()){
			  $datos['data'][]=$fila;
			      
			}
			$conectar->basedatos->close();
			return $datos;
		  }

		public function recuperar_empresa(){
			$sql="SELECT * FROM empresas WHERE id='$this->id'";
		  	$resultado = $this->basedatos->query($sql); 
			if($this->basedatos->errno){
			    return 0;
			}
			$fila = $resultado -> fetch_assoc();
			
			return $fila;
		}


		/*function enviar_email($email, $nombre, $usuario, $passwd ){
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

		}*/

		public function registro_empresa(){
	      $sql = "INSERT INTO 
	      empresas (razon_social, direccion, email, telefono, tutor, estado) 
	      VALUES 
	          ('$this->razonsocial','$this->direccion', '$this->email', '$this->telefono', '$this->tutor', '$this->estado')";  
	      $this->basedatos->query($sql);
	      if($this->basedatos->errno){
	        return 1;
	      }
	      	$id=$this->basedatos->insert_id;
			$this->id=$id;
	  	}

		public function modificar_empresa($id, $razonsocial, $direccion, $email, $telefono, $tutor, $estado){
		    $id=$this->basedatos->real_escape_string($id);
		    $razonsocial=$this->basedatos->real_escape_string($razonsocial);
		    $direccion=$this->basedatos->real_escape_string($direccion);
		    $email=$this->basedatos->real_escape_string($email);
		    $telefono=$this->basedatos->real_escape_string($telefono);
		    $tutor=$this->basedatos->real_escape_string($tutor);
		    $estado=$this->basedatos->real_escape_string($estado);
		  	
		    $sql = "UPDATE 
				empresas SET 
		        razon_social='$razonsocial', direccion='$direccion', email='$email', telefono='$telefono', tutor='$tutor', estado='$estado' WHERE id='$id'"; 

		  $this->basedatos->query($sql); 
		  if($this->basedatos->errno){
		        return 1;
		  }
		  
		  $resultado=$this->recuperar_empresa();

		  return $resultado;
		}



	}

	




 ?>