<?php

define('RAIZ',$_SERVER['DOCUMENT_ROOT']);
require_once(RAIZ.'/ProyectoFinal/plugins/funciones.php'); 
function mi_autocargador($clase) {
  require_once(RAIZ.'/ProyectoFinal/clases/' . $clase . '.php');
}
spl_autoload_register('mi_autocargador');


//session_name ("proyecto");
session_start();
$script="";

if (isset($_POST['enviar']) || !empty($_SESSION)){
	if(isset($_POST['enviar'])){
		$nombre=$_POST['exampleInputName2'];
		$pass=$_POST['exampleInputPassword1'];

		if(validar_texto($nombre) && validar_texto($pass)){
			$acceso=new Usuario($nombre,$pass);
			$fila=$acceso->acceder();
		   
		    if ($fila == 0){ 
		    	$tituloError='Error de conexión';
		    	$ContenidoError='El usuario no existe';
		    	include('alertas.php');
		    	echo $alerta;
		    	include('login.php');

		    }elseif($fila==1) {
				$tituloError='Error de conexión';
			    	$ContenidoError='La contraseña no es correcta';
			    	include('alertas.php');
			    	echo $alerta;
				 	include('login.php');
			}else {
				if($fila['activo']=='1') {
					 	if($fila['baja']==null){
			 			    $_SESSION['usuario'] = $fila['usuario'];
			 			    $_SESSION['tipo']=$fila['tipousuario'];
			 			    $_SESSION['id'] = $fila['id'];
			 			    $_SESSION['alta']=$fila['alta'];
			 			    $_SESSION['baja'] = $fila['baja'];
			 			    $_SESSION['activo']=$fila['activo'];
			 			    switch ($fila['tipousuario']) {
			 			    	case '1':
			 			    		$script='<script type="text/javascript" src="administrador/administrador.js"></script>';
			 			    		include('administrador/administrador.php');
			 			    		break;
			 			    	case '2':
			 			    		$script='<script type="text/javascript" src="alumno/alumnofct.js"></script>';
			 			    		include('alumno/alumno.php');
			 			    		break;
			 			    	case '3':
			 			    		$script='<script type="text/javascript" src="tutor/tutorfct.js"></script>';
			 			    		include('tutor/tutor.php');
			 			    		break;
			 			    	
			 			    }
			 			}else{
			 				$tituloError='Error de conexión';
					    	$ContenidoError='El usuario ha sido dado de baja';
					    	include('alertas.php');
					    	echo $alerta;
			 				include('login.php');
			 			}
			 		}else{
			 			$tituloError='Error de conexión';
				    	$ContenidoError='El usuario ya no está activo';
				    	include('alertas.php');
				    	echo $alerta;
			 			include('login.php');
			 		}
			}
		}else{
			$tituloError='Error de conexión';
	    	$ContenidoError='Los datos no son correctos';
	    	include('alertas.php');
	    	echo $alerta;
 			include('login.php');
		}

	}else{
		switch ($_SESSION['tipo']) {
		 			    	case '1':
		 			    		$script='<script type="text/javascript" src="administrador/administrador.js"></script>';
		 			    		include('administrador/administrador.php');
		 			    		break;
		 			    	case '2':
		 			    		$script='<script type="text/javascript" src="alumno/alumnofct.js"></script>';
		 			    		include('alumno/alumno.php');
		 			    		break;
		 			    	case '3':
		 			    		$script='<script type="text/javascript" src="tutor/tutorfct.js"></script>';
		 			    		include('tutor/tutor.php');
		 			    		break;
		 			    	
		 }
	}

}else{
	include('login.php');
}


include ('cabecera.php');
include ('pie.php');
echo $cabecera;
echo $corpo;
echo $pie;
//echo $script;



?>