<?php

class Controladorenvios{

	/*=============================================
	MOSTRAR envioS
	=============================================*/

	static public function ctrMostrarenvios($item, $valor){

		$tabla = "envios";

		$respuesta = Modeloenvios::mdlMostrarenvios($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR envio
	=============================================*/

	static public function ctrCrearenvio(){

		if(isset($_POST["nuevaenvio"])){

			/*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS envioS DE LOS libroS
			=============================================*/

			$listalibros = json_decode($_POST["listalibros"], true);

			$totallibrosComprados = array();

			foreach ($listalibros as $key => $value) {

			   array_push($totallibrosComprados, $value["cantidad"]);
				
			   $tablalibros = "libros";

			    $item = "id";
			    $valor = $value["id"];

			    $traerlibro = Modelolibros::mdlMostrarlibros($tablalibros, $item, $valor);

				$item1a = "envios";
				$valor1a = $value["cantidad"] + $traerlibro["ventas"];

			    $nuevasenvios = Modelolibros::mdlActualizarlibro($tablalibros, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["stock"];

				$nuevoStock = Modelolibros::mdlActualizarlibro($tablalibros, $item1b, $valor1b, $valor);

			}

			$tablaClientes = "clientes";

			$item = "id";
			$valor = $_POST["seleccionarCliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);

			$item1a = "compras";
			$valor1a = array_sum($totallibrosComprados) + $traerCliente["compras"];

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			/*=============================================
			GUARDAR LA COMPRA
			=============================================*/	

			$tabla = "envios";

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["nuevaenvio"],
						   "libros"=>$_POST["listalibros"],
						   "fecha"=>$_POST["fecha"],
						   "fecha_entrega"=>$_POST["fecha_entrega"],
						   "estado"=>$_POST["estado"]);

			$respuesta = Modeloenvios::mdlIngresarenvio($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La envio ha sido guardada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "envios";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	EDITAR envio
	=============================================*/

	static public function ctrEditarenvio(){

		if(isset($_POST["editarenvio"])){

			/*=============================================
			FORMATEAR TABLA DE libroS Y LA DE CLIENTES
			=============================================*/
			$tabla = "envios";

			$item = "codigo";
			$valor = $_POST["editarenvio"];

			$traerenvio = Modeloenvios::mdlMostrarenvios($tabla, $item, $valor);

			/*=============================================
			REVISAR SI VIENE libroS EDITADOS
			=============================================*/

			if($_POST["listalibros"] == ""){

				$listalibros = $traerenvio["libros"];
				$cambiolibro = false;


			}else{

				$listalibros = $_POST["listalibros"];
				$cambiolibro = true;
			}

			if($cambiolibro){

				$libros =  json_decode($traerenvio["libros"], true);

				$totallibrosComprados = array();

				foreach ($libros as $key => $value) {

					array_push($totallibrosComprados, $value["cantidad"]);
					
					$tablalibros = "libros";

					$item = "id";
					$valor = $value["id"];

					$traerlibro = Modelolibros::mdlMostrarlibros($tablalibros, $item, $valor);

					$item1a = "envios";
					$valor1a = $traerlibro["envios"] - $value["cantidad"];

					$nuevasenvios = Modelolibros::mdlActualizarlibro($tablalibros, $item1a, $valor1a, $valor);

					$item1b = "stock";
					$valor1b = $value["cantidad"] + $traerlibro["stock"];

					$nuevoStock = Modelolibros::mdlActualizarlibro($tablalibros, $item1b, $valor1b, $valor);

				}

				$tablaClientes = "clientes";

				$itemCliente = "id";
				$valorCliente = $_POST["seleccionarCliente"];

				$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

				$item1a = "compras";
				$valor1a = $traerCliente["compras"] - array_sum($totallibrosComprados);

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

				/*=============================================
				ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS envioS DE LOS libroS
				=============================================*/

				$listalibros_2 = json_decode($listalibros, true);

				$totallibrosComprados_2 = array();

				foreach ($listalibros_2 as $key => $value) {

					array_push($totallibrosComprados_2, $value["cantidad"]);
					
					$tablalibros_2 = "libros";

					$item_2 = "id";
					$valor_2 = $value["id"];

					$traerlibro_2 = Modelolibros::mdlMostrarlibros($tablalibros_2, $item_2, $valor_2);

					$item1a_2 = "envios";
					$valor1a_2 = $value["cantidad"] + $traerlibro_2["envios"];

					$nuevasenvios_2 = Modelolibros::mdlActualizarlibro($tablalibros_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					$valor1b_2 = $traerlibro_2["stock"] - $value["cantidad"];

					$nuevoStock_2 = Modelolibros::mdlActualizarlibro($tablalibros_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaClientes_2 = "clientes";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarCliente"];

				$traerCliente_2 = ModeloClientes::mdlMostrarClientes($tablaClientes_2, $item_2, $valor_2);

				$item1a_2 = "compras";
				$valor1a_2 = array_sum($totallibrosComprados_2) + $traerCliente_2["compras"];

				$comprasCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_compra";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha.' '.$hora;

				$fechaCliente_2 = ModeloClientes::mdlActualizarCliente($tablaClientes_2, $item1b_2, $valor1b_2, $valor_2);

			}

			/*=============================================
			GUARDAR CAMBIOS DE LA COMPRA
			=============================================*/	

			$datos = array("id_vendedor"=>$_POST["idVendedor"],
						   "id_cliente"=>$_POST["seleccionarCliente"],
						   "codigo"=>$_POST["editarenvio"],
						   "libros"=>$listalibros,
						   "impuesto"=>$_POST["nuevoPrecioImpuesto"],
						   "neto"=>$_POST["nuevoPrecioNeto"],
						   "total"=>$_POST["totalenvio"],
						   "metodo_pago"=>$_POST["listaMetodoPago"]);


			$respuesta = Modeloenvios::mdlEditarenvio($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "La envio ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "envios";

								}
							})

				</script>';

			}

		}

	}

	/*=============================================
	ELIMINAR envio
	=============================================*/

	static public function ctrEliminarenvio(){

		if(isset($_GET["idenvio"])){

			$tabla = "envios";

			$item = "id";
			$valor = $_GET["idenvio"];

			$traerenvio = Modeloenvios::mdlMostrarenvios($tabla, $item, $valor);

			/*=============================================
			ACTUALIZAR FECHA ÚLTIMA COMPRA
			=============================================*/

			$tablaClientes = "clientes";

			$itemenvios = null;
			$valorenvios = null;

			$traerenvios = Modeloenvios::mdlMostrarenvios($tabla, $itemenvios, $valorenvios);

			$guardarFechas = array();

			foreach ($traerenvios as $key => $value) {
				
				if($value["id_cliente"] == $traerenvio["id_cliente"]){

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if(count($guardarFechas) > 1){

				if($traerenvio["fecha"] > $guardarFechas[count($guardarFechas)-2]){

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-2];
					$valorIdCliente = $traerenvio["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}else{

					$item = "ultima_compra";
					$valor = $guardarFechas[count($guardarFechas)-1];
					$valorIdCliente = $traerenvio["id_cliente"];

					$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

				}


			}else{

				$item = "ultima_compra";
				$valor = "0000-00-00 00:00:00";
				$valorIdCliente = $traerenvio["id_cliente"];

				$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item, $valor, $valorIdCliente);

			}

			/*=============================================
			FORMATEAR TABLA DE libroS Y LA DE CLIENTES
			=============================================*/

			$libros =  json_decode($traerenvio["libros"], true);

			$totallibrosComprados = array();

			foreach ($libros as $key => $value) {

				array_push($totallibrosComprados, $value["cantidad"]);
				
				$tablalibros = "libros";

				$item = "id";
				$valor = $value["id"];

				$traerlibro = Modelolibros::mdlMostrarlibros($tablalibros, $item, $valor);

				$item1a = "envios";
				$valor1a = $traerlibro["envios"] - $value["cantidad"];

				$nuevasenvios = Modelolibros::mdlActualizarlibro($tablalibros, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["cantidad"] + $traerlibro["stock"];

				$nuevoStock = Modelolibros::mdlActualizarlibro($tablalibros, $item1b, $valor1b, $valor);

			}

			$tablaClientes = "clientes";

			$itemCliente = "id";
			$valorCliente = $traerenvio["id_cliente"];

			$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);

			$item1a = "compras";
			$valor1a = $traerCliente["compras"] - array_sum($totallibrosComprados);

			$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);

			/*=============================================
			ELIMINAR envio
			=============================================*/

			$respuesta = Modeloenvios::mdlEliminarenvio($tabla, $_GET["idenvio"]);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La envio ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "envios";

								}
							})

				</script>';

			}		
		}

	}
	
}