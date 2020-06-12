<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

        if (isset($_POST["nombre"]) && isset($_POST["precio"]) && isset($_POST["tipo_producto"]) && isset($_POST["marca"]) && isset($_POST["modelo"])) {
            $nombre = htmlspecialchars($_POST["nombre"]);
            $modelo = htmlspecialchars($_POST["modelo"]);
            $precio = htmlspecialchars($_POST["precio"]);
            $id_tipo = htmlspecialchars($_POST["tipo_producto"]);
            $id_marca = htmlspecialchars($_POST["marca"]);
            $almacen = $_SESSION["almacen"];
            if($_POST["tipo_producto"]==2){
                $cantidad = 0 ;
                $id_estatus = 2;
            }else{
                $cantidad=1;
                $id_estatus=6;
            }

        insertar_producto($nombre, $cantidad, $modelo, $precio, $id_marca, $almacen, $id_tipo,$id_estatus);
        $id_producto = consultar_ultimo_id();
        insertar_producto_estatus($id_producto, $id_estatus);
        $_SESSION["mensaje"] = "Se completo el registro";
        }

    else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }
    

    header("location:productos.php");

?>