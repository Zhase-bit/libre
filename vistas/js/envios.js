/*=============================================
CARGAR LA TABLA DINÁMICA DE envioS
=============================================*/



$('.tablaenvios').DataTable( {
    "ajax": "ajax/datatable-envios.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );

/*=============================================
AGREGANDO libroS A LA envio DESDE LA TABLA
=============================================*/

$(".tablaenvios tbody").on("click", "button.agregarlibro", function(){

	var idlibro = $(this).attr("idlibro");

	$(this).removeClass("btn-primary agregarlibro");

	$(this).addClass("btn-default");

	var datos = new FormData();
    datos.append("idlibro", idlibro);

     $.ajax({

     	url:"ajax/libros.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){

      	    var descripcion = respuesta["descripcion"];
          	var stock = respuesta["stock"];
          	var precio = respuesta["precio_envio"];

          	/*=============================================
          	EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
          	=============================================*/

          	if(stock == 0){

      			swal({
			      title: "No hay stock disponible",
			      type: "error",
			      confirmButtonText: "¡Cerrar!"
			    });

			    $("button[idlibro='"+idlibro+"']").addClass("btn-primary agregarlibro");

			    return;

          	}

          	$(".nuevolibro").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del libro -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarlibro" idlibro="'+idlibro+'"><i class="fa fa-times"></i></button></span>'+

	              '<input type="text" class="form-control nuevaDescripcionlibro" idlibro="'+idlibro+'" name="agregarlibro" value="'+descripcion+'" readonly required>'+

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del libro -->'+

	          '<div class="col-xs-3">'+
	            
	             '<input type="number" class="form-control nuevaCantidadlibro" name="nuevaCantidadlibro" min="1" value="1" stock="'+stock+'" nuevoStock="'+Number(stock-1)+'" required>'+

	          '</div>' +

	          '<!-- Precio del libro -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPreciolibro" precioReal="'+precio+'" name="nuevoPreciolibro" value="'+precio+'" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>') 

	        // SUMAR TOTAL DE PRECIOS

	        sumarTotalPrecios()

	        // AGREGAR IMPUESTO

	        agregarImpuesto()

	        // AGRUPAR libroS EN FORMATO JSON

	        listarlibros()

	        // PONER FORMATO AL PRECIO DE LOS libroS

	        $(".nuevoPreciolibro").number(true, 2);

      	}

     })

});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaenvios").on("draw.dt", function(){

	if(localStorage.getItem("quitarlibro") != null){

		var listaIdlibros = JSON.parse(localStorage.getItem("quitarlibro"));

		for(var i = 0; i < listaIdlibros.length; i++){

			$("button.recuperarBoton[idlibro='"+listaIdlibros[i]["idlibro"]+"']").removeClass('btn-default');
			$("button.recuperarBoton[idlibro='"+listaIdlibros[i]["idlibro"]+"']").addClass('btn-primary agregarlibro');

		}


	}


})


/*=============================================
QUITAR libroS DE LA envio Y RECUPERAR BOTÓN
=============================================*/

var idQuitarlibro = [];

localStorage.removeItem("quitarlibro");

$(".formularioenvio").on("click", "button.quitarlibro", function(){

	$(this).parent().parent().parent().parent().remove();

	var idlibro = $(this).attr("idlibro");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL libro A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarlibro") == null){

		idQuitarlibro = [];
	
	}else{

		idQuitarlibro.concat(localStorage.getItem("quitarlibro"))

	}

	idQuitarlibro.push({"idlibro":idlibro});

	localStorage.setItem("quitarlibro", JSON.stringify(idQuitarlibro));

	$("button.recuperarBoton[idlibro='"+idlibro+"']").removeClass('btn-default');

	$("button.recuperarBoton[idlibro='"+idlibro+"']").addClass('btn-primary agregarlibro');

	if($(".nuevolibro").children().length == 0){

		$("#nuevoImpuestoenvio").val(0);
		$("#nuevoTotalenvio").val(0);
		$("#totalenvio").val(0);
		$("#nuevoTotalenvio").attr("total",0);

	}else{

		// SUMAR TOTAL DE PRECIOS

    	sumarTotalPrecios()

    	// AGREGAR IMPUESTO
	        
        agregarImpuesto()

        // AGRUPAR libroS EN FORMATO JSON

        listarlibros()

	}

})

/*=============================================
AGREGANDO libroS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numlibro = 0;

$(".btnAgregarlibro").click(function(){

	numlibro ++;

	var datos = new FormData();
	datos.append("traerlibros", "ok");

	$.ajax({

		url:"ajax/libros.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    	$(".nuevolibro").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del libro -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarlibro" idlibro><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionlibro" id="libro'+numlibro+'" idlibro name="nuevaDescripcionlibro" required>'+

	              '<option>Seleccione el libro</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

	          '<!-- Cantidad del libro -->'+

	          '<div class="col-xs-3 ingresoCantidad">'+
	            
	             '<input type="number" class="form-control nuevaCantidadlibro" name="nuevaCantidadlibro" min="1" value="1" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del libro -->'+

	          '<div class="col-xs-3 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPreciolibro" precioReal="" name="nuevoPreciolibro" readonly required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');


	        // AGREGAR LOS libroS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	if(item.stock != 0){

		         	$("#libro"+numlibro).append(

						'<option idlibro="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
		         	)

		         }

	         }

	         // SUMAR TOTAL DE PRECIOS

    		sumarTotalPrecios()

    		// AGREGAR IMPUESTO
	        
	        agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS libroS

	        $(".nuevoPreciolibro").number(true, 2);

      	}


	})

})

/*=============================================
SELECCIONAR libro
=============================================*/

$(".formularioenvio").on("change", "select.nuevaDescripcionlibro", function(){

	var nombrelibro = $(this).val();

	var nuevaDescripcionlibro = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionlibro");

	var nuevoPreciolibro = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPreciolibro");

	var nuevaCantidadlibro = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadlibro");

	var datos = new FormData();
    datos.append("nombrelibro", nombrelibro);


	  $.ajax({

     	url:"ajax/libros.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	     $(nuevaDescripcionlibro).attr("idlibro", respuesta["id"]);
      	    $(nuevaCantidadlibro).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadlibro).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPreciolibro).val(respuesta["precio_envio"]);
      	    $(nuevoPreciolibro).attr("precioReal", respuesta["precio_envio"]);

  	      // AGRUPAR libroS EN FORMATO JSON

	        listarlibros()

      	}

      })
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioenvio").on("change", "input.nuevaCantidadlibro", function(){

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPreciolibro");

	var precioFinal = $(this).val() * precio.attr("precioReal");
	
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

		$(this).val(1);

		var precioFinal = $(this).val() * precio.attr("precioReal");

		precio.val(precioFinal);

		sumarTotalPrecios();

		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR IMPUESTO
	        
    agregarImpuesto()

    // AGRUPAR libroS EN FORMATO JSON

    listarlibros()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios(){

	var precioItem = $(".nuevoPreciolibro");
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		 arraySumaPrecio.push(Number($(precioItem[i]).val()));
		 
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
	
	$("#nuevoTotalenvio").val(sumaTotalPrecio);
	$("#totalenvio").val(sumaTotalPrecio);
	$("#nuevoTotalenvio").attr("total",sumaTotalPrecio);


}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto(){

	var impuesto = $("#nuevoImpuestoenvio").val();
	var precioTotal = $("#nuevoTotalenvio").attr("total");

	var precioImpuesto = Number(precioTotal * impuesto/100);

	var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);
	
	$("#nuevoTotalenvio").val(totalConImpuesto);

	$("#totalenvio").val(totalConImpuesto);

	$("#nuevoPrecioImpuesto").val(precioImpuesto);

	$("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoenvio").change(function(){

	agregarImpuesto();

});

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalenvio").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val();

	if(metodo == "Efectivo"){

		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			 '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+ 

			 		'<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>'+

			 	'</div>'+

			 '</div>'+

			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+

			 	'</div>'+

			 '</div>'

		 )

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);


      	// Listar método en la entrada
      	listarMetodos()

	}else{

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>')

	}

	

})

/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioenvio").on("change", "input#nuevoValorEfectivo", function(){

	var efectivo = $(this).val();

	var cambio =  Number(efectivo) - Number($('#nuevoTotalenvio').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(cambio);

})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioenvio").on("change", "input#nuevoCodigoTransaccion", function(){

	// Listar método en la entrada
     listarMetodos()


})


/*=============================================
LISTAR TODOS LOS libroS
=============================================*/

function listarlibros(){

	var listalibros = [];

	var descripcion = $(".nuevaDescripcionlibro");

	var cantidad = $(".nuevaCantidadlibro");

	var precio = $(".nuevoPreciolibro");

	for(var i = 0; i < descripcion.length; i++){

		listalibros.push({ "id" : $(descripcion[i]).attr("idlibro"), 
							  "descripcion" : $(descripcion[i]).val(),
							  "cantidad" : $(cantidad[i]).val(),
							  "stock" : $(cantidad[i]).attr("nuevoStock"),
							  "precio" : $(precio[i]).attr("precioReal"),
							  "total" : $(precio[i]).val()})

	}

	$("#listalibros").val(JSON.stringify(listalibros)); 

}

/*=============================================
LISTAR MÉTODO DE PAGO
=============================================*/

function listarMetodos(){

	var listaMetodos = "";

	if($("#nuevoMetodoPago").val() == "Efectivo"){

		$("#listaMetodoPago").val("Efectivo");

	}else{

		$("#listaMetodoPago").val($("#nuevoMetodoPago").val()+"-"+$("#nuevoCodigoTransaccion").val());

	}

}

/*=============================================
BOTON EDITAR envio
=============================================*/
$(".tablas").on("click", ".btnEditarenvio", function(){

	var idenvio = $(this).attr("idenvio");

	window.location = "index.php?ruta=editar-envio&idenvio="+idenvio;


})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL libro YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarlibro(){

	//Capturamos todos los id de libros que fueron elegidos en la envio
	var idlibros = $(".quitarlibro");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaenvios tbody button.agregarlibro");

	//Recorremos en un ciclo para obtener los diferentes idlibros que fueron agregados a la envio
	for(var i = 0; i < idlibros.length; i++){

		//Capturamos los Id de los libros agregados a la envio
		var boton = $(idlibros[i]).attr("idlibro");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idlibro") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarlibro");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaenvios').on( 'draw.dt', function(){

	quitarAgregarlibro();

})



/*=============================================
BORRAR envio
=============================================*/
$(".tablas").on("click", ".btnEliminarenvio", function(){

  var idenvio = $(this).attr("idenvio");

  swal({
        title: '¿Está seguro de borrar la envio?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar envio!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=envios&idenvio="+idenvio;
        }

  })

})