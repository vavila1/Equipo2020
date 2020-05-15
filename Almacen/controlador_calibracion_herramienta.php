<?php

    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");

    //var_dump($_GET["id"]);
    $id =  $_GET["id"];
    $estatus = $_GET["estatus"];


    if (isset($id) && isset($estatus)) {
         $id = htmlspecialchars($_GET["id"]);
        registar_termino_calibracion($id);
        registar_termino_calibracion_historial($id);
        $_SESSION["mensaje"] = "Registro exitoso, la herramienta esta Disponible";
    }else if (isset($id)) {
        $id = htmlspecialchars($_GET["id"]);
        registar_calibracion($id);
        registar_calibracion_historial($id);
        $_SESSION["mensaje"] = "Registro exitoso, la herramienta esta Calibración";
    } else{ $_SESSION["warning"] = "Ocurrio un error al registar la calibración de la herramienta";
    }

    header("location:productos.php");


?>