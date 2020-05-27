<?php

    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_marca.php");


    $id =  $_GET["id"];

    if (isset($id)) {
        $id = htmlspecialchars($_GET["id"]);
        eliminar_marca($id);
        $_SESSION["delete"] = "Se ha eliminado una marca";
    }

    header("location:marcas.php");


?>