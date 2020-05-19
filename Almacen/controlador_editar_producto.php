<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");
    $id = htmlspecialchars($_SESSION['ID_ADD']);

        if (isset($_POST["nombre"]) && isset($_POST["estatus_producto"]) && isset($_POST["precio"]) && isset($_POST["tipo_producto"]) && isset($_POST["marca"])) {
        
        $nombre = htmlspecialchars($_POST["nombre"]);
        $precio = htmlspecialchars($_POST["precio"]);
        $id_tipo = htmlspecialchars($_POST["tipo_producto"]);
        $id_marca = htmlspecialchars($_POST["marca"]);
        $id_estatus = htmlspecialchars($_POST["estatus_producto"]);
        $almacen = $_SESSION["almacen"];

        editar_producto_nombre($nombre,$id);
        editar_producto_precio($precio,$id);
        editar_producto_tipo($id_tipo,$id);
        editar_producto_marca($id_marca,$id);
        editar_producto_idestatus($id_estatus,$id);
        insertar_producto_estatus($id, $id_estatus);
        
        unset($_SESSION['ID_ADD']);
        $_SESSION["mensaje"] = "Se completo el registro";
        }

         else {
            $_SESSION["warning"] = "Ocurrio un error al registar el producto";
        }
    
    header("location:productos.php");

?>



