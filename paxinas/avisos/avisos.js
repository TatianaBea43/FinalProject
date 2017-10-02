 btns='<div class="text-center"><button type="button" class=" ver btn btn-warning" id="ver"><span class="glyphicon glyphicon-eye-open"></button>';    
 
 

 tbl=$('#avisos').DataTable( {
        "language": {
                "url": "/ProyectoFinal/plugins/datatables/lang/"+idiomas[lengua]+".json"
            },
        "ajax":"avisos/gestionavisos.php",
        //Creo las columnas de la tabla
         "columns": [
            { "data": "id"},
            { "data": "id_alumno"},
            { "data": "fecha"},
            { "data": "aviso",
                render: function (data) {
                    
                    if(data.length<90){
                        return data; 
                    }else{
                        return data.substring(0, 90)+'...';
                    }
                } 

            },
            { "data": "estado"},
            { "data": null,
            defaultContent: btns}
        ],
        "order": [[ 2, "desc" ]],

        autoWidth: false,
        fixedColumns: true,

        columnDefs:[
            {
                targets: [0],
                visible:false,
            },
            {
                targets: [1],
                visible:false
            },
            {
                targets: [2],
                width: "20%"
            },
            {
                targets: [3],
                width: "70%"
            },
            

            {
                targets: [4],
                visible:false
            },
            {
                targets: [5],
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
                
            }
            
        ],

         fnCreatedRow  : function (nRow, data) {
                  if(data.estado=='0'){
                    $(nRow).addClass("highlight");
                  }else if (data.estado=='1') {
                    $(nRow).addClass("downlight");
                  }


         }
    } );
 var mostraraviso= function () {
           $('#myModalAviso').modal({
                        show: true,
                        backdrop:false,
                        keyboard:false
                    });
                };

 $('#avisos').on('click', '.ver', function () {
    var btn2=$(this);
    var tr=btn2.closest('tr');
    //tr.addClass('highlight');
    fila2=tbl.row(tr).index();//Así obtengo la posición de la fila

    $('#idaviso').val(tbl.cell(fila2, 0).data());
    $('#id_alumno_aviso').val(tbl.cell(fila2, 1).data());
    $('#fechaaviso').val(tbl.cell(fila2, 2).data());
    $('#aviso').val(tbl.cell(fila2, 3).data());
            
    
    mostraraviso();
   
        
    } );

 $('#botonLeido').on('click', function(){
    $.ajax({
                               
                url:   'avisos/gestionavisos.php',//archivo donde está el código para ejecutar las altas

                data:  $('#formularioAviso').serialize(),// la información a enviar. Está convertida en una cadena de datos

                type: 'POST',

                dataType: "json"
      

        }).done(function(data){

            $("#btnavisos").html('Avisos ('+data+')');
            

        }).fail(function() {
            alert( "Se ha producido un error" );
          })
        tbl.ajax.reload();

 })

 $("#btnactividades").on('click', function(){
    location.reload();
})
