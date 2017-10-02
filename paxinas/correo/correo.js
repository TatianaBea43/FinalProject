
CKEDITOR.replace('editor1');
var parametros = {
                "valor" : 0
        	};
//var box='<div class="radio"><label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Option two can be something else and selecting it will deselect option one</label></div>';

$("#seleccion").change(function(){
		var opcion=$("#seleccion").val();
	switch (opcion) {
		case "1":
			parametros = {
                "valor" : 1
        	};
			buscarmail();
			break;
		case "2":
			parametros = {
                "valor" : 2
        	};
			buscarmail();
			break;
	}
})

var buscarmail=function(){
	$.ajax({
                               
                url:   'correo/buscarmail.php',//archivo donde está el código para ejecutar las altas

                data:  parametros,// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json",

                // código a ejecutar si la petición es satisfactoria;
                // la respuesta es pasada como argumento a la función
                success : function(data) {
                    
                    
                },
             
                // código a ejecutar si la petición falla;
     
                error : function() {
           
               
               } 
        });
}