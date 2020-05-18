<?php

if(isset($_POST['Cantidad'])){
	$cantidad = htmlspecialchars($_POST['Cantidad']);
	$estado = htmlspecialchars($_POST['estado']);
	insertarPaciente($nombre,$estado);
	 $_SESSION["mensaje"] = "Se completo el registro";
	header("location:almacenes.php");
}else{
	$nombre = "";
	$estado = "";
	 $_SESSION["warning"] = "Ocurrio un error al registar el Almacen";
}



?>