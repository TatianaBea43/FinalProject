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
        
        var patron = /[A-Za-z0-9ñÑ-áéíóúÁÉÍÓÚçÇ\s\.\,\:\?¿\¡!]/;
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
 
 $('#botonModalEvento').on('click', function(){
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
                self.setContentAppend(data);
                /*if(data==0){
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
                }*/

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