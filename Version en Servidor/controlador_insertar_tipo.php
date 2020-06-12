<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_tipoProducto.php");

    if (isset($_POST["nombre"])) {
    	$nombre = htmlspecialchars($_POST["nombre"]);
    	insertar_tipoProducto($nombre);
    	$_SESSION["mensaje"] = "Se completo el registro";
    	}

    else {
    		$_SESSION["warning"] = "Ocurrio un error al registar el tipo";
    	}
    

    header("location:tipoProducto.php");

?>