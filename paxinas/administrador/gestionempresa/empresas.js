var id=null;
var res=0;
var idiomas = new Array();
	idiomas['es'] = 'Spanish';
	idiomas['gl'] = 'Galician';
	idiomas['en'] = 'English';
var lengua=navigator.language;
    
    //Esta función muestra el cuadro modal
    var mostrar= function () {
           $('#myModal').modal({
                        show: true,
                        backdrop:false,
                        keyboard:false
                    });
                };

    //Creo los botones de modificar y eliminar fila
    botones='<div class="text-center"><button type="button" class=" editar btn btn-success" ><span class="glyphicon glyphicon-pencil"></button>';    
    //Aquí están las funcionalidades del botón del formulario modal
    $('#botonModal').on('click', function(e){
        var opcion=$('#opcion').val();
        switch (opcion) {
            //Para añadir registros
            case "anadir":
            validar();
            if(res==1){
            e.preventDefault();//capo la función submit del botón. Si no también podría capar el submit antes de las comprobaciones y después hacer un else y añadir la función submit al formulario ($('form').submit();)
            res=0;
            }
            else{
                altas();//función para enviar datos a la bd
                $("#formulario")[0].reset();
                $(".has-error").removeClass('has-error');
                $('#myModal').modal('hide');
            }

            break;
            
            //Para modificar registros
            case "editar":
            validar();
            if(res==1){
            e.preventDefault();//capo la función submit del botón. Si no también podría capar el submit antes de las comprobaciones y después hacer un else y añadir la función submit al formulario ($('form').submit();)
            res=0;
            }else{
                modificar();
                $("#formulario")[0].reset(); 
                $(".has-error").removeClass('has-error'); 
                $('#myModal').modal('hide');//Para que desaparezca el formulario modal
            }
                
            break;
            
        }
   
    });

    //Botón cerrar del modal para que elimine datos
    $("#botonCerrar").on('click', function(){
        $("#formulario")[0].reset();
        $(".has-error").removeClass('has-error'); 
        $(".help-block").addClass('hide'); 
    });

    //Para que elimine los datos al darle a la x de cerrar
    $('#myModal').on('hide.bs.modal', function () {
        $("#formulario")[0].reset();
        $(".has-error").removeClass('has-error'); 
        $(".help-block").addClass('hide'); 
    });
      
    //Botón para modificar el registro
    $("#empresas").on('click', '.editar', function(){
        $("#opcion").val("editar"); //cambio el valor del botón del formulario modal para que funcione el switch
        $("#myModalLabel").html("Modificar registro");//cambio el titulo del formulario modal
        $("#botonModal").html("Modificar registro");//cambio el nombre del botón del formulario modal
        var btn2=$(this);
        var tr=btn2.closest('tr');//con esta función cojo el elemento 'tr' más cercano al botón.
        fila2=tbl.row(tr).index();//Así obtengo la posición de la fila
        valores=[
            $('#id').val(tbl.cell(fila2, 0).data()),
            $('#razonsocial').val(tbl.cell(fila2, 1).data()),
            $('#direccion').val(tbl.cell(fila2, 2).data()),
            $('#email').val(tbl.cell(fila2, 3).data()),
            $('#telefono').val(tbl.cell(fila2, 4).data()),
            $('#tutor').val(tbl.cell(fila2, 5).data()),
            $('#estado').val(tbl.cell(fila2, 6).data())

        ];//En este array cojo el valor de cada celda
        mostrar();


    });

     /*var validar_dni_nif_nie = function (value){
 
                  var validChars = 'TRWAGMYFPDXBNJZSQVHLCKET';
                  var nifRexp = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i;
                  var nieRexp = /^[XYZ]{1}[0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKET]{1}$/i;
                  var str = value.toString().toUpperCase();
 
                  if (!nifRexp.test(str) && !nieRexp.test(str)) return false;
 
                  var nie = str
                      .replace(/^[X]/, '0')
                      .replace(/^[Y]/, '1')
                      .replace(/^[Z]/, '2');
 
                  var letter = str.substr(-1);
                  var charIndex = parseInt(nie.substr(0, 8)) % 23;
 
                  if (validChars.charAt(charIndex) === letter) return true;
 
                  return false;
            }*/ 

   //Validación de campos del formulario
   var validar=function(){
        var patrongenerico=/[\*\'\"]/;
        var patron = /[A-Za-zñÑ-áéíóúÁÉÍÓÚ\s]/;
        var patronmail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var patrontelefono=/^\d{9}$/;
        //var fec=$('#fechanac').val().split(/[\-\.\,\s\/]/).reverse().join("-");
        if ($('#razonsocial').val()=="") {
            $('#divrazonsocial').addClass('has-error');
            $('#helpBlock1').html('No has introducido el nombre de la empresa');
            $('#helpBlock1').removeClass('hide');
            res=1;
            
        }else {
            if (!patron.test($('#razonsocial').val().trim())) {
            $('#divrazonsocial').addClass('has-error');
            $('#helpBlock1').html('El nombre de la empresa no es correcto');
            $('#helpBlock1').removeClass('hide');
            res=1;
            }else{
                $('#divrazonsocial').removeClass('has-error');
                $('#helpBlock1').addClass('hide');
            }
        } 

        if ($('#direccion').val()=="") {
            $('#divdireccion').addClass('has-error');
            $('#helpBlock2').html('No has introducido el teléfono');
            $('#helpBlock2').removeClass('hide');
            res=1;
        }else {
            if (patrongenerico.test($('#direccion').val().trim())) {
                 $('#divdireccion').addClass('has-error');
                 $('#helpBlock2').removeClass('hide');
                 res=1;

            }else{
                $('#divdireccion').removeClass('has-error');
                $('#helpBlock2').addClass('hide');
            } 
        }

        if ($('#email').val()=="") {
            $('#divemail').addClass('has-error');
            $('#helpBlock3').html('No has introducido el email');
            $('#helpBlock3').removeClass('hide');
            res=1;
        }else{
            if (!patronmail.test($('#email').val().trim())) {
            $('#divemail').addClass('has-error');
            $('#helpBlock3').html('El email no es correcto');
            $('#helpBlock3').removeClass('hide');
            res=1;
            }else{
                $('#divemail').removeClass('has-error');
                $('#helpBlock3').addClass('hide');
            }
        }

        if ($('#telefono').val()=="") {
            $('#divtelefono').addClass('has-error');
            $('#helpBlock4').html('No has introducido el teléfono');
            $('#helpBlock4').removeClass('hide');
            res=1;
        }else {
            if (!patrontelefono.test($('#telefono').val().trim())) {
             $('#divtelefono').addClass('has-error');
             $('#helpBlock4').html('El teléfono no es correcto');
             $('#helpBlock4').removeClass('hide');
             res=1;
            }else{
                $('#divtelefono').removeClass('has-error');
                $('#helpBlock4').addClass('hide');
            }
        }

        if ($('#tutor').val()=="") {
            $('#divtutor').addClass('has-error');
            $('#helpBlock5').html('No has introducido el teléfono');
            $('#helpBlock5').removeClass('hide');
            res=1;
        }else {
            if (!patron.test($('#tutor').val().trim())) {
             $('#divtutor').addClass('has-error');
             $('#helpBlock5').html('El teléfono no es correcto');
             $('#helpBlock5').removeClass('hide');
             res=1;
            }else{
                $('#divtutor').removeClass('has-error');
                $('#helpBlock5').addClass('hide');
            }
        }

        

   }


   /**********FUNCIÓN PARA DAR DE ALTA****************/

   var altas=function () {
    var envio=  $('#formulario').serialize();
    var control=false;
    $.confirm({

        title: 'Alta de empresa',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'administrador/gestionempresa/altaempresa.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json"
            }).done (function (data) {
                if(data==0){
                    self.setType('red');
                    self.setContentAppend('Error al crear el objeto empresa');
                    }else{
                        if(data==1){
                            self.setType('red');
                            self.setContentAppend('No se ha podido realizar el registro de la empresa<br>');
                        }else{
                            $.each(data,function(index,value){
                                if(index=='empresa'){ 
                                    if(value==0){
                                    self.setType('red'),
                                    self.setContentAppend('No se ha podido dar de alta la empresa');
                                    }else{
                                        var valores={
                                            "id":value.id,
                                            "razon_social": value.razon_social,
                                            "direccion": value.direccion,
                                            "email": value.email,
                                            "telefono":value.telefono,
                                            "tutor":value.tutor,
                                            "estado":value.estado
                                            }
                                            tbl.row.add(valores).draw(false);
                                            control=true;
                                    }
                                }
                                if(index=='errores'){
                                self.setType('red'),
                                self.setContentAppend(value);
                                control=false;
                                }
                            })
                        }
                    }

                    if(control){
                            self.setType('green'),
                            self.setContentAppend('La operación se ha realizado correctamente<br>');
                    }

            }).fail(function(){
                    self.setType('red'),
                    self.setContentAppend('Ups! ha sucedido un error<br>');
                })
        },
        buttons:{
            ok:{
                text:'OK',
                btnClass:'blue'
            }
        }

    })

   }

   /**********FUNCIÓN PARA MODIFICAR************/
   
   var modificar=function () {
    var envio=  $('#formulario').serialize();
    var control=false;
    $.confirm({
        title: 'Modificar empresa',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'administrador/gestionempresa/modificarempresa.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
            }).done(function (data) {
                if(data==0){
                    self.setType('red'),
                    self.setContentAppend('Los datos no son correctos');
                }else{
                    $.each(data,function(index,value){
                        if(index=='empresa'){ 
                            if(value==0){
                                self.setType('red'),
                                self.setContentAppend('No se han podido recuperar los datos de la empresa<br>');

                            }else{
                                if(value==1){
                                self.setType('red'),
                                self.setContentAppend('No se han podido modificar los datos de la empresa<br>');
                                }else{
                                   var valores={
                                    "id":value.id,
                                    "razon_social": value.razon_social,
                                    "direccion": value.direccion,
                                    "email": value.email,
                                    "telefono":value.telefono,
                                    "tutor":value.tutor,
                                    "estado":value.estado
                                    };
                                    tbl.row(fila2).data(valores); 
                                    control=true;
                                }
                            }
                            
                        }
                        if(index=='errores'){
                            self.setType('red'),
                            self.setContentAppend(value);
                            control=false;
                            
                        }
                    })
                }
                           
                if(control){
                    self.setType('green'),
                    self.setContentAppend('La operación se ha realizado correctamente<br>');
                }     

            }).fail(function(){
                    self.setType('red'),
                    self.setContentAppend('Ups! ha sucedido un error');
                })
            },
            buttons:{
                ok:{
                    text:'OK',
                    btnClass:'blue'
                }
            }
             
        })
   }
       
    
    //en la variable 'tbl' meto el objeto datatable
    tbl=$('#empresas').DataTable( {
        "language": {
                "url": "/ProyectoFinal/plugins/datatables/lang/"+idiomas[lengua]+".json"
            },
        "ajax":"administrador/gestionempresa/datosempresas.php",
        //Creo las columnas de la tabla
        "columns": [
            { "data": "id"},
            { "data": "razon_social" },
            { "data": "direccion" },
            { "data": "email" },
            { "data": "telefono" },
            { "data": "tutor" },
            { "data": "estado", 
                render:function(data){
                    switch (data) {
                        case '0':
                            return 'No activa';
                        break;
                        case '1':
                            return 'Activa';
                        break;
                    } 
                }
            },
            { "data": null,
            defaultContent: botones}
        ],

        columnDefs:[
            {
                targets: [0],
                visible:false
            },
            {
                targets: [4],
                width: "8%"
            },
            {
                targets: [6],
                width: "8%"
            },
            {
                targets: [7],
                width: "5%"
            },
        ],
        

        "dom": "<'row'<'form-inline'<'col-sm-7' B><'col-sm-5' f>>><rt><'row'<'col-sm-7' p>>",

        "buttons": [
            {
                extend:'print',//Extiende a la clase print
                text:'<i class="glyphicon glyphicon-print"></i>',//Nombre del icono en la clase y va entre etiquetas <i> porque es icono
                className:'btn btn-primary btn-md',//clase botón con color y tamaño
                titleAttr:'Imprimir',//texto alternativo
                title:'Listado',//titulo de la página creada
                autoPrint:true
                
            },
            {
                extend:'pdf',
                text:'<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                className:'btn btn-success btn-md',
                titleAttr:'Pdf',
                title:'Listado'
                
            },
            {
                extend:'excel',
                text:'<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                className:'btn btn-warning btn-md',
                titleAttr:'Excel',
                title:'Listado'
                
            },
            {
                extend:'csv',
                text:'<i class="fa fa-file-archive-o" aria-hidden="true"></i>',
                className:'btn btn-info btn-md',
                titleAttr:'Hoja de cálculo',
                title:'Listado'
                
            },
            {
                extend:'colvis',
                text:'<i class="fa fa-list-alt" aria-hidden="true"></i>',
                className:'btn btn-danger btn-md',
                titleAttr:'columnas',
                title:'Listado'
                
            },
            {
                text:'Añadir',
                className:'btn btn-info btn-md',
                titleAttr:'Añadir',
                //llamada a la función anadir
                action: function (argument) {
                    $("#opcion").val("anadir");
                    $("#myModalLabel").html("Añadir registro");
                    $("#botonModal").html("Añadir");
                    mostrar();
                } 
            }
            
    ]
    } );

    
         
        
