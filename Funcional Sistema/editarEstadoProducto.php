<?php
	//Inicio o recuperdo la sesión
    session_start();

    require_once("model_EstadoProducto.php");

    $proyecto_id = htmlspecialchars($_GET["id"]);
    $nombre_proyecto = htmlspecialchars($_GET["nombre"]);


    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarEstadoProducto.html");
    include("partials/_footer.html");

?>