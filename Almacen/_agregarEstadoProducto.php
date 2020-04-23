<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_tipoProducto.php");
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_formEstadoProducto.html");
    include("partials/_footer.html");

?>