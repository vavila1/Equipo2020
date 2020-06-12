<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

    $id = htmlspecialchars($_SESSION['ID_ADD']);
    $idempleado=htmlspecialchars($_SESSION["IDempleado"]);
    if(isset($_POST['Cantidad'])){
    	$cantidad = htmlspecialchars($_POST['Cantidad']);
		registrarEntrada($id,$cantidad,$idempleado);
		unset($_SESSION['ID_ADD']);
    	$_SESSION["mensaje"] = "Se completo el registro";
    	}

    else {
    		$_SESSION["warning"] = "Ocurrio un error al registar el estado";
    	}
    

    header("location:productos.php");
?>