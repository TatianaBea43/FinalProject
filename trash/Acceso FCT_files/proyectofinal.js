$(document).ready(function() {
	
	var alert= function (texto) {
           $('#alerta').removeClass("hide");
           $('#alerta').html(texto);
           
           setTimeout(function(){
            $('#alerta').addClass('hide');
           },8000);

    };



}