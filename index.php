<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/autores.controlador.php";
require_once "controladores/libros.controlador.php";
require_once "controladores/envios.controlador.php";
require_once "controladores/documentos.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/autores.modelo.php";
require_once "modelos/libros.modelo.php";
require_once "modelos/envios.modelo.php";
require_once "modelos/documentos.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();