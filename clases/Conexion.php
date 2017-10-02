<?php 

define("DB_HOST","localhost" );  
define("DB_USER", "testuser");  
define("DB_PASS", "testpassword");  
define("DB_DATABASE", "proyecto" );

class Conexion 
{ 
    protected $basedatos; 

    public function __construct() 
    { 
        $this->basedatos = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);  

        $this->basedatos->query("SET NAMES utf8"); //PARA CARACTERES ESPECIALES EN LA BASE DE DATOS, sino el json no codifica bien!!!!!!!
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