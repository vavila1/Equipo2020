<?php

    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_tipoProducto.php");

    var_dump($_GET["id"]);
    $id =  $_GET["id"];

    if (isset($id)) {
        $id = htmlspecialchars($_GET["id"]);
        eliminar_tipo($id);
        $_SESSION["delete"] = "Se ha eliminado un registro con exito";
    }

    header("location:tipoProducto.php");


?>