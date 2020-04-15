<?php

if(isset($_POST['Nombre']) && isset($_POST['estado'])){
	$nombre = htmlspecialchars($_POST['Nombre']);
	$estado = htmlspecialchars($_POST['estado']);
	insertarPaciente($nombre,$estado);
	header("location:almacenes.php");
}else{
	$nombre = "";
	$estado = "";
}



?>