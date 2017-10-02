var id=null;
var msg="";
var idiomas = new Array();
	idiomas['es'] = 'Spanish';
	idiomas['gl'] = 'Galician';
	idiomas['en'] = 'English';
var lengua=navigator.language;


    //Creo los botones de modificar y eliminar fila
    botones='<div class="text-center"><button type="button" class=" alta btn btn-success" ><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>&nbsp;<button type="button" class="baja btn btn-danger" ><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button></div>';
    

      
    //Botón para dar de alta
    $("#usuarios").on('click', '.alta', function(){
        var btn2=$(this);
        var tr=btn2.closest('tr');//con esta función cojo el elemento 'tr' más cercano al botón.
        fila2=tbl.row(tr).index();//Así obtengo la posición de la fila
        valores2={
            'id': tbl.cell(fila2, 0).data(),
            'usuario': tbl.cell(fila2, 1).data(),
            'apellidos': tbl.cell(fila2, 2).data(),
            'nombre': tbl.cell(fila2, 3).data(),
            'email': tbl.cell(fila2, 4).data(),
            'tipo': tbl.cell(fila2, 5).data()       

        };
        $.confirm({
            columnClass: 'medium',
            title: 'Alta de usuario',
            content: '¿Estás seguro de que deseas dar de alta a '+tbl.cell(fila2, 3).data()+' '+tbl.cell(fila2, 2).data()+'?',
            type:'orange',
            buttons: {
                Aceptar: {
                    text:'Aceptar',
                    btnClass:'orange',
                    action: function () {
                        altas();
                        //$.alert('El usuario ha sido dado de alta');
                    }
                },
                Cancelar: function () {
                    //$.alert('La operación ha sido cancelada');
                }
            }
        });
    });

        
    //Botón para dar de baja
    $("#usuarios").on('click', '.baja', function(){
        var btn2=$(this);
        var tr=btn2.closest('tr');//con esta función cojo el elemento 'tr' más cercano al botón.
        fila2=tbl.row(tr).index();//Así obtengo la posición de la fila
        valores1={
            'id': tbl.cell(fila2, 0).data(),
            'usuario': tbl.cell(fila2, 1).data(),
            'email': tbl.cell(fila2, 4).data(),
            'tipo': tbl.cell(fila2, 5).data()       

        };
        $.confirm({
            columnClass: 'medium',
            title: 'Baja de usuario',
            content: '¿Estás seguro de que deseas dar de baja a '+tbl.cell(fila2, 3).data()+' '+tbl.cell(fila2, 2).data()+'?',
            type:'orange',
            buttons: {
                Aceptar: {
                    text:'Aceptar',
                    btnClass:'orange',
                    action: function () {
                        bajas();
                        //$.alert('El usuario ha sido dado de baja');
                    }
                },
                Cancelar: function () {
                    //$.alert('La operación ha sido cancelada');
                }
            }
        });
    });



   var altas=function () {
       //var envio=  valores2;
       var control=false;
       $.confirm({

            title: 'Alta de usuario',
            type: 'blue',
            columnClass: 'medium',
            content: function(){ 
                var self = this;
                return $.ajax({
                               
                url:   'administrador/gestionusuario/altausuario.php',//archivo donde está el código para ejecutar las altas

                data:  valores2,// la información a enviar. Está convertida en una cadena de datos)

                type: 'POST',

                dataType: "json"

                }).done(function (data) {
                    if(data==0){
                        self.setType('red'),
                        self.setContentAppend('Error al crear el objeto usuario');
                    }else{
                           $.each(data,function(index,value){
                            if(index=='usuario'){
                                if(value==0){
                                    self.setType('red'),
                                    self.setContentAppend('No se ha podido dar de alta al usuario');
                                }else{
                                    var valores={
                                    "id":value.id,
                                    "usuario":value.usuario,
                                    "apellidos": value.apellidos,
                                    "nombre": value.nombre,
                                    "email": value.email,
                                    "tipousuario": value.tipousuario,
                                    "alta": value.alta,
                                    "baja":value.baja,
                                    "activo":value.activo
                                    };
                                    tbl.row(fila2).data(valores);
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

   
   var bajas=function () {
       var control=false;
       $.confirm({
            title: 'Baja de usuario',
            type: 'blue',
            columnClass: 'medium',
            content: function(){ 
                var self = this;
                return $.ajax({
                               
                url:   'administrador/gestionusuario/bajasusuario.php',//archivo donde está el código para ejecutar las altas

                data:  valores1,// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
                }).done(function (data) {
                    if(data==0){
                        self.setType('red'),
                        self.setContentAppend('Error al crear el objeto usuario');
                    }else{
                        $.each(data,function(index,value){
                            if(index=='usuario'){
                                if(value==0){
                                   self.setType('red'),
                                   self.setContentAppend('No se han podido recuperar los datos del usuario'); 
                                }else{
                                    if(value==1){
                                        self.setType('red'),
                                        self.setContentAppend('No se ha podido dar de baja al usuario');
                                    }else{
                                        var valores={
                                            "id":value.id,
                                            "usuario":value.usuario,
                                            "apellidos": value.apellidos,
                                            "nombre": value.nombre,
                                            "email": value.email,
                                            "tipousuario": value.tipousuario,
                                            "alta": value.alta,
                                            "baja":value.baja,
                                            "activo":value.activo
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

/****carga de datatable*****/    
//en la variable 'tbl' meto el objeto datatable
    tbl=$('#usuarios').DataTable( {
        "language": {
                "url": "/ProyectoFinal/plugins/datatables/lang/"+idiomas[lengua]+".json"
            },
        "ajax":"administrador/gestionusuario/datosusuario.php",

        //Creo las columnas de la tabla
        "columns": [
            { "data": "id"},
            { "data": "usuario"},
            { "data": "apellidos" },
            { "data": "nombre" },
            { "data": "email" },
            { "data": "tipousuario",
                render:function(data){
                    switch (data) {
                        case '1':
                            return 'Administrador';
                        break;
                        case '2':
                            return 'Alumno';
                        break;
                        case '3':
                            return 'Tutor';
                        break;
                    } 
                }
            },
            { "data": "alta" },
            { "data": "baja" },
            { "data": "activo",
                render:function(data){
                    switch (data) {
                        case '0':
                            return 'No activo';
                        break;
                        case '1':
                            return 'Activo';
                        break;
                    } 
                }
            },
            { "data": null,
            defaultContent: botones}
        ],

        autoWidth: false,

        columnDefs:[
            {
                targets: [0],
                visible:false
            },
            {
                targets: [1],
                visible:false
            },
            {
                targets: [4],
                visible:false
            },
            {
                targets: [2],
                width: "20%"
            },
            {
                targets: [3],
                width: "20%"
            },
            {
                targets: [4],
                width: "12%"
            },
            {
                targets: [5],
                width: "12%"
            },
            {
                targets: [6],
                width: "12%"
            },
            {
                targets: [7],
                width: "12%"
            },
            {
                targets: [8],
                width: "12%"
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
                
            }
            
    ]
    } );

    
         
        
