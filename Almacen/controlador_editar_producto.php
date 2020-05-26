<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

        if (isset($_POST["precio"])) {
        $precio = htmlspecialchars($_POST["precio"]);

        editar_producto_precio($precio,$_GET['id']);
        $_SESSION["mensaje"] = "Se completo el registro";
        }

         else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }
    

    header("location:productos.php");

?>