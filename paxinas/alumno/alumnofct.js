var id=null;
var res=0;
var idiomas = new Array();
	idiomas['es'] = 'Spanish';
	idiomas['gl'] = 'Galician';
	idiomas['en'] = 'English';
var lengua=navigator.language;

$("#btnavisos").on('click', function(){
    $("#cuerpo").load('avisos/tablaavisos.html');
})

$("#btnactividades").on('click', function(){
    location.reload();
})


$("#btncalendario").on('click', function(){
     $("#cuerpo").load('alumno/calendar.html');
})



$("#LogoutButton").on('click', function(){
    $.confirm({
        title: 'Cerrar sesión',
        content: '¿Estás seguro de que quieres cerrar la sesión?',
        type: 'orange',
        buttons: {
            Confirmar: {
            text: 'Cerrar sesión',
            btnClass: 'btn-orange',
            action:function () {
                document.location = 'logout.php';
                //$.alert('Se ha cerrado tu sesión');
                }
            },
            Cancelar: {
                //$.alert('Canceled!');
            }
        }
    });

    

});

$("#passButton").on('click', function(){
    $("#cuerpo").load('pass/cambiarpass.html');

});

$("#mailButton").on('click', function(){
    $("#cuerpo").load('correo/correo.html');

});
    
    /*******MODIFICAR PERFIL*******/
    var mostrarperfil= function () {
           $('#myModalPerfil').modal({
                        show: true,
                        backdrop:false,
                        keyboard:false
                    });
                };

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
   var validarperfil=function(){
        
        var patron = /[A-Za-zñÑ-áéíóúÁÉÍÓÚ\s\.\,\:]/;
        var patronmail=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var patrontelefono=/^\d{9}$/;
        var patrongenerico=/[\*\'\"]/
        if ($('#apellidos').val()=="") {
            $('#divapellidos').addClass('has-error');
            $('#helpBlock10').html('No has introducido los apellidos');
            $('#helpBlock10').removeClass('hide');
            res=1;
            
        }else {
            if (!patron.test($('#apellidos').val().trim())) {
            $('#divapellidos').addClass('has-error');
            $('#helpBlock10').html('Los apellidos no son correctos');
            $('#helpBlock10').removeClass('hide');
            res=1;
            }else{
                $('#divapellidos').removeClass('has-error');
                $('#helpBlock10').addClass('hide');
            }
        } 
        
        if ($('#nombre').val()=="") {
            $('#divnombre').addClass('has-error');
            $('#helpBlock20').html('No has introducido el nombre');
            $('#helpBlock20').removeClass('hide');
            res=1;
        }else {
            if (!patron.test($('#nombre').val().trim())) {
            $('#divnombre').addClass('has-error');
            $('#helpBlock20').html('El nombre no es correcto');
            $('#helpBlock20').removeClass('hide');
            res=1;
            }else{
                $('#divnombre').removeClass('has-error');
                $('#helpBlock20').addClass('hide');
            }
        }

        if ($('#dni').val()=="") {
            $('#divdni').addClass('has-error');
            $('#helpBlock30').html('No has introducido el DNI');
            $('#helpBlock30').removeClass('hide');
            res=1;
        }else {
            if (!validar_dni_nif_nie($('#dni').val())) {
            $('#divdni').addClass('has-error');
            $('#helpBlock30').html('El DNI no es correcto');
            $('#helpBlock30').removeClass('hide');
            res=1;
            }else{
                $('#divdni').removeClass('has-error');
                $('#helpBlock30').addClass('hide');
            }
        }

        if (patrongenerico.test($('#direccion').val().trim())) {
             $('#divdireccion').addClass('has-error');
             $('#helpBlock40').removeClass('hide');
             res=1;

        }else{
            $('#divdireccion').removeClass('has-error');
            $('#helpBlock40').addClass('hide');
        } 

        if ($('#telefono').val()=="") {
            $('#divtelefono').addClass('has-error');
            $('#helpBlock50').html('No has introducido el teléfono');
            $('#helpBlock50').removeClass('hide');
            res=1;
        }else {
            if (!patrontelefono.test($('#telefono').val().trim())) {
             $('#divtelefono').addClass('has-error');
             $('#helpBlock50').html('El teléfono no es correcto');
             $('#helpBlock50').removeClass('hide');
             res=1;
            }else{
                $('#divtelefono').removeClass('has-error');
                $('#helpBlock50').addClass('hide');
            }
        }

        if ($('#email').val()=="") {
            $('#divemail').addClass('has-error');
            $('#helpBlock60').html('No has introducido el email');
            $('#helpBlock60').removeClass('hide');
            res=1;
        }else{
            if (!patronmail.test($('#email').val().trim())) {
            $('#divemail').addClass('has-error');
            $('#helpBlock60').html('El email no es correcto');
            $('#helpBlock60').removeClass('hide');
            res=1;
            }else{
                $('#divemail').removeClass('has-error');
                $('#helpBlock60').addClass('hide');
            }
        }

        if(typeof($('#estudios').val()) != "undefined" && $('#estudios').val() !== null) {
            if (patrongenerico.test($('#estudios').val().trim())) {
            $('#divestudios').addClass('has-error');
            $('#helpBlock70').removeClass('hide');
            res=1;
            }else{
                $('#divestudios').removeClass('has-error');
                $('#helpBlock70').addClass('hide');
            } 
        }

        if(typeof($('#tecnologias').val()) != "undefined" && $('#tecnologias').val() !== null) {
            if (patrongenerico.test($('#tecnologias').val().trim())) {
                 $('#divtecnologias').addClass('has-error');
                 $('#helpBlock80').removeClass('hide');
                 res=1;
            }else{
                $('#divtecnologias').removeClass('has-error');
                $('#helpBlock80').addClass('hide');
            }
        } 

        if(typeof($('#preferencias').val()) != "undefined" && $('#preferencia').val() !== null) {
            if (patrongenerico.test($('#preferencias').val().trim())) {
                $('#divpreferencias').addClass('has-error');
                $('#helpBlock90').removeClass('hide');
                res=1;
            } else{
                $('#divpreferencias').removeClass('has-error');
                $('#helpBlock90').addClass('hide');
            }
        }
        
   }
   $('#btnperfil').on('click', function(){
     mostrarperfil();
   })
   $('#botonModalPerfil').on('click', function(e){
     validarperfil();
        if(res==1){
        e.preventDefault();//capo la función submit del botón. Si no también podría capar el submit antes de las comprobaciones y después hacer un else y añadir la función submit al formulario ($('form').submit();)
        res=0;
        }
        else{
            modificar();//función para enviar datos a la bd
            $("#formularioperfil")[0].reset();
            $(".has-error").removeClass('has-error');
            //$('#myModalPerfil').modal('hide');
        }
    })

     //Botón cerrar del modal para que elimine datos
    $("#botonCerrarPerfil").on('click', function(){
        $("#formularioperfil")[0].reset();
        $(".has-error").removeClass('has-error'); 
        $(".help-block").addClass('hide');
        location.reload(); 
    });

    //Para que elimine los datos al darle a la x de cerrar
    $('#myModalPerfil').on('hide.bs.modal', function () {
        $("#formularioperfil")[0].reset();
        $(".has-error").removeClass('has-error'); 
        $(".help-block").addClass('hide'); 
        location.reload();
    });



    var mostrar= function () {
           $('#myModal').modal({
                        show: true,
                        backdrop:false,
                        keyboard:false
                    });
                };



    //Creo los botones de modificar y eliminar fila
    botones='<div class="text-center"><button type="button" class=" editar btn btn-success" ><span class="glyphicon glyphicon-pencil"></button>&nbsp;<button type="button" class=" eliminar btn btn-danger" ><span class="glyphicon glyphicon-remove"></button></div>';    
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
            case "cambiar":
            validar();
            if(res==1){
            e.preventDefault();//capo la función submit del botón. Si no también podría capar el submit antes de las comprobaciones y después hacer un else y añadir la función submit al formulario ($('form').submit();)
            res=0;
            }else{
                modificarRegistro();
                $("#formulario")[0].reset(); 
                $(".has-error").removeClass('has-error'); 
                $('#myModal').modal('hide');//Para que desaparezca el formulario modal
            }
                
            break;
            
        }
   
    });


    $(function () {
        $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant', 
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
        'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié;', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $("#datepicker").datepicker();
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
    $("#alumnofct").on('click', '.editar', function(){
        $("#opcion").val("cambiar"); //cambio el valor del botón del formulario modal para que funcione el switch
        $("#myModalLabel").html("Modificar registro");//cambio el titulo del formulario modal
        $("#botonModal").html("Modificar registro");//cambio el nombre del botón del formulario modal
        var btn2=$(this);
        var tr=btn2.closest('tr');//con esta función cojo el elemento 'tr' más cercano al botón.
        fila2=tbl.row(tr).index();//Así obtengo la posición de la fila
        valores=[
           
            $('#id_registro').val(tbl.cell(fila2, 0).data()),
            $('#datepicker').val(tbl.cell(fila2, 1).data()),
            $('#horas').val(tbl.cell(fila2, 2).data()),
            $('#observaciones').val(tbl.cell(fila2, 3).data())
            

        ];//En este array cojo el valor de cada celda
        mostrar();


    });

    $("#alumnofct").on('click', '.eliminar', function(){
         //cambio el valor del botón del formulario modal para que funcione el switch
        var btn3=$(this);
        var tr=btn3.closest('tr');//con esta función cojo el elemento 'tr' más cercano al botón.
        fila3=tbl.row(tr).index();//Así obtengo la posición de la fila
        valoresRegistro={
            "opcion": "eliminar",
            "id_registro":tbl.cell(fila3, 0).data(),
            "fecha":tbl.cell(fila3, 1).data(),
            "horas":tbl.cell(fila3, 2).data(),
            "observaciones":tbl.cell(fila3, 3).data()
                


        };//En este array cojo el valor de cada celda
            $.confirm({
                title: 'Eliminar registro',
                content: '¿Estás seguro de que eliminar este registro?',
                type: 'orange',
                buttons: {
                    Confirmar: {
                    text: 'ELiminar',
                    btnClass: 'btn-orange',
                    action:function () {
                        eliminarRegistro();
                        $("#formulario")[0].reset(); 
                        $(".has-error").removeClass('has-error'); 
                        $('#myModal').modal('hide');//Para que desaparezca el formulario modal
                        }           
                    },
                    Cancelar: {
                        
                    }
                }
            });

    });


   //Validación de campos del formulario
   var validar_fecha=function(fecha) {
        var fechaf = fecha.split("-");
        var d = fechaf[2];
        var m = fechaf[1];
        var y = fechaf[0];
        return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
    }

    var Buscar=function(cadena){
        encontrado=false;
        tbl.rows().eq(0).each( function ( index ) {
        var row = tbl.row( index );
        var data = tbl.cell(row, 1).data();
            if(data==cadena){
                encontrado=true;
            }

        } );

        return encontrado;

    }

    
    var validar=function(){
        
        var patron = /[A-Za-z0-9ñÑ-áéíóúÁÉÍÓÚçÇ\s\.\,\:\?¿\!¡]/;
        if ($('#datepicker').val()=="") {
            $('#divfecha').addClass('has-error');
            $('#helpBlock1').html('No has introducido la fecha');
            $('#helpBlock1').removeClass('hide');
            res=1;
            
        }else{
            if(!validar_fecha($('#datepicker').val())){
                $('#divfecha').addClass('has-error');
                $('#helpBlock1').html('La fecha no es correcta');
                $('#helpBlock1').removeClass('hide');
                res=1;

            }else{

                if($('#opcion').val()=='anadir' && Buscar($('#datepicker').val())){
                    $('#divfecha').addClass('has-error');
                    $('#helpBlock1').html('La fecha ya existe');
                    $('#helpBlock1').removeClass('hide');
                    res=1;

                }else{
                    $('#fecha').removeClass('has-error');
                    $('#helpBlock1').addClass('hide'); 
               }
                
            }
                
        }
        
        if ($('#horas').val()=="") {
            $('#divhoras').addClass('has-error');
            $('#helpBlock2').html('No has introducido las horas');
            $('#helpBlock2').removeClass('hide');
            res=1;
        }else{
            if(isNaN($('#horas').val())){
                $('#divhoras').addClass('has-error');
                $('#helpBlock2').html('Las horas no son correctas');
                $('#helpBlock2').removeClass('hide');
                res=1;

            }else{
                $('#divhoras').removeClass('has-error');
                $('#helpBlock2').addClass('hide');
            }

        }
    
        if ($('#observaciones').val()=="") {
            $('#divobservaciones').addClass('has-error');
            $('#helpBlock3').html('No has introducido las observaciones');
            $('#helpBlock3').removeClass('hide');
            res=1;
        }else{
            if(!patron.test($('#observaciones').val())){
                $('#divobservaciones').addClass('has-error');
                $('#helpBlock3').html('Las observaciones no son correctas');
                $('#helpBlock3').removeClass('hide');
                res=1;
            }else{
                $('#divobservaciones').removeClass('has-error');
                $('#helpBlock3').addClass('hide');
            }     
        }
   }


   /**********FUNCIÓN PARA DAR DE ALTA****************/

   var altas=function () {
    var envio=  $('#formulario').serialize();
    var control=false;
    $.confirm({

        title: 'Registro de horas',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'alumno/insertardia.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json"
            }).done (function (data) {
                if(data==0){
                    self.setType('red');
                    self.setContentAppend('Los datos introducidos no son correctos<br>');
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
                                    "num_horas": value.num_horas,
                                    "fecha": value.fecha,
                                    "observaciones": value.observaciones
                                    }
                                    tbl.row.add(valores).draw(false);
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
    var envio=  $('#formularioperfil').serialize();
    var control=false;
    $.confirm({
        title: 'Modificación de datos personales',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   '/ProyectoFinal/paxinas/administrador/gestionalumno/modificaralumnos.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
            }).done(function (data) {
                //self.setContentAppend(data);
                if(data==0){
                    self.setType('red'),
                    self.setContentAppend('Los datos no son correctos');
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
                                    $("#apellidos").val(value.apellidos);
                                    $("#nombre").val(value.nombre);
                                    $("#dni").val(value.dni);
                                    $("#direccion").val(value.direccion);
                                    $("#telefono").val(value.telefono);
                                    $("#email").val(value.email);
                                    $("#estudios").val(value.estudios);
                                    $("#tecnologias").val(value.tecnologias);
                                    $("#preferencias").val(value.preferencias);

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

   var modificarRegistro=function () {
    var envio=  $('#formulario').serialize();
    var control=false;
    $.confirm({
        title: 'Modificar registro',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'alumno/modificardia.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
            }).done(function (data) {
                if(data==0){
                    self.setType('red'),
                    self.setContentAppend('Los datos no son correctos');
                }else{
                    $.each(data,function(index,value){
                        if(index=='alumno'){
                            if(value==0){
                            self.setType('red'),
                            self.setContentAppend('No se han podido recuperar los datos del alumno<br>');
                            }else{
                                if(value==1){
                                self.setType('red'),
                                self.setContentAppend('No se han podido modificar los datos del alumno<br>');  
                                }else{
                                     var valores={
                                        "id":value.id,
                                        "num_horas": value.num_horas,
                                        "fecha": value.fecha,
                                        "observaciones": value.observaciones
                                    }
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

   /*****ELIMINAR REGISTRO***********/

   var eliminarRegistro=function () {
    
    var control=false;
    $.confirm({
        title: 'Eliminar registro',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'alumno/modificardia.php',//archivo donde está el código para ejecutar las altas

                data:  valoresRegistro,// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
            }).done(function (data) {
                if(data==0){
                    self.setType('red'),
                    self.setContentAppend('Los datos no son correctos');
                }else{
                    $.each(data,function(index,value){
                        if(index=='alumno'){
                            if(value==0){
                            tbl.row(fila3).remove().draw(false);
                            control=true;
                            }
                            
                            if(value==1){
                            self.setType('red'),
                            self.setContentAppend('No se han podido eliminar los datos del alumno<br>');  
        
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
    tbl=$('#alumnofct').DataTable( {
        "language": {
                "url": "/ProyectoFinal/plugins/datatables/lang/"+idiomas[lengua]+".json"
            },
        "ajax":"alumno/datosfct.php",
        //Creo las columnas de la tabla
         "columns": [
            { "data": "id"},
            { "data": "fecha"},
            { "data": "num_horas" },
            { "data": "observaciones",
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
                width: "10%"
            },
            {
                targets: [2],
                width: "10%"
            },
            {
                targets: [4],
                width: "10%"
            }
           
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

    
         
        
