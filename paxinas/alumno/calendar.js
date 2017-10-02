//$().ready(function() {
	var contador=0;
	var extraEvents=new Array();
    //$res=0;
    
    var options = { 

    	firstDayOfWeek: 1,
	    navLinks: {
	        enableToday: true,
			enableNextYear: true,
			enablePrevYear: true,
			p:'&lsaquo; Ant', 
			n:'Sig &rsaquo;', 
			t:'Hoy'
	    },
	    locale: {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],

        daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],

        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],

        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],

        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]

    },
    onEventBlockClick: function(event) {
        $.confirm({
            title: event.Date,
            content: event.Description,
            columnClass: 'large',
            type: 'purple',
            buttons:{
                ok:{
                    text:'OK',
                    btnClass:'btn-purple'
                }
            },
            draggable: true
        });   

    }

    };
    



    
    
    var events = [    
    
        /*{ "EventID": 3, "Date": "2017-05-23", "Title": "9:30 pm - this is a much longer title", "Description": "This is a sample event description", "CssClass": "Meeting" }
            { "EventID": 2, "Date": "2009-02-28T00:00:00.0000000", "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" },*/


    ];
    
    envio={'opcion_alumno': $('#opcion_alumno').val()};

    $.ajax({
                data:  envio,
                               
                url:   'alumno/gestioncalendario.php',//archivo donde está el código para ejecutar las altas

                type: 'POST',

                dataType: "json"
            }).done(function( data ) {
            	$.each(data,function(index,value){
                    contador++;
                    if(index=='eventos'){
                        $.each(value,function(index2,value2){
                            $.each(value2,function(index3,value3){
                                valores={
                                "EventID": contador,
                                "Date": value3.fecha_evento,
                                "Title": value3.evento,
                                "Description": value3.descripcion,
                                "CssClass": "Reunion"
                                }
                            $.jMonthCalendar.AddEvents(valores);
                            })

                        })
                    }
                    if(index=='horas'){
                        $.each(value,function(index2,value2){
                            $.each(value2,function(index3,value3){
                                if(value3.num_horas==0){
                                    valores={
                                    "EventID": contador,
                                    "Date": value3.fecha,
                                    "Title": 'No presentado',
                                    "Description": value3.observaciones,
                                    "CssClass": "HorasNO"
                                    }
                                }else{
                                  valores={
                                    "EventID": contador,
                                    "Date": value3.fecha,
                                    "Title": value3.num_horas,
                                    "Description": value3.observaciones,
                                    "CssClass": "Horas"
                                    }  
                                }
                                
                            $.jMonthCalendar.AddEvents(valores);
                            })

                        })
                    }
                    if(index=='proyecto'){
                        if(value==null){
                            alert("Todavía no se ha asignado un proyecto a este alumno")
                        }else{
                             valores={
                                "EventID": contador,
                                "Date": value.inicio,
                                "Title": "Fecha inicio",
                                "Description": "Empresa: "+value.razon_social+"<br>Email: "+value.email+"<br>Total_Horas: "+value.total_horas,
                                "CssClass": "Proyecto"
                                }
                                contador++;
                            valores2={
                                "EventID": contador,
                                "Date": value.fin,
                                "Title": "Fecha fin",
                                "Description": "Empresa: "+value.razon_social+"<br>Email: "+value.email+"<br>Total_Horas: "+value.total_horas,
                                "CssClass": "Proyecto"
                            }
                        $.jMonthCalendar.AddEvents(valores);
                        $.jMonthCalendar.AddEvents(valores2);

                        }
                        
                           
                    }

            		
            	})
            })
 
	
    $.jMonthCalendar.Initialize(options, events);

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

    var mostrarevento= function () {
   $('#myModalEvento').modal({
        show: true,
        backdrop:false,
        keyboard:false
    });
};
$("#botonCerrarEvento").on('click', function(){
        $("#formularioEvento")[0].reset();
        $(".has-error").removeClass('has-error'); 
        $(".help-block").addClass('hide'); 
    });

    //Para que elimine los datos al darle a la x de cerrar
$('#myModalEvento').on('hide.bs.modal', function () {
    $("#formularioEvento")[0].reset();
    $(".has-error").removeClass('has-error'); 
    $(".help-block").addClass('hide'); 
});
var validar_fecha=function(fecha) {
        var fechaf = fecha.split("-");
        var d = fechaf[2];
        var m = fechaf[1];
        var y = fechaf[0];
        return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
    }
var validarEvento=function(){
        
        var patron = /[A-Za-z0-9ñÑ-áéíóúÁÉÍÓÚçÇ\s\.\,\:]/;
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
                $('#fecha').removeClass('has-error');
                $('#helpBlock1').addClass('hide');
            }
                
        }
        if ($('#tituloevento').val()=="") {
            $('#divtituloevento').addClass('has-error');
            $('#helpBlock3').html('No has introducido el título');
            $('#helpBlock3').removeClass('hide');
            res=1;
            
        }else {
            if (!patron.test($('#tituloevento').val().trim())) {
            $('#divtituloevento').addClass('has-error');
            $('#helpBlock3').html('El título no es correcto');
            $('#helpBlock3').removeClass('hide');
            res=1;
            }else{
                $('#divtituloevento').removeClass('has-error');
                $('#helpBlock3').addClass('hide');
            }
        } 

        if ($('#descripcion').val()=="") {
            $('#divdescripcion').addClass('has-error');
            $('#helpBlock2').html('No has introducido la descripción');
            $('#helpBlock2').removeClass('hide');
            res=1;
            
        }else {
            if (!patron.test($('#descripcion').val().trim())) {
            $('#divdescripcion').addClass('has-error');
            $('#helpBlock2').html('La descripción no es correcta');
            $('#helpBlock2').removeClass('hide');
            res=1;
            }else{
                $('#divdescripcion').removeClass('has-error');
                $('#helpBlock2').addClass('hide');
            }
        } 
}
 $('#botonevento').on('click', function(){
     $('#id_alumnoModal').val($('#opcion_alumno').val());
     mostrarevento();
 })
 
 $('#botonModalEvento').on('click', function(e){
     validarEvento();
        if(res==1){
        e.preventDefault();//capo la función submit del botón. Si no también podría capar el submit antes de las comprobaciones y después hacer un else y añadir la función submit al formulario ($('form').submit();)
        res=0;
        }
        else{
            anadirEvento();//función para enviar datos a la bd
            $("#formularioEvento")[0].reset();
            $(".has-error").removeClass('has-error');
            $('#myModalEvento').modal('hide');
        }
 })
 var anadirEvento=function () {
    var envio=  $('#formularioEvento').serialize();
    var control=false;
    $.confirm({

        title: 'Añadir evento',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                               
                url:   'alumno/eventos.php',//archivo donde está el código para ejecutar las altas

                data:  envio,// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json"
            }).done (function (data) {
                if(data==0){
                    self.setType('red');
                    self.setContentAppend('Error al crear el objeto usuario');
                }else{
                    $.each(data,function(index,value){
                        if(index=="evento"){
                            if(value==0){
                            self.setType('red');
                            self.setContentAppend('No se han podido insertar el evento<br>');
                            }else{
                                if(value==1){
                                  self.setType('red');
                                  self.setContentAppend('No se han podido insertar el evento<br>');  
                                }else{
                                    contador++;
                                    valores={
                                            "EventID": contador,
                                            "Date": value.fecha_evento,
                                            "Title": value.evento,
                                            "Description": value.descripcion,
                                            "CssClass": "Reunion"
                                            }
                                    $.jMonthCalendar.AddEvents(valores);
                                    
                                    self.setType('green');
                                    self.setContentAppend('Operación realizada con éxito');
                                }
                            }
                        }
                        if(index=='errores'){
                            self.setType('red'),
                            self.setContentAppend(value);
                        }
                    
                    })
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

   //$.jMonthCalendar.onEventBlockClick(event);

   //$.jMonthCalendar.DrawEventsOnCalendar();


//});

