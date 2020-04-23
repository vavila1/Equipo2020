<?php

    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

    //var_dump($_GET["id"]);
    $id =  $_GET["id"];

    if (isset($id)) {
        $id = htmlspecialchars($_GET["id"]);
        eliminar_producto($id);
        $_SESSION["delete"] = "Se ha eliminado un registro con exito";
    }

    header("location:productos.php");


?>