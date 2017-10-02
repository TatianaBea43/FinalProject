$(document).ready(function() {

	$("#btnusuario").on('click',function () {
		
    	$("#cuerpo").load('administrador/gestionusuario/tablausuario.html');
	});

	$("#btnalumno").on('click',function () {
		
    	$("#cuerpo").load('administrador/gestionalumno/tablaalumno.html');
	});

	$("#btntutor").on('click',function () {
		
    	$("#cuerpo").load('administrador/gestiontutor/tablatutor.html');
	});

    $("#btnempresa").on('click',function () {
        
        $("#cuerpo").load('administrador/gestionempresa/tablaempresa.html');
    });

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
                Cancelar: function () {
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





});