$(function() {
	

    function ceros (num) {

		if(num.toString().length<2){
			num ="0"+num;
		}

		return num;
		}//Esta función añade un cero para que los dígitos de la fecha sean al mínimo 2

	var reloj=function (){

		f=new Date();

		var horas=f.getHours();
		var minutos=f.getMinutes();
		var segundos=f.getSeconds();
		var horaactual=ceros(horas)+":"+ceros(minutos)+":"+ceros(segundos);

		$('#reloj').html(horaactual);		
	
		setTimeout(function(){reloj();},1000);//Esta función le dice que cada 1000 milisegundos, es decir, cada segundo, llame a la función reloj(). De esta manera conseguimos que la hora se actualice cada segundo.
	

	}

	reloj();

	var fecha=function(){
		fa=new Date();

		var ano=fa.getFullYear();//para extraer de la fecha el año
		var mes=fa.getMonth();//para extraer el mes. IMPORTANTE: esta función me da un entero de 0 a 11 donde 0 sería Enero y Diciembre 11, por eso siempre hay que sumarle 1 para que me dé el mes exacto. Le sumaré 1 cuando creo la cadena de la fecha.
		var dia=fa.getDate();//para extraer el día

		var meses="enero,febrero,marzo,abril,mayo,junio,julio,agosto,septiembre,octubre,noviembre,diciembre";
		var arraymeses=meses.split(",");

		var dias="Domingo,Lunes,Martes,Miércoles,Jueves,Viernes,Sábado";//empiezo por domingo porque la función que utilizo para calcular el día entiende que el primer día de la semana es domingo.
		var arraydias=dias.split(",");
		var diadelasemana=fa.getDay();//me devuelve un número del 0 al 6 al que se corresponde el día actual, siendo 0 el domingo y 6 el sábado
		var resultado=arraydias[diadelasemana]+", "+ceros(dia)+"-"+arraymeses[mes]+"-"+ano;//Del array de nombres de dias extraigo aquel que esté en la posición que me indica la variable diadelasemana.
		$("#fecha").html(resultado);


	}

	fecha();

	function crearpie (){
		
		var ano=new Date().getFullYear();
		resultado = "&copy; "+ano+"/"+(ano+1)+" Tatiana";
		$("#footer").html(resultado);
	}

	crearpie();

	var alerta=function (){
		$('#modalerror').modal({show:true});

	}
	alerta();

	
});