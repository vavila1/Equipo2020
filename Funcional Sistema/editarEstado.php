<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_EstadoProducto.php");

    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_editarEstado.html");
    include("partials/_footer.html");

?>