<?php 


class Alumno extends Usuario{
		
		protected $apellidos;
		protected $nombre;
		protected $dni;
		protected $direccion;
		protected $telefono;
		protected $email;
		protected $estudios;
		protected $tecnologias;
		protected $preferencias;
    protected $id_tutor;




 public function __construct() { 
        $argumentos = func_get_args();
      if (func_num_args() == 1){
        parent::__construct(func_get_arg(0));
      }elseif(func_num_args() == 15){
        parent::__construct(func_get_arg(0), func_get_arg(1), func_get_arg(2),func_get_arg(3), func_get_arg(4));
        $this->apellidos=$this->basedatos->real_escape_string(func_get_arg(5));
        $this->nombre=$this->basedatos->real_escape_string(func_get_arg(6));
        $this->dni=$this->basedatos->real_escape_string(func_get_arg(7));
        $this->direccion=$this->basedatos->real_escape_string(func_get_arg(8));
        $this->telefono=$this->basedatos->real_escape_string(func_get_arg(9));
        $this->email=$this->basedatos->real_escape_string(func_get_arg(10));
        $this->estudios=$this->basedatos->real_escape_string(func_get_arg(11));
        $this->tecnologias=$this->basedatos->real_escape_string(func_get_arg(12));
        $this->preferencias=$this->basedatos->real_escape_string(func_get_arg(13));
        $this->id_tutor=$this->basedatos->real_escape_string(func_get_arg(14));
      }
    
    

  }

  public function registro_alumno(){
    $bandera=true;
    $this->basedatos->begin_transaction();
  	$respuesta=$this->registro_usuario($this->usuario, $this->password_usuario, $this->tipo, $this->alta);
    if($respuesta==0){
      return 1;
    }elseif($respuesta==1){
      $sql = "INSERT INTO 
      alumno (id, apellidos, nombre, dni, direccion, telefono, email, estudios, tecnologias, preferencias, id_tutor) 
      VALUES 
          ('$this->id', '$this->apellidos','$this->nombre', '$this->dni', '$this->direccion', '$this->telefono', '$this->email', '$this->estudios', '$this->tecnologias', '$this->preferencias', '$this->id_tutor')";  

      $this->basedatos->query($sql);
      if($this->basedatos->errno){
        $bandera=false;
      }
    } 
    if($bandera){
       $this->basedatos->commit(); 
    } else{
      $this->basedatos->rollback(); 
      return 1;
    }   
  }

  public function modificar_alumno($id, $apellidos, $nombre, $dni, $direccion, $telefono, $email, $estudios, $tecnologias, $preferencias){
    $id=$this->basedatos->real_escape_string($id);
    $apellidos=$this->basedatos->real_escape_string($apellidos);
    $nombre=$this->basedatos->real_escape_string($nombre);
    $dni=$this->basedatos->real_escape_string($dni);
    $direccion=$this->basedatos->real_escape_string($direccion);
    $telefono=$this->basedatos->real_escape_string($telefono);
    $email=$this->basedatos->real_escape_string($email);
    $estudios=$this->basedatos->real_escape_string($estudios);
    $tecnologias=$this->basedatos->real_escape_string($tecnologias);
    $preferencias=$this->basedatos->real_escape_string($preferencias);
  	
    $sql = "UPDATE 
		alumno SET 
        apellidos='$apellidos', nombre='$nombre', dni='$dni', direccion='$direccion',  telefono='$telefono', email='$email', estudios='$estudios', tecnologias='$tecnologias', preferencias='$preferencias' WHERE id='$id'"; 

	$this->basedatos->query($sql); 
  if($this->basedatos->errno){
        return 1;
  }
  
	$resultado=$this->recuperar_alumno();

  return $resultado;
  }

  public function recuperar_alumno(){
  	$sql="SELECT * FROM alumno WHERE id=$this->id";
	$resultado=$this->basedatos->query($sql); 
	if($this->basedatos->errno){
        return 0;
  }
	$fila = $resultado -> fetch_assoc();
	return $fila;
  }



  public static function recuperar_alumnos(){
  	$conectar=new Conexion();
  	$sql="SELECT * FROM alumno A INNER JOIN usuario U ON U.id = A.id WHERE U.activo=1";
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

  public function datos_fct(){
  
    $sql="SELECT * FROM fcthoras WHERE id_alumno='$this->id'";
    $resultado=$this->basedatos->query($sql); 
    if($this->basedatos->errno){
          return 1;
    }
    $datos['data']=array();

    while($fila = $resultado -> fetch_assoc()){
      $datos['data'][]=$fila;
          
    }
    return $datos;
   
  }

  public function inserta_horas($fecha, $num_horas, $observaciones){
    //$id_alumno=$this->id;
    $fecha=$this->basedatos->real_escape_string($fecha);
    $num_horas=$this->basedatos->real_escape_string($num_horas);
    $observaciones=$this->basedatos->real_escape_string($observaciones);
    $sql = "INSERT INTO 
      fcthoras (id_alumno, fecha, num_horas, observaciones) 
      VALUES 
          ('$this->id', '$fecha','$num_horas', '$observaciones')";  

      $this->basedatos->query($sql);
      if($this->basedatos->errno){
        return 1;
      }else{
      $id=$this->basedatos->insert_id;
     
      
      $sql="SELECT inicio,jornada, total_horas FROM fct WHERE id_alumno='$this->id'";
      $resultado=$this->basedatos->query($sql);
      
      while($fila = $resultado -> fetch_assoc()) { 
        $inicio= $fila['inicio'];
        $total_horas=$fila['total_horas'];
        $jornada=$fila['jornada'];
      } 
      
      $sql="SELECT num_horas FROM fcthoras WHERE id_alumno='$this->id'";
      $res=$this->basedatos->query($sql);
      $horas=0;
      
      while($fila = $res -> fetch_assoc()) { 
        $horas+=$fila['num_horas'];
      } 
     
      $fechafin=date_format(actualiza_fecha($fecha,$horas, $jornada, $total_horas), 'Y-m-d');

      $sql="UPDATE fct SET fin='$fechafin' WHERE id_alumno='$this->id'";
      $this->basedatos->query($sql);
      return $id;
      }




  }

  public function modificardatos_fct($id_registro, $fecha, $horas, $observaciones){
    $id_registro=$this->basedatos->real_escape_string($id_registro);
    $fecha=$this->basedatos->real_escape_string($fecha);
    $horas=$this->basedatos->real_escape_string($horas);
    $observaciones=$this->basedatos->real_escape_string($observaciones);
    $sql="UPDATE 
    fcthoras SET 
        fecha='$fecha', num_horas='$horas', observaciones='$observaciones' WHERE id='$id_registro'"; 
    $this->basedatos->query($sql);
    if($this->basedatos->errno){
        return 1;
    }else{
      $resultado=$this->recuperadatos_fct($id_registro);
      return $resultado;
    }
    
  }

  public function eliminardatos_fct($id_registro){
    $id_registro=$this->basedatos->real_escape_string($id_registro);
    
    $sql="DELETE FROM  fcthoras WHERE id='$id_registro'"; 
    $this->basedatos->query($sql);
    if($this->basedatos->errno){
        return 1;
    }else{
      return 0;
      
    }
    
  }

  public function recuperadatos_fct($id){
    $sql="SELECT * FROM fcthoras WHERE id='$id'";
    $resultado=$this->basedatos->query($sql); 
    if($this->basedatos->errno){
        return 0;
    }
    $fila = $resultado -> fetch_assoc();
    return $fila;
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

}

 ?>