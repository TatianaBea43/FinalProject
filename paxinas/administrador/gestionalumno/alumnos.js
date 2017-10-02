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

    var mostrarcsv= function () {
           $('#myModalcsv').modal({
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
                $('#info').remove();
                $("#masinfo").remove();
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
                $('#info').remove();
                $('#myModal').modal('hide');//Para que desaparezca el formulario modal
            }
   
            break;
            
        }
   
    });

    /******VARIABLES PARA AMPLIAR EL MODAL PARA AÑADIR UN ALUMNO************/

    var btninfo='<div class="form-group" id="btninfo"><div class="col-sm-12"><button type="button" class="btn btn-primary" id="masinfo">Añadir estudios, tecnologías y preferencias</button></div></div>';

    var info='<div id="info"><div class="form-group" id="divestudios"><div class="col-sm-12"><label for="estudios">Estudios Previos</label><textarea class="form-control" rows="3" id="estudios" name="estudios"></textarea><span id="helpBlock7" class="help-block hide">Los estudios no son correctos</span></div></div><div class="form-group" id="divtecnologias"><div class="col-sm-12"><label for="tecnologias">Tecnologías que maneja</label><textarea class="form-control" rows="3" id="tecnologias" name="tecnologias"></textarea><span id="helpBlock8" class="help-block hide">Las tecnologías no son correctas</span></div></div><div class="form-group" id="divpreferencias"><div class="col-sm-12"><label for="preferencias">Preferencias</label><textarea class="form-control" rows="3" id="preferencias" name="preferencias"></textarea><span id="helpBlock9" class="help-block hide">Las preferencias no son correctas</span></div></div></div>';

    
    //Botón cerrar del modal para que elimine datos
    $("#botonCerrar").on('click', function(){
        $("#formulario")[0].reset();
        $(".has-error").removeClass('has-error');
        $(".help-block").addClass('hide'); 
        $('#info').remove();
        $("#btninfo").remove();
       
    });

    //Para que elimine los datos al darle a la x de cerrar
    $('#myModal').on('hide.bs.modal', function () {
        $("#formulario")[0].reset();
        $(".has-error").removeClass('has-error'); 
        $(".help-block").addClass('hide'); 
        $('#info').remove();
        $("#btninfo").remove();
        
    });
      
    //Botón para modificar el registro
    $("#alumnos").on('click', '.editar', function(){
        $("#opcion").val("editar"); //cambio el valor del botón del formulario modal para que funcione el switch
        $("#myModalLabel").html("Modificar registro");//cambio el titulo del formulario modal
        $("#botonModal").html("Modificar registro");//cambio el nombre del botón del formulario modal
        $("#formulario").append(info);
        var btn2=$(this);
        var tr=btn2.closest('tr');//con esta función cojo el elemento 'tr' más cercano al botón.
        fila2=tbl.row(tr).index();//Así obtengo la posición de la fila
        valores=[
            $('#id').val(tbl.cell(fila2, 0).data()),
            $('#apellidos').val(tbl.cell(fila2, 1).data()),
            $('#nombre').val(tbl.cell(fila2, 2).data()),
            $('#dni').val(tbl.cell(fila2, 3).data()),
            $('#direccion').val(tbl.cell(fila2, 4).data()),
            $('#telefono').val(tbl.cell(fila2, 5).data()),
            $('#email').val(tbl.cell(fila2, 6).data()),
            $('#estudios').val(tbl.cell(fila2, 7).data()),
            $('#tecnologias').val(tbl.cell(fila2, 8).data()),
            $('#preferencias').val(tbl.cell(fila2, 9).data())

        ];//En este array cojo el valor de cada celda
        mostrar();


    });

    /******MODAL PARA INSERTAR ALUMNOS DESDE ARCHIVO*********/

    /*****Función necesaria para no perder el archivo al meterlo en el input******/
    // Variable to store your files
    var files;
    // Add events
    $('input[type=file]').on('change', prepareUpload);

    // Grab the files and set them to our variable
    function prepareUpload(event)
    {
      files = event.target.files;
    }


    $("#botonModalcsv").on('click',function(){
    // Crear un objet formdata y añadir 'files'
       var fordata = new FormData();
       $.each(files, function(key, value)
        {
            fordata.append(key, value);
        });
       var control=false;
       $.confirm({
            title: 'Alta de alumno',
            type: 'blue',
            columnClass: 'medium',
            content: function(){ 
                var self = this;
                return $.ajax({
                    url: 'administrador/gestionalumno/csv.php',
                    type: 'POST',
                    dataType: "json",
                    data: fordata,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (data){
                    
                    $.each(data,function(index,value){
                        
                        if(index=='errores'){
                            self.setType('red');
                            control=false;
                            $.each(value,function(index,value3){
                                self.setContentAppend(value3+'<br>');
                            })  
                        }
                        
                    });
                    tbl.ajax.reload(); 
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


    $("#formcsv")[0].reset(); //Para que desaparezcan los datos de los inputs
    $('#myModalcsv').modal('hide');//Para que desaparezca el formulario modal
    })

    
    $('#myModalcsv').on('hide.bs.modal', function () {
        $("#formcsv")[0].reset();
    });


    var validar_dni_nif_nie = function (value){
 
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
            } 

   //Validación de campos del formulario
   var validar=function(){
        
        var patron = /[A-Za-zñÑ-áéíóúÁÉÍÓÚ\s]/;
        var patronmail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var patrontelefono=/^\d{9}$/;
        var patrongenerico=/[\*\'\"]/
        if ($('#apellidos').val()=="") {
            $('#divapellidos').addClass('has-error');
            $('#helpBlock1').html('No has introducido los apellidos');
            $('#helpBlock1').removeClass('hide');
            res=1;
            
        }else {
            if (!patron.test($('#apellidos').val().trim())) {
            $('#divapellidos').addClass('has-error');
            $('#helpBlock1').html('Los apellidos no son correctos');
            $('#helpBlock1').removeClass('hide');
            res=1;
            }else{
                $('#divapellidos').removeClass('has-error');
                $('#helpBlock1').addClass('hide');
            }
        } 
        
        if ($('#nombre').val()=="") {
            $('#divnombre').addClass('has-error');
            $('#helpBlock2').html('No has introducido el nombre');
            $('#helpBlock2').removeClass('hide');
            res=1;
        }else {
            if (!patron.test($('#nombre').val().trim())) {
            $('#divnombre').addClass('has-error');
            $('#helpBlock2').html('El nombre no es correcto');
            $('#helpBlock2').removeClass('hide');
            res=1;
            }else{
                $('#divnombre').removeClass('has-error');
                $('#helpBlock2').addClass('hide');
            }
        }

        if ($('#dni').val()=="") {
            $('#divdni').addClass('has-error');
            $('#helpBlock3').html('No has introducido el DNI');
            $('#helpBlock3').removeClass('hide');
            res=1;
        }else {
            if (!validar_dni_nif_nie($('#dni').val())) {
            $('#divdni').addClass('has-error');
            $('#helpBlock3').html('El DNI no es correcto');
            $('#helpBlock3').removeClass('hide');
            res=1;
            }else{
                $('#divdni').removeClass('has-error');
                $('#helpBlock3').addClass('hide');
            }
        }

        if (patrongenerico.test($('#direccion').val().trim())) {
             $('#divdireccion').addClass('has-error');
             $('#helpBlock4').removeClass('hide');
             res=1;

        }else{
            $('#divdireccion').removeClass('has-error');
            $('#helpBlock4').addClass('hide');
        } 

        if ($('#telefono').val()=="") {
            $('#divtelefono').addClass('has-error');
            $('#helpBlock5').html('No has introducido el teléfono');
            $('#helpBlock5').removeClass('hide');
            res=1;
        }else {
            if (!patrontelefono.test($('#telefono').val().trim())) {
             $('#divtelefono').addClass('has-error');
             $('#helpBlock5').html('El teléfono no es correcto');
             $('#helpBlock5').removeClass('hide');
             res=1;
            }else{
                $('#divtelefono').removeClass('has-error');
                $('#helpBlock5').addClass('hide');
            }
        }

        if ($('#email').val()=="") {
            $('#divemail').addClass('has-error');
            $('#helpBlock6').html('No has introducido el email');
            $('#helpBlock6').removeClass('hide');
            res=1;
        }else{
            if (!patronmail.test($('#email').val().trim())) {
            $('#divemail').addClass('has-error');
            $('#helpBlock6').html('El email no es correcto');
            $('#helpBlock6').removeClass('hide');
            res=1;
            }else{
                $('#divemail').removeClass('has-error');
                $('#helpBlock6').addClass('hide');
            }
        }

        if(typeof($('#estudios').val()) != "undefined" && $('#estudios').val() !== null) {
            if (patrongenerico.test($('#estudios').val().trim())) {
            $('#divestudios').addClass('has-error');
            $('#helpBlock7').removeClass('hide');
            res=1;
            }else{
                $('#divestudios').removeClass('has-error');
                $('#helpBlock7').addClass('hide');
            } 
        }

        if(typeof($('#tecnologias').val()) != "undefined" && $('#tecnologias').val() !== null) {
            if (patrongenerico.test($('#tecnologias').val().trim())) {
                 $('#divtecnologias').addClass('has-error');
                 $('#helpBlock8').removeClass('hide');
                 res=1;
            }else{
                $('#divtecnologias').removeClass('has-error');
                $('#helpBlock8').addClass('hide');
            }
        } 

        if(typeof($('#preferencias').val()) != "undefined" && $('#preferencia').val() !== null) {
            if (patrongenerico.test($('#preferencias').val().trim())) {
                $('#divpreferencias').addClass('has-error');
                $('#helpBlock9').removeClass('hide');
                res=1;
            } else{
                $('#divpreferencias').removeClass('has-error');
                $('#helpBlock9').addClass('hide');
            }
        }
        
   }

 /**********FUNCIÓN PARA DAR DE ALTA****************/

   var altas=function () {
    var envio=  $('#formulario').serialize();
    var control=false;
    $.confirm({

        title: 'Alta de alumno',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'administrador/gestionalumno/altaalumnos.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json"
            }).done (function (data) {
                if(data==0){
                    self.setType('red');
                    self.setContentAppend('Error al crear el objeto alumno');
                    }else{
                        if(data==1){
                            self.setType('red');
                            self.setContentAppend('El alumno ya existe<br>');
                        }else{
                                $.each(data,function(index,value){
                                if(index=='alumno'){ 
                                    if(value==0){
                                    self.setType('red'),
                                    self.setContentAppend('No se ha podido dar de alta al alumno<br>');
                                    }else{
                                        var valores={
                                        "id":value.id,
                                        "apellidos": value.apellidos,
                                        "nombre": value.nombre,
                                        "dni": value.dni,
                                        "direccion": value.direccion,
                                        "telefono":value.telefono,
                                        "email":value.email,
                                        "estudios":value.estudios,
                                        "tecnologias":value.tecnologias,
                                        "preferencias":value.preferencias
                                        }
                                        tbl.row.add(valores).draw(false);
                                        control=true;

                                        }
                                    }

                                if(index=='mail'){
                                    if(value==0){
                                        self.setType('red'),
                                        self.setContentAppend('No se ha podido enviar el email<br>');
                                        control=false;
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
        title: 'Modificar datos del alumno',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'administrador/gestionalumno/modificaralumnos.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
            }).done(function (data) {
                if(data==0){
                    self.setType('red'),
                    self.setContentAppend('Error al crear el objeto alumno');
                }else{
                    $.each(data,function(index,value){
                        if(index=='alumno'){ 
                            if(value==0){
                                self.setType('red'),
                                self.setContentAppend('No se han podido recuperar los datos del alumno<br>');

                            }else {
                               if(value==1){
                               self.setType('red'),
                               self.setContentAppend('No se han podido modificar los datos del alumno<br>'); 
                                }else{
                                    var valores={
                                        "id":value.id,
                                        "apellidos": value.apellidos,
                                        "nombre": value.nombre,
                                        "dni": value.dni,
                                        "direccion": value.direccion,
                                        "telefono":value.telefono,
                                        "email":value.email,
                                        "estudios":value.estudios,
                                        "tecnologias":value.tecnologias,
                                        "preferencias":value.preferencias
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
    tbl=$('#alumnos').DataTable( {
        "language": {
                "url": "/ProyectoFinal/plugins/datatables/lang/"+idiomas[lengua]+".json"
            },
        "ajax":"administrador/gestionalumno/datosalumnos.php",
        //Creo las columnas de la tabla
        "columns": [
            { "data": "id"},
            { "data": "apellidos" },
            { "data": "nombre" },
            { "data": "dni" },
            { "data": "direccion" },
            { "data": "telefono" },
            { "data": "email" },
            { "data": "estudios",
                render: function (data) {
                    
                    if(data.length<90){
                        return data; 
                    }else{
                        return data.substring(0, 90)+'...';
                    }
                }
            },
            { "data": "tecnologias",
                render: function (data) {
                    
                    if(data.length<90){
                        return data; 
                    }else{
                        return data.substring(0, 90)+'...';
                    }
                }
            },
            { "data": "preferencias",
                render: function (data) {
                    
                    if(data.length<90){
                        return data; 
                    }else{
                        return data.substring(0, 90)+'...';
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
                targets: [1],
                width: "12%"
            },
            {
                targets: [2],
                width: "12%"
            },
            {
                targets: [3],
                visible:false
            },
            {
                targets: [4],
                width: "20%"
            },
            {
                targets: [5],
                width: "8%"
            },
            {
                targets: [6],
                visible:false,
            },
            {
                targets: [10],
                width: "5%"
            },
        ],

        //"scrollY":"30vh",
        

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
                    $("#formulario").append(btninfo);
                    $("#masinfo").on('click', function (){
                       $("#formulario").append(info); 
                       $("#masinfo").addClass('hide');
                    })
                    
                    mostrar();
                } 
            }, 

            {
                text:'Añadir desde archivo',
                className:'btn btn-success btn-md',
                titleAttr:'Añadir desde csv',
                //llamada a la función anadir
                action: function () {
                    mostrarcsv();
                } 
            }

            
    ]
    });

    
         
        
