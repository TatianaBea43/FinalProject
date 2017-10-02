
 var res=0;

 var verificar= function () {
 	var patronpass=/[a-zA-Z0-9_\.\-]/;
 	if ($('#usuario').val()=="") {
        $('#primero').addClass('has-error');
        $('#helpBlock1').removeClass('hide');
        res=1;
    }else{
        $('#primero').removeClass('has-error');
        $('#helpBlock1').addClass('hide');
    }

    if ($('#pass1').val()=="") {
        $('#segundo').addClass('has-error');
        $('#helpBlock2').removeClass('hide');
        res=1;
    }else{
        $('#segundo').removeClass('has-error');
        $('#helpBlock2').addClass('hide');
    }

    if ($('#pass2').val()=="") {
      $('#tercero').addClass('has-error');
      $('#helpBlock3').html('No has introducido la contraseña');
      $('#helpBlock3').removeClass('hide');
      res=1;
    }else{ 
        if ($('#pass2').val().length>10){
        $('#tercero').addClass('has-error');
        $('#helpBlock3').html('La contraseña no puede contener más de 10 caracteres');
        $('#helpBlock3').removeClass('hide');
        res=1;
        }else{
            if(!patronpass.test($('#pass2').val().trim())){
            $('#tercero').addClass('has-error');
            $('#helpBlock3').html('Hay caracteres no aceptados en su contraseña. Puede usar letras, números, puntos y/o barras');
            $('#helpBlock3').removeClass('hide');
            res=1;
            }else{
                $('#tercero').removeClass('has-error');
                $('#helpBlock3').addClass('hide'); 
            }
        }
    }

    if ($('#pass3').val()=="") {
      $('#cuarto').addClass('has-error');
      $('#helpBlock4').html('No has introducido la contraseña');
      $('#helpBlock4').removeClass('hide');
      res=1;
    }else{
        if ($('#pass2').val()!=$('#pass3').val()){
        $('#tercero').addClass('has-error');
        $('#cuarto').addClass('has-error');
        $('#helpBlock4').html('Hay un error en la verificación de la contraseña');
        $('#helpBlock4').removeClass('hide');
        res=1;
        }else{
           $('#cuarto').removeClass('has-error');
           $('#helpBlock4').addClass('hide'); 
        }
    }

}

 $('#btncambiar').on('click', function(e){
            verificar();
            if(res==1){
            e.preventDefault();//capo la función submit del botón. Si no también podría capar el submit antes de las comprobaciones y después hacer un else y añadir la función submit al formulario ($('form').submit();)
            res=0;
            }
            else{
                cambiar();//función para enviar datos a la bd
                $("#formpass")[0].reset(); 
                $(".has-error").removeClass('has-error');
                $(".helpBlock").addClass('hide');
                $('#helpBlock3').removeClass('hide');
                $('#helpBlock3').html('La contraseña no puede contener más de 10 caracteres');

            }
})



var cambiar=function () {
   var envio=  $('#formpass').serialize(); 
   var control=false;
    $.confirm({

        title: 'Cambiar contraseña',
        type: 'blue',
        columnClass: 'medium',
        content: function(){
            var self = this;
            return $.ajax({
                                   
                    url:   'pass/cambiarpass.php',//archivo donde está el código para ejecutar las altas

                    data:  envio,// la información a enviar. Está convertida en una cadena de datos)

                    type: 'POST',

                    dataType: "json"

            }).done(function (data) {
                if(data==0){
                    self.setType('red');
                    self.setContentAppend('Error al crear el objeto usuario');
                }else{
                    $.each(data,function(index,value){
                       if(index=='usuario'){
                         if(value==2){
                            self.setType('red'),
                            self.setContentAppend('La contraseña no es correcta');
                         }else{
                            if(value==1){
                                control=true;
                            }else{
                                self.setType('red'),
                                self.setContentAppend('No se ha podido conectar con la base de datos');
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
                    self.setContentAppend('La contraseña ha sido cambiada correctamente');
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

       /*$.ajax({
                               
                url:   'pass/cambiarpass.php',//archivo donde está el código para ejecutar las altas

                data:  $('#formpass').serialize(),// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json",

                // código a ejecutar si la petición es satisfactoria;
                // la respuesta es pasada como argumento a la función
                beforeSend: function(){
                    $("#dialog").dialog({
                       title: 'Cargando la petición', 
                       content:'<div><img src="../img/ajax-loader.gif"/></div><div>Procesando, espere por favor...</div>',
                       type: 'blue'

                    })

                },
                success : function(data) {
                	if(data==="La contraseña ha sido cambiada correctamente"){
                		$("#dialog").dialog({
                           title: 'Petición procesada con éxito', 
                           content:data,
                           Type: 'green'

                        })
                	}else {
                		$("#dialog").dialog({
                           title: 'Error en la petición', 
                           content:data,
                           Type: 'red'

                        })
                	}
                     
                    
                },
             
                // código a ejecutar si la petición falla;
                error : function() {
                
                   $.dialog({
                       title: 'Error en el proceso', 
                       content:'Up! ha sucedido un error inesperado',
                       type: 'red'

                    })
                }
            
        });*/
  


