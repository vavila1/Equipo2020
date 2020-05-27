<?php
	session_start();
	require_once("model_producto.php");

	$marca = htmlspecialchars($_GET["marca"]);
	$tipo_producto = htmlspecialchars($_GET["tipo_producto"]);
	$estatus_producto = htmlspecialchars($_GET["estatus_producto"]);

 	echo consultar_productos($marca,$tipo_producto,$estatus_producto);

?>