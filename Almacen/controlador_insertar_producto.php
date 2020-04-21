<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

        if (isset($_POST["nombre"]) && isset($_POST["cantidad"]) && isset($_POST["precio"]) && isset($_POST["tipo_producto"]) && isset($_POST["marca"])) {
        //var_dump($_POST["descripcion"]);
        $nombre = htmlspecialchars($_POST["nombre"]);
        $cantidad = htmlspecialchars($_POST["cantidad"]);
        $precio = htmlspecialchars($_POST["precio"]);
        $id_tipo = htmlspecialchars($_POST["tipo_producto"]);
        $id_marca = htmlspecialchars($_POST["marca"]);
        $id_estatus = 1;

        insertar_producto($nombre, $cantidad, $precio, $id_marca, $id_estatus, $id_tipo);
        $_SESSION["mensaje"] = "Se completo el registro";
        }

    else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }
    

    header("location:productos.php");

?>