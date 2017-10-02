<?php 


$id_alumno=$_SESSION['id'];

$alumno=new Alumno($id_alumno);

$datos=$alumno->recuperar_alumno();
if($datos==0){
  $tituloError='Error de conexión';
  $ContenidoError='No se ha podido conectar con la base de datos';
  include('alertas.php');
  echo $alerta;
}

$contadoravisos=0;
$conexion=new Conexion();
$sql="SELECT * FROM avisos WHERE id_alumno='$id_alumno'";
$resultado = $conexion->basedatos->query($sql); 
while($fila = $resultado -> fetch_assoc()){
  if($fila['estado']==0){
    $contadoravisos++;
  }
      
}

$corpo='<!--Cabecera-->
<input type="hidden" id="opcion_alumno" name="opcion_alumno" value="'.$id_alumno.'">
<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
  <div class="col-md-6">
  <div class="pull-left">
    <button type="button" id="btnactividades" class="btn btn-default navbar-btn">Actividades</button>
    <button type="button" id="btnperfil" class="btn btn-default navbar-btn">Cambiar perfil</button>
    <button type="button" id="btnavisos" class="btn btn-default navbar-btn">Avisos ('.$contadoravisos.')</button>
    <button type="button" id="btncalendario" class="btn btn-default navbar-btn">Ver calendario</button>
    </div>
    </div>
    <div class="col-md-6">
  	<div class="pull-right">
    <button type="button" id="mailButton" class="btn btn-default navbar-btn">Enviar email</button>
    <button type="button" id="passButton" class="btn btn-default navbar-btn">Cambiar Contraseña</button>
    <button type="button" id="LogoutButton" class="btn btn-default navbar-btn">Cerrar Sesión</button>
    </div>
    </div>
    
  </div>
</nav>
</div>

 <!--formulario perfil-->
      <div class="modal fade" id="myModalPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Modificar datos</h4>
            </div>
            <div class="modal-body">
              <!--FORMULARIO-->
              <form class="form-horizontal" id="formularioperfil">
              <!--El input que va a continuación solamente vale como elemento al que yo puedo cambiar el valor para poder ejecutar los diferentes casos del switch-->
                <input type="hidden" id="opcion" name="opcion" value="">
                  
                <input type="hidden" class="form-control" name="id" id="id" value="'.$datos["id"].'">              
                <div class="form-group" id="divapellidos">
                  <div class="col-sm-12">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" value="'.$datos["apellidos"].'">
                    <span id="helpBlock10" class="help-block hide">No has introducido los apellidos</span>
                  </div>
                </div>

                <div class="form-group" id="divnombre">
                  <div class="col-sm-12">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="'.$datos["nombre"].'">
                    <span id="helpBlock20" class="help-block hide">No has introducido el nombre de usuario</span>
                  </div>
                </div>

                <div class="form-group" id="divdni">
                  <div class="col-sm-12">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="'.$datos["dni"].'">
                    <span id="helpBlock30" class="help-block hide">No has introducido el DNI</span>
                  </div>
                </div>

                <div class="form-group" id="divdireccion">
                  <div class="col-sm-12">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="'.$datos["direccion"].'">
                    <span id="helpBlock40" class="help-block hide">La dirección no es correcta</span>
                  </div>
                </div>

                <div class="form-group" id="divtelefono">
                  <div class="col-sm-12">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="'.$datos["telefono"].'">
                    <span id="helpBlock50" class="help-block hide">No has introducido el teléfono</span>
                  </div>
                </div>

                <div class="form-group" id="divemail">
                  <div class="col-sm-12">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="'.$datos["email"].'">
                    <span id="helpBlock60" class="help-block hide">No has introducido el email</span>
                  </div>
                </div>

                <div class="form-group" id="divestudios">
                  <div class="col-sm-12">
                    <label for="estudios">Estudios Previos</label>
                      <textarea class="form-control" rows="3" id="estudios" name="estudios">'.$datos["estudios"].'</textarea>
                      <span id="helpBlock70" class="help-block hide">Los estudios no son correctos</span>
                  </div>
                </div>

                <div class="form-group" id="divtecnologias">
                  <div class="col-sm-12">
                    <label for="tecnologias">Tecnologías que maneja</label>
                      <textarea class="form-control" rows="3" id="tecnologias" name="tecnologias">'.$datos["tecnologias"].'</textarea>
                      <span id="helpBlock80" class="help-block hide">Las tecnologías no son correctas</span>
                  </div>
                </div>

                <div class="form-group" id="divpreferencias">
                  <div class="col-sm-12">
                    <label for="preferencias">Preferencias</label>
                      <textarea class="form-control" rows="3" id="preferencias" name="preferencias">'.$datos["preferencias"].'</textarea>
                      <span id="helpBlock90" class="help-block hide">Las preferencias no son correctas</span>
                  </div>
                </div>
  
              </form>
              <br>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="botonCerrarPerfil">Cerrar</button>
              <button type="button" class="btn btn-primary" id="botonModalPerfil">Modificar</button>
            </div>
          </div>
        </div>
      </div>
      </div>
<div class="container" id="cuerpo">

<!--TABLA-->
    <div class="panel panel-info">
    <!-- Default panel contents -->
    <div class="panel-heading">Registro de actividades</div>
    <div class="panel-body">
      <table id="alumnofct" class="table table-striped table-bordered table-hover table-condensed" width="100%" cellspacing="0">
          <thead>
              <tr>
                  <th>id</th>
                  <th>Día</th>
                  <th>Horas</th>
                  <th>Observaciones</th>
                  <th></th>
              </tr>
          </thead>
        </table>
       </div>
     </div>
  

    <!--formulario modal-->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Añadir día</h4>
            </div>
            <div class="modal-body">
              <!--FORMULARIO-->
              <form class="form-horizontal" id="formulario">
              <!--El input que va a continuación solamente vale como elemento al que yo puedo cambiar el valor para poder ejecutar los diferentes casos del switch-->
                
                <input type="hidden" id="opcion" name="opcion" value="cambiar"> 
                <input type="hidden" class="form-control" name="id_registro" id="id_registro"> 
          
                <div class="col-sm-7 ">
                   <div class="form-group" id="divfecha">
                    <label for="fecha">Fecha</label>
                    <input type="text" class="form-control" name="fecha" id="datepicker">
                    <span id="helpBlock1" class="help-block hide">No has introducido la fecha</span>
                  </div>
                </div>

                
                  <div class=" col-sm-offset-2 col-sm-3 ">
                  <div class="form-group" id="divhoras">
                    <label for="horas">Horas</label>
                    <input type="number" class="form-control" id="horas" name="horas">
                    <span id="helpBlock2" class="help-block hide">No has introducido las horas</span>
                  </div>
                </div>
              

                <div class="form-group" id="divobservaciones">
                  <div class="col-sm-12">
                    <label for="observaciones">Observaciones</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="5"></textarea>
                    <span id="helpBlock3" class="help-block hide">No has introducido las observaciones</span>
                  </div>
                </div>


  
              </form>
              <div></div>
              <br>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="botonCerrar">Cerrar</button>
              <button type="button" class="btn btn-primary" id="botonModal"></button>
            </div>
          </div>
        </div>
      </div>
      </div>

         
	
</div>
';














 ?>