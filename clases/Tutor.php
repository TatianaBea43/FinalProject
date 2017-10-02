<?php 

class Tutor extends Usuario{
		
		protected $apellidos;
		protected $nombre;
		protected $dni;
		protected $telefono;
		protected $email;




 public function __construct() {

    $argumentos = func_get_args();
    if (func_num_args() == 1){
      parent::__construct(func_get_arg(0));
    }elseif(func_num_args() == 10) {
      parent::__construct(func_get_arg(0), func_get_arg(1), func_get_arg(2), func_get_arg(3), func_get_arg(4));
      $this->apellidos=$this->basedatos->real_escape_string(func_get_arg(5));
      $this->nombre=$this->basedatos->real_escape_string(func_get_arg(6));
      $this->dni=$this->basedatos->real_escape_string(func_get_arg(7));
      $this->telefono=$this->basedatos->real_escape_string(func_get_arg(8));
        $this->email=$this->basedatos->real_escape_string(func_get_arg(9));
    }
    
    

  }

  public function registro_tutor(){
    $bandera=true;
    $this->basedatos->begin_transaction();
  	$respuesta=$this->registro_usuario($this->usuario, $this->password_usuario, $this->tipo, $this->alta);
  	if($respuesta==0){
      return 1;
    }elseif($respuesta==1){
      $sql = "INSERT INTO 
  		tutor (id, apellidos, nombre, dni, telefono, email) 
  		VALUES 
          ('$this->id', '$this->apellidos','$this->nombre', '$this->dni', '$this->telefono', '$this->email')";  

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

 
  public function modificar_tutor($id, $apellidos, $nombre, $dni, $telefono, $email){
    $id=$this->basedatos->real_escape_string($id);
    $apellidos=$this->basedatos->real_escape_string($apellidos);
    $nombre=$this->basedatos->real_escape_string($nombre);
    $dni=$this->basedatos->real_escape_string($dni);
    $telefono=$this->basedatos->real_escape_string($telefono);
    $email=$this->basedatos->real_escape_string($email);
  	
    $sql = "UPDATE 
		tutor SET 
        apellidos='$apellidos', nombre='$nombre', dni='$dni', telefono='$telefono', email='$email'  WHERE id='$id'"; 

	  $this->basedatos->query($sql); 
    if($this->basedatos->errno){
        return 1;
    }

	$resultado=$this->recuperar_tutor();
  return $resultado;
  }

  public function recuperar_tutor(){
  	$sql="SELECT * FROM tutor WHERE id=$this->id";
  	$resultado=$this->basedatos->query($sql); 
  	if($this->basedatos->errno){
        return 0;
    }
  	$fila = $resultado -> fetch_assoc();
  	return $fila;
  }

  public static function recuperar_tutores(){
  	$conectar=new Conexion();
  	$sql="SELECT * FROM tutor T INNER JOIN usuario U ON U.id = T.id WHERE U.activo=1";
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

  public function lista_alumnos($id){

  $sql="SELECT * FROM alumno A INNER JOIN usuario U ON U.id = A.id WHERE U.activo=1 AND A.id_tutor='$id'";
    $resultado = $this->basedatos->query($sql); 
  
  if($this->basedatos->errno){
        die("Error conectando a la BD: " . $this->basedatos->connect_error);
  }

  $datos['data']=array();

  while($fila = $resultado -> fetch_assoc()){
    $datos['data'][]=$fila;
        
  }
  $this->basedatos->close();
  return $datos;

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