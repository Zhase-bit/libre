<?php

class ControladorDocumentos{

	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	static public function ctrMostrarDocumentos($item, $valor){

		$tabla = "documento";

		$respuesta = ModeloDocumentos::mdlMostrarDocumentos($tabla, $item, $valor);

		return $respuesta;

	}

	




}