<?php 

$corpo='

	
	<!--Cabecera-->

	<div class="container">
		<!---Paneles-->
		<div class="col-md-offset-3 col-md-6 col-md-offset-3">
			<div class="panel panel-info ">
				<div class="panel-heading">Acceso de usuarios</div>
				<div class="panel-body">
					<form action="index.php" method="post">
						<!--usuario-->
						<div class="form-group">
	    					<label for="exampleInputName2">Nombre</label>
	    					<div class="input-group input-group-lg">
		    					<div class="input-group-addon" id="sizing-addon1">
								    <i class="fa fa-user fa-lg" aria-hidden="true"></i>
								</div>
		    					<input type="text" class="form-control" name="exampleInputName2" id="exampleInputName2">
		    				</div>
	  					</div>
						<!--contraseña-->
					    <div class="form-group">
						    <label for="exampleInputPassword1">Contraseña</label>
						    <div class="input-group input-group-lg">
							    <div class="input-group-addon" id="sizing-addon1">
							    	<i class="fa fa-lock fa-lg" aria-hidden="true"></i>
							    </div>
						    	<input type="password" class="form-control" id="exampleInputPassword1" name="exampleInputPassword1">
						    </div>
						</div>
						<!--botón-->
						<div class="col-md-offset-9 col-md-3">
							<input type="submit" name="enviar" class="btn btn-info" value="Acceder">
						</div>
				    </form>
				</div>

			</div>
		</div>

	</div>
';








 ?>