<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_marca.php");

    if (isset($_POST["nombre"])) {
    	//var_dump($_POST["descripcion"]);
    	$nombre = htmlspecialchars($_POST["nombre"]);
    	insertar_marca($nombre);
    	$_SESSION["mensaje"] = "Se completo el registro";
    	}

    else {
    		$_SESSION["warning"] = "Ocurrio un error al registar el producto";
    	}
    

    header("location:marcas.php");

?>