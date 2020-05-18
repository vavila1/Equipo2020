<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

        if (isset($_POST["nombre"]) && isset($_POST["estatus_producto"]) && isset($_POST["precio"]) && isset($_POST["tipo_producto"]) && isset($_POST["marca"])) {
        //var_dump($_POST["descripcion"]);
        $nombre = htmlspecialchars($_POST["nombre"]);
        $id_estatus = htmlspecialchars($_POST["estatus_producto"]);
        $precio = htmlspecialchars($_POST["precio"]);
        $id_tipo = htmlspecialchars($_POST["tipo_producto"]);
        $id_marca = htmlspecialchars($_POST["marca"]);
        

        editar_producto($nombre, $precio, $id_marca, $id_tipo,$id_estatus,$_GET['id']);
        $id_historial = consultar_ultimo_estado($_GET['id']);
        editar_producto_estatus($id_historial, $id_estatus);
        $_SESSION["mensaje"] = "Se completo el registro";
        }

    else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }
    

    header("location:productos.php");

?>