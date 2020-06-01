<?php
session_start();
require_once("model_almacen.php");

if(isset($_POST["estado"])){
	$id = $_SESSION["id_almacen"];
	$estado = htmlspecialchars($_POST['estado']);
	editarAlmacen($id,$estado);
	$_SESSION["mensaje"] = "Se completo el cambio";
	header("location:almacenes.php");
}else{
	$estado = "";
	$_SESSION["warning"] = "Ocurrio un error al registar el Almacen";
}




?>