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
        $almacen = $_SESSION["almacen"];
        $id_estatus = 6;

        insertar_producto($nombre, $cantidad, $precio, $id_marca, $almacen, $id_tipo);
        $id_producto = consultar_ultimo_id();
        insertar_producto_estatus($id_producto, $id_estatus);
        $_SESSION["mensaje"] = "Se completo el registro";
        }

    else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }
    

    header("location:productos.php");

?>