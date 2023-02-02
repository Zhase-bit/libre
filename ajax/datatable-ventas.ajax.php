<?php

require_once "../controladores/libros.controlador.php";
require_once "../modelos/libros.modelo.php";


class TablalibrosVentas{

 	/*=============================================
 	 MOSTRAR LA TABLA DE libroS
  	=============================================*/ 

	public function mostrarTablalibrosVentas(){

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

		  	$botones =  "<div class='btn-group'><button class='btn btn-primary agregarlibro recuperarBoton' idlibro='".$libros[$i]["id"]."'>Agregar</button></div>"; 

		  	$datosJson .='[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$libros[$i]["codigo"].'",
			      "'.$libros[$i]["nombre"].'",
			      "'.$stock.'",
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
$activarlibrosVentas = new TablalibrosVentas();
$activarlibrosVentas -> mostrarTablalibrosVentas();

