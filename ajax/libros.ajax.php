<?php

require_once "../controladores/libros.controlador.php";
require_once "../modelos/libros.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class Ajaxlibros{

  /*=============================================
  GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
  =============================================*/
  public $idCategoria;

  


  /*=============================================
  EDITAR libro
  =============================================*/ 

  public $idlibro;
  public $traerlibros;
  public $nombrelibro;

  public function ajaxEditarlibro(){

    if($this->traerlibros == "ok"){

      $item = null;
      $valor = null;

      $respuesta = Controladorlibros::ctrMostrarlibros($item, $valor);

      echo json_encode($respuesta);


    }else if($this->nombrelibro != ""){

      $item = "descripcion";
      $valor = $this->nombrelibro;

      $respuesta = Controladorlibros::ctrMostrarlibros($item, $valor);

      echo json_encode($respuesta);

    }else{

      $item = "id";
      $valor = $this->idlibro;

      $respuesta = Controladorlibros::ctrMostrarlibros($item, $valor);

      echo json_encode($respuesta);

    }

  }

}


/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/	


/*=============================================
EDITAR libro
=============================================*/ 

if(isset($_POST["idlibro"])){

  $editarlibro = new Ajaxlibros();
  $editarlibro -> idlibro = $_POST["idlibro"];
  $editarlibro -> ajaxEditarlibro();

}

/*=============================================
TRAER libro
=============================================*/ 

if(isset($_POST["traerlibros"])){

  $traerlibros = new Ajaxlibros();
  $traerlibros -> traerlibros = $_POST["traerlibros"];
  $traerlibros -> ajaxEditarlibro();

}

/*=============================================
TRAER libro
=============================================*/ 

if(isset($_POST["nombrelibro"])){

  $traerlibros = new Ajaxlibros();
  $traerlibros -> nombrelibro = $_POST["nombrelibro"];
  $traerlibros -> ajaxEditarlibro();

}



if(isset($_POST['buscar']))
    { 
    	$doc = $_POST['doc'];
    	$valores = array();
    	$valores['existe'] = "0";

    	//CONSULTAR
		  $resultados = mysqli_query($conexion,"SELECT * FROM $tabla_db1 WHERE codigo = '$doc'");
		  while($consulta = mysqli_fetch_array($resultados))
		  {
		  	$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
		  	$valores['nuevaDescripcion'] = $consulta['descripcion'];
        $valores['nuevoStock'] = $consulta['stock'];

        $valores['nuevaCategoria'] = $consulta['id_categoria'];
        $valores['nuevoAutor'] = $consulta['id_autor'];
        $valores['nuevaFecha'] = $consulta['fecha'];
        $valores['nuevoIdioma'] = $consulta['idioma'];
        $valores['nuevoPrecioCompra'] = $consulta['precio_compra'];
        $valores['nuevoPrecioVenta'] = $consulta['precio_venta'];
        $valores['nuevaImagen'] = $consulta['imagen'];
        $valores['nuevoNombre'] = $consulta['nombre'];
   
		  }
		  sleep(1);
		  $valores = json_encode($valores);
			  echo $valores;
    }


    

