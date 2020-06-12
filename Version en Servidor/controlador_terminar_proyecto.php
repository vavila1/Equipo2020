<?php

    //Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_proyecto.php");

    //var_dump($_GET["id"]);
    $id =  $_GET["id"];

    if (isset($id)) {
        $id = htmlspecialchars($_GET["id"]);
        terminar_proyecto($id);
        $_SESSION["mensaje"] = "Se ha marcado como terminado el proyecto con exito";
    }

    header("location:proyectos.php");


?>