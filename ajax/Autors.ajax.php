<?php

require_once "../controladores/autores.controlador.php";
require_once "../modelos/autores.modelo.php";

class AjaxAutors{

	/*=============================================
	EDITAR Autor
	=============================================*/	

	public $idAutor;

	public function ajaxEditarAutor(){

		$item = "id";
		$valor = $this->idAutor;

		$respuesta = ControladorAutors::ctrMostrarAutors($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR Autor
	=============================================*/	

	public $activarAutor;
	public $activarId;


	public function ajaxActivarAutor(){

		$tabla = "Autors";

		$item1 = "estado";
		$valor1 = $this->activarAutor;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloAutors::mdlActualizarAutor($tabla, $item1, $valor1, $item2, $valor2);

	}

	/*=============================================
	VALIDAR NO REPETIR Autor
	=============================================*/	

	public $validarAutor;

	public function ajaxValidarAutor(){

		$item = "Autor";
		$valor = $this->validarAutor;

		$respuesta = ControladorAutors::ctrMostrarAutors($item, $valor);

		echo json_encode($respuesta);

	}
}

/*=============================================
EDITAR Autor
=============================================*/
if(isset($_POST["idAutor"])){

	$editar = new AjaxAutors();
	$editar -> idAutor = $_POST["idAutor"];
	$editar -> ajaxEditarAutor();

}

/*=============================================
ACTIVAR Autor
=============================================*/	

if(isset($_POST["activarAutor"])){

	$activarAutor = new AjaxAutors();
	$activarAutor -> activarAutor = $_POST["activarAutor"];
	$activarAutor -> activarId = $_POST["activarId"];
	$activarAutor -> ajaxActivarAutor();

}

/*=============================================
VALIDAR NO REPETIR Autor
=============================================*/

if(isset( $_POST["validarAutor"])){

	$valAutor = new AjaxAutors();
	$valAutor -> validarAutor = $_POST["validarAutor"];
	$valAutor -> ajaxValidarAutor();

}