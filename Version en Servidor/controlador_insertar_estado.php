<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_EstadoProducto.php");

    if (isset($_POST["nombre"])) {
    	$nombre = htmlspecialchars($_POST["nombre"]);
    	agregar_estadoProducto($nombre);
    	$_SESSION["mensaje"] = "Se completo el registro";
    	}

    else {
    		$_SESSION["warning"] = "Ocurrio un error al registar el estado";
    	}
    

    header("location:estadoProducto.php");

?>