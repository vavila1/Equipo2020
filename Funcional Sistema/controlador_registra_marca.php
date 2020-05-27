<?php
	//Inicio o recuperdo la sesión
    session_start();

    //Traemos libreria de model
    require_once("model_producto.php");
    include("partials/_header.html");
    include("partials/_nav.html");
    include("partials/_form_marca.html");
    include("partials/_footer.html");

?>