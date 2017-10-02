<?php 
function validar_dni($dni){
    $validChars = 'TRWAGMYFPDXBNJZSQVHLCKET';
    $nifRexp = '/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i';
    $nieRexp = '/^[XYZ]{1}[0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i';
    $str = strtoupper(strval($dni));
    
    if (!preg_match($nifRexp,$str) && !preg_match($nieRexp,$str)){
        $resultado=false;
    } 
    $nie = str_replace('X', '0', $str);
    $nie = str_replace('Y', '1', $str);
    $nie = str_replace('Z', '2', $str);
 
    $letter = substr($str,-1);
    $charIndex = (int)substr($nie,0, 8) % 23;
 
    if (substr($validChars,$charIndex,1)=== $letter){
        $resultado=true;
    } else{
        $resultado=false;
    }

    return $resultado;
}

function validateDate($fecha, $formato='Y-m-d'){
    $d = DateTime::createFromFormat($formato, $fecha);
    return $d && $d->format($formato) == $fecha;
}

function validar_telefono($telefono){
    $patrontelefono="/^\d{9}$/";
    if( !preg_match($patrontelefono, $telefono) ){
            return false;
    }else{
        return true;
    }  
}

function validar_texto($texto){
     $patron_texto = "/^[a-zA-Z0-9áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñçÇ\s\.\,\:\¿?\¡!]+$/";
    if( !preg_match($patron_texto, $texto) ){  
        return false;
    }else{
        return true;
    }  
}
function validar_direccion($texto){
     $patron_texto = "/^[a-zA-Z0-9áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑñçÇ\s\/\.\,\-\(\)]+$/";
    if( !preg_match($patron_texto, $texto) ){  
        return false;
    }else{
        return true;
    }  
}

function validar_mail($mail){
   $patronmail="/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
    if( !preg_match($patronmail, $mail) ){
        return false;
    }else{
        return true;
    }  
}

function verificardatos($nombre,$apellidos,$dni,$telefono,$email,$contador){
    $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
    $patrontelefono="/^\d{9}$/";
    $patronmail="/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/";
    $resultado['errores']=null;
    // Nombre:
    if( empty($nombre) ){
        $resultado['errores'][] = "Debe especificar el nombre del alumno ".$contador;
        
    }else if ( !preg_match($patron_texto, $nombre) ){
        $resultado['errores'][] = "El nombre sólo puede contener letras y espacios del alumno ".$contador; 
        
    }
    // Apellidos:
    if( empty($apellidos) ){
        $resultado['errores'][] = "Debe especificar los apellidos del alumno ".$contador;
        
    }else if( !preg_match($patron_texto, $apellidos) ){
        $resultado['errores'][] = "Los apellidos sólo puede contener letras y espacios del alumno ".$contador;
        
    }
    //DNI:
    if( empty($dni) ){
        $resultado['errores'][] = "Debe especificar el dni del alumno ".$contador;
        
    }else if( !validar_dni($dni) ){
        $resultado['errores'][] = "El DNI no es válido del alumno ".$contador;
        
    }
    //Teléfono:
    if( empty($telefono) ){
        $resultado['errores'][] = "Debe especificar el teléfono del alumno ".$contador;
        
    }else if( !preg_match($patrontelefono, $telefono) ){
        $resultado['errores'][] = "El teléfono no es válido del alumno ".$contador;
        
    }
    //Email:
     if( empty($email) ){
        $resultado['errores'][] = "Debe especificar el email del alumno ".$contador;
        
    }else if( !preg_match($patronmail, $email) ){
        $resultado['errores'][] = "El email no es válido del alumno ".$contador;
        
    }
    return $resultado['errores'];

}

function generaUsuario($apellidos,$nombre){
    
    $str2=sanear_string($apellidos);
    $str3=sanear_string($nombre);
    $str2=substr($str2, 0, 3);
    $str3=substr($str3, 0, 3);
    $usuario="FCT".date('y').$str2.$str3;
    return $usuario;
}

function generaPass(){
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=10;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}

function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
 
    return $string;
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

 

function actualiza_fecha($fecha, $horas_realizadas, $jornada, $total_horas){
   
    if($horas_realizadas==0){
        $fech=new DateTime();
    }else{
       $fech=new DateTime($fecha); 
    }

    $días_pendientes=($total_horas-$horas_realizadas)/$jornada;

    for($i=0;$i<$días_pendientes;$i++){

        $fech=$fech->add(new DateInterval('P1D'));
        if($fech->format('w')==0 || $fech->format('w')==6){
            $i--;    
        }
          
    }
    return $fech;
}    




 ?>