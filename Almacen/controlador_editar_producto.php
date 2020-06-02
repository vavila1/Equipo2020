<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");
    

        if (isset($_POST["precio"])&&isset($_POST["nombre"])&&isset($_POST["tipo_producto"])&&isset($_POST["estatus_producto"])&&isset($_POST["precio"])&&isset($_POST["marca"])) {

        $Nombre = htmlspecialchars($_POST["nombre"]);
        $Id_tipo = htmlspecialchars($_POST["tipo_producto"]);
        $Id_marca = htmlspecialchars($_POST["marca"]);
        $Id_estatus = htmlspecialchars($_POST["estatus_producto"]);
        $Precio = htmlspecialchars($_POST["precio"]);
        $Id_producto = $_SESSION['id_producto'];

        editar_producto($Nombre, $Precio, $Id_marca, $Id_tipo,$Id_estatus,$Id_producto);
        editar_producto_estatus($Id_producto,$Id_estatus);

        $_SESSION["mensaje"] = "Se completo el registro";
        unset($_SESSION['id_producto']);
        }
         else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
            unset($_SESSION['id_producto']);
        }
    
    header("location:productos.php");

?>