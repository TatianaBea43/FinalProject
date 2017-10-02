<?php 
$seleccion="";

$id_tutor=$_SESSION['id'];

$tutor=new Tutor($id_tutor);

$datos=$tutor->recuperar_tutor();
if($datos==0){
  $tituloError='Error de conexión';
  $ContenidoError='No se ha podido conectar con la base de datos';
  include('alertas.php');
  echo $alerta;
}

$empresas=Empresa::recuperar_empresas();
foreach ($empresas['data'] as $key => $value) {
  if($value['estado']==1){
    $seleccion.="<option value=".$value['id'].">".$value['razon_social']."</option>";
  }
  
}


$corpo='<!--Cabecera-->
<input type="hidden" id="opcion_alumno" name="opcion_alumno" value="">
<div class="container">
<nav class="navbar navbar-default">
  <div class="container-fluid">
  <div class="col-md-6">
  <div class="pull-left">
    <button type="button" id="btnperfil" class="btn btn-default navbar-btn">Cambiar perfil</button>
    <div class="btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Alumnos <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li ><a href="#" id="ver">Ver lista</a></li>
        <li ><a href="#" id="anadir">Añadir nuevo</a></li>
        <li ><a href="#" id="anadircsv">Añadir desde archivo</a></li>
        <li><a href="#" id="anadirlista">Añadir desde lista</a></li>
      </ul>
    </div>
    
    <button type="button" id="btnempresas" class="btn btn-default navbar-btn">Empresas</button>
    <button type="button" id="btnusuarios" class="btn btn-default navbar-btn">Usuarios</button>
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
<!--lista alumnos-->
<div class="modal fade" id="myModalLista" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-th-list"></span> Lista alumnos</h4>
      </div>
      <div class="modal-body" id="lista">
          <table id="listaalumnos" class="table table-striped table-bordered table-hover table-condensed" width="80%" cellspacing="0">
          <thead>
              <tr>
                  <th>id</th>
                  <th>Apellidos</th>
                  <th>Nombre</th>
                  <th>DNI</th>
                  <th></th>
              </tr>
          </thead>
        </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerraralumnos">Cerrar</button>
        <button type="button" class="btn btn-primary" name="enviarlista" id="enviarlista">Añadir</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modallistaalumnos -->


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
                
                  
                <input type="hidden" class="form-control" name="idperfil" id="idperfil" value="'.$datos["id"].'">              
                <div class="form-group" id="divapellidosperfil">
                  <div class="col-sm-12">
                    <label for="apellidosperfil">Apellidos</label>
                    <input type="text" class="form-control" name="apellidosperfil" id="apellidosperfil" value="'.$datos["apellidos"].'">
                    <span id="helpBlock10" class="help-block hide">No has introducido los apellidos</span>
                  </div>
                </div>

                <div class="form-group" id="divnombreperfil">
                  <div class="col-sm-12">
                    <label for="nombreperfil">Nombre</label>
                    <input type="text" class="form-control" id="nombreperfil" name="nombreperfil" value="'.$datos["nombre"].'">
                    <span id="helpBlock20" class="help-block hide">No has introducido el nombre de usuario</span>
                  </div>
                </div>

                <div class="form-group" id="divdniperfil">
                  <div class="col-sm-12">
                    <label for="dniperfil">DNI</label>
                    <input type="text" class="form-control" id="dniperfil" name="dniperfil" value="'.$datos["dni"].'">
                    <span id="helpBlock30" class="help-block hide">No has introducido el DNI</span>
                  </div>
                </div>

                <div class="form-group" id="divtelefonoperfil">
                  <div class="col-sm-12">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefonoperfil" name="telefonoperfil" value="'.$datos["telefono"].'">
                    <span id="helpBlock50" class="help-block hide">No has introducido el teléfono</span>
                  </div>
                </div>

                <div class="form-group" id="divemailperfil">
                  <div class="col-sm-12">
                    <label for="emailperfil">Email</label>
                    <input type="text" class="form-control" id="emailperfil" name="emailperfil" value="'.$datos["email"].'">
                    <span id="helpBlock60" class="help-block hide">No has introducido el email</span>
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
    <div class="panel-heading">Alumnos</div>
    <div class="panel-body">
      <table id="alumnos" class="table table-striped table-bordered table-hover table-condensed" width="100%" cellspacing="0">
          <thead>
              <tr>
                  <th>id</th>
                  <th>Apellidos</th>
                  <th>Nombre</th>
                  <th>DNI</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th>Estudios previos</th>
                  <th>Tecnologías</th>
                  <th>Preferencias</th>
                  <th></th>
              </tr>
          </thead>
        </table>
       </div>
     </div>
     
    
    

    <!--Modal datos alumno-->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Añadir alumno</h4>
            </div>
            <div class="modal-body">
              <!--FORMULARIO-->
              <form class="form-horizontal" id="formulario">
              <!--El input que va a continuación solamente vale como elemento al que yo puedo cambiar el valor para poder ejecutar los diferentes casos del switch-->
                <input type="hidden" id="opcion" name="opcion" value="">
                  
                <input type="hidden" class="form-control" name="id" id="id">              
                <div class="form-group" id="divapellidos">
                  <div class="col-sm-12">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" name="apellidos" id="apellidos" >
                    <span id="helpBlock1" class="help-block hide">No has introducido los apellidos</span>
                  </div>
                </div>

                <div class="form-group" id="divnombre">
                  <div class="col-sm-12">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                    <span id="helpBlock2" class="help-block hide">No has introducido el nombre de usuario</span>
                  </div>
                </div>

                <div class="form-group" id="divdni">
                  <div class="col-sm-12">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni">
                    <span id="helpBlock3" class="help-block hide">No has introducido el DNI</span>
                  </div>
                </div>

                <div class="form-group" id="divdireccion">
                  <div class="col-sm-12">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                    <span id="helpBlock4" class="help-block hide">La dirección no es correcta</span>
                  </div>
                </div>

                <div class="form-group" id="divtelefono">
                  <div class="col-sm-12">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                    <span id="helpBlock5" class="help-block hide">No has introducido el teléfono</span>
                  </div>
                </div>

                <div class="form-group" id="divemail">
                  <div class="col-sm-12">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                    <span id="helpBlock6" class="help-block hide">No has introducido el email</span>
                  </div>
                </div>
  
              </form>
              <br>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" id="botonCerrar">Cerrar</button>
              <button type="button" class="btn btn-primary" id="botonModal"></button>
            </div>
          </div>
        </div>
      </div>
      </div>

      <!--formulario modal CSV-->
      <div class="modal fade" id="myModalcsv" tabindex="-1" role="dialog" aria-labelledby="myModalLabelcsv">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabelcsv"><span class="glyphicon glyphicon-file"></span> Añadir usuarios desde archivo</h4>
            </div>
            <div class="modal-body">
            <form id="formcsv" enctype="multipart/form-data" method="post">
              <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000" required="" />
                <input  type="file" name="fichero" >
              </div>
              <button type="button" class="btn btn-primary" id="botonModalcsv">Enviar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

<!-- Modal fct -->
    <div class="modal fade" id="ModalFct" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-briefcase"></span> Asignación de proyecto</h4>
      </div>
      <div class="modal-body">
        
        <form class="form-horizontal" id="formulariofct">
        <input type="hidden" id="opcionFCT" name="opcionFCT" value="modificarFCT">
        <input type="hidden" class="form-control" name="idalumnofct" id="idalumnofct">
        <input type="hidden" class="form-control" name="idregistro" id="idregistro">
          
          <div class="col-sm-5">
            <div class="form-group" id="divfechainicio">
              <label for="fecha">Fecha inicio</label>
              <input type="text" class="form-control" name="fechainicio" id="datepicker">
              <span id="helpBlock222" class="help-block hide">No has introducido la fecha</span>
            </div>
          </div>

          <div class="col-sm-offset-2 col-sm-5">
            <div class="form-group" id="divfechafin">
              <label for="fecha">Fecha fin</label>
              <input type="text" class="form-control" name="fechafin" id="fechafin">
              <span id="helpBlock333" class="help-block hide">No has introducido la fecha</span>
            </div>
          </div>

          <div class="col-sm-5">
            <div class="form-group" id="divtotalhoras">
              <label for="totalhoras">Total horas</label>
              <input type="number" class="form-control" name="totalhoras" id="totalhoras">
              <span id="helpBlock444" class="help-block hide">No has introducido la fecha</span>
            </div>
          </div>

          <div class="col-sm-offset-2 col-sm-5">
          <div class="form-group" id="divjornada">
              <label for="jornada">Jornada</label>
              <input type="number" class="form-control" name="jornada" id="jornada">
              <span id="helpBlock555" class="help-block hide">No has introducido la fecha</span>
            </div>
          </div>
  
          <label for="id_empresa">Empresa</label>
            <select class="form-control" id="id_empresa" name="id_empresa">
                '.$seleccion.'
              </select>
            <span id="helpBlock666" class="help-block hide">No has introducido la fecha</span> 
        </form>
        </div>
        <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="cerrarfct" data-dismiss="modal">Cerrar</button>
          <button type="button" id="btnFCT" class="btn btn-primary">Modificar</button>
        </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal avisos -->
    <div class="modal fade" id="ModalAvisos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-envelope"></span> Enviar aviso</h4>
      </div>
      <div class="modal-body">
        
        <form class="form-horizontal" id="formularioavisos">
          
          <label for="destinatarios">Destinatarios</label>
            <select class="form-control" id="destinatarios" name="destinatarios">
               
            </select> 

          
          <label for="textoaviso">Aviso</label>
          <textarea class="form-control" rows="5" name="textoaviso" id="textoaviso"></textarea>
          <span id="helpBlock101" class="help-block hide">No has introducido el aviso</span>

        </form>
        </div>
        <br>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="cerraravisos" data-dismiss="modal">Cerrar</button>
          <button type="button" id="btnavisos" class="btn btn-primary">Enviar</button>
        </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

         
	
</div>
';














 ?>