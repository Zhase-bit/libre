/*=============================================
SUBIENDO LA FOTO DEL Autor
=============================================*/
$(".nuevaFoto").change(function(){

	var imagen = this.files[0];
	
	/*=============================================
  	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
  	=============================================*/

  	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen debe estar en formato JPG o PNG!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else if(imagen["size"] > 2000000){

  		$(".nuevaFoto").val("");

  		 swal({
		      title: "Error al subir la imagen",
		      text: "¡La imagen no debe pesar más de 2MB!",
		      type: "error",
		      confirmButtonText: "¡Cerrar!"
		    });

  	}else{

  		var datosImagen = new FileReader;
  		datosImagen.readAsDataURL(imagen);

  		$(datosImagen).on("load", function(event){

  			var rutaImagen = event.target.result;

  			$(".previsualizar").attr("src", rutaImagen);

  		})

  	}
})

/*=============================================
EDITAR Autor
=============================================*/
$(".tablas").on("click", ".btnEditarAutor", function(){

	var idAutor = $(this).attr("idAutor");

	var datos = new FormData();
	datos.append("idAutor", idAutor);

	$.ajax({

		url:"ajax/Autors.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarAutor").val(respuesta["Autor"]);
			$("#idCategoria").val(respuesta["id"]);
			$("#fotoActual").val(respuesta["foto"]);


			if(respuesta["foto"] != ""){

				$(".previsualizar").attr("src", respuesta["foto"]);

			}

		}

	});

})


/*=============================================
REVISAR SI EL Autor YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoAutor").change(function(){

	$(".alert").remove();

	var Autor = $(this).val();

	var datos = new FormData();
	datos.append("validarAutor", Autor);

	 $.ajax({
	    url:"ajax/Autors.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	if(respuesta){

	    		$("#nuevoAutor").parent().after('<div class="alert alert-warning">Este Autor ya existe en la base de datos</div>');

	    		$("#nuevoAutor").val("");

	    	}

	    }

	})
})

/*=============================================
ELIMINAR Autor
=============================================*/
$(".tablas").on("click", ".btnEliminarAutor", function(){

  var idAutor = $(this).attr("idAutor");
  var fotoAutor = $(this).attr("fotoAutor");
  var Autor = $(this).attr("Autor");

  swal({
    title: '¿Está seguro de borrar el Autor?',
    text: "¡Si no lo está puede cancelar la accíón!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar Autor!'
  }).then(function(result){

    if(result.value){

      window.location = "index.php?ruta=autores&idAutor="+idAutor+"&Autor="+Autor+"&fotoAutor="+fotoAutor;

    }

  })

})




