<?php

require_once "../controladores/libros.controlador.php";
require_once "../modelos/libros.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

require_once "../controladores/autores.controlador.php";
require_once "../modelos/autores.modelo.php";



class Tablalibros{

 	/*=============================================
 	 MOSTRAR LA TABLA DE libroS
  	=============================================*/ 

	public function mostrarTablalibros(){
       

		$item = null;
    	$valor = null;

  		$libros = Controladorlibros::ctrMostrarlibros($item, $valor);
		
  		if(count($libros) == 0){

  			echo '{"data": []}';

		  	return;
  		}	
		
  		$datosJson = '{
		  "data": [';

		  for($i = 0; $i < count($libros); $i++){

		  	/*=============================================
 	 		TRAEMOS LA IMAGEN
  			=============================================*/ 

		  	$imagen = "<img src='".$libros[$i]["imagen"]."' width='40px'>";

		  	/*=============================================
 	 		TRAEMOS LA CATEGORÍA
  			=============================================*/ 
			$item = "id";
		  	$valor = $libros[$i]["id_autor"];

		  	$autores = ControladorAutors::ctrMostrarAutors($item, $valor);

		  	$item = "id";
		  	$valor = $libros[$i]["id_categoria"];

		  	$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

			


		  	/*=============================================
 	 		STOCK
  			=============================================*/ 

  			if($libros[$i]["stock"] <= 10){

  				$stock = "<button class='btn btn-danger'>".$libros[$i]["stock"]."</button>";

  			}else if($libros[$i]["stock"] > 11 && $libros[$i]["stock"] <= 15){

  				$stock = "<button class='btn btn-warning'>".$libros[$i]["stock"]."</button>";

  			}else{

  				$stock = "<button class='btn btn-success'>".$libros[$i]["stock"]."</button>";

  			}

		  	/*=============================================
 	 		TRAEMOS LAS ACCIONES
  			=============================================*/ 

		  	$botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarlibro' idlibro='".$libros[$i]["id"]."' data-toggle='modal' data-target='#modalEditarlibro'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarlibro' idlibro='".$libros[$i]["id"]."' codigo='".$libros[$i]["codigo"]."' imagen='".$libros[$i]["imagen"]."'><i class='fa fa-times'></i></button></div>"; 

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
				  "'.$libros[$i]["nombre"].'",
			      "'.$libros[$i]["codigo"].'",
				 
                  "'.$autores["nombre"].'",
			      "'.$libros[$i]["descripcion"].'",
			      "'.$categorias["categoria"].'",
                  "'.$libros[$i]["idioma"].'",
			      "'.$libros[$i]["fecha"].'",
                  "'.$stock.'",
                  "'.$libros[$i]["precio_compra"].'",
			      "'.$libros[$i]["precio_venta"].'",
                  
			      "'.$botones.'"
			    ],';

		  }

		  $datosJson = substr($datosJson, 0, -1);

		 $datosJson .=   '] 

		 }';
		
		echo $datosJson;


	}


}

/*=============================================
ACTIVAR TABLA DE libroS
=============================================*/ 
$activarlibros = new Tablalibros();
$activarlibros -> mostrarTablalibros();

